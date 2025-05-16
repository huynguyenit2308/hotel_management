<?php

namespace App\Http\Controllers;

use App\Models\BookingService;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function payment(Request $request)
    {
        $invoiceIds = $request->input('invoice_ids', []);
        $voucherCode = $request->input('voucher_code');

        $invoices = BookingService::whereIn('id', $invoiceIds)
            ->where('status', 'pending')
            ->with('service')
            ->get();

        if ($invoices->isEmpty()) {
            return redirect()->back()->with('error', 'Bạn chưa chọn hóa đơn thanh toán.');
        }

        $originalTotal = $invoices->sum(fn($invoice) => $invoice->service->price);
        $discount = 0;

        $voucher = null;
        if ($voucherCode) {
            $voucher = Voucher::where('code', $voucherCode)
                ->where('active', true)
                ->where(function ($query) {
                    $now = now();
                    $query->whereNull('start_date')->orWhere('start_date', '<=', $now);
                })
                ->where(function ($query) {
                    $now = now();
                    $query->whereNull('end_date')->orWhere('end_date', '>=', $now);
                })
                ->first();

            if ($voucher) {
                if ($voucher->type === 'percent') {
                    $discount = $originalTotal * ($voucher->value / 100);
                } elseif ($voucher->type === 'fixed') {
                    $discount = $voucher->value;
                }

                $discount = min($discount, $originalTotal);
            } else {
                return redirect()->back()->with('error', 'Mã giảm giá không hợp lệ hoặc đã hết hạn.');
            }
        }

        $totalAmount = $originalTotal - $discount;

        $vouchers = Voucher::where('active', true)
            ->where(function ($query) {
                $now = now();
                $query->whereNull('start_date')->orWhere('start_date', '<=', $now);
            })
            ->where(function ($query) {
                $now = now();
                $query->whereNull('end_date')->orWhere('end_date', '>=', $now);
            })
            ->get();

        return view('userService.payment', compact(
            'invoices',
            'originalTotal',
            'discount',
            'totalAmount',
            'voucherCode',
            'vouchers'
        ));
    }

    // Thanh toán momo
    public function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }

    public function paymentCashAndOnline(Request $request)
    {
        $paymentMethod = $request->input('payment_method');
        $invoiceIds = $request->input('invoice_ids');
        $voucherCode = $request->input('voucher_code');


        // Thanh toán bằng tiền mặt
        if ($paymentMethod === 'cash') {
            $invoices = BookingService::whereIn('id', $invoiceIds)->with('service')->get();
            if ($invoices->isEmpty()) {
                return redirect()->back()->with('error', 'Không tìm thấy hóa đơn.');
            }

            $originalTotal = $invoices->sum(fn($item) => $item->service->price);
            $totalAmount = $originalTotal;
            $discount = 0;
            $voucher = null;

            if ($voucherCode) {
                $voucher = Voucher::where('code', $voucherCode)
                    ->where('active', true)
                    ->where(function ($query) {
                        $now = now();
                        $query->whereNull('start_date')->orWhere('start_date', '<=', $now);
                    })
                    ->where(function ($query) {
                        $now = now();
                        $query->whereNull('end_date')->orWhere('end_date', '>=', $now);
                    })
                    ->first();

                if (!$voucher) {
                    return redirect()->back()->with('error', 'Voucher không hợp lệ hoặc đã hết hạn.');
                }

                if ($voucher->used_count >= $voucher->usage_limit) {
                    return redirect()->back()->with('error', 'Voucher đã hết lượt sử dụng.');
                }

                $discount = $voucher->type === 'percent'
                    ? $originalTotal * ($voucher->value / 100)
                    : $voucher->value;

                $discount = min($discount, $originalTotal);
                $totalAmount = $originalTotal - $discount;
            }

            $usedTime = $invoices->first()->booking_date ?? Carbon::now();

            // Lưu vào bảng invoice
            $invoice = Invoice::create([
                'customer_id' => auth()->user()->id,
                'create_at' => $usedTime,
                'total_amount' => $totalAmount,
                'payment_method' => $paymentMethod,
                'status' => 'Paid',
            ]);
            $invoice->services()->attach($invoices->pluck('service_id'));

            // Lưu vào bảng payment
            Payment::create([
                'invoice_id' => $invoice->id,
                'customer_id' => auth()->user()->id,
                'payment_method' => 'cash',
                'original_amount' => $originalTotal,
                'discount_amount' => $discount,
                'final_amount' => $totalAmount,
                'voucher_id' => $voucher?->id,
                'paid_at' => now(),
            ]);

            foreach ($invoices as $invoiceItem) {
                $invoiceItem->status = 'confirmed';
                $invoiceItem->save();
            }

            $bookingCount = BookingService::where('customer_id', auth()->user()->id)
                ->where('status', 'pending')
                ->count();
            session(['booking_count' => $bookingCount]);

            if ($voucher) {
                $voucher->increment('used_count');
            }
            return redirect()->route('invoice.list.user')->with('success', 'Thanh toán tiền mặt thành công');

            // Thanh toán online
        } else if ($paymentMethod === 'online') {
            $invoices = BookingService::whereIn('id', $invoiceIds)->with('service')->get();
            if ($invoices->isEmpty()) {
                return redirect()->back()->with('error', 'Không tìm thấy hóa đơn.');
            }

            $originalTotal = $invoices->sum(fn($item) => $item->service->price);
            $totalAmount = $originalTotal;
            $discount = 0;
            $voucher = null;

            if ($voucherCode) {
                $voucher = Voucher::where('code', $voucherCode)
                    ->where('active', true)
                    ->where(function ($query) {
                        $now = now();
                        $query->whereNull('start_date')->orWhere('start_date', '<=', $now);
                    })
                    ->where(function ($query) {
                        $now = now();
                        $query->whereNull('end_date')->orWhere('end_date', '>=', $now);
                    })
                    ->first();

                if (!$voucher) {
                    return redirect()->back()->with('error', 'Voucher không hợp lệ hoặc đã hết hạn.');
                }

                if ($voucher->used_count >= $voucher->usage_limit) {
                    return redirect()->back()->with('error', 'Voucher đã hết lượt sử dụng.');
                }

                $discount = $voucher->type === 'percent'
                    ? $originalTotal * ($voucher->value / 100)
                    : $voucher->value;

                $discount = min($discount, $originalTotal);
                $totalAmount = $originalTotal - $discount;
            }

            $totalAmount = max(1000, intval($totalAmount));
            $usedTime = $invoices->first()->booking_date ?? Carbon::now();


            $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
            $partnerCode = 'MOMOBKUN20180529';
            $accessKey = 'klm05TvNBzhg7h7j';
            $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';

            $orderInfo = "Thanh toán qua MoMo";
            $amount = (string) $totalAmount;
            $orderId = uniqid('');
            // Trả về trang cảm ơn khách hàng
            $redirectUrl = route('momo.callback');
            // Trả về trang truy vấn kết quả
            $ipnUrl = route('momo.callback');
            $extraData = json_encode([
                'invoice_ids' => $invoiceIds,
                'voucher_code' => $voucherCode,
                'customer_id' => auth()->id(),
            ]);;

            $partnerCode = $partnerCode;
            $accessKey = $accessKey;
            $serectkey = $secretKey;
            $orderId = $orderId;
            $orderInfo = $orderInfo;
            $amount = $amount;
            $ipnUrl = $ipnUrl;
            $redirectUrl = $redirectUrl;
            $extraData = $extraData;

            $requestId = time() . "";
            $requestType = "payWithATM";
            // $extraData = ($_POST["extraData"] ? $_POST["extraData"] : "");
            //before sign HMAC SHA256 signature
            $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
            $signature = hash_hmac("sha256", $rawHash, $serectkey);
            $data = array(
                'partnerCode' => $partnerCode,
                'partnerName' => "Test",
                "storeId" => "MomoTestStore",
                'requestId' => $requestId,
                'amount' => $amount,
                'orderId' => $orderId,
                'orderInfo' => $orderInfo,
                'redirectUrl' => $redirectUrl,
                'ipnUrl' => $ipnUrl,
                'lang' => 'vi',
                'extraData' => $extraData,
                'requestType' => $requestType,
                'signature' => $signature
            );
            $result = $this->execPostRequest($endpoint, json_encode($data));
            $jsonResult = json_decode($result, true);  // decode json

            //Just a example, please check more in there

            if (isset($jsonResult['payUrl'])) {
                return redirect()->away($jsonResult['payUrl']);
            } else {
                return redirect()->back()->with('error', 'Lỗi thanh toán online: ' . ($jsonResult['message'] ?? 'Không xác định'));
            }
            // Lưu vào bảng invoice
            // $invoice = Invoice::create([
            //     'customer_id' => auth()->user()->id,
            //     'create_at' => $usedTime,
            //     'total_amount' => $totalAmount,
            //     'payment_method' => $paymentMethod,
            //     'status' => 'Paid',
            // ]);
            // $invoice->services()->attach($invoices->pluck('service_id'));

            // // Lưu vào bảng payment
            // Payment::create([
            //     'invoice_id' => $invoice->id,
            //     'customer_id' => auth()->user()->id,
            //     'payment_method' => 'online',
            //     'original_amount' => $originalTotal,
            //     'discount_amount' => $discount,
            //     'final_amount' => $totalAmount,
            //     'voucher_id' => $voucher?->voucher_code,
            //     'paid_at' => now(),
            // ]);

            // foreach ($invoices as $invoiceItem) {
            //     $invoiceItem->status = 'confirmed';
            //     $invoiceItem->save();
            // }

            // $bookingCount = BookingService::where('customer_id', auth()->user()->id)
            //     ->where('status', 'pending')
            //     ->count();
            // session(['booking_count' => $bookingCount]);

            // if ($voucher) {
            //     $voucher->increment('used_count');
            // }
        }
        return redirect()->route('invoice.list.user')->with('error', 'Phương thức thanh toán không được hỗ trợ.');
    }
    // Tài khoản test momo:
    // 9704 0000 0000 0018
    // NGUYEN VAN A
    // 03/07
    // OTP

    public function handleMomoCallback(Request $request)
    {
        if ($request->resultCode == 0) {
            $data = json_decode($request->extraData, true);
            $invoiceIds = $data['invoice_ids'] ?? [];
            $voucherCode = $data['voucher_code'] ?? null;
            $customerId = $data['customer_id'] ?? null;

            if (!$customerId) {
                return redirect()->route('invoice.list.user')->with('error', 'Không xác định được người dùng.');
            }

            $invoices = BookingService::whereIn('id', $invoiceIds)->with('service')->get();
            if ($invoices->isEmpty()) {
                return redirect()->route('invoice.list.user')->with('error', 'Không tìm thấy hóa đơn.');
            }

            $originalTotal = $invoices->sum(fn($item) => $item->service->price);
            $discount = 0;
            $voucher = null;

            if ($voucherCode) {
                $voucher = Voucher::where('code', $voucherCode)->where('active', true)->first();
                if ($voucher) {
                    $discount = $voucher->type === 'percent'
                        ? $originalTotal * ($voucher->value / 100)
                        : $voucher->value;
                    $discount = min($discount, $originalTotal);
                    $voucher->increment('used_count');
                }
            }

            $totalAmount = max(1000, intval($originalTotal - $discount));

            $usedTime = $invoices->first()->booking_date ?? Carbon::now();
            $invoice = Invoice::create([
                'customer_id' => auth()->user()->id,
                'create_at' => $usedTime,
                'total_amount' => $totalAmount,
                'payment_method' => 'online',
                'status' => 'Paid',
            ]);

            $invoice->services()->attach($invoices->pluck('service_id'));

            Payment::create([
                'invoice_id' => $invoice->id,
                'customer_id' => auth()->user()->id,
                'payment_method' => 'online',
                'original_amount' => $originalTotal,
                'discount_amount' => $discount,
                'final_amount' => $totalAmount,
                'voucher_id' => $voucher?->id,
                'paid_at' => now(),
            ]);

            foreach ($invoices as $invoiceItem) {
                $invoiceItem->status = 'confirmed';
                $invoiceItem->save();
            }

            session(['booking_count' => BookingService::where('customer_id', auth()->id())->where('status', 'pending')->count()]);

            return redirect()->route('invoice.list.user')->with('success', 'Thanh toán online thành công.');
        }

        return redirect()->route('invoice.list.user')->with('error', 'Thanh toán thất bại hoặc bị huỷ.');
    }
}

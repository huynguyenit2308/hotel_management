<?php

namespace App\Http\Controllers;

use App\Models\BookingService;
use App\Models\Invoice;
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

    public function paymentCash(Request $request)
    {
        $paymentMethod = $request->input('payment_method');
        $invoiceIds = $request->input('invoice_ids');
        $voucherCode = $request->input('voucher_code');

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

            $invoice = Invoice::create([
                'customer_id' => auth()->user()->id,
                'create_at' => $usedTime,
                'total_amount' => $totalAmount,
                'status' => 'paid',
            ]);
            $invoice->services()->attach($invoices->pluck('service_id'));

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

            return redirect()->route('invoice.detail', ['invoice' => $invoice->id])->with('success', 'Thanh toán tiền mặt thành công');
        }

        return redirect()->route('invoice.list.user')->with('error', 'Phương thức thanh toán không được hỗ trợ.');
    }
}

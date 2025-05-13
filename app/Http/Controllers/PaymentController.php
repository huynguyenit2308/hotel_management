<?php

namespace App\Http\Controllers;

use App\Models\BookingService;
use App\Models\Voucher;
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

        if ($paymentMethod === 'cash') {
            $invoices = BookingService::whereIn('id', $invoiceIds)->get();
            foreach ($invoices as $invoice) {
                $invoice->status = 'confirmed';
                $invoice->save();
            }
            $bookingCount = BookingService::where('customer_id', auth()->user()->id)
                ->where('status', 'pending')
                ->count();
            session(['booking_count' => $bookingCount]);
            return redirect()->route('invoice.list.user')->with('success', 'Thanh toán tiền mặt thành công');
        }

        if ($paymentMethod === 'online') {
            return redirect()->route('invoice.list.user')->with('error', 'Thanh toán online chưa được xử lý.');
        }

        return redirect()->route('invoice.list.user')->with('error', 'Phương thức thanh toán không hợp lệ');
    }
}

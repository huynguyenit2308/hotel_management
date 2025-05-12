<?php

namespace App\Http\Controllers;

use App\Models\BookingService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function payment(Request $request)
    {
        $invoiceIds = $request->input('invoice_ids', []);
        $invoices = BookingService::whereIn('id', $invoiceIds)
            ->where('status', 'pending')
            ->with('service')
            ->get();

        if ($invoices->isEmpty()) {
            return redirect()->back()->with('error', 'Bạn chưa chọn hóa đơn thanh toán.');
        }

        $totalAmount = $invoices->sum(fn($invoice) => $invoice->service->price);

        return view('userService.payment', compact('invoices', 'totalAmount'));
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

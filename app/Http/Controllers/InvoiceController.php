<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    // Danh sách hóa đơn
    public function listInvoice()
    {
        try {
            $invoices = Invoice::paginate(6);
            return view('userService.listInvoice', compact('invoices'));
        } catch (\Exception $e) {
            return redirect()->route('invoice.list')->with('error', 'Đã xảy ra lỗi: ' . $e->getMessage());
        }
    }

    // Chi tiết hóa đơn
    public function detailInvoice(Request $request)
    {
        try {
            $id = $request->get('id');
            $invoice = Invoice::with('services')->where('id', $id)->first();

            if (!$invoice) {
                return redirect()->route('invoice.list')->with('error', 'Hóa đơn không tồn tại hoặc chưa được xác nhận.');
            }

            return view('userService.detailInvoice', compact('invoice'));
        } catch (\Exception $e) {
            return redirect()->route('invoice.list')->with('error', 'Đã xảy ra lỗi: ' . $e->getMessage());
        }
    }
}

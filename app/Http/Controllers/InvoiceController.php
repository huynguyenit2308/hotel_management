<?php

namespace App\Http\Controllers;

use App\Helpers\IdEncoder;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    // Danh sách hóa đơn
    public function listInvoice()
    {
        $invoices = Invoice::paginate(6);
        if ($invoices->isEmpty()) {
            return view('userService.listInvoice', compact('invoices'))->with('error', 'Không có hóa đơn nào!!!');
        }
        foreach ($invoices as $invoice) {
            $invoice->encoded_id = IdEncoder::encodeId($invoice->id);
        }
        return view('userService.listInvoice', compact('invoices'));
    }

    // Chi tiết hóa đơn
    public function detailInvoice(Request $request)
    {
        $encodedId = $request->get('id');
        $id = IdEncoder::decodeId($encodedId);
        $invoice = Invoice::with('services')->where('id', $id)->first();

         if (!$id) {
            return redirect()->route('invoice.list')->with('error', 'ID không hợp lệ!');
        }

        return view('userService.detailInvoice', compact('invoice'));
    }
}

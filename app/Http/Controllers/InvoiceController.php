<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function listInvoice()
    {
        try {
            $invoices = Invoice::paginate(6);
            return view('userService.listInvoice', compact('invoices'));
        } catch (\Exception $e) {
            return redirect()->route('invoice.list')->with('error', 'Đã xảy ra lỗi: ' . $e->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\BookingService;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

class BookingServiceController extends Controller
{
    public function bookingService(Request $request)
    {
        try {
            $id = $request->get('id');
            $service = Service::find($id);
            if (!$service) {
                return redirect()->route('home')->with('error', 'Dịch vụ không tồn tại.');
            }
            return view('userService.bookingService', compact('service'));
        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Đã xảy ra lỗi: ' . $e->getMessage());
        }
    }

    public function postBookingService(Request $request)
    {
        try {
            $request->validate([
                'service_id' => 'required|exists:service,id',
                'date' => 'required|date|after_or_equal:today',
                'time' => 'required',
                'note' => 'nullable|string',
            ], [
                'service_id.required' => 'Vui lòng chọn dịch vụ.',
                'service_id.exists' => 'Dịch vụ không hợp lệ.',
                'date.required' => 'Vui lòng chọn ngày sử dụng.',
                'date.date' => 'Ngày sử dụng không hợp lệ.',
                'date.after_or_equal' => 'Ngày sử dụng phải là hôm nay hoặc trong tương lai.',
                'time.required' => 'Vui lòng chọn giờ sử dụng.',
                'note.string' => 'Ghi chú phải là văn bản.',
            ]);

            if (!auth()->check()) {
                return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để đặt dịch vụ.');
            }

            $bookingDateTime = $request->date . ' ' . $request->time;

            $hasConflict = BookingService::where('service_id', $request->service_id)
                ->where('booking_date', $bookingDateTime)
                ->exists();

            if ($hasConflict) {
                $errors = new MessageBag(['time' => 'Đã trùng thời gian. Vui lòng chọn thời gian khác.']);
                return redirect()->back()->withErrors($errors)->withInput();
            }

            BookingService::create([
                'service_id' => $request->service_id,
                'customer_id' => auth()->user()->id,
                'booking_date' => $bookingDateTime,
                'note' => $request->note,
                'status' => 'pending',
            ]);

            session()->forget('booking_count');
            $bookingCount = BookingService::where('customer_id', auth()->user()->id)
                ->where('status', 'pending')
                ->count();
            session(['booking_count' => $bookingCount]);

            $serviceName = Service::find($request->service_id)?->service_name ?? 'dịch vụ';
            return redirect()->route('invoice.list.user')->with('success', "Đặt dịch vụ $serviceName thành công!");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi đặt dịch vụ: ' . $e->getMessage())->withInput();
        }
    }

    public function listInvoice()
    {
        try {
            $invoices = BookingService::where('status', 'confirmed')->paginate(6);
            return view('userService.listInvoice', compact('invoices'));
        } catch (\Exception $e) {
            return view('userService.listInvoice')->with('error', 'Đã xảy ra lỗi khi tải danh sách hóa đơn: ' . $e->getMessage());
        }
    }

    public function detailInvoice(Request $request)
    {
        $id = $request->get('id');
        $invoice = BookingService::where('id', $id)
            ->where('status', 'confirmed')
            ->first();

        if (!$invoice) {
            return redirect()->route('invoice.list')->with('error', 'Hóa đơn không tồn tại hoặc chưa được xác nhận.');
        }

        return view('userService.detailInvoice', compact('invoice'));
    }

    public function listInvoiceUser()
    {
        $invoices = BookingService::where('customer_id', auth()->user()->id)
            ->where('status', 'pending')
            ->get();

        return view('userService.listInvoiceUser', compact('invoices'));
    }

    public function cancelInvoiceUser(Request $request)
    {
        $id = $request->get('id');
        $invoice = BookingService::find($id);

        if (!$invoice) {
            return redirect()->route('home')->with('error', 'Dịch vụ không tồn tại.');
        }

        if ($invoice->status === 'pending') {
            $invoice->status = 'cancelled';
            $invoice->save();

            $bookingCount = BookingService::where('customer_id', auth()->user()->id)
                ->where('status', 'pending')
                ->count();
            session(['booking_count' => $bookingCount]);

            return redirect()->route('invoice.list.user')->with('success', 'Hóa đơn đã được hủy thành công.');
        }

        return redirect()->route('invoice.list.user')->with('error', 'Không thể hủy hóa đơn này.');
    }
}

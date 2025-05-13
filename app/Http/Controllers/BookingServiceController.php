<?php

namespace App\Http\Controllers;

use App\Models\BookingService;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingServiceController extends Controller
{
    public function bookingService(Request $request)
    {
        $id = $request->get('id');
        $service = Service::find($id);
        if (!$service) {
            return redirect()->route('home')->with('error', 'Dịch vụ không tồn tại.');
        }
        return view('userService.bookingService', compact('service'));
    }

    public function postBookingService(Request $request)
    {
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

        BookingService::create([
            'service_id' => $request->service_id,
            'customer_id' => auth()->user()->id,
            'booking_date' => $bookingDateTime,
            'note' => $request->note,
            'status' => 'pending',
        ]);

        $bookingCount = BookingService::where('customer_id', auth()->user()->id)->count();
        session(['booking_count' => $bookingCount]);

        return redirect()->route('home')->with('success', 'Đặt dịch vụ thành công!');
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
}

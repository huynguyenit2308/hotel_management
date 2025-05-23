<?php

namespace App\Http\Controllers;

use App\Models\BookingService;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

class BookingServiceController extends Controller
{
    // Đặt dịch vụ
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
        $request->validate([
            'service_id' => 'required|exists:service,id',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'note' => 'nullable|string|max:255',
        ], [
            'service_id.required' => 'Vui lòng chọn dịch vụ.',
            'service_id.exists' => 'Dịch vụ không hợp lệ.',
            'date.required' => 'Vui lòng chọn ngày sử dụng.',
            'date.date' => 'Ngày sử dụng không hợp lệ.',
            'date.after_or_equal' => 'Ngày sử dụng phải là hôm nay hoặc trong tương lai.',
            'time.required' => 'Vui lòng chọn giờ sử dụng.',
            'note.string' => 'Ghi chú phải là văn bản.',
            'note.max' => 'Ghi chú không được vượt quá 255 ký tự.',
        ]);
        $date = Carbon::parse($request->date);
        $time = Carbon::parse($request->time);
        if ($date->isToday() && $time->lt(Carbon::now())) {
            return back()->withErrors(['time' => 'Không thể chọn giờ đã qua trong hôm nay.'])->withInput();
        }
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
    }

    // Danh sách dịch vụ đặt của người dùng
    public function listInvoiceUser()
    {
        try {
            if (!auth()->check()) {
                return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để xem hóa đơn.');
            }

            $invoices = BookingService::where('customer_id', auth()->id())
                ->where('status', 'pending')
                ->orderBy('booking_date', 'desc')
                ->get();

            return view('userService.listInvoiceUser', compact('invoices'));
        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Đã xảy ra lỗi: ' . $e->getMessage());
        }
    }

    // Hủy dịch vụ đã đặt của người dùng
    public function cancelInvoiceUser(Request $request)
    {
        try {
            $id = $request->get('id');
            $invoice = BookingService::find($id);

            if (!$invoice) {
                return redirect()->route('home')->with('error', 'Hóa đơn không tồn tại.');
            }

            if ($invoice->customer_id !== auth()->id()) {
                return redirect()->route('home')->with('error', 'Bạn không có quyền hủy hóa đơn này.');
            }

            if ($invoice->status === 'pending') {
                $invoice->status = 'cancelled';
                $invoice->save();

                $bookingCount = BookingService::where('customer_id', auth()->id())
                    ->where('status', 'pending')
                    ->count();
                session(['booking_count' => $bookingCount]);

                return back()->with('success', 'Hóa đơn đã được hủy thành công.');
            }

            return back()->with('error', 'Chỉ có thể hủy hóa đơn ở trạng thái đang chờ xác nhận.');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}

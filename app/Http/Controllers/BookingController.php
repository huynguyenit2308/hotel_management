<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function __construct()
    {
        // Remove authentication middleware
    }

    // Hiển thị form đặt phòng trực tuyến
    public function create(Request $request)
    {
        $rooms = Room::where('status_id', 1)->get();
        $room_id = $request->query('room_id');
        return view('bookings.create', compact('rooms', 'room_id'));
    }

    // Xử lý đặt phòng trực tuyến   
    public function storeOnline(Request $request)
    {
        try {
            $validated = $request->validate([
                'full_name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:15',
                'room_id' => 'required|exists:room,id',
                'check_in_date' => 'required|date|after:today',
                'check_out_date' => 'required|date|after:check_in_date',
            ]);

            // Tạo hoặc tìm khách hàng
            $customer = Customer::firstOrCreate(
                ['email' => $validated['email']],
                [
                    'full_name' => $validated['full_name'],
                    'phone' => $validated['phone'],
                    'registration_date' => Carbon::now(),
                ]
            );

            // Kiểm tra phòng trống
            $isAvailable = !Booking::where('room_id', $validated['room_id'])
                ->where(function ($query) use ($validated) {
                    $query->whereBetween('check_in_date', [$validated['check_in_date'], $validated['check_out_date']])
                          ->orWhereBetween('check_out_date', [$validated['check_in_date'], $validated['check_out_date']])
                          ->orWhere(function ($q) use ($validated) {
                              $q->where('check_in_date', '<=', $validated['check_in_date'])
                                ->where('check_out_date', '>=', $validated['check_out_date']);
                          });
                })->exists();

            if (!$isAvailable) {
                return redirect()->back()->with('error', 'Phòng đã được đặt trong khoảng thời gian này.')->withInput();
            }

            Booking::create([
                'customer_id' => $customer->id,
                'room_id' => $validated['room_id'],
                'booking_date' => Carbon::now(),
                'check_in_date' => $validated['check_in_date'],
                'check_out_date' => $validated['check_out_date'],
                'status_name' => 'Pending',
            ]);

            return redirect()->route('bookings.index')->with('success', 'Đặt phòng thành công. Vui lòng chờ xác nhận.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Đã xảy ra lỗi khi đặt phòng. Vui lòng thử lại sau.')->withInput();
        }
    }

    // Hiển thị form đặt phòng trực tiếp (cho nhân viên)
    public function createDirect()
    {
        $rooms = Room::where('status_id', 1)->get();
        $customers = Customer::all();
        return view('bookings.create_direct', compact('rooms', 'customers'));
    }

    // Xử lý đặt phòng trực tiếp
    public function storeDirect(Request $request)
    {
        try {
            $validated = $request->validate([
                'full_name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:15',
                'room_id' => 'required|exists:room,id',
                'check_in_date' => 'required|date|after_or_equal:today',
                'check_out_date' => 'required|date|after:check_in_date',
            ]);

            // Tạo hoặc tìm khách hàng
            $customer = Customer::firstOrCreate(
                ['email' => $validated['email']],
                [
                    'full_name' => $validated['full_name'],
                    'phone' => $validated['phone'],
                    'registration_date' => Carbon::now(),
                ]
            );

            // Kiểm tra phòng trống
            $isAvailable = !Booking::where('room_id', $validated['room_id'])
                ->where(function ($query) use ($validated) {
                    $query->whereBetween('check_in_date', [$validated['check_in_date'], $validated['check_out_date']])
                          ->orWhereBetween('check_out_date', [$validated['check_in_date'], $validated['check_out_date']])
                          ->orWhere(function ($q) use ($validated) {
                              $q->where('check_in_date', '<=', $validated['check_in_date'])
                                ->where('check_out_date', '>=', $validated['check_out_date']);
                          });
                })->exists();

            if (!$isAvailable) {
                return redirect()->back()->with('error', 'Phòng đã được đặt trong khoảng thời gian này.')->withInput();
            }

            // Tạo booking mới
            $booking = Booking::create([
                'customer_id' => $customer->id,
                'room_id' => $validated['room_id'],
                'booking_date' => Carbon::now(),
                'check_in_date' => $validated['check_in_date'],
                'check_out_date' => $validated['check_out_date'],
                'status_name' => 'Confirmed',
            ]);

            // Cập nhật trạng thái phòng
            Room::find($validated['room_id'])->update(['status_id' => 2]); // Occupied

            return redirect()->route('bookings.index')->with('success', 'Đặt phòng trực tiếp thành công.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Đã xảy ra lỗi khi đặt phòng. Vui lòng thử lại sau.')->withInput();
        }
    }

    // Danh sách đặt phòng
    public function index(Request $request)
    {
        $query = Booking::with(['customer', 'room']);

        if ($request->has('search')) {
            $query->whereHas('customer', function ($q) use ($request) {
                $q->where('full_name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%');
            });
        }

        $bookings = $query->paginate(10);
        return view('bookings.index', compact('bookings'));
    }

    // Xem chi tiết đặt phòng
    public function show(Booking $booking)
    {
        return view('bookings.show', compact('booking'));
    }

    // Hiển thị form cập nhật đặt phòng
    public function edit(Booking $booking)
    {
        $rooms = Room::where('status_id', 1)->get();
        $customers = Customer::all();
        return view('bookings.edit', compact('booking', 'rooms', 'customers'));
    }

    // Cập nhật đặt phòng
    public function update(Request $request, Booking $booking)
    {
        try {
            $validated = $request->validate([
                'room_id' => 'required|exists:room,id',
                'check_in_date' => 'required|date|after_or_equal:today',
                'check_out_date' => 'required|date|after:check_in_date',
                'status_name' => 'required|in:Pending,Confirmed,Cancelled,Completed',
            ]);

            // Kiểm tra phòng trống (trừ booking hiện tại)
            $isAvailable = !Booking::where('room_id', $validated['room_id'])
                ->where('id', '!=', $booking->id)
                ->where(function ($query) use ($validated) {
                    $query->whereBetween('check_in_date', [$validated['check_in_date'], $validated['check_out_date']])
                          ->orWhereBetween('check_out_date', [$validated['check_in_date'], $validated['check_out_date']])
                          ->orWhere(function ($q) use ($validated) {
                              $q->where('check_in_date', '<=', $validated['check_in_date'])
                                ->where('check_out_date', '>=', $validated['check_out_date']);
                          });
                })->exists();

            if (!$isAvailable) {
                return redirect()->back()->with('error', 'Phòng đã được đặt trong khoảng thời gian này.')->withInput();
            }

            // Cập nhật thông tin đặt phòng
            $booking->update([
                'room_id' => $validated['room_id'],
                'check_in_date' => $validated['check_in_date'],
                'check_out_date' => $validated['check_out_date'],
                'status_name' => $validated['status_name'],
            ]);

            // Cập nhật trạng thái phòng
            if ($validated['status_name'] == 'Confirmed') {
                Room::find($validated['room_id'])->update(['status_id' => 2]); // Occupied
            } elseif ($validated['status_name'] == 'Cancelled' || $validated['status_name'] == 'Completed') {
                Room::find($validated['room_id'])->update(['status_id' => 1]); // Available
            }

            return redirect()->route('bookings.index')->with('success', 'Cập nhật đặt phòng thành công.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Đã xảy ra lỗi khi cập nhật đặt phòng. Vui lòng thử lại sau.')->withInput();
        }
    }

    // Hủy đặt phòng
    public function destroy(Booking $booking)
    {
        try {
            // Cập nhật trạng thái phòng về Available
            Room::find($booking->room_id)->update(['status_id' => 1]);
            // Xóa bản ghi booking
            $booking->delete();
            return redirect()->route('bookings.index')->with('success', 'Hủy đặt phòng thành công.');
        } catch (\Exception $e) {
            return redirect()->route('bookings.index')->with('error', 'Đã xảy ra lỗi khi hủy đặt phòng. Vui lòng thử lại sau.');
        }
    }
}
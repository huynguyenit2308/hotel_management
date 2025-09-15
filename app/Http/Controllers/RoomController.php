<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomStatus;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Room::with('status');

            // Tìm kiếm theo số phòng
            if ($request->has('search')) {
                $query->where('room_number', 'like', '%' . $request->search . '%');
            }

            // Lọc theo loại phòng
            if ($request->has('room_type') && $request->room_type != '') {
                $query->where('room_type', $request->room_type);
            }

            // Lọc theo trạng thái
            if ($request->has('status') && $request->status != '') {
                $query->where('status_id', $request->status);
            }

            $rooms = $query->paginate(6);
            $roomTypes = Room::distinct()->pluck('room_type');
            $statuses = RoomStatus::all();

            $page = $request->query('page');
        if ($page !== null) {
            // Nếu page không phải số nguyên dương
            if (!ctype_digit(strval($page)) || intval($page) < 1) {
                return redirect()->route('rooms.index')->with('error', 'Số trang không hợp lệ.');
            }
            // Nếu page vượt quá tổng số trang
            if ($rooms->lastPage() > 0 && intval($page) > $rooms->lastPage()) {
                return redirect()->route('rooms.index')->with('error', 'Số trang không tồn tại.');
            }
        }

            return view('rooms.index', compact('rooms', 'roomTypes', 'statuses'));
        } catch (\Exception $e) {
            return redirect()->route('rooms.index')->with('error', 'Đã xảy ra lỗi khi tải danh sách phòng. Vui lòng thử lại sau.');
        }
    }

    public function create()
    {
        try {
            $statuses = RoomStatus::all();
            return view('rooms.create', compact('statuses'));
        } catch (\Exception $e) {
            return redirect()->route('rooms.index')->with('error', 'Đã xảy ra lỗi khi tải trang thêm phòng. Vui lòng thử lại sau.');
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'room_number' => 'required|string|max:50|unique:room',
                'room_type' => 'required|string|max:50',
                'price' => 'required|integer|min:0',
                'status_id' => 'required|exists:room_status,id'
            ]);

            Room::create($validated);
            return redirect()->route('rooms.index')->with('success', 'Thêm phòng thành công.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (QueryException $e) {
            if (str_contains($e->getMessage(), 'Data too long')) {
                return redirect()->back()->with('error', 'Dữ liệu quá dài. Vui lòng kiểm tra lại thông tin nhập vào.')->withInput();
            }
            return redirect()->back()->with('error', 'Đã xảy ra lỗi khi thêm phòng. Vui lòng thử lại sau.')->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Đã xảy ra lỗi không xác định. Vui lòng thử lại sau.')->withInput();
        }
    }

    public function show($id)
    {
        try {
            $room = Room::findOrFail($id);
            return view('rooms.show', compact('room'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404, 'Không tìm thấy trang');
        } catch (\Exception $e) {
            return redirect()->route('rooms.index')->with('error', 'Đã xảy ra lỗi khi tải thông tin phòng. Vui lòng thử lại sau.');
        }
    }

    public function edit($id)
    {
        try {
            $room = Room::findOrFail($id);
            $statuses = RoomStatus::all();
            return view('rooms.edit', compact('room', 'statuses'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404, 'Không tìm thấy trang');
        } catch (\Exception $e) {
            return redirect()->route('rooms.index')->with('error', 'Đã xảy ra lỗi khi tải trang chỉnh sửa. Vui lòng thử lại sau.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $room = Room::findOrFail($id);
            if ($request->has('updated_at') && $request->updated_at != $room->updated_at) {
                return redirect()->back()->with('error', 'Dữ liệu phòng đã bị thay đổi. Vui lòng tải lại trang trước khi cập nhật.');
            }
            $validated = $request->validate([
                'room_number' => 'required|string|max:50|unique:room,room_number,' . $room->id,
                'room_type' => 'required|string|max:50',
                'price' => 'required|integer|min:0',
                'status_id' => 'required|exists:room_status,id'
            ], [
                'status_id.exists' => 'Danh mục không tồn tại.',
            ]);
            $room->update($validated);
            return redirect()->route('rooms.index')->with('success', 'Cập nhật phòng thành công.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404, 'Không tìm thấy trang');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (QueryException $e) {
            if (str_contains($e->getMessage(), 'Data too long')) {
                return redirect()->back()->with('error', 'Dữ liệu quá dài. Vui lòng kiểm tra lại thông tin nhập vào.')->withInput();
            }
            return redirect()->back()->with('error', 'Đã xảy ra lỗi khi cập nhật phòng. Vui lòng thử lại sau.')->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Đã xảy ra lỗi không xác định. Vui lòng thử lại sau.')->withInput();
        }
    }
    ////****** */
    public function destroy($id)
    {
        try {
            $room = Room::find($id);
            if (!$room) {
                return redirect()->route('rooms.index')->with('error', 'Phòng này không tồn tại hoặc đã bị xóa.');
            }
            $room->delete();
            return redirect()->route('rooms.index')->with('success', 'Xóa phòng thành công.');
        } catch (\Exception $e) {
            return redirect()->route('rooms.index')->with('error', 'Đã xảy ra lỗi khi xóa phòng. Vui lòng thử lại sau.');
        }
    }
}

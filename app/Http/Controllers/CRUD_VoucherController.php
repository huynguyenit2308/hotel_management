<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\Request;

class CRUD_VoucherController extends Controller
{
    // Danh sách voucher
    public function listVoucher()
    {
        try {
            $voucher = Voucher::paginate(6);

            if ($voucher->isEmpty()) {
                return view('crud_voucher.list', compact('voucher'))
                    ->with('error', 'Không có voucher nào!!!');
            }

            return view('crud_voucher.list', compact('voucher'));
        } catch (\Exception $e) {
            return back()->with('error', 'Đã xảy ra lỗi khi tải danh sách voucher: ' . $e->getMessage());
        }
    }

    // Thêm voucher
    public function addVoucher()
    {
        return view('crud_voucher.add');
    }

    public function postAddVoucher(Request $request)
    {
        $request->validate([
            'code' => 'required|max:50|unique:voucher,code',
            'type' => 'required|in:percent,fixed',
            'value' => 'required|numeric|min:0',
            'usage_limit' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'active' => 'required|boolean',
        ], [
            'code.required' => 'Vui lòng nhập mã voucher.',
            'code.max' => 'Mã voucher không được vượt quá 50 ký tự.',
            'code.unique' => 'Mã voucher đã tồn tại.',
            'type.required' => 'Vui lòng chọn loại voucher.',
            'type.in' => 'Loại voucher không hợp lệ.',
            'value.required' => 'Vui lòng nhập giá trị giảm.',
            'value.numeric' => 'Giá trị giảm phải là số.',
            'usage_limit.required' => 'Vui lòng nhập số lượt sử dụng tối đa.',
            'usage_limit.integer' => 'Số lượt sử dụng phải là số nguyên.',
            'start_date.required' => 'Vui lòng chọn ngày bắt đầu.',
            'end_date.required' => 'Vui lòng chọn ngày kết thúc.',
            'end_date.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu.',
            'active.required' => 'Vui lòng chọn trạng thái kích hoạt.',
            'active.boolean' => 'Trạng thái kích hoạt không hợp lệ.'
        ]);

        $voucher = Voucher::create([
            'code' => $request->code,
            'type' => $request->type,
            'value' => $request->value,
            'usage_limit' => $request->usage_limit,
            'used_count' => 0,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'active' => $request->active,
        ]);

        return redirect()->route('voucher.list')->with('success', 'Thêm voucher "' . $voucher->code . '" thành công!');
    }

    // Chi tiết voucher
    public function detailVoucher(Request $request)
    {
        try {
            $id = $request->get('id');
            $voucher = Voucher::find($id);

            if (!$voucher) {
                return redirect()->route('voucher.list')->with('error', 'Voucher không tồn tại.');
            }

            return view('crud_voucher.detail', compact('voucher'));
        } catch (\Exception $e) {
            return redirect()->route('voucher.list')->with('error', 'Đã có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    // Xóa voucher
    public function deleteVoucher(Request $request)
    {
        try {
            $id = $request->get('id');
            $voucher = Voucher::find($id);

            if (!$voucher) {
                return redirect()->route('voucher.list')->with('error', 'Voucher không tồn tại!');
            }

            $voucherName = $voucher->code;
            $voucher->delete();

            return redirect()->route('voucher.list')->with('success', 'Xóa voucher "' . $voucherName . '" thành công!');
        } catch (\Exception $e) {
            return redirect()->route('voucher.list')->with('error', 'Đã có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    // Sửa dịch vụ
    public function updateVoucher(Request $request)
    {
        $id = $request->get('id');
        $voucher = Voucher::find($id);
        return view('crud_voucher.update', compact('voucher'));
    }

    public function updatePostVoucher(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:voucher,id',
            'code' => 'required|max:50|unique:voucher,code,' . $request->id,
            'type' => 'required|in:percent,fixed',
            'value' => 'required|numeric|min:0',
            'usage_limit' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'active' => 'required|boolean',
        ], [
            'id.required' => 'Thiếu ID voucher.',
            'id.exists' => 'Voucher không tồn tại.',
            'code.required' => 'Vui lòng nhập mã voucher.',
            'code.max' => 'Mã voucher không được vượt quá 50 ký tự.',
            'code.unique' => 'Mã voucher đã tồn tại.',
            'type.required' => 'Vui lòng chọn loại voucher.',
            'type.in' => 'Loại voucher không hợp lệ.',
            'value.required' => 'Vui lòng nhập giá trị giảm.',
            'value.numeric' => 'Giá trị giảm phải là số.',
            'usage_limit.required' => 'Vui lòng nhập số lượt sử dụng tối đa.',
            'usage_limit.integer' => 'Số lượt sử dụng phải là số nguyên.',
            'start_date.required' => 'Vui lòng chọn ngày bắt đầu.',
            'end_date.required' => 'Vui lòng chọn ngày kết thúc.',
            'end_date.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu.',
            'active.required' => 'Vui lòng chọn trạng thái kích hoạt.',
            'active.boolean' => 'Trạng thái kích hoạt không hợp lệ.'
        ]);

        $voucher = Voucher::find($request->id);

        $voucher->update([
            'code' => $request->code,
            'type' => $request->type,
            'value' => $request->value,
            'usage_limit' => $request->usage_limit,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'active' => $request->active,
        ]);

        return redirect()->route('voucher.detail', ['id' => $voucher->id])
            ->with('success', 'Cập nhật voucher "' . $voucher->code . '" thành công!');
    }
}

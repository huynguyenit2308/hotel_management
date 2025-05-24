<?php

namespace App\Http\Controllers;

use App\Helpers\IdEncoder;
use App\Models\Voucher;
use Illuminate\Http\Request;

class CRUD_VoucherController extends Controller
{
    // Danh sách voucher
    public function listVoucher()
    {
        $voucher = Voucher::paginate(6);

        if ($voucher->isEmpty()) {
            return view('crud_voucher.list', compact('voucher'))->with('error', 'Không có voucher nào!!!');
        }
        foreach ($voucher as $value) {
            $value->encoded_id = IdEncoder::encodeId($value->id);
        }

        return view('crud_voucher.list', compact('voucher'));
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
        $encodedId = $request->get('id');
        $id = IdEncoder::decodeId($encodedId);

        if (!$id || !($voucher = Voucher::find($id))) {
            return redirect()->route('voucher.list')->with('error', 'ID không hợp lệ!');
        }

        return view('crud_voucher.detail', compact('voucher'));
    }

    // Xóa voucher
    public function deleteVoucher(Request $request)
    {
        $encodedId = $request->get('id');
        $id = IdEncoder::decodeId($encodedId);

        if (!$id || !($voucher = Voucher::find($id))) {
            return redirect()->route('voucher.list')->with('error', 'ID không hợp lệ!');
        }

        $voucherName = $voucher->code;
        $voucher->delete();

        return redirect()->route('voucher.list')->with('success', 'Xóa voucher "' . $voucherName . '" thành công!');
    }

    // Sửa dịch vụ
    public function updateVoucher(Request $request)
    {
        $encodedId = $request->get('id');
        $id = IdEncoder::decodeId($encodedId);

        if (!$id || !($voucher = Voucher::find($id))) {
            return redirect()->route('voucher.list')->with('error', 'ID không hợp lệ!');
        }

        return view('crud_voucher.update', compact('voucher'));
    }

    public function updatePostVoucher(Request $request)
    {
        $encodedId = $request->get('id');
        $id = IdEncoder::decodeId($encodedId);

        $request->merge(['id' => $id]);
        $request->validate([
            'id' => 'required|exists:voucher,id',
            'code' => 'required|max:50' . $id,
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

        $voucher = Voucher::find($id);

        $voucher->update([
            'code' => $request->code,
            'type' => $request->type,
            'value' => $request->value,
            'usage_limit' => $request->usage_limit,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'active' => $request->active,
        ]);

        $encodedId = IdEncoder::encodeId($voucher->id);

        return redirect()->route('voucher.detail', ['id' => $encodedId])->with('success', 'Cập nhật voucher "' . $voucher->code . '" thành công!');
    }
}

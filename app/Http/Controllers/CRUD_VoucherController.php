<?php

namespace App\Http\Controllers;

use App\Helpers\IdEncoder;
use App\Models\Voucher;
use App\Rules\HasAtLeastOneChar;
use App\Rules\NoFullWidthSpace;
use App\Rules\NoHTML;
use App\Rules\NotEmptyOrSpace;
use Illuminate\Http\Request;

class CRUD_VoucherController extends Controller
{
    // Danh sách voucher
    public function listVoucher()
    {
        $page = request()->query('page');

        if (!$page) {
            $page = 1;
        }

        if (!is_numeric($page) || (int)$page < 1) {
            return redirect()->route('voucher.list')->with('error', 'Trang không tồn tại.');
        }

        $page = (int) $page;

        $voucher = Voucher::paginate(6, ['*'], 'page', $page);

        if ($page > $voucher->lastPage()) {
            return redirect()->route('voucher.list')->with('error', 'Trang không tồn tại.');
        }

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
            'code' => [
                'max:50',
                'unique:voucher,code',
                new NoFullWidthSpace(),
                new NotEmptyOrSpace(),
                new HasAtLeastOneChar(),
                new NoHTML(),
            ],
            'type' => 'required|in:percent,fixed',
            'value' => 'required|numeric|min:0',
            'usage_limit' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'active' => 'required|boolean',
        ], [
            // 'code.required' => 'Vui lòng nhập mã voucher.',
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
        ], [
            'code' => 'Mã voucher',
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
        $encodedId = $request->input('id');
        $id = IdEncoder::decodeId($encodedId);

        if (!$id) {
            return redirect()->route('voucher.list')->with('error', 'ID không hợp lệ!');
        }

        $voucher = Voucher::find($id);
        if (!$voucher) {
            return redirect()->route('voucher.list')->with('error', 'Voucher đã bị xóa hoặc không tồn tại!');
        }

        $voucherName = $voucher->code;
        $voucher->delete();

        return redirect()->route('voucher.list')->with('success', 'Xóa voucher "' . $voucherName . '" thành công!');
    }

    // Sửa voucher
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
        $request->validate([
            'code' => [
                'max:50',
                new NoFullWidthSpace(),
                new NotEmptyOrSpace(),
                new HasAtLeastOneChar(),
                new NoHTML(),
            ],
            'type' => 'required|in:percent,fixed',
            'value' => 'required|numeric|min:0',
            'usage_limit' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'active' => 'required|boolean',
        ], [
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
        ], [
            'code' => 'Mã voucher',
        ]);
        $encodedId = $request->get('id');
        $id = IdEncoder::decodeId($encodedId);
        $voucher = Voucher::find($id);

        $formUpdatedAt = $request->input('updated_at');
        if ($voucher->updated_at->toDateTimeString() !== $formUpdatedAt) {
            return back()->withInput()->with('error', 'Dữ liệu đã bị thay đổi bởi người khác. Vui lòng tải lại trang và thử lại.');
        }

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

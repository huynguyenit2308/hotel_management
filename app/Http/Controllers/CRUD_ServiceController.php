<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Helpers\IdEncoder;

class CRUD_ServiceController extends Controller
{
    // Danh sách dịch vụ
    public function listService()
    {
        $service = Service::paginate(6);

        if ($service->isEmpty()) {
            return view('crud_service.list', compact('service'))->with('error', 'Không có dịch vụ nào!!!');
        }
        foreach ($service as $value) {
            $value->encoded_id = IdEncoder::encodeId($value->id);
        }
        return view('crud_service.list', compact('service'));
    }

    // Thêm dịch vụ
    public function addService()
    {
        return view('crud_service.add');
    }

    public function postAddService(Request $request)
    {
        $request->validate([
            'service_name' => 'required|max:255|unique:service,service_name',
            'price' => 'required|numeric|min:0|max:1000000000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required|max:1000',
        ], [
            'service_name.required' => 'Vui lòng nhập tên dịch vụ.',
            'service_name.max' => 'Tên dịch vụ không được vượt quá 255 ký tự.',
            'service_name.unique' => 'Tên dịch vụ đã tồn tại.',
            'price.required' => 'Vui lòng nhập giá dịch vụ.',
            'price.numeric' => 'Giá phải là một số.',
            'price.min' => 'Giá phải lớn hơn hoặc bằng 0.',
            'price.max' => 'Giá không được quá 1 tỷ.',
            'image.image' => 'Tập tin phải là một ảnh.',
            'image.mimes' => 'Ảnh phải có định dạng jpeg, png, jpg, gif, hoặc svg.',
            'image.max' => 'Ảnh phải có kích thước nhỏ hơn 2MB.',
            'description.required' => 'Vui lòng nhập mô tả dịch vụ.',
            'description.max' => 'Mô tả dịch vụ không được vượt quá 1000 ký tự.',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('service_images', 'public');
        } else {
            $imagePath = null;
        }

        $service = Service::create([
            'service_name' => $request->service_name,
            'price' => $request->price,
            'image' => $imagePath,
            'description' => $request->description,
        ]);
        return redirect()->route('service.list')->with('success', 'Thêm dịch vụ "' . $service->service_name . '" thành công!');
    }


    // Chi tiết dịch vụ
    public function detailService(Request $request)
    {
        $encodedId = $request->get('id');
        $id = IdEncoder::decodeId($encodedId);

        if (!$id || !($service = Service::find($id))) {
            return redirect()->route('service.list')->with('error', 'ID không hợp lệ!');
        }

        return view('crud_service.detail', compact('service'));
    }

    // Xóa dịch vụ
    public function deleteService(Request $request)
    {
        $encodedId = $request->get('id');
        $id = IdEncoder::decodeId($encodedId);

        if (!$id) {
            return redirect()->route('service.list')->with('error', 'ID không hợp lệ!');
        }

        $service = Service::find($id);
        if (!$service) {
            return redirect()->route('service.list')->with('error', 'Dịch vụ đã bị xóa hoặc không tồn tại!');
        }

        if ($service->image && Storage::exists('public/' . $service->image)) {
            Storage::delete('public/' . $service->image);
        }

        $serviceName = $service->service_name;
        $service->delete();

        return redirect()->route('service.list')->with('success', 'Xóa dịch vụ "' . $serviceName . '" thành công!');
    }

    // Sửa dịch vụ
    public function updateService(Request $request)
    {
        $encodedId = $request->get('id');
        $id = IdEncoder::decodeId($encodedId);

        if (!$id || !($service = Service::find($id))) {
            return redirect()->route('service.list')->with('error', 'ID không hợp lệ!');
        }

        return view('crud_service.update', compact('service'));
    }

    public function updatePostService(Request $request)
    {
        $request->validate([
            'service_name' => 'required|max:255',
            'price' => 'required|numeric|min:0|max:100000000000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required|max:1000',
        ], [
            'service_name.required' => 'Vui lòng nhập tên dịch vụ.',
            'service_name.max' => 'Tên dịch vụ không được vượt quá 255 ký tự.',
            'price.required' => 'Vui lòng nhập giá dịch vụ.',
            'price.numeric' => 'Giá phải là một số.',
            'price.min' => 'Giá phải lớn hơn hoặc bằng 0.',
            'price.max' => 'Giá không được quá 100 tỷ.',
            'image.image' => 'Tập tin phải là một ảnh.',
            'image.mimes' => 'Ảnh phải có định dạng jpeg, png, jpg, gif, hoặc svg.',
            'image.max' => 'Ảnh phải có kích thước nhỏ hơn 2MB.',
            'description.required' => 'Vui lòng nhập mô tả dịch vụ.',
            'description.max' => 'Mô tả dịch vụ không được vượt quá 1000 ký tự.',
        ]);

        $encodedId = $request->get('id');
        $id = IdEncoder::decodeId($encodedId);

        if (!$id) {
            return redirect()->back()->with('error', 'ID không hợp lệ!');
        }
        $service = Service::find($id);
        if (!$service) {
            return redirect()->back()->with('error', 'Dịch vụ không tồn tại!');
        }
        $imagePath = $service->image;
        if ($request->hasFile('image')) {
            if ($service->image && Storage::exists('public/' . $service->image)) {
                Storage::delete('public/' . $service->image);
            }

            $imagePath = $request->file('image')->store('service_images', 'public');
        }

        $service->update([
            'service_name' => $request->service_name,
            'price' => $request->price,
            'image' => $imagePath,
            'description' => $request->description,
        ]);

        return redirect()->route('service.detail', ['id' => IdEncoder::encodeId($service->id)])->with('success', 'Sửa dịch vụ "' . $service->service_name . '" thành công!');
    }

    // Tìm kiếm dịch vụ
    public function searchService(Request $request)
    {
        $keyword = $request->get('keyword');

        $service = Service::where('service_name', 'like', "%{$keyword}%")
            ->orWhere('price', 'like', "%{$keyword}%")
            ->orWhere('description', 'like', "%{$keyword}%")
            ->paginate(10);

        return view('crud_service.list', compact('service'));
    }

    public function autoCompleteService(Request $request)
    {
        try {
            $keyword = $request->get('keyword');
            $services = Service::where('service_name', 'like', '%' . $keyword . '%')->pluck('service_name');
            return response()->json($services);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Lỗi khi gợi ý dịch vụ: ' . $e->getMessage()], 500);
        }
    }

    // Quản lý giá dịch vụ
    public function editPriceService(Request $request)
    {
        $encodedId = $request->get('id');
        $id = IdEncoder::decodeId($encodedId);

        if (!$id || !($service = Service::find($id))) {
            return redirect()->route('service.list')->with('error', 'ID không hợp lệ!');
        }

        return view('crud_service.price', compact('service'));
    }

    public function updatePriceService(Request $request)
    {
        $request->validate([
            'base_price' => 'required|numeric|min:0',
            'adjust_type' => 'required|in:increase,decrease',
            'adjust_percent' => 'required|numeric|min:0|max:100',
        ], [
            'base_price.required' => 'Vui lòng nhập giá gốc.',
            'base_price.numeric' => 'Giá gốc phải là số.',
            'base_price.min' => 'Giá gốc phải lớn hơn hoặc bằng 0.',

            'adjust_type.required' => 'Vui lòng chọn loại điều chỉnh.',
            'adjust_type.in' => 'Loại điều chỉnh không hợp lệ.',

            'adjust_percent.required' => 'Vui lòng nhập phần trăm điều chỉnh.',
            'adjust_percent.numeric' => 'Phần trăm điều chỉnh phải là số.',
            'adjust_percent.min' => 'Phần trăm điều chỉnh không được âm.',
            'adjust_percent.max' => 'Phần trăm điều chỉnh tối đa là 100.',
        ]);
        $basePrice = $request->base_price;
        $percent = $request->adjust_percent;
        $adjustType = $request->adjust_type;

        $adjustedPrice = $adjustType === 'increase'
            ? $basePrice * (1 + $percent / 100)
            : $basePrice * (1 - $percent / 100);

        $encodedId = $request->get('id');
        $id = IdEncoder::decodeId($encodedId);
        $service = Service::find($id);
        $service->price = round($adjustedPrice, 0);
        $service->save();

        return redirect()->route('service.detail', ['id' => $encodedId])->with('success', 'Cập nhật giá thành công!');
    }

    // // Thống kê dịch vụ
    // public function statisticService()
    // {
    //     $statistic = InvoiceDetail::join('service', 'invoice_detail.service_id', '=', 'service.id')
    //         ->select(
    //             'service.service_name as service_name',
    //             DB::raw('SUM(invoice_detail.quantity) as total_quantity'),
    //             DB::raw('SUM(invoice_detail.amount) as total_amount')
    //         )
    //         ->groupBy('service.service_name')
    //         ->orderByDesc('total_amount')
    //         ->get();

    //     return view('crud_service.statistic', compact('statistic'));
    // }

    // Lấy dịch vụ
    public function getAllService()
    {
        $service = Service::all();
        return view('home', compact('service'));
    }
}

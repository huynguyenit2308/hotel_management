<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class CRUD_ServiceController extends Controller
{
    // Danh sách dịch vụ
    public function listService()
    {
        $service = Service::all();
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
            'price' => 'required',
            'description' => 'required|max:1000',
        ], [
            'service_name.required' => 'Vui lòng nhập tên dịch vụ.',
            'service_name.max' => 'Tên dịch vụ không được vượt quá 255 ký tự.',
            'service_name.unique' => 'Tên dịch vụ đã tồn tại.',
            'price.required' => 'Vui lòng nhập giá dịch vụ.',
            'price.numeric' => 'Giá phải là một số.',
            'price.min' => 'Giá phải lớn hơn hoặc bằng 0.',
            'description.required' => 'Vui lòng nhập mô tả dịch vụ.',
            'description.max' => 'Mô tả dịch vụ không được vượt quá 1000 ký tự.',
        ]);
        $service = Service::create([
            'service_name' => $request->service_name,
            'price' => $request->price,
            'description' => $request->description,
        ]);
        return redirect()->route('service.list')->with('success', 'Thêm dịch vụ "' . $service->service_name . '" thành công!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'service_name' => 'required',
            'price' => 'required',
            'description' => 'required',
        ]);
        Service::create([
            'service_name' => $request->service_name,
            'price' => $request->price,
            'description' => $request->description,
        ]);
        return redirect()->route('service.list');
    }

    // Chi tiết dịch vụ
    public function detailService(Request $request)
    {
        $id = $request->get('id');
        $service = Service::find($id);

        if (!$service) {
            return redirect()->route('service.list')->with('error', 'Dịch vụ không tồn tại.');
        }

        return view('crud_service.detail', compact('service'));
    }

    // Xóa dịch vụ
    public function deleteService(Request $request)
    {
        $id = $request->get('id');
        $service = Service::find($id);
        $service->delete();
        return redirect()->route('service.list')->with('success', 'Xóa dịch vụ thành công!');
    }

    // Sửa dịch vụ
    public function updateService(Request $request)
    {
        $id = $request->get('id');
        $service = Service::find($id);
        return view('crud_service.update', compact('service'));
    }

    public function updatePostService(Request $request)
    {
        $request->validate([
            'service_name' => 'required|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required|max:1000',
        ], [
            'service_name.required' => 'Vui lòng nhập tên dịch vụ.',
            'service_name.max' => 'Tên dịch vụ không được vượt quá 255 ký tự.',
            'price.required' => 'Vui lòng nhập giá dịch vụ.',
            'price.numeric' => 'Giá phải là một số.',
            'price.min' => 'Giá phải lớn hơn hoặc bằng 0.',
            'image.image' => 'Tập tin phải là một ảnh.',
            'image.mimes' => 'Ảnh phải có định dạng jpeg, png, jpg, gif, hoặc svg.',
            'image.max' => 'Ảnh phải có kích thước nhỏ hơn 2MB.',
            'description.required' => 'Vui lòng nhập mô tả dịch vụ.',
            'description.max' => 'Mô tả dịch vụ không được vượt quá 1000 ký tự.',
        ]);

        $id = $request->get('id');
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

        return redirect()->route('service.detail', ['id' => $service->id])->with('success', 'Sửa dịch vụ "' . $service->service_name . '" thành công!');
    }
}

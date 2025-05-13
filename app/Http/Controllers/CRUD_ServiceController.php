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
            'service_name' => 'required',
            'price' => 'required',
            'description' => 'required',
        ]);

        $id = $request->get('id');
        $service = Service::find($id);
        $service->update([
            'service_name' => $request->service_name,
            'price' => $request->price,
            'description' => $request->description,
        ]);

        return redirect()->route('service.detail', ['id' => $id]);
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

    // Quản lý giá dịch vụ
    public function editPriceService(Request $request)
    {
        try {
            $id = $request->get('id');
            $service = Service::find($id);

            if (!$service) {
                return redirect()->route('service.list')->with('error', 'Dịch vụ không tồn tại.');
            }

            return view('crud_service.price', compact('service'));
        } catch (\Exception $e) {
            return redirect()->route('service.list')->with('error', 'Lỗi khi truy cập chỉnh sửa giá: ' . $e->getMessage());
        }
    }

    public function updatePriceService(Request $request)
    {
        try {
            $request->validate([
                'base_price' => 'required|numeric|min:0',
                'adjust_type' => 'required|in:increase,decrease',
                'adjust_percent' => 'required|numeric|min:0|max:100',
            ]);

            $basePrice = $request->base_price;
            $percent = $request->adjust_percent;
            $adjustType = $request->adjust_type;

            $adjustedPrice = $adjustType === 'increase'
                ? $basePrice * (1 + $percent / 100)
                : $basePrice * (1 - $percent / 100);

            $id = $request->get('id');
            $service = Service::find($id);
            $service->price = round($adjustedPrice, 0);
            $service->save();

            return redirect()->route('service.detail', ['id' => $id])->with('success', 'Cập nhật giá thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Lỗi khi cập nhật giá: ' . $e->getMessage());
        }
    }
}

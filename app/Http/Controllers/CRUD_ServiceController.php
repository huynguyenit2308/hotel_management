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
     public function deleteService(Request $request) {
        $id = $request->get('id');
        $service = Service::find($id);
        $service->delete();
        return redirect()->route('service.list')->with('success', 'Xóa dịch vụ thành công!');
    }
}

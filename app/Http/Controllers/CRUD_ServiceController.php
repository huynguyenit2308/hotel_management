<?php

namespace App\Http\Controllers;

use App\Models\InvoiceDetail;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CRUD_ServiceController extends Controller
{
    // Danh sách dịch vụ
    public function listService()
    {
        $service = Service::all();
        if ($service->isEmpty()) {
            return view('crud_service.list', compact('service'))->with('error', 'Không có dịch vụ nào!!!');
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
            'service_name' => 'required',
            'price' => 'required',
            'description' => 'required',
        ], [
            'service_name.required' => 'Vui lòng nhập tên dịch vụ.',
            'price.required' => 'Vui lòng nhập giá dịch vụ.',
            'price.numeric' => 'Giá phải là một số.',
            'price.min' => 'Giá phải lớn hơn hoặc bằng 0.',
            'description.required' => 'Vui lòng nhập mô tả dịch vụ.',
        ]);
        $service = Service::create([
            'service_name' => $request->service_name,
            'price' => $request->price,
            'description' => $request->description,
        ]);
        return redirect()->route('service.list')->with('success', 'Thêm dịch vụ "' . $service->service_name . '" thành công!');
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
        return redirect()->route('service.list')->with('success', 'Xóa dịch vụ "' . $service->service_name . '" thành công!');
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
        $id = $request->get('id');
        $service = Service::find($id);
        return view('crud_service.price', compact('service'));
    }

    public function updatePriceService(Request $request)
    {
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
    }

    // Thống kê dịch vụ
    public function statisticService()
    {
        $statistic = InvoiceDetail::join('service', 'invoice_detail.service_id', '=', 'service.id')
            ->select(
                'service.service_name as service_name',
                DB::raw('SUM(invoice_detail.quantity) as total_quantity'),
                DB::raw('SUM(invoice_detail.amount) as total_amount')
            )
            ->groupBy('service.service_name')
            ->orderByDesc('total_amount')
            ->get();

        return view('crud_service.statistic', compact('statistic'));
    }
}

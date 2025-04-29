<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class CRUD_ServiceController extends Controller
{
    // Danh sách dịch vụ
    public function listService()
    {
        $service = Service::paginate(6);
        if ($service->isEmpty()) {
            return view('crud_service.list', compact('service'))->with('error', 'Không có dịch vụ nào!!!');
        }
        return view('crud_service.list', compact('service'));
    }
}

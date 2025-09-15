<?php

namespace App\Http\Controllers;


use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{

    // hiển thị danh sách khách hàng đã đánh giá
    public function List()
    {
        // Lấy tất cả các đánh giá, bao gồm thông tin khách hàng
        $ratings = Rating::with('customer')->get();

        // Trả về view và truyền các đánh giá vào
        return view('ratings.list', compact('ratings'));
    }
    // // Hiển thị form đánh giá (customer)
    public function create()
    {
        return view('ratings.create');
    }

    //Đánh giá của khách hàng
    public function store(Request $request)
    {
        // Validate dữ liệu
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ], [
            'rating.required' => 'Vui lòng chọn một đánh giá từ 1 đến 5.',
            'rating.integer' => 'Đánh giá phải là một số nguyên.',
            'rating.min' => 'Đánh giá phải ít nhất là 1.',
            'rating.max' => 'Đánh giá không được vượt quá 5.',
            'comment.string' => 'Bình luận phải là văn bản.',
        ]);

        $account = Auth::user();
        $customerId = $account->customer_id;

        Rating::create([
            'customer_id' => $customerId,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('ratings.create')->with('success', 'Cảm ơn bạn đã đánh giá!');
    }
    public function showRatings()
    {
        // Lấy tất cả các đánh giá cùng với thông tin khách hàng
        $ratings = Rating::with('customer')->get();
    
        // Trả về view với dữ liệu đánh giá
        return view('ratings.customerRatings', compact('ratings'));
    }
}



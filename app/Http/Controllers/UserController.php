<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = User::query();

            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where('name', 'like', "%{$search}%");
            }

            if ($request->has('role') && !empty($request->role)) {
                $query->where('role', $request->role);
            }

            $users = $query->paginate(6);

            return view('users.index', compact('users'));
        } catch (\Exception $e) {
            Log::error('Error in UserController@index: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Đã xảy ra lỗi khi tải danh sách người dùng.');
        }
    }

    public function create()
    {
        try {
            return view('users.create');
        } catch (\Exception $e) {
            Log::error('Error in UserController@create: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Đã xảy ra lỗi khi tải trang tạo người dùng.');
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:50',
                'email' => 'required|string|email|max:100|unique:users',
                'password' => 'required|string|min:6',
                'role' => 'required|in:admin,staff',
            ], [
                'name.required' => 'Vui lòng nhập tên nhân viên',
                'name.max' => 'Tên nhân viên không được vượt quá 50 ký tự',
                'email.required' => 'Vui lòng nhập email',
                'email.email' => 'Email không đúng định dạng',
                'email.max' => 'Email không được vượt quá 100 ký tự',
                'email.unique' => 'Email đã được sử dụng',
                'password.required' => 'Vui lòng nhập mật khẩu',
                'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
                'role.required' => 'Vui lòng chọn chức vụ',
                'role.in' => 'Chức vụ không hợp lệ',
            ]);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'],
            ]);

            return redirect()->route('users.index')
                ->with('success', 'Thêm nhân viên thành công!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Error creating user: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra khi thêm nhân viên. Vui lòng thử lại!');
        }
    }

    public function show(User $user)
    {
        try {
            return view('users.show', compact('user'));
        } catch (\Exception $e) {
            Log::error('Error in UserController@show: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Đã xảy ra lỗi khi xem thông tin người dùng.');
        }
    }

    public function edit(User $user)
    {
        try {
            return view('users.edit', compact('user'));
        } catch (\Exception $e) {
            Log::error('Error in UserController@edit: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Đã xảy ra lỗi khi tải trang chỉnh sửa người dùng.');
        }
    }

    public function update(Request $request, User $user)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:50',
                'email' => 'required|string|email|max:100|unique:users,email,' . $user->id,
                'role' => 'required|in:admin,staff',
                'password' => 'nullable|string|min:6',
            ], [
                'name.required' => 'Vui lòng nhập tên nhân viên',
                'name.max' => 'Tên nhân viên không được vượt quá 50 ký tự',
                'email.required' => 'Vui lòng nhập email',
                'email.email' => 'Email không đúng định dạng',
                'email.max' => 'Email không được vượt quá 100 ký tự',
                'email.unique' => 'Email đã được sử dụng',
                'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
                'role.required' => 'Vui lòng chọn chức vụ',
                'role.in' => 'Chức vụ không hợp lệ',
            ]);

            $userData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'role' => $validated['role'],
            ];

            if (!empty($validated['password'])) {
                $userData['password'] = Hash::make($validated['password']);
            }

            $user->update($userData);

            return redirect()->route('users.index')
                ->with('success', 'Cập nhật thông tin nhân viên thành công!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating user: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra khi cập nhật thông tin. Vui lòng thử lại!');
        }
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();
            return redirect()->route('users.index')->with('success', 'Xóa người dùng thành công.');
        } catch (\Exception $e) {
            Log::error('Error in UserController@destroy: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Đã xảy ra lỗi khi xóa người dùng. Vui lòng thử lại.');
        }
    }
} 
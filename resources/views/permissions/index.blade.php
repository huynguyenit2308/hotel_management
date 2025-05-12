@extends('dashboard')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Quản lý Phân quyền</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Phân quyền</li>
    </ol>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-user-shield me-1"></i>
            Danh sách Tài khoản và Phân quyền
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên người dùng</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Quyền hiện tại</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($accounts as $account)
                        <tr>
                            <td>{{ $account->id }}</td>
                            <td>{{ $account->customer->full_name }}</td>
                            <td>{{ $account->username }}</td>
                            <td>{{ $account->customer->email }}</td>
                            <td>
                                @if($account->adminRole)
                                    <span class="badge {{ $account->adminRole->role_name == 'Super Admin' ? 'bg-danger' : ($account->adminRole->role_name == 'Admin' ? 'bg-danger' : ($account->adminRole->role_name == 'Employee' ? 'bg-success' : 'bg-secondary')) }}">
                                        {{ $account->adminRole->role_name }}
                                    </span>
                                @else
                                    <span class="badge bg-warning">Chưa phân quyền</span>
                                @endif
                            </td>
                            <td>
                                @if($account->status == 1)
                                <span class="badge bg-success">Hoạt động</span>
                                @else
                                <span class="badge bg-danger">Khóa</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('permissions.edit', $account->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-user-cog"></i> Phân quyền
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Không có tài khoản nào</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $accounts->links() }}
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-info-circle me-1"></i>
            Thông tin về phân quyền
        </div>
        <div class="card-body">
            <h5>Các loại quyền trong hệ thống:</h5>
            <div class="row">
                @foreach($roles as $role)
                <div class="col-md-6 mb-3">
                    <div class="card h-100">
                        <div class="card-header {{ $role->role_name == 'Super Admin' ? 'bg-danger text-white' : ($role->role_name == 'Admin' ? 'bg-primary text-white' : ($role->role_name == 'Employee' ? 'bg-success text-white' : 'bg-secondary text-white')) }}">
                            {{ $role->role_name }}
                        </div>
                        <div class="card-body">
                            <p>{{ $role->description }}</p>
                            <div>
                                <strong>Các quyền bao gồm:</strong>
                                <div class="d-flex flex-wrap mt-2">
                                    @if(is_array($role->permissions))
                                        @foreach($role->permissions as $permission)
                                        <span class="badge bg-info m-1">{{ $permission }}</span>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection 
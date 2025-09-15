@if (session('error'))
    <div class="alert alert-danger shadow-sm" id="error-alert">
        {{ session('error') }}
    </div>
@endif
@extends('dashboard')

@section('content')
    <section id="users" class="py-5">
        <div class="container-fluid padding-side" data-aos="fade-up">
            <h3 class="display-3 text-center fw-normal col-lg-4 offset-lg-4">Danh sách nhân viên</h3>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex gap-4 flex-grow-1 me-4">
                    <form action="{{ route('users.index') }}" method="GET" class="d-flex gap-4 flex-grow-1" id="searchForm">
                        <div class="search-group" style="width: 300px;">
                            <div class="input-group">
                                <button type="submit" class="input-group-text bg-transparent border-0 text-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                                <input type="text" name="search" 
                                    class="form-control bg-secondary bg-opacity-10 border-0 ps-2"
                                    placeholder="Tìm kiếm nhân viên..." 
                                    value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="filter-group" style="width: 150px;">
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-0">
                                    <i class="fas fa-filter text-primary"></i>
                                </span>
                                <select name="role" 
                                    class="form-select bg-secondary bg-opacity-10 border-0 ps-2"
                                    onchange="this.form.submit()">
                                    <option value="">Tất cả</option>
                                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="staff" {{ request('role') == 'staff' ? 'selected' : '' }}>Nhân viên</option>
                                </select>
                            </div>
                        </div>
                        @if(request('search') || request('role'))
                            <a href="{{ route('users.index') }}" 
                               class="btn btn-light rounded-pill d-flex align-items-center gap-2 px-4"
                               style="height: 45px;">
                                <i class="fas fa-sync-alt"></i>
                                <span>Reset</span>
                            </a>
                        @endif
                    </form>
                </div>
                <a href="{{ route('users.create') }}"
                    class="btn btn-primary rounded-pill px-4 py-2 d-flex align-items-center gap-2 shadow-sm transition-all"
                    style="transition: all 0.3s ease-in-out;"
                    onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 16px rgba(0,0,0,0.2)'"
                    onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 6px rgba(0,0,0,0.1)'">
                    <i class="fas fa-user-plus"></i>
                    <span>Thêm nhân viên</span>
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row mt-5 justify-content-center">
                @forelse($users as $user)
                    <div class="col-md-6 col-xl-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="service mb-4 text-center rounded-4 p-5 position-relative" 
                             style="background: #fff; box-shadow: 0 4px 24px rgba(0,0,0,0.08); transition: all 0.3s ease-in-out;"
                             onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 32px rgba(0,0,0,0.12)'"
                             onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 24px rgba(0,0,0,0.08)'">
                            <div class="user-avatar mb-4">
                                <i class="fas fa-user-circle fa-4x text-primary opacity-75"></i>
                            </div>
                            <h4 class="display-6 fw-normal mb-2">{{ $user->name }}</h4>
                            <p class="text-muted mb-3">{{ $user->email }}</p>
                            <span class="badge bg-{{ $user->role == 'admin' ? 'primary' : 'success' }} rounded-pill px-3 py-2 mb-4">
                                {{ ucfirst($user->role) }}
                            </span>
                            <div class="mt-4">
                                <a href="{{ route('users.show', $user) }}" class="btn btn-arrow">
                                    <span class="text-decoration-underline">
                                        Xem chi tiết
                                        <i class="fas fa-arrow-right ms-2"></i>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <div class="empty-state" style="background: #f8f9fa; border-radius: 1rem; padding: 3rem;">
                            <i class="fas fa-user-slash fa-3x text-muted mb-4"></i>
                            <p class="text-muted mb-0">Không tìm thấy nhân viên nào</p>
                        </div>
                    </div>
                @endforelse
            </div>

            @if($users->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $users->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </section>
@endsection

@push('styles')
<style>
    .service {
        background: #fff;
        border-radius: 1rem;
        transition: all 0.3s ease;
    }

    .user-avatar {
        width: 100px;
        height: 100px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: rgba(13, 110, 253, 0.1);
        border-radius: 50%;
        transition: all 0.3s ease;
    }

    .btn-arrow {
        color: #0d6efd;
        background: transparent;
        border: none;
        padding: 0;
        transition: all 0.3s ease;
    }

    .btn-arrow:hover {
        color: #0a58ca;
        transform: translateX(5px);
    }

    .badge {
        font-weight: 500;
    }

    .form-control, .form-select {
        transition: all 0.3s ease;
        height: 45px;
    }

    .form-control:focus, .form-select:focus {
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.15);
        background-color: #fff !important;
    }

    .form-control::placeholder {
        color: #6c757d;
        opacity: 0.8;
    }

    .form-select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
        background-position: right 1rem center;
    }

    .pagination {
        gap: 0.5rem;
    }

    .page-link {
        border-radius: 0.5rem;
        border: none;
        padding: 0.5rem 1rem;
        color: #495057;
        background-color: #f8f9fa;
        transition: all 0.3s ease;
    }

    .page-link:hover {
        background-color: #e9ecef;
        color: #0d6efd;
        transform: translateY(-2px);
    }

    .page-item.active .page-link {
        background-color: #0d6efd;
        color: white;
    }

    .empty-state {
        animation: fadeIn 0.5s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Search Form Styles */
    .search-group, .filter-group {
        position: relative;
    }

    .input-group {
        background-color: rgba(var(--bs-secondary-rgb), 0.1);
        border-radius: 25px;
        overflow: hidden;
    }

    .input-group-text {
        padding-left: 1.25rem;
        cursor: pointer;
    }

    .input-group-text:hover {
        opacity: 0.8;
    }

    .form-control, .form-select {
        transition: all 0.3s ease;
        height: 45px;
        background-color: transparent !important;
    }

    .form-control:focus, .form-select:focus {
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.15);
    }

    .form-control::placeholder {
        color: #6c757d;
        opacity: 0.8;
    }

    .form-select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
        background-position: right 1rem center;
        padding-right: 2.5rem;
    }

    .btn-light {
        background-color: rgba(var(--bs-secondary-rgb), 0.1);
        border: none;
        transition: all 0.3s ease;
    }

    .btn-light:hover {
        background-color: rgba(var(--bs-secondary-rgb), 0.2);
        transform: translateY(-2px);
    }
</style>
@endpush

@push('scripts')
<script>
    AOS.init({
        duration: 800,
        once: true
    });

    // Thêm sự kiện submit form khi nhấn Enter trong input search
    document.querySelector('input[name="search"]').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            document.getElementById('searchForm').submit();
        }
    });
</script>
@endpush 
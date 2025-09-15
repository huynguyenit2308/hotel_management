@extends('dashboard')

@section('content')
<section class="py-5">
    <div class="container-fluid padding-side" data-aos="fade-up">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm rounded-4 border-0">
                    <div class="card-header bg-transparent border-0 pt-4 pb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="display-6 fw-normal mb-0">
                                <i class="fas fa-user-circle me-2 text-primary opacity-75"></i>
                                Thông tin nhân viên
                            </h3>
                            <div class="d-flex gap-3">
                                <a href="{{ route('users.edit', $user) }}" 
                                   class="btn btn-warning rounded-pill px-4 py-2 d-flex align-items-center gap-2">
                                    <i class="fas fa-edit"></i>
                                    <span>Sửa</span>
                                </a>
                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline" 
                                      onsubmit="return confirm('Bạn có chắc chắn muốn xóa nhân viên này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-danger rounded-pill px-4 py-2 d-flex align-items-center gap-2">
                                        <i class="fas fa-trash"></i>
                                        <span>Xóa</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <div class="user-avatar mb-3 mx-auto">
                                <i class="fas fa-user-circle fa-5x text-primary opacity-75"></i>
                            </div>
                            <h4 class="display-6 fw-normal mb-1">{{ $user->name }}</h4>
                            <p class="text-muted mb-3">{{ $user->email }}</p>
                            <span class="badge bg-{{ $user->role == 'admin' ? 'primary' : 'success' }} rounded-pill px-4 py-2">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="detail-item p-3 rounded-3 bg-light">
                                    <small class="text-muted d-block mb-1">Ngày tạo</small>
                                    <p class="mb-0">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-item p-3 rounded-3 bg-light">
                                    <small class="text-muted d-block mb-1">Cập nhật lần cuối</small>
                                    <p class="mb-0">{{ $user->updated_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <a href="{{ route('users.index') }}" 
                               class="btn btn-light rounded-pill px-4 py-2 d-inline-flex align-items-center gap-2">
                                <i class="fas fa-arrow-left"></i>
                                <span>Quay lại danh sách</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .user-avatar {
        width: 120px;
        height: 120px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: rgba(13, 110, 253, 0.1);
        border-radius: 50%;
        transition: all 0.3s ease;
    }

    .detail-item {
        transition: all 0.3s ease;
    }

    .detail-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    }

    .btn {
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .badge {
        font-weight: 500;
    }
</style>
@endpush 
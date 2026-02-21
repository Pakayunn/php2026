@extends('layouts.admin')

@section('title', 'Profile Admin')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="fas fa-shield-alt"></i> Thông tin Admin</h5>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-3 text-center">
                @if($user['avatar'])
                    <img src="{{ $user['avatar'] }}" alt="Avatar" class="img-fluid rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                @else
                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 150px; height: 150px; margin: 0 auto;">
                        <i class="fas fa-user fa-5x text-secondary"></i>
                    </div>
                @endif
            </div>
            <div class="col-md-9">
                <div class="row mb-2">
                    <div class="col-md-6">
                        <label class="form-label text-muted">ID</label>
                        <p class="fs-6"><strong>{{ $user['id'] }}</strong></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Vai trò</label>
                        <p class="fs-6"><span class="badge bg-danger">{{ ucfirst($user['role']) }}</span></p>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-6">
                        <label class="form-label text-muted">Username</label>
                        <p class="fs-6"><strong>{{ $user['username'] }}</strong></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Email</label>
                        <p class="fs-6"><strong>{{ $user['email'] }}</strong></p>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-6">
                        <label class="form-label text-muted">Họ tên</label>
                        <p class="fs-6"><strong>{{ $user['full_name'] ?? 'Chưa cập nhật' }}</strong></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Điện thoại</label>
                        <p class="fs-6"><strong>{{ $user['phone'] ?? 'Chưa cập nhật' }}</strong></p>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-12">
                <a href="/admin" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i> Quay lại Dashboard
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

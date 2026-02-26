@extends('layouts.master')

@section('title', 'Profile')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Thông tin tài khoản</h5>
                </div>

                <div class="card-body">

                    <div class="mb-3">
                        <strong>Họ tên:</strong>
                        <span>{{ $user['full_name'] ?? 'Chưa cập nhật' }}</span>
                    </div>

                    <div class="mb-3">
                        <strong>Username:</strong>
                        <span>{{ $user['username'] ?? '' }}</span>
                    </div>

                    <div class="mb-3">
                        <strong>Email:</strong>
                        <span>{{ $user['email'] ?? '' }}</span>
                    </div>

                    <div class="mb-3">
                        <strong>Điện thoại:</strong>
                        <span>{{ $user['phone'] ?? 'Chưa cập nhật' }}</span>
                    </div>

                    <div class="mb-3">
                        <strong>Vai trò:</strong>
                        <span class="badge bg-info text-dark">
                            {{ $user['role'] ?? '' }}
                        </span>
                    </div>

                    <hr>

                    <a href="/user/editProfile" class="btn btn-warning">
                        Chỉnh sửa thông tin
                    </a>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
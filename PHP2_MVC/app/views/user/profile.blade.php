@extends('layouts.customer')

@section('title', 'Profile')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header">
            <h5>Thông tin tài khoản</h5>
        </div>
        <div class="card-body">

            <p><strong>Họ tên:</strong> {{ $user['full_name'] ?? '' }}</p>
            <p><strong>Username:</strong> {{ $user['username'] ?? '' }}</p>
            <p><strong>Email:</strong> {{ $user['email'] ?? '' }}</p>
            <p><strong>Điện thoại:</strong> {{ $user['phone'] ?? 'Chưa cập nhật' }}</p>
            <p><strong>Vai trò:</strong> {{ $user['role'] ?? '' }}</p>

        </div>
    </div>
</div>
@endsection
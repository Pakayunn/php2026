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
<style>/* ===== PROFILE PAGE - SHARP MODERN STYLE ===== */

/* Giới hạn chiều rộng */
.container {
    max-width: 900px;
}

/* Card chính */
.card {
    border: none;
    border-radius: 0; /* bỏ bo góc */
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
}

/* Header */
.card-header {
    border-radius: 0;
    padding: 18px 25px;
    font-size: 18px;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
}

/* Body */
.card-body {
    padding: 35px;
    background: #ffffff;
}

/* Các dòng thông tin */
.card-body .mb-3 {
    display: grid;
    grid-template-columns: 180px 1fr;
    align-items: center;
    padding: 15px 0;
    border-bottom: 1px solid #e5e5e5;
    margin-bottom: 0;
}

/* Bỏ border cuối */
.card-body .mb-3:last-of-type {
    border-bottom: none;
}

/* Label bên trái */
.card-body strong {
    font-weight: 600;
    color: #777;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Nội dung bên phải */
.card-body span {
    font-size: 16px;
    font-weight: 500;
    color: #111;
}

/* Badge role */
.badge {
    border-radius: 0;
    padding: 6px 14px;
    font-size: 13px;
    font-weight: 600;
    letter-spacing: 0.5px;
}

/* HR */
.card-body hr {
    margin: 25px 0;
    border-top: 2px solid #f0f0f0;
}

/* Nút chỉnh sửa */
.btn-warning {
    border-radius: 0;
    padding: 12px 24px;
    font-weight: 700;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
}

/* Hover nút */
.btn-warning:hover {
    transform: translateX(5px);
    box-shadow: -6px 6px 0 rgba(0, 0, 0, 0.15);
}

/* Responsive */
@media (max-width: 768px) {
    .card-body .mb-3 {
        grid-template-columns: 1fr;
        gap: 5px;
        padding: 12px 0;
    }

    .card-body strong {
        margin-bottom: 5px;
    }
}</style>
@endsection
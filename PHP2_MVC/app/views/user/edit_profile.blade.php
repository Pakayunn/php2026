@extends('layouts.master')

@section('title', 'Chỉnh sửa hồ sơ')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm">
                <div class="card-header bg-warning">
                    <h5 class="mb-0">Chỉnh sửa thông tin</h5>
                </div>

                <div class="card-body">
                    <form method="POST" action="/user/updateProfile">
                        
                        <h6>Đổi mật khẩu (không bắt buộc)</h6>

                        <div class="mb-3">
                            <label class="form-label">Mật khẩu mới</label>
                            <input type="password"
                                   name="password"
                                   class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Xác nhận mật khẩu</label>
                            <input type="password"
                                   name="password_confirmation"
                                   class="form-control">
                        </div>

                        <button type="submit" class="btn btn-success">
                            Cập nhật
                        </button>

                        <a href="/user/profile" class="btn btn-secondary">
                            Hủy
                        </a>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
 <style>/* ===== EDIT PROFILE PAGE - SHARP ADMIN STYLE ===== */

/* Container giới hạn chiều rộng */
.container {
    max-width: 900px;
}

/* Card */
.card {
    border: none;
    border-radius: 0;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
}

/* Header */
.card-header {
    border-radius: 0;
    padding: 18px 25px;
    font-size: 18px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
}

/* Body */
.card-body {
    padding: 35px;
    background: #ffffff;
}

/* Tiêu đề section */
.card-body h6 {
    font-weight: 700;
    text-transform: uppercase;
    font-size: 14px;
    color: #444;
    margin-bottom: 25px;
    padding-bottom: 10px;
    border-bottom: 2px solid #f1f1f1;
}

/* Label */
.form-label {
    font-weight: 600;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #666;
}

/* Input */
.form-control {
    border-radius: 0;
    border: 1px solid #dcdcdc;
    padding: 12px;
    font-size: 15px;
    transition: all 0.3s ease;
    box-shadow: none;
}

/* Focus input */
.form-control:focus {
    border-color: #000;
    box-shadow: none;
}

/* Khoảng cách giữa các input */
.mb-3 {
    margin-bottom: 20px !important;
}

/* Button chung */
.btn {
    border-radius: 0;
    padding: 12px 22px;
    font-weight: 700;
    letter-spacing: 0.5px;
    transition: all 0.25s ease;
}

/* Button cập nhật */
.btn-success:hover {
    transform: translateX(5px);
    box-shadow: -6px 6px 0 rgba(0, 0, 0, 0.15);
}

/* Button hủy */
.btn-secondary {
    margin-left: 10px;
}

.btn-secondary:hover {
    transform: translateX(5px);
    box-shadow: -6px 6px 0 rgba(0, 0, 0, 0.12);
}

/* Responsive */
@media (max-width: 768px) {
    .card-body {
        padding: 25px;
    }

    .btn {
        width: 100%;
        margin-bottom: 10px;
    }

    .btn-secondary {
        margin-left: 0;
    }
}</style>
@endsection
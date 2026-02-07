@extends('layouts.master')

@section('title', 'Quên mật khẩu')

@section('content')

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 col-lg-5">

                <div class="card shadow-sm">
                    <div class="card-body p-4">

                        <h3 class="text-center mb-4">
                            <i class="fas fa-key"></i> Quên mật khẩu
                        </h3>

                        {{-- Hiển thị lỗi --}}
                        @if(isset($error) && $error)
                            <div class="alert alert-danger">
                                {{ $error }}
                            </div>
                        @endif

                        {{-- Hiển thị thành công --}}
                        @if(isset($success) && $success)
                            <div class="alert alert-success">
                                {{ $success }}
                            </div>
                        @endif

                        <form method="post">

                            <div class="mb-3">
                                <label class="form-label">Email của bạn</label>
                                <input type="email" name="email" class="form-control" placeholder="Nhập email đã đăng ký"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mật khẩu mới</label>
                                <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu mới"
                                    required>
                            </div>


                            <button class="btn btn-primary w-100">
                                <i class="fas fa-paper-plane"></i> Gửi yêu cầu
                            </button>

                        </form>

                        <div class="text-center mt-3">
                            <a href="/auth/login" class="text-decoration-none">
                                ← Quay lại đăng nhập
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
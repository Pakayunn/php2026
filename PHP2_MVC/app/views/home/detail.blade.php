@extends('layouts.master')

@section('content')

<div class="container mt-5">
    <div class="row">

        <!-- ẢNH -->
        <div class="col-md-6 position-relative">

            {{-- NÚT WISHLIST --}}
            @if(isset($_SESSION['user']))
                <a href="/wishlist/add/{{ $product['id'] }}"
                   class="btn position-absolute top-0 end-0 m-2 
                   {{ !empty($product['is_liked']) ? 'btn-danger' : 'btn-outline-danger' }}"
                   style="z-index:10;">
                    <i class="fas fa-heart"></i>
                </a>
            @endif

            <img src="{{ $product['image'] ?? 'https://via.placeholder.com/500x400' }}"
                 class="img-fluid rounded shadow-sm"
                 style="width:100%; object-fit:cover;">
        </div>


        <!-- THÔNG TIN -->
        <div class="col-md-6">

            <h3 class="fw-bold">{{ $product['name'] }}</h3>

            <h4 class="text-danger mb-3">
                {{ number_format($product['price']) }} VNĐ
            </h4>

            <p class="text-muted">
                {{ $product['description'] ?? '' }}
            </p>


            <!-- ===== BIẾN THỂ CỨNG ===== -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Chọn màu:</label>
                <select class="form-select" name="variant_color">
                    <option value="Đen">Đen</option>
                    <option value="Trắng">Trắng</option>
                    <option value="Xanh">Xanh</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Dung lượng:</label>
                <select class="form-select" name="variant_storage">
                    <option value="128GB">128GB</option>
                    <option value="256GB">256GB</option>
                </select>
            </div>


            <!-- ===== NÚT HÀNH ĐỘNG ===== -->
            <div class="mt-4 d-flex gap-2">

                @if($product['stock'] > 0)
                    <a href="/cart/add/{{ $product['id'] }}" 
                       class="btn btn-primary">
                        Thêm vào giỏ hàng
                    </a>

                    <a href="/order/buy-now/{{ $product['id'] }}" 
                       class="btn btn-danger">
                        Mua ngay
                    </a>
                @else
                    <button class="btn btn-secondary" disabled>
                        Hết hàng
                    </button>
                @endif

            </div>

        </div>
    </div>
</div>

@endsection
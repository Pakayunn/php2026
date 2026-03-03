@extends('layouts.master')

@section('title', $product['name'])

@section('content')

<div class="container mt-4">

    <div class="row">

        <!-- ẢNH -->
        <div class="col-md-6 position-relative">

            @if(isset($_SESSION['user']))
                <a href="/wishlist/add/{{ $product['id'] }}"
                   class="btn position-absolute top-0 end-0 m-2 
                   {{ !empty($product['is_liked']) ? 'btn-danger' : 'btn-outline-danger' }}"
                   style="z-index:10;">
                    <i class="fas fa-heart"></i>
                </a>
            @endif

            <img src="/uploads/products/{{ $product['image'] }}"
                 class="img-fluid">
        </div>

        <!-- THÔNG TIN -->
        <div class="col-md-6">

            <h3>{{ $product['name'] }}</h3>

            <h4 class="text-danger">
                {{ number_format($product['price']) }} đ
            </h4>

            <p>
                {{ $product['description'] ?? '' }}
            </p>

            <!-- NÚT HÀNH ĐỘNG (THÊM GIỐNG HOME) -->
            <div class="mt-4 d-flex gap-2">

                @if(isset($product['stock']) && $product['stock'] > 0)

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

    <hr class="my-5">

    <h4>Sản phẩm liên quan</h4>

    <div class="row">

        @forelse($relatedProducts as $item)
            <div class="col-md-3">
                <div class="card h-100 shadow-sm">

                    <a href="/shop/detail/{{ $item['id'] }}">
                        <img src="/uploads/products/{{ $item['image'] }}"
                             class="card-img-top"
                             style="height:200px; object-fit:cover;">
                    </a>

                    <div class="card-body text-center">
                        <h6>{{ $item['name'] }}</h6>
                        <div class="text-danger">
                            {{ number_format($item['price']) }} đ
                        </div>

                        <a href="/shop/detail/{{ $item['id'] }}"
                           class="btn btn-sm btn-outline-dark mt-2">
                            Xem chi tiết
                        </a>
                    </div>

                </div>
            </div>
        @empty
            <p>Không có sản phẩm liên quan.</p>
        @endforelse

    </div>

</div>

@endsection
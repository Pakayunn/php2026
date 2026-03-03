@extends('layouts.master')

@section('content')

<div class="container mt-5">

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

            @if(!empty($product['image']))
                <img src="/uploads/products/{{ $product['image'] }}"
                     class="img-fluid"
                     style="height:550px; object-fit:cover;">
            @else
                <img src="https://picsum.photos/600/400"
                     class="img-fluid"
                     style="height:550px; object-fit:cover;">
            @endif
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

            <!-- BIẾN THỂ -->
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

            <!-- NÚT HÀNH ĐỘNG -->
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

    <!-- ================= RELATED PRODUCTS ================= -->

    <hr class="my-5">

    <h4 class="mb-4">Sản phẩm liên quan</h4>

    <div class="row">
        @forelse(($relatedProducts ?? []) as $item)
            <div class="col-md-3 mb-4">
                <div class="card h-100 shadow-sm">

                    <a href="/shop/detail/{{ $item['id'] }}">
                        @if(!empty($item['image']))
                            <img src="/uploads/products/{{ $item['image'] }}"
                                 class="card-img-top"
                                 style="height:250px; object-fit:cover;">
                        @else
                            <img src="https://picsum.photos/400/300"
                                 class="card-img-top"
                                 style="height:250px; object-fit:cover;">
                        @endif
                    </a>

                    <div class="card-body text-center">
                        <h6 class="card-title">
                            <a href="/shop/detail/{{ $item['id'] }}"
                               class="text-decoration-none text-dark">
                                {{ $item['name'] }}
                            </a>
                        </h6>

                        <p class="text-danger fw-bold">
                            {{ number_format($item['price']) }} VNĐ
                        </p>

                        <a href="/shop/detail/{{ $item['id'] }}"
                           class="btn btn-sm btn-outline-primary">
                            Xem chi tiết
                        </a>
                    </div>

                </div>
            </div>
        @empty
            <div class="col-12">
                <p>Không có sản phẩm liên quan.</p>
            </div>
        @endforelse
    </div>

</div>

@endsection
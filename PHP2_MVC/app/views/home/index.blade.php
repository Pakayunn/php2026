@extends('layouts.master')

@section('title', $title ?? 'Trang chủ')

@section('content')

<div class="row g-4">

    <!-- ===== SIDEBAR ===== -->
    <aside class="col-12 col-lg-3">
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-semibold">
                Categories
            </div>

            <div class="list-group list-group-flush">

                <a href="/" class="list-group-item active">
                    All
                </a>

                @if(isset($categories))
                    @foreach($categories as $category)
                        <a href="/product/filterByCategory/{{ $category['id'] }}"
                           class="list-group-item">
                            {{ $category['name'] }}
                        </a>
                    @endforeach
                @endif

            </div>
        </div>
    </aside>


    <!-- ===== PRODUCTS ===== -->
    <section class="col-12 col-lg-9">

        <h1 class="h4 mb-3">Products</h1>

        <div class="row g-3">

        @if(isset($products) && count($products) > 0)

            @foreach($products as $product)

            <div class="col-12 col-sm-6 col-xl-4">
                <div class="card h-100 shadow-sm">

                    <!-- CLICK ẢNH → DETAIL -->
                    <a href="/home/detail/{{ $product['id'] }}">
                        @if(!empty($product['image']))
                            <img src="/uploads/products/{{ $product['image'] }}"
                                 class="card-img-top"
                                 style="height:200px; object-fit:cover;">
                        @else
                            <img src="https://picsum.photos/600/400"
                                 class="card-img-top"
                                 style="height:200px; object-fit:cover;">
                        @endif
                    </a>

                    <div class="card-body d-flex flex-column">

                        <!-- CLICK TÊN → DETAIL -->
                        <h5 class="card-title">
                            <a href="/home/detail/{{ $product['id'] }}"
                               class="text-decoration-none text-dark">
                                {{ $product['name'] }}
                            </a>
                        </h5>

                        <div class="fw-semibold text-danger mb-2">
                            {{ number_format($product['price']) }} đ
                        </div>

                        <!-- Badge biến thể (chuẩn bị nâng cấp sau) -->
                        @if(isset($product['has_variant']) && $product['has_variant'])
                            <span class="badge bg-info mb-2">
                                Có biến thể
                            </span>
                        @endif

                        <div class="mt-auto d-grid gap-2">

                            <a href="/home/detail/{{ $product['id'] }}"
                               class="btn btn-sm btn-outline-dark">
                                Xem chi tiết
                            </a>

                            @if($product['stock'] > 0)
                                <a href="/cart/add/{{ $product['id'] }}"
                                   class="btn btn-sm btn-outline-primary">
                                   Thêm vào giỏ
                                </a>
                            @else
                                <button class="btn btn-sm btn-secondary" disabled>
                                    Hết hàng
                                </button>
                            @endif

                        </div>

                    </div>
                </div>
            </div>

            @endforeach

        @else

            <div class="alert alert-info">
                Không có sản phẩm nào.
            </div>

        @endif

        </div>
    </section>

</div>

@endsection
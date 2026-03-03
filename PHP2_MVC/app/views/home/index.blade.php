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
        <form method="GET" action="/shop" class="card card-body mb-4 shadow-sm">
    <div class="row g-2">

        <!-- Tìm kiếm -->
        <div class="col-12 col-md-3">
            <input type="text"
                   name="keyword"
                   value="{{ $_GET['keyword'] ?? '' }}"
                   class="form-control"
                   placeholder="Tìm sản phẩm...">
        </div>

        <!-- Giá từ -->
        <div class="col-6 col-md-2">
            <input type="number"
                   name="min"
                   value="{{ $_GET['min'] ?? '' }}"
                   class="form-control"
                   placeholder="Giá từ">
        </div>

        <!-- Giá đến -->
        <div class="col-6 col-md-2">
            <input type="number"
                   name="max"
                   value="{{ $_GET['max'] ?? '' }}"
                   class="form-control"
                   placeholder="Giá đến">
        </div>

        <!-- Sắp xếp -->
        <div class="col-12 col-md-3">
            <select name="sort" class="form-select">
                <option value="">Sắp xếp</option>
                <option value="newest" {{ ($_GET['sort'] ?? '') == 'newest' ? 'selected' : '' }}>
                    Mới nhất
                </option>
                <option value="price_asc" {{ ($_GET['sort'] ?? '') == 'price_asc' ? 'selected' : '' }}>
                    Giá tăng dần
                </option>
                <option value="price_desc" {{ ($_GET['sort'] ?? '') == 'price_desc' ? 'selected' : '' }}>
                    Giá giảm dần
                </option>
            </select>
        </div>

        <!-- Button -->
        <div class="col-12 col-md-2 d-grid">
            <button class="btn btn-dark">
                Lọc
            </button>
        </div>

    </div>
</form>
        <div class="row g-3">

        @if(isset($products) && count($products) > 0)

            @foreach($products as $product)

            <div class="col-12 col-sm-6 col-xl-4">
                <div class="card h-100 shadow-sm position-relative">

                    {{-- ===== WISHLIST BUTTON ===== --}}
                    @if(isset($_SESSION['user']))
                        <a href="/wishlist/add/{{ $product['id'] }}"
                           class="btn btn-sm position-absolute top-0 end-0 m-2 
                           {{ !empty($product['is_liked']) ? 'btn-danger' : 'btn-outline-danger' }}"
                           style="z-index:2;">
                            <i class="fas fa-heart"></i>
                        </a>
                    @endif


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
        @if(isset($totalPages) && $totalPages > 1)
<nav class="mt-4">
    <ul class="pagination justify-content-center">

        {{-- Previous --}}
        <li class="page-item {{ $currentPage <= 1 ? 'disabled' : '' }}">
            <a class="page-link" 
               href="?page={{ $currentPage - 1 }}">
                Previous
            </a>
        </li>

        {{-- Number Pages --}}
        @for($i = 1; $i <= $totalPages; $i++)
            <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                <a class="page-link" href="?page={{ $i }}">
                    {{ $i }}
                </a>
            </li>
        @endfor

        {{-- Next --}}
        <li class="page-item {{ $currentPage >= $totalPages ? 'disabled' : '' }}">
            <a class="page-link" 
               href="?page={{ $currentPage + 1 }}">
                Next
            </a>
        </li>

    </ul>
</nav>
@endif

        </div>
    </section>

</div>

@endsection
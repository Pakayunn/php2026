@extends('layouts.master')

@section('title', $title ?? 'Sản phẩm')

@section('content')

<div class="row g-4">

    <!-- ===== SIDEBAR ===== -->
    <aside class="col-12 col-lg-3">
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-semibold">
                Categories
            </div>

            <div class="list-group list-group-flush">
                <a href="/shop" class="list-group-item">
                    All
                </a>

                @if(!empty($categories))
                    @foreach($categories as $category)
                        <a href="/shop?category_id={{ $category['id'] }}"
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

                <div class="col-md-3">
                    <input type="text"
                           name="keyword"
                           value="{{ $_GET['keyword'] ?? '' }}"
                           class="form-control"
                           placeholder="Tìm sản phẩm...">
                </div>

                <div class="col-md-2">
                    <input type="number"
                           name="min"
                           value="{{ $_GET['min'] ?? '' }}"
                           class="form-control"
                           placeholder="Giá từ">
                </div>

                <div class="col-md-2">
                    <input type="number"
                           name="max"
                           value="{{ $_GET['max'] ?? '' }}"
                           class="form-control"
                           placeholder="Giá đến">
                </div>

                <div class="col-md-3">
                    <select name="sort" class="form-select">
                        <option value="">Sắp xếp</option>
                        <option value="newest" {{ ($_GET['sort'] ?? '') == 'newest' ? 'selected' : '' }}>
                            Mới nhất
                        </option>
                        <option value="price_asc" {{ ($_GET['sort'] ?? '') == 'price_asc' ? 'selected' : '' }}>
                            Giá tăng
                        </option>
                        <option value="price_desc" {{ ($_GET['sort'] ?? '') == 'price_desc' ? 'selected' : '' }}>
                            Giá giảm
                        </option>
                    </select>
                </div>

                <div class="col-md-2 d-grid">
                    <button class="btn btn-dark">
                        Lọc
                    </button>
                </div>

            </div>
        </form>

        <div class="row g-3">

        @forelse($products as $product)

            <div class="col-md-4">
                <div class="card h-100 shadow-sm">

                    <a href="/shop/detail/{{ $product['id'] }}">
                        @if(!empty($product['image']))
                            <img src="/uploads/products/{{ $product['image'] }}"
                                 class="card-img-top"
                                 style="height:200px; object-fit:cover;">
                        @endif
                    </a>

                    <div class="card-body d-flex flex-column">

                        <h5 class="card-title">
                            <a href="/shop/detail/{{ $product['id'] }}"
                               class="text-decoration-none text-dark">
                                {{ $product['name'] }}
                            </a>
                        </h5>

                        <div class="fw-bold text-danger mb-2">
                            {{ number_format($product['price']) }} đ
                        </div>

                        <div class="mt-auto d-grid">
                            <a href="/shop/detail/{{ $product['id'] }}"
                               class="btn btn-outline-dark btn-sm">
                                Xem chi tiết
                            </a>
                        </div>

                    </div>
                </div>
            </div>
            

        @empty
            <div class="alert alert-info">
                Không có sản phẩm.
            </div>
        @endforelse

        </div>
        @if(isset($totalPages) && $totalPages > 1)
<nav class="mt-4">
    <ul class="pagination justify-content-center">

        @php
            $query = $_GET;
        @endphp

        {{-- Previous --}}
        <li class="page-item {{ $currentPage <= 1 ? 'disabled' : '' }}">
            @php $query['page'] = $currentPage - 1; @endphp
            <a class="page-link" href="?{{ http_build_query($query) }}">
                Previous
            </a>
        </li>

        {{-- Number Pages --}}
        @for($i = 1; $i <= $totalPages; $i++)
            @php $query['page'] = $i; @endphp
            <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                <a class="page-link" href="?{{ http_build_query($query) }}">
                    {{ $i }}
                </a>
            </li>
        @endfor

        {{-- Next --}}
        <li class="page-item {{ $currentPage >= $totalPages ? 'disabled' : '' }}">
            @php $query['page'] = $currentPage + 1; @endphp
            <a class="page-link" href="?{{ http_build_query($query) }}">
                Next
            </a>
        </li>

    </ul>
</nav>
@endif

    </section>

</div>

@endsection
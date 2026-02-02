@extends('layouts.user')

@section('title', $product['name'] . ' - Shop Online')

@section('content')
<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="/products">Sản phẩm</a></li>
            <li class="breadcrumb-item active">{{ $product['name'] }}</li>
        </ol>
    </nav>

    <!-- Product Detail -->
    <div class="row mb-5">
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm">
                @if(!empty($product['image']))
                    <img src="/uploads/products/{{ $product['image'] }}" 
                         class="card-img-top" 
                         alt="{{ $product['name'] }}"
                         style="height: 500px; object-fit: cover;">
                @else
                    <img src="https://via.placeholder.com/600x500/e5e7eb/6b7280?text={{ urlencode($product['name']) }}" 
                         class="card-img-top" 
                         alt="{{ $product['name'] }}"
                         style="height: 500px; object-fit: cover;">
                @endif
            </div>
        </div>

        <div class="col-lg-6">
            <div class="mb-3">
                <span class="badge bg-primary me-2">{{ $product['category_name'] ?? 'N/A' }}</span>
                <span class="badge bg-info">{{ $product['brand_name'] ?? 'N/A' }}</span>
            </div>

            <h1 class="mb-3">{{ $product['name'] }}</h1>

            <div class="rating mb-3">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
                <span class="text-muted ms-2">(4.5) 128 đánh giá</span>
            </div>

            <h2 class="text-primary mb-4">
                {{ number_format($product['price'], 0, ',', '.') }}đ
            </h2>

            <div class="mb-4">
                @if($product['stock'] > 0)
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> <strong>Còn hàng:</strong> {{ $product['stock'] }} sản phẩm
                    </div>
                @else
                    <div class="alert alert-danger">
                        <i class="fas fa-times-circle"></i> <strong>Hết hàng</strong>
                    </div>
                @endif
            </div>

            <div class="mb-4">
                <h5 class="mb-3">Mô tả sản phẩm:</h5>
                <p class="text-muted">
                    {{ $product['description'] ?? 'Sản phẩm chất lượng cao, được nhập khẩu chính hãng. Bảo hành đầy đủ theo chính sách của nhà sản xuất.' }}
                </p>
            </div>

            <div class="mb-4">
                <h5 class="mb-3">Thông tin chi tiết:</h5>
                <table class="table table-borderless">
                    <tr>
                        <td class="text-muted" width="40%">Danh mục:</td>
                        <td><strong>{{ $product['category_name'] ?? 'N/A' }}</strong></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Thương hiệu:</td>
                        <td><strong>{{ $product['brand_name'] ?? 'N/A' }}</strong></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Tình trạng:</td>
                        <td>
                            @if($product['stock'] > 0)
                                <span class="badge bg-success">Còn hàng</span>
                            @else
                                <span class="badge bg-danger">Hết hàng</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">SKU:</td>
                        <td><strong>SP{{ str_pad($product['id'], 6, '0', STR_PAD_LEFT) }}</strong></td>
                    </tr>
                </table>
            </div>

            @if($product['stock'] > 0)
            <div class="mb-4">
                <label class="form-label"><strong>Số lượng:</strong></label>
                <div class="input-group" style="max-width: 150px;">
                    <button class="btn btn-outline-secondary" type="button">
                        <i class="fas fa-minus"></i>
                    </button>
                    <input type="text" class="form-control text-center" value="1">
                    <button class="btn btn-outline-secondary" type="button">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button class="btn btn-primary btn-lg">
                    <i class="fas fa-shopping-cart"></i> Thêm vào giỏ hàng
                </button>
                <button class="btn btn-success btn-lg">
                    <i class="fas fa-bolt"></i> Mua ngay
                </button>
            </div>
            @endif

            <div class="mt-4 p-3 bg-light rounded">
                <h6 class="mb-3"><i class="fas fa-shield-alt text-primary"></i> Chính sách bảo hành</h6>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2"><i class="fas fa-check text-success"></i> Bảo hành chính hãng 12 tháng</li>
                    <li class="mb-2"><i class="fas fa-check text-success"></i> Đổi trả trong 7 ngày</li>
                    <li class="mb-2"><i class="fas fa-check text-success"></i> Miễn phí vận chuyển toàn quốc</li>
                    <li><i class="fas fa-check text-success"></i> Hỗ trợ kỹ thuật 24/7</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if(!empty($relatedProducts) && count($relatedProducts) > 1)
    <div class="mb-5">
        <h3 class="mb-4"><i class="fas fa-layer-group"></i> Sản phẩm liên quan</h3>
        <div class="row row-cols-1 row-cols-md-4 g-4">
            @foreach(array_slice($relatedProducts, 0, 4) as $related)
                @if($related['id'] != $product['id'])
                <div class="col">
                    <div class="card h-100 product-card border-0">
                        @if(!empty($related['image']))
                            <img src="/uploads/products/{{ $related['image'] }}" 
                                 class="card-img-top" 
                                 alt="{{ $related['name'] }}"
                                 style="height: 200px; object-fit: cover;">
                        @else
                            <img src="https://via.placeholder.com/300x200/e5e7eb/6b7280?text={{ urlencode($related['name']) }}" 
                                 class="card-img-top" 
                                 alt="{{ $related['name'] }}"
                                 style="height: 200px; object-fit: cover;">
                        @endif
                        
                        <div class="card-body">
                            <h6 class="card-title mb-2">{{ $related['name'] }}</h6>
                            <p class="text-primary fw-bold mb-3">
                                {{ number_format($related['price'], 0, ',', '.') }}đ
                            </p>
                            <a href="/detail/{{ $related['id'] }}" class="btn btn-outline-primary btn-sm w-100">
                                Xem chi tiết
                            </a>
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
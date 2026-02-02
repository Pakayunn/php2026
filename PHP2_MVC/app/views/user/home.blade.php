@extends('layouts.user')

@section('title', 'Trang chủ - Shop Online')

@section('content')
<div class="container">
    <!-- Hero Section -->
    <div class="hero-section">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="badge bg-white bg-opacity-25 text-white mb-3">
                    <i class="fas fa-star"></i> 4.9/5 Stars from 500+ Customers
                </div>
                <h1 class="display-4 fw-bold mb-4">
                    AI-Powered Customer Support Shopping Experience
                </h1>
                <p class="lead mb-4">
                    Khám phá hàng nghìn sản phẩm chất lượng cao với công nghệ AI hỗ trợ tư vấn 24/7. 
                    Mua sắm thông minh, tiết kiệm thời gian.
                </p>
                <div class="d-flex gap-3">
                    <a href="#products" class="btn btn-light btn-lg">
                        <i class="fas fa-shopping-bag"></i> Mua sắm ngay
                    </a>
                    <a href="/about" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-info-circle"></i> Tìm hiểu thêm
                    </a>
                </div>
                
                <!-- Features -->
                <div class="row mt-5">
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle fa-lg me-2"></i>
                            <div>
                                <strong>AI-powered responses</strong><br>
                                <small>Cut reply time by 60%</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle fa-lg me-2"></i>
                            <div>
                                <strong>24/7 intelligent chatbot</strong><br>
                                <small>Instant answers anytime</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="text-center">
                    <img src="https://via.placeholder.com/600x400/667eea/ffffff?text=Analytics+Dashboard" 
                         alt="Dashboard" 
                         class="img-fluid rounded shadow-lg">
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="row mb-5">
        <div class="col-md-3 text-center mb-4">
            <div class="p-4">
                <div class="display-4 fw-bold text-primary mb-2">500+</div>
                <p class="text-muted">Khách hàng tin dùng</p>
            </div>
        </div>
        <div class="col-md-3 text-center mb-4">
            <div class="p-4">
                <div class="display-4 fw-bold text-primary mb-2">1000+</div>
                <p class="text-muted">Sản phẩm chất lượng</p>
            </div>
        </div>
        <div class="col-md-3 text-center mb-4">
            <div class="p-4">
                <div class="display-4 fw-bold text-primary mb-2">24/7</div>
                <p class="text-muted">Hỗ trợ khách hàng</p>
            </div>
        </div>
        <div class="col-md-3 text-center mb-4">
            <div class="p-4">
                <div class="display-4 fw-bold text-primary mb-2">99%</div>
                <p class="text-muted">Khách hàng hài lòng</p>
            </div>
        </div>
    </div>

    <!-- Categories Section -->
    @if(!empty($categories))
    <div class="mb-5">
        <h2 class="mb-4"><i class="fas fa-th-large"></i> Danh mục sản phẩm</h2>
        <div class="row">
            @foreach($categories as $category)
            <div class="col-md-3 col-sm-6 mb-3">
                <a href="/products?category={{ $category['id'] }}" class="text-decoration-none">
                    <div class="card border-0 shadow-sm h-100 text-center p-4 category-card">
                        <i class="fas fa-box fa-3x text-primary mb-3"></i>
                        <h5 class="card-title mb-0">{{ $category['name'] }}</h5>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Products Section -->
    <div id="products" class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fas fa-fire"></i> Sản phẩm nổi bật</h2>
            <a href="/products" class="btn btn-outline-primary">
                Xem tất cả <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        
        @if(!empty($products) && count($products) > 0)
            <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
                @foreach(array_slice($products, 0, 8) as $product)
                <div class="col">
                    <div class="card h-100 product-card border-0">
                        <div class="position-relative overflow-hidden">
                            @if(!empty($product['image']))
                                <img src="/uploads/products/{{ $product['image'] }}" 
                                     class="card-img-top" 
                                     alt="{{ $product['name'] }}"
                                     style="height: 250px; object-fit: cover;">
                            @else
                                <img src="https://via.placeholder.com/300x250/e5e7eb/6b7280?text={{ urlencode($product['name']) }}" 
                                     class="card-img-top" 
                                     alt="{{ $product['name'] }}"
                                     style="height: 250px; object-fit: cover;">
                            @endif
                            
                            @if($product['stock'] <= 0)
                                <span class="position-absolute top-0 end-0 m-2 badge bg-danger">
                                    Hết hàng
                                </span>
                            @endif
                        </div>
                        
                        <div class="card-body d-flex flex-column">
                            <span class="badge bg-light text-dark mb-2 align-self-start">
                                {{ $product['category_name'] ?? 'N/A' }}
                            </span>
                            <h5 class="card-title mb-2">{{ $product['name'] }}</h5>
                            
                            <div class="rating mb-2">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <span class="text-muted small">(4.5)</span>
                            </div>
                            
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h4 class="text-primary mb-0">
                                        {{ number_format($product['price'], 0, ',', '.') }}đ
                                    </h4>
                                    @if($product['stock'] > 0)
                                        <small class="text-success">
                                            <i class="fas fa-check-circle"></i> Còn {{ $product['stock'] }}
                                        </small>
                                    @endif
                                </div>
                                
                                <div class="d-grid">
                                    <a href="/detail/{{ $product['id'] }}" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-eye"></i> Xem chi tiết
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info text-center py-5">
                <i class="fas fa-inbox fa-4x mb-3 d-block text-muted"></i>
                <h4>Chưa có sản phẩm nào</h4>
                <p class="text-muted">Vui lòng quay lại sau</p>
            </div>
        @endif
    </div>

    <!-- Features Section -->
    <div class="row mb-5 bg-light p-5 rounded">
        <div class="col-md-4 text-center mb-4">
            <div class="mb-3">
                <i class="fas fa-shipping-fast fa-3x text-primary"></i>
            </div>
            <h5>Miễn phí vận chuyển</h5>
            <p class="text-muted">Cho đơn hàng trên 500.000đ</p>
        </div>
        <div class="col-md-4 text-center mb-4">
            <div class="mb-3">
                <i class="fas fa-shield-alt fa-3x text-primary"></i>
            </div>
            <h5>Thanh toán an toàn</h5>
            <p class="text-muted">100% bảo mật thông tin</p>
        </div>
        <div class="col-md-4 text-center mb-4">
            <div class="mb-3">
                <i class="fas fa-headset fa-3x text-primary"></i>
            </div>
            <h5>Hỗ trợ 24/7</h5>
            <p class="text-muted">Luôn sẵn sàng hỗ trợ bạn</p>
        </div>
    </div>
</div>

<style>
.category-card {
    transition: all 0.3s ease;
    cursor: pointer;
}

.category-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
}

.category-card:hover i {
    transform: scale(1.1);
    transition: transform 0.3s ease;
}
</style>
@endsection
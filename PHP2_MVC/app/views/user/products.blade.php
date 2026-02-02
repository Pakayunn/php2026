@extends('layouts.user')

@section('title', 'Sản phẩm - Shop Online')

@section('content')
<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
            <li class="breadcrumb-item active">Sản phẩm</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Sidebar Filter -->
        <div class="col-lg-3 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="mb-4"><i class="fas fa-filter"></i> Bộ lọc</h5>
                    
                    <!-- Categories -->
                    <div class="mb-4">
                        <h6 class="mb-3">Danh mục</h6>
                        <div class="list-group">
                            <a href="/products" class="list-group-item list-group-item-action <?php echo !isset($_GET['category']) ? 'active' : ''; ?>">
                                Tất cả sản phẩm
                            </a>
                            @foreach($categories as $category)
                            <a href="/products?category={{ $category['id'] }}" 
                               class="list-group-item list-group-item-action <?php echo (isset($_GET['category']) && $_GET['category'] == $category['id']) ? 'active' : ''; ?>">
                                {{ $category['name'] }}
                            </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Price Range -->
                    <div class="mb-4">
                        <h6 class="mb-3">Khoảng giá</h6>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="priceRange" id="price1">
                            <label class="form-check-label" for="price1">
                                Dưới 5 triệu
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="priceRange" id="price2">
                            <label class="form-check-label" for="price2">
                                5 - 10 triệu
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="priceRange" id="price3">
                            <label class="form-check-label" for="price3">
                                10 - 20 triệu
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="priceRange" id="price4">
                            <label class="form-check-label" for="price4">
                                Trên 20 triệu
                            </label>
                        </div>
                    </div>

                    <!-- Stock Status -->
                    <div class="mb-4">
                        <h6 class="mb-3">Tình trạng</h6>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="inStock">
                            <label class="form-check-label" for="inStock">
                                Còn hàng
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="outStock">
                            <label class="form-check-label" for="outStock">
                                Hết hàng
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="col-lg-9">
            <!-- Toolbar -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">
                    Tất cả sản phẩm 
                    <span class="badge bg-primary">{{ count($products) }}</span>
                </h4>
                <div class="d-flex gap-2">
                    <select class="form-select form-select-sm" style="width: auto;">
                        <option>Mặc định</option>
                        <option>Giá: Thấp đến cao</option>
                        <option>Giá: Cao đến thấp</option>
                        <option>Tên: A-Z</option>
                        <option>Tên: Z-A</option>
                    </select>
                </div>
            </div>

            @if(!empty($products) && count($products) > 0)
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                    @foreach($products as $product)
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
                                @else
                                    <span class="position-absolute top-0 start-0 m-2 badge bg-success">
                                        Mới
                                    </span>
                                @endif
                            </div>
                            
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <span class="badge bg-light text-dark">
                                        {{ $product['category_name'] ?? 'N/A' }}
                                    </span>
                                    <span class="badge bg-info">
                                        {{ $product['brand_name'] ?? 'N/A' }}
                                    </span>
                                </div>
                                
                                <h5 class="card-title mb-2">{{ $product['name'] }}</h5>
                                
                                <div class="rating mb-2">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <span class="text-muted small">(4.5)</span>
                                </div>
                                
                                <p class="card-text text-muted small mb-3">
                                    {{ substr($product['description'] ?? 'Sản phẩm chất lượng cao', 0, 80) }}...
                                </p>
                                
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
                                    
                                    <div class="d-grid gap-2">
                                        <a href="/detail/{{ $product['id'] }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-shopping-cart"></i> Mua ngay
                                        </a>
                                        <a href="/detail/{{ $product['id'] }}" class="btn btn-outline-secondary btn-sm">
                                            <i class="fas fa-eye"></i> Chi tiết
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <nav class="mt-5">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled">
                            <a class="page-link" href="#"><i class="fas fa-chevron-left"></i></a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
                        </li>
                    </ul>
                </nav>
            @else
                <div class="alert alert-info text-center py-5">
                    <i class="fas fa-inbox fa-4x mb-3 d-block text-muted"></i>
                    <h4>Không tìm thấy sản phẩm</h4>
                    <p class="text-muted">Vui lòng thử lọc theo danh mục khác</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
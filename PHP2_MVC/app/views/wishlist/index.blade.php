@extends('layouts.master')

@section('title','Sản phẩm yêu thích')

@section('content')
<div class="container py-4">

    <h4 class="mb-4">
        <i class="fas fa-heart text-danger me-2"></i>
        Sản phẩm yêu thích
    </h4>

    @if(empty($items))
        <div class="alert alert-info">
            Bạn chưa có sản phẩm yêu thích nào.
        </div>
    @else
        <div class="row">
            @foreach($items as $item)
                <div class="col-md-3 mb-4">
                    <div class="card h-100 shadow-sm">

                        {{-- ẢNH --}}
                        <a href="/product/detail/{{ $item['id'] }}">
                            @if (!empty($item['image']))
                                <img src="/uploads/products/{{ $item['image'] }}"
                                     class="card-img-top"
                                     style="height:220px; object-fit:cover;">
                            @else
                                <img src="https://via.placeholder.com/300x300"
                                     class="card-img-top"
                                     style="height:220px; object-fit:cover;">
                            @endif
                            
                        </a>

                        <div class="card-body d-flex flex-column">
                            <h6 class="mb-2">
                                <a href="/product/detail/{{ $item['id'] }}"
                                   class="text-decoration-none text-dark">
                                    {{ $item['name'] }}
                                </a>
                            </h6>

                            <p class="text-danger fw-bold mt-auto">
                                {{ number_format($item['price'],0,',','.') }} đ
                            </p>
                        </div>

                        <div class="card-footer bg-white border-0">
                            <a href="/wishlist/remove/{{ $item['id'] }}"
                               class="btn btn-sm btn-outline-danger w-100"
                               onclick="return confirm('Xóa sản phẩm này khỏi yêu thích?')">
                                <i class="fas fa-trash me-1"></i>
                                Xóa khỏi yêu thích
                            </a>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
@extends('layouts.master')

@section('title', 'Quản lý sản phẩm')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-6">
            <h2><i class="fas fa-box"></i> Quản lý sản phẩm</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="/product/create" class="btn btn-primary">
                <i class="fas fa-plus"></i> Thêm sản phẩm mới
            </a>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th width="5%">ID</th>
                            <th width="10%">Ảnh</th>
                            <th width="20%">Tên sản phẩm</th>
                            <th width="12%">Giá</th>
                            <th width="15%">Danh mục</th>
                            <th width="15%">Thương hiệu</th>
                            <th width="8%">Tồn kho</th>
                            <th width="15%">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($products) && count($products) > 0)
                            @foreach($products as $product)
                            <tr>
                                <td>{{ $product['id'] }}</td>
                                <td>
                                    @if(!empty($product['image']))
                                        <img src="/uploads/products/{{ $product['image'] }}" 
                                             alt="{{ $product['name'] }}" 
                                             class="img-thumbnail" 
                                             style="max-width: 60px; height: auto;">
                                    @else
                                        <img src="https://via.placeholder.com/60" 
                                             alt="No image" 
                                             class="img-thumbnail">
                                    @endif
                                </td>
                                <td>{{ $product['name'] }}</td>
                                <td>{{ number_format($product['price'], 0, ',', '.') }} đ</td>
                                <td>
                                    <span class="badge bg-info">
                                        {{ $product['category_name'] ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-success">
                                        {{ $product['brand_name'] ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $product['stock'] > 0 ? 'bg-primary' : 'bg-danger' }}">
                                        {{ $product['stock'] }}
                                    </span>
                                </td>
                                <td>
                                    <a href="/product/edit/{{ $product['id'] }}" 
                                       class="btn btn-sm btn-warning" 
                                       title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="deleteProduct({{ $product['id'] }})" 
                                            class="btn btn-sm btn-danger" 
                                            title="Xóa">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8" class="text-center">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                                    <p class="text-muted">Chưa có sản phẩm nào</p>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function deleteProduct(id) {
    Swal.fire({
        title: 'Bạn có chắc chắn?',
        text: "Sản phẩm sẽ bị xóa vĩnh viễn!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Xóa',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/product/delete/${id}`,
                type: 'POST',
                success: function(response) {
                    const data = JSON.parse(response);
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Thành công!',
                            text: data.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Lỗi!', data.message, 'error');
                    }
                },
                error: function() {
                    Swal.fire('Lỗi!', 'Có lỗi xảy ra khi xóa sản phẩm!', 'error');
                }
            });
        }
    });
}
</script>
@endsection
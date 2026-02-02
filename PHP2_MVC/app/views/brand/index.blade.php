@extends('layouts.master')

@section('title', 'Quản lý thương hiệu')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-6">
            <h2><i class="fas fa-tags"></i> Quản lý thương hiệu</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="/brand/create" class="btn btn-primary">
                <i class="fas fa-plus"></i> Thêm thương hiệu mới
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
                            <th width="15%">Logo</th>
                            <th width="25%">Tên thương hiệu</th>
                            <th width="35%">Mô tả</th>
                            <th width="20%">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($brands) && count($brands) > 0)
                            @foreach($brands as $brand)
                            <tr>
                                <td>{{ $brand['id'] }}</td>
                                <td>
                                    @if(!empty($brand['logo']))
                                        <img src="/uploads/brands/{{ $brand['logo'] }}" 
                                             alt="{{ $brand['name'] }}" 
                                             class="img-thumbnail" 
                                             style="max-width: 60px; height: auto;">
                                    @else
                                        <img src="https://via.placeholder.com/60" 
                                             alt="No logo" 
                                             class="img-thumbnail">
                                    @endif
                                </td>
                                <td>{{ $brand['name'] }}</td>
                                <td>{{ $brand['description'] ?? 'N/A' }}</td>
                                <td>
                                    <a href="/brand/edit/{{ $brand['id'] }}" 
                                       class="btn btn-sm btn-warning" 
                                       title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="deleteBrand({{ $brand['id'] }})" 
                                            class="btn btn-sm btn-danger" 
                                            title="Xóa">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                                    <p class="text-muted">Chưa có thương hiệu nào</p>
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
function deleteBrand(id) {
    Swal.fire({
        title: 'Bạn có chắc chắn?',
        text: "Thương hiệu sẽ bị xóa vĩnh viễn!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Xóa',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/brand/delete/${id}`,
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
                    Swal.fire('Lỗi!', 'Có lỗi xảy ra khi xóa thương hiệu!', 'error');
                }
            });
        }
    });
}
</script>
@endsection
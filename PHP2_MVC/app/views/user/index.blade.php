@extends('layouts.master')

@section('title', 'Quản lý người dùng')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-6">
            <h2><i class="fas fa-users"></i> Quản lý người dùng</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="/user/create" class="btn btn-primary">
                <i class="fas fa-plus"></i> Thêm người dùng mới
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
                            <th width="15%">Username</th>
                            <th width="20%">Email</th>
                            <th width="20%">Họ tên</th>
                            <th width="10%">Vai trò</th>
                            <th width="10%">Trạng thái</th>
                            <th width="20%">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($users) && count($users) > 0)
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user['id'] }}</td>
                                <td>{{ $user['username'] }}</td>
                                <td>{{ $user['email'] }}</td>
                                <td>{{ $user['full_name'] }}</td>
                                <td>
                                    <span class="badge {{ $user['role'] == 'admin' ? 'bg-danger' : 'bg-primary' }}">
                                        {{ $user['role'] == 'admin' ? 'Admin' : 'User' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $user['status'] == 'active' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $user['status'] == 'active' ? 'Hoạt động' : 'Khóa' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="/user/edit/{{ $user['id'] }}" 
                                       class="btn btn-sm btn-warning" 
                                       title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="deleteUser({{ $user['id'] }})" 
                                            class="btn btn-sm btn-danger" 
                                            title="Xóa">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-center">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                                    <p class="text-muted">Chưa có người dùng nào</p>
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
function deleteUser(id) {
    Swal.fire({
        title: 'Bạn có chắc chắn?',
        text: "Người dùng sẽ bị xóa vĩnh viễn!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Xóa',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/user/delete/${id}`,
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
                    Swal.fire('Lỗi!', 'Có lỗi xảy ra khi xóa người dùng!', 'error');
                }
            });
        }
    });
}
</script>
@endsection
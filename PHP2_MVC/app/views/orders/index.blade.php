@extends('layouts.master')

@section('title', 'Quản lý đơn hàng')

@section('content')
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-md-6">
                <h2><i class="fas fa-shopping-cart"></i> Quản lý đơn hàng</h2>
            </div>
            <div class="col-md-6 text-end">
                <span class="badge bg-primary fs-6">
                    Tổng: {{ !empty($orders) ? count($orders) : 0 }} đơn
                </span>
            </div>
        </div>

        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th width="5%">ID</th>
                                <th width="25%">Khách hàng</th>
                                <th width="20%">Tổng tiền</th>
                                <th width="20%">Trạng thái</th>
                                <th width="20%">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($orders) && count($orders) > 0)
                                @foreach($orders as $order)
                                    @php
                                        $status = $order['status'] ?? 'pending';
                                    @endphp
                                    <tr>
                                        <td>{{ $order['id'] }}</td>
                                        <td>{{ $order['shipping_name'] }}</td>
                                        <td>
                                            <strong class="text-danger">
                                                {{ number_format($order['final_amount']) }} đ
                                            </strong>
                                        </td>

                                        {{-- Dropdown trạng thái --}}
                                        <td>
                                            <select class="form-select form-select-sm"
                                                onchange="updateStatus({{ $order['id'] }}, this.value)">
                                                <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>
                                                    Chờ xử lý
                                                </option>
                                                <option value="processing" {{ $status == 'processing' ? 'selected' : '' }}>
                                                    Đang xử lý
                                                </option>
                                                <option value="completed" {{ $status == 'completed' ? 'selected' : '' }}>
                                                    Hoàn thành
                                                </option>
                                                <option value="cancelled" {{ $status == 'cancelled' ? 'selected' : '' }}>
                                                    Đã hủy
                                                </option>
                                            </select>
                                        </td>

                                        <td>
                                            <a href="/orders/show/{{ $order['id'] }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                                        <p class="text-muted">Chưa có đơn hàng nào</p>
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
        function updateStatus(id, status) {

            fetch(`/orders/updateStatus/${id}/${status}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json'
                }
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error("HTTP error");
                    }
                    return response.json();
                })
                .then(data => {

                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Cập nhật thành công',
                            timer: 1200,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire('Lỗi!', 'Không thể cập nhật trạng thái', 'error');
                    }

                })
                .catch(error => {
                    console.error(error);
                    Swal.fire('Lỗi!', 'Có lỗi xảy ra từ server!', 'error');
                });
        }
    </script>

@endsection
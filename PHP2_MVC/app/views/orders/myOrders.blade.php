@extends('layouts.master')

@section('content')
<div class="container mt-4">
    <h3>Lịch sử mua hàng</h3>

    @if(empty($orders))
        <p>Bạn chưa có đơn hàng nào.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Mã đơn</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Ngày đặt</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>#{{ $order['id'] }}</td>
                   <td>{{ number_format($order['final_amount']) }}đ</td>
                    <td>{{ $order['status'] }}</td>
                    <td>{{ $order['created_at'] }}</td>
                    <td>
                        <a href="/my-orders/{{ $order['id'] }}" 
                           class="btn btn-sm btn-primary">
                           Xem chi tiết
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
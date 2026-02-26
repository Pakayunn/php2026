@extends('layouts.master')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Chi tiết đơn #{{ $order['id'] }}</h3>
        <a href="/" class="btn btn-secondary">
            ← Quay lại trang chủ
        </a>
    </div>

    <p><strong>Trạng thái:</strong> {{ $order['status'] }}</p>
    <p><strong>Ngày đặt:</strong> {{ $order['created_at'] }}</p>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Sản phẩm</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Tổng</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr>
                <td>{{ $item['name'] }}</td>
                <td>{{ number_format($item['price'] ?? 0) }}đ</td>
                <td>{{ $item['quantity'] }}</td>
                <td>{{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 0)) }}đ</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h5 class="text-end">
        Tổng cộng: {{ number_format($order['final_amount'] ?? 0) }}đ
    </h5>

</div>
@endsection
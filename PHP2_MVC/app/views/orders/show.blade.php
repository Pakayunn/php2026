@extends('layouts.master')

@section('content')

<div style="max-width:900px;margin:40px auto;">

<h2>Chi tiết đơn hàng #{{ $order['id'] }}</h2>

<p><strong>Khách:</strong> {{ $order['shipping_name'] }}</p>
<p><strong>SĐT:</strong> {{ $order['shipping_phone'] }}</p>
<p><strong>Địa chỉ:</strong> {{ $order['shipping_address'] }}</p>
<p><strong>Trạng thái:</strong> {{ $order['status'] }}</p>

<hr>

<h3>Sản phẩm</h3>

@foreach($items as $item)
<div style="margin-bottom:10px;">
    {{ $item['product_name'] }} 
    (x{{ $item['quantity'] }}) 
    - {{ number_format($item['subtotal']) }} đ
</div>
@endforeach

<hr>

<form method="POST" action="/admin/orders/updateStatus/{{ $order['id'] }}">
    <select name="status">
        <option value="pending">pending</option>
        <option value="processing">processing</option>
        <option value="completed">completed</option>
        <option value="cancelled">cancelled</option>
    </select>
    <button type="submit">Cập nhật</button>
</form>

</div>

@endsection
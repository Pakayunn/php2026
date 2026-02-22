@extends('layouts.master')

@section('content')

<h2>Thanh toán</h2>

<table class="table">
@foreach($items as $item)
<tr>
    <td>{{ $item['name'] }}</td>
    <td>{{ $item['quantity'] }}</td>
    <td>{{ number_format($item['price'] * $item['quantity']) }} đ</td>
</tr>
@endforeach
</table>

<h4 class="text-end">
    Tổng: <span class="text-danger">{{ number_format($total) }} đ</span>
</h4>

<form action="/order/placeOrder" method="POST">
    <button class="btn btn-success">Xác nhận đặt hàng</button>
</form>

@endsection
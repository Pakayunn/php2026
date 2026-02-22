@extends('layouts.master')

@section('title', 'Đặt hàng thành công')

@section('content')

<div style="max-width:900px;margin:60px auto;padding:0 20px;">

    <div style="background:#fff;padding:40px;border:1px solid #e5e5e5;">

        <div style="text-align:center;margin-bottom:30px;">

            <div style="font-size:48px;color:#28a745;margin-bottom:15px;">
                ✓
            </div>

            <h2 style="margin-bottom:10px;font-weight:600;">
                Đặt hàng thành công
            </h2>

            <p style="color:#666;margin:0;">
                Cảm ơn bạn đã mua hàng. Đơn hàng của bạn đang được xử lý.
            </p>

        </div>

        <hr style="margin:30px 0;border-color:#eee;">

        <div style="display:flex;justify-content:space-between;flex-wrap:wrap;gap:15px;">

            <a href="/"
               style="padding:10px 20px;
                      background:#356de5;
                      color:#fff;
                      text-decoration:none;
                      font-weight:500;">
                Về trang chủ
            </a>

            <a href="/orders"
               style="padding:10px 20px;
                      border:1px solid #356de5;
                      color:#356de5;
                      text-decoration:none;
                      font-weight:500;">
                Xem đơn hàng của tôi
            </a>

        </div>

    </div>

</div>

@endsection
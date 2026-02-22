@extends('layouts.master')

@section('title', $title ?? 'Giỏ hàng')

@section('content')

<h2 class="mb-4">Giỏ hàng của bạn</h2>

@if(isset($_GET['error']) && $_GET['error'] === 'out_of_stock')
    <div class="alert alert-danger">
        Sản phẩm đã đạt giới hạn tồn kho.
    </div>
@endif

@if(!empty($items))

    <table class="table table-bordered align-middle">
        <thead class="table-light">
            <tr>
                <th>Tên</th>
                <th width="150">Giá</th>
                <th width="180">Số lượng</th>
                <th width="150">Thành tiền</th>
                <th width="120">Hành động</th>
            </tr>
        </thead>
        <tbody>

        @foreach($items as $item)

            @php
                $subtotal = $item['price'] * $item['quantity'];
            @endphp

            <tr>
                <td>{{ $item['name'] }}</td>

                <td class="text-danger">
                    {{ number_format($item['price']) }} đ
                </td>

                <td>
                    <div class="d-flex align-items-center gap-2">

                        {{-- Nút giảm --}}
                        <a href="/cart/decrease/{{ $item['product_id'] }}" 
                           class="btn btn-sm btn-outline-secondary {{ $item['quantity'] == 1 ? 'disabled' : '' }}"
                           {{ $item['quantity'] == 1 ? 'onclick=return false;' : '' }}>
                           -
                        </a>

                        <strong>{{ $item['quantity'] }}</strong>

                        {{-- Nút tăng --}}
                        <a href="/cart/increase/{{ $item['product_id'] }}" 
                           class="btn btn-sm btn-outline-secondary">
                           +
                        </a>

                    </div>
                </td>

                <td class="fw-semibold">
                    {{ number_format($subtotal) }} đ
                </td>

                <td>
                    <button 
                        type="button"
                        class="btn btn-sm btn-outline-danger btn-delete"
                        data-url="/cart/remove/{{ $item['id'] }}">
                        Xóa
                    </button>
                </td>
            </tr>

        @endforeach

        </tbody>
    </table>

    <div class="text-end">
        <h4>
            Tổng tiền:
            <span class="text-danger">
                {{ number_format($total ?? 0) }} đ
            </span>
        </h4>
    </div>

    <div class="mt-3 d-flex justify-content-between">

        <button 
            type="button"
            class="btn btn-outline-danger btn-clear"
            data-url="/cart/clear">
            Xóa toàn bộ giỏ
        </button>

        <a href="/checkout" class="btn btn-primary">
            Thanh toán
        </a>

    </div>

@else

    <div class="alert alert-info">
        Giỏ hàng đang trống.
    </div>

@endif

@endsection


@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {

    /* ================= XÓA 1 SẢN PHẨM ================= */
    document.querySelectorAll(".btn-delete").forEach(function(button) {

        button.addEventListener("click", function () {

            let url = this.getAttribute("data-url");

            Swal.fire({
                title: "Xác nhận xóa?",
                text: "Sản phẩm sẽ bị xóa khỏi giỏ hàng!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#dc3545",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Xóa",
                cancelButtonText: "Hủy"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });

        });

    });


    /* ================= XÓA TOÀN BỘ ================= */
    document.querySelectorAll(".btn-clear").forEach(function(button) {

        button.addEventListener("click", function () {

            let url = this.getAttribute("data-url");

            Swal.fire({
                title: "Xóa toàn bộ giỏ hàng?",
                text: "Tất cả sản phẩm sẽ bị xóa!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#dc3545",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Xóa hết",
                cancelButtonText: "Hủy"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });

        });

    });


    /* ================= NÂNG CẤP NÚT GIẢM ================= */
    document.querySelectorAll(".btn-decrease").forEach(function(button) {

        button.addEventListener("click", function(e) {

            let qty = parseInt(this.dataset.qty);

            if (qty === 1) {
                e.preventDefault();

                let url = this.getAttribute("href");

                Swal.fire({
                    title: "Số lượng sẽ về 0",
                    text: "Bạn có muốn xóa sản phẩm này khỏi giỏ hàng?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#dc3545",
                    cancelButtonColor: "#6c757d",
                    confirmButtonText: "Xóa",
                    cancelButtonText: "Hủy"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            }

        });

    });

});
</script>
@endsection
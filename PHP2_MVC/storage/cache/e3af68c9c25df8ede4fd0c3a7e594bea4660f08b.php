

<?php $__env->startSection('title', 'Thanh toán'); ?>

<?php $__env->startSection('content'); ?>


<div class="container" style="max-width:1200px;margin:auto;padding:20px;">

    <h2 style="margin-bottom:20px;">Thanh toán</h2>

    <div style="display:flex;gap:30px;align-items:flex-start;flex-wrap:wrap;">

        <div style="flex:2;min-width:350px;">

            <div style="background:#fff;border-radius:8px;padding:20px;box-shadow:0 2px 10px rgba(0,0,0,0.05);">
                <h3 style="margin-bottom:15px;">Sản phẩm của bạn</h3>

                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div style="display:flex;align-items:center;border-bottom:1px solid #eee;padding:15px 0;gap:15px;">

                    <img src="/uploads/<?php echo e($item['image']); ?>" width="70" style="border-radius:6px;">

                    <div style="flex:1;">
                        <strong><?php echo e($item['name']); ?></strong><br>
                        <small>Số lượng: <?php echo e($item['quantity']); ?></small>
                    </div>

                    <div style="text-align:right;">
                        <div><?php echo e(number_format($item['price'])); ?> đ</div>
                        <strong style="color:#cf243b;">
                            <?php echo e(number_format($item['price'] * $item['quantity'])); ?> đ
                        </strong>
                    </div>

                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <div style="text-align:right;margin-top:15px;font-size:18px;">
                    <strong>Tổng cộng: 
                        <span style="color:#e53935;">
                            <?php echo e(number_format($total)); ?> đ
                        </span>
                    </strong>
                </div>
            </div>

        </div>

        
        <div style="flex:1;min-width:300px;">

            <form method="POST" action="/cart/placeOrder"
                  style="background:#fff;border-radius:8px;padding:20px;box-shadow:0 2px 10px rgba(0,0,0,0.05);">

                <h3 style="margin-bottom:15px;">Thông tin giao hàng</h3>

                <div style="margin-bottom:15px;">
                    <label>Họ tên</label>
                    <input type="text" name="shipping_name" required
                        style="width:100%;padding:8px;border:1px solid #ccc;border-radius:5px;">
                </div>

                <div style="margin-bottom:15px;">
                    <label>Số điện thoại</label>
                    <input type="text" name="shipping_phone" required
                        style="width:100%;padding:8px;border:1px solid #ccc;border-radius:5px;">
                </div>

                <div style="margin-bottom:15px;">
                    <label>Địa chỉ</label>
                    <input type="text" name="shipping_address" required
                        style="width:100%;padding:8px;border:1px solid #ccc;border-radius:5px;">
                </div>

                <div style="margin-bottom:15px;">
                    <label>Phương thức thanh toán</label>
                    <select name="payment_method"
                        style="width:100%;padding:8px;border:1px solid #ccc;border-radius:5px;">
                        <option value="cod">Thanh toán khi nhận hàng (COD)</option>
                    </select>
                </div>

                <div style="margin-bottom:15px;">
                    <label>Ghi chú</label>
                    <textarea name="notes"
                        style="width:100%;padding:8px;border:1px solid #ccc;border-radius:5px;"></textarea>
                </div>

                <button type="submit"
                        style="width:100%;padding:12px;background:#356de5;color:#fff;border:none;border-radius:6px;font-weight:bold;font-size:16px;cursor:pointer;">
                    Đặt hàng
                </button>

            </form>

        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Xamppp2\htdocs\hi\php2026\PHP2_MVC\app\views/checkout/index.blade.php ENDPATH**/ ?>
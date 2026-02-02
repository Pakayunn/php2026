@extends('layouts.master')

@section('title', 'Sửa danh mục')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12">
            <h2><i class="fas fa-edit"></i> Sửa danh mục</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/category">Danh mục</a></li>
                    <li class="breadcrumb-item active">Sửa</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <form action="/category/update/{{ $category['id'] }}" method="POST" id="categoryForm">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="name" class="form-label">Tên danh mục <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control <?php echo isset($_SESSION['errors']['name']) ? 'is-invalid' : ''; ?>" 
                               id="name" 
                               name="name" 
                               value="<?php echo $_SESSION['old']['name'] ?? $category['name']; ?>"
                               required
                               minlength="3">
                        <?php if(isset($_SESSION['errors']['name'])): ?>
                            <div class="invalid-feedback"><?php echo $_SESSION['errors']['name']; ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="col-12 mb-3">
                        <label for="description" class="form-label">Mô tả danh mục</label>
                        <textarea class="form-control" 
                                  id="description" 
                                  name="description" 
                                  rows="4"><?php echo $_SESSION['old']['description'] ?? $category['description']; ?></textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="/category" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Cập nhật
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php unset($_SESSION['old'], $_SESSION['errors']); ?>

<script>
document.getElementById('categoryForm').addEventListener('submit', function(e) {
    const name = document.getElementById('name').value.trim();
    
    if (!name || name.length < 3) {
        e.preventDefault();
        Swal.fire('Lỗi!', 'Tên danh mục phải có ít nhất 3 ký tự', 'error');
        return false;
    }
});
</script>
@endsection
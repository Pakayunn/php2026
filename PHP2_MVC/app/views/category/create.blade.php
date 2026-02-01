@extends('layouts.master')

@section('title', 'Thêm danh mục')

@section('content')
<div class="container">
    <h1>Thêm danh mục mới</h1>
    
    <form action="/category/store" method="POST">
        <div class="form-group">
            <label>Tên danh mục</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label>Mô tả</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Lưu</button>
        <a href="/category" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection
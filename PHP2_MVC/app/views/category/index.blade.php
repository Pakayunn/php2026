@extends('layouts.master')

@section('title', 'Quản lý danh mục')

@section('content')
<div class="container">
    <h1>Danh sách danh mục</h1>
    <a href="/category/create" class="btn btn-primary">Thêm mới</a>
    
    @if(!empty($categories))
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên danh mục</th>
                    <th>Mô tả</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                <tr>
                    <td>{{ $category['id'] }}</td>
                    <td>{{ $category['name'] }}</td>
                    <td>{{ $category['description'] ?? '' }}</td>
                    <td>
                        <a href="/category/edit/{{ $category['id'] }}" class="btn btn-sm btn-warning">Sửa</a>
                        <a href="/category/delete/{{ $category['id'] }}" class="btn btn-sm btn-danger" 
                           onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Chưa có danh mục nào</p>
    @endif
</div>
@endsection
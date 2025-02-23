@extends('admin.layouts.admin')

@section('title')
    <title>Quản lý</title>
@endsection

@section('content')
    <div class="container">
        <h2 class="text-center">Các câu trích dẫn</h2>
        <div class="d-flex justify-content-end">
          <a href="search.php" class="btn btn-primary text-white mb-3 ms-3">Tìm trích dẫn</a>
          <a href="add_quote.php" class="btn btn-success text-white mb-3 ms-3">Thêm trích dẫn</a>
        </div>
        <table class="table table-bordered table-striped">
            <thead>
                <th>STT</th>
                <th>Danh mục</th>
                <th>Ngày tạo</th>
                <th>Sửa</th>
                <th>Xóa</th>
            </thead>

            <tbody>
                <tr>
                    <td>1</td>
                    <td>Giày Vanz</td>
                    <td>16-10-2004</td>
                    <td><a href="" class="btn btn-warning btn-sm"><i class="fa-solid fa-pen-to-square"></i></a></td>
                    <td><a href="" class="btn btn-danger btn-sm">
                            <i class='bx bxs-trash-alt'></i></a></td>
                </tr>
            </tbody>
        </table>

    </div>
@endsection

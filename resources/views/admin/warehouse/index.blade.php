@extends('admin.layouts.admin')

@section('title')
    <title>Kho</title>
@endsection

{{-- @section('namePage', 'Danh sách sản phẩm') --}}

@section('content')
    <div class="container" style="width: 90%">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('danger'))
            <div class="alert alert-danger">
                {{ session('danger') }}
            </div>
        @endif

        <h2 class="text-center fw-bolder ">Danh sách kho</h2>
        <div class="d-flex align-items-center mb-1 row">
            <div class="col-3">
                <form action="{{ route('admin.warehouse.index') }}" class="" method="GET">
                    <div class="form-group d-flex">
                        <input placeholder="Tìm kho" id="search" name="search" class="form-control"></input>
                        <button type="submit" class="btn btn-primary text-white text-decoration-none m-1">Tìm</button>
                    </div>
                </form>
            </div>
            <div class="text-end col-9">
                <a href="{{ route('admin.warehouse.create') }}" class="btn btn-success text-white text-end ms-3">Thêm kho</a>
            </div>
        </div>

        @isset($search)
            <h5 class='text-start mt-4 mb-4'>Kết quả tìm kiếm: <b>{{ $search }}</b></h5>
        @endisset


        <table class="table table-bordered table-striped">
            <thead>
                <th>STT</th>
                <th>Địa chỉ</th>
                <th>Dung tích</th>
                <th>Xem chi tiết</th>
                <th>Sửa</th>
                <th>Xóa</th>
            </thead>

            <tbody>
                @foreach ($data as $warehouse)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td> {{ $warehouse['address'] }} </td>
                        <td> {{ $warehouse['capacity'] }} </td>
                        <td><a href="{{ route('admin.warehouse.show', $warehouse) }}" class="btn btn-warning btn-sm"><i
                                    class='bx bxs-detail'></i></a></td>
                        <td><a href="{{ route('admin.warehouse.edit', $warehouse) }}" class="btn btn-warning btn-sm"><i
                                    class='bx bxs-edit'></i></a></td>
                        <td>
                            <form action="{{ route('admin.warehouse.destroy', $warehouse) }}" method="POST">
                                @csrf
                                @method ("DELETE")
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Bạn chắc chắn muốn xóa kho {{ $warehouse['address'] }}?')">
                                    <i class='bx bxs-trash-alt'></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>
            {{ $data->withQueryString()->links() }}
        </div>
    </div>
@endsection

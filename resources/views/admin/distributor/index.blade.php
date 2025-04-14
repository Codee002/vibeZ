@extends('admin.layouts.admin')

@section('title')
    <title>
        Nhà cung cấp</title>
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

        <h2 class="text-center fw-bolder ">Danh sách nhà cung cấp</h2>
        <div class="d-flex align-items-center mb-1 row">
            <div class="col-5">
                <form action="{{ route('admin.distributor.index') }}" class="" method="GET">
                    <div class="form-group d-flex">
                        <input placeholder="Tên" id="search" name="name" class="form-control me-1"></input>
                        <input placeholder="Địa chỉ" name="phone" class="form-control me-1"></input>
                        <button type="submit" class="btn btn-primary text-white text-decoration-none m-1">Tìm</button>
                    </div>
                </form>
            </div>
            <div class="text-end col-7">
                <a href="{{ route('admin.distributor.create') }}" class="btn btn-success text-white text-end ms-3">Thêm NCC</a>
            </div>
        </div>

        @isset($search)
            <h5 class='text-start mt-4 mb-4'>Kết quả tìm kiếm: <b>{{ $search }}</b></h5>
        @endisset


        <table class="table table-bordered table-striped">
            <thead>
                <th>Mã NCC</th>
                <th>Tên</th>
                <th>Địa chỉ</th>
                <th>Email</th>
                <th>Thao tác</th>
            </thead>

            <tbody>
                @foreach ($data as $distributor)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td> {{ $distributor['name'] }} </td>
                        <td> {{ $distributor['address'] }} </td>
                        <td> {{ $distributor['email'] }} </td>
 
                        <td><a href="{{ route('admin.distributor.show', $distributor) }}"
                                class="btn btn-secondary btn-sm"><i class='bx bxs-detail'></i></a>
                            <a href="{{ route('admin.distributor.edit', $distributor) }}"
                                class="btn btn-warning btn-sm"><i class='bx bxs-edit'></i></a>
                            <form action="{{ route('admin.distributor.destroy', $distributor) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method ("DELETE")
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Bạn chắc chắn muốn xóa phương thức {{ $distributor['name'] }}?')">
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

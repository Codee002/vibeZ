@extends('admin.layouts.admin')

@section('title')
    <title>
        Tài khoản người dùng</title>
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

        <h2 class="text-center fw-bolder ">Danh sách tài khoản</h2>
        <div class="d-flex align-items-center mb-1 row">
            <div class="col-3">
                <form action="{{ route('admin.account.index') }}" class="" method="GET">
                    <div class="form-group d-flex">
                        <input placeholder="Tìm danh mục" id="search" name="search" class="form-control"></input>
                        <button type="submit" class="btn btn-primary text-white text-decoration-none m-1">Tìm</button>
                    </div>
                </form>
            </div>
            <div class="text-end col-9">
                <a href="{{ route('admin.account.export') }}" class="btn btn-success text-white text-end ms-3">Xuất Excel</a>
            </div>
        </div>

        @isset($search)
            <h5 class='text-start mt-4 mb-4'>Kết quả tìm kiếm: <b>{{ $search }}</b></h5>
        @endisset


        <table class="table table-bordered table-striped">
            <thead>
                <th>Mã</th>
                <th>Tên</th>
                <th>Số điện thoại</th>
                <th>Email</th>
                <th>Tổng đơn hàng</th>
                <th>Thanh toán</th>
                <th>Thao tác</th>
            </thead>

            <tbody>
                @foreach ($data as $user)
                {{-- {{dd($user)}} --}}
                    <tr>
                        <td>KH{{ $user['id'] }}</td>
                        <td> {{$user['name'] }} </td>
                        <td> {{$user['phone'] }} </td>
                        <td> {{$user['email'] }} </td>
                        <td> {{$user['count_all_order'] }} </td>
                        <td> {{$user['order_price'] }} </td>
                        <td><a href="{{ route('admin.account.show', $user['id']) }}"
                                class="btn btn-secondary btn-sm"><i class='bx bxs-detail'></i></a>
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

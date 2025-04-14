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
            <div class="col-9">
                <form action="{{ route('admin.account.index') }}" class="" method="GET">
                    <div class="form-group d-flex">
                        <input placeholder="Tên" id="search" name="search" class="form-control me-1"></input>
                        <input placeholder="Số điện thoại" name="phone" class="form-control me-1"></input>
                        {{-- {{dd($ranks)}} --}}
                        <select name="rank" class="form-select me-1">
                            <option value="" disabled selected>Cấp</option>
                            @foreach ($ranks as $rank)
                                <option value="{{ $rank['id'] }}">{{ $rank['type'] }}</option>
                            @endforeach
                        </select>
                        <select name="order_price" class="form-select me-1">
                            <option value="" disabled selected>Sắp theo đơn giá</option>
                            <option value="asc">Tăng dần</option>
                            <option value="desc">Giảm dần</option>
                        </select>
                        <button type="submit" class="btn btn-primary text-white text-decoration-none m-1">Tìm</button>
                    </div>
                </form>
            </div>
            <div class="text-end col-3">
                <a href="{{ route('admin.account.export') }}" class="btn btn-success text-white text-end ms-3">Xuất
                    Excel</a>
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
                <th>Cấp tài khoản</th>
                <th>Thao tác</th>
            </thead>

            <tbody>
                @foreach ($data as $user)
                    {{-- {{dd($user)}} --}}
                    <tr>
                        <td>KH{{ $user['id'] }}</td>
                        <td> {{ $user['name'] }} </td>
                        <td> {{ $user['phone'] ?? 'Chưa có SĐT' }} </td>
                        <td> {{ $user['email'] ?? 'Chưa có Email' }}</td>
                        <td> {{ $user['count_all_order'] }} </td>
                        <td> {{ number_format($user['order_price'], 0, '', '.') }} </td>
                        <td> {{ $user['rank'] }} </td>
                        <td><a href="{{ route('admin.account.show', $user['id']) }}" class="btn btn-secondary btn-sm"><i
                                    class='bx bxs-detail'></i></a>
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

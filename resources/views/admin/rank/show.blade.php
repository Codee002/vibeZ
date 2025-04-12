@extends('admin.layouts.admin')

@section('title')
    <title>Cấp tài khoản</title>
@endsection

@section('content')
    <div class="container">
        <h2 class="text-center fw-bolder text-">Thông tin cấp</h2>
        <div class="row" style="margin: auto">
            <div class="col-8 d-flex align-items-center row">
                <p class="title col-4">Cấp: </p>
                <p class="d-flex align-items-center col-5">{{ $rank['type'] }}</p>
            </div>

            <div class="col-8 d-flex align-items-center row">
                <p class="title col-4">Số điểm: </p>
                <p class="d-flex align-items-center col-5">{{ number_format($rank['point'], 0, '', '.') }}</p>
            </div>

            <div class="col-8 d-flex align-items-center row">
                <p class="title col-4">Khuyến mãi: </p>
                <p class="d-flex align-items-center col-5">{{ $rank['discount'] }}%</p>
            </div>

            <div class="col-8 d-flex align-items-center row">
                <p class="title col-4">Tổng tài khoản: </p>
                <p class="d-flex align-items-center col-5">{{ count($users) }}
            </div>

        </div>

        {{-- Phiếu nhập --}}
        {{-- {{dd($users)}} --}}
        @if ($users)
            <div class="d-flex align-items-center mb-1 row">
                <div class="col-3">
                    <form action="{{ route('admin.account.index') }}" class="" method="GET">
                        <div class="form-group d-flex">
                            <input placeholder="Tìm phiếu nhập" id="search" name="search" class="form-control"></input>
                            <button type="submit" class="btn btn-primary text-white text-decoration-none m-1">Tìm</button>
                        </div>
                    </form>
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
                    @foreach ($users as $user)
                        {{-- {{dd($user)}} --}}
                        <tr>
                            <td>KH{{ $user['id'] }}</td>
                            <td> {{ $user['name'] }} </td>
                            <td> {{ $user['phone'] }} </td>
                            <td> {{ $user['email'] }} </td>
                            <td> {{ $user['count_all_order'] }} </td>
                            <td> {{ number_format($user['order_price'], 0, '', '.') }} </td>
                            <td> {{ $user['rank'] }} </td>
                            <td><a href="{{ route('admin.account.show', $user['id']) }}"
                                    class="btn btn-secondary btn-sm"><i class='bx bxs-detail'></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

    </div>

    <style>
        .title {
            font-size: 1rem;
            font-weight: 700;
            margin-right: 1rem;
            display: flex;
            justify-content: start;
            align-items: center;
        }
    </style>
@endsection

@extends('admin.layouts.admin')

@section('title')
    <title>
        Đơn hàng</title>
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

        <h2 class="text-center fw-bolder ">Danh sách đơn hàng</h2>
        <div class="d-flex align-items-center mb-1 row">
            <div class="col-3">
                <form action="{{ route('admin.discount.index') }}" class="" method="GET">
                    <div class="form-group d-flex">
                        <input placeholder="Tìm đơn hàng" id="search" name="search" class="form-control"></input>
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
                <th>Mã HD</th>
                <th>Khách hàng</th>
                <th>Tổng SL</th>
                <th>Tổng đơn giá</th>
                <th>Thời gian</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </thead>

            <tbody>
                @foreach ($data as $order)
                    <tr>
                        <td>{{ 'HD' . $order['id'] }}</td>
                        <td> {{ $order->user['name'] }} </td>
                        <td> {{ $order->getTotalQuantity() }} </td>
                        <td> {{ $order['total_price'] }} </td>
                        <td> {{ \Carbon\Carbon::parse($order['created_at'])->format('d/m/Y H:i:s') }} </td>
                        <td>
                            @if ($order['status'] == 'pending')
                                <button type="button" class="btn btn-warning">Đang duyệt</button>
                            @elseif ($order['status'] == 'rejecting')
                                <button type="button" class="btn btn-danger">Từ chối</button>
                            @elseif ($order['status'] == 'aborting')
                                <button type="button" class="btn btn-danger">Đã hủy</button>
                            @elseif ($order['status'] == 'shipping')
                                <button type="button" class="btn btn-secondary">Đang giao</button>
                            @elseif ($order['status'] == 'completing')
                                <button type="button" class="btn btn-success">Hoàn thành</button>
                            @endif
                        </td>
                        <td><a href="{{ route('admin.order.show', $order) }}" class="btn btn-secondary btn-sm"><i
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

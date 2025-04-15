@extends('admin.layouts.admin')

@section('title')
    <title>Tài khoản</title>
@endsection

@section('content')
    <div class="container">
        <h2 class="text-center fw-bolder text-">Thông tin khách hàng</h2>
        <div class="row" style="margin: auto">
            <div class="col-12 d-flex align-items-center row">
                <p class="title col-2">Tên: </p>
                <p class="d-flex align-items-center col-5">{{ $user['name'] }}</p>
            </div>

            <div class="col-12 d-flex align-items-center row">
                <p class="title col-2">Số điện thoại: </p>
                <p class="d-flex align-items-center col-5">{{ $user['phone'] ?? 'Chưa có SĐT' }}</p>
            </div>

            <div class="col-12 d-flex align-items-center row">
                <p class="title col-2">Email: </p>
                <p class="d-flex align-items-center col-5">{{ $user['email'] ?? 'Chưa có Email' }}</p>
            </div>

            <div class="col-12 d-flex align-items-center row">
                <p class="title col-2">Tổng đơn hàng: </p>
                <p class="d-flex align-items-center col-7">{{ $user['count_all_order'] }}
                    @if ($user['count_all_order'] != 0)
                        <i class="ms-1">
                            ({{ $user['count_order_completed'] }} hoàn thành,
                            {{ $user['count_order_shipping'] }} đang vận chuyển,
                            {{ $user['count_order_pending'] }} chờ duyệt,
                            {{ $user['count_order_aborting'] }} đã hủy,
                            {{ $user['count_order_rejecting'] }} bị từ chối)
                        </i>
                    @endif
                </p>
            </div>

            <div class="col-12 d-flex align-items-center row">
                <p class="title col-2">Thanh toán: </p>
                <p class="d-flex align-items-center col-5">{{ number_format($user['order_price'], 0, '', '.') }}</p>
            </div>

            <div class="col-12 d-flex align-items-center row">
                <p class="title col-2">Cấp tài khoản: </p>
                <p class="d-flex align-items-center col-5">{{ $user['rank'] }}</p>
            </div>
        </div>

        {{-- Đơn hàng --}}
        @if ($orders->isNotEmpty())
            <table class="table table-bordered table-striped">
                <thead>
                    <th>Mã HD</th>
                    <th>Tổng SL</th>
                    <th>Tổng đơn giá</th>
                    <th>Thời gian</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </thead>

                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ 'HD' . $order['id'] }}</td>
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
                {{ $orders->withQueryString()->links() }}
            </div>
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

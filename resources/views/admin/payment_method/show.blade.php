@extends('admin.layouts.admin')

@section('title')
    <title>Chi tiết phương thức</title>
@endsection

@section('content')
    <div class="container">
        <h2 class="text-center fw-bolder text-">Chi tiết phương thức</h2>
        <div class="row" style="margin: auto">
            <div class="col-8 d-flex align-items-center row">
                <p class="title col-4">Tên phương thức: </p>
                <p class="d-flex align-items-center col-5">{{ $payment_method['name'] }}</p>
            </div>

            <div class="col-8 d-flex align-items-center row">
                <p class="title col-4">Trạng thái: </p>
                @if ($payment_method['status'] == 'on')
                    <p class="col-5">Đang bật</p>
                @else
                    <p class="col-5">Đang tắt</p>
                @endif
            </div>

            <div class="col-8 d-flex align-items-center row">
                <p class="title col-4">Ngày tạo: </p>
                <p class="col-5">{{ \Carbon\Carbon::parse($payment_method['created_at'])->format('d/m/Y') }}</p>
            </div>

            <div class="col-8 d-flex align-items-center row">
                <p class="title col-4">Tổng sản phẩm thuộc phương thức: </p>
                <p class="col-5">{{ count($orders) }}</p>
            </div>
            <div>

            </div>
        </div>

        @if ($orders->isNotEmpty())
            <table class="table table-bordered table-striped mt-3">
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
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ 'HD' . $order['id'] }}</td>
                            <td> {{ $order->user['name'] }} </td>
                            <td> {{ number_format($order->getTotalQuantity(), 0, '', '.') }} </td>
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

@extends('admin.layouts.admin')

@section('title')
    <title>Chi tiết khuyến mãi</title>
@endsection

@section('content')
    <div class="container">
        <h2 class="text-center fw-bolder text-">Chi tiết khuyến mãi</h2>
        <div class="row" style="margin: auto">
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
            <div class="col-8 d-flex align-items-center row">
                <p class="title col-4">Danh mục khuyến mãi: </p>
                <p class="d-flex align-items-center col-5">{{ $discount->category['name'] }}</p>
            </div>

            <div class="col-8 d-flex align-items-center row">
                <p class="title col-4">Trị giá: </p>
                <p class="d-flex align-items-center col-5">{{ $discount['percent'] }}%</p>
            </div>

            <div class="col-8 d-flex align-items-center row">
                <p class="title col-4">Mô tả khuyến mãi: </p>
                <p class="d-flex align-items-center col-7">{{ $discount['des'] }}</p>
            </div>

            <div class="col-8 d-flex align-items-center row">
                <p class="title col-4">Ngày bắt đầu: </p>
                <p class="col-5">{{ \Carbon\Carbon::parse($discount['start_at'])->format('d/m/Y') }}</p>
            </div>

            <div class="col-8 d-flex align-items-center row">
                <p class="title col-4">Ngày kết thúc: </p>
                <p class="col-5">{{ \Carbon\Carbon::parse($discount['end_at'])->format('d/m/Y') }}</p>
            </div>

            <div class="col-8 d-flex align-items-center row">
                <p class="title col-4">Số ngày khuyến mãi: </p>
                <p class="col-5">{{ $discount->getTotalDay() }}</p>
            </div>

            <div class="col-8 d-flex align-items-center row">
                <p class="title col-4">Số đơn hàng: </p>
                <p class="col-5">{{ count($discount->orders) }}</p>
            </div>

            <div class="col-8 d-flex align-items-center row">
                <p class="title col-4">Tổng tiền đã khuyến mãi: </p>
                <p class="col-5">{{ number_format($discount->getTotalPrice(), 0, "", ".") }}</p>
            </div>

            <div class="col-8 d-flex align-items-center row">
                <p class="title col-4">Trạng thái: </p>
                @if ($discount['status'] == 'disabled')
                    <form action="{{ route('admin.discount.activedDiscount', $discount) }}" method="POST"
                        class="d-flex align-items-center col-5"
                        onsubmit="return confirm('Đồng ý chuyển sang trạng thái kích hoạt?\n' 
                                    + 'Trạng thái này sẽ cho phép người dùng có thể áp dụng khuyến mãi')">
                        @csrf
                        <button type="submit" class="btn btn-danger">Chưa kích hoạt</button>
                    </form>
                @else
                    <form action="{{ route('admin.discount.disabledDiscount', $discount) }}" method="POST"
                        class="d-flex align-items-center col-5"
                        onsubmit="return confirm('Xác nhận không kích hoạt trạng thái ?')">
                        @csrf
                        <button type="submit" class="btn btn-success">Đã kích hoạt</button>
                    </form>
                @endif
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
                            <td> {{ number_format($order['total_price'], 0, '', '.') }} </td>
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

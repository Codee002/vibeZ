@extends('pages.layouts.layout')

@section('title')
    <title>Lịch sử đặt hàng</title>
@endsection

@section('css')
    <link rel="stylesheet" href="/css/cart.css">
@endsection

@section('content')
    <main>
        <p class="title">Các đơn hàng đã đặt</p>

        {{-- FLASH MESSAGE --}}
        @if ($errors->any())
            <div class="alert alert-danger mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

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

        {{-- {{dd($user)}} --}}
        <p class="mb-1">Số tiền đã thanh toán: <b>{{ number_format($user['order_price'], 0, "", ".") }}</b></p>
        @if ($user['rank'] != "Chưa có cấp")
            <p class="mb-3">Tài khoản <b>{{ $user['rank'] }}</b>: Khi mua hàng được giảm <b>{{ $user['discount'] }}%</b> trên tổng đơn hàng</p>
        @endif

        @if ($data->isEmpty())
            <h4 class="text-center mt-4 fw-light">Bạn chưa có đơn hàng nào</h4>
        @else
            <table class="table table-bordered table-striped">
                <thead>
                    <th>Mã HD</th>
                    <th>Tổng SL</th>
                    <th>Tổng đơn giá</th>
                    <th>Thời gian đặt</th>
                    <th>Thanh toán</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </thead>

                <tbody>
                    @foreach ($data as $order)
                        <tr>
                            <td>{{ 'HD' . $order['id'] }}</td>
                            <td> {{ $order->getTotalQuantity() }} </td>
                            <td> {{ number_format($order['total_price'], 0, "", ".") }} </td>
                            <td> {{ \Carbon\Carbon::parse($order['created_at'])->format('d/m/Y H:i:s') }} </td>
                            <td> {{ $order->payment_method['name'] }} </td>
                            <td>
                                @if ($order['status'] == 'pending')
                                    <button type="button" class="btn btn-warning">Chờ duyệt</button>
                                @elseif ($order['status'] == 'rejecting')
                                    <button type="button" class="btn btn-danger">Bị từ chối</button>
                                @elseif ($order['status'] == 'aborting')
                                    <button type="button" class="btn btn-danger">Đã hủy</button>
                                @elseif ($order['status'] == 'shipping')
                                    <button type="button" class="btn btn-secondary">Đang giao</button>
                                @elseif ($order['status'] == 'completing')
                                    <button type="button" class="btn btn-success">Hoàn thành</button>
                                @endif
                            </td>
                            <td><a href="{{ route('order.history.detail', $order) }}" class="btn btn-secondary btn-sm"><i
                                        class='bx bxs-detail'></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div>
                {{ $data->withQueryString()->links() }}
            </div>
        @endif
    </main>
@endsection

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
            <div class="col-8">
                <form action="{{ route('admin.order.index') }}" class="" method="GET">
                    <div class="form-group d-flex">
                        <input placeholder="Mã HD" id="search" name="id" class="form-control me-1"></input>
                        <input placeholder="Tên KH" id="search" name="name" class="form-control me-1"></input>

                        {{-- {{dd($ranks)}} --}}
                        <select name="status" class="form-select me-1">
                            <option value="" disabled selected>Trạng thái</option>
                            <option value="pending">Đang duyệt</option>
                            <option value="shipping">Đang giao</option>
                            <option value="completing">Hoàn thành</option>
                            <option value="aborting">Đã hủy</option>
                            <option value="rejecting">Từ chôi</option>
                        </select>

                        <select name="created_at" class="form-select me-1">
                            <option value="" disabled selected>Thời gian</option>
                            <option value="asc">Cũ nhất</option>
                            <option value="desc">Mới nhất</option>
                        </select>
                        <button type="submit" class="btn btn-primary text-white text-decoration-none m-1">Tìm</button>
                    </div>
                </form>
            </div>
        </div>

        @if (!empty($id))
            <h5 class='text-start mt-4 mb-4'>Mã DH: <b>{{ $id }}</b></h5>
        @endif

        @if (!empty($name))
        <h5 class='text-start mt-4 mb-4'>Tên KH: <b>{{ $name }}</b></h5>
    @endif

        @if (!empty($status))
            <h5 class='text-start mt-4 mb-4'>Trạng thái: <b>
                    @if ($status == 'pending')
                        Đang duyệt
                    @elseif($status == 'shipping')
                        Đang giao
                    @elseif($status == 'completing')
                        Hoàn thành
                    @elseif($status == 'aborting')
                        Đã hủy
                    @elseif($status == 'rejecting')
                        Từ chôi
                    @endif
                </b></h5>
        @endif

        @if (!empty($order_by))
            <h5 class='text-start mt-4 mb-4'>Thời gian: <b>{{ $order_by == 'asc' ? 'Cũ nhất' : 'Mới nhất' }}</b></h5>
        @endif


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
            {{ $data->withQueryString()->links() }}
        </div>
    </div>
@endsection

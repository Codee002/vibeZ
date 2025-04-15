@extends('admin.layouts.admin')

@section('title')
    <title>
        Phương thức thanh toán</title>
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

        <h2 class="text-center fw-bolder ">Danh sách phương thức thanh toán</h2>
        <div class="d-flex align-items-center mb-1 row">
            <div class="col-5">
                <form action="{{ route('admin.payment_method.index') }}" class="" method="GET">
                    <div class="form-group d-flex">
                        <input placeholder="Tên PT" id="search" name="name" class="form-control me-1"></input>
                        <select name="status" class="form-select me-1">
                            <option value="" disabled selected>Trạng thái</option>
                            <option value="on">Đang bật</option>
                            <option value="off">Đang tắt</option>
                        </select>
                        <button type="submit" class="btn btn-primary text-white text-decoration-none m-1">Tìm</button>
                    </div>
                </form>
            </div>
            <div class="text-end col-7">
                <a href="{{ route('admin.payment_method.create') }}" class="btn btn-success text-white text-end ms-3">Thêm
                    phương thức</a>
            </div>
        </div>

        @if (!empty($name))
            <h5 class='text-start mt-4 mb-4'>Tên PT: <b>{{ $name }}</b></h5>
        @endif

        @if (!empty($status))
            <h5 class='text-start mt-4 mb-4'>Trạng thái:
                <b>{{ $status == 'on' ? 'Đang bật' : 'Đang tắt' }}</b></h5>
        @endif


        <table class="table table-bordered table-striped">
            <thead>
                <th>STT</th>
                <th>Phương thức</th>
                <th>Trạng thái</th>
                <th>Số đơn hàng</th>
                <th>Thao tác</th>
            </thead>

            <tbody>
                @foreach ($data as $payment_method)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td> {{ $payment_method['name'] }} </td>
                        <td>
                            @if ($payment_method['status'] == 'on')
                                <button class="btn btn-success">Đang bật</button>
                            @else
                                <button class="btn btn-secondary">Đang tắt</button>
                            @endif
                        </td>
                        <td>{{   $payment_method['count_order']  }}</td>
                        <td><a href="{{ route('admin.payment_method.show', $payment_method) }}"
                                class="btn btn-secondary btn-sm"><i class='bx bxs-detail'></i></a>
                            <a href="{{ route('admin.payment_method.edit', $payment_method) }}"
                                class="btn btn-warning btn-sm"><i class='bx bxs-edit'></i></a>
                            <form action="{{ route('admin.payment_method.destroy', $payment_method) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method ("DELETE")
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Bạn chắc chắn muốn xóa phương thức {{ $payment_method['name'] }}?')">
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

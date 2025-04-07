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
            <div class="col-3">
                <form action="{{ route('admin.payment_method.index') }}" class="" method="GET">
                    <div class="form-group d-flex">
                        <input placeholder="Tìm danh mục" id="search" name="search" class="form-control"></input>
                        <button type="submit" class="btn btn-primary text-white text-decoration-none m-1">Tìm</button>
                    </div>
                </form>
            </div>
            <div class="text-end col-9">
                <a href="{{ route('admin.payment_method.create') }}" class="btn btn-success text-white text-end ms-3">Thêm
                    phương thức</a>
            </div>
        </div>

        @isset($search)
            <h5 class='text-start mt-4 mb-4'>Kết quả tìm kiếm: <b>{{ $search }}</b></h5>
        @endisset


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
                        <td>0</td>
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

@extends('admin.layouts.admin')

@section('title')
    <title>
        Danh sách khuyến mãi</title>
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

        <h2 class="text-center fw-bolder ">Danh sách khuyến mãi thanh toán</h2>
        <div class="d-flex align-items-center mb-1 row">
            <div class="col-3">
                <form action="{{ route('admin.discount.index') }}" class="" method="GET">
                    <div class="form-group d-flex">
                        <input placeholder="Tìm khuyến mãi" id="search" name="search" class="form-control"></input>
                        <button type="submit" class="btn btn-primary text-white text-decoration-none m-1">Tìm</button>
                    </div>
                </form>
            </div>
            <div class="text-end col-9">
                <a href="{{ route('admin.discount.create') }}" class="btn btn-success text-white text-end ms-3">Thêm
                    khuyến mãi</a>
            </div>
        </div>

        @isset($search)
            <h5 class='text-start mt-4 mb-4'>Kết quả tìm kiếm: <b>{{ $search }}</b></h5>
        @endisset


        <table class="table table-bordered table-striped">
            <thead>
                <th>STT</th>
                <th>Danh mục</th>
                <th>Trị giá</th>
                <th>Ngày bắt đầu</th>
                <th>Ngày kết thúc</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </thead>

            <tbody>
                @foreach ($data as $discount)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td> {{ $discount->category['name'] }} </td>
                        <td> {{ $discount['percent'] }}% </td>
                        <td> {{ $discount['start_at'] }} </td>
                        <td> {{ $discount['end_at'] }} </td>
                        <td>
                            @if ($discount['status'] == 'disabled')
                                <form action="{{ route('admin.discount.activedDiscount', $discount) }}"
                                    method="POST"
                                    onsubmit="return confirm('Đồng ý chuyển sang trạng thái kích hoạt?\n' 
                                    + 'Trạng thái này sẽ cho phép người dùng có thể áp dụng khuyến mãi')">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Chưa kích hoạt</button>
                                </form>
                            @else
                                <form action="{{ route('admin.discount.disabledDiscount', $discount) }}"
                                    method="POST"
                                    onsubmit="return confirm('Xác nhận không kích hoạt trạng thái ?')">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Đã kích hoạt</button>
                                </form>
                            @endif
                        </td>
                        <td><a href="{{ route('admin.discount.show', $discount) }}" class="btn btn-secondary btn-sm"><i
                                    class='bx bxs-detail'></i></a>
                            <a href="{{ route('admin.discount.edit', $discount) }}" class="btn btn-warning btn-sm"><i
                                    class='bx bxs-edit'></i></a>
                            <form action="{{ route('admin.discount.destroy', $discount) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method ("DELETE")
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Bạn chắc chắn muốn xóa khuyến mãi {{ $discount['name'] }}?')">
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

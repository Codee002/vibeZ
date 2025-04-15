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

        <h2 class="text-center fw-bolder ">Danh sách khuyến mãi</h2>
        <div class="d-flex align-items-center mb-1 row">
            <div class="col-7">
                <form action="{{ route('admin.discount.index') }}" class="" method="GET">
                    <div class="row d-flex align-items-center mb-1">
                        <div class="form-group col-4">
                            <label for="start_at">Ngày bắt đầu: </label>
                            <input type="date" placeholder="Nhập vào trị giá khuyến mãi" name="start_at" id="start_at"
                                class="form-control
                     @error('start_at') is-invalid @enderror"
                                value="{{ old('start_at') }}">
                            @error('start_at')
                                <span class="invalid-feedback" style="display: block">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group  col-4">
                            <label for="end_at">Ngày kết thúc: </label>
                            <input type="date" placeholder="Nhập vào trị giá khuyến mãi" name="end_at" id="end_at"
                                class="form-control
                     @error('end_at') is-invalid @enderror"
                                value="{{ old('end_at') }}">

                            @error('end_at')
                                <span class="invalid-feedback" style="display: block">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group d-flex">

                        <select name="category" class="form-select me-1">
                            <option value="" disabled selected>Danh mục</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                            @endforeach
                        </select>

                        <select name="percent" class="form-select me-1">
                            <option value="" disabled selected>Sắp theo trị giá</option>
                            <option value="asc">Tăng dần</option>
                            <option value="desc">Giảm dần</option>
                        </select>

                        {{-- {{dd($ranks)}} --}}
                        <select name="status" class="form-select me-1">
                            <option value="" disabled selected>Trạng thái</option>
                            <option value="actived">Đã kích hoạt</option>
                            <option value="disabled">Chưa kích hoạt</option>
                        </select>


                        <button type="submit" class="btn btn-primary text-white text-decoration-none m-1">Tìm</button>
                    </div>

                </form>
            </div>
            <div class="text-end col-5">
                <a href="{{ route('admin.discount.create') }}" class="btn btn-success text-white text-end ms-3">Thêm
                    khuyến mãi</a>
            </div>
        </div>

        @if ($start_at || $end_at)
            <p class="mt-4" style="font-size: 1.2rem">Khuyến mãi
                @if ($start_at)
                    từ ngày <b>{{ Carbon\Carbon::parse($start_at)->format('d/m/Y') }}</b>
                @endif
                @if ($end_at)
                    đến ngày
                    <b>{{ Carbon\Carbon::parse($end_at)->format('d/m/Y') }}</b>
                @endif
            </p>
        @endif

        @if (!empty($category_id))
            <h5 class='text-start mt-4 mb-4'>Danh mục: <b>
                    @foreach ($categories as $category)
                        @if ($category['id'] == $category_id)
                            {{ $category['name'] }}
                        @endif
                    @endforeach
                </b></h5>
        @endif

        @if (!empty($percent))
            <h5 class='text-start mt-4 mb-4'>Trị giá: <b>{{ $percent == 'asc' ? 'Tăng dần' : 'Giảm dần' }}</b></h5>
        @endif

        @if (!empty($status))
            <h5 class='text-start mt-4 mb-4'>Trạng thái: <b>{{ $status == "actived" ? "Đã kích hoạt" : "Chưa kích hoạt" }}</b></h5>
        @endif

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
                                <form action="{{ route('admin.discount.activedDiscount', $discount) }}" method="POST"
                                    onsubmit="return confirm('Đồng ý chuyển sang trạng thái kích hoạt?\n' 
                                    + 'Trạng thái này sẽ cho phép người dùng có thể áp dụng khuyến mãi')">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Chưa kích hoạt</button>
                                </form>
                            @else
                                <form action="{{ route('admin.discount.disabledDiscount', $discount) }}" method="POST"
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

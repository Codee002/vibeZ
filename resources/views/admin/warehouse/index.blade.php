@extends('admin.layouts.admin')

@section('title')
    <title>Kho</title>
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

        <h2 class="text-center fw-bolder ">Danh sách kho</h2>
        <div class="d-flex align-items-center mb-1 row">
            <div class="col-5">
                <form action="{{ route('admin.warehouse.index') }}" class="" method="GET">
                    <div class="form-group d-flex">
                        <input placeholder="Vị tri" id="search" name="address" class="form-control me-1"></input>
                        <select name="capacity" class="form-select me-1">
                            <option value="" disabled selected>Dung tích</option>
                            <option value="asc">Tăng dần</option>
                            <option value="desc">Giảm dần</option>
                        </select>
                        {{-- <select name="" class="form-select me-1">
                            <option value="" disabled selected>Số sản phẩm</option>
                            <option value="asc">Tăng dần</option>
                            <option value="desc">Giảm dần</option>
                        </select> --}}
                        <button type="submit" class="btn btn-primary text-white text-decoration-none m-1">Tìm</button>
                    </div>
                </form>
            </div>
            <div class="text-end col-7">
                <a href="{{ route('admin.warehouse.create') }}" class="btn btn-success text-white text-end ms-3">Thêm
                    kho</a>
            </div>
        </div>

        @if (!empty($address))
            <h5 class='text-start mt-4 mb-4'>Vị tri: <b>{{ $address }}</b></h5>
        @endif

        @if (!empty($capacity))
            <h5 class='text-start mt-4 mb-4'>Sắp xếp: <b>{{ $capacity == 'asc' ? 'Tăng dần' : 'Giảm dần' }}</b></h5>
        @endif


        <table class="table table-bordered table-striped">
            <thead>
                <th>Mã kho</th>
                <th>Vị trí</th>
                <th>Dung tích</th>
                <th>Số sản phẩm</th>
                <th>Thao tác</th>
            </thead>

            <tbody>
                @foreach ($data as $warehouse)
                    <tr>
                        <td>K{{ $warehouse['id'] }}</td>
                        <td> {{ $warehouse['address'] }} </td>
                        <td> {{ $warehouse['capacity'] }} </td>
                        <td> {{ $warehouse->getQuantity() }} </td>
                        <td><a href="{{ route('admin.warehouse.show', $warehouse) }}" class="btn btn-secondary btn-sm"><i
                                    class='bx bxs-detail'></i></a>
                            <a href="{{ route('admin.warehouse.edit', $warehouse) }}" class="btn btn-warning btn-sm"><i
                                    class='bx bxs-edit'></i></a>
                            <form action="{{ route('admin.warehouse.destroy', $warehouse) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method ("DELETE")
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Bạn chắc chắn muốn xóa kho {{ $warehouse['address'] }}?')">
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

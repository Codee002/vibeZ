@extends('admin.layouts.admin')

@section('title')
    <title>Danh mục</title>
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

        <h2 class="text-center fw-bolder ">Danh sách danh mục</h2>
        <div class="d-flex align-items-center mb-1 row">
            <div class="col-3">
                <form action="{{ route('admin.category.index') }}" class="" method="GET">
                    <div class="form-group d-flex">
                        <input placeholder="Tên danh mục" id="search" name="name" class="form-control me-1"></input>
                        {{-- <select name="order_price" class="form-select me-1">
                            <option value="" disabled selected>Sắp theo sản phẩm</option>
                            <option value="asc">Tăng dần</option>
                            <option value="desc">Giảm dần</option>
                        </select> --}}
                        <button type="submit" class="btn btn-primary text-white text-decoration-none m-1">Tìm</button>
                    </div>
                    
                </form>
            </div>
            <div class="text-end col-9">
                <a href="{{ route('admin.category.create') }}" class="btn btn-success text-white text-end ms-3">Thêm danh
                    mục</a>
            </div>
        </div>

        @if (!empty($name))
            <h5 class='text-start mt-4 mb-4'>Tên danh mục: <b>{{ $name }}</b></h5>
        @endif


        <table class="table table-bordered table-striped">
            <thead>
                <th>STT</th>
                <th>Danh mục</th>
                <th>Số sản phẩm</th>
                <th>Ngày tạo</th>
                <th>Thao tác</th>
            </thead>

            <tbody>
                @foreach ($data as $category)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td> {{ $category['name'] }} </td>
                        <td>{{  $category['count_product'] }}</td>
                        <td> {{ \Carbon\Carbon::parse($category['created_at'])->format('d/m/Y') }} </td>
                        <td><a href="{{ route('admin.category.show', $category) }}" class="btn btn-secondary btn-sm"><i
                                    class='bx bxs-detail'></i></a>
                            <a href="{{ route('admin.category.edit', $category) }}" class="btn btn-warning btn-sm"><i
                                    class='bx bxs-edit'></i></a>
                            <form action="{{ route('admin.category.destroy', $category) }}" method="POST" class="d-inline">
                                @csrf
                                @method ("DELETE")
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Bạn chắc chắn muốn xóa danh mục {{ $category['name'] }}?')">
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

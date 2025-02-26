@extends('admin.layouts.admin')

@section('title')
    <title>Sản phẩm</title>
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

        <h2 class="text-center fw-bolder ">Danh sách sản phẩm</h2>
        <div class="d-flex align-items-center mb-1 row">
            <div class="col-3">
                <form action="{{ route('admin.product.index') }}" class="" method="GET">
                    <div class="form-group d-flex">
                        <input placeholder="Tìm sản phẩm" id="search" name="search" class="form-control"></input>
                        <button type="submit" class="btn btn-primary text-white text-decoration-none m-1">Tìm</button>
                    </div>
                </form>
            </div>
            <div class="text-end col-9">
                <a href="{{ route('admin.product.create') }}" class="btn btn-success text-white text-end ms-3">Thêm sản
                    phẩm</a>
            </div>
        </div>

        @isset($search)
            <h5 class='text-start mt-4 mb-4'>Kết quả tìm kiếm: <b>{{ $search }}</b></h5>
        @endisset


        <table class="table table-bordered table-striped">
            <thead>
                <th>STT</th>
                <th>Hình ảnh</th>
                <th>Tên sản phẩm</th>
                <th>Danh mục</th>
                <th>Thao tác</th>
            </thead>

            <tbody>
                @foreach ($data as $product)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if ($product->images->isNotEmpty())
                                @if ($product->images[0] && \Storage::exists($product->images[0]->img_path))
                                    <img src="{{ \Storage::url($product->images[0]->img_path) }}" alt=""
                                        width="50rem">
                                @endif
                            @endif
                        </td>
                        <td> {{ $product['name'] }} </td>
                        <td> {{ $product->category->name }} </td>
                        <td><a href="{{ route('admin.product.show', $product) }}" class="btn btn-warning btn-sm"><i
                                    class='bx bxs-detail'></i></a>
                            <a href="{{ route('admin.product.edit', $product) }}" class="btn btn-warning btn-sm"><i
                                    class='bx bxs-edit'></i></a>
                            <form action="{{ route('admin.product.destroy', $product) }}" method="POST" class="d-inline">
                                @csrf
                                @method ("DELETE")
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Bạn chắc chắn muốn xóa sản phẩm {{ $product['name'] }}?')">
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

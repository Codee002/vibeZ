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
            <div class="col-7">
                <form action="{{ route('admin.product.index') }}" class="" method="GET">
                    <div class="form-group d-flex">
                        <input placeholder="Mã SP" id="search" name="id" class="form-control me-1"></input>
                        <input placeholder="Tên" name="name" class="form-control me-1"></input>
                        <select name="category" class="form-select me-1">
                            <option value="" disabled selected>Danh mục</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                            @endforeach
                        </select>
                        <select name="order_by" class="form-select me-1">
                            <option value="" disabled selected>Sắp theo</option>
                            <option value="asc">Cũ nhất</option>
                            <option value="desc">Mới nhất</option>
                        </select>
                        <button type="submit" class="btn btn-primary text-white text-decoration-none m-1">Tìm</button>
                    </div>
                </form>
            </div>
            <div class="text-end col-5">
                <a href="{{ route('admin.product.create') }}" class="btn btn-success text-white text-end ms-3">Thêm sản
                    phẩm</a>
            </div>
        </div>

        @if (!empty($id))
            <h5 class='text-start mt-4 mb-4'>Mã SP: <b>{{ $id }}</b></h5>
        @endif
        @if (!empty($name))
            <h5 class='text-start mt-4 mb-4'>Tên SP: <b>{{ $name }}</b></h5>
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

        @if (!empty($order_by))
            <h5 class='text-start mt-4 mb-4'>Sắp xếp: <b>{{ $order_by == 'asc' ? 'Cũ nhất' : 'Mới nhất' }}</b></h5>
        @endif


        <table class="table table-bordered table-striped">
            <thead>
                <th>Mã SP</th>
                <th>Hình ảnh</th>
                <th>Tên sản phẩm</th>
                <th>Danh mục</th>
                <th>Thao tác</th>
            </thead>

            <tbody>
                @foreach ($data as $product)
                    <tr>
                        <td>SP{{ $product['id'] }}</td>
                        <td class="">
                            @if ($product->images->isNotEmpty())
                                @if ($product->images[0] && \Storage::exists($product->images[0]->img_path))
                                    <img src="{{ \Storage::url($product->images[0]->img_path) }}" alt=""
                                        width="50rem">
                                @endif
                            @endif
                        </td>
                        <td> {{ $product['name'] }} </td>
                        <td> {{ $product->category->name }} </td>
                        <td><a href="{{ route('admin.product.show', $product) }}" class="btn btn-secondary btn-sm"><i
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

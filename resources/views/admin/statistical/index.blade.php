@extends('admin.layouts.admin')

@section('title')
    <title>Thống kê</title>
@endsection

{{-- @section('namePage', 'Danh sách thống kê') --}}

@section('content')
    <div class="p-3">
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

        <h2 class="text-center fw-bolder ">Thống kê</h2>
        <div class="d-flex align-items-center mb-1 row">
            <div class="col-5">
                <form action="{{ route('admin.statistical.index') }}" class="" method="GET">
                    <div class="form-group d-flex">
                        <input placeholder="Mã SP" id="search" name="id" class="form-control me-1"></input>
                        <input placeholder="Tên SP" id="search" name="name" class="form-control me-1"></input>
                        {{-- <select name="quantity_receipt" class="form-select me-1">
                            <option value="" disabled selected>SL nhập</option>
                            <option value="asc">Tăng dần</option>
                            <option value="desc">Giảm dần</option>
                        </select>

                        <select name="quantity_sale" class="form-select me-1">
                            <option value="" disabled selected>SL bán</option>
                            <option value="asc">Tăng dần</option>
                            <option value="desc">Giảm dần</option>
                        </select>

                        <select name="quantity_warehouse" class="form-select me-1">
                            <option value="" disabled selected>SL tồn</option>
                            <option value="asc">Tăng dần</option>
                            <option value="desc">Giảm dần</option>
                        </select>

                        <select name="total_receipt" class="form-select me-1">
                            <option value="" disabled selected>Tổng giá nhập</option>
                            <option value="asc">Tăng dần</option>
                            <option value="desc">Giảm dần</option>
                        </select>

                        <select name="total_sale" class="form-select me-1">
                            <option value="" disabled selected>Tổng giá bán</option>
                            <option value="asc">Tăng dần</option>
                            <option value="desc">Giảm dần</option>
                        </select>

                        <select name="total_price" class="form-select me-1">
                            <option value="" disabled selected>Doanh thu</option>
                            <option value="asc">Tăng dần</option>
                            <option value="desc">Giảm dần</option>
                        </select> --}}
                        <button type="submit" class="btn btn-primary text-white text-decoration-none m-1">Tìm</button>
                    </div>
                </form>
            </div>
            <div class="text-end col-7">
                <a href="{{ route('admin.statistical.export') }}" class="btn btn-success text-white text-end ms-3">Xuất File</a>
            </div>
        </div>

        @if (!empty($id))
            <h5 class='text-start mt-4 mb-4'>Mã SP: <b>{{ $id }}</b></h5>
        @endif

        @if (!empty($name))
            <h5 class='text-start mt-4 mb-4'>Tên SP: <b>{{ $name }}</b></h5>
        @endif


        <table class="table table-bordered table-striped">
            <thead>
                <th>Mã</th>
                <th>Ảnh</th>
                <th style="width: 13rem">Tên sản phẩm</th>
                <th>Đơn vị tính</th>
                <th>Giá nhập</th>
                <th>Giá bán</th>
                <th>SL nhập</th>
                <th>SL bán</th>
                <th>SL giao</th>
                <th>SL tồn</th>
                <th>Tổng giá nhập</th>
                <th>Tổng giá bán</th>
                <th>Doanh thu</th>
                {{-- <th>Thao tác</th> --}}
            </thead>


            <tbody>
                @foreach ($products as $product)
                    {{-- {{ dd($product) }} --}}
                    <tr>
                        <td>SP{{ $product['product_id'] }}</td>
                        <td class="">
                            @if ($product['image'] && \Storage::exists($product['image']))
                                <img src="{{ \Storage::url($product['image']) }}" alt="" width="50rem">
                            @endif
                        </td>
                        <td class="product_name"> {{ $product['product_name'] }} </td>
                        <td> {{ $product['product_unit'] }} </td>
                        <td> {{ number_format($product['purchase_price'], 0, ',', '.') }} </td>
                        <td> {{ number_format($product['sale_price'], 0, ',', '.') }} </td>
                        <td> {{ $product['quantity_receipt'] }} </td>
                        <td> {{ $product['quantity_order'] }} </td>
                        <td> {{ $product['quantity_ship'] }} </td>
                        <td> {{ $product['quantity_warehouse'] }} </td>
                        <td> {{number_format($product['purchase_price'] * $product['quantity_receipt'], 0, ',', '.')  }} </td>
                        <td> {{number_format($product['sale_price'] * $product['quantity_order'], 0, ',', '.')  }} </td>
                        <td> {{number_format($product['sale_price'] * $product['quantity_order'] -
                            $product['purchase_price'] * $product['quantity_receipt'], 0, ',', '.')  }}
                        </td>

                        {{-- <td><a href=""
                                class="btn btn-secondary btn-sm"><i class='bx bxs-detail'></i></a>
                        </td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>
            {{ $products->withQueryString()->links() }}
        </div>
    </div>

    <style>
        .product_name {
            height: 4.1rem;
            display: block;
            width: 13rem !important;
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
        }
    </style>
@endsection

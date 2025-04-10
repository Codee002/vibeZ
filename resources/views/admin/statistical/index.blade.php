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
            <div class="col-3">
                <form action="{{ route('admin.product.index') }}" class="" method="GET">
                    <div class="form-group d-flex">
                        <input placeholder="Tìm sản phẩm" id="search" name="search" class="form-control"></input>
                        <button type="submit" class="btn btn-primary text-white text-decoration-none m-1">Tìm</button>
                    </div>
                </form>
            </div>
            <div class="text-end col-9">
                <a href="{{ route('admin.statistical.export') }}" class="btn btn-success text-white text-end ms-3">Xuất File</a>
            </div>
        </div>

        @isset($search)
            <h5 class='text-start mt-4 mb-4'>Kết quả tìm kiếm: <b>{{ $search }}</b></h5>
        @endisset


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

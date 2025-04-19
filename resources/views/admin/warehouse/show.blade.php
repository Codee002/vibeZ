@extends('admin.layouts.admin')

@section('title')
    <title>Chi tiết kho</title>
@endsection

@section('content')
    <div class="container">
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
        <h2 class="text-center fw-bolder text-">Chi tiết kho</h2>
        <div class="row" style="margin: auto">
            <div class="col-8 d-flex align-items-center row">
                <p class="title col-3">Địa chỉ kho: </p>
                <p class="d-flex align-items-center col-4">{{ $warehouse['address'] }}</p>
            </div>
            <div class="col-8 d-flex align-items-center row">
                <p class="title col-3">Dung tích kho: </p>
                <p class="col-4">{{ $warehouse['capacity'] }}</p>
            </div>
            <div class="col-8 d-flex align-items-center row">
                <p class="title col-3">Ngày tạo: </p>
                <p class="col-4">{{ \Carbon\Carbon::parse($warehouse['created_at'])->format('d/m/Y') }}</p>
            </div>

            <div class="col-8 d-flex align-items-center row">
                <p class="title col-3">Tổng sản phẩm thuộc kho: </p>
                <p class="col-5">{{ $warehouse->getQuantity() }}
                    @if ($warehouse->getQuantity() != 0)
                    <i class="ms-1">
                        ({{ $warehouse->getQuantityActived() }} kích hoạt,
                        {{  $warehouse->getQuantityDisabled() }} chưa kích họat)
                    </i>
                @endif
                </p>
            </div>

            <div class="col-8 d-flex align-items-center row">
                <p class="title col-3">Tổng sản phẩm chưa xử lý: </p>
                <p class="col-4">{{ $warehouse->getQuantityPending() }}</p>
            </div>

            <div class="col-8 d-flex align-items-center row">
                <p class="title col-3">Còn trống: </p>
                <p class="col-4">{{ $warehouse['capacity'] - $warehouse->getQuantity() - $warehouse->getQuantityPending() }}</p>
            </div>


        </div>
        <div class="d-flex align-items-center mb-1 row">
            <div class="col-5">
                <form action="{{ route('admin.warehouse.show', $warehouse) }}" class="" method="GET">
                    <div class="form-group d-flex">
                        <input placeholder="Tên SP" id="search" name="name" class="form-control me-1"></input>

                        <select name="status" class="form-select me-1">
                            <option value="" disabled selected>Trạng thái</option>
                            <option value="actived">Đã kích hoạt</option>
                            <option value="disabled">Chưa kích hoạt</option>
                        </select>

                        <button type="submit" class="btn btn-primary text-white text-decoration-none m-1">Tìm</button>
                    </div>
                </form>
            </div>
        </div>

        @if (!empty($name))
            <h5 class='text-start mt-4 mb-4'>Mã DH: <b>{{ $name }}</b></h5>
        @endif

        @if (!empty($status))
            <h5 class='text-start mt-4 mb-4'>Trạng thái: <b>
                    {{ $status == "actived" ? "Đã kích hoạt" : "Chưa kích hoạt" }}
                </b></h5>
        @endif

        <table class="table table-bordered table-striped">
            <thead>
                <th>STT</th>
                <th>Hình ảnh</th>
                <th>Tên sản phẩm</th>
                <th>Size</th>
                <th>Danh mục</th>
                <th>Số lượng</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </thead>


            @foreach ($warehouse_details as $warehouse_detail)
            @endforeach
            {{-- {{dd($warehouse_detail->product)}} --}}
            <tbody>
                @foreach ($warehouse_details as $warehouse_detail)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="">
                            @if ($warehouse_detail->product->images->isNotEmpty())
                                @if ($warehouse_detail->product->images[0] && \Storage::exists($warehouse_detail->product->images[0]->img_path))
                                    <img src="{{ \Storage::url($warehouse_detail->product->images[0]->img_path) }}"
                                        alt="" width="50rem">
                                @endif
                            @endif
                        </td>

                        <td> {{ $warehouse_detail->product['name'] }} </td>
                        <td>{{ $warehouse_detail->size }}</td>
                        <td> {{ $warehouse_detail->product->category->name }} </td>
                        <td>{{ $warehouse_detail['quantity'] }}</td>
                        <td>
                            {{-- {{ dd($warehouse_detail) }} --}}
                            @if ($warehouse_detail['status'] == 'disabled')
                                <form action="{{ route('admin.warehouse.activedProduct', $warehouse_detail) }}"
                                    method="POST"
                                    onsubmit="return confirm('Đồng ý chuyển sang trạng thái kích hoạt?\n' 
                                    + 'Trạng thái này sẽ cho phép người dùng có thể tìm kiếm và mua hàng')">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Chưa kích hoạt</button>
                                </form>
                            @else
                                <form action="{{ route('admin.warehouse.disabledProduct', $warehouse_detail) }}"
                                    method="POST"
                                    onsubmit="return confirm('Xác nhận không kích hoạt trạng thái ?\n' 
                            + 'Người dùng sẽ không được phép tìm kiếm và mua sản phẩm này')">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Đã kích hoạt</button>
                                </form>
                            @endif
                        </td>

                        <td><a href="{{ route('admin.product.show', $warehouse_detail->product) }}"
                                class="btn btn-secondary btn-sm"><i class='bx bxs-detail'></i></a>
                            <a href="{{ route('admin.product.edit', $warehouse_detail->product) }}"
                                class="btn btn-warning btn-sm"><i class='bx bxs-edit'></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="">
            {{ $warehouse_details->withQueryString()->links() }}
        </div>
    </div>

    <style>
        .title {
            font-size: 1rem;
            font-weight: 700;
            margin-right: 1rem;
            display: flex;
            justify-content: start;
            align-items: center;
        }
    </style>
@endsection

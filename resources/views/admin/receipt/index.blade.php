@extends('admin.layouts.admin')

@section('title')
    <title>
        Phiếu nhập</title>
@endsection

{{-- @section('namePage', 'Danh sách phiếu nhập') --}}

@section('content')
    <div class="container" style="width: 90%">
        @if (session('success'))
            <div class="alert alert-success">
                {!! session('success') !!}
            </div>
        @endif

        @if (session('danger'))
            <div class="alert alert-danger">
                {{ session('danger') }}
            </div>
        @endif

        <h2 class="text-center fw-bolder ">Danh sách phiếu nhập</h2>
        <div class="d-flex align-items-center mb-1 row">
            <div class="col-9">
                <form action="{{ route('admin.receipt.index') }}" class="" method="GET">
                    <div class="form-group d-flex">
                        <input placeholder="Mã" id="search" name="id" class="form-control me-1"></input>
                        {{-- {{dd($warehouses)}} --}}
                        <select name="warehouse" class="form-select me-1">
                            <option value="" disabled selected>Kho</option>
                            @foreach ($warehouses as $warehouse)
                                <option value="{{ $warehouse['id'] }}">{{ $warehouse['address'] }}</option>
                            @endforeach
                        </select>

                        <select name="point" class="form-select me-1">
                            <option value="" disabled selected>Tổng sản phẩm</option>
                            <option value="asc">Tăng dần</option>
                            <option value="desc">Giảm dần</option>
                        </select>

                        <select name="status" class="form-select me-1">
                            <option value="" disabled selected>Trạng thái</option>
                            <option value="pending">Đã nhập</option>
                            <option value="completing">Đang xử lý</option>
                        </select>
                        <button type="submit" class="btn btn-primary text-white text-decoration-none m-1">Tìm</button>
                    </div>
                </form>
            </div>
            <div class="text-end col-3">
                <a href="{{ route('admin.receipt.choiceProduct') }}" class="btn btn-success text-white text-end ms-3">Tạo
                    phiếu nhập</a>
            </div>
        </div>

        @isset($search)
            <h5 class='text-start mt-4 mb-4'>Kết quả tìm kiếm: <b>{{ $search }}</b></h5>
        @endisset

        <table class="table table-bordered table-striped">
            <thead>
                <th>Mã</th>
                <th>Tổng sản phẩm</th>
                <th>Kho nhập</th>
                <th>Ngày tạo</th>
                <th>Ngày xử lý</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </thead>

            <tbody>
                @foreach ($data as $receipt)
                    {{-- {{dd($receipt['status'])}} --}}
                    <tr>
                        <td>PN{{ $receipt['id'] }}</td>

                        <td> {{ $receipt->getQuantity() }} </td>
                        <td> {{ $receipt->warehouse->address }} </td>
                        <td>
                            <p>{{ \Carbon\Carbon::parse($receipt['created_at'])->format('d/m/Y') }}</p>
                        </td>
                        <td>
                            @if ($receipt['status'] == 'pending')
                                <p>Đang chờ xử lý</p>
                            @else
                                {{ \Carbon\Carbon::parse($receipt['updated_at'])->format('d/m/Y') }}
                            @endif
                        </td>
                        <td>
                            @if ($receipt['status'] == 'pending')
                                <form action="{{ route('admin.receipt.handleReceipt', $receipt) }}" method="POST"
                                    onsubmit="return confirm('Đồng ý chuyển sang trạng thái đã xử lý?\n' 
                                    + 'Trạng thái này sẽ chuyển các sản phẩm vào kho hàng tương ứng')">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Đang xử lý</button>
                                </form>
                            @else
                                <p class="btn btn-success">Đã nhập</p>
                            @endif
                        </td>
                        <td><a href="{{ route('admin.receipt.show', $receipt) }}" class="btn btn-secondary btn-sm"><i
                                    class='bx bxs-detail'></i></a>
                            {{-- <a href="{{ route('admin.receipt.edit', $receipt) }}" class="btn btn-warning btn-sm"><i
                                    class='bx bxs-edit'></i></a> --}}
                            <form action="{{ route('admin.receipt.destroy', $receipt) }}" method="POST" class="d-inline">
                                @csrf
                                @method ("DELETE")
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Bạn chắc chắn muốn xóa phiếu nhập {{ $receipt['name'] }}?')">
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

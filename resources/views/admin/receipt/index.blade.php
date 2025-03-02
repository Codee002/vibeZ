@extends('admin.layouts.admin')

@section('title')
    <title>Phiếu nhập</title>
@endsection

{{-- @section('namePage', 'Danh sách phiếu nhập') --}}

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

        <h2 class="text-center fw-bolder ">Danh sách phiếu nhập</h2>
        <div class="d-flex align-items-center mb-1 row">
            <div class="col-3">
                <form action="{{ route('admin.receipt.index') }}" class="" method="GET">
                    <div class="form-group d-flex">
                        <input placeholder="Tìm phiếu nhập" id="search" name="search" class="form-control"></input>
                        <button type="submit" class="btn btn-primary text-white text-decoration-none m-1">Tìm</button>
                    </div>
                </form>
            </div>
            <div class="text-end col-9">
                <a href="{{ route('admin.receipt.choiceProduct') }}" class="btn btn-success text-white text-end ms-3">Tạo
                    phiếu nhập</a>
            </div>
        </div>

        @isset($search)
            <h5 class='text-start mt-4 mb-4'>Kết quả tìm kiếm: <b>{{ $search }}</b></h5>
        @endisset

        <table class="table table-bordered table-striped">
            <thead>
                <th>STT</th>
                <th>Tổng sản phẩm</th>
                <th>Kho nhập</th>
                <th>Ngày tạo</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </thead>

            <tbody>
                @foreach ($data as $receipt)
                    {{-- {{dd($receipt['status'])}} --}}
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td> {{ $receipt->getQuantity() }} </td>
                        <td> {{ $receipt->warehouse->address }} </td>
                        <td> {{ \Carbon\Carbon::parse($receipt['created_at'])->format('d/m/Y') }} </td>
                        <td>
                            @if ($receipt['status'] == 'pending')
                                <p class="btn btn-danger">Đang xử lý</p>
                            @else
                                <p class="btn btn-success">Đã nhập</p>
                            @endif
                        </td>
                        <td><a href="{{ route('admin.receipt.show', $receipt) }}" class="btn btn-secondary btn-sm"><i
                                    class='bx bxs-detail'></i></a>
                            <a href="{{ route('admin.receipt.edit', $receipt) }}" class="btn btn-warning btn-sm"><i
                                    class='bx bxs-edit'></i></a>
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

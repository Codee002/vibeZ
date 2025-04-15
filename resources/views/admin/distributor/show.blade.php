@extends('admin.layouts.admin')

@section('title')
    <title>Nhà cung cấp</title>
@endsection

@section('content')
    <div class="container">
        <h2 class="text-center fw-bolder text-">Thông tin nhà cung cấp</h2>
        <div class="row" style="margin: auto">
            <div class="col-8 d-flex align-items-center row">
                <p class="title col-4">Tên: </p>
                <p class="d-flex align-items-center col-5">{{ $distributor['name'] }}</p>
            </div>

            <div class="col-8 d-flex align-items-center row">
                <p class="title col-4">Địa chỉ: </p>
                <p class="d-flex align-items-center col-5">{{ $distributor['address'] }}</p>
            </div>

            <div class="col-8 d-flex align-items-center row">
                <p class="title col-4">Email: </p>
                <p class="d-flex align-items-center col-5">{{ $distributor['email'] }}</p>
            </div>

            <div class="col-8 d-flex align-items-center row">
                <p class="title col-4">Tổng phiếu đã nhập: </p>
                <p class="d-flex align-items-center col-5">{{ $distributor->countReceipt() }}
                    <i class="ms-1">  
                    ({{ $distributor->countReceiptCompleted() }} đã xử lý,
                    {{ $distributor->countReceipt() - $distributor->countReceiptCompleted() }} chưa xử lý)</p>
                </i>
            </div>

            <div class="col-8 d-flex align-items-center row">
                <p class="title col-4">Tổng số lượng sản phẩm đã nhập: </p>
                <p class="d-flex align-items-center col-5">{{number_format($distributor->countQuantityProductCompleted(), 0, "", ".")  }}</p>
            </div>

            <div class="col-8 d-flex align-items-center row">
                <p class="title col-4">Tổng tiền đã thanh toán: </p>
                <p class="d-flex align-items-center col-5">{{ number_format($distributor->getPriceCompleted() ,0, "", ".")  }}</p>
            </div>

        </div>

        {{-- Phiếu nhập --}}
        @if ($receipts->isNotEmpty())
            <table class="table table-bordered table-striped">
                <thead>
                    <th>STT</th>
                    <th>Tổng sản phẩm</th>
                    <th>Kho nhập</th>
                    <th>Ngày tạo</th>
                    <th>Ngày xử lý</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </thead>

                <tbody>
                    @foreach ($receipts as $receipt)
                        {{-- {{dd($receipt['status'])}} --}}
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td> {{ $receipt->getQuantity() }} </td>
                            <td> {{ $receipt->warehouse->address }} </td>
                            <td>
                                @if ($receipt['status'] == 'pending')
                                    <p>Đang chờ xử lý</p>
                                @else
                                    <p>{{ \Carbon\Carbon::parse($receipt['updated_at'])->format('d/m/Y') }}</p>
                                @endif
                            </td>
                            <td> {{ \Carbon\Carbon::parse($receipt['created_at'])->format('d/m/Y') }} </td>
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
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div>
                {{ $receipts->withQueryString()->links() }}
            </div>
        @endif

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

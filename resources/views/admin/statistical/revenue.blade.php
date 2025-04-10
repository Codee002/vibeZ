@extends('admin.layouts.admin')

@section('title')
    <title>Thống kê doanh thu</title>
@endsection

@section('content')
    <div class="container" style="width: 90%">
        <h2 class="text-center fw-bolder text-">Doanh thu</h2>

        <form action="{{ route('admin.statistical.revenue') }}" class="col-12 mt-3" method="get">
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

            <div class="row d-flex align-items-center">
                <div class="form-group col-3 ms-4">
                    <label for="start_at">Ngày bắt đầu: </label>
                    <input type="date" placeholder="Nhập vào trị giá khuyến mãi" name="start_at" id="start_at"
                        class="form-control
             @error('start_at') is-invalid @enderror"
                        value="{{ old('start_at') }}">
                    @error('start_at')
                        <span class="invalid-feedback" style="display: block">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group  col-3">
                    <label for="end_at">Ngày kết thúc: </label>
                    <input type="date" placeholder="Nhập vào trị giá khuyến mãi" name="end_at" id="end_at"
                        class="form-control
             @error('end_at') is-invalid @enderror" value="{{ old('end_at') }}">

                    @error('end_at')
                        <span class="invalid-feedback" style="display: block">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class=" d-flex align-items-center ">
                    <button href="" class="btn btn-primary text-white text-decoration-none mt-2 ms-4 ">Tìm</button>
                </div>
            </div>
        </form>

        <div class="row mb-4 mt-3 ms-4">
            <div class="">
                @if ($startDate || $endDate)
                    <p class="" style="font-size: 1.2rem">Thống kê doanh thu
                        @if ($startDate)
                            từ ngày <b>{{ Carbon\Carbon::parse($startDate)->format('d/m/Y') }}</b>
                        @endif
                        @if ($endDate)
                            đến ngày
                            <b>{{ Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</b>
                        @endif
                    </p>
                @endif
            </div>
            <div class="col-4 d-flex align-items-center">
                <p class="title col-4">Tổng SL nhập: </p>
                <p class="d-flex align-items-center col-6">{{ $totalQuantityReceipt }}</p>
            </div>

            <div class="col-4 d-flex align-items-center">
                <p class="title col-4">Tổng SL bán: </p>
                <p class="d-flex align-items-center col-6">{{ $totalQuantityOrder }}</p>
            </div>

            <div class="col-4 d-flex align-items-center">
                <p class="title col-3">Tổng SL tồn: </p>
                <p class="d-flex align-items-center col-6">{{ $totalQuantityWarehouse }}</p>
            </div>

            {{-- Tổng giá --}}
            <div class="col-4 d-flex align-items-center">
                <p class="title col-4">Tổng giá nhập: </p>
                <p class="col-6">{{ number_format($totalPurchasePrice, 0, ',', '.') }}</p>
            </div>

            <div class="col-4 d-flex align-items-center">
                <p class="title col-4">Tổng giá bán: </p>
                <p class="col-6">{{ number_format($totalSalePrice, 0, ',', '.') }}</p>
            </div>

            <div class="col-4 d-flex align-items-center">
                <p class="title col-3">Doanh thu: </p>
                <p class="col-6">{{ number_format($totalSalePrice - $totalPurchasePrice, 0, ',', '.') }}</p>
            </div>
        </div>

        {{-- Chart --}}
        <div class="mb-4">
            <canvas id="quantityChart"></canvas>
        </div>

        <div class="row" style="margin: auto">
            {{-- Chart --}}
            <div style="margin-top: 20px;" class="mb-3">
                <canvas id="valueChart"></canvas>
            </div>
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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        totalQuantityReceipt = @json($totalQuantityReceipt);
        totalQuantityOrder = @json($totalQuantityOrder);
        totalQuantityWarehouse = @json($totalQuantityWarehouse);
        quantityData = {
            labels: ['Số lượng'], // Chỉ có một nhóm dữ liệu tại thời điểm này
            datasets: [{
                    label: 'SL nhập',
                    data: [totalQuantityReceipt],
                    backgroundColor: '#5e9ed5', // Màu xanh dương

                },
                {
                    label: 'SL bán',
                    data: [totalQuantityOrder],
                    backgroundColor: '#ea7133', // Màu đỏ

                },
                {
                    label: 'SL tồn',
                    data: [totalQuantityWarehouse],
                    backgroundColor: '#196923',

                },
            ],
        };

        // Lấy context của canvas cho biểu đồ số lượng
        const quantityCtx = document.getElementById('quantityChart').getContext('2d');


        const quantityChart = new Chart(quantityCtx, {
            type: 'bar',
            data: quantityData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: ''
                        }
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Biểu đồ thống kê số lượng nhập, bán và tồn kho',
                        font: {
                            size: 16
                        }
                    }
                }
            }
        });

        totalPurchasePrice = @json($totalPurchasePrice);
        totalSalePrice = @json($totalSalePrice);

        valueData = {
            labels: ['Giá'], // Chỉ có một nhóm dữ liệu tại thời điểm này
            datasets: [{
                    label: 'Tổng giá nhập',
                    data: [totalPurchasePrice],
                    backgroundColor: '#5e9ed5', // Màu xanh dương
                },
                {
                    label: 'Tổng giá bán',
                    data: [totalSalePrice],
                    backgroundColor: '#ea7133', // Màu đỏ
                },
                {
                    label: 'Doanh thu',
                    data: [totalSalePrice - totalPurchasePrice],
                    backgroundColor: '#196923',
                },
            ],
        };

        // Lấy context của canvas cho biểu đồ giá trị
        const valueCtx = document.getElementById('valueChart').getContext('2d');
        const valueChart = new Chart(valueCtx, {
            type: 'bar',
            data: valueData,
            options: {
                scales: {
                    y: {
                        title: {
                            display: true,
                            text: ''
                        }
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Biểu đồ thống kê tổng giá nhập, bán và doanh thu',
                        font: {
                            size: 16
                        }
                    }
                }
            }
        });
    </script>
@endsection

@section('script')
@endsection

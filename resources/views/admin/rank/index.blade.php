@extends('admin.layouts.admin')

@section('title')
    <title>
        Cấp tài khoản</title>
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

        <h2 class="text-center fw-bolder ">Danh sách cấp của tài khoản</h2>
        <div class="d-flex align-items-center mb-1 row">
            <div class="col-3">
                <form action="{{ route('admin.rank.index') }}" class="" method="GET">
                    <div class="form-group d-flex">
                        <input placeholder="Tìm cấp" id="search" name="search" class="form-control"></input>
                        <button type="submit" class="btn btn-primary text-white text-decoration-none m-1">Tìm</button>
                    </div>
                </form>
            </div>
            <div class="text-end col-9">
                <a href="{{ route('admin.rank.create') }}" class="btn btn-success text-white text-end ms-3">Thêm cấp</a>
            </div>
        </div>

        @isset($search)
            <h5 class='text-start mt-4 mb-4'>Kết quả tìm kiếm: <b>{{ $search }}</b></h5>
        @endisset


        <table class="table table-bordered table-striped">
            <thead>
                <th>Cấp</th>
                <th>Số điểm</th>
                <th>Giảm giá</th>
                <th>Thao tác</th>
            </thead>

            <tbody>
                @foreach ($data as $rank)
                    <tr>
                        <td>{{ $rank['type'] }}</td>
                        <td> {{ number_format($rank['point'], 0, "", ".") }} </td>
                        <td> {{ number_format($rank['discount'], 0, "", ".") }}% </td>
                        <td><a href="{{ route('admin.rank.show', $rank) }}" class="btn btn-secondary btn-sm"><i
                                    class='bx bxs-detail'></i></a>
                            <a href="{{ route('admin.rank.edit', $rank) }}" class="btn btn-warning btn-sm"><i
                                    class='bx bxs-edit'></i></a>
                            <form action="{{ route('admin.rank.destroy', $rank) }}" method="POST" class="d-inline">
                                @csrf
                                @method ("DELETE")
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Bạn chắc chắn muốn xóa phương thức {{ $rank['name'] }}?')">
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

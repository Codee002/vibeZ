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
            <div class="col-5">
                <form action="{{ route('admin.rank.index') }}" class="" method="GET">
                    <div class="form-group d-flex">
                        <select name="rank" class="form-select me-1">
                            <option value="" disabled selected>Cấp</option>
                            @foreach ($ranks as $rank)
                                <option value="{{ $rank['id'] }}">{{ $rank['type'] }}</option>
                            @endforeach
                        </select>
                        <select name="point" class="form-select me-1">
                            <option value="" disabled selected>Sắp theo số điểm</option>
                            <option value="asc">Tăng dần</option>
                            <option value="desc">Giảm dần</option>
                        </select>
                        <button type="submit" class="btn btn-primary text-white text-decoration-none m-1">Tìm</button>
                    </div>
                </form>
            </div>
            <div class="text-end col-7">
                <a href="{{ route('admin.rank.create') }}" class="btn btn-success text-white text-end ms-3">Thêm cấp</a>
            </div>
        </div>

        @if (!empty($id))
            <h5 class='text-start mt-4 mb-4'>Cấp: <b>
                    @foreach ($ranks as $rank)
                        @if ($rank['id'] == $id)
                            {{ $rank['type'] }}
                        @endif
                    @endforeach
                </b></h5>
        @endif

        @if (!empty($point))
            <h5 class='text-start mt-4 mb-4'>Số điểm: <b>{{ $point == 'asc' ? 'Tăng dần' : 'Giảm dần' }}</b></h5>
        @endif


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
                        <td> {{ number_format($rank['point'], 0, '', '.') }} </td>
                        <td> {{ number_format($rank['discount'], 0, '', '.') }}% </td>
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

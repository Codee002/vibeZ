@extends('admin.layouts.admin')

@section('title')
    <title>Chọn sản phẩm nhập</title>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
    <link rel="stylesheet" href="{{ asset('css/config.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layouts.css') }}">
@endsection
{{-- @section('namePage', 'Danh sách nhập hàng') --}}

@section('content')
    <div class="container">
        @if (session('danger'))
            <div class="alert alert-danger">
                {{ session('danger') }}
            </div>
        @endif
        <h3 class="text-center fw-bolder ">Chọn sản phẩm nhập</h3>
        <form action="{{ route('admin.receipt.create') }}" class="col-12" style="margin: 3rem auto" method="get">
            @csrf
            <div class="order__info">
                <div class="row mb-4">
                    <div class="col-1"></div>
                    <div class="col-4">
                        <h5>Sản phẩm</h5>
                    </div>
                    <div class="col-2  d-flex justify-content-center">
                        <h5>Phân loại</h5>
                    </div>
                    <div class="col-2  d-flex justify-content-center">
                        <h5>Tổng kho</h5>
                    </div>
                    <div class="col-2  d-flex justify-content-center">
                        <h5>Kích thước</h5>
                    </div>

                </div>


                {{-- Thoong tin sản phẩm --}}
                @foreach ($data as $product)
                    <div class="order__info__product d-flex row">
                        <div class="col-1"></div>
                        @if ($product->images->isNotEmpty())
                            <div class="col-4 d-flex">
                                <div class="col-3 me-4">
                                    @if ($product->images[0] && \Storage::exists($product->images[0]->img_path))
                                        <img src="{{ asset(\Storage::url($product->images[0]->img_path)) }}" class=""
                                            alt="">
                                    @endif
                                </div>
                                <p class="col-9 d-flex justify-content-center align-items-center">{{ $product->name }}</p>
                            </div>
                        @endif
                        <div class="col-2 d-flex justify-content-center">
                            <p>{{ $product->category->name }}</p>
                        </div>

                        <div class="col-2 d-flex justify-content-center">
                            <p>{{ $product->getToTalWarehouse() }}</p>
                        </div>


                        @if ($product->sizes->count() > 0)
                            <div class="col-2 d-flex justify-content-center order__info__product__size">
                                <select multiple class="form-select multipleSelect" size="1"
                                    name="products[{{ $product->id }}][]">
                                    @foreach ($product->sizes as $size)
                                        <option class="hidden-options" value="{{ $size->pivot->size }}">
                                            {{ $size->pivot->size }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <div class="col-1 d-flex">
                            {{-- Radiao --}}
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="addProducts[]s"
                                    value="{{ $product->id }}">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mb-4">
                {{-- {{$data->links()}} --}}
            </div>

            <div class="form-group mb-3 d-flex" style="justify-content: end;">
                <a href="{{ route('admin.receipt.index') }}"
                    class="btn btn-secondary text-white text-decoration-none m-1">Hủy</a>
                <button type="submit" class="btn btn-primary text-white text-decoration-none m-1">Thêm</button>
            </div>
        </form>

    </div>
    <script>
        const selects = document.querySelectorAll('select[multiple]');
        selects.forEach(select => {
            select.addEventListener('click', () => {
                select.size = select.options.length;
            });

            select.addEventListener('blur', () => {
                select.size = 1;
            });
        });
    </script>
@endsection

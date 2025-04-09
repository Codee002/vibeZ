@extends('pages.layouts.layout')

@section('title')
    <title>Chỉnh sửa đánh giá</title>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/cart.css') }}">
    <link rel="stylesheet" href="{{ asset('css/product.css') }}">
    <link rel="stylesheet" href="{{ asset('css/evaluate.css') }}">
@endsection

@section('content')
    <main>
        <p class="title">Chỉnh sửa đánh giá</p>

        {{-- FLASH MESSAGE --}}
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


        {{-- {{ dd($listProductOrder) }} --}}
        <form action="{{ route('evaluate.update', [$order, $evaluate]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                {{-- Thoong tin sản phẩm --}}
                <div class="contentContainer col-3">
                    <a href="{{ route('product.detail', $evaluate->product['id']) }}">
                        @if ($evaluate->product->images[0]->img_path)
                            @if ($evaluate->product->images[0]->img_path && \Storage::exists($evaluate->product->images[0]->img_path))
                                <img src="{{ \Storage::url($evaluate->product->images[0]->img_path) }}" alt=""
                                    class="product_img">
                            @endif
                        @endif
                        <div class="productInfoContainer">
                            <p class="product_name">{{ $evaluate->product->name }}
                            </p>
                            <p class="product_category">{{ $evaluate->product->category->name }}
                            </p>
                            <p class="product_category">Size:
                                @foreach ($order->order_details as $temp)
                                    @if ($temp['product_id'] == $evaluate['product_id'])
                                        {{ $temp['size'] }}
                                    @endif
                                @endforeach
                            </p>
                        </div>
                    </a>
                </div>

                {{-- {{dd($errors)}} --}}

                <div class="contentContainer col-9">
                    <div class="form-group mb-2 row d-flex align-items-center
                         product-review"
                        data-product-id="{{ $evaluate->product['id'] }}">
                        <label for="rate">Số sao:</label>
                        <div class="star-rating d-flex align-items-center">
                            <span class="star" data-rating="1">★</span>
                            <span class="star" data-rating="2">★</span>
                            <span class="star" data-rating="3">★</span>
                            <span class="star" data-rating="4">★</span>
                            <span class="star" data-rating="5">★</span>
                            <input type="hidden" class="selected_rating" name="rating"
                                value="{{ old('rating', $evaluate['rate']) }}">
                            @error('rating')
                                <span class="invalid-feedback ms-3" style="display: block">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div>
                            <label for="rate">Đánh giá:</label>
                            <textarea id="" cols="30" rows="4" class="form-control mb-2" placeholder="Đánh giá" name="content">{{ old('content', $evaluate['content']) }}</textarea>
                        </div>

                        <div class="">
                            <label for="images">Ảnh đánh giá</label>
                            @if ($evaluate['image'])
                                <div class="form-group mb-3  d-flex row">
                                    <img id="{{ $evaluate->id }}" src="{{ \Storage::url($evaluate['image']) }}"
                                        alt="" style="height: 10rem; width: 9rem;" class="col-4">
                                    <div class="form-group col-7 p-3">
                                        <input id="imageInput" type="file" accept="image/*" name="image"
                                            class="form-control
                                               @error('image') is-invalid @enderror"
                                            onchange="previewImage({{ $evaluate->id }}, this)" value="">
                                        @error('image')
                                            <span class="invalid-feedback" style="display: block">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <div class="form-group mt-4 d-flex align-items-center">
                                            <button class="btn btn-secondary me-4" type="button"
                                                onclick="cancelImage({{ $evaluate->id }})">Hủy
                                                chọn</button>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="deleteImage"
                                                    value="true">
                                                <label class="form-check-label">Xóa ảnh</label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @else
                                <input type="file" accept="image/*" name="image"
                                    class="form-control images
                              @error('image') is-invalid @enderror" id="{{ $evaluate->id }}">
                                @error('image')
                                    <span class="invalid-feedback" style="display: block">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div class="form-group mb-3 mt-2 previewImages">
                                    <!-- Script in anh xem truoc -->
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Lựa chọn --}}
                <div class="row mt-3">
                    <div class="col-8"></div>
                    <div class="col-4 d-flex">
                        <div class="order__info__option d-flex justify-content-end">
                            <button class="btn" type="submit" id="btn-submit"
                                style="font-size: 1.2rem;font-weight: 700; color: var(--extra1-color)">Cập nhật</button>
                        </div>
                    </div>
                </div>
        </form>
    </main>
@endsection

<script>
    function previewImage(imageId, input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $("#" + imageId).attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function cancelImage(imageId) {
        $('#' + imageId).attr('src',
            '{{ URL::asset('storage/' . $evaluate->image) }}'); // Lấy đường dẫn ảnh cũ từ biến $image
        $('input[name="image"]').val(''); // Đặt lại giá trị của input file
    }
</script>

@section('js')
    <script src="/js/product.js"></script>
    <script src="{{ asset('js/evaluate.js') }}"></script>
@endsection

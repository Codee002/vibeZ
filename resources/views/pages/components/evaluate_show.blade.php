@extends('pages.layouts.layout')

@section('title')
    <title>Xem đánh giá đơn hàng</title>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/cart.css') }}">
    <link rel="stylesheet" href="{{ asset('css/product.css') }}">
    <link rel="stylesheet" href="{{ asset('css/evaluate.css') }}">
@endsection

@section('content')
    <main>
        <p class="title">Xem đánh giá</p>

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
        <div class="row">
            {{-- Thoong tin sản phẩm --}}
            @foreach ($order->evaluates as $detail)
                {{-- {{ dd($detail) }} --}}
                <div class="contentContainer col-3">
                    <a href="{{ route('product.detail', $detail->product['id']) }}">
                        @if ($detail->product->images[0]->img_path)
                            @if ($detail->product->images[0]->img_path && \Storage::exists($detail->product->images[0]->img_path))
                                <img src="{{ \Storage::url($detail->product->images[0]->img_path) }}" alt=""
                                    class="product_img">
                            @endif
                        @endif
                        <div class="productInfoContainer">
                            <p class="product_name">{{ $detail->product->name }}
                            </p>
                            <p class="product_category">{{ $detail->product->category->name }}
                            </p>
                            <p class="product_category">Size:
                                @foreach ($order->order_details as $temp)
                                    @if ($temp['product_id'] == $detail['product_id'])
                                        {{ $temp['size'] }}
                                    @endif
                                @endforeach
                            </p>
                        </div>
                    </a>
                </div>

                {{-- {{dd($errors)}} --}}

                <div class="contentContainer col-9 input-evaluates">
                    <div class="form-group mb-2 row d-flex align-items-center
                         product-review"
                        data-product-id="{{ $detail->product['id'] }}">
                        <label for="rate">Số sao:</label>
                        <div class="star-rating d-flex align-items-center">
                            <span class="star" data-rating="1">★</span>
                            <span class="star" data-rating="2">★</span>
                            <span class="star" data-rating="3">★</span>
                            <span class="star" data-rating="4">★</span>
                            <span class="star" data-rating="5">★</span>
                            <input type="hidden" class="selected_rating" name="ratings[{{ $detail->product['id'] }}]"
                                value="{{ old('ratings' . '.' . $detail->product['id'], $detail['rate']) }}">
                            @error('ratings' . '.' . $detail->product['id'])
                                <span class="invalid-feedback ms-3" style="display: block">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div>
                            <label for="rate">Đánh giá:</label>
                            <textarea id="" cols="30" rows="4" class="form-control mb-2" placeholder="Đánh giá" disabled
                                name="contents[{{ $detail->product['id'] }}]">{{ old('contents.' . $detail->product['id'], $detail['content']) }}</textarea>
                        </div>

                        <div class="">
                            <label for="images">Ảnh đánh giá</label>
                            @if ($detail['image'])
                                @if ($detail['image'] && \Storage::exists($detail['image']))
                                    <div>
                                        <a href="{{ \Storage::url($detail['image']) }}"><img
                                                src="{{ \Storage::url($detail['image']) }}" alt=""
                                                class="product_img ms-2" style="height: 9rem; width: 8rem;"></a>
                                    </div>
                                @endif
                            @else
                                <div>
                                    <i class="ms-3">(Không có ảnh đánh giá)</i>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Sửa --}}
                <div class="row mb-3 mt-1">
                    <div class="col-8"></div>
                    <div class="col-4 d-flex">
                        <div class="order__info__option d-flex justify-content-end">
                            <form action="{{ route('evaluate.edit', [$order, $detail]) }}">
                                <button class="btn" type="submit" id="btn-submit"
                                    style="font-size: 1.2rem;font-weight: 700; color: var(--extra1-color); width:100%">Sửa</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </main>
@endsection

<script>
    // Sao đánh giá
    document.addEventListener('DOMContentLoaded', function() {
        const productReviews = document.querySelectorAll('.product-review');
        productReviews.forEach(reviewContainer => {
            const stars = reviewContainer.querySelectorAll('.star-rating .star');
            const selectedRatingInput = reviewContainer.querySelector('.selected_rating');
            highlightStars(stars, parseInt(selectedRatingInput.value));
        });

        // Tô màu
        function highlightStars(starElements, rating) {
            starElements.forEach(star => {
                const starValue = parseInt(star.dataset.rating);
                if (starValue <= rating) {
                    star.classList.add('active');
                } else {
                    star.classList.remove('active');
                }
            });
        }
    });
</script>
@section('js')
    <script src="{{ asset('/js/product.js') }} "></script>
    <script src="{{ asset('js/cart.js') }}"></script>
@endsection

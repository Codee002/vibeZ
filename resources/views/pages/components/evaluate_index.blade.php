@extends('pages.layouts.layout')

@section('title')
    <title>Danh sách đánh giá</title>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
    <link rel="stylesheet" href="{{ asset('css/product.css') }}">
    <link rel="stylesheet" href="{{ asset('css/evaluate.css') }}">
@endsection

@section('content')
    <main>
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

        <div class="evaluate__container productPreviewContainer  mt-2">
            <h4 class="product-title" style="font-size: 1.2rem">
                @if ($countEvaluate != 0)
                    {{ $averageRate }} <span class="star active">★</span>
                @endif
                Đánh giá ({{ $countEvaluate }})
            </h4>
            {{-- <i class='bx bx-right-arrow-alt nav'></i> --}}

            <div class="product-content__info ">
                <div class="col-12 d-flex flex-column align-items-start product-evaluate">
                    @if ($product->evaluates->isNotEmpty())
                        @foreach ($product->evaluates as $evaluate)
                            <hr width="100%">
                            {{-- {{ dd($product->evaluates, $evaluate) }} --}}

                            <div style="width: 100%" class="d-flex align-items-center row">
                                <p class="col-2"></b><i class='bx bx-user'></i>:</b></p>
                                <p class="col-8"> {{ $evaluate->order->user['name'] }}</p>
                                <p class="col-2">
                                    {{ \Carbon\Carbon::parse($evaluate['updated_at'])->format('d/m/Y') }}
                                </p>
                            </div>

                            <div style="width: 100%" class="product-rate">
                                <div class="star-rating d-flex align-items-center row" style="width: 100%">
                                    <p class="col-2"><b>Số sao:</b></p>
                                    <div class="col-10">
                                        <span class="star" data-rating="1">★</span>
                                        <span class="star" data-rating="2">★</span>
                                        <span class="star" data-rating="3">★</span>
                                        <span class="star" data-rating="4">★</span>
                                        <span class="star" data-rating="5">★</span>
                                        <input type="hidden" class="selected_rating" value="{{ $evaluate['rate'] }}">

                                    </div>
                                </div>
                            </div>

                            <div style="width: 100%" class="d-flex align-items-center row mb-2">
                                <p class="col-2"><b>Đánh giá: </b></p>
                                <p class="col-10">{{ $evaluate['content'] ?? '(Không có nội dung)' }}
                                </p>
                            </div>

                            {{-- {{ dd($evaluate->order, $evaluate->order->order_details) }} --}}
                            <div style="width: 100%" class="d-flex align-items-center row mb-2">
                                <p class="col-2"><b>Size: </b></p>
                                <p class="col-10">
                                    @foreach ($evaluate->order->order_details as $temp)
                                        @if ($temp['product_id'] == $evaluate['product_id'])
                                            {{ $temp['size'] }}
                                        @endif
                                    @endforeach
                                </p>
                            </div>

                            <div class="row d-flex" style="width: 100%">
                                <p class="col-2"><b>Ảnh:</b></p>
                                @if ($evaluate['image'])
                                    @if ($evaluate['image'] && \Storage::exists($evaluate['image']))
                                        <a class="col-10" href="{{ \Storage::url($evaluate['image']) }}"><img
                                                src="{{ \Storage::url($evaluate['image']) }}" alt=""
                                                class="product_img ms-2" style="height: 9rem; width: 8rem;"></a>
                                    @endif
                                @else
                                    <p class="col-10">(Không có ảnh đánh giá)</p>
                                @endif
                            </div>
                        @endforeach
                        <hr width="100%">
                    @else
                        <div class="p-2 row" style="width:100%">
                            <div class="col-2"></div>
                            <p class="title col-7">(Sản phẩm chưa có đánh giá)</p>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </main>
@endsection
<style>
    .product-evaluate p {
        margin: 0
    }
</style>
<script>
    // Sao đánh giá
    document.addEventListener('DOMContentLoaded', function() {
        const productReviews = document.querySelectorAll('.product-rate');
        productReviews.forEach(reviewContainer => {
            const stars = reviewContainer.querySelectorAll('.star-rating .star');
            const selectedRatingInput = reviewContainer.querySelector('.selected_rating');
            highlightStars(stars, parseInt(selectedRatingInput.value));
            console.log(productReviews, reviewContainer, selectedRatingInput)
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
    <script src="{{ asset('/js/product.js') }}"></script>
@endsection

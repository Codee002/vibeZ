@extends('admin.layouts.admin')

@section('title')
    <title>Sửa sản phẩm</title>
@endsection

{{-- @section('namePage', 'Danh sách sản phẩm') --}}

@section('content')
    <div class="container">
        @if (session('danger'))
            <div class="alert alert-danger">
                {{ session('danger') }}
            </div>
        @endif
        <h2 class="text-center fw-bolder text-">Sửa sản phẩm</h2>
        <form action="{{ route('admin.product.update', $product) }}" class="col-8" style="margin: 50px auto" method="post"
            onsubmit="return confirm('Bạn chắc chắn muốn sửa sản phẩm này?')" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group mb-3">
                <label for="name">Tên sản phẩm</label>
                <input type="text" placeholder="Nhập vào tên sản phẩm" name="name" id="name"
                    class="form-control
                 @error('name') is-invalid @enderror" value="{{ $product->name }}">
                @error('name')
                    <span class="invalid-feedback" style="display: block">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="category">Danh mục sản phẩm</label>
                <select placeholder="Nhập vào danh mục sản phẩm" name="category" id="category"
                    class="form-select
             @error('category') is-invalid @enderror">
                    <option value="" disabled selected>Chọn danh mục sản phẩm</option>
                    @foreach ($categories as $id => $category)
                        <option @selected($product->category->id == $id) value="{{ $id }}">{{ $category }}</option>
                    @endforeach
                </select>
                @error('category')
                    <span class="invalid-feedback" style="display: block">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="sizes">Kích thước sản phẩm</label>
                <select placeholder="Nhập vào danh mục sản phẩm" name="sizes[]" id="sizes"
                    class="form-select
             @error('sizes') is-invalid @enderror" multiple>
                    @foreach ($sizes as $size)
                        <option @selected(in_array($size, $productSizes)) value="{{ $size }}">{{ $size }}</option>
                    @endforeach
                </select>
                @error('sizes')
                    <span class="invalid-feedback" style="display: block">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="des">Mô tả sản phẩm</label>
                <textarea type="text" placeholder="Nhập vào mô tả sản phẩm" name="des" id="des"
                    class="form-control
                 @error('des') is-invalid @enderror">{{ $product->des }}</textarea>
                @error('des')
                    <span class="invalid-feedback" style="display: block">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <label for="images">Ảnh sản phẩm</label>

            @if ($product->images->isNotEmpty()) 
                @foreach ($product->images as $image)
                    <div class="form-group mb-3  d-flex row">
                        <img id="{{ $image->id }}" src="{{ \Storage::url($image->img_path) }}" alt=""
                            width="100%" class="col-4">
                        <div class="form-group col-7 p-3">
                            <input type="file" accept="image/*" name="images[{{ $image->id }}]"
                                class="form-control
                 @error('images') is-invalid @enderror"
                                onchange="previewImage({{ $image->id }}, this)" value="">
                            @error('images')
                                <span class="invalid-feedback" style="display: block">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <div class="form-group mt-4 d-flex align-items-center">
                                <button class="btn btn-secondary me-4" type="button"
                                    onclick="cancelImage({{ $image->id }})">Hủy
                                    chọn</button>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="deleteImages[]"
                                        value="{{ $image->id }}">
                                    <label class="form-check-label">Xóa ảnh</label>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
            @endif
            <div class="form-group mb-3">
                <label for="images">Thêm ảnh cho sản phẩm sản phẩm</label>
                <input type="file" accept="image/*" name="addImages[]" id="images"
                    class="form-control
                 @error('images') is-invalid @enderror" multiple>
                @error('images')
                    <span class="invalid-feedback" style="display: block">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-3" id="previewImages">
                <!-- Script in anh xem truoc -->
            </div>

            <div class="form-group mb-3 d-flex" style="justify-content: end;">
                <a href="{{ route('admin.product.index') }}"
                    class="btn btn-secondary text-white text-decoration-none m-1">Hủy</a>
                <button type="submit" class="btn btn-primary text-white text-decoration-none m-1">Sửa</button>
            </div>
        </form>

    </div>

    <script>
        const imageInput = document.getElementById('images');
        const previewContainer = document.getElementById('previewImages');

        imageInput.addEventListener('change', function() {
            previewContainer.innerHTML = ''; // Xóa ảnh xem trước cũ

            const files = this.files;
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();

                reader.onload = function(event) {
                    const image = document.createElement('img');
                    image.src = event.target.result;
                    image.style.width = '7rem'; // Tùy chỉnh kích thước ảnh
                    previewContainer.appendChild(image);
                }

                reader.readAsDataURL(file);
            }
        });

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
                '{{ URL::asset('storage/' . $image->img_path) }}'); // Lấy đường dẫn ảnh cũ từ biến $image
            $('input[name="images[' + imageId + ']"]').val(''); // Đặt lại giá trị của input file
        }
    </script>
@endsection

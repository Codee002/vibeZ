@extends('admin.layouts.admin')

@section('title')
    <title>Thêm sản phẩm</title>
@endsection

{{-- @section('namePage', 'Danh sách sản phẩm') --}}

@section('content')
    <div class="container">
        @if (session('danger'))
            <div class="alert alert-danger">
                {{ session('danger') }}
            </div>
        @endif
        <h2 class="text-center fw-bolder text-">Thêm sản phẩm</h2>
        <form action="{{ route('admin.product.store') }}" class="col-8" style="margin: 50px auto" method="POST"
            onsubmit="return confirm('Bạn chắc chắn muốn thêm sản phẩm này?')" enctype="multipart/form-data">
            @csrf

            <div class="form-group mb-3">
                <label for="name">Tên sản phẩm</label>
                <input type="text" placeholder="Nhập vào tên sản phẩm" name="name" id="name"
                    class="form-control
                 @error('name') is-invalid @enderror" value="{{ old('name') }}">
                @error('name')
                    <span class="invalid-feedback" style="display: block">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="buying_price">Giá mua</label>
                <input type="text" placeholder="Nhập vào giá mua" name="buying_price" id="buying_price"
                    class="form-control
                 @error('buying_price') is-invalid @enderror"
                    value="{{ old('buying_price') }}">
                @error('buying_price')
                    <span class="invalid-feedback" style="display: block">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>


            <div class="form-group mb-3">
                <label for="selling_price">Giá bán</label>
                <input type="text" placeholder="Nhập vào giá bán" name="selling_price" id="selling_price"
                    class="form-control
                 @error('selling_price') is-invalid @enderror"
                    value="{{ old('selling_price') }}">
                @error('selling_price')
                    <span class="invalid-feedback" style="display: block">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>


            <div class="form-group mb-3">
                <label for="category">Danh mục sản phẩm</label>
                <select placeholder="Nhập vào danh mục sản phẩm" name="category" id="category"
                    class="form-select
             @error('category') is-invalid @enderror" value="{{ old('category') }}">
                    <option value="" disabled selected>Chọn danh mục sản phẩm</option>
                    @foreach ($categories as $id => $category)
                        <option value="{{ $id }}">{{ $category}}</option>
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
                        <option value="{{ $size}}">{{ $size }}</option>
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
                 @error('des') is-invalid @enderror">{{ old('des') }}</textarea>
                @error('des')
                    <span class="invalid-feedback" style="display: block">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="images">Ảnh sản phẩm</label>
                <input type="file" accept="image/*" name="images[]" id="images"
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
                <button type="submit" class="btn btn-primary text-white text-decoration-none m-1">Thêm</button>
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
                    image.style.width = '10rem'; // Tùy chỉnh kích thước ảnh
                    previewContainer.appendChild(image);
                }

                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection

@extends('admin.layouts.admin')

@section('title')
    <title>Giao diện hệ thống</title>
@endsection

{{-- @section('namePage', 'Danh sách sản phẩm') --}}

@section('content')
    <div class="container">
        @if (session('danger'))
            <div class="alert alert-danger">
                {{ session('danger') }}
            </div>
        @endif
        <h2 class="text-center fw-bolder text-">Giao diện hệ thống</h2>
        <form action="{{ route('admin.general.store') }}" class="col-8" style="margin: 50px auto" method="post"
            onsubmit="return confirm('Bạn chắc chắn muốn cập nhật ảnh?')" enctype="multipart/form-data">
            @csrf

            {{-- {{ dd($general) }} --}}
            <div class="form-group mb-3">
                <label for="banner">Banner</label>
                <input type="file" accept="image/*" name="banner"
                    class="form-control images
                 @error('banner') is-invalid @enderror">
                @error('banner')
                    <span class="invalid-feedback" style="display: block">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                @if ($general['banner'] && \Storage::exists($general['banner']))
                    <img class="mt-3" src="{{ \Storage::url($general['banner']) }}" alt="" style="width: 100%;">
                @endif
            </div>

            <div class="form-group mb-3 mt-3">
                <label for="logo_header">Logo header</label>
                <input type="file" accept="image/*" name="logo_header"
                    class="form-control images
                 @error('logo_header') is-invalid @enderror">
                @error('logo_header')
                    <span class="invalid-feedback" style="display: block">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                @if ($general['logo_header'] && \Storage::exists($general['logo_header']))
                    <div class="d-flex justify-content-center">
                        <img class="mt-3" src="{{ \Storage::url($general['logo_header']) }}" alt=""
                            style="height: 5rem;">
                    </div>
                @endif
            </div>

            <div class="form-group mb-3 mt-3">
                <label for="logo_footer">Logo Footer</label>
                <input type="file" accept="image/*" name="logo_footer"
                    class="form-control  images
                 @error('logo_footer') is-invalid @enderror">
                @error('logo_footer')
                    <span class="invalid-feedback" style="display: block">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                @if ($general['logo_footer'] && \Storage::exists($general['logo_footer']))
                    <div class="d-flex justify-content-center">
                        <img class="mt-3" src="{{ \Storage::url($general['logo_footer']) }}" alt=""
                            style="height: 7rem;">
                    </div>
                @endif
            </div>

            <div class="form-group mb-3 mt-3">
                <label for="login">Login</label>
                <input type="file" accept="image/*" name="login"
                    class="form-control images
                 @error('login') is-invalid @enderror">
                @error('login')
                    <span class="invalid-feedback" style="display: block">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                @if ($general['login'] && \Storage::exists($general['login']))
                    <div class="d-flex justify-content-center">
                        <img class="mt-3 w-50" src="{{ \Storage::url($general['login']) }}" alt="" width="50rem">
                    </div>
                @endif
            </div>

            <div class="form-group mb-3 mt-3">
                <label for="register">Register</label>
                <input type="file" accept="image/*" name="register"
                    class="form-control images
                 @error('register') is-invalid @enderror">
                @error('register')
                    <span class="invalid-feedback" style="display: block">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                @if ($general['register'] && \Storage::exists($general['register']))
                    <div class="d-flex justify-content-center">
                        <img class="mt-3 w-50" src="{{ \Storage::url($general['register']) }}" alt=""
                            width="50rem">
                    </div>
                @endif
            </div>

            <div class="form-group mb-3 d-flex" style="justify-content: end;">
                <a href="{{ route('admin.general.index') }}"
                    class="btn btn-secondary text-white text-decoration-none m-1">Hủy</a>
                <button type="submit" class="btn btn-primary text-white text-decoration-none m-1">Cập nhật</button>
            </div>
        </form>

    </div>

    <script>
        const imageInput = document.querySelectorAll('.images');
        console.log(imageInput)
        const previewContainer = document.getElementById('previewImages');

        imageInput.forEach(input => {
            input.addEventListener('change', function() {
                image = input.parentElement.querySelector("img")
                console.log(image)
                const files = this.files;
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    const reader = new FileReader();

                    reader.onload = function(event) {
                        image.src = event.target.result;
                    }

                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
@endsection

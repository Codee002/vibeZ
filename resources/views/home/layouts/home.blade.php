<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Link Boostrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"
        integrity="sha384-4LISF5TTJX/fLmGSxO53rV4miRxdg84mZsxmO8Rx5jGtp/LbrixFETvWa5a6sESd" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">


    {{-- Link Config CSS  --}}
    <link rel="stylesheet" href="css/config.css?ver=3">

    {{-- Link My CSS  --}}
    <link rel="stylesheet" href="css/layouts.css?ver=2">
    {{-- Title --}}
    @yield('title')
    <!-- LINK ICON -->
    <link rel="shortcut icon" href="assets/images/logo/7.png">
    {{-- Title --}}
    @yield('title')
</head>

<body>
    @include("home.partials.header")
    <div class="container">
        @yield("content")
        <div class="h-100 bg-primary w-100"></div>
    </div>
    @include("home.partials.footer")
</body>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/layouts.js"></script>
</html>

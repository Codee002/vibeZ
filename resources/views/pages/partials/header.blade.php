<!----------------------- Header  ----------------------------->
<header>
    <div class="search-container">

        <!----------------------- Sidebar ----------------------------->
        @include('pages.partials.sidebar')
        <!----------------------- Sidebar End ----------------------------->


        <!------- Logo ------->
        <div class="logo">
            <a href="{{ route('home') }}"><img src="/assets/images/logo/11-format.png" alt="" id="logo">
                <img id="house" src="/asse/logo/15.png" alt=""></a>
        </div>

        <!------- Search ------->
        <div class="inputSearch">
            <form method="get" action="/_timkiem/timkiem.html" id="frmSearch" onsubmit="return frmValidate()">
                <input name="input" type="text" placeholder="Tìm kiếm" id="TimKiem">
                <button title="Tìm kiếm" id="TimKiembtn" type="submit"><i class='bx bx-search-alt'></i></button>
            </form>

            {{-- <div class="convenient">
                <i class='bx bxs-bell'></i>
                <i class='bx bxs-chat'></i>
            </div> --}}

        </div>

        <!------- User ------->
        <div class="user ">
            <div class="user_Lover_container">
                <a href="{{ route('cart') }}"><i class='bx bxs-cart-alt' id="user_Love"></i>Giỏ hàng</a>
            </div>

            <div>
                <a href="{{ route('login') }}"> <i class='bx bxs-user'></i>Tài khoản</a>
            </div>
        </div>
    </div>
</header>
<!----------------------- Header end ----------------------------->

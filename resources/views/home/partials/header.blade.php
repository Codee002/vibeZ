<!----------------------- Header  ----------------------------->
<header>
    <div class="search-container">

        <!----------------------- Sidebar ----------------------------->
       @include("home.partials.sidebar")
        <!----------------------- Sidebar End ----------------------------->


        <!------- Logo ------->
        <div class="logo">
            <a href=""><img src="/assets/images/logo/11-format.png" alt="" id="logo">
                <img id="house" src="/header_img/logo/house.png" alt=""></a>
        </div>

        <!------- Search ------->
        <div class="inputSearch">
            <form method="get" action="/_timkiem/timkiem.html" id="frmSearch" onsubmit="return frmValidate()">
                <input name="input" type="text" placeholder="Tìm kiếm" id="TimKiem">
                <button title="Tìm kiếm" id="TimKiembtn" type="submit"><i class='bx bx-search-alt'></i></button>
            </form>

            <div class="convenient">
                <i class='bx bxs-bell'></i>
                <i class='bx bxs-chat'></i>
            </div>

        </div>

        <!------- User ------->
        <div class="user ">
            <div class="user_Lover_container">
                <a href="/_yeuthich/yeuthich.html"><i class='bx bxs-heart' id="user_Love"></i>Yêu thích</a>
            </div>

            <div>
                <a href="/_dangnhap/dangnhap.html"> <i class='bx bxs-user'></i>Tài khoản</a>
            </div>
        </div>
    </div>
</header>
<!----------------------- Header end ----------------------------->

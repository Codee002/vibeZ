<div class="sidebar">
    <i id="menu_active"></i>
    <div class="menusidebar" id="menusidebar">
        <div class="info">
            <img src="" alt=""> <!-- Không thêm hình ở đây -->
        </div>
        <ul class="nav-menu">
            <a href="{{ route('home') }}">
                <li class="">
                    <i class='bx bxs-home'></i>
                    <span>Trang chủ</span>
                </li>
            </a>

            <a href="{{ route('product') }}">
                <li>
                    <i class='bx bxs-food-menu'></i>
                    <span>Sản phẩm</span>
                </li>
            </a>

            <a href="{{ route('cart') }}">
                <li>
                    <i class='bx bxs-cart-alt'></i>
                    <span>Giỏ hàng</span>
                </li>
            </a>


            <a href="">
                <li>
                    <i class='bx bxs-cog'></i>
                    <span>Cài đặt</span>
                </li>
            </a>

            <a href="">
                <li>
                    <i class='bx bx-support'></i>
                    <span>Hỗ trợ</span>
                </li>
            </a>

            <a href="">
                <li class="end">
                    <i class='bx bxs-log-out'></i>
                    <span>Đăng xuất</span>
                </li>
            </a>
    </div>
</div>

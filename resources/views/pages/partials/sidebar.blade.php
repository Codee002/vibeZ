<div class="sidebar">
    <i id="menu_active"></i>
    <div class="menusidebar" id="menusidebar">
        <div class="info">
            <img src="" alt=""> <!-- Không thêm hình ở đây -->
        </div>
        <ul class="nav-menu">
            <a href="{{ route('home') }}" @if (request()->is('home*')) class="active" @endif>
                <li class="">
                    <i class='bx bxs-home'></i>
                    <span>Trang chủ</span>
                </li>
            </a>

            <a href="{{ route('product') }}" @if (request()->is('product*')) class="active" @endif>
                <li>
                    <i class='bx bxs-food-menu'></i>
                    <span>Sản phẩm</span>
                </li>
            </a>

            @if (Auth::check())
                <a href="{{ route('cart') }}" @if (request()->is('cart*')) class="active" @endif>
                    <li>
                        <i class='bx bxs-cart-alt'></i>
                        <span>Giỏ hàng</span>
                    </li>
                </a>

                <a href="{{ route('order.history') }}" @if (request()->is('order/history*')) class="active" @endif>
                    <li>
                        <i class='bx bxs-package'></i>
                        <span>Đơn đã mua</span>
                    </li>
                </a>

                <a href="{{ route('contact') }}" @if (request()->is('contact*')) class="active" @endif>
                    <li>
                        <i class='bx bx-support'></i>
                        <span>Liên hệ</span>
                    </li>
                </a>

                <a href="{{ route('setting.info') }}" @if (request()->is('setting/info*')) class="active" @endif>
                    <li>
                        <i class='bx bxs-user'></i>
                        <span>Tài khoản</span>
                    </li>
                </a>

                <a href="{{ route('setting.security') }}" @if (request()->is('setting/security*')) class="active" @endif>
                    <li>
                        <i class='bx bxs-cog'></i>
                        <span>Bảo mật</span>
                    </li>
                </a>

                <a href="{{ route('logout') }}" @if (request()->is('logout*')) class="active" @endif>
                    <li class="end">
                        <i class='bx bxs-log-out'></i>
                        <span>Đăng xuất</span>
                    </li>
                </a>
            @else
                <a href="{{ route('logout') }}" @if (request()->is('login*')) class="active" @endif>
                    <li class="end">
                        <i class='bx bxs-log-in'></i>
                        <span>Đăng nhập</span>
                    </li>
                </a>
            @endif
    </div>
</div>

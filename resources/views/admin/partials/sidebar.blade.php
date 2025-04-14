      <!--begin::Sidebar-->
      <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
          <!--begin::Sidebar Brand-->
          <div class="sidebar-brand">
              <!--begin::Brand Link-->
              <a href="./index.html" class="brand-link">
                  <!--begin::Brand Text-->
                  <span class="brand-text fw-light">Quản lý</span>
                  <!--end::Brand Text-->
              </a>
              <!--end::Brand Link-->
          </div>
          <!--end::Sidebar Brand-->

          <!--begin::Sidebar Wrapper-->
          <div class="sidebar-wrapper">
              <nav class="mt-2">
                  <!--begin::Sidebar Menu-->
                  <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu"
                      data-accordion="false">

                      {{-- Giao diện --}}
                      <li class="nav-header">Quản lý giao diện</li>
                      <li class="nav-item">
                          <a href="#" class="nav-link ">
                              <i class='bx bxs-cog'></i>
                              <p>
                                  Tùy chỉnh giao diện
                                  <i class="nav-arrow bi bi-chevron-right"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="./UI/general.html" class="nav-link">
                                      <p>Banner</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="./UI/icons.html" class="nav-link">
                                      <p>Sản phẩm nổi bật</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="./UI/icons.html" class="nav-link">
                                      <p>Thông tin liên lạc</p>
                                  </a>
                              </li>
                          </ul>
                      </li>

                      {{-- Tài Khoản --}}
                      <li class="nav-header">Tài khoản</li>
                      <li class="nav-item">
                          <a href="{{ route('admin.account.index') }}" class="nav-link">
                              <i class='bx bxs-user'></i>
                              <p>
                                  Người dùng
                              </p>
                          </a>
                      </li>
                      <li class="nav-item">
                        <a href="{{ route('admin.rank.index') }}" class="nav-link">
                            <i class='bx bxs-diamond'></i>
                            <p>
                                Cấp tài khoản
                            </p>
                        </a>
                    </li>

                      {{-- Sản phẩm --}}
                      <li class="nav-header">Sản phẩm</li>
                      {{-- Nhà cung cấp --}}
                      <li class="nav-item">
                        <a href="{{ route('admin.distributor.index') }}" class="nav-link">
                          <i class='bx bxl-mastercard'></i>
                            <p>
                                Nhà cung cấp
                            </p>
                        </a>
                    </li>

                      <li class="nav-item">
                          <a href="{{ route('admin.product.index') }}" class="nav-link">
                              <i class='bx bxs-food-menu'></i>
                              <p>
                                  Sản phẩm
                              </p>
                          </a>
                      </li>

                      {{-- Danh mục --}}
                      <li class="nav-item">
                          <a href="{{ route('admin.category.index') }}" class="nav-link">
                              <i class='bx bxs-category'></i>
                              <p>
                                  Danh mục
                              </p>
                          </a>
                      </li>

                      {{-- Kho --}}
                      <li class="nav-header">Kho hàng</li>
                      <li class="nav-item">
                          <a href="{{ route('admin.warehouse.index') }}" class="nav-link">
                              <i class='bx bxs-home-alt-2'></i>
                              <p>
                                  Kho hàng
                              </p>
                          </a>
                      </li>

                      {{-- Nhập hàng --}}
                      <li class="nav-item">
                          <a href="{{ route('admin.receipt.index') }}" class="nav-link">
                              <i class='bx bx-import'></i>
                              <p>
                                  Phiếu nhập
                              </p>
                          </a>
                      </li>

                      {{-- Thống kê --}}
                      <li class="nav-item">
                          <a href="#" class="nav-link">
                              <i class='bx bxs-chart'></i>
                              <p>
                                  Thống kê
                                  <i class="nav-arrow bi bi-chevron-right"></i>
                              </p>
                          </a>

                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('admin.statistical.index') }}" class="nav-link">
                                      <p>Sản phẩm</p>
                                  </a>
                              </li>

                              <li class="nav-item">
                                  <a href="{{ route('admin.statistical.revenue') }}" class="nav-link">
                                      <p>Doanh thu</p>
                                  </a>
                              </li>

                              {{-- <li class="nav-item">
                                  <a href="{{ route('admin.statistical.revenue') }}" class="nav-link">
                                      <p>Doanh thu theo tháng</p>
                                  </a>
                              </li> --}}
                          </ul>
                      </li>

                      {{-- Đơn hàng --}}
                      <li class="nav-header">Đơn hàng</li>
                      <li class="nav-item">
                          <a href="{{ route('admin.order.index') }}" class="nav-link">
                              <i class='bx bxs-package'></i>
                              <p>
                                  Đơn hàng
                              </p>
                          </a>
                      </li>

                      {{-- Khuyến mãi --}}
                      <li class="nav-item">
                          <a href="{{ route('admin.discount.index') }}" class="nav-link">
                              <i class='bx bxs-discount'></i>
                              <p>
                                  Khuyến mãi
                              </p>
                          </a>
                      </li>

                      {{-- Phương thức thanh toán --}}
                      <li class="nav-item">
                          <a href="{{ route('admin.payment_method.index') }}" class="nav-link">
                              <i class='bx bxs-home-alt-2'></i>
                              <p>
                                  Phương thức thanh toán
                              </p>
                          </a>
                      </li>



                  </ul>
                  <!--end::Sidebar Menu-->
              </nav>
          </div>
          <!--end::Sidebar Wrapper-->
      </aside>
      <!--end::Sidebar-->

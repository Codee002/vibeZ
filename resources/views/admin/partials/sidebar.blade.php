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
                      <li class="nav-header">Tài khoản người dùng</li>
                      <li class="nav-item">
                          <a href="#" class="nav-link">
                              <i class='bx bxs-user'></i>
                              <p>
                                  Khách hàng
                                  <i class="nav-arrow bi bi-chevron-right"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="./UI/general.html" class="nav-link">
                                     
                                      <p>Danh sách tài khoản</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="./UI/icons.html" class="nav-link">
                                     
                                      <p>Tài khoản bị khóa</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="./UI/timeline.html" class="nav-link">
                                     
                                      <p>Khách hàng thân quen</p>
                                  </a>
                              </li>
                          </ul>
                      </li>

                      {{-- Kho --}}
                      <li class="nav-header">Kho hàng</li>
                      <li class="nav-item">
                          <a href="#" class="nav-link">
                              <i class='bx bxs-home-alt-2'></i>
                              <p>
                                  Kho
                                  <i class="nav-arrow bi bi-chevron-right"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{route("admin.warehouse.create")}}" class="nav-link">
                                     
                                      <p>Thêm kho</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{route("admin.warehouse.index")}}" class="nav-link">
                                     
                                      <p>Danh sách các kho</p>
                                  </a>
                              </li>
                          </ul>
                      </li>

                      {{-- Danh mục --}}
                      <li class="nav-header">Danh mục sản phẩm</li>
                      <li class="nav-item">
                          <a href="#" class="nav-link">
                              <i class='bx bxs-category'></i>
                              <p>
                                  Danh mục
                                  <i class="nav-arrow bi bi-chevron-right"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href=" {{route("admin.category.create")}} " class="nav-link">
                                      <p>Thêm danh mục</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{route("admin.category.index")}}" class="nav-link">
                                      <p>Danh sách danh mục</p>
                                  </a>
                              </li>
                          </ul>
                      </li>

                      {{-- Sản phẩm --}}
                      <li class="nav-header">Sản phẩm</li>
                      <li class="nav-item">
                          <a href="#" class="nav-link">
                              <i class='bx bxs-food-menu'></i>
                              <p>
                                  Sản phẩm
                                  <i class="nav-arrow bi bi-chevron-right"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{route("admin.product.create")}}" class="nav-link">
                                     
                                      <p>Thêm sản phẩm</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{route("admin.product.index")}}" class="nav-link">
                                     
                                      <p>Danh sách sản phẩm</p>
                                  </a>
                              </li>
                          </ul>
                      </li>

                      {{-- Khuyến mãi --}}
                      <li class="nav-header">Chương trình khuyến mãi</li>
                      <li class="nav-item">
                          <a href="#" class="nav-link">
                              <i class='bx bxs-discount'></i>
                              <p>
                                  Khuyến mãi
                                  <i class="nav-arrow bi bi-chevron-right"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="./UI/general.html" class="nav-link">
                                     
                                      <p>Thêm khuyến mãi</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="./UI/icons.html" class="nav-link">
                                     
                                      <p>Danh sách khuyến mãi</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="./UI/icons.html" class="nav-link">
                                     
                                      <p>Khuyến mãi đang áp dụng</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="./UI/icons.html" class="nav-link">
                                     
                                      <p>Khuyến mãi đã hết hạn</p>
                                  </a>
                              </li>
                          </ul>
                      </li>

                      {{-- Đơn hàng --}}
                      <li class="nav-header">Đơn hàng</li>
                      <li class="nav-item">
                          <a href="#" class="nav-link">
                              <i class='bx bxs-package'></i>
                              <p>
                                  Đơn hàng
                                  <i class="nav-arrow bi bi-chevron-right"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="./UI/general.html" class="nav-link">
                                     
                                      <p>Xem danh sách đơn hàng</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="./UI/icons.html" class="nav-link">
                                     
                                      <p>Đơn hàng hiện có</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="./UI/icons.html" class="nav-link">
                                     
                                      <p>Đơn trả về</p>
                                  </a>
                              </li>
                          </ul>
                      </li>

                      {{-- Nhập hàng --}}
                      <li class="nav-header">Nhập hàng</li>
                      <li class="nav-item">
                          <a href="#" class="nav-link">
                            <i class='bx bx-import' ></i>
                              <p>
                                  Nhập hàng
                                  <i class="nav-arrow bi bi-chevron-right"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="./UI/general.html" class="nav-link">
                                     
                                      <p>Tạo phiếu nhập</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="./UI/icons.html" class="nav-link">
                                     
                                      <p>Danh sách phiếu nhập</p>
                                  </a>
                              </li>
                          </ul>
                      </li>
                  </ul>
                  <!--end::Sidebar Menu-->
              </nav>
          </div>
          <!--end::Sidebar Wrapper-->
      </aside>
      <!--end::Sidebar-->

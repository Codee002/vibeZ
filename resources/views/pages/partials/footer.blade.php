 <!----------------------- Footer Start ----------------------------->
 <footer>
     <div class="footer-container">
         <div class="footer-head">
             <a href="#logo">
                 <div class="card-title">
                     <h3>VIBEZ</h3>
                 </div>
             </a>

             <div class="footer-logo">
                 <i class='bx bxl-facebook-circle'></i>
                 <i class='bx bxl-twitter'></i>
                 <i class='bx bxl-google'></i>
                 <i class='bx bxl-instagram-alt'></i>
                 <i class='bx bxl-github'></i>
             </div>
         </div>
         <hr>

         <div class="footer-main">
             <div class="card-title">
                 <h4>SHOP GIÀY GIÁ RẺ</h4>
                 <h5>Chất lượng hàng đầu Việt Nam</h5>
                 {{-- <img src="/assets/images/logo/12-format.png" alt=""> --}}
                 <img src="{{ \Storage::url(\App\Models\GeneralImage::getFooter()) }}" alt="">
             </div>
             <div class="thongtinll">
                 <h4>Địa chỉ liên hệ</h4>
                 <p><i class='bx bxs-home-alt-2'></i> Ấp Hòa Đức, xã Hòa An, huyện Phụng Hiệp,<br> tình Hậu Giang</p>
                 <p><i class='bx bxl-gmail'></i> phucb2205955@student.ctu.edu.vn</p>
                 <p><i class='bx bxs-phone'></i> Hotline: 0918242085</p>
             </div>
             <div class="chungnhan">
                 <h4>Chứng nhận</h4>
                 <img src="/header_img/footer/cerfiticate.png" alt="">
                 <p>Giấy phép số: 429/GP-BTTTT do Bộ <br> TTTT cấp ngày 11/10/2019</p>
             </div>
         </div>
         <hr>
         <div class="footer-end">
             <h4>&copy 2025 Copyright: <a href="">vibeZ.com</a></h4>
         </div>
     </div>
     <a href="#">
         <div class="ToTop" id="totop">
             <i class='bx bxs-to-top'></i>
         </div>
     </a>
 </footer>
 <!----------------------- Footer End ----------------------------->

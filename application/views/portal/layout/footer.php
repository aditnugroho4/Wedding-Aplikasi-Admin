<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="logo">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="logo__carousel owl-carousel">
                    <div class="logo__item">
                        <a href="https://akbargrup.id/services">
                            <img width="114" height="69" class="lazyload" data-src="<?php echo base_url('asset/portal/')?>img/logo-carousel/Emua-Logo.png" alt="Emua Makeup">
                        </a>
                    </div>
                    <div class="logo__item">
                        <a href="https://akbargrup.id/services">
                            <img width="114" height="69" class="lazyload" data-src="<?php echo base_url('asset/portal/')?>img/logo-carousel/De-logo.png" alt="Odie Dekor"/>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<footer class="footer">
    <div class="container">
        <div class="footer__top">
            <div class="row">
                <div class="col-lg-8 col-md-6">
                    <div class="footer___subscribe">
                        <div class="footer__subscribe__text">
                            <h4>Newsletter Subscribe</h4>
                            <p>Login Dan Dapatkan Penawaran Menarik..!</p>
                        </div>
                        <div class="footer__subscribe__form">
                            <label for="txt_email"></label>
                            <form id="post_newslate">
                                <input type="email" id="txtEmailNewslater" placeholder="Email">
                                <button type="submit" id="bntNewslate"><i class="fa fa-send-o"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="footer__social">
                        <a href="https://www.instagram.com/akbargrup/" target="_blank" rel="nofollow"><i
                                class="fa fa-instagram"></i></a>
                        <a href="https://www.youtube.com/channel/UCGGJ01l-Nmq52VxOt5uFKsw" target="_blank"
                            rel="nofollow"><i class="fa fa-youtube-play"></i></a>
                        <a href="https://www.facebook.com/akbargrup" target="_blank" rel="nofollow"><i
                                class="fa fa-facebook"></i></a>
                        <a href="https://twitter.com/akbar_grup" target="_blank" rel="nofollow"><i
                                class="fa fa-twitter"></i></a>
                        <a href="https://api.whatsapp.com/send?phone=+6285780555092&text=Hallo%20Akbar%20Grup..%20%20Saya%20ingin%20mengajukan%20Pertanyaan%20tolong%20berikan%20kemudahan%20kepada%20saya%20..?"
                            target="_blank" rel="nofollow"><i class="fa fa-whatsapp"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="footer__logo">
                    <a href="<?= base_url();?>"><img width="267" height="73"
                    class="lazyload" data-src="<?php echo base_url(); ?>asset/portal/img/logo-footer.png"
                            alt="Akbar Group Wedding Organizer"></a>
                </div>
                <div class="footer__widget">
                    <h5>Tentang Kami</h5>
                    <p>Akbar Grup Kami bergerak dibidang jasa Wedding Organizer dan Event Organizer serta menyewakan
                        perlengkapan pesta ( tenda, kursi, panggung, dekorasi, mc, musik, catering, dan upacara adat )
                    </p>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="footer__widget">
                    <h5>Jam Buka Gallery</h5>
                    <ul>
                        <li>Senin 08.00–17.00</li>
                        <li>Selasa Libur</li>
                        <li>Rabu 08.00–17.00</li>
                        <li>Kamis 08.00–17.00</li>
                        <li>Jumat 08.00–17.00</li>
                        <li>Sabtu 08.00–17.00</li>
                        <li>Minggu 08.00–17.00</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="footer__widget">
                    <h5>Phone & whatsapp</h5>
                    <ul>
                        <li><a href="https://api.whatsapp.com/send?phone=+6285780555092&text=Hallo%20Akbar%20Grup..%20%20Saya%20ingin%20mengajukan%20Pertanyaan%20tolong%20berikan%20kemudahan%20kepada%20saya%20..?"
                                target="_blank" rel="nofollow">+62 857-8055-5092</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="footer__widget">
                    <h5>Alamat Gallery</h5>
                    <a href="https://g.page/akbargrup?share" target="_blank" rel="nofollow">
                        <p>Jl. Karadenan No.30, Karadenan, Cibinong, Bogor, Jawa Barat 16913</p>
                    </a>
                </div>
            </div>
        </div>
        <div class="footer__copyright">
            <div class="row">
                <div class="col-lg-7 col-md-7">
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    <p class="footer__copyright__text">Copyright &copy; 2021 All rights reserved <i
                            class="fa fa-heart-o" aria-hidden="true"></i> by <a href="<?= base_url('home');?>"
                            target="_blank" rel="nofollow">Akbar Grup</a>
                    </p>
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                </div>
                <div class="col-lg-5 col-md-5">
                    <ul class="footer__copyright__widget">
                        <li>Terms & Use</li>
                        <li><a href="<?= base_url('blog');?>" target="_blank" rel="nofollow">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
<div class="search-model">
    <div class="h-100 d-flex align-items-center justify-content-center">
        <div class="search-close-switch"><i class="icon_close"></i></div>
        <form id="src-content" class="search-model-form">
            <input type="text" id="search-input" placeholder="Search here.....">
        </form>
    </div>
</div>
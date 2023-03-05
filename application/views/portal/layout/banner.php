<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<script >
    $(document).ready(function () {
        $(".banner__item__pic__slider").owlCarousel({
            items: 1,
            itemsDesktop: [1199, 5],
            itemsDesktopSmall: [980, 5],
            itemsTablet: [768, 5],
            itemsTabletSmall: [550, 2],
            itemsMobile: [480, 2],
            loop: true,
            nav: true,
            dots: false,
            navText: ["<span class='arrow_carrot-left'></span>","<span class='arrow_carrot-right'></span>"],
            autoplay: true,
            autoplayTimeout: 10000,
            smartSpeed: 120,
            margin: 30,
            stagePadding: 10,
            animateIn: 'animate__backInDown',
        });
    });
</script>
<section class="hero set-bg" data-setbg="<?= base_url('asset/portal/')?>img/bg-ag-min.png">
    <div class="container-fluid">
            <div class="banner__item__pic__slider owl-carousel">
                <div class="item active">
                    <div class="row">
                        <div class="col-lg-8 col-sm-12">
                            <div class="hero__text">
                            <div class="img_1">
                                <img class="animate__animated animate__zoomIn lazyload" width="61" height="51"data-src="<?= base_url('asset/portal/img/icon/akbar-group.png')?>"
                                    alt="Wedding Planner" /></div>
                                <div class="img_2">
                                <img width="61" height="51" class="lazyload" data-src="<?= base_url('asset/portal/img/icon/logo-hi.png')?>"
                                    alt="Wedding Organizer" /></div>
                                <h1>Wedding Organizer & Catering</h1>
                                <h2 class="animate__animated animate__lightSpeedInRight">Wujudkan Moment Kebahagian
                                    Pernikhaan Anda Bersama Kami Akbar Grup</h2>
                                <p>Jasa Wedding Organizer, Catering Bogor, Sewa Tenda Dan Dekorasi </p>
                                <a class="btn btn-secondary text-white btn-sm" href="https://api.whatsapp.com/send?phone=+6285780555092&text=Hallo%20Akbar%20Grup..%20%20Saya%20ingin%20mengajukan%20Pertanyaan%20tolong%20berikan%20kemudahan%20kepada%20saya%20..?"
                                        target="_blank" rel="nofollow">
                                <i class="fa fa-whatsapp"></i> Hubungi Kami</a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <div class="hero__text__logo">
                                <img class="animate__animated animate__zoomIn lazyload" width="557" height="557"
                                data-src="<?= base_url('asset/portal/img/about/about.png')?>" alt="Wedding Foto" />
                            </div>
                        </div>
                    </div>
                </div>
                <?php if($banner){ foreach($banner['data'] as $i=> $value){?>
                <div class="item">
                    <div class="row">
                        <div class="col-lg-8 col-sm-12">
                            <div class="hero__text">
                                <div class="img_1">
                                <img class="animate__animated animate__zoomIn lazyload" width="61" height="51"
                                    data-src="<?= base_url('asset/images/blog/').$value['Img']; ?>"
                                    alt="<?= $value['Ctgr']?>"/></div>
                                <div class="img_2">
                                <img width="61" height="51" class="lazyload" data-src="<?= base_url('asset/portal/img/icon/logo-hi.png')?>"
                                    alt="<?= $value['Desc']?>" /></div>
                                <h5><?= $value['Ctgr']?></h5>
                                <h2 class="animate__animated animate__lightSpeedInRight"><?= $value['Judul']?></h2>
                                <p><?= $value['Desc']?></p>
                                <a class="btn btn-secondary text-white btn-sm" href="<?= $value['Link']['link_target']?>" target="_blank" rel="nofollow">
                                        <i class="<?= $value['Link']['icon']?>"></i>
                                        <?= $value['Link']['name']?>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <div class="hero__text__logo">
                                <img class="animate__animated animate__zoomIn lazyload" width="557" height="557" data-src="<?= base_url('asset/images/blog/').$value['Img']; ?>" alt="<?= $value['Judul']?>"/>
                            </div>
                        </div>
                    </div>
                </div>
                <?php }}?>
            </div>
    </div>
</section>
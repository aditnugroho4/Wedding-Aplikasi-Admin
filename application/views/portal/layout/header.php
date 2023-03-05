<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<header class="header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2 col-md-2">
                <div class="header__logo">
                    <a href="<?=site_url('home'); ?>"><img width="212" height="70" class="lazyload" data-src="<?=base_url(); ?>asset/portal/img/logo-akbar.png" alt="Akbar Group Logo"></a>
                </div>
            </div>
            <div class="col-lg-8 col-md-9">
                <nav class="header__menu mobile-menu">
                    <ul>
                        <?php foreach($Menu['data'] as $i=> $key){?>
                        <li class="mn-<?= $i+1 ?>"><a
                                href="<?=site_url($key['menu']['url']); ?>"><?= $key['menu']['menu'] ?></a>
                            <?php if($key['submenu']){?>
                            <ul class="dropdown">
                                <?php foreach($key['submenu'] as $val ){?>
                                <li><a href="<?= site_url('home/page/').$val[0]['url']?>"><?= $val[0]['name'] ?></a>
                                </li>
                                <?php } ?>
                            </ul>
                            <?php } ?>
                        </li>
                        <?php } ?>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-2 col-md-1">
                <div class="header__right">
                    <div class="header__right__social">
                        <a href="https://www.facebook.com/akbargrup" target="_blank" rel="nofollow"><i
                                class="fa fa-facebook"></i></a>
                        <a href="https://www.instagram.com/akbargrup/" target="_blank" rel="nofollow"><i
                                class="fa fa-instagram"></i></a>
                        <a href="https://www.youtube.com/channel/UCGGJ01l-Nmq52VxOt5uFKsw" target="_blank"
                            rel="nofollow"><i class="fa fa-youtube-play"></i></a>
                        <a href="https://twitter.com/akbar_grup" target="_blank" rel="nofollow"><i
                                class="fa fa-twitter-square"></i></a>
                        <a href="https://api.whatsapp.com/send?phone=+6285780555092&text=Hallo%20Akbar%20Grup..%20%20Saya%20ingin%20mengajukan%20Pertanyaan%20tolong%20berikan%20kemudahan%20kepada%20saya%20..?"
                            target="_blank" rel="nofollow"><i class="fa fa-whatsapp"></i></a>
                    </div>
                    <div class="header__right__search">
                        <a href="#" class="search-switch"><i class="fa fa-search"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div id="mobile-menu-wrap"></div>
    </div>
</header>
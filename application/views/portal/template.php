<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?=$Seo['data']['title']; ?></title>

    <meta name="title" content="<?=$Seo['data']['title'];?>" />
    <meta name="url" content="<?=site_url().$Seo['data']['link'];?>" />
    <meta name="author" content="<?=$Seo['data']['author'];?>" />
    <meta name="description" content="<?=$Seo['data']['deskripsi'];?>">
    <meta name="keywords" content="<?=$Seo['data']['keyword'];?>">
    <meta name="image" content="<?=site_url().str_replace('-','/',$Seo['data']['img']);?>">

    <meta property="fb:app_id" content="1066881707059210" />
    <meta property="og:url" content="<?=site_url().$Seo['data']['link'];?>" />
    <meta property="og:title" content="<?=$Seo['data']['title'];?>" />
    <meta property="og:type" content="website" />
    <meta property="og:image:url" content="<?=site_url().str_replace('-','/',$Seo['data']['img']);?>" />
    <meta property="og:image:alt" content="<?=$Seo['data']['title'];?>" />
    <meta property="og:description" content="<?=$Seo['data']['deskripsi'];?>" />
    <meta property="og:site_name" content="Akbar Grup Wedding Organizer" />
    <meta property="article:author" content="<?=$Seo['data']['author'];?>" />

    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="@akbar_grup" />
    <meta name="twitter:creator" content="@akbar_grup" />
    <meta name="twitter:url" content="<?=site_url().$Seo['data']['link'];?>" />
    <meta name="twitter:title" content="<?=$Seo['data']['title'];?>" />
    <meta name="twitter:description" content="<?=$Seo['data']['deskripsi'];?>" />
    <meta name="twitter:image" content="<?=site_url().str_replace('-','/',$Seo['data']['img']);?>" />
    <meta name="twitter:image:alt" content="<?=$Seo['data']['deskripsi'];?>" />

    <meta name="robots" content="index, follow" />
    <meta name="googlebot" content="index,follow" />
    <meta name="Googlebot-Image" content="follow, all" />
    <meta name="Scooter" content="follow, all" />
    <meta name="msnbot" content="follow, all" />
    <meta name="alexabot" content="follow, all" />
    <meta name="Slurp" content="follow, all" />
    <meta name="ZyBorg" content="follow, all" />


    <link rel="shortcut icon" href="<?=site_url(); ?>asset/portal/img/fav.png" />
    <link rel="preload" href="<?=base_url(); ?>asset/portal/css/bootstrap.min.css" as="style"
        onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="<?=base_url(); ?>asset/portal/css/bootstrap.min.css">
    </noscript>

    <link rel="preload" href="<?=base_url(); ?>asset/portal/css/font-awesome.min.css" as="style"
        onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="<?=base_url(); ?>asset/portal/css/font-awesome.min.css">
    </noscript>

    <link rel="preload" href="<?=base_url(); ?>asset/portal/css/animate.min.css" as="style"
        onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="<?=base_url(); ?>asset/portal/css/animate.min.css">
    </noscript>

    <link rel="preload" href="<?=base_url(); ?>asset/portal/owlcarousel/assets/owl.carousel.min.css" as="style"
        onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="<?=base_url(); ?>asset/portal/owlcarousel/assets/owl.carousel.min.css">
    </noscript>

    <link rel="preload" href="<?=base_url(); ?>asset/portal/owlcarousel/assets/owl.theme.default.min.css" as="style"
        onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="<?=base_url(); ?>asset/portal/owlcarousel/assets/owl.theme.default.min.css">
    </noscript>

    <link rel="preload" href="<?=base_url(); ?>asset/portal/css/slicknav.min.css" as="style"
        onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="<?=base_url(); ?>asset/portal/css/slicknav.min.css">
    </noscript>

    <link rel="preload" href="<?=base_url(); ?>asset/portal/css/nice-select.css" as="style"
        onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="<?=base_url(); ?>asset/portal/css/nice-select.css">
    </noscript>

    <link rel="preload" href="<?=base_url(); ?>asset/admin/plugins/pagination/pagination-min.css" as="style"
        onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="<?=base_url(); ?>asset/admin/plugins/pagination/pagination-min.css">
    </noscript>

    <link rel="preload" href="<?=base_url(); ?>asset/portal/css/style.css" as="style"
        onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="<?=base_url(); ?>asset/portal/css/style.css">
    </noscript>

    <link rel="preload" href="<?=base_url(); ?>asset/admin/plugins/chat-room/css/style.css" as="style"
        onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="<?=base_url(); ?>asset/admin/plugins/chat-room/css/style.css">
    </noscript>

    <script src="https://www.googletagmanager.com/gtag/js?id=UA-180345971-1" async="async"></script>
    <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', 'UA-180345971-1');
    </script>
    <script src="https://www.googleoptimize.com/optimize.js?id=OPT-5VZKLF9" async="async"></script>
    <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments)
    }
    gtag('js', new Date());
    gtag('config', 'G-Z3MWG6T7Y9');
    </script>

    <script data-ad-client="ca-pub-3500053889711919" async
        src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script async custom-element="amp-auto-ads" src="https://cdn.ampproject.org/v0/amp-auto-ads-0.1.js">
    </script>
</head>

<body>
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MQZ64V4" height="0" width="0"
            style="display:none;visibility:hidden"></iframe>
    </noscript>
    <div id="fb-root"></div>
    <noscript>
        <script
            src="https://connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v9.0&appId=1066881707059210&autoLogAppEvents=1"
            nonce="ZCz8wjAy" async="async" crossorigin="anonymous"></script>
    </noscript>

    <div id="preloder">
        <div class="loader"></div>
    </div>
    <script src="<?=base_url(); ?>asset/portal/js/jquery-3.3.1.min.js"></script>
    <?=$_header;?>
    <?=$_container;?>
    <?=$_footer;?>
    <?=$_chatboot;?>
    <script src="<?=base_url(); ?>asset/portal/js/lazysizes.min.js" async></script>
    <script src="<?=base_url(); ?>asset/portal/js/bootstrap.min.js" defer></script>
    <script src="<?=base_url(); ?>asset/portal/js/jquery.magnific-popup.min.js" defer></script>
    <script src="<?=base_url(); ?>asset/portal/js/mixitup.min.js" defer="defer"></script>
    <script src="<?=base_url(); ?>asset/portal/js/jquery.nice-select.min.js" defer="defer"></script>
    <script src="<?=base_url(); ?>asset/portal/js/isotope.pkgd.min.js" defer="defer"></script>
    <script src="<?=base_url(); ?>asset/portal/js/masonry.pkgd.min.js" defer="defer"></script>
    <script src="<?=base_url(); ?>asset/portal/js/jquery.slicknav.js" defer="defer"></script>
    <script src="<?=base_url(); ?>asset/portal/js/owl.carousel.min.js" defer="defer"></script>
    <script src="<?=base_url(); ?>asset/portal/js/main.js" defer="defer"></script>
    <script src="<?=base_url(); ?>asset/admin/plugins/pagination/pagination.min.js" defer="defer"></script>
    <script src="<?=base_url(); ?>asset/admin/plugins/jquery-validation/jquery.validate.min.js" defer="defer">
    </script>
</body>

</html>
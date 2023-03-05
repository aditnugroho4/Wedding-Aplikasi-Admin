<?php if ( ! defined( 'BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view('portal/menu/content/function/f_portofolio');?>
<div class="breadcrumb-option set-bg" data-setbg="<?php echo base_url('asset/portal/')?>img/bg-ag.png">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__text">
                    <h1>Portfolio</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $_panel;?>
<section class="portfolio spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>Event Kami</h2>
                    <img width="50" height="15" src="<?php echo base_url(); ?>asset/portal/img/icon/ti.png"
                        alt=" Gallery Akbar Grup">
                </div>
                <ul class="filter__controls"></ul>
            </div>
            <div class="col-lg-12">
                <div class="view__gallery"></div>
            </div>
            <div class="col-lg-12 text-center">
                <div class="load__more">
                    <!-- Button Pagination -->
                </div>
                <amp-auto-ads type="adsense" data-ad-client="ca-pub-3500053889711919">
                </amp-auto-ads>
            </div>
        </div>
    </div>
</section>
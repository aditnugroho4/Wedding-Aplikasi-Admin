<?php if ( ! defined( 'BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view('portal/menu/content/function/f_about');?>
<div class="breadcrumb-option set-bg" data-setbg="<?php echo base_url('asset/portal/')?>img/bg-ag.png">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__text">
                    <h1>TENTANG KAMI</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="about spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="about__text">
                    <h2>Akbar Grup</h2>
                    <?= $html = R::findOne('m_confiq','name=?',array("Tentang Kami"))->content;?>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="about__pic"><img src="<?php echo base_url('asset/portal/')?>img/about/about-1.png"
                        alt="About">
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="about__counter">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="counter__item"><img src="<?php echo base_url(); ?>asset/portal/img/icon/ci-2.png"
                            alt="Wedding Planner">
                        <h2 class="counter_num">568</h2>
                        <p>Wedding Planner</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="counter__item"><img src="<?php echo base_url(); ?>asset/portal/img/icon/ci-5.png"
                            alt="Photo & Video">
                        <h2 class="counter_num">8365</h2>
                        <p>Photos & Video</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="counter__item"><img src="<?php echo base_url(); ?>asset/portal/img/icon/ci-6.png"
                            alt="Makeup">
                        <h2 class="counter_num">849</h2>
                        <p>Makeup</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="counter__item"><img src="<?php echo base_url(); ?>asset/portal/img/icon/ci-4.png"
                            alt="Catering & Dekorasi">
                        <h2 class="counter_num">2574</h2>
                        <p>Catering & Dekorasi</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="testimonial spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>Testimonial</h2><img src="<?php echo base_url('asset/portal/')?>img/icon/ti.png"
                        alt="Testimoni">
                    <p>Bagaimana pelayanan Akbar Grup menurut mereka?</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="testimonial__carousel owl-carousel">
                <div class="col-lg-6">
                    <div class="testimonial__item">
                        <div class="testimonial__item__text">
                            <p>Tempatnya strategis,bagus,paketannya ok dan staff nya ramah ramah. </p>
                        </div>
                        <div class="testimonial__item__author">
                            <div class="testimonial__item__author__pic"><img
                                    src="<?php echo base_url('asset/portal/')?>img/testimoni/GSA-hotel.png"
                                    alt="Testimoni-1">
                            </div>
                            <div class="testimonial__item__author__text">
                                <h5>GSA RHotel</h5>
                                <div class="rating"><span class="icon_star"></span><span class="icon_star"></span><span
                                        class="icon_star"></span><span class="icon_star"></span><span
                                        class="icon_star"></span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="testimonial__item">
                        <div class="testimonial__item__text">
                            <p>Pelayanan ramah bangett terus harga paketannya juga worth it, suka deh pokoknyaa. </p>
                        </div>
                        <div class="testimonial__item__author">
                            <div class="testimonial__item__author__pic"><img
                                    src="<?php echo base_url('asset/portal/')?>img/testimoni/ts-delisa.png"
                                    alt="Testimoni-1">
                            </div>
                            <div class="testimonial__item__author__text">
                                <h5>Delisa Fahira</h5>
                                <div class="rating"><span class="icon_star"></span><span class="icon_star"></span><span
                                        class="icon_star"></span><span class="icon_star"></span><span
                                        class="icon_star"></span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="testimonial__item">
                        <div class="testimonial__item__text">
                            <p>pelayanan sangat baik , gaunnya jg bagus bagus. </p>
                        </div>
                        <div class="testimonial__item__author">
                            <div class="testimonial__item__author__pic"><img
                                    src="<?php echo base_url('asset/portal/')?>img/testimoni/miyla-mhs.png"
                                    alt="Testimoni-1">
                            </div>
                            <div class="testimonial__item__author__text">
                                <h5>Miyla Mhs</h5>
                                <div class="rating"><span class="icon_star"></span><span class="icon_star"></span><span
                                        class="icon_star"></span><span class="icon_star"></span><span
                                        class="icon_star"></span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="testimonial__item">
                        <div class="testimonial__item__text">
                            <p>Tempat sewa tenda yang cukup besar di karadenan. </p>
                        </div>
                        <div class="testimonial__item__author">
                            <div class="testimonial__item__author__pic"><img
                                    src="<?php echo base_url('asset/portal/')?>img/testimoni/aloysius.png"
                                    alt="Testimoni-1"></div>
                            <div class="testimonial__item__author__text">
                                <h5>Aloysius Suminto</h5>
                                <div class="rating"><span class="icon_star"></span><span class="icon_star"></span><span
                                        class="icon_star"></span><span class="icon_star"></span><span
                                        class="icon_star"></span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="team spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>Tim Kami</h2><img src="<?php echo base_url('asset/portal/')?>img/icon/ti.png" alt="Testimoni-1">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="team__item">
                    <div class="team__item__pic"><img src="<?php echo base_url('asset/portal/')?>img/team/1-team.png"
                            alt="EMUA MAKE-UP"></div>
                    <div class="team__item__text">
                        <h5>EMUA</h5><span>Makeup</span>
                        <div class="team__item__social"><a rel="nofollow" href="#"><i class="fa fa-facebook"></i></a><a
                                href="#"><i class="fa fa-twitter"></i></a><a href="#"><i
                                    class="fa fa-instagram"></i></a><a href="#"><i class="fa fa-dribbble"></i></a></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="team__item">
                    <div class="team__item__pic"><img src="<?php echo base_url('asset/portal/')?>img/team/2-team.png"
                            alt="ODIE DEKORASI"></div>
                    <div class="team__item__text">
                        <h5>ODIE</h5><span>Dekorasi</span>
                        <div class="team__item__social"><a rel="nofollow" href="#"><i class="fa fa-facebook"></i></a><a
                                rel="nofollow" href="#"><i class="fa fa-twitter"></i></a><a href="#"><i
                                    class="fa fa-instagram"></i></a><a href="#"><i class="fa fa-dribbble"></i></a></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="team__item">
                    <div class="team__item__pic"><img src="<?php echo base_url('asset/portal/')?>img/team/1-team.png"
                            alt="AKBAR GRUP CATERING"></div>
                    <div class="team__item__text">
                        <h5>Akbar Grup</h5><span>Tenda & Catring</span>
                        <div class="team__item__social"><a rel="nofollow" href="#"><i class="fa fa-facebook"></i></a><a
                                href="#"><i class="fa fa-twitter"></i></a><a rel="nofollow" href="#"><i
                                    class="fa fa-instagram"></i></a><a href="#"><i class="fa fa-dribbble"></i></a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
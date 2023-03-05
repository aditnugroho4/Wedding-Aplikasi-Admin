<?php if ( ! defined( 'BASEPATH')) exit('No direct script access allowed'); ?><?php $this->load->view('portal/menu/content/function/f_services');?>
<div class="breadcrumb-option set-bg" data-setbg="<?php echo base_url('asset/portal/')?>img/bg-ag.png">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__text">
                    <h1>Akbar Grup</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $_panel;?>
<section class="services spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>Layanan Kami</h2><img src="<?php echo base_url(); ?>asset/portal/img/icon/ti.png"
                        alt="Layanan Kami">
                </div>
            </div>
        </div>
        <div class="row"><?php foreach($Product['data'] as $all){?><div class="col-lg-4 col-6">
                <?php $link=$all[0]['name']; $link=str_replace(' ','-',$link); $link=str_replace('&','dan',$link); ?><a
                    href="<?=base_url('services/detail/').strtolower($link); ?>">
                    <div class="services__item"><img src="<?=base_url().$all[0]['img']; ?>" alt="<?=$all[0]['name'];?>">
                        <h4><?=$all[0]['name']?></h4>
                        <p><?=$all[0]['label']?></p>
                    </div>
                </a></div><?php }?></div>
    </div>
</section>
<!-- Pricing Section Begin -->
<section class="pricing spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>MACAM - MACAM PAKET</h2>
                    <img width="50" height="15" src="<?php echo base_url('asset/portal/')?>img/icon/ti.png"
                        alt="Paket Wedding">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="pricing__item">
                    <h5>PAKET RUMAH</h5>
                    <!-- <h2>Rp 4.500.000</h2> -->
                    <img width="119" height="34" src="<?php echo base_url('asset/portal/')?>img/icon/pricing-icon.png"
                        alt="Paket Rumah">
                    <ul>
                        <li>Dekorasi</li>
                        <li>MUA</li>
                        <li>Baju Pengantin</li>
                        <li>Baju Orang Tua</li>
                        <li>Baju Penerima Tamu</li>
                    </ul>
                    <a rel="nofollow"
                        href="https://api.whatsapp.com/send?phone=+6285780555092&text=Hallo%20Akbar%20Grup..%20%20Saya%20ingin%20mengajukan%20Pertanyaan%20tolong%20berikan%20kemudahan%20kepada%20saya%20..?"
                        target="_blank" class="primary-btn"><i class="fa fa-whatsapp"></i> Tanya
                        Langsung</a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="pricing__item">
                    <h5>PAKET STANDAR</h5>
                    <!-- <h2>Rp. 8.500.000</h2> -->
                    <img width="119" height="34" src="<?php echo base_url('asset/portal/')?>img/icon/pricing-icon.png"
                        alt="Paket Standar">
                    <ul>
                        <li>Catering 600/Pack</li>
                        <li>Dekorasi ++</li>
                        <li> Waiters</li>
                        <li> MUA</li>
                        <li>Baju Pengantin</li>
                        <li>Baju Orang Tua</li>
                        <li>Baju Penerima Tamu</li>
                        <li>Foto + Video</li>
                        <li>Album Kolase</li>
                        <li>Liputan Video Shooting</li>
                        <li>MC</li>
                        <li>Manajemen Acara</li>
                        <li>BONUS +</li>
                    </ul>
                    <a rel="nofollow"
                        href="https://api.whatsapp.com/send?phone=+6285780555092&text=Hallo%20Akbar%20Grup..%20%20Saya%20ingin%20mengajukan%20Pertanyaan%20tolong%20berikan%20kemudahan%20kepada%20saya%20..?"
                        target="_blank" class="primary-btn"><i class="fa fa-whatsapp"></i> Tanya
                        Langsung</a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="pricing__item">
                    <h5>Paket Eksklusif</h5>
                    <!-- <h2>Rp. 45.000.000</h2> -->
                    <img width="119" height="34" src="<?php echo base_url('asset/portal/')?>img/icon/pricing-icon.png"
                        alt="Paket Eksklusif">
                    <ul>
                        <li>Catering 1000/Pack</li>
                        <li>Dekorasi +++</li>
                        <li>Waiters</li>
                        <li>Prewedd</li>
                        <li>Foto + Video Cinematic</li>
                        <li>Album Kolase</li>
                        <li>Liputan Video Shooting</li>
                        <li>Upacara Adat Sunda/Jawa</li>
                        <li>MUA</li>
                        <li>Baju Pengantin</li>
                        <li>Baju Orang Tua</li>
                        <li>Baju Penerima Tamu</li>
                        <li>MC</li>
                        <li>Manajemen Acara</li>
                    </ul>
                    <a rel="nofollow"
                        href="https://api.whatsapp.com/send?phone=+6285780555092&text=Hallo%20Akbar%20Grup..%20%20Saya%20ingin%20mengajukan%20Pertanyaan%20tolong%20berikan%20kemudahan%20kepada%20saya%20..?"
                        target="_blank" class="primary-btn"><i class="fa fa-whatsapp"></i> Tanya
                        Langsung</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Pricing Section End -->
<section class="request request--services spad">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-7">
                <div class="request__form">
                    <div class="section-title">
                        <span>AYO BERTEMU</span>
                        <h2>BUAT SEBUAH PERMINTAAN</h2>
                        <p>Jika Anda memiliki pertanyaan tentang Wedding Planner, silakan isi formulir pertanyaan
                            kami.</p>
                    </div>
                    <form id="send_request">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 px-2">
                                <input id="txtNama" name="nama" type="text" placeholder="Name">
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 px-2">
                                <input id="txtEmail" name="email" type="text" placeholder="Email">
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 px-2">
                                <select id="cmbLayanan" name="layanan">
                                    <option value="">Services</option>
                                    <option value="">Option 1</option>
                                    <option value="">Option 2</option>
                                </select>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 px-2">
                                <select id="cmbClient" name="client">
                                    <option value="">Guest</option>
                                    <option value="">Option 1</option>
                                    <option value="">Option 2</option>
                                </select>
                            </div>
                            <div class="col-lg-12 px-2 text-center">
                                <textarea id="txtPesan" name="pesan" placeholder="Message"></textarea>
                                <button type="submit" class="site-btn">send a request</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-12">
                <amp-auto-ads type="adsense" data-ad-client="ca-pub-3500053889711919">
                </amp-auto-ads>
            </div>
        </div>
    </div>
</section>
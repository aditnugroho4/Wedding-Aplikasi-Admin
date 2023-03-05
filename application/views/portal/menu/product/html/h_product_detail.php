<?php if ( ! defined( 'BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view('portal/menu/product/function/f_product_detail');?>
<section class="services spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 mt-5">
                <div class="section-title">
                    <h2>Layanan Kami</h2>
                    <img width="50" height="15" src="<?= base_url(); ?>asset/portal/img/icon/ti.png"
                        alt="Product & layanan Akbar Grup">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6">
                <a href="<?= base_url('services'); ?>">
                    <div class="services__item">
                        <img width="50" height="15" src="<?= base_url().$Product['img']; ?>"
                            alt="<?= $Product['title']?>">
                        <h4><?= $Product['nama']?></h4>
                        <p><?= $Product['label']?></p>
                    </div>
                </a>
            </div>
            <div class="col-lg-8 col-md-6 col-sm-6">
                <h1 class="text-center"><?= $Product['title']?></h1>
                <p><?= $Product['deskripsi']?></p>
                <div class="text-left">
                    <div class="fb-share-button" data-href="<?= site_url().str_replace('-','/',$Seo['data']['link']);?>"
                        data-layout="button_count" data-size="small"><a target="_blank" rel="nofollow"
                            href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fakbargrup.id%2F&amp;src=sdkpreparse"
                            class="fb-xfbml-parse-ignore">Bagikan</a></div>
                </div>
            </div>
            <div class="col-lg-12 mt-5 border-top border-bottom">
                <?= $Product['content']?>
            </div>
            <div class="col-lg-12 mt-3">
                <div class="blog__sidebar__item">
                    <h4>Tags</h4>
                    <div class="blog__sidebar__tags">
                        <?php $count=explode(',',$Seo['data']['keyword']); $link=$Seo['data']['short_link']; $link=str_replace(" ", "-",$link); $link=str_replace('&', 'dan',$link); $link=str_replace("/", "-",$link); $link=str_replace("|", "-",$link); for($i=0 ; $i<count($count) ; $i++){?>
                        <a href="<?=base_url('blog');?>"><?=$count[$i]; ?></a><?php }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
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
        </div>
    </div>
</section>
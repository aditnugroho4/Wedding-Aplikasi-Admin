<?php if ( ! defined( 'BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view('portal/menu/content/function/f_home');?>
<?php echo $_banner;?>
<?php echo $_panel;?>
<section class="services spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>Layanan</h2>
                    <img width="50" height="15" class="lazyload" data-src="<?php echo base_url(); ?>asset/portal/img/icon/ti.png"
                        alt="Menu & Services">
                </div>
            </div>
        </div>
        <div class="row">
            <?php foreach($Product['data'] as $all){?>
            <div class="col-lg-4 col-6">
                <?php   $link = $all[0]['name'];
                                $link = str_replace(' ','-',$link);
                                $link = str_replace('&','dan',$link);
                        ?>
                <a href="<?= base_url('services/detail/').strtolower($link); ?>">
                    <div class="services__item">
                        <img width="68" height="70" class="lazyload" data-src="<?= base_url().$all[0]['img']; ?>"
                            alt="<?= $all[0]['label']?>">
                        <h4><?= $all[0]['name']?></h4>
                        <p><?= $all[0]['label']?></p>
                    </div>
                </a>
            </div>
            <?php }?>
        </div>
    </div>
</section>
<section class="features spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>Gallery</h2>
                    <img width="50" height="15" class="lazyload" data-src="<?php echo base_url(); ?>asset/portal/img/icon/ti.png"
                        alt=" Gallery Akbar Grup">
                </div>
                <ul class="filter__controls"></ul>
            </div>
            <div class="col-lg-12">
                <div class="view__gallery"></div>
            </div>
            <div class="col-lg-12 text-center">
                <div class="load__more"></div>
            </div>
        </div>
    </div>
</section>
<section class="blog ">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>Our blog</h2>
                    <img width="50" height="15" class="lazyload" data-src="<?php echo base_url(); ?>asset/portal/img/icon/ti.png"
                        alt="Blog Akbar Grup">
                </div>
            </div>
        </div>
        <div class="row">
            <?php $con=0; foreach($Blogs['All'] as $all){ ?>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="latest__item">
                    <img width="360" height="211" class="lazyload" data-src="<?= base_url().$all[0]['img']?>" alt="<?= $all[0]['judul']?>">
                    <ul>
                        <li>Tips</li>
                        <li><?= date("F j, Y, g:i a", strtotime($all[0]['date']))?></li>
                        <li>(<?= $all[0]['comment']?>) Comment</li>
                        <li>By : Admin</li>
                    </ul>
                    <?php $link = $all['seo']['short_link'];
                                    $link = str_replace(" ", "-",$link);
                                    $link = str_replace('&', 'dan',$link);
                                    $link = str_replace("/", "-",$link);
                                    $link = str_replace("|", "-",$link); ?>

                    <h4><a href="<?= base_url('blog/detail/').$link.'/'?>"><?= $all['seo']['title']?></a>
                    </h4>
                    <p><?= $all['seo']['deskripsi'] ?>...</p>
                    <a href="<?= base_url('blog/detail/').$link.'/'?>" class="site-btn priamry-btn"><i
                            class="fa fa-eye"></i> Read More..</a>
                </div>
            </div>
            <?php $con +=1 ; if($con == 3) break; } ?>
        </div>
    </div>
</section>
<section class="counter spad set-bg" data-setbg="<?php echo base_url(); ?>asset/portal/img/counter-bg.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="counter__item">
                    <img width="67" height="90" class="lazyload" data-src="<?php echo base_url(); ?>asset/portal/img/icon/ci-2.png"
                        alt="Wedding Planner">
                    <h2 class="counter_num">568</h2>
                    <p>Wedding Planner</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="counter__item">
                    <img width="67" height="90" class="lazyload" data-src="<?php echo base_url(); ?>asset/portal/img/icon/ci-5.png"
                        alt="Photo & Video">
                    <h2 class="counter_num">8365</h2>
                    <p>Photos & Video</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="counter__item">
                    <img width="67" height="90" class="lazyload" data-src="<?php echo base_url(); ?>asset/portal/img/icon/ci-6.png"
                        alt="Makeup">
                    <h2 class="counter_num">849</h2>
                    <p>Makeup</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="counter__item">
                    <img width="67" height="90" class="lazyload" data-src="<?php echo base_url(); ?>asset/portal/img/icon/ci-4.png"
                        alt="Catering & Dekorasi">
                    <h2 class="counter_num">2574</h2>
                    <p>Catering & Dekorasi</p>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="request spad">
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
                                <label for="txtNama"></label>
                                <input type="text" id="txtNama" placeholder="Name">
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 px-2">
                                <label for="txtEmail"></label>
                                <input type="email" id="txtEmail" placeholder="Email">
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 px-2">
                                <label for="cmbLayanan"></label>
                                <select id="cmbLayanan">
                                    <option value="">Services</option>
                                    <option value="">Option 1</option>
                                    <option value="">Option 2</option>
                                </select>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 px-2">
                                <label for="cmbClient"></label>
                                <select id="cmbClient">
                                    <option value="">Guest</option>
                                    <option value="">Option 1</option>
                                    <option value="">Option 2</option>
                                </select>
                            </div>
                            <div class="col-lg-12 px-2 text-center">
                                <label for="txtPesan"></label>
                                <textarea id="txtPesan" placeholder="Message"></textarea>
                                <button type="submit" class="site-btn">send a request</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
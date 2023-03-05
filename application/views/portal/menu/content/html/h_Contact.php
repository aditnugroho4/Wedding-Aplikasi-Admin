<?php if ( ! defined( 'BASEPATH')) exit('No direct script access allowed'); ?><?php $this->load->view('portal/menu/content/function/f_contact');?>
<div class="map">
    <div class="container-fluid p-t-20">
        <div class="row">
            <div class="col-lg-12"><iframe
                    src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15855.931361427596!2d106.8083481!3d-6.52385!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x6c642ba4a14bbba0!2sAkbar%20Grup%20(%20Wedding%20Organizer%2C%20Decoration%2C%20Tenda%2C%20dan%20MUA%20)%20-%20Bogor!5e0!3m2!1sid!2sid!4v1601346112107!5m2!1sid!2sid"
                    width="600" height="450" allowfullscreen="" aria-hidden="false"></iframe>
            </div>
        </div>
    </div>
</div>
<section class="contact spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4">
                <div class="contact__widget">
                    <h1>Contact info</h1>
                    <ul>
                        <li>
                            <div class="contact__widget__icon"><a
                                    href="https://api.whatsapp.com/send?phone=+6285780555092&text=Hallo%20Akbar%20Grup..%20%20Saya%20ingin%20mengajukan%20Pertanyaan%20tolong%20berikan%20kemudahan%20kepada%20saya%20..?"
                                    target="_blank" rel="nofollow"><i class="fa fa-phone"></i></a></div>
                            <div class="contact__widget__text"><span>akbargrupbogor@gmail.com</span>
                                <p>+62 857-8055-5092</p>
                            </div>
                        </li>
                        <li>
                            <div class="contact__widget__icon"><a href="https://g.page/akbargrup?share" target="_blank"
                                    rel="nofollow"><i class="fa fa-map-marker"></i></a></div>
                            <div class="contact__widget__text">
                                <p>Jl. Karadenan No.30, Karadenan, Cibinong, Bogor, Jawa Barat 16913</p>
                            </div>
                        </li>
                        <li>
                            <div class="contact__widget__icon"><i class="fa fa-clock-o"></i></div>
                            <div class="contact__widget__text"><span>Hari Kerja - Sat :8:00am - 17:00pm</span>
                                <p>Hari Libur:8:00am - 17:00pm</p>
                            </div>
                        </li>
                    </ul>
                    <div class="text-left">
                        <div class="fb-share-button"
                            data-href="<?=site_url().str_replace('-','/',$Seo['data']['link']);?>"
                            data-layout="button_count" data-size="small"><a target="_blank" rel="nofollow"
                                href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fakbargrup.id%2F&amp;src=sdkpreparse"
                                class="fb-xfbml-parse-ignore">Bagikan</a></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-8">
                <div class="contact__form">
                    <h2>Get in touch</h2>
                    <form id="send_pesan">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6"><input id="txtNama" name="name" type="text"
                                    placeholder="Name"></div>
                            <div class="col-lg-6 col-md-6 col-sm-6"><input id="txtEmail" name="email" type="text"
                                    placeholder="Email"></div>
                        </div><textarea id="txtPesan" name="pesan" placeholder="Your message"></textarea>
                        <button id="btn-kirim" type="submit" class="site-btn">Send</button>
                    </form>
                </div>
                <amp-auto-ads type="adsense" data-ad-client="ca-pub-3500053889711919">
                </amp-auto-ads>
            </div>
        </div>
    </div>
</section>
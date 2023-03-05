<?php if ( ! defined( 'BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view('portal/menu/content/function/f_blog');?>
<div class="breadcrumb-option set-bg" data-setbg="<?php echo base_url('asset/portal/')?>img/bg-ag.png">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__text">
                    <h1>Blog</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="blog spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8 list-artikel">
                <div class="list-blog"></div>
                <div id="pagination"></div>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="blog__sidebar">
                    <div class="blog__sidebar__item">
                        <h4>Blog Akbar Grup</h4>
                        <?php foreach($Seo['Blogs']['All'] as $all){ $link=$all['seo']['short_link']; $link=str_replace(" ", "-",$link); $link=str_replace('&', 'dan',$link); $link=str_replace("/", "-",$link); $link=str_replace("|", "-",$link); ?><a
                            href="<?=base_url('blog/detail/'.$link).'/';?>" class="blog__sidebar__recent__item">
                            <div class="blog__sidebar__recent__item__pic"><img class="img-responsive" width="100"
                                    height="65" src="<?=base_url().$all[0]['img'];?>" alt="<?=$all[0]['judul'];?>">
                            </div>
                            <div class="blog__sidebar__recent__item__text">
                                <h5><?=$all[0]['judul'];?></h5>
                                <span><?=date("F j, Y, g:i a", strtotime($all[0]['date']))?></span>
                            </div>
                        </a><?php }?>
                    </div>
                    <div class="blog__sidebar__item">
                        <h4>Blog Categories</h4>
                        <ul>
                            <li>
                                <h3 onclick="$.load_ctgr_blog(5,'All')">All..</h3>
                            </li>
                            <?php foreach($Seo['Blogs']['Ctgr'] as $ctgr){?><li>
                                <h3 onclick="$.load_ctgr_blog(10,<?=$ctgr[0]['id'];?>)"><?=$ctgr[0]['nama'];?></h3>
                            </li><?php }?>
                        </ul>
                    </div>
                    <div class="blog__sidebar__item">
                        <h4>Sosial media</h4>
                        <div class="blog__sidebar__instagram">
                            <div class="text-left">
                                <div class="fb-share-button"
                                    data-href="<?=site_url().str_replace('-','/',$Seo['data']['link']);?>"
                                    data-layout="button_count" data-size="small"><a target="_blank" rel="nofollow"
                                        href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fakbargrup.id%2F&amp;src=sdkpreparse"
                                        class="fb-xfbml-parse-ignore">Bagikan</a></div>
                            </div>
                        </div>
                        <amp-auto-ads type="adsense" data-ad-client="ca-pub-3500053889711919">
                        </amp-auto-ads>
                    </div>
                    <div class="blog__sidebar__item">
                        <h4>Tags</h4>
                        <div class="blog__sidebar__tags">
                            <?php $count=explode(',',$Seo['data']['keyword']); $link=$Seo['data']['short_link']; $link=str_replace(" ", "-",$link); $link=str_replace('&', 'dan',$link); $link=str_replace("/", "-",$link); $link=str_replace("|", "-",$link); for($i=0 ; $i<count($count) ; $i++){?>
                            <a href="<?=base_url('blog');?>"><?=$count[$i]; ?></a>
                            <?php }?>
                        </div>
                    </div>
                    <div class="blog__sidebar__item blog__sidebar__item__newslatter">
                        <h4>NEWSLETTER</h4>
                        <p>Berlanganan untuk mengetahu informasi update tentang kami</p>
                        <form id="post_subscribe">
                            <input id="txtEmail" type="text" placeholder="e-mail">
                            <button id="btnSubscribe" type="submit" class="btn btn-primary icon_mail_alt"></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
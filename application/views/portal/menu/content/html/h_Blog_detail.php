<?php if ( ! defined( 'BASEPATH')) exit('No direct script access allowed'); ?><?php $this->load->view('portal/menu/content/function/f_blog_detail');?>
<div class="breadcrumb-option set-bg lazyloaded" data-setbg="<?php echo base_url('asset/portal/')?>img/bg-ag.png">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__text">
                    <h1>Blog Detail</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="blog-details spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8">
                <div class="blog__details__content">
                    <div class="blog__item">
                        <div class="blog__item__title">
                            <ul>
                                <li><?=$Seo['Blogs']['Kategory']; ?></li>
                                <li><?=$Seo['Blogs']['Date']; ?></li>
                                <li>(<?=$Seo['Blogs']['Comment']; ?>) Comment</li>
                                <li>(<?=$Seo['data']['view'] ?>) Views</li>
                            </ul>
                            <h2><?=$Seo['Blogs']['Judul'];?></h2>
                        </div>
                        <div class="blog__item__pic set-bg lazyloaded"
                            data-setbg="<?=base_url().$Seo['Blogs']['Img'];?>"></div>
                        <div class="blog__item__text">
                            <span><?=$Seo['data']['title'];?></span>
                        </div>
                    </div><?php if($Seo['Blogs']['Quote'] !=null){ ?><div class="blog__quote">
                        <p><?=$Seo['Blogs']['Quote']; ?></p>
                        <h5>–" "-</h5><span>“</span>
                    </div><?php }?><div class="blog__details__text"><?=$Seo['Blogs']['Content']?></div>
                    <div class="blog__details__widget">
                        <div class="col-lg-12 mb-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="float-left blog__details__social">
                                        <span><i class="fa fa-share"></i>Share</span>
                                        <?php $link = $Seo['data']['short_link']; $link=str_replace(" ", "-",$link); $link=str_replace('&', 'dan',$link); $link=str_replace("/", "-",$link); $link=str_replace("|", "-",$link);?>
                                        <a rel="nofollow"
                                            href="https://www.facebook.com/sharer.php?u=<?=base_url('blog/detail/'.$link).'/'?>"
                                            target="_blank"><i class="fa fa-facebook"></i></a>
                                        <a rel="nofollow"
                                            href="http://twitter.com/share?url=<?=base_url('blog/detail/'.$link)?>"
                                            target="_blank"><i class="fa fa-twitter"></i></a>
                                        <a rel="nofollow"
                                            href="https://www.instagram.com/?url=<?=base_url('blog/detail/'.$link)?>"
                                            target="_blank"><i class="fa fa-instagram"></i></a>
                                        <a rel="nofollow"
                                            href="whatsapp://send?text=<?=base_url('blog/detail/'.$link)?>"
                                            target="_blank"><i class="fa fa-whatsapp"></i></a>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="fb-share-button" data-href="https://akbargrup.id/"
                                        data-layout="button_count" data-size="small">
                                        <a rel="nofollow"
                                            href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fakbargrup.id%2F&amp;src=sdkpreparse"
                                            class="fb-xfbml-parse-ignore" target="_blank">Bagikan</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="blog__details__tags">
                                <span><i class="fa fa-tag"></i>Tag:</span>
                                <?php $count=explode(',',$Seo['data']['keyword']); $link=$Seo['data']['short_link']; $link=str_replace(" ", "-",$link); $link=str_replace('&', 'dan',$link); $link=str_replace("/", "-",$link); $link=str_replace("|", "-",$link);for($i=0 ; $i<count($count) ; $i++){?>
                                <a href="<?=base_url('blog/detail/'.$link).'/'?>"><?=$count[$i] ?></a>
                                <?php }?>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="accordion" id="accordionSumber">
                                <div class="card">
                                    <div class="card-header bg-brown" id="headingOne">
                                        <span class="btn btn-link" data-toggle="collapse" data-target="#collapse1"
                                            aria-expanded="true" role="button">
                                            <i class="fa fa-tag"> Sumber Artikel</i>
                                        </span>
                                    </div>
                                    <div id="collapse1" class="collapse" aria-labelledby="headingOne"
                                        data-parent="#accordionSumber">
                                        <div class="card-body">
                                            <ul class="list-group">
                                                <?php $count=explode(',',$Seo['Blogs']['Sumber']); for($i=0 ; $i<count($count) ; $i++){ ?>
                                                <li class="list-group-item">
                                                    <span class="text-blue"><?=$count[$i];?></span>
                                                </li>
                                                <?php }?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="blog__details__btns">
                        <div id="pagination"></div>
                    </div>
                    <div class="blog__details__recent">
                        <h4>Recent posts</h4>
                        <div class="row list-artikel"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="blog__sidebar">
                    <div class="blog__sidebar__item">
                        <h4>Blog Akbar Grup</h4>
                        <?php foreach($Seo['Blogs']['All'] as $all){ $link=$all['seo']['short_link']; $link=str_replace(" ", "-",$link); $link=str_replace('&', 'dan',$link); $link=str_replace("/", "-",$link); $link=str_replace("|", "-",$link); ?><a
                            href="<?=base_url('blog/detail/'.$link).'/'?>" class="blog__sidebar__recent__item">
                            <div class="blog__sidebar__recent__item__pic"><img width="100" height="65"
                                    src="<?=base_url().$all[0]['img']?>" alt="<?=$all[0]['judul']?>"></div>
                            <div class="blog__sidebar__recent__item__text">
                                <h5><?=$all[0]['judul']?></h5>
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
                        <h4>Tags</h4>
                        <div class="blog__sidebar__tags">
                            <?php $count=explode(',',$Seo['data']['keyword']); $link=$Seo['data']['short_link']; $link=str_replace(" ", "-",$link); $link=str_replace('&', 'dan',$link); $link=str_replace("/", "-",$link); $link=str_replace("|", "-",$link); for($i=0 ; $i<count($count) ; $i++){?><a
                                href="<?=base_url('blog/detail/'.$link).'/'?>"><?=$count[$i] ?></a><?php }?>
                        </div>
                        <amp-auto-ads type="adsense" data-ad-client="ca-pub-3500053889711919">
                        </amp-auto-ads>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php if ( ! defined( 'BASEPATH')) exit('No direct script access allowed'); ?>
<script>
var $limit=5;
var $ctgr=0;
$(document).ready(function (){
$('.header__menu ul').find('li.active').removeAttr('class','active');
$('.header__menu ul').find('li.mn-4').addClass('active'); 
$.load_ctgr_blog = function(limit,ctgr){
        $_pagination_get(limit,ctgr);
    }
    $_pagination_get($limit,'All');

function $_pagination_get(limit,ctgr){
$('.blog__details__recent').append('<div class="loader" style="z-index:1000;"></div>');
$('#pagination').pagination({
            dataSource: '<?=site_url('blog/json_load_data'); ?>?table=w_post_artikel&ctgr='+ctgr,
            locator: 'data',
            pageSize: limit,
            pageRange: null,
            showPageNumbers: true,
            totalNumberLocator: function (response) {
                // you can return totalNumber by analyzing response content
                if (response) {
                    return Math.floor(response.total);
                }
            },
            ajax: {
                beforeSend: function (data) {
                    if (typeof (data) == 'object') {
                        $('.blog__details__recent').find('.loader').remove();
                    }
                }
            },
            callback: function (data, pagination) {
                $('.blog__details__recent').find('.loader').remove();
                var html = Templating(data);
                $('.list-artikel').html(html);
                $('.set-bg').each(function () {
                    var bg = $(this).data('setbg');
                    $(this).css('background-image', 'url(' + bg + ')');
                });
                var pagebar = $('#pagination');
                pagebar.find('.paginationjs-pages').attr('class', 'pagination__option');
            }
        });
}
function Templating(data){
var $html="";
for (var i=0, len=data.length; i < len; i++){
$html +='<div class="col-lg-4 col-md-6 col-sm-6">'+
'<div class="blog__details__recent__item">'+
'<img height="152.98" src="<?=base_url()?>'+ data[i].items.img +'" alt="'+ data[i].items.judul +'">'+ '<h5><a href="<?=base_url('blog/detail')?>/'+data[i].seo.short_link.replaceAll(' ', '-').replaceAll('&', 'dan')+'/">'+ data[i].items.judul +'</a></h5>'+ '<span>'+data[i].items.date+'</span>'+
'</div>'+
'</div>';}
return $html;};
}); </script>
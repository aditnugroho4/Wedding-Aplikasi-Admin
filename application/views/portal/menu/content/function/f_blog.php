<?php if ( ! defined( 'BASEPATH')) exit('No direct script access allowed'); ?>
<script>
var $limit=5;
var $ctgr=0;
$(document).ready(function () {
    $('.header__menu ul').find('li.active').removeAttr('class', 'active');
    $('.header__menu ul').find('li.mn-4').addClass('active');
    $.load_ctgr_blog = function(limit,ctgr){
        $_pagination_get(limit,ctgr);
    }
    $_pagination_get($limit,'All');

    function $_pagination_get(limit,ctgr) {
        $('.list-artikel').append('<div class="loader" style="z-index:1000;"></div>');
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
                        $('.list-artikel').find('.loader').remove();
                    }
                }
            },
            callback: function (data, pagination) {
                $('.list-artikel').find('.loader').remove();
                var html = Templating(data);
                $('.list-blog').html(html);
                $('.set-bg').each(function () {
                    var bg = $(this).data('setbg');
                    $(this).css('background-image', 'url(' + bg + ')');
                });
                var pagebar = $('#pagination');
                pagebar.find('.paginationjs-pages').attr('class', 'pagination__option');
            }
        });
    }

    function Templating(data) {
        var $html = "";
        for (var i = 0, len = data.length; i < len; i++) {
            $html += '<div class="blog__item">'+
                '<div class="blog__item__title">' +
                '<ul>' + '<li>Inspiration</li>' +
                '<li>' + data[i].items.date + '</li>' +
                '<li>(' + data[i].items.comment + ') Comment</li>' +
                '</ul>' + '<h2>' + data[i].items.judul + '</h2>' +
                '</div>' + '<div class="blog__item__pic set-bg" data-setbg="<?=base_url()?>' + data[i].items.img + '"></div>' +
                '<div class="blog__item__text">' + '<p>' + data[i].seo.deskripsi + '</p>' +
                '<a class="btn priamry-btn" href="<?=base_url('blog/detail')?>/' + data[i].seo.short_link.replaceAll(' ', '-').replaceAll('&', 'dan') + '">READ MORE</a>' +
                '</div>' +
                '</div>';
        }
        return $html;
    };
}); 
</script>
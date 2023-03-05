<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?> 
<script>
    var start = 0;
    var limit = 3;
    var action = 'none';

'use strict'
$(window).on('load', function () {
    $('.header__menu ul').find('li.active').removeAttr('class', 'active');
    $('.header__menu ul').find('li.mn-3').addClass('active');

    
    $.pagination_get = function($start,$limit){
        $_load_gallery($start,$limit);
    }

    var control = $(".filter__controls");
    var gallery = $(".view__gallery");
    
    $_load_gallery(start,limit);

    function $_load_gallery($start,$limit){
        gallery.empty();
        
        $('.load__more').empty();
            $.ajax({
					type: "POST",
					dataType: 'json',
					url: "<?php echo site_url('home/get_data_gallery');?>",
                    data:{
                        start:$start,
                        limit:$limit
                    },
					success: function (msg) {
                        
                        if (control.length > 0) {
                            control.empty();
                            control.append('<li class="active" data-filter="*">All</li>');
                            for (var i = 0; i < msg.data.length; i++) {
                                control.append('<li data-filter="#views-'+ msg.data[i].css +'">'+ msg.data[i].name+'</li>');
                            }
                        }

                        $('.load__more').append(msg.more);

                        if(msg.images){
                            gallery.append('<div class="grid-sizer"></div>');
                            for (var i = 0; i < msg.images.length; i++) {

                                    var size = msg.images[i].size;
                                    if(size == 'L'){
                                        gallery.append('<div id="views-'+ msg.images[i].ctgr +'" class="fg__item mid_item set-bg" data-setbg="'+ msg.images[i].img +'">'+
                                        '<div class="fg__item__text">'+
                                                '<span>'+ msg.images[i].label +'</span>'+
                                                '<h2>'+ msg.images[i].nama +'</h2>'+
                                                '<a href="'+ msg.images[i].link +'">'+ msg.images[i].lokasi +'</a>'+
                                            '</div>'+
                                        '</div>');
                                    }
                                    if(size == 'P'){
                                        gallery.append('<div id="views-'+ msg.images[i].ctgr +'" class="fg__item large_item set-bg" data-setbg="'+ msg.images[i].img +'">'+
                                        '<div class="fg__item__text">'+
                                                '<span>'+ msg.images[i].label +'</span>'+
                                                '<h2>'+ msg.images[i].nama +'</h2>'+
                                                '<a href="'+ msg.images[i].link +'">'+ msg.images[i].lokasi +'</a>'+
                                            '</div>'+
                                        '</div>');
                                    }
                                    if(size == null){
                                        gallery.append('<div id="views-'+ msg.images[i].ctgr +'" class="fg__item set-bg" data-setbg="'+ msg.images[i].img +'">'+
                                        '<div class="fg__item__text">'+
                                                '<span>'+ msg.images[i].label +'</span>'+
                                                '<h2>'+ msg.images[i].nama +'</h2>'+
                                                '<a href="'+ msg.images[i].link +'">'+ msg.images[i].lokasi +'</a>'+
                                            '</div>'+
                                        '</div>');
                                    }
                            }
                        
                            gallery.find('.set-bg').each(function () {
                                var bg = $(this).data('setbg');
                                $(this).css('background-image', 'url(' + bg + ')');
                            });
                            
                            gallery.isotope({
                                itemSelector: '.fg__item',
                                percentPosition: true,
                                masonry: {
                                // use element for option
                                columnWidth: '.fg__item',
                                horizontalOrder: true
                                }
                            });
                            gallery.isotope( 'reloadItems' ).isotope();
                            
                        }
                        control.find("li").on('click', function () {
                            var filterData = $(this).attr("data-filter");
                            gallery.isotope({
                                filter: filterData,
                                });
                            control.find("li").removeClass('active');
                                $(this).addClass('active');
                                return this;
                        });

                        gallery.masonry({
                            itemSelector: '.fg__item',
                            columnWidth: '.grid-sizer',
                            gutter: 15
                        });

                        control.find("[data-filter='*']").click();
                        
					}
				});
                
			};
            

            
        });
</script>
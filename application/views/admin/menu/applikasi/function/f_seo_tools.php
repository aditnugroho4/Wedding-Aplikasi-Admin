<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript">
String.prototype.replaceAll = function(str1, str2, ignore) {
		return this.replace(new RegExp(str1.replace(/([\/\,\!\\\^\$\{\}\[\]\(\)\.\*\+\?\|\<\>\-\&])/g,"\\$&"),(ignore?"gi":"g")),(typeof(str2)=="string")?str2.replace(/\$/g,"$$$$"):str2);
	};
    var selectedId;
    var fildeselect;
	var active;
	var tables;
	var Edit=false;
$(document).ready(function () {
	var $role ="<?php echo $role->id;?>";
	if($role == 1){
		$('[data-toggle="#Aplikasi"]').addClass('menu-open');
			}else{
		$('[data-toggle="#MainMenu"]').addClass('menu-open');
		}

    $('a[href="'+location+'"]').addClass('active');

	var $date = "<?php echo R::isoDateTime(); ?>";
	var $user ="<?php echo $user->id;?>";

	$("#tblData").dataTable({
		"bJQueryUI": true,
		"bAutoWidth": true,
		// "bProcessing": true,
		"iDisplayLength": 15,
		"aLengthMenu": [15, 50, 100, 200],
		"bServerSide": true,
		"sPaginationType": "full_numbers",
		"sAjaxSource": "<?php echo site_url('admin/get_data_table_source'); ?>?table=m_seo&columns=,title,deskripsi",
		"aoColumns": [{
				"sTitle": "#",
				"mData": "no",
				"bSortable": false,
				"sClass": "center"
			},
			{
				"sTitle": "Judul",
				"mData": "title",
				"sClass": "center",
				"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
					var id = "title-" + oData.id;
					$(nTd).attr("id", id);
				}
			},
			{
				"sTitle": "Deskripsi",
				"mData": "deskripsi",
				"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
					var id = "deskripsi-" + oData.id;
					$(nTd).attr("id", id);
				}
            },
            {
				"sTitle": "Keyword",
				"mData": "keyword",
				"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
					var id = "keyword-" + oData.id;
					$(nTd).attr("id", id);
					if(oData.keyword != null){
						var html="";
						var tag = oData.keyword.split(',');
						for (let i = 0; i < tag.length; i++) {
							html +='<span class="badge bg-pink ml-1">'+ tag[i] +'</span>';
						}
						$(nTd).html(html);	
					}
					
                },
            },
            {
				"sTitle": "Image share",
				"mData": "icon",
				"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) { 
						var id = "icon-" + oData.id;
						$(nTd).attr("id", id);
						if(oData.icon == null)
							{
							htmlx= "<div class='from-group'><img class='img-thumbnail' width='65' height='65' src='<?php echo base_url('asset/images/product/no-img.png'); ?>'></div>";
						$(nTd).html(htmlx);
						}else{
							htmlx= "<div class='from-group thumbnail'><img class='img-thumbnail'width='65' height='65' src='<?= base_url(); ?>"+ oData.icon +"' alt='' ></div>";
							$(nTd).html(htmlx);	
						}
				} 
            },{
				"sTitle": "Pembuat",
				"mData": "author",
				"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
					var id = "author-" + oData.id;
					$(nTd).attr("id", id);
                },
            },{
				"sTitle": "Action",
				"sClass": "text-center",
				"mData": "id",
				"bSortable": false,
				"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                    $(nTd).html("<button class='btn btn-xs bg-green'><i class='fas fa-check'> Edit</i></button>");
                    $($(nTd).children()[0]).button().click(function () {
							selectedId = oData.id;
							$("#txtKeyword_e").tagsinput('removeAll');
							$("#txtTitle_e").val(oData.title);
                   			$("#txtDeskripsi_e").val(oData.deskripsi);                   		
                    		$("#txtIcon_e").val(oData.icon);
                    		$("#txtAuthor_e").val(oData.author);
							$("#txtKeyword_e").tagsinput('add',oData.keyword);
                    		$("#txtShortLink_e").val(oData.short_link);
							Edit =true;
							$('#frm-edit').modal('show');
							
						});
				}
			}
		]
	});
	$("#add-data").submit(function (e) {
		e.preventDefault();
		if ($('#add-data').valid()) {
			$('.load-ding-add').append('<div class="overlay"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>');
			var short_link =$("#txtTitle").val();
				short_link = short_link.replaceAll(' ','-');
				short_link = short_link.replaceAll('&','dan');
				short_link = short_link.replaceAll('/','-');
				short_link = short_link.replaceAll('|','-');
				short_link = short_link.replaceAll('--','-');
			$.ajax({
				type: "POST",
				dataType: 'json',
				url: "<?php echo site_url('admin/create/m_seo'); ?>",
				data: {
                    title: $("#txtTitle").val(),
                    deskripsi: $("#txtDeskripsi").val(),
                    keyword: $("#txtKeyword").val(),
                    icon: $("#txtIcon").val(),
                    author: $("#txtAuthor").val(),
                    short_link: short_link
				},
				success: function (ret) {
					var title = "Info";
					var label = "Menyimpan Data";
					var message = " Data Table berhasil di Simpan.";
					$('#add-data')[0].reset();
					alert_info(title, label, message);
					$("#tblData").dataTable().fnDraw();
					$('.load-ding-add').find('.overlay').remove();
					$("#frm-add").modal("hide");
				}
			});
		}
    });
    $('#txtKeyword,#txtKeyword_e').tagsinput({
        tagClass: 'badge bg-info',
        maxChars: 500
		});
	$("#btnAdd").button().click(function () {
		$('#add-data')[0].reset();
		$("#frm-add").modal("show");
	});
	$("#btnReload").button().click(function () {
		$("#tblData").dataTable().fnDraw();
		var title = "Reload..";
		var label = "Data Table..";
		var message = " Data Table berhasil di Refresh..";
		alert_info(title, label, message);
	});
	$("#btnLink").button().click(function () {
		$("#dlg-add_permalink").modal("show");
	});
	$("#btnSetting").button().click(function () {
		$("#dlg-setting_permalink").modal("show");
	});
	$("#btn-simpan-sitempas").attr('disabled',true);
	$("#btnSitemaps").button().click(function () {
		$("#frm-create-sitemaps").modal("show");
		$.ajax({
				type: "POST",
				dataType: 'json',
				url: "<?php echo site_url('admin/create_sitemap_list');?>",
				success: function (data) {
					var HtmL ='';
					if(data){
						HtmL +='<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">\n'+
								'<url>\n'+
									'<loc><?php echo base_url("home");?></loc>\n'+
									'<priority>1.0</priority>\n'+
									'<lastmod>'+ $date +'</lastmod>\n'+
								'</url>\n';
						HtmL +='<url>\n'+
									'<loc><?php echo base_url("services");?></loc>\n'+
									'<priority>1.0</priority>\n'+
									'<lastmod>'+ $date +'</lastmod>\n'+
								'</url>\n';
						HtmL +='<url>\n'+
									'<loc><?php echo base_url("services/detail");?></loc>\n'+
									'<priority>1.0</priority>\n'+
									'<lastmod>'+ $date +'</lastmod>\n'+
								'</url>\n';	
						HtmL +='<url>\n'+
									'<loc><?php echo base_url("home/portfolio");?></loc>\n'+
									'<priority>1.0</priority>\n'+
									'<lastmod>'+ $date +'</lastmod>\n'+
								'</url>\n';
						HtmL +='<url>\n'+
									'<loc><?php echo base_url("home/blog");?></loc>\n'+
									'<priority>1.0</priority>\n'+
									'<lastmod>'+ $date +'</lastmod>\n'+
								'</url>\n';				
						for (var i = 0; i < data.length; i++) {
						HtmL +='<url>\n'+
									'<loc><?php echo base_url('blog/detail/');?>'+ data[i].id +'/'+data[i].short_link+'</loc>\n'+
									'<priority>0.5</priority>\n'+
									'<lastmod>'+ data[i].date +'</lastmod>\n'+
								'</url>\n';
						}
						HtmL +='<url>\n'+
									'<loc><?php echo base_url("home/contact");?></loc>\n'+
									'<priority>1.0</priority>\n'+
									'<lastmod>'+ $date +'</lastmod>\n'+
								'</url>\n';
						HtmL +='<url>\n'+
									'<loc><?php echo base_url("home/page");?></loc>\n'+
									'<priority>1.0</priority>\n'+
									'<lastmod>'+ $date +'</lastmod>\n'+
								'</url>\n';
						HtmL +='</urlset>\n';
						$("#xmlSitemaps").html(HtmL);
						$("#btn-simpan-sitempas").attr('disabled',false);
					}
				}
			});
	});
	$("#edit-data").submit(function(e){ 
		e.preventDefault();
		if($('#edit-data').valid()){
		$('.load-ding-edit').append('<div class="overlay text-center"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>');
        var short_link = $("#txtTitle_e").val();
				short_link = short_link.replaceAll(' ','-');
				short_link = short_link.replaceAll('&','dan');
				short_link = short_link.replaceAll('/','-');
				short_link = short_link.replaceAll('|','-');
				short_link = short_link.replaceAll('--','-');
		$.ajax({type: "POST",
                url: "<?php echo site_url('admin/update/m_seo'); ?>",
                data: { id: selectedId, 
						title: $("#txtTitle_e").val(),
						deskripsi: $("#txtDeskripsi_e").val(),
						keyword: $("#txtKeyword_e").val(),
						icon: $("#txtIcon_e").val(),
						author: $("#txtAuthor_e").val(),
						short_link: short_link
				},success: function(msg) {
                console.log(msg);
					if(msg){
						$("#tblData").dataTable().fnDraw();
						$('.load-ding-edit').find('.overlay').remove();
						$('#edit-data')[0].reset();
						var title = "Edit";
						var label = "Data Table..";
						var message = " Data Table berhasil di Update..";
						alert_info(title, label, message);
						$("#frm-edit").modal("hide");
					}else{
						$("#tblData").dataTable().fnDraw();
						$('.load-ding-edit').find('.overlay').remove();
						var title = "Edit";
						var label = "Data Table..";
						var message = " Data Table Gagal di Update..";
						alert_warning(title, label, message);
						$("#frm-edit").modal("hide");
						}
					Edit=false;
                }
            });
        }
    });
	// Fungsi Pilih Gambar 
    $.search_img = function(){
		if(Edit == true){
		$("#frm-edit").modal("hide");
        $('#frm-find-img').modal('show');
		}else{
			$("#frm-add").modal("hide");
        	$('#frm-find-img').modal('show');	
		}
        $("#cmbImg").empty();
			$.ajax({
				type: "POST",
				dataType: 'json',
				url: "<?php echo site_url('admin/multi_select');?>?table=w_post_images",
				success: function (data) {
					if (data == '') {
						$("#cmbImg").append("<option value=''> -- No Result -- </option>");
					} else {
						for (var i = 0; i < data.length; i++) {
							$("#cmbImg").append("<option value='" + data[i].id + "' data-img_src='<?=base_url()?>" + data[i].img + "' name='" + data[i].img + "'>" + data[i].name + "</option>");
						}
					}
				}
			});
	}
	function drp_template(obj){ /* Fungsi Nyisipin Objek Ke Dropdown Gyus.. */
            var data = $(obj.element).data();
            var text = $(obj.element).text();
            if(data && data['img_src']){
                img_src = data['img_src'];
                template = $("<div class='row'><img class='img-thumbnail img-md col-4' src='" + img_src + "'/><label class='col-8'>" + text + "</label></div>");
                return template;
            }
        }
    var options = {
        'templateSelection': drp_template,
        'templateResult': drp_template,
    }
	$('#cmbImg').select2(options);
	$('.select2').css({'width':'100%'});
	$('.select2-container--default .select2-selection--single').css({'height': '80px'});
	$("#cmbImg").change(function () {
		var img = $("#cmbImg option:selected").attr('name');
		if(Edit == true){
			$("#txtIcon_e").val(img);
			$("#txtIcon_e").attr('disabled','disabled');
			$("#txtIcon_e").val(img);
			$('#frm-find-img').modal('hide');
			$("#frm-edit").modal("show");
		}else {
			$("#txtIcon").val(img);
			$("#txtIcon").attr('disabled','disabled');
			$("#txtImg").val(img);
			$('#frm-find-img').modal('hide');
			$("#frm-add").modal("show");
		}
		});
	// Function End 
	/*
		fungsi membuat count di text-input
		 */
		$.queryLength =function(element,lbl){
			$(element).keyup(function (event) {
				if( event.keyCode == 8 || event.keyCode == 48){
					if($(this).val().length > 0){
						var count = $(this).val().length;
						$(lbl).html(count -1);
					}
				}else{
					if($(this).val().length > 0){
						var count = $(this).val().length;
						$(lbl).html(count);
					}
				}
				return false;
			});	
			}
		/* END */
}); 
	// Alert Toast
		
	function alert_info(title, label, message) {
	        $(document).Toasts('create', {
	            body: message,
	            class: 'bg-info',
	            title: title,
	            subtitle: label,
	            icon: 'far fa-bell',
	            autohide: true,
	            delay: 3000
	        });
	    };

	    function alert_warning(title, label, message) {
	        $(document).Toasts('create', {
	            body: message,
	            class: 'bg-warning',
	            title: title,
	            subtitle: label,
	            icon: 'fas fa-exclamation-circle',
	            autohide: true,
	            delay: 3000
	        });
	    };
		function alert_danger(title, label, message) {
	        $(document).Toasts('create', {
	            body: message,
	            class: 'bg-danger',
	            title: title,
	            subtitle: label,
	            icon: 'fas fa-exclamation-circle',
	            autohide: true,
	            delay: 3000
	        });
	    };
	    function alert_success(title, label, message) {
	        $(document).Toasts('create', {
	            body: message,
	            class: 'bg-success',
	            title: title,
	            subtitle: label,
	            icon: 'far fa-bell',
	            autohide: true,
	            delay: 3000
	        });
	    };
</script>
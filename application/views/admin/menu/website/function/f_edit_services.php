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
	var linkId;
$(document).ready(function () {
	var $role ="<?php echo $role->id;?>";
	if($role == 1){
		$('[data-toggle="#Webportal"]').addClass('menu-open');
			}else{
		$('[data-toggle="#MainMenu"]').addClass('menu-open');
		}

    $('a[href="'+location+'"]').addClass('active');

	var $date = "<?php echo R::isoDateTime(); ?>";
	var $user ="<?php echo $user->id;?>";
	
	$('#btn-draft').attr('disabled',true);
	$('#btn-simpan').attr('disabled',true);
	$_pagination_get();	

	CKEDITOR.replace('txtContent', {
		"height": '600px',
		"extraPlugins" : 'imagebrowser',
		"imageBrowser_listUrl" : "<?php echo site_url('admin/get_images_list');?>?table=w_post_images"
	});
	$('#txtKeyword_e').tagsinput({'tagClass': 'badge bg-info','maxChars': 500,'minChars': 2});
	$('.bootstrap-tagsinput').addClass('form-control');
	$('.bootstrap-tagsinput').css({'min-height':'80px','height':'auto'});
	/* 
		Edit Content Product 	
	*/
	$("#edit-Product").submit(function (e) {
		e.preventDefault();
		if ($('#edit-Product').valid()) {
			$('.load-edit').append('<div class="overlay text-center"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>');
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('admin/update/w_post_kategory'); ?>",
				data: {
					id: selectedId,
					label: $("#txtLabel").val(),
					deskripsi: $("#txtDescproduk").val(),
					title: $("#txtJudul").val(),
					content: CKEDITOR.instances['txtContent'].getData(),
					link_id: linkId,
					user_id:$user,
					date:$date
				},
				success: function (msg) {
					var short_link =$("#txtTitle").val();
						short_link = short_link.replaceAll(' ','-');
						short_link = short_link.replaceAll('&','dan');
						short_link = short_link.replaceAll('/','-');
						short_link = short_link.replaceAll('|','-');
						short_link = short_link.replaceAll('--','-');
					$.ajax({
								type: "POST",
								url: "<?php echo site_url('admin/update/m_seo'); ?>",
								data: {
									id: linkId,
									title: $("#txtTitle").val(),
									deskripsi: $("#txtDeskripsi").val(),
									keyword:$("#txtKeyword_e").val(),
									author:$("#txtAuthor_e").val(),
									short_link:short_link,
									date:$date
								},
								success: function (msg) {
									var title = "Peringatan";
									var label = "Edit Data";
									var message = " Data berhasil di Simpan.";
									alert_warning(title, label, message);
									CKEDITOR.instances['txtContent'].setData('');
									$('#edit-Product')[0].reset();
									$('.load-edit').find('.overlay').remove();
									location.reload();
								}
							});
				}
			});
		}
	});
	$.edit_content = function ($id) {
		$('#edit-Product')[0].reset();
		$('.list-product').hide();
		$('.edit-product').show();
		$('.info-product').attr('class','col-md-12 info-product');
		$('.load-edit').append('<div class="overlay text-center"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>');
		CKEDITOR.instances['txtContent'].setData('');
		$.ajax({
			type: "POST",
			dataType: 'json',
			url: "<?php echo site_url('admin/multi_select');?>?table=w_post_kategory&select=id&id=" + $id,
			success: function (data) {
				$("#txtJudul").val(data[0].title);
				$("#txtLabel").val(data[0].label);
				$("#txtDescproduk").val(data[0].deskripsi);
				CKEDITOR.instances['txtContent'].insertHtml(data[0].content);
				selectedId = data[0].id;
				linkId = data[0].link_id;
				$('.load-edit').find('.overlay').remove();
				$('#btn-draft').attr('disabled',false);
				$('#btn-simpan').attr('disabled',false);
				$.get_seo(linkId);
			}
		});
	}
	$.get_seo = function ($id) {
		$.ajax({
				type: "POST",
				dataType: 'json',
				url: "<?php echo site_url('admin/multi_select');?>?table=m_seo&select=id&id="+$id,
				success: function (data) {
					if (data) {
						$("#txtImg_e").val(data[0].icon);
						$("#txtAuthor_e").val(data[0].author);							
						$("#txtKeyword_e").tagsinput('removeAll');
						$("#txtKeyword_e").tagsinput('add',data[0].keyword);
						$("#txtDeskripsi").val(data[0].deskripsi);
						$("#txtTitle").val(data[0].title);
					}
				}
			});
	}
	$("#btnReload").button().click(function () {
		$_pagination_get();
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
	$("#btnUpload").button().click(function () {
		$("#cmbKategory-upd").empty();
			$.ajax({
				type: "POST",
				dataType: 'json',
				url: "<?php echo site_url('admin/multi_select');?>?table=w_post_kategory",
				success: function (data) {
					if (data == '') {
						$("#cmbKategory-upd").append("<option value=''> -- No Result -- </option>");
					} else {
						$("#cmbKategory-upd").append("<option value=''> -- Silahkan Pilih -- </option>");
						for (var i = 0; i < data.length; i++) {
							$("#cmbKategory-upd").append("<option value='" + data[i].id + "' name='" + data[i].folder + "'>" + data[i].name + "</option>");
						}
					}
					$("#dlg-add_upload").modal("show");
				}
			});
	});
	$("#btn-reset").button().click(function () {
		$('#edit-Product')[0].reset();
		$('.list-product').show();
		$('.edit-product').hide();
		$('.info-product').attr('class','col-md-8 info-product');
		$("#txtKeyword_e").tagsinput('removeAll');
		$("#cmbSeo").empty();
		$('#btn-draft').attr('disabled','disabled');
		$('#btn-simpan').attr('disabled','disabled');
		CKEDITOR.instances['txtContent'].setData('');
	});
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
		/* 
			Fungsi Pilih Gambar 
		*/
		$.search_img = function(){
			$('#frm-find-img').modal('show');
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
		/* Fungsi Nyisipin Objek Ke Dropdown Gyus.. */
		function drp_template(obj){ 
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
					$("#txtImg_e").val(img);
					$("#txtImg_e").attr('disabled','disabled');
					$("#txtImg_e").val(img);
			});		
		/* Function End */
	
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
		function $_pagination_get() {
			$('#pagination').pagination({
				dataSource: '<?= site_url('admin/json_load_data'); ?>?table=w_post_kategory',
				locator: 'data',
				pageSize: 10,
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
						$('.list-product').append('<div class="overlay"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>');
					}
				},
				callback: function (data, pagination) {
					$('.list-product').find('.overlay').remove();
					var html = Templating(data);
					$('.todo-list').html(html);
					var pagebar = $('#pagination');
					pagebar.find('.paginationjs-pages').attr('class', 'card-tools float-right');
					pagebar.find('ul').attr('class', 'pagination pagination-sm');
					pagebar.find('li').attr('class', 'page-item');
					pagebar.find('a').attr('class', 'page-link');
				}
			});
		};
		function Templating(data) {
			var $html = '';
			for (var i = 0, len = data.length; i < len; i++) {
				var time = '00:00:00';
				if (data[i].items.date != null) {
					time = data[i].items.date.substr(0, 10);
				}
				if (data[i].items.product == 'Y') {
				$html += '<li>' +
					'<span class="handle">' +
					'<i class="fas fa-ellipsis-v"></i>' +
					'<i class="fas fa-ellipsis-v"></i>' +
					'</span>' +
					'<span class="text">' + data[i].items.name + '</span>' +
					'<small class="badge badge-danger"><i class="far fa-clock"></i> ' + time + '</small>' +
					'<div class="tools">' +
					'<i onclick="$.edit_content(' + data[i].items.id + ');" class="fas fa-edit"></i>' +
					'<i class="fas fa-trash-o"></i>' +
					'</div>' +
					'</li>';
				}
			}
			return $html;
		};
</script>
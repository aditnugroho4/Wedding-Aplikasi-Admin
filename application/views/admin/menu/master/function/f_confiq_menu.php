<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript">
String.prototype.replaceAll = function(str1, str2, ignore) {
		return this.replace(new RegExp(str1.replace(/([\/\,\!\\\^\$\{\}\[\]\(\)\.\*\+\?\|\<\>\-\&])/g,"\\$&"),(ignore?"gi":"g")),(typeof(str2)=="string")?str2.replace(/\$/g,"$$$$"):str2);
	};
    var selectedId;
	var seoId;
    var fildeselect;
	var active;
	var tables;
	var Edit=false;
	$(document).ready(function () {
		var $role ="<?php echo $role->id;?>";
		if($role == 1){
			$('[data-toggle="#Pengaturan"]').addClass('menu-open');
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
			"sAjaxSource": "<?php echo site_url('admin/get_data_table_source'); ?>?table=m_menu&columns=,menu,id&jwhere=link_id&fildjoins=,m_seo.title,m_seo.icon,m_seo.deskripsi,m_seo.keyword,m_seo.id as seoId,m_seo.author&joins=m_seo&exports=m_seo",
			"aoColumns": [{
					"sTitle": "#",
					"mData": "no",
					"bSortable": false,
					"sClass": "center"
				},
				{
					"sTitle": "Menu",
					"mData": "menu",
					"sClass": "center",
					"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
						var id = "menu-" + oData.id;
						$(nTd).attr("id", id);
					}
				},
				{
					"sTitle": "Title",
					"mData": "title",
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
					"bSortable": false,
					"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
						var id = "keyword-" + oData.id;
						$(nTd).attr("id", id);
						var html="";
						var tag = oData.keyword.split(',');
						for (let i = 0; i < tag.length; i++) {
								html +='<span class="badge bg-pink ml-1">'+ tag[i] +'</span>';
							}
						$(nTd).html(html);	
					}
				},
				{
				"sTitle": "Status",
				"sClass": "text-center",
				"mData": "status",
				"bSortable": false,
				"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
					if (oData.status == 'Y') {
						htmlx = "<button class='btn btn-xs bg-green'><i class='fas fa-check'></i></button>";
						$(nTd).html(htmlx);
						$($(nTd).children()[0]).button().click(function () {
							var id = "status-" + oData.id;
							$(nTd).attr("id", id);
							selectedId = oData.id;
							fildeselect = "status";
							active = 'N';
							$("#txt-status").html("Status akan di Ubah Menjadi Non aktif..?");
							$("#dlg-edit-status").modal("show");
						});
						$($(nTd).children()[0]).find("span").css("padding", "2px 2px");
					} else if (oData.status == 'N') {
						htmlx = "<button class='btn btn-xs bg-danger'><i class='fa fa-ban'></i></button>";
						$(nTd).html(htmlx);
						$($(nTd).children()[0]).button().click(function () {
							var id = "status-" + oData.id;
							$(nTd).attr("id", id);
							fildeselect = "status";
							selectedId = oData.id;
							active = 'Y';
							$("#txt-status").html("Status akan di Ubah Menjadi aktif..?");
							$("#dlg-edit-status").modal("show");
						});
					}
				}
			},
			{
				"sTitle": "Action",
				"sClass": "text-center",
				"mData": "id",
				"bSortable": false,
				"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                    $(nTd).html("<button class='btn btn-xs bg-red'><i class='fas fa-pencil'> Edit</i></button>");
                    $($(nTd).children()[0]).button().click(function () {
							selectedId = oData.id;
							$("#txtMenu_e").val(oData.menu);
							$("#txtTitle_e").val(oData.title);
                   			$("#txtDeskripsi_e").val(oData.deskripsi);                   		
                    		$("#txtImg_e").val(oData.icon);
							$("#txtAuthor_e").val(oData.author);
							$('#txtKeyword_e').tagsinput({
								tagClass: 'badge bg-info',
								maxChars: 500
								});
								
							$("#txtKeyword_e").tagsinput('removeAll');
							$("#txtKeyword_e").tagsinput('add',oData.keyword);	
							Edit =true;
							seoId = oData.seoId;
							$('#frm-edit-menu').modal('show');
						});
				}
			}
			]
		});
		$("#btnAdd").button().click(function () {
			$('#frm-add-menu').modal('show');
			$('#save-data')[0].reset();
			$('#txtKeyword').tagsinput({
				tagClass: 'badge bg-info',
				maxChars: 500
				});
		});
		$("#btnAddSub").button().click(function () {
			$('#frm-add-submenu').modal('show');
			$('#save-data-submenu')[0].reset();
			$('#txtSubKeyword').tagsinput({
				tagClass: 'badge bg-info',
				maxChars: 500
				});
				$("#cmbMenu").empty();
				$.ajax({
					type: "POST",
					dataType: 'json',
					url: "<?php echo site_url('admin/multi_select');?>?table=m_menu",
					success: function (data) {
						if (data == '') {
							$("#cmbMenu").append("<option value=''> -- No Result -- </option>");
						} else {
							$("#cmbMenu").append("<option value=''> -- Pilih Menu Utama -- </option>");
							for (var i = 0; i < data.length; i++) {
								$("#cmbMenu").append("<option value='" + data[i].id + "'>" + data[i].menu + "</option>");
							}
						}
					}
				});
		});
		$("#save-data").submit(function (e) {
			e.preventDefault();
			if ($('#save-data').valid()) {
				var parsings = $("#txtTitle").val();
				parsings = parsings.replaceAll(".", "-");
				parsings = parsings.replaceAll("&", "dan");
				parsings = parsings.replaceAll("|", "_");
				$('.load-ding-add').append('<div class="overlay text-center"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>');
				$.ajax({
					type: "POST",
					dataType: 'json',
					url: "<?php echo site_url('admin/create/m_seo'); ?>",
					data: {
						title: $("#txtTitle").val(),
						deskripsi: $("#txtDeskripsi").val(),
						keyword: $("#txtKeyword").val(),
						icon: $("#txtImg").val(),
						author: $("#txtAuthor").val(),
						short_link: parsings,
						date:$date
					},
					success: function (ret) {
						if(ret.error == false){
							$.ajax({
								type: "POST",
								dataType: 'json',
								url: "<?php echo site_url('admin/create/m_menu'); ?>",
								data: {
									menu: $("#txtMenu").val(),
									link_id: ret.id,
									status:'Y',
									date:$date
								},
								success: function (msg) {
									var title = "Info";
									var label = "Menyimpan Data";
									var message = " Data Table berhasil di Simpan.";
									$('#save-data')[0].reset();
									alert_info(title, label, message);
									$("#tblData").dataTable().fnDraw();
									$('.load-ding-add').find('.overlay').remove();
									$("#frm-add-menu").modal("hide");
									}
								});
							}
						}
					});
				}
    		});
		$("#btnReload").button().click(function () {
			$("#tblData").dataTable().fnDraw();
			var title = "Reload..";
			var label = "Data Table..";
			var message = " Data Table berhasil di Refresh..";
			alert_info(title, label, message);
		});
		$("#edit-data").submit(function (e) {
			e.preventDefault();
			if ($('#edit-data').valid()) {
				var parsings = $("#txtTitle_e").val();
				parsings = parsings.replaceAll(".", "-");
				parsings = parsings.replaceAll("&", "dan");
				parsings = parsings.replaceAll("|", "-");
				$('.load-ding-edit').append('<div class="overlay text-center"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>');
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('admin/update/m_menu'); ?>",
					data: {
						id: selectedId,
						menu: $("#txtMenu_e").val(),
						link_id: seoId,
						date: $date
					},
					success: function (msg) {
						if (msg) {
							$.ajax({
								type: "POST",
								url: "<?php echo site_url('admin/update/m_seo'); ?>",
								data: {
									id: seoId,
									title: $("#txtTitle_e").val(),
									deskripsi: $("#txtDeskripsi_e").val(),
									keyword: $("#txtKeyword_e").val(),
									icon: $("#txtImg_e").val(),
									author: $("#txtAuthor_e").val(),
									short_link: parsings,
									date:$date
								},
								success: function (msg) {
									if (msg) {
										$("#tblData").dataTable().fnDraw();
										$('.load-ding-edit').find('.overlay').remove();
										$('#edit-data')[0].reset();
										var title = "Edit";
										var label = "Data Table..";
										var message = " Data Table berhasil di Update..";
										alert_info(title, label, message);
										$("#frm-edit-menu").modal("hide");
									} else {
										$("#tblData").dataTable().fnDraw();
										$('.load-ding-edit').find('.overlay').remove();
										var title = "Edit";
										var label = "Data Table..";
										var message = " Data Table Gagal di Update..";
										alert_warning(title, label, message);
										$("#frm-edit-menu").modal("hide");
									}
									Edit = false;
								}
							});
						}
					}
				});
			}
		});
		$("#save-data-submenu").submit(function (e) {
			e.preventDefault();
			if ($('#save-data-submenu').valid()) {
				var parsings = $("#txtTitle").val();
				parsings = parsings.replaceAll(".", "-");
				parsings = parsings.replaceAll("&", "dan");
				parsings = parsings.replaceAll("|", "-");
				$('.load-ding-sub').append('<div class="overlay text-center"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>');
				$.ajax({
					type: "POST",
					dataType: 'json',
					url: "<?php echo site_url('admin/create/m_seo'); ?>",
					data: {
						title: $("#txtSubTitle").val(),
						deskripsi: $("#txtSubDeskripsi").val(),
						keyword: $("#txtSubKeyword").val(),
						icon: $("#txtSubImg").val(),
						author: $("#txtSubAuthor").val(),
						short_link: parsings,
						date:$date
					},
					success: function (ret) {
						if(ret.error == false){
							$.ajax({
								type: "POST",
								dataType: 'json',
								url: "<?php echo site_url('admin/create/m_menu'); ?>",
								data: {
									name: $("#txtSubMenu").val(),
									menu_id:$("#cmbMenu option:selected").val(),
									link_id: ret.id,
									status:'Y',
									date:$date
								},
								success: function (msg) {
									var title = "Info";
									var label = "Menyimpan Data";
									var message = " Data Table berhasil di Simpan.";
									$('#save-data-submenu')[0].reset();
									alert_info(title, label, message);
									$("#tblData").dataTable().fnDraw();
									$('.load-ding-sub').find('.overlay').remove();
									$("#frm-add-submenu").modal("hide");
									}
								});
							}
						}
					});
				}
    		});
		/*
			fungsi Copy Paste text-input
		 */
		// $('#click-copy').click(function(){
		// 	$(this).siblings('#txtCopy').select();      
		// 	document.execCommand("copy");
		// 	alert('Paste text '+ $("#txtCopy").val()+' Di Colom Table');
		// 	$("#txtCopy").attr('disabled','disabled');
		// 	$('#frm-find-img').modal('hide');
		// });
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
				if(Edit == true){
					$("#txtImg_e").val(img);
					$("#txtImg_e").attr('disabled','disabled');
					$("#txtImg_e").val(img);
				}else {
					$("#txtImg").val(img);
					$("#txtImg").attr('disabled','disabled');
					$("#txtImg").val(img);
				}
			});		
		/* Function End */
	}); 
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
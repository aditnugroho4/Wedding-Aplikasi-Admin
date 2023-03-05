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
	var Data;
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
			"sAjaxSource": "<?php echo site_url('admin/get_data_table_source'); ?>?table=m_confiq&columns=,name,variabel",
			"aoColumns": [{
					"sTitle": "#",
					"mData": "no",
					"bSortable": false,
					"sClass": "center"
				},
				{
					"sTitle": "Code",
					"mData": "code",
					"sClass": "center",
					"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
						var id = "code-" + oData.id;
						$(nTd).attr("id", id);
					}
				},
				{
					"sTitle": "Name",
					"mData": "name",
					"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
						var id = "name-" + oData.id;
						$(nTd).attr("id", id);
					}
				},
				{
					"sTitle": "Variabel",
					"mData": "variabel",
					"bSortable": false,
					"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
						var id = "variabel-" + oData.id;
						$(nTd).attr("id", id);
						if(oData.name == 'Keyword'){
								var html="";
								var tag = oData.variabel.split(',');
								for (let i = 0; i < tag.length; i++) {
									html +='<span class="badge bg-pink ml-1">'+ tag[i] +'</span>';
								}
								$(nTd).html(html);	
							}
					}
				}
			]
		});
		$("#btnGallery").button().click(function () {
			$.search_img();
		});

		$("#btnEdit").button().click(function () {
			
			$.ajax({
					type: "POST",
					dataType: 'json',
					url: "<?php echo site_url('admin/multi_select');?>?table=m_confiq",
					success: function (data) {
						if (data) {
							Data = data;
							$("#frm-edit-confiq").modal('show');
							for (var i = 0; i < data.length; i++) {
								if(data[i].name == 'Title'){
									$("#txtTitle").val(data[i].variabel);
								}
								if(data[i].name == 'Deskripsi'){
									$("#txtDeskripsi").val(data[i].variabel);
								}
								if(data[i].name == 'Logo'){
									$("#txtImg").val(data[i].variabel);
								}
								if(data[i].name == 'Vendor'){
									$("#txtAuthor").val(data[i].variabel);
								}
								if(data[i].name == 'Keyword'){
									$('#txtKeyword').tagsinput({
										tagClass: 'badge bg-info',
										maxChars: 500
										});
									$("#txtKeyword").tagsinput('removeAll',);
									$("#txtKeyword").tagsinput('add',data[i].variabel);
								}
							}
						}
					}
				});
		});
		$("#save-data").submit(function (e) {
			e.preventDefault();
			if ($('#save-data').valid()) {
				$('.load-ding-add').append('<div class="overlay text-center"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>');
				for (var i = 0; i < Data.length; i++) {
						if(Data[i].name == 'Title'){
							$.ajax({type: "POST",dataType: 'json',url: "<?php echo site_url('admin/update/m_confiq'); ?>",
								data: { id: Data[i].id,variabel: $("#txtTitle").val()},
								success: function (msg) {}
							});
							}
						if(Data[i].name == 'Deskripsi'){
							$.ajax({type: "POST",dataType: 'json',url: "<?php echo site_url('admin/update/m_confiq'); ?>",
								data: { id: Data[i].id,variabel: $("#txtDeskripsi").val()},
								success: function (msg) {}
							});
						}
						if(Data[i].name == 'Logo'){
							$.ajax({type: "POST",dataType: 'json',url: "<?php echo site_url('admin/update/m_confiq'); ?>",
								data: { id: Data[i].id,variabel: $("#txtImg").val()},
								success: function (msg) {}
							});
						}
						if(Data[i].name == 'Vendor'){
							$.ajax({type: "POST",dataType: 'json',url: "<?php echo site_url('admin/update/m_confiq'); ?>",
								data: { id: Data[i].id,variabel: $("#txtAuthor").val()},
								success: function (msg) {}
							});
						}
						if(Data[i].name == 'Keyword'){
							$.ajax({type: "POST",dataType: 'json',url: "<?php echo site_url('admin/update/m_confiq'); ?>",
								data: { id: Data[i].id,variabel: $("#txtKeyword").val()},
								success: function (msg) {}
							});
						}
					}

					var title = "Info";
					var label = "Menyimpan Data";
					var message = " Data Table berhasil di Simpan.";
						$('#save-data')[0].reset();
						alert_info(title, label, message);
						$("#tblData").dataTable().fnDraw();
						$('.load-ding-add').find('.overlay').remove();
						$("#frm-edit-confiq").modal("hide");
				}
				
    		});
		$("#btnReload").button().click(function () {
			$("#tblData").dataTable().fnDraw();
			var title = "Reload..";
			var label = "Data Table..";
			var message = " Data Table berhasil di Refresh..";
			alert_info(title, label, message);
		});
		$('#click-copy').click(function(){
			$(this).siblings('#txtCopy').select();      
			document.execCommand("copy");
			alert('Paste text '+ $("#txtCopy").val()+' Di Colom Table');
			$("#txtCopy").attr('disabled','disabled');
			$("#txtImg").val($("#txtCopy").val());
			$('#frm-find-img').modal('hide');
		});
	
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
		// Fungsi Pilih Gambar 
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
			var link_img = $("#cmbImg option:selected").attr('name');
				$("#txtCopy").val(link_img);
				$("#txtImg").val(link_img);
				
			});		
		// Function End 
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
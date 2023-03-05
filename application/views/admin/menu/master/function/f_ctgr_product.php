<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript">
String.prototype.replaceAll = function(str1, str2, ignore) {
		return this.replace(new RegExp(str1.replace(/([\/\,\!\\\^\$\{\}\[\]\(\)\.\*\+\?\|\<\>\-\&])/g,"\\$&"),(ignore?"gi":"g")),(typeof(str2)=="string")?str2.replace(/\$/g,"$$$$"):str2);
	};
    var selectedId;
    var fildeselect;
	var active;
	var tables;
$(document).ready(function () {
	var $role ="<?php echo $role->id;?>";
	if($role == 1){
		$('[data-toggle="#Datamaster"]').addClass('menu-open');
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
		"sAjaxSource": "<?php echo site_url('admin/get_data_table_source'); ?>?table=w_post_kategory&columns=,name",
		"aoColumns": [{
				"sTitle": "#",
				"mData": "no",
				"bSortable": false,
				"sClass": "center"
			},
			{
				"sTitle": "Nama",
				"mData": "name",
				"sClass": "center",
				"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
					var id = "name-" + oData.id;
					$(nTd).attr("id", id);
					$(nTd).editable("<?php echo site_url('admin/update_grid/w_post_kategory'); ?>", {
						"callback": function (sValue, y) {
							/* Redraw the table from the new data on the server */
							$("#tblData").dataTable().fnDraw();
						}
					});
				}
			},{
				"sTitle": "Status Product",
				"sClass": "text-center",
				"mData": "product",
				"bSortable": false,
				"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
					if (oData.product == 'Y') {
						htmlx = "<button class='btn btn-xs bg-green'><i class='fas fa-check'></i></button>";
						$(nTd).html(htmlx);
						$($(nTd).children()[0]).button().click(function () {
							var id = "product-" + oData.id;
							$(nTd).attr("id", id);
							selectedId = oData.id;
							fildeselect = "product";
							active = null;
							tables="w_post_kategory";
							$("#txtDecision").html("Status akan di Ubah Menjadi Non aktif..?");
							$("#dlgDecision").modal("show");
						});
						$($(nTd).children()[0]).find("span").css("padding", "2px 2px");
					} else if (oData.product == null) {
						htmlx = "<button class='btn btn-xs bg-danger'><i class='fa fa-ban'></i></button>";
						$(nTd).html(htmlx);
						$($(nTd).children()[0]).button().click(function () {
							var id = "product-" + oData.id;
							$(nTd).attr("id", id);
							fildeselect = "product";
							selectedId = oData.id;
							active = 'Y';
							tables="w_post_kategory";
							$("#txtDecision").html("Status akan di Ubah Menjadi aktif..?");
							$("#dlgDecision").modal("show");
						});
					}
				}
			},
		]
	});

	$("#add-data").submit(function (e) {
		e.preventDefault();
		if ($('#add-data').valid()) {
			$('.load-ding-add').append('<div class="overlay"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>');
			$.ajax({
				type: "POST",
				dataType: 'json',
				url: "<?php echo site_url('admin/create/w_post_kategory'); ?>",
				data: {
					name: $("#txtName").val()
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

	$('#btn-prosess').button().click(function () {
		$.ajax({
			url: "<?php echo site_url('admin/aktive'); ?>/"+tables+"/" + fildeselect + "/" + selectedId + "/" + active,
			success: function (data) {
				$("#tblData").dataTable().fnDraw();
				$("#dlgDecision").modal("hide");
			}
		});
	});
	
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
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript">
	String.prototype.replaceAll = function(str1, str2, ignore) {
		return this.replace(new RegExp(str1.replace(/([\/\,\!\\\^\$\{\}\[\]\(\)\.\*\+\?\|\<\>\-\&])/g,"\\$&"),(ignore?"gi":"g")),(typeof(str2)=="string")?str2.replace(/\$/g,"$$$$"):str2);
		};
	var Table ='';
	var cookie;
    var selectedId;
	var idval;
	$(document).ready(function () {
	$('[data-toggle="#Datamaster"]').addClass('menu-open');
    $('a[href="'+location+'"]').addClass('active');
	
	$("#tblData").dataTable({
		"bJQueryUI": true,
		"bAutoWidth": true,
		// "bProcessing": true,
		"bServerSide": true,
		"sPaginationType": "full_numbers",
		"sAjaxSource": "<?php echo site_url('admin/get_data_table_source'); ?>?table=n_submenu&columns=,nama_submenu,link_submenu,nama_menu,m_role.name&jwhere=role_id,menu_id,n_menu.unit_id&fildjoins=,n_menu.nama_menu,m_role.name,m_unit.name as unit&joins=m_role,n_menu,m_unit&exports=m_role,n_menu,m_unit",
		"aoColumns": [{
				"sTitle": "#",
				"mData": "no",
				"bSortable": false,
				"sClass": "center"
			},
			{
				"sTitle": "Nama Submenu",
				"mData": "nama_submenu",
				"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
					var id = "nama_submenu-" + oData.id;
					$(nTd).attr("id", id);
					$(nTd).editable("<?php echo site_url('admin/update_grid/n_submenu'); ?>", {
						"callback": function (sValue, y) {
							/* Redraw the table from the new data on the server */
							$("#tblData").dataTable().fnDraw();
						}
					});
				}
			},
			{
				"sTitle": "Link Module",
				"mData": "link_submenu",
				"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
					var id = "link_submenu-" + oData.id;
					$(nTd).attr("id", id);
					$(nTd).editable("<?php echo site_url('admin/update_grid/n_submenu'); ?>", {
						"callback": function (sValue, y) {
							/* Redraw the table from the new data on the server */
							$("#tblData").dataTable().fnDraw();
						}
					});
				}
			},
			{
				"sTitle": "Struktur Menu",
				"mData": "unit",
				"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
					var id = "menu_id-" + oData.id;
					$(nTd).attr("id", id);
					/* $(nTd).editable("<?php echo site_url('admin/update_grid/n_submenu'); ?>?table=n_menu", { 
						loadurl : "<?php echo site_url('admin/get_editable_select'); ?>?table=n_menu&filds=struktur_id&select=" + oData.menu_id,
						type   : "select",
						submit : "OK",
						"callback": function( sValue, y ) {
							/* Redraw the table from the new data on the server
							$("#tblData").dataTable().fnDraw();
						}
					});*/
				}
			},
			{
				"sTitle": "Menu Position",
				"mData": "nama_menu",
				"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
					var id = "menu_id-" + oData.id;
					$(nTd).attr("id", id);
					$(nTd).editable("<?php echo site_url('admin/update_grid/n_submenu'); ?>?table=n_menu", {
						loadurl: "<?php echo site_url('admin/get_editable_select'); ?>?table=n_menu&filds=nama_menu&select=" + oData.menu_id,
						type: "select",
						submit: "OK",
						"callback": function (sValue, y) {
							/* Redraw the table from the new data on the server*/
							$("#tblData").dataTable().fnDraw();
						}
					});
				}
			},
			{
				"sTitle": "Level User",
				"mData": "name",
				"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
					var id = "role_id-" + oData.id;
					$(nTd).attr("id", id);
					$(nTd).editable("<?php echo site_url('admin/update_grid/n_submenu/'); ?>?table=m_role", {
						loadurl: "<?php echo site_url('admin/get_editable_select'); ?>?table=m_role&filds=name&select=" + oData.role_id,
						type: "select",
						submit: "OK",
						"callback": function (sValue, y) {
							/* Redraw the table from the new data on the server */
							$("#tblData").dataTable().fnDraw();
						}
					});
				}
			},
			{
				"sTitle": "Urut Togle",
				"mData": "urutan",
				"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
					var id = "urutan-" + oData.id;
					$(nTd).attr("id", id);
					$(nTd).editable("<?php echo site_url('admin/update_grid/n_submenu'); ?>", {
						type: "select",
						data: "{'1':'1','2':'2','3':'3','4':'4','5':'5','6':'6','7':'7','8':'8','9':'9','10':'10'}",
						submit: "OK",
						"callback": function (sValue, y) {
							/* Redraw the table from the new data on the server*/
							$("#tblData").dataTable().fnDraw();
						}
					});
				}
			},
			{
				"sTitle": "Action",
				"sClass": "text-center",
				"mData": null,
				"bSortable": false,
				"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
					if (oData.active == 'Y') {
						htmlx = "<button class='btn btn-xs bg-green'><i class='fas fa-check'></i></button>";
						$(nTd).html(htmlx);
						$($(nTd).children()[0]).button().click(function () {
							var id = "active-" + oData.id;
							$(nTd).attr("id", id);
							selectedId = oData.id;
							active = 'N';
							$("#lblText").html("Menu ini akan di non aktive..?");
							$("#dlgAlert").modal("show")
						});
					} else if (oData.active == 'N') {
						htmlx = "<button class='btn btn-xs bg-danger'><i class='fa fa-ban'></i></button>";
						$(nTd).html(htmlx);
						$($(nTd).children()[0]).button().click(function () {
							var id = "active-" + oData.id;
							$(nTd).attr("id", id);
							selectedId = oData.id;
							active = 'Y';
							$("#lblText").html("Menu ini akan di aktive kan..?");
							$("#dlgAlert").modal("show");
						});
					}
				}
			}
		]
	});

		$('#btnChange').button().click(function () {
			$.ajax({
				type: "POST",
				dataType: 'json',
				url: "<?php echo site_url('admin/aktive/n_submenu/active'); ?>/" + selectedId + "/" + active,
				success: function (msg) {
					if(msg.error==false){
						$("#tblData").dataTable().fnDraw();
						$.swalDefaultAlert("error: " + msg.error + "<br> Code: " + msg.code + " <br> message: " + msg.message,'success');
					}else{
						$.swalDefaultAlert("error: " + msg.error + "<br> Code: " + msg.code + " <br> message: " + msg.message,'warning');
					}
					
				}
			});
			$("#dlgAlert").modal("hide");
		});
		$.Delete = function () {
			$.ajax({
				type: "POST",
				dataType: 'json',
				url: "<?php echo site_url('admin/delete/n_menu'); ?>/" + selectedId,
				success: function (msg) {
					if(msg.error==false){
						$("#tblData").dataTable().fnDraw();
						$.swalDefaultAlert("error: " + msg.error + "<br> Code: " + msg.code + " <br> message: " + msg.message,'success');
					}else{
						$.swalDefaultAlert("error: " + msg.error + "<br> Code: " + msg.code + " <br> message: " + msg.message,'warning');
					}
				}
			});
			$(this).dialog("close");
		}
		$("#btnReload").button().click(function () {
	        $("#tblData").dataTable().fnDraw();
	        var title = "Reload..";
	        var label = "Data Table..";
	        var message = " Data Table berhasil di Refresh..";
			$.swalDefaultAlert(title + "<br> " + label + " <br> message: " + message,'info');
			
		});

		$('#add-data').submit(function (e) {
			e.preventDefault();
			if ($('#add-data').valid()) {
				$.ajax({
					type: "POST",
					dataType: 'json',
					url: "<?php echo site_url('admin/create/n_submenu'); ?>",
					data: {
						nama_submenu: $("#txtContent").val(),
						link_submenu: $("#txtFolder").val(),
						menu_id: $("#cmbNamaMenu option:selected").val(),
						role_id: $("#cmbRole option:selected").val(),
						active: 'N'
					},
					success: function (msg) {
						if(msg.error==false){
						$("#tblData").dataTable().fnDraw();
						$.swalDefaultAlert("error: " + msg.error + "<br> Code: " + msg.code + " <br> message: " + msg.message,'success');
						}else{
							$.swalDefaultAlert("error: " + msg.error + "<br> Code: " + msg.code + " <br> message: " + msg.message,'warning');
						}
						$('#frm-add').modal('hide');
					},
					cache: false
				});
				return false;
			}
		});
		$("#btnAdd").button().click(function () {
			$('#add-data')[0].reset();
			$.ajax({
				type: "POST",
				dataType: 'json',
				url: "<?php echo site_url('admin/multi_select');?>?table=m_struktur",
				success: function (data) {
					$("#cmbStruktur").empty();
					if (data == '') {
						$("#cmbStruktur").append("<option value=''> -- No Result -- </option>");
					} else {
						$('#frm-add').modal('show');
						$("#cmbStruktur").append("<option value=''> -- Silahkan Pilih -- </option>");
						for (var i = 0; i < data.length; i++) {
							$("#cmbStruktur").append('<option value="' + data[i].id + '">' + data[i].name + '</option>');
						}
					}
				}
			});
		});
		$("#cmbStruktur").change(function () {
			$.ajax({
				type: "POST",
				dataType: 'json',
				url: "<?php echo site_url('admin/multi_select');?>?table=m_unit&select=struktur_id&id=" + $(this).val(),
				success: function (data) {
					$("#cmbUnit").empty();
					if (data == '') {
						$("#cmbUnit").append("<option value=''> -- No Result -- </option>");
					} else {
						$("#cmbUnit").append("<option value=''> -- Silahkan Pilih -- </option>");
						for (var i = 0; i < data.length; i++) {
							$("#cmbUnit").append('<option value="' + data[i].id + '">' + data[i].name + '</option>');
						}
					}
				}
			});
		});
		$("#cmbUnit").change(function () {
			$.ajax({
				type: "POST",
				dataType: 'json',
				url: "<?php echo site_url('admin/multi_select');?>?table=m_role&select=unit_id&id=" + $(this).val(),
				success: function (data) {
					$("#cmbRole").empty();
					if (data == '') {
						$("#cmbRole").append("<option value=''> -- No Result -- </option>");
					} else {
						$("#cmbRole").append("<option value=''> -- Silahkan Pilih -- </option>");
						for (var i = 0; i < data.length; i++) {
							$("#cmbRole").append('<option value="' + data[i].id + '">' + data[i].name + '</option>');
						}
					}
				}
			});
		});
		$("#cmbRole").change(function () {
			$.ajax({
				type: "POST",
				dataType: 'json',
				url: "<?php echo site_url('admin/multi_select');?>?table=n_menu&select=unit_id&id=" + $("#cmbStruktur option:selected").val(),
				success: function (data) {
					$("#cmbNamaMenu").empty();
					if (data == '') {
						$("#cmbNamaMenu").append("<option value=''> -- No Result -- </option>");
					} else {
						$("#cmbNamaMenu").append("<option value=''> -- Silahkan Pilih -- </option>");
						for (var i = 0; i < data.length; i++) {
							$("#cmbNamaMenu").append('<option value="' + data[i].id + '">' + data[i].nama_menu + '</option>');
						}
					}
					$("#txtFolder").focus();
				}
			});
		});


		// alert //
		const Toast = Swal.mixin({
			toast: true,
			position: 'top-end',
			showConfirmButton: false,
			timer: 3000
		});

		$.swalDefaultAlert = function(label,icons) {
			Toast.fire({
				icon: icons,
				title: label
			})
		}
	}); 
</script>
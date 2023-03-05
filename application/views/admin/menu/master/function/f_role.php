<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript">
	String.prototype.replaceAll = function(str1, str2, ignore) 
			{
				return this.replace(new RegExp(str1.replace(/([\/\,\!\\\^\$\{\}\[\]\(\)\.\*\+\?\|\<\>\-\&])/g,"\\$&"),(ignore?"gi":"g")),(typeof(str2)=="string")?str2.replace(/\$/g,"$$$$"):str2);
			};	
			var htmlx='';
            var selectedId;
	$(document).ready(function () {
		$('[data-toggle="#Datamaster"]').addClass('menu-open');
		$('a[href="' + location + '"]').addClass('active');

		$("#tblData").dataTable({
			"bJQueryUI": true,
			"bAutoWidth": true,
			// "bProcessing": true,
			"iDisplayLength": 15,
			"aLengthMenu": [15, 50, 100, 200],
			"bServerSide": true,
			"sPaginationType": "full_numbers",
			"sAjaxSource": "<?php echo site_url('admin/get_data_table_source'); ?>?table=m_role&columns=,m_role.name,m_role.unit_id&jwhere=unit_id&fildjoins=,m_unit.name as nama&joins=m_unit&exports=m_unit",
			"aoColumns": [{
					"sTitle": "#",
					"mData": "no",
					"bSortable": false,
					"sClass": "center"
				},
				{
					"sTitle": "UNIT / BAGIAN",
					"mData": "nama",
					"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
						var id = "instalasi_id-" + oData.id;
						$(nTd).attr("id", id);
						$(nTd).editable("<?php echo site_url('admin/update_grid/m_role'); ?>?table=m_unit", {
							loadurl: "<?php echo site_url('admin/get_editable_select'); ?>?table=m_unit&filds=name&select=" + oData.instalasi_id,
							type: "select",
							submit: "OK",
							"callback": function (sValue, y) {
								/*Redraw the table from the new data on the server */
								$("#tblData").dataTable().fnDraw();
							}
						});
					}
				},
				{
					"sTitle": "Level / Role",
					"mData": "name",
					"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
						var id = "name-" + oData.id;
						$(nTd).attr("id", id);
						$(nTd).editable("<?php echo site_url('admin/update_grid/m_role'); ?>", {
							"callback": function (sValue, y) {
								/* Redraw the table from the new data on the server */
								$("#tblData").dataTable().fnDraw();
							}
						});
					}
				}

			]
		});
		$("#add-data").submit(function (e) {
			e.preventDefault();
			if ($('#add-data').valid()) {
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('admin/create/m_role'); ?>",
					data: {
						name: $("#txtRole").val(),
						unit_id: $("#cmbUnit").val()
					},
					success: function (msg) {
	                    $("#frm-add").modal("hide");
	                    console.log(msg);
	                    $("#tblData").dataTable().fnDraw();
	                    var title = "Info";
	                    var label = "Menyimpan Data";
	                    var message = " Data Table berhasil di Simpan.";
	                    $('#add-data')[0].reset();
	                    alert_info(title, label, message);
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
					if (data == '') {
						var options = "<option value=''> -- No Result -- </option>";
					} else {
						var options = "<option value=''> -- Silahkan Pilih -- </option>";
						for (var i = 0; i < data.length; i++) {

							options += "<option value='" + data[i].id + "'>" + data[i].name + "</option>";
						}
						$("#frm-add").modal("show");
					}
					$("#cmbStruktur").html(options);
				}
			});
		});
		$("#cmbStruktur").change(function () {
			$.ajax({
				type: "POST",
				dataType: 'json',
				url: "<?php echo site_url('admin/multi_select');?>?table=m_unit&select=struktur_id&id=" + $(this).val(),
				success: function (data) {
					if (data == '') {
						var options = "<option value=''> -- No Result -- </option>";
					} else {
						var options = "<option value=''> -- Silahkan Pilih -- </option>";
						for (var i = 0; i < data.length; i++) {

							options += "<option value='" + data[i].id + "'>" + data[i].name + "</option>";
						}
					}
					$("#cmbUnit").html(options);

				}
			});
		});
		$("#btnReload").button().click(function () {
	        $("#tblData").dataTable().fnDraw();
	        var title = "Reload..";
	        var label = "Data Table..";
	        var message = " Data Table berhasil di Refresh..";
	        alert_info(title, label, message);
	    });
		// Alert Toast
	    function alert_info(title, label, message) {
	        $(document).Toasts('create', {
	            body: message,
	            class: 'bg-info',
	            title: title,
	            subtitle: label,
	            icon: 'fas fa-envelope fa-lg',
	            autohide: true,
	            delay: 1000
	        });
	    };

	    function alert_warning(title, label, message) {
	        $(document).Toasts('create', {
	            body: message,
	            class: 'bg-warning',
	            title: title,
	            subtitle: label,
	            icon: 'fas fa-envelope fa-lg',
	            autohide: true,
	            delay: 1000
	        });
	    };

	    function alert_success(title, label, message) {
	        $(document).Toasts('create', {
	            body: message,
	            class: 'bg-success',
	            title: title,
	            subtitle: label,
	            icon: 'fas fa-envelope fa-lg',
	            autohide: true,
	            delay: 1000
	        });
	    };
	});
</script>
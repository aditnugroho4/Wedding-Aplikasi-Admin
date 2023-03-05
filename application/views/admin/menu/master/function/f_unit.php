<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript">
	String.prototype.replaceAll = function (str1, str2, ignore) {
		return this.replace(new RegExp(str1.replace(/([\/\,\!\\\^\$\{\}\[\]\(\)\.\*\+\?\|\<\>\-\&])/g, "\\$&"), (ignore ? "gi" : "g")), (typeof (str2) == "string") ? str2.replace(/\$/g, "$$$$") : str2);
	};
	var htmlx = '';
	var selectedId;
	var menu = {
		codeunit: '',
		namaunit: ''
	};
	$(document).ready(function () {
		$('[data-toggle="#Datamaster"]').addClass('menu-open');
		$('a[href="'+location+'"]').addClass('active');	
	
		$("#tblData").dataTable({
			"bJQueryUI": true,
			"bAutoWidth": true,
			// "bProcessing": true,
			"iDisplayLength": 15,
			"aLengthMenu": [15, 50, 100, 200],
			"bServerSide": true,
			"sPaginationType": "full_numbers",
			"sAjaxSource": "<?php echo site_url('admin/get_data_table_source'); ?>?table=m_unit&columns=,m_unit.name,m_struktur.name&jwhere=struktur_id&fildjoins=,m_struktur.name as nama &joins=m_struktur&exports=m_struktur",
			"aoColumns": [{
					"sTitle": "#",
					"mData": "no",
					"bSortable": false,
					"sClass": "center"
				},
				{
					"sTitle": "CODE",
					"mData": "code",
					"sClass": "center",
					"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
						var id = "code-" + oData.id;
						$(nTd).attr("id", id);
						$(nTd).editable("<?php echo site_url('admin/update_grid/m_unit'); ?>", {
							"callback": function (sValue, y) {
								/* Redraw the table from the new data on the server */
								$("#tblData").dataTable().fnDraw();
							}
						});
					}
				},
				{
					"sTitle": "Struktural",
					"mData": "nama",
					"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
						var id = "struktur_id-" + oData.id;
						$(nTd).attr("id", id);
						$(nTd).editable("<?php echo site_url('admin/update_grid/m_unit'); ?>?table=m_struktur", {
							loadurl: "<?php echo site_url('admin/get_editable_select'); ?>?table=m_struktur&filds=name&select=" + oData.struktur_id,
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
					"sTitle": "Unit / Bagian",
					"mData": "name",
					"sClass": "center",
					"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
						var id = "name-" + oData.id;
						$(nTd).attr("id", id);
						$(nTd).editable("<?php echo site_url('admin/update_grid/m_unit'); ?>", {
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
					dataType: 'json',
					url: "<?php echo site_url('admin/create/m_unit'); ?>",
					data: {
						name: $("#txtName").val(),
						struktur_id: $("#cmbStruktur option:selected").val()
					},
					success: function (ret) {
						$("#frm-add").modal("hide");
						var title = "Info";
	                    var label = "Menyimpan Data";
	                    var message = " Data Table berhasil di Simpan.";
	                    $('#add-data')[0].reset();
	                    alert_info(title, label, message);
						$("#tblData").dataTable().fnDraw();
					}
				});
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
						$("#cmbStruktur").append("<option value=''> -- No Result -- </option>");
					} else {
						$("#cmbStruktur").append("<option value=''> -- Silahkan Pilih -- </option>");
						for (var i = 0; i < data.length; i++) {
							$("#cmbStruktur").append('<option value="' + data[i].id + '">' + data[i].name + '</option>');
						}
						$("#frm-add").modal("show");
					}
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
	            delay: 750
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
	            delay: 750
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
	            delay: 750
	        });
	    };

	}); 

</script>
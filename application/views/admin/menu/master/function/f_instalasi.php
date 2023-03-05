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
		Globalize.culture("id-ID");
		$('a[href="#Support"]').attr('class', 'menu-toggle waves-effect waves-block toggled');
        $('.count-to').countTo();
        $('select').selectpicker();
		$("#tblData").dataTable({
			"bJQueryUI": true,
			"bAutoWidth": true,
			// "bProcessing": true,
			"iDisplayLength": 20,
			"aLengthMenu": [20, 50, 100, 200],
			"bServerSide": true,
			"sPaginationType": "full_numbers",
			"sAjaxSource": "<?php echo site_url('admin/get_data_table_source'); ?>?table=m_unitinstalasi&columns=,m_unitinstalasi.name,m_unit.name,m_struktur.name&jwhere=unit_id,struktur_id&fildjoins=,m_unit.name as subbagian,m_struktur.name as struktur&joins=m_unit,m_struktur&exports=m_unit,m_struktur",
			"aoColumns": [{
					"sTitle": "#",
					"mData": "no",
					"bSortable": false,
					"sClass": "center"
				},
				{
					"sTitle": "KODE",
					"mData": "code",
					"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
						var id = "code-" + oData.id;
						$(nTd).attr("id", id);
						$(nTd).editable("<?php echo site_url('admin/update_grid/m_unitinstalasi'); ?>", {
							"callback": function (sValue, y) {
								$("#tblData").dataTable().fnDraw();
							}
						});
					}
				},
				{
					"sTitle": "UNIT",
					"mData": "name",
					"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
						var id = "name-" + oData.id;
						$(nTd).attr("id", id);
						$(nTd).editable("<?php echo site_url('admin/update_grid/m_unitinstalasi'); ?>", {
							"callback": function (sValue, y) {
								$("#tblData").dataTable().fnDraw();
							}
						});
					}
				},
				{
					"sTitle": "INSTALASI",
					"mData": "subbagian",
					"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
						var id = "unit_id-" + oData.id;
						$(nTd).attr("id", id);
						$(nTd).editable("<?php echo site_url('admin/update_grid/m_unitinstalasi'); ?>?table=m_unit", {
							loadurl: "<?php echo site_url('admin/get_editable_select'); ?>?table=m_unit&filds=name&select=" + oData.unit_id,
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
					"sTitle": "STRUKTURAL",
					"mData": "struktur",
					"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
						var id = "struktur_id-" + oData.id;
						$(nTd).attr("id", id);
					}
				}
			]
		});
		$("#txtAddInstalasi").button().click(function () {
			$('#saveForm')[0].reset();
			$.ajax({
				type: "POST",
				dataType: 'json',
				url: "<?php echo site_url('admin/multi_select');?>?table=m_unit",
				success: function (data) {
					if (data == '') {
						$("#cmbUnit").append("<option value=''> -- No Result -- </option>");
					} else {
						$("#cmbUnit").append("<option value=''> -- Silahkan Pilih -- </option>");
						for (var i = 0; i < data.length; i++) {
							$("#cmbUnit").append('<option value="' + data[i].id + '">' + data[i].name + '</option>').selectpicker('refresh');
						}
						$("#myModal1").modal('show');
					}
				}
			});
		});
		$("#saveForm").submit(function (e) {
			e.preventDefault();
			if ($('#saveForm').valid()) {
				$.ajax({
					type: "POST",
					dataType: 'json',
					url: "<?php echo site_url('admin/autonumber/m_unitinstalasi'); ?>/" + 2,
					success: function (msg) {
						var Kode = msg;
						$.ajax({
							type: "POST",
							dataType: 'json',
							url: "<?php echo site_url('admin/create/m_unitinstalasi'); ?>",
							data: {
								unit_id: $("#cmbUnit").val(),
								name: $("#txtNamaInstalasi").val(),
								code: Kode,
								order_id: 0
							},
							success: function (ret) {
								$("#tblData").dataTable().fnDraw();
								$("#myModal1").modal('hide');
							}
						});
					}
				});
			}
		});
	}); 

</script>

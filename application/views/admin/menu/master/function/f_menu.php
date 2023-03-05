<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript">
	String.prototype.replaceAll = function(str1, str2, ignore) {
		return this.replace(new RegExp(str1.replace(/([\/\,\!\\\^\$\{\}\[\]\(\)\.\*\+\?\|\<\>\-\&])/g,"\\$&"),(ignore?"gi":"g")),(typeof(str2)=="string")?str2.replace(/\$/g,"$$$$"):str2);
	};
	var Table ='';
	var cookie;
    var selectedId;
    var active;
	var idval;
    $(document).ready(function () {
		$('[data-toggle="#Datamaster"]').addClass('menu-open');
    	$('a[href="'+location+'"]').addClass('active');
        
		// Data Table //
		$("#tblData").dataTable({
            "bJQueryUI": true,
            "bAutoWidth": true,
            // "bProcessing": true,
            "iDisplayLength": 20,
            "aLengthMenu": [20, 50, 100, 200],
            "bServerSide": true,
            "sPaginationType": "full_numbers",
            "sAjaxSource": "<?php echo site_url('admin/get_data_table_source'); ?>?table=n_menu&columns=,nama_menu,unit_id,status,material_icon,fonts_icon,class1,class2&jwhere=unit_id&fildjoins=,m_unit.name&joins=m_unit&exports=m_unit",
            "aoColumns": [{
                    "sTitle": "#",
                    "mData": "no",
                    "bSortable": false,
                    "sClass": "center"
                },
                {
                    "sTitle": "Nama Manu",
                    "mData": "nama_menu",
                    "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                        var id = "nama_menu-" + oData.id;
                        $(nTd).attr("id", id);
                        $(nTd).editable("<?php echo site_url('admin/update_grid/n_menu'); ?>", {
                            "callback": function (sValue, y) {
                                /* Redraw the table from the new data on the server */
                                $("#tblData").dataTable().fnDraw();
                            }
                        });
                    }
                },
                {
                    "sTitle": "Struktur Menu",
                    "mData": "name",
                    "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                        var id = "unit_id-" + oData.id;
                        $(nTd).attr("id", id);
                        $(nTd).editable("<?php echo site_url('admin/update_grid/n_menu/'); ?>?table=m_unit", {
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
                    "sTitle": "Material Icons",
                    "mData": "material_icon",
                    "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                        var id = "class-" + oData.id;
                        $(nTd).attr("id", id);
                        $(nTd).editable("<?php echo site_url('admin/update_grid/n_menu'); ?>", {
                            "callback": function (sValue, y) {
                                /* Redraw the table from the new data on the server */
                                $("#tblData").dataTable().fnDraw();
                            }
                        });
                    }
                },
                {
                    "sTitle": "font awesome Icon",
                    "mData": "fonts_icon",
                    "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                        var id = "fonts_icon-" + oData.id;
                        $(nTd).attr("id", id);
						$(nTd).editable("<?php echo site_url('admin/update_grid/n_menu'); ?>", {
                            "callback": function (sValue, y) {
                                /* Redraw the table from the new data on the server */
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
						if (oData.status == 'Y') {
							htmlx = "<button class='btn btn-xs bg-green'><i class='fas fa-check'></i></button>";
							$(nTd).html(htmlx);
							$($(nTd).children()[0]).button().click(function () {
								var id = "status-" + oData.id;
								$(nTd).attr("id", id);
								selectedId = oData.id;
								active = 'N';
								$("#txtAlert").html("Menu ini akan di non aktive..?");
								$("#dlgAlert").modal("show")
							});
						} else if (oData.status == 'N' || oData.status == null) {
							htmlx = "<button class='btn btn-xs bg-danger'><i class='fa fa-ban'></i></button>";
							$(nTd).html(htmlx);
							$($(nTd).children()[0]).button().click(function () {
								var id = "status-" + oData.id;
								$(nTd).attr("id", id);
								selectedId = oData.id;
								active = 'Y';
								$("#txtAlert").html("Menu ini akan di aktive kan..?");
								$("#dlgAlert").modal("show");
							});
						}
					}
				}
            ]
        	});
		// End Data Table //

		// Function CRUD //
		$('#btnChange').button().click(function () {
			$.ajax({
				type: "POST",
				dataType: 'json',
				url: "<?php echo site_url('admin/aktive/n_menu/status'); ?>/" + selectedId + "/" + active,
				success: function (data) {
					$.swalDefaultAlert("error: " + data.error + "<br> Code: " + data.code + " <br> message: " + data.message,'success');
					$("#tblData").dataTable().fnDraw();
				}
				});
				$("#dlgAlert").modal("hide");
			});
			
		$("#btnReload").button().click(function () {
	        $("#tblData").dataTable().fnDraw();
	        var title = "Reload..";
	        var label = "Data Table..";
	        var message = " Data Table berhasil di Refresh..";
	        alert_info(title, label, message);
		});
		
		$("#btnAdd").button().click(function () {
			$("#cmbUnit").empty();
			$.ajax({
				type: "POST",
				dataType: 'json',
				url: "<?php echo site_url('admin/multi_select');?>?table=m_unit",
				success: function (data) {
					if (data == '') {
						$("#cmbUnit").append('<option value="">-- No Result --</option>');
					} else {
						$('#frm-add').modal('show');
						$("#cmbUnit").append('<option value=""> -- Silahkan Pilih -- </option>');
						for (var i = 0; i < data.length; i++) {
							$("#cmbUnit").append("<option value='" + data[i].id + "'>" + data[i].name + "</option>");
						}
					}
					}
				});
			});

		$('#add-data').submit(function (e) {
			e.preventDefault();
			if ($('#add-data').valid()) {
				$.ajax({
					type: "POST",
					dataType: "json",
					url: "<?php echo site_url('admin/create_menu'); ?>/" + $('#cmbUnit option:selected').val(),
					data: $('#add-data').serialize(),
					
					success: function (data) {
						if(data.error == false){
							$('#frm-add').modal("hide");
							$.swalDefaultAlert("error: " + data.error + "<br> Code: " + data.code + " <br> message: " + data.message,'success');
							$("#tblData").dataTable().fnDraw();
						}else{
							$('#frm-add').modal("hide");
							$.swalDefaultAlert("error: " + data.error + "<br> Code: " + data.code + " <br> message: " + data.message,'success');
							$("#tblData").dataTable().fnDraw();
						}
					}
					});
				}
			});

		// End CRUD //

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
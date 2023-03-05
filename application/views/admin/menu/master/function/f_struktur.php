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
	        "aLengthMenu": [15, 30, 50, 100],
	        "bServerSide": true,
	        "sPaginationType": "full_numbers",
	        "sAjaxSource": "<?php echo site_url('admin/get_data_table_source'); ?>?table=m_struktur&columns=,code,name",
	        "aoColumns": [{
	                "sTitle": "#",
	                "mData": "no",
	                "bSortable": false,
	                "sClass": "center"
	            },
	            {
	                "sTitle": "CODE",
	                "mData": "code",
	                "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
	                    var id = "code-" + oData.id;
	                    $(nTd).attr("id", id);
	                    $(nTd).editable("<?php echo site_url('admin/update_grid/m_struktur'); ?>", {
	                        "callback": function (sValue, y) {
	                            /* Redraw the table from the new data on the server */
	                            $("#tblData").dataTable().fnDraw();
	                        }
	                    });
	                }
	            },
	            {
	                "sTitle": "NAMA STRUKTUR",
	                "mData": "name",
	                "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
	                    var id = "name-" + oData.id;
	                    $(nTd).attr("id", id);
	                    $(nTd).editable("<?php echo site_url('admin/update_grid/m_struktur'); ?>", {
	                        "callback": function (sValue, y) {
	                            /* Redraw the table from the new data on the server */
	                            $("#tblData").dataTable().fnDraw();
	                        }
	                    });
	                }
	            }
	        ]
	    });
	    $('#add-data').submit(function (e) {
	        e.preventDefault();
	        if ($('#add-data').valid()) {
	            $.ajax({
	                type: "POST",
	                url: "<?php echo site_url('admin/create/m_struktur'); ?>",
	                data: {
	                    code: $("#txtCode").val(),
	                    name: $("#txtStruktural").val()
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
	        $("#frm-add").modal("show");
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
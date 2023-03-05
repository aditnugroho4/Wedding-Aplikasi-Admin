<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript">
String.prototype.replaceAll = function(str1, str2, ignore) {
		return this.replace(new RegExp(str1.replace(/([\/\,\!\\\^\$\{\}\[\]\(\)\.\*\+\?\|\<\>\-\&])/g,"\\$&"),(ignore?"gi":"g")),(typeof(str2)=="string")?str2.replace(/\$/g,"$$$$"):str2);
	};
	var selectedId;
    var fildeselect;
	var active;
	var parsing =null;
    var tables;
	var $date = "<?php echo R::isoDateTime(); ?>";
	var $user ="<?php echo $user->id;?>";
$(document).ready(function () {
	// Data Table Gambar Rubah Setting Gallery
	$("#tblPermalink").dataTable({
	    "bJQueryUI": true,
	    "bAutoWidth": true,
	    // "bProcessing": true,
	    "iDisplayLength": 5,
	    "aLengthMenu": [5, 10, 15],
	    "bServerSide": true,
	    "sPaginationType": "full_numbers",
	    "sAjaxSource": "<?php echo site_url('admin/get_data_table_source'); ?>?table=w_post_link_button&columns=,name,link_target,icon",
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
	                /*$(nTd).editable("<?php echo site_url('admin/update_grid/w_post_link_button'); ?>", {
	                    "callback": function (sValue, y) {
	                         Redraw the table from the new data on the server 
	                        $("#tblPermalink").dataTable().fnDraw();
	                    }
	                });*/
	            }
	        },
	        {
	            "sTitle": "Permalink",
	            "mData": "link_target",
	            "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
	                var id = "link_target-" + oData.id;
	                $(nTd).attr("id", id);
	                $(nTd).editable("<?php echo site_url('admin/update_grid/w_post_link_button'); ?>", {
	                    "callback": function (sValue, y) {
	                        /* Redraw the table from the new data on the server */
	                        $("#tblPermalink").dataTable().fnDraw();
	                    }
	                });
	            }
	        }
	    ]
	});	 
    $("#add-data-permalink").submit(function (e) {
		e.preventDefault();
		if ($('#add-data-permalink').valid()) {
			$('.load-ding-add').append('<div class="overlay"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>');
			$.ajax({
				type: "POST",
				dataType: 'json',
				url: "<?php echo site_url('admin/create/w_post_link_button'); ?>",
				data: {
					name: $("#txtNamaLink").val(),
					link_target: $("#txtPermalink").val(),
					icon: $("#cmbIcon option:selected").val()
				},
				success: function (ret) {
					var title = "Info";
					var label = "Menyimpan Data";
					var message = " Data Table berhasil di Simpan.";
					$('#add-data-permalink')[0].reset();
					alert_info(title, label, message);
					$("#tblPermalink").dataTable().fnDraw();
					$('.load-ding-add').find('.overlay').remove();
					$("#dlg-add_permalink").modal("hide");

				}
			});
		}
	});
});
</script>
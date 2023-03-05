<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript">
String.prototype.replaceAll = function(str1, str2, ignore) {
		return this.replace(new RegExp(str1.replace(/([\/\,\!\\\^\$\{\}\[\]\(\)\.\*\+\?\|\<\>\-\&])/g,"\\$&"),(ignore?"gi":"g")),(typeof(str2)=="string")?str2.replace(/\$/g,"$$$$"):str2);
	};
	var selectedId;
    var fildeselect;
	var active;
	var parsing =null;
	var $path=null;
	Dropzone.autoDiscover = false;
	var $date = "<?php echo R::isoDateTime(); ?>";
	var $user ="<?php echo $user->id;?>";
$(document).ready(function () {
	// Data Table Gambar Rubah Setting Gallery
	$("#tblData-setting").dataTable({
	    "bJQueryUI": true,
	    "bAutoWidth": true,
	    // "bProcessing": true,
	    "iDisplayLength": 5,
	    "aLengthMenu": [5, 10, 15],
	    "bServerSide": true,
	    "sPaginationType": "full_numbers",
	    "sAjaxSource": "<?php echo site_url('admin/get_data_table_source'); ?>?table=w_post_images&columns=,w_post_images.name,w_post_images.date,w_post_kategory.name,size,ctgr_id&jwhere=ctgr_id&fildjoins=,w_post_kategory.name as nama_katagory&joins=w_post_kategory&exports=w_post_kategory",
	    "aoColumns": [{
	            "sTitle": "#",
	            "mData": "no",
	            "bSortable": false,
	            "sClass": "center"
	        },
	        {
	            "sTitle": "Images",
	            "mData": "img",
	            "sClass": "center",
	            "bSortable": false,
	            "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
	                var id = "img-" + oData.id;
	                $(nTd).attr("id", id);
	                if (oData.img == null) {
	                    htmlx = "<div class='from-group'><img class='img-thumbnail' width='65' src='<?php echo base_url('asset/admin/dist/default-150x150.png'); ?>'></div>";
	                    $(nTd).html(htmlx);
	                } else {
	                    htmlx = "<div class='from-group thumbnail'><img id='img-"+oData.id+"' class='img-thumbnail'width='65' src='<?php echo base_url(); ?>/" +
	                        oData.img + "' alt='' ></div>";
	                    $(nTd).html(htmlx);
	                }
	            }
	        },
	        {
	            "sTitle": "Nama",
	            "mData": "name",
	            "sClass": "center",
	            "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
	                var id = "name-" + oData.id;
	                $(nTd).attr("id", id);
	                $(nTd).editable("<?php echo site_url('admin/update_grid/w_post_images'); ?>", {
	                    "callback": function (sValue, y) {
	                        /* Redraw the table from the new data on the server */
	                        $("#tblData-setting").dataTable().fnDraw();
	                    }
	                });
	            }
	        },
	        {
	            "sTitle": "Kategori",
	            "mData": "nama_katagory",
	            "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
	                var id = "ctgr_id-" + oData.id;
	                $(nTd).attr("id", id);
	                $(nTd).editable("<?php echo site_url('admin/update_grid/w_post_images'); ?>?table=w_post_kategory", {
	                    loadurl: "<?php echo site_url('admin/get_editable_select'); ?>?table=w_post_kategory&filds=name&select=" + oData.ctgr_id,
	                    type: "select",
	                    submit: "OK",
	                    "callback": function (sValue, y) {
	                        /*Redraw the table from the new data on the server */
	                        $("#tblData-setting").dataTable().fnDraw();
	                    }
	                });
	            }
	        },
	        {
	            "sTitle": "Posisi Gambar",
	            "mData": "size",
	            "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
	                var id = "size-" + oData.id;
	                $(nTd).attr("id", id);
	                if (oData.size == null) {
	                    htmlx = "Default";
	                    $(nTd).html(htmlx);
	                } else if (oData.size == 'P') {
	                    htmlx = "Portrait";
	                    $(nTd).html(htmlx);
	                } else if (oData.size == 'L') {
	                    htmlx = "Landscape";
	                    $(nTd).html(htmlx);
	                }
	                $(nTd).editable(
	                    "<?php echo site_url('admin/update_grid/w_post_images'); ?>", {
	                        type: "select",
	                        data: "{'L':'Landscape','P':'Portrait'}",
	                        submit: "OK",
	                        "callback": function (sValue, y) {
	                            /* Redraw the table from the new data on the server */
	                            $("#tblData-setting").dataTable().fnDraw();
	                        }
	                    });
	            }
	        },{
	            "sTitle": "Tgl-Upload",
	            "mData": "date",
	            "sClass": "center",
	            "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
	                var id = "date-" + oData.id;
	                $(nTd).attr("id", id);
	            }
	        }, {
	            "sTitle": "Action",
	            "sClass": "text-center",
	            "mData": "status",
	            "bSortable": false,
	            "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
	                if ( oData.status == 'Y') {
	                    htmlx = "<button class='btn btn-xs bg-green'><i class='fas fa-check'></i></button>";
	                    $(nTd).html(htmlx);
	                    $($(nTd).children()[0]).button().click(function () {
	                        var id = "status-" + oData.id;
	                        $(nTd).attr("id", id);
	                        selectedId = oData.id;
	                        fildeselect = "status";
	                        active = 'N';
	                        $("#dlg-confiq_gallery").modal("hide");
	                        $("#txt-status").html("Status akan di Ubah Menjadi Non aktif..?");
	                        $("#dlg-edit-status").modal("show");
	                    });
	                    $($(nTd).children()[0]).find("span").css("padding", "2px 2px");
	                } else if ( oData.status == null || oData.status == 'N') {
	                    htmlx = "<button class='btn btn-xs bg-danger'><i class='fa fa-ban'></i></button>";
	                    $(nTd).html(htmlx);
	                    $($(nTd).children()[0]).button().click(function () {
	                        var id = "status-" + oData.id;
	                        $(nTd).attr("id", id);
	                        fildeselect = "status";
	                        selectedId = oData.id;
	                        active = 'Y';
	                        $("#dlg-confiq_gallery").modal("hide");
	                        $("#txt-status").html("Status akan di Ubah Menjadi aktif..?");
	                        $("#dlg-edit-status").modal("show");
	                    });
	                } 
	            }
	        },{
	            "sTitle": "Resize",
	            "sClass": "text-center",
	            "mData": "status",
	            "bSortable": false,
	            "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
	                htmlx = "<button class='btn btn-xs bg-pink btn-sm'><i class='fas fa-file-image'></i> Resize</button>";
	                    $(nTd).html(htmlx);
	                    $($(nTd).children()[0]).button().click(function () {
							var Img_path = '<?php echo base_url(); ?>'+oData.img;
							$("#dlg-resize-images").modal("show");
							$path = oData.img;
							imgSize(Img_path);
	                    });
	            }
	        }
	    ]
	});	 	
	function imgSize(path){
		var img = $('#resize-show');
			img.attr("src",path);
			var realSize =getImageSizeInBytes(path);
			realSize = realSize / 1000;
			$("#load-size").button().click();
			$('#uk-size').html("Original Size= " + realSize+' kb');
		};
	function getImageSizeInBytes(imgURL) {
		var request = new XMLHttpRequest();
		request.open("HEAD", imgURL, false);
		request.send(null);
		var headerText = request.getAllResponseHeaders();
		var re = /Content\-Length\s*:\s*(\d+)/i;
		re.exec(headerText);
		return parseInt(RegExp.$1);
		}
	function imgResize(path){
		$('.load-ding-resize').append('<div class="overlay text-center"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>');
		var file= path.split('/').pop();
		var ext =path.split('.').pop();
		var path= path.split("/").slice(0, -1).join("/");
		$.ajax({
				type: "POST",
				dataType: 'json',
				url: "<?php echo site_url('admin/resizeImageTo');?>",
				data:{
					file:file,
					path:path
				},
				success: function (data) {
					if(data.error==false){
						var newpath ='<?= base_url();?>'+data.path;		
						$('#resize-show').attr("src",'');
						imgSize(newpath);
						$path=null;
						// $("#tblData-setting").dataTable().fnDraw();
						var title = "Setting Form";
						var label = "Resize Foto";
						var message = "Merubah Ukuran Berhasil..! (";
						alert_info(title, label, message + data.message+")");
					}
					$('.load-ding-resize').find('.overlay').remove();
				}
			});
		}
	$("#load-size").button().click(function () {
		var myImg = $("#resize-show");	
		var realWidth = myImg.prop('naturalWidth');
		var realHeight = myImg.prop('naturalHeight');
		$('#uk-width').html("Original width= " + realWidth);
		$('#uk-height').html("Original height= " + realHeight);
	});
	$("#resize-img").button().click(function () {
		if($path != null){
			imgResize($path);
		}else{
			var title = "Setting Form";
			var label = "Resize Foto";
			var message = "Sudah Melakukan Resize Image";
			alert_danger(title, label, message);
			$("#dlg-resize-images").modal("hide");
		}
		
	});
    $('#btn-prosess').button().click(function () {
		$.ajax({
			url: "<?php echo site_url('admin/aktive/w_post_images'); ?>/"+ fildeselect +"/" + selectedId +"/"+ active,
			success: function(data) {
			$("#dlg-edit-status").modal("hide");
			$("#dlg-setting_gallery").modal("show");
			$("#tblData-setting").dataTable().fnDraw();
			}
		});
	});
	$("#cmbKategory-upd").change(function () {
			$("#cmbLink-upd").empty();
			$.ajax({
				type: "POST",
				dataType: 'json',
				url: "<?php echo site_url('admin/multi_select');?>?table=w_post_link_button",
				success: function (data) {
					if (data == '') {
						$("#cmbLink-upd").append("<option value=''> -- No Result -- </option>");
					} else {
						for (var i = 0; i < data.length; i++) {
							$("#cmbLink-upd").append('<option value="' + data[i].id + '">' + data[i].name + '</option>');
						}
					}
				}
			});
		});
    $("#cmbLink-upd").change(function () {
	    var confiq = {
	        id: $user,
	        sizeH: 125,
	        sizeW: 125,
	        tbL: "w_post_images",
	        path: $("#cmbKategory-upd option:selected").attr('name'),
	        ctgrId: $("#cmbKategory-upd option:selected").val(),
	        linkId: $("#cmbLink-upd option:selected").val(),
	        name: $("#txtNameModel").val(),
			lokasi: $("#txtLokasi").val()
	    };
	    var parsings = $.base64.encode(JSON.stringify(confiq));
	    parsings = parsings.replaceAll(".", "^");
	    parsings = parsings.replaceAll("+", "-");
	    parsings = parsings.replaceAll("/", "_");

	    parsing = parsings;
	    //alert(parsing);
	});    
	var myDropzone = new Dropzone("#myDropzone",{
        url: "<?php echo site_url('admin/add_multipel_upload');?>",
        paramName: "file",
        autoProcessQueue: false,
        uploadMultiple: true, // uplaod files in a single request
        parallelUploads: 100, // use it with uploadMultiple
        maxFilesize: 1, // MB
        maxFiles: 6,
        acceptedFiles: ".png, .jpg, .jpeg, .ico, .gif",
        addRemoveLinks: true,
        // Language Strings
        dictFileTooBig: "Data Terlalu Besar ({{filesize}}mb). Max allowed file size is {{maxFilesize}}mb",
        dictInvalidFileType: "Jenis File Tidak di Izinkan",
        dictCancelUpload: "Cancel",
        dictRemoveFile: "Remove",
        dictMaxFilesExceeded: "Only {{maxFiles}} files are allowed",
        dictDefaultMessage: "Drag File yang akan di Upload Di sini gan.."
	});
    // End Upload Gambar
}); 
Dropzone.options.myDropzone = {
    // The setting up of the dropzone
    init: function() {
			var totalFile =0;
			var myDropzone = this;
			// First change the button to actually tell Dropzone to process the queue.
			$("#add-data-upload").submit(function(e) {
				// Make sure that the form isn't actually being sent.
				e.preventDefault();
				e.stopPropagation();					
				if (myDropzone.files != "") {	
					$('.load-ding-upload').append('<div class="overlay text-center"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>');
					
						myDropzone.on('sending', function(file, xhr, formData){
							formData.append('data', parsing);
						});	
						myDropzone.processQueue();			
														
				} else {
					$("#myDropzone").submit();
				}
			});
			// on add file
			this.on("addedfile", function(file) {
				totalFile +=1;
				if (myDropzone.files[6]!=null){
					myDropzone.removeFile(myDropzone.files[6]);
				}
			});
			// on error
			this.on("error", function(file, response) {
				// console.log(response);
				
			});
			this.on("complete", function (file) {
				if(totalFile == 6){
					var title = "Add Form";
					var label = "Upload Foto";
					var message = "Maximum Upload 6 File Gambar..!!";
					alert_danger(title, label, message);
				}
				
			});
			// on start
			this.on("sendingmultiple", function(file) {
				// console.log(file);	
							
			});
			// on success
			this.on("successmultiple", function(file) {
				// submit form						
					//$("#add-data-upload").submit();
					var title = "Add Form";
					var label = "Upload Foto";
					var message = "Upload Foto Berhasil";
					alert_success(title, label, message);
					if(get_gallery()){
						get_gallery();
					}
					$('.load-ding-upload').find('.overlay').remove();	
					$("#add-data-upload")[0].reset();
					Dropzone.forElement('#myDropzone').removeAllFiles(true);
			});
    }
};
</script>
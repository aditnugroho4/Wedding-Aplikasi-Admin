<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript">
	String.prototype.replaceAll = function(str1, str2, ignore) 
	{
		return this.replace(new RegExp(str1.replace(/([\/\,\!\\\^\$\{\}\[\]\(\)\.\*\+\?\|\<\>\-\&])/g,"\\$&"),(ignore?"gi":"g")),(typeof(str2)=="string")?str2.replace(/\$/g,"$$$$"):str2);
	};	
	 var selectedId;
	 var eleFocus;
	function tampilkanPreview(gambar,idpreview){
				if(window.ActiveXObject){
					var fso = new ActiveXObject("Scripting.FileSystemObject");
					var filepath = document.getElementById('file').value;
					var thefile = fso.getFile(filepath);
					var sizeinbytes = thefile.size;
					}else{
						var sizeinbytes = document.getElementById('file').files[0].size;
					}

					var fSExt = new Array('Bytes', 'KB', 'MB', 'GB');
					fSize = sizeinbytes; i=0;while(fSize>900){fSize/=1024;i++;}
					var hasil =(Math.round(fSize*100)/100)+' '+fSExt[i];
					
				if(sizeinbytes > 500000)
				{
					$("#txtAlert").html("Ukuran Foto Terlalu Besar " + hasil + " (Max Upload 500 kb)");
					$("#dlg-alert").dialog("open");	
					$('#file').val('');
				}else
					{
				var gb = gambar.files;
//                loop untuk merender gambar
				$("#txtSize").html("Ukuran File Upload " + hasil );
               for (var i = 0; i < gb.length; i++){
//                    bikin variabel
                    var gbPreview = gb[i];
                    var imageType = /image.*/;
                    var preview=document.getElementById(idpreview);            
                    var reader = new FileReader();
                    
                    if (gbPreview.type.match(imageType)) {
//                        jika tipe data sesuai
                        preview.file = gbPreview;
                        reader.onload = (function(element) { 
                            return function(e) { 
										element.src = e.target.result; 
									}; 
								})(preview);
		 
			//                    membaca data URL gambar
								$("#btnUpload").show();
								reader.readAsDataURL(gbPreview);
							}
					else{
//                        jika tipe data tidak sesuai
                    
							$("#txtAlert").html("Type file tidak sesuai. Khusus image");
							$("#dlg-alert").dialog("open");	
						}
					   
						}
					}
                    
            }
			function uploadfoto(id) {
				var path ='asset-foto-pegawai-';
				var fd = new FormData(document.getElementById("foto"));
				$.ajax({
						url: "<?php echo site_url('admin/uploads/m_datapegawai');?>/"+ id +"/"+ path +"/foto",
						type: 'post',
						enctype: 'multipart/form-data',
						dataType: 'json',
						data: fd ,
						async: false,
						success: function (data) {
									if(!data.error){
										$("#lbllogo").attr("src","<?php echo base_url();?>images/success.png");
										$("#lblloading").html(data.lbl);
										$("#lblhasil").html(data.path);
										$("#insert-confirm").dialog("open");
										}
										else{
										$("#lbllogo").attr("src","<?php echo base_url();?>images/error.png");
										$("#lblloading").html(data.lbl);
										$("#insert-confirm").dialog("open");
										}
						},
						cache: false,
						contentType: false,
						processData: false
				});
				}
	$(document).ready(function () {
			$('[data-toggle="#Datamaster"]').addClass('menu-open');
			$('a[href="'+location+'"]').addClass('active');
				// Item Tindakan \\
				$("#tblData").dataTable({
				   "bJQueryUI": true,
				    "bAutoWidth": false,
                    // "bProcessing": true,
					"iDisplayLength": 10,
					"aLengthMenu": [ 10, 20, 50,100 ],
                    "bServerSide": true,
                    "sPaginationType": "full_numbers",
                    "sAjaxSource": "<?php echo site_url('admin/get_data_table_source'); ?>?table=m_datapegawai&columns=,nik,nama,tmptlahir,tgllahir,kelamin,pendidikan,profesi,golongan,tmtgol,jabatan,tmtdinas,status",
                    "aoColumns" : [
                        { "sTitle" : "#", "mData" : "no", "bSortable" : false, "sClass" : "center" },
							{ 
								"sTitle" : "NIP/NIRPTT/NIK", "mData" : "nik",
								"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) { 
									var id = "nik-" + oData.id;
									$(nTd).attr("id", id);
									$(nTd).editable("<?php echo site_url('admin/update_grid/m_datapegawai'); ?>", { 
										"callback": function( sValue, y ) {
											/* Redraw the table from the new data on the server */
											$("#tblData").dataTable().fnDraw();
										}
									});
								} 
							},
							{ 
								"sTitle" : "NAMA", "mData" : "nama",
								"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) { 
									var id = "nama-" + oData.id;
									$(nTd).attr("id", id);
										$(nTd).editable("<?php echo site_url('admin/update_grid/m_datapegawai'); ?>", 
										{ 
										"callback": function( sValue, y ) {
											/* Redraw the table from the new data on the server */
											$("#tblData").dataTable().fnDraw();
										}
									});
								} 
							},
							{ 
								"sTitle" : "Tempat Lahir", "mData" : "tmptlahir",
								"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) { 
									var id = "tmptlahir-" + oData.id;
									$(nTd).attr("id", id);
										$(nTd).editable("<?php echo site_url('admin/update_grid/m_datapegawai'); ?>", { 
										"callback": function( sValue, y ) {
											/* Redraw the table from the new data on the server */
											$("#tblData").dataTable().fnDraw();
										}
									});
								} 
							},
							{ 
								"sTitle" : "Tanggal Lahir", "mData" : "tgllahir",
								"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) { 
									var id = "tgllahir-" + oData.id;
									$(nTd).attr("id", id);
										$(nTd).editable("<?php echo site_url('admin/update_grid/m_datapegawai'); ?>", 
										{ 
										type : "datepicker",
										datepicker: {
                                        dateFormat: "yy-mm-dd",
										changeMonth : true,
										changeYear : true,
										showButtonPanel: true,
										yearRange: '1920:2050'
										},
										"callback": function( sValue, y ) {
                                        /* Redraw the table from the new data on the server */
                                        $("#tblData").dataTable().fnDraw();
										}
									});
								} 
							},
							
							{ 
								"sTitle" : "Kelamin", "mData" : "kelamin",
								"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) { 
									var id = "kelamin-" + oData.id;
										$(nTd).attr("id", id);
										$(nTd).editable("<?php echo site_url('admin/update_grid/m_datapegawai'); ?>", { 
											type : "select",
											data: "{'L':'Laki-Laki','P':'Perempuan'}",
											submit : "OK",
											"callback": function( sValue, y ) {
                                       /* Redraw the table from the new data on the server */
                                        $("#tblData").dataTable().fnDraw();
										}
									});
								}
							},
							{ 
								"sTitle" : "Pendidikan", "mData" : "pendidikan",
								"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) { 
									var id = "pendidikan-" + oData.id;
									$(nTd).attr("id", id);
										$(nTd).editable("<?php echo site_url('admin/update_grid/m_datapegawai'); ?>", { 
										"callback": function( sValue, y ) {
											/* Redraw the table from the new data on the server */
											$("#tblData").dataTable().fnDraw();
										}
									});
								} 
							},
							{ 
								"sTitle" : "Tanggal Masuk", "mData" : "tmtdinas",
								"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) { 
									var id = "tmtdinas-" + oData.id;
									$(nTd).attr("id", id);
										$(nTd).editable("<?php echo site_url('admin/update_grid/m_datapegawai'); ?>", { 
										type : "datepicker",
										datepicker: {
                                        dateFormat: "yy-mm-dd"
										},
										"callback": function( sValue, y ) {
                                        /* Redraw the table from the new data on the server */
                                        $("#tblData").dataTable().fnDraw();
										}
									});
								} 
							},
							{ 
								"sTitle" : "STATUS", "mData" : "status",
								"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) { 
									var id = "status-" + oData.id;
									$(nTd).attr("id", id);
										$(nTd).editable("<?php echo site_url('admin/update_grid/m_datapegawai'); ?>", { 
											type : "select",
											data: "{'PNS':'PNS','PTT':'PTT','BLUD':'BLUD','MAGANG':'MAGANG'}",
											submit : "OK",
										"callback": function( sValue, y ) {
											/* Redraw the table from the new data on the server */
											$("#tblData").dataTable().fnDraw();
										}
									});
								} 
							},
							{ 
								"sTitle" : "Jabatan/Profesi", "mData" : "jabatan",
								"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) { 
									var id = "jabatan-" + oData.id;
									$(nTd).attr("id", id);
										$(nTd).editable("<?php echo site_url('admin/update_grid/m_datapegawai'); ?>", { 
										"callback": function( sValue, y ) {
											/* Redraw the table from the new data on the server */
											$("#tblData").dataTable().fnDraw();
										}
									});
								} 
							},
							/*{ 
								"sTitle" : "Struktur", "mData" : "name",
								"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) { 
									var id = "unit_id-" + oData.id;
									$(nTd).attr("id", id);
										$(nTd).editable("<?php echo site_url('admin/update_grid/m_datapegawai'); ?>?table=m_unit", { 
										loadurl : "<?php echo site_url('admin/get_editable_select'); ?>?table=m_unit&filds=name&select=" + oData.unit,
										type   : "select",
										submit : "OK",
										"callback": function( sValue, y ) {
                                        Redraw the table from the new data on the server 
                                        $("#tblData").dataTable().fnDraw();
                                    }
                                });
								} 
							},*/
							{ 
								"sTitle" : "Edit", "mData" : "foto", "sClass" : "center",
								"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
									$(nTd).html("<button>Foto</button><button>Edit</button>");
									$($(nTd).children()[0]).button().click(function () {
										selectedId = oData.id;
										if(oData.foto == null)
										{
										$('#lihat').attr('src',"<?php echo base_url('asset/foto'); ?>/preview.png");
										$("#btnUpload").show();
										}else{
										$('#lihat').attr('src',"<?php echo base_url('asset/foto/pegawai'); ?>/"+oData.foto);
										}
									   $("#dlg-upload").dialog("open");
									   $("#btnUpload").hide();
									   
									});
									$($(nTd).children()[1]).button().click(function () {
										selectedId = oData.id;
									   $.getProcess(selectedId);
									});
									$($(nTd).children()[0]).find("span").css("padding", "2px 7px");
									$($(nTd).children()[1]).find("span").css("padding", "2px 7px");
									
								}
							}
                        
                    ]
				});
				$.getProcess = function(id)
					{
						$.ajax({
								type:"POST",
								url:"<?php echo site_url('admin/get_edit_pegawai');?>/"+ id,
									success: function(data)
										{
											if(data){
											$('#content-input').html(data);
											$('#site_info').css('position','relative');
											$(".block").hide();
											}
										}
								});
					}
				 	$("#dlg-upload").dialog({
					autoOpen: false,
					resizable: false,
					modal: true,
					buttons: [
								{
								  id: "btnUpload",
								  text: "Upload",
								  click: function () 
								  {
									 uploadfoto(selectedId); 
								  }
								},
								{
								  id: "close",
								  text: "Close",
								  click: function () 
								  {
									 $(this).dialog("close"); 
								  }
								}
								],
							close: function() {
								$(this).dialog("close");
								$(eleFocus).focus();
								$('#file').val('');
								}
				});
				$("#insert-confirm").dialog({
						autoOpen: false,
						resizable: false,
						modal: true,
						buttons: {
							OK: function() {
								$(this).dialog("close");
								$("#inputdata").dialog('close');
							   $("#tblData").dataTable().fnDraw();
							   $('#file').val('');
							}
						}
						
					});
				$("#btnTambah").button().click(function () {
					$("#inputdata").dialog('open');
					$.unit ();
					$('#preview').attr('src',"<?php echo base_url('asset/foto'); ?>/preview.png");
					$("#txtNik").focus();
				});	
		$("#inputdata").dialog({
						autoOpen: false,
						resizable: false,
						width: 850,
						modal: true,
						buttons: {
							Close: function() {
								$(this).dialog("close");
							   $("#tblData").dataTable().fnDraw();
							}
						}
						
					});
	$("#dlg-alert").dialog({
					autoOpen: false,
					resizable: false,
					modal: true,
					buttons: {
						 OK: function() {
							$(this).dialog("close");
							$(eleFocus).focus();
						}
					}
				}); 				
	$("#btnBack").button().click(function () {
		location.reload();
	});
	$("#btnSimpan").button().click(function () {
					if ($("#file").val() !='' && $("#txtNik").val().length >0 &&  $("#txtTglLahir").val().length >0)
						{ 
						$.ajax({
						type: "POST",
						url: "<?php echo site_url('admin/create/m_datapegawai'); ?>",
						data: { 
								nik: $("#txtNik").val(),
								nama: $("#txtNama").val(),
								kelamin: $("#cmbKelamin option:selected").val(),
								tmptlahir: $("#txtTmptLahir").val(),
								tgllahir: $("#txtTglLahir").val(),
								pendidikan: $('#txtPendidikan').val(),
								tmtdinas: $('#txtTglMasuk').val(),
								golongan: $("#txtPangkat").val(),
								jabatan: $('#txtJabatan').val(),
								status: $('#cmbStatus option:selected').val(),
								profesi: $('#txtProfesi').val()
							},
						success: function(msg) {
								if(msg)
									{
									 $("#tblData").dataTable().fnDraw();
										uploadfoto(msg);
										$("#insert-confirm").dialog("open");
										$("#lblloading").html("Registarsi Berhasil..!!");
									}else
									{
										$("#insert-confirm").dialog("open");
										$("#lblloading").html("Registarsi Gagal Hubungi Admin IT..!!");
									}
								}
						});	
											
				}else
					{	
					$("#txtAlert").html("Data Belum Lengkap...!!");
					$("#dlg-alert").dialog("open");	
					eleFocus="#txtNik";
					}
				});
		$("#txtTglLahir,#txtTglMasuk").datepicker({
                dateFormat : "yy-mm-dd",
                changeMonth : true,
                changeYear : true,
				showButtonPanel: true,
				yearRange: '1920:2050'
            });	
			$.unit = function(){
							$.ajax({
							type:"POST",
							dataType:'json',
							url:"<?php echo site_url('admin/multi_select');?>?table=m_unit",
							success: function(data)
							{
								if(data==''){
									var options = "<option value=''> -- No Result -- </option>";
									}else{
									var options = "<option value=''> -- Silahkan Pilih -- </option>";
									for (var i =0; i<data.length; i++)
											{
												
												options += "<option value='"+ data[i].id +"'>"+ data[i].name +"</option>";
											}
										}
											$("#cmbBidang").html(options);
												
							}
							});	
			}
			$("#cmbBidang").change(function() {
							$.ajax({
							type:"POST",
							dataType:'json',
							url:"<?php echo site_url('admin/multi_select');?>?table=m_unitinstalasi&select=unit_id&id="+$(this).val(),
							success: function(data)
							{
								if(data==''){
									var options = "<option value=''> -- No Result -- </option>";
									}else{
									var options = "<option value=''> -- Silahkan Pilih -- </option>";
									for (var i =0; i<data.length; i++)
											{
												
												options += "<option value='"+ data[i].id +"'>"+ data[i].name +"</option>";
											}
										}
											$("#cmbUnit").html(options);
												
							}
							});	
			});
				
});
</script>
	
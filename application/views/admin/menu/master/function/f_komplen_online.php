<script type="text/javascript">
		String.prototype.replaceAll = function(str1, str2, ignore) 
	{
		return this.replace(new RegExp(str1.replace(/([\/\,\!\\\^\$\{\}\[\]\(\)\.\*\+\?\|\<\>\-\&])/g,"\\$&"),(ignore?"gi":"g")),(typeof(str2)=="string")?str2.replace(/\$/g,"$$$$"):str2);
	};
            var selectedId;
			var eleFocus ='';
		
			$(document).ready(function () {
				Globalize.culture("id-ID");
				var today = "<?php echo R::isoDateTime(); ?>";
				$("#tblData").dataTable({
				    "bJQueryUI": true,
				    "bAutoWidth": true,
                    // "bProcessing": true,
					"iDisplayLength": 15,
					"aLengthMenu": [ 15, 30, 50,100 ],
                    "bServerSide": true,
                    "sPaginationType": "full_numbers",
                    "sAjaxSource": "<?php echo site_url('admin/get_data_table_source'); ?>?table=t_komplen_online&columns=,user_id,kategory,komplen,solve,solve_id,tglkomplen&jwhere=ruangan_id,user_id,kategory&fildjoins=,m_unitinstalasi.name,m_user.nama,t_komplen_kategory.nama as ctgr&joins=m_unitinstalasi,m_user,t_komplen_kategory&exports=m_unitinstalasi,m_user,t_komplen_kategory&cVoid= AND t_komplen_online.unit_id=<?php echo $subunit->id; ?>",
                    "aoColumns" : [
                        { "sTitle" : "#", "mData" : "no", "bSortable" : false, "sClass" : "center" },
						{ "sTitle" : "Tanggal", "sClass" : "center", "mData" : 'tglkomplen', "bSortable" : false, 
                            "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) { 
                                var id = "tglkomplen-" + oData.id;
                                $(nTd).attr("id", id);
                               /* $(nTd).editable("<?php echo site_url('admin/update_grid/t_komplen_online'); ?>", { 
                                    "callback": function( sValue, y ) {
                                         Redraw the table from the new data on the server 
                                        $("#tblData").dataTable().fnDraw();
                                    }
                                });*/
							}
                        },
						{ "sTitle" : "User Komplen", "mData" : "nama", 
                            "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) { 
                                var id = "nama-" + oData.id;
                                $(nTd).attr("id", id);
                                /*$(nTd).editable("<?php echo site_url('admin/update_grid/t_komplen_online'); ?>", { 
                                    "callback": function( sValue, y ) {
                                         Redraw the table from the new data on the server 
                                        $("#tblData").dataTable().fnDraw();
                                    }
                                });*/
                            } 
                        },
						{ "sTitle" : "Untuk", "mData" : "name", 
                            "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) { 
                                var id = "name-" + oData.id;
                                $(nTd).attr("id", id);
                                /*$(nTd).editable("<?php echo site_url('admin/update_grid/t_komplen_online'); ?>", { 
                                    "callback": function( sValue, y ) {
                                         Redraw the table from the new data on the server 
                                        $("#tblData").dataTable().fnDraw();
                                    }
                                });*/
                            } 
                        },
                        { "sTitle" : "Kategory Komplen", "mData" : "ctgr", 
                            "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) { 
                                var id = "kategory-" + oData.id;
                                $(nTd).attr("id", id);
                                /*$(nTd).editable("<?php echo site_url('admin/update_grid/t_komplen_online'); ?>", { 
                                    "callback": function( sValue, y ) {
                                         Redraw the table from the new data on the server 
                                        $("#tblData").dataTable().fnDraw();
                                    }
                                });*/
                            } 
                        },
                        { "sTitle" : "Komplen / Permintaan", "mData" : "komplen", 
                            "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) { 
                                var id = "komplen-" + oData.id;
                                $(nTd).attr("id", id);
                              /* $(nTd).editable("<?php echo site_url('admin/update_grid/t_komplen_online'); ?>", { 
                                    "callback": function( sValue, y ) {
                                         Redraw the table from the new data on the server 
                                        $("#tblData").dataTable().fnDraw();
                                    }
                                });*/
                            }
                        },
						{"sTitle" : "Solusi", "mData" : "solve",
                            "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) { 
                                var id = "solve-" + oData.id;
                                $(nTd).attr("id", id);
                               /* $(nTd).editable("<?php echo site_url('admin/update_grid/t_komplen_online'); ?>", { 
                                    "callback": function( sValue, y ) {
                                         Redraw the table from the new data on the server 
                                        $("#tblData").dataTable().fnDraw();
                                    }
                                });*/
                            }
                        },
                        { "sTitle" : "Petugas", "sClass" : "center", "mData" : 'petugas', "bSortable" : false, 
                            "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) { 
                                var id = "petugas-" + oData.id;
                                $(nTd).attr("id", id);
                                 /*$(nTd).editable("<?php echo site_url('admin/update_grid/t_komplen_online'); ?>", { 
                                    "callback": function( sValue, y ) {
                                        Redraw the table from the new data on the server 
                                        $("#tblData").dataTable().fnDraw();
                                    }
                                });*/
							}
                        },
						{"sTitle" : "Tanggal Selesai", "sClass" : "center", "mData" : 'tglselesai', "bSortable" : false, 
                            "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) { 
                                var id = "tglselesai-" + oData.id;
                                $(nTd).attr("id", id);
                               /* $(nTd).editable("<?php echo site_url('admin/update_grid/t_komplen_online'); ?>", { 
                                    "callback": function( sValue, y ) {
                                         Redraw the table from the new data on the server 
                                        $("#tblData").dataTable().fnDraw();
                                    }
                                });*/
							}
                        },
						{ 
                            "sTitle" : "Action", "sClass" : "center", "mData" : "action", "bSortable" : false, 							
                            "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
								 if (oData.action =='S') {
                                   htmlx= "<button style='background: #4BE807;background: -webkit-gradient(linear, left top, left bottom, from(#4BE807), to(#C4EB1A));'>Perosess</button>";
								 
									$(nTd).html(htmlx);
									$($(nTd).children()[0]).button().click(function () {
										var id = "action-" + oData.id;
										$(nTd).attr("id", id);
									});
									$($(nTd).children()[0]).find("span").css("padding", "2px 7px");
                                } else if (oData.action == 'P') {
									htmlx= "<button style='background: #EB1A1A; background: -webkit-gradient(linear, left top, left bottom, from(#EB1A1A), to(#EB891A)); color:#FBFAFA;'>Selesai</button>";
									$(nTd).html(htmlx);
									$($(nTd).children()[0]).button().click(function () {
										var id = "action-" + oData.id;
										$(nTd).attr("id", id);
										
									});
									$($(nTd).children()[0]).find("span").css("padding", "2px 7px");
                                }else {
									htmlx= "<button style='background: #EB1A1A; background: -webkit-gradient(linear, left top, left bottom, from(#EB1A1A), to(#EB891A)); color:#FBFAFA;'>Meunggu</button>";
									$(nTd).html(htmlx);
									$($(nTd).children()[0]).button().click(function () {
										var id = "action-" + oData.id;
										$(nTd).attr("id", id);
									});
									$($(nTd).children()[0]).find("span").css("padding", "2px 7px");
								}
                            }
                        }
                    ]
				});
				$("#dlg-alert").dialog({
					autoOpen: false,
					resizable: false,
					modal: true,
					buttons: {
						 OK: function() {
							$(this).dialog("close");
							$(eleFocus).focus();
							$(eleFocus).val('');
						}
					}
				}); 
                $("#data-baru-form").dialog({
                    autoOpen: false,
                    resizable: false,
					width: '50%',
                    modal: true,
                    buttons: {
                         Kirim: function() {
						   if( $("#txtKomplen").val().length >0 && $("#cmbInstalasi option:selected").val().length > 0 && $("#cmbKategory option:selected").val().length > 0)
							   {
								   $.ajax({
									type: "POST",
									url: "<?php echo site_url('admin/create/t_komplen_online'); ?>",
									data: { 
										user_id: <?php echo $user->id ?>,
										ruangan_id: $("#cmbInstalasi option:selected").val(),
										kategory: $("#cmbKategory option:selected").val(),
										komplen: $("#txtKomplen").val(),
										tglkomplen: today,
										role: "<?php echo $role->name;?>",
										unit_id: "<?php echo $subunit->id; ?>"
									},
									success: function(msg) {
									//debugger;
										console.log(msg);
										$("#tblData").dataTable().fnDraw();
									}
								});
								$(this).dialog("close");
							}else
							{
								$("#txtAlert").html("Data Harus Lengkap...!");
								$("#dlg-alert").dialog("open");
								eleFocus ='#txtKomplen';
							}
                           
                        },	
                        Cancel: function() {
                            $(this).dialog("close");
                        }
                    },
                    close: function() {
                        $("#txtKomplen").val("");
                        $("#cmbInstalasi option").eq(0).attr("selected", "selected");
                        $("#cmbKategory option").eq(0).attr("selected", "selected");
                    }
                });
         $("#btnInputKomplen").button().click(function () {
                    $("#data-baru-form").dialog("open");
					$.ajax({
						type:"POST",
						dataType:'json',
						url:"<?php echo site_url('admin/multi_select');?>?table=m_unitinstalasi",
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
							
										
										$("#cmbInstalasi").html(options);
											
						}
				});
                });
			$("#cmbInstalasi").change(function() {
							$.ajax({
							type:"POST",
							dataType:'json',
							url:"<?php echo site_url('admin/multi_select');?>?table=t_komplen_kategory&select=instalasi_id&id="+$(this).val(),
							success: function(data)
							{
								if(data==''){
									var options = "<option value=''> -- No Result -- </option>";
									}else{
									var options = "<option value=''> -- Silahkan Pilih -- </option>";
									for (var i =0; i<data.length; i++)
											{
												
												options += "<option value='"+ data[i].id +"'>"+ data[i].nama +"</option>";
											}
											$("#cmbKategory").removeAttr("disabled");
										}
										$("#cmbKategory").html(options);	
							}
							});	
			});	
			}); 
		</script>
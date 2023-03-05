<script type="text/javascript">
	String.prototype.replaceAll = function(str1, str2, ignore) {
		return this.replace(new RegExp(str1.replace(/([\/\,\!\\\^\$\{\}\[\]\(\)\.\*\+\?\|\<\>\-\&])/g,"\\$&"),(ignore?"gi":"g")),(typeof(str2)=="string")?str2.replace(/\$/g,"$$$$"):str2);
		};
    var selectedId;
    var fildeselect;
	var active;
	var eleFocus ='';
	$(document).ready(function () {
	$('[data-toggle="#Datamaster"]').addClass('menu-open');
   	$('a[href="'+location+'"]').addClass('active');	

	$("#tblData").dataTable({
		"bJQueryUI": true,
		"bAutoWidth": false,
        // "bProcessing": true,
		"iDisplayLength": 15,
		"aLengthMenu": [ 15, 30, 50,100 ],
        "bServerSide": true,
        "sPaginationType": "full_numbers",
    	"sAjaxSource": "<?php echo site_url('admin/get_data_table_source'); ?>?table=m_user&columns=,nama,username,status,role_id,auth,ipaddress,unit_id,m_role.name&jwhere=role_id,unit_id&fildjoins=,m_role.name,m_unit.name as inst&joins=m_role,m_unit&exports=m_role,m_unit",
        "aoColumns" : [
            {"sTitle" : "#", "mData" : "no", "bSortable" : false, "sClass" : "center" },
            {"sTitle" : "Nama", "mData" : "nama","fnCreatedCell": function (nTd, sData, oData, iRow, iCol){ 
				var id = "nama-" + oData.id;
				$(nTd).attr("id", id);
				$(nTd).editable("<?php echo site_url('admin/update_grid/m_user'); ?>", { 
						"callback": function( sValue, y ) {
						/* Redraw the table from the new data on the server */
						$("#tblData").dataTable().fnDraw();
						}
					});
				}
            },
            {"sTitle" : "Username", "mData" : "username","fnCreatedCell": function (nTd, sData, oData, iRow, iCol) { 
                var id = "username-" + oData.id;
                $(nTd).attr("id", id);
                }
            },
            {"sTitle" : "Unit / Bagian", "mData" : "inst","fnCreatedCell": function (nTd, sData, oData, iRow, iCol) { 
                var id = "unit_id-" + oData.id;
                $(nTd).attr("id", id);
            	}
            },
			{"sTitle" : "Role", "mData" : "name","fnCreatedCell": function (nTd, sData, oData, iRow, iCol) { 
                var id = "role_id-" + oData.id;
                $(nTd).attr("id", id);
                $(nTd).editable("<?php echo site_url('admin/update_grid/m_user'); ?>?table=m_role", { 
                loadurl : "<?php echo site_url('admin/get_editable_select'); ?>?table=m_role&filds=name&select=" + oData.role_id ,
                type   : "select",
                submit : "OK",
                "callback": function( sValue, y ) {
                     /* Redraw the table from the new data on the server */
                $("#tblData").dataTable().fnDraw();
                    }
                });
                }
            },
            {"sTitle" : "Action", "sClass" : "center", "mData" : null, "bSortable" : false,"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) { 
                $(nTd).html("<button class='btn btn-xs bg-info'><i class='fas fa-lock'></i><span> Ubah Password</span></button>");
                $($(nTd).children()[0]).button().click(function () {
                    selectedId = oData.id;
					$('#txtNamas').val(oData.nama);
					$('#txtUsernames').val(oData.username);
					$('#txtPasswordBaru').focus();
                    $("#dlgEditPassword").modal("show");
                    });
                } 
            },
			{ "sTitle" : "Connecting", "sClass" : "center", "mData" : "auth", "bSortable" : true,"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
				if (oData.auth =='Y') {
                htmlx= "<button class='btn btn-xs bg-green waves-effect'><span>Online</span></button>";
				$(nTd).html(htmlx);
					$($(nTd).children()[0]).button().click(function () {
					var id = "auth-" + oData.id;
					$(nTd).attr("id", id);
					selectedId = oData.id;
					fildeselect = "auth";
					active = 'N';
					$("#txtDecision").html("Resset Login User..?");
					$("#dlgDecision").modal("show");
					});
				$($(nTd).children()[0]).find("span").css("padding", "2px 2px");
                    } else if (oData.auth == 'N') {
						htmlx= "<button class='btn btn-xs bg-red waves-effect'><span>Offline</span></button>";
						$(nTd).html(htmlx);
						$($(nTd).children()[0]).button().click(function () {
						var id = "auth-" + oData.id;
						$(nTd).attr("id", id);
						});
                    } 
                }
            },
			{ "sTitle" : "Status", "sClass" : "center", "mData" : "status", "bSortable" : false,"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
				if (oData.status =='Y') {
            	htmlx= "<button class='btn btn-xs bg-green waves-effect'><span>Active</span></button>";
				$(nTd).html(htmlx);
				$($(nTd).children()[0]).button().click(function () {
					var id = "status-" + oData.id;
					$(nTd).attr("id", id);
					selectedId = oData.id;
					fildeselect = "status";
					active = 'N';
					$("#txtDecision").html("Username akan di blokir..?");
					$("#dlgDecision").modal("show");
				});
				$($(nTd).children()[0]).find("span").css("padding", "2px 2px");
            	} else if (oData.status == 'N') {
					htmlx= "<button class='btn btn-xs bg-red waves-effect'><span>Deactive</span></button>";
					$(nTd).html(htmlx);
					$($(nTd).children()[0]).button().click(function () {
						var id = "status-" + oData.id;
						$(nTd).attr("id", id);
						fildeselect = "status";
						selectedId = oData.id;
						active = 'Y';
						$("#txtDecision").html("Username akan di aktivkan..?");
						$("#dlgDecision").modal("show");
					});
					}
            	}
            }, 
			{"sTitle" : "Alamat IP", "mData" : "ipaddress","fnCreatedCell": function (nTd, sData, oData, iRow, iCol) { 
                var id = "ipaddress-" + oData.id;
                $(nTd).attr("id", id);
				if(oData.ipaddress != null){
				$(nTd).html("<label>"+ oData.ipaddress +" WAKTU SESSION "+oData.date+"</label>");
					}else {
					$(nTd).html("<label><small>Alamat Tidak Terdeteksi</small></label>");
					}
                }
            }
            ]
		});
	$('#btn-prosess').button().click(function () {
		$.ajax({
				url: "<?php echo site_url('admin/aktive/m_user'); ?>/"+ fildeselect +"/" + selectedId +"/"+ active,
				success: function(data) {
				$("#tblData").dataTable().fnDraw();
				$("#dlgDecision").modal("hide");
			}
        });
		}); 
	$("#editPassword").submit(function(e){ 
		e.preventDefault();
		if($('#editPassword').valid()){
        $.ajax({type: "POST",
                url: "<?php echo site_url('admin/update/m_user'); ?>",
                data: { id: selectedId, 
				password : $.md5($("#txtPasswordBaru").val()),
				},success: function(msg) {
                console.log(msg);
				if(msg){
				$("#tblData").dataTable().fnDraw();
				$("#dlgEditPassword").modal("hide");
				$("#txtPasswordBaru").val('');
				$("#lblText").html("Update Password Berhasil");
				$("#dlgAlert").modal("show");
				}else{$("#lblText").html("Merubah password Gagal..");
						$("#dlgAlert").modal("show");
					}
                }
            });
        }
    	});
    $("#add-data").submit(function(e){   
		e.preventDefault();
		if($('#add-data').valid()){
			$.ajax({type: "POST",
					dataType:'json',
					url: "<?php echo site_url('admin/create_username/m_user'); ?>",
					data: { nama: $("#txtNama").val(),
							username: $("#txtUsername").val(),
							password: $.md5($("#txtPassword").val()),
							role_id: $("#cmbRole option:selected").val(),
							status: 'N',
							auth: 'N',
							//employ_id: selectedId,
							email: $("#txtEmail").val()
							},success: function(msg) {
							if(msg.error == false){
								$("#tblData").dataTable().fnDraw();
								$("#frm-add").modal("hide");
								var title = "Add Form";
								var label = "Tambah Username";
								var message = msg.message;
								alert_success(title, label, message);
							}else{
								$("#tblData").dataTable().fnDraw();
								var title = "Add Form";
								var label = "Tambah Username";
								var message = msg.message;
								alert_warning(title, label, message);
							}
					}
				});
			}
        });
		
    $("#btnAdd").button().click(function () {
		$("#cmbStruktur").empty();
		$.ajax({type:"POST",
				dataType:'json',
				url:"<?php echo site_url('admin/multi_select');?>?table=m_struktur",
				success: function(data){
				if(data==''){
					$("#cmbStruktur").append("<option value=''> -- No Result -- </option>");
					}else{
						$("#cmbStruktur").append("<option value=''> -- Silahkan Pilih -- </option>");
					for (var i =0; i<data.length; i++){
						$("#cmbStruktur").append("<option value='"+ data[i].id +"'>"+ data[i].name +"</option>");
					}
				$("#frm-add").modal("show");			
				}
			}
			});
		});
	$.cekUser = function(id){
		$.ajax({type:"POST",
				dataType:'json',
				url:"<?php echo site_url('admin/CekUser');?>/"+ id,
				success: function(data){
				if(data.kapangih == true){
				$("#lblText").html("Username Sudah Ada..!");
				$("#dlgAlert").modal("show");	
				eleFocus ="#txtUsername";
				$("#txtUsername").css({"background": "yellow"});
				}else{
				$("#cmbUnit").focus();
				}	
			}
		});	
		}			
	$("#cmbStruktur").change(function() {
		$.ajax({type:"POST",
				dataType:'json',
				url:"<?php echo site_url('admin/multi_select');?>?table=m_unit&select=struktur_id&id="+$(this).val(),
				success: function(data){
					$("#cmbUnit").empty();
				if(data==''){
					$("#cmbUnit").append("<option value=''> -- No Result -- </option>");
					}else{
						$("#cmbUnit").append("<option value=''> -- Silahkan Pilih -- </option>");
				for (var i =0; i<data.length; i++){
					$("#cmbUnit").append("<option value='"+ data[i].id +"'>"+ data[i].name +"</option>");
					}
				}
			$.cekUser($("#txtUsername").val());	
			}
		});	
		});	
	$("#cmbUnit").change(function() {
		$.ajax({type:"POST",
				dataType:'json',
				url:"<?php echo site_url('admin/multi_select');?>?table=m_role&select=unit_id&id="+$(this).val(),
				success: function(data){
				$("#cmbRole").empty();
				if(data==''){
					$("#cmbRole").append("<option value=''> -- No Result -- </option>");
					}else{
						$("#cmbRole").append("<option value=''> -- Silahkan Pilih -- </option>");
					for (var i =0; i<data.length; i++){
						$("#cmbRole").append("<option value='"+ data[i].id +"'>"+ data[i].name +"</option>");
						}
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
<?php if ( ! defined( 'BASEPATH')) exit(
'No direct script access allowed'); ?>
<script>
String.prototype.replaceAll = function(str1, str2, ignore) 
	{
		return this.replace(new RegExp(str1.replace(/([\/\,\!\\\^\$\{\}\[\]\(\)\.\*\+\?\|\<\>\-\&])/g,"\\$&"),(ignore?"gi":"g")),(typeof(str2)=="string")?str2.replace(/\$/g,"$$$$"):str2);
	};
	var eleCaptcha=false;
	var ipKomputer;
	var OSName = "Unknown OS";
	var HDInfo = "Unknown Iformation";
	var Device = "No Detect";
	var d = new Date(); 		
	$(document).ready(function() {
		$("#Capthca").find("img").addClass("img");
		$('#sign_in').submit(function(e){
			e.preventDefault();
			if($('#sign_in').valid()){
					$.ajax({
							type: "POST",
							dataType: 'json',
							url: "<?php echo site_url('login/auth');?>",
							data:{username: $("#txtUsername").val(),
									password:  $.base64.encode($("#txtPassword").val())
									},
							success: function(msg){
									//debugger;
									if(msg.auth == false){
										$("#notif").find('i').text('verified_user');
										$("#notif").find("label").text('info..');
										$("#notif").find("small").text('waiting from redirecting..');
										$("#notif").find('i').addClass('text-green');
										$('#btn_sigin').attr('disabled','disabled');
										load_computer_information();		
										window.location.reload('admin');								
										}else if(msg.auth == true){
										$("#notif").find("label").text('warning..');
										$("#notif").find("small").text('Cek kembali User login anda..!');
										$("#notif").find('i').addClass('text-yellow');
										$("#notif").find('i').text('report');	
										window.location.reload('login');										
									}
								}
							});
				}				
			});
		$("#txtPassword").keydown(function (event){
						if (event.which == 13) {
							if($(this).val().length > 0){
								$("#txtcaptcha").focus();								
							}else{
							$("#txtPassword").focus();
							}
						}
				});
		$("#txtcaptcha").keyup(function(){
				if($("#txtcaptcha").val().length >= 6){					
					$.ajax({
					type: "POST",
					dataType: 'json',
					url: "<?php echo site_url('login/cek_captcha');?>?id="+$(this).val(),
					success: function(msg)
								{
								if(msg.error == true){
									$("#notif").find("label").text('warning..');
									$("#notif").find("small").text('Code Tidak Sesuai.. '+msg.message);
									$("#notif").find('i').addClass('text-red');
									$("#notif").find('i').text('report');
									$("#txtcaptcha").removeAttr('disabled');
									window.location.reload('login');
									}else if(msg.error == false){
										$("#txtcaptcha").attr('disabled','disabled');
										eleCaptcha = true;
										$("#notif").find("label").text('info..');
										$("#notif").find("small").text('Code Sesuai.. '+msg.message);
										$("#notif").find('i').addClass('text-blue');
										$("#notif").find('i').text('verified_user');
										$('#sign_in').submit().click();															
									}
								}
							});
					}			 
			});				
		function load_computer_information($ip){ 
			try
				{
					if (navigator.appVersion.indexOf("Win") != -1) OSName = "Windows";
					else if (navigator.appVersion.indexOf("Mac") != -1) OSName = "MacOS";
					else if (navigator.appVersion.indexOf("X11") != -1) OSName = "UNIX";
					else if (navigator.appVersion.indexOf("Linux") != -1) OSName = "Linux";
					HDInfo = OSName +" "+ navigator.platform;
					//console.log(HDInfo);
				}catch (e){
					//console.log(HDInfo);
					HDInfo =('Permission to access computer name is denied');
				} 
				sys_security($ip,Device,HDInfo);
			}	
		function sys_security($ipaddress,$devices,$OSName){
			var date = "<?php echo R::isoDateTime(); ?>";
				$.ajax({
						type: "POST",
						dataType: 'json',
						url: "<?php echo site_url('home/sys_user_monitoring/n_web_monitoring'); ?>",
						data: {
								ipaddress:$ipaddress,
								devices:$devices,
								os:$OSName,
								upd_time: d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds(),
								tanggal: date.substring(0,10),
						},
				success: function(msg){}
				});
			}
		});	

</script>
	

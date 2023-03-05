<?php if ( ! defined( 'BASEPATH')) exit('No direct script access allowed'); ?>
<script type="text/javascript">
		String.prototype.replaceAll = function(str1, str2, ignore) 
			{
			return this.replace(new RegExp(str1.replace(/([\/\,\!\\\^\$\{\}\[\]\(\)\.\*\+\?\|\<\>\-\&])/g,"\\$&"),(ignore?"gi":"g")),(typeof(str2)=="string")?str2.replace(/\$/g,"$$$$"):str2);
            };
            var date = "<?php echo R::isoDateTime(); ?>";
        $(document).ready(function () {
            $("#frm-register").hide();
            $("#btn-registrasi").click(function () {
                $("#frm-register").show();
                $("#frm-login").hide();
            });
            $("#btn-bck-login").click(function () {
                $("#frm-register").hide();
                $("#frm-login").show();
            });
            $('#registrasiForm').submit(function (e) {
                e.preventDefault();
                if ($('#registrasiForm').valid()) {
                    $.ajax({
                        type: "POST",
                        dataType: 'json',
                        url: "<?php echo base_url('login/member_singup');?>",
                        data: {
                            first_name: $("#first_name").val(),
                            last_name: $("#last_name").val(),
                            email: $("#r_email").val(),
                            password: $.base64.encode($("#r_password").val()),
                            datetime: date,
                        },
                        success: function (msg) {
                            if(msg.auth == false){
                                window.location.href = "<?php echo site_url('home/page').'?link='.base64_encode("portal-menu-content-html-h_member_area");?>";
                            }else{
                                location.reload();
                            }
                            
                        }
                    });
                }
            });
            $('#loginForm').submit(function (e) {
                e.preventDefault();
                if ($('#loginForm').valid()) {
                    $(".log-area").hide();
                    $("#loading-login").show();
                    var datalogin = {
                        username: $("#txt_email").val(),
                        password: $.base64.encode($("#txt_password").val()),
                    };
                    $.ajax({
                        type: "POST",
                        dataType: 'json',
                        url: "<?php echo base_url('login/member_auth');?>",
                        data: datalogin,
                        success: function (msg) {
                            if(msg.auth == false){
                                $('#loginForm')[0].reset();
								window.location.href = "<?php echo site_url('home/'.$this->input->get('ctrl')).'?link='.$this->input->get('page').'&id='.$this->input->get('id');?>";
								}else{
                                $(".log-area").show();
                                $("#loading-login").hide();    
								location.reload('home');
							}
                        }
                    });
                }
            });
        });
        
</script>
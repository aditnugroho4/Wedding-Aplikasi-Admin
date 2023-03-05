<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<script>
    var load;
    var interval;
    var onlineCheck=false;
    var chatRoom = false;
    jQuery.event.special.touchstart = {
        setup: function( _, ns, handle ){
            if ( ns.includes("noPreventDefault") ) {
            this.addEventListener("touchstart", handle, { passive: false });
            } else {
            this.addEventListener("touchstart", handle, { passive: true });
            }
        }
    };
    $(document).ready(function () {
        // Session 
        var session = "<?php if(isset($_SESSION['akbarId'])) echo ($_SESSION['akbarId']['id']);?>";
        var user = "<?php if(isset($_SESSION['akbarId'])) echo ($_SESSION['akbarId']['nama']);?>";
        var adminId=null;

        // elementasi form
        var chat = $('.chat');
        var elementLogin = $('#chat_login');
        var elementChat = $('#chat_converse');
        var control = $('.fab_field');
        var notif = $('.online');
        chat.hide();
        var messageSend = control.find('#chatSend');

        var myStorage = localStorage;

    $('#prime').click(function() {
        if(chatRoom== false){
            chat.show();            
            chatRoom=true;
        }else if(chatRoom== true){
            chat.hide();
            chatRoom=false;
        }
        toggleFab();
        Notification(false);
    });
    //Toggle chat and links
    function toggleFab() {        
        $('.prime').toggleClass('zmdi-comment-outline');
        $('.prime').toggleClass('zmdi-close');
        $('.prime').toggleClass('is-active');
        $('.prime').toggleClass('is-visible');
        $('#prime').toggleClass('is-float');
        $('.chat').toggleClass('is-visible');
        $('.fab').toggleClass('is-visible'); 
        hideChat(0);
    }

    $('#chat_first_screen').click(function(e) {
        if(session){   
                hideChat(2);      
                loadChatHistory(); 
                messageSend.focus(); 
                onlineCheck=true;
            }else{
                hideChat(1);
                onlineCheck=false;
            }
    });

    $('#chat_second_screen').click(function(e) {
            hideChat(2);
    });

    $('#chat_third_screen').click(function(e) {
            hideChat(3);
    });

    $('#chat_fourth_screen').click(function(e) {
            hideChat(4);
    });

    $('#chat_fullscreen_loader').click(function(e) {
        $('.fullscreen').toggleClass('zmdi-window-maximize');
        $('.fullscreen').toggleClass('zmdi-window-restore');
        $('.chat').toggleClass('chat_fullscreen');
        $('.fab').toggleClass('is-hide');
        $('.header_img').toggleClass('change_img');
        $('.img_container').toggleClass('change_img');
        $('.chat_header').toggleClass('chat_header2');
        $('.fab_field').toggleClass('fab_field2');
        $('.chat_converse').toggleClass('chat_converse2');
        $('.chat_converse').css('height', '100%');
        //$('#chat_converse').css('display', 'none');
        // $('#chat_body').css('display', 'none');
        // $('#chat_form').css('display', 'none');
        // $('.chat_login').css('display', 'none');
        // $('#chat_fullscreen').css('display', 'block');
    });

    function hideChat(hide) {
        switch (hide) {
        case 0:
                $('#chat_welcome').css('display', 'block');
                $('#chat_converse').css('display', 'none');
                $('#chat_login').css('display', 'none');
                $('#chat_body').css('display', 'none');
                // $('#chat_form').css('display', 'none');
                $('.fab_field').css('display', 'none');
                $('.chat_fullscreen_loader').css('display', 'none');
                $('#chat_fullscreen').css('display', 'none');      
                $('.fab_field').find('#chatSend').off('keydown', onMetaAndEnter).prop("disabled", true).blur();                         
                break;
        case 1:
                $('#chat_login').css('display', 'block');
                $('#chat_converse').css('display', 'none');
                $('#chat_welcome').css('display', 'none');
                // $('#chat_body').css('display', 'none');
                // $('#chat_form').css('display', 'none');                
                $('.chat_fullscreen_loader').css('display', 'block');
                $('.fab_field').css('display', 'none');
                $('.chat_converse').css('height', 'auto');
                break;
        case 2:
                $('#chat_converse').css('display', 'block');
                $('#chat_login').css('display', 'none');
                $('#chat_welcome').css('display', 'none');
                // $('#chat_body').css('display', 'none');
                // $('#chat_form').css('display', 'none');
                $('.chat_fullscreen_loader').css('display', 'block');
                $('.fab_field').css('display', 'block');
                $('.fab_field').find('#chatSend').keydown(onMetaAndEnter).prop("disabled", false).focus();
                $('.fab_field').find('#fab_send').click(sendNewMessage);
                break;
        case 3:
                $('#chat_converse').css('display', 'none');
                $('#chat_body').css('display', 'none');
                // $('#chat_form').css('display', 'block');
                $('.chat_login').css('display', 'none');
                $('.chat_fullscreen_loader').css('display', 'block');
                break;
        case 4:
                $('#chat_converse').css('display', 'none');
                $('#chat_body').css('display', 'none');
                $('#chat_form').css('display', 'none');
                $('.chat_login').css('display', 'none');
                $('.chat_fullscreen_loader').css('display', 'block');
                $('#chat_fullscreen').css('display', 'block');
                break;
        }
    }

    // controler \\
    // Call Oprator
    $("#chat-form").submit(function(e){ 
            e.preventDefault();
            if($('#chat-form').valid()){
                elementLogin.append('<div class="loader" style="z-index:1000;"></div>'); 
                $('#btn-send').attr('disabled','disabled');
                $.ajax({
                    url: "<?php echo site_url('Chatboot/chat_send_cookie'); ?>",
                    dataType: "json",
                    type: "post",
                    data: {nama:$("#txt_nama").val(),
                            email:$("#txt_email").val(),
                            telpon:$("#txt_tlp").val()
                    },
                    success:function(msg){
                        if(msg.error == "false"){
                            session = msg.id;
                            loadChatHistory();
                            elementLogin.find('.loader').remove();
                            $("#chat-form")[0].reset();
                            hideChat(2);
                            messageSend.focus();
                            $('#btn-send').removeAttr('disabled');
                            //footer.show();
                            //alert(msg.message);
                        }else if(msg.error == "true"){
                            //element.find(idelement).show();
                            //messageSend.hide();
                           // footer.hide();
                           elementLogin.find('.loader').remove();
                           $("#chat-form")[0].reset();
                           $('#btn-send').removeAttr('disabled');
                            alert(msg.message);
                        }
                        
                    }
                });
            }
        });
        // Load history chat
        function loadChatHistory() {
            if(session){         
                    elementChat.append('<div class="loader" style="z-index:1000;"></div>');                            
                    $.ajax({
                        url: "<?php echo site_url('Chatboot/chat_load_message'); ?>",
                        dataType: "json",
                        type: "post",
                        data: { clientId:session,
                                adminId:adminId},
                            success:function(msg){
                                if(msg.error ==false){    
                                    elementChat.html("");   
                                    var welcome="Hai.."+ user + " Selamat Datang di Akbar Grup..";               
                                    if(msg.data.newMessage){
                                        elementChat.append([
                                                '<span class="chat_msg_item chat_msg_item_admin">',
                                                    '<div class="chat_avatar">',
                                                    '<img src="<?php echo base_url(); ?>asset/portal/img/icon/akbar-group.png" alt="Support Wedding Organizer"/>',
                                                    '</div>',
                                                    welcome.replace(/\<div\>|\<br.*?\>/ig, '\n').replace(/\<\/div\>/g, '').trim().replace(/\n/g, '<br>'),
                                                '</span>'
                                                ].join(''));        
                                            for (var i = 0; i < msg.data.newMessage.length; i++) {
                                                if(msg.data.newMessage[i].clientId == session && msg.data.newMessage[i].adminId == null){                                                
                                                    elementChat.append([
                                                        '<span class="chat_msg_item chat_msg_item_user">',
                                                            msg.data.newMessage[i].message.replace(/\<div\>|\<br.*?\>/ig, '\n').replace(/\<\/div\>/g, '').trim().replace(/\n/g, '<br>'),
                                                            '</span>',
                                                        '<span class="status">'+msg.data.newMessage[i].nama+' ('+msg.data.newMessage[i].date+')</span>'].join(''));
                                                }else if(msg.data.newMessage[i].clientId == session && msg.data.newMessage[i].adminId != null) {
                                                    if(msg.data.newMessage[i].status == null){
                                                        readChat(msg.data.newMessage[i].id);
                                                    }
                                                    elementChat.append([
                                                    '<span class="chat_msg_item chat_msg_item_admin">',
                                                        '<div class="chat_avatar">',
                                                        '<img src="<?php echo base_url(); ?>asset/portal/img/icon/akbar-group.png" alt="Client Akbar Group Wedding"/>',
                                                        '</div>',
                                                        msg.data.newMessage[i].message.replace(/\<div\>|\<br.*?\>/ig, '\n').replace(/\<\/div\>/g, '').trim().replace(/\n/g, '<br>'),
                                                    '</span>'].join(''));
                                                }
                                            }
                                            adminId = msg.data.newMessage[0].adminId;
                                            user = msg.data.newMessage[0].nama;
                                        }
                                        if(msg.data.length == 0 ){
                                            var welcome="Hai.."+ user + " Selamat Datang di Akbar Grup..";
                                            elementChat.append([
                                                '<span class="chat_msg_item chat_msg_item_admin">',
                                                    '<div class="chat_avatar">',
                                                    '<img src="<?php echo base_url(); ?>asset/portal/img/icon/akbar-group.png" alt="Support Wedding Organizer"/>',
                                                    '</div>',
                                                    welcome.replace(/\<div\>|\<br.*?\>/ig, '\n').replace(/\<\/div\>/g, '').trim().replace(/\n/g, '<br>'),
                                                '</span>'
                                                ].join('')); 
                                        }
                                        elementChat.finish().animate({
                                            scrollTop: elementChat.prop("scrollHeight")
                                        }, 250);
                                    }
                                    Notification(true);
                                    notif.find('.lampu').remove();
                                    elementChat.find('.loader').remove();
                                }
                        });
                }
            }
        // Triger
        function onMetaAndEnter(event) {
            if ((event.metaKey || event.ctrlKey) && event.keyCode == 13) {
                sendNewMessage();
            }
        }

        $('#fab_send').click(function() {   
            if(onlineCheck == true){
                sendNewMessage();
            }else{
                messageSend.focus();
            }    
        });

        function sendNewMessage() {    
            Notification(false);    
            //alert('Fuck Me..');   
            var newMessage = messageSend.val();
            newMessage.replace(/\<div\>|\<br.*?\>/ig, '\n').replace(/\<\/div\>/g, '').trim().replace(/\n/g, '<br>');

            if (!newMessage) return;

            elementChat.append([
                    '<span class="chat_msg_item chat_msg_item_user">',
                    newMessage,
                        '</span>',
                    '<span class="status">new</span>'].join(''));
                    messageSend.val('');
                    messageSend.focus();
                elementChat.finish().animate({
                    scrollTop: elementChat.prop("scrollHeight")
                    }, 250);
            // Sending to Database 
                $.ajax({
                    url: "<?php echo site_url('Chatboot/chat_send_message'); ?>",
                    dataType: "json",
                    type: "post",
                    data: { adminId:adminId,
                            clientId:session,
                            message:newMessage
                        },
                        success:function(msg){
                            if(msg.error ==false){  
                                Notification(true); 
                            }
                        }
                    });
            }
        // Load Replay Message
        function Notification(flag){
            if(flag == true){
                interval = setInterval(function () {                    
                    loadReplayMessage();
                }, 5000);
            }else if(flag==false){
                clearInterval(interval);
                notif.find('.lampu').remove();
            }
        }

        function loadReplayMessage() {                    
                $.ajax({
                    url: "<?php echo site_url('Chatboot/chat_load_message'); ?>",
                    dataType: "json",
                    type: "post",
                    data: { clientId:session,adminId:adminId},
                        success:function(msg){
                            if(msg.error ==false){
                                if(msg.count){
                                    Notification(false);
                                        for (var i = 0; i < msg.data.newMessage.length ; i++) {
                                            if(msg.data.newMessage[i].clientId == session || msg.data.newMessage[i].adminId == adminId){
                                                    if(msg.data.newMessage[i].status == null){
                                                        elementChat.append([
                                                            '<span class="chat_msg_item chat_msg_item_admin">',
                                                            '<div class="chat_avatar">',
                                                            '<img src="<?php echo base_url(); ?>asset/portal/img/icon/akbar-group.png" alt="Support Wedding Organizer"/>',
                                                            '</div>',
                                                            msg.data.newMessage[i].message.replace(/\<div\>|\<br.*?\>/ig, '\n').replace(/\<\/div\>/g, '').trim().replace(/\n/g, '<br>'),
                                                            '</span>'].join(''));                                                        
                                                        readChat(msg.data.newMessage[i].id);
                                                        load=true;
                                                    }
                                                }
                                            }
                                        if(load == true){ 
                                            load == false;
                                            var audioElement = document.getElementById("audio");
                                            audioElement.setAttribute('src',"<?php echo base_url();?>vocal/clink-clink.mp3");
                                            audioElement.volume = 0.8;
                                            audioElement.autoplay = true;
                                            audioElement.load();
                                            elementChat.finish().animate({
                                                    scrollTop: elementChat.prop("scrollHeight")
                                                }, 250);
                                        }
                                        Notification(true);                                        
                                    }    
                            }else{
                                Notification(true);
                            }
                        }
                    });
                return;
            }

            function readChat(selectedId){
                $.ajax({
				type: "POST",
				dataType: 'json',
				url: "<?php echo site_url('Chatboot/read_chat/m_user_chat_replay/status'); ?>/" + selectedId + "/R",
				success: function (data) {
				    }
				});
            }
    });
</script>
<div class="fabs">
    <div class="chat">
        <div class="chat_header">
            <div class="chat_option">
                <div class="header_img">
                    <img width="55" height="58" class="lazyload" data-src="<?php echo base_url(); ?>asset/portal/img/icon/cs-ico.png"
                        alt="Chat Room Wedding Organizer" />
                </div>
                <span id="chat_head">Akbar Grup</span> <br> <span class="agent">Support</span><span class="online">(<i
                        class="spinner-grow spinner-grow-sm text-danger lampu" role="status"></i> Online)</span>
                <span id="chat_fullscreen_loader" class="chat_fullscreen_loader"><i
                        class="fullscreen zmdi zmdi-window-maximize"></i></span>
                <audio id="audio" autoplay style="display:none;"></audio>
            </div>
        </div>
        <div id="chat_welcome" class="chat_body">
            <div id="chat_first_screen" class="fab"><i class="fa fa-arrow-circle-o-right"></i></div>
            <p>Temukan Kemudahan dalam berkonsultasi dengan kami, Tanyakan apa saja kepada kami tentang kebutuhan
                pernikahan anda..</p>
        </div>
        <div id="chat_login" class="chat_conversion chat_converse">
            <div class="fab"><i class="fa fa-envelope-o"></i></div>
            <div class="col-12">
                <p class="text-center">Masukan data anda dan mulai percakapan</p>
                <div class="card">
                    <div class="card-body">
                        <form id="chat-form">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="txt_nama" name="Nama" maxlength="50"
                                    placeholder="Nama Lengkap" required autofocus>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fa fa-user"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="email" class="form-control" id="txt_email" name="Email"
                                    placeholder="Alamat Email" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fa fa-envelope"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="number" class="form-control" id="txt_tlp" name="Telpon"
                                    placeholder="No WhatsApp" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fa fa-whatsapp"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <input type="submit" id="btn-send" class="btn btn-primary btn-block" value="Kirim"/>
                            </div>
                        </form>
                    </div>

                </div>
            </div>

        </div>
        <div id="chat_converse" class="chat_conversion chat_converse">
        </div>
        <div class="fab_field">
            <div id="fab_camera" class="fab"><i class="fa fa-camera"></i></div>
            <div id="fab_send" class="fab send-chat"><i class="fa fa-send"></i></div>
            <textarea id="chatSend" name="chat_message" placeholder="Send a message"
                class="chat_field chat_message"></textarea>
        </div>
    </div>
    <div id="prime" class="fab"><i class="fa fa-whatsapp prime"></i></div>
</div>


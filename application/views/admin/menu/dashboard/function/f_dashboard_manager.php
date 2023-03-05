<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript">
String.prototype.replaceAll = function(str1, str2, ignore) {
    return this.replace(new RegExp(str1.replace(/([\/\,\!\\\^\$\{\}\[\]\(\)\.\*\+\?\|\<\>\-\&])/g, "\\$&"), (
        ignore ? "gi" : "g")), (typeof(str2) == "string") ? str2.replace(/\$/g, "$$$$") : str2);
};
var htmlx = '';
var selectedId;
var clientId;
var menu = {
    codeunit: '',
    namaunit: ''
};
var interval;
var load;
var loadUser;
var start = 0;
var limit = 5;
$(document).ready(function() {
    Globalize.culture("id-ID");
    var $date = "<?php echo R::isoDateTime(); ?>";
    var session = "<?php echo $user->id; ?>";
    var element = $('.list-user');
    var userInput = $('#text-box');
    var myStorage = localStorage;
    var messagesContainer = $('.direct-chat-messages');
    $("#btnSend").prop("disabled", true).blur();
    userInput.keydown(onMetaAndEnter).prop("disabled", true).focus();

    setTimeout(function() {
        element.click(get_client_list);
    }, 250);


    if (!myStorage.getItem('chatID')) {
        myStorage.setItem('chatID', createUUID());
    }

    function createUUID() {
        // http://www.ietf.org/rfc/rfc4122.txt
        var s = [];
        var hexDigits = "0123456789abcdef";
        for (var i = 0; i < 36; i++) {
            s[i] = hexDigits.substr(Math.floor(Math.random() * 0x10), 1);
        }
        s[14] = "4"; // bits 12-15 of the time_hi_and_version field to 0010
        s[19] = hexDigits.substr((s[19] & 0x3) | 0x8, 1); // bits 6-7 of the clock_seq_hi_and_reserved to 01
        s[8] = s[13] = s[18] = s[23] = "-";

        var uuid = s.join("");
        return uuid;
    }

    function get_client_list() {
        $('.direct-chat').append('<div class="overlay"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>');
        $('.contacts-list').html('');
        messagesContainer.html('');
        try {
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "<?php echo site_url('dashboard/json_get_client');?>",
                success: function(msg) {
                    if (msg.error == false) {
                        var foto;
                        for (var i = 0; i < msg.data.length; i++) {
                            if (msg.data[i].foto) {
                                foto = msg.data[i].foto;
                            } else {
                                foto = "avatar5.png";
                            }
                            if (typeof(msg.data[i].message.message) != "undefined") {
                                $('.contacts-list').append('<li onclick="$.openChat(' + msg.data[i]
                                    .user.id + ');">' +
                                    '<a >' +
                                    '<img class="contacts-list-img" src="<?php echo base_url('asset/images/user/')?>' +
                                    foto + '">' +

                                    '<div class="contacts-list-info">' +
                                    '<span class="contacts-list-name">' + msg.data[i].user
                                    .nama +
                                    '<small class="contacts-list-date float-right">' + msg.data[
                                        i].message.date + '</small>' +
                                    '</span>' +
                                    '<span data-toggle="tooltip" title="Hapus Chat" class="badge badge-danger float-right ml-2" onclick="$.clearChat(' +
                                    msg.data[i].user.id +
                                    ');"><i class=" fas fa-trash"></i></span>' +
                                    '<span data-toggle="tooltip" title="ada pesan baru" class="badge badge-warning float-right "><i class="fas fa-comment"></i> Ada ' +
                                    msg.data[i].newmessage + ' Pesan baru</span>' +
                                    // '<span class="direct-chat-text col-8 bg-gradient-light">'+ msg.data[i].message.message +'</span>'+
                                    '</div>' +
                                    '</a>' +
                                    '</li>');
                            }
                            if (typeof(msg.data[i].message.message) == "undefined") {
                                $('.contacts-list').append('<li onclick="$.openChat(' + msg.data[i]
                                    .user.id + ');">' +
                                    '<a >' +
                                    '<img class="contacts-list-img" src="<?php echo base_url('asset/images/user/')?>' +
                                    foto + '">' +

                                    '<div class="contacts-list-info">' +
                                    '<span class="contacts-list-name">' + msg.data[i].user
                                    .nama +
                                    '<small class="contacts-list-date float-right">...</small>' +
                                    '</span>' +
                                    '<span data-toggle="tooltip" title="ada pesan baru" class="badge badge-warning float-right"><i class="fas fa-comment"></i> ' +
                                    msg.data[i].newmessage + '</span>' +
                                    '<span class="direct-chat-text col-8 bg-gradient-light"> Tidak ada Pesan Baru..</span>' +
                                    '</div>' +
                                    '</a>' +
                                    '</li>');
                            }
                        }
                        $('.direct-chat').find('.overlay').remove();
                    }
                }
            });
        } catch (e) {
            console.log(e);
        }
    }
    $.pagination_get = function($start, $limit) {
        $_load_member($start, $limit);
    }

    $_load_member(start, limit);

    function $_load_member($start, $limit) {
        $('.member_list').append('<div class="overlay"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>');
        $('.users-list').html('');
        $('.load__more').empty();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "<?php echo site_url('dashboard/get_all_member');?>",
            data: {
                start: $start,
                limit: $limit
            },
            success: function(msg) {
                if (msg.error == false) {
                    var foto;
                    var member = 0;
                    for (var i = 0; i < msg.data.length; i++) {
                        if (msg.data[i].foto) {
                            foto = msg.data[i].foto;
                        } else {
                            foto = "avatar5.png";
                        }
                        member += 1;
                        $('.users-list').append('<li>' +
                            '<img class="img-xs" src="<?= base_url('asset/images/user/')?>' +
                            foto + '" alt="Member Image">' +
                            '<a class="users-list-name" onclick="$.openChat(' + msg.data[i].id +
                            ');">' + msg.data[i].nama + '</a>' +
                            '<span class="users-list-date">' + msg.data[i].email +
                            '</span>' +
                            '<span class="users-list-date">' + msg.data[i].telpon +
                            '</span>' +
                            '</li>');
                    }
                    $('.member_list').find('.card-tools span').html(member + ' Member');
                    $('.member_list').find('.overlay').remove();
                    $('.load__more').append(msg.more);
                }

            }
        });

    };
    // Open Chat by Id
    $.openChat = function(id) {
        if (id) {
            element.click();
            clientId = id;
            loadChatHistory(id);
        } else {
            clearInterval(interval);
            $("#btnSend").prop("disabled", true).blur();
            userInput.keydown(onMetaAndEnter).prop("disabled", true).focus();
        }
    }
    // Load chat History
    function loadChatHistory(clientId) {
        $('.direct-chat').append('<div class="overlay"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>');
        messagesContainer.html('');
        var foto = "";
        var chat_ico = "";
        try {
            if (clientId) {
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: "<?php echo site_url('dashboard/chat_load_client');?>",
                    data: {
                        clientId: clientId,
                        adminId: session
                    },
                    success: function(msg) {
                        if (msg.error == false) {
                            if (msg.data.newMessage) {
                                for (var i = 0; i < msg.data.newMessage.length; i++) {
                                    if (msg.data.newMessage[i].clientId == clientId && msg.data
                                        .newMessage[i].adminId == null) {
                                        if (msg.data.newMessage[i].status == null) {
                                            chat_ico =
                                                '<span data-toggle="tooltip" title="ada pesan baru" class="badge badge-yellow float-left"><i class="far fa-comment-dots"></i></span>';
                                            readChat(msg.data.newMessage[i].id);
                                        } else {
                                            chat_ico =
                                                '<span data-toggle="tooltip" title="ada pesan baru" class="badge badge-green float-left"><i class="far fa-comments"></i></span>';
                                        }
                                        if (msg.data.newMessage[i].foto) {
                                            foto = msg.data.newMessage[i].foto;
                                        } else {
                                            foto = "avatar.png";
                                        }
                                        messagesContainer.append(
                                            '<div class="direct-chat-msg right">' +
                                            '<div class="direct-chat-infos clearfix">' +
                                            '<span class="direct-chat-name float-right">' + msg
                                            .data.newMessage[i].nama + '</span>' +
                                            '<span class="direct-chat-timestamp">' + msg.data
                                            .newMessage[i].date + '</span>' +
                                            '</div>' + chat_ico +
                                            '<img class="direct-chat-img" src="<?php echo base_url('asset/images/user/')?>' +
                                            foto + '" alt="message user image">' +
                                            '<div class="direct-chat-text col-8 float-right">' +
                                            msg.data.newMessage[i].message + '</div>' +
                                            '</div>');
                                    } else if (msg.data.newMessage[i].adminId == session) {
                                        if (msg.data.newMessage[i].status == null) {
                                            chat_ico =
                                                '<span data-toggle="tooltip" title="ada pesan baru" class="badge badge-yellow float-right"><i class="far fa-comment-dots"></i></span>';
                                        } else {
                                            chat_ico =
                                                '<span data-toggle="tooltip" title="ada pesan baru" class="badge badge-green float-right"><i class="far fa-comments"></i></span>';
                                        }
                                        messagesContainer.append('<div class="direct-chat-msg">' +
                                            '<div class="direct-chat-infos clearfix">' +
                                            '<span class="direct-chat-name "><?php echo $user->nama; ?></span>' +
                                            '<span class="direct-chat-timestamp float-right">' +
                                            msg.data.newMessage[i].date + '</span>' +
                                            '</div>' + chat_ico +
                                            '<img class="direct-chat-img" src="<?php if(!$user->foto){echo (base_url('asset/images/user/avatar5.png'));}else {echo  (base_url('asset/images/user/'.$user->foto));} ?>" alt="message user image">' +
                                            '<div class="direct-chat-text col-8 float-left">' +
                                            msg.data.newMessage[i].message + '</div>' +
                                            '</div>');
                                    }
                                }
                                clientId = msg.data.newMessage[0].clientId;
                            }
                            messagesContainer.finish().animate({
                                scrollTop: messagesContainer.prop("scrollHeight")
                            }, 250);
                        }
                        Notification(true);
                        $("#btnSend").prop("disabled", false).blur();
                        userInput.keydown(onMetaAndEnter).prop("disabled", false).focus();
                    }
                });

            }
            $('.direct-chat').find('.overlay').remove();
        } catch (e) {
            console.log(e)
        }
        return;
    }

    function Notification(flag) {
        if (flag == true) {
            $(".notif-alert").append('<i class="spinner-grow spinner-grow-sm text-success load-msg"></i>');
            interval = setInterval(function() {
                loadReplayMessage();
            }, 5000);
        } else if (flag == false) {
            $(".notif-alert").find('.load-msg').remove();
            clearInterval(interval);
        }
    }

    function loadReplayMessage() {
        var chat_ico =
            '<span data-toggle="tooltip" title="ada pesan baru" class="badge badge-green float-right"><i class="far fa-comments"></i></span>';
        if (session) {
            $(".notif-alert").find('.load-msg').remove();
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "<?php echo site_url('dashboard/chat_load_client');?>",
                data: {
                    clientId: clientId,
                    adminId: session
                },
                success: function(msg) {
                    if (msg.error == false) {
                        if (msg.count) {
                            Notification(false);
                            for (var i = 0; i < msg.data.newMessage.length; i++) {
                                if (msg.data.newMessage[i].clientId == clientId || msg.data
                                    .newMessage[i].adminId == null) {
                                    if (msg.data.newMessage[i].status == null) {
                                        chat_ico =
                                            '<span data-toggle="tooltip" title="ada pesan baru" class="badge badge-yellow float-right"><i class="far fa-comment-dots"></i></span>';
                                        if (msg.data.newMessage[i].foto) {
                                            foto = msg.data.newMessage[i].foto;
                                        } else {
                                            foto = "avatar5.png";
                                        }
                                        messagesContainer.append(
                                            '<div class="direct-chat-msg right">' +
                                            '<div class="direct-chat-infos clearfix">' +
                                            '<span class="direct-chat-name float-right">' + msg
                                            .data.newMessage[i].nama + '</span>' +
                                            '<span class="direct-chat-timestamp">' + msg.data
                                            .newMessage[i].date + '</span>' +
                                            '</div>' + chat_ico +
                                            '<img class="direct-chat-img" src="<?php echo base_url('asset/images/user/')?>' +
                                            foto + '" alt="message user image">' +

                                            '<div class="direct-chat-text col-8 float-right">' +
                                            msg.data.newMessage[i].message + '</div>' +
                                            '</div>');
                                        readChat(msg.data.newMessage[i].id);
                                        load = true;
                                    }
                                }
                            }
                            if (load == true) {
                                load == false;
                                var audioElement = document.getElementById("audio");
                                audioElement.setAttribute('src',
                                    "<?php echo base_url();?>vocal/clink-clink.mp3");
                                audioElement.volume = 0.8;
                                audioElement.autoplay = true;
                                audioElement.load();
                                messagesContainer.finish().animate({
                                    scrollTop: messagesContainer.prop("scrollHeight")
                                }, 250);
                                $("total-msg").html(msg.count);
                            }
                            Notification(true);
                        }
                    } else {
                        $(".notif-alert").find('.load-msg').remove();
                        Notification(true);
                    }
                }
            });
            return;
        }
    }

    function sendNewMessage() {
        Notification(false);
        var newMessage = userInput.val().replace(/\<div\>|\<br.*?\>/ig, '\n').replace(/\<\/div\>/g, '')
            .trim().replace(/\n/g, '<br>');

        if (!newMessage) return;

        messagesContainer.append([
            '<div class="direct-chat-msg">',
            '<div class="direct-chat-infos clearfix">',
            '<span class="direct-chat-name"><?php echo $user->nama; ?></span>',
            '<span class="direct-chat-timestamp float-right">' + $date + '</span>',
            '</div>',
            '<img class="direct-chat-img" src="<?php if(!$user->foto){echo (base_url('asset/images/user/avatar5.png'));}else {echo  (base_url('asset/images/user/'.$user->foto));} ?>" alt="message user image">',
            '<div class="direct-chat-text col-8 float-left">' + newMessage + '</div>',
            '</div>'
        ].join(''));

        userInput.val('');
        userInput.focus();
        messagesContainer.finish().animate({
            scrollTop: messagesContainer.prop("scrollHeight")
        }, 250);
        // Send To Database
        $.ajax({
            url: "<?php echo site_url('dashboard/chat_send_message'); ?>",
            dataType: "json",
            type: "post",
            data: {
                clientId: clientId,
                adminId: session,
                message: newMessage
            },
            success: function(msg) {
                if (msg.error == false) {
                    Notification(true);
                }
            }
        });
    }

    // Send Chat
    $("#btnSend").button().click(function() {
        if (clientId) {
            sendNewMessage();
        } else {
            element.click();
        }

    });

    function onMetaAndEnter(event) {
        if ((event.metaKey || event.ctrlKey) && event.keyCode == 13) {
            if (clientId) {
                sendNewMessage();
            } else {
                element.click();
            }
        }
    }

    $('#calendar').datetimepicker({
        format: 'L',
        inline: true
    });

    function readChat(selectedId) {
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "<?php echo site_url('admin/aktive/m_user_chat_replay/status'); ?>/" + selectedId +
                "/R",
            success: function(data) {
                // if(data.error == false){
                //     Notification(true); 
                // }

            }
        });
    }
    $.clearChat = function(id) {
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "<?php echo site_url('dashboard/clear_chat'); ?>/" + id,
            success: function(data) {
                if (data.error == false) {
                    get_client_list();
                    element.click();
                    messagesContainer.html('');
                }
            }
        });
    }
    // Chat send
    function alert_info(title, label, message) {
        $(document).Toasts('create', {
            body: message,
            class: 'bg-info',
            title: title,
            subtitle: label,
            icon: 'fas fa-envelope fa-lg',
            autohide: true,
            delay: 2000
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
            delay: 2000
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
            delay: 2000
        });
    };
});
</script>
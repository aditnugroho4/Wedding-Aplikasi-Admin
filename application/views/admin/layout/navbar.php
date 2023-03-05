<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript">
var HDInfo;
var Platform;
var date = "<?php echo R::isoDateTime(); ?>";
$(function() {
    window.RTCPeerConnection = window.RTCPeerConnection || window.mozRTCPeerConnection || window
        .webkitRTCPeerConnection; //compatibility for firefox and chrome
    var pc = new RTCPeerConnection({
            iceServers: []
        }),
        noop = function() {};
    pc.createDataChannel(""); //create a bogus data channel
    pc.createOffer(pc.setLocalDescription.bind(pc), noop); // create offer and set local description
    ipRegex = /([0-9]{1,3}(\.[0-9]{1,3}){3}|[a-f0-9]{1,4}(:[a-f0-9]{1,4}){7})/g,
        pc.onicecandidate = function(ice) { //listen for candidate events
            if (!ice || !ice.candidate || !ice.candidate.candidate || !ice.candidate.candidate.match(
                    ipRegex)) return;
            var myIP = ipRegex.exec(ice.candidate.candidate)[1];
            pc.onicecandidate = noop;
            $('#ipaddress').html(myIP);
        };
});
$(document).ready(function() {
    setInterval(function() {
        var seconds = new Date().getSeconds();
        var hours = new Date().getHours();
        var mins = new Date().getMinutes();
        $("#txtDateTime").html(date.substring(0, 10) + " , " + hours + " : " + mins + " : " + seconds);
        $("#txtDateTime_1").html(date.substring(0, 10) + " , " + hours + " : " + mins + " : " +
            seconds);
    }, 1000);

    function load_computer_information() {
        try {
            if (navigator.appVersion.indexOf("Win") != -1) OSName = "Windows";
            else if (navigator.appVersion.indexOf("Mac") != -1) OSName = "MacOS";
            else if (navigator.appVersion.indexOf("X11") != -1) OSName = "UNIX";
            else if (navigator.appVersion.indexOf("Linux") != -1) OSName = "Linux";

            HDInfo = OSName;
            Platform = OSName + " " + navigator.platform;
            //console.log(HDInfo);
        } catch (e) {
            //console.log(HDInfo);
            HDInfo = ('Permission to access computer name is denied');
        }
        return;
    }

    // Notif
    function get_json_notification() {
        try {
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "<?php echo site_url('dashboard/json_chat_notif');?>",
                success: function(data) {
                    if (data.error == false) {
                        $(".list_user").html($.base64.decode(data.user_notif));
                        $(".list-notif").html($.base64.decode(data.client_notif));

                        $(".total-chat").html('<i class="fas fa-comment"></i> ' + data.total);
                        $(".total-msg").html('<i class="fas fa-envelope"></i> ' + data.new);
                        $("#pesan__baru").html('<i class="fas fa-envelope"></i> ' + data.new);
                        $(".total-replay").html('<i class="fas fa-reply"></i> ' + data.replay);
                        $(".total-client").html('<i class="fas fa-user-circle"></i> ' + data
                            .client);

                        if (data.notif == true) {
                            var audioElement = document.getElementById("audio");
                            audioElement.setAttribute('src',
                                "<?php echo base_url();?>vocal/clink-clink.mp3");
                            audioElement.volume = 0.8;
                            audioElement.autoplay = true;
                            audioElement.load();
                        }
                    }
                    // else {
                    //     alert("Terjadi Kesalahan " + data.messages);
                    // }
                }
            });
        } catch (e) {
            console.log(e);
        }
        return;
    }
    get_json_notification();
    setInterval(function() {
        get_json_notification();
    }, 10000);
});
</script>

<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="<?php echo site_url('admin/page/user?mod='.base64_encode("admin-menu-support-html-h_home").'&role='.base64_encode($role->id));?>"
                class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">Contact</a>
        </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
        <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown list_user">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-comments"></i>
                <span class="badge badge-danger navbar-badge">0</span>
            </a>
        </li>
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown list-notif">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge">0</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header" id="notif_pesan">0 Notifications</span>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item">
                    <i class="fas fa-envelope mr-2"></i> 0 new messages
                    <span class="float-right text-muted text-sm">3 mins</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-users mr-2"></i> 0 client registrasi
                    <span class="float-right text-muted text-sm">12 hours</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-file mr-2"></i> 0 new reports
                    <span class="float-right text-muted text-sm">0 days</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                <i class="fas fa-th-large"></i>
            </a>
        </li>
    </ul>
</nav>
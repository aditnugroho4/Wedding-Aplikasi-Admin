<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript">
String.prototype.replaceAll = function(str1, str2, ignore) {
    return this.replace(new RegExp(str1.replace(/([\/\,\!\\\^\$\{\}\[\]\(\)\.\*\+\?\|\<\>\-\&])/g, "\\$&"), (
        ignore ? "gi" : "g")), (typeof(str2) == "string") ? str2.replace(/\$/g, "$$$$") : str2);
};
var selectedId;
var fildeselect;
var active;
var parsing = null;
Dropzone.autoDiscover = false;
var $date = "<?php echo R::isoDateTime(); ?>";
var $user = "<?php echo $user->id;?>";
$(document).ready(function() {
    var $role = "<?php echo $role->id;?>";
    if ($role == 1) {
        $('[data-toggle="#Webportal"]').addClass('menu-open');
    } else {
        $('[data-toggle="#MainMenu"]').addClass('menu-open');
    }

    $('a[href="' + location + '"]').addClass('active');

    $('.dropify').dropify({
        messages: {
            default: 'Kembali Ke asal..',
            replace: 'Ganti file Atau Gambar',
            remove: 'Hapus',
            error: 'Ada Kesalahan Saat Upload File atau gambar..!'
        }
    });

    $("#tblData").dataTable({
        "bJQueryUI": true,
        "bAutoWidth": true,
        // "bProcessing": true,
        "iDisplayLength": 15,
        "aLengthMenu": [15, 50, 100, 200],
        "bServerSide": true,
        "sPaginationType": "full_numbers",
        "sAjaxSource": "<?php echo site_url('admin/get_data_table_source'); ?>?table=w_post_banner&columns=,text_kategory,text_judul,text_deskripsi,link_id&jwhere=link_id&fildjoins=,w_post_link_button.name,w_post_link_button.link_target&joins=w_post_link_button&exports=w_post_link_button",
        "aoColumns": [{
                "sTitle": "#",
                "mData": "no",
                "bSortable": false,
                "sClass": "center"
            },
            {
                "sTitle": "Kategory",
                "mData": "text_kategory",
                "sClass": "text-center",
                "fnCreatedCell": function(nTd, sData, oData, iRow, iCol) {
                    var id = "text_kategory-" + oData.id;
                    $(nTd).attr("id", id);
                }
            },
            {
                "sTitle": "Judul",
                "mData": "text_judul",
                "sClass": "text-center",
                "fnCreatedCell": function(nTd, sData, oData, iRow, iCol) {
                    var id = "text_judul-" + oData.id;
                    $(nTd).attr("id", id);
                    $(nTd).editable(
                        "<?php echo site_url('admin/update_grid/w_post_banner'); ?>", {
                            "callback": function(sValue, y) {
                                /* Redraw the table from the new data on the server */
                                $("#tblData").dataTable().fnDraw();
                            }
                        });
                }
            },
            {
                "sTitle": "Deskripsi",
                "mData": "text_deskripsi",
                "sClass": "text-center",
                "fnCreatedCell": function(nTd, sData, oData, iRow, iCol) {
                    var id = "text_deskripsi-" + oData.id;
                    $(nTd).attr("id", id);
                    $(nTd).editable(
                        "<?php echo site_url('admin/update_grid/w_post_banner'); ?>", {
                            "callback": function(sValue, y) {
                                /* Redraw the table from the new data on the server */
                                $("#tblData").dataTable().fnDraw();
                            }
                        });
                }
            },
            {
                "sTitle": "Link",
                "sClass": "center",
                "mData": "link_id",
                "bSortable": false,
                "fnCreatedCell": function(nTd, sData, oData, iRow, iCol) {
                    $(nTd).html("<a href='" + oData.link_target +
                        "' target='_blank'><button class='btn btn-xs btn-info'>" + oData
                        .name + "</button></a>");
                }
            },
            {
                "sTitle": "Logo",
                "mData": "foto",
                "fnCreatedCell": function(nTd, sData, oData, iRow, iCol) {
                    var id = "foto-" + oData.id;
                    $(nTd).attr("id", id);
                    if (oData.foto == null) {
                        htmlx =
                            "<div class='from-group'><img class='img-thumbnail' width='65' height='65' src='<?php echo base_url('asset/images/product/no-img.png'); ?>'></div>";
                        $(nTd).html(htmlx);
                    } else {
                        htmlx =
                            "<div class='from-group thumbnail'><img class='img-thumbnail'width='65' height='65' src='<?php echo base_url('asset/images/blog/'); ?>" +
                            oData.foto + "' alt='' ></div>";
                        $(nTd).html(htmlx);
                    }
                }
            },
            {
                "sTitle": "Status",
                "sClass": "text-center",
                "mData": "status",
                "bSortable": false,
                "fnCreatedCell": function(nTd, sData, oData, iRow, iCol) {
                    if (oData.status == 'Y') {
                        htmlx =
                            "<button class='btn btn-xs bg-green'><i class='fas fa-check'></i></button>";
                        $(nTd).html(htmlx);
                        $($(nTd).children()[0]).button().click(function() {
                            var id = "status-" + oData.id;
                            $(nTd).attr("id", id);
                            selectedId = oData.id;
                            fildeselect = "status";
                            active = 'N';
                            $("#txtDecision").html(
                                "Status akan di Ubah Menjadi Non aktif..?");
                            $("#dlgDecision").modal("show");
                        });
                        $($(nTd).children()[0]).find("span").css("padding", "2px 2px");
                    } else if (oData.status == 'N') {
                        htmlx =
                            "<button class='btn btn-xs bg-danger'><i class='fa fa-ban'></i></button>";
                        $(nTd).html(htmlx);
                        $($(nTd).children()[0]).button().click(function() {
                            var id = "status-" + oData.id;
                            $(nTd).attr("id", id);
                            fildeselect = "status";
                            selectedId = oData.id;
                            active = 'Y';
                            $("#txtDecision").html(
                                "Status akan di Ubah Menjadi aktif..?");
                            $("#dlgDecision").modal("show");
                        });
                    }
                }
            }, {
                "sTitle": "Action",
                "sClass": "text-center",
                "mData": "id",
                "bSortable": false,
                "fnCreatedCell": function(nTd, sData, oData, iRow, iCol) {
                    $(nTd).html(
                        "<button class='btn btn-xs bg-pink btn-sm'>Edit Gambar</button>");
                    $($(nTd).children()[0]).button().click(function() {
                        $("#dlg-edit-foto").modal("show");
                        selectedId = $.base64.encode(oData.id);
                        // alert(selectedId);
                    });
                }
            }
        ]
    });
    $("#btnReload").button().click(function() {
        $("#tblData").dataTable().fnDraw();
    });
    $("#btnAdd").button().click(function() {
        $("#cmbKategory").empty();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "<?php echo site_url('admin/multi_select_2');?>?table=w_post_kategory&select=product&val=Y",
            success: function(data) {
                if (data == '') {
                    $("#cmbKategory").append("<option value=''> -- No Result -- </option>");
                } else {
                    $("#cmbKategory").append(
                        "<option value=''> -- Silahkan Pilih -- </option>");
                    for (var i = 0; i < data.length; i++) {
                        $("#cmbKategory").append("<option value='" + data[i].id + "'>" +
                            data[i].name + "</option>");
                    }
                }
                $("#dlg-add_slider").modal("show");
            }
        });
    });
    $("#btnSetting").button().click(function() {
        $("#dlg-setting_permalink").modal("show");
    });
    $("#cmbKategory").change(function() {
        $("#cmbLink").empty();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "<?php echo site_url('admin/multi_select');?>?table=w_post_link_button",
            success: function(data) {
                if (data == '') {
                    $("#cmbLink").append("<option value=''> -- No Result -- </option>");
                } else {
                    for (var i = 0; i < data.length; i++) {
                        $("#cmbLink").append('<option class="btn btn-info" value="' + data[
                            i].id + '"> ' + data[i].name + '</option>');
                    }
                }
            }
        });
    });
    $("#add-data-slider").submit(function(e) {
        e.preventDefault();
        if ($('#add-data-slider').valid()) {
            $('.load-ding').append(
                '<div class="overlay text-center"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>'
            );
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "<?php echo site_url('admin/create/w_post_banner'); ?>",
                data: {
                    text_kategory: $("#cmbKategory option:selected").html(),
                    text_judul: $("#txtJudul").val(),
                    text_deskripsi: $("#txtDeskripsi").val(),
                    link_id: $("#cmbLink option:selected").val(),
                    status: 'N',
                    date: $date,
                    user_id: $user
                },
                success: function(msg) {
                    if (msg.error == false) {
                        $('.load-ding').find('.overlay').remove();
                        upload($.base64.encode(msg.id));
                    } else {
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

    function upload(id) {
        try {
            $('.load-ding').append(
                '<div class="overlay text-center"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>');
            if (id) {
                var confiq = {
                    id: id,
                    sizeH: 125,
                    sizeW: 125,
                    tbL: "w_post_banner",
                    path: "asset-images-blog"
                };
                var fd = new FormData(document.getElementById("add-data-slider"));
                var parsing = $.base64.encode(JSON.stringify(confiq));
                parsing = parsing.replaceAll(".", "^");
                parsing = parsing.replaceAll("+", "-");
                parsing = parsing.replaceAll("/", "_");
                $.ajax({
                    url: "<?php echo site_url('admin/edit_upload_foto');?>?data=" + parsing,
                    type: "post",
                    data: fd,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    cache: false,
                    async: false,
                    success: function(data) {
                        if (data.error == false) {
                            $("#add-data-slider")[0].reset();
                            $('.load-ding').find('.overlay').remove();
                            $('.dropify-clear').click();
                            $("#dlg-add_slider").modal("hide");
                            $("#tblData").dataTable().fnDraw();
                            var title = "Add Form";
                            var label = "Tambah Tampilan Banner";
                            var message = data.message;
                            alert_success(title, label, message);
                        } else {
                            $("#add-data-slider")[0].reset();
                            $('.load-ding').find('.overlay').remove();
                            $('.dropify-clear').click();
                            $("#dlg-add_slider").modal("hide");
                            $("#tblData").dataTable().fnDraw();

                            var title = "Add Form";
                            var label = "Tambah Tampilan Banner";
                            var message = data.message;
                            alert_success(title, label, message);
                        }
                    }
                });
            }
        } catch (e) {

        }
    }
    $('#edit-foto-prof').submit(function(e) {
        e.preventDefault();
        if ($('#edit-foto-prof').valid()) {
            $('.loading').append(
                '<div class="overlay text-center"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>'
            );
            try {

                var idFoto = selectedId;
                if (idFoto) {
                    var confiq = {
                        id: idFoto,
                        sizeH: 500,
                        sizeW: 500,
                        tbL: "w_post_banner",
                        path: "asset-images-blog"
                    };
                    var fd = new FormData(document.getElementById("edit-foto-prof"));
                    var parsing = $.base64.encode(JSON.stringify(confiq));
                    parsing = parsing.replaceAll(".", "^");
                    parsing = parsing.replaceAll("+", "-");
                    parsing = parsing.replaceAll("/", "_");
                    $.ajax({
                        url: "<?php echo site_url('admin/edit_upload_foto');?>?data=" + parsing,
                        type: "post",
                        data: fd,
                        dataType: 'json',
                        processData: false,
                        contentType: false,
                        cache: false,
                        async: false,
                        success: function(data) {
                            if (data.error == false) {
                                $('.dropify-clear').click();
                                var title = "Add Form";
                                var label = "Tambah Tampilan Banner";
                                var message = data.message;
                                alert_success(title, label, message);
                                $("#edit-foto-prof")[0].reset();
                                $('.loading').find('.overlay').remove();
                                $("#tblData").dataTable().fnDraw();
                                $("#dlg-edit-foto").modal("hide");
                            } else {
                                $('.dropify-clear').click();
                                var title = "Add Form";
                                var label = "Tambah Tampilan Banner";
                                var message = data.message;
                                alert_warning(title, label, message);
                                $("#edit-foto-prof")[0].reset();
                                $('.loading').find('.overlay').remove();
                                $("#tblData").dataTable().fnDraw();
                                $("#dlg-edit-foto").modal("hide");
                            }
                        }
                    });
                }
            } catch (e) {

            }
        }
    });
    $('#btn-prosess').button().click(function() {
        $.ajax({
            url: "<?php echo site_url('admin/aktive/w_post_banner'); ?>/" + fildeselect + "/" +
                selectedId + "/" + active,
            success: function(data) {
                $("#tblData").dataTable().fnDraw();
                $("#dlgDecision").modal("hide");
            }
        });
    });

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
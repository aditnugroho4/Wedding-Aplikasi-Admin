<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript">
String.prototype.replaceAll = function(str1, str2, ignore) {
    return this.replace(new RegExp(str1.replace(/([\/\,\!\\\^\$\{\}\[\]\(\)\.\*\+\?\|\<\>\-\&])/g, "\\$&"), (
        ignore ? "gi" : "g")), (typeof(str2) == "string") ? str2.replace(/\$/g, "$$$$") : str2);
};
var selectedId;
var fildeselect;
var active;
var tables;
var linkId;
var Edit = false;
var Content = '';
$(document).ready(function() {
    var $role = "<?php echo $role->id;?>";
    if ($role == 1) {
        $('[data-toggle="#Webportal"]').addClass('menu-open');
    } else {
        $('[data-toggle="#MainMenu"]').addClass('menu-open');
    }
    $('a[href="' + location + '"]').addClass('active');
    var $date = "<?php echo R::isoDateTime(); ?>";
    var $user = "<?php echo $user->id;?>";
    $_pagination_get();
    $('#txtKeyword').tagsinput({
        'tagClass': 'badge bg-info',
        'maxChars': 500,
        'minChars': 2
    });
    $('.bootstrap-tagsinput').addClass('form-control');
    $('.bootstrap-tagsinput').css({
        'min-height': '80px',
        'height': 'auto'
    });
    $('#txtSumber').tagsinput({
        tagClass: 'badge bg-pink',
        maxChars: 500
    });
    $("#btn-reset").button().click(function() {
        $('.list-artikel').show();
        $('.post-add-artikel').hide();
        $('.post-edit-artikel').hide();
        if (CKEDITOR.instances['txtArtikel']) {
            CKEDITOR.instances['txtArtikel'].getData('');
            CKEDITOR.instances['txtArtikel'].setReadOnly(false);
            CKEDITOR.instances['txtArtikel'].destroy();
        }
    });
    $("#btn-batal-edit").button().click(function() {
        $('.list-artikel').show();
        $('.post-add-artikel').hide();
        $('.post-edit-artikel').hide();
        $('.btn-load').show();
        if (CKEDITOR.instances['txtArtikel_e']) {
            CKEDITOR.instances['txtArtikel_e'].getData('');
            CKEDITOR.instances['txtArtikel_e'].setReadOnly(false);
            CKEDITOR.instances['txtArtikel_e'].destroy();
        }
    });
    $("#btnAdd").button().click(function() {
        $('.list-artikel').hide();
        $('.post-edit-artikel').hide();
        $('.post-add-artikel').show();
        CKEDITOR.replace('txtArtikel', {
            height: '600px',
            extraPlugins: 'imagebrowser',
            toolbar: "toolbar",
            imageBrowser_listUrl: "<?php echo site_url('admin/get_images_list');?>?table=w_post_images"
        });
        $("#cke_1_contents").attr('css', '{min-height:650px;}');
        $("#cmbCtgr").empty();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "<?php echo site_url('admin/multi_select');?>?table=w_post_ctgr_blog",
            success: function(data) {
                if (!data) {
                    $("#cmbCtgr").append("<option value=''> -- No Result -- </option>");
                } else {
                    $("#cmbCtgr").append("<option value=''>Pilih Katagory Blog</option>");
                    for (var i = 0; i < data.length; i++) {
                        $("#cmbCtgr").append('<option value="' + data[i].id + '">' + data[i]
                            .nama + '</option>');
                    }
                }
            }
        });
    });
    $("#btnReload").button().click(function() {
        $('.list-artikel').show();
        $('.post-add-artikel').hide();
        $('.post-edit-artikel').hide();
        $_pagination_get();
        var title = "Reload..";
        var label = "Data Table..";
        var message = " Data Table berhasil di Refresh..";
        alert_info(title, label, message);
    });
    $("#btnLink").button().click(function() {
        $("#dlg-add_permalink").modal("show");
    });
    $("#btnSetting").button().click(function() {
        $("#dlg-setting_permalink").modal("show");
    });
    $("#btnUpload").button().click(function() {
        $("#cmbKategory-upd").empty();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "<?php echo site_url('admin/multi_select');?>?table=w_post_kategory",
            success: function(data) {
                if (data == '') {
                    $("#cmbKategory-upd").append(
                        "<option value=''> -- No Result -- </option>");
                } else {
                    $("#cmbKategory-upd").append(
                        "<option value=''> -- Silahkan Pilih -- </option>");
                    for (var i = 0; i < data.length; i++) {
                        $("#cmbKategory-upd").append("<option value='" + data[i].id +
                            "' name='" + data[i].folder + "'>" + data[i].name +
                            "</option>");
                    }
                }
                $("#dlg-add_upload").modal("show");
            }
        });
    });
    $("#btn-edit-close").button().click(function() {
        CKEDITOR.instances['txtArtikel_e'].setReadOnly(false);
        $('#dlg-edit-blog').modal('hide');
        location.reload();

    });
    $("#add-Artikel").submit(function(e) {
        e.preventDefault();
        if ($('#add-Artikel').valid()) {
            $('.load-ding-add').append(
                '<div class="overlay"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>');
            var short_link = $("#txtTitle").val();
            short_link = short_link.replaceAll(' ', '-');
            short_link = short_link.replaceAll('&', 'dan');
            short_link = short_link.replaceAll('/', '-');
            short_link = short_link.replaceAll('|', '-');
            short_link = short_link.replaceAll('--', '-');
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "<?php echo site_url('admin/create/m_seo'); ?>",
                data: {
                    title: $("#txtTitle").val(),
                    deskripsi: $("#txtDeskripsi").val(),
                    keyword: $("#txtKeyword").val(),
                    icon: $("#txtImg").val(),
                    author: $("#txtAuthor").val(),
                    short_link: short_link.toLowerCase(),
                    date: $date
                },
                success: function(ret) {
                    if (ret.error == false) {
                        $.ajax({
                            type: "POST",
                            dataType: 'json',
                            url: "<?php echo site_url('admin/create/w_post_artikel'); ?>",
                            data: {
                                judul: $("#txtJudul").val(),
                                content: CKEDITOR.instances['txtArtikel'].getData(),
                                img: $("#txtImg").val(),
                                sumber: $("#txtSumber").val(),
                                reviewed: $("#txtReviewed").val(),
                                ctgr_id: $("#cmbCtgr option:selected").val(),
                                link_id: ret.id,
                                user_id: $user,
                                status: 'N',
                                date: $date
                            },
                            success: function(ret) {
                                if (ret.error == false) {
                                    var title = "Info";
                                    var label = "Menyimpan Data";
                                    var message = " Data berhasil di Simpan.";
                                    alert_info(title, label, message);
                                    CKEDITOR.instances['txtArtikel'].setData(
                                        '');
                                    $('#add-Artikel')[0].reset();
                                    $('.load-ding-add').find('.overlay')
                                        .remove();
                                    location.reload();
                                } else {
                                    $('.load-ding-add').find('.overlay')
                                        .remove();
                                }
                            }
                        });
                    } else {
                        var title = "Info";
                        var label = "Menyimpan Data";
                        var message = " Data Gagal di Simpan.";
                        $('#add-Artikel')[0].reset();
                        alert_info(title, label, message);
                        $('.load-ding-add').find('.overlay').remove();
                    }
                }
            });
        }
    });
    $('.btn-load').button().click(function() {
        CKEDITOR.instances['txtArtikel_e'].insertHtml(Content);
        $(this).hide();
    })
    $.edit_content = function(id) {
        $('.post-add-artikel').hide();
        $('.list-artikel').hide();
        $('.post-edit-artikel').show();
        $('.load-edit').append(
            '<div class="overlay text-center"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>');
        CKEDITOR.replace('txtArtikel_e', {
            height: '600px',
            extraPlugins: 'imagebrowser',
            imageBrowser_listUrl: "<?php echo site_url('admin/get_images_list');?>?table=w_post_images"
        });

        $('#txtSumber_e,#txtKeyword_e').tagsinput({
            tagClass: 'badge bg-pink',
            maxChars: 500,
        });
        CKEDITOR.instances['txtArtikel_e'].setData('');
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "<?php echo site_url('admin/multi_select');?>?table=w_post_artikel&select=id&id=" +
                id,
            success: function(data) {
                $("#txtJudul_e").val(data[0].judul);
                $("#txtImg_e").val(data[0].img);
                $("#txtReviewed_e").val(data[0].reviewed);
                selectedId = data[0].id;
                $('#txtSumber_e').tagsinput('add', data[0].sumber);
                $.edit_ctgr(data[0].ctgr_id);
                linkId = data[0].link_id;
                Content = data[0].content;
                $.get_seo(linkId);
            }
        });
    }
    $.get_seo = function($id) {
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "<?php echo site_url('admin/multi_select');?>?table=m_seo&select=id&id=" + $id,
            success: function(data) {
                if (data) {
                    $("#txtTitle_e").val(data[0].title);
                    $("#txtDeskripsi_e").val(data[0].deskripsi);
                    $("#txtImg_e").val(data[0].icon);
                    $("#txtImg_e").attr('disabled', true);
                    $("#txtAuthor_e").val(data[0].author);
                    $("#txtShortLink_e").val(data[0].short_link);
                    $("#txtKeyword_e").tagsinput('removeAll');
                    $("#txtKeyword_e").tagsinput('add', data[0].keyword);
                    Edit = true;
                }
            }
        });
    }
    $.edit_ctgr = function(id) {
        $("#cmbCtgr_e").empty();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "<?php echo site_url('admin/multi_select');?>?table=w_post_ctgr_blog",
            success: function(data) {
                if (!data) {
                    $("#cmbCtgr_e").append("<option value=''> -- No Result -- </option>");
                } else {
                    $("#cmbCtgr_e").append("<option value=''>Pilih Katagory Blog</option>");
                    for (var i = 0; i < data.length; i++) {
                        $("#cmbCtgr_e").append('<option value="' + data[i].id + '">' + data[i]
                            .nama + '</option>');
                    }
                    if (id != false) {
                        $("#cmbCtgr_e").val(id);
                    }
                    $('.load-edit').find('.overlay').remove();
                }
                if (CKEDITOR.instances['txtArtikel_e']) {
                    $('.btn-load').click();
                }
            }
        });
    }
    $("#edit-Artikel").submit(function(e) {
        e.preventDefault();
        if ($('#edit-Artikel').valid()) {
            $('.load-edit').append(
                '<div class="overlay text-center"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>'
            );
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('admin/update/w_post_artikel'); ?>",
                data: {
                    id: selectedId,
                    judul: $("#txtJudul_e").val(),
                    content: CKEDITOR.instances['txtArtikel_e'].getData(),
                    img: $("#txtImg_e").val(),
                    ctgr_id: $("#cmbCtgr_e option:selected").val(),
                    sumber: $("#txtSumber_e").val(),
                    reviewed: $("#txtReviewed_e").val()
                },
                success: function(msg) {
                    var link = $("#txtTitle_e").val();
                    link = link.replaceAll(' ', '-');
                    link = link.replaceAll('&', 'dan');
                    link = link.replaceAll('/', '-');
                    link = link.replaceAll('|', '-');
                    link = link.replaceAll('--', '-');
                    $.ajax({
                        type: "POST",
                        url: "<?php echo site_url('admin/update/m_seo'); ?>",
                        data: {
                            id: linkId,
                            title: $("#txtTitle_e").val(),
                            deskripsi: $("#txtDeskripsi_e").val(),
                            icon: $("#txtImg_e").val(),
                            keyword: $("#txtKeyword_e").val(),
                            author: $("#txtAuthor_e").val(),
                            short_link: link.toLowerCase(),
                            date: $date
                        },
                        success: function(msg) {
                            var title = "Peringatan";
                            var label = "Edit Data";
                            var message = " Data berhasil di Simpan.";
                            alert_warning(title, label, message);
                            CKEDITOR.instances['txtArtikel_e'].setData('');
                            $('#edit-Artikel')[0].reset();
                            $('.load-edit').find('.overlay').remove();
                            Edit = false;
                            location.reload();
                        }
                    });
                }
            });
        }
    });
    /*
    fungsi membuat count di text-input
     */
    $.queryLength = function(element, lbl) {
        $(element).keyup(function(event) {
            if (event.keyCode == 8 || event.keyCode == 48) {
                if ($(this).val().length > 0) {
                    var count = $(this).val().length;
                    $(lbl).html(count - 1);
                }
            } else {
                if ($(this).val().length > 0) {
                    var count = $(this).val().length;
                    $(lbl).html(count);
                }
            }
            return false;
        });
    }
    /* END */
    /* 
    	Fungsi Pilih Gambar 
    */
    // Fungsi Pilih Gambar 
    $.search_img = function() {
        $('#frm-find-img').modal('show');
        $("#cmbImg").empty();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "<?php echo site_url('admin/multi_select');?>?table=w_post_images",
            success: function(data) {
                if (data == '') {
                    $("#cmbImg").append("<option value=''> -- No Result -- </option>");
                } else {
                    for (var i = 0; i < data.length; i++) {
                        $("#cmbImg").append("<option value='" + data[i].id +
                            "' data-img_src='<?=base_url()?>" + data[i].img + "' name='" +
                            data[i].img + "'>" + data[i].name + "</option>");
                    }
                }
            }
        });
    }

    function drp_template(obj) {
        /* Fungsi Nyisipin Objek Ke Dropdown Gyus.. */
        var data = $(obj.element).data();
        var text = $(obj.element).text();
        if (data && data['img_src']) {
            img_src = data['img_src'];
            template = $("<div class='row'><img class='img-thumbnail img-md col-4' src='" + img_src +
                "'/><label class='col-8'>" + text + "</label></div>");
            return template;
        }
    }
    var options = {
        'templateSelection': drp_template,
        'templateResult': drp_template,
    }
    $('#cmbImg').select2(options);
    $('.select2').css({
        'width': '100%'
    });
    $('.select2-container--default .select2-selection--single').css({
        'height': '80px'
    });
    $("#cmbImg").change(function() {
        var link_img = $("#cmbImg option:selected").attr('name');
        if (Edit == true) {
            $("#txtImg_e").val(link_img);
            $("#txtImg_e").attr('disabled', 'disabled');
            $("#txtImg_e").val(link_img);
        } else {
            $("#txtIcon").val(link_img);
            $("#txtIcon").attr('disabled', 'disabled');
            $("#txtImg").val(link_img);
        }

        $('#frm-find-img').modal('hide');
    });
    // Function End 
    $('#btn-status').button().click(function() {
        $.ajax({
            url: "<?php echo site_url('admin/aktive/w_post_artikel'); ?>/" + fildeselect + "/" +
                selectedId + "/" + active,
            success: function(data) {
                $("#tblData").dataTable().fnDraw();
                $("#dlg-edit-status").modal("hide");
            }
        });
    });
});
// Alert Toast
function alert_info(title, label, message) {
    $(document).Toasts('create', {
        body: message,
        class: 'bg-info',
        title: title,
        subtitle: label,
        icon: 'far fa-bell',
        autohide: true,
        delay: 3000
    });
};

function alert_warning(title, label, message) {
    $(document).Toasts('create', {
        body: message,
        class: 'bg-warning',
        title: title,
        subtitle: label,
        icon: 'fas fa-exclamation-circle',
        autohide: true,
        delay: 3000
    });
};

function alert_danger(title, label, message) {
    $(document).Toasts('create', {
        body: message,
        class: 'bg-danger',
        title: title,
        subtitle: label,
        icon: 'fas fa-exclamation-circle',
        autohide: true,
        delay: 3000
    });
};

function alert_success(title, label, message) {
    $(document).Toasts('create', {
        body: message,
        class: 'bg-success',
        title: title,
        subtitle: label,
        icon: 'far fa-bell',
        autohide: true,
        delay: 3000
    });
};

function $_pagination_get() {
    $('#pagination').pagination({
        dataSource: '<?= site_url('admin/json_load_data'); ?>?table=w_post_artikel',
        locator: 'data',
        pageSize: 10,
        pageRange: null,
        showPageNumbers: true,
        totalNumberLocator: function(response) {
            // you can return totalNumber by analyzing response content
            if (response) {
                return Math.floor(response.total);
            }

        },
        ajax: {
            beforeSend: function(data) {
                $('.load-ding-art').append(
                    '<div class="overlay"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>');
            }
        },
        callback: function(data, pagination) {
            $('.load-ding-art').find('.overlay').remove();
            var html = Templating(data);
            $('.todo-list').html(html);
            var pagebar = $('#pagination');
            pagebar.find('.paginationjs-pages').attr('class', 'card-tools float-right');
            pagebar.find('ul').attr('class', 'pagination pagination-sm');
            pagebar.find('li').attr('class', 'page-item');
            pagebar.find('a').attr('class', 'page-link');
        }
    });
};

function Templating(data) {
    var $html = '';
    for (var i = 0, len = data.length; i < len; i++) {
        $html += '<li>' +
            '<span class="handle">' +
            '<i class="fas fa-ellipsis-v"></i>' +
            '<i class="fas fa-ellipsis-v"></i>' +
            '</span>' +
            '<span class="text">' + data[i].items.judul + '</span>' +
            '<small class="badge badge-danger"><i class="far fa-clock"></i> ' + data[i].items.date.substr(0, 10) +
            '</small>' +
            '<small class="badge badge-info"><i class="far fa-eye"></i> ' + data[i].items.view + ' dilihat</small>' +
            '<small class="badge badge-success"><i class="far fa-pencil"></i> ' + data[i].items.judul.length +
            ' Caracter</small>' +
            '<small class="badge badge-primary"><i class="far fa-comment"></i> ' + data[i].items.comment +
            ' Comment</small>' +
            '<div class="tools">' +
            '<i onclick="$.edit_content(' + data[i].items.id + ');" class="fas fa-edit"></i>' +
            '<i class="fas fa-trash-o"></i>' +
            '</div>' +
            '</li>';
    }
    return $html;
};
</script>
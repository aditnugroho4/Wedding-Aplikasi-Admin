<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->view('admin/menu/website/function/f_edit_header'); ?>
<?php $id=$this->input->get('route'); $date = R::isoDateTime();?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <!-- Breadcrumb -->
        <div class="row mb-2">
            <div class="col-sm-4">
                <h1>Header Editor</h1>
            </div>
            <div class="col-sm-8">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <?php $menu = R::getALL("SELECT * FROM n_submenu where menu_id=".base64_decode($id)." AND role_id='".$role->id."' AND active='Y' ORDER BY urutan ASC;");?>
                    <?php foreach($menu as $i=> $val){?>
                    <li class="breadcrumb-item"><a
                            href="<?php echo site_url('admin/page')."?mod=".base64_encode($val['id'])."&route=".base64_encode($val['menu_id']);?>"><?php echo $val['nama_submenu']?></a>
                    </li>
                    <?php }?>
                </ol>
            </div>
        </div>
        <!-- End -->
        <!-- Info Pannel -->
        <div class="row">
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="far fa-envelope"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Posting Banner</span>
                        <span class="info-box-number">0</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Gallery</span>
                        <span class="info-box-number">410</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-warning"><i class="far fa-copy"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Posting Blog</span>
                        <span class="info-box-number">0</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-danger"><i class="far fa-star"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Sosial Media</span>
                        <span class="info-box-number">0</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- Button Action -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Navigasi</h3>
            </div>
            <div class="card-body">
                <a class="btn btn-app bg-green" id="btnAdd">
                    <i class="fas fa-file-alt"></i> Add
                </a>
                <a class="btn btn-app bg-warning" id="btnSetting">
                    <i class="fas fa-wrench"></i> Setting
                </a>
                <a class="btn btn-app bg-info" id="btnReload">
                    <i class="fas fa-sync"></i> Reload
                </a>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- End -->
    </div><!-- /.container-fluid -->
</section>
<!-- Container -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tampilan Slider</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table table id="tblData" class="table table-bordered table-striped"></table>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>

</section>
<!-- Modal Dialog -->
<div id="dlg-add_upload" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog modal-lg">
        <div class="modal-content modal-col-light-blue">
            <div class="modal-header">
                <h4 class="modal-title">Form Add</h4>
            </div>
            <div class="modal-body">
                <div class="card card-primary">
                    <div class="card-header">
                        <p>Upload Gambar</p>
                    </div>
                    <form id="add-data-upload" method="POST">
                        <div class="card-body load-ding-upload">
                            <div class="row">
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="logo-img">Images</label>
                                        <div id="myDropzone" class="dropzone"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="txtNameModel">Nama Model</label>
                                        <input type="text" id="txtNameModel" placeholder="ex.: Ariel Tatum"
                                            class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="txtLokasi">Lokasi</label>
                                        <input type="text" id="txtLokasi" placeholder="ex.: Braja Mustika"
                                            class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="cmbKategory-upd">Kategory</label>
                                        <select id="cmbKategory-upd" class="form-control" required></select>
                                    </div>
                                    <div class="form-group">
                                        <label for="cmbLink-upd">Permalink Button</label>
                                        <select id="cmbLink-upd" multiple class="form-control selectpicker"
                                            required></select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="form-group text-right">
                                <button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button>
                                <button type="submit" class="btn btn-primary ">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="dlg-add_slider" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog modal-lg">
        <div class="modal-content modal-col-light-blue">
            <div class="modal-header">
                <h4 id="frm-edit-foto-Label" class="modal-title">Form Add</h4>
            </div>
            <div class="modal-body">
                <div class="card card-primary">
                    <div class="card-header">
                        <p>Add Data Slider</p>
                    </div>
                    <form id="add-data-slider">
                        <div class="card-body load-ding">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="logo-img">Logo images</label>
                                        <input type="file" id="logo-img" data-allowed-file-extensions="png jpg jpeg"
                                            name="file" class="dropify" data-max-file-size="1M" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="cmbKategory"> Produk</label>
                                        <select id="cmbKategory" class="form-control" required></select>
                                    </div>
                                    <div class="form-group">
                                        <label for="txtJudul">Judul</label>
                                        <textarea class="form-control" id="txtJudul"
                                            placeholder="ex : Wujudkan Pernikahan dengan Kami " maxlength="2000"
                                            required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="txtDeskripsi">Deskripsi</label>
                                        <textarea class="form-control" id="txtDeskripsi"
                                            placeholder="ex : Dapatkan Paket Promo " maxlength="2000"
                                            required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="cmbLink">Link Buttons</label>
                                        <select id="cmbLink" multiple class="custom-select " required></select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="form-group text-right">
                                <button type="button" id="btnECancelPost" class="btn btn-warning">Cancel</button>
                                <button type="submit" id="btnESavePost" class="btn btn-primary ">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button>
            </div>
        </div>
    </div>
</div>
<div id="dlg-edit-foto" tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="true"
    class="modal fade text-left">
    <div role="document" class="modal-dialog loading">
        <div class="modal-content modal-col-light-blue">
            <div class="modal-header">
                <h4 id="frm-edit-foto-Label" class="modal-title">Form Edit</h4>
            </div>
            <div class="modal-body">
                <div class="card card-primary">
                    <div class="card-header">
                        <p>Edit Gamabar</p>
                    </div>
                    <form id="edit-foto-prof">
                        <div class="card-body">
                            <div class="form-group">
                                <input type="file" id="upl-upd-foto-prof" data-allowed-file-extensions="png jpg jpeg"
                                    name="file" class="dropify" data-max-file-size="1M" required>
                            </div>
                            <div class="input-group">
                                <div class="input-group-append ">
                                    <button type="submit" class="input-group-text bg-gradient btn-info">Upload</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-secondary ">Close</button>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('admin/menu/website/html/h_edit_permalink');?>
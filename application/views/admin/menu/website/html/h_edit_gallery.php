<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->view('admin/menu/website/function/f_edit_gallery'); ?>
<?php $id=$this->input->get('route'); $date = R::isoDateTime();?>
 <!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <!-- Breadcrumb -->
        <div class="row mb-2">
            <div class="col-sm-4">
                <h1>Gallery</h1>
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
                <a class="btn btn-app bg-pink" id="btnUpload">
                    <i class="fas fa-upload"></i> Upload
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
                <div class="card card-primary">
                    <div class="card-header">
                        <div class="card-title">
                            Images List
                        </div>
                    </div>
                    <div class="card-body">
                        <div>
                            <div class="btn-group w-100 mb-2 ctgr-label row">
                                <!-- <a class="btn btn-info" href="javascript:void(0)" data-filter="all"> All items </a>
                                <a class="btn btn-info" href="javascript:void(0)" data-filter="1"> Category 1 (WHITE)</a>
                                <a class="btn btn-info" href="javascript:void(0)" data-filter="2"> Category 2 (BLACK)</a>
                                <a class="btn btn-info active" href="javascript:void(0)" data-filter="3"> Category 3(COLORED) </a>
                                <a class="btn btn-info" href="javascript:void(0)" data-filter="4"> Category 4 (COLORED, BLACK) </a> -->
                            </div>
                            <div class="mb-2">
                                <div class="row">
                                    <div class="col-xs-12 col-4">
                                        <a class="btn btn-secondary mb-1" href="javascript:void(0)" data-shuffle=""> Shuffle items</a>
                                    </div>
                                    <div class="col-xs-12 col-8 float-right">
                                        <select class="custom-select" style="width: auto;" data-sortorder="">
                                            <option value="index"> Sort by Position </option>
                                            <option value="sortData"> Sort by Custom Data </option>
                                        </select>
                                        <div class="btn-group">
                                            <a class="btn btn-default" href="javascript:void(0)" data-sortasc=""> Ascending</a>
                                            <a class="btn btn-default" href="javascript:void(0)" data-sortdesc=""> Descending </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="filter-container">
                            <div class="list-images row p-0">
                                <div class="filtr-item col-sm-2" data-category="1" data-sort="white sample">
                                    <a href="https://via.placeholder.com/1200/FFFFFF.png?text=1" data-toggle="lightbox" data-title="sample 1 - white">
                                        <img src="https://via.placeholder.com/300/FFFFFF?text=1" class="img-fluid mb-2" alt="white sample"/>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <div class="card-title">
                            Images Setting
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table table id="tblData" class="table table-bordered table-striped"></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Resize Images -->
<div id="dlg-resize-images" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" class="modal fade text-left">
    <div role="document" class="modal-dialog modal-lg">
        <div class="modal-content modal-col-light-blue">
            <div class="modal-header">
                <h4 class="modal-title">From Setting</h4>
            </div>
            <div class="modal-body">
                <div class="card card-primary">
                    <div class="card-header">
                        <p>Resize Gambar</p>
                    </div>
                    <div class="card-body load-ding-resize">
                        <div class="col-lg-12 text-center">
                            <img width="500" id="resize-show" class="mb-5" src="" alt="Resize">
                        </div>
                        <div class="col-lg-12 mt-5">
                            <label for="resize-show">Ukuran Gambar</label>
                            <p id="uk-width"></p>
                            <p id="uk-height"></p>
                            <p id="uk-size"></p>
                            <button type="button" id="resize-img" class="btn btn-circle float-right bg-fuchsia"><i class="fas fa-file-image"></i> Resize</button>
                            <button type="button" id="load-size" class="btn btn-circle float-right bg-cyan"><i class="fas fa-refresh"></i> Refresh</button>
                        </div>
                    </div>
                    <div class="card-footer">
                        <p>Setting Rasio Gambar Minimum 50%</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button>
            </div>
        </div>
    </div>
</div>
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
								        <input type="text" id="txtNameModel" placeholder="ex.: Ariel Tatum" class="form-control"required>
                                    </div>
                                    <div class="form-group">
                                        <label for="txtLokasi">Lokasi</label>
								        <input type="text" id="txtLokasi" placeholder="ex.: Braja Mustika" class="form-control"required>
                                    </div>
                                    <div class="form-group">
                                        <label for="cmbKategory-upd">Kategory</label>
                                        <select id="cmbKategory-upd" class="form-control" required></select>
                                    </div>
                                    <div class="form-group">
                                        <label for="cmbLink-upd">Permalink Button</label>
                                        <select id="cmbLink-upd" multiple class="form-control selectpicker" required></select>
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
<div id="dlg-edit-status" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade text-left">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pilihan Lanjutan</h5>
            </div>
            <div class="modal-body">
                <p id="txt-status"></p>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn-prosess" class="btn bg-green waves-effect">Prosess</button>
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
    
    
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->view('admin/menu/website/function/f_edit_footer'); ?>
<?php $id=$this->input->get('route'); $date = R::isoDateTime();?>
 <!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <!-- Breadcrumb -->
        <div class="row mb-2">
            <div class="col-sm-4">
                <h1>Footer Editor</h1>
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
                <a class="btn btn-app bg-yellow" id="btnEdit">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a class="btn btn-app bg-danger" id="btnDell">
                    <i class="fas fa-eraser"></i> Delete
                </a>
                <a class="btn btn-app bg-info" id="btnReload">
                    <i class="fas fa-sync"></i> Reload
                </a>
                <a class="btn btn-app bg-pink" id="btnUpload">
                    <i class="fas fa-upload"></i> Upload
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
                        <h3 class="card-title">Footer Controller</h3>
                    </div>
                <!-- /.card-header -->
                <div class="card-body">
                    
                </div>
                <!-- /.card-body -->
                </div>
            </div>    
        </div>
    </div>

</section>

<!-- Modal Dialog -->
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
                                                <input type="file" id="logo-img" data-allowed-file-extensions="png jpg jpeg" name="file" class="dropify" data-max-file-size="1M" required>
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
												placeholder="ex : Wujudkan Pernikahan dengan Kami " maxlength="2000" required></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="txtDeskripsi">Deskripsi</label>
                                                <textarea class="form-control" id="txtDeskripsi"
												placeholder="ex : Dapatkan Paket Promo " maxlength="2000" required></textarea>
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
                                        <button  type="button" id="btnECancelPost" class="btn btn-warning">Cancel</button>
                                        <button  type="submit" id="btnESavePost" class="btn btn-primary ">Simpan</button>
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
    <div id="dlgDecision" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade text-left">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pilihan Lanjutan</h5>
                </div>
                <div class="modal-body">
                    <p id="txtDecision"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-prosess" class="btn bg-green waves-effect">Prosess</button>
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
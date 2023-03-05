<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->view('admin/menu/master/function/f_confiq_web'); ?>
<?php $id=$this->input->get('route'); $date = R::isoDateTime();?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <!-- Breadcrumb -->
            <div class="row mb-2">
                <div class="col-sm-4">
                    <h1>Konfigurasi</h1>
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
                            <span class="info-box-number">0</span>
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
                    <a class="btn btn-app bg-info" id="btnReload">
                        <i class="fas fa-sync"></i> Reload
                    </a>
                    <a class="btn btn-app bg-green" id="btnGallery">
                        <i class="fas fa-images"></i>Gallery
                    </a>
                    <a class="btn btn-app bg-yellow" id="btnEdit">
                        <i class="fas fa-edit"></i>Edit
                    </a>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- End -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- Container -->
	<!-- Main Content -->
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">Web Configurasi</h3>
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
	<!-- End Content -->
    <!-- Modal Form Image Search -->
	<div id="frm-edit-confiq" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" class="modal fade ">
		<div role="document" class="modal-dialog">
			<div class="modal-content modal-col-light-blue">
				<div class="modal-body">
					<div class="card card-primary">
						<div class="card-header">
							<p>Data Confiq</p>
						</div>	
						<form id="save-data">
                            <div class="card-body">	
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="txtTitle">Title</label>
                                            <textarea type="text" id="txtTitle" onfocus="$.queryLength(this,'#cnt-tl');" rows="2" cols="50" maxlength="60" placeholder="Wedding Planner terbaik di Bogor" class="form-control"required></textarea>
                                            <span class="float-right"><i id="cnt-tl">0</i> : 60 characters</span>
                                        </div>
                                        <div class="form-group">
                                            <label for="txtDeskripsi">Deskripsi</label>
                                            <textarea type="text" id="txtDeskripsi" onfocus="$.queryLength(this,'#cnt-dk');" rows="4" cols="50" maxlength="155" placeholder="cari wedding planner terbaik di bogor" class="form-control" required></textarea>
                                            <span class="float-right"><i id="cnt-dk">0</i> : 155 characters</span>
                                        </div>   
                                        <div class="form-group">
                                            <label for="txtImg">Image</label>
                                            <div class="input-group">
                                                <input type="text" id="txtImg"  class="form-control" required>
                                                <div class="input-group-append" onclick="$.search_img();">
                                                    <div class="input-group-text"><i class="fa fa-images"></i></div>
                                                </div>
                                            </div>								
                                        </div>
                                        <div class="form-group ">
                                            <label for="txtAuthor">Author</label>
                                            <div class="input-group">
                                                <input type="text" id="txtAuthor" onfocus="$.queryLength(this,'#cnt-au');" maxlength="60" placeholder="akbargrup wedding planner" class="form-control "required>
                                            </div>
                                            <span class="float-right"><i id="cnt-au">0</i>  : 60 characters</span>
                                        </div>
                                        <div class="form-group ">
                                            <label for="txtKeyword">Keyword</label>
                                            <div class="input-group">
                                                <input type="text" id="txtKeyword" onfocus="$.queryLength(this,'#cnt-ky');" maxlength="500" value="akbargrup,wedding bogor" class="form-control "required>
                                            </div>
                                            <span class="float-right"><i id="cnt-ky">0</i>  : 500 characters</span>
                                        </div>
                                    </div>
                                </div>
                            </div>	
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary float-right">Simpan</button>
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
    <!-- End Modal -->
    <!-- Modal Form Image Search -->
	<div id="frm-find-img" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade ">
		<div role="document" class="modal-dialog">
			<div class="modal-content modal-col-light-blue ">
				<div class="modal-body">
					<div class="card card-primary">
						<div class="card-header">
							<p>Pilih Gambar Untuk Gambar Utama</p>
						</div>	
						<div class="card-body">	
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="txtName">Data Gambar</label>
                                        <div class="input-group">
                                            <select id="cmbImg" class="form-control" required></select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="txtCopy">Copy Link Gambar</label>
                                        <div class="input-group">
                                            <input type="text" id="txtCopy" class="form-control" required>
                                            <div class="input-group-append" id="click-copy">
                                                <div class="btn bg-purple input-group-text"><i class="fa fa-copy"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
						</div>	
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button>
				</div>
			</div>
		</div>
	</div>
    <!-- End Modal -->
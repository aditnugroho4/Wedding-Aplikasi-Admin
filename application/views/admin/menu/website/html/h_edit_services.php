<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->view('admin/menu/website/function/f_edit_services'); ?>
<?php $id=$this->input->get('route'); $date = R::isoDateTime();?>
 <!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <!-- Breadcrumb -->
        <div class="row mb-2">
            <div class="col-sm-4">
                <h1>Content Editor</h1>
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
        
        <!-- Button Action -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Navigasi</h3>
            </div>
            <div class="card-body">
                <a class="btn btn-app bg-pink" id="btnUpload">
                    <i class="fas fa-upload"></i> Upload
                </a>
                <a class="btn btn-app bg-warning" id="btnSetting">
                    <i class="fas fa-wrench"></i> Setting
                </a>
                <a class="btn btn-app bg-green" id="btnLink">
                    <i class="fas fa-link"></i> Permalink
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
            <div class="col-md-4 col-sm-12 ">
                <!-- List Blog Content -->
                <div class="card list-product">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="ion ion-clipboard mr-1"></i>
                            List Product & Services
                        </h3>
                        <div id="pagination"></div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <ul class="todo-list" data-widget="todo-list">
                            <li>
                                <span class="handle">
                                    <i class="fas fa-ellipsis-v"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </span>
                                <div class="icheck-primary d-inline ml-2">
                                    <input type="checkbox" value="" name="todo1" id="todoCheck1">
                                    <label for="todoCheck1"></label>
                                </div>
                                <span class="text">Design a nice theme</span>
                                <small class="badge badge-danger"><i class="far fa-clock"></i> 2 mins</small>
                                <div class="tools">
                                    <i class="fas fa-edit"></i>
                                    <i class="fas fa-trash-o"></i>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <!-- /.card-body -->
                    <!-- <div class="card-footer clearfix">
                        <button type="button" id="new-artikel" class="btn btn-info float-right"><i class="fas fa-plus"></i> Add Blog</button>
                    </div> -->
                </div>
                <!-- /.card -->
            </div>
            <div class="col-md-8 info-product">
                <!-- Info Product -->
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-info"><i class="far fa-envelope"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">View</span>
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
                                <span class="info-box-text">Click</span>
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
                                <span class="info-box-text">Comment</span>
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
                                <span class="info-box-text">Dibagikan</span>
                                <span class="info-box-number">0</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                </div>
            </div>
            <!-- Add Post -->
            <div class="col-md-12 edit-product" style="display:none;">
                <div class="card card-primary card-outline load-edit">
                    <div class="card-header">
                        <h3 class="card-title">Edit Data Product</h3>
                    </div>
                    <!-- /.card-header -->
                    <form id="edit-Product" action="POST">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <p>Data Content</p>
                                        </div>	
                                        <div class="card-body">	
                                            <div class="row">
                                                <div class="col-lg-8 col-md-12">
                                                    <div class="form-group">
                                                        <label for="txtJudul">Judul</label>
                                                        <input id="txtJudul" class="form-control" placeholder="ex : Catering & Bufe" onfocus="$.queryLength(this,'#cnt-jdl_e');" maxlength="100">
                                                        <span class="float-right"><i id="cnt-jdl_e">0</i>  : 100 characters</span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="txtLabel">QUOTS</label>
                                                        <input id="txtLabel" class="form-control" placeholder="ex : Temukan Keindahan Bersama Kami" onfocus="$.queryLength(this,'#cnt-lb_e');" maxlength="100">
                                                        <span class="float-right"><i id="cnt-lb_e">0</i>  : 100 characters</span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="txtDescproduk">Deskripsi Layanan</label>
                                                        <textarea id="txtDescproduk" class="form-control" col="5" row="4" placeholder="ex : Wedding Organizer" onfocus="$.queryLength(this,'#cnt-des');" maxlength="500"></textarea>
                                                        <span class="float-right"><i id="cnt-des">0</i>  : 500 characters</span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="txtContent">Content</label>
                                                        <textarea id="txtContent" class="form-control"
                                                            style="min-height: 300px;"> </textarea>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-12">
                                                    <div class="card card-pink">
                                                        <div class="card-header">
                                                            <p>Optimasi Pencarian</p>
                                                        </div>	
                                                        <div class="card-body">	                                                    
                                                            <div class="form-group">
                                                                <label for="txtTitle">Title</label>
                                                                <input id="txtTitle" class="form-control" placeholder="ex : Wedding Organizer" onfocus="$.queryLength(this,'#cnt-tl_e');" maxlength="60">
                                                                <span class="float-right"><i id="cnt-tl_e">0</i>  : 60 characters</span>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="txtDeskripsi">Deskripsi</label>
                                                                <textarea id="txtDeskripsi" class="form-control" col="5" row="4" placeholder="ex : Wedding Organizer" onfocus="$.queryLength(this,'#cnt-des_e');" maxlength="155"></textarea>
                                                                <span class="float-right"><i id="cnt-des_e">0</i>  : 155 characters</span>
                                                            </div>    
                                                            <div class="form-group">
                                                                <label for="txtImg_e">Image</label>
                                                                <div class="input-group">
                                                                        <input type="text" id="txtImg_e"  class="form-control" required>
                                                                    <div class="input-group-append" onclick="$.search_img();">
                                                                        <div class="input-group-text"><i class="fa fa-images"></i></div>
                                                                    </div>
                                                                </div>								
                                                            </div>
                                                            <div class="form-group ">
                                                                <label for="txtAuthor_e">Author</label>
                                                                <div class="input-group">
                                                                    <input type="text" id="txtAuthor_e" onfocus="$.queryLength(this,'#cnt-au_e');" maxlength="60" placeholder="akbargrup wedding planner" class="form-control "required>
                                                                </div>
                                                                <span class="float-right"><i id="cnt-au_e">0</i>  : 60 characters</span>
                                                            </div>
                                                            <div class="form-group ">
                                                                <label for="txtKeyword_e">Keyword</label>
                                                                <div class="input-group">
                                                                    <input type="text" id="txtKeyword_e" onfocus="$.queryLength(this,'#cnt-ky_e');" maxlength="500" value="akbargrup,wedding bogor" class="form-control" required>
                                                                </div>
                                                                <span class="float-right"><i id="cnt-ky_e">0</i> : 500 characters</span>
                                                            </div> 
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <div class="float-right">
                                <button type="button" id="btn-draft" class="btn btn-default"><i class="fas fa-pencil-alt"></i>
                                    Draft</button>
                                <button type="submit" id="btn-simpan" class="btn btn-primary"><i class="far fa-envelope"></i> Simpan</button>
                            </div>
                            <button type="button" id="btn-reset" class="btn btn-default"><i class="fas fa-times"></i> Discard</button>
                        </div>
                        <!-- /.card-footer -->
                    </form>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
</section>
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
    <?php $this->load->view('admin/menu/website/html/h_upload_images');?>
    <?php $this->load->view('admin/menu/website/html/h_edit_permalink');?>
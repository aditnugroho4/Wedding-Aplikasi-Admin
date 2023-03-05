<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
	<?php $id=$this->input->get('route'); $date = R::isoDateTime();
		$this->load->view('admin/menu/master/function/f_submenu'); ?>
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <!-- Breadcrumb -->
      <div class="row mb-2">
        <div class="col-sm-4">
          <h1>Master SubMenu</h1>
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
              <span class="info-box-text">Messages</span>
              <span class="info-box-number">1,410</span>
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
              <span class="info-box-text">Bookmarks</span>
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
              <span class="info-box-text">Uploads</span>
              <span class="info-box-number">13,648</span>
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
              <span class="info-box-text">Likes</span>
              <span class="info-box-number">93,139</span>
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
          <a class="btn btn-app bg-yellow"id="btnEdit">
            <i class="fas fa-edit"></i> Edit
          </a>
          <a class="btn btn-app bg-danger"id="btnDell">
            <i class="fas fa-eraser"></i> Delete
          </a>
          <a class="btn btn-app bg-info"id="btnReload">
            <i class="fas fa-sync"></i> Reload
          </a>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- End -->
    </div><!-- /.container-fluid -->
  </section>

<!-- Main Content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Data Table</h3>
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

  <!-- Modal -->
  <div id="frm-add" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
    <div role="document" class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Modul Applikasi</h4>
        </div>
        <div class="modal-body">
          <div class="card card-primary">
            <div class="card-header">
              <p>Data Link Modul Applikasi</p>
            </div>
            <form id="add-data">
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="txtContent">Nama Modul</label>
                        <input id="txtContent" type="text" name="content" placeholder="Nama Modul.." class="form-control" autofocus required>
                    </div>
                    <div class="form-group">
                      <label for="cmbStruktur">Struktur Modul</label>
                      <select id="cmbStruktur" class="form-control" required></select>
                    </div>
                    <div class="form-group">
                      <label for="cmbUnit">Unit / Bagian</label>
                      <select id="cmbUnit" class="form-control" required></select>
                    </div>
                    <div class="form-group">
                      <label for="cmbRole">Level / Role</label>
                      <select id="cmbRole" class="form-control" required></select>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="cmbNamaMenu">Grup Menu</label>
                      <select id="cmbNamaMenu" class="form-control" required></select>
                    </div>
                    <div class="form-group">
                      <label for="txtUsername">Patch Link Folder</label>
                      <input id="txtFolder" type="text" name="Folder" placeholder="root/main/folder/html/"
                          class="form-control" required>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
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

  <div id="dlgAlert" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
    <div class="modal-dialog" role="document">
      <div class="modal-content ">
        <div class="modal-header">
          <div class="modal-title">
            <span class="btn btn-warning btn-sm" data-dismiss="modal"><i class="fas fa-warning"></i></span>
          </div>
        </div>
        <div class="modal-body">
          <div class="card card-primary">
            <div class="card-header">
              <p>Info...</p>
            </div>
            <div class="card-body">
              <div class="row clearfix">
                <h4 id="lblText"></h4>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" id="btnChange" class="btn bg-success">Save changes</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

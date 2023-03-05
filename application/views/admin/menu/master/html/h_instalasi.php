<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
  <?php $id=$this->input->get('route'); $date = R::isoDateTime(); 
  $this->load->view('admin/menu/master/function/f_instalasi')?>
  <div class="block-header">
      <h2>DATA INSTALASI</h2>
  </div>
  <!-- Info Dashboard -->
  <div class="row clearfix">
    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
      <div class="info-box bg-pink hover-expand-effect">
        <div class="icon">
          <i class="material-icons">playlist_add_check</i>
        </div>
        <div class="content">
          <div class="text">POSTING BANNER</div>
          <div class="number count-to" data-from="0"
            data-to="<?php echo R::count("w_post_banner"," date like ? AND status='Y'",array(substr($date,0,7).'%')); ?>"
            data-speed="15" data-fresh-interval="20"></div>
        </div>
      </div>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
      <div class="info-box bg-cyan hover-expand-effect">
        <div class="icon">
          <i class="material-icons">help</i>
        </div>
        <div class="content">
          <div class="text">POSTING DOKUMENT</div>
          <div class="number count-to" data-from="0" data-to="<?php echo R::count("w_post_files"); ?>" data-speed="1000"
            data-fresh-interval="20"></div>
        </div>
      </div>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
      <div class="info-box bg-light-green hover-expand-effect">
        <div class="icon">
          <i class="material-icons">forum</i>
        </div>
        <div class="content">
          <div class="text">POSTING HEADLINE</div>
          <div class="number count-to" data-from="0"
            data-to="<?php echo R::count("w_post_headline"," date like ? AND status='Y'",array(substr($date,0,7).'%')); ?>"
            data-speed="1000" data-fresh-interval="20"></div>
        </div>
      </div>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
      <div class="info-box bg-light-green hover-expand-effect">
        <div class="icon">
          <i class="material-icons">forum</i>
        </div>
        <div class="content">
          <div class="text">POSTING BERITA</div>
          <div class="number count-to" data-from="0"
            data-to="<?php echo R::count("w_post_berita"," date like ? AND status='Y'",array(substr($date,0,7).'%')); ?>"
            data-speed="1000" data-fresh-interval="20"></div>
        </div>
      </div>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
      <div class="info-box bg-light-green hover-expand-effect">
        <div class="icon">
          <i class="material-icons">forum</i>
        </div>
        <div class="content">
          <div class="text">COMMENTS</div>
          <div class="number count-to" data-from="0"
            data-to="<?php echo R::count("w_post_comment"," date like ? AND status='Y' AND author is null ",array(substr($date,0,7).'%')); ?>"
            data-speed="1000" data-fresh-interval="20"></div>
        </div>
      </div>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
      <div class="info-box bg-orange hover-expand-effect">
        <div class="icon">
          <i class="material-icons">person_add</i>
        </div>
        <div class="content">
          <div class="text">PENGUNJUNG</div>
          <div class="number count-to" data-from="0" data-to="1225" data-speed="1000" data-fresh-interval="20"></div>
        </div>
      </div>
    </div>
  </div>
<!-- Breadcrumb-->
  <ol class="breadcrumb breadcrumb-bg-light-blue">
    <li class="breadcrumb-item"><i class="material-icons"></i><a href="<?php echo base_url('admin'); ?>">Home</a></li>
    <?php $menu = R::getALL("SELECT * FROM n_submenu where menu_id=".base64_decode($id)." AND role_id='".$role->id."' AND active='Y' ORDER BY urutan ASC;");?>
    <?php foreach($menu as $i=> $val){?>
    <li class="breadcrumb-item"><a
        href="<?php echo site_url('admin/page')."?mod=".base64_encode($val['id'])."&route=".base64_encode($val['menu_id']);?>"><?php echo $val['nama_submenu']?></a>
    </li>
    <?php }?>
  </ol>
  <div class="row clearfix">
    <div class="col-lg-12 col-sm-12">
      <div class="card">
        <div class="header bg-blue-grey">
          <h2>Button</h2>
          <ul class="header-dropdown m-r--5">
            <li>
              <a href="javascript:void(0);" data-toggle="loading-nav" data-loading-effect="ios">
                <i class="material-icons">loop</i>
              </a>
            </li>
          </ul>
        </div>
        <div class="body">
          <button id="txtAddInstalasi" class="btn bg-green waves-effect"><i
              class="material-icons">add_box</i><span>Tambah Data</span></button>
        </div>
      </div>
    </div>
  </div>
  <!-- Data Table -->
  <div class="row clearfix">
	  <div class="col-lg-12 col-sm-12">
	    <div class="card">
	      <div class="header bg-blue-grey">
	        <h2>Data List</h2>
	        <ul class="header-dropdown m-r--5">
	          <li>
	            <a href="javascript:void(0);" data-toggle="loading-table" data-loading-effect="ios">
	              <i class="material-icons">loop</i>
	            </a>
	          </li>
	        </ul>
	      </div>
	      <div class="body">
	        <div class="table-responsive">
	          <table id="tblData" class="table table-striped table-bordered table-hover text-dark" cellspacing="0"
	            width="100%"></table>
	        </div>
	      </div>
	    </div>
	  </div>
	</div>
  <div id="myModal1" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
    <div role="document" class="modal-dialog">
      <div class="modal-content modal-col-light-blue">
        <div class="modal-header">
          <h4 id="exampleModalLabel" class="modal-title">Tambah Data</h4>
          <small>Tambahkan Data Dengan Benar.</small>
        </div>
        <div class="modal-body">
          <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
            <div class="card">
              <div class="body">
                <div class="row clearfix">
                <form id="saveForm">
                  <div class="col-xs-12 col-md-12">
                    <h5 class="card-inside-title">Sub Bagian/Unit</h5>
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="material-icons">group_add</i>
                      </span>
                      <select id="cmbUnit" name="subag" class="form-control" required></select>
                    </div>
                    <h5 class="card-inside-title">Nama Instalasi</h5>
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="material-icons">contacts</i>
                      </span>
                      <div class="form-line">
                        <input id="txtNamaInstalasi" type="text" name="Folder" placeholder="Nama Instalasi"
                          class="form-control" required>
                      </div>
                    </div>
                    <div class="pull-right">
                      <button type="submit" class="btn bg-green waves-effect">Simpan</button>
                    </div>
                  </div>
                </form>
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

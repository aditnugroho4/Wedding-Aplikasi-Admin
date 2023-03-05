<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $id=$this->input->get('route'); $date = R::isoDateTime();
	$this->load->view('admin/menu/master/function/f_user');?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<div class="container-fluid">
		<!-- Breadcrumb -->
		<div class="row mb-2">
			<div class="col-sm-4">
				<h1>USER MANAGEMENT</h1>
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

		<!-- Info -->
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
		<!-- End -->

		<!-- Button -->
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
			</div>
			<!-- /.card-body -->
		</div>
		<!-- End -->
	</div><!-- /.container-fluid -->
</section>
<!-- End Header -->

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
							<table id="tblData" class="table table-bordered table-striped">
							</table>
						</div>
					</div>
					<!-- /.card-body -->
				</div>
			</div>
		</div>
	</div>
</section>
<!-- End Content -->

<!-- Modal Dialog-->	
<div id="frm-add" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade text-left">
	<div role="document" class="modal-dialog modal-lg">
		<div class="modal-content modal-col-light-blue">
			<div class="modal-header">
				<h4 id="exampleModalLabel" class="modal-title">Tambah Data</h4>
			</div>
			<div class="modal-body">
				<div class="card card-primary">
					<div class="card-header">
						<p>Data Username Backend Dashboard</p>
					</div>
					<form id="add-data">
						<div class="card-body">
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label for="txtNama">Nama Lengkap</label>
										<input id="txtNama" type="text" name="nama" placeholder="Nama Lengkap"
											class="form-control" autofocus required>
									</div>
									<div class="form-group">
										<label for="txtUsername">Username</label>
										<input id="txtUsername" type="text" name="Username"
											placeholder="Username login." class="form-control" required>
									</div>
									<div class="form-group">
										<label for="txtPassword">New Password</label>
										<input id="txtPassword" type="password" name="password"
											placeholder="Password login." class="form-control" required>
									</div>
									<div class="form-group">
										<label for="txtRepassword">Re Password</label>
										<input type="password" id="txtRepassword" name="Repassword"
											placeholder="Username login." class="form-control" required>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="cmbStruktur">Struktur</label>
										<select id="cmbStruktur" name="Struktur" class="form-control" required></select>
									</div>
									<div class="form-group">
										<label for="txtUsername">Unit / Bagian</label>
										<select id="cmbUnit" name="Unit" class="form-control" required></select>
									</div>
									<div class="form-group">
										<label for="cmbRole">Role</label>
										<select id="cmbRole" name="Role" class="form-control" required></select>
									</div>
									<div class="form-group">
										<label for="txtEmail">Email</label>
										<input id="txtEmail" type="email" name="Folder"
											placeholder="exsample@nugroho.co.id" class="form-control" required>
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
				<button type="button" data-dismiss="modal" class="btn btn-secondary waves-effect">Close</button>
			</div>
		</div>
	</div>
</div>

<div id="dlgEditPassword" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade text-left">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Ganti Password</h5>
			</div>
			<div class="modal-body">
				<div class="card card-primary">
					<div class="card-header">
						<p>Edit Password</p>
					</div>
					<form id="editPassword">
						<div class="card-body">
							<div class="form-group">
								<label for="txtNamas">Nama Lengkap</label>
								<input id="txtNamas" type="text" name="nama" placeholder="Nama Lengkap"
									class="form-control" autofocus required>
							</div>
							<div class="form-group">
								<label for="txtUsernames">Username</label>
								<input id="txtUsernames" type="text" name="Username" placeholder="Username login."
									class="form-control" required>
							</div>
							<div class="form-group">
								<label for="txtPasswordBaru">New Password</label>
								<input id="txtPasswordBaru" type="password" name="password" placeholder="Password Baru"
									class="form-control" required>
							</div>
						</div>
						<div class="card-footer">
							<button type="submit" class="btn btn-primary">Simpan</button>
						</div>
						</from>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
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

<div id="dlgAlert" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade text-left">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Aktive Content</h5>
			</div>
			<div class="modal-body">
				<p id="lblText"></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn bg-yellow waves-effect" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

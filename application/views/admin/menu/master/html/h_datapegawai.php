<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->view('admin/menu/master/function/f_datapegawai');?>
	<div class="breadcrumb-holder">
        <div class="container-fluid">
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo site_url('admin');?>">Home</a></li>
            <li class="breadcrumb-item active">Tables       </li>
          </ul>
        </div>
      </div>
	<section>
        <div class="container-fluid">
          <!-- Page Header-->
          <header> 
            <h1 class="h3 display">List Tables </h1>
          </header>
          <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-header">
                  <h4>DATA PEGAWAI RSUD LEUWILIANG</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive-sm">
                    <div class="block">
						<button id="btnTambah" style="margin-bottom: 10px;">Tambah Pegawai</button>
							<table style="font-size:auto;" id="tblData" class="display"></table>
					</div>
					<div id="content-input" style="margin:0 auto;"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
 	<div id="dlg-upload" title="Foto Karyawan">
					<div style="width: 200px; margin:0 auto;">
								<div style="width: 90%; padding: 5px;">
									<img id="lihat" src="" alt="" style="width:140px; height:170px; margin:5px 15%;border:1px solid #FFD500;"/>
								</div>
							</div> 
	</div>
	<div id="inputdata" title="Registrasi Pegawai">
		<div class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-dialog-buttons"style="position: relative; width: 100%;">
						<div style="width: 100%; padding:5px; margin:0 auto;">
									<div style="width: 250px; float:left; margin:10px;">
											<div style="width: 90%; padding: 5px;">
												<img id="preview" src="" alt="" style="width:150px; height:190px; margin:5px 15%;border:1px solid #FFD500;"/>
											</div>
										<label>Upload Foto</label>
											<form id="foto" method="POST" enctype="multipart/form-data">
												<fieldset>
												<input type="file" id="file" name="file" value="" accept="image/*"  onchange="tampilkanPreview(this,'preview')" style="width:80%; margin:5px; padding:4px; float:left;" class="text ui-widget-content ui-corner-all" />
												<label style="color:red;font-size:12px;" id="txtSize"></label>
												</fieldset>
											</form>
									</div>
								<div style="width: 250px; float:left; margin:10px; border-right:1px solid #8F8776;">
												<label>NIP/NIRPTT/NIK</label>
												<br>
												<input type="text" id="txtNik" style="width:90%; padding:5px 5px;" class="text ui-widget-content ui-corner-all"/>
												<br>
												<label>NAMA</label>
												<br>
												<input type="text" id="txtNama" style="width:90%; padding:5px 5px;" class="text ui-widget-content ui-corner-all"/>
												<br>
												<label>Jenis Kelamin</label>
												<select id="cmbKelamin" style="width:90%; padding:5px 5px;" class="text ui-widget-content ui-corner-all">
												<option value="L">Laki - Laki</option>
												<option value="P">Perempuan</option>
												</select>	
												<br>
												<label>TEMPAT LAHIR</label>
												<input type="text" id="txtTmptLahir" style="width: 90%; padding:5px 5px;" value="" class="text ui-widget-content ui-corner-all" />
												<br>
												<label>TGL LAHIR</label>
												<input type="text" id="txtTglLahir" Placeholder="contoh : 1989-25-09" style="width: 90%; padding:5px 5px;" value="" class="text ui-widget-content ui-corner-all" />
												<br>
												<label>PENDIDIKAN</label>
												<br>
												<input type="text" id="txtPendidikan" style="width: 90%; padding:5px 5px;" value="" class="text ui-widget-content ui-corner-all" />
												<br>
								</div>
							<div style="width: 250px; float:left; margin:10px;">
											<label>TANGGAL MASUK</label>
											<br>
											<input type="text" id="txtTglMasuk"  Placeholder="contoh : 1989-25-09" style="width: 90%; padding:5px 5px;" value="" class="text ui-widget-content ui-corner-all" />
											<br>
											<label>STATUS</label>
											<br>
											<select type="text" id="cmbStatus"  style="width: 95%; padding:5px 5px;" value="" class="text ui-widget-content ui-corner-all" >	
												<option value="PNS">PNS</option>
												<option value="PTT">PTT</option>
												<option value="BLUD<">BLUD</option>
												<option value="MAGANG<">MAGANG</option>
												<option value="KSO">KSO</option>
											</select>
											<br>
											<label>PANGKAT GOLOGAN</label>
											<br>
											<input type="text" id="txtPangkat" style="width: 90%; padding:5px 5px;" value="" class="text ui-widget-content ui-corner-all" />
											</select>
											<br>
											<label>PROFESI</label>
											<br>
											<select type="text" id="cmbProfesi"  style="width: 95%; padding:5px 5px;" value="" class="text ui-widget-content ui-corner-all" >	
												<option value="Dokter">Dokter</option>
												<option value="Bidan">Bidan</option>
												<option value="Perawat">Perawat</option>
												<option value="Staff">Staff</option>
												<option value="Engginering">Engginering</option>
												<option value="Cleaning Services">Cleaning Services</option>
												<option value="OB">OB</option>
												<option value="Security">Security</option>
											</select>
											<br>
											<label>JABATAN</label>
											<br>
											<input type="text" id="txtJabatan"  style="width: 90%; padding:5px 5px;" value="" class="text ui-widget-content ui-corner-all" />	
											
							</div>
							<div class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-dialog-buttons" style="position: relative; margin:0 auto; width:95%;">
								<button id="btnSimpan" style="width: 20%;margin:5px;padding:5px; float:right;">Simpan</button>
							</div>
						</div>
			</div>
	</div>
	<div id="insert-confirm" title="Loading....!">
        <span><img id="lbllogo" src="" alt="" style="width:150px; height:150px; margin:0 23%;"/></span>
		 <p>
        <div id="lblloading"style="text-align:center;font-weight:bold;"></div>
		</p>
	</div>
<div id="dlg-alert" title="Alert">
    <p>
        <span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>
        <div id="txtAlert"></div>
    </p>
</div>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $id=$this->input->get('route'); $date = R::isoDateTime(); 
if($id){$this->load->view('admin/menu/website/function/f_upload_images'); }else{redirect('home','refresh');}?>

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
<div id="dlg-setting_gallery" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog modal-lg">
        <div class="modal-content modal-col-light-blue">
            <div class="modal-header">
                <h4 class="modal-title">From Setting</h4>
            </div>
            <div class="modal-body">
                <div class="card card-primary">
                    <div class="card-header">
                        <p>Setting Gallery</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table table id="tblData-setting" class="table table-bordered table-striped"></table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <p>Setting Gambar sesuai format yang sudah di sesuaikan..</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button>
            </div>
        </div>
    </div>
</div>
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
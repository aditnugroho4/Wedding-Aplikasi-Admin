<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $id=$this->input->get('route'); $date = R::isoDateTime(); 
if($id){$this->load->view('admin/menu/website/function/f_edit_permalink'); }else{redirect('home','refresh');}?>

<div id="dlg-add_permalink" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <div class="modal-content modal-col-light-blue">
            <div class="modal-header">
                <h4 class="modal-title">Form Add</h4>
            </div>
            <div class="modal-body">
                <div class="card card-primary">
                    <div class="card-header">
                        <p>Tambah Permalink</p>
                    </div>
                    <form id="add-data-permalink" method="POST">
                        <div class="card-body load-ding-add">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="txtNamaLink">Nama Link</label>
                                        <input type="text" id="txtNamaLink" placeholder="ex.: WhatsApp" class="form-control" maxlength="50" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="txtPermalink">Permalink</label>
                                        <input type="text" id="txtPermalink" placeholder="ex.: https://akbargrup.id/" class="form-control"required>
                                    </div>
                                    <div class="form-group">
                                        <label for="cmbIcon">Icon</label>
                                        <select id="cmbIcon" class="form-control " required>
                                            <option value="fas fa-whatsapp"><span>WhatsApp</span></option>
                                            <option value="fas fa-facebook"><span>Facebook</span></option>
                                            <option value="fas fa-instagram"><span>Instagram</span></option>
                                            <option value="fas fa-youtube-play"><span>Youtube</span></option>
                                            <option value="fas fa-twitter-square"><span>Twitter</span></option>
                                            <option value="fas fa-globe"><span>Website</span></option>
                                        </select>
                                    </div>
                                </div>
                                    
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-primary ">Simpan</button>
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
<div id="dlg-setting_permalink" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog modal-lg">
        <div class="modal-content modal-col-light-blue">
            <div class="modal-header">
                <h4 class="modal-title">From Setting</h4>
            </div>
            <div class="modal-body">
                <div class="card card-primary">
                    <div class="card-header">
                        <p>Setting Permalink</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table table id="tblPermalink" class="table table-bordered table-striped"></table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <p>Setting Permalink Pastikan target link sesuai..</p>
                    </div>
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
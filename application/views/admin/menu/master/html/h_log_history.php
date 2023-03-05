<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
	<?php $this->load->view('admin/menu/master/function/f_log_history'); ?>
<!-- Breadcrumb-->
      <div class="breadcrumb-holder">
        <div class="container-fluid">
          <ul class="breadcrumb">
            <li class="breadcrumb-item active"><a href="<?php echo site_url('admin');?>">Home</a></li>
			<li class="breadcrumb-item">Log Aktivity</li>
          </ul>
        </div>
      </div>	
 <section class="forms">
	<div class="container-fluid" >
	<!-- Page Header-->
          <header> 
		  <div class="card-body">
		  
		  </div>
          </header>
		<div class="row">
			<div class="col-lg-12">
					 <div class="card-header">
						<h4>Log History</h4>
					</div>
					 <div class="card">
						<div class="card-body">
							<div class="table-responsive">
								<table id="tblData" class="table table-striped table-bordered table-sm table-hover text-dark" cellspacing="0" width="100%"></table>
							</div>
						</div>
					</div>
			</div>
		</div>
	</div>
</section>

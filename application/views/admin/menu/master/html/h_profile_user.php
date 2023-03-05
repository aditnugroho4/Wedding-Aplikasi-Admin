<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $id=$this->input->get('role'); $date = R::isoDateTime();
$this->load->view('admin/menu/master/function/f_profile_user') ;?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<div class="container-fluid">
		<!-- Breadcrumb -->
		<div class="row mb-2">
			<div class="col-sm-4">
				<h1>Profile Setting</h1>
			</div>
			<div class="col-sm-8">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item active">User Profile</li>
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
						<span class="info-box-text">Bookmarks</span>
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
						<span class="info-box-text">Uploads</span>
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
						<span class="info-box-text">Likes</span>
						<span class="info-box-number">0</span>
					</div>
					<!-- /.info-box-content -->
				</div>
				<!-- /.info-box -->
			</div>
			<!-- /.col -->
		</div>
	</div><!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-3">

				<!-- Profile Image -->
				<div class="card card-primary card-outline">
					<div class="card-body box-profile">
						<div class="text-center">
							<img class="profile-user-img img-fluid img-circle" src="<?php if(!$user->foto){echo (base_url('asset/images/user/avatar5.png'));}else {echo  (base_url('asset/images/user/'.$user->foto));}  ?>"
								alt="User profile picture">
						</div>

						<h3 class="profile-username text-center"><?php echo $user->nama; ?></h3>

						<p class="text-muted text-center"><?php echo $role->name; ?></p>

						<button type="button" class="btn btn-primary btn-block edit-foto-profile"><b>Edit Foto</b></button>
					</div>
					<!-- /.card-body -->
				</div>
				<!-- /.card -->

				<!-- About Me Box -->
				<div class="card card-primary">
					<div class="card-header">
						<h3 class="card-title">Data Sosial</h3>
					</div>
					<!-- /.card-header -->
					<div class="card-body">
						<strong><i class="fab fa-whatsapp mr-1"></i> WhatsApp</strong>

						<p class="text-muted">
							<?php echo $user->whatsapp;?>
						</p>

						<hr>

						<strong><i class="fas fa-map-marker-alt mr-1"></i> Alamat</strong>

						<p class="text-muted"><?php echo $user->alamat;?></p>

						<hr>

						<strong><i class="fas fa-pencil-alt mr-1"></i> Sosial Media</strong>

						<p class="text-muted">
							<span class="tag tag-danger"><?php echo $user->email;?></span>
							<span class="tag tag-success"><?php echo $user->facebook;?></span>
							<span class="tag tag-info"><?php echo $user->instagram;?></span>
							<span class="tag tag-warning"><?php echo $user->youtube;?></span>
							<span class="tag tag-primary"><?php echo $user->twitter;?></span>
						</p>

						<hr>

						<strong><i class="far fa-file-alt mr-1"></i> Experience</strong>

						<p class="text-muted"><?php echo $user->alamat;?></p>
					</div>
					<!-- /.card-body -->
				</div>
				<!-- /.card -->
			</div>
			<!-- /.col -->
			<div class="col-md-9">
				<div class="card load-prof">
					<div class="card-header p-2">
						<ul class="nav nav-pills">
							<li class="nav-item"><a class="nav-link" href="#activity"
									data-toggle="tab">Activity</a></li>
							<li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a>
							</li>
							<li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Settings</a>
							</li>
						</ul>
					</div><!-- /.card-header -->
					<div class="card-body ">
						<div class="tab-content">
							<div class=" tab-pane" id="activity">
								<!-- <div class="post">
									<div class="user-block">
										<img class="img-circle img-bordered-sm" src="../../dist/img/user1-128x128.jpg"
											alt="user image">
										<span class="username">
											<a href="#">Jonathan Burke Jr.</a>
											<a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
										</span>
										<span class="description">Shared publicly - 7:30 PM today</span>
									</div>
									<p>
										Lorem ipsum represents a long-held tradition for designers,
										typographers and the like. Some people hate it and argue for
										its demise, but others ignore the hate as they create awesome
										tools to help create filler text for everyone from bacon lovers
										to Charlie Sheen fans.
									</p>

									<p>
										<a href="#" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i>
											Share</a>
										<a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i>
											Like</a>
										<span class="float-right">
											<a href="#" class="link-black text-sm">
												<i class="far fa-comments mr-1"></i> Comments (5)
											</a>
										</span>
									</p>

									<input class="form-control form-control-sm" type="text"
										placeholder="Type a comment">
								</div>
								<div class="post clearfix">
									<div class="user-block">
										<img class="img-circle img-bordered-sm" src="../../dist/img/user7-128x128.jpg"
											alt="User Image">
										<span class="username">
											<a href="#">Sarah Ross</a>
											<a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
										</span>
										<span class="description">Sent you a message - 3 days ago</span>
									</div>
									<p>
										Lorem ipsum represents a long-held tradition for designers,
										typographers and the like. Some people hate it and argue for
										its demise, but others ignore the hate as they create awesome
										tools to help create filler text for everyone from bacon lovers
										to Charlie Sheen fans.
									</p>

									<form class="form-horizontal">
										<div class="input-group input-group-sm mb-0">
											<input class="form-control form-control-sm" placeholder="Response">
											<div class="input-group-append">
												<button type="submit" class="btn btn-danger">Send</button>
											</div>
										</div>
									</form>
								</div>
								<div class="post">
									<div class="user-block">
										<img class="img-circle img-bordered-sm" src="../../dist/img/user6-128x128.jpg"
											alt="User Image">
										<span class="username">
											<a href="#">Adam Jones</a>
											<a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
										</span>
										<span class="description">Posted 5 photos - 5 days ago</span>
									</div>
									<div class="row mb-3">
										<div class="col-sm-6">
											<img class="img-fluid" src="../../dist/img/photo1.png" alt="Photo">
										</div>
										<div class="col-sm-6">
											<div class="row">
												<div class="col-sm-6">
													<img class="img-fluid mb-3" src="../../dist/img/photo2.png"
														alt="Photo">
													<img class="img-fluid" src="../../dist/img/photo3.jpg" alt="Photo">
												</div>
												<div class="col-sm-6">
													<img class="img-fluid mb-3" src="../../dist/img/photo4.jpg"
														alt="Photo">
													<img class="img-fluid" src="../../dist/img/photo1.png" alt="Photo">
												</div>
											</div>
										</div>
									</div>
									<p>
										<a href="#" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i>
											Share</a>
										<a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i>
											Like</a>
										<span class="float-right">
											<a href="#" class="link-black text-sm">
												<i class="far fa-comments mr-1"></i> Comments (5)
											</a>
										</span>
									</p>

									<input class="form-control form-control-sm" type="text"
										placeholder="Type a comment">
								</div>-->
							</div> 
							<!-- /.tab-pane -->
							<div class="tab-pane" id="timeline">
								<!-- <div class="timeline timeline-inverse">
									<div class="time-label">
										<span class="bg-danger">
											10 Feb. 2014
										</span>
									</div>
									<div>
										<i class="fas fa-envelope bg-primary"></i>

										<div class="timeline-item">
											<span class="time"><i class="far fa-clock"></i> 12:05</span>

											<h3 class="timeline-header"><a href="#">master Team</a> sent you an
												email</h3>

											<div class="timeline-body">
												Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
												weebly ning heekya handango imeem plugg dopplr jibjab, movity
												jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
												quora plaxo ideeli hulu weebly balihoo...
											</div>
											<div class="timeline-footer">
												<a href="#" class="btn btn-primary btn-sm">Read more</a>
												<a href="#" class="btn btn-danger btn-sm">Delete</a>
											</div>
										</div>
									</div>
									<div>
										<i class="fas fa-user bg-info"></i>

										<div class="timeline-item">
											<span class="time"><i class="far fa-clock"></i> 5 mins ago</span>

											<h3 class="timeline-header border-0"><a href="#">Sarah Young</a>
												accepted your friend request
											</h3>
										</div>
									</div>
									<div>
										<i class="fas fa-comments bg-warning"></i>

										<div class="timeline-item">
											<span class="time"><i class="far fa-clock"></i> 27 mins ago</span>

											<h3 class="timeline-header"><a href="#">Jay White</a> commented on your
												post</h3>

											<div class="timeline-body">
												Take me to your leader!
												Switzerland is small and neutral!
												We are more like Germany, ambitious and misunderstood!
											</div>
											<div class="timeline-footer">
												<a href="#" class="btn btn-warning btn-flat btn-sm">View comment</a>
											</div>
										</div>
									</div>
									<div class="time-label">
										<span class="bg-success">
											3 Jan. 2014
										</span>
									</div>
									<div>
										<i class="fas fa-camera bg-purple"></i>

										<div class="timeline-item">
											<span class="time"><i class="far fa-clock"></i> 2 days ago</span>

											<h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos
											</h3>

											<div class="timeline-body">
												<img src="http://placehold.it/150x100" alt="...">
												<img src="http://placehold.it/150x100" alt="...">
												<img src="http://placehold.it/150x100" alt="...">
												<img src="http://placehold.it/150x100" alt="...">
											</div>
										</div>
									</div>
									<div>
										<i class="far fa-clock bg-gray"></i>
									</div>
								</div> -->
							</div>
							<!-- /.tab-pane -->

							<div class="active tab-pane" id="settings">
								<form class="form-horizontal" id="edit-data-prof">
									<div class="form-group row">
										<label for="UserName" class="col-sm-2 col-form-label">Username</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="inputUserName" value="<?php echo $user->username; ?>"  placeholder="UserName" required>
										</div>
									</div>
									<div class="form-group row">
										<label for="Password" class="col-sm-2 col-form-label">Password</label>
										<div class="col-sm-4">
											<div class="input-group">
												<input type="password"  maxlength="8" class="form-control" id="inputPassword" placeholder="Password" required>
												<span class="input-group-append">
													<button type="button" class="btn btn-dark btn-flat btn-views1"><i class="fas fa-eye"></i></button>
												</span>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="input-group">
											<input type="password" maxlength="8" class="form-control" id="inputNewPassword" placeholder="New Password" >
												<span class="input-group-append">
													<button type="button" class="btn btn-dark btn-flat btn-views2"><i class="fas fa-eye"></i></button>
												</span>
											</div>
										</div>
									</div>
									<div class="form-group row">
										<label for="inputName" class="col-sm-2 col-form-label">Nama</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" value="<?php echo $user->nama; ?>" id="inputName" placeholder="Name" required>
										</div>
									</div>
									<div class="form-group row">
										<label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
										<div class="col-sm-10">
											<input type="email" class="form-control" value="<?php echo $user->email; ?>" id="inputEmail"
												placeholder="Email" required>
										</div>
									</div>
									<div class="form-group row">
										<label for="inputWhatsapp" class="col-sm-2 col-form-label">WhatsApp</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" value="<?php echo $user->whatsapp; ?>" maxlength="16" id="inputWhatsapp" placeholder="WhatsApp" required>
										</div>
									</div>
									<div class="form-group row">
										<label for="inputAlamat" class="col-sm-2 col-form-label">Alamat</label>
										<div class="col-sm-10">
											<textarea class="form-control" id="inputAlamat"
												placeholder="Alamat" maxlength="1000" required><?php echo $user->alamat; ?></textarea>
										</div>
									</div>
									<div class="form-group row">
										<label for="inputPengalaman"  class="col-sm-2 col-form-label">Pengalaman</label>
										<div class="col-sm-10">
											<textarea class="form-control" id="inputPengalaman"
												placeholder="Pengalaman" maxlength="2000" required><?php echo $user->pengalaman; ?></textarea>
										</div>
									</div>
									<div class="form-group row">
										<label for="inputInstagram" class="col-sm-2 col-form-label">Instagram</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" value="<?php echo $user->instagram; ?>" id="inputInstagram"
												placeholder="ex : @akbargrup" required>
										</div>
									</div>
									<div class="form-group row">
										<label for="inputFacebook" class="col-sm-2 col-form-label">Facebook</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" value="<?php echo $user->facebook; ?>" id="inputFacebook"
												placeholder="Facebook" required>
										</div>
									</div>
									<div class="form-group row">
										<label for="inputTwitter" class="col-sm-2 col-form-label">Twitter</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" value="<?php echo $user->twitter; ?>" id="inputTwitter"
												placeholder="ex : @Twitter" required>
										</div>
									</div>
									<div class="form-group row">
										<label for="inputYoutube" class="col-sm-2 col-form-label">Youtube Chanel</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" value="<?php echo $user->youtube; ?>" id="inputYoutube"
												placeholder="Youtube Chanel" required>
										</div>
									</div>
									<div class="form-group row">
										<div class="offset-sm-2 col-sm-10">
											<div class="checkbox">
												<label>
													<input type="checkbox" required> I agree to the <a href="#">terms and
														conditions</a>
												</label>
											</div>
										</div>
									</div>
									<div class="form-group row">
										<div class="offset-sm-2 col-sm-10">
											<button type="submit" class="btn btn-danger">Submit</button>
										</div>
									</div>
								</form>
							</div>
							<!-- /.tab-pane -->
						</div>
						<!-- /.tab-content -->
					</div><!-- /.card-body -->
				</div>
				<!-- /.nav-tabs-custom -->
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</div><!-- /.container-fluid -->
</section>
<!-- /.content -->

<!-- Dialog Model -->
<div id="frm-edit-foto" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade text-left">
	<div role="document" class="modal-dialog">
		<div class="modal-content modal-col-light-blue">
			<div class="modal-header">
				<h4 id="frm-edit-foto-Label" class="modal-title">Form Edit</h4>
			</div>
			<div class="modal-body load-ding">
				<div class="card card-primary">
					<div class="card-header">
						<p>Edit Foto Profile</p>
					</div>
					<form id="edit-foto-prof">
						<div class="card-body">
							<div class="form-group">
								<input type="file" id="upl-upd-foto-prof" data-allowed-file-extensions="png jpg jpeg" name="file" class="dropify" data-max-file-size="2M" required>
							</div>
							<div class="input-group">
								<div class="input-group-append ">
									<button type="submit" class="input-group-text bg-gradient btn-info">Upload</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" data-dismiss="modal" class="btn btn-secondary ">Close</button>
			</div>
		</div>
	</div>
</div>
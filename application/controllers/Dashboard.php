<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard extends CI_Controller {
private $user;

public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->library(array('Layout','rb','session'));
		$this->load->helper(array('form', 'url','html','file'));
		$this->load->helper('cookie');
		$this->load->database();		
			if(!$this->session->userdata('123456akbar'))
				{
				//Jika tidak ada session di kembalikan ke halaman login
				$this->session->sess_destroy();
				redirect('login','refresh');
				}
			else
				{
				$session_data = $this->session->userdata('123456akbar');
				$this->Auth['user'] = $session_data['user'];
				$this->Auth['unit'] = $session_data['unit'];
				$this->Auth['role'] = $session_data['role'];
				$this->Auth['ipaddress'] = $session_data['ipaddress'];
			}
	}
	public function get_all_member(){
		R::setStrictTyping(false);
			$start = 0;
			$limit = 0;
			if($this->input->post('limit')){
				$start = $this->input->post('start');	
				$limit = $this->input->post('limit');
			}
			$arr =  array();
			try{
				// $sql=R::getAll("SELECT * FROM m_user_member");
				$count=0;
				$row=0;
				$view=0;
				// foreach($sql as $key=>$v){
					$count += R::count("m_user_chat");
					$sql1 =R::getAll("SELECT * FROM m_user_chat ORDER BY id DESC LIMIT ".$start.",".$limit.";");
					if($sql1){						
						foreach($sql1 as $key=>$value){
							$arr['data'][]=$value;
							$row +=1;
							}
						$view += $row;
						$arr['error'] =false;
						$arr['code'] =100;
						}
					
					// }
				
				$limits = $row + $limit;
				$count = $count - $row - $limit;
				if($count > 0){
						$arr['more']='<button id="btn-load" onclick="$.pagination_get(0,'.$limits.')" class="btn btn-primary btn-sm">View more +'.$count.'</button>';
					}else{
						$arr['more']='<button id="btn-back" onclick="$.pagination_get(0,5)" class="btn btn-warning btn-sm">Back View</button>';
					}	
				
			}catch (Exception $e){
				$arr['error'] =true;
				$arr['code'] =201;
				$arr['message'] =$e->getMessage();
			}
		echo json_encode($arr);	
	}
	public function json_get_client(){
		R::setStrictTyping(false);
		$arr = array();
		try {
			$sql = R::getAll('SELECT * FROM m_user_chat');
			if($sql){
				foreach ($sql as $key => $value) {
					$chat = R::findOne('m_user_chat_replay','chat_id=? AND replay_id IS NULL AND activ IS NULL ORDER BY date DESC',array($value['id']));
					$newMessage=R::count('m_user_chat_replay','chat_id=? AND replay_id IS NULL AND activ IS NULL ORDER BY date DESC',array($value['id']));
					$message = "";
					if($chat){
						$message = $chat->export();
					}else{
						$message = "no message";
					}
					$arr['data'][]=array('user'=>$value,'message'=>$message,'newmessage'=>$newMessage);
				}
				$arr['code']='200';
				$arr['error']=false;
				$arr['message']="Success..";
			}else{
				$arr['code']='100';
				$arr['error']=true;
				$arr['message']="System error..";
			}
		} catch (Exception $e) {
			$arr['code']='101';
			$arr['error']=true;
			$arr['message']=$e->getMessage();
		}
		echo json_encode($arr);
	}

	public function chat_load_client(){
		R::setStrictTyping(false);
		$date = R::isoDateTime();
		$arr =array();
		$id=0;
		try{
			if($this->input->post()){
				// cek Pesan 
				$message=array();
					$sqlClient = R::getAll('SELECT * FROM m_user_chat_replay WHERE chat_id=? AND activ IS NULL',array($this->input->post('clientId')));
					if($sqlClient){
						foreach($sqlClient as $key=>$v){
							$message['newMessage'][]=array('id'=>$v['id'],
												'message'=>$v['message'],
												'adminId'=>$v['replay_id'],
												'clientId'=>$v['chat_id'],
												'status'=>$v['status'],
												'date'=>$v['date'],
												'nama'=>R::load('m_user_chat',$v['chat_id'])->nama,
												'namaAdmin'=>R::load('m_user',$v['replay_id'])->nama
											);
												
									if($v['chat_id']== $this->input->post('clientId') && $v['replay_id'] == null && $v['status'] == null ){
										$i =1;
										$arr['count']= $i++;
									}
						}	
					}
				$arr['data']=$message;		
				$arr['code']=200;
				$arr['error']=false;
				$arr['message']="Success..";		
			}else{
				$arr['code']=100;
				$arr['error']='true';
				$arr['message']="System failed...";
			}
		}catch (Exception $e) {
			$arr['code']=101;
			$arr['error']='true';
			$arr['message']=$e->getMessage();
		}
		echo json_encode($arr);
	}
	public function chat_send_message(){
		R::setStrictTyping(false);
		$date = R::isoDateTime();
		$arr =array();
		$id=0;
		try{
			if($this->input->post()){
				// cek email 
				$dump = R::dispense("m_user_chat_replay");
				$dump->message = $this->input->post('message');
				$dump->replay_id =$this->input->post('adminId');
				$dump->chat_id =$this->input->post('clientId');
				$dump->date =$date;
				$id = R::store($dump);

				$status = R::getAll('SELECT * FROM m_user_chat_replay WHERE chat_id= ? AND replay_id IS NULL AND activ IS NULL',array($this->input->post('clientId')));
						if($status){
							foreach ($status as $key => $value) {
								$read = R::load('m_user_chat_replay',$value['id']);
								$read->status ='R';
								R::store($read);
							}
						}
				if($id){
					$arr['code']=200;
					$arr['error']=false;
					$arr['id']=$this->input->post('clientId');
					$arr['message']="New Message..";
				}else{
					$arr['code']=100;
					$arr['error']=true;
					$arr['message']="System failed...";
				}
			}else{
				$arr['code']=101;
				$arr['error']=true;
				$arr['message']="System failed...";
			}
		}catch (Exception $e) {
			$arr['code']=101;
			$arr['error']=true;
			$arr['message']=$e->getMessage();
		}
		echo json_encode($arr);
	}
	public function json_chat_notif(){
		$ret = array();
		$date = R::isoDateTime();
		try{
			$Message = R::count("m_user_chat_replay","replay_id IS NULL GROUP BY chat_id AND activ IS NULL AND date like ?",array(substr($date,0,7).'%'));
			$newMessage=R::count("m_user_chat_replay","replay_id IS NULL AND status IS NULL AND activ IS NULL AND date like ?",array(substr($date,0,7).'%'));
			$userClient = R::count("m_user_chat");
			$userAdmin = R::count("m_user");
			$chat = R::getAll("SELECT * FROM m_user_chat_replay WHERE date like ? AND replay_id IS NULL AND status IS NULL",array(substr($date,0,7).'%'));
			// New Message
			$ret['new'] =$newMessage;
			$ret['client'] =$userClient;
			$ret['total']=$Message;
			$ret['replay']=R::count("m_user_chat_replay","replay_id IS NOT NULL AND activ IS NULL GROUP BY replay_id AND date like ?",array(substr($date,0,7).'%'));
			$client_notif = '<li class="nav-item dropdown">
								<a class="nav-link" data-toggle="dropdown" href="#">
									<i class="far fa-bell"></i>
									<span class="badge badge-warning navbar-badge" >'.$newMessage.'</span>
								</a>
								<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
									<span class="dropdown-item dropdown-header" id="notif_pesan">'.$newMessage.' Notifications Baru</span>
									<div class="dropdown-divider"></div>
										<a href="#" class="dropdown-item">
											<i class="fas fa-envelope mr-2"></i>'.$Message.' Pesan Baru
											<span class="float-right text-muted text-sm"> mins</span>
										</a>
									<div class="dropdown-divider"></div>
									<a href="#" class="dropdown-item">
										<i class="fas fa-users mr-2"></i>'.$userClient.' client registrasi
										<span class="float-right text-muted text-sm"> hours</span>
									</a>
									<div class="dropdown-divider"></div>
									<a href="#" class="dropdown-item">
										<i class="fas fa-file mr-2"></i> 0 new subscirbe
										<span class="float-right text-muted text-sm">days</span>
									</a>
									<div class="dropdown-divider"></div>
									<a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
								</div>
							</li>';
							if($newMessage){
								$ret['notif'] =true;
							}else{
								$ret['notif'] =false;
							}			
							$user_notif ='<li class="nav-item dropdown">
								<a class="nav-link" data-toggle="dropdown" href="#">
									<i class="fas fa-user-friends"></i>
									<span class="badge badge-danger navbar-badge">'.$userAdmin .'</span>
								</a>
								<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">';
							$user_admin = R::getAll("SELECT * FROM m_user"); 
							$url='';
							$note ='';
									foreach ($user_admin as $key => $value) {
										if($value['auth'] == "Y"){$note="Online";}else{$note="Offline";};
										if(!$value['foto']){$url=base_url('asset/images/user/avatar5.png');}else{$url=base_url('asset/images/user/').$value['foto'];}
										$user_notif .='<a href="#" class="dropdown-item"><div class="media">';
										$user_notif .='<img src="'.$url.'" alt="User Avatar" class="img-size-50 mr-3 img-circle">';
										$user_notif .='<div class="media-body">';
										$user_notif .='<h3 class="dropdown-item-title">'.$value['nama'].'<span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span></h3>'; 
										$user_notif .='<p class="text-sm">'.$value['email'].'</p>'; 
										$user_notif .='<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>'.$note.'</p>'; 
										$user_notif .='</div>'; 
										$user_notif .='</div>'; 
										$user_notif .='</a>'; 
									};
									$user_notif .='<div class="dropdown-divider"></div><a href="#" class="dropdown-item dropdown-footer">See All Messages</a></div>';
									$user_notif .='</li>';
									$user_notif.='<li><audio id="audio" autoplay style="display:none;"></audio></li>';	
								$ret['error']=false;
								$ret['code']='200';
								$ret['messages']='Success....';	
						$ret['client_notif'] = base64_encode($client_notif);
						$ret['user_notif'] = base64_encode($user_notif);
						}
						
						catch (Exception $e){
							$ret['error']=true;
							$ret['code']='101';
							$ret['messages']= $e->getMessage();
						}
					//var_dump($ret);	
					echo json_encode($ret);
				}
	// Clear Chat 
	public function clear_chat($id){
		$ret = array();
		$date = R::isoDateTime();
		try{
			$status = R::getAll('SELECT * FROM m_user_chat_replay WHERE chat_id= ? AND activ IS NULL ',array($id));
						if($status){
							foreach ($status as $key => $value) {
								$read = R::load('m_user_chat_replay',$value['id']);
								$read->activ ='N';
								R::store($read);
							}
							$ret['error']=false;
							$ret['code']='200';
							$ret['messages']= "success..";
						}
			
		}catch (Exception $e){
			$ret['error']=true;
			$ret['code']='101';
			$ret['messages']= $e->getMessage();
		}
		echo json_encode($ret);
	}
}
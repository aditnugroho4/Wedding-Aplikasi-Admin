<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chatboot extends CI_Controller {
	private $Auth;
	function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->library(array('form_validation','session','layout','rb'));
		$this->load->database();
		$this->load->helper(array('form', 'url','html','file','cookie'));
		$this->load->model('sendemail');
		if($this->session->userdata('akbarId'))
				{
					$session_data = $this->session->userdata('akbarId');
					$this->Auth['user'] = $session_data['id'];
					$this->Auth['nama'] = $session_data['nama'];
					$this->Auth['email'] = $session_data['email'];
					$this->Auth['telpon'] = $session_data['telpon'];
				}else{
					$this->Auth['user'] = 0;
				}
		}
// Function Chat Boot 
	public function chat_send_cookie(){
		R::setStrictTyping(false);
		$date = R::isoDateTime();
		$arr =array();
		$cookie=array();
		$id=0;
		try{
			if($this->input->post()){
				// cek email 
				$sql = R::findOne('m_user_chat','email=?',array($this->input->post('email')));
					if(!$sql){
						$dump = R::dispense("m_user_chat");
						$dump->nama = $this->input->post('nama');
						$dump->email =$this->input->post('email');
						$dump->telpon =$this->input->post('telpon');
						$dump->date = $date;
						$id=R::store($dump);

						$cookie = array(
							'id'=>$id,
							'nama'=>$this->input->post('nama'),
							'email'=> $this->input->post('email'),
							'telpon'=> (string)$this->input->post('telpon')
						);
					}else {
						$id = $sql->id;
					}
				// create session chat
					$cookie = array(
						'id'=>$id,
						'nama'=>$this->input->post('nama'),
						'email'=> $this->input->post('email'),
						'telpon'=> (string)$this->input->post('telpon')
					);
// 				$this->sendemail->send($this->input->post('email'),$this->input->post('nama'),"Layanan Customer Care Akbar Grup");
				$this->chat_send_marketing($id,$date);
				$this->session->set_userdata('akbarId', $cookie);	
				$arr['nama']=$this->input->post('nama');
				$arr['id']=$id;
				$arr['code']=200;
				$arr['error']='false';
				$arr['message']="System Success...";				
				
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
				$dump->chat_id =$this->input->post('clientId');
				$dump->date =$date;
				$id = R::store($dump);

				$status = R::getAll('SELECT * FROM m_user_chat_replay WHERE chat_id= ? AND replay_id=? AND activ IS NULL',array($this->input->post('clientId'),$this->input->post('adminId')));
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
			$arr['code']=102;
			$arr['error']=true;
			$arr['message']=$e->getMessage();
		}
		echo json_encode($arr);
		}
	public function chat_load_message(){
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
							if($v['chat_id']== $this->input->post('clientId') && $v['replay_id'] != null && $v['status'] == null ){
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
	public function read_chat($table,$fild,$id,$value){
		R::setStrictTyping(false);
		$arr = array();	
		try {
				$sql=R::load($table,$id);
				if($sql){
					$sql->$fild= $value;
					$tes = R::store($sql);
					if($tes){
						$arr['error']=false;
						$arr['code']='200';
						$arr['message']='Merubah Data Berhasil...';
					}else{
						$arr['error']=true;
						$arr['code']='100';
						$arr['message']='Gagal Merubah Data..';
					}
				}else{
					$arr['error']=true;
					$arr['code']='101';
					$arr['message']='Data Tidak Di Temukan..';
				}				
			}catch (Exception $e) {
				$arr['error']=true;
				$arr['code']='102';
				$arr['message']='Gaga System ..'.$e->getMessage();
			}
			echo json_encode($arr);
			// $this->add_log('ACTION USER ' . $table . ' ID ' . $id .' '.$fild.' '.$value);
		}
	public function chat_send_marketing($id,$date){
		$arr = array();
		try{
			$user=R::getAll("SELECT * FROM m_user WHERE role_id=?",array(2));
			if($user){
				foreach($user as $value){
					$this->sendemail->email_notif($value['email'],$value['nama'],'Chat Dari Pelanggan');
				}
				// First Chat email 
				$dump = R::dispense("m_user_chat_replay");
				$dump->message = "Hai.. Bisa Bantu Saya Untuk mengetahui Product Akbargrup";
				$dump->chat_id =$id;
				$dump->date =$date;
				R::store($dump);
			}else{
				$arr['error'] =true;
			}
		}catch (Exception $e){
			$arr['error'] =false;
			$arr['message'] =$e->getMessage();
		}
		return;
	}
	
}
?>

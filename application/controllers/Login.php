<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->library(array('form_validation','session','layout','rb'));
		$this->load->database();
		$this->load->model('user');
		$this->load->helper(array('form','url'));
	}
	function index($link=null){
			if($this->session->userdata('123456akbar')){
				redirect('Admin', 'refresh');
				$this->session->unset_userdata('123456akbar',FALSE);
				}
			else if($this->session->userdata('123456akbar')){
				redirect('Home', 'refresh');
				$this->session->unset_userdata('123456akbar',FALSE);
			}else{
				if($link==null) {
					$link = 'admin-menu-login-html-h_signin';
					}
				$this->sigin($link);
			}
		}
	public function sigin($content=null){
			$data=array('title'=>'LOGIN SIMRS LEWILIANG',
						'captcha'=>str_replace('-','/',$this->get_captcha()),
						'content'=>str_replace('-','/',$content));
			$this->layout->login('admin/menu/login/html/container',$data);
		}
	public function sigup(){
			$data=array('title'=>'Autentikasi',
						'captcha'=>$this->get_captcha(),
						'content'=>str_replace('-','/','admin-menu-login-html-h_signup'));
			$this->layout->login('admin/menu/login/html/container',$data);		
		}	
	public function forgot(){
			$data=array('title'=>'Autentikasi',
						'captcha'=>$this->get_captcha(),
						'content'=>str_replace('-','/','admin-menu-login-html-h_forgot'));
			$this->layout->login('admin/menu/login/html/container',$data);		
		}
	public function auth(){
			$arr = array();
			if (!$this->session->userdata('123456akbar') && $this->input->post('username')){
						$username = $this->input->post('username');
						$password = $this->input->post('password');
						$login = $this->user->login($username,base64_decode($password));
							if($login){
									$sess_array = array();
									foreach($login as $row)
												{
													//if($row->auth =='N'){	
														$sess_array = array(
															'user' => $row->id,
															'role'=> $row->role_id,
															'unit'=> R::load('m_role',$row->role_id)->unit_id,
															'ipaddress'=> $this->input->post('ipaddress')
														);
														$this->session->set_userdata('123456akbar', $sess_array);
														$arr['auth'] = false ;
														$arr['id'] = $row->id ;
														$arr['code'] = "100" ;
														$arr['message'] = "Login Berhasil..." ;
													//}else {
													//	$arr['auth'] = 'busy' ;
													//}
												}
							}else {
								$arr['auth'] = true ;
								$arr['code'] = "103" ;
								$arr['message'] = "Login Gagal Username atau password Salah" ;
							}
					echo json_encode($arr);		
				}else{
					redirect('login','refresh');
				}	
		}	
	function logout(){
			$id=$this->input->get('end');
			$user = R::load('m_user',base64_decode($id));
			$user->auth ='N';
			$user->ipaddress = null;
			$user->date = date("Y-m-d H:i:s");
			R::store($user);
			$this->session->unset_userdata('123456akbar',FALSE);
			$this->session->sess_destroy();
			redirect('home');
		}
	public function cek_captcha(){
			R::setStrictTyping(false);
				try{
						$word =$this->input->get('id');
						$expiration = time()-70;
						$arr=array();
						$sql = R::findOne("tb_captcha","word=?",array($word));
								if($sql){
									$arr['error']=false;
									$arr['code']='100';
									$arr['message']='verifikasi berhasil..';
								}else{
									$arr['error']=true;
									$arr['code']='101';
									$arr['error']='verifikasi gagal...!';
								}
						$this->db->query("DELETE FROM tb_captcha WHERE captcha_time < ".$expiration);					
					}catch(Exception $e){
						$arr['error']=true;
						$arr['code']='102';
						$arr['error']=$e->getMessage();
							}
				echo json_encode($arr);
			}
			
	public function get_captcha(){	/* Function untuk membuat gambar captcha yang berisi numerik atau angka */
				$CI =& get_instance();
				$this->load->helper(array('captcha')); /* library captcha dari Codeigniter  */
				$captcha = create_captcha(array(
					'word'=> strtoupper(substr(md5(time()), 0, 6)),
					'img_path'=> './asset/admin/images/captcha/',
					'img_url'=> './asset/admin/images/captcha/', /* ini Untuk Menyimpan Temporarry Gambar capcha yang di buat */
					'img_height'=> 40,
					'expiration'=>50,
					'pool'          => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
				));
				if($captcha){ /* Kondisi dimana angka pada captcha digunakan ketika login */
					$data=array(
								'captcha_time'=>$captcha['time'],
								'ip_address'=>$this->input->ip_address(),
								'word'=>$captcha['word'],);
								$expiration = time()-50; /* Akan di Hapus dari Database */
								$this->db->query("DELETE FROM tb_captcha WHERE captcha_time < ".$expiration);
								$query=$this->db->insert_string('tb_captcha',$data);
								$this->db->query($query);
				}
				else{
					return"captcha not work"; /* Kondisi Pada fuction Ketika Tidak bekerja atau error */
				}
				$CI->session->set_userdata(array('captchasecurity'  => strtoupper(substr(md5(time()), 0, 6))));
				return $captcha['image']; 
			}
			
	private function delete_captcha(){ /* Function ini untuk menghapus file image Captcha pada direktory asset */
				$filename= array();
				if ($handle = opendir('./asset/admin/images/captcha/')) {
				while (false !== ($entry = readdir($handle))) {
					if ($entry != "." && $entry != ".."){
						unlink('./asset/admin/images/captcha/'.$entry);  
						}
					}
					closedir($handle);
				}
			}

	// Login user Member 
	public function member_auth(){
		R::setStrictTyping(false);
		$arr = array();
		try{
			if (!$this->session->userdata('123456akbar') && $this->input->post('username')){
				$username = $this->input->post('username');
				$password = $this->input->post('password');
				$login = $this->user->login_member($username,$password);
					if($login)
					{
						$sess_array = array();
						foreach($login as $row){
							$sess_array = array(
								'user_id' => $row->id,
								'first_name'=> $row->first_name,
								'last_name'=>$row->last_name,
								'email'=> $row->email,
							);
								$this->session->set_userdata('123456akbar', $sess_array);
						}
						$arr['auth'] = false ;
						$arr['id'] = $row->id ;
						$arr['code'] = "000" ;
						$arr['message'] = "Login Berhasil..." ;
					}else {
						$arr['auth'] = true ;
						$arr['code'] = "101" ;
						$arr['message'] = "Login Gagal Username atau password Salah" ;
					}
			}else{
				redirect('home','refresh');
			}		
		}catch(Exception $e){
						$arr['error']=true;
						$arr['code']='102';
						$arr['error']=$e->getMessage();
							}
		echo json_encode($arr);
		}
	public function member_singup (){
		R::setStrictTyping(false);
		$arr =array();
			try{
				$sql= R::findOne('m_user_member','email=?',array($this->input->post('email')));
				if ($sql)
					{
						$arr['error'] = true;
						$arr['code']='101';
						$arr['message']='Email Anda sudah terdaftar..!';
					}else {
					if($this->input->post())
						{
						$bean = R::dispense("m_user_member");
						foreach ($this->input->post() as $column => $value)
							{
								$bean->$column = $value;
							}
								$id = R::store($bean);
							}
							$arr['error'] = false;
							$arr['code']='100';
							$arr['message']='Selamat Anda Berhasil Mendaftar..!</br> Silahkan Verifikasi Email Anda..';
						}
				}catch(Exception $e){
					$arr['error']=true;
					$arr['code']='102';
					$arr['message']=$e->getMessage();
						}
		echo json_encode($arr);
		}
	public function member_logout(){
		$id=$this->input->get('end');
		$user = R::load('m_user_member',base64_decode($id));
		$user->auth ='N';
		$user->ipaddress = null;
		$user->date = date("Y-m-d H:i:s");
		R::store($user);
		$this->session->unset_userdata('123456akbar',FALSE);
		$this->session->sess_destroy();
		redirect('home');
		}	
	
}
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Portfolio extends CI_Controller {
    private $Auth;
	function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->library(array('form_validation','session','layout','rb'));
		$this->load->database();
		$this->load->helper(array('form', 'url','html','file','url_helper'));
		$this->load->helper('cookie');
		if($this->session->userdata('123456akbarGroup'))
				{
					$session_data = $this->session->userdata('123456akbarGroup');
					$this->Auth['user'] = $session_data['user_id'];
					$this->Auth['first_name'] = $session_data['first_name'];
					$this->Auth['last_name'] = $session_data['last_name'];
					$this->Auth['email'] = $session_data['email'];
				}else{
					$this->Auth['user'] = 0;
				}
    }

    public function index($url=null){
		if($url==null){
			$data=array('user'=>R::load('m_user_member',$this->Auth['user']),
                        'Menu'=>$this->get_data_menu(),
                        'content'=>str_replace('-','/','portal-menu-content-html-h_Portfolio'),
                        'Seo'=>$this->get_data_seo(null),
                    );
			$this->layout->portal('portal/layout/container',$data);	
			}else{					
				$this->url($url);
			}
		}
        
	function log_url($id){
		$arr= array();
			try {
				$data = R::load('m_seo',$id);
				if($data){
					$data->url = strtolower($this->uri->uri_string());
					$data->date = R::isoDateTime();
					$data->view += 1;
					$arr['error'] =false;
					$arr['code'] =200;
					$arr['id']=$id;
					$id= R::store($data);
					}
				} catch(Exception $e) {
				$arr['error'] =true;
				$arr['code'] =201;
				$arr['message'] =$e->getMessage();
				}
		}	
	/* 
		Get Content Blog 
	*/
	//  Data Home
	public function get_data_menu(){
		$arr = array();
		try{
			$data =R::getAll('SELECT * FROM m_menu WHERE status="Y"');
			foreach($data as $value){
				$sql = R::getAll('SELECT * FROM m_submenu WHERE menu_id=?',array($value['id']));
				$sub = array();
				foreach($sql as $val){
					$sub[]=array($val);
				}
				$arr['data'][]=array('menu'=>$value,'submenu'=>$sub);
			}
		}catch (Exception $e) {
			$arr['error'] =true;
			$arr['code'] =201;
			$arr['message'] =$e->getMessage();
			}
		return($arr);
		// var_dump($arr);
		}
	public function get_data_seo($slug){
		$arr= array();
		$url=null;
		$data=null;
		try {
			if($slug==null){
				$id = R::findOne('m_menu','url=?',array($this->uri->uri_string()))->link_id;
				$data = R::load('m_seo',$id);
			}else{
				$data = R::load('m_seo',$slug);
			}
				if($data->id){
				$arr['data'] = array('title'=>$data->title,
								'deskripsi'=> $data->deskripsi,
								'keyword'=> $data->keyword,
								'img'=> str_replace('/','-',$data->icon),
								'link'=>$this->uri->uri_string(),
								'author'=> $data->author,
								'view'=>$data->view,
								'short_link'=> $data->short_link
					);
					$this->log_url($data->id);
				}else{
					$confiq = R::getAll('SELECT * FROM m_confiq');
						$title; $logo; $icon; $desc; $vendor; $keyword; $url;
					foreach($confiq as $i){
						if($i['name']=='Title')
							$title = $i['variabel'];
						if($i['name']=='Logo')
							$logo = $i['variabel'];
						if($i['name']=='Fav Icon') 
							$icon = $i['variabel'];
						if($i['name']=='Deskripsi')
							$desc = $i['variabel'];
						if($i['name']=='Vendor')
							$vendor = $i['variabel'];
						if($i['name']=='Keyword')
							$keyword = $i['variabel'];
						if($i['name']=='Url')
							$url = $i['variabel'];						
					}
					$arr['data']= array('title'=>$title,
						'deskripsi'=>$desc,
						'keyword'=> $keyword,
						'img'=>str_replace('/','-',$logo),
						'link'=>$this->uri->uri_string(),
						'author'=>$vendor,
						'short_link'=>'wedding-organizer');
				}
		}catch (Exception $e) {
			$arr['error'] =true;
			$arr['code'] =201;
			$arr['message'] =$e->getMessage();
			}
		return($arr);
		//var_dump($arr);
		}
	
}
?>
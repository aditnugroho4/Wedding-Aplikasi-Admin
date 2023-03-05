<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Services extends CI_Controller {
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
					'content'=>str_replace('-','/','portal-menu-content-html-h_Services'),
					'Product'=>$this->get_data_product(null),	
					'Seo'=>$this->get_data_seo(null)
				);
			$this->layout->portal('portal/layout/container',$data);	
			}
		}
    public function detail($id=null){
		if($id==null){
			redirect('services', 'refresh');
		}
		$link = $id;
		$link = str_replace('dan', '&',$link);
		$link = str_replace("-", " ",$link);
		$link = str_replace("%", " ",$link);
		$id = str_replace('|',' ',$id);

		$sql =R::findOne("w_post_kategory","product ='Y' AND name=?",array($link));
		$seo=null;
		$prd=null;
		if($sql){
			$seo=$sql->link_id;
			$prd=$sql->id;
		}

		$data=array('user'=>R::load('m_user_member',$this->Auth['user']),
					'Menu'=>$this->get_data_menu(),
					'content'=>str_replace('-','/','portal-menu-product-html-h_product_detail'),
					'Product'=>$this->get_data_product($prd),	
					'Seo'=>$this->get_data_seo($seo)
				);
		$this->layout->portal('portal/layout/container',$data);
	}
	function log_url($id){
		$arr= array();
			try {
				$data = R::load('m_seo',$id);
				if($data->id){
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
	public function get_data_seo($slug=null){
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
					$arr['data']= array('title'=>$data->title,
									'deskripsi'=> $data->deskripsi,
									'keyword'=> $data->keyword,
									'img'=> str_replace('/','-',$data->icon),
									'link'=>$this->uri->uri_string(),
									'view'=>$data->view,
									'author'=> $data->author,
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
							'view'=>0,
							'short_link'=>'wedding-organizer-bogor-akbargrup');
					}
			}catch (Exception $e) {
				$arr['error'] =true;
				$arr['code'] =201;
				$arr['message'] =$e->getMessage();
				}
			return($arr);
			//var_dump($arr);
			}
	public function get_data_product($id=null){
		$arr= array();
		$data ="";
		try {
			if($id==null){
				$data =R::getAll("SELECT * FROM w_post_kategory WHERE product ='Y';");
				foreach($data as $val){
					$arr['data'][]=array($val);
				}
			}else{
				$data =R::findOne("w_post_kategory","product ='Y' AND id=?",array($id));
				if($data){
					$arr['nama']=$data->name;
					$arr['label']=$data->label;
					$arr['title']=$data->title;					
					$arr['deskripsi']=$data->deskripsi;
					$arr['content']=$data->content;
					$arr['img']=$data->img;
					$this->log_url($data->id);
				}
			}
				
		}catch (Exception $e) {
			$arr['error'] =true;
			$arr['code'] =201;
			$arr['message'] =$e->getMessage();
			}
		return($arr);
		//var_dump($arr);
		}
	public function json_load_data(){
		R::setStrictTyping(false);
		$arr=array();
		try{
			$table = $this->input->get('table');
			$limit = $this->input->get('pageSize');
			$page = 0 ;

			if($this->input->get('pageNumber') < 1){
				$page = $this->input->get('pageNumber');
			}
			$ctgr = $this->input->get('ctgr');
			$MySql=R::getAll('Select * from '.$table.' ORDER BY id ASC LIMIT '.$page.','.$limit.';');

			$config = R::count($table);

			if($MySql){
				foreach($MySql as $i=> $key){	
						$arr['data'][]= array('items'=>$key,'user'=>R::load('m_user',$key['user_id'])->export(),'seo'=>R::load('m_seo',$key['link_id'])->export());
					}
					if($page == 0){
						$page =1;
					}
				$choice = $config / $page;
        		$arr["total"] = floor($choice);
				$arr['error']=false;
				$arr['code'] =100;
				$arr['message'] ='success..';
				}else{
					$arr["total"]=0;
					$arr['error'] =true;
					$arr['code'] =200;
					$arr['message'] ='Data Tidak Di Temukan..';
				}
			}
		catch(Exception $e) 
				{
				$arr['error'] =true;
				$arr['code'] =201;
				$arr['message'] =$e->getMessage();
				}
		echo json_encode($arr);	
	}
	/*
		END
	*/
}
?>
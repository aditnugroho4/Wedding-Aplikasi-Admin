<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Blog extends CI_Controller {
    private $Auth;
	function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->library(array('form_validation','session','layout','rb'));
		$this->load->database();
		$this->load->helper(array('form', 'url','html','file'));
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
					'content'=>str_replace('-','/','portal-menu-content-html-h_Blog'),
					'Seo'=>$this->get_data_seo($url)
				);
			$this->layout->portal('portal/layout/container',$data);	
			}else{					
				$this->detail($url);
			}		
		
	}

	public function detail($slug=null){		
		$data=array();
		if($slug==null){			
			redirect('blog', 'refresh');
		}else{
			$id = $slug;
			$id = str_replace('--','-',$id);
			$id = str_replace('|','-',$id);
			$id = str_replace('_','-',$id);
			$id = str_replace('%','-',$id);
			$hasil = R::findOne('m_seo','short_link=?',array($id));
			if($hasil){
				$data=array('user'=>R::load('m_user_member',$this->Auth['user']),
					'Menu'=>$this->get_data_menu(),
					'content'=>str_replace('-','/','portal-menu-content-html-h_Blog_detail'),
					'Seo'=>$this->get_data_seo($slug)
				);
			}else {
				$data=array('user'=>R::load('m_user_member',$this->Auth['user']),
					'Menu'=>$this->get_data_menu(),
					'content'=>str_replace('-','/','portal-menu-product-html-h_notfound'),
					'Seo'=>$this->get_data_seo($slug)
				);
			}

			
		}
		$this->layout->portal('portal/layout/container',$data);
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
				$id = $slug;
				$id = str_replace('&','dan',$id);
				$id = str_replace('|','-',$id);
				$id = str_replace('_','-',$id);
				$id = str_replace('%','-',$id);
				$data = R::findOne('m_seo','short_link=?',array($id));
			}
				if($data){
					$arr['data']= array('title'=>$data->title,
									'deskripsi'=> $data->deskripsi,
									'keyword'=> $data->keyword,
									'img'=> str_replace('/','-',$data->icon),
									'link'=>$this->uri->uri_string(),
									'view'=>$data->view,
									'author'=> $data->author,
									'short_link'=> $data->short_link
						);
						$url=$data->id;							
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
							'short_link'=>'blog-akbar-grup');
					}
				$arr['Blogs']=$this->get_data_blog($url);
				$this->log_url($url);
			}catch (Exception $e) {
				$arr['error'] =true;
				$arr['code'] =201;
				$arr['message'] =$e->getMessage();
				}
			return($arr);
			//var_dump($arr);
			}
	public function get_data_blog($id=null){
		$arr= array();
		$data ='';
		try {
			if($id==null){
				$data =R::getAll("SELECT * FROM w_post_artikel ORDER BY id DESC LIMIT 1");
			}else{
				$data = R::findOne("w_post_artikel","link_id=?",array($id));
			}
			if($data){
				$arr = array(
					'Id'=>$data->id,
					'Kategory'=>R::load('w_post_ctgr_blog',$data->ctgr_id)->nama,
					'Judul'=>$data->judul,
					'Content'=>$data->content,
					'Img'=>$data->img,
					'Reviewed'=>$data->reviewed,
					'Sumber'=>$data->sumber,
					'Quote'=>$data->quote,
					'Comment'=>$data->comment,
					'Like'=>$data->like,
					'Shared'=>$data->shared,
					'View'=>$data->view,
					'User'=>R::load('m_user',$data->user_id)->nama,
					'Date'=>date("F j, Y, g:i a", strtotime($data->date)),
					);
				
				}
				$ctgr = R::getAll('SELECT * FROM w_post_ctgr_blog');
				foreach($ctgr as $val){
					$arr['Ctgr'][]=array($val);
					}
				$blogAll="";
					if($this->input->get('Url')){
						$blogAll = R::getAll("SELECT * FROM w_post_artikel WHERE ctgr_id=? ORDER BY id DESC Limit 0,10",array($this->input->get('Url')));
					}else if($this->input->get('Url')=='All'){
						$blogAll = R::getAll("SELECT * FROM w_post_artikel ORDER BY id DESC Limit 0,10");
					}else if(!$this->input->get('Url')){
						$blogAll = R::getAll("SELECT * FROM w_post_artikel ORDER BY id DESC Limit 0,10");
					}
					if(!$blogAll){
						redirect('blog', 'refresh');
					}
					foreach($blogAll as $val){
						$arr['All'][]=array($val,'seo'=>R::load('m_seo',$val['link_id'])->export());
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
			$ctgr = $this->input->get('ctgr');
			$page = 0 ;

			if($this->input->get('pageNumber') < 1){
				$page = $this->input->get('pageNumber');
			}
			
			$MySql="";
					if($ctgr=='All'){
						$MySql=R::getAll('Select * from '.$table.' ORDER BY id DESC LIMIT '.$page.','.$limit.';');
					}else{
						$MySql=R::getAll('Select * from '.$table.' WHERE ctgr_id=? ORDER BY id DESC LIMIT '.$page.','.$limit.';',array($ctgr));
					}
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
		END
	*/
}
?>
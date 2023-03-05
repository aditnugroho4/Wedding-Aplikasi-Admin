<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	private $Auth;
	function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->library(array('form_validation','session','layout','rb'));
		
		$this->load->database();
		$this->load->helper(array('form', 'url','html','file','cookie'));

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

	public function index($url=null){
			if($url==null){
					$data=array('user'=>R::load('m_user_member',$this->Auth['user']),
					'Menu'=>$this->get_data_menu(),
					'content'=>str_replace('-','/','portal-menu-content-html-h_Home'),
					'banner'=>$this->get_data_banner(),	
					'Seo'=>$this->get_data_seo(null),
					'Blogs'=>$this->get_data_blog(),
					'Product'=>$this->get_data_product(null));
					$this->layout->portal('portal/layout/container',$data);	
				}
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

	public function contact($id=null){
			$data=array('user'=>R::load('m_user_member',$this->Auth['user']),
						'Menu'=>$this->get_data_menu(),
						'content'=>str_replace('-','/','portal-menu-content-html-h_Contact'),
						'Seo'=>$this->get_data_seo($id),
					);
			$this->layout->portal('portal/layout/container',$data);
		}

	public function page($slug=null){
			$url=null;
			$seo=null;
			$data=array();
				if($slug==null){
					$slug='customer-care-kami';
					$seo=6;
				}
				$id = $slug;
				$id = str_replace('|','-',$id);
				$id = str_replace('/','-',$id);
				$id = str_replace('%','-',$id);
				$id = str_replace('_','-',$id);
				$id = str_replace('--','-',$id);
				$url = R::findOne('m_submenu','url=?',array($id));
				
				if($url){
					if($seo != 6){
						$seo = $url->link_id;
					}
				$data=array('user'=>R::load('m_user_member',$this->Auth['user']),
						'Menu'=>$this->get_data_menu(),
						'content'=>str_replace('-','/',$url->html_patch),
						'Seo'=>$this->get_data_seo($seo)
					);
				}else {
					$data=array('user'=>R::load('m_user_member',$this->Auth['user']),
					'Menu'=>$this->get_data_menu(),
					'content'=>str_replace('-','/','portal-menu-product-html-h_notfound'),
					'Seo'=>$this->get_data_seo($slug)
					);
				}
				$this->layout->portal('portal/layout/container',$data);
			
		}
		
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
	public function get_data_banner(){
		$arr = array();
		try{
			$data =R::getAll('SELECT * FROM w_post_banner WHERE status="Y" ORDER BY id ASC limit 0,5; ');
			foreach($data as $key=>$value){
				$arr['data'][]=array('Ctgr'=>$value['text_kategory'],
									'Judul'=>$value['text_judul'],
									'Desc'=>$value['text_deskripsi'],
									'Img'=>$value['foto'],
									'Link'=>R::load('w_post_link_button',$value['link_id'])->export()
								);
			}
		}catch (Exception $e) {
			$arr['error'] =true;
			$arr['code'] =201;
			$arr['message'] =$e->getMessage();
			}
		return($arr);
		// var_dump($arr);
		}
	public function get_data_gallery(){
			R::setStrictTyping(false);
			$start = 0;
			$limit = 0;
			if($this->input->post('limit')){
				$start = $this->input->post('start');	
				$limit = $this->input->post('limit');
			}
			$arr =  array();
			try{
				$sql=R::getAll("SELECT * FROM w_post_kategory WHERE product='Y';");
				$count=0;
				$row=0;
				$view=0;
				foreach($sql as $key=>$v){
					$arr['data'][]=array('name'=>$v['name'],'css'=>$v['id']);
					$count += R::count("w_post_images","status='Y' AND ctgr_id=?",array($v['id']));
					$sql1 =R::getAll("SELECT * FROM w_post_images WHERE ctgr_id=? AND status='Y' ORDER BY id DESC LIMIT ".$start.",".$limit."",array($v['id']));
					if($sql1){						
						foreach($sql1 as $key=>$value){
							$arr['images'][]=array('img'=>$value['img'],
								'nama'=> $value['name'],
								'lokasi'=> $value['lokasi'],
								'label'=> R::load('w_post_kategory',$value['ctgr_id'])->name,
								'link'=> R::load('w_post_link_button',$value['link_id'])->link_target,
								'ctgr'=> $value['ctgr_id'],
								'size'=> $value['size']
								);
							$row +=1;
							}
						$view += $row;
						}
					
					}
				
				$limits = $row + $limit;
				$count = $count - $row - $limit;
				if($count > 0){
						$arr['more']='<button id="btn-load" onclick="$.pagination_get(0,'.$limits.')" class="primary-btn">View more +'.$count.'</button>';
					}else{
						$arr['more']='<button id="btn-back" onclick="$.pagination_get(0,3)" class="primary-btn">Back View</button>';
					}	
				
			}catch (Exception $e){
				$arr['error'] =true;
				$arr['code'] =201;
				$arr['message'] =$e->getMessage();
			}
			echo json_encode($arr);
		}
		
	public function get_imageList(){
			$imageList = array();
			try{
					if ($handle = opendir('asset/images/ads')) {
						while (false !== ($entry = readdir($handle))) {
							if ($entry != "." && $entry != "..") {
								$imageList['data'][] = $entry;
							}
						}
						closedir($handle);
					}
				} catch (Exception $e) {
					$imageList['error'] =true;
					$imageList['code'] =103;
					$imageList['message'] =$e->getMessage();
			}
			echo json_encode($imageList);
			}
	public function get_data_seo($slug=null){
		$arr= array();
		$data=null;
		try {
			if($slug==null){
				$id = R::findOne('m_menu','url=?',array($this->uri->uri_string()));
				if($id !=null){
					$data = R::load('m_seo',$id->link_id);
				}
				
			}else{
				$data = R::load('m_seo',$slug);
			}
				if($data){
					$arr['data'] = array('title'=>$data->title,
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
								'short_link'=>'wedding-organizer-bogor-akbargrup');
						}
				} catch(Exception $e) {
				$arr['error'] =true;
				$arr['code'] =201;
				$arr['message'] =$e->getMessage();
				}
			return($arr);
			// var_dump($id);
		}
	public function get_data_blog(){
		$arr= array();
		try {
			$data =R::getAll("SELECT * FROM w_post_artikel ORDER BY id DESC LIMIT 1");
			foreach($data as $key=>$value){
					$arr['Id'] = $value['id'];
					$arr['Kategory'] = R::load('w_post_ctgr_blog',$value['ctgr_id'])->nama;
					$arr['Judul'] = $value['judul'];
					$arr['Content'] = $value['content'];
					$arr['Img'] = $value['img'];
					$arr['Reviewed'] = $value['reviewed'];
					$arr['Sumber'] = $value['sumber'];
					$arr['Quote'] = $value['quote'];
					$arr['Comment'] = $value['comment'];
					$arr['Like'] = $value['like'];
					$arr['Shared'] = $value['shared'];
					$arr['View'] = $value['view'];
					$arr['Date'] = date("F j, Y, g:i a", strtotime($value['date']));
				}
			$ctgr = R::getAll('SELECT * FROM w_post_ctgr_blog');
				foreach($ctgr as $val){
					$arr['Ctgr'][]=array($val);
				}
			$blogAll = R::getAll("SELECT * FROM w_post_artikel ORDER BY id DESC Limit 0,10");
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
					$data =R::findOne("w_post_kategory","product ='Y' AND `name` LIKE ?",array($id.'%'));
					if($data){
						$arr['nama']=$data->name;
						$arr['label']=$data->label;
						$arr['title']=$data->title;					
						$arr['deskripsi']=$data->deskripsi;
						$arr['content']=$data->content;
						$arr['img']=$data->img;
						$this->get_data_seo($data->link_id);
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
		// Function Blog
	public function json_load_comment(){
		R::setStrictTyping(false);
		$id = $this->input->post('id');
		$arr=array();
		$replay=array();
		try{
			$sql = R::getAll("SELECT uc.*,um.first_name,um.last_name,um.foto_id FROM m_user_comment uc INNER JOIN m_user_member um ON um.id=uc.member_id WHERE uc.product_id=?",array($id));
			if($sql){
				foreach($sql as $i=> $val){
					$sql1 = R::getAll("SELECT ur.*,um.first_name,um.last_name,um.foto_id FROM m_user_replay ur INNER JOIN m_user_member um ON um.id=ur.member_id WHERE ur.comment_id=?",array($val['id']));
						foreach($sql1 as $a=> $value){
							$replay[]= $value;
						}
					$arr["data"][]= array('comment'=>$val,'replay'=>$replay) ;
				}
				$arr['code']='100';
				$arr['error']='false';
				$arr['message']="Success..";
			}else{
				$arr['code']='200';
				$arr['error']='true';
				$arr['message']="Data Not Found..";
			}
		}catch(Exception $e) 
		{
			$arr['code']='201';
			$arr['error']='true';
			$arr['message']=$e->getMessage();
		}
		echo json_encode($arr);
		}
	public function json_load_ulasan(){
		R::setStrictTyping(false);
		$id = $this->input->post('id');
		$arr=array();
		try{
			$sql = R::getAll("SELECT uc.*,um.first_name,um.last_name,um.foto_id FROM m_user_ulasan uc INNER JOIN m_user_member um ON um.id=uc.member_id WHERE uc.product_id=? ORDER BY uc.id ASC LIMIT 0,20",array($id));
			if($sql){
				foreach($sql as $i=> $val){
					$arr["data"][]= $val ;
				}
				$arr['code']='100';
				$arr['error']='false';
				$arr['message']="Success..";
			}else{
				$arr['code']='200';
				$arr['error']='true';
				$arr['message']="Data Not Found..";
			}
		}catch(Exception $e) 
		{
			$arr['code']='201';
			$arr['error']='true';
			$arr['message']=$e->getMessage();
		}
		echo json_encode($arr);
		}
	public function json_load_project(){
		R::setStrictTyping(false);
		$arr=array();
		try{
			$MySql=R::getAll('Select * from m_product_timeline ORDER BY id ASC LIMIT 0,9;');
			if($MySql){
				foreach($MySql as $i=> $key){
					if($key['img_id']!=null){
						$sql= R::findOne("m_product_img"," code_id=?",array($key['img_id']));
						$img ="asset/images/project/bg-proj.png";
                                if($sql){
                                    $img =$sql->link.'/'.$sql->name;
                                }else{
                                    $img ="asset/images/project/bg-proj.png";
                                }
					}
					$arr['data'][]=array('prod'=>$key,'img'=>$img);
				}
				$arr['error']=false;
				$arr['code'] =100;
				$arr['message'] ='success..';
				}else{
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
		return($arr);	
		}
	// Function Triger
	public function multi_select(){
		$table = $this->input->get('table');
		$select='';
		$MySql ='';
			try{	
				if ($this->input->get('select')) {
					$select =' Where '.$this->input->get('select').'='.$this->input->get('id');
				}
				if ($this->input->get('aVar')) {
					$select .='AND '.$this->input->get('aVar').'='.$this->input->get('var');
				}
				//echo('Select * from '.$table.''.$select.';');
				$data=array();
				if(!empty($table))
				{
					$q=R::getALL('Select * from '.$table.' '.$select.';');
					foreach($q as $h)
					{
							array_push( $data,$h);
					}
				}
			}catch (Exception $e)
				{
					echo $e->getMessage();
				}
		echo json_encode($data);
		}
	public function get_data_table($table,$id){
		R::setStrictTyping(false);
		$arr =  array();
		try{
			$sql = R::load($table,$id);
			if($sql){
				$arr['data']=$sql->export();
				$arr['error']=false;
				$arr['code']='100';
				$arr['message']='success..';
			}else{
				$arr['error']=true;
				$arr['code']='200';
				$arr['message']='data not found..';
			}
		}catch (Exception $e){
			$arr['error']=true;
			$arr['code']='201';
			$arr['message']= $e->getMessage();
		}
		echo json_encode($arr);
		}
	public function create($table) {		
		R::setStrictTyping(false);
		$arr = array();
		try{
			$bean = R::dispense($table);
			if($this->input->post())
				{
				foreach ($this->input->post() as $column => $value) {
						$bean->$column = $value;
						}
						$id = R::store($bean);
						$arr['code']='100';
						$arr['error']='false';
						$arr['message']='berhasil..';
						$arr['id']=$id;
				}else{
					$arr['code']='200';
					$arr['error']='true';
					$arr['message']='Gagal..!';
					$arr['id']=$arr['id'];
				}		
		}
		catch (Exception $e) {
			$arr['code']='201';
			$arr['error']='true';
			$arr['message']=$e->getMessage();
			$arr['id']=$arr['id'];
		}
		echo json_encode($arr);
		//$this->add_log('CREATE Data Ke Table (' . $table . ') Dengan ID ' . $arr['id'] .' Dan Value ('. $bean.')');
		}
	public function post_order(){
		R::setStrictTyping(false);
		$arr =array();
		try{
			
			$data = $this->input->get('data');
			$data = str_replace("^",".",$data);
			$data = str_replace("-","+",$data);
			$data = str_replace("_","/",$data);
			$hasil = json_decode(base64_decode($data));/* enkripsi data for*/

			$config['upload_path']   = FCPATH.'asset/images/project/';
			$config['allowed_types'] = 'jpg|png|jpeg';
			//$config['encrypt_name'] = TRUE;
			$time = "P-".strtoupper(substr(md5(time()), 0, 5));
			$config['file_name'] =$time;
			$this->load->library('upload',$config);

			if($this->upload->do_upload('file')){
				$file = $this->upload->data();				
				// image manipulasi merisize
				$nama = $file['file_name'];
				$type = $file['file_type'];
				$config['image_library']='GD2';
				$config['source_image'] = $file['full_path'];
				$config['maintain_ratio'] = FALSE;
				$config['create_thumb'] = FALSE;
				// size image
				$config['width'] = 960;
				$config['height'] = 850;
				$config['quality'] = 50;
				$config["image_sizes"]["square"] = array($config['width'], $config['height']);
				$this->load->library('image_lib', $config);
				$this->image_lib->resize();		
				if($this->load->library('image_lib', $config)){
						$drop = R::dispense('m_order_cart');
						$drop->cart_no = substr(R::isoDateTime(),0,8).'-'.strtoupper(substr(md5(time()), 0, 3));
						$drop->member_id = $hasil->userId;
						$drop->product_id =$hasil->prodId;
						$drop->discount =$hasil->discount;
						$drop->qty =$hasil->qty;
						$drop->total = intval($hasil->total);
						$drop->deskripsi = $hasil->desc;
						$drop->status ='O';
						$drop->tgl_order = R::isoDateTime();
						$drop->mocup= $nama;
						$drop->type= $hasil->type;
						$bean = R::store($drop);
						if($bean){
							foreach($hasil->dataTables as $key){
								$detail = R::dispense('m_order_detail');
									$detail->deskripsi = $hasil->desc;
									$detail->model = $key[1];
									$detail->size = $key[2];
									$detail->qty = $key[3];
									$detail->harga = str_replace(['.','Rp'],"",$key[4]);
									$detail->cart_id = $bean;
									$detail->date = R::isoDateTime();
									R::store($detail);
							}
							$arr['error'] =false;
							$arr['code'] =100;
							$arr['message'] ='simpan data berhasil..';
							}else{
								$arr['error'] =true;
								$arr['code'] =200;
								$arr['message'] ='Gagal simpan data..';
							}
					}else {
						$arr['error'] =true;
						$arr['code'] =201;
						$arr['message'] ='Gagal Kompresing image or file ..';
					}						
				}else{
					$arr['error'] =true;
					$arr['code'] =202;
					$arr['message'] ='Gagal Upload Data...';	
				}	
		}catch (Exception $e) {
			$arr['code']=204;
			$arr['error']='true';
			$arr['message']=$e->getMessage();
		}
		echo json_encode($arr);
		}
	public function post_cart(){
		R::setStrictTyping(false);
		$arr =array();
		try{
			$data = $this->input->post('data');
			$data = str_replace("^",".",$data);
			$data = str_replace("-","+",$data);
			$data = str_replace("_","/",$data);
			$hasil = json_decode(base64_decode($data));/* enkripsi data for*/

			if($data){
				$drop = R::dispense('m_order_cart');
				$drop->cart_no = substr(R::isoDateTime(),0,8).'-'.strtoupper(substr(md5(time()), 0, 3));
				$drop->member_id = $hasil->userId;
				$drop->product_id =$hasil->prodId;
				$drop->discount =$hasil->discount;
				$drop->qty =$hasil->qty;
				$drop->total = $hasil->total;
				$drop->deskripsi = $hasil->desc;
				$drop->status ='O';
				$drop->tgl_order = R::isoDateTime();
				$drop->mocup= $hasil->img;
				$drop->type= $hasil->type;
				$bean = R::store($drop);
				if($bean){
					$arr['error'] =false;
					$arr['code'] =100;
					$arr['message'] ='simpan data berhasil..';
					}else{
						$arr['error'] =true;
						$arr['code'] =200;
						$arr['message'] ='Gagal simpan data..';
					}
			}
		}catch (Exception $e) {
			$arr['code']=204;
			$arr['error']='true';
			$arr['message']=$e->getMessage();
		}
		echo json_encode($arr);	
		}
	
	// Send Message
	
	// Function System 
	public function sys_user_monitoring($table){
		R::setStrictTyping(false);
		$data = array();
		$bean = R::dispense($table);
		
		$MAC = exec('getmac'); 
		$MAC = strtok($MAC, ' '); 
		
		$host = exec('hostname');
		$ips = trim($host); //remove any spaces before and after
		
		$command="/sbin/ifconfig eth0 | grep 'inet addr:' | cut -d: -f2 | awk '{ print $1}'";
		$localIP = exec ($command);	
		
		$hasil ='';
		if($this->win_os()){
			$hasil = $this->win_os();
		}else {
			$hasil=$this->unix_os();
		}
		$data['Mac'] = $MAC;
		$data['host'] = $host;
		$data['ipAddress'] = $hasil;
		$data['sysinfo'] = $this->sys_get_info();
		if($this->input->post())
		{
			$cek = R::findOne('n_web_monitoring','macaddress =?',array($MAC));
			if(!$cek){
			foreach ($this->input->post() as $column => $value) {
					$bean->$column = $value;
					}
					$bean->ipaddress =$hasil;
					$bean->devices =$host;
					$bean->macaddress =$MAC;
					$bean->sysinfo =$this->sys_get_info();
					$id = R::store($bean);
			}else{
				foreach ($this->input->post() as $column => $value) {
					$cek->$column = $value;
					}
					$cek->ipaddress =$hasil;
					$cek->devices =$host;
					$cek->macaddress =$MAC;
					$cek->sysinfo =$this->sys_get_info();
					$id = R::store($cek);
			}
		}
		echo json_encode($data);		
		}	
	private function GetClientMac(){
		$macAddr=false;
		$arp=`arp -n`;
		$lines=explode("\n", $arp);

		foreach($lines as $line){
			$cols=preg_split('/\s+/', trim($line));

			if ($cols[0]==$_SERVER['REMOTE_ADDR']){
				$macAddr=$cols[2];
			}
		}

		return $macAddr;
		}
	private function ipCheck() {
		$ip='';
		if (getenv('HTTP_CLIENT_IP')) {
			$ip= getenv('HTTP_CLIENT_IP');
		}
		elseif (getenv('HTTP_X_FORWARDED_FOR')) {
			$ip .= getenv('HTTP_X_FORWARDED_FOR');
		}
		elseif (getenv('HTTP_X_FORWARDED')) {
			$ip = getenv('HTTP_X_FORWARDED');
		}
		elseif (getenv('HTTP_FORWARDED_FOR')) {
			$ip = getenv('HTTP_FORWARDED_FOR');
		}
		elseif (getenv('HTTP_FORWARDED')) {
			$ip = getenv('HTTP_FORWARDED');
		}
		else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
		}
	private function win_os(){ 
		ob_start();
		system('ipconfig | findstr /C:Address');
		$mycom=ob_get_contents(); // Capture the output into a variable
		ob_clean(); // Clean (erase) the output buffer
		$findme = "Physical";
		$pmac = strpos($mycom, $findme); // Find the position of Physical text
		$mac=substr($mycom,($pmac+39),16); // Get Physical Address

		return $mac;
		}
	
	private function unix_os(){
		ob_start();
		system('ifconfig -a');
		$mycom = ob_get_contents(); // Capture the output into a variable
		ob_clean(); // Clean (erase) the output buffer
		$findme = "Physical";
		//Find the position of Physical text 
		$pmac = strpos($mycom, $findme); 
		$mac = substr($mycom, ($pmac + 37), 18);
		
		return $mac;
    	}	
	private function sys_get_info(){
		$names = php_uname();
		$names .= PHP_OS;
		return $names;
		}
	// sitemaps create
	public function sitemaps(){
		$data=array();
		try{
				$q=R::getALL('SELECT a.id,a.date,s.short_link,s.url FROM w_post_artikel a inner join m_seo s ON s.id=a.link_id');
					foreach($q as $h){$data['blog'][]=$h;}

				$s=R::getALL('SELECT a.id,s.url FROM w_post_kategory a inner join m_seo s ON s.id=a.link_id WHERE a.product="Y"');
						foreach($s as $h){$data['services'][]=$h;}	

				$s=R::getALL('SELECT mn.id,se.url FROM m_menu mn INNER JOIN m_seo se ON se.id=mn.link_id');
						foreach($s as $h){
							$data['menu'][]=$h;
							$s=R::getALL('SELECT ms.id,se.url FROM m_submenu ms INNER JOIN m_seo se ON se.id=ms.link_id WHERE ms.menu_id=?',array($h['id']));
								foreach($s as $hh){
									$data['submenu'][]=$hh;
								}	
						}	

				$data['date']=R::isoDateTime();
				}catch (Exception $e)
					{
						$data['error'] = $e->getMessage();
					}
				//var_dump($data);
				$this->load->view('sitemap',$data);
				
		}
}
?>
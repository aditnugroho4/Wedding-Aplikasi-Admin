<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// Index session ......1
// Page Menu ..........2
// CRUD ...............3
// Datatable View .....4
// Tools ..............5 
// Json Search ........6

class Admin extends CI_Controller {
	private $Auth;
	public function __construct(){
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

	public function index($link=null){

				if($link==null) {
					$link = 'admin-menu-dashboard-html-h_dashboard_manager';
					}
				$role = R::findOne('m_role', 'id = ?', array($this->Auth['role']));
				$this->ceksession($this->Auth['user']);
				$this->page($link);

		}
	// function Load View 
	public function page($content=null){
		if($content==null){
				$content = R::load('n_submenu',base64_decode($this->input->get('mod')))->link_submenu;
			}else if($this->input->get('mod')) {
				$content = base64_decode($this->input->get('mod'));
			}
		$data=array('title'=>'Dashboard | Back End',
						'content'=>str_replace('-','/',$content),
						//'topnav' => $this->getTopnav($this->Auth['unit'],''),
						'sidebar' => $this->get_json_sidebar($this->Auth['unit']),
						'user'=>R::load('m_user',$this->Auth['user']),
						'role'=>R::load('m_role',$this->Auth['role']),
						'unit'=>R::load('m_unit',$this->Auth['unit'])
					);
		$this->layout->admin('admin/layout/content',$data);		
		}


	// End 

	// Function konfiq Menu Utama
	private function get_json_sidebar($parent){
		$arr = array();
			try{
				$sql =R::getAll("SELECT * FROM n_menu WHERE unit_id='".$parent."' AND status='Y' ORDER BY urut ASC;");
				foreach($sql as $key=>$value){
					$query ="SELECT * FROM n_submenu WHERE menu_id='".$value['id']."'AND role_id='".$this->Auth['role']."' AND active='Y' ORDER BY urutan";
					$sql2 =R::getAll($query);
					$sub = array();
					foreach($sql2 as $i=>$val){							
						$sub[]=array('id'=>$val['id'],
								'label'=>$val['nama_submenu'],
								'link'=>site_url('admin/page')."?mod=".base64_encode($val['id'])."&route=".base64_encode($val['menu_id']));
							}
						$arr['menu'][]=array('id'=>$value['id'],
									'label'=>$value['nama_menu'],	
									'tag'=>$value['tag_link'],										
									'icon1'=>$value['material_icon'],
									'icon2'=>$value['fonts_icon'],'submenu'=>$sub,
									'lbl_count'=>R::count("n_submenu","menu_id= ? AND role_id=? AND active=?",array($value['id'],$this->Auth['role'],'Y'))
								);
						}				
				}catch (Exception $e) {
					$arr['error'] =true;
					$arr['code'] =201;
					$arr['message'] =$e->getMessage();
					}
				return($arr);
				//var_dump($arr);
			}

	public function create_menu($id) {
		$ret = array();
		R::setStrictTyping(false);
		try {
			if ($this->input->post()) {
				$cekpoint = R::findOne('n_menu', "unit_id= ?", array($id));
				if (!$cekpoint) {
					$value = '';
					$menu = array("Data Master", "Main Menu", "Report", "Pengaturan");
					for ($i = 0; $i < 4; $i++) {
						$web = R::dispense('n_menu');
						$value = $menu[$i];
						$web->unit_id = $id;
						$web->nama_menu = $value;
						$web->tag_link = '#'.preg_replace('/\s+/', '', $value);
						$web->status = 'Y';
						$web->urut += 1;
							if ($value == 'Data Master') {
								$web->material_icon = 'dns';
								$web->fonts_icon = 'fas fa-server';
							}
							if ($value == 'Main Menu') {
								$web->material_icon = 'apps';
								$web->fonts_icon = 'fas fa-desktop';
							}
							if ($value == 'Report') {
								$web->material_icon = 'store_mall_directory';
								$web->fonts_icon = 'fas fa-poll';
							}
							if ($value == 'Pengaturan') {
								$web->material_icon = 'settings_input_component';
								$web->fonts_icon = 'fas fa-tools';
							}
						//$web->class2 ="aria-expanded='false'  data-toggle='collapse'";
						//$web->class3 ="collapse list-unstyled";
						R::store($web);
					}
					$ret['error'] = false;
					$ret['code'] = '200';
					$ret['message'] = 'Data Berhasil Di simpan..!';
				} else {
					$ret['error'] = true;
					$ret['code'] = '100';
					$ret['message'] = 'Gagal saat cek point Menu..! Atau Data Sudah Ada..';
				}
			} else {
				$ret['error'] = true;
				$ret['code'] = '101';
				$ret['message'] = 'Gagal saat Mengirim Data..!';
			}
		} catch (Exception $e) {
			$ret['error'] = true;
			$ret['code'] = '102';
			$ret['message'] = $e->getMessage();
		}
		echo json_encode($ret);
		}

	public function create_username($table){
		R::setStrictTyping(false);
		$arr = array();
		try
			{
			if($this->input->post()){
				$bean = R::dispense($table);
				$cek = R::findOne('m_user','username=?',array($this->input->post('username')));
					if (!$cek){
						foreach ($this->input->post() as $column => $value)
							{
								$bean->$column = $value;
							}
						$id = R::store($bean);
						if($id){
							$ret['error'] =false;
							$ret['code'] =200;
							$ret['message'] ="Create Username Success..";
						}else {
							$ret['error'] =true;
							$ret['code'] =100;
							$ret['message'] ="System Error...";
						}
					}else{
						$ret['error'] =true;
						$ret['code'] =201;
						$ret['message'] ="Username Sudah Digunakan..";
					}
					
				}
		}
		catch (Exception $e)
			{
				$ret['error'] =true;
				$ret['code'] =101;
				$ret['message'] =$e->getMessage();
			}
		echo json_encode($arr);
		}	

	// End Menu Konfigurasi //

	// function Tool's //
	
	private function add_log($action){
			R::setStrictTyping(false);
			$log = R::dispense('m_log');
			$user = R::load('m_user',$this->Auth['user']);
			$log->user_id = $user->id;
			$log->ipaddress = $user->ipaddress;
			$log->action = $action;
			$log->date = date("Y-m-d H:i:s");
			R::store($log);
		}	

	public function ceksession($id){
			$user = R::load('m_user',$id);
			$user->auth ='Y';
			$user->ipaddress = $this->Auth['ipaddress'];
			$user->date = date("Y-m-d H:i:s");
			R::store($user);
	}		
		
	// End 

	// CRUD
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
						if($id){
							$arr['code']='200';
							$arr['error']=false;
							$arr['message']='berhasil..';
							$arr['id']=$id;
						}else{
							$arr['code']='100';
							$arr['error']=true;
							$arr['message']='System faild...';
							$arr['id']=$id;
						}
						
				}else{
					$arr['code']='101';
					$arr['error']=true;
					$arr['message']='System faild...';
					$arr['id']=$arr['id'];
				}		
		}
		catch (Exception $e) {
			$arr['code']='102';
			$arr['error']=true;
			$arr['message']=$e->getMessage();
			$arr['id']=$arr['id'];
		}
		echo json_encode($arr);
		$this->add_log('CREATE Data Ke Table (' . $table . ') Dengan ID ' . $arr['id'] .' Dan Value ('. $bean.')');
	}
	// END \\
	private function get_json_navbar($parent,$hasil){
				$sql="SELECT * from n_submenu where role_id='".$parent."'";
				ini_set('memory_set',-1);
				$w = $this->db->query($sql);
				$hasil .="<ul class='section menu'>";
					foreach($w->result() as $h)
						{	$hasil.="<ul class='".$h->class."'>";
							$hasil .= "<li><a class='menuitem'>".$h->nama_submenu."</a>";
							$hasil.="<ul class='".$h->class."'>";
							$wa= $this->db->query("SELECT * from n_leftmenu where submenu_id='".$h->id."'");
								foreach($wa->result() as $ha)
									{
										$hasil .= "<li><a href=".site_url('admin/'.str_replace('/','-',$ha->link))."> ".$ha->nama."</a><ul>";
										$hasil .= "</li>";
									
									}
									$hasil .= " </ul></li></ul>";
						}	
		var_dump($hasil);		
		//return $hasil;
		}
	public function json_search_data(){
			R::setStrictTyping(false);
			$data=array();
			try{
				$table = $this->input->get('table');
				$aColumns = explode(',', $this->input->get('columns'));
				$sWhere = "";
					if ($this->input->get('aSearch') !== false && $this->input->get('aSearch') != "" )
					{
						$sWhere = "(";
						for ( $i=0 ; $i<count($aColumns) ; $i++ )
						{
							if ($aColumns[$i] != "") {
								$sWhere .= "".$aColumns[$i]." LIKE '%".R::$adapter->escape( $this->input->get('aSearch') )."%' OR ";
							}
						}
						$sWhere = substr_replace( $sWhere, "", -3 );
						$sWhere .= ') ORDER BY NOMR DESC LIMIT 0,2';
						$MySql ='Select * from '.$table.' Where '.$sWhere.';';
									$q=mysql_query($MySql);
									while($arr=mysql_fetch_array($q))
									{
									array_push( $data,$arr );
									}
						echo json_encode($data);	
					}
					
				}
			catch(Exception $e) 
					{
						echo $e->getMessage();
					}
		}		
	
	public function cek_captcha(){
			$word =$this->input->get('idcap');
			$expiration = time()-70;
			$sql = mysql_query("SELECT * FROM tb_captcha WHERE word='".$word."'");
			$query =mysql_fetch_array($sql);
			$msg="";
			if ($query > 0)
			{
				$msg='<div class="valid" style="float:left; font-size:6px; height:40px; padding:2px 2px;">Security Code Benar</div>';
				echo ($msg);
			}
			else
			{
				$msg='<div class="error" style="float:left; font-size:6px;  height:40px; padding:2px 2px;">Security Code Salah</div>';
				echo($msg);
				return;
			}
			$this->db->query("DELETE FROM tb_captcha WHERE captcha_time < ".$expiration);
		}
	public function get_captcha(){
			$CI = get_instance();
			$this->load->helper(array('captcha'));
			$captcha = create_captcha(array(
				'word'        => strtoupper(substr(md5(time()), 0, 6)),
				'img_path'=> './asset/captcha/',
				'img_url'=> base_url().'/asset/captcha/',
				'img_width'=> '150',
				'img_height'=> 50,
				'expiration'=>90,
			));
			if($captcha)
			{
				$data=array(
							'captcha_time'=>$captcha['time'],
							'ip_address'=>$this->input->ip_address(),
							'word'=>$captcha['word'],);
							$expiration = time()-90;
							$this->db->query("DELETE FROM tb_captcha WHERE captcha_time < ".$expiration);
							$query=$this->db->insert_string('tb_captcha',$data);
							$this->db->query($query);
			}
			else
			{
				return"captcha not work";
			}
			$CI->session->set_userdata(array('captchasecurity'  => strtoupper(substr(md5(time()), 0, 6))));
			return $captcha['image'];
		}
	public function delete_captcha(){
			$filename= array();
			if ($handle = opendir('./asset/captcha/')) 
			{
			while (false !== ($entry = readdir($handle))) 
				{
					if ($entry != "." && $entry != "..")
					{
						unlink('./asset/captcha/'.$entry);  
					}
				}
				closedir($handle);
			}	
		}	
	public function get_data_table_source() {
			// var_dump($this->input->get());
			// R::debug(true);		
			$table = $this->input->get('table');
			//Fild tertentu yang di select untuk di tampilakn 
			$fildjoins=$this->input->get('fildjoins');
			$filds = array();
			if ( $this->input->get('filds')) {
				$filds = explode(',',  $this->input->get('filds'));
			}
			$aColumns = explode(',', $this->input->get('columns'));
			
			$joins = array();
			if ($this->input->get('joins')) {
				$joins = explode(',', $this->input->get('joins'));
			}
			$exports = array("");
			if ($this->input->get('exports')) {
				$exports = explode(',', $this->input->get('exports'));
			}
				$select = array("");
			if ($this->input->get('select')) {
				$select = explode(',', $this->input->get('select'));
			}
			// var_dump($joins);
			/* 
			* Paging
			*/
			$sLimit = "";
			if ($this->input->get('iDisplayStart') !== false && $this->input->get('iDisplayLength') != '-1' )
			{
				$sLimit = "LIMIT ".R::$adapter->escape( $this->input->get('iDisplayStart') ).", ".
					R::$adapter->escape( $this->input->get('iDisplayLength') );
			}		
			/*
			* Ordering
			*/
			$sOrder = "";
			if ($this->input->get('iSortCol_0') !== false)
			{
				$sOrder = "ORDER BY  ";
				for ( $i=0 ; $i<intval( $this->input->get('iSortingCols') ) ; $i++ )
				{
					if ( $this->input->get( 'bSortable_'.intval($this->input->get('iSortCol_'.$i)) ) == "true" )
					{
						$sOrder .= "".$aColumns[ intval( $this->input->get('iSortCol_'.$i) ) ]." ".
						R::$adapter->escape( $this->input->get('sSortDir_'.$i) ) .", ";
					}
				}
				
				$sOrder = substr_replace( $sOrder, "", -2 );
				if ( $sOrder == "ORDER BY" )
				{
					$sOrder = "";
				}
				
			}		
			/* 
			* Filtering
			* NOTE this does not match the built-in DataTables filtering which does it
			* word by word on any field. It's possible to do here, but concerned about efficiency
			* on very large tables, and MySQL's regex functionality is very limited
			*/
			$sWhere = "1";
			if ($this->input->get('sSearch') !== false && $this->input->get('sSearch') != "" )
			{
				$sWhere = "(";
				for ( $i=0 ; $i<count($aColumns) ; $i++ )
				{
					if ($aColumns[$i] != "") {
						$sWhere .= "".$aColumns[$i]." LIKE '%".R::$adapter->escape( $this->input->get('sSearch') )."%' OR ";
					}
				}
				$sWhere = substr_replace( $sWhere, "", -3 );
				$sWhere .= ')';
			}		
			//Kondisi fild yang di filter yang di select untuk di tampilakan\\
			//contoh* WHERE nama='?'\\
			$jwhere = array("");
			if ($this->input->get('jwhere')) {
			$jwhere = explode(',', $this->input->get('jwhere'));
			}
			$var = array();
			if ($this->input->get('var')) {
				$var = explode(',', $this->input->get('var'));
			}
			$sql = " FROM $table";
			for ($i = 0; $i < count($joins); $i++) {
				$sql .= "," . $joins[$i];
			}
			$sql .= " WHERE";
			for ($i = 0; $i < count($joins); $i++) {
				$sql .= " " . $jwhere[$i] . " = " . $joins[$i] . ".id AND";
			}
			for ($i = 0; $i < count($filds); $i++) {
				$sql .= " " .$filds[$i] . "='".$var[$i]."' AND";
			}
			if ($this->input->get('cVoid')) {
				$sql .= " 1 AND ($sWhere) ".$this->input->get('cVoid');
			}else{
				$sql .= " 1 AND ($sWhere)";
			}		
			//echo ($sql);
			$output = array(
				'sEcho' => intval($this->input->get('sEcho')),
				'iTotalRecords' => R::count($table),
				'iTotalDisplayRecords' => R::getCell("SELECT count(*) $sql")
			);
			$sql .= " $sOrder $sLimit ";
			$rows = R::getAll("SELECT $table.*$fildjoins $sql ");
			//echo ($rows);
			$beans = R::convertToBeans($table,$rows);
			$schema = R::$duplicationManager->getSchema();
			R::$duplicationManager->setTables($schema);
			// var_dump($exports);
			//echo ($beans);
			$expBeans = R::exportAll($beans, true, $exports);
			
			$i = 0;
			if ($this->input->get('iDisplayStart')) {
				$i = intval($this->input->get('iDisplayStart'));
			}
			foreach ($expBeans as $key => $value) {
				$expBeans[$key]['no'] = ++$i;
			}
			$output['aaData'] = $expBeans;
			echo json_encode($output);
		}
	public function get_editable_select(){
			R::setStrictTyping(false);
			$table = $this->input->get('table');
			$select = $this->input->get('select');
			$filds = $this->input->get('filds');
			$res = R::findAll($table);
			$ret = array();
			foreach ($res as $key => $value) {
				$ret[$value['id']] = $value[$filds];
			}
			$ret['selected'] = $select;
			echo json_encode($ret);
		}
	public function update($table) {
			$ret = array();
			R::setStrictTyping(false);			
			try{	
				$id = $this->input->post('id');
				$email ='';
				if($this->input->post()){
					$bean = R::load($table, $id);
					foreach ($this->input->post() as $column => $value){
							$bean->$column = $value;
							
							if($column == 'email'){
							$email = $value ;
							}
						}
							$id = R::store($bean);
							if($email){
							$to = $this->input->post('password');
							$name = $this->input->post('nama');
							$pass = $this->input->post('email');
							$this->send_email($to,$name,$pass);
							}
							$ret['error'] =false;
							$ret['code'] =100;
							$ret['message'] ='Update Berhasil...'.$id;
					}else{
						$ret['error'] =true;
						$ret['code'] =101;
						$ret['message'] ='Gagal System..';
				}
			}catch (Exception $e)
					{
						$ret['error'] =true;
						$ret['code'] =103;
						$ret['message'] =$e->getMessage();
						R::rollback();
					}
			echo json_encode($ret);	
			$this->add_log('Melakukan Update Ke Table (' . $table . ') Dengan ID ' . $id . ' SET ' . $column . ' = ' . $value);
		} 
	
	public function update_grid($table) {
			R::setStrictTyping(false);
			$id = $this->input->post('id');
			$value = $this->input->post('value');
			list($column, $id) = explode('-', $id);
			$bean = R::load($table, $id);
			if (strpos($column, '_id') === false) {
				$bean->$column = $value;
				} else 
				{
				$column = substr($column, 0, strpos($column, '_id'));
				$bean->$column = R::load($this->input->get('table'), $value);
				}
			R::store($bean);
			$this->add_log('Update Data ke table (' . $table . ') ID ' . $id . ' SET ' . $column . ' = ' . $value.' Melalui DataGrid');
		}	
	public function delete($table, $id) {
			$bean = R::load($table, $id);
			R::trash($bean);

			$this->add_log('DELETE ' . $table . ' ID ' . $id);
		}
		
	public function create_data_pegawai($table){
			R::setStrictTyping(false);
			$id ='';
			$arr = array();
			$bean = R::dispense($table);
			if($this->input->post())
			{
				$cekpoint = R::findOne($table,'nik=?',array($this->input->post('nik')));
				if(!$cekpoint){
					foreach ($this->input->post() as $column => $value) {
						$bean->$column = $value;
						}
					$id = R::store($bean);
					$arr['id']= $id;
					$arr['error']= false;
					$this->add_log('CREATE ' . $table . ' ID ' . $id .' Berhasil Menyimpan Data Pegawai');
				}else {
				$arr['error']= true; 	
				$arr['lbl']= "ada kesamaan data pada no identitas"; 	
				$this->add_log('CREATE ' . $table . ' ID ' . $id .' Gagal Menyimpan Data Pegawai');	
				}
			}
			echo json_encode($arr);
		}
	public function update_data_pegawai($table) {
			R::setStrictTyping(false);
			$id ='';
			$arr = array();
			//$bean = R::dispense($table);
			if($this->input->post())
			{
				$cekpoint = R::findOne($table,'employ_id=? AND nik=?',array($this->input->post('employ_id'),$this->input->post('nik')));
				if($cekpoint){
					foreach ($this->input->post() as $column => $value) {
						$cekpoint->$column = $value;
						}
					$id = R::store($cekpoint);
					$arr['id']= $id;
					$arr['error']= false;
					$this->add_log('CREATE ' . $table . ' ID ' . $id .' Berhasil Menyimpan Data Pegawai');
				}else {
				$arr['error']= true; 	
				$arr['lbl']= "ada kesamaan data pada no identitas"; 	
				$this->add_log('CREATE ' . $table . ' ID ' . $id .' Gagal Menyimpan Data Pegawai');	
				}
			}
			echo json_encode($arr);
		}
	public function load_from_Update_pegawai($table,$id){
			$cekpoint = R::findOne($table,'employ_id=?',array($id));
			if($cekpoint)
			{
				echo json_encode($cekpoint->export());
			}
			
		}
	public function aktive($table,$fild,$id,$value){
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
			$this->add_log('ACTION USER ' . $table . ' ID ' . $id .' '.$fild.' '.$value);
		}	
	public function get_json_config($table){
			R::setStrictTyping(false);
			$cookie=$this->input->get('cookie');
			$cashiers = R::findAll($table);
			$cashiers = R::exportAll($cashiers, true, array(""));
			$ret = array(
				'cookies' => $this->input->cookie($cookie),
				'listKasir' => $cashiers
			);
			echo json_encode($ret);
			$this->add_log('SETTING COOKIE ' . $table . ' ID VALUE ' . $cookie);
		}	
		
	public function save_config($cookie,$val){
			if ($cookie != "null") {
				delete_cookie('poli');
				delete_cookie('Loket');
				delete_cookie('Kasir');
				$this->input->set_cookie($cookie, $val, '2592000');
			}else{
				delete_cookie('poli');
				delete_cookie('Loket');
				delete_cookie('Kasir');
			}
			$this->add_log('SETTING COOKIE ' . $cookie . ' ID VALUE ' . $val);

		}
	public function multi_select(){
		$table = $this->input->get('table');
		$select='';
		$MySql ='';
			try{	
				if ($this->input->get('select')) {
					$select ='Where '.$this->input->get('select').'='.$this->input->get('id');
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
	public function multi_select_2(){
		$table = $this->input->get('table');
		$select = array("");
			if ($this->input->get('select')) {
				$select = explode(',', $this->input->get('select'));
				}
			$sql = "";	
			$var = array();
				if ($this->input->get('val')) {
						$sql .='WHERE';
						$var = explode(',', $this->input->get('val'));
						for ($i = 0; $i < count($select); $i++) {
							$sql .= " " .$select[$i] . "='".$var[$i]."' AND";
						}
						$sql .=' (1)';
					}
				$MySql = "SELECT * FROM $table ".$sql;
				//echo($MySql);
				$data=array();
				if(!empty($MySql))
				{
					$q=R::getALL($MySql);
					foreach($q as $h)
					{
							array_push( $data,$h);
					}
					
				}
			echo json_encode($data);
			}	

	public function autonumber($tabel,$lebar){
				$query="select count(*) as ctgr from $tabel";
				$nomor=0;
				$hasil=mysql_query($query);
				$jumlahrecord= mysql_fetch_assoc($hasil);
				if(!$jumlahrecord['ctgr']== 0){
						$nomor=$jumlahrecord['ctgr']+1;
					}
					else
					{
						$row=mysql_fetch_assoc($hasil);
						$nomor=$row['ctgr']+1;
					}
					$angka=str_pad($nomor,$lebar,"0",STR_PAD_LEFT); 
				echo json_encode($angka);
		}


	// End
	public function uploads($table,$id,$folder,$columns){
			$path = str_replace('-','/',$folder);
			$arr= array();
			$echo='';
			try
			{
				R::setStrictTyping(false);
				if (!empty($id))
				{
					$allowedExts = array("pdf","gif", "JPEG","jpeg","JPG", "jpg", "png");
					$temp = explode(".", $_FILES["file"]["name"]);
					$extension = end($temp);
					if ((($_FILES["file"]["type"] == "application/pdf")||
							($_FILES["file"]["type"] == "image/gif") ||
							($_FILES["file"]["type"] == "image/jpeg") || 
							($_FILES["file"]["type"] == "image/JPEG") || 
							($_FILES["file"]["type"] == "image/jpg") ||
							($_FILES["file"]["type"] == "image/JPG") || 
							($_FILES["file"]["type"] == "image/pjpeg") ||
							($_FILES["file"]["type"] == "image/x-png") || 
							($_FILES["file"]["type"] == "image/png"))
							&& ($_FILES["file"]["size"] < 500000) && in_array($extension, $allowedExts))
							{
							if ($_FILES["file"]["error"] > 0) 
							{
								$arr['upload']= "Return Code: " . $_FILES["file"]["error"] . "<br>";
							} else {
								$filename =$_FILES["file"]["name"];
								$echo .= "Upload: " . $_FILES["file"]["name"] . "<br>";
								$echo .= "Type: " . $_FILES["file"]["type"] . "<br>";
								$echo .= "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
								$echo .= "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";
								
								$file_basename = substr($filename, 0, strripos($filename, '.')); // strip extention
								$file_ext = substr($filename, strripos($filename, '.')); // strip name
								$fileurl=str_replace(base_url(),'.',$path);
								$unit = R::load('m_unitinstalasi',$this->Auth['subunit'])->code;
								$newfilename =  $unit.".".$id.$file_ext;
								$echo="";
								$foto = R::load($table,$id);
								if (file_exists($fileurl.$newfilename)) {
									unlink($fileurl.$newfilename);
									move_uploaded_file($_FILES["file"]["tmp_name"],$fileurl . $newfilename);
									$echo = "Stored in: " . $path . $newfilename;
									if($foto){
										$foto->$columns = $newfilename;
										$id = R::store($foto);
									}else {$id ="error";}
								}else {
									move_uploaded_file($_FILES["file"]["tmp_name"],$fileurl . $newfilename);
									if($foto){
										$foto->$columns = $newfilename;
										$id = R::store($foto);
									}else {$id ="error";}
									$echo = "Stored in: " . $path . $newfilename;
								}
								if($id)
									{
										$arr['error']=false;
										$arr['id']= $id;
										$arr['path']= $echo;
										$arr ['lbl']='Upload Foto Berhasil..';
										
									}else{
										$arr['error']=true;
										$arr['lbl']='Upload Foto Gagal..!!';
									}
								}
							}else {
								$arr['error']=false;
							} 
					}else {
						$arr['error']=true;
					}
				} catch (Exception $e) {
					echo $e->getMessage();
					R::rollback();
				}
				echo json_encode($arr);
			}
	
	public function json_get_data_user(){
			$arr=array();
			try
			{ R::setStrictTyping(false);
					$pegawai = R::load('m_datapegawai',base64_decode($this->input->get('data')));
					$pribadi = R::findOne('m_datapribadi','employ_id = ?',array($pegawai->id));
					if ($pegawai) {
						$arr['pegawai'] = $pegawai->export();
					}
					if ($pribadi) {
						$arr['pribadi'] = $pribadi->export();
					}
			}catch (Exception $e)
			{
				$arr['error'] = true;
			}
			echo json_encode($arr);
		}
	public function set_file_vocal(){
			$imageList = array();
			$data = array();
			if ($handle = opendir('vocal')) 
			{
			while (($entry = readdir($handle)) !== FALSE) {
				if ($entry != "." && $entry != "..") {
					$imageList[] = $entry;
				foreach ($imageList as $key => $value) {
						$data[$key]['vocal'] =  $value ;
						}
						
					}
				}
				closedir($handle);
				echo json_encode($data);
			}
		}
	public function get_message(){
			$this->load->view('admin/menu/support/html/h_msg_error');
		}
	public function ganerateVocal($val){
				$query="select count(*) as vocal from m_vocal where nomor like '%".$val."%'";
				$hasil=mysql_query($query);
				$jumlahrecord= mysql_fetch_assoc($hasil);
				$nomor='';
				if(!$jumlahrecord['vocal']== 0){
					$nomor = $jumlahrecord['vocal']+1;
					}else
					{
					$nomor = 1;
					}
				echo json_encode($val.str_pad($nomor,3,"0",STR_PAD_LEFT));
		}
	public function report_pendaftaran($dateStart, $dateEnd,$idLoket){
			//$data=array();
			$arrData = R::getAll(
				"
				SELECT
					m_datapasien.*,
					p_pendaftaran.nama_loket,
					p_pendaftaran.`date`,
					p_pendaftaran.`cekin`,
					p_pendaftaran.trx_id,
					p_pendaftaran.pasien_id,
					p_pendaftaran.stsbayar,
					p_pendaftaran.stspasien,m_user.nama as name
				FROM
					m_datapasien,
					p_pendaftaran,
					m_user
				WHERE
					m_datapasien.id=p_pendaftaran.pasien_id AND m_user.id=p_pendaftaran.user_id AND
					p_pendaftaran.`date` BETWEEN ? AND ? AND p_pendaftaran.loket_id = ?
				", array($dateStart ." 00:00:00", $dateEnd . " 23:59:59",$idLoket)
			);
			//$data = $arrData;
			//echo json_encode();
			$this->load->view('loket/print/lap_pendaftaran',array('start'=>$dateStart,'end'=>$dateEnd,'data'=>$arrData,'nmaLoket'=>R::load('m_loket',$idLoket)->name));
		}
	public function CreateCode($table,$keter){
			if($table !=null)
			{
			$id =0;
			$no =0;
			R::setStrictTyping(false);	
			$MySql = 'Select * from '.$table.';';
				$data=array();
				if(!empty($MySql))
				{
					$query=$MySql;
					$q=mysql_query($query);
							while($arr=mysql_fetch_object($q))
							{
									//$qt = mysql_query('Select * from '.$table.' WHERE kat_id = '.$arr->kat_id.';');
									//$num_rows = mysql_num_rows($qt);
									// while($arrs = mysql_fetch_object($qt)){
									//	for ($x = 1; $x <= $num_rows; $x++){ 
										//	echo ($arrs->nama);
											$value = R::load($table,$arr->id);
											if($value->code == null){
											$code = R::load($keter, $value->kat_id);	
											$value->code = $code->code.".".str_pad($arr->id, 4, '0', STR_PAD_LEFT);
											$id = R::store($value);
											}
									//	}
							}
					echo json_encode($id);
				}	
			}else{
				echo ('error');
			}
		}
	public function SimpanDataKir (){
			$ret = array();
			$id = 0;
			R::begin();
				try 
					{
					R::setStrictTyping(false);
					$data = $this->input->post('data');
					$data = str_replace("^",".",$data);
					$data = str_replace("-","+",$data);
					$data = str_replace("_","/",$data);
					$hasil = json_decode(base64_decode($data));
					$date = R::isoDateTime();
			foreach ($hasil->dataTable as $key => $value) 
						{
							
							$cek = R::findOne('m_inventory','serialnumber=?', array($value[3]));
							if(!$cek){
									$detail = R::dispense('m_inventory');
									$detail->code = $value[1];
									$detail->nama = $value[2];
									$detail->serialnumber = $value[3];
									$detail->spesifikasi = $value[4];
									$detail->kondisi = $value[5];
									$detail->qty = $value[6];
									$detail->ukuran = $value[7];
									$detail->bahan = $value[8];
									$detail->thnperolehan = $value[9];
									
									if($value[10]){
									$detail->ruangan = $value[10];
									}
									$detail->instalasi_id =$value[11];
									$detail->user_id = $value[12];
									
									$detail->tanggal = $date;
									$id = R::store($detail);		
								}else
								{
									$cek->kondisi = $value[1];
									$cek->qty += $value[6];	
									$cek->tanggal = $date;
									$id = R::store($cek);	
								}
						$ret['id']= $id;		
					}
					R::commit();
					}catch (Exception $e)
					{
						echo $e->getMessage();
						R::rollback();
					}
				echo json_encode($ret);
		}
	public function countNumber(){
		$table=$this->input->post('tbl');
		$length=$this->input->post('length');
		R::setStrictTyping(false);
		$query = R::count($table);
		$nomor = $query;
		if($nomor){
				echo (str_pad($nomor, $length, '0', STR_PAD_LEFT));			
					}
				else{
					echo (str_pad($nomor, $length, '0', STR_PAD_LEFT));
				}
		}	
	public function get_process_poli($id){
			$arr=array();
			try
			{ R::setStrictTyping(false);
					$daftar= R::load('p_pendaftaran', $id);
					if ($daftar) {
						$pasien = R::getAll("SELECT * FROM m_datapasien WHERE id = ?", array($daftar->pasien_id));
						$arr['pasien']= $pasien[0];
						$arr['daftar']= $daftar->export();
						$arr['poli']= R::load('m_poli', $daftar->poli_id)->export();
						$rm = R::getAll("SELECT m_rekammedis.*,m_dokter.nama_dokter FROM m_rekammedis,m_dokter where m_dokter.id=m_rekammedis.dokter_id AND  m_rekammedis.pasien_id= ?",array($daftar->pasien_id));
						if($rm){
						$arr['medis']= $rm[0];
							$detail = R::getAll("SELECT * from m_rekammedisdetail WHERE id= ? ORDER BY no_urut DESC",array($rm[0]['id']));
						if($detail){
						$arr['medisdetail']= $detail[0];}
						}
						
					}else{
						$arr['error'] = true;
						}
				
			}catch (Exception $e)
			{
				$arr['error'] = true;
			}
			echo json_encode($arr);
		}	
	public function CekUser($user){
				$arry = array();
				try
				{
					$neangan = R::findOne('m_user','username=?',array($user));
					if ($neangan)
					{
						$arry['kapangih'] = true;
					}else {$arry['kapanggih'] = false; }
				}
				catch (Exception $e)
					{
						echo $e->getMessage();
						R::rollback();
					}
				echo json_encode($arry);
		}
	function cek_user_login() {
		R::setStrictTyping(false);
		$arr = array();
		try {
			if ($this->input->post()) {
				$user = R::load('m_user', $this->input->post('id'));
				if ($user) {
					$arr['id'] = $user->nama;
				} else {
					$arr['error'] = true;
				}
			}
			echo json_encode($arr);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
		}
	public function get_process_status($id){
			$time = date("H:i:s");
			$date = R::isoDateTime();
			$arr=array();
			try
			{ 		R::setStrictTyping(false);
						$bean = R::load('p_pendaftaran',$id);
						if ($bean) {
							$pasien =R::load('m_datapasien',$bean->pasien_id);
							$jam=substr($time, 0, 2);
							$menit=substr($time, 3, 2);
							$selisih = floor($jam - substr($bean->cekin,0, 2))." JAM ";
							$hasil= floor($menit - substr($bean->cekin, 5, 2))." Menit";
							$bean->tracert='N';
							$bean->lama_waktu=$selisih.$hasil;
							$pasien->bundel = $this->input->get('data');
							R::store($pasien);
							R::store($bean);
							$arr['error'] = false;
						}else{
							$arr['error'] = true;
							}
				
			}catch (Exception $e)
				{
					echo ('error');
				}
			echo json_encode($arr);
		}
	public function cek_alamat_pasien(){
			$arr=array();
			try{
				$rawData = R::getAll("SELECT m_datapasien.id,m_kota.namakota AS kota,
												m_provinsi.namaprovinsi AS provinsi,
												m_kecamatan.namakecamatan AS kecamatan,
												m_kelurahan.namakelurahan AS kelurahan
											FROM
												m_datapasien,
												m_kota,
												m_provinsi,
												m_kecamatan,
												m_kelurahan
											WHERE
												provinsi_id = m_provinsi.idprovinsi AND
												kota_id = m_kota.idkota AND
												kecamatan_id = m_kecamatan.idkecamatan AND
												kelurahan_id = m_kelurahan.idkelurahan and id = ? 
											", array($this->input->post('pasien_id')));
									if($rawData){	
										$rawData = $rawData[0];
										$arr=$rawData;
									}
				}catch (Exception $e)
					{
						echo ('error');
					}
				echo json_encode($arr);
		}		
	public function json_get_klarifikasi(){
				try{			
					$html='<thead><tr><th rowspan="2" class="text-center" width="60">NO</th><th colspan="1" class="text-center"><i class="fa fa-address-card"></i> JENIS ARSIP</th><th colspan="3" class="text-center"><i class="fa fa-pencil-square-o"></i> STATUS</th></tr>
																				<tr><th class="text-center">KUALIFIKASI STAF</th><th class="text-center">ADA</th><th class="text-center">TIDAK</th><th class="text-center">ACTION</th></tr></thead>';
					$html .='<tbody style="font-size:9;">';
					$detail = R::getAll("SELECT * FROM m_kualifikasi;");
						$i=1;
						if($detail){
								foreach ($detail as $key=> $value)
								{
									
									//$html .='<tr><td>'.$i++.'</td><td>'.$value['rmlama'].'</td><td>'.$value['nama'].','.$value['alias'].'</td><td>'.$value['trxid'].'</td><td>'.$value['poli'].'</td><td>'.$value['tanggal'].'</td><td>'.$value['stsbayar'].'</td><td>'.$value['dokter'].'</td><td>'.$qty.'</td><td>Rp.'.number_format($total,2).'</td><td>'.$status.'</td><td><button class="btn btn-primary btn-xs" onclick="$.print_tindakan('.$value['daftar'].')"><i class="fa fa-print"></i>&nbsp;Detail</button></td>';	
									$html .='<tr><td>'.$i++.'</td><td>'.$value['nama'].'</td><td></td><td></td><td></td>';	
									
								}
							}
						$html.='</tr></tbody>';		
					}catch (Exception $e)
						{
							echo $e->getMessage();
							R::rollback();
						}
					echo json_encode(base64_encode($html));	
		}
	public function json_search_pegawai(){
		$date = R::isoDateTime();
		$data=array();
		try{
			$aColumns = explode(',', $this->input->get('columns'));
			$sWhere = "";
			if ($this->input->get('aSearch') !== false && $this->input->get('aSearch') != "" )
				{
				$sWhere = '(';
					for ( $i=0 ; $i<count($aColumns) ; $i++ )
						{
						if ($aColumns[$i] != "") {
							$sWhere .= "".$aColumns[$i]." LIKE '%".R::$adapter->escape( $this->input->get('aSearch') )."%' OR ";
						}
					}
					$sWhere = substr_replace( $sWhere, "", -3 );
					$sWhere .= ')';
					$MySql = 'SELECT * FROM m_datapegawai WHERE '.$sWhere.'';
					//echo ($MySql);
					$data=array();
					if(!empty($MySql))
						{
						$q=mysql_query($MySql);
							while($arr=mysql_fetch_array($q))
						{
							array_push( $data,$arr );
						}		
					}
					echo json_encode($data);
					}else {echo json_encode('error');}
					return false;				
				} catch (Exception $e) {
					$data['error'] = true;
				}		
		}	
	public function json_get_user(){
		$date = R::isoDateTime();
			$data=array();
				try{
					$aColumns = explode(',', $this->input->get('columns'));
					$sWhere = "";
					if ($this->input->get('aSearch') !== false && $this->input->get('aSearch') != "" )
					{
						$sWhere = '(';
						for ( $i=0 ; $i<count($aColumns) ; $i++ )
						{
							if ($aColumns[$i] != "") {
								$sWhere .= "".$aColumns[$i]." LIKE '%".R::$adapter->escape( $this->input->get('aSearch') )."%' OR ";
							}
						}
						$sWhere = substr_replace( $sWhere, "", -3 );
						$sWhere .= ')';
						$MySql = 'SELECT u.id,u.nama,u.username,u.role_id,r.name,r.instalasi_id,i.name as instalasi FROM
								m_user u inner join 
								m_role r inner join 
								m_datapegawai dp inner join
								m_unitinstalasi i On r.id=u.role_id AND dp.id=u.employ_id AND i.id=r.instalasi_id WHERE '.$sWhere.'';
						//echo ($MySql);
						$data=array();
						if(!empty($MySql))
						{
							$q=mysql_query($MySql);
									while($arr=mysql_fetch_array($q))
									{
									array_push( $data,$arr );
									}
										
						}
						echo json_encode($data);
					}else {echo json_encode('error');}
					return false;
					
				} catch (Exception $e) {
					$data['error'] = true;
				}		
		}
	public function json_search_barang(){
				$date = R::isoDateTime();
				$data=array();
				try{
					$aColumns = explode(',', $this->input->get('columns'));
					$sWhere = "";
					if ($this->input->get('aSearch') !== false && $this->input->get('aSearch') != "" )
					{
						$sWhere = '(';
						for ( $i=0 ; $i<count($aColumns) ; $i++ )
						{
							if ($aColumns[$i] != "") {
								$sWhere .= "".$aColumns[$i]." LIKE '%".R::$adapter->escape( $this->input->get('aSearch') )."%' OR ";
							}
						}
						$sWhere = substr_replace( $sWhere, "", -3 );
						$sWhere .= ')';
						$MySql = 'SELECT * FROM m_masterbarang WHERE '.$sWhere.'';
						//echo ($MySql);
						$data=array();
						if(!empty($MySql))
						{
							$q=mysql_query($MySql);
									while($arr=mysql_fetch_array($q))
									{
									array_push( $data,$arr );
									}
										
						}
						echo json_encode($data);
					}else {echo json_encode('error');}
					return false;
					
				} catch (Exception $e) {
					$data['error'] = true;
				}		
		}
	public function json_search_stockbarang(){
				$date = R::isoDateTime();
				$data=array();
				try{
					$aColumns = explode(',', $this->input->get('columns'));
					$sWhere = "";
					if ($this->input->get('aSearch') !== false && $this->input->get('aSearch') != "" )
					{
						$sWhere = '(';
						for ( $i=0 ; $i<count($aColumns) ; $i++ )
						{
							if ($aColumns[$i] != "") {
								$sWhere .= "".$aColumns[$i]." LIKE '%".R::$adapter->escape( $this->input->get('aSearch') )."%' OR ";
							}
						}
						$sWhere = substr_replace( $sWhere, "", -3 );
						$sWhere .= ')';
						$MySql = 'SELECT * FROM m_stockbarang WHERE '.$sWhere.'';
						//echo ($MySql);
						$data=array();
						if(!empty($MySql))
						{
							$q=mysql_query($MySql);
									while($arr=mysql_fetch_array($q))
									{
									array_push( $data,$arr );
									}
										
						}
						echo json_encode($data);
					}else {echo json_encode('error');}
					return false;
					
				} catch (Exception $e) {
					$data['error'] = true;
				}		
		}	
	public function json_search_suplier(){
				$date = R::isoDateTime();
				$data=array();
				try{
					$aColumns = explode(',', $this->input->get('columns'));
					$sWhere = "";
					if ($this->input->get('aSearch') !== false && $this->input->get('aSearch') != "" )
					{
						$sWhere = '(';
						for ( $i=0 ; $i<count($aColumns) ; $i++ )
						{
							if ($aColumns[$i] != "") {
								$sWhere .= "".$aColumns[$i]." LIKE '%".R::$adapter->escape( $this->input->get('aSearch') )."%' OR ";
							}
						}
						$sWhere = substr_replace( $sWhere, "", -3 );
						$sWhere .= ')';
						$MySql = 'SELECT * FROM m_suplier WHERE '.$sWhere.'';
						//echo ($MySql);
						$data=array();
						if(!empty($MySql))
						{
							$q=mysql_query($MySql);
									while($arr=mysql_fetch_array($q))
									{
									array_push( $data,$arr );
									}
										
						}
						echo json_encode($data);
					}else {echo json_encode('error');}
					return false;
					
				} catch (Exception $e) {
					$data['error'] = true;
				}
			
		}    
	public function CetakBarcode() {
			$this->load->view('admin/print/labelbarang');
		}
	public function insert_data_maintenance(){		
			$date = R::isoDateTime();
			$ret = array();
			R::begin();
			try{
				R::setStrictTyping(false);
				$data = $this->input->post('data');
				$data = str_replace("^",".",$data);
				$data = str_replace("-","+",$data);
				$data = str_replace("_","/",$data);
				$hasil = json_decode(base64_decode($data));							
					foreach ($hasil->dataTable as $key => $value) 
							{			
								$services = R::dispense('t_dataperbaikan');
								$services->nospk = str_replace("-","",substr($date, 0, 10)).str_pad(substr($date, 17, 18), 3, '0', STR_PAD_LEFT);
								$services->nama_barang = $value[1]." (".$value[3].")";
								$services->serialnumber = $value[2];
								$services->kategory = $value[7];
								$services->kerusakan = $value[4];
								$services->kelengkapan = $value[5];
								$services->tglperbaikan = $hasil->tglPerbaikan;
								$services->tglselesai = $hasil->tglSelesai;
								$services->rekanan = $value[6];
								$services->user_id = $this->Auth['user'];
								$services->instalasi_id = $value[8];
								R::store($services);
								$ret['hasil'] =str_replace("-","",substr($date, 0, 10)).str_pad(substr($date, 17, 18), 3, '0', STR_PAD_LEFT);
							}	
					R::commit();					
				} catch (Exception $e) {
					$ret['error'] = $e->getMessage();
					R::rollback();
				}
			echo json_encode($ret);
		}
	public function print_rincian_pemeliharaan($id){
		$rincian='';
		$filter ='dp.nospk=?';
		$barang = R::getAll("SELECT d.*,us.nama as user from t_dataperbaikan d INNER JOIN m_user us ON us.id=d.user_id WHERE d.id=?",array($id));
			if($barang){
					$data = $barang[0];
					$param= array($data['nospk']);
					if($this->input->get('insid')){
						$filter .= ' AND dp.instalasi_id='.$this->input->get('insid');
						}
					$detail = R::getAll("SELECT dp.*,un.name as instalasi FROM t_dataperbaikan dp INNER JOIN m_unitinstalasi un on un.id=dp.instalasi_id WHERE ".$filter,$param);			
					if($detail){		
						$jumlah=0; 
						$rincian ='<label class="col-lg-12"><h4>RINCIAN PEMELIHARAAN</h4></label>';
						$rincian.='<div class="col-lg-12"><table class="table table-sm"><tr>
							<td style="padding:10px; width:5%;">NO</td>
							<td style="padding:10px;width:30%;">NAMA BARANG</td>
							<td style="padding:10px;width:5%;">SERIALNUMBER</td>
							<td style="padding:10px;width:5%;">KERUSAKAN</td>
							<td style="padding:10px;width:5%;">KELENGKAPAN</td>
							<td style="padding:10px;width:10%;">PENGUNA BARANG</td></tr>';
						$i=0;
						foreach ($detail as $key=> $value) 
							{	
								$rincian.='<tr><td style="padding:10px;">'.$i++.'</td>
										<td style="padding:10px;">'.$value['nama_barang'].'</td>
										<td style="padding:10px;">'.$value['serialnumber'].'</td>
										<td style="padding:10px;">'.$value['kerusakan'].'</td>
										<td style="padding:10px;">'.$value['kelengkapan'].'</td>
										<td style="padding:10px;">'.$value['instalasi'].'</td></tr>';
							}							
						$rincian.='</table></div>';
						$rincian.='<div class="col-lg-12"style ="border-top:1px solid black; margin-bottom:120px;"></div>';
						$rincian.='<div class="col-lg-12">';
						$rincian.='<label style="float:right;"><h1>(......................)</h1></label><label style="float:left;"><h1>(......................)</h1></label>';
						$rincian.='<label style="float:right;"><h1>        Mengetahui      </h1></label><label style="float:left;"><h1>        Penerima        </h1></label></div>';
					}
				$this->load->view('admin/print/p_pemeliharaan',array('data'=>$data,'rincian'=> $rincian));					
					}
					return;
		}
	public function json_get_notification(){
			$ret = array();
			$date = R::isoDateTime();
			try{
				$notif = R::count("t_komplen_masuk","tglmasuk like ? AND cancelled IS NULL AND action IS NULL OR action='P'",array(substr($date,0,7).'%'));
				$komplen = R::getAll("SELECT * FROM t_komplen_masuk WHERE tglmasuk like ? AND cancelled IS NULL AND action IS NULL OR action='P'",array(substr($date,0,7).'%'));
				$htmlPesan='<a id="notifications" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link"><i class="fa fa-bell"></i><span class="badge badge-danger">'.$notif.'</span></a>';
				$htmlPesan.='<ul aria-labelledby="notifications" class="dropdown-menu" >';	
					if($komplen){
						$htmlPesan.='<li><a rel="nofollow" href="#" class="dropdown-item"> 
									<div class="notification d-flex justify-content-between">
									<div class="notification-content"><i class="fa fa-envelope"></i>'.$notif.' Komplen Masuk </div>
									<div class="notification-time"><small>'. substr($komplen[0]['tglmasuk'],10,18).'</small></div>
									</div>
									</a>
									</li>';
						if($komplen[0]['action']==null){
							$ret['notif'] = base64_encode('Y');
							}
						}		
						$htmlPesan.='<li><a rel="nofollow" href="#" class="dropdown-item all-notifications text-center"> <strong> <i class="fa fa-bell"></i>Lihat Semua Notifikasi</strong></a></li></ul>';
						$htmlKomplen='<a id="notifications" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link"><i class="fa fa-wrench"></i><span class="badge badge-warning">'.$notif.'</span></a>';
						$htmlKomplen.=' <ul aria-labelledby="notifications" class="dropdown-menu" id="notif-komplen">';
						foreach ($komplen as $key => $value) {
								$foto = R::load('m_user',$value['client_id']);	
								$htmlKomplen.='<li><a rel="nofollow" href="'.site_url('admin/index/admin-menu-support-html-h_ruangkerja').'" class="dropdown-item d-flex"><div class="msg-profile">'; 
								$url='';
								$note='';
								if(!$foto->foto){$url=base_url('asset/foto/preview.png');}else{$url=base_url('asset/foto/user/'.$foto->foto);}
								if($value['action']=='P'){$note='</br>Sedang Di Respons..';}else{$note='</br>Menunggu..';}
								$htmlKomplen.='<img src="'.$url.'" alt="..." class="img-fluid rounded-circle">';
								$htmlKomplen.='</div><div class="msg-body"><h3 class="h6">'.$value['dari'].'</h3><span>'.substr($value['keluhan'],0,25).'..</span><small>'.$value['tglmasuk'].$note.'</small></div></a></li>';
							}
						$htmlKomplen.='<li><li><audio id="audio" autoplay style="display:none;"></audio></li><a rel="nofollow" href="'.site_url('admin/index/admin-menu-support-html-h_ruangkerja').'" class="dropdown-item all-notifications text-center"> <strong> <i class="fa fa-wrench"></i>Lihat Semua Komplen</strong></a></li> </ul>';	
						$ret['pesan'] = base64_encode($htmlPesan);
						$ret['komplen'] = base64_encode($htmlKomplen);				
					}
					catch (Exception $e){
						$ret['error'] = $e->getMessage();
					}
				echo json_encode($ret);
		}	
	
	// Function website
	// Upload foto 
	public function add_upload_foto($w,$h){
		R::setStrictTyping(false);
		$ret = array();
			try{					
				$config['upload_path']   = FCPATH.'asset/foto/publikasi/';
				$config['allowed_types'] = 'gif|jpg|png|ico|jpeg';
				$config['encrypt_name'] = TRUE;
				
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
					$config['width'] = $w;
					$config['height'] = $h;
					$config['quality'] = 50;
					$config["image_sizes"]["square"] = array($w, $h);
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();			
					
					if($this->load->library('image_lib', $config)){
						$temp= FCPATH.'asset/foto/publikasi/'.$nama;
						$image_data = file_get_contents($temp);
						$image_token = base64_encode($image_data); 
						$time = strtoupper(substr(md5(time()), 0, 6));
						$id=$this->input->get('id');
						$tb=$this->input->get('tb');
						$drop ="";
						if($this->input->get('img')){
							$drop = R::load('w_post_foto',$this->input->get('img'));
								if($drop){
									if(file_exists(FCPATH.'asset/foto/publikasi/'.$drop->name)){
										unlink(FCPATH.'asset/foto/publikasi/'.$drop->name);
										}
								}else{$drop = R::dispense('w_post_foto');}															
							}else{
							$drop = R::dispense('w_post_foto');
							}
							$drop->name = $nama;
							$drop->sumber = $this->input->post('sumberfoto');
							$drop->type =$type;					
							//$drop->img_binary =$image_token;
							$drop->date = R::isoDateTime();
							$drop->upload_id=$time.'.'.$id;
							$bean = R::store($drop);
							if($bean){
									$edit = R::load(base64_decode($tb),$id);
									$edit->img_id = $bean;
									R::store($edit);
								$ret['error'] =false;
								$ret['code'] =100;
								$ret['message'] ='upload berhasil..';
								}
						}else {
							$ret['error'] =true;
							$ret['code'] =300;
							$ret['message'] ='Gagal Kompresing image or file ..';
						}						
					}else{
						$ret['error'] =true;
						$ret['code'] =101;
						$ret['message'] ='Gagal Upload Data...';	
					}					
				} catch (Exception $e) {
					$ret['error'] =true;
					$ret['code'] =201;
					$ret['message'] =$e->getMessage();
					}
			echo json_encode($ret);
		}
	public function edit_upload_foto(){
		R::setStrictTyping(false);
		$ret = array();
			try{

				$parsing = base64_decode($this->input->get('data'));
				$parsing = str_replace("^",".",$parsing);
				$parsing = str_replace("-","+",$parsing);
				$parsing = str_replace("_","/",$parsing);
				$hasil = json_decode($parsing);
				
				$uploadPath = FCPATH.str_replace("+","/",$hasil->path).'/';
				$config['upload_path'] = $uploadPath;
				$config['allowed_types'] = 'gif|jpg|png|ico|jpeg';
				$config['encrypt_name'] = TRUE;			

				$this->load->library('upload',$config);			
				// $ret['hasil']=$hasil->path;	
			if($this->upload->do_upload('file')){
				$file = $this->upload->data();				
				// image manipulasi merisize
				$nama = $file['file_name'];
				$type = $file['file_type'];
						
				$resize = $this->resizeImage($uploadPath,$nama);
				
				// if($resize){
					$temp = $uploadPath.$nama;
					$image_data = file_get_contents($temp);
					$image_token = base64_encode($image_data); 
					$id=base64_decode($hasil->id);
					$tb=str_replace("/","_",$hasil->tbL);
						$drop = R::load($tb,$id);
						if($drop){	
							if($drop->foto != NULL){	
								if(file_exists($uploadPath.$drop->foto)){
									unlink($uploadPath.$drop->foto);
									}															
								$drop->foto =$nama;	
							}else{
								$drop->foto =$nama;
							}
							$cek = R::store($drop);
							if($cek){
								$ret['error'] =false;
								$ret['code'] =200;
								$ret['message'] ='sucsess..';
							}else{
								$ret['error'] =true;
								$ret['code'] =100;
								$ret['message'] ='faild to update data table';
							}
						}else{
								$ret['error'] =true;
								$ret['code'] =100;
								$ret['message'] ='data not found...';
						}
					// }else {
					// 	$ret['error'] =true;
					// 	$ret['code'] =300;
					// 	$ret['message'] ='Gagal Kompresing image or file ..';
					// }						
				}else{
					$ret['error'] =true;
					$ret['code'] =101;
					$ret['message'] ='Gagal Upload Data...';	
				}					
			} catch (Exception $e) {
					$ret['error'] =true;
					$ret['code'] =201;
					$ret['message'] =$e->getMessage();
				}
			echo json_encode($ret);
		}
	public function add_multipel_upload(){
			R::setStrictTyping(false);
			$date =R::isoDateTime();
			$ret = array();
				try{
					$parsing = base64_decode($this->input->post('data'));
					$parsing = str_replace("^",".",$parsing);
					$parsing = str_replace("-","+",$parsing);
					$parsing = str_replace("_","/",$parsing);
					$hasil = json_decode($parsing);		
					$files = $_FILES;
					$cpt = count($_FILES['file']['name']);	
				
					if(!empty($_FILES['file']['name'])){							
						$id= $hasil->id;
						$tb=str_replace("/","_",$hasil->tbL);
						for($i=0; $i<$cpt; $i++)
								{           
									$_FILES['file']['name']= $files['file']['name'][$i];
									$_FILES['file']['type']= $files['file']['type'][$i];
									$_FILES['file']['tmp_name']= $files['file']['tmp_name'][$i];
									$_FILES['file']['error']= $files['file']['error'][$i];
									$_FILES['file']['size']= $files['file']['size'][$i];    

									// File upload configuration
									$uploadPath = FCPATH.str_replace("+","/",$hasil->path).'/';
									$config['upload_path'] = $uploadPath;
									$config['allowed_types'] = 'jpg|png|ico|jpeg';
									$config['encrypt_name'] = TRUE;
									// Load and initialize upload library
									$this->load->library('upload',$config);
									$this->upload->initialize($config);

									if($this->upload->do_upload('file')){
										$file = $this->upload->data();				
										// image manipulasi merisize
										$nama = $file['file_name'];
										$type = $file['file_type'];
											
										$this->resizeImage($uploadPath,$nama);

										$drop = R::dispense($tb);
										$drop->name = $hasil->name;
										$drop->lokasi = $hasil->lokasi;
										$drop->img = str_replace("+","/",$hasil->path).'/'.$nama;
										$drop->link_id =$hasil->linkId;	
										$drop->ctgr_id =$hasil->ctgrId;				
										$drop->date = $date;
										$drop->user_id= $hasil->id;
										R::store($drop);
									}else{
										$ret['error'] =true;
										$ret['code'] =001;
										$ret['message'] ='Error Function System uploading...';
									}
								}				
												
						}else{
							$ret['error'] =true;
							$ret['code'] =002;
							$ret['message'] ='Gagal Upload Data...';	
						}					
					} catch (Exception $e) {
						$ret['error'] =true;
						$ret['code'] =003;
						$ret['message'] =$e->getMessage();
						}
			echo json_encode($ret);
		}	
	// Resize image
	public function resizeImage($path,$filename)
		{
			$source_path = $path. $filename;
			$target_path = $path;

			$config_manip = array(
				'image_library' => 'gd2',
				'source_image' => $source_path,
				'new_image' => $target_path,
				'maintain_ratio' => TRUE,
				'quality'=>100,
				'width' =>500,
			);
		
			$this->load->library('image_lib', $config_manip);
			if (!$this->image_lib->resize()) {
				echo $this->image_lib->display_errors();
			}
		
			$this->image_lib->clear();
		}
	public function resizeImageTo()
		{
			$arr = array();
			$source_path =null;
			$target_path =null;
			try
				{
				$this->load->library('image_lib');

				if($this->input->post('file') || $this->input->post('path')){
					$source_path = FCPATH.$this->input->post('path').'/'.$this->input->post('file');
					$target_path = FCPATH.$this->input->post('path').'/'.$this->input->post('file');
				}			
				$config['image_library'] ="gd2";
				$config['source_image'] = $source_path;
				$config['create_thumb'] = FALSE;
				$config['maintain_ratio'] = TRUE;
				$config['width'] =500;
				$config['quality'] =50;
				//$config['new_image']=$target_path;

				$this->image_lib->initialize($config);

				if (!$this->image_lib->resize()) {
					$arr['error'] = $this->image_lib->display_errors();
					$arr['message'] = $source_path;
				}else{
					$arr['message'] = $source_path;
					$arr['path'] = $this->input->post('path').'/'.$this->input->post('file');
					
					$arr['error']=false;
				}
				$this->image_lib->clear();
			}catch (Exception $e)
				{
					$arr['error'] = $e->getMessage();
				}
			echo json_encode($arr);
		}
		// Update User Profile \\
	public function update_user_profile() {	
		$id = $this->input->get('id');
		$arr = array();
		try
			{
			if($this->input->post())
			{
				$bean = R::load('m_user',base64_decode($id));
				if($bean){
						if($bean->password == md5($this->input->post('oldpassword')))
						{
							if ($bean->username != $this->input->post('username'))
								{
									$cekUser = R::findOne('m_user','username = ?',array($this->input->post('username')));
									if($cekUser){
										if($cekUser->username == $this->input->post('username'))
										{
											$arr['error'] = true ;
											$arr['message'] = 'Username Sudah Di Gunakan..!!' ;
										}else {
											$bean->username = $this->input->post('username');
										}
									}
									
								}
							if($this->input->post('newpassword')){
								$bean->password =md5($this->input->post('newpassword'));
								$bean->oldpassword =md5($this->input->post('oldpassword'));
								}
							if ($bean->email != $this->input->post('email'))
								{
									$bean->email = $this->input->post('email');
									$to = $this->input->post('newpassword');
									$name = $this->input->post('nama');
									$pass = $this->input->post('email');
									$this->send_email($to,$name,$pass);
								}

								$bean->nama = $this->input->post('nama');
								$bean->whatsapp = $this->input->post('whatsapp');
								$bean->alamat = $this->input->post('alamat');
								$bean->pengalaman = $this->input->post('pengalaman');
								$bean->instagram = $this->input->post('instagram');
								$bean->youtube = $this->input->post('youtube');
								$bean->facebook = $this->input->post('facebook');
								$bean->twitter = $this->input->post('twitter');
								$bean->updtime =R::isoDateTime();
								$id = R::store($bean);
								
								if($id){
									$arr['error'] = false ;
									$arr['message'] = 'Success...' ;
								}else {
									$arr['error'] = true ;
									$arr['message'] = 'System Faild...' ;
								}	
						}else {
							$arr['error'] = true ;
							$arr['message'] = 'Password Lama Tidak Sesuai...!';
						}
				}else {
					$arr['error'] = true ;
					$arr['message'] = 'User Error...!!' ;
				}
			$this->add_log('Update Data Username Ke Tabel  (m_user) Dengan ID (' . $id .') Variabel ( SET ' . $bean->username . ' = ' . $bean->username .' '.$arr['message']);	
			}else
			{
					$arr['error'] = true ;
					$arr['message'] = 'Data Error Call IT ext 165..' ;
			}
		}	
		catch (Exception $e)
				{
					echo $e->getMessage();
					R::rollback();
				}
		echo json_encode ($arr);
		}
	
	
		// Fungsi Megirim Email
	public function send_email($to,$name,$pass){
		$txt='';
		$to = $to;
		$subject = "My subject";
		$txt .= "HALO : ".$name;
		$txt = "PASSWORD ANDA : ".md5($pass);
		$config = Array(
				$config['protocol'] = 'smtp',
				$config['smtp_host'] = 'ssl://smtp.googlemail.com',
				$config['smtp_port'] = 465,
				'smtp_user' => 'aditnugroho4@gmail.com', // change it to yours
				'smtp_pass' => '$el4lu4m4n', // change it to yours
				'mailtype' => 'html',
				'newline'  => "\r\n",
				'charset' => 'iso-8859-1',
				'wordwrap' => TRUE
				);
		$message = $txt;
		$this->load->library('email',$config);
		$this->email->from('aditnugroho4@gmail.com'); // change it to yours
		$this->email->to($to);// change it to yours
		$this->email->subject('User Password SIMRS');
		$this->email->message($message);
		if($this->email->send())
			{
				echo 'Email sent.';
			}
		else
			{
			show_error($this->email->print_debugger());
			}
		}


	

	// Upload File
	public function add_upload_file(){
			R::setStrictTyping(false);
			$date =R::isoDateTime();
			$ret = array();
				try{					
					$files = $_FILES;
					$cpt = count($_FILES['file']['name']);						
					if(!empty($_FILES['file']['name'])){							
						$id = $this->input->get('id');
						for($i=0; $i<$cpt; $i++)
								{           
									$_FILES['file']['name']= $files['file']['name'][$i];
									$_FILES['file']['type']= $files['file']['type'][$i];
									$_FILES['file']['tmp_name']= $files['file']['tmp_name'][$i];
									$_FILES['file']['error']= $files['file']['error'][$i];
									$_FILES['file']['size']= $files['file']['size'][$i];    

									// File upload configuration
									$uploadPath = FCPATH.'asset/admin/dokument/e-library/';
									$config['upload_path'] = $uploadPath;
									$config['allowed_types'] = 'pdf';
									$config['encrypt_name'] = TRUE;
									
									// Load and initialize upload library
									$this->load->library('upload', $config);
									$this->upload->initialize($config);
									
									if($this->upload->do_upload('file')){
										// Uploaded file data
										$file = $this->upload->data();	
										$nama = $file['file_name'];
										$type = $file['file_type'];
										$drop = R::dispense('w_post_files');
										$drop->nama = $files['file']['name'][$i];
										$drop->link = 'asset/admin/dokument/e-library/'.$nama;
										$drop->type =$type;				
										$drop->date = $date;
										$drop->upload_id= $this->input->post('idUpload');
										R::store($drop);
									}else{
										$ret['error'] =true;
										$ret['code'] =001;
										$ret['message'] ='Error Function System uploading...';
									}
								}				
												
						}else{
							$ret['error'] =true;
							$ret['code'] =002;
							$ret['message'] ='Gagal Upload Data...';	
						}					
					} catch (Exception $e) {
						$ret['error'] =true;
						$ret['code'] =003;
						$ret['message'] =$e->getMessage();
						}
			echo json_encode($ret);
		}	
	public function get_json_data_file(){
		R::setStrictTyping(false);
		$date =R::isoDateTime();
		$ret = array();
			try{
				$pokja = R::getAll('SELECT * FROM m_akreditasi');
					foreach($pokja as $p=> $ja){	
						$sql = R::getAll('SELECT * FROM w_post_elibrary WHERE pokja_id= ?',array($ja['id']));	
						$ret['pokja'][]=array('id'=>$ja['id'],'nama'=>'('.$ja['pokja'].')'.$ja['nama'],'count'=>R::count('w_post_elibrary','pokja_id= ?',array($ja['id'])));							
							foreach($sql as $key=>$val){
								$sql2 = R::getAll('SELECT * FROM w_post_files WHERE upload_id= ?',array($val['id']));	
								$ret['folder'][]=array('id'=>$val['id'],'judul'=>$val['judul'],'pokja_id'=>$val['pokja_id'],'count'=>R::count('w_post_files','upload_id= ?',array($val['id'])));
									foreach($sql2 as $key=>$value){
										$ret['file'][]=array('id'=>$value['id'],'file'=>$value['nama'],'link'=>$value['link']);
									}
								}																
						}	
			} catch (Exception $e) {
				$ret['error'] =true;
				$ret['code'] =003;
				$ret['message'] =$e->getMessage();
				}
		echo json_encode($ret);
		}
	public function get_json_data_berita(){
		R::setStrictTyping(false);
		$date =R::isoDateTime();
		$ret = array();
		$file = array();
		try{
				$sql = R::getAll('SELECT ph.*,pk.name FROM w_post_headline ph INNER JOIN w_post_kategory pk ON pk.id=ph.ctgr_id ORDER BY date DESC LIMIT 0,10;');
				if($sql){
					foreach($sql as $p=> $ja){
						$img = R::load('w_post_foto',$ja['img_id']);
						$ret['headline'][]=array('judul'=>$ja['judul'],
												'sumber'=>$ja['sumber'],
												'artikel'=>$ja['artikel'],
												'date'=>$ja['date'],
												'kategory'=>$ja['name'],
												'img_id'=>$img->id,
												'img'=>$img->name,
												'id'=>$ja['id']
												);
						$sql1 = R::getAll('SELECT pb.* FROM w_post_berita pb INNER JOIN w_post_headline ph ON ph.id=pb.headline_id WHERE pb.id = ? ORDER BY date DESC LIMIT 0,2;',array($ja['id']));				
						foreach($sql1 as $i=> $val){
								$imgs = R::load('w_post_foto',$val['img_id']);
								$ret['berita'][]=array('judul'=>$val['judul'],
														'sumber'=>$val['sumber'],
														'artikel'=>$val['artikel'],
														'date'=>$val['date'],
														'img_id'=>$imgs->id,
														'headline_id'=>$val['headline_id'],
														'img'=>$imgs->name,
														'id'=>$val['id']);
							}
					}
						$ret['error'] =false;
				}else{
					$ret['error'] =true;
					$ret['code'] =102;
					$ret['message'] ="Data Not Found..";
				}
									
				} catch (Exception $e) {
					$ret['error'] =true;
					$ret['code'] =103;
					$ret['message'] =$e->getMessage();
					}
			echo json_encode($ret);
		}
	public function get_json_data_banner(){
		R::setStrictTyping(false);
		$date =R::isoDateTime();
		$ret = array();
		$file = array();
		try{
			$sql = R::getAll('SELECT * FROM w_post_banner ORDER BY date DESC;');
			if($sql){
				foreach($sql as $p=> $ja){
				$img = R::load('w_post_foto',$ja['img_id']);
				$ret['banner'][]=array('judul'=>$ja['judul'],
										'label1'=>$ja['label_1'],
										'label2'=>$ja['label_2'],
										'date'=>$ja['date'],
										'content'=>$ja['content'],
										'img_id'=>$img->id,
										'img'=>$img->name,
										'id'=>$ja['id'],
										'id_img'=>$ja['img_id']
										);				
							}
						$ret['error'] =false;
					}else{
						$ret['error'] =true;
						$ret['code'] =102;
						$ret['message'] ="Data Not Found..";
					}										
			} catch (Exception $e) {
				$ret['error'] =true;
				$ret['code'] =103;
				$ret['message'] =$e->getMessage();
			}
			echo json_encode($ret);
		}

	public function get_images_list(){ /* Untuk Plugin CkEditor */
		$table = $this->input->get('table');
		$data=array();
		try{
			$q=R::getALL('Select * from '.$table.';');
			foreach($q as $h)
				{
					$data[] = array('image'=>base_url().$h['img'],'thumb'=>base_url().$h['img'],'folder'=>$h['name']);
				}
			}catch (Exception $e)
				{
					$data['error'] = $e->getMessage();
				}
			echo json_encode($data);
		}
	public function create_sitemap_list(){
		$data=array();
		try{
				$q=R::getALL('SELECT a.id,a.date,s.short_link FROM w_post_artikel a inner join m_seo s ON s.id=a.link_id');
				foreach($q as $h)
					{
						array_push( $data,$h);
					}
				}catch (Exception $e)
					{
						$data['error'] = $e->getMessage();
					}
				echo json_encode($data);
		}
	// Load data Paginating
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
						$arr['data'][]= array('items'=>$key,'user'=>R::load('m_user',$key['user_id'])->export());
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
}
?>
<?php
class Layout {
	protected $_ci;
	function __construct(){
		$this->_ci =&get_instance();
		}	
	function portal($template,$data=null)
		{		
		$data['_header']=$this->_ci->load->view('portal/layout/header',$data, true);
		$data['_banner']=$this->_ci->load->view('portal/layout/banner',$data, true);
		$data['_panel']=$this->_ci->load->view('portal/layout/panel',$data, true);
		$data['_container']=$this->_ci->load->view($template,$data, true);
		$data['_footer']=$this->_ci->load->view('portal/layout/footer',$data, true);
		$data['_chatboot']=$this->_ci->load->view('portal/layout/chat',$data, true);
		$this->_ci->load->view('portal/template.php',$data);
		}		
	function admin($template,$data=null)
		{
			$data['_navbar']=$this->_ci->load->view('admin/layout/navbar',$data, true);
			$data['_sidebar']=$this->_ci->load->view('admin/layout/sidebar',$data, true);
			$data['_content']=$this->_ci->load->view('admin/layout/content',$data, true);
			$data['_footer']=$this->_ci->load->view('admin/layout/footer',$data, true);
			$this->_ci->load->view('admin/template.php',$data);
		}	
		function login($template,$data=null)
		{
			$data['_signin']=$this->_ci->load->view($template,$data, true);
			$this->_ci->load->view('admin/menu/login/template.php',$data);
		}
	
		
}
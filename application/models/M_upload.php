<?php
class M_upload extends CI_Model{

	function simpan_upload($judul,$image){
		$data = array(
	        	'judul' => $judul,
	        	'lampiran' => $image
	       	);  
	    $result= $this->db->insert('p_daftarpaket',$data);
	    return $result;
	}

	
}
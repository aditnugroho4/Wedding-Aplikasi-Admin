<?php defined('BASEPATH') OR exit ('No direct script access allowed');

class Load_page extends CI_Model {

    public function getAll($table)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('id', 'ASC');

        return $this->db->get();
    }
    public function get_Pagination($table,$limit, $offset)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('id', 'ASC');
        $this->db->limit($limit, $offset);

        return $this->db->get();
    }

}
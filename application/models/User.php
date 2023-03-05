<?php
Class User extends CI_Model
  {
    function login($username, $password)
      {
        $this->db-> select('*');
        $this->db-> from('m_user');
        $this->db-> where('username', $username);
        $this->db-> where('password', MD5($password));
        $this->db->where('status','Y');
        $this->db->limit(1);

        $query = $this->db->get();

        if($query -> num_rows() == 1)
        {
            return $query->result();
          }
      else
        {
          return false;
        }
      }
    function login_member($username, $password)
      {
        $this->db-> select('*');
        $this->db-> from('m_user_member');
        $this->db-> where('email', $username);
        $this->db-> where('password', $password);
        $this->db->where('status',NULL);
        $this->db->limit(1);

        $query = $this->db->get();

        if($query -> num_rows() == 1)
        {
            return $query->result();
          }
      else
        {
          return false;
        }
      }
}
?>


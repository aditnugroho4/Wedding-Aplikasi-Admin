<?php
Class Sql_modul extends CI_Model
{
	public function getTable($columns,$SQL1,$wh_ews, $sidx, $sord, $start, $limit)
		{

			$SQL1 = "SELECT ".$columns." FROM ".$SQL1."";
            $SQL1 = "SELECT ".$columns." FROM(".$SQL1.")AS a WHERE 1=1 ".$wh_ews." ORDER BY ".$sidx." ".$sord." LIMIT ".$start." , ".$limit;
 
            return($this->db->query($SQL1));
		}
	function countData($wh_ews,$SQL,$columns)
        {
            $SQL = "SELECT ".$columns." FROM ".$SQL."";
            $SQL_COUNT = "SELECT count(a.`id`) AS count FROM ( ".$SQL." ) as a ".$wh_ews."";
 
            return($this->db->query($SQL_COUNT));
        }

	

	function update_data($id,$data,$table)
	{
    $this->db->where('id',$id);
    return $this->db->update($table, $data);
	}
	
	function delete_data($id) 
	{
    $this->db->where('id', $id);
    $this->db->delete($table);
	}
}
?>
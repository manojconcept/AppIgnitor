<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sector_model extends CI_Model
{

    public function get_sector($userid=null)
    {
        return $this->db->get_where('sector', array('id' => $userid))->row_array();
    }

    public function get_sectorAll()
    {
      return $this->db->get('sector')->result();
    }

    public function isCheck_sector($sectorName)
    {
        $this->db->where('sector_name', $sectorName);
        $query = $this->db->get('sector'); 
        if ($query->num_rows() == 1) {
            return $query->row(); 
        } else {
            return false; 
        }
    }

    public function sector_post($data){
        return $this->db->insert('sector',$data);
    }

    public function sector_delete($id){
        $this->db->where('id',$id);
        return $this->db->delete('sector');
    }
}
 
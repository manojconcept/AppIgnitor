<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Section_model extends CI_Model
{
    public function sections()
    {
        return $this->db->get('section')->result();
    }

    public function section($id)
    {
        return $this->db->get_where('section', array('id' => $id))->result();
    }

    public function isCheck_section($name)
    {
        $this->db->where('name', $name);
        $query = $this->db->get('section'); 
        if ($query->num_rows() == 1) {
            return $query->row(); 
        } else {
            return false; 
        }
    }
   
    public function create_section($data)
    {
        return $this->db->insert('section', $data);
    }

    public function section_update($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->set($data);
        return $this->db->update('section');
    }

    public function delete_section($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('section');
    }


    public function truncate_section(){
        return  $this->db->truncate('section');
    }
}

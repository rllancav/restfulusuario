<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_model extends CI_Model {

		public $nombre;
        public $email;
        public $link;
        public function __construct()
        {
                parent::__construct();
              
        }
	
	public function get($usuario_id)
        {	
		$this->db->where('usuario_id',$usuario_id);
        $query = $this->db->get('usuarios');
        return $query->row();
        }
        public function get_alls($where=array(),$start=false,$limit=false)
        {   
		$this->db->where($where);
        if($limit){
           $this->db->limit($start,$limit);
        }
        $this->db->order_by('usuario_id','desc');
        $query = $this->db->get('usuarios');
        return $query->result();
        }

        public function insert_entry($post)
        {
        $this->nombre = $post['nombre']; 
        $this->email  = $post['email'];
        $this->link   = $post['link'];

        $this->db->insert('usuarios', $this);
		return $this->db->insert_id();
        }

        public function update_entry($post)
        {
        $this->nombre    = $post['nombre']; 
        $this->email  = $post['email'];
        $this->link     = $post['link'];

        $this->db->update('usuarios', $this, array('usuario_id' => $post['usuario_id']));
		if($this->db->affected_rows()){
			return true;
		} else {
			return false;
		}
        }
	public function delete_entry($usuario_id)
        {
        $this->db->where('usuario_id',$usuario_id);
        $this->db->delete('usuarios');
		if($this->db->affected_rows()){
			return true;
		} else {
			return false;
		}
        }

}

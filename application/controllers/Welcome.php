<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require "Curl_api.php";
class Welcome extends Curl_api {

	public function index()
	{
                $json=$this->getUserList();
                
                if($json['success']){
                    $this->layout->data['usuarios']=$json['usuarios'];
                   
                } else {
                    $this->layout->data['usuarios']=array();
                }
		$this->layout->render();
	}
        public function delete($id)
	{
              
              $json=$this->deleteUser($id);
               if($json['success']){
                    $this->session->set_flashdata("success","Registro Eliminado!");
                } else {
                    $this->session->set_flashdata("success","Usuario no se puede eliminar!");
                }
              
            redirect(base_url('welcome/index'));
	}
        public function edit($id)
	{
                $json=$this->getUser($id);
                if($json['success']){
			       $this->layout->data['usuario']=$json['usuario'];
			    } else {
                        $this->session->set_flashdata("success","Usuario No Encontrado!");
                        redirect("welcome/index");
                }
                
                $this->load->helper(array('form', 'url'));

                $this->load->library('form_validation');
                if($_POST){
                    $original_value=$json['usuario']['email'];
                    if($this->input->post('email') != $original_value) {
                        $is_unique =  '|is_unique[usuarios.email]';
                     } else {
                        $is_unique =  '';
                     }
                    $this->layout->data['usuario']=array(
                            'usuario_id'=>$id,
                            'nombre'=>$this->input->post('nombre'),
                            'email'=>$this->input->post('email'),
                            'link'=>$this->input->post('link'),
                        );    
                    $this->form_validation->set_rules('nombre', 'nombre', 'required');             

                    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email'.$is_unique);
                    $this->form_validation->set_rules('link', 'Link', 'trim|required|valid_url_format');

                    if ($this->form_validation->run() == FALSE)
                    {
                        
                    }
                    else
                    {
                        $post=$this->input->post();
                        
                        $response=$this->updateUser($id,$post);
                        if($response['success']){
                            $this->session->set_flashdata("success","Registro Actualizado!");
                         } else {
                            $this->session->set_flashdata("success","No se puede Actualizar!");
                        }
                       redirect("welcome/index"	);

                    }
                }
		$this->layout->render();	
	}
        
        public function add()
	{
                
                $this->load->helper(array('form', 'url'));

                $this->load->library('form_validation');
                if($_POST){
                    $this->layout->data['usuario']=array(
                           
                            'nombre'=>$this->input->post('nombre'),
                            'email'=>$this->input->post('email'),
                            'link'=>$this->input->post('link'),
                        );    
                    $this->form_validation->set_rules('nombre', 'nombre', 'required');             
                    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
                    $this->form_validation->set_rules('link', 'Link', 'trim|required|valid_url_format');

                    if ($this->form_validation->run() == FALSE)
                    {
                        
                    }
                    else
                    {
                        $post=$this->input->post();
                        
                        $response=$this->addUser($post);
                        if($response['success']){
                            $this->session->set_flashdata("success","Registro Agregado!");
                        } else {
                            $this->session->set_flashdata("success","Usuario No se Puede Agregar!");
                        }                   
                      
                        redirect("welcome/index");

                    }
                }
		$this->layout->render();
	}
}       

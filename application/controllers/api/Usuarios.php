<?php

defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;


class Usuarios extends REST_Controller {

    function __construct()
    {
      
        parent::__construct();

        $this->methods['usuarios_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['usuarios_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['usuarios_delete']['limit'] = 50; // 50 requests per hour per user/key
        $this->methods['usuarios_put']['limit'] = 50; // 50 requests per hour per user/key
		$this->load->model('usuario_model');
    }

    public function usuarios_get()
    {
        $json=array('success'=>false);
        $usuarios =$this->usuario_model->get_alls();

        $id = $this->get('id'); 

          if ($id === NULL)
        {
             if ($usuarios)
            {
                $json=array('success'=>true,'usuarios'=>$usuarios,'status_code'=>REST_Controller::HTTP_OK,'message'=>'User found');
                $this->response($json, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                $json=array('success'=>false,'status_code'=>REST_Controller::HTTP_NOT_FOUND,'message'=>'not found');
                $this->response($json, REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }

         else {
            $id = (int) $id;

             if ($id <= 0)
            {
                 $json=array('success'=>false,'status_code'=>REST_Controller::HTTP_BAD_REQUEST,'message'=>'User not found');
                $this->response($json, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
            }

            $usuario = $this->usuario_model->get($id);
           

            if (!empty($usuario))
            {
                $json=array('success'=>true,'usuario'=>$usuario,'status_code'=>REST_Controller::HTTP_OK,'message'=>'User found');
                $this->set_response($json, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                $json=array('success'=>false,'status_code'=>REST_Controller::HTTP_NOT_FOUND,'message'=>'not found');
                $this->set_response($json, REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    public function usuarios_post()
    {
        $json=array('success'=>false);
        $post=$this->post(); 
       
        $usuario_id=$this->usuario_model->insert_entry($post);
        if($usuario_id){
            $json=array('success'=>true,'status_code'=>REST_Controller::HTTP_CREATED,'message'=>'User added');       
            $this->set_response($json, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
        }
    }
    public function usuarios_put()
    {   
    $json=array('success'=>false);
	$post=$this->put();       
        
        $usuario_id=$this->usuario_model->update_entry($post);
        if($usuario_id){
            $json=array('success'=>true,'status_code'=>REST_Controller::HTTP_CREATED,'message'=>'User updated');       
            $this->set_response($json, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
        }
    }

    public function usuarios_delete()
    {
        $json=array('success'=>false);
        $id = (int) $this->get('id'); 

         if ($id <= 0)
        {
             $json=array('success'=>false,'status_code'=>REST_Controller::HTTP_BAD_REQUEST,'message'=>'User not found');
            $this->response($json, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }
        else {
            $bool=$this->usuario_model->delete_entry($id);
            if($bool){
                $json=array('success'=>true,'status_code'=>REST_Controller::HTTP_OK,'message'=>'User deleted');	

                $this->set_response($json, REST_Controller::HTTP_OK); // NO_CONTENT (204) being the HTTP response code
            }
        }
	
    }
	
}

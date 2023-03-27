<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<?php $this->load->view('layout/header',$data); ?>
<div id="wrapper">
<main id="page-content-wrapper" role="main">        
<div class="col-md-12" id="submenu-2">
    <div class="row">
         <div class="mainbox col-md-12 col-sm-6 col-sm-8">
	<div class="panel panel-info">
            <div class="panel-heading">
              <div class="panel-title">Consulta de Usuarios</div>
              <div style="float:right; font-size: 85%; position: relative; top:-10px"><a id="signinlink" href=<?php echo base_url('welcome/add/');?>">Agregar Usuario</a></div>
            </div>
            <div class="panel-body" >
      <div class="col-md-12">
     
      <div class="table-responsive">
        <div class="success"><?php echo $this->session->flashdata('success'); ?></div>
	
             <table class="table table-bordred table-striped">
                 <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email </th>
                    <th>Link</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                
                <?php if(count($usuarios)>0){ foreach($usuarios as $usuario){ ?>
                <tr>
                    <td><?php echo $usuario['usuario_id']; ?></td>
                    <td><?php echo $usuario['nombre']; ?></td>
                    <td><?php echo $usuario['email']; ?></td>
                    <td><?php echo $usuario['link']; ?></td>
                    <td>
                         <a href=<?php echo base_url('welcome/edit/')?><?php echo $usuario['usuario_id']; ?>>Edit</a> | <a href=<?php echo base_url('welcome/delete/')?><?php echo $usuario['usuario_id']; ?>>Eliminar</a> 	                    </td>
                </tr>
                <?php } } else { ?>
                    <tr><td colspan="5" align="center"><p class="alert alert-info">No se encontraron Registros! </p></td></tr>
                <?php } ?>
                </tbody>
            </table>
           
	</div>
        </div>
        </div>
        </div>
        
</div>
</div>
        </main>
    </div> 
<?php $this->load->view('layout/footer',$data); ?>
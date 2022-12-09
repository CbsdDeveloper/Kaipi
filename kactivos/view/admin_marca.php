<?php
	session_start( );
?>	
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
 
</head>
<body>
  <div class="well">  
  
        <div class="modal-content">

        	<div class="modal-body"> 
 
                  <div class="list-group">
                     
                     <form action="admin_marca" method="post" enctype="application/x-www-form-urlencoded" accept-charset="UTF-8">
                      
                  	   <div style="padding-top: 5px;" class="col-md-12"><h5>Crear Marca</h5></div>
                       
                                       
 								<label  style="padding-top: 5px;text-align: right;" class="col-md-2">Marca</label>
                                   <div style="padding-top: 5px;" class="col-md-4">
                                        <input name="nombre"  type="text" required="required"  class="form-control required" id="nombre" > 
                                   </div> 

                                   
                                   <label  style="padding-top: 5px;text-align: right;" class="col-md-2">Detalle</label>
                                   <div style="padding-top: 5px;" class="col-md-4">
                                         <input name="referencia"  type="text" required="required"  class="form-control required" id="referencia" > 
                                   </div> 
                   
                			 		<input type="hidden" id="action" value="add" name="action">
                			 
								  <div style="padding-top: 5px;" class="col-md-12">

										<button type="submit" class="btn btn-success btn-sm">
										<span class="glyphicon glyphicon-floppy-saved"></span> Guardar  </button>

										<button type="button" onClick="window.close();" class="btn btn-primary btn-sm">
										<span class="glyphicon glyphicon-log-out"></span> Cancelar </button>
 
								 </div> 
    
                    </form>
 
 		 </div>
	</div>
   </div>
 </div>
</body>
</html>
<?php

 

if (isset($_POST['action']))	{
      $inserta = $_POST['action'];
	  if ($inserta == 'add'){
	  		require 'SesionInicio.php';
	  		Agregar($obj,$bd,$set );		  
	  }
}  

 function Agregar($obj,$bd,$set  ){

         
		$InsertQuery = array(   
                                    array( campo => 'nombre',   	valor => strtoupper($_POST["nombre"])),
                                    array( campo => 'referencia',   valor => strtoupper($_POST["referencia"])) 
                                );
 
                                    
          $bd->JqueryInsertSQL('web_marca',$InsertQuery);

  		  $url ='../model/Model-MarcaCategoria.php?lista=marca';
 
		  DivCategoria('#idmarca', $url );
  	
	 	  $obj->var->kaipi_cierre_pop();

 }
 
 function DivCategoria($div,$url ){
 
  echo '<script type="text/javascript">';
  echo "  opener.$('".$div."').load('".$url."');   ";
  echo '</script>';  
 
  } 
 
?>
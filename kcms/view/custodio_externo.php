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
 
 <div style="padding: 25px;" class="col-md-12">
                       
                  	   <div style="padding-top: 5px;" class="col-md-12"><h5>ENLACE - VALIDACION DE IDENTIFICACION DE CUSTODIOS ADMINISTRATIVOS</h5></div>
                       
                                       
 								<label  style="padding-top: 5px;text-align: right;" class="col-md-3">Busqueda de Identificacion Custodio</label>
                                   <div style="padding-top: 5px;" class="col-md-4">
                                        <input name="cedula"  type="text" required="required"  class="form-control required" id="cedula" > 
                                   </div> 

	 							  <div style="padding-top: 5px;" class="col-md-8"> Actualizar la informacion - enlace servicios </div> 
	 
	 
	 								<div style="padding-top: 10px;" class="col-md-12">
										<div class="col-md-12">Identificacion <h5 style="font-weight: bolder" id="a"> </h5> </div> 
 										 
                                    </div> 
	 
                   
                			 		<input type="hidden" id="action" value="add" name="action">
                			 
								  <div style="padding-top: 5px;" class="col-md-12">

										<button type="button" id="xx" class="btn btn-success btn-sm">
										<span class="glyphicon glyphicon-floppy-saved"></span> Buscar  </button>

										<button type="button" onClick="window.close();" class="btn btn-primary btn-sm">
										<span class="glyphicon glyphicon-log-out"></span> Cancelar </button>
 
								 </div> 
    </div> 
 
</body>
	<script>
		$(document).ready(function(){
	
			  $('#xx').on('click',function(){
				  
			 
	 		 
	    	    var itemVariable = $("#cedula").val();  
	 
        		var parametros = {
											"id" : itemVariable 
									};
									 
    									$.ajax({
    										    type:  'GET' ,
    											data:  parametros,
    											url:   '../empleadoPoeCedula.php',
    											dataType: "json",
     											success:  function (response) {
    
     	 											 
    													 $("#a").html( response.a );  
    												 
    													  
    											} 
    									});
          
			});
	    
		
		});  
	</script>	
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
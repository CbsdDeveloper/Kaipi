<?php	session_start( ); 	require 'SesionInicio.php'; ?>	
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
 
</head>
<body>
 
                     
                     <form action="problemas" method="post" enctype="application/x-www-form-urlencoded" accept-charset="UTF-8">
                      
                  	   <div style="padding: 25px;" class="col-md-12"><h5>Registro Incidencias - Control Problemas</h5></div>
                       
                                   <?php  
 								  
									$obj->text->text('Tipo',"texto" ,'tipo' ,80,80, $datos ,'required','','div-2-4') ;
									$obj->text->text('Solucion',"texto" ,'solucion' ,80,80, $datos ,'required','','div-2-4') ;
									$obj->text->text('Contigencia',"texto" ,'contigencia' ,80,80, $datos ,'required','','div-2-4') ;
									$obj->text->text('Estado',"texto" ,'estado' ,80,80, $datos ,'required','','div-2-4') ;
									$obj->text->text('Problema',"texto" ,'problema' ,80,80, $datos ,'required','','div-2-4') ;
                			 		
						 			?>
								  <div style="padding-top:25px;" align="center" class="col-md-12">
									  
									    <input type="hidden" id="action" value="add" name="action">
									  
										<button type="submit" class="btn btn-success btn-sm">
										<span class="glyphicon glyphicon-floppy-saved"></span> Guardar  </button>

										<button type="button" onClick="window.close();" class="btn btn-primary btn-sm">
										<span class="glyphicon glyphicon-log-out"></span> Cancelar </button>
 
								 </div> 
    
                    </form>
 
 
</body>
</html>
<?php

 

if (isset($_POST['action']))	{
      $inserta = $_POST['action'];
	  if ($inserta == 'add'){
	  	
	  		Agregar($obj,$bd,$set );		  
	  }
}  

 function Agregar($obj,$bd,$set  ){

	 
	 $idcaso = $_SESSION['idcaso'] ;
         
		$InsertQuery = array(   
                                    array( campo => 'nombre',   	valor => strtoupper($_POST["nombre"])),
                                    array( campo => 'referencia',   valor => strtoupper($_POST["referencia"])) 
                                );
 
                                    
         // $bd->JqueryInsertSQL('web_marca',$InsertQuery);

 
  	
	 	  $obj->var->kaipi_cierre_pop();

 }
 
 
 
?>
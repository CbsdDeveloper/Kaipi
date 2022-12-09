<?php  

  session_start( );  
  
   
   require 'SesionInicio.php';

   
   if (isset($_GET['action']))	{
	   
           $action = $_GET['action'];
	   
	   	   $id = $_GET['id'];
	   
	    if ($action == 'add'){
				Agregar($obj,$bd,$set, $id  );
			}  
            
     }  
	
   /*-----------------------------------------------------------------------------
  -------------------------------------------------------------------------------*/
   function Agregar($obj,$bd,$set, $id   ){
 
			
	    $InsertQuery = array(   
                                    array( campo => 'id_producto',   valor => $id  ),
                                    array( campo => 'monto',   valor => @$_POST["monto"]),
                                    array( campo => 'activo',   valor => @$_POST["activo"]),
                                    array( campo => 'detalle',   valor => @$_POST["detalle"]),
                                    array( campo => 'principal',   valor => @$_POST["principal"])
                                );
 
                                    
          $bd->JqueryInsertSQL('inv_producto_vta',$InsertQuery);

  		  DivPrecio('#precio_grilla','../model/Model-ajax_precio.php?id='.$id);
  
 	 	  $obj->var->kaipi_cierre_pop();

 }
 
 function DivPrecio($div,$url ){
 
  echo '<script type="text/javascript">';
  echo "  opener.$('".$div."').load('".$url."');   ";
  echo '</script>';  
 
  } 
 
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php   require('Head.php') ; 	?> 
 
</head>

<body>
 
	  <div class="col-md-12">   
  
        	<div class="modal-body"> 
				
              <form action="nom_laboral?action=add&id=<?php echo $_GET['id']; ?>" method="post" enctype="application/x-www-form-urlencoded" accept-charset="UTF-8">
                      
                  	   <div style="padding-top: 5px;" class="col-md-12"><h5> Actualizar Historia Laboral</h5></div>
                       			  <div style="padding-top: 5px;" class="col-md-2">Id</div> 
                                   <div style="padding-top: 5px;" class="col-md-4">
                                        <input name="id_laboral"  type="text" required="required"  class="form-control required" id="id_laboral" readonly> 
                                   </div> 
					
							      <div style="padding-top: 5px;" class="col-md-2"> Tipo</div> 
                                   <div style="padding-top: 5px;" class="col-md-4">
                                     <select name="tipo" class="form-control required" required="required" id="tipo">
                                       <option value="privada">Privada</option>
                                       <option value="publica">Publica</option>
                                     </select>
              					  </div> 
					
					             <div style="padding-top: 5px;" class="col-md-2"> Nombre Puesto</div>  
                                  <div style="padding-top: 5px;" class="col-md-4">
                                        <input name="institucion"  type="text" required="required"  class="form-control required" id="institucion" > 
                                   </div> 
								  
                   				   <div style="padding-top: 5px;" class="col-md-2"> Puesto Laboral</div>  
                                  <div style="padding-top: 5px;" class="col-md-4">
                                        <input name="puesto"  type="text" required="required"  class="form-control required" id="puesto" > 
                                   </div> 
				   
				  
                                    <div style="padding-top: 5px;" class="col-md-2"> Activo</div> 
								   <div style="padding-top: 5px;" class="col-md-4">
											<select name="activo"  class="form-control required"  required="required" id="activo">
											   <option value="S">Si</option>
											   <option value="N">No</option>
											</select>
								   </div>  
				  
				   				  <div style="padding-top: 5px;" class="col-md-2"> Ingreso</div>  
                                  <div style="padding-top: 5px;" class="col-md-4">
                                        <input name="fecha_in"  type="date" required="required"  class="form-control required" id="fecha_in" > 
                                   </div> 
				  
				  			     <div style="padding-top: 5px;" class="col-md-2"> Salida</div>  
                                  <div style="padding-top: 5px;" class="col-md-4">
                                        <input name="fecha_out"  type="date"  class="form-control required" id="fecha_out" > 
                                   </div> 
				  
				  
				  
                                   <div style="padding-top: 10px;" class="col-md-12">
                             			<button type="submit" class="btn btn-success btn-sm">
                            			<span class="glyphicon glyphicon-floppy-saved"></span> Guardar  </button>
 
										<button type="button" onClick="window.close();" class="btn btn-primary btn-sm">
										<span class="glyphicon glyphicon-log-out"></span> Cancelar </button>
 
					    		 </div> 
                     </form>
			</div>		
      </div>
 
</body>
</html>

 
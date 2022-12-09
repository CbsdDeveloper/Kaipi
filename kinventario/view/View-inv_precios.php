<?php
	session_start( );
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
  <div class="well">  
  
        <div class="modal-content">

        	<div class="modal-body"> 
                    
                
                <form action="View-inv_precios?action=add&id=<?php echo $_GET['id']; ?>" method="post" enctype="application/x-www-form-urlencoded" accept-charset="UTF-8">
                      
                  	   <div style="padding-top: 5px;" class="col-md-12"><h5> Actualizar Precio de Venta</h5></div>
                       			  <div style="padding-top: 5px;" class="col-md-2"> Nro.Producto</div> 
                                   <div style="padding-top: 5px;" class="col-md-4">
                                        <input name="idproducto"  type="text" required="required"  class="form-control required" id="idproducto" readonly> 
                                   </div> 
					
							      <div style="padding-top: 5px;" class="col-md-2"> Precio Venta</div> 
                                   <div style="padding-top: 5px;" class="col-md-4">
                                        <input name="monto"  type="number" step='0.01' value='0.00' placeholder='0.00' required="required"   class="form-control required" id="monto"> 
                                   </div> 
					
					
                                  <div style="padding-top: 5px;" class="col-md-2"> Detalle</div>  
                                  <div style="padding-top: 5px;" class="col-md-4">
                                      
                                      <select name="detalle"  class="form-control required"  required="required" id="detalle">
											   <option value="Normal">Normal</option>
											   <option value="PorMayor">Al Por Mayor</option>
                                               <option value="VentaComision">Venta Comision</option>
                                               <option value="VentaTarjeta">Venta Con Tarjeta</option>
                                          
											</select>
                                      
                                      
                                   </div> 
								  
                   				   <div style="padding-top: 5px;" class="col-md-2"> Principal</div> 
									 <div style="padding-top: 5px;" class="col-md-4"> 
											<select name="principal"  class="form-control required"  required="required" id="principal">
											   <option value="S">Si</option>
											   <option value="N">No</option>
											</select>
									 </div>   
                                    <div style="padding-top: 5px;" class="col-md-2"> Activo</div> 
								   <div style="padding-top: 5px;" class="col-md-4">
											<select name="activo"  class="form-control required"  required="required" id="activo">
											   <option value="S">Si</option>
											   <option value="N">No</option>
											</select>
								   </div>  
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
</body>
</html>
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
 
			
	   
	   $x = $bd->query_array('inv_producto_vta',
							 'count(*) as nn', 
							 'id_producto='.$bd->sqlvalue_inyeccion($id,true)
							); 

	   if ( $x["nn"] > 0 ){
		   
		     $principal  = 'N';
		   
	    } else{
		   
		   $principal  = 'S';
		 }   
	 
	   
	    $InsertQuery = array(   
                                    array( campo => 'id_producto',   valor => $id  ),
                                    array( campo => 'monto',   valor => @$_POST["monto"]),
                                    array( campo => 'activo',   valor => @$_POST["activo"]),
                                    array( campo => 'detalle',   valor => @$_POST["detalle"]),
                                    array( campo => 'principal',   valor => $principal)
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
 
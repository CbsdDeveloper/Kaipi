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
                    
                
                <form action="View-inv_gasto?action=add&id=<?php echo $_GET['fecha']; ?>" method="post" enctype="application/x-www-form-urlencoded" accept-charset="UTF-8">
                      
                  	   <div style="padding-top: 5px;" class="col-md-12"><h5> GASTOS DE CAJA CHICA</h5></div>
					
					
					 
					
								<div style="padding-top: 5px;" class="col-md-2"> Tipo Gasto</div> 
									 <div style="padding-top: 5px;" class="col-md-4"> 
											<select name="tipo"  class="form-control required"  required="required" id="tipo">
											   <option value="Alimentacion">Alimentacion</option>
											   <option value="Anticipo Sueldo">Anticipo Sueldo</option>
											   <option value="Anticipo Proveedor">Anticipo Proveedor</option>
											   <option value="Movilizacion">Movilizacion</option>
											   <option value="Anticipo Proveedor">Pago A proveedores</option>
											   <option value="Materiales de Oficina">Materiales de Oficina</option>
											   <option value="Suministros de oficina">Suministros de oficina</option>
												 <option value="Otros">Otros Varios</option>
											</select>
									 </div>  
					
					 			<div style="padding-top: 5px;" class="col-md-2"> Detalle</div>  
                                  <div style="padding-top: 5px;" class="col-md-4">
                                        <input name="detalle"  type="text" required="required"  class="form-control required" id="detalle" value="Compra de..." > 
                                   </div> 
					
							      <div style="padding-top: 5px;" class="col-md-2"> Gasto</div> 
                                   <div style="padding-top: 5px;" class="col-md-4">
                                        <input name="monto"  type="number" step='0.01' value='0.00' placeholder='0.00' required="required"   class="form-control required" id="monto"> 
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
 
	   $fecha =    $id ;  
	   $monto =    @$_POST["monto"];
	   
		
	   $ACierre = $bd->query_array(
		   'inv_movimiento',
		   'max(cierre) as cierre', 
		   'fecha='.$bd->sqlvalue_inyeccion($fecha,true).' and 
		    sesion='.$bd->sqlvalue_inyeccion($_SESSION['email'],true)
	   
	       ); 
 	   
 		
	       if (  $ACierre["cierre"] == 'N'  ) {
		 		

			   if ( $monto > 0  ) {

				$InsertQuery = array(   
											array( campo => 'fecha',   valor => $fecha),
											array( campo => 'monto',   valor => @$_POST["monto"]),
											array( campo => 'sesion',   valor => $_SESSION['email']),
											array( campo => 'tipo',   valor => @$_POST["tipo"]),
											array( campo => 'detalle',   valor => @$_POST["detalle"]) 
										);


				  $bd->JqueryInsertSQL('inv_producto_gasto',$InsertQuery);

				  DivPrecio('#precio_grilla','../model/Model-ajax_gasto.php?fecha='.$id);

				 }   
			   
			 }      
  
 	  $obj->var->kaipi_cierre_pop();

 }
 
 function DivPrecio($div,$url ){
 
  echo '<script type="text/javascript">';
  echo "  opener.$('".$div."').load('".$url."');   ";
  echo '</script>';  
 
  } 
 
?>
 
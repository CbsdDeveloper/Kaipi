<?php session_start( ); ?>	
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestion Empresarial</title>
	
    <?php   require('Head.php') ; 	?> 
 
	
	<script>
		
		$(document).ready(function(){
 	    
  	    $.ajax({
  			url: "../model/Model_busca_categoria.php",
 			type: "GET",
 			success: function(response)
 			{
 					$('#categoria').html(response);
 			}
 		});
});  
	
	</script>
	
</head>

<body>

  <div class="well">  
  
        <div class="modal-content">

        	<div class="modal-body"> 
                    
                
                <form action="View-inv_pvp?action=add&id=<?php echo $_GET['id']; ?>" method="post" enctype="application/x-www-form-urlencoded" accept-charset="UTF-8">
                      
                  	   			 <div style="padding-top: 5px;" class="col-md-12"><h5> Actualizar Precio de Venta</h5></div>
                       			  
					
							      <div style="padding-top: 5px;" class="col-md-2"> % Venta</div> 
							      
                                   <div style="padding-top: 5px;" class="col-md-4">
									   
                                         <select name="monto"  class="form-control required"  required="required" id="monto">
											   <option value="20">20%</option>
											   <option value="15">15%</option>
                                               <option value="10">10%</option>
 											</select>
									   
                                   </div> 
					
					
								  <div style="padding-top: 5px;" class="col-md-2"> Categoria</div>  
								
                                  <div style="padding-top: 5px;" class="col-md-4">
                                      
                                          <select name="categoria"  class="form-control required"  required="required" id="categoria">
 											</select>
                                      
                                      
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
								  
                   				      
                                   <div style="padding-top: 5px;" class="col-md-12">
                             			<button type="submit" class="btn btn-success btn-sm">
                            			<span class="glyphicon glyphicon-floppy-saved"></span> Procesar  </button>
 
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
  
   $obj ='';
   $bd  ='';
   $set ='';
  
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
 
 		$porcentaje = 	@$_POST["monto"];
 		
 	    $categoria = 	@$_POST["categoria"];
	 	   
	   
	    $sql1 = "SELECT idproducto, producto  ,tributo, costo,   fob, promedio, fifo
				FROM  web_producto
				where idcategoria = ".$categoria;

 
		$stmt1 = $bd->ejecutar($sql1);

 

		while ($fila=$bd->obtener_fila($stmt1)){

			 $id      =  $fila['idproducto'];
			 $costo   =  $fila['costo'];
			 $tributo =  $fila['tributo'];
			
			$parcial = ($porcentaje/100) *  round($costo,2) ;
			$pbase   =  round($costo,2) + round($parcial,2);
			
			if ( $tributo  == 'I'){
				$pbase  = $pbase * ((12/100)) + $pbase ;
			} 
			
			 $x = $bd->query_array('inv_producto_vta',
							 'id_productov', 
							 'id_producto='.$bd->sqlvalue_inyeccion($id,true)
							); 
			
			if ( $x["id_productov"] > 0 ){
		   
		     
				    $sql = " UPDATE inv_producto_vta
            							              SET 	monto=".$bd->sqlvalue_inyeccion($pbase , true)."
            							      WHERE id_productov=".$bd->sqlvalue_inyeccion($x["id_productov"], true);
            					
            		$bd->ejecutar($sql);
		   
			 } else{
		   
					 
				   $InsertQuery = array(   
                                    array( campo => 'id_producto',   valor => $id  ),
                                    array( campo => 'monto',   valor => $pbase ),
                                    array( campo => 'activo',   valor => 'S'),
                                    array( campo => 'detalle',   valor => 'Normal'),
                                    array( campo => 'principal',   valor => 'S')
                                );
 
                                    
          			$bd->JqueryInsertSQL('inv_producto_vta',$InsertQuery);
				
		     }   
	 
 

			echo  $fila['idproducto'].' ->  ' ;
		}


	   
 
   
	   
 	   $obj->var->kaipi_cierre_pop(); 

 }
 
 
?>
 
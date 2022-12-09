<?php 

	session_start( );  
 	
	require 'SesionInicio.php'; 
	
 
	if (isset($_GET['action']))
	 {
		if (isset($_GET['ref']))
		{
			$id = $_GET['tid'];
			
			$ref = $_GET['ref'];
			
			$action		= $_GET['action'];
            
           	if (isset($_GET['opc'])){
           	    $ref = $_GET['opc'];
           	}
        
	 		/// valida
			$ref_codigo = $ref ;
			
            $id_asiento = $ref ;
			
			$sql = "SELECT estado FROM co_asiento  where id_asiento = ".$bd->sqlvalue_inyeccion($ref_codigo ,true);
 		
			$resultado = $bd->ejecutar($sql);
		
			$datos = $bd->obtener_array( $resultado);
			 
			$digitado =  $datos['estado'] ;
			 
			if (trim($digitado) == 'digitado') {
				
  				K_eventos($action,$ref_codigo,$id,$bd,$obj,$set);
			
			}else{
 			
				 $obj->var->kaipi_cierre_pop();
			}	
		}
	}  
?> 
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
	
    <title>Plataforma de Gestión Empresarial</title>

	<!--=== CSS ===
      <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.0-rc1/css/bootstrap.min.css" />  
    -->
	 
     
  <?php  require('Head.php')  ?>  
    
  <script type="text/javascript" src="../js/kaipi.js"></script>   
  	
  
	<script>

 jQuery.noConflict(); 
 
         jQuery(document).ready(function() {
        	jQuery('#jsontable').DataTable( {      
                 "searching": true,
                 "paging": true, 
                 "info": true,         
                 "lengthChange":false 
            } );
} );
</script>
	
	
</head>
<body>
<!-- topbar starts --><!-- topbar ends -->
<div class="well">
  <div class="modal-dialog" style="left: 0; width: 100%; padding-top: 0; padding-bottom: 10px; margin: 0;">
    <div class="modal-content">
          <div class="modal-body"> 
			  <?php
			  
			   $formulario = 'co_asientosd_cxp';
	
			   $anio       =  $_SESSION['anio'];
	
			  
               $ruc_registro = $_SESSION['ruc_registro'];
               
               $sql = "SELECT cuenta,detalle, aux as auxiliar
                        FROM co_plan_ctas
                        where estado = 'S' and univel = 'S' and  
						      anio =".$bd->sqlvalue_inyeccion($anio ,true)." and 
							  registro =".$bd->sqlvalue_inyeccion($ruc_registro ,true)." order by cuenta";
                    
						$resultado  = $bd->ejecutar($sql);
                        $tipo 		= $bd->retorna_tipo();
                        $action		= 'agregar';
            
                        if (isset($_GET['ref'])){
                            $ref = $_GET['ref'];
                        }			
                        
                        if (isset($_GET['opc'])){
                            $ref = $_GET['opc'];
                        }
            
                        $obj->grid->KP_GRID_CTA_SE($resultado,$tipo,'cuenta',$formulario,'S','',$action,'','&ref='.$ref);  
	
            ?>												
       </div>
    </div>
   </div>  
  </div>
</body>
</html>
<?php
// primera opcion para las ventanas operativas
 function K_eventos( $opcion,$ref,$id,$bd,$obj,$set){
 	
   
 	if  ($opcion == 'agregar'){
 	   		K_agregar($ref,$id ,$bd,$obj,$set);
 	}	
  		
  }
/////////////// llena datos de la consulta individual
 function K_agregar($id_asiento,$cuenta,$bd,$obj,$set ){
 
  
   	 $sql = "SELECT * FROM co_asiento  where id_asiento = ".$bd->sqlvalue_inyeccion($id_asiento ,true);
  	 
  	 $resultado = $bd->ejecutar($sql);
  	 $datos1 = $bd->obtener_array($resultado);
	 
	 $id_periodo = $datos1["id_periodo"];
	 $anio  = $datos1["anio"];
	 $mes  = $datos1["mes"];
	 
	// parametros kte 
	 $sesion 	 = $_SESSION['email'];
 	 $hoy 		 = $bd->hoy();
	 $ruc 		 = $_SESSION['ruc_registro'];
	 $cuenta	 = trim($cuenta);

	 $sqlaux = "SELECT aux
	  FROM co_plan_ctas  where cuenta = ".$bd->sqlvalue_inyeccion($cuenta ,true);
  	
     $resultado = $bd->ejecutar($sqlaux);
  	 $datosaux = $bd->obtener_array( $resultado);
	 $aux		= $datosaux['aux'];
	 
		 $sql = "INSERT INTO co_asientod(
				id_asiento, cuenta, aux,debe, haber, id_periodo, anio, mes,
				sesion, creacion, registro)
				VALUES (".
						$bd->sqlvalue_inyeccion($id_asiento , true).",".
						$bd->sqlvalue_inyeccion( $cuenta, true).",".
						$bd->sqlvalue_inyeccion( $aux, true).",".
						$bd->sqlvalue_inyeccion(0, true).",".
						$bd->sqlvalue_inyeccion(0, true).",".
						$bd->sqlvalue_inyeccion( $id_periodo, true).",".
						$bd->sqlvalue_inyeccion( $anio, true).",".
						$bd->sqlvalue_inyeccion( $mes, true).",".
 						$bd->sqlvalue_inyeccion($sesion , true).",".
						$hoy.",".
						$bd->sqlvalue_inyeccion( $ruc , true).")";
 
  	 $resultado = $bd->ejecutar($sql);
 
    
     K_ejecuta_detalle('#DivAsientosTareas','../model/ajax_AsientosGastos.php?id_asiento='.$id_asiento);
     
   
         
     $obj->var->kaipi_cierre_pop();
  
    }	
    	  
   function K_ejecuta_detalle($div,$url ){
     
      echo '<script type="text/javascript">';
      echo "  opener.$('".$div."').load('".$url."');   ";
      echo '</script>';  
        
   }
 
 	  	 
 ?>
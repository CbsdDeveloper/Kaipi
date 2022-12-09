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
	

 <script type="text/javascript">
	    $('#jsontable').dataTable(); 
   </script>   	
  
	
	
	
</head>
<body>
<!-- topbar starts --><!-- topbar ends -->
<div class="well">
  <div class="modal-dialog" style="left: 0; width: 100%; padding-top: 0; padding-bottom: 10px; margin: 0;">
    <div class="modal-content">
          <div class="modal-body"> 
			  <?php
	
	
			$anio       =  $_SESSION['anio'];
	
			  
			   $formulario = 'co_asientosd_ant';
			  
               $ruc_registro = $_SESSION['ruc_registro'];
    
               if (isset($_GET['opc'])){
                            $ref = $_GET['opc'];
                
               
                   $sql = "SELECT idprov FROM co_asiento  where id_asiento = ".$bd->sqlvalue_inyeccion($ref ,true);

                $resultado = $bd->ejecutar($sql);

                $datos = $bd->obtener_array( $resultado);

                $idprov =  $datos['idprov'] ;
                   
                   
               }
    
 			  $cadena = " || '   '  ";
               
               $sql = "SELECT cuenta, idprov  ".$cadena." as identificacion, razon, debe, haber, saldo 
                        FROM  view_aux_saldos
                        where registro = ".$bd->sqlvalue_inyeccion($ruc_registro ,true)."  and 
                             tipo_cuenta in  ('J','N','O','C','P') and saldo > 0 and 
                             idprov=".$bd->sqlvalue_inyeccion($idprov ,true);
               
 
						
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
 
	 	$anio       =  $_SESSION['anio'];
    
   	 $sql = "SELECT * FROM co_asiento  where id_asiento = ".$bd->sqlvalue_inyeccion($id_asiento ,true);
  	 
  	 $resultado = $bd->ejecutar($sql);
	 
  	 $datos1      = $bd->obtener_array($resultado);
	 $id_periodo  = $datos1["id_periodo"];
	 $mes         = $datos1["mes"];
     $idprov      = $datos1['idprov'] ;
	 // parametros kte 
	 $sesion 	 = $_SESSION['email'];
 	 $hoy 		 = $bd->hoy();
	 $ruc 		 = $_SESSION['ruc_registro'];
	 $cuenta	 = trim($cuenta);

     //---------- saldos
      $sql1 = "SELECT saldo 
                FROM view_aux_saldos  
               where  idprov = ".$bd->sqlvalue_inyeccion($idprov ,true)." and
                      cuenta = ".$bd->sqlvalue_inyeccion($cuenta ,true)." and
                      tipo_cuenta in  ('J','N','O','C','P') and saldo > 0 and 
                      saldo > 0 and
                      registro=".$bd->sqlvalue_inyeccion($ruc ,true);
       
 
  	 $resultado1 = $bd->ejecutar($sql1);
  	 $datos2     = $bd->obtener_array($resultado1);
     $saldo      = $datos2["saldo"];
     //----------------------------------------------------------------------
	 $sqlaux = "SELECT aux
	  			  FROM co_plan_ctas  
				  where cuenta = ".$bd->sqlvalue_inyeccion($cuenta ,true). " and  
				  	    anio = ".$bd->sqlvalue_inyeccion($anio ,true) ;
  	
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
						$bd->sqlvalue_inyeccion( $saldo, true).",".
						$bd->sqlvalue_inyeccion( $id_periodo, true).",".
						$bd->sqlvalue_inyeccion( $anio, true).",".
						$bd->sqlvalue_inyeccion( $mes, true).",".
 						$bd->sqlvalue_inyeccion($sesion , true).",".
						$hoy.",".
						$bd->sqlvalue_inyeccion( $ruc , true).")";
 
  	 $resultado = $bd->ejecutar($sql);
 
    //---------------
	 $x = $bd->query_array('view_aux',
										  'id_asiento,id_asiento_aux,id_asientod,cuenta,haber', 
										  'id_asiento='.$bd->sqlvalue_inyeccion($id_asiento,true) .' and 
										  idprov='.$bd->sqlvalue_inyeccion($idprov,true) .' and 
										  cuenta like '."'213%'"
										 ); 
 
	  $saldo_cxp =  $x['haber'] - $saldo ;
	 
	  $sqledit = "update co_asientod 
	  				 set   haber = ".$bd->sqlvalue_inyeccion($saldo_cxp,true). " 
					 where id_asiento=".$bd->sqlvalue_inyeccion($id_asiento,true) .' and 
						   id_asientod='.$bd->sqlvalue_inyeccion($x['id_asientod'],true) ;
	 
	 $bd->ejecutar($sqledit);								  
									  
	  $sqledit = "update co_asiento_aux 
	  				 set   haber = ".$bd->sqlvalue_inyeccion($saldo_cxp,true). " 
					 where id_asiento=".$bd->sqlvalue_inyeccion($id_asiento,true) .' and 
					       idprov='.$bd->sqlvalue_inyeccion($idprov,true) .' and 
						   id_asientod='.$bd->sqlvalue_inyeccion($x['id_asientod'],true) ;
	 
	 $bd->ejecutar($sqledit);	
     
	 
	  $sqledit = "update co_asiento
	  				 set   apagar = ".$bd->sqlvalue_inyeccion($saldo_cxp,true). " 
					 where id_asiento=".$bd->sqlvalue_inyeccion($id_asiento,true) ;
	 
	 $bd->ejecutar($sqledit);								  
								
	 
	 
     K_ejecuta_detalle('#DivAsientosTareas','../model/ajax_DetAsiento.php?id_asiento='.$id_asiento);
     
   
         
    $obj->var->kaipi_cierre_pop(); 
  
    }	
    	  
   function K_ejecuta_detalle($div,$url ){
     
      echo '<script type="text/javascript">';
      echo "  opener.$('".$div."').load('".$url."');   ";
      echo '</script>';  
        
   }
 
 	  	 
 ?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
 
     <link rel="stylesheet" href="bootstrap.min.css">
	  
     <script src="jquery.min.js"></script>
  
	  <script src="bootstrap.min.js"></script>
 
    <style type="text/css">
	.alert-box {
		color:#555;
		border-radius:10px;
		font-family:Tahoma,Geneva,Arial,sans-serif;
		font-size:13px;
		padding:10px 36px;
		margin:10px;
	}
	.alert-box span {
		font-weight:bold;
		text-transform:uppercase;
	}
	.error {
		background:#ffecec url('../../images/error.png') no-repeat 10px 50%;
		border:1px solid #f5aca6;
	}
	.success {
		background:#e9ffd9 url( "../kimages/alert.png") no-repeat 10px 50%;
		border:1px solid #a6ca8a;
	}
	.warning {
		background:#fff8c4 url('"../kimages/v_interes.png"') no-repeat 10px 50%;
		border:1px solid #f2c779;
	}
	 
    </style>
	  
  </head>

  <body>
	  
	    <div class='col-md-4' style="padding: 5px"> 
	  
<?php
	 session_start( );  

    require '../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    require '../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	  
    $bd	     =	new Db;
			
	$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

	$sesion 	=  trim($_SESSION['email']);
			
	$datos =  $bd-> __user($sesion);
	
	$idpartamento = $datos['id_departamento'];
	
	$UNIDAD = trim($datos['unidad']);
 	
	$anio = date('Y');		
	  
	   $x = $bd->query_array('flow.view_proceso_caso',   // TABLA
	                                'count(*) as nn',                        // CAMPOS
	                                'sesion_actual='.$bd->sqlvalue_inyeccion( $sesion,true) ." and  
									 tipo_doc = 'proceso' and estado in ('1','2','3')"
	        );
			
	    $xx = $bd->query_array('flow.view_doc_tarea',   // TABLA
	                                'count(*) as nn',                        // CAMPOS
	                                'sesion_actual='.$bd->sqlvalue_inyeccion( $sesion,true) ." and  
									 finaliza = 'N' and estado in ('1','2','3','4') and tipo_doc= 'documental'"
	        );
			
			
			
		$yy = $bd->query_array('planificacion.view_tarea_poa',   // TABLA
	                                'count(*) as nn',                        // CAMPOS
	                                'correo='.$bd->sqlvalue_inyeccion( $sesion,true) ." and  
									 cumplimiento <>  'S'  and anio= " .$bd->sqlvalue_inyeccion( $anio,true)
	        );
			
			
			

 
			
		//---------- planificacion
		$sql = "SELECT count(*) as poas
            FROM planificacion.view_tarea_proceso a,
            	 planificacion.sitarea_seg b,
            	 planificacion.view_tarea_poa c
            where a.iddepartamento  = ".$bd->sqlvalue_inyeccion(trim($idpartamento), true)." and
            	  a.cumplio = 'N' and
            	  c.anio = ".$bd->sqlvalue_inyeccion($anio, true)." and
            	  b.idtarea_seg = a.idtarea_seg and
            	  b.idtarea = c.idtarea";
		
		         $resultado  = $bd->ejecutar($sql);
		         $poa_uni    = 0;
		         while ($z=$bd->obtener_fila($resultado)){
		             $poa_uni    = $poa_uni + $z['poas'];
		         }
			
	 
		    $array   = $bd->__user($sesion) ;
			$perfil  = trim($array['tipo']);
			
 			
			if ( $perfil == 'tthh') {
				
				   $xa = $bd->query_array('co_anticipo',     'count(*) as nn',  'estado='.$bd->sqlvalue_inyeccion('tthh',true)   );
				
				if ( $xa['nn'] > 0 ) {
 					echo '<div class="alert-box success"><span> '.$xa['nn'].' ANTICIPOS PENDIENTES: </span> VER BANDEJA DE TRAMITES INTERNOS - ANTICIPOS</div>';
				}
				
			}	
			
			if ( $perfil == 'financiero') {
				
				   $xa = $bd->query_array('co_anticipo',     'count(*) as nn',  'estado='.$bd->sqlvalue_inyeccion('financiero',true)   );
				
				if ( $xa['nn'] > 0 ) {
 					echo '<div class="alert-box success"><span> '.$xa['nn'].' ANTICIPOS PENDIENTES: </span> VER BANDEJA DE TRAMITES INTERNOS - ANTICIPOS</div>';
				}
				
			}	
			
			
		 if ( $perfil == 'planificacion') {
				
				   $xa = $bd->query_array('planificacion.view_reprogramaciones', 'count(*) as nn', 
										  'estado='.$bd->sqlvalue_inyeccion('solicitado',true)  .' and 
										  tipo=' .$bd->sqlvalue_inyeccion('reprogramacion',true)  .' and 
										  anio=' .$bd->sqlvalue_inyeccion($anio ,true)
										 );
				
				if ( $xa['nn'] > 0 ) {
 					echo '<div class="alert-box success"><span> '.$xa['nn'].' REPROGRAMACIONES PENDIENTES: </span> VER BANDEJA DE TRAMITES INTERNOS - REPROGRAMACIONES</div>';
				}
				
			}	
			
		  if ( $perfil == 'admin') {
				
				    $xa = $bd->query_array('planificacion.view_reprogramaciones', 'count(*) as nn', 
										  'estado='.$bd->sqlvalue_inyeccion('solicitado',true)  .' and 
										  tipo=' .$bd->sqlvalue_inyeccion('reprogramacion',true)  .' and 
										  anio=' .$bd->sqlvalue_inyeccion($anio ,true)
										 );
				
				if ( $xa['nn'] > 0 ) {
 					echo '<div class="alert-box success"><span> '.$xa['nn'].' REPROGRAMACIONES PENDIENTES: </span> VER BANDEJA DE TRAMITES INTERNOS - REPROGRAMACIONES</div>';
				}
				
			}	
			
			 

			
			
			
			
			if ( $x['nn'] > 0 ) {
 
			  echo '<div class="alert-box success"><span> '.$x['nn'].' TRAMITES PENDIENTES: </span> VER BANDEJA DE TRAMITES (GESTION WK-PROCESO)</div>';
				  
			}	
			
			
			if ( $xx['nn'] > 0 ) {
 
			  echo '<div class="alert-box success"><span> '.$xx['nn'].' DOCUMENTOS PENDIENTES: </span> VER BANDEJA DE TRAMITES (GESTION DOCUMENTAL)</div>';
				  
			}	
			
			if ( $yy['nn'] > 0 ) {
 
			  echo '<div class="alert-box success"><span> '.$yy['nn'].' TAREAS PENDIENTES PLANIFICADAS: </span><b> VER BANDEJA DE GESTION POA</b></div>';
				  
			}	
			
			if ( $poa_uni > 0 ) {
			    
			    echo '<div class="alert-box success"><span  style="color: #910103"> '.$poa_uni.' TAREAS PENDIENTES  PROCESO FINANCIERO-ADMINISTRATIVO </span><b> VER BANDEJA MODULO '.$UNIDAD.'</b></div>';
			    
			}	
			
			

?>	  
	 
 
		    
		  
   		 
 	  	    
   		</div>       
  

 
  </body>
</html>

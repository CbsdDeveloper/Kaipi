<?php
     session_start( );
     
     require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
     require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
     
     require '../../kconfig/Db.emailMarket.php'; /*Incluimos el fichero de la clase objetos*/
     
     $obj      = 	new objects;
     $bd	   =	new Db;
     
     $mail     =	new EmailEnvio;
     
     $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
     
     $sesion 	    =  trim($_SESSION['email']);
 
     
     $response = 'Error de conexion...';
     
     $mail->_DBconexion( $obj, $bd );
     
     $mail->_smtp_tramites( );
     
     
     $Q_IDPERIODO       = trim($_GET['Q_IDPERIODO']) ;
     
     $Q_IDUNIDAD        = $_GET['Q_IDUNIDAD'];
 
        
     $plantilla = $bd->query_array(
         'ven_plantilla',
         'contenido,   variable',
         'id_plantilla='.$bd->sqlvalue_inyeccion(-4,true)
         );
     
 
          
	$sqlO1= 'SELECT  nombre_funcionario ,correo ,idprov
    FROM planificacion.view_tarea_poa
    WHERE  id_departamento = '.$bd->sqlvalue_inyeccion($Q_IDUNIDAD,true)." and  
            estado = 'S'  and 
            anio =  ".$bd->sqlvalue_inyeccion($Q_IDPERIODO,true).' 
            group by nombre_funcionario ,correo ,idprov' ;

    $stmt_ac = $bd->ejecutar($sqlO1);
 
    
		 while ($x=$bd->obtener_fila($stmt_ac)){
		     
		     $idprov = trim($x['idprov']);
		     
		     $content =  str_replace ( '#NOMBRE' , trim($x['nombre_funcionario']) ,  $plantilla['contenido']);
		     
		     $cadena = Formulario(  $obj, $bd,$idprov,$Q_IDUNIDAD,$Q_IDPERIODO );
		     
 
		     $content =  str_replace ( '#DETALLE' , $cadena ,   $content);
		     
		     
		     $asunto = 'GESTION DE PLANIFICACION INSTITUCIONAL ';
		     
		     $mail->_DeCRM( $sesion, trim($_SESSION['razon']));
		     
		     $mail->_ParaCRM(trim($x['correo']),trim($x['nombre_funcionario']));

		     $mail->_AsuntoCRM($asunto,$content );
		     
		     
		      $response = $mail->_EnviarElectronica();
		     
        }

        echo $response;
/*
 funcion agrupa las tareas
 */
        
 function Formulario(   $obj, $bd,$idprov,$Q_IDUNIDAD,$Q_IDPERIODO ){
     
     
     $tipo = $bd->retorna_tipo();
     
     $sqlO2= 'SELECT  tarea  ,fechainicial as fecha_inicio ,fechafinal as fecha_final , recurso
    FROM planificacion.view_tarea_poa
    WHERE  id_departamento = '.$bd->sqlvalue_inyeccion($Q_IDUNIDAD,true)." and
            estado = 'S'  and
            idprov = ".$bd->sqlvalue_inyeccion($idprov,true) ." and
            anio =  ".$bd->sqlvalue_inyeccion($Q_IDPERIODO,true)  ;
     
     $stmt_ac1 = $bd->ejecutar($sqlO2);
     
     $tabla =     $obj->grid->KP_GRID_EXCEL($stmt_ac1,$tipo);
    
     
     pg_free_result ($stmt_ac1) ;
     
      return  $tabla;
     
            
   }
     
     
  
     
      
?>
 
  
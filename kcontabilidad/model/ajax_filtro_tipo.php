<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 	$bd	   = new Db ;
 	
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

    $anio            =  $_SESSION['anio'];

    $ruc             =  $_SESSION['ruc_registro'];

    $tipo            =	trim($_GET["tipo"]);

    $sql ="select trim(cuenta) as codigo, (trim(cuenta) || '.' || trim(detalle))  as nombre
            									   from co_plan_ctas
            									   where univel = 'N'  and 
                                                         anio = ". $bd->sqlvalue_inyeccion($anio ,true)." and
                                                         tipo = ". $bd->sqlvalue_inyeccion($tipo ,true)." and
                                                         registro=". $bd->sqlvalue_inyeccion( $ruc,true)."
												  order by 1";


   $stmt = $bd->ejecutar($sql);
    
       while ($x=$bd->obtener_fila($stmt)){

        $codigo = trim($x["codigo"]);

        $nombre = trim($x["nombre"]);

        echo '<option value="'.$codigo.'" >'.$nombre.'</option>';

     }
  
?>
 
  
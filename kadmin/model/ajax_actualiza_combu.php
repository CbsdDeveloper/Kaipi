<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

 
$bd	   = new Db ;

 
$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);


$txtcodigo =  $_POST['id_combus'];

$ubicacion_salida =  trim($_POST['ubicacion_salida']);
$u_km_inicio      =  $_POST['u_km_inicio'];
$tipo_comb        =  trim($_POST['tipo_comb']);
$costo            =  $_POST['costo'];
$cantidad         =  $_POST['cantidad'];
$medida           =  trim($_POST['medida']);

$cantidad_ca      =  $_POST['cantidad_ca'];


$fecha_modifica = date('Y-m-d');

$sql = "UPDATE adm.ad_vehiculo_comb
            SET
            ubicacion_salida =".$bd->sqlvalue_inyeccion($ubicacion_salida,true).",
            u_km_inicio =".$bd->sqlvalue_inyeccion($u_km_inicio,true).",
            tipo_comb =".$bd->sqlvalue_inyeccion($tipo_comb,true).",
            medida =".$bd->sqlvalue_inyeccion($medida,true).",
            cantidad_ca =".$bd->sqlvalue_inyeccion($cantidad_ca,true).",
            estado =".$bd->sqlvalue_inyeccion('autorizado',true).",
            fecha_modifica=".$bd->sqlvalue_inyeccion($fecha_modifica,true).",
            costo =".$bd->sqlvalue_inyeccion($costo,true).",
            cantidad =".$bd->sqlvalue_inyeccion($cantidad,true)."
		   WHERE id_combus =".$bd->sqlvalue_inyeccion($txtcodigo,true) ;


  $bd->ejecutar($sql);
 

  echo 'DATOS ACTUALIZADOS CON EXITO....';
 



?>
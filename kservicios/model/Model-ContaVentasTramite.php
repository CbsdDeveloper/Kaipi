<?php
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/

 
 
$bd	   =	new  Db ;


$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

 
$anio          = $_SESSION['anio'] ;
 
 
$id_tramite = $_GET["id_tramite"];
$fecha_caja = $_GET["fecha_caja"];
$parte_caja = trim($_GET["parte_caja"]);
 

$sql = "UPDATE co_asientod_manual
							    SET 	tramite  =".$bd->sqlvalue_inyeccion($id_tramite, true)."
							      WHERE parte=".$bd->sqlvalue_inyeccion(trim($parte_caja),true)."  and
                                       fecha=" .$bd->sqlvalue_inyeccion($fecha_caja,true)." and cuenta like '63%'";

$bd->ejecutar($sql);
 
echo 'Enlace generado';
?>
<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
 

$bd	   =	new Db;

$idprov        = $_GET['idprov'];
$razon         = strtoupper($_GET['razon']);
$direccion     = strtoupper($_GET['direccion']);
$correo        = $_GET['correo'];
  


$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
$sql1 = " UPDATE par_ciu
			 SET  razon       =".$bd->sqlvalue_inyeccion(trim($razon), true).",
                  correo      =".$bd->sqlvalue_inyeccion(trim($correo), true).",
				  direccion   =".$bd->sqlvalue_inyeccion(trim($direccion), true)."
			WHERE idprov      =".$bd->sqlvalue_inyeccion(trim($idprov), true);

$bd->ejecutar($sql1);



 

$asignado = 'DATO ACTUALIZADO CON EXITO '.$idprov;

echo $asignado;



?>
								
 
 
 
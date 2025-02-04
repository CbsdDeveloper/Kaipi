<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
 

$bd	   =	new Db;

$id        = $_GET['id'];
$num_carro         = trim($_GET['num_carro']);
$hora              = trim($_GET['hora']);
 

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
 


$sql1 = " UPDATE rentas.ren_fre_mov
			 SET  hora       =".$bd->sqlvalue_inyeccion(trim($hora), true).",
				  num_carro   =".$bd->sqlvalue_inyeccion(trim($num_carro), true)."
			WHERE id_fre_mov      =".$bd->sqlvalue_inyeccion($id, true);

$bd->ejecutar($sql1);



 
$asignado = 'DATO ACTUALIZADO CON EXITO '.$idprov;

echo $asignado;



?>
								
 
 
 
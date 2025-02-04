<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/



$bd	   =	new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

$id         = $_GET['id'];
$estado     = trim($_GET['estado']);
$codigo     = $_GET['codigo'];


$campo = 'h'.$codigo;

 

 
    $sql = 'update medico.ate_medica
            set '.$campo.' = '.$bd->sqlvalue_inyeccion($estado ,true).' 
            where id_atencion = '.$bd->sqlvalue_inyeccion($id ,true);
 

  

  $bd->ejecutar($sql);


 
 
  echo 'Informacion actualizada: '.$estado;
    
 


?>
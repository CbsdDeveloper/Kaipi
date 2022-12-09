<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

 
$bd	   = 	new Db ;
 

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

 
$id_acta	=  $_GET["id_acta"] ;
$id	        =  $_GET["id"] ;
$accion     =  $_GET["accion"] ;


$sesion 	 =     trim($_SESSION['email']);

$hoy 	     =     date("Y-m-d");    	
 
$ATabla_acta = array(
    array( campo => 'id_acta_det',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
    array( campo => 'estado',tipo => 'VARCHAR2',id => '1',add => 'S', edit => 'N', valor => 'N', key => 'N'),
    array( campo => 'id_acta',tipo => 'NUMBER',id => '2',add => 'S', edit => 'N', valor => $id_acta, key => 'N'),
    array( campo => 'id_bien',tipo => 'NUMBER',id => '3',add => 'S', edit => 'N', valor =>$id, key => 'N'),
    array( campo => 'sesion',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => $sesion, key => 'N'),
    array( campo => 'creacion',tipo => 'DATE',id => '5',add => 'S', edit => 'S', valor =>  $hoy, key => 'N')
);


if ( $accion == 'agregar') {
    $bd->_InsertSQL('activo.ac_movimiento_det',$ATabla_acta , 'activo.ac_movimiento_det_id_acta_det_seq');
    
}
     

if ( $accion == 'eliminar') {
    $sql = 'delete from activo.ac_movimiento_det  where id_acta_det='.$bd->sqlvalue_inyeccion($id, true);
    $bd->ejecutar($sql);
    
}
    
     
    echo 'Datos Guardados correctamente';



?>
 
  
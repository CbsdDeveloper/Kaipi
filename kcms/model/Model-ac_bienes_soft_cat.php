<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


 
$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

 

$tipo       = $_POST['tipo'];
$categoria  = $_POST['categoria'];
$detalle    = $_POST['detalle'];
$licencia   = $_POST['licencia'];
$id_software= $_POST['id_software'];


$sesion 	 =     trim($_SESSION['email']);
$hoy 	     =     date("Y-m-d");  

$ATabla = array(
    array( campo => 'id_software',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
    array( campo => 'tipo',tipo => 'VARCHAR2',id => '1',add => 'S', edit => 'S', valor => $tipo, key => 'N'),
    array( campo => 'categoria',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => $categoria, key => 'N'),
    array( campo => 'detalle',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor =>$detalle, key => 'N'),
    array( campo => 'sesion',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'N', valor =>$sesion, key => 'N'),
    array( campo => 'creacion',tipo => 'DATE',id => '5',add => 'S', edit => 'N', valor => $hoy, key => 'N'),
    array( campo => 'sesionm',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => $sesion, key => 'N'),
    array( campo => 'modificacion',tipo => 'DATE',id => '7',add => 'S', edit => 'S', valor =>$hoy, key => 'N'),
    array( campo => 'archivo',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor => '-', key => 'N'),
    array( campo => 'licencia',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'S', valor => $licencia, key => 'N'),
);

if ( $id_software > 0  ) {
    $bd->_UpdateSQL('flow.itil_software',$ATabla,$id_software);
    
}else {
    $bd->_InsertSQL('flow.itil_software',$ATabla, 'flow.itil_software_id_software_seq');
}

echo 'Registro procesado correctamente...'


?>
 
  
<?php

session_start();

require '../../kconfig/Db.class.php';  
require '../../kconfig/Obj.conf.php';  
 

$bd	   =	 	new Db ;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
$id_rubro  = $_GET['rubro'] ;

$tramite  = $_GET['tramite'] ;

$sesion 	 =  trim($_SESSION['email']);

$sql = 'delete from rentas.ren_temp 
where sesion= '.$bd->sqlvalue_inyeccion($sesion ,true);

$bd->ejecutar($sql);


$sql = 'SELECT id_ren_tramite_var, id_ren_tramite, id_rubro_var, 
               id_rubro, valor_variable, sesion ,nombre_variable,
               variable
          FROM rentas.view_ren_tramite_var
        where id_rubro= '.$bd->sqlvalue_inyeccion($id_rubro, true).' and 
               id_ren_tramite='.$bd->sqlvalue_inyeccion($tramite, true);

 
 
$resultado	= $bd->ejecutar($sql);

echo '<script>';
while ($x=$bd->obtener_fila($resultado)){
    //$objeto  = trim($x['nombre_variable']).'_'.$x['id_rubro_var'].'_'.$id_rubro ;
   
    $objeto  = trim($x['variable']);
     
    $nombre  = trim($x['valor_variable']);
    
    echo '$("#'.$objeto.'").val('."'".$nombre."'".');';
}
echo '</script>';

$div_mistareas = ' ';

echo $div_mistareas;
?>
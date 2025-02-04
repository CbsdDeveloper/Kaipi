<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/


$bd	   =	new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);


$iddet          = $_GET['iddet'];
$idtramite      = $_GET['idtramite'];
$vmonto         = $_GET['vmonto'];
 
$x = $bd->query_array('presupuesto.pre_tramite_det',
                     'partida, iva', 
                     'id_tramite_det='.$bd->sqlvalue_inyeccion($iddet,true)
    );


if ( $x['iva']  > 0 ){
    $parcial   = $vmonto / 1.12;
    $monto_iva = $vmonto - round($parcial,2);
}else{
    $monto_iva=0;
}

$y = $bd->query_array('presupuesto.pre_tramite_temp',
    'id_tramite_temp',
    'id_tramite_det='.$bd->sqlvalue_inyeccion($iddet,true). ' and 
         id_tramite='.$bd->sqlvalue_inyeccion($idtramite,true). ' and estado='.$bd->sqlvalue_inyeccion('N',true)
    );

$ATabla = array(
    array( campo => 'id_tramite_temp',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
    array( campo => 'id_tramite',tipo => 'NUMBER',id => '1',add => 'S', edit => 'N', valor => $idtramite, key => 'N'),
    array( campo => 'id_tramite_det',tipo => 'NUMBER',id => '2',add => 'S', edit => 'N', valor => $iddet, key => 'N'),
    array( campo => 'partida',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'N', valor => $x['partida'] , key => 'N'),
    array( campo => 'monto',tipo => 'NUMBER',id => '4',add => 'S', edit => 'S', valor => $vmonto, key => 'N'),
    array( campo => 'iva',tipo => 'NUMBER',id => '5',add => 'S', edit => 'S', valor => $monto_iva, key => 'N'),
    array( campo => 'sesion',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => trim($_SESSION['email']), key => 'N'),
    array( campo => 'estado',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'N', valor => 'N' , key => 'N'),
);

if ( $y['id_tramite_temp']  > 0 ){
    
    $bd->_UpdateSQL('presupuesto.pre_tramite_temp',$ATabla, $y['id_tramite_temp']);
    
}else{
    $bd->_InsertSQL('presupuesto.pre_tramite_temp',$ATabla,'presupuesto.pre_tramite_temp_id_tramite_temp_seq'); 
}



?>

 
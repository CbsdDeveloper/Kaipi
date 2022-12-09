<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/



$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

$anio       =  $_SESSION['anio'];

$idprov_funcionario   = trim( $_POST["idprov_funcionario"]);

$saldo_anterior   =  $_POST["saldo_anterior"];
$dias_derecho    =  $_POST["dias_derecho"];

$ajuste    =  $_POST["ajuste"];

  

$variable = $bd->query_array('view_nomina_rol',
'id_cargo,idprov,fecha',
'idprov='.$bd->sqlvalue_inyeccion(trim($idprov_funcionario),true) 
);
     
$sesion 	 =  trim($_SESSION['email']);
$hoy 	     =  date("Y-m-d");    
        
 

$ATabla = array(
    array( campo => 'id_cvacacion',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
    array( campo => 'idprov',tipo => 'VARCHAR2',id => '1',add => 'S', edit => 'N', valor => $idprov_funcionario, key => 'N'),
    array( campo => 'estado',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => 'S', key => 'N'),
    array( campo => 'fecha_in',tipo => 'DATE',id => '3',add => 'S', edit => 'N', valor => $variable['fecha'], key => 'N'),
    array( campo => 'saldo_anterior',tipo => 'NUMBER',id => '4',add => 'S', edit => 'S', valor =>$saldo_anterior , key => 'N'),
    array( campo => 'dias_derecho',tipo => 'NUMBER',id => '5',add => 'S', edit => 'S', valor => $dias_derecho, key => 'N'),
    array( campo => 'dias_tomados',tipo => 'NUMBER',id => '6',add => 'S', edit => 'N', valor => '0.00', key => 'N'),
    array( campo => 'dias_pendientes',tipo => 'NUMBER',id => '7',add => 'S', edit => 'N', valor => '0.00', key => 'N'),
    array( campo => 'sesion',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor => $sesion, key => 'N'),
    array( campo => 'fecha',tipo => 'DATE',id => '9',add => 'S', edit => 'S', valor => $hoy , key => 'N'),
    array( campo => 'horas_tomadas',tipo => 'NUMBER',id => '10',add => 'S', edit => 'N', valor => '0.00', key => 'N'),
    array( campo => 'horas_dias',tipo => 'NUMBER',id => '11',add => 'S', edit => 'N', valor => '0.00', key => 'N'),
    array( campo => 'dias',tipo => 'NUMBER',id => '12',add => 'S', edit => 'N', valor => '0.00', key => 'N'),
    array( campo => 'periodo',tipo => 'VARCHAR2',id => '13',add => 'S', edit => 'N', valor =>$anio  , key => 'N'),
    array( campo => 'ajuste',tipo => 'NUMBER',id => '14',add => 'S', edit => 'S', valor =>$ajuste  , key => 'N'),
    );
 
    
    $x = $bd->query_array('nom_cvacaciones',
    'id_cvacacion',
    'idprov='.$bd->sqlvalue_inyeccion(trim($idprov_funcionario),true) . ' and 
     periodo='.$bd->sqlvalue_inyeccion($anio,true)
    );
 
    $tabla = 'nom_cvacaciones';

  if ( $x['id_cvacacion'] > 0 ) {
     $id = $x['id_cvacacion'];
     $bd->_UpdateSQL($tabla,$ATabla,$id);

  }else{
    $idseq = 'nom_cvacaciones_id_cvacacion_seq';
    $id = $bd->_InsertSQL($tabla,$ATabla,$idseq);
}

echo 'Actulizada informacion...'. $id ;

?>
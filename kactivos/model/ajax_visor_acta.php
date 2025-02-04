<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/



$bd	   =	new Db;
$obj     = 	new objects;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

 
$canio   = $_GET['canio'] ;
$cmes    = intval($_GET['cmes']) ;
 
$tipo    = $bd->retorna_tipo();


    $qquery = array(
        array( campo => "id_acta || ' '",    valor => '-',  filtro => 'N',   visor => 'S'),
        array( campo => 'anio',valor => $canio,filtro => 'S', visor => 'N'),
        array( campo => 'mes',valor => $cmes ,filtro => 'S', visor => 'N'),
        array( campo => 'tipo',valor => 'A',filtro => 'S', visor => 'N'),
        array( campo => 'fecha',valor => '-',filtro => 'N', visor => 'S'),
        array( campo => 'clase_documento',valor => '-',filtro => 'N', visor => 'S'),
        array( campo => "documento || ' ' " ,valor => '-',filtro => 'N', visor => 'S'),
        array( campo => "idprov || ' ' ",valor => '-',filtro => 'N', visor => 'S') ,
        array( campo => 'razon',valor => '-',filtro => 'N', visor => 'S'),
        array( campo => 'unidad',valor => '-',filtro => 'N', visor => 'S')
      );
    
   

    $bd->_order_by('documento asc');
    
    $resultado = $bd->JqueryCursorVisor('activo.view_acta',$qquery );
    
    $obj->table->table_basic_js($resultado, // resultado de la consulta
    $tipo,      // tipo de conexoin
    '',         // icono de edicion = 'editar' - seleccion
    '',			// icono de eliminar = 'del'
    '' ,        // evento funciones parametro Nombnre funcion - codigo primerio
    "Codigo,Fecha,Clase,Nro Acta, Identificacion,Custodio,Unidad" , // nombre de cabecera de grill basica,
    '10px',      // tamaño de letra
    'id'         // id
   );
     
     

?>
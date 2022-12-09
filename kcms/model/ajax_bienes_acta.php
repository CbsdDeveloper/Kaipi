<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/



$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);




    $codigo   = $_GET['idacta'] ;
 
 
    $qcabecera = array(
        array(etiqueta => 'id_acta',campo => 'id_acta',ancho => '0%', filtro => 'S', valor => $codigo, indice => 'S', visor => 'N'),
        array(etiqueta => 'Nro.Bien',campo => 'id_bien',ancho => '5%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
        array(etiqueta => 'Clase',campo => 'clase',ancho => '15%', filtro => 'N', valor => '-', indice => 'N', visor => 'N'),
        array(etiqueta => 'Tipo',campo => 'tipo_bien',ancho => '10%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
        array(etiqueta => 'Detalle',campo => 'descripcion',ancho => '40%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
        array(etiqueta => 'Serie',campo => 'serie',ancho => '10%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
        array(etiqueta => 'Estado',campo => 'estado_bien',ancho => '10%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
        array(etiqueta => 'Adquisicion',campo => 'costo_adquisicion',ancho => '10%', filtro => 'N', valor => '-', indice => 'N', visor => 'S')
    );
    
    $bd->JqueryArrayTable('activo.view_acta_detalle',$qcabecera,$acciones,$funcion,'tabla_aux' );
     

?>
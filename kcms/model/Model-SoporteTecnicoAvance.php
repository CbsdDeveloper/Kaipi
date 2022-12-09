<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);


$idtiket        = $_GET['idtiket'];

$carpeta        =  $bd->query_array('wk_config',
    '*',
    'tipo='.$bd->sqlvalue_inyeccion(2,true). ' AND
		   					         registro = '.$bd->sqlvalue_inyeccion($_SESSION['ruc_registro'] ,true)
    );

$imagen 	 = $carpeta['carpetasub'].trim($_SESSION['foto']);
$stmt1       =  $bd->query_cursor(
    'flow.view_itil_tiket_his',                             // tabla
    "*",                                                   // campos
    "id_tiket = ".$bd->sqlvalue_inyeccion($idtiket,true) , // condicion
    '',                         // grupo
    'id_tiket_msj desc',        // orden
    '',                         // limit
    '0',                       // offet
    '0'                        // debug 0 | 1 ver sql
    );


while ($fila=$bd->obtener_fila($stmt1)){
    
    $tecnico             = trim($fila['tecnico']);
    $fecha               = $bd->_formato_fecha($fila['fecha']);
    $tipo                = trim($fila['tipo']);
    
    if ( trim($tipo) == '0'){
        
        $imagen = '../../kimages/socio.png';
        
    }
    
    echo '<div class="col-md-12" style="padding: 10px">
              <div class="media-left">
                    <img src="'.$imagen.'" class="media-object" style="width:24px">
              </div>
              <div class="media-body">
                 <h4 class="media-heading"><b>'.$tecnico.'</b><small> <i> Enviado '.$fecha.'</i></small></h4>
              <p>';
    
    echo   $fila['mensaje']  ;
    
    echo '</p></div></div>';
    
}


?>
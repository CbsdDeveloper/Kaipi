<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


$obj   = 	new objects;
$bd	   =	new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

$ruc       =  $_SESSION['ruc_registro'];


$estado        = $_GET['estado'];
$pagina        = $_GET['pagina'];



$filtro = '';
$valor = '';


$ruc       =  $_SESSION['ruc_registro'];
$sesion    =  $_SESSION['email'];


if ($pagina < 0 ){
    $pagina = 0;
}

$Responsable = $bd->query_array('par_usuario',
    'responsable', 'email='.$bd->sqlvalue_inyeccion($sesion,true)
    );


if ($Responsable['responsable'] == 'S'){
    
    $usuario_where =    ' ';
    
}
else {
    
    $usuario_where =    ' and  sesion ='.$bd->sqlvalue_inyeccion( trim($sesion), true) ;
}

 

if ( $estado == '-'){
    
    $sql1 = 'SELECT idven_gestion, idprov, razon, estado, medio, canal, sesion, 
                    novedad, fecha, producto, porcentaje, factura, vendedor, registro, modulo
                  FROM  ven_cliente_gestion
                  where registro = '.$bd->sqlvalue_inyeccion( $ruc, true) ." and  
                       modulo = 'CO'  and estado =".$bd->sqlvalue_inyeccion( $estado, true) .
                  $usuario_where.' order by fecha desc
                  OFFSET '.$pagina.' LIMIT 8' ;
                  
}else
{
    $sql1 = 'SELECT idven_gestion, idprov, razon, estado, medio, canal, sesion, 
                    novedad, fecha, producto, porcentaje, factura, vendedor, registro, modulo
                  FROM  ven_cliente_gestion
                  where registro = '.$bd->sqlvalue_inyeccion( $ruc, true) ." and 
                       modulo = 'CO'  and estado =".$bd->sqlvalue_inyeccion( $estado, true).
                     $usuario_where.' order by   fecha desc
                  OFFSET '.$pagina.' LIMIT 8' ;
}


 

$stmt1 = $bd->ejecutar($sql1);



while ($fila=$bd->obtener_fila($stmt1)){
    
     $idprov             = trim($fila['idprov']);
     $idvengestion       = trim($fila['idven_gestion']);
     $nombre             = "'".trim($fila['razon'])."'";
     
     $accion = 'editar';
    
      $eventoHistorial =  ' onClick="'.'VerHistorial('."'".$idprov."',".$nombre.','.$idvengestion.')" ';
     
      $eventoGo =  ' onClick="'.'goToURLEditor('."'".$accion."',"."'".$idprov."',".$idvengestion.','.$nombre.')" ';
       
    $eventoModal =   $fila['fecha'] ;
     
    $BandejaDatos = ' <a href="#" class="list-group-item">
                        <span class="glyphicon glyphicon-star-empty"></span>
                        <span class="name" style="min-width: 120px; display: inline-block;" '.$eventoHistorial.'>
                        <b>'.$idvengestion.' . '.trim($fila['razon']).'</b></span> 
                        <span class="" '.$eventoHistorial.' style="font-size: 12px;"> '.trim($fila['sesion']).'</span> 
                        <span class="text-muted" '.$eventoHistorial.' style="font-size: 12px;"> - '.substr(trim($fila['novedad']),0,150).'... </span> 
                        <span class="badge" title="Visualizar informacion" '.$eventoGo.' >'.$eventoModal.' &nbsp;
                        <span class="glyphicon glyphicon-edit" onClick="#"></span></span> <span class="pull-right"> </span> 
                    </a>';
    
    echo $BandejaDatos;
}



?>
 
  
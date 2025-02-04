<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


 
$bd	   =	new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

$ruc       =  $_SESSION['ruc_registro'];


$estado        = $_GET['estado'];
$pagina        = $_GET['pagina'];

 

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
    
    $sql1 = 'SELECT fecha, sesion,detalle, acceso,razon,idprov
                  FROM  ven_cliente
                  where registro = '.$bd->sqlvalue_inyeccion( $ruc, true) .' and  
                       id_campana <> 0  and estado ='.$bd->sqlvalue_inyeccion( $estado, true) .
                  $usuario_where.' order by razon
                  OFFSET '.$pagina.' LIMIT 6' ;
                  
}else
{
    $sql1 = 'SELECT fecha, sesion,detalle, acceso,razon,idprov
                  FROM  ven_cliente
                  where registro = '.$bd->sqlvalue_inyeccion( $ruc, true) .' and 
                        id_campana <> 0 and estado ='.$bd->sqlvalue_inyeccion( $estado, true).
                  $usuario_where.' order by razon
                  OFFSET '.$pagina.' LIMIT 6' ;
}

 

$stmt1 = $bd->ejecutar($sql1);



while ($fila=$bd->obtener_fila($stmt1)){
    
    $id     = trim($fila['idprov']);
    
    $ASeguimiento = $bd->query_array('ven_cliente_seg',
        'COALESCE (idvengestion, 0) as idvengestion', 
        'idprov='.$bd->sqlvalue_inyeccion($id,true).' and registro = '.$bd->sqlvalue_inyeccion( $ruc, true) 
        );
    
 
    if (empty($ASeguimiento['idvengestion'])){
        $idvengestion = 0;
        $accion = 'add';
    }else {
        $idvengestion =  $ASeguimiento['idvengestion'];
        $accion = 'editar';
    }
       
     $nombre = "'".trim($fila['razon'])."'";
    
     $eventoHistorial =  ' onClick="'.'VerHistorial('."'".$id."',".$nombre.','.$idvengestion.')" ';
     
    $eventoGo =  ' onClick="'.'goToURLEditor('."'".$accion."',"."'".$id."',".$idvengestion.','.$nombre.')" ';
       
    $eventoModal =   $fila['fecha'] ;
     
    $BandejaDatos = ' <a href="#" class="list-group-item"><span class="glyphicon glyphicon-star-empty"></span><span class="name" style="min-width: 120px; display: inline-block;" '.$eventoHistorial.'><b>'.trim($fila['razon']).'</b></span> <span class="" '.$eventoHistorial.' style="font-size: 12px;"> '.trim($fila['sesion']).'</span> <span class="text-muted" '.$eventoHistorial.' style="font-size: 12px;"> - '.substr(trim($fila['detalle']),0,90).'... </span> <span class="badge" title="Visualizar informacion" '.$eventoGo.' >'.$eventoModal.' &nbsp;<span class="glyphicon glyphicon-edit" onClick="#"></span></span> <span class="pull-right"> </span> </a>';
    
    echo $BandejaDatos;
}



?>
 
  
<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


$obj   = 	new objects;
$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);


 
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
    
    $sql1 = 'SELECT fecha, sesion,detalle, acceso,razon,idprov
                  FROM  ven_cliente
                  where  id_campana <> 0  and estado ='.$bd->sqlvalue_inyeccion( $estado, true) .
                        $usuario_where.' order by razon
                  OFFSET '.$pagina.' LIMIT 6' ;
    
}else
{
    $sql1 = 'SELECT fecha, sesion,detalle, acceso,razon,idprov
                  FROM  ven_cliente
                  where  id_campana <> 0 and estado ='.$bd->sqlvalue_inyeccion( $estado, true).  
                        $usuario_where.' order by razon
                  OFFSET '.$pagina.' LIMIT 6' ;
}
 
$stmt1 = $bd->ejecutar($sql1);

 

while ($fila=$bd->obtener_fila($stmt1)){
    
    $enlace ='';
      
    $id     = $fila['idprov'];
    $nombre = "'".trim($fila['razon'])."'";
  
    $eventoHistorial =  ' onClick="javascript:'.'VerHistorial('."'".$id."',".$nombre.')" ';
    
 
        
    $BandejaDatos = ' <a href="#" class="list-group-item">
                             <span class="glyphicon glyphicon-star-empty"></span>
							<span class="name" 
                                 style="min-width: 120px;
                                 display: inline-block;" '.$eventoHistorial.'><b>'.$fila['razon'].'</b></span> 
							<span class="" '.$eventoHistorial.' style="font-size: 12px;"> '.$fila['sesion'].'</span>
                            <span class="text-muted" '.$eventoHistorial.' style="font-size: 12px;"> - '.substr($fila['detalle'],0,90).'... </span> 
							<span class="badge" onClick="javascript:'.'goToURL('."'editar'".','.$id.')">'.$fila['fecha'].'</span> 
							<span class="pull-right">  
								<span class="glyphicon glyphicon-paperclip" onClick="#"></span>
							</span>
						</a>';
    
    echo $BandejaDatos;
}

    

?>
 
  
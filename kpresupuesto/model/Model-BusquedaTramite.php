<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


$bd	   =	new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

$ruc           =  $_SESSION['ruc_registro'];
$estado        =  $_GET['estado'];
$pagina        =  $_GET['pagina'];

$ruc            =  $_SESSION['ruc_registro'];
 
$anio_ejecuta   = $_SESSION['anio'];


if ($pagina < 0 ){
    $pagina = 0;
}

          
 
 
    $usuario_where =    ' ';
    
 

 
    $sql1 = 'SELECT id_tramite, fecha,anio, mes, detalle, 
                    observacion, sesion, sesion_asigna, creacion, 
                    comprobante, estado, tipo, documento, 
                    id_departamento, idprov, planificado, id_asiento_ref, marca, 
                    solicita, unidad, siglas, iduser_crea, iddepar_crea, user_crea, 
                    rol_crea, iduser_asig, iddepar_asig, user_asig, rol_asig, 
                    iduser_sol, iddepar_sol, fcertifica,fcompromiso,
                    user_sol, rol_sol, proveedor, direccion, telefono, correo, movil
                  FROM  presupuesto.view_pre_tramite
                  where registro = '.$bd->sqlvalue_inyeccion( $ruc, true) ." and 
                        anio =  ".$bd->sqlvalue_inyeccion( $anio_ejecuta, true) ." and 
                        estado =".$bd->sqlvalue_inyeccion( $estado, true).
                        $usuario_where.' order by   id_tramite desc
                  OFFSET '.$pagina.' LIMIT 12' ;
 

    $stmt1 = $bd->ejecutar($sql1);



while ($fila=$bd->obtener_fila($stmt1)){
    
     $id_tramite             = trim($fila['id_tramite']);
     $user_sol               = trim($fila['user_sol']);
     $nombre                 = "'".trim($fila['unidad'])."'";
     
     $accion = 'editar';
    
     $eventoHistorial =  ' onClick="'.'VerHistorial('."'".$id_tramite."',". $nombre .','."'".$user_sol."'".')" ';
     
     $eventoGo        =  ' onClick="'.'goToURLEditor('."'".$accion."',"."'".$id_tramite."',"."'".$user_sol."'".','. $nombre .')" ';
       
     $eventoModal =   $fila['fecha'] ;
     
     $certifica   =  $fila['fcertifica'] ;
     
     $fcompromiso =  $fila['fcompromiso'] ;
     
     $clase = 'glyphicon glyphicon-star-empty';
     
     
     if (empty($certifica)){
         $clase = 'glyphicon glyphicon-star-empty';
     }else {
          if (empty($fcompromiso)){
             $clase = 'glyphicon glyphicon-star';
         }else{
             $clase = 'glyphicon glyphicon-ok';
         }
     }
     
     
     $cc = $bd->query_array('par_usuario',
         'completo,login', 'email='.$bd->sqlvalue_inyeccion(trim($fila['sesion']),true)
         );
     
     
     //-- <span class="pull-right"> </span> 
     
     $title = ' title='."'".trim($fila['detalle'])."' ";
     
     $BandejaDatos = ' <a href="#" class="list-group-item">
                        <span class="'.$clase.'"></span>
                        <span class="name" style="min-width: 20%; display: inline-block;" '.$eventoHistorial.'>
                        <b>'.$id_tramite.' . '.trim($fila['unidad']).'</b></span> 
                        <span class="" '.$eventoHistorial.' style="font-size: 12px;min-width: 10%;"> '.trim($cc['login']).'</span> 
                        <span class="text-muted" '.$eventoHistorial.' style="font-size: 12px;min-width: 70%;"'.$title.'> - '.substr(trim($fila['detalle']),0,100).'</span> 
                        <span class="badge" title="Visualizar informacion" '.$eventoGo.' >'.$eventoModal.' &nbsp;
                        <span class="glyphicon glyphicon-edit" onClick="#"></span></span> 
                    </a>';
    
    echo $BandejaDatos;
}



?>
 
  
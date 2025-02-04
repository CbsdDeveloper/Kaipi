<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


$bd	   =	new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
$estado        = $_GET['estado'];
$pagina        = $_GET['pagina'];
$qbusqueda     = '%'.strtoupper (trim($_GET['qbusqueda'])).'%';

$qmes        = $_GET['qmes'];
$qdetalle    = '%'.  strtoupper(trim($_GET['qdetalle'])).'%';

 
$anio       =  $_SESSION['anio'];

$qtramite      = $_GET['qtramite'];
 

$ruc            =  trim($_SESSION['ruc_registro']);
$sesion         =  trim($_SESSION['email']);

if ($pagina < 0 ){
    $pagina = 0;
}

$Responsable = $bd->query_array('par_usuario',
    'responsable,tipo', 'email='.$bd->sqlvalue_inyeccion($sesion,true)
    );



    if (trim($Responsable['tipo']) == 'admin'){
    
        $usuario_where =    ' ';
        
    }
    else {
        
        if (trim($Responsable['tipo']) == 'financiero'){
            $usuario_where =    ' ';
        }    else {
            $usuario_where =    ' and  sesion ='.$bd->sqlvalue_inyeccion( trim($sesion), true) ;
        }
    }

 

if ( $qtramite > 0){
    
    $sql1 = 'SELECT id_tramite, fecha,anio, mes, detalle,
                    observacion, sesion, sesion_asigna, creacion,
                    comprobante, estado, tipo, documento,
                    id_departamento, idprov, planificado, id_asiento_ref, marca,
                    solicita, unidad, siglas, iduser_crea, iddepar_crea, user_crea,
                    rol_crea, iduser_asig, iddepar_asig, user_asig, rol_asig,
                    iduser_sol, iddepar_sol,
                    user_sol, rol_sol, proveedor, direccion, telefono, correo, movil
                  FROM  presupuesto.view_pre_tramite
                  where registro = '.$bd->sqlvalue_inyeccion( $ruc, true) ." and
                        id_tramite = ".$bd->sqlvalue_inyeccion( $qtramite, true).'   '.
                        $usuario_where.' order by   id_tramite desc
                  OFFSET '.$pagina.' LIMIT 12' ;
}
else{
    
    $longitud        = strlen($_GET['qdetalle']);
  
   
    if ( $qmes == '-'){
        
        if ( $longitud > 4 ){
           $a = " upper(detalle) like ".$bd->sqlvalue_inyeccion( $qdetalle, true);
        }else{
            
            $a = "  upper(unidad) like ".$bd->sqlvalue_inyeccion( $qbusqueda, true);
        }
    
        
        $sql1 = 'SELECT id_tramite, fecha,anio, mes, detalle,
                    observacion, sesion, sesion_asigna, creacion,
                    comprobante, estado, tipo, documento,
                    id_departamento, idprov, planificado, id_asiento_ref, marca,
                    solicita, unidad, siglas, iduser_crea, iddepar_crea, user_crea,
                    rol_crea, iduser_asig, iddepar_asig, user_asig, rol_asig,
                    iduser_sol, iddepar_sol,
                    user_sol, rol_sol, proveedor, direccion, telefono, correo, movil
                  FROM  presupuesto.view_pre_tramite
                  where registro = '.$bd->sqlvalue_inyeccion( $ruc, true) ." and
                         ". $a."   ".
                         $usuario_where.' order by   id_tramite desc
                  OFFSET '.$pagina.' LIMIT 12' ;
        
        
    }else{
        
         
        
        $sql1 = 'SELECT id_tramite, fecha,anio, mes, detalle,
                    observacion, sesion, sesion_asigna, creacion,
                    comprobante, estado, tipo, documento,
                    id_departamento, idprov, planificado, id_asiento_ref, marca,
                    solicita, unidad, siglas, iduser_crea, iddepar_crea, user_crea,
                    rol_crea, iduser_asig, iddepar_asig, user_asig, rol_asig,
                    iduser_sol, iddepar_sol,
                    user_sol, rol_sol, proveedor, direccion, telefono, correo, movil
                  FROM  presupuesto.view_pre_tramite
                  where registro = '.$bd->sqlvalue_inyeccion( $ruc, true) ." and
                        mes = ".$bd->sqlvalue_inyeccion( $qmes, true)." and 
                        anio =".$bd->sqlvalue_inyeccion( $anio, true). " and  
                        estado =".$bd->sqlvalue_inyeccion( $estado, true).
                        $usuario_where.' order by   id_tramite desc
                  OFFSET '.$pagina.' LIMIT 12' ;
        
        
    }
    
   
    
                        
}
 
 
 

    $stmt1 = $bd->ejecutar($sql1);



while ($fila=$bd->obtener_fila($stmt1)){
    
     $id_tramite             = trim($fila['id_tramite']);
     $user_sol               = trim($fila['user_sol']);
     $nombre                 = "'".trim($fila['unidad'])."'";
     
     $accion = 'editar';
    
     $eventoHistorial =  ' onClick="'.'VerHistorialUni('."'".$id_tramite."',". $nombre .','."'".$user_sol."',"."'".trim($fila['estado'])."'".')" ';
     
     $eventoGo        =  ' onClick="'.'goToURLEditor('."'".$accion."',"."'".$id_tramite."',"."'".$user_sol."'".','. $nombre .')" ';
       
     $eventoModal =   $fila['fecha'] ;
     
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
     
     $BandejaDatos = ' <a href="#" class="list-group-item">
                        <span class="'.$clase.'"></span>
                        <span class="name" style="min-width: 20%; display: inline-block;" '.$eventoHistorial.'>
                        <b>'.$id_tramite.' . '.trim($fila['unidad']).'</b></span>
                        <span class="" '.$eventoHistorial.' style="font-size: 12px;min-width: 10%;"> '.trim($cc['login']).'</span>
                        <span class="text-muted" '.$eventoHistorial.' style="font-size: 12px;min-width: 70%;"> - '.substr(trim($fila['detalle']),0,115).'</span>
                        <span class="badge" title="Visualizar informacion" '.$eventoGo.' >'.$eventoModal.' &nbsp;
                        <span class="glyphicon glyphicon-edit" onClick="#"></span></span>
                    </a>';
     
     echo $BandejaDatos;
 
}



?>
 
  
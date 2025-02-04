<?php
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
      
 
    $bd	   =	new Db ;
    
 
    $sesion 	 =  trim($_SESSION['email']);
  
   $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
    

    $_SESSION['pide_secuencia'] = 'S';
    $contenido                 =  $_GET['secuencia'] ;
    $tipo                      =  trim($_GET["tipo"]);
    
    $documento_array           =  $bd->__user( $sesion );
    $unidad                    =  $documento_array['id_departamento'];
    
    
     
    if (trim($tipo) =='Informe'){
        $secuencia      = $contenido+ 1 ;
        $tipo_secuencia = 'informe';
    }
    
    if (trim($tipo) =='Memo'){
        $secuencia      = $contenido + 1 ;
        $tipo_secuencia = 'memo';
    }
    
    if (trim($tipo) =='Notificacion'){
        $secuencia      = $contenido + 1 ;
        $tipo_secuencia = 'notifica';
    }
    
    if (trim($tipo) =='Circular'){
        $secuencia      = $contenido + 1 ;
        $tipo_secuencia = 'circular';
    }
    
    if (trim($tipo) =='Oficio'){
        $secuencia      = $contenido + 1 ;
        $tipo_secuencia = 'oficio';
    }
    
    $sqlima  = "update nom_departamento
                            set ".$tipo_secuencia." =".$bd->sqlvalue_inyeccion($secuencia,true)."
                          where id_departamento = ".$bd->sqlvalue_inyeccion($unidad,true);
    
    $bd->ejecutar($sqlima);
  
    echo 'Secuencia generada...'.$contenido;
    
?>
 
  
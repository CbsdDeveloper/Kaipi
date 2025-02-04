<?php
session_start( );

require '../../kconfig/Db.class.php';   

require '../../kconfig/Obj.conf.php';  

     
    $obj     = 	new objects;
    $bd	   =	new Db ;
 
 
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
    
    $idproceso     = $_GET['idproceso'];
    $idtarea       = $_GET['idtarea'];
    $tipoAcceso    = $_GET['tipo'];
    
    $tipo 		= $bd->retorna_tipo();
     
    $sql = 'SELECT  idproceso ,
                    idtarea  ,
                    documento  ,
                    perfil_documento ,
                    tipo ,
                    estado ,
                    sesion,idtareadoc
      FROM flow.view_unidadProcesodocu
      where idproceso = '.$bd->sqlvalue_inyeccion($idproceso ,true).' and
            idtarea = '.$bd->sqlvalue_inyeccion($idtarea ,true)      ;
     
    
    
    ///--- desplaza la informacion de la gestion
    $resultado  = $bd->ejecutar($sql);
     
    $cabecera =  "Proceso,Tarea,Documento,Perfil,Tipo,Estado,sesion";
   
    if ($tipoAcceso == 'V'){
        $evento   = "";
        $obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
    }else{
        $evento   = "delDocumento-7";
        $obj->table->table_basic_js($resultado,$tipo,'','del',$evento ,$cabecera);
    }
     
    
    $DetalleRequisitos= 'ok';

    echo $DetalleRequisitos;
 
 

?>
 
  
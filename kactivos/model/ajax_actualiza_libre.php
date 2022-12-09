<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/



$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

 
    $idbien   = $_GET['codigo'] ;
    $idprov   = trim($_GET['idprov']) ;
 
    $Array            = $bd->query_array('view_nomina_rol','id_departamento', 'idprov='.$bd->sqlvalue_inyeccion($idprov,true));
    $id_departamento  = $Array['id_departamento'];
 
        
        $sql = "UPDATE activo.ac_bienes_custodio
                   SET idprov= ".$bd->sqlvalue_inyeccion($idprov,true) .',
                       id_departamento= '.$bd->sqlvalue_inyeccion($id_departamento,true) .'
                 WHERE id_bien='.$bd->sqlvalue_inyeccion($idbien,true);
        
        $bd->ejecutar($sql);
        
        
        $clase= 'INFORMACION ACTUALIZADA CON EXITO NRO BIEN '. $idbien.' ... Actualice la informacion';
 
      
        
    echo $clase;

?>
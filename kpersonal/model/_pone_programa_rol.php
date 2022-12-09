<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/



$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);


 
        $sql1 = "SELECT id_rold,idprov 
        FROM nom_rol_pagod
        where programa is null   order by 1";
        
 
    
 

$stmt1 = $bd->ejecutar($sql1);

 
while ($fila=$bd->obtener_fila($stmt1)){
    
    
    $variable = $bd->query_array('view_nomina_rol',
        'programa,idprov',
        'idprov='.$bd->sqlvalue_inyeccion(trim($fila['idprov']),true) 
        );
    
    
    $programa = trim($variable['programa']);
    
    $id_rold =  $fila['id_rold'];
    
    $sql12 = 'update nom_rol_pagod
            set programa = '.$bd->sqlvalue_inyeccion($programa ,true).'
            where id_rold = '.$bd->sqlvalue_inyeccion($id_rold ,true);
    
    $bd->ejecutar($sql12);
    
}


?>
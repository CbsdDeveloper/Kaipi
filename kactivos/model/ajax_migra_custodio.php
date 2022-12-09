<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


 
$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 

$timestamp = date('H:i:s');

echo $timestamp

  //-------------------------------------------
  /*
$sql1 = 'SELECT item, identificador, detalle, cuenta, id_matriz_esigef, clase
        FROM activo.ac_matriz_esigef';

$stmt1 = $bd->ejecutar($sql1);

 
while ($fila=$bd->obtener_fila($stmt1)){
    
    $detalle = trim($fila['detalle']);
    
    $matriz = explode('/', $detalle);
    
    
    $sql = "update activo.ac_matriz_esigef
               set clase=".$bd->sqlvalue_inyeccion(trim($matriz[0]), true).'
            where id_matriz_esigef='.$bd->sqlvalue_inyeccion($fila['id_matriz_esigef'], true) ;
    
    $bd->ejecutar($sql);
    
    echo $matriz[0].' - ';
}

*/

 /*
    
    $sql1 = ' SELECT a.id_bien, a.idprov, a.id_departamento, a.departamento,
 		(select b.id_departamento from nom_departamento b where trim(b.nombre) =  trim(a.departamento)) as depa
FROM activo.temp_custodio a' ;
 

$stmt1 = $bd->ejecutar($sql1);

 
while ($fila=$bd->obtener_fila($stmt1)){
    
    $idprov = trim($fila['idprov']);
    
    $sql = "update activo.ac_bienes_custodio 
               set id_departamento=".$bd->sqlvalue_inyeccion($fila['depa'], true).'
            where idprov='.$bd->sqlvalue_inyeccion($idprov, true).' and id_bien='.$bd->sqlvalue_inyeccion($fila['id_bien'], true);
    
    $bd->ejecutar($sql);
   
    $sql11 = "update nom_personal
               set id_departamento=".$bd->sqlvalue_inyeccion($fila['depa'], true).'
            where idprov='.$bd->sqlvalue_inyeccion($idprov, true);
    
    $bd->ejecutar($sql11);
    
    
}

*/
 

?>
 
  
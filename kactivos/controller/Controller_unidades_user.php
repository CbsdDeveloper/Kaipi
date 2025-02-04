<?php

session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

$bd	   =	new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);


$id            		= $_GET['id'];



$sql = " SELECT  razon, idprov,correo,telefono
                FROM view_nomina_rol
                where id_departamento = ".$bd->sqlvalue_inyeccion($id,true)." order by razon";



$stmt_nivelTarea= $bd->ejecutar($sql);


echo ' <div class="list-group">
              <a href="#" class="list-group-item active">Personal</a>';

while ($y=$bd->obtener_fila($stmt_nivelTarea)){
    
    
    $idprov   =  trim($y['idprov']);
  
    
    $cadena = "'".$idprov."'";
    
    echo '<a href="#" title ="ASIGNAR CUSTODIO" onclick="actualiza_cliente('.$cadena.')" class="list-group-item">'.' ['.trim($y['razon']).']'.'</a>';
    
    
    
}

echo ' </div>';




?>

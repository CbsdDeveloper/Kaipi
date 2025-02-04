<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


 
$bd	   =	new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

$unidad  = $_GET['unidad'];
 
    
if ( $unidad  == '-2'){

    $sesion 	 =  trim($_SESSION['email']);
    $datos       =  $bd->__user($sesion);
    $longitud    =  strlen($datos['orden']);
    $orden       = trim($datos['orden']);
    
            if (  $longitud > 1 ){
                $orden = substr( $orden ,0,1);
            }
            $sql1 = 'SELECT email, completo ,cargo
                        FROM view_nomina_user
                        where orden like '.$bd->sqlvalue_inyeccion($orden .'%',true) . " and 
                              cargo is not null and
                              estado = 'S' 
                                order by responsable desc,completo" ;
 
    }else{

        $sql1 = 'SELECT email, completo ,cargo
        FROM view_nomina_user
    where id_departamento = '.$bd->sqlvalue_inyeccion($unidad,true) . ' 
            order by responsable desc,completo' ;

    }

   

$stmt1 = $bd->ejecutar($sql1);

echo '<option value="-"> -  Seleccionar Funcionario  - </option>';


while ($fila=$bd->obtener_fila($stmt1)){

    $cargo    = trim($fila['cargo']);
    $completo = trim($fila['completo']). ' ( '.$cargo .' )';
    
    
    echo '<option style="font-weight:bold" value="'.trim($fila['email']).'">'.$completo .'</option>';
    
}
 

?>
 
  
<?php 
 session_start(); 

 require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 
 require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
 


    $bd	   =	 	new Db ;
   
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

    $id = $_POST['id_reciproco'];

    $sql = "DELETE FROM co_reciprocas
            WHERE id_reciproco = ".$bd->sqlvalue_inyeccion( $id,true);

    $bd->ejecutar($sql);

    $data = 'DATOS ACTUALIZADOS....';

     
   
	 
        echo $data;
 	 
?>
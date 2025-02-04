<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


 
$bd	   =	new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

$tipo      =     $_GET['tipo'];
$ruc       =     $_SESSION['ruc_registro'];


if ($tipo == 'privado' ){
    
      $sql0 = "SELECT  email,completo
                FROM public.par_usuario
                where empresas = ".$bd->sqlvalue_inyeccion( $ruc , true)."  and
                      estado = 'S' union "; 
    
        
      $sql1 = $sql0 . " SELECT  email,completo
                FROM public.par_usuario
                where empresas = '0000000000000'  and 
                      estado = 'S' 
                order by 2"; 
        
        $stmt1 = $bd->ejecutar($sql1);
        
        while ($fila=$bd->obtener_fila($stmt1)){
            
            echo '<option value="'.$fila['email'].'">'.$fila['completo'].'</option>';
            
        }
        
       
        
    }else{
        
        echo '<option value="todos">'.'[ Mensaje publico ]'.'</option>';
    
    }
    
 
?>
 
  
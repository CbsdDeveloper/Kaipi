<?php
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


 
$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

$tipo              =  trim($_GET['tipo']);
$sesion 	       =  trim($_SESSION['email']);
$documento_array   =  $bd->__user( $sesion );
$unidad            =  $documento_array['id_departamento'];
 
$anio              = date('Y');


$sql1 = "select secuencia,envia,uso,completo, bandera
                        from flow.view_doc_generados 
                        where id_departamento = ".$bd->sqlvalue_inyeccion($unidad,true) ." and 
                              tipodoc= ".$bd->sqlvalue_inyeccion(trim($tipo),true) ." and 
                              anio= ".$bd->sqlvalue_inyeccion(trim($anio),true) ." 
                        order by secuencia desc limit 7";

 
 
                $stmt1 = $bd->ejecutar($sql1);
                
                echo '<h5>Ultimas Secuencia Documentos</h5>';
                
                echo ' <div class="btn-group btn-group-justified">';
          
      
    
                while ($fila=$bd->obtener_fila($stmt1)){
                    
                    $completo = trim($fila['completo']);
                    $envia    = trim($fila['envia']);
                    
                    if ( $envia == '0'){
                        echo ' <a href="#" title ="Generado por '.$completo.'" class="btn btn-danger">'.$fila['secuencia'].'</a>';
                    }else{
                        echo ' <a href="#" title ="Generado por '.$completo.'" class="btn btn-default">'.$fila['secuencia'].'</a>';
                    }
             }
          
            echo '</div>';


?>
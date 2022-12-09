<?php 
session_start();   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 	$bd	   = new Db ;
 	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

    $anio            =  $_SESSION['anio'];
  
 
    $sql ="select a.grupo, x.detalle 
            from presupuesto.view_grupo_ingreso a , presupuesto.pre_catalogo x
            where anio = ". $bd->sqlvalue_inyeccion($anio ,true)."  and x.codigo = a.grupo
            group by a.grupo , x.detalle 
            order by 1";
            
 
  echo '<option value="-" >-- Seleccione el grupo presupuestario --</option>';

   $stmt = $bd->ejecutar($sql);
    
       while ($x=$bd->obtener_fila($stmt)){

        $codigo = trim($x["grupo"]);

        $nombre =  $codigo.' '.trim($x["detalle"]);

        echo '<option value="'.$codigo.'" >'.$nombre.'</option>';

     }
  
?> 
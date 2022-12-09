<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';  
    
    require '../../kconfig/Obj.conf.php';  
	
 
	$bd	   = new Db ;
	
	$registro= $_SESSION['ruc_registro'];
	
	$anio       =  $_SESSION['anio'];
	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 


        $cajero =  trim($_GET['cajero']);
        $fecha  =  $_GET['fecha'];

        $sql1 ="select '-' as codigo , ' --- Impresion parte de caja  --- ' as nombre union
        select parte as codigo, 'Parte Nro. ' || parte || ' Fecha: '  || fecha_pago   as nombre
        from rentas.view_ren_caja_cierre
        where conta = 'N' and 
              sesion=".$bd->sqlvalue_inyeccion($cajero, true).' and 
              fecha_pago='.$bd->sqlvalue_inyeccion($fecha, true).'
           order by 2 asc';

        $stmt1 = $bd->ejecutar($sql1);

        while ($fila=$bd->obtener_fila($stmt1)){

           echo  '<option value="'.trim($fila['codigo']).'">'.trim($fila['nombre']).'</option>';

        }

  
    
?>
 
  
<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';  
    
    require '../../kconfig/Obj.conf.php';  
	
 
	$bd	   = new Db ;
	
	$registro= $_SESSION['ruc_registro'];
	
	$anio       =  $_SESSION['anio'];
	
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 


        $cajero =  trim($_GET['cajero']);
        
        $fecha  =  $_GET['fecha'];

        $sql1 ="select parte as codigo, 'Parte Nro. ' || parte || ' Fecha: '  || fecha_pago   as nombre
        from rentas.view_ren_diario_pagos
        where 
              sesion=".$bd->sqlvalue_inyeccion($cajero, true)." and cierre ='S'
            GROUP BY   parte,fecha_pago
           order by fecha_pago desc";
 



        $stmt1 = $bd->ejecutar($sql1);

        echo  '<option value="'.'-'.'"> --- Impresion parte de caja  --- </option>';

        while ($fila=$bd->obtener_fila($stmt1)){

           echo  '<option value="'.trim($fila['codigo']).'">'.trim($fila['nombre']).'</option>';

        }

  
    
?>
 
  
<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 
	$bd	   = new Db ;
	
	$id     = $_SESSION['ruc_registro'];
	
	$anio   = $_SESSION['anio'];
	
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	
     
 	 if (isset($_GET['codigo_cuenta']))	{
		 
		 $cuentas = $_GET['codigo_cuenta'];
		 
		 // nivel actual
		 $sql = "SELECT nivel 
                       FROM co_plan_ctas  
				      where trim(cuenta) =".$bd->sqlvalue_inyeccion($cuentas ,true)." and 
                            anio = ".$bd->sqlvalue_inyeccion($anio ,true)." and 
                            registro =".$bd->sqlvalue_inyeccion($id,true);
 		
		 $resultado1 = $bd->ejecutar($sql);
		 $datos_sql   = $bd->obtener_array( $resultado1);
		 $nivel           = $datos_sql['nivel'] ;
         
         
	 	 // numero de registros
		 $sql = "SELECT count(*) as numero 
                      FROM co_plan_ctas  
                     WHERE trim(cuentas) =".$bd->sqlvalue_inyeccion($cuentas ,true)." and 
                           anio = ".$bd->sqlvalue_inyeccion($anio ,true)." and 
                           registro =".$bd->sqlvalue_inyeccion($id,true);
 		
		 $resultado1 = $bd->ejecutar($sql);
		 $datos_sql = $bd->obtener_array( $resultado1);
		 $cuenta_numero = $datos_sql['numero'];
		 
         /*
		 1  1
		 11 2
 		 111  3
 		 111.01 4
 		 111.01.01 5*/
		 
		 if ( $nivel == 1){
		    $cuenta_numero = $cuenta_numero + 1;
		    $ccuenta =  trim($cuentas).$cuenta_numero;
		  }
		 if ( $nivel == 2){
		    $cuenta_numero = $cuenta_numero + 1;
		    $ccuenta =  trim($cuentas).$cuenta_numero;
		  }		
		 if ( $nivel == 3){
		    $cuenta_numero = $cuenta_numero + 1;
		    $ccuenta =  trim($cuentas).'.'.str_pad($cuenta_numero,2,'00',STR_PAD_LEFT);
		  }	
		 if ( $nivel == 4){
		    $cuenta_numero = $cuenta_numero + 1;
		    $ccuenta =  trim($cuentas).'.'.str_pad($cuenta_numero,2,'00',STR_PAD_LEFT);
		  }		
		  	  		    
  		if ( $nivel == 5){
		    $cuenta_numero = $cuenta_numero + 1;
		    $ccuenta =  trim($cuentas).'.'.str_pad($cuenta_numero,2,'00',STR_PAD_LEFT);
		  }	

		$cuenta =  trim($ccuenta);
		
		echo $cuenta;
    
  		  
   	 }	
?>
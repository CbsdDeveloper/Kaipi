 <?php 
 session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
     
	$bd	   = new Db ;
	
 	
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
    
    
    $sql = "SELECT cuenta, detalle, substring(debito,1,6) as debito, substring(credito,1,6) as credito, substring(deudor,1,1) as deudor
            FROM presupuesto.matriz_sigef
            where substring(cuenta,1,2) in ('62','63','15','14','13','12')" ;
                
      $stmt = $bd->ejecutar($sql);
    
    while ($x=$bd->obtener_fila($stmt)){
        
        $cnombre =  trim($x['cuenta']);
        $debito =  trim($x['debito']);
        $credito =  trim($x['credito']);
        $deudor =  trim($x['deudor']);
        
        $sqle ="update co_plan_ctas 
                set deudor_acreedor=".$bd->sqlvalue_inyeccion(trim($deudor),true).",
                    debito=".$bd->sqlvalue_inyeccion(trim($debito),true).",
                    credito=".$bd->sqlvalue_inyeccion(trim($credito),true)."
               where cuenta =".$bd->sqlvalue_inyeccion(trim($cnombre),true) ;
 
        $bd->ejecutar($sqle);
        
        echo $cnombre.' - '.$debito.' - '.$credito.'   ->> ' ;
    }
    
    
    
  
?>
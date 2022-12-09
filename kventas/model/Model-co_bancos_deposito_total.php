<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
    
	$bd	   = new Db ;
 	
	$registro= $_SESSION['ruc_registro'];
	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
      
    $id_concilia	=	$_GET["id_concilia"];
    
 
    
    $Aconciliacion = $bd->query_array('co_concilia',
                                      'anio, mes,   estado, cuenta', 
                                      'id_concilia='.$bd->sqlvalue_inyeccion($id_concilia,true)
                                     );
    
    

    
    $sql = "SELECT sum(debe) as debe, sum(haber) as haber
            FROM  view_bancos_concilia
where 	registro = ".$bd->sqlvalue_inyeccion($registro,true)." and
        cuenta = ".$bd->sqlvalue_inyeccion(trim($Aconciliacion["cuenta"]),true)." and
        coalesce(tipo,'-')   <>   'cheque'  and  concilia = 'S' and
        anio   = ".$bd->sqlvalue_inyeccion($Aconciliacion["anio"],true)."  and
        mes    = ".$bd->sqlvalue_inyeccion($Aconciliacion["mes"],true) ;

 
  
       
    $stmt = $bd->ejecutar($sql);
    
    $debe  = 0;
    $haber = 0;
 
    
    while ($x=$bd->obtener_fila($stmt)){
        
     	
    	$haber =  $haber +  $x['haber'] ;
    	
    	$debe =  $debe +  $x['debe'] ;
     
    	
    }
 
    
    
    echo	' <div class="col-md-12" align="right" style="padding: 10px;font-size: 15px">
                    <div class="col-md-6" align="right">
                    </div>
                    <div class="col-md-3" align="right"><b>Total Seleccion '.number_format($debe,2).'</b>
                    </div>
                    <div class="col-md-3" align="right"><b>Total Seleccion '.number_format($haber,2).'</b>
                    </div> </div>';

 
 
    
    
?>
  
<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
    
	$bd	   = new Db ;
 	
	$registro= $_SESSION['ruc_registro'];
	
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	
      
    $id_concilia	=	$_GET["id_concilia"];
    
 
    
    $Aconciliacion = $bd->query_array('co_concilia',
                                      'anio, mes,   estado, cuenta', 
                                      'id_concilia='.$bd->sqlvalue_inyeccion($id_concilia,true)
                                     );
    
    

    
    $sql = "SELECT sum(a.debe) as debe, sum(a.haber) as haber
   FROM co_asiento b
     JOIN co_asientod a ON a.id_asiento = b.id_asiento AND b.estado = 'aprobado'::bpchar AND a.registro = b.registro AND a.anio = b.anio
     JOIN co_plan_ctas c ON c.cuenta = a.cuenta AND a.registro = c.registro AND c.tipo_cuenta = 'B'::bpchar AND c.anio::text = b.anio::character varying::text
     LEFT JOIN par_ciu x ON x.idprov = b.idprov
where 	b.registro = ".$bd->sqlvalue_inyeccion($registro,true)." and
        a.cuenta = ".$bd->sqlvalue_inyeccion(trim($Aconciliacion["cuenta"]),true)." and
        coalesce(( SELECT max(j.tipo) AS max
        FROM co_asiento_aux j
       WHERE j.id_asiento = a.id_asiento AND j.id_asientod = a.id_asientod),'-')   <>   'cheque'  and  concilia = 'S' and
        b.anio   = ".$bd->sqlvalue_inyeccion($Aconciliacion["anio"],true)."  and
        b.mes    = ".$bd->sqlvalue_inyeccion($Aconciliacion["mes"],true) ;

 
        // echo $sql;
       
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
  
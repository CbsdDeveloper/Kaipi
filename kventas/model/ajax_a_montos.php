<?php 

session_start( );  
   	
require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
 

 
$bd	   =	new Db;
    
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
    
   
    
    
    $sql_det1 = "SELECT  razon, comprobante,fechaa,idproducto, cantidad,id_movimiento, costo, total, tarifa_cero,monto_iva,baseiva, autorizacion
FROM public.view_mov_aprobado
where ( coalesce(tarifa_cero,0) + coalesce(monto_iva,0) + coalesce(baseiva,0)) <>  total and 
	  autorizacion is not null
order by fechaa desc";
    
 
 
    $stmt1 = $bd->ejecutar($sql_det1);
    
    
    while ($x=$bd->obtener_fila($stmt1)){
        
        $id = $x['id_movimiento'];
        
        
        /*
       
        $sqlEdit1 = "update inv_movimiento_det
				     set  monto_iva = (costo * 0.12)
 				 		 WHERE tipo = 'I' and  id_movimiento=".$bd->sqlvalue_inyeccion( $id, true);
 				 		 
 				 		 */
       
        $sqlEdit1 = "update inv_movimiento_det
				     set  monto_iva = (costo * 0.12)
 				 		 WHERE coalesce(monto_iva,0) > 0 and tipo = 'I' and  id_movimiento=".$bd->sqlvalue_inyeccion( $id, true);
        
        $bd->ejecutar($sqlEdit1); 
        
     
       $ATotal = $bd->query_array(
            'inv_movimiento_det',
            'sum( total) as t1, sum(monto_iva) as t2, sum(tarifa_cero) as t3, sum(baseiva) as t4',
            ' id_movimiento ='.$bd->sqlvalue_inyeccion($id,true)
            );
        
        $sqlEdit = "update inv_movimiento
				     set  iva = ".$bd->sqlvalue_inyeccion($ATotal['t2'],true).",
                          base0 = ".$bd->sqlvalue_inyeccion($ATotal['t3'],true).",
                          base12 = ".$bd->sqlvalue_inyeccion($ATotal['t4'],true).",
                          total = ".$bd->sqlvalue_inyeccion($ATotal['t1'],true)."
 				 		 WHERE  id_movimiento=".$bd->sqlvalue_inyeccion( $id, true);
        
        $bd->ejecutar($sqlEdit);  
        
        echo $id.' - ';
        
    }
 
    /*
    $sql_det1 = "select   id_movimiento
                        FROM inv_movimiento
                        where modulo='arriendo'";
    
    
    
    $stmt1 = $bd->ejecutar($sql_det1);
    
    
    while ($x=$bd->obtener_fila($stmt1)){
        
        $id = $x['id_movimiento'];
        
        $ATotal = $bd->query_array(
            'inv_movimiento_det',
            'sum( total) as t1, sum(monto_iva) as t2, sum(tarifa_cero) as t3, sum(baseiva) as t4',
            ' id_movimiento ='.$bd->sqlvalue_inyeccion($id,true)
            );
        
        $sqlEdit = "update inv_movimiento
				     set  iva = ".$bd->sqlvalue_inyeccion($ATotal['t2'],true).",
                          base0 = ".$bd->sqlvalue_inyeccion($ATotal['t3'],true).",
                          base12 = ".$bd->sqlvalue_inyeccion($ATotal['t4'],true).",
                          total = ".$bd->sqlvalue_inyeccion($ATotal['t1'],true)."
 				 		 WHERE  id_movimiento=".$bd->sqlvalue_inyeccion( $id, true);
        
        $bd->ejecutar($sqlEdit);
        
        
    }
 */
  ?> 
								
 
 
 
<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

     
    $obj     = 	new objects;
    $bd	   =	new Db ;
    
    $ruc       =    $_SESSION['ruc_registro'];
    
    
 
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
    
    $fecha        = $_GET['fecha'];
    $cajero       = $_GET['cajero'];
 
 
    verifica_anulados($bd,$fecha,$ruc);
    
    Verifica_suma_facturas_Total(  $bd );
    
    $tipo 		= $bd->retorna_tipo();
 
    
    $sql = 'SELECT  max(fecha) as fecha ,
                    modulo ,
                    count(*) as numero,
                    sum(base12) base12,
                    sum(iva) iva ,
                    sum(base0)  base0,
                    sum(total) total
      FROM view_ventas_modulo
      where fecha = '.$bd->sqlvalue_inyeccion($fecha ,true).'   group by modulo order by modulo'    ;
     
 
   
    
    ///--- desplaza la informacion de la gestion
    $resultado  = $bd->ejecutar($sql);
     
    
    $cabecera =  "Fecha,Modulo,Nro Facturas,Base Imponible,IVA,Tarifa Cero,Total";
   
    $evento   = "";
    
    $obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
     
     $DivMovimiento= ' ';

    echo $DivMovimiento;
 
//-------------------------------------
    function verifica_anulados($bd,$fecha,$ruc){
        
        
        
        $sql = "select id_movimiento from view_ventas_fac 
                where estado = 'anulado' and 
                	  fecha  =".$bd->sqlvalue_inyeccion($fecha ,true)." and 
                	  registro=".$bd->sqlvalue_inyeccion($ruc ,true);

 
        
        /*Ejecutamos la query*/
        $resultado = $bd->ejecutar($sql);
        
        
        while ($x=$bd->obtener_fila($resultado)){
            
            $idmovimiento = $x['id_movimiento'];
            
            $sql = 'update inv_fac_pago set monto = 0 where id_movimiento = '.$bd->sqlvalue_inyeccion($idmovimiento ,true);
           
            $bd->ejecutar($sql);
            
        }
        
    }  
    //-----------------------
    function Verifica_suma_facturas_Total(  $bd ){
        
        
        $sql_det1 = "select   id_movimiento
                        FROM inv_movimiento
                        where  tipo = 'F' AND 
                              (coalesce(iva,0) + coalesce(base0,0) + coalesce(base12,0)) <> total ";
        
        
        
        $stmt1 = $bd->ejecutar($sql_det1);
        
        
        while ($x=$bd->obtener_fila($stmt1)){
            
            $id = $x['id_movimiento'];
            
            $ATotal = $bd->query_array(
                'inv_movimiento_det',
                'sum( total) as t1, sum(monto_iva) as t2, sum(tarifa_cero) as t3, sum(baseiva) as t4',
                "id_movimiento =".$bd->sqlvalue_inyeccion($id,true)
                );
            
            $sqlEdit = "update inv_movimiento
				     set  iva = ".$bd->sqlvalue_inyeccion($ATotal['t2'],true).",
                          base0 = ".$bd->sqlvalue_inyeccion($ATotal['t3'],true).",
                          base12 = ".$bd->sqlvalue_inyeccion($ATotal['t4'],true).",
                          total = ".$bd->sqlvalue_inyeccion($ATotal['t1'],true)."
 				 		 WHERE  id_movimiento=".$bd->sqlvalue_inyeccion( $id, true);
            
            $bd->ejecutar($sqlEdit);
            
            
        }
    }
?>
 
  
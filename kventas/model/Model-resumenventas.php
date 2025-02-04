<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

     
    $obj     = 	new objects;
    $bd	   =	new Db ;
    
    $ruc       =    $_SESSION['ruc_registro'];
    
    
 
    // $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
    $bd->conectar('postgres','db_kaipi','Cbsd2019');
    
    $fecha        = $_GET['fecha'];
    $cajero       = $_GET['cajero'];
 
 
    verifica_anulados($bd,$fecha,$ruc);
    
    Verifica_suma_facturas_Total(  $bd );
    
    $tipo 		= $bd->retorna_tipo();
 
    
    $sql = 'SELECT  fecha ,
                      facturas ,
                    base12,
                    iva ,
                    base0 ,
                     total
      FROM view_factura_caja
      where fecha = '.$bd->sqlvalue_inyeccion($fecha ,true).' and
            sesion = '.$bd->sqlvalue_inyeccion(trim($cajero) ,true)      ;
     
    
    
    ///--- desplaza la informacion de la gestion
    $resultado  = $bd->ejecutar($sql);
     
    $cabecera =  "Fecha,Nro Facturas,Base Imponible,IVA,Base Tarifa Cero,Total";
    
    $evento   = "";
    
    $obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
     
     $DivMovimiento= ' ';

     echo ' <h6 align="center"><b> DETALLE NOTAS DE CREDITO </b></h6>';
     
     $sql = 'select a.fechaemisiondocsustento,b.razon,a.numdocmodificado,a.secuencial1,b.base12, b.iva, b.base0, b.total
			from doctor_vta a
			join view_ventas_fac b on b.id_movimiento = a.id_diario and
				 a.fechaemisiondocsustento='.$bd->sqlvalue_inyeccion($fecha ,true);
     
     
     $resultado  = $bd->ejecutar($sql);
     
     $cabecera =  "Fecha,Nombre,Documento Modificado,Nota Credito,Base Imponible,IVA,Base Tarifa Cero,Total";
     
     $evento   = "";
     
     $obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
     
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
 
  
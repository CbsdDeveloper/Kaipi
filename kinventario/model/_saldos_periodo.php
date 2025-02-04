 <?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php';   /*Incluimos el fichero de la clase objetos*/
	
 	$bd	   = new Db ;
 	
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	
    
    $fecha2                =     $_GET["fecha2"];

    $cbodega               =     $_GET["cbodega"];
    
    $x                     =     explode('-',$fecha2);
    $mes  			       =     $x[1];
    $anio  			       =     $x[0];
 
    $fecha1 = $anio.'-01-01';
 
    
    $delete = 'delete from inv_saldos_kar where idbodega = '.$bd->sqlvalue_inyeccion($cbodega,true);
    
    $bd->ejecutar($delete);
    
    
    $sql_det = 'SELECT idproducto,count(*) as nn,producto
                 from view_inv_movimiento_kar 
                where ( fecha between '."'".$fecha1."'"." and "."'".$fecha2."'".')  and
                      idbodega = '.$bd->sqlvalue_inyeccion($cbodega,true).'   
                group by idproducto,producto order by idproducto';
        
     
  

    $stmt2  = $bd->ejecutar($sql_det);
    
    $i      = 1;
    
    while ($x=$bd->obtener_fila($stmt2)){
        
        $contador   = $x['nn'];
        
        $idproducto = $x['idproducto'];
         
        if ( $contador >= 1){
            
            costo_promedio($bd,$idproducto,$fecha2,$anio,$mes,$cbodega);

           
             
            $i ++;
            
        }
    }
    
    verifica_saldo($bd);
    
    echo   'Articulos: '.$i.'|  <br>';
    
 //-----------------
    function costo_saldo($bd,$idproducto){
        
        $AResultado = $bd->query_array('web_producto','costo', 'idproducto='.$bd->sqlvalue_inyeccion($idproducto,true));
        
     if ( $AResultado['costo'] > 0 ){

        return $AResultado['costo'];

     }else{

        return  0;
     }
        
    }
    
    //-----------------
    function costo_promedio($bd,$idproducto,$fecha2,$anio,$mes,$cbodega){
        
        
        $fecha1 = $anio.'-01-01';
        
        $sql_det ="SELECT  fecha, tipo, 
                            COALESCE(costo,0) as costo,
                            COALESCE(cantidad,0) as cantidad,
                            COALESCE(total,0) as total,
                            COALESCE(ingreso,0) as ingreso,
                            COALESCE(egreso,0) as egreso,
                            ( COALESCE(cantidad,0) * COALESCE(costo,0) ) as total_variable,
                            id_movimiento, detalle,razon,comprobante,producto
        FROM  view_mov_aprobado
        WHERE ( fecha between "."'".$fecha1."'"." and "."'".$fecha2."'".") and 
              idproducto= ".$bd->sqlvalue_inyeccion($idproducto,true).' 
        order by fecha asc,ingreso desc, tipo asc';
   
        
 
          
        $stmt21 = $bd->ejecutar($sql_det);
        
        $i = 1;
        
        $total_saldo    = 0;
        $total_cantidad = 0;
        $tota_promedio  = 0;
        
        $total_ingreso = 0;
        $total_egreso  = 0;
         
    
        $cantidad_ingreso = 0;
        $cantidad_egreso  = 0;
        
        
        $total_egreso   = 0;
        
        while ($y=$bd->obtener_fila($stmt21)){
            
             $tipo     = $y['tipo'];
             $cantidad = $y['cantidad'];
           
            //--- sin afectar al iva
            // $total    = $y['total_variable'];
           
            //--- con afectar al iva
            $total    = $y['total'];
            
            if ( $i == 1) {
                
                if ( $tipo == 'I') {
                    $total_cantidad = $total_cantidad + $cantidad;
                    $total_saldo    = $total_saldo + $total;
                    
                    $tota_promedio  = round($total_saldo,6) / round($total_cantidad,6);
                    $cantidad_ingreso  = $cantidad_ingreso  + $cantidad ;
                    $total_ingreso     = $total_ingreso + $total;
                        
                }
             }else{
                
                if ( $tipo == 'I') {
                    
                    $total_cantidad    = $total_cantidad + $cantidad;
                    $cantidad_ingreso  = $cantidad_ingreso  + $cantidad ;
                    
                    $total_saldo    = $total_saldo + $total;
                    
                    $tota_promedio  = round($total_saldo,6) / round($total_cantidad,6);
                     //$costo_ingreso  = $costo;
                    
                    $total_ingreso     = $total_ingreso + $total;
                    
                 }else {
                    
                    $total_egreso   = $total_egreso + $total;
                    $total_cantidad = $total_cantidad - $cantidad;
                    $total_saldo    = $total_saldo - $total;
                   
                    
                    if ( $total_cantidad == 0 ){
                        $tota_promedio = $tota_promedio;
                    }else{
                        $tota_promedio  = round($total_saldo,6) / round($total_cantidad,6);
                    }
                     $cantidad_egreso = $cantidad_egreso + $cantidad;
                 }
             }
           
          
           
            $i++;
        }
 
     //   $total_saldo = $total_ingreso - $total_egreso;

        if ( $tota_promedio > 0 ){
        }else{
            $tota_promedio = '0.00';
        }

        if ( $total_saldo > 0 ){
        }else{
            $total_saldo = '0.00';
        }
 
        
        $InsertQuery = array(
            array( campo => 'idbodega',   valor =>$cbodega),
            array( campo => 'idproducto',   valor =>$idproducto),
            array( campo => 'entrada',   valor => $cantidad_ingreso),
            array( campo => 'salida',   valor => $cantidad_egreso),
            array( campo => 'saldo',   valor => $total_cantidad),
            array( campo => 'ventrada',   valor => $total_ingreso),
            array( campo => 'vsalida', valor => $total_egreso),
            array( campo => 'vsaldo',   valor => $total_saldo),
            array( campo => 'anio',   valor =>$anio),
            array( campo => 'kpromedio',   valor =>$tota_promedio),
            array( campo => 'sesion',   valor => trim(  $_SESSION['email']))
        );
        
        
       $bd->pideSq(0);
        
     $bd->JqueryInsertSQL('inv_saldos_kar',$InsertQuery  );
        
 
        
    }
    //-----------
    function verifica_saldo($bd){
        
       
        $sql_det1 = 'SELECT * FROM inv_saldos_kar WHere saldo= 0';
         
        
        $stmt3 = $bd->ejecutar($sql_det1);
        
         
        while ($xx=$bd->obtener_fila($stmt3)){
            
             
            $idproducto = $xx['idproducto'];
            
            $total    = $xx['ventrada'];
            $cantidad = $xx['entrada'];
            
            $parcial = $total/$cantidad;
            
            $costo = round($parcial,4);
            
            if (  $costo > 0  ){
            }else    {
                $costo = '0.00';
            }
            
                    $sql3 = "update web_producto
                        set  costo= ". $costo.",
                            promedio =". $costo."
                        WHERE idproducto= ".$bd->sqlvalue_inyeccion($idproducto, true);
                    
                    $bd->ejecutar($sql3);
                    
                    $costo_total = '0.00';
                    
                    $sql4 = "update inv_saldos_kar
                        set  vsalida= ". $total.",
                            vsaldo =". $costo_total."
                        WHERE idproducto= ".$bd->sqlvalue_inyeccion($idproducto, true);
                    
                    $bd->ejecutar($sql4);
            
        }
        
    }
?>
 
  
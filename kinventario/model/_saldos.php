 <?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 	$bd	   = new Db ;
 	
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	
    
    if (isset($_GET['id']))	{
         
        $id        = $_GET['id'];
        
        
        $sql_det = ' SELECT idproducto,count(*) as nn,producto
                 from view_inv_movimiento_det 
                 where idproducto = '. $id  .' 
                group by idproducto,producto';
        
 
 
    }else{
        
        $sql_det = ' SELECT idproducto,count(*) as nn,producto
                 from view_inv_movimiento_det 
                group by idproducto,producto';
        
    }
    
   
   

    
    $stmt2 = $bd->ejecutar($sql_det);
    
    $i = 1;
    
    while ($x=$bd->obtener_fila($stmt2)){
        
        $contador   = $x['nn'];
        
        $idproducto = $x['idproducto'];
         
        if ( $contador > 1){
            
            $datos=costo_promedio($bd,$idproducto);
            
			
			if (is_numeric($datos['lifo'] )){
			}else  	{
				$datos['lifo'] = $datos['promedio'];
			}	
       
            $sql3 = "update web_producto
                set  costo= ". round($datos['promedio'],4).",
                     lifo = ".   round($datos['lifo'],4) .",
                     promedio =". round($datos['promedio'],4)."
                  WHERE idproducto= ".$bd->sqlvalue_inyeccion($idproducto, true);
            
            $bd->ejecutar($sql3);
            
 
            
            $i ++;
            
           
        }

    

    }

    echo 'INFORMACION ACTUALIZADA....<br>';
 //-----------------
    function costo_saldo($bd,$idproducto){
        
        $AResultado = $bd->query_array('web_producto','costo', 'idproducto='.$bd->sqlvalue_inyeccion($idproducto,true));
        
        return $AResultado['costo'];
        
    }
    
    //-----------------
    function costo_promedio($bd,$idproducto){
        
        
        $anio       =  $_SESSION['anio'];
        
         
        
        $sql_det ='SELECT  fecha, tipo, costo,cantidad,total,ingreso,egreso,(cantidad * costo) as total_variable,
                             id_movimiento, detalle,razon,comprobante,producto
        FROM  view_mov_aprobado
        WHERE idproducto= '.$bd->sqlvalue_inyeccion($idproducto,true).' and
             anio = '.$bd->sqlvalue_inyeccion($anio,true).' 
        order by fecha asc,ingreso desc, tipo asc';
 
        
        $stmt21 = $bd->ejecutar($sql_det);
        
        $i = 1;
        
        $total_saldo    = 0;
        $total_cantidad = 0;
        $tota_promedio  = 0;
        $tota_lifo      = 0;
    
        
        while ($y=$bd->obtener_fila($stmt21)){

            $costo    = $y['costo'];
            $tipo     = $y['tipo'];
            $cantidad = round($y['cantidad'],2);
           
            //--- sin afectar al iva
            // $total    = $y['total_variable'];
            
            //--- con afectar al iva
            $total    = $y['total'];
            
            if ( $i == 1) {
                
                if ( $tipo == 'I') {
                    $total_cantidad = $total_cantidad + $cantidad;
                    $total_saldo    = $total_saldo + $total;
                    $tota_promedio  = round($total_saldo / $total_cantidad,4);
                    $tota_lifo      = $costo;
               
                    $costo_egreso   = '0.00';
                    $total_egreso   = '0.00';
 
                }
                
            }else{
                
                if ( $tipo == 'I') {

                    $total_cantidad = $total_cantidad + $cantidad;
                    $total_saldo    = round($total_saldo + $total,4);
                    $tota_promedio  = round($total_saldo / $total_cantidad,4);
                    $tota_lifo      = $costo;
                    
                    $costo_egreso   = '0.00';
                    $total_egreso   = '0.00';

                }else {
                    
                    $total_egreso   = $cantidad * $tota_promedio;
                    $total_cantidad = $total_cantidad - $cantidad;
                    
                    $total_saldo    = round($total_saldo - $total_egreso,4);
                   
                    
                    if ( $total_cantidad <= 0 ){
                        $tota_promedio = $tota_promedio;
                    }else{
                        $tota_promedio  = round($total_saldo / $total_cantidad,4);
                    }
                 
                    $costo_egreso   = $tota_promedio;
                    $total_egreso  = $costo * $costo_egreso ;
                }
                
            }
            
    
            $i++;
        }
 
       
      //  echo 'Producto: '.$idproducto.' (saldo: '.$total_cantidad.' promedio: '.$tota_promedio.')  <br>';
        
        $datos['promedio'] = $tota_promedio;
		
        $datos['lifo']     = $tota_lifo;
        
        return $datos;
        
    }
?>
 
  
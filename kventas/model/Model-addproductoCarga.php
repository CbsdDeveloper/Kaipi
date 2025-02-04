<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
	$obj   = 	new objects;
	$bd	   = 	new Db ;
	
	$registro= $_SESSION['ruc_registro'];
	
    
	$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	 
	
	$idproducto	       =	$_GET["id"];
	$id_movimiento     = 	-1;
 	$cantidad          = 	$_GET["cantidad"];
	$costo             = 	$_GET["costo_carga"];
	$tipo =  'I';

	$idbodega =  ($_GET['idbodega']);
	
	
	$x = $bd->query_array('view_inv_movimiento',
	    'max(id_movimiento) as id_movimiento',
	    'idbodega   ='.$bd->sqlvalue_inyeccion($idbodega,true). ' and
                           transaccion='.$bd->sqlvalue_inyeccion('carga inicial',true). ' and
                           registro   ='.$bd->sqlvalue_inyeccion($registro,true)
	    );
	
	$id_movimiento = $x['id_movimiento'];
	
	
	$Existe = $bd->query_array(
	    'inv_movimiento_det',
	    'count(*) as nn ', 
	    'idproducto='.$bd->sqlvalue_inyeccion($idproducto,true) . ' and 
         id_movimiento = '.$bd->sqlvalue_inyeccion($id_movimiento,true)
	    );
	
	$DatosCarga = 'No Existe movimiento de carga inicial';
	
	if (!$Existe){

	     if ($Existe["nn"] == 0)
            {
            
                $DatosCarga = nuevo( $id_movimiento,$idproducto, $bd ,'S',$tipo,$costo,$cantidad);
                $DatosCarga = 'Dato Procesado ';
                 
            }else  {
                
                editar($id_movimiento,$idproducto, $bd ,$estado,$tipo,$costo,$cantidad);
                
                $DatosCarga = 'Dato Ya Ingresado, puede modificar en movimientoss ';
            }
	}
            
        echo $DatosCarga;
        	
//--- funciones grud	
    function nuevo($id_movimiento,$idproducto, $bd ,$estado,$tipo,$costo,$cantidad){
 	    
 	    //---------------------------------------------------
 	    $IVA               =    12/100;
 	    $IVADesglose       =    1 + $IVA;
 	    $sesion 	       =    $_SESSION['email'];
 	  
 	    //----------------------------------------------------
 	    
 	    $AProducto = $bd->query_array( 'web_producto',
 	        'costo,tributo,saldo',
 	        'idproducto='.$bd->sqlvalue_inyeccion($idproducto,true).' and 
             registro = '.$bd->sqlvalue_inyeccion($registro,true)
 	        );
 	    
 	    
 	    //----------------------------------------------------
 	        $saldo         = $AProducto['saldo'];
 	        $ingreso       = $cantidad;
 	        $egreso        = 0;
 	        $nbandera      = 1;
 	   
 	    
 	    //----------------------------------------------------
  	    
 	    if (trim($AProducto['tributo']) == 'I'){
 	     /*   $total = $AProducto['costo'];
 	        $baseiva     = round($total / $IVADesglose,2);
 	        $tarifa_cero = 0;
 	        $monto_iva   = round($baseiva * $IVA,2);*/
 	        
 	        $baseiva     = $costo * $cantidad ;
 	        $monto_iva   = round($baseiva * $IVA,2);
  	        $total       = $monto_iva + $baseiva ;
  	        $tarifa_cero = '0';
  	        
 	    } else{
 	        $monto_iva   = '0';
 	        $tarifa_cero = $costo;
 	        $baseiva     = '0';
 	        $total = $tarifa_cero;
 	    }
 	    
 	    
 
 	    $ATabla = array(
 	        array( campo => 'idproducto',   tipo => 'VARCHAR2',   id => '0',  add => 'S',   edit => 'S',   valor => $idproducto,   filtro => 'N',   key => 'N'),
 	        array( campo => 'cantidad',   tipo => 'NUMBER',   id => '1',  add => 'S',   edit => 'S',   valor => $cantidad,   filtro => 'N',   key => 'N'),
 	        array( campo => 'id_movimiento',   tipo => 'NUMBER',   id => '2',  add => 'S',   edit => 'N',   valor => $id_movimiento,   filtro => 'N',   key => 'N'),
 	        array( campo => 'id_movimientod',   tipo => 'NUMBER',   id => '3',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
 	        array( campo => 'costo',   tipo => 'NUMBER',   id => '4',  add => 'S',   edit => 'S',   valor => $costo,   filtro => 'N',   key => 'N'),
 	        array( campo => 'total',   tipo => 'NUMBER',   id => '5',  add => 'S',   edit => 'S',   valor => $total,   filtro => 'N',   key => 'N'),
 	        array( campo => 'monto_iva',   tipo => 'NUMBER',   id => '6',  add => 'S',   edit => 'S',   valor => $monto_iva,   filtro => 'N',   key => 'N'),
 	        array( campo => 'tarifa_cero',   tipo => 'NUMBER',   id => '7',  add => 'S',   edit => 'S',   valor => $tarifa_cero,   filtro => 'N',   key => 'N'),
 	        array( campo => 'estado',   tipo => 'VARCHAR2',   id => '8',  add => 'S',   edit => 'S',   valor => 'S',   filtro => 'N',   key => 'N'),
 	        array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '9',  add => 'S',   edit => 'S',   valor => $AProducto['tributo'],   filtro => 'N',   key => 'N'),
 	        array( campo => 'ingreso',   tipo => 'NUMBER',   id => '10',  add => 'S',   edit => 'S',   valor => $ingreso,   filtro => 'N',   key => 'N'),
 	        array( campo => 'egreso',   tipo => 'NUMBER',   id => '11',  add => 'S',   edit => 'S',   valor => $egreso,   filtro => 'N',   key => 'N'),
 	        array( campo => 'baseiva',   tipo => 'NUMBER',   id => '12',  add => 'S',   edit => 'N',   valor => $baseiva,   filtro => 'N',   key => 'N'),
 	        array( campo => 'sesion',   tipo => 'NUMBER',   id => '13',  add => 'S',   edit => 'N',   valor => $sesion,   filtro => 'N',   key => 'N')
 	    );
 	    
 
 	         $id = $bd->_InsertSQL('inv_movimiento_det',$ATabla, '-' );
 	           
 	        
 	    
 	}
 //---------------------
 	function editar($id_movimiento,$idproducto, $bd ,$estado,$tipo,$costo,$cantidad){
 	    
 	    $sql = "update inv_movimiento_det 
                    set cantidad = ".$bd->sqlvalue_inyeccion($cantidad, true).",
                        ingreso= ".$bd->sqlvalue_inyeccion($cantidad, true).'  
                    where     id_movimiento='.$bd->sqlvalue_inyeccion($id_movimiento, true).' and 
                              idproducto='.$bd->sqlvalue_inyeccion($idproducto, true); 
 	    
 	    $bd->ejecutar($sql);
 	    
 	}
   
    
?>
 
  
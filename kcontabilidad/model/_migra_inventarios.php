<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 	$bd	   = new Db ;
 	
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
    $sql ='SELECT bodegas, "Codigo", "Descripcion", "Unidad_Medida", "Cantidad", "Costo", 
  promedio, cuenta FROM migra.ingresoscorrientes' ;
 
    $stmt = $bd->ejecutar($sql);
    
    $i = 1;
    
    while ($x=$bd->obtener_fila($stmt)){
        
        $idD = agregar($bd, $x);
        
        
         echo trim($x["cuenta"]).'   -  '.$idD.'<br> ';
        
        $i++;
        
    }
 //----------------------------------------------------------
  
 //---------------------------
    function agregarDetalle( $bd, $dx ,$idproducto){
        
             
         $sesion 	       =    $_SESSION['email'];
         $bodegas = $dx["bodegas"];
         
         if ($bodegas == '1'){
             $id_movimiento = 1;
         }else{
             $id_movimiento = 2;
         }
         
      
        
        
                 
                 $monto_iva   = '0';
                 $egreso    = '0';
                 $ingreso = $dx["Cantidad"];
                 
                 $tarifa_cero = $dx["promedio"] * $ingreso;
              
                 $baseiva = '0';
                 $total = $tarifa_cero * $ingreso;
                 
                  
                      $ATabla = array(
                          array( campo => 'idproducto',   tipo => 'VARCHAR2',   id => '0',  add => 'S',   edit => 'S',   valor => $idproducto,   filtro => 'N',   key => 'N'),
                          array( campo => 'cantidad',   tipo => 'NUMBER',   id => '1',  add => 'S',   edit => 'S',   valor => $ingreso,   filtro => 'N',   key => 'N'),
                          array( campo => 'id_movimiento',   tipo => 'NUMBER',   id => '2',  add => 'S',   edit => 'S',   valor => $id_movimiento,   filtro => 'N',   key => 'N'),
                          array( campo => 'id_movimientod',   tipo => 'NUMBER',   id => '3',  add => 'N',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'S'),
                          array( campo => 'costo',   tipo => 'NUMBER',   id => '4',  add => 'S',   edit => 'S',   valor => round($dx["promedio"],4),   filtro => 'N',   key => 'N'),
                          array( campo => 'total',   tipo => 'NUMBER',   id => '5',  add => 'S',   edit => 'S',   valor => $total,   filtro => 'N',   key => 'N'),
                          array( campo => 'monto_iva',   tipo => 'NUMBER',   id => '6',  add => 'S',   edit => 'S',   valor => $monto_iva,   filtro => 'N',   key => 'N'),
                          array( campo => 'tarifa_cero',   tipo => 'NUMBER',   id => '7',  add => 'S',   edit => 'S',   valor => $tarifa_cero,   filtro => 'N',   key => 'N'),
                          array( campo => 'estado',   tipo => 'VARCHAR2',   id => '8',  add => 'S',   edit => 'S',   valor => 'S',   filtro => 'N',   key => 'N'),
                          array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '9',  add => 'S',   edit => 'S',   valor => 'T',   filtro => 'N',   key => 'N'),
                          array( campo => 'ingreso',   tipo => 'NUMBER',   id => '10',  add => 'S',   edit => 'S',   valor => $ingreso,   filtro => 'N',   key => 'N'),
                          array( campo => 'egreso',   tipo => 'NUMBER',   id => '11',  add => 'S',   edit => 'S',   valor => $egreso,   filtro => 'N',   key => 'N'),
                          array( campo => 'baseiva',   tipo => 'NUMBER',   id => '12',  add => 'S',   edit => 'N',   valor => $baseiva,   filtro => 'N',   key => 'N'),
                          array( campo => 'sesion',   tipo => 'VARCHAR2',   id => '13',  add => 'S',   edit => 'N',   valor => $sesion,   filtro => 'N',   key => 'N'),
                          array( campo => 'descuento',   tipo => 'NUMBER',   id => '14',  add => 'S',   edit => 'N',   valor => '0',   filtro => 'N',   key => 'N'),
                          array( campo => 'pdescuento',   tipo => 'NUMBER',   id => '15',  add => 'S',   edit => 'N',   valor => '0',   filtro => 'N',   key => 'N')
                      );
                
                      $bd->_InsertSQL('inv_movimiento_det',$ATabla, '-' );

 
    }
    //---------------------------
    function agregar( $bd, $x ){
        
        
    

        $cuenta1 = $x["cuenta"];
        $cuenta2 = '-';
        
        $costo = round($x["promedio"],4);
        
        $ruc        = $_SESSION['ruc_registro'];
        
        $InsertQuery = array(
            array( campo => 'producto',   valor => strtoupper (trim($x["Descripcion"]))),
            array( campo => 'referencia',   valor => $x["Codigo"]),
            array( campo => 'tipo',   valor => 'B'),
            array( campo => 'idcategoria',   valor => 1),
            array( campo => 'estado',   valor => 'S'),
            array( campo => 'url',   valor => '-'),
            array( campo => 'idmarca',  0),
            array( campo => 'unidad',   valor => 'unidad'),
            array( campo => 'facturacion',   valor => 'N'),
            array( campo => 'saldo',   valor => $x["Cantidad"]),
            array( campo => 'idbodega',   valor => $x["bodegas"]),
            array( campo => 'cuenta_inv',   valor => $cuenta1),
            array( campo => 'cuenta_ing',   valor => $cuenta2),
            array( campo => 'minimo',   valor => 5),
            array( campo => 'codigo',   valor => $x["Codigo"]),
            array( campo => 'tributo',   valor => 'I'),
            array( campo => 'costo',   valor => $costo),
            array( campo => 'promedio',   valor => $costo),
            array( campo => 'codigob',   valor => '-'),
            array( campo => 'controlserie',   valor =>  '-'),
            array( campo => 'cuenta_gas',   valor =>'-'),
            array( campo => 'registro',   valor => $ruc ),
            array( campo => 'tipourl',       valor => '1' )
        );
        
        
        
        $idD = $bd->JqueryInsertSQL('web_producto',$InsertQuery);
         
        agregarDetalle($bd, $x,$idD);
           
        return $idD;
     	
     	
    }
    
?>
 
  
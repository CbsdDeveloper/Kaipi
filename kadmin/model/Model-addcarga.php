<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
	$obj   = 	new objects;
	$bd	   = 	new Db ;
	
	$registro= $_SESSION['ruc_registro'];
	
    
	$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
	$categoria	       =	$_GET["categoria"];
	$id_movimiento     = 	$_GET["id_movimiento"];
	$id                = 	$_GET["id"];
	$accion            = 	$_GET["accion"];
	$estado            = trim($_GET["estado"]);
	
	
	if ($accion == 'add'){
	    nuevo( $id_movimiento,$categoria, $bd ,$estado,'I');
	}
	
	if ($accion == 'eliminar'){
	    elimina_dato( $id, $bd,$estado );
	}
	

//--- funciones grud	
 
	function nuevo($id_movimiento,$categoria, $bd ,$estado,$tipo ){
 	  
 
	    
	    $AResultado = $bd->query_array('web_categoria','idcategoria', 
	        'nombre='.$bd->sqlvalue_inyeccion($categoria,true));
	    
	    
	    
 	   $sql = "SELECT idproducto, producto, referencia,  unidad, saldo, url,  costo 
                FROM  web_producto
                where  	tipo  =  'B' and 
                		idcategoria = ".$bd->sqlvalue_inyeccion($AResultado['idcategoria'],true);
	 
	    $stmt = $bd->ejecutar($sql);
	    
	    $hoy = date("Y-m-d");  
	    
	    //---- insert grupo
	    while ($x=$bd->obtener_fila($stmt)){
	        
	        $ATabla = array(
	            array( campo => 'idcarga_inicial',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
	            array( campo => 'idproducto',   tipo => 'NUMBER',   id => '1',  add => 'S',   edit => 'S',   valor => $x['idproducto'],   filtro => 'N',   key => 'N'),
	            array( campo => 'cantidad',   tipo => 'NUMBER',   id => '2',  add => 'S',   edit => 'S',   valor => 0,   filtro => 'N',   key => 'N'),
	            array( campo => 'costo',   tipo => 'NUMBER',   id => '3',  add => 'S',   edit => 'S',   valor => $x['costo'],   filtro => 'N',   key => 'N'),
	            array( campo => 'sesion',   tipo => 'VARCHAR2',   id => '4',  add => 'S',   edit => 'S',   valor => $_SESSION['email'],   filtro => 'N',   key => 'N'),
	            array( campo => 'creacion',   tipo => 'DATE',   id => '5',  add => 'S',   edit => 'S',   valor => $hoy,   filtro => 'N',   key => 'N'),
	            array( campo => 'registro',   tipo => 'VARCHAR2',   id => '6',  add => 'S',   edit => 'S',   valor => $x['url'],   filtro => 'N',   key => 'N'),
	            array( campo => 'producto',   tipo => 'VARCHAR2',   id => '7',  add => 'S',   edit => 'S',   valor =>  $x['producto'],   filtro => 'N',   key => 'N'),
	            array( campo => 'total',   tipo => 'NUMBER',   id => '8',  add => 'N',   edit => 'S',   valor => 0,   filtro => 'N',   key => 'N'),
	            array( campo => 'saldo',   tipo => 'NUMBER',   id => '9',  add => 'S',   edit => 'S',   valor => $x['saldo'],   filtro => 'N',   key => 'N'),
	            array( campo => 'id_cmovimiento',   tipo => 'NUMBER',   id => '10',  add => 'S',   edit => 'N',   valor => $id_movimiento,   filtro => 'N',   key => 'N'),
	        );
	        
	        $Aproducto = $bd->query_array('inv_carga_inicial',
	                                      'count(idcarga_inicial) as registro',
	                                      'id_cmovimiento='.$bd->sqlvalue_inyeccion($id_movimiento,true).' and 
                                           idproducto='.$bd->sqlvalue_inyeccion($x['idproducto'],true)
	            
	            );
	            
	        if ( $estado == 'digitado'){
	            if ($Aproducto['registro']== 0){
	                $id = $bd->_InsertSQL('inv_carga_inicial',$ATabla, '-' );
	             
	            }
  	        }
	        
	    }
 }
 	//--- funciones grud
 	
 	function elimina_dato($id, $bd ,$estado ){
 	    
 	    $tabla = 'inv_carga_inicial';
 	    
 	    $where = 'idcarga_inicial = '.$id;
 	    
 	    if ( $estado == 'digitado'){
 	        
 	        $bd->JqueryDeleteSQL($tabla,$where);
 	        
 	    }
 	   
 	    
 	}
    
   
    
?>
 
  
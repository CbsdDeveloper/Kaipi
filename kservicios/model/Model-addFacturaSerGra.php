<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
 
	$bd	   = 	new Db ;
 
	
    
	$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
	$idproducto	       =	$_GET["idproducto"];
	
	$id_movimiento     = 	$_GET["id_movimiento"];
	
	$id                = 	$_GET["id"];
	
	$accion            = 	$_GET["accion"];
 
 	$estado 		   =    trim($_GET["estado"]);

	$costo			   =    $_GET["costo"];
	
	$tipo   		   = 'S';
	
	
 	
	
	if ($accion == 'add'){
	    if ($idproducto  > 0){
	        nuevo( $id_movimiento,$idproducto, $bd ,$estado,$tipo,$costo);
	    }
	}
	
	if ($accion == 'eliminar'){
	    elimina_dato( $id, $bd,$estado );
	}
	

//--- funciones grud	
 
	function nuevo($id_movimiento,$idproducto, $bd ,$estado,$tipo,$costo ){
 	    
 	    //---------------------------------------------------
 
 	    $sesion 	       =    trim($_SESSION['email']);
		$creacion		   =    date('Y-m-d');
 	   	    
 	    
 	    $ATabla = array(
 	       
			  array( campo => 'idproducto_ser',tipo => 'NUMBER',id => '0',add => 'S', edit => 'N', valor =>$idproducto, key => 'N'),
			  array( campo => 'id_ren_movimiento',tipo => 'NUMBER',id => '1',add => 'S', edit => 'S', valor => '0', key => 'N'),
			  array( campo => 'id_ren_movimientod',   tipo => 'NUMBER',   id => '3',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
			  array( campo => 'costo',tipo => 'NUMBER',id => '3',add => 'S', edit => 'S', valor => $costo , key => 'N'),
			  array( campo => 'monto_iva',tipo => 'NUMBER',id => '4',add => 'S', edit => 'S', valor => '0.00', key => 'N'),
			  array( campo => 'baseiva',tipo => 'NUMBER',id => '5',add => 'S', edit => 'S', valor => '0.00', key => 'N'),
			  array( campo => 'tarifa_cero',tipo => 'NUMBER',id => '6',add => 'S', edit => 'S', valor =>$costo, key => 'N'),
			  array( campo => 'descuento',tipo => 'NUMBER',id => '7',add => 'S', edit => 'S', valor => '0.00', key => 'N'),
			  array( campo => 'interes',tipo => 'NUMBER',id => '8',add => 'S', edit => 'S', valor => '0.00', key => 'N'),
			  array( campo => 'recargo',tipo => 'NUMBER',id => '9',add => 'S', edit => 'S', valor => '0.00', key => 'N'),
			  array( campo => 'total',tipo => 'NUMBER',id => '10',add => 'S', edit => 'S', valor => $costo, key => 'N'),
			  array( campo => 'tipo',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'S', valor => '0', key => 'N'),
			  array( campo => 'sesion',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'S', valor =>$sesion, key => 'N'),
			  array( campo => 'creacion',tipo => 'DATE',id => '13',add => 'S', edit => 'S', valor =>$creacion, key => 'N') 
  	    );
 	    



		  $Avalida = $bd->query_array('rentas.ren_movimiento_det',    
								'count(*) as nexiste',                        // CAMPOS
								'sesion ='.$bd->sqlvalue_inyeccion (trim($sesion), true).' and
								idproducto_ser='.$bd->sqlvalue_inyeccion($idproducto, true) .' and 
								id_ren_movimiento = 0'
			);		

			if ( trim($estado) == 'D'){

				if ($Avalida['nexiste'] == 0 ){
					
					$id = $bd->_InsertSQL('rentas.ren_movimiento_det',$ATabla, 'rentas.ren_movimiento_det_id_ren_movimientod_seq' );
					
					echo ' ok ' ;
				}		
			}else{
			 
				echo 'Ya existe...';

			}

		 
 	    
 	    
 	}
 	//--- funciones grud
 	
 	function elimina_dato($id, $bd ,$estado ){
 	    
 	    $tabla = 'rentas.ren_movimiento_det';
 	    
 	    $where = 'id_ren_movimientod = '.$id;
 	    
 	    if ( $estado == 'D'){
 	        
 	        $bd->JqueryDeleteSQL($tabla,$where);
 	        
 	    }
 	   
 	    
 	}
    
   
    
?>
 
  
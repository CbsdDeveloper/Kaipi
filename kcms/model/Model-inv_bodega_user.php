<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
	$obj   = 	new objects;
	$bd	   = 	new Db ;
	
	$registro= $_SESSION['ruc_registro'];
	
    
	$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	
 
	$idbodega	       =	$_GET["idbodega"];
	$tipo              = 	$_GET["tipo"];
	$sesion            = 	trim($_GET["sesion"]);
	
	
	if ($tipo == '1'){
	    nuevo($bd, $idbodega,$registro,$sesion);
	}
	
	if ($tipo == '2'){
	    elimina_dato($bd, $idbodega,$registro,$sesion );
	}
	
	
	$sql = 'SELECT idbodega_user, idbodega, sesion, registro
            FROM inv_bodega_user
			WHERE registro ='.$bd->sqlvalue_inyeccion($registro, true).' and
		          idbodega='.$bd->sqlvalue_inyeccion($idbodega, true);
	
	$stmt12 = $bd->ejecutar($sql);
	
	$ViewUser = '<div class="col-md-12"> <h6>Lista usuarios asignados</h6><ul class="list-group">';
	
	while ($x=$bd->obtener_fila($stmt12)){
	    
	    $ViewUser .= '<li class="list-group-item" title="Dar Click para eliminar" onClick="UserBodegaDel('.$x['idbodega_user'].',2);">'.$x['sesion'].'</li>';
	    
	}
	
	$ViewUser .= '</ul></div>';
	
 
	
	echo $ViewUser;
	
	

//--- funciones grud	
 
	function nuevo( $bd,$idbodega,$registro,$sesion){
 	  
 	        $ATabla = array(
	            array( campo => 'idbodega_user',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
 	            array( campo => 'idbodega',   tipo => 'NUMBER',   id => '1',  add => 'S',   edit => 'S',   valor => $idbodega,   filtro => 'N',   key => 'N'),
 	            array( campo => 'sesion',   tipo => 'NUMBER',   id => '2',  add => 'S',   edit => 'S',   valor => $sesion,   filtro => 'N',   key => 'N'),
 	            array( campo => 'registro',   tipo => 'NUMBER',   id => '3',  add => 'S',   edit => 'S',   valor => $registro,   filtro => 'N',   key => 'N'),
	        );
	        
 	        $longitud = strlen($sesion);
	      
 	        $bandera = busca_dato($bd,$idbodega,$registro,$sesion );
 	        
 	        if ($longitud > 10 ){
 	            if ( $bandera == 0 ){
 	                $bd->_InsertSQL('inv_bodega_user',$ATabla, 'inv_bodega_user_idbodega_user_seq' );
 	            }
	          
 	        }
	      
 }
 	//--- funciones grud
 	
 function elimina_dato($bd, $idbodega,$registro,$sesion){
 	    

        $tabla = 'inv_bodega_user';
 	    $where = 'idbodega_user = '.$bd->sqlvalue_inyeccion($sesion,true);
 	    
        $bd->JqueryDeleteSQL($tabla,$where);
 
 	   
 	    
 	}
 //-----------------------------------   
 	function busca_dato($bd,$idbodega,$registro,$sesion ){
 
 	        
 	    $Aver = $bd->query_array('inv_bodega_user',
 	                                   'count(*) as nn', 
                             	        'idbodega='.$bd->sqlvalue_inyeccion($idbodega,true).
                             	        ' and sesion='.$bd->sqlvalue_inyeccion($sesion,true).
                             	        ' and registro='.$bd->sqlvalue_inyeccion($registro,true)
 	        );
 	    
 	    return $Aver['nn'];
 	}
    
?>
 
  
<?php 
session_start();   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 
	$bd	   = 	new Db ;
	
	$registro= $_SESSION['ruc_registro'];
	
    
	$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	
	$id                = 	$_POST["id"];
	$accion            = 	$_POST["accion"];
	
	$comprobante1      = 	$_POST["comprobante1"];
	$fecha_factura     = 	$_POST["fecha_factura"];
	$secuencial1       = 	$_POST["secuencial1"];
	$estab1            = 	$_POST["estab1"];
	$ptoemi1           = 	$_POST["ptoemi1"];
	$fechaemisiondocsustento   =  	$_POST["fechaemisiondocsustento"];
	$coddocmodificado          = 	$_POST["coddocmodificado"];
	$numdocmodificado          = 	$_POST["numdocmodificado"];
	$idcliente                 = 	$_POST["idcliente"];
	$id_diario                 = 	$_POST["id_diario"];
 
	
	if ($accion == 'add'){
	   
	    if ( $id_diario > 0 )  {
	       
	        $sql = "UPDATE inv_movimiento
						                    SET 	estado=".$bd->sqlvalue_inyeccion('notacredito', true)."
 						                  WHERE id_movimiento=".$bd->sqlvalue_inyeccion($id, true);
	        
	        $bd->ejecutar($sql);
	        
 	        
	        echo $secuencial1;
	        
	    }    
	    else   {
	        
	     $secuencial1 =  nuevo(  $bd, $registro,$id,$idcliente,$comprobante1,$fecha_factura,
	                            $secuencial1,$estab1,$ptoemi1,$fechaemisiondocsustento,
	                            $coddocmodificado,$numdocmodificado);
	     
	     echo $secuencial1;
	     
	    }
	 
	   
	}
	
	if ($accion == 'eliminar'){
	    
	    elimina_dato( $id, $bd );
	    
	}
	
//--------------------------------------------------
//--- funciones grud	
 
	function nuevo($bd, $registro,$id,$idcliente,$comprobante1,$fecha_factura,$secuencial1,
	                    $estab1,$ptoemi1,$fechaemisiondocsustento,
	                    $coddocmodificado,$numdocmodificado ){
 	  
	    $x = $bd->query_array('doctor_vta',
	                          'max(secuencial1) as nn', 
	                          'registro ='.$bd->sqlvalue_inyeccion($registro,true)
	                         );
	 	    
	 //   if (empty($secuencial1)){
	        
	        $secuencial1 = $x["nn"] + 1 ;
	        
	//    }
	    
	    $ATabla = array(
	        array( campo => 'id_pkvta',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
	        array( campo => 'id_diario',tipo => 'NUMBER',id => '0',add => 'S', edit => 'S', valor => $id, key => 'N'),
	        array( campo => 'idcliente',tipo => 'VARCHAR2',id => '1',add => 'S', edit => 'S', valor => $idcliente, key => 'N'),
	        array( campo => 'tipocomprobante',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => '01', key => 'N'),
	        array( campo => 'nombre',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => 'NC', key => 'N'),
	        array( campo => 'formapago',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => '00', key => 'N'),
	        array( campo => 'tipopago',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => '00', key => 'N'),
	        array( campo => 'comprobante1',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => $comprobante1, key => 'N'),
	        array( campo => 'secuencial',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => $secuencial1, key => 'N'),
	        array( campo => 'codestab',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor => $estab1, key => 'N'),
	        array( campo => 'coddocmodificado',tipo => 'VARCHAR2',id => '10',add => 'S', edit => 'S', valor => $coddocmodificado, key => 'N'),
	        array( campo => 'numdocmodificado',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'S', valor => $numdocmodificado, key => 'N'),
	        array( campo => 'registro',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'S', valor => $registro, key => 'N'),
	        array( campo => 'usuario',tipo => 'VARCHAR2',id => '13',add => 'S', edit => 'S', valor => 'facturacion', key => 'N'),
	        array( campo => 'fechaemision',tipo => 'DATE',id => '16',add => 'S', edit => 'S', valor => $fechaemisiondocsustento, key => 'N'),
	        array( campo => 'secuencial1',tipo => 'VARCHAR2',id => '17',add => 'S', edit => 'S', valor => $secuencial1, key => 'N'),
	        array( campo => 'cab_autorizacion',tipo => 'VARCHAR2',id => '18',add => 'N', edit => 'S', valor => '-', key => 'N'),
	        array( campo => 'fechaemisiondocsustento',tipo => 'DATE',id => '19',add => 'S', edit => 'S', valor => $fechaemisiondocsustento, key => 'N'),
	        array( campo => 'fecha_factura',tipo => 'DATE',id => '20',add => 'S', edit => 'S', valor => $fecha_factura, key => 'N'),
	        array( campo => 'estab1',tipo => 'VARCHAR2',id => '21',add => 'S', edit => 'S', valor => $estab1, key => 'N'),
	        array( campo => 'ptoemi1',tipo => 'VARCHAR2',id => '22',add => 'S', edit => 'S', valor => $ptoemi1, key => 'N')
	    );
	    
	    
	    $id = $bd->_InsertSQL('doctor_vta',$ATabla,'id_doctor_vta');
	    
	     
	    return $secuencial1;
	   
 }
 	//--- funciones grud
 	
 	function elimina_dato($id, $bd  ){
 	    
 	    $tabla = 'inv_carga_inicial';
 	    
 	    $where = 'idcarga_inicial = '.$id;
 	    
 	    
 	    $bd->JqueryDeleteSQL($tabla,$where);
 	        
 	 
 	   
 	    
 	}
    
   
    
?>
 
  
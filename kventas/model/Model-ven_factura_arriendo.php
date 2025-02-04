<?php
session_start( );

require '../../kconfig/Db.class.php';    

require '../../kconfig/Obj.conf.php';  

require 'interes_mensual.php';  

class proceso{
	
 
	
	private $obj;
	private $bd;
	
	private $ruc;
	public  $sesion;
	public  $hoy;
	private $POST;
	private $ATabla;
	private $ATablaPago;
	private $tabla ;
	private $secuencia;
	private $finteres;
	private $estado_periodo;
	
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function proceso( ){
		//inicializamos la clase para conectarnos a la bd
		
		$this->obj     = 	new objects;
		$this->bd	   =	new Db ;
		
		$this->ruc       =     $_SESSION['ruc_registro'];
		
		$this->sesion 	 =     trim($_SESSION['email']);
		
		$this->hoy 	     =     date("Y-m-d");    	 
		
		$this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
		
		$this->finteres     = 	new interes_variable( $this->obj,  $this->bd);
		
		$this->ATabla = array(
				array( campo => 'id_movimiento',   tipo => 'VARCHAR2',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
				array( campo => 'fecha',   tipo => 'DATE',   id => '1',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'registro',   tipo => 'VARCHAR2',   id => '2',  add => 'S',   edit => 'N',   valor => $this->ruc,   filtro => 'N',   key => 'N'),
				array( campo => 'detalle',   tipo => 'VARCHAR2',   id => '3',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'sesion',   tipo => 'VARCHAR2',   id => '4',  add => 'S',   edit => 'S',   valor => $this->sesion ,   filtro => 'N',   key => 'N'),
				array( campo => 'creacion',   tipo => 'DATE',   id => '5',  add => 'S',   edit => 'N',   valor => $this->hoy,   filtro => 'N',   key => 'N'),
				array( campo => 'comprobante',   tipo => 'VARCHAR2',   id => '6',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'estado',   tipo => 'VARCHAR2',   id => '7',  add => 'S',   edit => 'N',   valor => 'digitado',   filtro => 'N',   key => 'N'),
				array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '8',  add => 'S',   edit => 'N',   valor => 'F',   filtro => 'N',   key => 'N'),
				array( campo => 'id_periodo',   tipo => 'NUMBER',   id => '9',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
		        array( campo => 'documento',   tipo => 'VARCHAR2',   id => '10',  add => 'S',   edit => 'S',   valor => '00000',   filtro => 'N',   key => 'N'),
				array( campo => 'idprov',   tipo => 'VARCHAR2',   id => '11',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'id_asiento_ref',   tipo => 'NUMBER',   id => '12',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'fechaa',   tipo => 'DATE',   id => '13',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
		        array( campo => 'cierre',   tipo => 'VARCHAR2',   id => '14',  add => 'S',   edit => 'N',   valor => 'N',   filtro => 'N',   key => 'N'),
		    array( campo => 'base12',   tipo => 'NUMBER',   id => '15',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'iva',   tipo => 'NUMBER',   id => '16',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'base0',   tipo => 'NUMBER',   id => '17',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'total',   tipo => 'NUMBER',   id => '18',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'novedad',   tipo => 'VARCHAR2',   id => '19',  add => 'S',   edit => 'N',   valor => 'servicio',   filtro => 'N',   key => 'N'),
		    array( campo => 'idbodega',   tipo => 'NUMBER',   id => '20',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'carga',   tipo => 'VARCHAR2',   id => '21',  add => 'S',   edit => 'N',   valor => '0',   filtro => 'N',   key => 'N'),
		    array( campo => 'modulo',   tipo => 'VARCHAR2',   id => '22',  add => 'S',   edit => 'N',   valor => 'arriendo',   filtro => 'N',   key => 'N')
 		);
		
		
		$this->ATablaPago = array(
		    array( campo => 'id_movimiento',   tipo => 'VARCHAR2',   id => '0',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'formapago',   tipo => 'VARCHAR2',   id => '1',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'tipopago',   tipo => 'VARCHAR2',   id => '2',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'monto',   tipo => 'NUMBER',   id => '3',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'idbanco',   tipo => 'NUMBER',   id => '4',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'cuenta',   tipo => 'VARCHAR2',   id => '5',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'fecha',   tipo => 'DATE',   id => '6',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'sesion',   tipo => 'VARCHAR2',   id => '7',  add => 'S',   edit => 'S',   valor => $this->sesion,   filtro => 'N',   key => 'N'),
		    array( campo => 'idfacpago',   tipo => 'NUMBER',   id => '8',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S')
		);
		
		
		$this->tabla 	  	  = 'inv_movimiento';
		
		$this->secuencia 	     = '-';
		
	}
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function div_resultado($accion,$id,$tipo){
		//inicializamos la clase para conectarnos a la bd
		
		if ($tipo == 0){
			
			
			
			if ($accion == 'editar')
			    $resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>EDITAR REGISTRO TRANSACCION ?</b>';
			    
				if ($accion == 'del')
				    $resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ELIMINAR REGISTRO TRANSACCION ?</b>';
				    
		}
		
		if ($tipo == 1){
			
 			
			$resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO ['.$id.']</b>';
			
		}
		
		echo '<script type="text/javascript">accion('.$id.',"'.$accion.'" );</script>';
		
 		
		return $resultado;
		
	}
	
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function div_limpiar( ){
		//inicializamos la clase para conectarnos a la bd
		
		$resultado = '';
		
		echo '<script type="text/javascript">';
		
		echo  'LimpiarPantalla();';
		
		echo '</script>';
		
		return $resultado;
		
	}
	
	
	
	//--------------------------------------------------------------------------------
	//--- busqueda de por codigo para llenar los datos
	//--------------------------------------------------------------------------------
	function consultaId($accion,$id ){
		
 
		$qquery = array(  
		    array( campo => 'id_movimiento',   valor => $id,  filtro => 'S',   visor => 'S'),
		    array( campo => 'fecha',   valor => '-',  filtro => 'N',   visor => 'S'),
  		    array( campo => 'comprobante',   valor => '-',  filtro => 'N',   visor => 'S'),
		    array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
 		    array( campo => 'idprov',   valor => '-',  filtro => 'N',   visor => 'S'),
		    array( campo => 'detalle',   valor => '-',  filtro => 'N',   visor => 'S'),
		    array( campo => 'fechaa',   valor => '-',  filtro => 'N',   visor => 'S'),
		    array( campo => 'carga',   valor => '-',  filtro => 'N',   visor => 'S'),
  		    array( campo => 'razon',   valor => '-',  filtro => 'N',   visor => 'S')
 		);
		
	    $this->bd->JqueryArrayVisor('view_ventas_fac',$qquery );
		
		$result =  $this->div_resultado($accion,$id,0);
		
		echo  $result;
	}
	
	///*-----------------------------------------------------------------
	
	function inserta_interes( $id_movimiento  ){
	    
	  
	    
	    $costo = $this->finteres->_arriendo_facturacion($id_movimiento) ;
	  
	   
	    
	    $idproducto = 1084;
	    
	    $x =  $this->bd->query_array('inv_movimiento_det',
	        'id_movimientod',
	        'id_movimiento='.$this->bd->sqlvalue_inyeccion($id_movimiento,true). ' and
             idproducto='.$this->bd->sqlvalue_inyeccion($idproducto,true)
	        );
	    
	  
	    
	    $ATabla = array(
	        array( campo => 'idproducto',   tipo => 'VARCHAR2',   id => '0',  add => 'S',   edit => 'N',   valor => $idproducto,   filtro => 'N',   key => 'N'),
	        array( campo => 'cantidad',   tipo => 'NUMBER',   id => '1',  add => 'S',   edit => 'N',   valor => 1,   filtro => 'N',   key => 'N'),
	        array( campo => 'id_movimiento',   tipo => 'NUMBER',   id => '2',  add => 'S',   edit => 'N',   valor => $id_movimiento,   filtro => 'N',   key => 'N'),
	        array( campo => 'id_movimientod',   tipo => 'NUMBER',   id => '3',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
	        array( campo => 'costo',   tipo => 'NUMBER',   id => '4',  add => 'S',   edit => 'S',   valor => $costo,   filtro => 'N',   key => 'N'),
	        array( campo => 'total',   tipo => 'NUMBER',   id => '5',  add => 'S',   edit => 'S',   valor => $costo,   filtro => 'N',   key => 'N'),
	        array( campo => 'monto_iva',   tipo => 'NUMBER',   id => '6',  add => 'S',   edit => 'N',   valor => '0.00',   filtro => 'N',   key => 'N'),
	        array( campo => 'tarifa_cero',   tipo => 'NUMBER',   id => '7',  add => 'S',   edit => 'S',   valor => $costo,   filtro => 'N',   key => 'N'),
	        array( campo => 'estado',   tipo => 'VARCHAR2',   id => '8',  add => 'S',   edit => 'N',   valor => 'S',   filtro => 'N',   key => 'N'),
	        array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '9',  add => 'S',   edit => 'N',   valor => 'T',   filtro => 'N',   key => 'N'),
	        array( campo => 'ingreso',   tipo => 'NUMBER',   id => '10',  add => 'S',   edit => 'N',   valor => '0',   filtro => 'N',   key => 'N'),
	        array( campo => 'egreso',   tipo => 'NUMBER',   id => '11',  add => 'S',   edit => 'N',   valor => '1',   filtro => 'N',   key => 'N'),
	        array( campo => 'baseiva',   tipo => 'NUMBER',   id => '12',  add => 'S',   edit => 'N',   valor => '0.00',   filtro => 'N',   key => 'N'),
	        array( campo => 'sesion',   tipo => 'VARCHAR2',   id => '13',  add => 'S',   edit => 'N',   valor => $this->sesion,   filtro => 'N',   key => 'N')
	        
	    );
	    
	    if ( $x['id_movimientod']  > 0 ) {
	        
	        $this->bd->_UpdateSQL('inv_movimiento_det',$ATabla,$x['id_movimientod']);
	        
	    }else{
	        $this->bd->_InsertSQL('inv_movimiento_det',$ATabla, '-' );
	    }
	    
	    
	    
	}
	
	
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	
	function xcrud($action,$id){
		
		
		// ------------------  agregar
		if ($action == 'add'){
			
			$this->agregar();
			
		}
		// ------------------  editar
		if ($action == 'editar'){
			
			$this->edicion($id );
			
		}
		// ------------------  eliminar
		if ($action == 'del'){
			
			$this->eliminar($id );
			
		}
		
	}
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	function agregar( ){
		
		$fecha =  $_POST["fecha"];
		
		$idperiodo = $this->periodo($fecha);
		
		$this->ATabla[9][valor] =  $idperiodo;
		
		$idprov =  trim($_POST["idprov"]);
		
		$efectivo = trim($_POST["efectivo"]);
		
		if (empty($efectivo)){
		    $efectivo= 0;
		}
		
		$formapago =trim($_POST["formapago"]);
		
		$this->ATabla[11][valor] =  trim($idprov);
		
		
		$result = $this->estado_periodo ;
		
		if ( $formapago   <> '-'){
		
        		if ( $this->estado_periodo == 'abierto' ){
        		    
        		    if (!empty($idprov)){
        		        
        		        $nruc = $this->_valida_prov($idprov);
        		        
        		        if ($nruc >= 1){
        		            
        		            if ( $efectivo >= 0 ){
        			
                    			$id = $this->bd->_InsertSQL($this->tabla,$this->ATabla, '-' );
                    			
                    			$result = $this->div_resultado('editar',$id,1);
                    			
                    			$this->DetalleMov($id);
                    			
                    			$tot = $this->DetalleTotal($id);
                    			
                    			$this->DetallePago($id,$tot);
                    			
                    			 
                    			
        		            }else {
        		                $result = 'Aplique forma y pago de la factura... Seleccione forma de pago';
        		            }
        		        }else{
        		            $result = 'Registre la informacion del cliente... complete su informacion!!! ';
        		        }
        		    }
        		}else{
        			
        			$result = 'Periodo que desea generar no esta abierto... aperture desde contabilidad';
        	
        		}
		}else {
		    $result = 'Periodo que desea generar no esta abierto... Seleccione forma de pago';
		}
	 
		echo $result;
		
	}
	//--------------------------------------------------------------------------------
	//--- edicion de registros
	//--------------------------------------------------------------------------------
	function edicion($id  ){
		
	    $estado =  $_POST["estado"];
	    
	    $idprov =  trim($_POST["idprov"]);
	    
	    $carga =  $_POST["carga"];
	    
	    $efectivo = trim($_POST["efectivo"]);
	    
	    if (empty($efectivo)){
	        $efectivo= 0;
	    }
	    
	    $this->ATabla[11][valor] =  trim($idprov);
	    
	  
	    
	    $formapago =trim($_POST["formapago"]);
	    
 	    if ( $formapago   <> '-'){
  	    
        	    if ($carga == '9') {
        	        $this->DetalleMovSin($id);
        	    }
        	        
        	    if ($estado == 'digitado') {
        	        
        	        $nruc = $this->_valida_prov($idprov);
        	        
        	        if ($nruc >= 1){
        	            
        	            if ( $efectivo >= 0 ){
        	                
                      		$this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
                    			
                      		$this->inserta_interes( $id  );
                      		
                      		$result =$this->div_resultado('editar',$id,1).' '.$idprov;
                    			
                    		$this->DetalleMov($id);
                    		
                    		$tot= $this->DetalleTotal($id);
                    		
                    		$this->DetallePago($id,$tot);
                    		
        	            }else {
        	                $result = 'Registre el monto pagado... Seleccione forma de pago';
        	            }
        	        }
        	    }		
	    
 	    }else {
 	        
 	        $result = 'Registre el monto pagado. .. Seleccione forma de pago';
 	        
 	    }
		
	    echo $result   ;
	}
	
	//--------------------------------------------------------------------------------
	//--- eliminar de registros
	//--------------------------------------------------------------------------------
	function eliminar($id ){
	
	    $AEstado = $this->bd->query_array('inv_movimiento',
	        'estado, autorizacion, 	envio',
	        'id_movimiento='.$this->bd->sqlvalue_inyeccion($id,true)
	        );
	    
	    
	    $result = '<b> REGISTRO NO ANULADO .... </b> '.$id ;
	    
	    
	    if (trim($AEstado['estado'])  == 'digitado'){
	        
	        $sql = 'delete from inv_movimiento_det  where id_movimiento='.$this->bd->sqlvalue_inyeccion($id, true);
	        
	        
	        $this->bd->ejecutar($sql);
	        
	        
	        $sql = 'delete from inv_movimiento  where id_movimiento='.$this->bd->sqlvalue_inyeccion($id, true);
	        
	        
	        $this->bd->ejecutar($sql);
	        
	        
	        $result = $this->div_limpiar();
	        
	    }else{
	        
	        $verifica = strlen(trim($AEstado['autorizacion']) );
	        
	        $enviado  = trim($AEstado['envio']);
	        
	        $result = '<b> NO SE PUEDE ELIMINAR EL REGISTRO !!!.... </b> ' . $verifica. ' '. $enviado;
	        
	        if ( $verifica > 5 ){
	            
	            if ( $enviado <>'S' ) {
	                
	                $sql = "update inv_movimiento set estado = 'anulado'
                                 where id_movimiento=".$this->bd->sqlvalue_inyeccion($id, true);
	                
	                $this->bd->ejecutar($sql);
	                
	                $result = $this->div_limpiar();
	                
	                $result = '<b> REGISTRO ANULADO .... </b> '.$id ;
	                
	                
	            }
	          
	        }else{
	            
	            $sql = "update inv_movimiento set estado = 'anulado'
                                 where id_movimiento=".$this->bd->sqlvalue_inyeccion($id, true);
	            
	            $this->bd->ejecutar($sql);
	            
	            $result = $this->div_limpiar();
	            
	            $result = '<b> REGISTRO ANULADO .... </b> '.$id ;
	            
	        }
	        
	        
	    }
	    
	    
	    echo $result;
		
	}
	//---------------------------------------
	function periodo($fecha ){
		
		$anio = substr($fecha, 0, 4);
		$mes  = substr($fecha, 5, 2);
		
		$APeriodo = $this->bd->query_array('co_periodo',
				'id_periodo, estado',
				'registro='.$this->bd->sqlvalue_inyeccion($this->ruc,true). ' AND
											  mes = '.$this->bd->sqlvalue_inyeccion($mes,true). ' AND
											  anio ='.$this->bd->sqlvalue_inyeccion($anio,true)
				);
		
 
		$this->estado_periodo = trim($APeriodo['estado']);
		
		return $APeriodo['id_periodo'];
		
	}
	//---------------------------------------
	function _valida_prov($proveedor){
	    
	  
	 
	    
	    $APeriodo = $this->bd->query_array('par_ciu',
	        'count(*) as nn',
	        'idprov='.$this->bd->sqlvalue_inyeccion($proveedor,true) 
	        );
	    
	    
	  
	    
	    return $APeriodo['nn'];
	    
	}
	//-----------------------------------------------------------
	function ActualizaPrecio($idproducto,$precio ){
	    
	   
	    
	    $APrecio = $this->bd->query_array(
	        'inv_producto_vta',
	        'count(id_producto) as valido',
	        'id_producto='.$this->bd->sqlvalue_inyeccion($idproducto,true) 
	        );
	    
 
	     $existe =   $APrecio['valido'] ;
	    
	     if ($existe == 0 ){
	         
	         $InsertQuery = array(
	             array( campo => 'id_producto',   valor => $idproducto  ),
	             array( campo => 'monto',   valor =>$precio ),
	             array( campo => 'activo',   valor => 'S'),
	             array( campo => 'detalle',   valor =>  'Normal'),
	             array( campo => 'principal',   valor => 'S')
	         );
	         
	         
	         $this->bd->JqueryInsertSQL('inv_producto_vta',$InsertQuery);
	         
	         
	     }
	     
	    
	}
	//-------------
	function AprobarComprobante($accion,$id,$tipo,$tipofactura){
	    
	    $hoy = date("Y-m-d");
	    
	    $fechaa		 = $this->bd->fecha($hoy);
	    
	 	$estado = 'aprobado';
	    
	 	if ( $tipofactura == '0'){
	 	    $comprobante_DATO = $this->K_comprobante($tipo);
	 	    
	 	}else{
	 	    
	 	    $input = str_pad($id, 8, "0", STR_PAD_LEFT);
	 	    
	 	    $comprobante_DATO = 'I'.$input ;
	 	}
	 	
	 	
	        
	        $sql = " UPDATE inv_movimiento
						   SET 	estado=".$this->bd->sqlvalue_inyeccion($estado, true).",
                                cierre=".$this->bd->sqlvalue_inyeccion('S', true).",
                                sesion=".$this->bd->sqlvalue_inyeccion($this->sesion, true).",
								comprobante=".$this->bd->sqlvalue_inyeccion($comprobante_DATO, true).",
								fechaa=".$fechaa."
						 WHERE id_movimiento=".$this->bd->sqlvalue_inyeccion($id, true);
	        
	         $this->bd->ejecutar($sql);
	        
	         // ACTUALIZA MONTOS PARCIALES
	         
	         $sql = "delete from inv_movimiento
 						 WHERE id_movimiento is null and 
                               sesion=".$this->bd->sqlvalue_inyeccion(trim($this->sesion), true);
	         
	         
	         $this->bd->ejecutar($sql);
	         
	         
	         
	         $sql1 = "UPDATE inv_movimiento_det
						   SET 	  tarifa_cero  =  tarifa_cero * cantidad
 						 WHERE tipo = 'T' and id_movimiento=".$this->bd->sqlvalue_inyeccion($id, true);
	         
	         $this->bd->ejecutar($sql1);
	        
	         
	         $sql2 = "UPDATE inv_fac_pago
						   SET 	  fecha = ".$fechaa.",
                                  sesion = ".$this->bd->sqlvalue_inyeccion($this->sesion, true)."
 						 WHERE id_movimiento=".$this->bd->sqlvalue_inyeccion($id, true);
	         
	         $this->bd->ejecutar($sql2);
	         
	         
	    
	         
	        
	        $this->DetalleMov($id);
	        
	        $this->K_kardex($id,$tipo);
	    
	        $this->DetalleTotal($id);
	        
	        
	        
	        $this->_Verifica_suma_facturas_Total();
	        $this->_Verifica_suma_facturas();
	        $this->_Verifica_facturas();
	        
	        
	        echo '<script type="text/javascript">acciona("'.$comprobante_DATO.'","'.$estado.'" );</script>';
	        
 	        
	        $result = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>COMPROBANTE EMITIDO CON EXITO [ '.$comprobante_DATO.' - '.$id.' ]</b>';
	        
	        echo $result;
	        
	}
  //------------------------------
	function K_comprobante($tipo ){
	 
 
	        
	    $sql = "SELECT   coalesce(factura,0) as secuencia
        	    FROM web_registro
        	    where ruc_registro = ".$this->bd->sqlvalue_inyeccion($this->ruc   ,true);
	    
	        
	    $parametros 			= $this->bd->ejecutar($sql);
	    
	    $secuencia 				= $this->bd->obtener_array($parametros);
	     
	    $contador = $secuencia['secuencia'] + 1;
	    
	    $input = str_pad($contador, 9, "0", STR_PAD_LEFT);
	    
	    
	    $sqlEdit = "UPDATE web_registro
    			   SET 	factura=".$this->bd->sqlvalue_inyeccion($contador, true)."
     			 WHERE ruc_registro=".$this->bd->sqlvalue_inyeccion($this->ruc , true);
	    
	    
	    $this->bd->ejecutar($sqlEdit);
	    
	    return $input ;
	}
	//------------------------------
	function K_kardex($id,$tipo){
  
	        //    $this->ActualizaPrecio($idproducto,$costo );
 
 	    
	}
	//--------------------
	function DetalleMov($id){
	    
	    $sql = " UPDATE inv_movimiento_det
    			   SET 	id_movimiento=".$this->bd->sqlvalue_inyeccion($id, true)."
     			 WHERE id_movimiento is null and sesion=".$this->bd->sqlvalue_inyeccion($this->sesion , true);
	    
	    
	    $this->bd->ejecutar($sql);
	    
	    
	}
	//--------------------
	function DetallePago($id,$tot){
	    
	 
	    $this->ATablaPago[0][valor] =  $id;
	   
	    $tipopago =  trim(@$_POST["tipopago"]);
	    
	    $formapago =  trim(@$_POST["formapago"]);
	    
	   
	    $fecha =  $_POST["fecha"];
	        
	    $this->ATablaPago[6][valor] =  $fecha;
	    
	    if( $tipopago == 'efectivo'){
	        
	        $this->ATablaPago[4][valor] =   -2;
	        $this->ATablaPago[5][valor] =   '0000000000';
	   
	    }else{
	    
	        $this->ATablaPago[5][valor] =   @$_POST["cuentaBanco"];
	    
	    }
	
	    if ($formapago== 'credito'){
	        $this->ATablaPago[4][valor] =   -2;
	    }
	    
	    $this->ATablaPago[3][valor] =  $tot;
	    
	    
	    ///------------------------
	    $xx = $this->bd->query_array('inv_fac_pago','count(*) as nn, max(idfacpago) as idfacpago', 
	                                 'id_movimiento='.$this->bd->sqlvalue_inyeccion($id,true). ' and  
                                      formapago='.$this->bd->sqlvalue_inyeccion(trim($formapago),true). ' and  
	                                  tipopago='.$this->bd->sqlvalue_inyeccion(trim($tipopago),true)
	        );
	    
	    
	    if ( $tot > 0 ){
	        
	        if ( $tipopago == 'efectivo' ) {
	            
	            if ($xx['nn'] > 0  ) {
	             
	                $this->bd->_UpdateSQL('inv_fac_pago',$this->ATablaPago,$xx['idfacpago']);
	            }else  {
	                $this->bd->_InsertSQL('inv_fac_pago',$this->ATablaPago, '-' );
	            }
  	          
	        }
	        //---------------------------------------------------------------
	        if ( $tipopago == 'cheque' ) {
	            
	            if ($xx['nn'] > 0  ) {
	                
	                $this->bd->_UpdateSQL('inv_fac_pago',$this->ATablaPago,$xx['idfacpago']);
	            }else  {
	                $this->bd->_InsertSQL('inv_fac_pago',$this->ATablaPago, '-' );
	            }
	            
	        }
	        //---------------------------------------------------------------
	        if ( $tipopago == 'tarjeta' ) {
	            
	            if ($xx['nn'] > 0  ) {
	                
	                $this->bd->_UpdateSQL('inv_fac_pago',$this->ATablaPago,$xx['idfacpago']);
	            }else  {
	                $this->bd->_InsertSQL('inv_fac_pago',$this->ATablaPago, '-' );
	            }
	            
	        }
	    }
	     
	 
 
	    
	    
	}
	//----/----
	//--------------------
	function DetalleTotal($id){
	    
	    $ATotal = $this->bd->query_array('view_ventas_idresumen',
	                                      'baseiva, monto_iva, tarifa_cero, total', 
	        'id_movimiento='.$this->bd->sqlvalue_inyeccion($id,true)
	        );
	    
 
	    
	    $sql = " UPDATE inv_movimiento 
    			   SET 	base12=".$this->bd->sqlvalue_inyeccion( $ATotal['baseiva'], true).",
                        iva=".$this->bd->sqlvalue_inyeccion($ATotal['monto_iva'], true).",
                    	base0=".$this->bd->sqlvalue_inyeccion($ATotal['tarifa_cero'], true).",
                    	total=".$this->bd->sqlvalue_inyeccion($ATotal['total'], true)." 
     			 WHERE id_movimiento =".$this->bd->sqlvalue_inyeccion($id , true);
	    
	    
	    $this->bd->ejecutar($sql);
 
	      
	      return  $ATotal['total'];
 
}
//--------------- DetalleMovSin
function DetalleMovSin( $id  ){
    
    $sqlEdit = "update inv_movimiento_det
				      set 
                         tipo=".$this->bd->sqlvalue_inyeccion('T', true).",
                         monto_iva = 0 , 
                         tarifa_cero = costo * cantidad , 
                         total = costo * cantidad , 
                         baseiva = 0 "."
 				 		 WHERE  id_movimiento =".$this->bd->sqlvalue_inyeccion($id, true);
    
    $this->bd->ejecutar($sqlEdit);
    
    
}
//-----------------------
function _Verifica_facturas(   ){
    /*
    $sqlEdit = "update inv_movimiento_det
				      set monto_iva = 0 , tarifa_cero = total / cantidad , baseiva = 0 "."
 				 		 WHERE  tarifa_cero is null and
                                cantidad > 0 and
                                monto_iva is null and
                                tipo=".$this->bd->sqlvalue_inyeccion('T', true);
    
    $this->bd->ejecutar($sqlEdit);
    
    
    
    $sql = "update inv_movimiento_det
                        set tipo = ".$this->bd->sqlvalue_inyeccion('T', true)."
                        where   cantidad > 0 and monto_iva = 0" ;
    
    $this->bd->ejecutar($sql);
    
    
    $sql = "update inv_movimiento_det
                     set tarifa_cero = costo * cantidad,
                         total       = costo * cantidad
                   where  tipo = ".$this->bd->sqlvalue_inyeccion('T', true)." and (monto_iva + tarifa_cero + baseiva) <> total" ;
    
    $this->bd->ejecutar($sql);
    */
    
}
//---------------
function _Verifica_suma_facturas(   ){
    
    
    $sql_det1 = 'SELECT id_movimiento,    iva, base0, base12, total
                        FROM inv_movimiento
                        where base0 is null';
    
    
    
    $stmt1 = $this->bd->ejecutar($sql_det1);
    
    
    while ($x=$this->bd->obtener_fila($stmt1)){
        
        $id = $x['id_movimiento'];
        
        $ATotal = $this->bd->query_array(
            'inv_movimiento_det',
            'sum( total) as t1, sum(monto_iva) as t2, sum(tarifa_cero) as t3, sum(baseiva) as t4',
            ' id_movimiento ='.$this->bd->sqlvalue_inyeccion($id,true)
            );
        
        $sqlEdit = "update inv_movimiento
				     set  iva = ".$this->bd->sqlvalue_inyeccion($ATotal['t2'],true).",
                          base0 = ".$this->bd->sqlvalue_inyeccion($ATotal['t3'],true).",
                          base12 = ".$this->bd->sqlvalue_inyeccion($ATotal['t4'],true).",
                          total = ".$this->bd->sqlvalue_inyeccion($ATotal['t1'],true)."
 				 		 WHERE  id_movimiento=".$this->bd->sqlvalue_inyeccion( $id, true);
        
        $this->bd->ejecutar($sqlEdit);
        
        
    }
    
}
//---------------
function _Verifica_suma_facturas_Total(   ){
    
    
    $sql_det1 = 'select   id_movimiento
                        FROM inv_movimiento
                        where ( iva + base0 + base12) <> total ';
    
    
    
    $stmt1 = $this->bd->ejecutar($sql_det1);
    
    
    while ($x=$this->bd->obtener_fila($stmt1)){
        
        $id = $x['id_movimiento'];
        
        $ATotal = $this->bd->query_array(
            'inv_movimiento_det',
            'sum( total) as t1, sum(monto_iva) as t2, sum(tarifa_cero) as t3, sum(baseiva) as t4',
            ' id_movimiento ='.$this->bd->sqlvalue_inyeccion($id,true)
            );
        
        $sqlEdit = "update inv_movimiento
				     set  iva = ".$this->bd->sqlvalue_inyeccion($ATotal['t2'],true).",
                          base0 = ".$this->bd->sqlvalue_inyeccion($ATotal['t3'],true).",
                          base12 = ".$this->bd->sqlvalue_inyeccion($ATotal['t4'],true).",
                          total = ".$this->bd->sqlvalue_inyeccion($ATotal['t1'],true)."
 				 		 WHERE  id_movimiento=".$this->bd->sqlvalue_inyeccion( $id, true);
        
        $this->bd->ejecutar($sqlEdit);
        
        
    }
    
}
///-------------------------------------------
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;

//------ poner informacion en los campos del sistema
if (isset($_GET['accion']))	{
	
	$accion    = $_GET['accion'];
	
	$id        = $_GET['id'];
	
	$tipo      = 'F';
	
	
	
	if ($accion == 'aprobacion'){
	    
	    $tipofactura  = $_GET['tipofactura'];
	    
	    $gestion->AprobarComprobante($accion,$id,$tipo,$tipofactura);
	
	}else{
	
	    if ($accion == 'del'){
	        
	        $gestion->eliminar($id);
	        
	    }else {
	        
	        $gestion->consultaId($accion,$id);
	        
	    }
	 
	
	}
	  
	
	
	
}

    //------ grud de datos insercion
    if (isset($_POST["action"]))	{
    	
    	$action = @$_POST["action"];
    	
    	$id =     @$_POST["id_movimiento"];
    	
    	$gestion->xcrud(trim($action),$id);
    	
    }



?>
 
  
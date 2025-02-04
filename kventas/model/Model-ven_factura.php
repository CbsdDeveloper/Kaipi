<?php
session_start( );

require '../../kconfig/Db.class.php';    

require '../../kconfig/Obj.conf.php';  


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
		    array( campo => 'carga',   tipo => 'VARCHAR2',   id => '21',  add => 'S',   edit => 'N',   valor => '0',   filtro => 'N',   key => 'N')
 		);
		
		
		$this->ATablaPago = array(
		    array( campo => 'id_movimiento',   tipo => 'VARCHAR2',   id => '0',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'formapago',   tipo => 'VARCHAR2',   id => '1',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'tipopago',   tipo => 'VARCHAR2',   id => '2',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'monto',   tipo => 'NUMBER',   id => '3',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'idbanco',   tipo => 'NUMBER',   id => '4',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'cuenta',   tipo => 'VARCHAR2',   id => '5',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'fecha',   tipo => 'DATE',   id => '6',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
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
			
			echo '<script type="text/javascript">accion('.$id.',"'.$accion.'" );</script>';
			
			if ($accion == 'editar')
			    $resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>EDITAR REGISTRO TRANSACCION ?</b>';
			    
				if ($accion == 'del')
				    $resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ELIMINAR REGISTRO TRANSACCION ?</b>';
				    
		}
		
		if ($tipo == 1){
			
			echo '<script type="text/javascript">accion('.$id.',"'.$accion.'" );</script>';
			
			$resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO ['.$id.']</b>';
			
		}
		
		
 		
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
		    array( campo => 'fechaa',   valor => '-',  filtro => 'N',   visor => 'S'),
  		    array( campo => 'comprobante',   valor => '-',  filtro => 'N',   visor => 'S'),
		    array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
 		    array( campo => 'idprov',   valor => '-',  filtro => 'N',   visor => 'S'),
		    array( campo => 'detalle',   valor => '-',  filtro => 'N',   visor => 'S'),
		    array( campo => 'carga',   valor => '-',  filtro => 'N',   visor => 'S'),
  		    array( campo => 'razon',   valor => '-',  filtro => 'N',   visor => 'S')
 		);
		
	    $this->bd->JqueryArrayVisor('view_ventas_fac',$qquery );
		
		$result =  $this->div_resultado($accion,$id,0);
		
		echo  $result;
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
		
		$fecha                  =  $_POST["fecha"];
		$idperiodo              = $this->periodo($fecha);
		$this->ATabla[9][valor] =  $idperiodo;
		$idprov                 =  trim($_POST["idprov"]);
 		
		$efectivo                = trim($_POST["efectivo"]);
		$formapago               = trim($_POST["formapago"]);
		$this->ATabla[11][valor] = trim($idprov);
		
		$result                   = $this->estado_periodo ;
		$result                   = 'Registre la informacion del cliente... complete su informacion!!! ';
		
		if (empty($efectivo)){
		    $efectivo= 0;
		}
  		
		
		if ( $formapago   <> '-'){
		
        		if ( $this->estado_periodo == 'abierto' ){
        		    
        		    if (!empty($idprov)){
        		        
        		        $nruc = $this->_valida_prov($idprov);
        		        
        		        if ($nruc >= 1){
        		            
         			
                    			$id = $this->bd->_InsertSQL($this->tabla,$this->ATabla, '-' );
                    			
                    			$result = $this->div_resultado('editar',$id,1);
                      			
                    			$tot = $this->DetalleTotal($id);
                    			
                    			$this->DetallePago($id,$tot);
        		       //     }else {
        		     //          $result = 'Aplique forma y pago de la factura... Seleccione forma de pago';
        		       //     }
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
		
	    $estado                  =  $_POST["estado"];
	    $idprov                  =  trim($_POST["idprov"]);
	    $carga                   =  $_POST["carga"];
	    $this->ATabla[11][valor] =  trim($idprov);
	    $efectivo                =  trim($_POST["efectivo"]);
	    $formapago               =  trim($_POST["formapago"]);
	    
		    
	    if (empty($efectivo)){
	    
	        $efectivo            = 0;
	    
	    }
 	     
	    $tot = $this->DetalleTotal($id);
	    
	    if ( $formapago   <> '-'){
  	    
        	    if ($carga == '9') {
        	        $this->DetalleMovSin($id);
        	    }
        	        
        	    if ($estado == 'digitado') {
        	        
        	        $nruc = $this->_valida_prov($idprov);
        	        
        	        if ($nruc >= 1){
        	            
        	            if ( $efectivo > 0 ){
        	                
                      		$this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
                    			
                      		$result =$this->div_resultado('editar',$id,1).' '.$idprov;
                      		
                      		$this->_Verifica_facturas(  $id  );
                      		
                    		$this->DetallePago($id,$tot);
                    		
        	            }else {
        	                $result = 'Registre el monto pagado... Seleccione forma de pago';
        	            }
        	        }
        	    }	
        	    else	 {
        	               $this->DetallePago($id,$tot);
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
	    
	    $hoy         = date("Y-m-d");
	    $fechaa		 = $this->bd->fecha($hoy);
	   $estado       = 'aprobado';
	    
	 	if ( $tipofactura == '0'){
	 	    
	 	    $comprobante_DATO = $this->K_comprobante($tipo);
	 	    
	 	}else{
	 	    
	 	    $input            = str_pad($id, 8, "0", STR_PAD_LEFT);
	 	    $comprobante_DATO = 'I'.$input ;
	 	}
	        
	        $sql = " UPDATE inv_movimiento
						   SET 	estado=".$this->bd->sqlvalue_inyeccion($estado, true).",
                                cierre=".$this->bd->sqlvalue_inyeccion('S', true).",
								comprobante=".$this->bd->sqlvalue_inyeccion($comprobante_DATO, true).",
								fechaa=".$fechaa."
						 WHERE id_movimiento=".$this->bd->sqlvalue_inyeccion($id, true);
	        
	         $this->bd->ejecutar($sql);
	        
  
	         $this->_Verifica_facturas(  $id  );
  
	    
	        $this->DetalleTotal($id);
	 
	        echo '<script type="text/javascript">acciona("'.$comprobante_DATO.'","'.$estado.'" );</script>';
	        
 	        
	        $result = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>COMPROBANTE EMITIDO CON EXITO [ '.$comprobante_DATO.' - '.$id.' ]</b>';
	        
	        echo $result;
	        
	}
//--------------------------
	function _Verifica_facturas( $id  ){
	    
	    
	    
	    $sql = "update inv_movimiento_det
                        set tarifa_cero = ".$this->bd->sqlvalue_inyeccion('0.00', true)."
                        where   tarifa_cero is null and
                                id_movimiento =".$this->bd->sqlvalue_inyeccion($id,true) ;
	    
	    
	    
	    
	    $this->bd->ejecutar($sql);
	    
	    
	    $sql = "update inv_movimiento_det
                        set monto_iva = ".$this->bd->sqlvalue_inyeccion('0.00', true)."
                        where   tipo =".$this->bd->sqlvalue_inyeccion('T',true) ." and
                                id_movimiento =".$this->bd->sqlvalue_inyeccion($id,true) ;
	    
	    
	    
	    
	    $this->bd->ejecutar($sql);
	    
	    
	    
	    
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
 
	//--------------------
	function DetallePago($id,$tot){
	    
	    $fecha                      =  $_POST["fecha"];
	    $this->ATablaPago[0][valor] =  $id;
	    $this->ATablaPago[6][valor] =  $fecha;
	    $tipopago                   =  trim(@$_POST["tipopago"]);
	    $formapago                  =  trim(@$_POST["formapago"]);
	    
	    if( $tipopago == 'efectivo'){
	        
	        $this->ATablaPago[4][valor] =   -2;
	        $this->ATablaPago[5][valor] =   '0000000000';
	   
	    }else{
	    
	        $this->ATablaPago[5][valor] =   @$_POST["cuentaBanco"];
	    
	    }
	
	    if ($formapago== 'credito'){
	        $this->ATablaPago[4][valor] =   -2;
	    }
	    
	    $this->ATablaPago[3][valor]     =  $tot;
	    
	    $idfacpago = $this->existe_pago($id) ;
	    
	    if ( $idfacpago == 0 ){
	        $this->bd->_InsertSQL('inv_fac_pago',$this->ATablaPago, '-' );
	    }else{
	        $this->bd->_UpdateSQL('inv_fac_pago',$this->ATablaPago,$idfacpago);
	    }
	    
	    
	    
	    
	}
	//----/----
	function existe_pago($id){
	    
	    $variable = $this->bd->query_array('inv_fac_pago',
	        'idfacpago',
	        'id_movimiento='.$this->bd->sqlvalue_inyeccion($id,true)
	        );
	    
	    
	    if ($variable['idfacpago'] > 0 ) {
	        return $variable['idfacpago'] ;
	    }else{
	        return 0;
	    }
	    
	}
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
 
//---------------
 
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
 
  
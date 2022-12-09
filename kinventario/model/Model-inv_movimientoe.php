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
	private $tabla ;
	private $secuencia;
	private $anio;

	private $estado_periodo;
	
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function proceso( ){
		//inicializamos la clase para conectarnos a la bd
		
		$this->obj     = 	new objects;
		$this->bd	   =	new Db ;
		
		$this->ruc       =     trim($_SESSION['ruc_registro']);
		
		$this->sesion 	 =     trim($_SESSION['email']);
		
		$this->hoy 	     =     date("Y-m-d");    	//$this->hoy 	     =  $this->bd->hoy();
		
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
		
		$this->ATabla = array(
				array( campo => 'id_movimiento',   tipo => 'VARCHAR2',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
				array( campo => 'fecha',   tipo => 'DATE',   id => '1',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'registro',   tipo => 'VARCHAR2',   id => '2',  add => 'S',   edit => 'N',   valor => $this->ruc,   filtro => 'N',   key => 'N'),
				array( campo => 'detalle',   tipo => 'VARCHAR2',   id => '3',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'sesion',   tipo => 'VARCHAR2',   id => '4',  add => 'S',   edit => 'S',   valor => $this->sesion ,   filtro => 'N',   key => 'N'),
				array( campo => 'creacion',   tipo => 'DATE',   id => '5',  add => 'S',   edit => 'N',   valor => $this->hoy,   filtro => 'N',   key => 'N'),
				array( campo => 'comprobante',   tipo => 'VARCHAR2',   id => '6',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'estado',   tipo => 'VARCHAR2',   id => '7',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '8',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'id_periodo',   tipo => 'NUMBER',   id => '9',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'documento',   tipo => 'VARCHAR2',   id => '10',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'idprov',   tipo => 'VARCHAR2',   id => '11',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'id_asiento_ref',   tipo => 'NUMBER',   id => '12',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'fechaa',   tipo => 'DATE',   id => '13',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
		        array( campo => 'transaccion',   tipo => 'VARCHAR2',   id => '14',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
		        array( campo => 'idbodega',   tipo => 'NUMBER',   id => '15',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
		        array( campo => 'id_departamento',   tipo => 'NUMBER',   id => '16',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
		        array( campo => 'autorizacion',   tipo => 'VARCHAR2',   id => '17',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N')
		);
		
		
		
		$this->tabla 	  	  = 'inv_movimiento';
		
		$this->secuencia 	     = '-';
		
	}
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function div_resultado($accion,$id,$tipo,$estado,$comprobante){
		//inicializamos la clase para conectarnos a la bd
		
	    if ($tipo == 1){
	        
	        $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO ['.$id.']</b>';
	        
	    }
	    
	    if ($tipo == 0){
	        if ($accion == 'editar')
	                $resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>EDITAR REGISTRO TRANSACCION ? ( '.$id.' )</b>';
	       if ($accion == 'del')
	                $resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ELIMINAR REGISTRO TRANSACCION ?( '.$id.' )</b>';
	    }
	    
	    if ($tipo == -1){
 	        $resultado = '<img src="../../kimages/nogusta.png" align="absmiddle"/>&nbsp;<b>VERIFIQUE LA INFORMACION DEL PROVEEDOR/RESPONSABLE</b>';
  	    }
	    
  	    if ($tipo == -2){
  	        $resultado = '<img src="../../kimages/nogusta.png" align="absmiddle"/>&nbsp;<b>DEBE APERTURAR EL PERIODO EN CONTABILIDAD</b>';
  	    }
  	  
  	    if ($tipo == 2){
  	        $resultado ='<img src="../../kimages/kfav.png" align="absmiddle"/>&nbsp;<b>COMPROBANTE EMITIDO CON EXITO ['.$id.']</b>';  	   
  	    }
  	    
 
 
	    $datos = array(
	        'resultado' => $resultado,
	        'id' => $id,
	        'accion' => $accion,
	        'estado' => $estado,
	        'comprobante' => $comprobante
	    );
	    
	    
	    return $datos;   
		
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
 		    array( campo => 'detalle',   valor => '-',  filtro => 'N',   visor => 'S'),
 		    array( campo => 'comprobante',   valor => '-',  filtro => 'N',   visor => 'S'),
		    array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
		    array( campo => 'tipo',   valor => '-',  filtro => 'N',   visor => 'S'),
 		    array( campo => 'documento',   valor => '-',  filtro => 'N',   visor => 'S'),
		    array( campo => 'idbodega',   valor => '-',  filtro => 'N',   visor => 'S'),
		    array( campo => 'idprov',   valor => '-',  filtro => 'N',   visor => 'S'),
  		    array( campo => 'razon',   valor => '-',  filtro => 'N',   visor => 'S'),
		    array( campo => 'id_departamento',   valor => '-',  filtro => 'N',   visor => 'S'),
		    array( campo => 'transaccion',   valor => '-',  filtro => 'N',   visor => 'S'),
		    array( campo => 'autorizacion',   valor => '-',  filtro => 'N',   visor => 'S')
  		);
		
		
		$datos =   $this->bd->JqueryArrayVisorDato('view_inv_movimiento',$qquery );
		
		header('Content-Type: application/json');
		
		echo json_encode($datos, JSON_FORCE_OBJECT);
		
		 
	 
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
		
		$idprov = $_POST["idprov"];
		
		$idperiodo = $this->periodo($fecha);
		
		$this->ATabla[9][valor] =  $idperiodo;
		
	//	$result = $this->estado_periodo ;
 		
		$longitud = strlen($idprov);
 
 
		if ( $this->estado_periodo == 'abierto' ){
			
		    if ($longitud < 5 ) {
		        
 		        $datos = $this->div_resultado('add',0, -1,'digitado','0') ;
 		        
		    }
		    else  {
	       
		         $id = $this->bd->_InsertSQL($this->tabla,$this->ATabla, '-' );
			
		         $this->DetalleMov($id);
		         
		         $datos = $this->div_resultado('editar',$id, 1,'digitado','0') ;
 			
			   
		    }
		}else{
			
 		    
		    $datos = $this->div_resultado('add',0, -2,'digitado','0') ;
	
		}
 
	 
		echo json_encode($datos, JSON_FORCE_OBJECT);
	 
		
	}
	//--------------------------------------------------------------------------------
	//--- edicion de registros
	//--------------------------------------------------------------------------------
	function edicion($id  ){
		
		
	    $estado =  trim($_POST["estado"]);
	    
	    if (trim($estado) == 'digitado') {
	        
	        $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
	        
	        $datos = $this->div_resultado('editar',$id, 1,'digitado','0') ;
	        
	        
	        $this->DetalleMov($id);
	 
    	}else{
    	    
    	    $this->ATabla[9][edit] =  'N';
    	    $this->ATabla[11][edit] =  'N';
    	    $this->ATabla[13][edit] =  'S';
     	    $this->ATabla[17][edit] =  'N';
    	    
    	    $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
    	    
    	    $datos =$this->div_resultado('editar',$id,1);
    	    
    	}
    	
    	$this->_Verifica_suma_facturas($id);
          		
	    echo json_encode($datos, JSON_FORCE_OBJECT);
	    
	}
	
	//--------------------------------------------------------------------------------
	//--- eliminar de registros
	//--------------------------------------------------------------------------------
	function eliminar($id ){
		
	    
	    $estado =  $_POST["estado"];
	    
	    if (trim($estado) == 'digitado') {
	        
	        $sql = 'delete from inv_movimiento  where id_movimiento='.$this->bd->sqlvalue_inyeccion($id, true);
	        $this->bd->ejecutar($sql);
	        
	        
	        $sql = 'delete from inv_movimiento_det  where id_movimiento='.$this->bd->sqlvalue_inyeccion($id, true);
	        $this->bd->ejecutar($sql);
	        
	        $result = $this->div_limpiar();
	        
	    }else {
	        
	        $sql = 'update inv_movimiento  
                       set estado = '.$this->bd->sqlvalue_inyeccion('anulado', true).'
                    where id_movimiento='.$this->bd->sqlvalue_inyeccion($id, true);
	        
	        
	        $this->bd->ejecutar($sql);
	        
	        $result = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>REGISTRO ANULADO </b>';
	        
	        
	    }
	    
		$this->K_verifica_saldos_01($id);
	  
	    
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
	//-------------
	function AprobarComprobante($accion,$id,$tipo){
	    
	    $this->verifica_costos($id);
	    
	    $x = $this->bd->query_array('inv_movimiento',
	        'comprobante, fecha,fechaa',
	        'id_movimiento='.$this->bd->sqlvalue_inyeccion($id,true)
	        );
	    
	    
	    $total_valida = $this->_Verifica_suma_facturas($id);
	    
	    $hoy = date("Y-m-d");
	    
	    $trozos = explode("-", $x['fecha'],3);
	    $anio = $trozos[0];
	    
	  
	    
	    $fechaa		 = $this->bd->fecha($hoy);
	    
	    $estado = 'aprobado';
	    
	    
	    if ( $total_valida > 0 ){
	    
	        $comprobante_valida = trim($x['comprobante']);
	        $long               = strlen($comprobante_valida);
	        
	        if ( $long > 3 ){
	            $comprobante = trim($comprobante_valida);
	            $fecha       = $x['fecha'];
	            $fechaa		 = $this->bd->fecha($fecha);
	        }else{
	            $comprobante = $this->K_comprobante($tipo,$anio);
	        }
	        
	        $sql = " UPDATE inv_movimiento
						   SET 	estado=".$this->bd->sqlvalue_inyeccion($estado, true).",
								comprobante=".$this->bd->sqlvalue_inyeccion($comprobante, true).",
								fechaa=".$fechaa."
						 WHERE id_movimiento=".$this->bd->sqlvalue_inyeccion($id, true);
	        
	        $this->bd->ejecutar($sql);
	        
	        
	        $sql = "delete from inv_movimiento
 						 WHERE id_movimiento is null and 
                               sesion=".$this->bd->sqlvalue_inyeccion(trim($this->sesion) , true);
	        
	        
	        $this->bd->ejecutar($sql);
 	        
	     
	        
	        $this->DetalleMov($id);
	        
	        $this->K_kardex($id,$tipo,$anio);

			$this->K_verifica_saldos_01($id);
	        
	        $datos = $this->div_resultado('aprobado',$id, 2,'aprobado',$comprobante) ;
	                                     
	        
	        echo json_encode($datos, JSON_FORCE_OBJECT);
	          
	    }
	        
	}
	//--------------------------------------------
	function _Verifica_suma_facturas( $id   ){
	    
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
	        
	        return $ATotal['t1'];
	    
	}
//----------------------------
	function verifica_costos($id ){
	   
	    
	    $sql = "update inv_movimiento_det
                    set ingreso = ".$this->bd->sqlvalue_inyeccion('0', true).",
                        monto_iva = ".$this->bd->sqlvalue_inyeccion('0', true).",
                        baseiva = ".$this->bd->sqlvalue_inyeccion('0', true)."
                        where id_movimiento=".$this->bd->sqlvalue_inyeccion($id, true);
	    
	    $this->bd->ejecutar($sql);
	    
	    
	    $sql_det = 'SELECT costo, total ,id,codigo ,cantidad
                	FROM public.view_movimiento_det
                	where costo = 0';
	    
	    
	    
	    $stmt1 = $this->bd->ejecutar($sql_det);
	    
	    
	    while ($x=$this->bd->obtener_fila($stmt1)){
	        
	        $cantidad                 = $x['cantidad'];
	        $costo                    = $x['total'] / $cantidad;
	        $id_movimientod           = $x['id'];
	        
	        
	        $sql = "update inv_movimiento_det
                    set costo = ".$this->bd->sqlvalue_inyeccion($costo, true)."
                        where id_movimientod=".$this->bd->sqlvalue_inyeccion($id_movimientod, true);
	        
	        $this->bd->ejecutar($sql);
	        
	    }
	    
	    
	}
  //------------------------------
	function K_comprobante($tipo ,$anio){
	 
	    
 
	    
	    $sql = "SELECT count(comprobante) as secuencia
			      FROM view_inv_movimiento
			      where  anio = ".$this->bd->sqlvalue_inyeccion($anio ,true)." and 
                         estado = 'aprobado' and 
                         tipo =".$this->bd->sqlvalue_inyeccion('E' ,true);

	    
	    $parametros 			= $this->bd->ejecutar($sql);
	    
	    $secuencia 				= $this->bd->obtener_array($parametros);
	    
	     
	    $contador = $secuencia['secuencia'] + 1;
	    
	    $input = str_pad($contador, 8, "0", STR_PAD_LEFT);
	    
	    return $input ;
	}
	//------------------------------
	function RevertirComprobante($accion,$id,$tipo){
	    
	    
	    $estado = 'digitado';
	    
	    $sql = " UPDATE inv_movimiento
						   SET 	estado=".$this->bd->sqlvalue_inyeccion($estado, true)."
						 WHERE id_movimiento=".$this->bd->sqlvalue_inyeccion($id, true);
	    
	    $this->bd->ejecutar($sql);
	    
	    
	    $sql = "delete from inv_movimiento
 						 WHERE id_movimiento is null and sesion=".$this->bd->sqlvalue_inyeccion(trim($this->sesion) , true);
	    
	    
	    $this->bd->ejecutar($sql);
	    
	    
	    $sql = "delete from inv_movimiento_det
 						 WHERE id_movimiento is null and sesion=".$this->bd->sqlvalue_inyeccion(trim($this->sesion) , true);
	    
	    
	    $this->bd->ejecutar($sql);
	    
	    
	    
	    $this->K_kardex_revertir($id,$tipo);
	    

		$this->K_verifica_saldos_01($id);
	    
	    $result = '<img src="../../kimages/kfav.png" align="absmiddle"/>&nbsp;<b>REVISE LA INFORMACION ['.$id.']</b>';
	    
	    echo $result;
	    
	}
	//----
	function K_kardex_revertir($id,$tipo){
	    
	    $sql_det = 'SELECT  a.cantidad,a.costo, a.idproducto,id_movimientod,total
				     FROM  inv_movimiento_det a
				     WHERE a.id_movimiento ='.$this->bd->sqlvalue_inyeccion($id, true);
	    
	    $stmt1 = $this->bd->ejecutar($sql_det);
	    
	    while ($x=$this->bd->obtener_fila($stmt1)){
	        
	        $idproducto        = $x['idproducto'];
	        $cantidad          = $x['cantidad'];
	        
 	            
	            $sql = 'UPDATE web_producto
						  SET  	egreso = egreso - '.$this->bd->sqlvalue_inyeccion($cantidad, true).',
  								saldo  = saldo + '.$this->bd->sqlvalue_inyeccion($cantidad, true).'
						  WHERE idproducto='.$this->bd->sqlvalue_inyeccion($idproducto, true);
	            
	            $this->bd->ejecutar($sql);
 	        
	    }
	}   
	//--
	function K_kardex($id,$tipo,$anio){
 
	    $sql_det = 'SELECT   cantidad, costo, idproducto,id_movimientod, total
				  from inv_movimiento_det  
				 where  id_movimiento ='.$this->bd->sqlvalue_inyeccion($id, true);
	    
 	    
	    $stmt1 = $this->bd->ejecutar($sql_det);
	    
	    
	    while ($x=$this->bd->obtener_fila($stmt1)){
	        
	        $idproducto        = $x['idproducto'];
	        $cantidad          = $x['cantidad'];
	        $total             = $x['cantidad'] * $x['costo'];
 
	        $xa = $this->bd->query_array('web_producto',
	            'COALESCE(costo,0) as costo,
                 COALESCE(saldo,0) as saldo',
	            'idproducto='.$this->bd->sqlvalue_inyeccion($idproducto,true)
	            );
	        
	    
	        
	        // 2. opcion costo con iva
	        $costo_actual = $xa['costo'] *  $xa['saldo']   ;
 	        
	        $costo_total  = $costo_actual - $total  ;
	        
	        $saldo_fecha = $xa['saldo'] - $cantidad ;
	        
	        $costo_uni =  $costo_total / $saldo_fecha ;
	        
	      
	            $sql = 'UPDATE web_producto
						  SET  	egreso = egreso + '.$this->bd->sqlvalue_inyeccion($cantidad, true).',
                                costo    ='.$this->bd->sqlvalue_inyeccion($costo_uni, true).',
  								saldo  = saldo - '.$this->bd->sqlvalue_inyeccion($cantidad, true).'
						  WHERE idproducto='.$this->bd->sqlvalue_inyeccion($idproducto, true);
	            
	            $this->bd->ejecutar($sql);
 	          
 
	        
	        
	    }
	}    
	//
	function CopiarMovimiento($id){
    	

		$x = $this->bd->query_array('inv_movimiento',   // TABLA
		'cab_codigo',                        // CAMPOS
		'id_movimiento='.$this->bd->sqlvalue_inyeccion($id,true) // CONDICION
		);

		if ( $x['cab_codigo'] > 0 ) {
			echo '<b>INFORMACION YA GENERADA.... VERIFIQUE LA INFORMACION</b>';
		}	
		else {
				$sql_insert = "INSERT INTO inv_movimiento (fecha, registro, detalle, sesion, creacion, comprobante, estado, tipo, 
				id_periodo, documento, idprov, id_asiento_ref, fechaa, cierre, iva, base0, base12, total, transaccion, novedad,
				carga, envio, autorizacion, cab_codigo, comision, idbodega, id_departamento, id_tramite, idproceso, 
				modulo, interes) 
				SELECT   fecha, registro, detalle, sesion, creacion, '-' ascomprobante, 'digitado' as estado,'E' as tipo, id_periodo, 
				documento, idprov, id_asiento_ref, fechaa, cierre, iva, base0, base12, total,'Egreso Bodega' as transaccion, novedad, carga,
				envio, autorizacion, cab_codigo, comision, idbodega, id_departamento, id_tramite, idproceso, modulo, interes 
				FROM  inv_movimiento
				where id_movimiento = ".$this->bd->sqlvalue_inyeccion($id, true);
		
				$this->bd->ejecutar($sql_insert);

				$idmov=  $this->bd->ultima_secuenciaP('id_inv_movimiento');


				$sql_detalle = "INSERT INTO inv_movimiento_det (idproducto, cantidad, id_movimiento, costo, total, monto_iva, tarifa_cero, 
				estado, tipo, ingreso, egreso, baseiva, sesion, descuento, pdescuento, interes)    
				SELECT idproducto, cantidad, ".	$idmov." as id_movimiento, (total/cantidad) costo, total, 0 as monto_iva, (total/cantidad) as tarifa_cero, 
					estado, tipo, 0 as ingreso, 
					ingreso as egreso, 0 as baseiva, sesion, descuento, pdescuento, interes 
				FROM inv_movimiento_det
				where id_movimiento = ".$this->bd->sqlvalue_inyeccion($id, true);

				$this->bd->ejecutar($sql_detalle);

				$sql = " UPDATE inv_movimiento
						SET 	cab_codigo=".$this->bd->sqlvalue_inyeccion($idmov, true)."
						WHERE  id_movimiento=".$this->bd->sqlvalue_inyeccion($id , true);
				
				
				$this->bd->ejecutar($sql);

				echo '<b>INFORMACION YA GENERADA.... VERIFIQUE LA INFORMACION EN MOVIMIENTO DE EGRESO DE BODEGA PARA APROBAR...NRO. '.$idmov .'</b>';
			}
    	
    }
    //--------------------
    	function DetalleMov($id){
    	
    	$sql = " UPDATE inv_movimiento_det
    			   SET 	id_movimiento=".$this->bd->sqlvalue_inyeccion($id, true)."
     			 WHERE id_movimiento is null and 
                       sesion=".$this->bd->sqlvalue_inyeccion(trim($this->sesion) , true);
    	
    	
    	 $this->bd->ejecutar($sql);
    	
    	
    }

	///----------------
	function K_verifica_saldos_01 ($id){
 
		$sql_det = 'SELECT  a.cantidad,a.costo, a.idproducto,id_movimientod
				  from inv_movimiento_det a
				 where a.id_movimiento ='.$this->bd->sqlvalue_inyeccion($id, true);
		  
		$stmt1 = $this->bd->ejecutar($sql_det);
		 
		while ($x=$this->bd->obtener_fila($stmt1)){
		
					$idproducto        = $x['idproducto'];
					$this->K_verifica_saldos_02 ($idproducto);
			 }
	 
		}    	
		//----------------
	function K_verifica_saldos_02 ($id){
			
		$anio       =  $_SESSION['anio'];
 	    
	    
	    $sql_det = 'SELECT  idproducto, 
                          sum(cantidad) as cantidad, 
                          avg(costo) as costo, 
                          sum(total) as total, 
                          sum(ingreso) as ingreso, 
                          sum(egreso) as egreso
                      FROM view_saldos_bodega_anio 
                     where idproducto='.$this->bd->sqlvalue_inyeccion($idproducto, true). ' and
                           anio = '.$this->bd->sqlvalue_inyeccion($anio, true). 
	                     ' group by    idproducto';
	    
 	 
			$stmt2 = $this->bd->ejecutar($sql_det);
 
			while ($xy=$this->bd->obtener_fila($stmt2)){
					 
					$idproducto           = $xy['idproducto'];
				 	 $ingreso             = $xy['ingreso'];
				 	 $egreso              = $xy['egreso'];
					 $saldo 			  = $ingreso - $egreso;
	 
					$sql_eq = 'UPDATE web_producto
						SET saldo     =   '.$this->bd->sqlvalue_inyeccion($saldo, true).',
							ingreso   =   '.$this->bd->sqlvalue_inyeccion($ingreso, true).',
							egreso    =   '.$this->bd->sqlvalue_inyeccion($egreso, true).'
						WHERE idproducto='.$this->bd->sqlvalue_inyeccion($idproducto, true) ;
	
					$this->bd->ejecutar($sql_eq);
  	 
			}
 			pg_free_result($stmt2);
	 
		}  
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
	
	$tipo      = $_GET['tipo'];
	
	if ($accion == 'aprobacion'){
	    
	    $gestion->AprobarComprobante($accion,$id,$tipo);
	    
	}elseif($accion == 'revertir'){
	    
	    $gestion->RevertirComprobante($accion,$id,$tipo);
	    
	}
	elseif($accion == 'copiar'){
	    
	    $gestion->CopiarMovimiento($id);
	    
	}
	else{
	    
	    $gestion->consultaId($accion,$id);
	    
	}
 
	
}

//------ grud de datos insercion
if (isset($_POST["action"]))	{
	
	$action = @$_POST["action"];
	
	$id =     @$_POST["id_movimiento"];
	
	$gestion->xcrud(trim($action),$id);
	
}



?>
 
  
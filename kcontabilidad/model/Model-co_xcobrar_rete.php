<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


require 'Model-asientos_saldos.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
	
	//creamos la variable donde se instanciar la clase "mysql"
	
	private $obj;
	private $bd;
	private $saldos;
	private $ATabla;
	
	private $ruc;
	private $sesion;
	private $hoy;
	private $POST;
	private $ruc_sri;
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function proceso( ){
	 
		
		$this->obj     = 	new objects;
		$this->bd	   =	new Db ;
		
		$this->ruc       =  $_SESSION['ruc_registro'];
		$this->sesion 	 =  $_SESSION['email'];
		$this->hoy 	     =  $this->bd->hoy();
		
		$this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
		
		$this->saldos     = 	new saldo_contable(  $this->obj,  $this->bd);
		
		
		
		$this->ATabla = array(
		    array( campo => 'id_ventas',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
		    array( campo => 'id_asiento',tipo => 'NUMBER',id => '1',add => 'S', edit => 'N', valor => '-', key => 'N'),
		    array( campo => 'tpidcliente',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'idcliente',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'tipocomprobante',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'N', valor => '-', key => 'N'),
		    array( campo => 'numerocomprobantes',tipo => 'NUMBER',id => '5',add => 'S', edit => 'N', valor => '1', key => 'N'),
		    array( campo => 'basenograiva',tipo => 'NUMBER',id => '6',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'baseimponible',tipo => 'NUMBER',id => '7',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'baseimpgrav',tipo => 'NUMBER',id => '8',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'montoiva',tipo => 'NUMBER',id => '9',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'valorretiva',tipo => 'NUMBER',id => '10',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'valorretrenta',tipo => 'NUMBER',id => '11',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'secuencial',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'codestab',tipo => 'VARCHAR2',id => '13',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'fechaemision',tipo => 'DATE',id => '14',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'registro',tipo => 'VARCHAR2',id => '15',add => 'S', edit => 'N', valor => $this->ruc , key => 'N'),
		    array( campo => 'valorretbienes',tipo => 'NUMBER',id => '16',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'valorretservicios',tipo => 'NUMBER',id => '17',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'anexo',tipo => 'NUMBER',id => '18',add => 'S', edit => 'S', valor => '1', key => 'N'),
		    array( campo => 'tipoemision',tipo => 'VARCHAR2',id => '19',add => 'S', edit => 'S', valor => 'F', key => 'N'),
		    array( campo => 'formapago',tipo => 'VARCHAR2',id => '20',add => 'S', edit => 'S', valor => '01', key => 'N'),
		    array( campo => 'montoice',tipo => 'NUMBER',id => '21',add => 'S', edit => 'S', valor => '-', key => 'N')
		);
		
		
		$sri= $this->bd->query_array('par_ciu',
		    'idprov',
		    'razon like '.$this->bd->sqlvalue_inyeccion('%SERVI%RENTA%',true)
		    );
		
		$this->ruc_sri = $sri['idprov'];
		
		
		
		
	}
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function div_resultado($accion,$id,$tipo,$estado){
		//inicializamos la clase para conectarnos a la bd
	
	   echo '<script type="text/javascript">accion('.$id.',"'.$accion.'","'.trim($estado).'"  );</script>';
 
	   
	   
	   
		if ($tipo == 0){
			
			if ($accion == 'editar'){
			    $resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>EDITAR REGISTRO TRANSACCION ?</b>';
			}
				
		    if ($accion == 'del'){
		        $resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ELIMINAR REGISTRO TRANSACCION ?</b>';
		    }
				
		    echo '<script type="text/javascript">DetalleAsiento();</script>';
		}
		
		if ($tipo == 1){
			
		    $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO ['.$id.']</b>';
		    
 			echo '<script type="text/javascript">DetalleAsiento();</script>';
			
		}
		
		if ($tipo == 2){
			
		    $resultado = '<img src="../../kimages/kfav.png" align="absmiddle" />&nbsp;<b>ACTUALIZANDO INFORMACION</b>';
		    
 			
		}
  	
	
		
		return $resultado;
		
	}
	
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function div_limpiar( ){
		//inicializamos la clase para conectarnos a la bd
		
		$resultado = 'REGISTRO ELIMINADO ';
		
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
				array( campo => 'id_asiento',    valor =>$id,  filtro => 'S',   visor => 'S'),
				array( campo => 'id_periodo',    valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'fecha',         valor => '-',  filtro => 'N',   visor => 'S'),
    		    array( campo => 'razon',         valor => '-',  filtro => 'N',   visor => 'S'),
    		    array( campo => 'idprov',         valor => '-',  filtro => 'N',   visor => 'S'),
    		    array( campo => 'txtcuenta',         valor => '-',  filtro => 'N',   visor => 'S'),
    		    array( campo => 'cuenta',         valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'comprobante',   valor => '-',  filtro => 'N',   visor => 'S'),
 				array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
 				array( campo => 'detalle',  valor => '-',  filtro => 'N',   visor => 'S')
		);
		
		$datos = $this->bd->JqueryArrayVisor('view_asientocxc',$qquery );
		
		
		$sql = 'UPDATE co_asiento_aux
            		 SET   detalle='.$this->bd->sqlvalue_inyeccion(trim($datos['detalle']), true).',
             		       comprobante='.$this->bd->sqlvalue_inyeccion(trim($datos['comprobante']), true).'
            		WHERE id_asiento='.$this->bd->sqlvalue_inyeccion($id, true). ' and
                         detalle is null';
		
		
		$this->bd->ejecutar($sql);
		
		$estado = $datos['estado'];
 		
		$qqueryCompras = array(
		    array( campo => 'id_ventas',valor =>  '-',filtro => 'N', visor => 'S'),
		    array( campo => 'id_asiento',valor => $id,filtro => 'S', visor => 'N'),
 		    array( campo => 'tipocomprobante',valor => '-',filtro => 'N', visor => 'S'),
 		    array( campo => 'basenograiva',valor => '-',filtro => 'N', visor => 'S'),
		    array( campo => 'baseimponible',valor => '-',filtro => 'N', visor => 'S'),
		    array( campo => 'baseimpgrav',valor => '-',filtro => 'N', visor => 'S'),
		    array( campo => 'montoiva',valor => '-',filtro => 'N', visor => 'S'),
		    array( campo => 'valorretiva',valor => '-',filtro => 'N', visor => 'S'),
		    array( campo => 'valorretrenta',valor => '-',filtro => 'N', visor => 'S'),
		    array( campo => 'secuencial',valor => '-',filtro => 'N', visor => 'S'),
		    array( campo => 'codestab',valor => '-',filtro => 'N', visor => 'S'),
		    array( campo => 'fechaemision',valor => '-',filtro => 'N', visor => 'S'),
		    array( campo => 'valorretbienes',valor => '-',filtro => 'N', visor => 'S'),
		    array( campo => 'valorretservicios',valor => '-',filtro => 'N', visor => 'S')
 		);
		
		$datos1 = $this->bd->JqueryArrayVisor('view_anexos_ventas',$qqueryCompras );
		
 
		$result =  $this->div_resultado($accion,$id,0,$estado);
		
		echo  $result;
	}
	//--------------------------------------------------------------------------------------
	//aprobaci�n de asientos
	function aprobacion($id  ){
		
	    $comprobante =  $this->saldos->_aprobacion($id);
	    
	    if ($comprobante <> '-')	{
	        
	        $this->AnexosTransacional($id);
	        
	        $result = $this->div_resultado('aprobado',$id,2,$comprobante);
	        
	    }else{
	        
	        $result = 'No se pudo actualizar y aprobar el asiento contable';
	    }
	    
	    
	    echo $result;
	 
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
			
			$this->edicion($id);
			
		}
		// ------------------  eliminar
		if ($action == 'del'){
			
			$this->eliminar($id );
			
		}
		
		// ------------------  eliminar
		if ($action == 'aprobacion'){
			
			$this->aprobacion($id );
			
		}
		
	}
	///--------------
	function _actualiza_aux($id,$idprov,$comprobante,$detalle){
	    
	 
	    $sql = "UPDATE co_asiento_aux
            							    SET 	detalle      =".$this->bd->sqlvalue_inyeccion(trim($detalle), true).",
                                                    comprobante  =".$this->bd->sqlvalue_inyeccion($comprobante, true)."
             							      WHERE id_asiento   =".$this->bd->sqlvalue_inyeccion($id, true). ' and 
                                                    idprov       ='.$this->bd->sqlvalue_inyeccion(trim($idprov), true);
	    
	    $this->bd->ejecutar($sql);
	    
	    
	}
	
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	function total_gasto( ){
	    
	    $baseimpgrav     = @$_POST["baseimpgrav"];
	    $baseimponible   = @$_POST["baseimponible"];
	    $basenograiva    = @$_POST["basenograiva"];
	    $montoiva        = @$_POST["montoiva"];
	    $montoice        = @$_POST["montoice"];
	    $descuento       = 0;  
	    
	    
	    
	    $valorretbienes      = @$_POST["valorretbienes"];
	    $valorretservicios   = @$_POST["valorretservicios"];
	    $valorretrenta       = @$_POST["valorretrenta"];
	    
	    
	    $total1 = ($baseimpgrav + $baseimponible + $basenograiva + $montoiva  ) -  $descuento;
	    
	    $total2 =  $valorretbienes + $valorretservicios +  $valorretrenta;
	    
	    return $total1 - $total2;
	    
	}
  	// bora asiento previo-------------------
	function borra_asiento( $idasiento  ){
	 
	    
	    $sql = 'SELECT count(*) as refe
                    FROM co_asiento_aux a
                   WHERE a.id_asiento='.$this->bd->sqlvalue_inyeccion($idasiento,true);
	    
	    $resultado      = $this->bd->ejecutar($sql);
	    
	    $datos_asiento  = $this->bd->obtener_array( $resultado);
	    
	    if ($datos_asiento['refe'] == 0 ){
        	    $sql = "delete 
                          from co_asientod 
                         where id_asiento=".$this->bd->sqlvalue_inyeccion($idasiento, true);
        	    
        	    $this->bd->ejecutar($sql);
        	  
        	    $sql = "delete
                          from co_asiento_aux
                         where id_asiento=".$this->bd->sqlvalue_inyeccion($idasiento, true);
        	    
        	    $this->bd->ejecutar($sql);
         
        	    $valida = 0;
        	    
	    }else {
	        $valida = 1;
	    }
	    
	    return $valida;
	    
	}

	//----------------------------------------------------
	function agregar( ){
	 
 		$id_periodo   = @$_POST["id_periodo"];
 		
 		$fecha		  = $this->bd->fecha(@$_POST["fecha"]);
 		$cuenta       = @$_POST["cuenta"];
 		$estado       = 'digitado';
 		$secuencial   = @$_POST["secuencial"];
 		
		//------------ seleccion de periodo
 		$periodo_s = $this->bd->query_array('co_periodo',
 		                                     'mes,anio',
											'registro ='.$this->bd->sqlvalue_inyeccion($this->ruc ,true).' and
                                          	id_periodo='.$this->bd->sqlvalue_inyeccion($id_periodo ,true)
 		    );
 		$idprov	        = @$_POST["idprov"];
 		$mes  			= $periodo_s["mes"];
		$anio  			= $periodo_s["anio"];
 		
		$comprobante    = '-';
		$detalle = @$_POST["detalle"];
 		
		$total_apagar    = $this->total_gasto();

		$longitud = strlen($cuenta);
		$longitudProve = strlen($idprov);
		
		//------------------------------------------------------------
		
		if ($longitud > 5 ) {
		    
		    if ($longitudProve > 5 ) {
		
                		$sql = "INSERT INTO co_asiento(	fecha, registro, anio, mes, detalle, sesion, creacion,modulo,
                                						comprobante, estado, tipo, documento,idprov,cuentag,estado_pago,apagar, 
                                                        id_periodo)
                										        VALUES (".$fecha.",".
                										        $this->bd->sqlvalue_inyeccion($this->ruc, true).",".
                										        $this->bd->sqlvalue_inyeccion($anio, true).",".
                										        $this->bd->sqlvalue_inyeccion($mes, true).",".
                										        $this->bd->sqlvalue_inyeccion($detalle, true).",".
                										        $this->bd->sqlvalue_inyeccion($this->sesion, true).",".
                										        $this->hoy.",".
                										        $this->bd->sqlvalue_inyeccion('cxcobrar', true).",".
                										        $this->bd->sqlvalue_inyeccion($comprobante, true).",".
                										        $this->bd->sqlvalue_inyeccion($estado, true).",".
                										        $this->bd->sqlvalue_inyeccion('F', true).",".
                										        $this->bd->sqlvalue_inyeccion(trim($secuencial), true).",".
                										        $this->bd->sqlvalue_inyeccion(trim(@$_POST["idprov"]), true).",".
                										        $this->bd->sqlvalue_inyeccion(trim(@$_POST["cuenta"]), true).",".
                										        $this->bd->sqlvalue_inyeccion( 'N', true).",".
                										        $this->bd->sqlvalue_inyeccion( $total_apagar, true).",".
                 										        $this->bd->sqlvalue_inyeccion($id_periodo, true).")";
                        
                     
                		$this->bd->ejecutar($sql);
                		
                        $idAsiento =  $this->bd->ultima_secuencia('co_asiento');
                        
                        $this->agregarDetalle( $idAsiento,trim($cuenta));
                        
                        $this->K_iva($idAsiento,$mes,$anio,$id_periodo);
                        
                        $this->K_Riva($idAsiento,$mes,$anio,$id_periodo);
                        
                        $this->K_Rfuente($idAsiento,$mes,$anio,$id_periodo);
                        
                        $this->K_cliente($idAsiento,$mes,$anio,$id_periodo,$idprov);
                        
                        $this->ATabla[1][valor] =  $idAsiento;
                        $this->ATabla[2][valor] =  $this->bd->_tipo_identificacion('V',$idprov);
                        $this->ATabla[3][valor] =  $idprov;
                        
                        $this->bd->_InsertSQL('co_ventas',$this->ATabla,'id_co_ventas');
                        
                        
                        $this->_actualiza_aux($idAsiento,$idprov,$secuencial,$detalle);
                        
                        
                        
                        $result = $this->div_resultado('editar',$idAsiento,1,$estado) ;
 
		    }else {
		        
		        
		        $resultado = '<img src="../../kimages/nogusta.png" align="absmiddle"/>&nbsp;<b>INGRESE PROVEEDOR</b>';
		        
		    }
		}else {
		    
		    
		    $resultado = '<img src="../../kimages/nogusta.png" align="absmiddle"/>&nbsp;<b>INGRESE LA CUENTA DEL GASTO PARA GUARDAR LA TRANSACCION</b>';
		    
		}
		 echo $result;
		
	}
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	function agregarDetalle( $id,$cuenta){
	    
	    
		
	    $periodo_s = $this->bd->query_array('co_asiento',
	        'mes,anio,id_periodo',
	        'id_asiento='.$this->bd->sqlvalue_inyeccion($id,true)
	        );
	    
	    $id_periodo     =$periodo_s["id_periodo"];
	    $mes  			= $periodo_s["mes"];
	    $anio  			= $periodo_s["anio"];
	    
	    $baseimpgrav     = @$_POST["baseimpgrav"];
	    $baseimponible   = @$_POST["baseimponible"];
	    $basenograiva    = @$_POST["basenograiva"];
	    $total1 = ($baseimpgrav + $baseimponible + $basenograiva )  ;
	    
	   
	    if ( $this->bd->_ccuenta($cuenta,$this->ruc) == 1 ){
 
            
            	    $Aexiste = $this->bd->query_array('co_asientod',
            	                                         'count(cuenta) as numero', 
            	                                         'id_asiento='.$this->bd->sqlvalue_inyeccion($id,true).' and  
            	                                         cuenta='.$this->bd->sqlvalue_inyeccion($cuenta,true).' and  
                                                         principal='.$this->bd->sqlvalue_inyeccion('S',true)  
            	                                       );
            	    
            	    
            	    if ($Aexiste['numero'] == 0){
            	        
            	        $sql = "INSERT INTO co_asientod(
            								id_asiento, cuenta, aux,debe, haber, id_periodo, anio, mes,
            								sesion, creacion, principal,registro)
            								VALUES (".
            								$this->bd->sqlvalue_inyeccion($id , true).",".
            								$this->bd->sqlvalue_inyeccion( ltrim(rtrim($cuenta)), true).",".
            								$this->bd->sqlvalue_inyeccion( 'N', true).",".
            								$this->bd->sqlvalue_inyeccion(0, true).",".
            								$this->bd->sqlvalue_inyeccion($total1, true).",".
            								$this->bd->sqlvalue_inyeccion( $id_periodo, true).",".
            								$this->bd->sqlvalue_inyeccion( $anio, true).",".
            								$this->bd->sqlvalue_inyeccion( $mes, true).",".
            								$this->bd->sqlvalue_inyeccion($this->sesion , true).",".
            								$this->hoy.",".
            								$this->bd->sqlvalue_inyeccion( 'S', true).",".
            								$this->bd->sqlvalue_inyeccion( $this->ruc, true).")";
            	        
            	        
            	    }else{
            	     
            	        $sql = 'UPDATE co_asientod
            								    SET   cuenta='.$this->bd->sqlvalue_inyeccion($cuenta, true).',
             					 					  debe='.$this->bd->sqlvalue_inyeccion($total_gasto, true).'
            								 WHERE id_asiento='.$this->bd->sqlvalue_inyeccion($id, true). ' and 
                                                   principal = '.$this->bd->sqlvalue_inyeccion('S', true);
            	        
            	    }
                   
            	    $this->bd->ejecutar($sql);
	    
	    }
	    
 	
	}
	//--------------------------------------------------------------------------------
	//--- edicion de registros
	//--------------------------------------------------------------------------------
	function edicion($id){
		
 	 	$id_periodo   = @$_POST["id_periodo"];
 	 	$cuenta       = @$_POST["cuenta"];
 	 	
	 	//------------ seleccion de periodo
	 	$periodo_s = $this->bd->query_array('co_periodo',
	 	    'mes,anio',
	 	    'registro ='.$this->bd->sqlvalue_inyeccion($this->ruc ,true).' and
                                          	id_periodo='.$this->bd->sqlvalue_inyeccion($id_periodo ,true)
	 	    );
 
	 	$total_apagar   = $this->total_gasto();
	 	$idventas       = @$_POST["id_ventas"];
	 	$idprov	        = @$_POST["idprov"];
	 	$detalle        = @$_POST["detalle"];
		
	 	$longitud      = strlen($cuenta);
	 	$longitudProve = strlen($idprov);
	 	
 
            			
 
            			 			
            					$this->agregarDetalle( $id,trim($cuenta));
            				  
            					$this->K_iva($id,$mes,$anio,$id_periodo);
            					
            					$this->K_Riva($id,$mes,$anio,$id_periodo);
            					
            					$this->K_Rfuente($id,$mes,$anio,$id_periodo);
            					
            					$this->K_cliente($id,$mes,$anio,$id_periodo,$idprov);
            					
            					$this->_actualiza_aux($id,$idprov,$secuencial,$detalle);
            					
            					$result = $this->div_resultado('editar',$id,1,$estado);
            		          
     	 
	 	$this->_actualiza_aux($id,$idprov,$secuencial,$detalle);
	 	
	 	echo $result;
	}
	
	//--------------------------------------------------------------------------------
	//--- eliminar de registros
	//--------------------------------------------------------------------------------
	function eliminar($id ){
		
	    $estado      = @$_POST["estado"];
	    
	    $comprobante =  $this->saldos->_elimina_asiento($id,$estado);
	    
	    
	    $result = $this->div_limpiar();
 
		
		echo $result;
 		
	}
	//--------------------
	function K_iva($id,$mes,$anio,$periodo_s){
	    
	    $ACuenta = $this->bd->query_array( 'co_catalogo',
	                                       'cuenta', 
	                                       'secuencia='.$this->bd->sqlvalue_inyeccion(123,true)
	                                      );
	    
	    $iva_total = $_POST["montoiva"];
	    
	    $acuentag = $ACuenta['cuenta'];
	    
	    $Aexiste = $this->bd->query_array('co_asientod',
	        'count(cuenta) as numero',
	        'id_asiento='.$this->bd->sqlvalue_inyeccion($id,true).' and
	             cuenta='.$this->bd->sqlvalue_inyeccion($acuentag,true) 
	        );
	    
	 
	    if ( $this->bd->_ccuenta($acuentag,$this->ruc) == 1 ){
	    
        	    if ($Aexiste['numero'] == 0){
         	  
                	    $sql = "INSERT INTO co_asientod(
                						id_asiento, mes,anio,id_periodo,cuenta, aux,debe, haber,
                						sesion, creacion, registro)
                						VALUES (".
                						$this->bd->sqlvalue_inyeccion($id, true).",".
                						$this->bd->sqlvalue_inyeccion($mes, true).",".
                						$this->bd->sqlvalue_inyeccion($anio, true).",".
                						$this->bd->sqlvalue_inyeccion($periodo_s, true).",".
                						$this->bd->sqlvalue_inyeccion( $acuentag, true).",".
                						$this->bd->sqlvalue_inyeccion( 'S', true).",".
                						$this->bd->sqlvalue_inyeccion( 0, true).",".
                						$this->bd->sqlvalue_inyeccion($iva_total, true).",".
                						$this->bd->sqlvalue_inyeccion($this->sesion , true).",".
                						$this->hoy.",".
                						$this->bd->sqlvalue_inyeccion( $this->ruc , true).")";
                						
                						$this->bd->ejecutar($sql);
                						
                						$id_asientod =  $this->bd->ultima_secuencia('co_asientod');
                						
         	     
                						$this->K_aux($id_asientod,$id,$this->ruc_sri,$acuentag,0,$iva_total,$periodo_s,$anio,$mes,'');
        	     }
        	     
	    }
	    
 
	}
	//----------------------------------------------------------
	function K_cliente($idAsiento,$mes,$anio,$id_periodo,$idprov){
	    
	    
	    $apagar = $this->total_gasto( );
	    
	    $ACuenta = $this->bd->query_array('co_plan_ctas',
                    	        'cuenta',
                    	        'univel='.$this->bd->sqlvalue_inyeccion('S',true).' and
                                 tipo_cuenta ='.$this->bd->sqlvalue_inyeccion('C',true).' and
                                 registro='.$this->bd->sqlvalue_inyeccion($this->ruc,true)
 	           );
 
	        
	    $acuentag = $ACuenta['cuenta'];
	    
	    
	    $Aexiste = $this->bd->query_array('co_asientod',
	        'count(cuenta) as numero',
	        'id_asiento='.$this->bd->sqlvalue_inyeccion($idAsiento,true).' and
	             cuenta='.$this->bd->sqlvalue_inyeccion($acuentag,true)
	        );
	    
	    
	    if ( $this->bd->_ccuenta($acuentag,$this->ruc) == 1 ){
	        
	
        	    if ($Aexiste['numero'] == 0){
        	
        	    $sql = "INSERT INTO co_asientod(
        						id_asiento, mes,anio,id_periodo,cuenta, aux,debe, haber,
        						sesion, creacion, registro)
        						VALUES (".
        						$this->bd->sqlvalue_inyeccion($idAsiento, true).",".
        						$this->bd->sqlvalue_inyeccion($mes, true).",".
        						$this->bd->sqlvalue_inyeccion($anio, true).",".
        						$this->bd->sqlvalue_inyeccion($id_periodo, true).",".
        						$this->bd->sqlvalue_inyeccion( $acuentag, true).",".
        						$this->bd->sqlvalue_inyeccion( 'S', true).",".
        						$this->bd->sqlvalue_inyeccion( $apagar, true).",".
        						$this->bd->sqlvalue_inyeccion( 0, true).",".
        						$this->bd->sqlvalue_inyeccion($this->sesion , true).",".
        						$this->hoy.",".
        						$this->bd->sqlvalue_inyeccion( $this->ruc , true).")";
        				
        						if (!empty($acuentag)){		
        					       $this->bd->ejecutar($sql);
        					       
        					       $id_asientod =  $this->bd->ultima_secuencia('co_asientod');
        					       
        					       $this->K_aux($id_asientod,$idAsiento,$idprov,$acuentag,$apagar,0,$id_periodo,$anio,$mes,'C');
        					       
        						}
         						
        	    }
	    }
        	  
	}	
	//---------------
	function K_Riva($idAsiento,$mes,$anio,$id_periodo){
	   

	    $valorretbienes      = @$_POST["valorretbienes"];
	    $valorretservicios   = @$_POST["valorretservicios"];
	 
	    $total2 =  $valorretbienes + $valorretservicios;
	    
	    
	   
	    $ACuenta = $this->bd->query_array( 'co_catalogo',
	        'cuenta',
	        'secuencia='.$this->bd->sqlvalue_inyeccion(129,true)
	        );
	    
	    $acuentag = $ACuenta['cuenta'];
	    
	    $Aexiste = $this->bd->query_array('co_asientod',
	        'count(cuenta) as numero',
	        'id_asiento='.$this->bd->sqlvalue_inyeccion($idAsiento,true).' and
	             cuenta='.$this->bd->sqlvalue_inyeccion($acuentag,true)
	        );
	    
	    
	    if ( $this->bd->_ccuenta($acuentag,$this->ruc) == 1 ){
  
            	    if ($Aexiste['numero'] == 0){
             	  
            	    
            	    $sql = "INSERT INTO co_asientod(
            						id_asiento, mes,anio,id_periodo,cuenta, aux,debe, haber,
            						sesion, creacion, registro)
            						VALUES (".
            						$this->bd->sqlvalue_inyeccion($idAsiento, true).",".
            						$this->bd->sqlvalue_inyeccion($mes, true).",".
            						$this->bd->sqlvalue_inyeccion($anio, true).",".
            						$this->bd->sqlvalue_inyeccion($id_periodo, true).",".
            						$this->bd->sqlvalue_inyeccion( $acuentag, true).",".
            						$this->bd->sqlvalue_inyeccion( 'S', true).",".
            						$this->bd->sqlvalue_inyeccion( $total2, true).",".
            						$this->bd->sqlvalue_inyeccion( 0, true).",".
            						$this->bd->sqlvalue_inyeccion($this->sesion , true).",".
            						$this->hoy.",".
            						$this->bd->sqlvalue_inyeccion( $this->ruc , true).")";
            			
            						if ($total2 > 0 ){
            						    $this->bd->ejecutar($sql);
            						}
            						
            	    }
	    }
	}	  
	//---------------
	function K_Rfuente($idAsiento,$mes,$anio,$id_periodo){
	    
	    $valorretrenta       = @$_POST["valorretrenta"];
	    
 	    
	    $total2 =  $valorretrenta;
	    
	    
	    
	    $ACuenta = $this->bd->query_array( 'co_catalogo',
	        'cuenta',
	        'secuencia='.$this->bd->sqlvalue_inyeccion(128,true)
	        );
	    
	    $acuentag = $ACuenta['cuenta'];
	    
	    $Aexiste = $this->bd->query_array('co_asientod',
	        'count(cuenta) as numero',
	        'id_asiento='.$this->bd->sqlvalue_inyeccion($idAsiento,true).' and
	             cuenta='.$this->bd->sqlvalue_inyeccion($acuentag,true)
	        );
	    
	  
	        
	       if ( $this->bd->_ccuenta($acuentag,$this->ruc) == 1 ){
	            
	         
            	    if ($Aexiste['numero'] == 0){
            	        
             	        
                        	        $sql = "INSERT INTO co_asientod(
                        						id_asiento, mes,anio,id_periodo,cuenta, aux,debe, haber,
                        						sesion, creacion, registro)
                        						VALUES (".
                        						$this->bd->sqlvalue_inyeccion($idAsiento, true).",".
                        						$this->bd->sqlvalue_inyeccion($mes, true).",".
                        						$this->bd->sqlvalue_inyeccion($anio, true).",".
                        						$this->bd->sqlvalue_inyeccion($id_periodo, true).",".
                        						$this->bd->sqlvalue_inyeccion( $acuentag, true).",".
                        						$this->bd->sqlvalue_inyeccion( 'S', true).",".
                        						$this->bd->sqlvalue_inyeccion( $total2, true).",".
                        						$this->bd->sqlvalue_inyeccion( 0, true).",".
                        						$this->bd->sqlvalue_inyeccion($this->sesion , true).",".
                        						$this->hoy.",".
                        						$this->bd->sqlvalue_inyeccion( $this->ruc , true).")";
                        						
                        						if ($total2 > 0 ){
                        						    $this->bd->ejecutar($sql);
                        						}
            						
            	    }
	    }
	    
	}	
	//--------------------------------------------------------------------------
	function Comprobante($tipo,$anio){
		
	    $secuencia = $this->bd->query_array('co_asiento',
	        'count(*) as doc',
	        'tipo='.$this->bd->sqlvalue_inyeccion($tipo,true).' and
                                             anio='.$this->bd->sqlvalue_inyeccion($anio,true).' and
                                             registro='.$this->bd->sqlvalue_inyeccion($this->ruc,true).' and
                                             estado='.$this->bd->sqlvalue_inyeccion( 'aprobado',true)
	        );
	    
	    
	    $contador 				= $secuencia['doc'] + 1;
	    
	    
	    $input = str_pad($contador, 10, "0", STR_PAD_LEFT);
	    
	    return $input ;
	}
 
//------------------
 function AnexosTransacional($id_asiento){
	 
     $sql = "SELECT count(*) as contador
    			  FROM co_ventas
    			  WHERE registro =".$this->bd->sqlvalue_inyeccion($this->ruc ,true).' and
    			  	    id_asiento='.$this->bd->sqlvalue_inyeccion($id_asiento ,true);
					    
	 // saca valor a un arreglo				    
	 $valida_asiento 	= $this->bd->ejecutar($sql);
	 $existe_anexos 	= $this->bd->obtener_array($valida_asiento);
					    
	 $id_ventas         = @$_POST["id_ventas"];
	 $valorretbienes    = @$_POST["valorretbienes"];
	 $valorretservicios = @$_POST["valorretservicios"];
	 
	 
	 $valorrenta =  (float) $_POST["valorretrenta"];
	 
	 
	 $tpidprov  = '04';
 	 $idprov	   = @$_POST["idprov"];
 	 $len          = strlen($idprov);
 	 
 	 if($len == 10)
 	     $tpidprov = '05';
 	 elseif($len == 13)
 	     $tpidprov = '04';
 	 
  	 if ($idcliente == '9999999999999')     {
 	         $tpidprov = '07';
 	 }
 	    
 	
 	     
 	     
 	 $this->ATabla[1][valor] =  $id_asiento;
 	 $this->ATabla[2][valor] =  $tpidprov;
 	 $this->ATabla[3][valor] =  $idprov;
 	 $this->ATabla[10][valor] = $valorretbienes + $valorretservicios;
 	 $this->ATabla[11][valor] =  $valorrenta;
 	  
 	 
 	  if ($existe_anexos["contador"] > 0){
					        
	          $this->bd->_UpdateSQL('co_ventas',$this->ATabla,$id_ventas);
  					        
		} else {
		 
		    $id_compras = $this->bd->_InsertSQL('co_ventas',$this->ATabla,'-');
            
		 }
		 
					    
		 return $id_compras;
	 }
 //--------------------------------------------------------------------------
	 function K_aux($id_asientod,$id_asiento,$idprov,$cuenta,$debe,$haber,$id_periodo,$anio,$mes,$tipo){
	     
	     
	     if (!empty($idprov)) {
	         
	         $sql = "INSERT INTO co_asiento_aux (id_asientod, id_asiento, idprov, cuenta, debe, haber,parcial, id_periodo,
		              									  anio, mes, sesion, creacion, tipo, registro) VALUES (".
		              									  $this->bd->sqlvalue_inyeccion($id_asientod  , true).",".
		              									  $this->bd->sqlvalue_inyeccion($id_asiento, true).",".
		              									  $this->bd->sqlvalue_inyeccion(trim($idprov) , true).",".
		              									  $this->bd->sqlvalue_inyeccion($cuenta , true).",".
		              									  $this->bd->sqlvalue_inyeccion($debe , true).",".
		              									  $this->bd->sqlvalue_inyeccion($haber , true).",".
		              									  $this->bd->sqlvalue_inyeccion(0 , true).",".
		              									  $this->bd->sqlvalue_inyeccion($id_periodo, true).",".
		              									  $this->bd->sqlvalue_inyeccion($anio, true).",".
		              									  $this->bd->sqlvalue_inyeccion($mes , true).",".
		              									  $this->bd->sqlvalue_inyeccion($this->sesion 	, true).",".
		              									  $this->hoy.",".
		              									  $this->bd->sqlvalue_inyeccion($tipo , true).",".
		              									  $this->bd->sqlvalue_inyeccion( $this->ruc  , true).")";
		              									  
		              									  $this->bd->ejecutar($sql);
		              									  
	     }
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
	
	$accion    		    = $_GET['accion'];
	$id            		= $_GET['id_asiento'];
	  
		$gestion->edicion($accion,$id);
	 
	 
	
}

 



?>
 
  
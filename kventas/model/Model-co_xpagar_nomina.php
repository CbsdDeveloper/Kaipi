<?php
session_start( );
require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require 'Model-asientos_saldos.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
	
 
	
	private $obj;
	private $bd;
	private $saldos;
	
	private $ruc;
	private $sesion;
	private $hoy;
	private $POST;
	private $ruc_sri;
	private $anio;
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function proceso( ){
		//inicializamos la clase para conectarnos a la bd
		
		$this->obj     = 	new objects;
		$this->bd	   =	new Db ;
		
		$this->ruc       =  $_SESSION['ruc_registro'];
		$this->sesion 	 =  trim($_SESSION['email']);
		$this->hoy 	     =  $this->bd->hoy();
		
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
		
		$this->saldos     = 	new saldo_contable(  $this->obj,  $this->bd);
		
 
		$sri= $this->bd->query_array('par_ciu',
		    'idprov',
		    'razon like '.$this->bd->sqlvalue_inyeccion('%SERVI%RENTA%',true)
		    );
 
		$this->ruc_sri = $sri['idprov'];
		    
		
		$this->anio       =  $_SESSION['anio'];
	
		
	}
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function div_resultado($accion,$id,$tipo,$estado,$id_compras){
		//inicializamos la clase para conectarnos a la bd
	
	   echo '<script type="text/javascript">accion('.$id.',"'.$accion.'","'.trim($estado).'"  );</script>';
	   
 
		if ($tipo == 0){
			
			if ($accion == 'editar'){
			    $resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>EDITAR REGISTRO TRANSACCION ?</b>';
			}
				
		    if ($accion == 'del'){
		        $resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ELIMINAR REGISTRO TRANSACCION ?</b>';
		    }
				
		 //   echo '<script type="text/javascript">DetalleAsiento();</script>';
		}
		
		if ($tipo == 1){
			
		    $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO ['.$id.']</b>';
		    
 		//	echo '<script type="text/javascript">DetalleAsiento();DetalleAsientoIR();</script>';
			
		}
		
		if ($tipo == 2){
			
		    $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO ['.$id.']</b>';
		    
		}
  	
	
		
		return $resultado;
		
	}
	
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function div_limpiar( ){
		//inicializamos la clase para conectarnos a la bd
		
		$resultado = 'REGISTRO ELIMINADO / ANULADO';
		
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
    		    array( campo => 'cuenta',         valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'comprobante',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'documento',     valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'tipo',     valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'detalle',  valor => '-',  filtro => 'N',   visor => 'S'),
		        array( campo => 'id_tramite',  valor => '-',  filtro => 'N',   visor => 'S')
		);
		
		
		$datos = $this->bd->JqueryArrayVisor('view_asientocxp',$qquery );
		
  
		$result =  $this->div_resultado($accion,$id,0,$datos["estado"],$datos["id_asiento"]);
		
		echo  $result;
	}
	//--------------------------------------------------------------------------------------
	//aprobación de asientos
	function aprobacion($id,$id_tramite  ){
		
	    $sql = 'delete from co_asientod
			    				 WHERE cuenta='.$this->bd->sqlvalue_inyeccion('-', true);
	    
	    $this->bd->ejecutar($sql);
	    
	    $comprobante =  $this->saldos->_aprobacion($id);
	    
	    $this->saldos->_saldo_cxp($id);
	    
	    $this->saldos->_saldo_devengado($id_tramite,$id);
	    
	    
	    
	    if ($comprobante <> '-')	{
	        
	        $result = $this->div_resultado('aprobado',$id,2,$comprobante,0);
	        
	    }else{
	        
	        $result = 'No se pudo actualizar y aprobar el asiento contable';
	    }
	    
	    
	    echo $result;
	 
	}
	 
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	
	function xcrud($action,$id , $id_tramite){
		
		
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
			
		    $this->aprobacion($id ,$id_tramite);
			
		}
		
	}
	//--------------------------------------------------------------------------------
	// bora asiento previo-------------------
	function borra_asiento( $idasiento  ){
	 
	    
	    $sql = 'SELECT count(*) as refe
                    FROM co_asiento_aux a
                   WHERE a.id_asiento='.$this->bd->sqlvalue_inyeccion($idasiento,true);
	    
	    $resultado      = $this->bd->ejecutar($sql);
	    
	    $datos_asiento  = $this->bd->obtener_array( $resultado);
	    
	    if ($datos_asiento['refe']  <= 2 ){
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
	//-----------------------
	function _actualiza_aux($id,$idprov,$comprobante,$detalle){
	    
	    
	    $sql = "UPDATE co_asiento_aux
            							    SET 	detalle      =".$this->bd->sqlvalue_inyeccion(trim($detalle), true).",
                                                    comprobante  =".$this->bd->sqlvalue_inyeccion($comprobante, true)."
             							      WHERE id_asiento   =".$this->bd->sqlvalue_inyeccion($id, true). ' and
                                                    idprov       ='.$this->bd->sqlvalue_inyeccion(trim($idprov), true);
	    
	    $this->bd->ejecutar($sql);
	    
	    
	}
	//----------------------
	//----------------------------------------------------
	function agregar( $id_tramite ){
	 
 	
	    $x = $this->bd->query_array('presupuesto.pre_tramite',
	        'anio, mes, detalle, observacion, documento,sesion,fcompromiso,idprov,id_asiento_ref,comprobante,id_departamento,nro_memo',
	        'estado='.$this->bd->sqlvalue_inyeccion('5',true).' and
              anio ='.$this->bd->sqlvalue_inyeccion(  $this->anio   ,true).' and
             id_tramite='.$this->bd->sqlvalue_inyeccion($id_tramite,true)
	        );
	    
	  
	  
	    $periodo_s = $this->bd->query_array('co_periodo',
                                	        'mes,anio,id_periodo',
                                	        'registro ='.$this->bd->sqlvalue_inyeccion($this->ruc ,true).' and
                                          	 anio='.$this->bd->sqlvalue_inyeccion($x["anio"],true).' and
                                          	 mes='.$this->bd->sqlvalue_inyeccion($x["mes"],true)
	        );
	    
	    
	    $id_periodo  = $periodo_s["id_periodo"];
 		$fecha		 = $this->bd->fecha($x["fcompromiso"]);
 		
 		$estado      = 'digitado';
 		$documento   = trim( $x["documento"]);
 		$detalle     = trim( $x["detalle"]);
 		$idprov       = trim( $x["idprov"] );
 		//------------ seleccion de periodo
 		$mes  			= $periodo_s["mes"];
		$anio  			= $periodo_s["anio"];
		$comprobante    = '-';
		
		$tipoa  = 'N';
		//------------------------------------------------------------
 		
 
	
            		$sql = "INSERT INTO co_asiento(	fecha, registro, anio, mes, detalle,id_tramite, sesion, creacion,modulo,
                            						comprobante, estado, tipo, documento,idprov,cuentag,estado_pago,
                                                    id_periodo)
            										        VALUES (".$fecha.",".
            										        $this->bd->sqlvalue_inyeccion($this->ruc, true).",".
            										        $this->bd->sqlvalue_inyeccion($anio, true).",".
            										        $this->bd->sqlvalue_inyeccion($mes, true).",".
            										        $this->bd->sqlvalue_inyeccion($detalle, true).",".
            										        $this->bd->sqlvalue_inyeccion($id_tramite, true).",".
            										        $this->bd->sqlvalue_inyeccion($this->sesion, true).",".
            										        $this->hoy.",".
            										        $this->bd->sqlvalue_inyeccion('nomina', true).",".
            										        $this->bd->sqlvalue_inyeccion($comprobante, true).",".
            										        $this->bd->sqlvalue_inyeccion($estado, true).",".
            										        $this->bd->sqlvalue_inyeccion($tipoa, true).",".
            										        $this->bd->sqlvalue_inyeccion(trim($documento), true).",".
            										        $this->bd->sqlvalue_inyeccion($idprov, true).",".
            										        $this->bd->sqlvalue_inyeccion('-', true).",".
            										        $this->bd->sqlvalue_inyeccion( 'N', true).",".
            										        $this->bd->sqlvalue_inyeccion($id_periodo, true).")";
                    
                 
            		$this->bd->ejecutar($sql);
            		
                    $idAsiento =  $this->bd->ultima_secuencia('co_asiento');
                  
                    $this->consultaId('editar',$idAsiento);
                    
                    $this->div_resultado('editar',$idAsiento,1,$estado,$id_tramite);
 
		
	}
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	function agregarDetallegasto($id_tramite,$id_asiento,$programa){
    
	    $periodo_s = $this->bd->query_array('co_asiento',
	        'mes,anio,id_periodo',
	        'id_asiento='.$this->bd->sqlvalue_inyeccion($id_asiento,true)
	        );
	    
	    $id_periodo     = $periodo_s["id_periodo"];
	    $mes  			= $periodo_s["mes"];
	    $anio  			= $periodo_s["anio"];
 	    
	    //--- AGREGA PARTIDA DE INGRESOS ----- ///
	    
	/*    $sql1 ="SELECT  a.id_tramite, b.partida, a.cuentai, a.cuentae, a.nombre,   a.clasificador,
                	    a.programa, a.tipo_config, a.tipoformula, a.ingreso, a.descuentos,
                	    a.salarios, a.id_rol, a.id_config
	             FROM public.view_rol_tramite a
	             join presupuesto.view_dettramites b on
                	    a.programa=b.funcion and a.clasificador = b.clasificador and a.id_tramite= b.id_tramite and
                	    a.id_tramite= ".$this->bd->sqlvalue_inyeccion($id_tramite,true) ." and
                	    a.programa = ".$this->bd->sqlvalue_inyeccion(trim($programa),true) ." and
                	    a.tipo_config= 'I'"; 
	        */
  
	    $sql1 ="SELECT id_tramite, cuentai, cuentae, nombre, id_rol, clasificador, regimen, programa, 
             		tipo_config, tipoformula, ingreso, descuentos, salarios, id_config
            FROM public.view_rol_tramite
             where id_tramite=  ".$this->bd->sqlvalue_inyeccion($id_tramite,true) ." and 
                   programa= ".$this->bd->sqlvalue_inyeccion(trim($programa),true) ." and 
                   tipo_config='I'  " ;
 
	    
	    $stmt1 = $this->bd->ejecutar($sql1);
 	    
	    while ($fila=$this->bd->obtener_fila($stmt1)){
	       
 	        
	        $apartida = $this->bd->query_array('presupuesto.view_dettramites','partida', 
	                     "id_tramite= ".$this->bd->sqlvalue_inyeccion($id_tramite,true)." and 
                         clasificador =  ".$this->bd->sqlvalue_inyeccion(trim($fila['clasificador']),true)."  and 
                         funcion =". $this->bd->sqlvalue_inyeccion($programa,true)
 	            );
	        
	        $partida     = trim($apartida['partida']);
	        $tipoformula = trim($fila['tipoformula']);
	        $cuenta      = trim($fila['cuentai']);
	        
	        $cxp         = trim($fila['cuentae']);
 	        $compromiso  = $fila['ingreso'] ;
	        $clasificador= trim($fila['clasificador']);
	        
	        $id_config    =  ($fila['id_config']);
	        
	        
	        $len = strlen($cuenta);
	        
	        
	        if ( $tipoformula == 'RS'){
	            
	            $tipo_salario = 1;
	            
	         
	            $xdes = $this->bd->query_array('view_rol_tramite',
	                'sum(descuentos) as descuento',
	                'id_tramite='.$this->bd->sqlvalue_inyeccion($id_tramite,true).' and 
                     tipo_config = '.$this->bd->sqlvalue_inyeccion('E',true).' and 
                     programa = '.$this->bd->sqlvalue_inyeccion(trim($programa),true)
	                );
  
	            $haber_cxp =  $compromiso - $xdes['descuento'] ;  
	         
	          
	            
	        }else{
	            $tipo_salario = 0;
	            
	            $haber_cxp =  $compromiso;
	            
	            
	        }
	        
	        if ( $len > 3 ) {
	            
	            $sql = "INSERT INTO co_asientod(
    								id_asiento, codigo1, cuenta, aux, debe, haber, id_periodo, anio, mes,
    								sesion, creacion, principal,partida,item,monto1,monto2,programa,codigo3,codigo4,registro)
    								VALUES (".
    								$this->bd->sqlvalue_inyeccion($id_asiento , true).",".
    								$this->bd->sqlvalue_inyeccion($id_tramite , true).",".
    								$this->bd->sqlvalue_inyeccion( ltrim(rtrim($cuenta)), true).",".
    								$this->bd->sqlvalue_inyeccion( 'N', true).",".
    								$this->bd->sqlvalue_inyeccion($compromiso, true).",".
    								$this->bd->sqlvalue_inyeccion(0, true).",".
    								$this->bd->sqlvalue_inyeccion( $id_periodo, true).",".
    								$this->bd->sqlvalue_inyeccion( $anio, true).",".
    								$this->bd->sqlvalue_inyeccion( $mes, true).",".
    								$this->bd->sqlvalue_inyeccion($this->sesion , true).",".
    								$this->hoy.",".
    								$this->bd->sqlvalue_inyeccion( 'S', true).",".
    								$this->bd->sqlvalue_inyeccion( trim($partida), true).",".
    								$this->bd->sqlvalue_inyeccion( trim($clasificador), true).",".
    								$this->bd->sqlvalue_inyeccion( $compromiso, true).",".
    								$this->bd->sqlvalue_inyeccion( '0', true).",".
    								$this->bd->sqlvalue_inyeccion( $programa, true).",".
    								$this->bd->sqlvalue_inyeccion( $tipo_salario, true).",".
    								$this->bd->sqlvalue_inyeccion( 1, true).",".
    								$this->bd->sqlvalue_inyeccion( $this->ruc, true).")";
    								
    			$this->bd->ejecutar($sql);
    			
    			
    	 
    			$this->_cuenta_por_pagar_ingreso($id_tramite,$id_asiento,$cxp,$haber_cxp,$partida,$programa,$id_config) ;
    		 
    			   
    			
	        }
	    }
	    
 	    $this->_cuenta_por_pagar_descuentos($id_tramite,$id_asiento,$programa);
	  
 	    $this->_cuenta_por_pagar_patronal($id_tramite,$id_asiento,$programa);
 	
 	    
 	    $this->agrupa_asiento($id_asiento);
	}
	//--------------------------------------------------------------------------------
	//--- edicion de registros
	//--------------------------------------------------------------------------------
	function edicion($id){
	    
	 	
	 	$estado       = @$_POST["estado"];
 	 	$id_periodo   = @$_POST["id_periodo"];
	 	$idprov       = trim( @$_POST["idprov"] );
	 	
	 	$fecha		 = $this->bd->fecha(@$_POST["fecha"]);	
 	 	
	  
 	 	$longitudProve   = strlen($idprov);
	 	
	 	$secuencial   = @$_POST["secuencial"];
	 	$detalle      = @$_POST["detalle"];
	 	
	  
	 	
	 	//------------------------
 
		
		if (trim($estado) == 'digitado'){
			
		    if ($longitudProve > 5 ) {
		        
		 		 
				    
		 			    $sql = "UPDATE co_asiento
							    SET 	detalle      =".$this->bd->sqlvalue_inyeccion(trim($detalle), true).",
								        idprov       =".$this->bd->sqlvalue_inyeccion(trim($idprov), true).",
                                        fecha       =".$fecha.",
                                        id_periodo       =".$this->bd->sqlvalue_inyeccion($id_periodo, true).",
										documento    =".$this->bd->sqlvalue_inyeccion(trim(@$_POST["documento"]), true)."
							      WHERE id_asiento   =".$this->bd->sqlvalue_inyeccion($id, true);
		 			    
		 			    $this->bd->ejecutar($sql);
		 			    
 			         	 
		    }else{
		        $result = '<b>INGRESE LA CUENTA DEL GASTO PARA GUARDAR LA TRANSACCION</b>';
		    }
		}	
 		
 
		$this->_actualiza_aux($id,$idprov,$secuencial,$detalle);
		
		
		$result = $this->div_resultado('editar',$id,1,$estado,0).' ('.$id .')   '  ;
 
		echo $result;
	}
	
	//--------------------------------------------------------------------------------
	//--- eliminar de registros
	//--------------------------------------------------------------------------------
	function eliminar($id ){
		
	//    $estado      = @$_POST["estado"];
	    
	  //  $comprobante =  $this->saldos->_elimina_asiento($id,$estado);
	    
	    
	    $result = $this->div_limpiar();
 
		
		echo $result;
 		
	}
	 
	//----------------------------------------------------------
	function _cuenta_por_pagar_ingreso($id_tramite,$id_asiento,$cxp,$montocxp,$partida,$programa,$id_config){
	    
	    
	    $x = $this->bd->query_array('co_asiento',
	                                'anio, mes, id_periodo, idprov', 
	                                'id_asiento='.$this->bd->sqlvalue_inyeccion($id_asiento,true));
	    
	    
	    $sql = "INSERT INTO co_asientod(
						id_asiento, mes,anio,id_periodo,cuenta, aux,debe, haber,
						codigo1,codigo4,partida, programa, sesion, creacion, registro)
						VALUES (".
						$this->bd->sqlvalue_inyeccion($id_asiento, true).",".
						$this->bd->sqlvalue_inyeccion($x["mes"], true).",".
						$this->bd->sqlvalue_inyeccion($x["anio"], true).",".
						$this->bd->sqlvalue_inyeccion($x["id_periodo"], true).",".
						$this->bd->sqlvalue_inyeccion( $cxp, true).",".
						$this->bd->sqlvalue_inyeccion( 'S', true).",".
						$this->bd->sqlvalue_inyeccion( 0, true).",".
						$this->bd->sqlvalue_inyeccion($montocxp, true).",".
						$this->bd->sqlvalue_inyeccion($id_tramite, true).",".
						$this->bd->sqlvalue_inyeccion(1, true).",".
						$this->bd->sqlvalue_inyeccion($partida, true).",".
						$this->bd->sqlvalue_inyeccion($programa, true).",".
						$this->bd->sqlvalue_inyeccion($this->sesion , true).",".
						$this->hoy.",".
						$this->bd->sqlvalue_inyeccion( $this->ruc , true).")";
						
						$this->bd->ejecutar($sql);
						
						$id_asientod =  $this->bd->ultima_secuencia('co_asientod');
						
						$this->_aux_ingresos($programa,$id_config,$id_asientod,$id_asiento,$id_tramite,$x["id_periodo"],$x["anio"],$x["mes"]);
						
	  
	}	
	//---------------
	function _cuenta_por_pagar_descuentos($id_tramite,$id_asiento,$programa){
	   

	    $xx = $this->bd->query_array('co_asiento','anio, mes, id_periodo, idprov', 'id_asiento='.$this->bd->sqlvalue_inyeccion($id_asiento,true));
 	    
	    
	    
	    $sql1 ="SELECT id_tramite, cuentai, cuentae, nombre, id_rol, clasificador,
                 	    regimen, programa, tipo_config, tipoformula, ingreso, descuentos, salarios,
                 	    id_config
                FROM view_rol_tramite
                where  id_tramite= ".$this->bd->sqlvalue_inyeccion($id_tramite,true) ." and 
                       tipo_config = 'E' and    
                        programa = ".$this->bd->sqlvalue_inyeccion($programa,true) ;
	
 	    $stmt1 = $this->bd->ejecutar($sql1);
 	    
	    
	    while ($x=$this->bd->obtener_fila($stmt1)){
	        
	        $cuentae      = trim($x["cuentae"]);
	        $clasificador = trim($x["clasificador"]);
	        $descuentos   = $x["descuentos"];
	        
	        $id_config     = $x["id_config"];
	        
	        $zz = $this->bd->query_array('co_asientod',
	            'partida',
	            'id_asiento='.$this->bd->sqlvalue_inyeccion($id_asiento,true).' and
                codigo1='.$this->bd->sqlvalue_inyeccion($id_tramite,true).' and
                item='.$this->bd->sqlvalue_inyeccion($clasificador,true).' and
                programa='.$this->bd->sqlvalue_inyeccion($programa,true)
	            );
	        
	        $partida = trim($zz["partida"]);
	        
  	        
	        
	        // tipoformula <> 'AN'  and 
	        
	        $len = strlen($cuentae);
	        
	        if ( $len >= 4 ){
	            
	            
	            
	            $sql = "INSERT INTO co_asientod(
            						id_asiento, mes,anio,id_periodo,cuenta, aux,debe, haber,
            						codigo1,codigo4,partida, programa,item, sesion, creacion, registro)
            						VALUES (".
            						$this->bd->sqlvalue_inyeccion($id_asiento, true).",".
            						$this->bd->sqlvalue_inyeccion($xx["mes"], true).",".
            						$this->bd->sqlvalue_inyeccion($xx["anio"], true).",".
            						$this->bd->sqlvalue_inyeccion($xx["id_periodo"], true).",".
            						$this->bd->sqlvalue_inyeccion( $cuentae, true).",".
            						$this->bd->sqlvalue_inyeccion( 'S', true).",".
            						$this->bd->sqlvalue_inyeccion( 0, true).",".
            						$this->bd->sqlvalue_inyeccion($descuentos, true).",".
            						$this->bd->sqlvalue_inyeccion($id_tramite, true).",".
            						$this->bd->sqlvalue_inyeccion(1, true).",".
            						$this->bd->sqlvalue_inyeccion($partida, true).",".
            						$this->bd->sqlvalue_inyeccion($programa, true).",".
            						$this->bd->sqlvalue_inyeccion($clasificador, true).",".
            						$this->bd->sqlvalue_inyeccion($this->sesion , true).",".
            						$this->hoy.",".
            						$this->bd->sqlvalue_inyeccion( $this->ruc , true).")";
            						
            						$this->bd->ejecutar($sql);
            						
            						
            						
            		 $id_asientod =  $this->bd->ultima_secuencia('co_asientod');
            		 
             						
            		 $this->_aux_descuentos($programa,$id_config,$id_asientod,$id_asiento,$id_tramite,$xx["id_periodo"],$xx["anio"],$xx["mes"]);
 	            
            	 
	        }
	            
	        
	    }
	    
  
 }	  
 //-----------------------------
 function _cuenta_por_pagar_patronal($id_tramite,$id_asiento,$programa){
     
     
     $xx = $this->bd->query_array('co_asiento','anio, mes, id_periodo, idprov', 'id_asiento='.$this->bd->sqlvalue_inyeccion($id_asiento,true));
     
     
     
     $sql1 ="SELECT  a.id_tramite, b.partida, a.cuenta_debe, a.cuenta_haber,   a.clasificador,
                	    a.programa,    
                	    MIN(a.patronal) AS patronal, a.id_rol
	             FROM public.view_rol_patronal a
	             join presupuesto.view_dettramites b on
                	    a.programa=b.funcion and a.clasificador = b.clasificador and a.id_tramite= b.id_tramite and
                	    a.id_tramite= ".$this->bd->sqlvalue_inyeccion($id_tramite,true) ." and
                	    a.programa = ".$this->bd->sqlvalue_inyeccion($programa,true).
                	    ' group by  a.id_tramite, b.partida, a.cuenta_debe, a.cuenta_haber,   a.clasificador,
                	    a.programa,    
                	     a.id_rol';

 
     
     $stmt1 = $this->bd->ejecutar($sql1);
     
     
     while ($x=$this->bd->obtener_fila($stmt1)){
         
         $cuentae      = trim($x["cuenta_debe"]);
         $cuentad      = trim($x["cuenta_haber"]);
         
         $clasificador = trim($x["clasificador"]);
         $patronal     = $x["patronal"];
         
         $tipo_salario = 0;
          
         $partida = trim($x["partida"]);
         
         
         
         $len = strlen($cuentae);
         
         if ( $len >= 4 ){
             
             
             //---- debe 
             $sql = "INSERT INTO co_asientod(
    								id_asiento, codigo1, cuenta, aux, debe, haber, id_periodo, anio, mes,
    								sesion, creacion, principal,partida,item,monto1,monto2,programa,codigo3,codigo4,registro)
    								VALUES (".
    								$this->bd->sqlvalue_inyeccion($id_asiento , true).",".
    								$this->bd->sqlvalue_inyeccion($id_tramite , true).",".
    								$this->bd->sqlvalue_inyeccion( ltrim(rtrim($cuentae)), true).",".
    								$this->bd->sqlvalue_inyeccion( 'N', true).",".
    								$this->bd->sqlvalue_inyeccion($patronal, true).",".
    								$this->bd->sqlvalue_inyeccion(0, true).",".
    								$this->bd->sqlvalue_inyeccion( $xx["id_periodo"], true).",".
    								$this->bd->sqlvalue_inyeccion( $xx["anio"], true).",".
    								$this->bd->sqlvalue_inyeccion( $xx["mes"], true).",".
    								$this->bd->sqlvalue_inyeccion($this->sesion , true).",".
    								$this->hoy.",".
    								$this->bd->sqlvalue_inyeccion( 'S', true).",".
    								$this->bd->sqlvalue_inyeccion( trim($partida), true).",".
    								$this->bd->sqlvalue_inyeccion( trim($clasificador), true).",".
    								$this->bd->sqlvalue_inyeccion( $patronal, true).",".
    								$this->bd->sqlvalue_inyeccion( '0', true).",".
    								$this->bd->sqlvalue_inyeccion( $programa, true).",".
    								$this->bd->sqlvalue_inyeccion( $tipo_salario, true).",".
    								$this->bd->sqlvalue_inyeccion( 1, true).",".
    								$this->bd->sqlvalue_inyeccion( $this->ruc, true).")";
             
              
            						$this->bd->ejecutar($sql);
            						
            						
            	//---- haber
            						
            						$sql = "INSERT INTO co_asientod(
            						id_asiento, mes,anio,id_periodo,cuenta, aux,debe, haber,
            						codigo1,codigo4,partida, programa,item, sesion, creacion, registro)
            						VALUES (".
            						$this->bd->sqlvalue_inyeccion($id_asiento, true).",".
            						$this->bd->sqlvalue_inyeccion($xx["mes"], true).",".
            						$this->bd->sqlvalue_inyeccion($xx["anio"], true).",".
            						$this->bd->sqlvalue_inyeccion($xx["id_periodo"], true).",".
            						$this->bd->sqlvalue_inyeccion( $cuentad, true).",".
            						$this->bd->sqlvalue_inyeccion( 'S', true).",".
            						$this->bd->sqlvalue_inyeccion( 0, true).",".
            						$this->bd->sqlvalue_inyeccion($patronal, true).",".
            						$this->bd->sqlvalue_inyeccion($id_tramite, true).",".
            						$this->bd->sqlvalue_inyeccion(0, true).",".
            						$this->bd->sqlvalue_inyeccion($partida, true).",".
            						$this->bd->sqlvalue_inyeccion($programa, true).",".
            						$this->bd->sqlvalue_inyeccion($clasificador, true).",".
            						$this->bd->sqlvalue_inyeccion($this->sesion , true).",".
            						$this->hoy.",".
            						$this->bd->sqlvalue_inyeccion( $this->ruc , true).")";
            						
            						$this->bd->ejecutar($sql);
            						
            						
            						
            						$id_asientod =  $this->bd->ultima_secuencia('co_asientod');
            						
            						$this->_aux_patronal($programa,$id_asientod,$id_asiento,$id_tramite,$xx["id_periodo"],$xx["anio"],$xx["mes"],$cuentad,$patronal) ;
            						
         }
         
         
     }
     
     
     
 }
 
	//--------------------------------------------------------------------------
 function _aux_descuentos($programa,$id_config,$id_asientod,$id_asiento,$id_tramite,$id_periodo,$anio,$mes){
     
     
     $sql1 ="SELECT   ingreso, descuento, sueldo,  cuentai, cuentae,  idprov,  id_rol, tipoformula
               FROM view_rol_impresion
              where  id_config= ".$this->bd->sqlvalue_inyeccion($id_config,true) ." and
                     id_tramite= ".$this->bd->sqlvalue_inyeccion($id_tramite,true) ." and
                    programa = ".$this->bd->sqlvalue_inyeccion($programa,true) ;
     
     $stmt1 = $this->bd->ejecutar($sql1);
     
     
     while ($x=$this->bd->obtener_fila($stmt1)){
         
         $tipoformula = trim($x['tipoformula']) ;
         
         $cuenta = trim($x['cuentae']) ;
         
         if ( $tipoformula  ==   'AN'){
             
             $idprov_aux =  trim($x['idprov']) ;
             
         }else{
             
             $Aprov = $this->bd->query_array('co_plan_ctas',
                                             'idprov', 
                                             'cuenta='.$this->bd->sqlvalue_inyeccion(trim($cuenta),true). ' and 
                                              anio = '.$this->bd->sqlvalue_inyeccion(trim($this->anio),true)
             );
 
             $idprov_aux =  trim($Aprov['idprov']) ;
             
         }
         
         $len = strlen($idprov_aux);
         
         $debe  = 0;
         
         $haber = $x['descuento'];
         
         $sql = "INSERT INTO co_asiento_aux (id_asientod, id_asiento, idprov, cuenta, debe, haber,parcial, id_periodo,
    		              									  anio, mes, sesion, creacion, tipo, registro) VALUES (".
    		              									  $this->bd->sqlvalue_inyeccion($id_asientod  , true).",".
    		              									  $this->bd->sqlvalue_inyeccion($id_asiento, true).",".
    		              									  $this->bd->sqlvalue_inyeccion(trim($idprov_aux) , true).",".
    		              									  $this->bd->sqlvalue_inyeccion($cuenta , true).",".
    		              									  $this->bd->sqlvalue_inyeccion($debe , true).",".
    		              									  $this->bd->sqlvalue_inyeccion($haber , true).",".
    		              									  $this->bd->sqlvalue_inyeccion(0 , true).",".
    		              									  $this->bd->sqlvalue_inyeccion($id_periodo, true).",".
    		              									  $this->bd->sqlvalue_inyeccion($anio, true).",".
    		              									  $this->bd->sqlvalue_inyeccion($mes , true).",".
    		              									  $this->bd->sqlvalue_inyeccion($this->sesion 	, true).",".
    		              									  $this->hoy.",".
    		              									  $this->bd->sqlvalue_inyeccion('S' , true).",".
    		              									  $this->bd->sqlvalue_inyeccion( $this->ruc  , true).")";
    		if ( $len > 9 )	{
    		    $this->bd->ejecutar($sql);
    		}
    	 
    	
     }
     
	 
	}
	//--------------------------
	function _aux_patronal($programa,$id_asientod,$id_asiento,$id_tramite,$id_periodo,$anio,$mes,$cuenta,$haber){
	    
 
	            
	            $Aprov = $this->bd->query_array('co_plan_ctas',
	                'idprov',
	                'cuenta='.$this->bd->sqlvalue_inyeccion(trim($cuenta),true). ' and
                                              anio = '.$this->bd->sqlvalue_inyeccion(trim($this->anio),true)
	                );
	            
	        $idprov_aux =  trim($Aprov['idprov']) ;
	    
	        
	        $len = strlen($idprov_aux);
	        
 
	        
	        $sql = "INSERT INTO co_asiento_aux (id_asientod, id_asiento, idprov, cuenta, debe, haber,parcial, id_periodo,
    		              									  anio, mes, sesion, creacion, tipo, registro) VALUES (".
    		              									  $this->bd->sqlvalue_inyeccion($id_asientod  , true).",".
    		              									  $this->bd->sqlvalue_inyeccion($id_asiento, true).",".
    		              									  $this->bd->sqlvalue_inyeccion(trim($idprov_aux) , true).",".
    		              									  $this->bd->sqlvalue_inyeccion($cuenta , true).",".
    		              									  $this->bd->sqlvalue_inyeccion(0 , true).",".
    		              									  $this->bd->sqlvalue_inyeccion($haber , true).",".
    		              									  $this->bd->sqlvalue_inyeccion(0 , true).",".
    		              									  $this->bd->sqlvalue_inyeccion($id_periodo, true).",".
    		              									  $this->bd->sqlvalue_inyeccion($anio, true).",".
    		              									  $this->bd->sqlvalue_inyeccion($mes , true).",".
    		              									  $this->bd->sqlvalue_inyeccion($this->sesion 	, true).",".
    		              									  $this->hoy.",".
    		              									  $this->bd->sqlvalue_inyeccion('S' , true).",".
    		              									  $this->bd->sqlvalue_inyeccion( $this->ruc  , true).")";
	        
    		              									  if ( $len > 9 )	{
    		              									      $this->bd->ejecutar($sql);
    		              									  }
    		              									  
     
	    
	}
	//--------------------------------------------------------------------------
	function _aux_ingresos($programa,$id_config,$id_asientod,$id_asiento,$id_tramite,$id_periodo,$anio,$mes){
	    
	    
	    $sql1 ="SELECT   ingreso, descuento, sueldo,  cuentai, cuentae,  idprov,  id_rol, tipoformula
               FROM view_rol_impresion
              where  id_config= ".$this->bd->sqlvalue_inyeccion($id_config,true) ." and
                     id_tramite= ".$this->bd->sqlvalue_inyeccion($id_tramite,true) ." and
                    programa = ".$this->bd->sqlvalue_inyeccion($programa,true) ;
	    
 
	        
	    $stmt1 = $this->bd->ejecutar($sql1);
	    
	    
	    while ($x=$this->bd->obtener_fila($stmt1)){
	        
	        $tipoformula = trim($x['tipoformula']) ;
	        
	        $cuenta = trim($x['cuentae']) ;
	        
	        $idprov_aux =  trim($x['idprov']) ;
	        
	        
	        $haber = $x['ingreso'];
	        
	        
	        if ( $tipoformula  ==   'RS'){
	            
	                  
	            $Aprov = $this->bd->query_array('view_rol_impresion',
	                ' sum(descuento) as ingreso',
	                'id_tramite='.$this->bd->sqlvalue_inyeccion($id_tramite,true). ' and
                     programa = '.$this->bd->sqlvalue_inyeccion(trim($programa),true). ' and
                     idprov = '.$this->bd->sqlvalue_inyeccion(trim($idprov_aux),true)
	                );
	            
	            $haber = $x['ingreso'] -   $Aprov['ingreso'] ;
	            
	        }
	        
	        $len = strlen($idprov_aux);
	        
	        $debe  = 0;
	        
	     
	        
	        $sql = "INSERT INTO co_asiento_aux (id_asientod, id_asiento, idprov, cuenta, debe, haber,parcial, id_periodo,
    		              									  anio, mes, sesion, creacion, tipo, registro) VALUES (".
    		              									  $this->bd->sqlvalue_inyeccion($id_asientod  , true).",".
    		              									  $this->bd->sqlvalue_inyeccion($id_asiento, true).",".
    		              									  $this->bd->sqlvalue_inyeccion(trim($idprov_aux) , true).",".
    		              									  $this->bd->sqlvalue_inyeccion($cuenta , true).",".
    		              									  $this->bd->sqlvalue_inyeccion($debe , true).",".
    		              									  $this->bd->sqlvalue_inyeccion($haber , true).",".
    		              									  $this->bd->sqlvalue_inyeccion(0 , true).",".
    		              									  $this->bd->sqlvalue_inyeccion($id_periodo, true).",".
    		              									  $this->bd->sqlvalue_inyeccion($anio, true).",".
    		              									  $this->bd->sqlvalue_inyeccion($mes , true).",".
    		              									  $this->bd->sqlvalue_inyeccion($this->sesion 	, true).",".
    		              									  $this->hoy.",".
    		              									  $this->bd->sqlvalue_inyeccion('S' , true).",".
    		              									  $this->bd->sqlvalue_inyeccion( $this->ruc  , true).")";
    		              									  if ( $len > 9 )	{
    		              									      $this->bd->ejecutar($sql);
    		              									  }
    		              									  
    		              									  
	    }
	    
	    
	}
	//--------------------------------------------------------------------------
	function Comprobante($tipo,$anio){
		
	    /*
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
	    */
	}

//----------------------------------
	function existe_tramite($id_tramite){
	    
	    $secuencia = $this->bd->query_array('co_asiento',
	        'id_asiento',
	         'registro='.$this->bd->sqlvalue_inyeccion($this->ruc,true).' and
             id_tramite='.$this->bd->sqlvalue_inyeccion($id_tramite,true)
	        );
	    
	    
	    $x = $this->bd->query_array('presupuesto.pre_tramite',  'idprov', 'id_tramite='.$this->bd->sqlvalue_inyeccion($id_tramite,true) );
	    
	    if ( $secuencia['id_asiento'] > 0  ) {
	      
	        $sql ="update co_asiento 
                      set idprov=".$this->bd->sqlvalue_inyeccion(trim($x['idprov']),true) ." 
                     where id_asiento=".$this->bd->sqlvalue_inyeccion( $secuencia['id_asiento'],true);
	   	       
	   	   $this->bd->ejecutar($sql);
	        
	    }
	   
	    
	    
 	    return $secuencia['id_asiento']  ;
	    
	}
					
//------------------
	function agrupa_asiento($id_asiento){
	    
	    
	    $sql2 ="select cuenta, partida, sum(debe) as debe, max(id_asientod) as id_asientod
             from co_asientod where id_asiento=  ".$this->bd->sqlvalue_inyeccion($id_asiento,true) ."  and principal = 'S' and debe > 0
             group by cuenta, partida";

 
	    
	    
	    $stmt2 = $this->bd->ejecutar($sql2);
	    
	    while ($x=$this->bd->obtener_fila($stmt2)){
	        
	        $cuenta        = trim($x["cuenta"]);
	        $partida       = trim($x["partida"]);
	        $id_asientod   = $x["id_asientod"];
	        $debe          = $x["debe"];
	        
	        $sql ="update co_asientod
                      set debe =".$this->bd->sqlvalue_inyeccion($debe,true) .",
                          monto1 =".$this->bd->sqlvalue_inyeccion($debe,true) ."
                     where id_asientod=".$this->bd->sqlvalue_inyeccion($id_asientod,true);
	        
	        $this->bd->ejecutar($sql);
	        
	        
	        $sql2 ="delete   from co_asientod 
                     where id_asiento =".$this->bd->sqlvalue_inyeccion($id_asiento,true) ." and
                               cuenta =".$this->bd->sqlvalue_inyeccion($cuenta,true) ."  and 
                           id_asientod <>".$this->bd->sqlvalue_inyeccion($id_asientod,true) ."  and 
                           partida =".$this->bd->sqlvalue_inyeccion($partida,true) ."  and principal = 'S' and debe > 0";
	        
	        
	        $this->bd->ejecutar($sql2);
	    }
	        
        return 1;
	    
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
	$id            		= $_GET['id'];
	  
	$idasiento = $gestion->existe_tramite($id);
 
	
	if ( $accion == 'editar') {
	    
    	if ($idasiento > 0  )   {
    	
    	    $gestion->consultaId($accion,$idasiento);
    	
    	}else{
    	    
    	    $gestion->agregar($id);
    	}
	}
	
	//--------------------------------------
	if ( $accion == 'gasto') {
	    $id_tramite         = $_GET['id_tramite'];
	    $programa           = $_GET['programa'];
 	    $id_asiento         = $_GET['id_asiento'];
 
 	    $gestion->agregarDetallegasto($id_tramite,$id_asiento,trim($programa));
	
      }
      
}
      
     
     
     
    //------ grud de datos insercion
    if (isset($_POST["action"]))	{
    	
    	$action 		=     $_POST["action"];
    	$id 			=     $_POST["id_asiento"];
    	$id_tramite     =     $_POST["id_tramite"];
     
    	$gestion->xcrud(trim($action) ,  $id ,$id_tramite );
     
    	
    }



?>
 
  
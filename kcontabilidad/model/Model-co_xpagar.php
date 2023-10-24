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
		
		$this->hoy 	     =  date('Y-m-d');
		
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
		        array( campo => 'id_tramite',  valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'sesion',  valor => '-',  filtro => 'N',   visor => 'S'),
		        array( campo => 'modulo',  valor => '-',  filtro => 'N',   visor => 'S'),
		        array( campo => 'sesionm',  valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'modificacion',  valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'creacion',  valor => '-',  filtro => 'N',   visor => 'S')
		);
		
		
		$datos = $this->bd->JqueryArrayVisor('view_asientocxp',$qquery );
		
  
		$result =  $this->div_resultado($accion,$id,0,$datos["estado"],$datos["id_asiento"]);
		
		echo  $result;
	}
	//--------------------------------------------------------------------------------------
	//aprobaci�n de asientos
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
	    
 		$fecha		 = $this->bd->fecha($this->hoy 	);
 		
 		$estado      = 'digitado';
 		$documento   = trim( $x["documento"]);
 		$detalle1    = trim( $x["detalle"] );
 		
 		$detalle =substr($detalle1,0,350);
 		
 		
 		$idprov       = trim( $x["idprov"] );
 		//------------ seleccion de periodo
 		$mes  			= $periodo_s["mes"];
		$anio  			= $periodo_s["anio"];
		$comprobante    = '-';
		
		$tipoa  = 'F';
		//------------------------------------------------------------
 		
 
	
            		$sql = "INSERT INTO co_asiento(	fecha, registro, anio, mes, detalle,id_tramite, sesion, creacion,
                                                    modulo, comprobante, estado, tipo, documento,idprov,cuentag,estado_pago,
                                                    id_periodo)
            										        VALUES (".$fecha.",".
            										        $this->bd->sqlvalue_inyeccion($this->ruc, true).",".
            										        $this->bd->sqlvalue_inyeccion($anio, true).",".
            										        $this->bd->sqlvalue_inyeccion($mes, true).",".
            										        $this->bd->sqlvalue_inyeccion($detalle, true).",".
            										        $this->bd->sqlvalue_inyeccion($id_tramite, true).",".
            										        $this->bd->sqlvalue_inyeccion($this->sesion, true).",".
															$fecha.",".
            										        $this->bd->sqlvalue_inyeccion('cxpagar', true).",".
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
	function agregarDetallegasto($id_tramite,$id_asiento,$partida,$clasificador,$cuenta,$compromiso,$iva,	$norma ){
		
	    $periodo_s = $this->bd->query_array('co_asiento',
	        'mes,anio,id_periodo',
	        'id_asiento='.$this->bd->sqlvalue_inyeccion($id_asiento,true)
	        );
	    
	    $id_periodo     = $periodo_s["id_periodo"];
	    $mes  			= $periodo_s["mes"];
	    $anio  			= $periodo_s["anio"];
	    
	   
	    $len = strlen($cuenta);
 	    
		$fecha		 = $this->bd->fecha($this->hoy 	);
	    
	    if ( $len > 3 ) {
	        

			if (    $norma  == 'X' ) {
			
					$compromiso =  $compromiso / (1.12);
					$iva        =  $compromiso * (12/100);
			}
			 
    	 
    	        
    	        $sql = "INSERT INTO co_asientod(
    								id_asiento, codigo1, cuenta, aux, debe, haber, id_periodo, anio, mes,
    								sesion, creacion, principal,partida,item,monto1,monto2,codigo4,registro)
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
    								$fecha.",".
    								$this->bd->sqlvalue_inyeccion( 'S', true).",".
    								$this->bd->sqlvalue_inyeccion( trim($partida), true).",".
    								$this->bd->sqlvalue_inyeccion( trim($clasificador), true).",".
    								$this->bd->sqlvalue_inyeccion( $compromiso, true).",".
    								$this->bd->sqlvalue_inyeccion( $iva, true).",".
    								$this->bd->sqlvalue_inyeccion( 1, true).",".
    								$this->bd->sqlvalue_inyeccion( $this->ruc, true).")";
    	        
    	        
     
    								
	    $this->bd->ejecutar($sql);
	    
	    }
	    
 	
	}
	//--------------------------------------------------------------------------------
	//--- edicion de registros
	//--------------------------------------------------------------------------------
	function edicion($id){
	    
	 	
	 	$estado          = $_POST["estado"];
 	 	$id_periodo      = $_POST["id_periodo"];
	 	$idprov          = trim( $_POST["idprov"] );
	 	
	 	$fecha_registro  = $_POST["fecha"];
	 	$fecha		     = $this->bd->fecha($_POST["fecha"]);	
	 	$bandera         = 0;
 	 	$longitudProve   = strlen($idprov);
	 	
	 	$secuencial   = $_POST["secuencial"];
	 	$detalle      = $_POST["detalle"];
	 	
	 	if ($this->bd->_cierre($fecha_registro) == 'cerrado'){
	 	    $bandera  = -1;
			 
	 	    $result   = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>PERIODO CERRADO '.$this->anio .'</b>';
	 	    
	 	}
	 	
		 $hoy 		   = date('Y-m-d');
		 $hoy 		   = $this->bd->fecha( $hoy );

	 	//------------------------
	 	if ( $bandera == 0 ) {
        		if (trim($estado) == 'digitado'){
        			
        		    if ($longitudProve > 5 ) {
         				    
        		 			    $sql = "UPDATE co_asiento
        							    SET 	detalle     =".$this->bd->sqlvalue_inyeccion(trim($detalle), true).",
        								        idprov      =".$this->bd->sqlvalue_inyeccion(trim($idprov), true).",
                                                fecha       =".$fecha.",
                                                id_periodo  =".$this->bd->sqlvalue_inyeccion($id_periodo, true).",
												sesionm      =".$this->bd->sqlvalue_inyeccion($this->sesion , true).",
												modificacion =". $hoy.",
        										documento   =".$this->bd->sqlvalue_inyeccion(trim($_POST["documento"]), true)."
        							      WHERE id_asiento  =".$this->bd->sqlvalue_inyeccion($id, true);
        		 			    
        		 			    $this->bd->ejecutar($sql);
        		 			    
								 $sql1 = "UPDATE co_asientod
								             SET item      =".$this->bd->sqlvalue_inyeccion('-', true).",
									            partida      =".$this->bd->sqlvalue_inyeccion('-', true)."
							               WHERE  id_asiento = ".$this->bd->sqlvalue_inyeccion( $id  ,true)."  and 
									              cuenta  like ".$this->bd->sqlvalue_inyeccion('112.%', true) ;
		   
							 	  $this->bd->ejecutar($sql1);


        		 			    $result = $this->div_resultado('editar',$id,1,$estado,0).' ('.$id .')   '  ;
         			         	 
        		    }else{
        		        $result = '<b>INGRESE LA CUENTA DEL GASTO PARA GUARDAR LA TRANSACCION</b>';
        		    }
        		}	
	 	}
		
		$this->_actualiza_aux($id,$idprov,$secuencial,$detalle);
		
		$this->apagar_asiento( $id, $idprov );
 	 
		
		
 
		echo $result;
	}
	
	//--------------------------------------------------------------------------------
	//--- eliminar de registros
	//--------------------------------------------------------------------------------
	function eliminar($id ){
 
	    $result = $this->div_limpiar();
 
		
		echo $result;
 		
	}
	//--------------------
	function K_iva($id_tramite,$id_asiento,$cuenta_iva,$cuenta_ivac,$cuenta_ivap,$grupo,$monto_iva,$norma ){
	    
	    //- id_tramite,$id_asiento,$iva,$ivac,$ivap,$grupo,$monto_iva
	    
	    $x = $this->bd->query_array('co_asiento',
	                                'anio, mes, id_periodo, idprov', 
	                                'id_asiento='.$this->bd->sqlvalue_inyeccion($id_asiento,true)
	        );
 
	    
	    if ( $cuenta_iva == '-'){
	        $bandera = 0;
	    }else {
	        $bandera = 1;
	    }
	    
	    if ( $cuenta_ivac == '-'){
	        $bandera1 = 3;
	    }else {
	        $bandera1 = 2;
	    }
	    
		$fecha		 = $this->bd->fecha( $this->hoy 	);
	    
	        if ( $monto_iva > 0 )  {
	            
	        
        	    if ($bandera == 1){
        	        
        	        $sql = "INSERT INTO co_asientod(
        						id_asiento, mes,anio,id_periodo,cuenta, aux,debe, haber,
        						codigo1, sesion, creacion, registro)
        						VALUES (".
        						$this->bd->sqlvalue_inyeccion($id_asiento, true).",".
        						$this->bd->sqlvalue_inyeccion($x["mes"], true).",".
        						$this->bd->sqlvalue_inyeccion($x["anio"], true).",".
        						$this->bd->sqlvalue_inyeccion($x["id_periodo"], true).",".
        						$this->bd->sqlvalue_inyeccion( $cuenta_iva, true).",".
        						$this->bd->sqlvalue_inyeccion( 'N', true).",".
        						$this->bd->sqlvalue_inyeccion( $monto_iva, true).",".
        						$this->bd->sqlvalue_inyeccion(0, true).",".
        						$this->bd->sqlvalue_inyeccion($id_tramite, true).",".
        						$this->bd->sqlvalue_inyeccion($this->sesion , true).",".
        						$fecha.",".
        						$this->bd->sqlvalue_inyeccion( $this->ruc , true).")";
        	        
        						if ( $cuenta_iva <> '-'){
            						$this->bd->ejecutar($sql);
        						}
         						
        	    }
        	    //-----------------------------------------------------
        	    if ($bandera1 == 3){
        	        
        	        $sql = "INSERT INTO co_asientod(
        						id_asiento, mes,anio,id_periodo,cuenta, aux,debe, haber,
        						codigo1, sesion, creacion,partida, registro)
        						VALUES (".
        						$this->bd->sqlvalue_inyeccion($id_asiento, true).",".
        						$this->bd->sqlvalue_inyeccion($x["mes"], true).",".
        						$this->bd->sqlvalue_inyeccion($x["anio"], true).",".
        						$this->bd->sqlvalue_inyeccion($x["id_periodo"], true).",".
        						$this->bd->sqlvalue_inyeccion( $cuenta_iva, true).",".
        						$this->bd->sqlvalue_inyeccion( 'N', true).",".
        						$this->bd->sqlvalue_inyeccion( 0, true).",".
        						$this->bd->sqlvalue_inyeccion($monto_iva, true).",".
        						$this->bd->sqlvalue_inyeccion($id_tramite, true).",".
        						$this->bd->sqlvalue_inyeccion($this->sesion , true).",".
        						$fecha.",".
        						$this->bd->sqlvalue_inyeccion($cuenta_ivap, true).",".
        						$this->bd->sqlvalue_inyeccion( $this->ruc , true).")";
        						
								if ( trim($norma)  == 'N'){
									if ( $cuenta_iva <> '-'){
										$this->bd->ejecutar($sql);
									}
							    }		
        	    }
 
        	    if ($bandera1 == 2){
        	         
        	        
        	        if (!empty($cuenta_ivap)){
        	            
        	            if($cuenta_ivac <> '-' ){
        	                
        	                $sql = "INSERT INTO co_asientod(
        						id_asiento, mes,anio,id_periodo,cuenta, aux,debe, haber,
        						codigo1,codigo4,partida, sesion, creacion, registro)
        						VALUES (".
        						$this->bd->sqlvalue_inyeccion($id_asiento, true).",".
        						$this->bd->sqlvalue_inyeccion($x["mes"], true).",".
        						$this->bd->sqlvalue_inyeccion($x["anio"], true).",".
        						$this->bd->sqlvalue_inyeccion($x["id_periodo"], true).",".
        						$this->bd->sqlvalue_inyeccion( $cuenta_ivac, true).",".
        						$this->bd->sqlvalue_inyeccion( 'N', true).",".
        						$this->bd->sqlvalue_inyeccion( 0, true).",".
        						$this->bd->sqlvalue_inyeccion($monto_iva, true).",".
        						$this->bd->sqlvalue_inyeccion($id_tramite, true).",".
        						$this->bd->sqlvalue_inyeccion(2, true).",".
        						$this->bd->sqlvalue_inyeccion($cuenta_ivap, true).",".
        						$this->bd->sqlvalue_inyeccion($this->sesion , true).",".
        						$fecha.",".
        						$this->bd->sqlvalue_inyeccion( $this->ruc , true).")";
        						
								if ( trim($norma)  == 'N'){
										if ( $cuenta_iva <> '-'){
											$this->bd->ejecutar($sql);
										}
							    }		
        	            }
        	        }
        	    }
        	 }
	  //  }
	    
	 
	}
	//------------------------------------------------------------------------- K_fuentes
	function K_Riva($id_tramite,$id_asiento,$riva,$montoriva,$partida, $norma  ){
	    
		$x = $this->bd->query_array('co_asiento','anio, mes, id_periodo, idprov', 'id_asiento='.$this->bd->sqlvalue_inyeccion($id_asiento,true));
 

		$xxx = $this->bd->query_array('co_plan_ctas',
									  'idprov', 
									   'cuenta='.$this->bd->sqlvalue_inyeccion( trim($riva),true).' and 
									    anio = '.$this->bd->sqlvalue_inyeccion($x["anio"],true)
										);

      if ( empty($xxx['idprov'] ) ){
		
		$idprov = $this->ruc_sri  ;

	  } else{

        $idprov = trim($xxx['idprov']);
   	}
 	   
	    $z = $this->bd->query_array('co_asientod',
	        'count(*) as nn',
	        'id_asiento='.$this->bd->sqlvalue_inyeccion($id_asiento,true). ' and
                                    cuenta = '.$this->bd->sqlvalue_inyeccion(trim($riva),true). ' and
                                    haber = '.$this->bd->sqlvalue_inyeccion($montoriva,true)
	        );
	    
		if ( $norma == 'S'){
			$partida = '-';
		}	
	    
	    if (  $z["nn"] >= 1 ){
	        return -1;
	    }
	    else {
	    
			$fecha		 = $this->bd->fecha($this->hoy 	);

	    $sql = "INSERT INTO co_asientod(
						id_asiento, mes,anio,id_periodo,cuenta, aux,debe, haber,
						codigo1,codigo4,partida, sesion, creacion, registro)
						VALUES (".
						$this->bd->sqlvalue_inyeccion($id_asiento, true).",".
						$this->bd->sqlvalue_inyeccion($x["mes"], true).",".
						$this->bd->sqlvalue_inyeccion($x["anio"], true).",".
						$this->bd->sqlvalue_inyeccion($x["id_periodo"], true).",".
						$this->bd->sqlvalue_inyeccion( $riva, true).",".
						$this->bd->sqlvalue_inyeccion( 'S', true).",".
						$this->bd->sqlvalue_inyeccion( 0, true).",".
						$this->bd->sqlvalue_inyeccion($montoriva, true).",".
						$this->bd->sqlvalue_inyeccion($id_tramite, true).",".
						$this->bd->sqlvalue_inyeccion(1, true).",".
						$this->bd->sqlvalue_inyeccion($partida, true).",".
						$this->bd->sqlvalue_inyeccion($this->sesion , true).",".
						$fecha.",".
						$this->bd->sqlvalue_inyeccion( $this->ruc , true).")";
						
						$this->bd->ejecutar($sql);
						
						$id_asientod =  $this->bd->ultima_secuencia('co_asientod');
						
						$this->K_aux($id_asientod,$id_asiento,  $idprov  ,$riva,0,$montoriva,$x["id_periodo"],$x["anio"],$x["mes"],'S');
 
	    }
	}
	 

	//----------------------------------------------------------
	function K_proveedor($id_tramite,$id_asiento,$cxp,$montocxp,$partida,$norma ){
	    
	    
	    $x = $this->bd->query_array('co_asiento','anio, mes, id_periodo, idprov', 'id_asiento='.$this->bd->sqlvalue_inyeccion($id_asiento,true));
	    
		$fecha		 = $this->bd->fecha($this->hoy 	);
	    
	    $sql = "INSERT INTO co_asientod(
						id_asiento, mes,anio,id_periodo,cuenta, aux,debe, haber,
						codigo1,codigo4,partida, sesion, creacion, registro)
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
						$this->bd->sqlvalue_inyeccion($this->sesion , true).",".
						$fecha	.",".
						$this->bd->sqlvalue_inyeccion( $this->ruc , true).")";
						
						$this->bd->ejecutar($sql);
						
						$id_asientod =  $this->bd->ultima_secuencia('co_asientod');
						
						$this->K_aux($id_asientod,$id_asiento,$x["idprov"],$cxp,0,$montocxp,$x["id_periodo"],$x["anio"],$x["mes"],'S');
						
	  
	}	
	//---------------
	function K_fuentes($id_tramite,$id_asiento,$rfuente,$montofuente,$partida){
	   

	    $x = $this->bd->query_array('co_asiento','anio, mes, id_periodo, idprov', 'id_asiento='.$this->bd->sqlvalue_inyeccion($id_asiento,true));
	    
	    $z = $this->bd->query_array('co_asientod',
	                                'count(*) as nn', 
	                                'id_asiento='.$this->bd->sqlvalue_inyeccion($id_asiento,true). ' and 
                                    cuenta = '.$this->bd->sqlvalue_inyeccion(trim($rfuente),true). ' and
                                    haber = '.$this->bd->sqlvalue_inyeccion($montofuente,true)
	    );
	    
	    $len = strlen($rfuente);

		$fecha		 = $this->bd->fecha($this->hoy 	);
	    
	    if ( $len >= 4 ){
             	    if (  $z["nn"] >= 1 ){
            	        return -1;
            	    }
            	    else {
            	    $sql = "INSERT INTO co_asientod(
            						id_asiento, mes,anio,id_periodo,cuenta, aux,debe, haber,
            						codigo1,codigo4,partida, sesion, creacion, registro)
            						VALUES (".
            						$this->bd->sqlvalue_inyeccion($id_asiento, true).",".
            						$this->bd->sqlvalue_inyeccion($x["mes"], true).",".
            						$this->bd->sqlvalue_inyeccion($x["anio"], true).",".
            						$this->bd->sqlvalue_inyeccion($x["id_periodo"], true).",".
            						$this->bd->sqlvalue_inyeccion( $rfuente, true).",".
            						$this->bd->sqlvalue_inyeccion( 'S', true).",".
            						$this->bd->sqlvalue_inyeccion( 0, true).",".
            						$this->bd->sqlvalue_inyeccion($montofuente, true).",".
            						$this->bd->sqlvalue_inyeccion($id_tramite, true).",".
            						$this->bd->sqlvalue_inyeccion(1, true).",".
            						$this->bd->sqlvalue_inyeccion($partida, true).",".
            						$this->bd->sqlvalue_inyeccion($this->sesion , true).",".
            						$fecha.",".
            						$this->bd->sqlvalue_inyeccion( $this->ruc , true).")";
            						
            						$this->bd->ejecutar($sql);
            						
            						 
            						
            						$id_asientod =  $this->bd->ultima_secuencia('co_asientod');
            						
            						$this->K_aux($id_asientod,$id_asiento,$this->ruc_sri ,$rfuente,0,$montofuente,$x["id_periodo"],$x["anio"],$x["mes"],'S');
            						
            	    }
	    
	    }else {
	        return -1;
	    }
	     
	}	  
	//--------------------------------------------------------------------------
	function K_aux($id_asientod,$id_asiento,$idprov,$cuenta,$debe,$haber,$id_periodo,$anio,$mes,$tipo){
	   
	    $longitud = strlen($idprov);
	    
	    if ($longitud > 5 ) {
	           
	        if (!empty(trim($cuenta))){

				$fecha		 = $this->bd->fecha($this->hoy 	);
	            
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
    		              									  $fecha.",".
    		              									  $this->bd->sqlvalue_inyeccion($tipo , true).",".
    		              									  $this->bd->sqlvalue_inyeccion( $this->ruc  , true).")";
    		              									  
    		              									  $this->bd->ejecutar($sql);
    		              									  
    		              									 
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
//----------------
	function apagar_asiento( $idasiento, $idprov ){
	    
	    
	    $secuencia = $this->bd->query_array('co_asiento_aux',
	        'sum(haber) as total',
	        'idprov='.$this->bd->sqlvalue_inyeccion(trim($idprov),true)." and cuenta like '213.%' and
             id_asiento=".$this->bd->sqlvalue_inyeccion($idasiento,true)
	        );
	    
 
	    $total = $secuencia['total'];
	    
	    $sql = " UPDATE co_asiento
							    SET 	apagar      =".$this->bd->sqlvalue_inyeccion($total, true)."
 							      WHERE id_asiento   =".$this->bd->sqlvalue_inyeccion($idasiento, true);
	    
	    $this->bd->ejecutar($sql);
	    
	    
	    
	    return 1;
	    
	}
//----------------------------------
	function existe_tramite($id_tramite){
	    
	    $secuencia = $this->bd->query_array('co_asiento',
	        'id_asiento',
	         'registro='.$this->bd->sqlvalue_inyeccion($this->ruc,true).' and
             id_tramite='.$this->bd->sqlvalue_inyeccion($id_tramite,true).' and
			 estado <> '.$this->bd->sqlvalue_inyeccion('aprobado',true)
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
	    $partida            = $_GET['partida'];
	    $clasificador       = $_GET['clasificador'];
	    $cuenta           	= $_GET['cuenta'];
	    $compromiso         = $_GET['compromiso'];
	    $iva            	= $_GET['iva'];
	    $id_asiento         = $_GET['id_asiento'];

		$norma         =     trim($_GET['norma']);
		
 
	    $gestion->agregarDetallegasto($id_tramite,$id_asiento,$partida,$clasificador,$cuenta,$compromiso,$iva,	$norma );
	
      }
        //--------------------------------------
      if ( $accion == 'cxp') {
          $id_tramite         = $_GET['id_tramite'];
          $id_asiento         = $_GET['id_asiento'];
          $partida            = $_GET['partida'];
          $grupo              = $_GET['grupo'];
          $monto_iva          = $_GET['monto_iva'];
          
          $iva          = $_GET['iva'];
          $ivac         = $_GET['ivac'];
          $ivap         = $_GET['ivap'];
        
          $riva          = $_GET['riva'];
          $montoriva     = $_GET['montoriva'];
          
          $rfuente                = $_GET['rfuente'];
          $montofuente          = $_GET['montofuente'];
   
          $cxp                  = $_GET['cxp'];
          $montocxp             = $_GET['montocxp'];
      
		  $norma   = $_GET['norma'];
           
          $gestion->K_iva($id_tramite,$id_asiento,$iva,$ivac,$ivap,$grupo,$monto_iva,$norma );
          
          if (!empty($riva)){
               $gestion->K_Riva($id_tramite,$id_asiento,$riva,$montoriva,$partida, $norma  );
          }
          if (!empty($rfuente)){
              $gestion->K_fuentes($id_tramite,$id_asiento,$rfuente,$montofuente,$partida);
          }
          if (!empty($cxp)){
              $gestion->K_proveedor($id_tramite,$id_asiento,$cxp,$montocxp,$partida,$norma );
          }
          
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
 
  
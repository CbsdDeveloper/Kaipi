<?php
session_start();

require '../../kconfig/Db.class.php';   

require '../../kconfig/Obj.conf.php';  

require 'Model-asientos_saldos.php';  

class proceso{
	
	 
	
	private $obj;
	private $bd;
	private $saldos;
	
	private $ruc;
	private $sesion;
	private $hoy;
	private $POST;
	private $anio;
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function proceso( ){
 		
		$this->obj     = 	new objects;
		$this->bd	   =	new Db ;
		
		$this->ruc       =  $_SESSION['ruc_registro'];
		
		$this->sesion 	 =  trim($_SESSION['email']);
		
		$this->hoy 	     =  $this->bd->hoy();
		
	 
		
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
		
		$this->saldos     = 	new saldo_contable(  $this->obj,  $this->bd);
		
		$this->anio       =  $_SESSION['anio'];
		
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
 
		}
		
		if ($tipo == 1){
			
		    $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO ['.$id.']</b>';
		    
 
			
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
		
		$resultado = 'TRANSACCION ELIMINADA';
		
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
				array( campo => 'comprobante',   valor => '-',  filtro => 'N',   visor => 'S'),
		        array( campo => 'nomina',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'documento',     valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'tipo',     valor => '-',  filtro => 'N',   visor => 'S'),
		        array( campo => 'id_tramite',     valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'detalle',  valor => '-',  filtro => 'N',   visor => 'S'),
		        array( campo => 'sesion',  valor => '-',  filtro => 'N',   visor => 'S'),
		        array( campo => 'modulo',  valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'sesion',  valor => '-',  filtro => 'N',   visor => 'S'),
		        array( campo => 'modulo',  valor => '-',  filtro => 'N',   visor => 'S'),
		        array( campo => 'sesionm',  valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'modificacion',  valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'creacion',  valor => '-',  filtro => 'N',   visor => 'S')
		);
		
		
		
 		$datos = $this->bd->JqueryArrayVisor('view_asientos',$qquery );

 		
		
	 
 
	 	$result =  $this->div_resultado($accion,$id,0,$datos['estado']);
		
		echo  $result;
	}
	//--------------------------------------------------------------------------------------
	//aprobaci�n de asientos
	function aprobacion( $id  ){
		
	    $comprobante =  $this->saldos->_aprobacion($id);
	     
	    if ($comprobante <> '-')	{
	    
	        $result = $this->div_resultado('aprobado',$id,2,$comprobante);
	 
	    }else{
	        
	        $result = 'NO SE APROBO EL ASIENTO... REVISE AUXILIARES - ENLACES PRESUPUESTARIOS INGRESO - GASTO';
	    }
 			
		 
		echo $result;
	}
	 
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	
	function xcrud($action,$id,	$estado  ){
		
		
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
		
		if ($action == 'cambio_tramite'){
			
			$this->cambio_datos($id,	$estado   );
			
		}
		
	}
	//--------------------------
	function apagar_asiento( $idasiento, $aidprov ){
	    
	    
	    $idprov = trim($aidprov['idprov']);
	    
	    $secuencia = $this->bd->query_array('co_asiento_aux',
	        'sum(haber)  - sum(debe) as total',
	        'idprov='.$this->bd->sqlvalue_inyeccion(trim($idprov),true)." and cuenta like '213.%' and
             id_asiento=".$this->bd->sqlvalue_inyeccion($idasiento,true)
	        );
	    
	    
	    $len = strlen(trim($idprov));
	    
	    $total = $secuencia['total'];
	    
	    $sql = " UPDATE co_asiento
							    SET 	apagar      =".$this->bd->sqlvalue_inyeccion($total, true)."
 							      WHERE id_asiento   =".$this->bd->sqlvalue_inyeccion($idasiento, true);
	    
	    if ( $len > 8 ){
	        
	        $this->bd->ejecutar($sql);
	    }
	  
	    
	    
	    
	    return 1;
	    
	}
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	function agregar( ){
  	
 		
		$fecha		    = $this->bd->fecha(@$_POST["fecha"]);
		$fecha_registro = @$_POST["fecha"];
		$x              = explode('-',$fecha_registro);
		$mes  			= $x[1];
		$anio  			= $x[0];
		
		$cuenta        = @$_POST["cuenta"];
		$estado        = 'digitado';
		$comprobante   = '-';
		$bandera       = 0;
		
		//------------ seleccion de periodo
		$periodo_s     = $this->bd->query_array('co_periodo','id_periodo,mes,anio',
		                                        'registro ='.$this->bd->sqlvalue_inyeccion($this->ruc ,true).' and
                                              	anio='.$this->bd->sqlvalue_inyeccion($anio ,true).' and
                                              	mes='.$this->bd->sqlvalue_inyeccion($mes ,true)
		    );
		
		$id_periodo    = $periodo_s["id_periodo"];
		
		if ( $anio   <>  $this->anio ) {
		    $bandera = -1;
		    $result   = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>PERIODO NO VALIDO... REVISE PORFAVOR PERIODO ?'.$this->anio .'</b>';
		}
 		
		
		if ($this->bd->_cierre($fecha_registro) == 'cerrado'){
		    
		    $bandera = -1;
		    $result   = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>PERIODO CERRADO '.$this->anio .'</b>';
		
		}
		    
		    //------------------------------------------------------------
    		$sql = "INSERT INTO co_asiento(	fecha, registro, anio, mes, detalle, sesion, sesionm,creacion,modificacion,
                    						comprobante, estado, tipo, documento,modulo,id_periodo)
    										        VALUES (".$fecha.",".
    										        $this->bd->sqlvalue_inyeccion($this->ruc, true).",".
    										        $this->bd->sqlvalue_inyeccion($anio, true).",".
    										        $this->bd->sqlvalue_inyeccion($mes, true).",".
    										        $this->bd->sqlvalue_inyeccion(@$_POST["detalle"], true).",".
    										        $this->bd->sqlvalue_inyeccion($this->sesion, true).",".
    										        $this->bd->sqlvalue_inyeccion($this->sesion, true).",".
    										        $this->hoy.",".
    										        $this->hoy.",".
    										        $this->bd->sqlvalue_inyeccion($comprobante, true).",".
    										        $this->bd->sqlvalue_inyeccion($estado, true).",".
    										        $this->bd->sqlvalue_inyeccion(@$_POST["tipo"], true).",".
    										        $this->bd->sqlvalue_inyeccion(@$_POST["documento"], true).",".
    										        $this->bd->sqlvalue_inyeccion('contabilidad', true).",".
    										        $this->bd->sqlvalue_inyeccion($id_periodo, true).")";
            
    	 
		
		   if ( $bandera == 0){
		     
        		  $this->bd->ejecutar($sql);
                  $idAsiento =  $this->bd->ultima_secuencia('co_asiento');

                  if  ( !empty(trim($cuenta))) {
                  	$this->agregarDetalle( $idAsiento,trim($cuenta));
                  }
                  $result = $this->div_resultado('editar',$idAsiento,1,$estado);
 
		  }
		 
		 echo $result;
		
	}
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	function agregarDetalle( $id,$cuenta){
		
		if (!empty($id)){
		    
					$periodo_s = $this->bd->query_array('co_asiento',
														'mes,anio,id_periodo',
														'id_asiento='.$this->bd->sqlvalue_inyeccion($id,true)
																				   	);
					$id_periodo=$periodo_s["id_periodo"];
					$mes  			= $periodo_s["mes"];
					$anio  			= $periodo_s["anio"];
					//-------------
					$datosaux  = $this->bd->query_array('co_plan_ctas',
											'aux',
						                	'cuenta='.$this->bd->sqlvalue_inyeccion($cuenta,true).' and 
										    registro ='.$this->bd->sqlvalue_inyeccion( $this->ruc,true)
											);
					 		
					$aux		= $datosaux['aux'];
					
					
					$sql_inserta = "INSERT INTO co_asientod(
								id_asiento, cuenta, aux,debe, haber, id_periodo, anio, mes,
								sesion, creacion, registro)
								VALUES (".
								$this->bd->sqlvalue_inyeccion($id , true).",".
								$this->bd->sqlvalue_inyeccion( ltrim(rtrim($cuenta)), true).",".
								$this->bd->sqlvalue_inyeccion( $aux, true).",".
								$this->bd->sqlvalue_inyeccion(0, true).",".
								$this->bd->sqlvalue_inyeccion(0, true).",".
								$this->bd->sqlvalue_inyeccion( $id_periodo, true).",".
								$this->bd->sqlvalue_inyeccion( $anio, true).",".
								$this->bd->sqlvalue_inyeccion( $mes, true).",".
								$this->bd->sqlvalue_inyeccion($this->sesion , true).",".
								$this->hoy.",".
								$this->bd->sqlvalue_inyeccion( $this->ruc, true).")";
								
								$this->bd->ejecutar($sql_inserta);
								
							
		}									        
	}
	//--------------------------------------------------------------------------------
	//--- edicion de registros
	//--------------------------------------------------------------------------------
	function edicion($id){
		
	 	$estado        = trim($_POST["estado"]);
	 	$cuenta        = trim($_POST["cuenta"]);
		
		$fecha_registro= $_POST["fecha"];
		$fecha		   = $this->bd->fecha($_POST["fecha"]);
		$hoy 		   = date('Y-m-d');
		$hoy 		   = $this->bd->fecha( $hoy );
 
		$bandera        = 0;
	 	$x              = explode('-',$fecha_registro);
	 	$mes  			= $x[1];
	 	$anio  			= $x[0];
	 	
	 	//------------ seleccion de periodo
	 	$periodo_s = $this->bd->query_array('co_periodo','id_periodo,mes,anio',
	 	                                    'registro ='.$this->bd->sqlvalue_inyeccion($this->ruc ,true).' and
                                          	anio='.$this->bd->sqlvalue_inyeccion($anio ,true).' and
                                          	mes='.$this->bd->sqlvalue_inyeccion($mes ,true)
	 	    );
 	 	
	 	$id_periodo    = $periodo_s["id_periodo"];
 	 	$aprov         = $this->bd->query_array('co_asiento',
                                    	 	    'idprov',
                                    	 	    'id_asiento='.$this->bd->sqlvalue_inyeccion($id,true)
                                    	 	    );
                                    	 	
	 	
	 	
	 	if ( $anio   <>  $this->anio ) {
	 	    $bandera = -1;
	 	    $result   = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>PERIODO NO VALIDO... REVISE PORFAVOR PERIODO ?'.$this->anio .'</b>';
	 	}
	 	
	 	
	 	
	 	if ($this->bd->_cierre($fecha_registro) == 'cerrado'){
	 	    $bandera = -1;
	 	    $result   = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>PERIODO CERRADO ?'.$this->anio .'</b>';
	 	    
	 	}
 	 	
	 	
	 	
	 	if ( $bandera == 0 ){
	 	
        		if (trim($estado) == 'digitado'){
        		    
 
        		 			$sql = " UPDATE co_asiento
        							              SET 	detalle      =".$this->bd->sqlvalue_inyeccion(trim($_POST["detalle"]), true).",
        											    comprobante  =".$this->bd->sqlvalue_inyeccion($_POST["comprobante"], true).",
                                                        id_tramite  =".$this->bd->sqlvalue_inyeccion($_POST["id_tramite"], true).",
                                                        id_periodo   =".$this->bd->sqlvalue_inyeccion($id_periodo, true).",
                                                        sesionm      =".$this->bd->sqlvalue_inyeccion($this->sesion , true).",
                                                        fecha        =".$fecha.",
                                                        modificacion =". $hoy.",
        												tipo         =".$this->bd->sqlvalue_inyeccion(trim($_POST["tipo"]), true).",
        												documento    =".$this->bd->sqlvalue_inyeccion(trim($_POST["documento"]), true)."
        							      WHERE id_asiento           =".$this->bd->sqlvalue_inyeccion($id, true);
        					
        					$this->bd->ejecutar($sql);
        			
        					if  ( !empty(trim($cuenta))) {
        						$this->agregarDetalle( $id,trim($cuenta));
        					}
         
        		}else 	{
        		    
        		    $sql = " UPDATE co_asiento
        							              SET 	detalle      =".$this->bd->sqlvalue_inyeccion(trim(@$_POST["detalle"]), true).",
                                                         fecha       =".$fecha.",
        												documento    =".$this->bd->sqlvalue_inyeccion(trim(@$_POST["documento"]), true)."
        							      WHERE id_asiento           =".$this->bd->sqlvalue_inyeccion($id, true);
        		    
        		    $this->bd->ejecutar($sql);
        		    
        		}
	       
        		
        		
        		$result = $this->div_resultado('editar',$id,1,$estado);
        		
	 	}	
		
	 	$this->apagar_asiento( $id, $aprov );
	 	
		echo $result;
	}
	
	//--------------------------------------------------------------------------------
	//--- eliminar de registros
	//--------------------------------------------------------------------------------
	function eliminar($id ){
		
	    $fecha_registro = @$_POST["fecha"];
	    $estado         = @$_POST["estado"];
	    $bandera        = 0;
	    
 		
		if ($this->bd->_cierre($fecha_registro) == 'cerrado'){
		    
		    $bandera  = -1;
		    $result   = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>PERIODO CERRADO '.$this->anio .'</b>';
		    
		}
		
		
		if ( $bandera == 0 ){
		    $this->saldos->_elimina_asiento($id,$estado);
		    $result = $this->div_limpiar();
		    
		}
	 	

		echo $result;
 		
	}

	/*
	cambio_datos
	*/
 
	function cambio_datos($id,	$estado   ){
		
 	
		if ( $estado == 'digitado'){
				$estado_cambio = 'aprobado' ;
		} else{
			  $estado_cambio = 'digitado' ;
 		} 
	    
		 
		 $sql = " UPDATE co_asiento
		 SET 	   estado    =".$this->bd->sqlvalue_inyeccion(trim($estado_cambio ), true)."
 				  WHERE id_asiento =".$this->bd->sqlvalue_inyeccion($id, true);

		$this->bd->ejecutar($sql);

 		
        $result   = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ESTADO MODIFICADO: '.	$estado .' Modificado a '.	$estado_cambio .'</b>';
	 
		echo $result;
 		
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
	  
		$gestion->consultaId($accion,$id);
	 
	 
	
}

//------ grud de datos insercion
if (isset($_POST["action"]))	{
	
	$action 	     	=     @$_POST["action"];
	
	$id 				=     @$_POST["id_asiento"];
	
	$estado             = $_POST["estado"];

 	$gestion->xcrud(trim($action) ,  $id,	$estado    );
 
	
}



?>
 
  
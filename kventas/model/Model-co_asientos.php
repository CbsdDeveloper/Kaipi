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
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function proceso( ){
		//inicializamos la clase para conectarnos a la bd
		
		$this->obj     = 	new objects;
		$this->bd	   =	new Db ;
		
		$this->ruc       =  $_SESSION['ruc_registro'];
		$this->sesion 	 =  $_SESSION['email'];
		$this->hoy 	     =  $this->bd->hoy();
		
		$this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
		
		$this->saldos     = 	new saldo_contable(  $this->obj,  $this->bd);
		
		
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
				array( campo => 'documento',     valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'tipo',     valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'detalle',  valor => '-',  filtro => 'N',   visor => 'S')
		);
		
		$datos = $this->bd->JqueryArrayVisor('co_asiento',$qquery );
 	 	 
 
	 	$result =  $this->div_resultado($accion,$id,0,$datos['estado']);
		
		echo  $result;
	}
	//--------------------------------------------------------------------------------------
	//aprobaci�n de asientos
	function aprobacion( $id  ){
	    
	    
	    $sqld = 'DELETE FROM  co_asientod
				 WHERE (coalesce(debe,0) + coalesce(haber,0)) = 0 and
                       id_asiento='.$this->bd->sqlvalue_inyeccion($id, true);
	    
	    $this->bd->ejecutar($sqld);
	    
	    $sqld = 'DELETE FROM  co_asiento_aux
				 WHERE (coalesce(debe,0) + coalesce(haber,0)) = 0 and
                       id_asiento='.$this->bd->sqlvalue_inyeccion($id, true);
	    
	    $this->bd->ejecutar($sqld);
	    
	    //------------------------------------------------------------------------
	    
		
	    $comprobante =  $this->saldos->_aprobacion($id);
	     
	    if ($comprobante <> '-')	{
	    
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
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	function agregar( ){
		
 		$id_periodo    = @$_POST["id_periodo"];
 		
		$fecha			= $this->bd->fecha(@$_POST["fecha"]);
		
		$cuenta   = @$_POST["cuenta"];
 		
		$estado        = 'digitado';
		
		//------------ seleccion de periodo
 		$periodo_s = $this->bd->query_array('co_periodo','mes,anio',
											'registro ='.$this->bd->sqlvalue_inyeccion($this->ruc ,true).' and
                                          	id_periodo='.$this->bd->sqlvalue_inyeccion($id_periodo ,true));
 		$mes  			= $periodo_s["mes"];
		$anio  			= $periodo_s["anio"];
 		
		$comprobante    = '-';
		//------------------------------------------------------------
		$sql = "INSERT INTO co_asiento(	fecha, registro, anio, mes, detalle, sesion, creacion,
                						comprobante, estado, tipo, documento,modulo,id_periodo)
										        VALUES (".$fecha.",".
										        $this->bd->sqlvalue_inyeccion($this->ruc, true).",".
										        $this->bd->sqlvalue_inyeccion($anio, true).",".
										        $this->bd->sqlvalue_inyeccion($mes, true).",".
										        $this->bd->sqlvalue_inyeccion(@$_POST["detalle"], true).",".
										        $this->bd->sqlvalue_inyeccion($this->sesion, true).",".
										        $this->hoy.",".
										        $this->bd->sqlvalue_inyeccion($comprobante, true).",".
										        $this->bd->sqlvalue_inyeccion($estado, true).",".
										        $this->bd->sqlvalue_inyeccion(@$_POST["tipo"], true).",".
										        $this->bd->sqlvalue_inyeccion(@$_POST["documento"], true).",".
										        $this->bd->sqlvalue_inyeccion('contabilidad', true).",".
										        $this->bd->sqlvalue_inyeccion($id_periodo, true).")";
        
     
		 $this->bd->ejecutar($sql);
		
          $idAsiento =  $this->bd->ultima_secuencia('co_asiento');
          
          if  ( !empty(trim($cuenta))) {
          	
          	$this->agregarDetalle( $idAsiento,trim($cuenta));
         
          }
          
              
          $result = $this->div_resultado('editar',$idAsiento,1,$estado);
 
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
		
	 	$estado        = @$_POST["estado"];
	 	
	 	$cuenta        = @$_POST["cuenta"];
		
	 	$fecha			= $this->bd->fecha(@$_POST["fecha"]);
	 	
		if (trim($estado) == 'digitado'){
			
		 			$sql = " UPDATE co_asiento
							              SET 	detalle             =".$this->bd->sqlvalue_inyeccion(trim(@$_POST["detalle"]), true).",
											    comprobante  =".$this->bd->sqlvalue_inyeccion(@$_POST["comprobante"], true).",
                                                fecha  =".$fecha.",
												 tipo                   =".$this->bd->sqlvalue_inyeccion(trim(@$_POST["tipo"]), true).",
												documento        =".$this->bd->sqlvalue_inyeccion(trim(@$_POST["documento"]), true)."
							      WHERE id_asiento           =".$this->bd->sqlvalue_inyeccion($id, true);
					
					$this->bd->ejecutar($sql);
			
					if  ( !empty(trim($cuenta))) {
						$this->agregarDetalle( $id,trim($cuenta));
					}
				
					
 			       //--------------------Realizamos un bucle para ir obteniendo los resultados*/
					$sql = 'SELECT a.id_asientod,b.aux
							     FROM co_asientod a, co_plan_ctas b
							  WHERE a.cuenta     = b.cuenta and
		                                    a.registro   ='.$this->bd->sqlvalue_inyeccion($this->ruc, true).' and
									        a.id_asiento ='.$this->bd->sqlvalue_inyeccion($id, true);
			
								$stmtD = $this->bd->ejecutar($sql);
							    
							    while ($x=$this->bd->obtener_fila($stmtD)){
				
													$id_asientod = $x['id_asientod'];
													$aux 			   = $x['aux'];
													$debe  = 0;
													$haber = 0;
													
													$odebe  = 'debe_'.$id_asientod;
													$ohaber = 'haber_'.$id_asientod;
													
													$debe  =  @$_POST[$odebe];
													$haber =  @$_POST[$ohaber];
									
									
												$sql = 'UPDATE co_asientod
														  SET   debe='.$this->bd->sqlvalue_inyeccion($debe, true).',
																   haber='.$this->bd->sqlvalue_inyeccion($haber, true).',
					 											   aux='.$this->bd->sqlvalue_inyeccion($aux, true).'
														  WHERE id_asientod='.$this->bd->sqlvalue_inyeccion($id_asientod, true);
												
									 	    $this->bd->ejecutar($sql);
		         	}
		}	
 
		//------------------------------------------------------
		$sqld = 'DELETE FROM  co_asientod
				 WHERE (coalesce(debe,0) + coalesce(haber,0)) = 0 and 
                       id_asiento='.$this->bd->sqlvalue_inyeccion($id, true);
		
		$this->bd->ejecutar($sqld);
		
		$sqld = 'DELETE FROM  co_asiento_aux
				 WHERE (coalesce(debe,0) + coalesce(haber,0)) = 0 and
                       id_asiento='.$this->bd->sqlvalue_inyeccion($id, true);
		
		$this->bd->ejecutar($sqld);
		
		$result = $this->div_resultado('editar',$id,1,$estado);
 
		echo $result;
	}
	
	//--------------------------------------------------------------------------------
	//--- eliminar de registros
	//--------------------------------------------------------------------------------
	function eliminar($id ){
		
 
		$estado      = @$_POST["estado"];
		
		 $this->saldos->_elimina_asiento($id,$estado);
		
		
		$result = $this->div_limpiar();
		
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
	
	$accion    		= $_GET['accion'];
	$id            		= $_GET['id'];
	  
		$gestion->consultaId($accion,$id);
	 
	 
	
}

//------ grud de datos insercion
if (isset($_POST["action"]))	{
	
	$action 		=     @$_POST["action"];
	
	$id 				=     @$_POST["id_asiento"];
	
 
 	$gestion->xcrud(trim($action) ,  $id  );
 
	
}



?>
 
  
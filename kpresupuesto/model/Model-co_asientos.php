<?php
session_start( );

require '../../kconfig/Db.class.php';   

require '../../kconfig/Obj.conf.php';  

 
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
		//inicializamos la clase para conectarnos a la bd
		
		$this->obj     = 	new objects;
		$this->bd	   =	new Db ;
		
		$this->ruc       =  trim($_SESSION['ruc_registro']);
		
		$this->sesion 	 =  trim($_SESSION['email']);
		
		$this->hoy 	     =  $this->bd->hoy();
 	 
		
		$this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
		
 
		
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
		
		 	
	    
	    $x = $this->bd->query_array('co_asiento','modulo,idprov', 
	        'id_asiento='.$this->bd->sqlvalue_inyeccion($id,true));
	    
	    if ( trim($x['modulo']) == 'nomina'){
	        
	      
	        $y = $this->bd->query_array('view_asientocxp_nomina','sum(haber) as monto', 
	                                   "modulo = 'N'  and cuenta like '2%'  and id_asiento=".$this->bd->sqlvalue_inyeccion($id,true));
	        
	        
	        $sql = 'update co_asiento
                       set idprov ='.$this->bd->sqlvalue_inyeccion($this->ruc,true).', 
                           apagar='.$this->bd->sqlvalue_inyeccion($y['monto'],true).'
                     WHERE id_asiento='.$this->bd->sqlvalue_inyeccion($id,true);
	        
	        $this->bd->ejecutar($sql);	
 
	            
	            
	    }else{ 
	        
	        $idprov = trim($x['idprov']);
	        
	        $this->apagar_asiento( $id, $idprov );
	        
	    }
	       
	    
	    
		$qquery = array(
				array( campo => 'id_asiento',    valor =>$id,  filtro => 'S',   visor => 'S'),
				array( campo => 'id_periodo',    valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'fecha',         valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'comprobante',   valor => '-',  filtro => 'N',   visor => 'S'),
		        array( campo => 'nomina',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'documento',     valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
		        array( campo => 'apagar',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'tipo',     valor => '-',  filtro => 'N',   visor => 'S'),
		        array( campo => 'modulo',     valor => '-',  filtro => 'N',   visor => 'S'),
		        array( campo => 'id_tramite',     valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'detalle',  valor => '-',  filtro => 'N',   visor => 'S'),
    		    array( campo => 'razon',  valor => '-',  filtro => 'N',   visor => 'S'),
    		    array( campo => 'idprov',  valor => '-',  filtro => 'N',   visor => 'S'),
		        array( campo => 'forden',  valor => '-',  filtro => 'N',   visor => 'S')		    
		);
		
 		$datos = $this->bd->JqueryArrayVisor('view_asientos_diario',$qquery );
 		
		
 		
 		
 
	 	$result =  $this->div_resultado($accion,$id,0,$datos['estado']);
		
		echo  $result;
	}
	//--------------------------------------------------------------------------------------
 
	 
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
	//--------------------------
	function apagar_asiento( $idasiento, $idprov ){
	    
	    
 
	    
	    $secuencia = $this->bd->query_array('co_asiento_aux',
	        'sum(haber)  - sum(debe) as total',
	        'idprov='.$this->bd->sqlvalue_inyeccion(trim($idprov),true)." and 
             cuenta like '21%' and
             id_asiento=".$this->bd->sqlvalue_inyeccion($idasiento,true)
	        );
	    
	    
	    $len = strlen(trim($idprov));
	    
	    $total = $secuencia['total'];
	    
		if (  $total > 0 ){
				$sql = " UPDATE co_asiento
										SET 	apagar      =".$this->bd->sqlvalue_inyeccion($total, true)."
										WHERE id_asiento   =".$this->bd->sqlvalue_inyeccion($idasiento, true);
 	 	}


		  $secuencia = $this->bd->query_array('co_asiento_aux',
	        'sum(debe) as total',
	        'idprov='.$this->bd->sqlvalue_inyeccion(trim($idprov),true)." and 
             cuenta like '112%' and
             id_asiento=".$this->bd->sqlvalue_inyeccion($idasiento,true)
	        );

			$total = $secuencia['total'];
	    

			if (  $total > 0 ){
				$sql = " UPDATE co_asiento
										SET 	apagar      =".$this->bd->sqlvalue_inyeccion($total, true)."
										WHERE id_asiento   =".$this->bd->sqlvalue_inyeccion($idasiento, true);
 	     	}

 	    
	    if ( $len > 5 ){
	        
	        $this->bd->ejecutar($sql);
	    }
	  
	    
	    
	    
	    return 1;
	    
	}
	//--------------------------------------------------------------------------------
 
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
 
  
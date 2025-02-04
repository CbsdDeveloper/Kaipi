<?php
session_start( );

require '../../kconfig/Db.class.php';    

require '../../kconfig/Obj.conf.php';  


class proceso{
 
	
	private $obj;
	private $bd;
	
	private $ruc;
	private $sesion;
	private $hoy;
	private $POST;
 
	private $tabla ;
 
	
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function proceso( ){
		 
		$this->obj     = 	new objects;
		$this->bd	   =	new Db ;
		
		$this->ruc       =  $_SESSION['ruc_registro'];
		
		$this->sesion 	 =  trim($_SESSION['email']);
		
		$this->hoy 	     =  $this->bd->hoy();
		
		$this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
		
	/*	
		$this->ATabla = array(
				array( campo => 'idproceso',   tipo => 'NUMBER',   id => '0',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'idproceso_var',   tipo => 'NUMBER',   id => '1',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
				array( campo => 'variable',   tipo => 'VARCHAR2',   id => '2',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '3',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
 				array( campo => 'tabla',   tipo => 'VARCHAR2',   id => '4',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'estado',   tipo => 'VARCHAR2',   id => '5',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'lista',   tipo => 'VARCHAR2',   id => '6',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'orden',   tipo => 'VARCHAR2',   id => '6',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N')
		);
		*/
		
		$this->tabla 	  		    = 'flow.wk_proceso_formulario';
		
	 
		
	}
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function div_resultado(){
		//inicializamos la clase para conectarnos a la bd
		
		 
 
			$resultado = '<img src="../../kimages/ksavee.png"  align="absmiddle" />&nbsp;<b>INFORMACION ACTUALIZADA DE LA TAREA</b>';
 
			
			echo "<script>tareaproceso('ok')</script>";
			
 
		
		return $resultado;
		
	}
 
	
	
	//--------------------------------------------------------------------------------
	//--- busqueda de por codigo para llenar los datos
	//--------------------------------------------------------------------------------
	function consultaId($accion,$id ){
 	
		$qquery = array(
				array( campo => 'idproceso_var',   valor =>$id,  filtro => 'S',   visor => 'S'),
				array( campo => 'idproceso',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'variable',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'tipo',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'tabla',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'orden',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'lista',   valor => '-',  filtro => 'N',   visor => 'S') 
		);
		
		$this->bd->JqueryArrayVisor('flow.wk_proceso_variables',$qquery );
 		
		$guardarAux =  $this->div_resultado($accion,$id,0);
		
		echo  $guardarAux;
	}
	
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	
	function xcrud($idtarea,$idproceso){
		
		
		
		$flujo = $this->bd->query_array('flow.wk_proceso_formulario',
				'count(idproceso_var) as nexiste',
				'idproceso='.$this->bd->sqlvalue_inyeccion($idproceso,true).' and 
                 idtarea  = '.$this->bd->sqlvalue_inyeccion($idtarea,true)
				);
 
		
		// ------------------  agregar
		if ($flujo['nexiste']== '0'){
			$this->agregar($idtarea,$idproceso);
 		}
		else 
		{
			$this->edicion($idtarea,$idproceso);
 		}
 
		
	}
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	function agregar( $idtarea,$idproceso){
	
		$sqlDepa = "SELECT idproceso, idproceso_var, variable
									  FROM flow.wk_proceso_variables
									  where estado = 'S' AND idproceso = ".$this->bd->sqlvalue_inyeccion($idproceso,true). " 
                                      order by orden";
		
		$stmt_depa= $this->bd->ejecutar($sqlDepa);
		
		
		
		while ($x=$this->bd->obtener_fila($stmt_depa)){
			
					$idproceso_var = $x['idproceso_var'];
			
					$op = 'op_'.$x['idproceso_var'];
					
					$acceso= @$_POST[$op] ;
					
					
					$InsertQuery = array( 
							array( campo => 'idproceso',   valor =>$idproceso  ),
							array( campo => 'idproceso_var',   valor => $idproceso_var ),
							array( campo => 'acceso',   valor =>$acceso),
							array( campo => 'sesion',   valor => $this->sesion  ),
							array( campo => 'idtarea',   valor => $idtarea )
					);
			
				  $this->bd->pideSq('0');
					
				  $this->bd->JqueryInsertSQL($this->tabla ,$InsertQuery);
		}
		
		//----- actualiza     condicion, siguiente,anterior
		
		if (empty( @$_POST["siguiente"] ) ) {
			$siguiente = 99;
		}else{
			$siguiente = $_POST["siguiente"];
		}
		if (empty( @$_POST["anterior"] ) ){
			$anterior= 0;
		}else{
			$anterior= $_POST["anterior"];
		}
		
		
		$UpdateQuery = array( 
				array( campo => 'idproceso',   valor => $idproceso,  filtro => 'S'),
				array( campo => 'idtarea',   valor => $idtarea,  filtro => 'S'),
				array( campo => 'condicion',   valor => $_POST["condicion"],  filtro => 'N'),
		        array( campo => 'tarea',   valor => $_POST["tarea"],  filtro => 'N'),
		    array( campo => 'notificacion',   valor => $_POST["notificacion"],  filtro => 'N'),
		    array( campo => 'tipotiempo',   valor => $_POST["tipotiempo"],  filtro => 'N'),
		    array( campo => 'tiempo',   valor => $_POST["tiempo"],  filtro => 'N'),
				array( campo => 'siguiente',   valor => $siguiente ,  filtro => 'N'),
				array( campo => 'anterior',   valor => $anterior ,  filtro => 'N')
		);
 
		$this->bd->JqueryUpdateSQL('flow.wk_procesoflujo',$UpdateQuery);
		
		
 		$guardarTarea= $this->div_resultado();
		
		echo $guardarTarea;
		
	}
	
	//--------------------------------------------------------------------------------
	//--- edicion de registros
	//--------------------------------------------------------------------------------
	function edicion($idtarea,$idproceso){
 
		
		
		$sqlDepa = "SELECT idproceso, idproceso_var, variable
					FROM flow.wk_proceso_variables
					where estado = 'S' AND 
                          idproceso = ".$this->bd->sqlvalue_inyeccion($idproceso,true). " 
                    order by orden";
		
		$stmt_depa= $this->bd->ejecutar($sqlDepa);
		
		
		
		while ($x=$this->bd->obtener_fila($stmt_depa)){
			
			$idproceso_var = $x['idproceso_var'];
			
			$op = 'op_'.$x['idproceso_var'];
			
			$acceso= @$_POST[$op] ;
			
			$UpdateQuery = array(
					array( campo => 'idproceso',   valor => $idproceso,  filtro => 'S'),
					array( campo => 'idtarea',   valor => $idtarea,  filtro => 'S'),
					array( campo => 'idproceso_var',   valor => $idproceso_var,  filtro => 'S'),
					array( campo => 'acceso',   valor => $acceso,  filtro => 'N'),
					array( campo => 'sesion',   valor =>$this->sesion  ,  filtro => 'N')
			);
			
            //-------------
 			$Avalida = $this->bd->query_array('flow.wk_proceso_formulario',
			                                  'count(*) as nn', 
			                                  'idproceso='.$this->bd->sqlvalue_inyeccion($idproceso,true).' and 
                                              idtarea='.$this->bd->sqlvalue_inyeccion($idtarea,true).' and 
                                              idproceso_var='.$this->bd->sqlvalue_inyeccion($idproceso_var,true)
			    ); 
 			
 			//----------------------------------------------------------
			if ($Avalida['nn'] == 0){
			    $InsertQuery = array(
			        array( campo => 'idproceso',   valor =>$idproceso  ),
			        array( campo => 'idproceso_var',   valor => $idproceso_var ),
			        array( campo => 'acceso',   valor =>$acceso),
			        array( campo => 'sesion',   valor => $this->sesion  ),
			        array( campo => 'idtarea',   valor => $idtarea )
			    );
			    
			    $this->bd->pideSq('0');
			    $this->bd->JqueryInsertSQL($this->tabla ,$InsertQuery);
			}else{
			    $this->bd->JqueryUpdateSQL($this->tabla,$UpdateQuery);
			}
			 
			
		}
		
		if (empty( @$_POST["siguiente"] ) ) {
			$siguiente = 99;
		}else{
			$siguiente = $_POST["siguiente"];
		}
		if (empty( @$_POST["anterior"] ) ){
			$anterior= 0;
		}else{
			$anterior= $_POST["anterior"];
		}
		
		$UpdateQuery = array(
				array( campo => 'idproceso',   valor => $idproceso,  filtro => 'S'),
				array( campo => 'idtarea',   valor => $idtarea,  filtro => 'S'),
				array( campo => 'condicion',   valor => $_POST["condicion"],  filtro => 'N'),
		         array( campo => 'tarea',   valor => $_POST["tarea"],  filtro => 'N'),
		    array( campo => 'notificacion',   valor => $_POST["notificacion"],  filtro => 'N'),
		    array( campo => 'tipotiempo',   valor => $_POST["tipotiempo"],  filtro => 'N'),
		    array( campo => 'tiempo',   valor => $_POST["tiempo"],  filtro => 'N'),
				array( campo => 'siguiente',   valor => $siguiente ,  filtro => 'N'),
				array( campo => 'anterior',   valor => $anterior ,  filtro => 'N')
		);
		$this->bd->JqueryUpdateSQL('flow.wk_procesoflujo',$UpdateQuery);
		
		$guardarTarea= $this->div_resultado();
		
		echo $guardarTarea;
		
	}
	
	//--------------------------------------------------------------------------------
	//--- eliminar de registros
	//--------------------------------------------------------------------------------
	function eliminar($id,$idproceso){
		
 		
		$sql = "SELECT publica FROM flow.wk_proceso where idproceso=".$this->bd->sqlvalue_inyeccion($idproceso,true);
		
		$resultado = $this->bd->ejecutar($sql);
		
		$datos = $this->bd->obtener_array( $resultado);
		
		if ($datos['publica'] == 'N'){
 			
			$sqlDel = "DELETE FROM flow.wk_proceso_variables  where idproceso_var=".$this->bd->sqlvalue_inyeccion($id,true);
			
			$resultado = $this->bd->ejecutar($sqlDel);
			
			$guardarAux= $this->div_resultado('eliminado',$id,1);
			
		}else{
			$guardarAux= 'No se puede eliminar el registro';
		}
	 
 
		
		echo $guardarAux;
		
	}
	
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;

//------ grud de datos insercion
if (isset($_POST["tareaid"]))	{
	
  
 	$idtarea	          =     @$_POST["tareaid"];
 	$idproceso		      =     @$_POST["procesoid"];
	
 	$gestion->xcrud($idtarea,$idproceso);
	
}
 
?>
 
  
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
	private $ATabla;
	private $tabla ;
	private $secuencia;
 
	
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
		
		$this->ATabla = array(
				array( campo => 'idproceso',   tipo => 'NUMBER',   id => '0',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'idproceso_requi',   tipo => 'NUMBER',   id => '1',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
				array( campo => 'requisito',   tipo => 'VARCHAR2',   id => '2',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'obligatorio',   tipo => 'VARCHAR2',   id => '3',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'prioridad',   tipo => 'VARCHAR2',   id => '4',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
 				array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '5',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'estado',   tipo => 'VARCHAR2',   id => '6',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N') 
		);
		
 
		$this->tabla 	  	= 'flow.wk_proceso_requisitos';
 
		$this->secuencia 	= 'flow.wk_proceso_requisitos_idproceso_requi_seq';
		
		 
	}
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function div_resultado($accion,$id,$tipo){
		//inicializamos la clase para conectarnos a la bd
		
		
		echo '<script type="text/javascript">';
		
		echo  'accion1('.$id.','. "'".$accion."'".')';
		
		echo '</script>';
		
	 
		if ($tipo == 0){
			
			if ($accion == 'editar')
				$resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>Editar registro?</b>';
				if ($accion == 'del')
					$resultado = '<img src="../kimages/kdel.png" align="absmiddle" />&nbsp;<b>Eliminar registro?</b>';
					
		}
		
		if ($tipo == 1){
			
			
			$resultado = '<img src="../../kimages/ksavee.png" align="absmiddle" />&nbsp;<b>Informacion actualizada</b> ';
			
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
				array( campo => 'idproceso_requi',   valor =>$id,  filtro => 'S',   visor => 'S'),
 				array( campo => 'requisito',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'tipo_req',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'obligatorio',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'prioridad',   valor => '-',  filtro => 'N',   visor => 'S'),				
				array( campo => 'estado_req',   valor => '-',  filtro => 'N',   visor => 'S')
		);
		
	 
		
		$this->bd->JqueryArrayVisorTab('flow.view_proceso_requisitos',$qquery ,'-' );
 		
		
 		
		$guardarRequisito=  $this->div_resultado($accion,$id,0);
		
		echo  $guardarRequisito;
	}
	
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	
	function xcrud($action,$id,$idproceso){
		
		
		// ------------------  agregar
		if ($action == 'add'){
			
			$this->agregar($idproceso);
			
		}
		
		// ------------------  editar
		if ($action == 'editar'){
			
			$this->edicion($id);
			
		}
		// ------------------  eliminar
		if ($action == 'del'){
			
			$this->eliminar($id,$idproceso);
			
		}
		
	}
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	function agregar( $idproceso){
	
		$this->ATabla[0][valor] = $idproceso;
		
		$estado   = $_POST["estado_req"];
		$tipo_req = $_POST["tipo_req"];
 		
		$this->ATabla[5][valor] = $tipo_req;
		$this->ATabla[6][valor] = $estado;
 		
		
		$id = $this->bd->_InsertSQL($this->tabla 	, $this->ATabla ,$this->secuencia );
		
		
		$guardarRequisito= $this->div_resultado('editar',$id,0);
		
		echo $guardarRequisito;
		
	}
	
	//--------------------------------------------------------------------------------
	//--- edicion de registros
	//--------------------------------------------------------------------------------
	function edicion($id  ){
		  
	    $estado   = $_POST["estado_req"];
	    $tipo_req = $_POST["tipo_req"];
	    
	    $this->ATabla[5][valor] = $tipo_req;
	    $this->ATabla[6][valor] = $estado;
 
		$id = $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
		
		$guardarRequisito= $this->div_resultado('editar',$id,1);
	 
		
		
		echo $guardarRequisito;
	}
	
	//--------------------------------------------------------------------------------
	//--- eliminar de registros
	//--------------------------------------------------------------------------------
	function eliminar($id,$idproceso){
		
 
		$sql = "SELECT publica 
                  FROM flow.wk_proceso 
                 WHERE idproceso=".$this->bd->sqlvalue_inyeccion($idproceso,true);
		
		$resultado = $this->bd->ejecutar($sql);
		
		$datos = $this->bd->obtener_array( $resultado);
		
		if ($datos['publica'] == 'N'){
			
			$sqlDel = "DELETE FROM flow.wk_proceso_requisitos  
                        WHERE idproceso_requi =".$this->bd->sqlvalue_inyeccion($id,true);
			
			$resultado = $this->bd->ejecutar($sqlDel);
			
			$guardarRequisito= $this->div_resultado('eliminado',$id,1);
			
		}else{
			$guardarRequisito= 'No se puede eliminar el registro';
		}
		
		
		
		echo $guardarRequisito;
		
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
	
	$gestion->consultaId($accion,$id);
}

//------ grud de datos insercion
if (isset($_POST["action1"]))	{
 	$action		 		= 		@$_POST["action1"];
 	$id				 	=     @$_POST["idproceso_requi"];
	$idproceso			=     @$_POST["idproceso1"];

	$gestion->xcrud( $action ,$id,$idproceso);
	
}

 

?>
 
  
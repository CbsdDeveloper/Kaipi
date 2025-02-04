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
	private $secuencia ;
 
	
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
				array( campo => 'idproceso_var',   tipo => 'NUMBER',   id => '1',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
				array( campo => 'variable',   tipo => 'VARCHAR2',   id => '2',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '3',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
 				array( campo => 'tabla',   tipo => 'VARCHAR2',   id => '4',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'estado',   tipo => 'VARCHAR2',   id => '5',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'lista',   tipo => 'VARCHAR2',   id => '6',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'orden',   tipo => 'VARCHAR2',   id => '7',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
		        array( campo => 'sistema',   tipo => 'VARCHAR2',   id => '8',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
		        array( campo => 'variable_sis',   tipo => 'VARCHAR2',   id => '9',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N')
		);
		

		
		$this->tabla 	  		    = 'flow.wk_proceso_variables';
		
		$this->secuencia 	  		= 'flow.wk_proceso_variables_idproceso_var_seq';
 
	}
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function div_resultado($accion,$id,$tipo){
		//inicializamos la clase para conectarnos a la bd
		
		
	    echo '<script type="text/javascript">'.'accion('.$id.',' . "'". $accion. "'".')'.'</script>';
		
 
	 
		if ($tipo == 0){
			
			if ($accion == 'editar')
				$resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>ACTUALIZAR REGISTRO?</b>';
				if ($accion == 'del')
					$resultado = '<img src="../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ELIMINAR REGISTRO?</b>';
					
		}
		
		if ($tipo == 1){
			
			
			$resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"  />&nbsp;<b>INFORMACION ACTUALIZADA</b>';
			
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
				array( campo => 'idproceso_var',   valor =>$id,  filtro => 'S',   visor => 'S'),
				array( campo => 'idproceso',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'variable',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'tipo_var',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'tabla',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'estado_var',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'orden',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'lista',   valor => '-',  filtro => 'N',   visor => 'S') 
		);
		
		$this->bd->JqueryArrayVisorTab('flow.view_proceso_var',$qquery,'-' );
 		
		$guardarAux =  $this->div_resultado($accion,$id,0);
		
		echo  $guardarAux;
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
		
		$this->ATabla[3][valor] = trim($_POST["tipo_var"]);
		$this->ATabla[5][valor] = trim($_POST["estado_var"]);
 
		
		
		$nombre = trim($_POST["variable"]);
		
		$variable = strtoupper(str_replace(" ","_",$nombre));
		
		$this->ATabla[9][valor] = '#'.$variable;
		
		$id = $this->bd->_InsertSQL($this->tabla,$this->ATabla,$this->secuencia);
		
		
		$guardarAux= $this->div_resultado('editar',$id,0);
		
		echo $guardarAux;
		
	}
	
	//--------------------------------------------------------------------------------
	//--- edicion de registros
	//--------------------------------------------------------------------------------
	function edicion($id  ){
 
	    $nombre = trim($_POST["variable"]);
	    
	    $this->ATabla[3][valor] = trim($_POST["tipo_var"]);
	    $this->ATabla[5][valor] = trim($_POST["estado_var"]);
	    
	    $variable = strtoupper(str_replace(" ","_",$nombre));
	    
	    $this->ATabla[9][valor] = '#'.$variable;
		
		$this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
		
		$guardarAux= $this->div_resultado('editar',$id,1);
		
		echo $guardarAux;
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

//------ poner informacion en los campos del sistema
if (isset($_GET['accion']))	{
	
	$accion    = $_GET['accion'];
	
	$id        = $_GET['id'];
	
	$gestion->consultaId($accion,$id);
}

//------ grud de datos insercion
if (isset($_POST["action"]))	{
	
	$action   	    =     @$_POST["action"];
 	$id	    	    =     @$_POST["idproceso_var"];
 	$idproceso		=     @$_POST["idproceso"];
	
	$gestion->xcrud( $action ,$id,$idproceso);
	
}

 

?>
 
  
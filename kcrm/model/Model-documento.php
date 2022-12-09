<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


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
		
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
		
		$this->ATabla = array(
				array( campo => 'idproceso',   tipo => 'NUMBER',   id => '0',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'idproceso_docu',   tipo => 'NUMBER',   id => '1',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
				array( campo => 'documento',   tipo => 'VARCHAR2',   id => '2',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '3',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'estado',   tipo => 'VARCHAR2',   id => '4',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N') 
		);
		
 
		$this->tabla 	    = 'flow.wk_proceso_documento';
		
		$this->secuencia 	= 'flow.wk_proceso_documento_idproceso_docu_seq';
		
	}
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function div_resultado($accion,$id,$tipo){
		//inicializamos la clase para conectarnos a la bd
		
		
		echo '<script type="text/javascript">';
		
		echo  'accion2('.$id.','. "'".$accion."'".')';
		
		echo '</script>';
		
	 
		if ($tipo == 0){
			
			if ($accion == 'editar')
				$resultado = '<img src="../../kimages/kedit.png"/>&nbsp;<b>Editar registro?</b><br>';
				if ($accion == 'del')
					$resultado = '<img src="../kimages/kdel.png"/>&nbsp;<b>Eliminar registro?</b><br>';
					
		}
		
		if ($tipo == 1){
			
			
			$resultado = '<img src="../../kimages/ksavee.png"/>&nbsp;<b>Informacion actualizada</b><br>';
			
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
				array( campo => 'idproceso_docu',   valor =>$id,  filtro => 'S',   visor => 'S'),
 				array( campo => 'tipo',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'documento',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S')
		);
		
 
 		
		$this->bd->JqueryArrayVisorTab('flow.wk_proceso_documento',$qquery ,'-' );
		
		
		
		$guardarDocumento=  $this->div_resultado($accion,$id,0);
		
		echo  $guardarDocumento;
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
		
		$id = $this->bd->_InsertSQL($this->tabla 	, $this->ATabla , $this->secuencia);
		
		
		$guardarDocumento= $this->div_resultado('editar',$id,0);
		
		echo $guardarDocumento;
		
	}
	
	//--------------------------------------------------------------------------------
	//--- edicion de registros
	//--------------------------------------------------------------------------------
	function edicion($id  ){
		  
 		
		$id = $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
		
		$guardarDocumento= $this->div_resultado('editar',$id,1);
  		
		echo $guardarDocumento;
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
			
			$sqlDel = "DELETE FROM flow.wk_proceso_documento  where idproceso_docu=".$this->bd->sqlvalue_inyeccion($id,true);
			
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

if (isset($_POST["action2"]))	{
 	$action		 		= 		@$_POST["action2"];
 	$id						=     @$_POST["idproceso_docu"];
	$idproceso			=     @$_POST["idproceso2"];

	$gestion->xcrud( $action ,$id,$idproceso);
	
}

 

?>
 
  
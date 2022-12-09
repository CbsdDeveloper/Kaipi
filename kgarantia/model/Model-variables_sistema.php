<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
	
	//creamos la variable donde se instanciar la clase "mysql"
	
	private $obj;
	private $bd;
	
	private $ruc;
	private $sesion;
	private $hoy;
	private $POST;
	private $secuencia;
	private $ATabla;
	private $tabla ;
 
	
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
		
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
		
		
		$this->ATabla = array(
 				array( campo => 'idvariable',   tipo => 'NUMBER',   id => '1',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
				array( campo => 'variable',   tipo => 'VARCHAR2',   id => '2',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '3',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
 				array( campo => 'tabla',   tipo => 'VARCHAR2',   id => '4',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'estado',   tipo => 'VARCHAR2',   id => '5',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'lista',   tipo => 'VARCHAR2',   id => '6',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'orden',   tipo => 'VARCHAR2',   id => '6',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
		        array( campo => 'sistema',   tipo => 'VARCHAR2',   id => '6',  add => 'S',   edit => 'N',   valor => 'S',   filtro => 'N',   key => 'N')
		);
		
		
		$this->tabla 	  		    = 'wk_variables';
		$this->secuencia	  		    = 'wk_variables_idvariable_seq';
	 
		
	}
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function div_resultado($accion,$id,$tipo){
		//inicializamos la clase para conectarnos a la bd
		
		
	    return $this->bd->resultadoCRUD('ACTUALIZACION',$accion,$id,$tipo);
		
 		
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
				array( campo => 'idvariable',   valor =>$id,  filtro => 'S',   visor => 'S'),
 				array( campo => 'variable',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'tipo',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'tabla',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'orden',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'lista',   valor => '-',  filtro => 'N',   visor => 'S') 
		);
		
		$datos = $this->bd->JqueryArrayVisor('wk_variables',$qquery );
 		
		$result =  $this->div_resultado($accion,$id,0);
		
		echo  $result;
	}
	
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	
	function xcrud($action,$id){
		
		
		// ------------------  agregar
		if ($action == 'add'){
			
			$this->agregar( );
			
		}
		
		// ------------------  editar
		if ($action == 'editar'){
			
			$this->edicion($id);
			
		}
		// ------------------  eliminar
		if ($action == 'del'){
			
			$this->eliminar($id);
			
		}
		
	}
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	function agregar(  ){
	
 		
	    $id = $this->bd->_InsertSQL($this->tabla,$this->ATabla,$this->secuencia);
 		
		$result= $this->div_resultado('editar',$id,0);
		
		echo $result;
		
	}
	
	//--------------------------------------------------------------------------------
	//--- edicion de registros
	//--------------------------------------------------------------------------------
	function edicion($id  ){
 
		
		$id = $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
		
		$result= $this->div_resultado('editar',$id,1);
		
		echo $result;
	}
	
	//--------------------------------------------------------------------------------
	//--- eliminar de registros
	//--------------------------------------------------------------------------------
	function eliminar($id){
		
 		
	    $sql = "DELETE FROM wk_variables where idvariable=".$this->bd->sqlvalue_inyeccion($id,true);
		
		$resultado = $this->bd->ejecutar($sql);
		
		 
			
		$result= $this->div_resultado('eliminado',$id,1);
			
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
	
	$accion    = $_GET['accion'];
	
	$id        = $_GET['id'];
	
	$gestion->consultaId($accion,$id);
}

//------ grud de datos insercion
if (isset($_POST["action"]))	{
	
	$action   	       = @$_POST["action"];
 	$id	    		   =     @$_POST["idvariable"];
 	
	$gestion->xcrud( $action ,$id);
	
}

 

?>
 
  
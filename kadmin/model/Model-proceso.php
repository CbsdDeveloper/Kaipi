<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
	
 	
	private $obj;
	private $bd;
	
	private $ruc;
	public  $sesion;
	public  $hoy;
 	private $ATabla;
	private $tabla ;
	private $secuencia;
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function proceso( ){

		//inicializamos la clase para conectarnos a la bd
		
		$this->obj     = 	new objects;

		$this->bd	   =	new Db ;
		
		$this->ruc       =  $_SESSION['ruc_registro'];
		
		$this->sesion 	 =  trim($_SESSION['email']);
 		
		$this->hoy 	     =  date("Y-m-d");    	 
		
		$this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
		
		
		$this->ATabla = array( 
			array( campo  => 'idproc',        tipo  => 'NUMBER',id  => '0',add  => 'N',edit => 'N',valor => '-',key  => 'S'),
			array( campo  => 'secuencia',     tipo  => 'VARCHAR2',id  => '1',add  => 'S',edit => 'S',valor => '-',key  => 'N'),
			array( campo  => 'estado',        tipo  => 'VARCHAR2',id  => '2',add  => 'S',edit => 'S',valor => '-',key  => 'N'),
			array( campo  => 'proceso',       tipo  => 'VARCHAR2',id  => '3',add  => 'S',edit => 'S',valor => '-',key  => 'N'),
			array( campo  => 'id_departamento',tipo  => 'VARCHAR2',id  => '4',add  => 'S',edit => 'S',valor => '-',key  => 'N'),
			array( campo  => 'sesion',         tipo  => 'VARCHAR2',id  => '5',add  => 'S',edit => 'N',valor => $this->sesion,key  => 'N'),
			array( campo  => 'creacion',       tipo  => 'DATE',id  => '6',add  => 'S',edit => 'N',valor => $this->hoy,key  => 'N'),
			array( campo  => 'modificacion',   tipo  => 'DATE',id  => '7',add  => 'S',edit => 'S',valor => $this->hoy,key  => 'N'),
			array( campo  => 'sesionm',        tipo  => 'VARCHAR2',id  => '8',add  => 'S',edit => 'S',valor => $this->sesion,key  => 'N'),
			array( campo  => 'modulo',        tipo  => 'VARCHAR2',id  => '9',add  => 'S',edit => 'S',valor => '-' , key=> 'N'),
			array( campo  => 'tipo',          tipo  => 'VARCHAR2',id  => '10',add  => 'S',edit => 'S',valor => '-',key  => 'N'),
		    array( campo  => 'valor',         tipo  => 'NUMBER',id  => '11',add  => 'S',edit => 'S',valor => '-',key  => 'N'),
		); 
			
			
		 
	 
 		$this->tabla 	  		    = 'planificacion.proceso';
		
		$this->secuencia 	        = 'planificacion.proceso_idproc_seq';
		
	}
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function div_resultado($accion,$id,$tipo){

		//inicializamos la clase para conectarnos a la bd


		//Mensaje de salida de sentencias con estados			

	    $resultado = 	$this->bd->resultadoCRUD($mensaje='ACTUALIZACION',
								 $accion,
								 $id,
								 $tipo,
								 $estado='X');

 		 
		
		return $resultado;
		
	}
	
/*
inicializamos la clase para conectarnos a la bd
*/
	function div_limpiar( ){
		
 		
		echo '<script type="text/javascript">';
		
		echo  'LimpiarPantalla();';
		
		echo '</script>';
		
 		
	}
/*	
 busqueda de por codigo para llenar los datos
*/
	function consultaId($accion,$id ){
		
	 
		$qquery = array(
			array( campo  => 'idproc',         valor => $id ,filtro => 'S',visor  => 'S'),

			array( campo  => 'secuencia',      valor => '-',filtro => 'N',visor  => 'S'),

			array( campo  => 'estado',         valor => '-',filtro => 'N',visor  => 'S'),

			array( campo  => 'proceso',        valor => '-',filtro => 'N',visor  => 'S'),

			array( campo  => 'modulo',        valor => '-',filtro => 'N',visor  => 'S'),

			array( campo  => 'tipo',        valor => '-',filtro => 'N',visor  => 'S'),

			array( campo  => 'id_departamento',valor => '-',filtro => 'N',visor  => 'S'),

		    array( campo  => 'valor',valor => '-',filtro => 'N',visor  => 'S')
		
		);
		
		 
		
		 $this->bd->JqueryArrayVisor($this->tabla,$qquery);
 		
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
			
			$this->edicion($id );
			
		}
		// ------------------  eliminar
		if ($action == 'del'){
			
			$this->eliminar($id );
			
		}
		
	}
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	function agregar(   ){
 
  	
		$id = $this->bd->_InsertSQL($this->tabla,$this->ATabla,$this->secuencia);
		
		$result = $this->div_resultado('editar',$id,1);
		
		echo $result;
		
	}
	//--------------------------------------------------------------------------------
	//--- edicion de registros
	//--------------------------------------------------------------------------------
	function edicion($id  ){
 		
 		
     	 $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
		
		$result = $this->div_resultado('editar',$id,1);
 
		
		echo $result  ;
	}
	
	//--------------------------------------------------------------------------------
	//--- eliminar de registros
	//--------------------------------------------------------------------------------
	function eliminar($id ){
		
	 
		 
		
 
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
	
	$gestion->consultaId($accion,trim($id));
}

//------ grud de datos insercion
if (isset($_POST["action"]))	{
	
	$action = $_POST["action"];
	
	$id =     $_POST['idproc'];
	
	$gestion->xcrud(trim($action),trim($id) );
	
}



?>
 
  
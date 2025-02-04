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
		
	}
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function div_resultado($accion,$id,$tipo,$estado){
	    
	    return  $this->bd->resultadoCRUD('ACTUALIZACION',$accion,$id,$tipo);
	    
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
				array( campo => 'secuencia',   valor =>$id,  filtro => 'S',   visor => 'S'),
				array( campo => 'tipo',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'codigo',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'activo',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'detalle',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'cuenta',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'valor1',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'parametro1',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'parametro2',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'parametro3',   valor => '-',  filtro => 'N',   visor => 'S')
		);
		
		$this->bd->JqueryArrayVisor('co_catalogo',$qquery );
 		
		$result =  $this->div_resultado($accion,$id,0,'');
		
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
		
	 
		
//		$idD = $this->bd->JqueryInsertSQL('web_producto',$InsertQuery);
		
		//------------ seleccion de periodo
		
		$result = 'NO SE PUEDE AGREGAR';
		
		echo $result;
		
	}
	
	//--------------------------------------------------------------------------------
	//--- edicion de registros
	//--------------------------------------------------------------------------------
	function edicion($id  ){
		
		
	    $accion ='editar';
	    $estado = '';
	    
		$UpdateQuery = array(
				array( campo => 'secuencia',   valor => $id ,  filtro => 'S'),
				array( campo => 'detalle',   valor => @$_POST["detalle"],  filtro => 'N'),
				array( campo => 'codigo',      valor => @$_POST["codigo"],  filtro => 'N'),
				array( campo => 'activo',      valor => @$_POST["activo"],    filtro => 'N'),
				array( campo => 'cuenta',       valor => @$_POST["cuenta"],    filtro => 'N'),
 				array( campo => 'valor1',       valor => @$_POST["valor1"],  filtro => 'N') ,
				array( campo => 'parametro1',      valor => @$_POST["parametro1"],  filtro => 'N'),
				array( campo => 'parametro2',      valor => @$_POST["parametro2"],    filtro => 'N'),
				array( campo => 'parametro3',  valor => @$_POST["parametro3"],  filtro => 'N')
		);
		
		
		$this->bd->JqueryUpdateSQL('co_catalogo',$UpdateQuery);
		
		$result =  $this->div_resultado($accion,$id,0,$estado) ;
 
		
		echo $result;
	}
	
	//--------------------------------------------------------------------------------
	//--- eliminar de registros
	//--------------------------------------------------------------------------------
	function eliminar($id ){
		
 
		$result = 'NO SE PUEDE ELIMINAR';
		
		echo $result;
		
	}
	//--------------------------------------------------------------------------------
	function CambioEstado($estado,$id ){
	    
	    
	    $sql = "update co_catalogo 
                   set activo =".$this->bd->sqlvalue_inyeccion($estado, true)." 
                where secuencia = ". $this->bd->sqlvalue_inyeccion($id, true);

 			
		$this->bd->ejecutar($sql);
		
		$mensajeEstado = 'Ok';
	    
		 echo $mensajeEstado;
	    
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
	
	if ( $accion <>  'check') {
	    $gestion->consultaId($accion,$id);
	}else{
	    $gestion->CambioEstado($_GET['estado'],$id);
	}
	
	
	
	
}

//------ grud de datos insercion
if (isset($_POST["action"]))	{
	
	$action = @$_POST["action"];
	
	$id =     @$_POST["secuencia"];
	
	$gestion->xcrud(trim($action),$id );
	
}



?>
 
  
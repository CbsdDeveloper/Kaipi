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
		//inicializamos la clase para conectarnos a la bd
		
		$this->obj     = 	new objects;
		$this->bd	   =		new Db ;
		
		$this->ruc       =  $_SESSION['ruc_registro'];
		
		$this->sesion 	 =  trim($_SESSION['email']);
		
		$this->hoy 	     =  date("Y-m-d");
		
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
		
		$this->tabla 	  	  = 'presupuesto.pre_periodo';
		
		$this->secuencia 	     = '-';
		
		$this->ATabla = array(
				array( campo => 'idperiodo',   tipo => 'NUMBER',   id => '0',  add => 'S',   edit => 'N',   visor => 'S',   valor => '-',   filtro => 'N',   key => 'S'),
				array( campo => 'fechainicial',   tipo => 'DATE',   id => '1',  add => 'S',   edit => 'S',   visor => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'fechafinal',   tipo => 'DATE',   id => '2',  add => 'S',   edit => 'S',   visor => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'detalle',   tipo => 'VARCHAR2',   id => '3',  add => 'S',   edit => 'N',   visor => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'estado',   tipo => 'VARCHAR2',   id => '4',  add => 'S',   edit => 'N',   visor => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'anio',   tipo => 'VARCHAR2',   id => '5',  add => 'S',   edit => 'N',   visor => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '6',  add => 'S',   edit => 'S',   visor => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
		        array( campo => 'sesionm',   tipo => 'VARCHAR2',   id => '7',  add => 'S',   edit => 'S',   visor => 'S',   valor => $this->sesion,   filtro => 'N',   key => 'N') 
		);
		
		 
		
	}
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function div_resultado($accion,$id,$tipo){
		//inicializamos la clase para conectarnos a la bd
		
		
		echo '<script type="text/javascript">';
		echo 'accion("'.$id.'","'.$accion.'")';
		echo '</script>';
		
		if ($tipo == 0){
			
			if ($accion == 'editar')
				$resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;  <b>EDITAR REGISTRO TRANSACCION ... PRESIONE EL ICONO DE GUARDAR PARA PROCESAR ESTA ACCION</b>';
 		    if ($accion == 'del')
				    $resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;  <b>ELIMINAR REGISTRO TRANSACCION ... PRESIONE EL ICONO DE GUARDAR PARA PROCESAR ESTA ACCION</b>';
					
		}
		
		if ($tipo == 1){
		    $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle" />&nbsp;  <b>INFORMACION GUARDADA CON EXITO... </b>';
 		}
		
		
		return $resultado;
		
	}
	
	//--------------------------------------------------------------------------------
	//--- busqueda de por codigo para llenar los datos
	//--------------------------------------------------------------------------------
	function consultaId($accion,$id ){
		
		
		$qquery = array( 
				array( campo => 'idperiodo',   valor => $id,  filtro => 'S',   visor => 'S'),
				array( campo => "fechainicial",   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'fechafinal',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'detalle',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'anio',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'tipo',   valor => '-',  filtro => 'N',   visor => 'S'),
		        array( campo => 'sesionm',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'modificacion',   valor => '-',  filtro => 'N',   visor => 'S') 
		);
		
		
		
	 
		
		
		 $this->bd->JqueryArrayVisor('presupuesto.view_periodo',$qquery);
		
		$result =  $this->div_resultado($accion,$id,0);
		
		echo  $result;
	}
	
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	
	function xcrud($action,$id,$idQuery,$visor){
		
		// ------------------  visor
		
		if ($visor == 'S'){
			
			$this->consultaId($action,$idQuery);
			
		}
		else {
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
		
		$result = $this->div_resultado('editar',$id,1) ;
		
		echo $result;
	}
	
	//--------------------------------------------------------------------------------
	//--- eliminar de registros
	//--------------------------------------------------------------------------------
	function eliminar($id ){
		
		
		$result = 'No se puede eliminar';
		
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


//------ grud de datos insercion
if (isset($_POST["action"]))	{
	
	$action 		= $_POST["action"];
	$id 			= $_POST["idperiodo"];
	$idQuery     	= $_POST['id'];
	$visor     		= $_POST['visor'];
	
	$gestion->xcrud( $action,$id,$idQuery,$visor);
	
}



?>
 
  
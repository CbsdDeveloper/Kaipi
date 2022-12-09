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

		$this->bd	   =	new Db ;
		
		$this->ruc       =  $_SESSION['ruc_registro'];
		
		$this->sesion 	 =  trim($_SESSION['email']);
 		
		$this->hoy 	     =  date("Y-m-d");    	 
		
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
		
		
		$this->ATabla = array( 
			array( campo  => 'referencia',    tipo  => 'NUMBER',id  => '0',add  => 'S',edit => 'S',valor => '-',key  => 'N'),
			array( campo  => 'partida',       tipo  => 'VARCHAR2',id  => '1',add  => 'S',edit => 'S',valor => '-',key  => 'N'),
			array( campo  => 'cpc',           tipo  => 'VARCHAR2',id  => '2',add  => 'S',edit => 'S',valor => '-',key  => 'N'),
			array( campo  => 'tipo',          tipo  => 'VARCHAR2',id  => '3',add  => 'S',edit => 'S',valor => '-',key  => 'N'),
			array( campo  => 'regimen',       tipo  => 'VARCHAR2',id  => '4',add  => 'S',edit => 'S',valor => '-',key  => 'N'),
			array( campo  => 'bid',           tipo  => 'VARCHAR2',id  => '5',add  => 'S',edit => 'S',valor => '-',key  => 'N'),
			array( campo  => 'tipo_proyecto' ,tipo  => 'VARCHAR2',id  => '6',add  => 'S',edit => 'S',valor => '-',key  => 'N'),
			array( campo  => 'tipo_producto', tipo  => 'VARCHAR2',id  => '7',add  => 'S',edit => 'S',valor => '-',key  => 'N'),
			array( campo  => 'catalogo_e',    tipo  => 'VARCHAR2',id  => '8',add  => 'S',edit => 'S',valor => '-',key  => 'N'),
			array( campo  => 'procedimiento', tipo  => 'VARCHAR2',id  => '9',add  => 'S',edit => 'S',valor => '-',key  => 'N'),
			array( campo  => 'detalle',       tipo  => 'VARCHAR2',id  => '10',add  => 'S',edit => 'S',valor => '-',key  => 'N'),
			array( campo  => 'cantidad',      tipo  => 'NUMBER',id  => '11',  add  => 'S',edit => 'S',valor => '-',key  => 'N'),
			array( campo  => 'medida',        tipo  => 'VARCHAR2',id  => '12',add  => 'S',edit => 'S',valor => '-',key  => 'N'),
			array( campo  => 'costo',          tipo  => 'NUMBER',id  => '13',add  => 'S',edit => 'S',valor => '-',key  => 'N'),
			array( campo  => 'total',          tipo  => 'NUMBER',id  => '14',add  => 'S',edit => 'S',valor => '-',key  => 'N'),
			array( campo  => 'periodo',        tipo  => 'VARCHAR2',id  => '15',add  => 'S',edit => 'S',valor => '-',key  => 'N'),
			array( campo  => 'estado',         tipo  => 'VARCHAR2',id  => '16',add  => 'S',edit => 'S',valor => '-',key  => 'N'),
			array( campo  => 'sesion',         tipo  => 'VARCHAR2',id  => '17',add  => 'S',edit => 'S',valor => $this->sesion ,key  => 'N'),
			array( campo  => 'fecha',          tipo  => 'DATE',id  => '18',   add  => 'S',edit => 'S',valor =>$this->hoy ,key  => 'N'),
			array( campo  => 'fecha_ejecuta',  tipo  => 'DATE',id  => '19',   add  => 'S',edit => 'S',valor => '-',key  => 'N'),
			array( campo  => 'fecha_final',    tipo  => 'DATE',id  => '20',   add  => 'S',edit => 'S',valor => '-',key  => 'N'),
			array( campo  => 'id_departamento',tipo  => 'NUMBER',id  => '21', add  => 'S',edit => 'S',valor => '-',key  => 'N'),
			array( campo  => 'id_pac',         tipo  => 'NUMBER',id  => '22',add  => 'N',edit => 'N',valor => '-',key  => 'S'),
			array( campo  => 'programa',       tipo  => 'VARCHAR2',id  => '23',add  => 'S',edit => 'S',valor => '-',key  => 'N'),
			array( campo  => 'clasificador',   tipo  => 'VARCHAR2',id  => '24',add  => 'S',edit => 'S',valor => '-',key  => 'N'),
			array( campo  => 'anio',           tipo  => 'VARCHAR2',id  => '25',add  => 'S',edit => 'N',valor => '-',key  => 'N'),
			array( campo  => 'partida_fin',    tipo  => 'VARCHAR2',id  => '26',add  => 'S',edit => 'N',valor => '-',key  => 'N'),
			array( campo  => 'avance',         tipo  => 'NUMBER',id  => '27',add  => 'S',edit => 'S',valor => '-',key  => 'N')

 ); 
			
			
		 
	 
 		$this->tabla 	  		    = 'adm.adm_pac';
		
		$this->secuencia 	        = 'adm.adm_pac_id_pac_seq';
		
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

                    array( campo  => 'referencia',  valor => '-',filtro => 'N',visor  => 'S'),

                    array( campo  => 'regimen',     valor => '-',filtro => 'N',visor  => 'S'),

                    array( campo  => 'tipo_producto',valor => '-',filtro => 'N',visor  => 'S'),

                    array( campo  => 'catalogo_e',   valor => '-',filtro => 'N',visor  => 'S'),

                    array( campo  => 'bid',          valor => '-',filtro => 'N',visor  => 'S'),

                    array( campo  => 'procedimiento',valor => '-',filtro => 'N',visor  => 'S'),

                    array( campo  => 'cantidad',     valor => '-',filtro => 'N',visor  => 'S'),

                    array( campo  => 'cpc',           valor => '-',filtro => 'N',visor  => 'S'),

                    array( campo  => 'tipo',          valor => '-',filtro => 'N',visor  => 'S'),

                    array( campo  => 'partida',       valor => '-',filtro => 'N',visor  => 'S'),

                    array( campo  => 'tipo_proyecto', valor => '-',filtro => 'N',visor  => 'S'),

                    array( campo  => 'medida',        valor => '-',filtro => 'N',visor  => 'S'),

                    array( campo  => 'sesion',        valor => '-',filtro => 'N',visor  => 'S'),

                    array( campo  => 'costo',          valor => '-',filtro => 'N',visor  => 'S'),

                    array( campo  => 'estado',         valor => '-',filtro => 'N',visor  => 'S'),

                    array( campo  => 'periodo',        valor => '-',filtro => 'N',visor  => 'S'),

                    array( campo  => 'detalle',        valor => '-',filtro => 'N',visor  => 'S'),

                    array( campo  => 'total',          valor => '-',filtro => 'N',visor  => 'S'),

                    array( campo  => 'id_departamento',valor => '-',filtro => 'N',visor  => 'S'),

                    array( campo  => 'fecha_final',    valor => '-',filtro => 'N',visor  => 'S'),

                    array( campo  => 'fecha',          valor => '-',filtro => 'N',visor  => 'S'),

                    array( campo  => 'fecha_ejecuta',  valor => '-',filtro => 'N',visor  => 'S'),

                    array( campo  => 'clasificador',   valor => '-',filtro => 'N',visor  => 'S'),

                    array( campo  => 'anio',           valor => '-',filtro => 'N',visor  => 'S'),

                    array( campo  => 'programa',       valor => '-',filtro => 'N',visor  => 'S'),

                    array( campo  => 'id_pac',         valor => $id,filtro => 'S',visor  => 'S'),

                    array( campo  => 'partida_fin',    valor => '-',filtro => 'N',visor  => 'S'),

                    array( campo  => 'avance',         valor => '-',filtro => 'N',visor  => 'S'),
);
		
		 
		
		$datos = $this->bd->JqueryArrayVisor($this->tabla,$qquery);
 		
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
		
	  $sql = 'delete from adm.adm_pac  where id_pac='.$this->bd->sqlvalue_inyeccion($id, true);
 					$this->bd->ejecutar($sql);
		
		
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
	
	$accion    = $_GET['accion'];
	
	$id        = $_GET['id'];
	
	$gestion->consultaId($accion,trim($id));
}

//------ grud de datos insercion
if (isset($_POST["action"]))	{
	
	$action = $_POST["action"];
	
	$id =     $_POST['id_pac'];
	
	$gestion->xcrud(trim($action),trim($id) );
	
}



?>
 
  
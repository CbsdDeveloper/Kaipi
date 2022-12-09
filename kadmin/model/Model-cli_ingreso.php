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
		
		$this->obj     = 	new objects;
		$this->bd	   =	new Db ;
		
		$this->ruc       =     $_SESSION['ruc_registro'];
		
		$this->sesion 	 =     trim($_SESSION['email']);
 		
		$this->hoy 	     =     date("Y-m-d");    	 
		
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
		
		$this->ATabla = array(
				array( campo => 'idprov',   tipo => 'VARCHAR2',   id => '0',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
				array( campo => 'razon',   tipo => 'VARCHAR2',   id => '1',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '2',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'direccion',   tipo => 'VARCHAR2',   id => '3',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'telefono',   tipo => 'VARCHAR2',   id => '4',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'correo',   tipo => 'VARCHAR2',   id => '5',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'movil',   tipo => 'VARCHAR2',   id => '6',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'idciudad',   tipo => 'NUMBER',   id => '7',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'contacto',   tipo => 'VARCHAR2',   id => '8',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'ctelefono',   tipo => 'VARCHAR2',   id => '9',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'ccorreo',   tipo => 'VARCHAR2',   id => '10',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'estado',   tipo => 'VARCHAR2',   id => '11',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'tpidprov',   tipo => 'VARCHAR2',   id => '12',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'modulo',   tipo => 'VARCHAR2',   id => '13',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'naturaleza',   tipo => 'VARCHAR2',   id => '14',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
		        array( campo => 'sesion',   tipo => 'VARCHAR2',   id => '15',  add => 'S',   edit => 'N',   valor => $this->sesion ,   filtro => 'N',   key => 'N'),
		        array( campo => 'creacion',   tipo => 'DATE',   id => '16',  add => 'S',   edit => 'N',   valor => $this->hoy,   filtro => 'N',   key => 'N'),
		        array( campo => 'modificacion',   tipo => 'DATE',   id => '17',  add => 'S',   edit => 'S',   valor =>$this->hoy,   filtro => 'N',   key => 'N'),
		        array( campo => 'msesion',   tipo => 'VARCHAR2',   id => '18',  add => 'S',   edit => 'S',   valor => $this->sesion ,   filtro => 'N',   key => 'N'),
				array( campo => 'cmovil',   tipo => 'VARCHAR2',   id => '19',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N') 
		);
		
		$this->tabla 	  		    = 'par_ciu';
		$this->secuencia 	        = '-';
		
	}
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	
	function div_resultado($accion,$id,$tipo,$estado = 'X'){
   	    
	    $resultado = $this->bd->resultadoCRUD('ACTUALIZACION',$accion,$id,$tipo,$estado);
  		
	    return $resultado ;
		
	}
	//--------------------------------------------------------------------------------
	//--- busqueda de por codigo para llenar los datos
	//--------------------------------------------------------------------------------
	function consultaId($accion,$id ){
		
 
		$qquery = array(
				array( campo => 'idprov',   valor =>$id,  filtro => 'S',   visor => 'S'),
				array( campo => 'razon',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'tipo',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'direccion',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'telefono',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'correo',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'movil',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'idciudad',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'contacto',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'ctelefono',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'ccorreo',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'tpidprov',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'modulo',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'naturaleza',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'cmovil',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'nombre',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'apellido',   valor => '-',  filtro => 'N',   visor => 'S')
		);
		
		$this->bd->JqueryArrayVisor('par_ciu',$qquery );
 		
		$result = $this->div_resultado($accion,$id,0);
		
		echo  $result;
	}
	 
	/**
	 Funcion para add, edicion, eliminar el registro
	 @return
	 **/
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
	/**
	 Funcion para agregar el registro
	 @return
	 **/
	function agregar(){
 
		$id =     $_POST["idprov"];
	 
		$id = $this->bd->_InsertSQL($this->tabla,$this->ATabla,$id);
		
		$result = $this->div_resultado('editar',$id,1);
		
		echo $result;
		
	}
	/**
	 Funcion para edicion el registro
	 @return
	 **/
	function edicion($id  ){
		
	   
     	 $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
		
 	     $result = $this->div_resultado('editar',$id,1);
 		
		echo $result  ;
	}
	
	/**
	 Funcion para eliminar el registro
	 @return
	 **/
	function eliminar( $id ){
 	    
	    
	    $x  = $this->bd->query_array('co_asiento_aux','count(*) as nn','idprov='.$this->bd->sqlvalue_inyeccion(trim($id),true)   );
	    $xx = $this->bd->query_array('presupuesto.pre_tramite','count(*) as nn','idprov='.$this->bd->sqlvalue_inyeccion(trim($id),true)   );
	    $y  = $this->bd->query_array('inv_movimiento','count(*) as nn','idprov='.$this->bd->sqlvalue_inyeccion(trim($id),true)   );
	    $z  = $this->bd->query_array('nom_personal','count(*) as nn','idprov='.$this->bd->sqlvalue_inyeccion(trim($id),true)   );
	    $w  = $this->bd->query_array('co_compras','count(*) as nn','idprov='.$this->bd->sqlvalue_inyeccion(trim($id),true)   );
	    
	    
	    $valida = $x['nn'] +  $y['nn'] +  $z['nn'] +  $w['nn'] + $xx['nn'] ;
	    
	    if ($valida == 0){
		
	        $this->bd->JqueryDeleteSQL('par_ciu','idprov='.$this->bd->sqlvalue_inyeccion(trim($id), true));	
	        
 		}
		
		$result = $this->bd->resultadoCRUD('ELIMINADO','eliminar',$id);
		
		echo $result;
		
 
	}
	
}
//------------------------------------------------------------------------
// Llama de la clase para creacion de formulario de busqueda
//------------------------------------------------------------------------

$gestion   = 	new proceso;

if (isset($_GET['accion']))	{
	
	$accion    = $_GET['accion'];
	$id        = $_GET['id'];
	
	$gestion->consultaId($accion,trim($id));
}

 

if (isset($_POST["action"]))	{
	
	$action =  $_POST["action"];
	$id     =  $_POST["idprov"];
	
	$gestion->xcrud(trim($action),trim($id) );
	
}



?>
 
  
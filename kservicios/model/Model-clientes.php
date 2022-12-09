<?php
session_start( );

require '../../kconfig/Db.class.php';    

require '../../kconfig/Obj.conf.php'; 


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
		
		$this->ruc       =     $_SESSION['ruc_registro'];
		
		$this->sesion 	 =     $_SESSION['email'];
		
		$this->hoy 	     =     date("Y-m-d");    	//$this->hoy 	     =  $this->bd->hoy();
		
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
		
		$this->ATabla = array(
				array( campo => 'idprov',   tipo => 'VARCHAR2',   id => '0',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
				array( campo => 'razon',   tipo => 'VARCHAR2',   id => '1',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '2',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'direccion',   tipo => 'VARCHAR2',   id => '3',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'telefono',   tipo => 'VARCHAR2',   id => '4',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'correo',   tipo => 'VARCHAR2',   id => '5',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'movil',   tipo => 'VARCHAR2',   id => '6',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'idciudad',   tipo => 'VARCHAR2',   id => '7',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'contacto',   tipo => 'VARCHAR2',   id => '8',  add => 'S',   edit => 'S',   valor => 'SN',   filtro => 'N',   key => 'N'),
				array( campo => 'ctelefono',   tipo => 'VARCHAR2',   id => '9',  add => 'S',   edit => 'S',   valor => '0000',   filtro => 'N',   key => 'N'),
				array( campo => 'ccorreo',   tipo => 'VARCHAR2',   id => '10',  add => 'S',   edit => 'S',   valor => 'xx@info.com',   filtro => 'N',   key => 'N'),
				array( campo => 'estado',   tipo => 'VARCHAR2',   id => '11',  add => 'S',   edit => 'S',   valor => 'S',   filtro => 'N',   key => 'N'),
				array( campo => 'tpidprov',   tipo => 'VARCHAR2',   id => '12',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'modulo',   tipo => 'VARCHAR2',   id => '13',  add => 'S',   edit => 'N',   valor => 'C',   filtro => 'N',   key => 'N'),
				array( campo => 'naturaleza',   tipo => 'VARCHAR2',   id => '14',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'sesion',   tipo => 'VARCHAR2',   id => '15',  add => 'S',   edit => 'S',   valor => $this->sesion ,   filtro => 'N',   key => 'N'),
		        array( campo => 'registro',   tipo => 'VARCHAR2',   id => '16',  add => 'S',   edit => 'S',   valor => $this->ruc ,   filtro => 'N',   key => 'N'),
		        array( campo => 'nacimiento',   tipo => 'DATE',   id => '17',  add => 'S',   edit => 'S',   valor => '-' ,   filtro => 'N',   key => 'N')
		);
		
		$this->tabla 	  	  = 'par_ciu';
		
		$this->secuencia 	     = '-';
		
	}
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function div_resultado($accion,$id,$tipo){
	    
		//inicializamos la clase para conectarnos a la bd
		
	    
	    $x = $this->bd->query_array('par_ciu',  
	        '*',                   
	        'idprov='.$this->bd->sqlvalue_inyeccion(trim($id),true)  
	        );
	    
	    
	    $idciu = $x['id_par_ciu'];
	    
		if ($tipo == 0){
			
		    echo '<script type="text/javascript">accion('.$idciu.',"'.$accion.'" );</script>';
			
			if ($accion == 'editar')
				$resultado = '<img src="../../kimages/kedit.png"/>&nbsp;<b>Editar registro?</b><br>';
				
				if ($accion == 'del')
					$resultado = '<img src="../../kimages/kdel.png"/>&nbsp;<b>Eliminar registro?</b><br>';
					
		}
		
		if ($tipo == 1){
			
		    echo '<script type="text/javascript">accion('.$idciu.',"'.$accion.'" );</script>';
			
			$resultado = '<img src="../../kimages/ksavee.png"/>&nbsp;<b>Informacion actualizada ['.$id.']</b><br>';
			
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
		
		
		$lon = strlen($id);
		if ($lon == 9 ){
			$id = '0'.$id;
		}
		if ($lon == 12 ){
			$id = '0'.$id;
		}
		
		$qquery = array(  
				array( campo => 'idprov',   valor => $id,  filtro => 'S',   visor => 'S'),
				array( campo => 'razon',   valor => '-',  filtro => 'N',   visor => 'S'),
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
				array( campo => 'naturaleza',   valor => '-',  filtro => 'N',   visor => 'S'),
		        array( campo => 'id_par_ciu',   valor => '-',  filtro => 'N',   visor => 'S'),
 				array( campo => 'cmovil',   valor => '-',  filtro => 'N',   visor => 'S')
		);
		
		 $this->bd->JqueryArrayVisor('par_ciu',$qquery );
		
		$result =  $this->div_resultado($accion,$id,0);
		
		echo  $result;
	}
	
	
	
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	
	function xcrud($action,$id){
		
		
		// ------------------  agregar
		if ($action == 'add'){
			
			$this->agregar();
			
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
	function agregar($id ){
		
 
		 
		 $this->bd->_InsertSQL($this->tabla,$this->ATabla, $id );
			
		 $result = $this->div_resultado('editar',$id,1);
			
	 
		echo $result;
		
	}
	//--------------------------------------------------------------------------------
	//--- edicion de registros
	//--------------------------------------------------------------------------------
	function edicion($id  ){
		
		
		$lon = strlen($id);
		if ($lon == 9 ){
			$id = '0'.$id;
		}
		if ($lon == 12 ){
			$id = '0'.$id;
		}
		
  		$this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
			
		$result =$this->div_resultado('editar',$id,1);
			
	 
		
		echo $result  ;
	}
	
	//--------------------------------------------------------------------------------
 	//--------------------------------------------------------------------------------
	function valida( $id){
	    
	    $x = $this->bd->query_array('par_ciu',
	        '*',
	        'idprov='.$this->bd->sqlvalue_inyeccion(trim($id),true)
	        );
	    
	    
	    $idciu = $x['id_par_ciu'];
	    
	    $AResultado = $this->bd->query_array('par_ciu',
	        'count(idprov) as nn',
	        'idprov='.$this->bd->sqlvalue_inyeccion($id,true));
	    
	    echo '<script type="text/javascript">accion('.$idciu.',"'.'edit'.'" );</script>';
	    
	    
	    return $AResultado["nn"];
	    
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
	
 
	
	$id =     @$_POST["idprov"];
	
	$a = $gestion->valida($id);
	
	if ($a == 0){
	    
	    $gestion->agregar($id);
	    
	}else {
	    
	    $result = 'Cliente ya registrado';
	    
	    echo $result;
	    
	}
	   
	
}



?>
 
  
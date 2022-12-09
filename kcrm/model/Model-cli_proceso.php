<?php
session_start( );

/*Incluimos el fichero de la clase Db*/

require '../../kconfig/Db.class.php';   

/*Incluimos el fichero de la clase objetos*/

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
 
		
		$this->obj     = 	new objects;
		
		$this->bd	   =	new Db ;
		
		$this->ruc       =     $_SESSION['ruc_registro'];
		
		$this->sesion 	 =     trim($_SESSION['email']);
 		
		$this->hoy 	     =     date("Y-m-d");     
		
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
		
		$this->ATabla = array(
				array( campo => 'idproceso',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
				array( campo => 'nombre',   tipo => 'VARCHAR2',   id => '1',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'objetivo',   tipo => 'VARCHAR2',   id => '2',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'estado',   tipo => 'VARCHAR2',   id => '3',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'fecha',   tipo => 'DATE',   id => '4',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'id_departamento',   tipo => 'NUMBER',   id => '5',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'archivo',   tipo => 'VARCHAR2',   id => '6',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '7',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'responsable',   tipo => 'VARCHAR2',   id => '8',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'alcance',   tipo => 'VARCHAR2',   id => '9',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'entrada',   tipo => 'VARCHAR2',   id => '10',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'salida',   tipo => 'VARCHAR2',   id => '11',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'indicador',   tipo => 'VARCHAR2',   id => '12',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'publica',   tipo => 'VARCHAR2',   id => '13',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'ambito',   tipo => 'VARCHAR2',   id => '14',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
		        array( campo => 'creado',   tipo => 'VARCHAR2',   id => '15',  add => 'S',   edit => 'S',   valor => $this->sesion,   filtro => 'N',   key => 'N'),
		        array( campo => 'modelador',   tipo => 'VARCHAR2',   id => '16',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
		       array( campo => 'registro',   tipo => 'VARCHAR2',   id => '17',  add => 'S',   edit => 'N',   valor => $this->ruc,   filtro => 'N',   key => 'N'),
		       array( campo => 'solicitud',   tipo => 'VARCHAR2',   id => '18',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
		       array( campo => 'macro_proceso',   tipo => 'VARCHAR2',   id => '19',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
		       array( campo => 'subproceso',   tipo => 'VARCHAR2',   id => '20',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
		       array( campo => 'disparador',   tipo => 'VARCHAR2',   id => '21',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
		       array( campo => 'legal',   tipo => 'VARCHAR2',   id => '22',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
		       array( campo => 'encuesta',   tipo => 'VARCHAR2',   id => '23',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'sesion',   tipo => 'VARCHAR2',   id => '24',  add => 'S',   edit => 'N',   valor => $this->sesion,   filtro => 'N',   key => 'N'),
		    array( campo => 'creacion',   tipo => 'DATE',   id => '25',  add => 'S',   edit => 'N',   valor => $this->hoy ,   filtro => 'N',   key => 'N'),
		    array( campo => 'sesionm',   tipo => 'VARCHAR2',   id => '26',  add => 'S',   edit => 'S',   valor => $this->sesion,   filtro => 'N',   key => 'N'),
		    array( campo => 'modificacion',   tipo => 'DATE',   id => '27',  add => 'S',   edit => 'S',   valor => $this->hoy ,   filtro => 'N',   key => 'N')
		);
		
		
		
		$this->tabla 	  	  = 'flow.wk_proceso';
		
		$this->secuencia 	  = 'flow.wk_proceso_idproceso_seq';
		
	}
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function div_resultado($accion,$id,$tipo){
		 
	    return $this->bd->resultadoCRUD('ACTUALIZACION',$accion,$id,$tipo);
		
	}
 	//--------------------------------------------------------------------------------
	//--- busqueda de por codigo para llenar los datos
	//--------------------------------------------------------------------------------
	function consultaId($accion,$id ){
		
 		
		$qquery = array( array( campo => 'idproceso',   valor => $id,  filtro => 'S',   visor => 'S'),
				array( campo => 'nombre',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'objetivo',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'fecha',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'id_departamento',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'archivo',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'tipo',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'responsable',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'alcance',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'entrada',   valor => '-',  filtro => 'N',   visor => 'S'),
		        array( campo => 'publica',   valor => '-',  filtro => 'N',   visor => 'S'),
 				array( campo => 'salida',   valor => '-',  filtro => 'N',   visor => 'S'),
		        array( campo => 'modelador',   valor => '-',  filtro => 'N',   visor => 'S'),
		        array( campo => 'solicitud',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'indicador',   valor => '-',  filtro => 'N',   visor => 'S'),
    		    array( campo => 'encuesta',   valor => '-',  filtro => 'N',   visor => 'S'),
    		    array( campo => 'disparador',   valor => '-',  filtro => 'N',   visor => 'S'),
    		    array( campo => 'macro_proceso',   valor => '-',  filtro => 'N',   visor => 'S'),
		        array( campo => 'ambito',   valor => '-',  filtro => 'N',   visor => 'S'),
    		    array( campo => 'subproceso',   valor => '-',  filtro => 'N',   visor => 'S'),
    		    array( campo => 'legal',   valor => '-',  filtro => 'N',   visor => 'S')
 		);
		
		
		
		
		$this->bd->JqueryArrayVisor('flow.wk_proceso',$qquery );
 		
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
	function agregar( ){
 
 		
		$procesado              = $_POST["archivo"];
		
		$this->ATabla[4][valor] =  $this->hoy 	 ;
		$this->ATabla[6][valor] =  $procesado;
		
		$this->ATabla[13][valor] = 'N';
		
		if ($procesado <> 'NO'){
		
		    $id = $this->bd->_InsertSQL($this->tabla,$this->ATabla,$this->secuencia);
			
			$result = $this->div_resultado('editar',$id,1);
		
		}else{
			$result = 'No se pudo completar el proceso...  datos [ '.$procesado.']';
			
		}
		echo $result;
		
	}
	//--------------------------------------------------------------------------------
	//--- edicion de registros
	//--------------------------------------------------------------------------------
	function edicion($id  ){
		
		$procesado = @$_POST["archivo"];
		
		//$publica = @$_POST["publica"];
		
		
		$this->ATabla[4][valor] =  $this->hoy 	 ;
		$this->ATabla[6][valor] = $procesado;
		
		$result = 'No se puede actualizar el proceso ya aprobado ... [ '.$id.']';
		
 		
		if ($procesado <> 'NO'){
			
		   
		      
		        $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
		       
 		        
		        $result =$this->div_resultado('editar',$id,1);
		        
	 
		 	
	 		
		}else{
			$result = 'No se pudo completar el proceso...  datos [ '.$procesado.']';
			
		}
 
		
		echo $result  ;
	}
	
	//--------------------------------------------------------------------------------
	//--- eliminar de registros
	//--------------------------------------------------------------------------------
	function eliminar($id ){
		
	   /*	 
 				    $sql = 'delete from par_ciu  where idprov='.$this->bd->sqlvalue_inyeccion($id, true);
 					$this->bd->ejecutar($sql);
 					
	                $result =  $this->bd->resultadoCRUD('ELIMINADO','',$id,'');
	    
	                echo $result;
		
		*/
 
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

//------ crud de datos insercion

if (isset($_POST["action"]))	{
	
	$action = @$_POST["action"];
 	$id =     @$_POST["idproceso"];
 	
    $gestion->xcrud(trim($action),$id);
	
}



?>
 
  
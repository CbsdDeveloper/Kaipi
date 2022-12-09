<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
	
	//creamos la variable donde se instanciar la clase "mysql"
	
	private $obj;
	private $bd;
	
	private $ruc;
	public  $sesion;
	public  $hoy;
	private $POST;
	private $ATabla;
	private $tabla ;
	private $secuencia;
	
	private $estado_periodo;
	
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function proceso( ){
		//inicializamos la clase para conectarnos a la bd
		
		$this->obj     = 	new objects;
		$this->bd	   =	new Db ;
		
		$this->ruc       =     $_SESSION['ruc_registro'];
		
		$this->sesion 	 =     $_SESSION['email'];
		
		$this->hoy 	     =     date("Y-m-d");     
		
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
		
		$this->ATabla = array(
		    array( campo => 'id_par_modulo',   tipo => 'NUMBER',   id => '0',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
		    array( campo => 'fid_par_modulo',   tipo => 'NUMBER',   id => '1',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'modulo',   tipo => 'VARCHAR2',   id => '2',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'estado',   tipo => 'VARCHAR2',   id => '3',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'vinculo',   tipo => 'VARCHAR2',   id => '4',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'publica',   tipo => 'VARCHAR2',   id => '5',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'script',   tipo => 'VARCHAR2',   id => '6',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '7',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'ruta',   tipo => 'VARCHAR2',   id => '8',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'accion',   tipo => 'VARCHAR2',   id => '9',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'detalle',   tipo => 'VARCHAR2',   id => '10',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'logo',   tipo => 'VARCHAR2',   id => '11',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N')
		);
		
		$this->tabla 	  	  = 'par_modulos';
		
		$this->secuencia 	     = '-';
		
	}
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function div_resultado($accion,$id,$tipo){
		//inicializamos la clase para conectarnos a la bd
		
		if ($tipo == 0){
			
			echo '<script type="text/javascript">accion('.$id.',"'.$accion.'" );</script>';
			
			if ($accion == 'editar')
				$resultado = '<img src="../../kimages/kedit.png"/>&nbsp;<b>Editar registro?</b><br>';
				
				if ($accion == 'del')
					$resultado = '<img src="../../kimages/kdel.png"/>&nbsp;<b>Eliminar registro?</b><br>';
					
		}
		
		if ($tipo == 1){
			
			echo '<script type="text/javascript">accion('.$id.',"'.$accion.'" );</script>';
			
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
		
 
	    $qquery = array( 
	        array( campo => 'id_par_modulo',   valor => $id,  filtro => 'S',   visor => 'S'),
	        array( campo => 'fid_par_modulo',   valor => '-',  filtro => 'N',   visor => 'S'),
	        array( campo => 'modulo',   valor => '-',  filtro => 'N',   visor => 'S'),
	        array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
	        array( campo => 'vinculo',   valor => '-',  filtro => 'N',   visor => 'S'),
	        array( campo => 'publica',   valor => '-',  filtro => 'N',   visor => 'S'),
	        array( campo => 'script',   valor => '-',  filtro => 'N',   visor => 'S'),
	        array( campo => 'tipo',   valor => '-',  filtro => 'N',   visor => 'S'),
	        array( campo => 'ruta',   valor => '-',  filtro => 'N',   visor => 'S'),
	        array( campo => 'accion',   valor => '-',  filtro => 'N',   visor => 'S'),
	        array( campo => 'detalle',   valor => '-',  filtro => 'N',   visor => 'S'),
	        array( campo => 'logo',   valor => '-',  filtro => 'N',   visor => 'S') 
	    );
		
	      
	    
	      
	      $datos = $this->bd->JqueryArrayVisor('par_modulos',$qquery );
	      
	  
		
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
 
			
			$id = $this->bd->_InsertSQL($this->tabla,$this->ATabla, '-' );
			
			$result = $this->div_resultado('editar',$id,1);
			
		 
 
	 
		echo $result;
		
	}
	//--------------------------------------------------------------------------------
	//--- edicion de registros
	//--------------------------------------------------------------------------------
	function edicion($id  ){
		
		         
	        $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
	        
	        $result =$this->div_resultado('editar',$id,1);
	     
	 
		
		echo $result  ;
	}
	
	//--------------------------------------------------------------------------------
	//--- eliminar de registros
	//--------------------------------------------------------------------------------
	function eliminar($id ){
		
		/*	if (strlen(trim($id)) == 9){
		 $id = '0'.$id;
		 }
		 if (strlen(trim($id)) == 12){
		 $id = '0'.$id;
		 }
		 
		 $sql = "SELECT count(*) as nro_registros
		 FROM co_asiento_aux
		 where idprov = ".$this->bd->sqlvalue_inyeccion($id ,true);
		 
		 $resultado = $this->bd->ejecutar($sql);
		 
		 $datos_valida = $this->bd->obtener_array( $resultado);
		 
		 if ($datos_valida['nro_registros'] == 0){
		 
		 $sql = 'delete from par_ciu  where idprov='.$this->bd->sqlvalue_inyeccion($id, true);
		 $this->bd->ejecutar($sql);
		 }
		 
		 $result = $this->div_limpiar();
		 
		 echo $result;
		 */
		
	}
	//---------------------------------------
  
  //------------------------------
 
	//------------------------------
	 
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
	
	$action = @$_POST["action"];
	
	$id =     @$_POST["id_par_modulo"];
	
	$gestion->xcrud(trim($action),$id);
	
}



?>
 
  
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
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function proceso( ){
		//inicializamos la clase para conectarnos a la bd
		
		$this->obj     = 	new objects;
		$this->bd	   =	new Db ;
		
		$this->ruc       =     $_SESSION['ruc_registro'];
		
		$this->sesion 	 =  $_SESSION['email'];
 		
		$this->hoy 	     =  date("Y-m-d");    	//$this->hoy 	     =  $this->bd->hoy();
		
		$this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
		
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
				array( campo => 'sesion',   tipo => 'VARCHAR2',   id => '15',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'creacion',   tipo => 'DATE',   id => '16',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'modificacion',   tipo => 'DATE',   id => '17',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'msesion',   tipo => 'VARCHAR2',   id => '18',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'cmovil',   tipo => 'VARCHAR2',   id => '19',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N') 
		);
		
		$this->tabla 	  		    = 'par_ciu';
		
		$this->secuencia 	     = '-';
		
	}
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function div_resultado($accion,$id,$tipo){
		//inicializamos la clase para conectarnos a la bd
 		
		echo '<script type="text/javascript">accion('.$id.',"'.$accion.'","'.$estado.'"  );</script>';
		$resultado = '<img src="../../kimages/kfav.png" align="absmiddle" />&nbsp;<b>ACTUALIZANDO INFORMACION</b><br>';
		
		
		if ($tipo == 0){
			
			if ($accion == 'editar')
			    $resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>EDITAR REGISTRO TRANSACCION ?</b>';
			    if ($accion == 'del')
			        $resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ELIMINAR REGISTRO TRANSACCION ?</b>';
		}
		if ($tipo == 1){
 			
		    $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO ['.$id.']</b>';
		    
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
		
		if (strlen(trim($id)) == 9){
			$id = '0'.$id;
		}
		if (strlen(trim($id)) == 12){
			$id = '0'.$id;
		} 
		
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
		
		$datos = $this->bd->JqueryArrayVisor('par_ciu',$qquery );
 		
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
	    
	    $id =     @$_POST["idprov"];
	    
	    
	    $AValida = $this->bd->query_array('par_ciu',
	                                         'count(idprov) as nproveedor', 
	                                         'idprov='.$this->bd->sqlvalue_inyeccion($id,true)
	                                       );
	    
	 
 
	    if ($AValida["nproveedor"] == 0 ){
	        
	        $this->ATabla[13][valor] ='P' ;
	        $this->ATabla[17][valor] =  $this->hoy 	 ;
	        $this->ATabla[18][valor] = $this->sesion ;
	        
	        $this->ATabla[16][valor] =  $this->hoy 	 ;
	        $this->ATabla[15][valor] = $this->sesion ;
	        
	        $this->bd->_InsertSQL($this->tabla,$this->ATabla,$id);
	        
	        $result = $this->div_resultado('editar',$id,1);
	        
	    }else{
	        $result = '<img src="../../kimages/kfav.png" align="absmiddle"/>&nbsp;<b>YA SE ENCUENTRA INGRESADA LA INFORMACION  ['.$id.']</b>';
	    }
        		
        		
		
		echo $result;
		
	}
	//--------------------------------------------------------------------------------
	//--- edicion de registros
	//--------------------------------------------------------------------------------
	function edicion($id  ){
		
		if (strlen(trim($id)) == 9){
			$id = '0'.$id;
		}
		if (strlen(trim($id)) == 12){
			$id = '0'.$id;
		} 
		
		$this->ATabla[17][valor] =  $this->hoy 	 ;
		$this->ATabla[18][valor] = $this->sesion ;
	
		
 		
     	$this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
		
		$result = $this->div_resultado('editar',$id,1);
 
		
		echo $result  ;
	}
	
	//--------------------------------------------------------------------------------
	//--- eliminar de registros
	//--------------------------------------------------------------------------------
	function eliminar($id ){
		
		if (strlen(trim($id)) == 9){
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
	
	$action = @$_POST["action"];
	
	$id =     @$_POST["idprov"];
	
	$gestion->xcrud(trim($action),$id );
	
}



?>
 
  
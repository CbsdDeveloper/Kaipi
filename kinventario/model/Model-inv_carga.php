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
		
		$this->hoy 	     =     date("Y-m-d");    	//$this->hoy 	     =  $this->bd->hoy();
		
		$this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
		
		$this->ATabla = array(
				array( campo => 'id_cmovimiento',   tipo => 'VARCHAR2',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
				array( campo => 'fecha',   tipo => 'DATE',   id => '1',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'registro',   tipo => 'VARCHAR2',   id => '2',  add => 'S',   edit => 'N',   valor => $this->ruc,   filtro => 'N',   key => 'N'),
				array( campo => 'detalle',   tipo => 'VARCHAR2',   id => '3',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'sesion',   tipo => 'VARCHAR2',   id => '4',  add => 'S',   edit => 'N',   valor => $this->sesion ,   filtro => 'N',   key => 'N'),
				array( campo => 'creacion',   tipo => 'DATE',   id => '5',  add => 'S',   edit => 'N',   valor => $this->hoy,   filtro => 'N',   key => 'N'),
				array( campo => 'comprobante',   tipo => 'VARCHAR2',   id => '6',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'estado',   tipo => 'VARCHAR2',   id => '7',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '8',  add => 'S',   edit => 'N',   valor => 'I',   filtro => 'N',   key => 'N'),
				array( campo => 'id_periodo',   tipo => 'NUMBER',   id => '9',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'documento',   tipo => 'VARCHAR2',   id => '10',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'idprov',   tipo => 'VARCHAR2',   id => '11',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'id_asiento_ref',   tipo => 'NUMBER',   id => '12',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'fechaa',   tipo => 'DATE',   id => '13',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
		        array( campo => 'transaccion',   tipo => 'VARCHAR2',   id => '14',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'  ),
		        array( campo => 'carga',   tipo => 'NUMBER',   id => '15',  add => 'S',   edit => 'N',   valor => 1,   filtro => 'N',   key => 'N'  )
  		    
		);
		
		$this->tabla 	  	  = 'inv_carga_movimiento';
		
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
		    array( campo => 'id_cmovimiento',   valor => $id,  filtro => 'S',   visor => 'S'),
		    array( campo => 'fecha',   valor => '-',  filtro => 'N',   visor => 'S'),
		    array( campo => 'fechaa',   valor => '-',  filtro => 'N',   visor => 'S'),
 		    array( campo => 'detalle',   valor => '-',  filtro => 'N',   visor => 'S'),
 		    array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S') 
  		);
		
		$datos = $this->bd->JqueryArrayVisor('inv_carga_movimiento',$qquery );
		
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
		
		$fecha =  $_POST["fecha"];
		
		$idperiodo = $this->periodo($fecha);
		
		$this->ATabla[9][valor] =  $idperiodo;
	 
		
		$result = $this->estado_periodo ;
		
 
		if ( $this->estado_periodo == 'abierto' ){
			
			$id = $this->bd->_InsertSQL($this->tabla,$this->ATabla, '-' );
			
			$result = $this->div_resultado('editar',$id,1);
	 	
		}else{
			
			$result = 'Periodo que desea generar no esta abierto... aperture desde contabilidad';
	
		}
 
	 
		echo $result;
		
	}
	//--------------------------------------------------------------------------------
	//--- edicion de registros
	//--------------------------------------------------------------------------------
	function edicion($id  ){
		
		
	    $estado =  $_POST["estado"];
	    
	    if ($estado == 'digitado') {
	          
	         $result =$this->div_resultado('editar',$id,1);
	        
	 	       
	    }
   		
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
	function periodo($fecha ){
		
		$anio = substr($fecha, 0, 4);
		$mes  = substr($fecha, 5, 2);
		
		$APeriodo = $this->bd->query_array('co_periodo',
				'id_periodo, estado',
				'registro='.$this->bd->sqlvalue_inyeccion($this->ruc,true). ' AND
											  mes = '.$this->bd->sqlvalue_inyeccion($mes,true). ' AND
											  anio ='.$this->bd->sqlvalue_inyeccion($anio,true)
				);
		
 
		$this->estado_periodo = trim($APeriodo['estado']);
		
		return $APeriodo['id_periodo'];
		
	}
	//-------------
	function AprobarComprobante($accion,$id,$tipo){
	    
	    $hoy = date("Y-m-d");
	    
	    $fechaa		 = $this->bd->fecha($hoy);
	    
	    $estado = 'aprobado';
	    
	    $comprobante = 'OK-'.$hoy;
	        
	     $sql = " UPDATE inv_carga_movimiento
						   SET 	estado=".$this->bd->sqlvalue_inyeccion($estado, true).",
								fechaa=".$fechaa."
						 WHERE id_cmovimiento=".$this->bd->sqlvalue_inyeccion($id, true);
	        
	      $resultado = $this->bd->ejecutar($sql);
	        
	      echo '<script type="text/javascript">acciona('.$comprobante.',"'.$estado.'" );</script>';
	        
	       $resultado = '<img src="../../kimages/ksavee.png"/>&nbsp;<b>Comprobante Autorizado ['.$id.']</b><br>';
	        
	        
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
	
	$tipo      = $_GET['tipo'];
	
	if ($accion == 'aprobacion'){
	    
	    $gestion->AprobarComprobante($accion,$id,$tipo);
	
	}else{
	
	    $gestion->consultaId($accion,$id);
	
	}
	  
	
	
	
}

//------ grud de datos insercion
if (isset($_POST["action"]))	{
	
	$action = @$_POST["action"];
	
	$id =     @$_POST["id_cmovimiento"];
	
	$gestion->xcrud(trim($action),$id);
	
}



?>
 
  
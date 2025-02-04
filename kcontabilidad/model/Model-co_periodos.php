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
		$this->sesion 	 =     $_SESSION['email'];
 		$this->hoy 	     =      date("Y-m-d");    	//$this->hoy 	     =  $this->bd->hoy();
		
		$this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
		
		$this->ATabla = array(
				array( campo => 'id_periodo',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
				array( campo => 'mes',   tipo => 'NUMBER',   id => '1',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'anio',   tipo => 'NUMBER',   id => '2',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'sesion',   tipo => 'VARCHAR2',   id => '3',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'creacion',   tipo => 'DATE',   id => '4',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'sesionm',   tipo => 'VARCHAR2',   id => '5',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'modificacion',   tipo => 'DATE',   id => '6',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'mesc',   tipo => 'VARCHAR2',   id => '7',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'estado',   tipo => 'VARCHAR2',   id => '8',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'registro',   tipo => 'VARCHAR2',   id => '9',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
		);
		
		$this->tabla 	  		    = 'co_periodo';
		
		$this->secuencia 	     = '-';
		
	}
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function div_resultado($accion,$id,$tipo){
		//inicializamos la clase para conectarnos a la bd
 		
		echo '<script type="text/javascript">accion('.$id.',"'.$accion.'","'.$estado.'"  );</script>';
 		
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
		
		 	
		$qquery = array(
				array( campo => 'id_periodo',   valor =>$id,  filtro => 'S',   visor => 'S'),
				array( campo => 'registro',   valor => $this->ruc ,  filtro => 'S',   visor => 'N'),
				array( campo => 'anio',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'mes',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'sesion',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'creacion',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'sesionm',   valor => '-',  filtro => 'N',   visor => 'S'),
 				array( campo => 'modificacion',   valor => '-',  filtro => 'N',   visor => 'S')
		);
		
		$datos = $this->bd->JqueryArrayVisor('co_periodo',$qquery );
 		
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
		
		$mes  =  @$_POST["mes"];
		$anio =  @$_POST["anio"];
		
		$mesc = $this->obj->var->_mes($mes);
		
		$this->ATabla[3][valor] =$this->sesion ;
		$this->ATabla[4][valor] =  $this->hoy 	 ;
		$this->ATabla[6][valor] =  $this->hoy 	 ;
		$this->ATabla[5][valor] =$this->sesion ;
		$this->ATabla[9][valor] = $this->ruc ;
		$this->ATabla[7][valor] = $mesc;
		
		$x = $this->bd->query_array('co_periodo',
		    'count(*) as nn',
		    'registro='.$this->bd->sqlvalue_inyeccion($this->ruc,true) . ' and '.
		    'anio='.$this->bd->sqlvalue_inyeccion($anio,true) . ' and '.
		    'mes='.$this->bd->sqlvalue_inyeccion($mes,true)
		    );
		
		
		if ( $x['nn']  > 0 ){
		    
	 
		    $result = ' Periodo ya generado ';
		    
		}else{
 
        		
        		$id = $this->bd->_InsertSQL($this->tabla,$this->ATabla,$this->secuencia);
        		
        		$result = $this->div_resultado('editar',$id,1);
        
		}
		
		echo $result;
		
	}
	//--------------------------------------------------------------------------------
	//--- edicion de registros
	//--------------------------------------------------------------------------------
	function edicion($id  ){
		
		$this->ATabla[5][valor] = $this->sesion ;
		$this->ATabla[6][valor] =  $this->hoy 	 ;
		
 		
     	$id = $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
		
		$result = $this->div_resultado('editar',$id,1);
 
		
		echo $result  ;
	}
	
	//--------------------------------------------------------------------------------
	//--- eliminar de registros
	//--------------------------------------------------------------------------------
	function eliminar($id ){
		
 
		$result = 'NO SE PUEDE ELIMINAR';
		
		echo $result;
		
	}
	//----------------------
	function cierre($anio ){
	    
 
	    
	    $sql = 'update  co_periodo 
                   set  estado='.$this->bd->sqlvalue_inyeccion('cerrado', true).
                'WHERE  registro= '.$this->bd->sqlvalue_inyeccion($this->ruc, true). ' and 
                        anio = '.$this->bd->sqlvalue_inyeccion($anio, true);

	  $this->bd->ejecutar($sql);
	    
	    
	  $result = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>TODOS LOS PERIODOS DEL PERIODO '.$anio.' ESTAN CERRADOS  </b>';
	    
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
	
	if ( $accion == 'cierre'){
	    
	    $anio        = $_GET['anio'];
	    
	    $gestion->cierre($anio);
	    
	}else{
	    
	    $gestion->consultaId($accion,$id);
	    
	}
	
}

//------ grud de datos insercion
if (isset($_POST["action"]))	{
	
	$action = @$_POST["action"];
	
	$id =     @$_POST["id_periodo"];
	
	$gestion->xcrud(trim($action),$id );
	
}



?>
 
  
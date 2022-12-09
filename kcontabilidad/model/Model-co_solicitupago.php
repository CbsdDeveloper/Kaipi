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
		
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
		
		
		$this->ATabla = array(
				array( campo => 'fecha',   tipo => 'DATE',   id => '0',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'registro',   tipo => 'VARCHAR2',   id => '1',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'anio',   tipo => 'NUMBER',   id => '2',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'mes',   tipo => 'NUMBER',   id => '3',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'detalle',   tipo => 'VARCHAR2',   id => '4',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'sesion',   tipo => 'VARCHAR2',   id => '5',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'comprobante',   tipo => 'VARCHAR2',   id => '6',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'estado',   tipo => 'VARCHAR2',   id => '7',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'idprov',   tipo => 'VARCHAR2',   id => '8',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'estado_pago',   tipo => 'VARCHAR2',   id => '9',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'apagar',   tipo => 'NUMBER',   id => '10',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'dia',   tipo => 'NUMBER',   id => '11',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'faprueba',   tipo => 'DATE',   id => '12',  add => 'N',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'sesiona',   tipo => 'VARCHAR2',   id => '13',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'asunto',   tipo => 'VARCHAR2',   id => '14',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'sesionr',   tipo => 'VARCHAR2',   id => '15',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'id_solpagos',   tipo => 'NUMBER',   id => '16',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
		);
		
  
		
		$this->tabla 	  		    = 'co_solpagos';
		
		$this->secuencia 	     = '-';
		
	}
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function div_resultado($accion,$id,$tipo,$estado){
		//inicializamos la clase para conectarnos a la bd
 		
		echo '<script type="text/javascript">accion('.$id.',"'.$accion.'","'.$estado.'"  );</script>';
 		
		if ($tipo == 0){
			
			if ($accion == 'editar')
				$resultado = '<img src="../../kimages/kedit.png"/>&nbsp;<b>Editar registro?</b><br>';
				if ($accion == 'del')
					$resultado = '<img src="../../kimages/kdel.png"/>&nbsp;<b>Eliminar registro?</b><br>';
					
		}
		
		if ($tipo == 1){
			
			
			$resultado = '<img src="../../kimages/ksavee.png"/>&nbsp;<b>Informacion actualizada</b><br>';
			
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
 
		 
		$fecha  =  @$_POST["fecha"];
		
		$afecha = explode("-", $fecha);
		
		
		$this->ATabla[0][valor] = $fecha;
		$this->ATabla[1][valor] =  $this->ruc   ;
		
		$this->ATabla[2][valor] = (int) $afecha[0];
		$this->ATabla[3][valor] = (int) $afecha[1];
		$this->ATabla[11][valor]= (int) $afecha[2];
		
		$this->ATabla[7][valor] ='Pendiente' ;
		$this->ATabla[9][valor] ='N' ;
		
		$this->ATabla[5][valor] =  $this->sesion ;
		
		
		$this->ATabla[4][valor] =  $_POST["detalle"];
		
	  
		
		$id = $this->bd->_InsertSQL($this->tabla,$this->ATabla,$this->secuencia);
		
		$result =  $this->div_resultado('editar',$id,1,'Pendiente');
		
		echo $result;
		
	}
	//--------------------------------------------------------------------------------
	//--- edicion de registros
	//--------------------------------------------------------------------------------
	function edicion($id  ){
		
		 
		
		$this->ATabla[4][valor] =  $_POST["detalle"];
		
		$estado =  $_POST["estado"];
		
 		
        $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
	 
        $result =  $this->div_resultado('editar',$id,1,$estado);
   
		
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
	
	function consultaId($accion,$id ){
		
		
		$qquery = array( 
				array( campo => 'fecha',   valor => '-',  filtro => 'N',   visor => 'S'),
  				array( campo => 'detalle',   valor => '-',  filtro => 'N',   visor => 'N'),
				array( campo => 'sesion',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'comprobante',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'idprov',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'estado_pago',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'txtidprov',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'apagar',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'dia',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'faprueba',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'sesiona',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'asunto',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'id_solpagos',   valor => $id,  filtro => 'S',   visor => 'S'),
				array( campo => 'sesionr',   valor => '-',  filtro => 'N',   visor => 'S') 
		);
		
		$datos = $this->bd->JqueryArrayVisor('view_pagos',$qquery );
		
	 	
		$result =  $this->div_resultado($accion,$id,0,trim($datos['estado']));
		
		//$datos['detalle']
		
		$editor = $this->bd->query_array('view_pagos',
				'detalle',
				'id_solpagos='.$this->bd->sqlvalue_inyeccion($id,true)
				);
		
		 
		echo '<script type="text/javascript">'.
			" 	jQuery('#detalle').data('wysihtml5').editor.setValue('".$editor['detalle']."');".
        		  '</script>';
		
		echo  $result;
		
		 
		
		
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
	
	$id =     @$_POST["id_solpagos"];
	
	$gestion->xcrud(trim($action),$id );
	
}



?>
 
  
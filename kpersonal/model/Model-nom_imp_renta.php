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
		
		$this->sesion 	 =  $_SESSION['email'];
 		
		$this->hoy 	     =  date("Y-m-d");    	 
		
		$this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
		
		
		$this->ATabla = array( 
		array( campo  => 'id',tipo  => 'NUMBER',id  => '0',add  => 'S',edit => 'N',valor => '-',key  => 'S'),
		array( campo  => 'anio',tipo  => 'NUMBER',id  => '1',add  => 'S',edit => 'S',valor => '-',key  => 'N'),
		array( campo  => 'tipo',tipo  => 'NUMBER',id  => '2',add  => 'S',edit => 'S',valor => '-',key  => 'N'),
		array( campo  => 'fracbasica',tipo  => 'NUMBER',id  => '3',add  => 'S',edit => 'S',valor => '-',key  => 'N'),
		array( campo  => 'excehasta',tipo  => 'NUMBER',id  => '4',add  => 'S',edit => 'S',valor => '-',key  => 'N'),
		array( campo  => 'impubasico',tipo  => 'NUMBER',id  => '5',add  => 'S',edit => 'S',valor => '-',key  => 'N'),
		array( campo  => 'impuexcedente',tipo  => 'NUMBER',id  => '6',add  => 'S',edit => 'S',valor => '-',key  => 'N')
 		); 
			
			
		 
	 
 		$this->tabla 	  		    = 'nom_imp_renta';
		
		$this->secuencia 	        = '-';
		
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
				array( campo  => 'id',           valor => $id, filtro => 'S',visor  => 'S'),

				array( campo  => 'anio',         valor => '-', filtro => 'N',visor  => 'S'),

				array( campo  => 'tipo',         valor => '-', filtro => 'N',visor  => 'S'),

				array( campo  => 'fracbasica',   valor => '-', filtro => 'N',visor  => 'S'),
 
				array( campo  => 'excehasta',    valor => '-', filtro => 'N',visor  => 'S'),

				array( campo  => 'impubasico',   valor => '-', filtro => 'N',visor  => 'S'),

				array( campo  => 'impuexcedente',valor => '-', filtro => 'N',visor  => 'S')
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

 
  		$id=$_POST['id'];

		$id = $this->bd->_InsertSQL($this->tabla,$this->ATabla,$id);
		
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
		
		  $sql = 'delete from nom_imp_renta  where id='.$this->bd->sqlvalue_inyeccion($id, true);
 					$this->bd->ejecutar($sql);
		
		
		$result = $this->div_limpiar();
		
		echo $result;
		
		
 
	}
	//-------------
	function cambio_anio( $banio ){
		
	 
		$anio  =  $banio  - 1;

		$datos = $this->bd->query_array('nom_imp_renta',
								  'max(id) as id', 
								  '1='.$this->bd->sqlvalue_inyeccion(1,true)
		);


		$datos_periodo = $this->bd->query_array('nom_imp_renta',
								  'count(*) as nn', 
								  'anio='.$this->bd->sqlvalue_inyeccion( $banio ,true)
		);



		$contador = $datos['id'] + 2;

		$sql1 = 'SELECT id, anio, tipo, fracbasica, excehasta, impubasico, impuexcedente
				   FROM nom_imp_renta
				  where anio = '. $this->bd->sqlvalue_inyeccion($anio,true).' order by 2' ;
 
  		$stmt1 =  $this->bd->ejecutar($sql1);

 
		$tabla 	  		    = 'nom_imp_renta';
				
		$secuencia 	        = '-';

		if ( $datos_periodo['nn'] > 0 ){
			$result = 'DATOS YA ACTUALIZADOS...';

		}else 	{

					while ($fila= $this->bd->obtener_fila($stmt1)){
							
						$ATabla = array( 
							array( campo  => 'id',tipo  => 'NUMBER',id  => '0',add  => 'S',edit => 'N',valor =>$contador,key  => 'S'),
							array( campo  => 'anio',tipo  => 'NUMBER',id  => '1',add  => 'S',edit => 'S',valor => $banio,key  => 'N'),
							array( campo  => 'tipo',tipo  => 'NUMBER',id  => '2',add  => 'S',edit => 'S',valor => $fila['tipo'],key  => 'N'),
							array( campo  => 'fracbasica',tipo  => 'NUMBER',id  => '3',add  => 'S',edit => 'S',valor => $fila['fracbasica'],key  => 'N'),
							array( campo  => 'excehasta',tipo  => 'NUMBER',id  => '4',add  => 'S',edit => 'S',valor => $fila['excehasta'],key  => 'N'),
							array( campo  => 'impubasico',tipo  => 'NUMBER',id  => '5',add  => 'S',edit => 'S',valor => $fila['impubasico'],key  => 'N'),
							array( campo  => 'impuexcedente',tipo  => 'NUMBER',id  => '6',add  => 'S',edit => 'S',valor => $fila['impuexcedente'],key  => 'N')
							); 
								
								
							$this->bd->_InsertSQL($tabla,$ATabla,$contador);

							$contador = $contador + 1;
							
							
					}
					$result = 'DATOS ACTUALIZADOS CORRECTAMENTE';
		 }

				
	

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
	
	if ( trim($accion)  == 'cambio'){

		$banio        = $_GET['banio'];
		
		$gestion->cambio_anio( $banio  );

	}else{
		
	$gestion->consultaId($accion,$id);

	}



}

//------ grud de datos insercion
if (isset($_POST["action"]))	{
	
	$action = $_POST["action"];
	
	$id =     $_POST['id'];
	
	$gestion->xcrud(trim($action),trim($id) );
	
}



?>
 
  
<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/


require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
	
	//creamos la variable donde se instanciar la clase "mysql"
	
	private $obj;
	private $bd;
	
	private $ruc;
	private $sesion;
	private $hoy;
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
		
		$this->sesion 	 =  $_SESSION['login'];
		$this->hoy 	     =  $this->bd->hoy();
		
		$this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
		
	}
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	function listar_actividad(   ){
		
		$AResultado = $this->bd->query_array('VIEW_USUARIOS',
				'ACTIVIDAD,IDUNIDAD',
				'USUARIO='.$this->bd->sqlvalue_inyeccion($this->sesion ,true)
				);
		
		
		if ( $AResultado['ACTIVIDAD'] == 'S'){
			$qquery = array(
					array( campo => 'detalle',   valor => '-',  filtro => 'N',   visor => 'S'),
					array( campo => 'fecha',   valor => '-',  filtro => 'N',   visor => 'S'),
					array( campo => 'vencimiento',   valor => '-',  filtro => 'N',   visor => 'S'),
					array( campo => 'leido',   valor => 'N', 			  filtro => 'S',   visor => 'N'),
 					array( campo => 'ambito',   valor => 'Recordatorio',  filtro => 'S',   visor => 'N')
			);
		}else{
			$qquery = array(
					array( campo => 'detalle',   valor => '-',  filtro => 'N',   visor => 'S'),
					array( campo => 'fecha',   valor => '-',  filtro => 'N',   visor => 'S'),
					array( campo => 'vencimiento',   valor => '-',  filtro => 'N',   visor => 'S'),
 					array( campo => 'actividad',   valor =>  $AResultado['IDUNIDAD'],  filtro => 'S',   visor => 'N'),
					array( campo => 'leido',   valor => 'N',  filtro => 'S',   visor => 'N'),
					array( campo => 'ambito',   valor => 'Recordatorio',  filtro => 'S',   visor => 'N')
			);
		}
		
		
		
		$resultado = $this->bd->JqueryCursorVisor('view_actividad_blo',$qquery );
		
  	
		$clientes = array(); //creamos un array
						
		while ($fetch=$this->bd->obtener_fila($resultado)){
			
			$title		=$fetch[0];
			$start		=$fetch[1];
			$end		=$fetch[2];
			 
		 		
			$clientes[] = array("title"=> $title, "start"=> $start, "end"=> $end );
			
		}
		
		//Creamos el JSON
		$json_string = json_encode($clientes);
		
		echo $json_string;
 
		
	}
	
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;



$gestion->listar_actividad( );


?>
 
  
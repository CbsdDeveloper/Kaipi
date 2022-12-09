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
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function proceso( ){
		//inicializamos la clase para conectarnos a la bd
		
		$this->obj     = 	new objects;
		$this->bd	   =	new Db ;
		
		$this->ruc       =  $_SESSION['ruc_registro'];
		$this->sesion 	 =  $_SESSION['login'];
		$this->hoy 	     =  $this->bd->hoy();
		
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
		
	}
	
	//-----------------------------------------------------------------------------------------------------------
	//--- busqueda de grilla primer tab
	//-----------------------------------------------------------------------------------------------------------
	public function BusquedaGrilla($ANIO){
		
 
	    $output = array();
		
		$qquery = array( 
				array( campo => 'anio',   valor => $ANIO,  filtro => 'N',   visor => 'S'),
				array( campo => 'tipo',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'detalle',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'fechainicial',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'fechafinal',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'idperiodo',   valor => '-',  filtro => 'N',   visor => 'S'),
		);
		
		$resultado = $this->bd->JqueryCursorVisor('presupuesto.view_periodo',$qquery );
		
		while ($fetch=$this->bd->obtener_fila($resultado)){
			
			$output[] = array (   $fetch['anio'], $fetch['tipo'],$fetch['detalle'],
			                      $fetch['estado'],
			                      $fetch['fechainicial'],
			                      $fetch['fechafinal'],
			                      $fetch['idperiodo'] 	);
			
		};
		
		echo json_encode($output);
	}
	
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

  $gestion   = 	new proceso;

  $ANIO= $_GET['ANIO1'];
  
  $gestion->BusquedaGrilla($ANIO);





?>
 
  
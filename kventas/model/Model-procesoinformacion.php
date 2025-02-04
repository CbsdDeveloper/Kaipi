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
		
		 
		
		$this->secuencia 	     = '-';
		
	}
	 
	
	 
	
	//--------------------------------------------------------------------------------
	function CargaTareas($id){
		
		$flujo = $this->bd->query_array('view_proceso',
										'nombre, idproceso, responsable, completo, id_departamento, unidad,
										objetivo, tipo, alcance, entrada, salida, publica,indicador',
										'idproceso='.$this->bd->sqlvalue_inyeccion($id,true)
				);
		
		$InformaProceso = '';
	 
		$InformaProceso = 'REFERENCIA:&nbsp;&nbsp;&nbsp;&nbsp;'. $flujo['idproceso'].'<br>'.
						  'PROCESO:&nbsp;&nbsp;&nbsp;&nbsp;'. $flujo['nombre'].'<br>'.
						  'RESPONSABLE: &nbsp;&nbsp;&nbsp;&nbsp;'. $flujo['completo'].'<br>'.
						  'DEPARTAMENTO: &nbsp;&nbsp;&nbsp;&nbsp;'. $flujo['unidad'].'<br>'.
						  'OBJETIVO: &nbsp;&nbsp;&nbsp;&nbsp;'. $flujo['objetivo'].'<br>'.
						  'PROCESO: &nbsp;&nbsp;&nbsp;&nbsp;'. $flujo['tipo'].'<br>'.
						  'AUTORIZADO:&nbsp;&nbsp;&nbsp;&nbsp;'. $flujo['publica'].'<br>';
 
		echo $InformaProceso;
		
	 
		
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
if (isset($_GET['id']))	{
	
	 
	$id        = $_GET['id'];
	
	 
	
	$gestion->CargaTareas($id);
	
}

 


?>
 
  
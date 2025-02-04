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
		
	 
		
	}
	 
 
	//--------------------------------------------------------------------------------
	function ProcesoNombre($id){
		
		
		$flujo = $this->bd->query_array('ven_cliente_seg',
				'porcentaje',
				'idprov='.$this->bd->sqlvalue_inyeccion($id,true).' and 
                 estado in (0,1,2,3)'
				);
 
		
		
		
		$ViewAvance= '<div  class="progress-bar 
                            progress-bar-striped active" 
                            role="progressbar" 
                            aria-valuenow="40" 
                            aria-valuemin="0" 
                            aria-valuemax="100" style="width:'.$flujo['porcentaje'].'%">'.$flujo['porcentaje'].' % </div>';
		
		 	
		echo $ViewAvance;
		
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
if (isset($_GET['idcliente']))	{
	
	 
	$id        = $_GET['idcliente'];
  
	
	$gestion->ProcesoNombre($id);
	
}

 


?>
 
  
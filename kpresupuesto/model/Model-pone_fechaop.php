<?php
session_start( );

require '../../kconfig/Db.class.php';   

require '../../kconfig/Obj.conf.php';  

 
class proceso{
	
	 
	
	private $obj;
	private $bd;
	private $saldos;
	
	private $ruc;
	private $sesion;
	private $hoy;
	private $POST;
	private $anio;
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function proceso( ){
		//inicializamos la clase para conectarnos a la bd
		
		$this->obj     = 	new objects;
		$this->bd	   =	new Db ;
		
		$this->ruc       =  trim($_SESSION['ruc_registro']);
		
		$this->sesion 	 =  trim($_SESSION['email']);
		
		$this->hoy 	     =  $this->bd->hoy();
 	 
		
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
		
		$this->anio       =  $_SESSION['anio'];
		
	}
 
	
	
	//--------------------------------------------------------------------------------
	//--- busqueda de por codigo para llenar los datos
	//--------------------------------------------------------------------------------
	function consultaId($id_asiento,$forden,$apagar ){
		
	    $result = 'ok';
	    
	     
	    
	       $fecha		   = $this->bd->fecha($forden);
 
	        $sql = 'update co_asiento
                       set forden ='.$fecha.' , 
                            apagar = '.$this->bd->sqlvalue_inyeccion($apagar,true).' 
                     WHERE id_asiento='.$this->bd->sqlvalue_inyeccion($id_asiento,true);
	        
	        $this->bd->ejecutar($sql);	
 
	         
		
		echo  $result;
	}
	//--------------------------------------------------------------------------------------
   
	 
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;


//------ poner informacion en los campos del sistema
if (isset($_GET['id_asiento']))	{
	
    $id_asiento    		    =  $_GET['id_asiento'];
    $forden          		=  $_GET['forden'];
    $apagar                 =  $_GET['apagar'];
    
    $gestion->consultaId($id_asiento,$forden,$apagar);
	 
	 
	
}

 


?>
 
  
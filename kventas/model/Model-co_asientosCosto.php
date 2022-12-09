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
		$this->sesion 	 =  $_SESSION['email'];
		$this->hoy 	     =  $this->bd->hoy();
		
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
		
	}
 
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	function agregar($idasientodetCosto,$codigo1,$codigo2,$codigo3,$codigo4){
		
	    
	    
	    $sql = " UPDATE co_asientod
				  SET 	codigo1      =".$this->bd->sqlvalue_inyeccion(trim($codigo1), true).",
                        codigo2      =".$this->bd->sqlvalue_inyeccion(trim($codigo2), true).",
                        codigo3      =".$this->bd->sqlvalue_inyeccion(trim($codigo3), true).",
                        codigo4      =".$this->bd->sqlvalue_inyeccion(trim($codigo4), true)."
 				WHERE   id_asientod =".$this->bd->sqlvalue_inyeccion($idasientodetCosto, true);
	    
	    $this->bd->ejecutar($sql);
	    
	    
	    $guardarCosto = '<br><b>DATO ACTUALIZADO PARA EL CONTROL DE COSTOS </b>';
	    
	    echo $guardarCosto;
		
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
if (isset($_GET['idasientodetCosto']))	{
	
    $idasientodetCosto   = $_GET['idasientodetCosto'];
	$codigo1   = $_GET['codigo1'];
	$codigo2   = $_GET['codigo2'];
	$codigo3   = $_GET['codigo3'];
	$codigo4   = $_GET['codigo4'];
 	  
	$gestion->agregar($idasientodetCosto,$codigo1,$codigo2,$codigo3,$codigo4);
 
		
}

 


?>
 
  
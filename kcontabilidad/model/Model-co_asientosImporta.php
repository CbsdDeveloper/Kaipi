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
		
		$this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
		
	}
 
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	function agregar($idasientodetCosto,$codigo1 ){
		
	    
	    
	    $sql = " UPDATE co_asiento
				  SET 	idmovimiento      =".$this->bd->sqlvalue_inyeccion(trim($codigo1), true)."
 				WHERE   id_asiento =".$this->bd->sqlvalue_inyeccion($idasientodetCosto, true);
	    
	    $this->bd->ejecutar($sql);
	    
 
	    
	    $guardarImportacion = '<p>&nbsp; </p><div align="center"><b>DATO ACTUALIZADO PARA EL CONTROL DE IMPORTACIONES</b></div>';
	    
	    
	    echo $guardarImportacion;
		
	}
	//--------------
	function visor($idasientodetCosto,$codigo1 ){
	    
	    
	    $x = $this->bd->query_array('co_asiento',
	        'idmovimiento', 
	        'id_asiento='.$this->bd->sqlvalue_inyeccion($idasientodetCosto,true)
	        );
	    
	    
	    echo "<script> $('#id_importacion').val(".$x['idmovimiento']." );</script>";
 
  
	    
	    $guardarImportacion = '<p>&nbsp; </p><div align="center"><b>CONTROL DE IMPORTACIONES </b></div>';
	    
	    echo $guardarImportacion;
	    
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
if (isset($_GET['id_asiento']))	{
	
    $idasientodetCosto   = $_GET['id_asiento'];
	$codigo1             = $_GET['id_importacion'];
	$accion              = $_GET['accion'];
	
	if ( $accion == 'add'){
	    
	    $gestion->agregar($idasientodetCosto,$codigo1 );
	    
	}
	
	if ( $accion == 'visor'){
	    
	    $gestion->visor($idasientodetCosto,$codigo1 );
	    
	}
	
 
		
}

 


?>
 
  
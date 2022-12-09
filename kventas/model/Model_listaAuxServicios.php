<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/

class proceso{
	
 
	
	private $obj;
	private $bd;
	private $set;
	
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
		$this->set     = 	new ItemsController;
		
		$this->ruc       =  $_SESSION['ruc_registro'];
		$this->sesion 	 =  $_SESSION['email'];
		$this->hoy 	     =  $this->bd->hoy();
		
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
		
	}
   
	 
 	//---------------------------------
	function GrillaServicios( $idprov){
	    
	    $tipo 		    = $this->bd->retorna_tipo();
	    
	    $sql = 'SELECT  idproducto AS "Codigo" , 
                        producto AS "Detalle" , 
                        avg(cantidad) as "Cantidad", 
                        max(costo) as "Precio"
                FROM  view_mov_aprobado
                where idprov = '. $this->bd->sqlvalue_inyeccion($idprov , true).' and 
                      tipo = '. $this->bd->sqlvalue_inyeccion('F' , true).' and 
                      registro= '. $this->bd->sqlvalue_inyeccion($this->ruc  , true).'
                group by  idproducto, producto';
 
      
	      $resultado  = $this->bd->ejecutar($sql);
	      
 	  
	 	    
	      $this->obj->grid->KP_GRID_CTAA($resultado,$tipo,'cuenta','','N','','','','');
	     
 
	     
	    
	}
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;

 
 
//------ grud de datos insercion
if (isset($_GET["idprov"]))	{
	
 
    $idprov				=   $_GET["idprov"];
  
    $gestion->GrillaServicios( $idprov);
 
	
}
 
 

?>
 
  
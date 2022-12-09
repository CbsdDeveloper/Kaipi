<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/

class proceso{
	
	//creamos la variable donde se instanciar la clase "mysql"
	
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
   
	//--- calcula libro diario
	function GrillaMaestro( $idprov){
		
	  
	    
	    echo '<div class="panel panel-default">
              <div class="panel-heading">Detalle de Movimientos por Auxiliar</div>
              <div class="panel-body">
               <ul class="list-group">';
	    
	    
	    $sql = "SELECT cuenta_detalle,  cuenta    
                FROM view_aux
                where idprov = ".$this->bd->sqlvalue_inyeccion($idprov,true)." and 
                      registro = ". $this->bd->sqlvalue_inyeccion(trim($this->ruc) , true)." 
                group by cuenta_detalle, cuenta
                order by cuenta_detalle,  cuenta";    

      
	    $stmt = $this->bd->ejecutar($sql);
	    
	    while ($x=$this->bd->obtener_fila($stmt)){
	        
	        $cnombre =  trim($x['cuenta_detalle']);
	        $cuenta =  trim($x['cuenta']);
	    
	        echo '   <li class="list-group-item">'.$cuenta.' '.$cnombre.'</li>';
	        
	        $this->GrillaPago( $idprov,$cuenta);
	   
	    }
	    
 	    
	    echo ' </ul>
               </div>
            </div>';
	    
 
		
	    $ViewFormCxc= '<h6><br>'.' Resumen de Auxiliares '.$idprov.'</br></h6>';
	    
	    echo $ViewFormCxc;
	
	}
 	//---------------------------------
	function GrillaPago( $idprov,$cuenta){
	    
	    $tipo 		    = $this->bd->retorna_tipo();
	    
	    $sql = 'SELECT  id_asiento as "Asiento",
                        fecha as "Fecha", 
                        comprobante as "Comprobante",
                        documento as "Documento",
                        detalle as "Detalle",  
                        debe as "Debe", 
                        haber as "Haber",  
                        debe - haber as "Saldo"
                FROM view_aux
                where idprov = '. $this->bd->sqlvalue_inyeccion($idprov , true).' and 
                      estado = '. $this->bd->sqlvalue_inyeccion('aprobado' , true).' and 
                      registro = '. $this->bd->sqlvalue_inyeccion(trim($this->ruc) , true).' and 
                      cuenta = '. $this->bd->sqlvalue_inyeccion($cuenta , true);

      
	      $resultado  = $this->bd->ejecutar($sql);
	      
	      $this->obj->grid->KP_sumatoria(6,"Debe","Haber", 'Saldo','');
	  
	 	    
	      $this->obj->grid->KP_GRID_CTAA($resultado,$tipo,'cuenta',$formulario,'N','','','','');
	     
 
	     
	    
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
  
    $gestion->GrillaMaestro( $idprov);
 
	
}
 
 

?>
 
  
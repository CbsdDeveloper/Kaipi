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
		
		$this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
		
	}
   
	//--- calcula libro diario
	function GrillaMaestro( $id_importacion){
		
	    $this->PoneDetalle( trim($idprov)) ;
	    
	    echo '<div class="panel panel-default">
              <div class="panel-heading">Detalle de Movimientos por Auxiliar</div>
              <div class="panel-body">
               <ul class="list-group">';
	    
	    
	    $sql = "SELECT cuenta_detalle,  cuenta    
                FROM view_aux
                where idprov = ".$this->bd->sqlvalue_inyeccion($idprov,true)." and 
                      registro = ".$this->bd->sqlvalue_inyeccion(trim($this->ruc),true)."
                group by cuenta_detalle, cuenta
                order by cuenta, cuenta_detalle";    
 
      
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
	function GrillaPago( $id_importacion){
	    
	    $tipo 		    = $this->bd->retorna_tipo();
	    
	    $sql = "SELECT a.id_asiento as Asiento,a.fecha,  a.idprov as proveedor, b.detalle  as cuenta,  a.detalle, a.debe  as monto
                    FROM view_diario a
                    join co_plan_ctas b on  a.idmovimiento = ". $this->bd->sqlvalue_inyeccion($idprov , true)." and 
                         a.tipo='M' and 
                         a.debe > 0 and 
                         a.registro = ". $this->bd->sqlvalue_inyeccion(trim($this->ruc) , true)." 
                         a.cuenta= b.cuenta and
                    	 a.registro = b.registro and tipo_cuenta <> 'I'";

    
      
	      $resultado  = $this->bd->ejecutar($sql);
	      
	      $this->obj->grid->KP_sumatoria(6,"monto","", '','');
	  
	 	    
	      $this->obj->grid->KP_GRID_CTAA($resultado,$tipo,'cuenta',$formulario,'N','','','','');
	     
 
	     
	    
	}
//-----------------
	function PoneDetalle( $idprov){
	    
	 
	    
	    $sql = 'SELECT  id_asiento,
                        id_asiento_aux
                 FROM view_aux
                where idprov = '. $this->bd->sqlvalue_inyeccion($idprov , true).' and detalle is null and 
                      registro = '. $this->bd->sqlvalue_inyeccion(trim($this->ruc) , true).' and  
                       estado = '. $this->bd->sqlvalue_inyeccion('aprobado' , true) ;
	    
	    
	    
	    $stmt = $this->bd->ejecutar($sql);
	    
	    while ($x=$this->bd->obtener_fila($stmt)){
	        
	        $y = $this->bd->query_array(
	            'co_asiento',
	            'detalle',
	            'id_asiento='.$this->bd->sqlvalue_inyeccion( $x['id_asiento'],true)
	            );
	        
	        $sql = "UPDATE co_asiento_aux
 					   SET 	detalle=".$this->bd->sqlvalue_inyeccion( trim($y['detalle']), true)."
 						 WHERE detalle is null and 
                               id_asiento_aux=".$this->bd->sqlvalue_inyeccion($x['id_asiento_aux'], true);
	        
	        $this->bd->ejecutar($sql);
	      
	            
	        
	    }
	    
	    
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
if (isset($_GET["id_importacion"]))	{
	
 
    $id_importacion			=   $_GET["id_importacion"];
  
    $gestion->GrillaPago( $id_importacion);
 
	
}
 
 

?>
 
  
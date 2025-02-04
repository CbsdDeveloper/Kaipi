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

		
		$this->obj     = 	new objects;
		$this->bd	   =	new Db ;
		$this->set     = 	new ItemsController;
		
		$this->ruc       =  $_SESSION['ruc_registro'];
		$this->sesion 	 =  $_SESSION['email'];
		$this->hoy 	     =  $this->bd->hoy();
		
		$this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
		
	}
   
	//--- calcula libro diario
	
	function GrillaMaestro( $idprov,$anio,$cuenta,$bandera){
		
	    $this->PoneDetalle( trim($idprov)) ;
	    
	    echo '<div class="panel panel-default">
              <div class="panel-heading">Detalle de Movimientos por Auxiliar</div>
              <div class="panel-body">
               <ul class="list-group">';
	    
	   
 	  
 
	        
	        $this->GrillaPago( $idprov,$cuenta,$anio,$bandera);
	   
	   
	    
 	    
	    echo ' </ul>
               </div>
            </div>';
	    
 
		
	    $ViewFormCxc= '<h6><br>'.' Resumen de Auxiliares '.$idprov.'</br></h6>';
	    
	    echo $ViewFormCxc;
	
	}
 	//---------------------------------
	function GrillaPago( $idprov,$cuenta,$anio,$bandera){
	    
	    $tipo 		    = $this->bd->retorna_tipo();

 
	        
                    $sql = 'SELECT  cuenta,
                    cuenta_detalle as detalle,
                    sum(debe) as "Debe", 
                    sum(haber) as "Haber",  
                    sum(debe) - sum(haber) as "Saldo"
            FROM view_aux
            where idprov = '. $this->bd->sqlvalue_inyeccion($idprov , true).' and 
                estado = '. $this->bd->sqlvalue_inyeccion('aprobado' , true).' and 
                anio = '. $this->bd->sqlvalue_inyeccion( $anio , true).' and 
                registro = '. $this->bd->sqlvalue_inyeccion(trim($this->ruc) , true).' 
                group by cuenta,cuenta_detalle
                order by cuenta';
	        
 
      
	    $formulario = '';
	      
	    $resultado  = $this->bd->ejecutar($sql);
	      
	      
	      $this->obj->grid->KP_sumatoria(3,"Debe","Haber", 'Saldo','');
	  
 
	 	    
	      $this->obj->grid->KP_GRID_CTAA($resultado,$tipo,'Asiento',$formulario,'S','visor','','','');
	     
 
	     
	     
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
	        
	        $detalle = substr(trim($y['detalle']),0,199);
	        
	        $sql = "UPDATE co_asiento_aux
 					   SET 	detalle=".$this->bd->sqlvalue_inyeccion( $detalle  , true)."
 						 WHERE detalle is null and 
                               id_asiento_aux=".$this->bd->sqlvalue_inyeccion($x['id_asiento_aux'], true);
	        
	         $this->bd->ejecutar($sql);
	            
	        
	    }
	    //----------------------------------------------------------
	    
	    $sql = 'SELECT  id_asiento,
                        id_asiento_aux
                 FROM view_aux
                where comprobante   is null and
                      registro = '. $this->bd->sqlvalue_inyeccion(trim($this->ruc) , true).' and
                       estado = '. $this->bd->sqlvalue_inyeccion('aprobado' , true) ;
	    
 
	    
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
if (isset($_GET["prove"]))	{
 
    
    $idprov				=   trim($_GET["prove"]);
    $anio				=   $_GET["anio"];
    $cuenta				=   trim($_GET["cuenta"]);
    $bandera				=   $_GET["bandera"];
    
    $gestion->GrillaMaestro( $idprov,$anio,$cuenta,$bandera);
 
	
}
 
 

?>
 
  
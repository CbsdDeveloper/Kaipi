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
		
		$this->ruc       =  trim($_SESSION['ruc_registro']);
		$this->sesion 	 =  trim($_SESSION['email']);
		$this->hoy 	     =  $this->bd->hoy();
		
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
		
	}
   
	//--- calcula libro diario
	function GrillaMaestro( $anio,$cuenta){
 
 
	    echo '<h5><b>'.$this->ruc.' '.$_SESSION['razon'].'</b><br>';
	    echo 'RESUMEN DE GESTION DE FINANCIERO - AUXILIARES <br>';
	    echo 'PERIODO '.$anio.'</h5>';
	    
	    echo '<div class="panel panel-default">
              <div class="panel-heading">Detalle de transacciones</div>
              <div class="panel-body">
               <ul class="list-group">';
	    
	    
	    $tipo_cta =  substr(trim($cuenta),0,1); 
	    
	    if ( $tipo_cta == '1'){
	       
	        
	        $sql = "SELECT cuenta,detalle,
                           sum(debe) as debe, 
                           sum(haber) as haber , 
                           sum(debe) - sum(haber) as saldo
                FROM view_diario_conta
                where cuenta = ".$this->bd->sqlvalue_inyeccion($cuenta,true)." and
                      anio = ".$this->bd->sqlvalue_inyeccion($anio,true)." and
                      registro = ". $this->bd->sqlvalue_inyeccion(trim($this->ruc) , true).' group by cuenta,detalle' ;    
	    }else{
	        
	        $sql = "SELECT cuenta,detalle,
                           sum(debe) as debe, 
                           sum(haber) as haber , 
                           sum(haber) - sum(debe) as saldo
                FROM view_diario_conta
                where cuenta = ".$this->bd->sqlvalue_inyeccion($cuenta,true)." and
                      anio = ".$this->bd->sqlvalue_inyeccion($anio,true)." and
                      registro = ". $this->bd->sqlvalue_inyeccion(trim($this->ruc) , true).' group by cuenta,detalle' ;    
	        
	    }
 
	      
	    
	    $idprov ='';
 
   
	    $stmt = $this->bd->ejecutar($sql);
	    
	    while ($x=$this->bd->obtener_fila($stmt)){
	        
	        $cnombre =  trim($x['detalle']);
	        
	        $cuenta =  trim($x['cuenta']);
	        
	      
	        
	    
	        echo '   <li class="list-group-item">'.$cuenta.' '.$cnombre.'</li>';
	        
	        $this->GrillaPago( $idprov,$cuenta,$anio,$tipo_cta);
	   
	    }
	    
 	    
	    echo ' </ul>
               </div>
            </div>';
	    
	    
 
	
	}
 	//---------------------------------
	function GrillaPago( $idprov,$cuenta,$anio,$tipo_cta){
	    
	    $tipo 		    = $this->bd->retorna_tipo();
	    
	    $formulario = '';
 
	    if( $tipo_cta == '1'){
	        
	        $sql = 'SELECT idprov as "Identificacion",
                       razon as "Nombre",
                       sum(debe) as "Debe",
                       sum(haber) as "Haber",  
                        sum(debe) - sum(haber) as "Saldo"
                FROM view_aux
                where cuenta = '.$this->bd->sqlvalue_inyeccion($cuenta,true)." and
                      anio = ".$this->bd->sqlvalue_inyeccion($anio,true)." and
                      estado = ".$this->bd->sqlvalue_inyeccion('aprobado',true)." and
                      registro = ". $this->bd->sqlvalue_inyeccion(trim($this->ruc) , true)."
                 group by idprov,razon
	            having sum(debe) - sum(haber)   <> 0";   
	        
	        $resultado  = $this->bd->ejecutar($sql);
	        $this->obj->grid->KP_sumatoria(3,"Debe","Haber", 'Saldo','');
	        
	        
	    }else{
	        
	        $sql = 'SELECT idprov as "Identificacion",
                       razon as "Nombre",
                       sum(debe) as "Debe",
                       sum(haber) as "Haber",  
                       sum(haber) - sum(debe) as "Saldo"
                FROM view_aux
                where cuenta = '.$this->bd->sqlvalue_inyeccion($cuenta,true)." and
                      anio = ".$this->bd->sqlvalue_inyeccion($anio,true)." and
                     estado = ".$this->bd->sqlvalue_inyeccion('aprobado',true)." and
                      registro = ". $this->bd->sqlvalue_inyeccion(trim($this->ruc) , true)."
                 group by idprov,razon
	            having sum(haber) - sum(debe)   <> 0";  
	        
	        $resultado  = $this->bd->ejecutar($sql);
	        $this->obj->grid->KP_sumatoria(3,"Debe","Haber", 'Saldo','');
	        
	    }

       
	  
	 	    
	      $this->obj->grid->KP_GRID_CTAA($resultado,$tipo,'Asiento',$formulario,'N','','','','');
	     
 
	     
	    
	}
//-----------------
 
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;

 
 
//------ grud de datos insercion
if (isset($_GET["cuenta"]))	{
 
    
     $anio				=   $_GET["anio"];
     $cuenta				=   $_GET["cuenta"];
     
   $gestion->GrillaMaestro(  $anio,$cuenta);
 
     
  
}
 
 

?>
 
  
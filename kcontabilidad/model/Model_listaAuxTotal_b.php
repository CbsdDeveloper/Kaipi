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
 

		$sql = 'SELECT distinct idprov,razon FROM view_aux
                where cuenta = '.$this->bd->sqlvalue_inyeccion($cuenta,true)." and
                      anio = ".$this->bd->sqlvalue_inyeccion($anio,true)." and
                      estado = ".$this->bd->sqlvalue_inyeccion('aprobado',true)." and
                      registro = ". $this->bd->sqlvalue_inyeccion(trim($this->ruc) , true); 
	    
	    $idprov ='';
 
   
	    $stmt = $this->bd->ejecutar($sql);
	    
	    while ($x=$this->bd->obtener_fila($stmt)){
	        
	        $razon =  trim($x['razon']);
	        
	        $idprov =  trim($x['idprov']);
	        
	        echo '   <li class="list-group-item"><b>'.$idprov.' '.$razon.'</b></li>';

			$sql1 = "SELECT cuenta_detalle,  cuenta
                FROM view_aux
                where idprov = ".$this->bd->sqlvalue_inyeccion($idprov,true)." and
                      cuenta = ".$this->bd->sqlvalue_inyeccion($cuenta,true)." and
                      anio = ".$this->bd->sqlvalue_inyeccion($anio,true)." and
                      registro = ". $this->bd->sqlvalue_inyeccion(trim($this->ruc) , true)."
                group by cuenta_detalle, cuenta
                order by cuenta_detalle,  cuenta";  

			$stmt1 = $this->bd->ejecutar($sql1);
	
			while ($x1=$this->bd->obtener_fila($stmt1)){
				
				$cnombre =  trim($x1['cuenta_detalle']);
				
				$cuenta =  trim($x1['cuenta']);
			
				echo '   <li class="list-group-item">'.$cuenta.' '.$cnombre.'</li>';
				
				$this->GrillaPago( $idprov,$cuenta,$anio);
			
			}
	        
	        // $this->GrillaPago( $idprov,$cuenta,$anio);
	   
	    }
	    
 	    
	    echo ' </ul>
               </div>
            </div>';
	    
	    
 
	
	}
 	//---------------------------------
	 function GrillaPago( $idprov,$cuenta,$anio){
	    
	    $tipo 		    = $this->bd->retorna_tipo();
	    
	    $sql = 'SELECT  id_asiento as "Asiento",
                        fecha as "Fecha", 
                        substring(comprobante,1,10) || '."' '".' as "Comprobante",
                        substring(detalle,1,150) as "Detalle",  
                        debe as "Debe", 
                        haber as "Haber",  
                        debe - haber as "Saldo"
                FROM view_aux
                where idprov = '. $this->bd->sqlvalue_inyeccion($idprov , true).' and 
                       estado = '. $this->bd->sqlvalue_inyeccion('aprobado' , true).' and 
                       anio = '. $this->bd->sqlvalue_inyeccion( $anio , true).' and 
                       registro = '. $this->bd->sqlvalue_inyeccion(trim($this->ruc) , true).' and 
                      cuenta = '. $this->bd->sqlvalue_inyeccion(trim($cuenta) , true).' order by fecha';

	   
      
	    $formulario = '';
	      
	    $resultado  = $this->bd->ejecutar($sql);
	      
	      
	      $this->obj->grid->KP_sumatoria(5,"Debe","Haber", 'Saldo','');
	  
 
	 	    
	      $this->obj->grid->KP_GRID_CTAA($resultado,$tipo,'Asiento',$formulario,'S','visor','','','');
	     
 
	     
	     
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
 
  
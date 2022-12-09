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
		$this->sesion    =  trim($_SESSION['email']);
		$this->hoy 	   =  $this->bd->hoy();
		
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
		
	}
   
	//--- calcula libro diario
	
	function GrillaMaestro(  $anio,$cuenta,$bandera){
		
	    $idprov ='';
	    
	    echo '<div class="panel panel-default">
              <div class="panel-heading">Detalle de Movimientos por Auxiliar</div>
              <div class="panel-body">
               <ul class="list-group">';

 
 
	    $this->GrillaPago( $idprov,$cuenta,$anio);
     
	    
	    
 	    
	    echo ' </ul>
               </div>
            </div>';
	    
 
		
	    $ViewFormCxc= '<h6><br>'.' Resumen de Auxiliares '.$idprov.'</br></h6>';
	    
	    echo $ViewFormCxc;
	
	}
 	//---------------------------------
	function GrillaPago( $idprov,$cuenta,$anio){
	    
	    $tipo 		    = $this->bd->retorna_tipo();
	    
	    $tipo_cuenta = substr($cuenta, 0,1);
	    
  
	    
	    if ($tipo_cuenta == '1'){
	        
	        $sql = 'select idprov as identificacion,
                           razon as nombre, sum(debe) debe,sum(haber) haber ,   sum(debe) - sum(haber) as saldo
             from view_aux
             where  anio = '. $this->bd->sqlvalue_inyeccion( $anio , true).' and
                    estado = '. $this->bd->sqlvalue_inyeccion('aprobado' , true).' and
                    cuenta like '. $this->bd->sqlvalue_inyeccion(trim($cuenta).'%' , true).'
             group by idprov ,razon
             having sum(debe) - sum(haber) > 0 order by razon';
	        
	    }else{
	        
	        if ( $cuenta == '224.85'){
	            $sql = 'select idprov as identificacion ,
                           razon as nombre, sum(debe) debe,sum(haber) haber ,
                           sum(haber) - sum(debe) as saldo
             from view_aux
             where  anio = '. $this->bd->sqlvalue_inyeccion( $anio , true).' and
                    estado = '. $this->bd->sqlvalue_inyeccion('aprobado' , true).' and
                    cuenta like '. $this->bd->sqlvalue_inyeccion(trim($cuenta).'%' , true).'
             group by idprov ,razon
             having sum(debe) - sum(haber) > 0 order by razon';
	        }else{
	            $sql = 'select idprov as identificacion ,
                           razon as nombre, sum(debe) debe,sum(haber) haber ,
                           sum(haber) - sum(debe) as saldo
             from view_aux
             where  anio = '. $this->bd->sqlvalue_inyeccion( $anio , true).' and
                    estado = '. $this->bd->sqlvalue_inyeccion('aprobado' , true).' and
                    cuenta like '. $this->bd->sqlvalue_inyeccion(trim($cuenta).'%' , true).'
             group by idprov ,razon
             having sum(haber) - sum(debe) > 0 order by razon';
	        }
	       
	        
	       
	    }
	 

 
	   
      
	    $formulario = '';
	      
	    $resultado  = $this->bd->ejecutar($sql);
	      
	      
	      $this->obj->grid->KP_sumatoria(3,"debe","haber", 'saldo','');
	  
 
	 	    
	      $this->obj->grid->KP_GRID_CTAA($resultado,$tipo,'Asiento',$formulario,'N','','','','');
	     
 
	     
	     
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
	    
/*	    
	    
	    $stmt1 = $this->bd->ejecutar($sql);
	    
	    while ($x=$this->bd->obtener_fila($stmt1)){
	        
	        $y = $this->bd->query_array(
	            'co_asiento',
	            'detalle,comprobante',
	            'id_asiento='.$this->bd->sqlvalue_inyeccion( $x['id_asiento'],true)
	            );
	        
	        
	        $COMP = substr(trim($x['comprobante']),0,9);
	        
	        $sql1 = "UPDATE co_asiento_aux
 					   SET 	comprobante=".$this->bd->sqlvalue_inyeccion( trim($COMP, true)."
 						 WHERE  id_asiento_aux=".$this->bd->sqlvalue_inyeccion($x['id_asiento_aux'], true);
	        
	        $this->bd->ejecutar($sql1);
	        
	        */
	   
	    
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
if (isset($_GET["cuenta"]))	{
 
    
    $anio				=   $_GET["anio"];
    $cuenta				=   $_GET["cuenta"];
    $bandera				=   $_GET["bandera"];
    
    $gestion->GrillaMaestro( $anio,$cuenta,$bandera);
 
	
}
 
 

?>
 
  
<?php
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/

class Model_listaAuxqSRI_res{
	
 	
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
	function Model_listaAuxqSRI_res( ){
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
	function GrillaMaestro( $idprov,$anio,$cuenta,$bandera,$cmes){
		
	    $this->PoneDetalle( trim($idprov)) ;
	    
	    echo '<div class="panel panel-default">
              <div class="panel-heading">Detalle de Movimientos por Auxiliar</div>
              <div class="panel-body">
               <ul class="list-group">';
	    
	    $cadena_mes =  ' mes = '.$this->bd->sqlvalue_inyeccion($cmes,true).' and ';
	    
	    if ( $cmes == '-'){
	        $cadena_mes = '';
	    }
	    
	 
	    
	  
       		$total_general = 0;
      
 
	        
	        $total  =  $this->GrillaPago( $idprov,$cuenta,$cmes,$anio,$bandera);
	    
 	        
 	      
	   
	    
	    
 	    
	    echo ' </ul>
               </div>
            </div>';
	    
 
		
	    $ViewFormCxc= '<h4><b>'.' Resumen de Auxiliares '. $total.'</b></h4>';
	    
	    echo $ViewFormCxc;
	
	}
 	//---------------------------------
	function GrillaPago( $idprov,$cuenta,$cmes,$anio,$bandera){
	    
	 
 
	    $cadena_mes =  ' and mes = '.$this->bd->sqlvalue_inyeccion($cmes,true).'  ';
	    
	    if ( $cmes == '-'){
	        $cadena_mes = '';
	    }
	    
	    
	    $sql = "SELECT  cuenta,
						cuenta_detalle as detalle,
                        sum(debe) as debe  , 
                        sum(haber)  as haber 
                FROM view_aux
                where idprov = ". $this->bd->sqlvalue_inyeccion($idprov , true).' and 
                       estado = '. $this->bd->sqlvalue_inyeccion('aprobado' , true).' and 
                       pago= '. $this->bd->sqlvalue_inyeccion('N' , true).' and 
                       anio= '. $this->bd->sqlvalue_inyeccion($anio , true).' and 
                       registro = '. $this->bd->sqlvalue_inyeccion(trim($this->ruc) , true).'   
                       '. $cadena_mes.'   
                group by  cuenta ,
						  cuenta_detalle
				order by  cuenta , cuenta_detalle';

				$nombre = 'resumen_total';

				echo '<table class="table table-bordered table-hover table-tabletools" id='."'".$nombre."'".' border="0" width="100%">
				<thead> <tr>';
					
 
					echo '<th width="10%" bgcolor="#167cd8" style="color: #F4F4F4">Cuenta</th>';
					echo '<th width="30%" bgcolor="#167cd8" style="color: #F4F4F4">Detalle</th>';
					echo '<th width="10%" bgcolor="#167cd8" style="color: #F4F4F4">Debe</th>';
					echo '<th width="10%" bgcolor="#167cd8" style="color: #F4F4F4">Haber</th>';
					echo '<th width="10%" bgcolor="#167cd8" style="color: #F4F4F4">Saldo</th>';
					echo '<th width="10%" bgcolor="#167cd8" style="color: #F4F4F4"></th>';
					 
					echo '</tr></thead><tbody>';
    
            
            $resultado  = $this->bd->ejecutar($sql);
	      
            
            $nsuma1 = 0;
            $nsuma2 = 0;
             
            $k = 1;
            
            while($row=pg_fetch_assoc($resultado)) {
                
				$total =   $row['haber'] - $row['debe'];

				if ( $total > 0  ) {
						$nsuma1 = $nsuma1 + $row['debe'];
						$nsuma2 = $nsuma2 + $row['haber'];

					

						$check =' ';
						$bandera = '<input type="checkbox" onclick="SumaTotal('.$total .',this)" '.$check.'> ';
						
		
						echo "<tr><td><b>".trim($row['cuenta']).'</b></td>';
						echo "<td>".trim($row['detalle']).'</td>';
			
						echo "<td align='right'>".number_format($row['debe'],2).'</td>';
						echo "<td align='right'>".number_format($row['haber'],2).'</td>';
						echo "<td align='right'><b>".number_format($total,2).'</b></td>';
						
						echo "<td>".$bandera.'</td></tr>';
					}

				$k++;

                 
            }
	     
            
            $total = $nsuma2 - $nsuma1;
            
         
         
            return  $total;
	     
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
	            'detalle,comprobante',
	            'id_asiento='.$this->bd->sqlvalue_inyeccion( $x['id_asiento'],true)
	            );
	        
	        $detalle = substr(trim($y['detalle']),0,150);
	        
	        $sql = "UPDATE co_asiento_aux
 					   SET 	detalle=".$this->bd->sqlvalue_inyeccion( $detalle  , true).", 
                            comprobante=".$this->bd->sqlvalue_inyeccion(  trim($x['comprobante'])  , true)."
 						 WHERE detalle is null and 
                               id_asiento_aux=".$this->bd->sqlvalue_inyeccion($x['id_asiento_aux'], true);
	        
	       $this->bd->ejecutar($sql);
	            
	        
	    }
	   
 
	    $sql = 'SELECT  id_asiento,
                        id_asiento_aux
                 FROM view_aux
                where comprobante   is null and
                      registro = '. $this->bd->sqlvalue_inyeccion(trim($this->ruc) , true).' and
                       estado = '. $this->bd->sqlvalue_inyeccion('aprobado' , true) ;
	    
	    
	    
	    $stmt1 = $this->bd->ejecutar($sql);
	    
	    while ($x=$this->bd->obtener_fila($stmt1)){
	        
	        $y = $this->bd->query_array(
	            'co_asiento',
	            'detalle,comprobante',
	            'id_asiento='.$this->bd->sqlvalue_inyeccion( $x['id_asiento'],true)
	            );
	        
	        $sql11 = "UPDATE co_asiento_aux
 					   SET 	comprobante=".$this->bd->sqlvalue_inyeccion( trim($y['comprobante']), true)."
 						 WHERE  id_asiento_aux=".$this->bd->sqlvalue_inyeccion($x['id_asiento_aux'], true);
	        
	        $this->bd->ejecutar($sql11);
	        
	        
	    }
	     
	    
	    
	}
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new Model_listaAuxqSRI_res;

 
 
//------ grud de datos insercion
if (isset($_GET["prove"]))	{
 
    
    $idprov				=   $_GET["prove"];
    $anio				=   $_GET["anio"];
    $cuenta				=   $_GET["cuenta"];
    $bandera				=   $_GET["bandera"];
    
    $cmes =   $_GET["cmes"];
    
 

    $gestion->GrillaMaestro( $idprov,$anio,$cuenta,$bandera,$cmes);
 
	
}
 
 

?>
 
  
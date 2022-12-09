 <?php 
    session_start();  
    
    include ('../../kconfig/Db.class.php');   
 	include ('../../kconfig/Obj.conf.php'); 
	
 
	$bd	   =    new Db ;
   
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
    
  
 
 	  
 		 $year = date('Y');
       	 $idcodigo   			= $_GET['id'];
       	 $periodo				= $_GET['periodo'];
       	 
          
       	
       	 
       	 //----------------------------------------
       	 if (!empty($periodo)){
       	 
       	 	$SQL_periodo ="anio =".$bd->sqlvalue_inyeccion($year,true);    
          
       	 }else{
       	 	
       	 	$SQL_periodo ="idperiodo =".$bd->sqlvalue_inyeccion($periodo,true);    
       	 }
       
       	 $estado =  EstadoPoa($periodo ,$bd);
       	 
       	 $ViewVisorArbol = '';
       	 
       	 if ( $estado == 0) {
        	     
       	     $ViewVisorArbol = '<div class="btn-group">
                    <button type="button" class="btn btn-primary btn-primary" data-toggle="modal" data-target="#myModaloo"   onClick="LimpiarPantalla_oo()"  >Crear Objetivos</button> 
              </div>';
        	     
       	 } 
       	 
         $APeriodo = $bd->query_array(
       	 		'presupuesto.view_periodo',
       	 		' idperiodo  ,detalle',
         		$SQL_periodo
         	);
       	 
       $periodo = $APeriodo['idperiodo'];
           
	 
	    
	    $SQL_DATO = "  SELECT  idobjetivo, objetivo
                	    FROM planificacion.pyobjetivos
                	    WHERE idperiodo =".$bd->sqlvalue_inyeccion($periodo,true) ." AND 
                			  id_departamento=".$bd->sqlvalue_inyeccion($idcodigo,true);
	    
	    $stmt = $bd->ejecutar($SQL_DATO);
	    
	    $i = 1;
	    
	    $ViewVisorArbol .= '<div class="col-md-12" style="padding-top: 10px;padding-bottom: 10px">';
	    
	    $ViewVisorArbol .= '<ul class="list-group">';
	    
	    while ($x=$bd->obtener_fila($stmt)){
	    	
	    	$evento = ' onClick="goToURLArbol('.$x['idobjetivo'].');"';
	    	
	    	$url = '<a data-toggle="modal" href="#" data-target="#myModaloo" '.$evento.'>'.$i.'.- '.$x['objetivo'].' </a>';
  	    	
	    	$ViewVisorArbol .= '<li class="list-group-item"> '.$url .' </li>';
	    	
	    	$i ++;
	    }
 
 	 
	    $ViewVisorArbol .= '</ul> </div>';
	   
	    
	   
	    
	    echo $ViewVisorArbol;
	    
	//----------------------------------------------------------------------------
	    function EstadoPoa( $Q_IDPERIODO ,$bd ){
	        
	        
	        $AUnidad = $bd->query_array('presupuesto.pre_periodo',
	            'tipo,estado',
	            "tipo in ('elaboracion','proforma') and
			 anio = ".$bd->sqlvalue_inyeccion($Q_IDPERIODO,true)
	            );
	        
	        $valida = 1;
	        
	        if ( $AUnidad['tipo']  == 'elaboracion'  ){
	            $valida = 0;
	        }
	        
	        
	        return $valida ;
	        
	    }
?>
 <?php 
    session_start();  
    
    include ('../../kconfig/Db.class.php');   
 	include ('../../kconfig/Obj.conf.php'); 
	
 
	$bd	   =    new Db ;
   
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
    
  
 	 if (isset($_GET['id']))	{
 	  
 		 $year = date('Y');
       	 $idcodigo   			= $_GET['id'];
       	 $periodo				= $_GET['periodo'];
       	 
         	 
       	 $AResultado = $bd->query_array(
       	 				'view_unidad_planificacion',
       	 				' nombre,   superior, atribuciones, competencias,techo,ambito', 
       	 				'id_departamento='.$bd->sqlvalue_inyeccion($idcodigo,true)
       	 			   );
      
       	 
       	 //----------------------------------------
       	 if (!empty($periodo)){
       	 
       	 	$SQL_periodo ="anio =".$bd->sqlvalue_inyeccion($year,true);    
          
       	 }else{
       	 	
       	 	$SQL_periodo ="idperiodo =".$bd->sqlvalue_inyeccion($periodo,true);    
       	 }
       
  
       	 
         $APeriodo = $bd->query_array(
       	 		'presupuesto.view_periodo',
       	 		' idperiodo  ,detalle',
         		$SQL_periodo
         	);
       	 
         
         $ViewVisorArbol 		.=  '<div class="panel panel-default"> <div class="panel-heading">
                                        <h4><b> '.$AResultado['nombre'].'</b></h4> </div> <div class="panel-body">';
         
         $ViewVisorArbol .= '<h5><b> '.$APeriodo['detalle'].'</b></h5>';
       	 $ViewVisorArbol .= '<b>Ambito:</b> '.$AResultado['ambito'].'<br><br>';
        	
       	 $ViewVisorArbol .= '<h5><b>Objetivos Operativos</b></h5>';
       	 $periodo = $APeriodo['idperiodo'];
       	 
	    }
	    
  	    
	    
	    $ViewVisorArbol .= '<ul class="list-group">';
	    
	    $SQL_DATO = "  SELECT  idobjetivo, objetivo
                	    FROM planificacion.pyobjetivos
                	    WHERE idperiodo =".$bd->sqlvalue_inyeccion($periodo,true) ." AND 
                			  id_departamento=".$bd->sqlvalue_inyeccion($idcodigo,true);
	    
	    $stmt = $bd->ejecutar($SQL_DATO);
	    
	    while ($x=$bd->obtener_fila($stmt)){
	    	
	    	$evento = ' onClick="goToURLArbol('.$x['idobjetivo'].');"';
	    	
	    	$url = '<a data-toggle="modal" href="#" data-target="#myModal" '.$evento.'><img title ="Editar Objetivo Operativo de la unidad" align="absmiddle" src="../../kimages/Search.png"/></a>&nbsp;&nbsp;&nbsp;';
	    	
 	    	
	    	$ViewVisorArbol .= '<li class="list-group-item"><b>'.$url.$x['objetivo'] .'</b></li>';
	    }
 
 	 
	    $ViewVisorArbol .= '</ul></div> </div>';
	   
	    
	   
	    
	    echo $ViewVisorArbol;
	    
?>


 
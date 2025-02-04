 <?php 
    session_start();  
    
    include ('../../kconfig/Db.class.php');   
 	include ('../../kconfig/Obj.conf.php'); 
	
	$obj   = 	new objects;
	$bd	   =    new Db ;
   
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
  
 	 if (isset($_GET['id']))	{
 	  
 
       	 $idcodigo   			= $_GET['id'];
       	 
       	 $ViewVisorArbol 		.=  '<div class="panel panel-default"> <div class="panel-heading">Unidad Seleccionada</div> <div class="panel-body">';
       	 $ViewVisorArbol 		.=  '<br>Referencia: '.$idcodigo .'<br>';
       	 
       	 $AResultado = $bd->query_array(
       	 				'nom_departamento',
       	 				' nombre,   atribuciones, competencias,ambito', 
       	 		'id_departamento='.$bd->sqlvalue_inyeccion($idcodigo,true));
       	 
 
		 
       	 $ViewVisorArbol .= '<h4><b>Unidad: '.$AResultado['nombre'].'</b></h4><br><br>';
       	 $ViewVisorArbol .= '<b>Ambito:</b> '.$AResultado['ambito'].'<br><br>';
       	 $ViewVisorArbol .= '<b>Atribucion:</b> '.$AResultado['atribuciones'].'<br><br>';
       	 $ViewVisorArbol .= '<b>Competencia:</b> '.$AResultado['competencias'].'<br></div> </div>';
		    
	    }
	    
	    echo $ViewVisorArbol;
        
	    echo  '<div style="width:100%; height:320px; overflow: auto;padding: 5px" >';
	    
	    $sql = 'SELECT programa as "Programa",
					    nombre as "Unidad",
						ambito as "Ambito",
						techo as "($) Techo Presupuesto"
				FROM nom_departamento
				WHERE (id_departamentos = '.$bd->sqlvalue_inyeccion($idcodigo,true).') or 
                      (id_departamento = '.$bd->sqlvalue_inyeccion($idcodigo,true).')
				order by id_departamento';
	    
	    $resultado     =  $bd->ejecutar($sql);
	    $tipo	       =  $bd->retorna_tipo();
	    $indicador = 0;
	    
	    $obj->grid->KP_GRID_WEB_P($resultado,$tipo,'Id', $indicador,'N','','','3','100%');
	   
	    
	    $total = $bd->query_array(
	        'nom_departamento',
	        ' sum(techo) as total',
	        '(id_departamentos = '.$bd->sqlvalue_inyeccion($idcodigo,true).') or 
             (id_departamento = '.$bd->sqlvalue_inyeccion($idcodigo,true).')'
	        );
	    
	    
	    $tot = number_format($total['total'], 2, ',', '.');
	    
	    echo '<h4><b>Total '.$tot.'</b><h4></div>';
 	 
?>


 
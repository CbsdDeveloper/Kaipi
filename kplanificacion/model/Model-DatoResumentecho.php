 <?php 
    session_start();  
    
    include ('../../kconfig/Db.class.php');   
 	include ('../../kconfig/Obj.conf.php'); 
	
	$obj   = 	new objects;
	$bd	   =    new Db ;
   
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
  
 	  
       	 
       	 $ViewVisorArbol 		.=  '<div class="panel panel-default"> <div class="panel-heading">Unidad Seleccionada</div> <div class="panel-body">';
       	 $ViewVisorArbol 		.=   '<br>';
       	 
       	 echo $ViewVisorArbol ;
       	 
       	 $sql = 'SELECT PROGRAMA as "Programa",
					    NOMBRE as "Unidad", 
						AMBITO as "Ambito",
						TECHOPRESUPUESTARIO as "($) Techo Presupuesto"
				FROM SIUNIDAD
				WHERE NVL(TECHOPRESUPUESTARIO,0) >0
				order by IDUNIDAD';
       	 
       	 $resultado =  $bd->ejecutar($sql);
       	 $tipo	      =  $bd->retorna_tipo();
       	 $indicador = 0;
       	 
       	 $obj->grid->KP_GRID_WEB_P($resultado,$tipo,'Id', $indicador,'N','','','','100%');
       	 
       	 
 
       	 $ViewVisorArbol = '<br></div> </div>';
		    
	   echo $ViewVisorArbol;
        
 	 
?>


 
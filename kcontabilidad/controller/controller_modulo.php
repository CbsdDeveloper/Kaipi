<?php 
session_start( );  
  
    // retorna el valor del campo para impresion de pantalla
  
require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Db.conf.php';   /*Incluimos el fichero de la clase Conf*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
/*Creamos la instancia del objeto. Ya estamos conectados*/

 
$obj   = 	new objects;
$set   = 	new ItemsController;
$bd	   =	Db::getInstance();

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

	$modulo = $_GET["ViewModulo"];
     
    $clase = array("btn btn-lg btn-primary", "btn btn-lg btn-info", 
								 			    "btn btn-lg btn-success", "btn btn-lg btn-warning",
												 "btn btn-lg btn-danger", "btn btn-lg btn-inverse"
												);
    
 	  $sql = "select a.modulo,a.vinculo
       	        from par_modulos a,par_usuario b, par_rol c
				where b.idusuario = c.idusuario and
				      a.id_par_modulo = c.id_par_modulo and	
	                  a.publica = 'O' and a.ruta =".$bd->sqlvalue_inyeccion($modulo ,true)." and
	                  b.idusuario  =" .$bd->sqlvalue_inyeccion($_SESSION['usuario'] ,true).' 
				order by a.id_par_modulo' ;	
				
     
    echo '<ul class="nav nav-pills nav-stacked">';

	/*Ejecutamos la query*/
	$stmt = $bd->ejecutar($sql);
	/*Realizamos un bucle para ir obteniendo los resultados*/
	  $i = 0;
	  while ($x=$bd->obtener_fila($stmt)){
		 $clase ='';  
     /*    if ($i == 0 ){
		    $clase = 'class="active"';
		 } 
        */
        	$url = trim($x['vinculo']);
        	
			$modulo = trim($x['modulo']);
		    
			$enlace ="'".$url."'".','."''".",'".trim($x['modulo'])."'";
			
			$vinculo = 'javascript:open_enlace('.$enlace.')';

			//echo '<button class="'.$clase[$i].'" onClick="'.$vinculo.'">'.$modulo.'</button>';
			
            echo '<li '.$clase.'><a href="'.$vinculo.'"> '.$modulo.' </a></li>';
     										
			$i++;						 
	}
 
	echo '</ul>';
	
	$modulo = '';
	
	echo $modulo;
 
?>
  
  
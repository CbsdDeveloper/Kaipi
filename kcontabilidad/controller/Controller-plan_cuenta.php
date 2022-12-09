  <script >// <![CDATA[

  jQuery.noConflict();
  
  jQuery(function () {

	  jQuery('.tree li:has(ul)').addClass('parent_li').find(' > span').attr('title', 'Collapse this branch');
	  
	  jQuery('.tree li.parent_li > span').on('click', function (e) {
	        var children = jQuery(this).parent('li.parent_li').find(' > ul > li');
	        if (children.is(":visible")) {
	            children.hide('fast');
	            $(this).attr('title', 'Expand this branch').find(' > i').addClass('icon-folder-close').removeClass('icon-folder-open');
	        } else {
	            children.show('fast');
	            $(this).attr('title', 'Collapse this branch').find(' > i').addClass('icon-folder-open').removeClass('icon-folder-close');
	        }
	        e.stopPropagation();
	    });


 	});
  	 	    
</script>	
<?php   
session_start();

//folder-close 
//folder-open


require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

    $obj   = 	new objects;
	$bd	   =	new Db;	
   
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
    
    $id     = $_SESSION['ruc_registro'];
    
    $anio   = $_SESSION['anio'];
    
    
    if (isset($_GET['tipo']))	{
    	$tipo  = $_GET['tipo'] ;
    }
    if (isset($_GET['nivel']))	{
    	$nivel = $_GET['nivel'] ;
    }
    
    if ($tipo == '-'){
    	$sql_nivel1 = 'select detalle,cuenta,cuentas
 	                 FROM co_plan_ctas
                     where nivel = 1 and 
                           anio = '.$bd->sqlvalue_inyeccion($anio ,true).' and 
                           registro = '.$bd->sqlvalue_inyeccion($id ,true).'
                     ORDER BY cuenta,cuentas';
    	
    }
	else{
		$sql_nivel1 = 'select detalle,cuenta,cuentas
 	                 FROM co_plan_ctas
                     where nivel = 1 and 
                           anio = '.$bd->sqlvalue_inyeccion($anio ,true).' and 
                           tipo = '.$bd->sqlvalue_inyeccion($tipo,true). '  and 
                           registro = '.$bd->sqlvalue_inyeccion($id ,true).'
                     ORDER BY cuenta,cuentas';
		
	}

 
	
	
    $stmt_nivel1 = $bd->ejecutar($sql_nivel1);
    
	/*Realizamos un bucle para ir obteniendo los resultados treeview-expandible */
 
    $formulario = '';
 
	echo '<div class="tree well">   <ul><li> <span><i class="icon-folder-open"></i> Plan de cuentas</span> 
				<ul>';
					   while ($x=$bd->obtener_fila($stmt_nivel1)){
							  $titulo_nivel1 						= trim($x['detalle']);
							  $id_departamento_nivel1               = trim($x['cuenta']);
							  $plan = $id_departamento_nivel1.'-'.$titulo_nivel1;
 							  
							  $evento = 'javascript:goToURLArbol('."'".trim($id_departamento_nivel1)."'".')';
							  
							  echo ' <li> <span><i class="icon-folder-open"></i></span><a href="'.$evento.'">'.$plan.'</a>';
							  if ($nivel <> 1){
 											niveles(trim($id_departamento_nivel1),$bd,$obj,$formulario);
							  }				
							  echo '</li>'; 

					   }  
    echo '  </ul> </li>  </ul>  </div>';
    
//---------------------------------------------------------------------------------------------------    
function niveles($idhijo,$bd,$obj,$formulario ){
 
 
$id         = $_SESSION['ruc_registro'];
$anio       = $_SESSION['anio'];

 
$sql1       = 'SELECT count(*) as existe
	             FROM co_plan_ctas  
                WHERE trim(cuentas) ='.$bd->sqlvalue_inyeccion(trim($idhijo) ,true).' and 
                      anio = '.$bd->sqlvalue_inyeccion($anio ,true).' and 
                      registro = '.$bd->sqlvalue_inyeccion($id ,true);
 
$resultado1 = $bd->ejecutar($sql1);
	
$datos_valida = $bd->obtener_array( $resultado1);

 
     
if ($datos_valida['existe'] == 0){
        echo ' ';
}
     else{
		 
        $sql_nivel2 = "SELECT detalle,cuenta,cuentas,nivel,univel
				  FROM co_plan_ctas
				  where trim(cuentas) =".$bd->sqlvalue_inyeccion(trim($idhijo) ,true).' and 
                        anio = '.$bd->sqlvalue_inyeccion($anio ,true).' and 
                        registro = '.$bd->sqlvalue_inyeccion($id ,true).' ORDER BY cuenta';
      
        $stmt_nivel2 = $bd->ejecutar($sql_nivel2);
 
        
        echo '<ul>'; 
              while ($y=$bd->obtener_fila($stmt_nivel2)){
                     $titulo_nivel2 		    = trim($y['detalle']);
	                 $id_departamento_nivel2    = trim($y['cuenta']);
					 //$nivel2  					= $y['nivel'];
					 $ultimonivel 				= $y['univel'];
                     $plan						= $id_departamento_nivel2.'-'.$titulo_nivel2;
					 
                     $evento = 'javascript:goToURLArbol('."'".trim($id_departamento_nivel2)."'".')';
                     $set    = '' ;
                     
                     if ($ultimonivel== 'N'){
                     	 $cierre =  '<li> <span><i class="icon-folder-open"></i> </span> <a href="'.$evento.'">'.$plan.'</a>';
					   }else{
					   	 $cierre = '<li> <span><i class="icon-edit"></i> </span><a href="'.$evento.'">'.$plan.'</a>';
					   }
					     
					   echo $cierre;
                            niveles(trim($id_departamento_nivel2),$bd,$obj,$formulario,$set);
                      echo '</li>';  
                      
              }             
              echo '</ul>';
     }
 	  
   }    
 ?>

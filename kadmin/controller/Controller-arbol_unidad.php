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

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

    $obj   = 	new objects;
	$bd	   =	new Db;	
   
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
    
    $id = $_SESSION['ruc_registro'];
    
 
   $sql_nivel1 = 'select nombre,id_departamento,id_departamentos
 	                 FROM nom_departamento
                     where nivel = 0  and ruc_registro = '.$bd->sqlvalue_inyeccion($id ,true).'
                     ORDER BY id_departamento,id_departamentos';
 
 
   
    $stmt_nivel1 = $bd->ejecutar($sql_nivel1);
	/*Realizamos un bucle para ir obteniendo los resultados treeview-expandible */
 
 	  echo '<div class="tree well">
				   <ul>';

	echo '  <li> <span><i class="icon-folder-open"></i> Unidades Administrativas</span> 
				<ul>';
					   while ($x=$bd->obtener_fila($stmt_nivel1)){
							  $titulo_nivel1 						= trim($x['nombre']);
							  $id_departamento_nivel1   = trim($x['id_departamento']);
							  $plan =  $titulo_nivel1;
 							  
							  $evento = 'javascript:goToURLArbol('.  $id_departamento_nivel1  .')';
							  
							  echo ' <li> <span><i class="icon-folder-open"></i></span><a href="'.$evento.'">'.$plan.'</a>';
							  
 									 niveles($id_departamento_nivel1,$bd,$obj,$formulario);
							 		
							  echo '</li>'; 

					   }  
    echo '  </ul>
				</li>
              </ul>
           </div>';
    
//---------------------------------------------------------------------------------------------------    
function niveles($idhijo,$bd,$obj,$formulario ){
 
 
$id         = $_SESSION['ruc_registro'];
 
$sql1       = "SELECT count(*) as existe
	             FROM nom_departamento  
                WHERE id_departamentos ='".trim($idhijo)."' and ruc_registro = ".$bd->sqlvalue_inyeccion($id ,true);
 
$resultado1 = $bd->ejecutar($sql1);
	
$datos_valida = $bd->obtener_array( $resultado1);

 
 
if ($datos_valida['existe'] == 0){
        echo ' ';
}
     else{
		 
        $sql_nivel2 = "SELECT nombre,id_departamento,id_departamentos, nivel,univel
				  FROM nom_departamento
				  where id_departamentos ='".trim($idhijo)."' and ruc_registro = ".$bd->sqlvalue_inyeccion($id ,true).
           ' ORDER BY id_departamento';
      
        $stmt_nivel2 = $bd->ejecutar($sql_nivel2);
        
        echo '<ul>'; 
        
              while ($y=$bd->obtener_fila($stmt_nivel2)){
                     $titulo_nivel2 			 = trim($y['nombre']);
	                 $id_departamento_nivel2     = trim($y['id_departamento']);
					 $nivel2  			 = $y['nivel'];
					 $ultimonivel 		 = $y['univel'];
                   //  $plan										 = $id_departamento_nivel2.'-'.$titulo_nivel2;
					 $plan		 =  $titulo_nivel2;
					 
                     $evento = 'javascript:goToURLArbol('. $id_departamento_nivel2 .')';
                     
                     if ($ultimonivel == 'N'){
                     	$cierre =  '<li> <span><i class="icon-folder-open"></i> </span> <a href="'.$evento.'">'.$plan.'</a>';
					   }else{
					   	$cierre = '<li> <span><i class="icon-edit"></i> </span><a href="'.$evento.'">'.$plan.'</a>';
					   }
					     
					   echo $cierre;
                            niveles($id_departamento_nivel2,$bd,$obj,$formulario,$set);
                      echo '</li>';  
                      
              }             
              echo '</ul>';
     }
 	  
   }    
 ?>

<script>
$(function(){
    
    $('.tree li:has(ul)').addClass('parent_li').find(' > span').attr('title', 'Collapse this branch');
    $('.tree li.parent_li > span').on('click', function (e) {
        var children = $(this).parent('li.parent_li').find(' > ul > li');
        if (children.is(":visible")) {
            children.hide('fast');
            $(this).attr('title', 'Expand this branch').find(' > i').addClass('icon-plus-sign').removeClass('icon-minus-sign');
        } else {
            children.show('fast');
            $(this).attr('title', 'Collapse this branch').find(' > i').addClass('icon-minus-sign').removeClass('icon-plus-sign');
        }
        e.stopPropagation();
    });
	
});
</script>
<?php   
 
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

 	$bd	   =	new Db;	
   
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
    
    
     
    //--------------------------------------------
    $sqlDepa = "SELECT   idunidad, unidad
		    FROM flow.view_proceso_estado
			 WHERE publica = 'S' 
            GROUP BY idunidad, unidad";

 
    
    $stmt_depa= $bd->ejecutar($sqlDepa);
    
    //--------------------------------------------------------
    
 	echo '<div class="tree well" style="padding: 1px">
			<ul>
			 <li>
			  <span><i class="icon-folder-open"></i> Procesos</span>
				 <ul> ';
			  				 while ($y=$bd->obtener_fila($stmt_depa)){
			  					echo '<li>';
			  				 	$unidad			 = trim($y['unidad']);
			  				 	$id_departamento =  $y['idunidad'];
			  				 	echo '<span><i class="icon-minus-sign"></i> '.$unidad.'</span>';
			  				 	niveles($id_departamento,$bd);
			  				 	echo '</li>';
			  				 }
			    
							echo ' 
 					</ul>
				</li>
 			</ul>
		</div>';

function niveles($idepar,$bd){
 
    
	$sqlunidad = "SELECT proceso, idproceso, usuario, publica, responsable, idunidad, unidad
		    FROM flow.view_proceso_estado
			 WHERE publica = 'S' and idunidad= ".$idepar;
	
	$stmt_nivel2= $bd->ejecutar($sqlunidad);
	
	echo '<ul>';
	while ($z=$bd->obtener_fila($stmt_nivel2)){
	    
		$bene = trim($z['proceso']);
	 	
		$razon = ' <a href="#" onClick="goToURL('. $z['idproceso'].','."'".strtoupper($bene)."'". ')">'.$bene.'</a>';
		echo '<li> <span><i class="icon-leaf"></i> '.$razon.'</span></li>';
	}
 										 
	 echo '</ul>';
	
}

?>

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
   
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
    
    //$id = $_SESSION['ruc_registro'];
    
    /*Realizamos un bucle para ir obteniendo los resultados treeview-expandible */
    

    $AUsuario = $bd->query_array('par_usuario',
                                       'login, email,    cedula,    tarea, completo,   id_departamento', 
                                       'idusuario='.$bd->sqlvalue_inyeccion($_SESSION['usuario'],true)
                );
    
 
    
    //--------------------------------------------
    $sqlDepa = "SELECT   ambito_proceso 
                FROM  flow.view_proceso_inicio
                group by ambito_proceso
                order by ambito_proceso desc";

 
    $id_departamento = $AUsuario['id_departamento'];
    
    $stmt_depa= $bd->ejecutar($sqlDepa);
    
    //--------------------------------------------------------
    
    echo  '<h6 align="center"><b> Bandeja de '.$AUsuario['completo'].   
          '</b></h6><div class="tree" style="padding: 1px;background-color:#F4F4F4">
			<ul>
			 <li>
			  <span><i class="icon-folder-open"></i> Procesos</span>
				 <ul> ';
			  				 while ($y=$bd->obtener_fila($stmt_depa)){
			  					echo '<li>';
			  				 	$nombre			 =  trim($y['ambito_proceso']);
			  				 	$ambito_proceso  =  trim($y['ambito_proceso']);
			  				 	echo '<span><i class="icon-minus-sign"></i> '.$nombre.'</span>';
			  				 	niveles($id_departamento,$ambito_proceso,$bd);
			  				 	echo '</li>';
			  				 }
			    
							echo ' 
 					</ul>
				</li>
 			</ul>
		</div>';

function niveles($id_departamento,$ambito_proceso,$bd){
 
 
    if (trim($ambito_proceso) == 'publico'){
        
        $sqlunidad = "SELECT  idproceso, proceso,ambito_proceso
                        FROM  flow.view_proceso_inicio
                       where ambito_proceso = 'publico'";
    }else{
        $sqlunidad = "SELECT  idproceso, proceso,ambito_proceso
                        FROM  flow.view_proceso_inicio
                       where ambito_proceso = 'privado' and idunidad =".$id_departamento;
    }
 
	
	$stmt_nivel2= $bd->ejecutar($sqlunidad);
	
	echo '<ul>';
	
	while ($z=$bd->obtener_fila($stmt_nivel2)){
	    
		$bene = trim($z['proceso']);
	 	
		$razon = ' <a href="#" onClick="goToURL('. $z['idproceso']. ')">'.$bene.'</a>';
		
		echo '<li> <span><i class="icon-leaf"></i> '.$razon.'</span></li>';
	}
 										 
	 echo '</ul>';
	
}
?>
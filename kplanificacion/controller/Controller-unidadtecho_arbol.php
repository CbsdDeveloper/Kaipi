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

//folder-close 
//folder-open
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

    $obj   = 	new objects;
	$bd	   =	new Db;	
   
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
    
    $sesion 	 =  trim($_SESSION['email']);
    
    $codigo      = $_GET['codigo'];
     
    $_SESSION['id_periodo'] =  $bd->_periodo( $_GET['anio'] );
    
    
    
    
   if ($codigo <> '-'){
   		//----- seleccion de variables
   		$AResultado = $bd->query_array('nom_departamento',
   									   'nombre, nivel,id_departamentos', 
   									   'id_departamento='.$bd->sqlvalue_inyeccion($codigo,true)
   		);
   	 
   		
   		$titulo = ' '.$AResultado['nombre'];
   	
   		$union = "union SELECT id_departamento, id_departamentos, nombre, nivel
                  FROM public.nom_departamento
                 where  id_departamento = ".$bd->sqlvalue_inyeccion( $codigo  ,true);
   		
   	    //----- seleccion de detalles
   		$sql_nivel1 = 'SELECT id_departamento, id_departamentos, nombre, nivel
 	                 FROM nom_departamento
                     WHERE id_departamento  = '.$bd->sqlvalue_inyeccion($codigo,true).$union.'
                     ORDER BY 2,1';
 
    	 
    }
    else{
    	
        $sql_nivel1 = PerfilSqlUsuario($bd,$sesion);
    	
    	$titulo ='Estructura Organizacional';
    	
     }
 

    
    $nivel = 1;
 
	
    $stmt_nivel1 = $bd->ejecutar($sql_nivel1);
	/*Realizamos un bucle para ir obteniendo los resultados treeview-expandible */
 
    echo '<div class="tree well"> <ul>';

	echo '  <li> <span><i class="icon-folder-open"></i>'.$titulo.'</span> 
				<ul>';
					   while ($x=$bd->obtener_fila($stmt_nivel1)){
							  $titulo_nivel1 						= trim($x['nombre']);
							  $id_departamento_nivel1   			= trim($x['id_departamento']);
							  $ultimonivel 						    = $x['nivel'];

							//  $plan = $id_departamento_nivel1.'-'.$titulo_nivel1.'-'.$ultimonivel;
							
							  $plan = $titulo_nivel1;
							  
							  $evento1 = 'goToURLDato('."'".trim($id_departamento_nivel1)."'".')';
							  
							  $eventoClic = ' onClick="'.$evento1.'" ';
							  
							  if ($ultimonivel== 'S'){
							  	  $ico = 'icon-edit';
							  }else{
 								  $ico = 'icon-edit icon-folder-close';
  							  }
							  
							  echo ' <li> <span><i class="'.$ico.'"></i></span><a href="#"'.$eventoClic.'>'.$plan.'</a>';
						
							  	niveles($id_departamento_nivel1,$bd,$obj,$nivel);
					 			
							  echo '</li>'; 

					   }  
    echo '  </ul>
				</li>
              </ul>
           </div>';
    
//---------------------------------------------------------------------------------------------------    
 function niveles($idhijo,$bd,$obj,$nivel){
 
   
   $nivel = $nivel + 1;
    	
   
   $sql1 = "SELECT  id_departamento, id_departamentos, nombre,
                      atribuciones, competencias, ubicacion, nivel, univel,
                      estado, ambito, siglas, secuencia, programa
             FROM public.nom_departamento 
            where id_departamentos =" .$bd->sqlvalue_inyeccion($idhijo,true)." 
            order by id_departamento, id_departamentos";
   
 
   $stmt_nivel2 = $bd->ejecutar($sql1);
   
   
   echo '<ul>';
   
   while ($y=$bd->obtener_fila($stmt_nivel2)){
   	
   	$titulo_nivel2 			= trim($y['nombre']);
   	$id_departamento_nivel2 = trim($y['id_departamento']);
  // 	$nivel2  				= $y['nivel'];
   	$ultimonivel 			= $y['univel'];
   	//$plan					= $id_departamento_nivel2.'-'.$titulo_nivel2;
   	$plan					= $titulo_nivel2;
    
			   	
			   	$evento1 = 'goToURLDato('."'".trim($id_departamento_nivel2)."'".')';
			   	
			   	$eventoClic = ' onClick="'.$evento1.'" ';
			 	   	
			   	if ($ultimonivel== 'N'){
			   		$cierre =  '<li> <span><i class="icon-folder-open"></i> </span> <a href="#"'.$eventoClic.'>'.$plan.'</a>';
			   	}else{
			   		$cierre =  '<li> <span><i class="icon-edit"></i> </span> <a href="#"'.$eventoClic.'>'.$plan.'</a>';
			   		
			   	}
   	
			   	echo $cierre;
			 
			   	niveles($id_departamento_nivel2,$bd,$obj,$nivel);
   	
   	echo '</li>';
   	
   }
   echo '</ul>';
   
 
   }    
   
   //---------------
   function PerfilSqlUsuario($bd,$sesion){
   	
       // admin planificacion  
       
       $x = $bd->query_array('par_usuario','tipo,id_departamento', 'email='.$bd->sqlvalue_inyeccion($sesion,true)) ;
       
 
       $WHERE = "where  id_departamento = ".$bd->sqlvalue_inyeccion( $x['id_departamento'] ,true);
       
   
       
       
       
       if (  trim($x['tipo']) == 'admin'  ){
           $WHERE = "where  nivel >= 1 ";
         
       }
           
           
       if (  trim($x['tipo']) == 'planificacion'  ){
           $WHERE = "where  nivel >= 1 ";
          
       }
           
               
       
       $sql =  " SELECT id_departamento, id_departamentos, nombre, nivel, univel, estado              
                FROM public.nom_departamento ". $WHERE. ' order by id_departamento, id_departamentos ';
       
   	 
 
   	
   	return $sql;
   	
   	
   }
 ?>

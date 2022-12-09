<?php 

session_start( );  
 
function navegador_opciones($bd, $obj){
	 
     $id = $_SESSION['ruc_registro'];

       $sql = "select a.script ,a.id_par_modulo 
						from par_modulos a  
						where  a.fid_par_modulo = 0 and a.publica = 'S' and a.tipo = 'A' and 
							   a.id_par_modulo in (select b.fid_par_modulo 
							                         from view_roles b 
													 where  b.idusuario =".$bd->sqlvalue_inyeccion($_SESSION['usuario'], true)." )
						order by a.id_par_modulo";
	 				  
            /*Ejecutamos la query b.idusuario = c.idusuario and */
            $stmt = $bd->ejecutar($sql);
            /*Realizamos un bucle para ir obteniendo los resultados*/
            $i= 1;
            $k = 0;
            while ($x=$bd->obtener_fila($stmt)){
             if ($i==1){
              echo utf8_encode('<li><a href="javascript:void(0);"><i class="icon-foursquare"></i>Gestión Administrativa</a><ul class="sub-menu">');
              $k  = 1;
              }
               echo  ($x['0']);
              $i++;
             }
             if ($k == 1)
               echo '</ul></li>';
        
                 $sql = "select a.script ,a.id_par_modulo 
						from par_modulos a  
						where  a.fid_par_modulo = 0 and a.publica = 'S' and a.tipo = 'F' and 
							   a.id_par_modulo in (select b.fid_par_modulo 
							                         from view_roles b 
													 where  b.idusuario =".$bd->sqlvalue_inyeccion($_SESSION['usuario'], true)." )
						order by a.id_par_modulo";
              /*Ejecutamos la query b.idusuario = c.idusuario and */
              $stmt = $bd->ejecutar($sql); /*Realizamos un bucle para ir obteniendo los resultados*/
              $i= 1;
              $k = 0;
              while ($x=$bd->obtener_fila($stmt)){
                if ($i==1){	//   echo '<li class="current">
                  echo utf8_encode('<li><a href="javascript:void(0);"><i class="icon-windows"></i>Gestión Financiera</a><ul class="sub-menu">');
                  $k  = 1;
                 }
                 echo  ($x['0']);
                 $i++;
                }
                if ($k == 1)
                    echo '</ul></li>';
        
                $sql = "select a.script ,a.id_par_modulo 
						from par_modulos a  
						where  a.fid_par_modulo = 0 and a.publica = 'S' and a.tipo = 'E' and 
							   a.id_par_modulo in (select b.fid_par_modulo 
							                         from view_roles b 
													 where  b.idusuario =".$bd->sqlvalue_inyeccion($_SESSION['usuario'], true)." )
						order by a.id_par_modulo";
			 		 
                $stmt = $bd->ejecutar($sql); /*Ejecutamos la query*/
                $i= 1;
                $k = 0;
                while ($x=$bd->obtener_fila($stmt)){
                   if ($i==1){	//   echo '<li class="current">
                    echo utf8_encode('<li><a href="javascript:void(0);"><i class="icon-bar-chart"></i>Gestión Empresarial</a><ul class="sub-menu">');
                    $k  = 1;
                   }
                   echo  ($x['0']);
                   $i++;
                }
                if ($k == 1)
                  echo '</ul></li>';
	 
}   
function navegador_mopciones($bd, $obj){
	 
	 /*
	  <li class="active"><a href="#">Home</a></li>
                            <li class="dropdown">
                              <a class="dropdown-toggle" data-toggle="dropdown" href="#">Menu 1 <span class="caret"></span></a>
                              <ul class="dropdown-menu">
                                <li><a href="#">Submenu 1-1</a></li>
                                <li><a href="#">Submenu 1-2</a></li>
                                <li><a href="#">Submenu 1-3</a></li>                        
                              </ul>
                            </li>
							
                            <li><a href="#">Menu 2</a></li>
                            <li><a href="#">Menu 3</a></li>*/
							
     $id = $_SESSION['ruc_registro'];

           $sql = "select a.script ,a.id_par_modulo,a.modulo,a.ruta 
						from par_modulos a  
						where  a.fid_par_modulo = 0 and a.publica = 'S' and a.tipo = 'A' and 
							   a.id_par_modulo in (select b.fid_par_modulo 
							                         from view_roles b 
													 where  b.idusuario =".$bd->sqlvalue_inyeccion($_SESSION['usuario'], true)." )
						order by a.id_par_modulo";
						
			 
            /*Ejecutamos la query b.idusuario = c.idusuario and */
            $stmt = $bd->ejecutar($sql);
            /*Realizamos un bucle para ir obteniendo los resultados*/
            $i= 1;
            $k = 0;
			
			echo '<li class="dropdown">';
			echo  utf8_encode('<a class="dropdown-toggle" data-toggle="dropdown" href="#" class="active">Gestión Administrativa<span class="caret"></span></a>');
			
            while ($x=$bd->obtener_fila($stmt)){
				 if ($i==1){
					 echo '<ul class="dropdown-menu">';
					$k  = 1;
				  }
				 //  echo '<li><a href="#">Submenu 1-1</a></li>';
				   echo $x['0'];
				  $i++;
             }
			 
             if ($k == 1){
               echo '</ul></li>';
			 }
			 else
			 {
				 echo '</li>';
			 }  
        
		    //----------------------------------------------------------------------------------------------
			  $sql = "select a.script ,a.id_par_modulo,a.modulo,a.ruta 
						from par_modulos a  
						where  a.fid_par_modulo = 0 and a.publica = 'S' and a.tipo = 'F' and 
							   a.id_par_modulo in (select b.fid_par_modulo 
							                         from view_roles b 
													 where  b.idusuario =".$bd->sqlvalue_inyeccion($_SESSION['usuario'], true)." )
						order by a.id_par_modulo";
						
			 
            /*Ejecutamos la query b.idusuario = c.idusuario and */
            $stmt = $bd->ejecutar($sql);
            /*Realizamos un bucle para ir obteniendo los resultados*/
            $i= 1;
            $k = 0;
			
			echo '<li class="dropdown">';
			echo  utf8_encode('<a class="dropdown-toggle" data-toggle="dropdown" href="#" class="active">Gestión Financiera<span class="caret"></span></a>');
			
            while ($x=$bd->obtener_fila($stmt)){
				 if ($i==1){
					 echo '<ul class="dropdown-menu">';
					$k  = 1;
				  }
				 //  echo '<li><a href="#">Submenu 1-1</a></li>';
				   echo $x['0'];
				  $i++;
             }
			 
             if ($k == 1){
               echo '</ul></li>';
			 }
			 else
			 {
				 echo '</li>';
			 }  
		 //----------------------------------------------------------------------------------------------
			  $sql = "select a.script ,a.id_par_modulo,a.modulo,a.ruta 
						from par_modulos a  
						where  a.fid_par_modulo = 0 and a.publica = 'S' and a.tipo = 'E' and 
							   a.id_par_modulo in (select b.fid_par_modulo 
							                         from view_roles b 
													 where  b.idusuario =".$bd->sqlvalue_inyeccion($_SESSION['usuario'], true)." )
						order by a.id_par_modulo";
						
			 
            /*Ejecutamos la query b.idusuario = c.idusuario and */
            $stmt = $bd->ejecutar($sql);
            /*Realizamos un bucle para ir obteniendo los resultados*/
            $i= 1;
            $k = 0;
			
			echo '<li class="dropdown">';
			echo  utf8_encode('<a class="dropdown-toggle" data-toggle="dropdown" href="#" class="active">Gestión Empresarial<span class="caret"></span></a>');
			
            while ($x=$bd->obtener_fila($stmt)){
				 if ($i==1){
					 echo '<ul class="dropdown-menu">';
					$k  = 1;
				  }
				 //  echo '<li><a href="#">Submenu 1-1</a></li>';
				   echo $x['0'];
				  $i++;
             }
			 
             if ($k == 1){
               echo '</ul></li>';
			 }
			 else
			 {
				 echo '</li>';
			 }  
		
              /*
        
                $sql = "select a.script ,a.id_par_modulo 
						from par_modulos a  
						where  a.fid_par_modulo = 0 and a.publica = 'S' and a.tipo = 'E' and 
							   a.id_par_modulo in (select b.fid_par_modulo 
							                         from view_roles b 
													 where  b.idusuario =".$bd->sqlvalue_inyeccion($_SESSION['usuario'], true)." )
						order by a.id_par_modulo";
			 		 
                $stmt = $bd->ejecutar($sql);  
                $i= 1;
                $k = 0;
                while ($x=$bd->obtener_fila($stmt)){
                   if ($i==1){	//   echo '<li class="current">
                    echo utf8_encode('<li><a href="javascript:void(0);"><i class="icon-bar-chart"></i>Gestión Empresarial</a><ul class="sub-menu">');
                    $k  = 1;
                   }
                   echo  ($x['0']);
                   $i++;
                }
                if ($k == 1)
                  echo '</ul></li>';*/
	 
}  
//------------------------------------------------------------------------
// retorna el valor del campo para impresion de pantalla
 function web_sitio( $bd, $obj){
 
 $id = $_SESSION['ruc_registro'];

	$sql = "SELECT web,mision,vision
			  FROM web_registro
			  where ruc_registro =".$bd->sqlvalue_inyeccion($id ,true);
				$resultado = $bd->ejecutar($sql);
				$aruc_registro = $bd->obtener_array( $resultado);

 
	 echo $aruc_registro['web'] ;
  }  
//------------------------------------------------------------------------
// retorna el valor del campo para impresion de pantalla
 function ventas_count( $bd, $obj){
 
    
  	$anio =  date('Y');
   	$id = $_SESSION['ruc_registro'];

	$sql = "SELECT COUNT(*) as total
          FROM co_ventas
          WHERE extract(year from fechaemision) = ".$anio."  AND registro = ".$bd->sqlvalue_inyeccion($id ,true);
      
  	$resultado = $bd->ejecutar($sql);
 	$aruc_registro = $bd->obtener_array( $resultado);

    echo $aruc_registro['total'] ;
  } 
 
 //------------------------------------------------------------------------
// retorna el valor del campo para impresion de pantalla
 function compras_count($bd, $obj ){
 
    
  	$anio =  date('Y');
   	$id = $_SESSION['ruc_registro'];

	$sql = "SELECT COUNT(*) as total
          FROM co_compras
          WHERE extract(year from fechaemision) = ".$anio."  AND registro = ".$bd->sqlvalue_inyeccion($id ,true);
      
  	$resultado = $bd->ejecutar($sql);
 	$aruc_registro = $bd->obtener_array( $resultado);

    echo $aruc_registro['total'] ;
  }  
 // retorna el valor del campo para impresion de pantalla
 function clientes_count( $bd, $obj){
	 
    
  	$anio =  date('Y');
   	$id = $_SESSION['ruc_registro'];

	$sql = "SELECT count(*) as total
              FROM par_ciu
              WHERE modulo = 'C'  and estado = 'S'" ;
                  
  	$resultado = $bd->ejecutar($sql);
 	$aruc_registro = $bd->obtener_array( $resultado);

    echo $aruc_registro['total'] ;
  }   
  // retorna el valor del campo para impresion de pantalla
 function proveedores_count($bd, $obj ){
 
    
  	$anio =  date('Y');
   	$id = $_SESSION['ruc_registro'];

	$sql = "SELECT count(*) as total
              FROM par_ciu
              WHERE modulo = 'P' and estado = 'S'" ;
                  
  	$resultado = $bd->ejecutar($sql);
 	$aruc_registro = $bd->obtener_array( $resultado);

    echo $aruc_registro['total'] ;
  }  
    // retorna el valor del campo para impresion de pantalla
 function tthh_count( $bd, $obj ){
 
    
  	$anio =  date('Y');
   	$id = $_SESSION['ruc_registro'];

	$sql = "SELECT count(*) as total
              FROM par_ciu
              WHERE modulo = 'N'  and estado = 'S'" ;
                  
  	$resultado = $bd->ejecutar($sql);
 	$aruc_registro = $bd->obtener_array( $resultado);

    echo $aruc_registro['total'] ;
  } 
     // retorna el valor del campo para impresion de pantalla
 function visitas_count(  $bd, $obj){
 
    
  	$anio =  date('Y');
   	$id = $_SESSION['ruc_registro'];

	$sql = "SELECT count(*) as total
              FROM web01_usuario " ;
                  
  	$resultado = $bd->ejecutar($sql);
 	$aruc_registro = $bd->obtener_array( $resultado);

    echo $aruc_registro['total'] ;
  }  
       // retorna el valor del campo para impresion de pantalla
 function miembros( $bd, $obj){
 
    $sql = "SELECT   login,  nombre,  url 
              FROM par_usuario
            WHERE   estado = 'S'" ;
	 				  
            /*Ejecutamos la query b.idusuario = c.idusuario and */
     $stmt = $bd->ejecutar($sql);
      while ($x=$bd->obtener_fila($stmt)){
        
        echo ' <li>
 				<img src="../../kimages/'.$x['url'].'"/>
 					   <a class="users-list-name" href="#">'.$x['nombre'].'</a>
                      <span class="users-list-date">'.$x['login'].'</span>
             </li>';
            // <img src="../kimages/'.$x['2'].'" alt="User Image"/>

	 
	  }   
  }  
  
  function miembroslista( $bd, $obj){
 
    $sql = "SELECT   login,  nombre,  url ,email
              FROM par_usuario
            WHERE   estado = 'S'" ;
	 				  
     /*Ejecutamos la query b.idusuario = c.idusuario and 
	 
	 <tr>  <td>
        <img src="http://bootdey.com/img/Content/user_1.jpg" alt="" width="20" height="20">
                                                        <a href="#" class="user-link">Full name 1</a>
                                                        
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="label label-default">pending</span>
                                                    </td>
                                                    <td>
                                                        <a href="#">marlon@brando.com</a>
                                                    </td>
                                                </tr>
	 
	 
	 */
     $stmt = $bd->ejecutar($sql);
	 while ($x=$bd->obtener_fila($stmt)){
  	   echo '<tr>';   
        
		echo '<td>
                 <img src="../kimages/'.$x['2'].'" width="25" height="25" />
                 <a href="#" class="user-link">'.$x['1'].'</a>
                   </td>
               <td class="text-center">
                 <span class="label label-default">acceso</span>
               </td>
               <td>
                  <a href="#">'.$x['3'].'</a>
               </td>';
	  
  		 echo '</tr>';   
      }   
  }  
 
      
function chat_msg( $bd, $obj ){
 
        
    $sesion 	 = $_SESSION['login'];
    
 	 $hoy 		 = $bd->hoy();      
   
     ///-------- busqyeda
     
      $sql = "SELECT  a.sesion,  a.fecha, a.mensaje,  b.url ,b.nombre
              FROM web_chat_directo a, par_usuario b
              where a.estado = 'E' and a.modulo = 'panel' and b.login = a.sesion  
              order by a.id_chat desc" ;
	 				  
 
      
            /*Ejecutamos la query b.idusuario = c.idusuario and */
            $stmt = $bd->ejecutar($sql);
            /*Realizamos un bucle para ir obteniendo los resultados*/
 
          $i = 0;
            while ($x=$bd->obtener_fila($stmt)){
                
                if($x['sesion'] == $sesion)
                {
                  $div_estilo =  '<div class="direct-chat-msg">';
                  $div_clase1 =  'direct-chat-name pull-left';
                  $div_clase2 =  'direct-chat-timestamp pull-right';
                }else{
                   $div_estilo =  ' <div class="direct-chat-msg right">'; 
                   $div_clase1 =  'direct-chat-name pull-right';
                   $div_clase2 =  'direct-chat-timestamp pull-left';
                }
  
               
                
             $result = $result.$div_estilo.'
                      <div class="direct-chat-info clearfix">
                        <span class="'.$div_clase1.'">'.$x['sesion'].'</span>
                        <span class="'.$div_clase2.'">'.$x['fecha'].'</span>
                      </div> 
                      <img class="direct-chat-img" src="../../kimages/'.$x['url'].'" title="message user image"  width="25" height="25"/>
					  <!-- /.direct-chat-img -->
                      <div class="direct-chat-text"><small>'.$x['mensaje'].'</small></div>  </div>' ;
              
             $i++;
           } 
           
     echo   $result;
  } 
  ?>
  
  
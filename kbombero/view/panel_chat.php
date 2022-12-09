<?php 
     session_start( );   
  
    require '../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
  
	require '../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/ 	 
 
   
 
    $obj   = 	new objects;
	$bd	   =	new Db;
    
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
    
 
     $sesion 	 = $_SESSION['login'];
 	 $hoy 		 = $bd->hoy();      
 	
     $mensaje = @$_POST["message"];
    
   	 if (!empty($mensaje)){
   	  
      $mensaje = (trim($mensaje));
           
      $sql = "INSERT INTO web_chat_directo( sesion, modulo,mensaje ,estado, fecha) values (".
                  $bd->sqlvalue_inyeccion($sesion, true).",".
                   $bd->sqlvalue_inyeccion('panel', true).",".
                   $bd->sqlvalue_inyeccion($mensaje, true).",".
                  $bd->sqlvalue_inyeccion('E', true).",".$hoy.")";   
                  
      $bd->ejecutar($sql);
     
     ///-------- busqyeda
     
      $sql = "SELECT  a.sesion,  a.fecha, a.mensaje,  b.url ,b.nombre
              FROM web_chat_directo a, par_usuario b
              where a.estado = 'E' and a.modulo = 'panel' and b.login = a.sesion
              order by a.id_chat desc" ;
	 				  
            /*Ejecutamos la query b.idusuario = c.idusuario and */
            $stmt = $bd->ejecutar($sql);
            /*Realizamos un bucle para ir obteniendo los resultados*/
           $result ='';
           
          
            while ($x=$bd->obtener_fila($stmt)){
                  
              if($x['0'] == $sesion)
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
                        <span class="'.$div_clase1.'">'.$x['0'].'</span>
                        <span class="'.$div_clase2.'">'.$x['1'].'</span>
                      </div> 
                      <img class="direct-chat-img" src="../kimages/'.$x['3'].'" alt="message user image" /><!-- /.direct-chat-img -->
                      <div class="direct-chat-text">'.$x['2'].'</div>  </div>' ;
             
           }
 
     echo $result ;
    }
  
     /////////////// llena para eliminar
 
 ?>
 
  
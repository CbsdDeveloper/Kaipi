<?php
     session_start( );
     
     require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
     require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
     require '../../kconfig/Db.emailMarket.php'; /*Incluimos el fichero de la clase objetos*/
     
     $obj   = 	new objects;
     $bd	   =	new Db;
     $mail  =	new EmailEnvio;
     
     $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
     
     $sesion         =  trim($_SESSION['email']);
     $razon_social   =  $_SESSION['razon'] ;
     
     
     $mail->_DBconexion( $obj, $bd );
     
     $mail->_smtp_factura_electronica( );
     
     $plantilla       = trim($_GET['plantilla']) ;
     $id_cartelera    = $_GET['id_cartelera'];


     $director         = trim($_GET['director']) ;
     $unidades        = trim($_GET['unidades']) ;

     $rol              = trim($_GET['rol']) ;

 
     
     
     $plantilla = $bd->query_array( 'ven_plantilla', 'contenido,   variable',   'id_plantilla='.$bd->sqlvalue_inyeccion($plantilla,true)
         );
     
     $x = $bd->query_array(  'nom_cartelera',  'asunto, notificacion, estado, sesion, fecha ',  'id_cartelera='.$bd->sqlvalue_inyeccion($id_cartelera ,true) );
     
     
     
       if (      $unidades  == 0  )   {


                    if (      $rol  == '9') {

                        $sql_valida = "select cedula as idprov, completo as razon,  email as correo 
                                        from par_usuario
                                        where coalesce(rol,'0') = ".$bd->sqlvalue_inyeccion($rol ,true) ;
                    }else{
                        $sql_valida = "select cedula as idprov, completo as razon,  email as correo 
                                        from par_usuario
                                        where director="		.$bd->sqlvalue_inyeccion( $director  ,true) ;
                    }


        } else  {
            $sql_valida = "select idprov, razon,   correo  
            from view_nomina_rol
                where estado="		.$bd->sqlvalue_inyeccion('S' ,true)." and
                id_departamento= ".$bd->sqlvalue_inyeccion($unidades ,true) ;
        } 

     
     
 
     	
           
     $content      =  str_replace ( '#notificacion' , trim($x['notificacion']) ,  $plantilla['contenido']);
     $content      =  str_replace ( '#empresa' , trim($razon_social) ,  $content);
     $content      =  str_replace ( '#fecha' , $x['fecha'] ,  $content);
     $imagen       =  $pagina_web.'kimages/'. trim($_SESSION['logo']) ;
     $content      =  str_replace ( '#imagen' , trim($imagen) ,  $content);
     $asunto_dato  = trim($x['asunto']);
    
     $i= 1;
     
     $stmt = $bd->ejecutar($sql_valida);
     
     while ($x=$bd->obtener_fila($stmt)){
         
         $idprov =  trim($x['idprov']);
         $idprov =  base64_encode($idprov);
         
         $razon  =  trim($x["razon"]);
         $correo =  trim($x["correo"]);
         
/*         $ruc  =  trim($_SESSION['ruc_registro']);
         $ruc  =  base64_encode($ruc);
         $enlace1 = $pagina_web.'reportes/R9lnom?us='.$_SESSION['us'].'&rd='.$ruc.'&db='.''.'&ac='.$_SESSION['ac'].'&i='.$idprov.'&r=1';
         $enlace2 = $pagina_web.'reportes/R9lnom?us='.$_SESSION['us'].'&rd='. $ruc.'&db='.''.'&ac='.$_SESSION['ac'].'&i='.$idprov.'&r=2';
         $content =  str_replace ( '#enlace1' , trim($enlace1) ,  $content);  
         $content =  str_replace ( '#enlace2' , trim($enlace2) ,  $content);  
         
         */
         $content =  str_replace ( '#empleado' , trim($razon) ,  $content);
         
         if (filter_var($correo, FILTER_VALIDATE_EMAIL)) {
             
             _envio($idprov,$razon,$correo,$content,$asunto_dato,$mail,$sesion);
             
         } 
        
      
         
         $i++;
         
     }
     
     $response = 'Mensaje Enviado '.$correo;
     
     echo $response;
     
  //--------------------------------------------------------------   
  //--------------------------------------------------------------   
     function _envio($idprov,$razon,$correo,$content,$asunto,$mail,$sesion){
      
         
      $mail->_DeCRM( $sesion, $_SESSION['razon']);
      
      $mail->_ParaCRM(trim($correo),trim($correo));
       
      $mail->_AsuntoCRM($asunto,$content );
       
      $response =  $mail->_EnviarElectronica();
      
      echo $response;
      
  }
     
    
?>
 
  
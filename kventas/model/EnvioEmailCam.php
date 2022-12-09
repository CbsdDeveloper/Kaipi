<?php 
session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    require '../../kconfig/Db.emailMarket.php'; /*Incluimos el fichero de la clase objetos*/
    
    $obj   = 	new objects;
    $bd	   =	new Db;
    $mail  =	new EmailEnvio;
    
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
    
    $sesion 	   =  trim($_SESSION['email']);
    
    //-----------------------------------------------------------------------
    
    $ASesion = $bd->query_array(
        'par_usuario',
        'completo',
        'email='.$bd->sqlvalue_inyeccion(trim($sesion),true) 
        );
    
 
    $sesion_nombre 	   =  trim($ASesion['completo']);
    
    
    $sql = "SELECT idvencliente,  razon,  correo,  proceso,  sesion,  id_campana
            FROM  ven_cliente
            where 
                  proceso   = ".$bd->sqlvalue_inyeccion( 'enviar' ,true)." and
                  estado    = ".$bd->sqlvalue_inyeccion('2',true)." and
                  sesion    =".$bd->sqlvalue_inyeccion($sesion,true)." limit 1";
    
  
 
    $stmt = $bd->ejecutar($sql);
 
    //-----------------------------------------------------------------------
    
    while ($fila=$bd->obtener_fila($stmt)){
        
        $id_campana   = $fila['id_campana'];
        $idvencliente = $fila['idvencliente'];
        
        
        $ACampana = $bd->query_array(
            'ven_campana',
            'publica,  titulo, tipo_envio, plantilla, fecha_email,asunto', 
            'id_campana='.$bd->sqlvalue_inyeccion(trim($id_campana),true). ' and 
                 estado='.$bd->sqlvalue_inyeccion('ejecucion',true)
            );
        
        $AContenido = $bd->query_array(
            'ven_plantilla',
            'contenido,   variable',
            'id_plantilla='.$bd->sqlvalue_inyeccion(trim($ACampana['plantilla']),true) 
            );
     
        
        // Formulario   Suscribete    Mas informacion -----------------------------------------
  
         $APie = $bd->query_array(
                                  'ven_registro',
                                  'pie,variable_mas,suscribete,formulario,urlmensaje',
                                  'idven_registro=1');
       
         $url_enlace = trim($APie['urlmensaje']);
         
         $var_url = '?ca='.base64_encode($id_campana).'&te='.
                           base64_encode($idvencliente).'&us='.
                           $bd->_us().'&db='.
                           $bd->_db().'&ac='.$bd->_ac();
      
                 
         
         if (trim($AContenido['variable']) == 'Mas informacion'){
             $mensaje_sistema =  trim($APie['variable_mas']); 
             $url = $url_enlace.'MasInformacion'.$var_url;
         }
         elseif(trim($AContenido['variable']) == 'Formulario'){
             $mensaje_sistema =  trim($APie['formulario']); 
             $url = $url_enlace.'FormularioDatos'.$var_url;
         }
         elseif(trim($AContenido['variable']) == 'Suscribete'){
              $mensaje_sistema =  trim($APie['suscribete']); 
              $url = $url_enlace.'SuscribeteAqui'.$var_url;
         }
             
         //-------------------------------------------------------------------------------------
         
         $variable =  str_replace ( '#url_email' , trim($url) ,  $mensaje_sistema);
         
         $contenido = str_replace ( '$nombre_email' , trim($fila['razon']) ,  $AContenido['contenido'] );
         
         if (trim($AContenido['variable']) == 'Mas informacion'){
             $contenido1 = str_replace ( '$mas_informacion' ,$variable , $contenido );
         }
         elseif(trim($AContenido['variable']) == 'Formulario'){
              
         }
         elseif(trim($AContenido['variable']) == 'Suscribete'){
             
         }
         
            
         $pie = str_replace ( '$nombre_email' ,  trim($fila['correo']),  $APie['pie'] );
        
         
         $urlBaja = $url_enlace.'DarBaja'.$var_url;
         
         $pie1 = str_replace ( '$baja' , $urlBaja ,  $pie );
         
         
         $content = trim($contenido1).$pie1;
         
         //-------------------------------------------------------------------------------------
        
         
         $mail->_DBconexion( $obj, $bd );
         
         $mail->_smtp_email(  trim($ACampana['tipo_envio']) );
         
         
        //------------------------------------------------------------------ 
         $asunto = trim($ACampana['asunto']) ; 
 
         
         $mail->_DeCRM( $sesion,$sesion_nombre);
         
         $mail->_ParaCRM(trim($fila['correo']),trim($fila['razon']));
              
         
         $mail->_AsuntoCRM($asunto,$content );
         
         
         
        $mensaje_enviado = $mail->_Enviar();
         
       
         
         
        $sqlEdit = "update ven_cliente
                                  set proceso  =".$bd->sqlvalue_inyeccion( 'enviado',true)."
                                where id_campana= ".$bd->sqlvalue_inyeccion($id_campana,true)." and
                                      estado= ".$bd->sqlvalue_inyeccion('2',true)." and
                                      sesion= ".$bd->sqlvalue_inyeccion($sesion,true)." and
                                      idvencliente= ".$bd->sqlvalue_inyeccion($idvencliente,true) ;
         
        
        
        $bd->ejecutar($sqlEdit);
  
        
        echo $mensaje_enviado;
         
   
    }
    
    
    
  
    
   
    
  
    
  
    
   
    
        

    
     
?>
 
  
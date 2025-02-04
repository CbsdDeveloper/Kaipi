 <?php 
 session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
	$obj   = 	new objects;
	$bd	   = 	new Db ;
	
 	
    
	$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	
	$sesion 	 =     trim($_SESSION['email']);
	
	$id_campana			=     $_GET["id"];
	$envio_email		=     $_GET["envio_email"];
	$tipo_envio			=     $_GET["tipo_envio"];
	$fecha_email		=     $_GET["fecha_email"];
	$plantilla		    =     $_GET["plantilla"];
	$asunto		        =     $_GET["asunto"];
	
	
 
	$bandera  =     $_GET["bandera"];
	
	
	

    
    $AContactos = $bd->query_array(
        'ven_cliente',
        'count(id_campana) as nn ', 
        'id_campana='.$bd->sqlvalue_inyeccion($id_campana,true).' and 
            sesion ='.$bd->sqlvalue_inyeccion($sesion,true) 
        );
    
     
   
    if ($bandera  == 0)  {
    
        $sqlEdit1 = "update ven_campana 
                                          set 
                                            envio_email  =".$bd->sqlvalue_inyeccion($envio_email,true).",
                                            tipo_envio   =".$bd->sqlvalue_inyeccion($tipo_envio,true).",
                                            asunto       =".$bd->sqlvalue_inyeccion($asunto,true).",
                                            plantilla    =".$bd->sqlvalue_inyeccion($plantilla,true).",
                                            contactos    =".$bd->sqlvalue_inyeccion($AContactos["nn"],true).",
                                            estado    =".$bd->sqlvalue_inyeccion('preparado',true).",
                                            fecha_email  =".$bd->fecha($fecha_email)."
                                        where id_campana= ".$bd->sqlvalue_inyeccion($id_campana,true)." and 
                                              estado =".$bd->sqlvalue_inyeccion('solicitado',true) ;
        
        $result = '<b>Proceso Generado con exito ... </b>' ;
        
        
        $sqlEdit = "update ven_cliente
                                  set proceso  =".$bd->sqlvalue_inyeccion('enviar',true)."
                                where id_campana= ".$bd->sqlvalue_inyeccion($id_campana,true)." and
                                      sesion= ".$bd->sqlvalue_inyeccion($sesion,true)." and
                                      proceso  is null and
                                      estado= ".$bd->sqlvalue_inyeccion('2',true) ;
        
        
        $bd->ejecutar($sqlEdit);
        
    }else{
        
        $sqlEdit1 = "update ven_campana
                                          set
                                            envio_email  =".$bd->sqlvalue_inyeccion($envio_email,true).",
                                            tipo_envio   =".$bd->sqlvalue_inyeccion($tipo_envio,true).",
                                            asunto       =".$bd->sqlvalue_inyeccion($asunto,true).",
                                            plantilla    =".$bd->sqlvalue_inyeccion($plantilla,true).",
                                            contactos    =".$bd->sqlvalue_inyeccion($AContactos["nn"],true).",
                                            estado    =".$bd->sqlvalue_inyeccion('ejecucion',true).",
                                            fecha_email  =".$bd->fecha($fecha_email)."
                                        where id_campana= ".$bd->sqlvalue_inyeccion($id_campana,true)." and
                                              estado =".$bd->sqlvalue_inyeccion('preparado',true) ;
        
        $result = '<b>Proceso generado con exito!!! ... </b> '. $id_campana ;
        
        $sqlEdit = "update ven_cliente
                                  set proceso  =".$bd->sqlvalue_inyeccion('enviar',true)."
                                where id_campana= ".$bd->sqlvalue_inyeccion($id_campana,true)." and
                                      sesion= ".$bd->sqlvalue_inyeccion($sesion,true)." and
                                      proceso  <> 'enviado' and
                                      estado= ".$bd->sqlvalue_inyeccion('2',true) ;
        
        
        $bd->ejecutar($sqlEdit);
        
    }
     
    $bd->ejecutar($sqlEdit1);
   
   
   
  
  
  echo $result;
  
?>
 
  
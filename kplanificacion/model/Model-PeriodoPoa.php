<?php 

session_start( );  
   	
require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
 

$obj   = 	new objects;
 $bd	   =	new Db;
    
   		 $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
       
   		 
   		 if (isset($_SESSION['POA_ANIO']))	{
   		 	
   		 	$year = $_SESSION['POA_ANIO'];
   		 	
   		 	$AResultado = $bd->query_array('VIEW_PERIODO',
   		 			'ANIO, TIPO,    IDPERIODO,    NOMBRE',
   		 			'ANIO ='.$bd->sqlvalue_inyeccion($year,true)
   		 			);
   		 	
   		 	
   		 	$_SESSION['POA_IDPERIODO'] =   $AResultado['IDPERIODO'];
   		 	
   		 	$_SESSION['POA_ESTADO']    =   $AResultado['TIPO'];
   		 	
   		 	$_SESSION['POA_ANIO']    =   $AResultado['ANIO'];
   		 	
   		 	$GestionPoa = '<b>'.$AResultado['NOMBRE'].'</b>';
   		 	
   		 	//-------------------------------------------- USUARIO
   		 	
   		 	$LOGIN =  $_SESSION['login'];
   		 	
   		 	$AUsuario = $bd->query_array(  'VIEW_USUARIOS',
   		 			'IDUNIDAD,TIPO,GESTIONATRAMITE,ESRESPONSABLE,ACTIVIDAD,EMAIL',
   		 			'USUARIO ='.$bd->sqlvalue_inyeccion($LOGIN,true)
   		 			);
   		 	
   		 	
   		 	$_SESSION['USER_UNIDAD']    =   $AUsuario['IDUNIDAD'];
   		 	
   		 	$_SESSION['USER_PERFIL']    =   $AUsuario['TIPO'];
   		 	
   		 	
   		 	$_SESSION['USER_TRAMITE']    =   $AUsuario['GESTIONATRAMITE'];
   		 	
   		 	$_SESSION['USER_RESPONSABLE']    =   $AUsuario['ESRESPONSABLE'];
   		 	
   		 	$_SESSION['USER_ACTIVIDAD']    =   $AUsuario['ACTIVIDAD'];
   		 	
   		 	$_SESSION['USER_EMAIL']        =   $AUsuario['EMAIL'];
   		 	
   		 	
   		 	echo '<script>$("#ANIO").val("'.$year.'");</script>';
   		 	
   		 	
   		 }else{
   		 	
   		 
 
   					 $year = date('Y');
   		 
			   		 $AResultado = $bd->query_array('VIEW_PERIODO',
			   		 								'ANIO, TIPO,    IDPERIODO,    NOMBRE', 
			   		 								'ANIO ='.$bd->sqlvalue_inyeccion($year,true)
			   		 				);
			   		 
			   		 
			   		 $_SESSION['POA_IDPERIODO'] =   $AResultado['IDPERIODO'];
			 
			   		 $_SESSION['POA_ESTADO']    =   $AResultado['TIPO'];
			   		 
			   		 $_SESSION['POA_ANIO']    =   $AResultado['ANIO'];
			 
			   		 $GestionPoa = '<b>'.strtoupper($AResultado['NOMBRE']).'</b>';
			   		 
			   		 //-------------------------------------------- USUARIO
			
			   		 $LOGIN =  $_SESSION['login'];
			   		 
			   		 $AUsuario = $bd->query_array(  'VIEW_USUARIOS',
									   		 		'IDUNIDAD,TIPO,GESTIONATRAMITE,ESRESPONSABLE,ACTIVIDAD,EMAIL',
			   		 								'USUARIO ='.$bd->sqlvalue_inyeccion($LOGIN,true)
									   		 		);
			   		 
			   		 
			   		 $_SESSION['USER_UNIDAD']    =   $AUsuario['IDUNIDAD'];
			   		 
			   		 $_SESSION['USER_PERFIL']    =   $AUsuario['TIPO'];
			   		 
			   		 
			   		 $_SESSION['USER_TRAMITE']    =   $AUsuario['GESTIONATRAMITE'];
			   		 
			   		 $_SESSION['USER_RESPONSABLE']    =   $AUsuario['ESRESPONSABLE'];
			   		 
			   		 $_SESSION['USER_ACTIVIDAD']    =   $AUsuario['ACTIVIDAD'];
			   		 
			   		 $_SESSION['USER_EMAIL']        =   $AUsuario['EMAIL'];
			   		 
			 
			   		 echo '<script>$("#ANIO").val("'.$year.'");</script>';
   		
   		 }
   		 
   		 $GestionPoa =  strtoupper($GestionPoa);
   		 
   		 echo $GestionPoa;
           
       
            
    
 
  ?> 
								
 
 
 
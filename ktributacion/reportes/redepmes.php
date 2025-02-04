<?php
 
    session_start( );  
 
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
     
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
    $obj     = 	new objects;
    
     $bd     = 	new Db;
    
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
    
 
  
     if (isset($_GET['anio']))	
     {
          $anio =  $_GET['anio']; 
		 
		  $mes =  $_GET['mes']; 
       
            
          $cadena1 =" '''' "; 
          $cadena =" '   ' ";
          
          $sql = "SELECT NOM01CEDUAL AS NROCEDULA,
							NOM01APELLIDOS AS APELLIDO,
							NOM01NOMBRE AS NOMBRE,
							ING_REMUNERACION AS REMUNERACION,
							ING_DECIMO3ER AS DECIMOTERCERO, 
							ING_DECIMO4TO AS DECIMOCUARTO,
							ING_OTROS_EMP AS ENCARGO_SUBROGRACION,
							FONDORESERVA,
							VIVIENDA, 
							SALUD, 
							EDUCACION, 
							ALIMENTACION, 
							VESTIDO, 
							BASE_IMPONIBLE, 
							IMPUESTORENTA AS IMPUESTO_RENTA,
							APORTEPERSONAL AS APORTEIESS
			 	FROM NOM_SRIRENTA 
                WHERE SESION =  USER
                order by NOM01APELLIDOS";
                
      }
       
  
       
    $resultado  = $bd->ejecutar($sql);
    
    $tipo 		= $bd->retorna_tipo();
    
    $tbHtml = $obj->grid->KP_GRID_EXCEL($resultado,$tipo); 
 
    header ('Content-type: text/html; charset=utf-8');
    header("Content-type: application/octet-stream");
 	header("Content-Disposition: attachment; filename=ResumenMensual". $anio.'-'.$mes.".xls");
	header("Pragma: no-cache");
	header("Expires: 0"); 

 	echo $tbHtml; 
    
    
?>
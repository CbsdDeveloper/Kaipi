<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
 
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
 
  	 		 
</head>
<body>
     <?php   
	
	  if (isset($_GET['notifica']))	{
            
            $accion        = $_GET['notifica'];
            $razon_social  = $_SESSION['razon'] ;
            $id            = $_GET['id'];
		  
		   require('SesionInicio.php') ;
            
		  $plantilla = $bd->query_array(
         'ven_plantilla',
         'contenido,   variable',
         'id_plantilla='.$bd->sqlvalue_inyeccion($id,true)
         );
     
         $x = $bd->query_array(
         'nom_cartelera',
         'asunto, notificacion, estado, sesion, fecha ',
         'id_cartelera='.$bd->sqlvalue_inyeccion($accion ,true)
         );
 
			   
		      $content =  str_replace ( '#notificacion' , trim($x['notificacion']) ,  $plantilla['contenido']);
              $content =  str_replace ( '#empresa' , trim($razon_social) ,  $content);
		  
		      echo $content;
     }  
	
	 ?> 
 </body>
</html>

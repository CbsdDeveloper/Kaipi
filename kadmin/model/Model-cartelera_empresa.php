<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


 
$bd	   =	new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);





$ruc    = trim($_SESSION['ruc_registro']);
 $login = trim($_SESSION['login']);
 
 
 if (isset($_GET['idchat']))	{
        
     $id        = $_GET['idchat'];
     
     $sql = 'delete from web_chat_directo  where id_chat='.$bd->sqlvalue_inyeccion($id, true);
     
     $bd->ejecutar($sql);
 
 }
 
 
 

 $sql0 = "SELECT id_chat, sesion, modulo,   fecha,mensaje
            FROM web_chat_directo
            where modulo = 'cartelera' and registro = ".$bd->sqlvalue_inyeccion( $ruc , true);
 
 
            $stmt1 = $bd->ejecutar($sql0);
        
           while ($fila=$bd->obtener_fila($stmt1)){
            
               $fecha = substr($fila['fecha'], 0,10);
               
               $elimina = ' ';
               
               if ( $login == trim($fila['sesion']) ){
                   $elimina = '<img src="../../kimages/kdel.png" onClick="EliminaChat('.$fila['id_chat'].')" width="20" height="20" title="Eliminar"/> ';
               }
               
               echo '<div class="col-md-2">
			          <div style="background-image: url(../../kimages/post_tipo.png); height: 256px"  align="center">
					     <p align="center" style="padding-top: 60px;padding-left:30px;padding-right:25px;">
	  	    		     <span style="font-size: 13px;font-weight: 600">'.$fila['mensaje'].'</span> <br>
                         '.$fecha.'<br>'.$fila['sesion'].'
					</p>	
			         '.$elimina.' 
			       </div>
		        </div>	 ';
               
             
            
           }
        
       
   
 
?>
 
  
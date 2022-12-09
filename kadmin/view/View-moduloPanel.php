<style>

	
a.list-group-item:hover {
  background:#F0F0F0;
}
	
a.list-group-item {
  color: #555;
font-size: 12px;
}
		

		
</style>

<?php
session_start( );
require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
  
$bd	   = new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

$idUsuario  = $_SESSION['usuario'];

$x 			= $bd->query_array('par_usuario',
                               'tipo', 
                               'idusuario='.$bd->sqlvalue_inyeccion($idUsuario,true) );

$boton 		= '';
    
$sql 		= "SELECT  ruta, modulo, detalle, logo, estado, publica
				 FROM view_perfil_inicio
			    WHERE publica <> 'X' and 
					  idusuario =  " . $bd->sqlvalue_inyeccion($idUsuario ,true).' 
			    order by modulo';

$stmt 		= $bd->ejecutar($sql);
 

$kaipiMain = '<div class="list-group">';

    while ($x=$bd->obtener_fila($stmt)){
 		 
         $url		= trim($x['ruta']);

         $modulo 	= trim($x['modulo']);
         
         $publica	= trim($x['publica']);
        
         if ($publica <> 'X'){
             
            $url = '../../'.$url;
         } 
         
         if ($url == '../../kadmin'){
            $url = 'inicio';
         } 
 
		$kaipiMain .= ' <a class="list-group-item"   href="'.$url.'"> '.$modulo.' </a>';   
			 
   
  }
    
    $kaipiMain .= $boton;
    
    $kaipiMain .= '</div>';
  
    echo $kaipiMain;
?>
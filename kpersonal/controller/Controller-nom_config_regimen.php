<?php   
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

 
	$bd	   =	new Db;	
   
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
    
    if (isset($_GET['accion']))	{
        
        $accion = trim($_GET['accion']);
        $codigo = trim($_GET['codigo']);
        
        if ( $accion == 'accion'){
            $sql = "UPDATE nom_regimen
    			     SET  activo  =".$bd->sqlvalue_inyeccion('S', true)."
     			 WHERE id_regimen=".$bd->sqlvalue_inyeccion($codigo, true);
        }
        if ( $accion == 'anula'){
            $sql = "UPDATE nom_regimen
    			     SET  activo  =".$bd->sqlvalue_inyeccion('N', true)."
     			 WHERE id_regimen=".$bd->sqlvalue_inyeccion($codigo, true);
        }
        $bd->ejecutar($sql);
    }
     
    
    
    
    
 
    
    $qcabecera = array(
        array(etiqueta => 'Id',campo => 'id_regimen',ancho => '10%', filtro => 'N', valor => '-', indice => 'S', visor => 'S'),
        array(etiqueta => 'Regimen',campo => 'regimen',ancho => '40%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
        array(etiqueta => 'Patronal',campo => 'patronal',ancho => '10%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
        array(etiqueta => 'Personal',campo => 'personal',ancho => '10%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
        array(etiqueta => 'Reserva',campo => 'reserva',ancho => '10%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
        array(etiqueta => 'activo',campo => 'activo',ancho => '10%', filtro => 'N', valor => '-', indice => 'N', visor => 'S') 
    );
    
 
    $acciones = "accion,anula";
    
    $funcion  = 'goToActiva';
       
    $bd->_order_by('id_regimen');
    
    $bd->JqueryArrayTable('nom_regimen',$qcabecera,$acciones,$funcion,'Tabla_regimen' );
   
    
 
?>
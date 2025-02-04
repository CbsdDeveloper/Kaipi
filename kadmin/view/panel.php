<?php
session_start( );
require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
 
 
$bd	   = new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

$idUsuario  = $_SESSION['usuario'];

$x 			= $bd->query_array('par_usuario',
                               'tipo', 
                               'idusuario='.$bd->sqlvalue_inyeccion($idUsuario,true) );
 
$modulo1 = $_GET['id'];  
    
$sql 		= "SELECT  modulo
				 FROM view_perfil_inicio
			    WHERE idusuario =  " . $bd->sqlvalue_inyeccion($idUsuario ,true).
              ' group by modulo order by modulo';

$stmt 		= $bd->ejecutar($sql);

$opcion     = '-';


    while ($x=$bd->obtener_fila($stmt)){
        
        $modulo 	= trim($x['modulo']);
 
        
        if ( $modulo1 == 1){
            if ( $modulo == 'A2 - Planificacion'){
                $opcion = '<meta HTTP-EQUIV="REFRESH" content="0; url=../../kplanificacion/view/inicio">';
                
            }
        }elseif ( $modulo1 == 2){
            if ( $modulo == 'A3 - Presupuesto'){
                $opcion =  '<meta HTTP-EQUIV="REFRESH" content="0; url=../../kpresupuesto/view/inicio">';
            }
        }elseif ( $modulo1 == 3){
            if ( $modulo == 'C4 - Talento Humano'){
                $opcion =  '<meta HTTP-EQUIV="REFRESH" content="0; url=../../kpersonal/view/inicio">';
            }elseif  ( $modulo == 'Personal'){
                $opcion = '<meta HTTP-EQUIV="REFRESH" content="0; url=../../kpersonal/view/inicio">';
            }
        }elseif ( $modulo1 == 4){
            if ( $modulo == 'C1 - Contabilidad'){
                $opcion =  '<meta HTTP-EQUIV="REFRESH" content="0; url=../../kcontabilidad/view/inicio">';
            }
        }elseif ( $modulo1 == 5){
            if ( $modulo == 'B1 - GKflow'){
                $opcion =  '<meta HTTP-EQUIV="REFRESH" content="0; url=../../kcrm/view/inicio">';
            }
        } elseif ( $modulo1 == 6){
            if ( $modulo == 'D2 - Servicios'){
                $opcion =  '<meta HTTP-EQUIV="REFRESH" content="0; url=../../kservicios/view/inicio">';
            } 
        } elseif ( $modulo1 == 7){
            if ( $modulo == 'C3 - Inventarios'){
                $opcion =  '<meta HTTP-EQUIV="REFRESH" content="0; url=../../kinventario/view/inicio">';
            }
        } elseif ( $modulo1 == 8){
            if ( $modulo == 'C2 - Activos FIjos'){
                $opcion =  '<meta HTTP-EQUIV="REFRESH" content="0; url=../../kactivos/view/inicio">';
            }
       } elseif ( $modulo1 == 10){
            if ( $modulo == 'A4 - Administracion'){
                $opcion =  '<meta HTTP-EQUIV="REFRESH" content="0; url=../../kgarantia/view/inicio">';
            }
        }
    }
        
         
        
        //----------------------------------------------------------
        if ( $modulo1 == 0){
            echo '<meta HTTP-EQUIV="REFRESH" content="0; url=visor-gerencial">';
        } elseif ( $modulo1 == 100){
            echo '<meta HTTP-EQUIV="REFRESH" content="0; url=../../kplanificacion/view/mipoa">';
        } elseif ( $modulo1 == 101){
            echo '<meta HTTP-EQUIV="REFRESH" content="0; url=../../kplanificacion/view/POASeguimientoUni.php">';
        } elseif ( $modulo1 == 102){
            echo '<meta HTTP-EQUIV="REFRESH" content="0; url=../../kplanificacion/view/inicio">';
        }else {
             if ( $opcion == '-'){
                echo '<meta HTTP-EQUIV="REFRESH" content="0; url=View-panel">';
            }else{
                echo $opcion;
            }
        }
		
		  
    
 
  
?>
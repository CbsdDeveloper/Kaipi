<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/


$bd	   =	new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

 
    
$idtramite          = $_GET['idtramite'];
$idprov             = $_GET['idprov'];
$accion             = $_GET['accion'];
 
$cur          = $_GET['cur'];

 

if ( $accion == 'add'){
    
    
    $sql1 = "UPDATE presupuesto.pre_tramite
                SET  idprov= ".$bd->sqlvalue_inyeccion(trim($idprov),true) .",
                     cur= ".$bd->sqlvalue_inyeccion(trim($cur),true) ."
              WHERE id_tramite = ".$bd->sqlvalue_inyeccion($idtramite,true) ;
    
    $bd->ejecutar($sql1);
    
    $guardarAux = 'Beneficiario actualizado con exito';
    
    echo $guardarAux  ;
}

///---------------------------------------------------

if ( $accion == 'visor'){
    
    $sql = "SELECT    idprov,   proveedor, direccion, telefono ,cur
            FROM presupuesto.view_pre_tramite
            where id_tramite = ".$bd->sqlvalue_inyeccion($idtramite,true) ;
    
    $resultado = $bd->ejecutar($sql);
    
    $dataProv  = $bd->obtener_array( $resultado);
 
    
    echo json_encode(
        array("a"=> $dataProv['idprov'] ,
              "b"=> $dataProv['proveedor'],
              "c"=> $dataProv['cur'],
        )
        
        );
    
   
}




 
   
?>

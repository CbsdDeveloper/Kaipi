<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/



$bd	   =	new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

 

    $codigo   = $_GET['idacta'] ;
 
    
    $x = $bd->query_array('activo.ac_movimiento',   // TABLA
        '*',                        // CAMPOS
        'id_acta='.$bd->sqlvalue_inyeccion($codigo,true) // CONDICION
        );
    
    $clase  = trim($x['clase_documento']) ;
    
    $idprov = trim($x['idprov']) ;
    
    
    $xval   = $bd->query_array('activo.ac_movimiento',   // TABLA
        'count(*) as nn',                        // CAMPOS
        "clase_documento = 'Acta Trasferencia de Bienes' and 
         idprov=".$bd->sqlvalue_inyeccion($idprov,true) 
        );
    
    $valida = $xval['nn'];
    //-----------------------------------------------
    
    if ( $valida > 0 ) {
        
        $clase= 'ESTA DOCUMENTO NO SE PUEDE ANULAR - DEBE GENERAR  UNA TRASFERENCIA DE BIENES';
        
    }
    else {
            if( $clase == 'Acta de Entrega - Recepcion'){
                
                  
                $sql_det = "SELECT *
                        FROM activo.ac_movimiento_det
                        where  id_acta = ".$bd->sqlvalue_inyeccion($codigo,true) ;
                
                 
                $stmt1 = $bd->ejecutar($sql_det);
                
                
                while ($xx=$bd->obtener_fila($stmt1)){
                      
                    $idbien = $xx['id_bien'];
                     //-------------------------------------------
                    $sqlx = "UPDATE activo.ac_movimiento_det
                           SET estado= ".$bd->sqlvalue_inyeccion('X',true).'
                         WHERE id_bien='.$bd->sqlvalue_inyeccion($idbien,true). ' and
                               id_acta='.$bd->sqlvalue_inyeccion($codigo,true);
                    
                    $bd->ejecutar($sqlx);
                    
                    actualiza_bien($bd,$idbien,$idprov);
                }
                //-------------------------------------
                $sql = "UPDATE activo.ac_movimiento
                           SET tipo= ".$bd->sqlvalue_inyeccion('X',true) .',
                               estado= '.$bd->sqlvalue_inyeccion('X',true) .'
                         WHERE id_acta='.$bd->sqlvalue_inyeccion($codigo,true);
                
                $bd->ejecutar($sql);
                
                $clase= 'DOCUMENTO '.$codigo.' ANULADO REVISE LA INFORMACION ';
                
            }else{
                
                $clase= 'ESTA DOCUMENTO NO SE PUEDE ANULAR - DEBE GENERAR  UNA TRASFERENCIA DE BIENES';
           
            }
    }
    
    echo $clase;
    
  ///*----------------------
    function actualiza_bien($bd,$idbien,$idprov){
        
        $sql = "UPDATE activo.ac_bienes
                   SET uso= ".$bd->sqlvalue_inyeccion('Libre',true) .'
                 WHERE id_bien='.$bd->sqlvalue_inyeccion($idbien,true);
        
        $bd->ejecutar($sql);
        
        
        $sql1 = "UPDATE activo.ac_bienes_custodio
                   SET tiene_acta= ".$bd->sqlvalue_inyeccion('N',true).'
                 WHERE id_bien='.$bd->sqlvalue_inyeccion($idbien,true). ' and 
                       idprov='.$bd->sqlvalue_inyeccion($idprov,true);
        
        $bd->ejecutar($sql1);
        
        
    }

?>
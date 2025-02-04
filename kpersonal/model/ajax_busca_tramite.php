<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/



$bd	   = new Db ;

 
$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);


$id_rol1     = $_GET['id_rol'];
$regimen     = strtoupper(trim($_GET['regimen']));
$certificado = $_GET['certificado'];


$accion     = trim($_GET['accion']);

 
    
if ( $accion == 'anula') {
    
    $AResultado = $bd->query_array('presupuesto.pre_tramite',
        'estado',
        'id_tramite='.$bd->sqlvalue_inyeccion($certificado, true) 
        );
    
    $nbandera = 0;
    $estado   = trim($AResultado['estado']);
    
    if ($estado == '2'){
        $nbandera = 1;
    }
    if ($estado == '3'){
        $nbandera = 1;
    }
 
    if ( $nbandera == 1 ){
         
        $sql = 'UPDATE nom_rol_pagod
                SET  id_tramite='.$bd->sqlvalue_inyeccion(0, true). "
                WHERE id_rol=".$bd->sqlvalue_inyeccion($id_rol1, true). ' and
                      regimen = '.$bd->sqlvalue_inyeccion($regimen, true);
        
        $bd->ejecutar($sql);
        
        //-----------------------------------------------------------------------------
        
        $sql = 'UPDATE presupuesto.pre_tramite
                SET  estado='.$bd->sqlvalue_inyeccion('0', true). '
                WHERE id_tramite='.$bd->sqlvalue_inyeccion($certificado, true) ;
        
        $bd->ejecutar($sql);
        
        ///---------------------------------
        $sql = 'delete from presupuesto.pre_tramite_det
                WHERE id_tramite='.$bd->sqlvalue_inyeccion($certificado, true) ;
        
        $bd->ejecutar($sql);
        
        $mensaje = 'Tramite eliminado ...estado actualice los saldos presupuestarios '.$id_rol1;
        
        $bd->audita($certificado,'ANULADO','NOMINA-PRESUPUESTO',$mensaje);
         
      
        $id_tramite = 0;
        
    }else{
        $mensaje = 'Tramite NO PUEDE anular ...estado comprometido o devengado ';
        $id_tramite = $certificado;
    }
    
}
else {
     
        $AResultado = $bd->query_array('nom_rol_pagod',
            'max(id_tramite) as idtramite',
            'id_rol='.$bd->sqlvalue_inyeccion($id_rol1, true). ' and
             regimen = '.$bd->sqlvalue_inyeccion($regimen, true)
            );
        
        $id_tramite = 0;
        
        $mensaje = 'Tramite NO se ha generado ... ';
        
        
        if ( $AResultado['idtramite'] > 1 ) {
            
            $id_tramite = $AResultado['idtramite'];
            
            $mensaje = 'Tramite generado con exito... '.$id_tramite;
        }
    
}
 

echo json_encode( array("a"=>$id_tramite,  "b"=> $mensaje   )
                 );


 



?>
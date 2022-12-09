<?php
session_start();   
require '../../kconfig/Db.class.php';   
$bd	    =	new Db ;
$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

// FUNCION PARA CALCULAR PERMISOS DE FUNCIONAMIENTO.
// ENTRADA:
//          $TRAMITE  CODIGO DEL TRAMITE QUE ENVIA A EMISION
//          $BD       CONEXION DE BASE DE DATOS
//          $FETCH    ARREGLO DE VARIABLES DEL RUBRO A CALCULAR
//
// SALIDA: RETORNA VALOR A PAGAR
//-------------------------------------------------------------------------------------------
$tramite = $_GET["tramite"];
 
   $calculo_servicio = 0;
 
    
    $x_tramite = $bd->query_array('rentas.ren_tramites',
        '*',
        'id_ren_tramite='.$bd->sqlvalue_inyeccion( $tramite ,true)
        );
    
    
    $calculo_servicio = $x_tramite['base'];
    

    if ( $calculo_servicio > 0 ){
        
        $calculo_servicio =  round($calculo_servicio,2);
        
    }else{
        
        $calculo_servicio = Tabla_permisos( $bd, $tramite );
    }
    
 
    echo $calculo_servicio;
 
//-------------------------------------------------------
// TABLA DE VALORES DE CALCULO
// FUNCION PARA SACAR INFORMACION DE LA TABLA DE VALORES
// ENTRADA:
//          $TRAMITE    CODIGO DEL TRAMITE QUE ENVIA A EMISION
//          $BD         CONEXION DE BASE DE DATOS
//          VISTA TABLA rentas.view_catalogo_var 
//                      Visualiza la informacion de las variables seleccionada en pantalla.
// SALIDA: RETORNA VALOR A PAGAR
//-------------------------------------------------------
function Tabla_permisos( $bd,$tramite ){
    
    
    $datosaux  = $bd->query_array('rentas.view_catalogo_var',  
                                   'idcatalogo',
                                   'id_ren_tramite='.$bd->sqlvalue_inyeccion($tramite,true).' and
			                       tipo ='.$bd->sqlvalue_inyeccion( 'Actividad Negocio',true)
        );
    
    $idcatalogo_a		= $datosaux['idcatalogo'];
    
    $datosaux  = $bd->query_array('rentas.view_catalogo_var',
                                  'idcatalogo',
                                  'id_ren_tramite='.$bd->sqlvalue_inyeccion($tramite,true).' and
			                       tipo ='.$bd->sqlvalue_inyeccion( 'Categoria Negocio',true)
        );
    
    $idcatalogo_b		= $datosaux['idcatalogo'];
    
    
    $datosaux  = $bd->query_array('rentas.view_catalogo_var',
                                        'idcatalogo',
                                        'id_ren_tramite='.$bd->sqlvalue_inyeccion($tramite,true).' and
                                		 tipo ='.$bd->sqlvalue_inyeccion( 'Tipo de Negocio',true)
                                        );
    
    $idcatalogo_c		= $datosaux['idcatalogo'];
    
    
    
    $datosaux  = $bd->query_array('rentas.ren_servicios_cat',
                                  'valor',
                                  'idcatalogo1='.$bd->sqlvalue_inyeccion($idcatalogo_a,true).' and
			                       idcatalogo2 ='.$bd->sqlvalue_inyeccion( $idcatalogo_b,true).' and
			                       idcatalogo3 ='.$bd->sqlvalue_inyeccion( $idcatalogo_c,true)
        );
    
    $valor		= $datosaux['valor'];
    
    if (empty($valor)){
        
        $valor = 0;
        
    }
    
    
    return $valor;
    
    
    
}



?>
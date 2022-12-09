<?php
session_start();
require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
$bd	   =	new Db;
$bd->conectar_sesion_servicios();
//-------------------------------------------------------
// FUNCION PARA CALCULAR FUNCION GENERAL Y REGRESAR EL VALOR MANUAL QUE INGRESA DESDE LA PANTALLA
// ENTRADA: 
//          $TRAMITE  CODIGO DEL TRAMITE QUE ENVIA A EMISION
//          $BD       CONEXION DE BASE DE DATOS
//          $FETCH    ARREGLO DE VARIABLES DEL RUBRO A CALCULAR
//
// SALIDA: RETORNA VALOR A PAGAR
//-------------------------------------------------------------------------------------------
    
$tramite          =  $_POST["tramite"];
$tipo_formula     =  $_POST["tipo_formula"];
$costo            =  $_POST["costo"];
    
    $x_tramite = $bd->query_array('rentas.ren_tramites',   
        '*',                       
        'id_ren_tramite='.$bd->sqlvalue_inyeccion( $tramite ,true)  
        );
    
    
    if ( $tipo_formula == 'constante'){
        
        $calculo_servicio = $costo;
        
    }else{
        
        $calculo_servicio = $x_tramite['base'];
        
    }
   
     
    echo $calculo_servicio;
 

?>
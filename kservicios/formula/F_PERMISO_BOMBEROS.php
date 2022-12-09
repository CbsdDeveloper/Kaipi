<?php
session_start();
require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
$bd	   =	new Db;
$bd->conectar_sesion_servicios();


//-------------------------------------------------------
// FUNCION PARA CALCULAR PERMISOS DE FUNCIONAMIENTO.
// ENTRADA:
//          $TRAMITE  CODIGO DEL TRAMITE QUE ENVIA A EMISION
//          $BD       CONEXION DE BASE DE DATOS
//          $FETCH    ARREGLO DE VARIABLES DEL RUBRO A CALCULAR
//
// SALIDA: RETORNA VALOR A PAGAR
//-------------------------------------------------------------------------------------------
$tramite          = $_POST["tramite"];
 
 
    
    $calculo_servicio = Tabla_permisos( $bd, $tramite );

 
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
        'idcatalogo,valor1,valor2,valor3,valor4',
        'id_ren_tramite='.$bd->sqlvalue_inyeccion($tramite,true).' and
		 trim(tipo) ='.$bd->sqlvalue_inyeccion( 'Actividad Negocio',true)
        );
    
    $valor1		= $datosaux['valor1'];
        
    $valor2		= $datosaux['valor2'];
        
    $valor3		= $datosaux['valor3'];
 

    $datos  = $bd->query_array('rentas.view_ren_tramite_var',
        'valor_variable',
        'id_ren_tramite='.$bd->sqlvalue_inyeccion($tramite,true).' and
        trim(nombre_variable) ='.$bd->sqlvalue_inyeccion( 'TIPO NEGOCIO',true)
        );
    
    $tipo_dato		= trim($datos['valor_variable']);
    
 
    $valor = 0;

    if ( trim($tipo_dato) == 'GRANDE'){
        $valor =  $valor1;
    }  

    if ( trim($tipo_dato)  == 'MEDIANO'){
        $valor = $valor2;
    }  

    if ( trim($tipo_dato)  == 'PEQUENO'){
        $valor =  $valor3;
    }  
    
 
    return $valor;
    
    
    
}
?>
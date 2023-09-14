<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/



$bd	   =	new Db;

$obj     = 	new objects;

$servidor ='192.168.1.3';
$base_datos = 'db_cbsd';
$usuario = 'postgres';
$password = 'Cbsd2019';

$bd->conectar_sesion_externo($servidor, $base_datos, $usuario, $password) ;

 

$codigo_ex       = trim($_GET['codigo_ex']);

$ruc_ex         =   trim($_GET['ruc_ex']);

$nombre_ex       = trim($_GET['nombre_ex']) .'%';

if ( empty($_GET['nombre_ex'])) {
    $nombre_ex  = '-';
}


if ( empty($_GET['codigo_ex'])) {
    $codigo_ex  = '-';
}




        $tipo = $bd->retorna_tipo();
            
            
        $sql = "SELECT  autoinspeccion_id || ' ' as  id, 
                        entidad_ruc  || ' ' as  ruc, 
                        entidad_razonsocial,
                        local_nombrecomercial,
                        actividad_nombre,
                        autoinspeccion_codigo,
                        autoinspeccion_fecha
                            FROM permisos.vw_autoinspecciones 
                            where autoinspeccion_anio = '2023' and 
                                  ( entidad_ruc = ".$bd->sqlvalue_inyeccion(trim($ruc_ex)  ,true). " or 
                                     autoinspeccion_codigo=".$bd->sqlvalue_inyeccion(trim($codigo_ex)  ,true). " or 
                                     entidad_razonsocial like ".$bd->sqlvalue_inyeccion(trim($nombre_ex)  ,true) .') order by entidad_razonsocial ';


 
                
            $resultado = $bd->ejecutar($sql);
            
            $obj->table->table_basic_js($resultado, // resultado de la consulta
                $tipo,      // tipo de conexoin
                'aprobar',         // icono de edicion = 'editar'
                '',			// icono de eliminar = 'del'
                'Enlace_Bomb_asigna-0' ,        // evento funciones parametro Nombnre funcion - codigo primerio
                "Referencia,Identificacion, Razon Social,Nombre,Actividad,Codigo,Fecha",  // nombre de cabecera de grill basica,
                '12px',      // tamaño de letra
                'Caja1'         // id
                );
        

?>
 
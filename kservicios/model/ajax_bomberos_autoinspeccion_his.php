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

 

 

$ruc_ex         =   trim($_GET['idprov']);

 

 


        $tipo = $bd->retorna_tipo();
            
            
        $sql = "SELECT  autoinspeccion_id || ' ' as  id, 
                         local_nombrecomercial,
                        actividad_nombre,
                        autoinspeccion_anio || ' ' as anio,
                        autoinspeccion_codigo,
                        autoinspeccion_fecha
                            FROM permisos.vw_autoinspecciones 
                            where    entidad_ruc = ".$bd->sqlvalue_inyeccion(trim($ruc_ex)  ,true). "   order by autoinspeccion_anio desc ";


 
                
            $resultado = $bd->ejecutar($sql);
            
            $obj->table->table_basic_js($resultado, // resultado de la consulta
                $tipo,      // tipo de conexoin
                '',         // icono de edicion = 'editar'
                '',			// icono de eliminar = 'del'
                'Enlace_Bomb_asigna-0' ,        // evento funciones parametro Nombnre funcion - codigo primerio
                "Referencia,Nombre,Actividad,Periodo,Codigo,Fecha",  // nombre de cabecera de grill basica,
                '12px',      // tamaño de letra
                'Caja11'         // id
                );
        

?>
 
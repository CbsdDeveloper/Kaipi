<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/



$bd	   =	new Db;

$obj     = 	new objects;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);



$accion       = trim($_GET['accion']);

$idprov       = $_GET['idprov'];

$id_teleasigna       = $_GET['id_teleasigna'];


 
if ( $accion == 'visor') {
  

    $tipo = $bd->retorna_tipo();
        
        
    $sql = "SELECT  id_teletrabajo || ' ' as  id, fecha_inicio, fecha_fin,actividades, sesion , estado,cumplida
                        FROM nom_tele_trabajo
                        where idprov = ".$bd->sqlvalue_inyeccion(trim($idprov)  ,true). ' and 
                              id_teleasigna=' .$bd->sqlvalue_inyeccion($id_teleasigna  ,true). ' order by id_teletrabajo desc';


 

            
        $resultado = $bd->ejecutar($sql);
        
        $obj->table->table_basic_js($resultado, // resultado de la consulta
            $tipo,      // tipo de conexoin
            'aprobar',         // icono de edicion = 'editar'
            'anular',			// icono de eliminar = 'del'
            'proceso_doc-0' ,        // evento funciones parametro Nombnre funcion - codigo primerio
            "Referencia, Desde,Hasta, Actividad,Sesion,Activo,Cumplida",  // nombre de cabecera de grill basica,
            '12px',      // tamaño de letra
            'Caja1'         // id
            );

} 



/*
$refe_tele       = $_GET['refe_tele'];

$motivo_tele       = $_GET['motivo_tele'];

$estado_tele       = $_GET['estado_tele'];

$idprov       = $_GET['idprov'];

$idprov_jefe       = $_GET['idprov_jefe'];


 
$sesion 	 =  trim($_SESSION['email']);
 
$anio = date('Y');

$tabla      = 'nom_tele_asigna';
$secuencia  = 'nom_tele_asigna_id_teleasigna_seq';


if ( $accion == 'add') {
    
    $ATabla = array(
        array( campo => 'id_teleasigna',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
        array( campo => 'idprov',tipo => 'VARCHAR2',id => '1',add => 'S', edit => 'N', valor => $idprov , key => 'N'),
        array( campo => 'fecha',tipo => 'DATE',id => '2',add => 'S', edit => 'S', valor => $fecha_tele, key => 'N'),
        array( campo => 'anio',tipo => 'NUMBER',id => '3',add => 'S', edit => 'S', valor => $anio, key => 'N'),
        array( campo => 'estado',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor =>$estado_tele, key => 'N'),
        array( campo => 'motivo',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor =>$motivo_tele , key => 'N'),
        array( campo => 'referencia',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => $refe_tele , key => 'N'),
        array( campo => 'sesion',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor =>$sesion , key => 'N'),
        array( campo => 'idprov_jefe',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor =>$idprov_jefe , key => 'N'),
        );

     
        $bd->_InsertSQL($tabla,$ATabla,$secuencia);

        echo 'Datos Actualizados... verifique la información';

} 

if ( $accion == 'aprobar') {
    
    $id_teleasigna       = $_GET['codigo'];

    $ATabla = array(
        array( campo => 'id_teleasigna',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
        array( campo => 'anio',tipo => 'NUMBER',id => '3',add => 'S', edit => 'S', valor => $anio, key => 'N'),
        array( campo => 'estado',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor =>'SI', key => 'N')
        );

        $this->bd->_UpdateSQL($tabla,$ATabla,$id_teleasigna);

         echo 'Datos Actualizados... verifique la información';

} 


if ( $accion == 'anular') {
    
    $id_teleasigna       = $_GET['codigo'];

        $x = $bd->query_array($tabla,   // TABLA
        'estado',                        // CAMPOS
        'id_teleasigna='.$bd->sqlvalue_inyeccion( $id_teleasigna ,true) // CONDICION
     );


     if (  trim($x['estado']) == 'NO'  ) {
 
        $xx = $bd->query_array('nom_tele_trabajo',   // TABLA
        'count(*) as nn',                        // CAMPOS
        'id_teleasigna='.$bd->sqlvalue_inyeccion( $id_teleasigna ,true));

        if (  $xx['nn']  > 0  ) {

        }else{
            
               $bd->JqueryDeleteSQL($tabla,'id_teleasigna='.$bd->sqlvalue_inyeccion($id_teleasigna, true));
        }



    } else      {   

            $ATabla = array(
                array( campo => 'id_teleasigna',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
                array( campo => 'anio',tipo => 'NUMBER',id => '3',add => 'S', edit => 'S', valor => $anio, key => 'N'),
                array( campo => 'estado',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor =>'NO', key => 'N')
                );

                $this->bd->_UpdateSQL($tabla,$ATabla,$id_teleasigna);

            }
         echo 'Datos Actualizados... verifique la información';

} 


 


    */
?>
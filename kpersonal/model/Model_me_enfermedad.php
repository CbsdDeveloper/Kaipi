<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


$obj     = 	new objects;
$bd	   =	new Db ;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);


$accion          = $_GET['accion'];   // VARIABLE DE ENTRADA CODIGO DE BITACORA

$tipo 		     = $bd->retorna_tipo(); // TIPO DE CONEXION DE BASE DE DATOS ... POSTGRES


if ( trim($accion) == 'add'){
    
    agregar(  $bd, $_GET );
    
    visor($bd,$obj,$tipo,$_GET);
    
}

if ( trim($accion) == 'del'){
    
    delete(  $bd, $_GET );
    
    visor($bd,$obj,$tipo,$_GET);
    
}

if ( trim($accion) == 'visor'){
    
     
    visor($bd,$obj,$tipo,$_GET);
    
}

//-----------------------------------------
//-----------------------------------------
function agregar(  $bd, $GET ){
    
     
    $sesion 	 =  trim($_SESSION['email']);
    
    $hoy 	     =     date("Y-m-d");    
    
    $ATabla = array(
        array( campo => 'id_atencion_enf',tipo => 'NUMBER',id => '0',add => 'N', edit => 'S', valor => '-', key => 'S'),
        array( campo => 'id_atencion',tipo => 'NUMBER',id => '1',add => 'S', edit => 'S', valor => $GET['id'], key => 'N'),
        array( campo => 'enfermedad',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => trim($GET['enfermedad']), key => 'N'),
        array( campo => 'sesion',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor =>$sesion, key => 'N'),
        array( campo => 'fcreacion',tipo => 'DATE',id => '4',add => 'S', edit => 'S', valor =>$hoy, key => 'N'),
    );
    
    
 
        
        $bd->_InsertSQL('medico.ate_medica_enfermedad',$ATabla, 'medico.ate_medica_enfermedad_id_atencion_enf_seq');
        
        $result = 'ok';
    
    echo $result;
    
}	

//-----------------------------------------
function delete( $bd, $GET  ){
    
    $id_atencion_enf = $GET['id_atencion_enf'];
    
    
    $bd->JqueryDeleteSQL('medico.ate_medica_enfermedad','id_atencion_enf='.$bd->sqlvalue_inyeccion( $id_atencion_enf, true));
    
}


//-----------------------------------------
function visor($bd,$obj,$tipo,$GET) {
    
    
    $id_atencion = $GET['id'];
    
    
     
    
    $sql = "select  id_atencion_enf,enfermedad
            from medico.ate_medica_enfermedad
            where id_atencion = ".$bd->sqlvalue_inyeccion($id_atencion, true).
            " order by enfermedad desc";
    
    $resultado  = $bd->ejecutar($sql); // EJECUTA SENTENCIA SQL  RETORNA RESULTADO
    
     
    $evento   = "goToURL_enfermo-0";  // nombre funcion javascript-columna de codigo primario
    $edita    = '';
    $del      = 'del';
    
   
    
    $cabecera =  "Codigo,Enfermedades Relacionadas"; // CABECERA DE TABLAR GRILLA HA VISUALIZAR
    
    
    
    $obj->table->table_basic_seleccion($resultado,$tipo,$edita,$del,$evento ,$cabecera);
    
    
    
}	
 

?>


  
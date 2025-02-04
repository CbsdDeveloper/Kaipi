<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/



$bd	   =	new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

 
    $idbien   = $_GET['codigo'] ;
    $idprov   = trim($_GET['idprov']) ;
 
    $Array            = $bd->query_array('view_nomina_rol','id_departamento', 'idprov='.$bd->sqlvalue_inyeccion($idprov,true));
    $id_departamento  = $Array['id_departamento'];
    
    
    
    $datos            = $bd->query_array('activo.ac_bienes_custodio','count(*) as nn', 'id_bien='.$bd->sqlvalue_inyeccion($idbien,true));
 
    if ( $datos['nn'] > 0 ){
        
        $sql = "UPDATE activo.ac_bienes_custodio
                   SET idprov= ".$bd->sqlvalue_inyeccion($idprov,true) .',
                       id_departamento= '.$bd->sqlvalue_inyeccion($id_departamento,true) .'
                 WHERE id_bien='.$bd->sqlvalue_inyeccion($idbien,true);
        
        $bd->ejecutar($sql);
        
    }else
    {
        $sesion 	 =     trim($_SESSION['email']);
        $hoy 	     =     date("Y-m-d");    
        
        $ATabla_custodio = array(
            array( campo => 'id_bien_custodio',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
            array( campo => 'id_bien',tipo => 'NUMBER',id => '1',add => 'S', edit => 'N', valor => $idbien, key => 'N'),
            array( campo => 'idprov',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => $idprov, key => 'N'),
            array( campo => 'id_departamento',tipo => 'NUMBER',id => '3',add => 'S', edit => 'S', valor =>$id_departamento, key => 'N'),
            array( campo => 'creacion',tipo => 'DATE',id => '4',add => 'S', edit => 'N', valor =>  $hoy, key => 'N'),
            array( campo => 'sesion',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'N', valor =>$sesion , key => 'N'),
            array( campo => 'modificacion',tipo => 'DATE',id => '6',add => 'S', edit => 'S', valor =>  $hoy, key => 'N'),
            array( campo => 'sesionm',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => $sesion , key => 'N'),
            array( campo => 'tipo_ubicacion',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor => 'Institucion', key => 'N'),
            array( campo => 'tiene_acta',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'N', valor => 'N', key => 'N'),
            array( campo => 'ubicacion_fisica',tipo => 'VARCHAR2',id => '10',add => 'S', edit => 'S', valor => 'N', key => 'N')
        );
        
        $bd->_InsertSQL('activo.ac_bienes_custodio',$ATabla_custodio, 'activo.ac_bienes_custodio_id_bien_custodio_seq');
        
    }
        
      
        
        
        $clase= 'INFORMACION ACTUALIZADA CON EXITO NRO BIEN '. $idbien.' ... Actualice la informacion';
 
      
        
    echo $clase;

?>
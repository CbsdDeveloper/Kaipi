<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

 
$bd	   = 	new Db ;
 

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

 
$idbien	    =  $_GET["idbien"] ;
$idprov     =  trim($_GET["id"]) ;
 


$sesion 	 =     trim($_SESSION['email']);

$hoy 	     =     date("Y-m-d");    	

$xval   = $bd->query_array('view_nomina_user',   // TABLA
    'id_departamento',                        // CAMPOS
    "idprov=".$bd->sqlvalue_inyeccion($idprov,true)
    );

$id_departamento = $xval['id_departamento'];

  
$ATabla_custodio = array(
    array( campo => 'id_bien_custodio',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
    array( campo => 'id_bien',tipo => 'NUMBER',id => '1',add => 'S', edit => 'N', valor => $idbien, key => 'N'),
    array( campo => 'idprov',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => $idprov, key => 'N'),
    array( campo => 'id_departamento',tipo => 'NUMBER',id => '3',add => 'S', edit => 'S', valor => $id_departamento, key => 'N'),
    array( campo => 'creacion',tipo => 'DATE',id => '4',add => 'S', edit => 'N', valor =>  $hoy, key => 'N'),
    array( campo => 'sesion',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'N', valor =>$sesion , key => 'N'),
    array( campo => 'modificacion',tipo => 'DATE',id => '6',add => 'S', edit => 'S', valor =>  $hoy, key => 'N'),
    array( campo => 'sesionm',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => $sesion , key => 'N'),
    array( campo => 'tipo_ubicacion',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor => 'Institucion', key => 'N'),
    array( campo => 'tiene_acta',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'S', valor => 'S', key => 'N'),
    array( campo => 'ubicacion_fisica',tipo => 'VARCHAR2',id => '10',add => 'S', edit => 'S', valor => 'N', key => 'N')
);


    $id_bien_custodio = id_custodio($bd,$idbien );

    if ( $id_bien_custodio == 0 ){
        
        $bd->_InsertSQL('activo.ac_bienes_custodio',$ATabla_custodio, 'activo.ac_bienes_custodio_id_bien_custodio_seq');
        
       $sql = "UPDATE activo.ac_bienes
                           SET uso= ".$bd->sqlvalue_inyeccion('Asignado',true) .'
                         WHERE id_bien='.$bd->sqlvalue_inyeccion($idbien,true);
       
       $bd->ejecutar($sql);
       
     }else{
         $tiene_acta  =   BuscaActa($bd,$idbien);
         
         if ( $tiene_acta == 'S'){
         
             $resultado = 'TIENE ACTA...'.$tiene_acta;
         
         }else{
             
             $resultado = 'Datos Guardados correctamente '.$tiene_acta.' '.$idbien;
             
             $bd->_UpdateSQL('activo.ac_bienes_custodio',$ATabla_custodio,$id_bien_custodio);
             
             $sql = "UPDATE activo.ac_bienes
                           SET uso= ".$bd->sqlvalue_inyeccion('Asignado',true) .'
                         WHERE id_bien='.$bd->sqlvalue_inyeccion($idbien,true);
             
             $bd->ejecutar($sql);
         
         }
       
         
    }
    
    echo $resultado ;

    
    

//--------------------------------------
    function id_custodio($bd,$idbien ){
        
        
        $x = $bd->query_array('activo.ac_bienes_custodio',
            'id_bien_custodio',
            'id_bien='.$bd->sqlvalue_inyeccion($idbien,true)
            );
        
        if (  $x['id_bien_custodio'] > 0 ){
            $id_bien_custodio =   $x['id_bien_custodio'] ;
        }else {
            $id_bien_custodio =0;
        }
        
        return $id_bien_custodio;
    }
 //---------------------------
    function BuscaActa($bd,$idbien){
        
        
        $x = $bd->query_array('activo.view_bienes',
            'tiene_acta',
            'id_bien='.$bd->sqlvalue_inyeccion($idbien,true)
            );
        
        
        
        return trim($x['tiene_acta']);
        
        
    }
?>
 
  
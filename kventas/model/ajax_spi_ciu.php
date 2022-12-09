<?php 

session_start( );  
   	
require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/

 
$bd	   =	new Db;
    
$idprov    = $_GET['idprov'];
$id_spi    = $_GET['id_spi'];


$id_banco   = $_GET['id_banco'];
$tipo_cta   = $_GET['tipo_cta'];
$cta_banco  = $_GET['cta_banco'];

 

    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
    
    $x = $bd->query_array('par_catalogo',
        'codigo',
        'idcatalogo='.$bd->sqlvalue_inyeccion($id_banco,true)
        );
    
    
    $banco = trim($x['codigo']);
    
    $sql1 = " UPDATE par_ciu
			    SET 	id_banco      =".$bd->sqlvalue_inyeccion($id_banco, true).",
                        banco      =".$bd->sqlvalue_inyeccion($banco, true).",
				        tipo_cta   =".$bd->sqlvalue_inyeccion($tipo_cta, true).",
                        cta_banco  =".$bd->sqlvalue_inyeccion($cta_banco, true)."
			WHERE idprov           =".$bd->sqlvalue_inyeccion(trim($idprov), true);
    
    $bd->ejecutar($sql1);
    
    
    
  
    
    $sql = " UPDATE tesoreria.spi_mov_det
			    SET 	codigo_banco      =".$bd->sqlvalue_inyeccion($banco, true).",
				        tipo_cuenta   =".$bd->sqlvalue_inyeccion($tipo_cta, true).",
                        nro_cuenta  =".$bd->sqlvalue_inyeccion($cta_banco, true)."
			WHERE idprov           =".$bd->sqlvalue_inyeccion(trim($idprov), true). ' AND 
                  id_spi='.$bd->sqlvalue_inyeccion($id_spi, true);
    
 
    
    $bd->ejecutar($sql);
     
    $asignado = 'DATO ACTUALIZADO CON EXITO '. $id_banco.' '.$idprov;
          	
    echo $asignado;
            
  
 
  ?> 
								
 
 
 
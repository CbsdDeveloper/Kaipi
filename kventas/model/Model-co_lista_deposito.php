<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

$obj   = 	new objects;
$bd	   = new Db ;

$registro= $_SESSION['ruc_registro'];



$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);


//$id_concilia	=	$_GET["id_concilia"];

$idaux	        =	$_GET["idaux"];
$estado	        =	$_GET["estado"];
$bandera	    =	$_GET["bandera"];
 

if ($bandera == 'S'){
     
        
        $sql = "update co_asientod
                    set concilia = ".$bd->sqlvalue_inyeccion($estado, true)."
                   where id_asientod =".$bd->sqlvalue_inyeccion($idaux, true);
        
        $bd->ejecutar($sql);
        
 
}
    
/*

$a = $bd->query_array('co_conciliad',
    'sum(haber) as egreso',
    'id_concilia='.$bd->sqlvalue_inyeccion($id_concilia,true). " and
                         tipo = ".$bd->sqlvalue_inyeccion('deposito',true)
    );

echo '<script>'.'$("#depositos").val( '.$a['egreso'].')'.'</script>';

$Mov_cheque = '<h6>Depositos y/o Trasferencias</h6>';

$tipo 		    = $bd->retorna_tipo();

$sql = 'SELECT  id_asiento_aux as "Asiento",
                                documento as "Documento",
                                detalle as "Detalle",
                                debe as "Ingreso",
                                haber as "Egreso"
                        FROM co_conciliad
                        where id_concilia = '. $bd->sqlvalue_inyeccion($id_concilia , true).' and
                              tipo = '. $bd->sqlvalue_inyeccion('deposito' , true).' and
                              registro = '. $bd->sqlvalue_inyeccion($registro , true);


$resultado  = $bd->ejecutar($sql);

echo $Mov_cheque;

$obj->grid->KP_sumatoria(4,"Ingreso","Egreso", '','');

$formulario = 'Asiento';

//$resultado,$tipo,$llave_primaria,$archivo_ref,$action,$visor,$editar,$del,$tab

$obj->grid->KP_GRID_CTAA($resultado,$tipo,'Asiento',$formulario,'S','elimina','','','');
*/


?>
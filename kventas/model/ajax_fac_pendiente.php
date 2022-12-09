<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/


$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);



$sql = "SELECT   idprov, razon , count(*) as  registros
                    FROM  ven_cliente_gestion
                    where idmovimiento = -1 and
                          factura = 'S' and
                          registro=".$bd->sqlvalue_inyeccion(trim($_SESSION['ruc_registro']),true)."
                    group by idprov, razon ";

$stmt1 = $bd->ejecutar($sql);

echo '<option value="-"> [ Seleccione Cliente ] </option>';


while ($fila=$bd->obtener_fila($stmt1)){
    
    echo '<option value="'.$fila['idprov'].'">'.$fila['razon'].'</option>';
    
}



?>

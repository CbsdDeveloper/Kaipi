<?php

session_start();

require '../../kconfig/Db.class.php';  
require '../../kconfig/Obj.conf.php';  
require '../../kconfig/Set.php'; 


$bd	   =	 	new Db ;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
$id         = $_GET['id'] ;
$id_fre    = $_GET['id_fre'] ;
$idprov    = trim($_GET['idprov'] );

$unidad    = trim($_GET['unidad'] );

$sesion 	 =  trim($_SESSION['email']);


$horar = trim($_GET['horar'] );
$hora = trim($_GET['hora'] );
 


$horar = date("H:i");
$hora = date("H:i");
 




$fecha = date('Y-m-d');

$xx = $bd->query_array('rentas.ren_fre_mov',   // TABLA
'count(*) as nn',                        // CAMPOS
'id_ren_movimiento = 0 and sesion ='.$bd->sqlvalue_inyeccion($sesion ,true));


        if ( $xx['nn'] > 0  )  {  

        } else    {        

                $id = '0';
                
                $sql = "INSERT INTO rentas.ren_fre_mov(fecha,	id_ren_movimiento, id_fre, idprov, num_carro, num_placa, sesion, hora)
                        VALUES (".$bd->sqlvalue_inyeccion($fecha , true).",".
                        $bd->sqlvalue_inyeccion($id , true).",".
                        $bd->sqlvalue_inyeccion($id_fre  , true).",".
                        $bd->sqlvalue_inyeccion($idprov, true).",".
                        $bd->sqlvalue_inyeccion($unidad , true).",".
                        $bd->sqlvalue_inyeccion($hora, true).",".
                        $bd->sqlvalue_inyeccion($sesion, true).",".
                        $bd->sqlvalue_inyeccion($horar, true).")";

                        $bd->ejecutar($sql);
                
                }                
                        $div_mistareas = ' ';
                        
                        echo $div_mistareas;



?>
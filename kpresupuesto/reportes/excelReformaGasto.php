<?php
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


$obj   = 	new objects;
$bd	   =	new Db ;

 
$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);


$id= $_GET['id'];

$anio       =  $_SESSION['anio'];

$tipo 		      = $bd->retorna_tipo();

$cadena  = " || '  '   ";

$cadena1 = " ' ' ||   ";

$sql = ' SELECT  partida ,
                 detalle,
                 codificado,
                 disponible , 
                 0 as aumento , 
                 0 as disminuye,funcion ,clasificador,grupo
              FROM presupuesto.pre_gestion' ."
              where tipo = 'G' and anio=".$bd->sqlvalue_inyeccion($anio, true).' order by  funcion ,clasificador';

 
$resultado	= $bd->ejecutar($sql);


//header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
//header("Content-type:   application/x-msexcel; charset=utf-8");
 
header("Content-type: text/csv; charset=utf-8");
header('Content-disposition: attachment; filename=gasto_traslado_reforma.csv');
 
echo 'Programa,Grupo,Clasificador,Partida Presupuestaria,detalle,codificado,disponible,aumento,disminuye'."\n";

while ($x=$bd->obtener_fila($resultado)){
    $detalle =     utf8_decode(trim($x["detalle"]));
    $detalle =     str_replace(',', ' ', $detalle);
    echo trim($x["funcion"]).' '.",";
    echo trim($x["grupo"]).' '.",";
    echo trim($x["clasificador"]).' '.",";
    echo 'G-'.trim($x["partida"]).",";
    echo $detalle.",";
    echo $x["codificado"] .",";
    echo $x["disponible"] .",";
    echo "0.00,";
    echo "0.00"."\n";
  
    
}



 


 
?> 
 
 
 
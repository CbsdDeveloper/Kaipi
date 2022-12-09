<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

 
$bd	   = 	new Db ;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);


$registro          =    $_SESSION['ruc_registro'];
$idprov	           =	$_GET["idprov"];
$accion            =	$_GET["accion"];

$sesion 	       =  $_SESSION['email'];

$servicio          = 	$_GET["servicio"];
$contrato          = 	$_GET["contrato"];
$fecha_inicio       = 	$_GET["fecha_inicio"];
$novedad            =    ($_GET["novedad"]);
$periodo            =    ($_GET["periodo"]);
$factura            =    ($_GET["factura"]);
$finalizado         =    ($_GET["finalizado"]);


    $ATabla = array(
         array( campo => 'idven_servicio',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
        array( campo => 'idprov',tipo => 'VARCHAR2',id => '1',add => 'S', edit => 'N', valor => trim($idprov), key => 'N'),
        array( campo => 'registro',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'N', valor => $registro, key => 'N'),
        array( campo => 'servicio',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => $servicio, key => 'N'),
        array( campo => 'contrato',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => $contrato, key => 'N'),
        array( campo => 'sesion',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => trim($sesion), key => 'N'),
        array( campo => 'fecha_inicio',tipo => 'DATE',id => '6',add => 'S', edit => 'S', valor => $fecha_inicio, key => 'N'),
        array( campo => 'novedad',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => $novedad, key => 'N'),
        array( campo => 'factura',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor => $factura, key => 'N'),
        array( campo => 'periodo',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor => $periodo, key => 'N'),
        array( campo => 'finalizado',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'S', valor => $finalizado, key => 'N')
    );

     
    $tabla 	  		    = 'ven_cliente_servicio';
    $secuencia 	        = 'ven_cliente_servicio_idven_servicio_seq';

   if ( $accion == 'actualiza'){
 
            $x = $bd->query_array('ven_cliente_servicio',
                                           'idven_servicio', 
                                            'idprov='.$bd->sqlvalue_inyeccion($idprov,true).' and 
                                            registro='.$bd->sqlvalue_inyeccion($registro,true)
                                   );
        
        
            if ($x["idven_servicio"]  > 0 ){
                
                $ViewGuardaCliente = 'Informacion actualizada: '. $bd->_UpdateSQL($tabla,$ATabla,$x["idven_servicio"] );
                
            }
            else{
                
           
                $ViewGuardaCliente = 'Informacion actualizada: '. $bd->_InsertSQL($tabla,$ATabla,$secuencia);
                
                
            }
            
            echo $ViewGuardaCliente;
            
  }

  if ( $accion == 'visor'){
      
      $x = $bd->query_array('ven_cliente_servicio',
          'idven_servicio,servicio, contrato, sesion, fecha_inicio, periodo,novedad, factura, finalizado',
          'idprov='.$bd->sqlvalue_inyeccion($idprov,true).' and
           registro='.$bd->sqlvalue_inyeccion($registro,true)
          );
   
      echo '<script> 
                $("#servicio").val("'.trim($x['servicio']).'");
                $("#contrato").val("'.trim($x['contrato']).'");
                $("#fecha_inicio").val("'.($x['fecha_inicio']).'");
                $("#novedad").val("'.trim($x['novedad']).'");
                $("#periodo").val("'.trim($x['periodo']).'");
                $("#factura").val("'.trim($x['factura']).'");
                $("#finalizado").val("'.trim($x['finalizado']).'");
            </script> ';
 
      
  }
//--- funciones grud
 



?>
 
  
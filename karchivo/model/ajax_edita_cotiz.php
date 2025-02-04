<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
 
$bd	   =	new Db;

     $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
    
 
      $isd = $_GET['isd'];  
      $trasporte = $_GET['trasporte'];  
      
      $vip        = $_GET['vip'];
      $integrador = $_GET['integrador'];  
      
      $pvp1 = $_GET['pvp1'];
      $pvp2 = $_GET['pvp2'];  
      $pvp3 = $_GET['pvp3'];
      
     
     $sql1 = "update temp_cotiza 
                set  isd= fob * ".$isd." ,
                     advalorem= fob * factor,
                     salvaguardia1 = salvaguardia * ".$isd." ,
                     transporte= fob * ".$trasporte.' where 1 = 1';
      
     $bd->ejecutar($sql1);
     
     $sql2 = "update temp_cotiza
                set  subtotal = fob + isd + advalorem +salvaguardia1 + transporte where 1 = 1";
     
     $bd->ejecutar($sql2);
     
     
     $sql3 = "update temp_cotiza
                set  vip= subtotal * ".$vip." ,
                     integrador = subtotal * ".$integrador." ,
                     v1 = subtotal * ".$pvp1." ,
                     v3 = subtotal * ".$pvp3." ,
                     v2= subtotal * ".$pvp2.' where 1 = 1';
     
     $bd->ejecutar($sql3);
     
 
    
     $procesado = 'Procesado';
    
  
 
	echo $procesado;
    
    ?>					 
 
 
 
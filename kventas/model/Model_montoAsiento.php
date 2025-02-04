<?php 
 session_start(); 

 require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 
 require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
 
  
	
 
 
    $bd	   =	 	new Db ;
   
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
  
 	 if (isset($_GET['estado']))	{
 	  
 	     $DivAsientosTareas = '';
 	     $estado = $_GET['estado'];
 	     $tipo   = $_GET['tipo'];
 	     $valor  = $_GET['valor'];
 	     
 	     
 	     $codigo     = $_GET['codigo'];
 	     
 	     $id_asiento = $_GET['id_asiento'];
 	     
 	     if ($tipo == 'D') {
 	         $debe = $valor ;
 	         $haber= '0';
 	         $B1 = 'NUMBER';
 	         $B2 = 'VARCHAR2';
 	     }else {
 	         $debe = '0';
 	         $haber= $valor ;
 	         $B1 = 'VARCHAR2';
 	         $B2 = 'NUMBER';
 	     }
 	 
 	     if ( $estado == 'digitado')  {
 	         
 	         $﻿ATabla = array(
 	             array( campo => 'id_asientod',   tipo => 'NUMBER',    id => '0',    add => 'N',     edit => 'N',     valor => '-',     key => 'S'),
 	             array( campo => 'debe',          tipo => $B1,    id => '1',    add => 'N',     edit => 'S',     valor => $debe,     key => 'N'),
 	             array( campo => 'haber',         tipo => $B2,    id => '2',    add => 'N',     edit => 'S',     valor => $haber,     key => 'N')
 	         );
 	         
 	         $bd->_UpdateSQL('co_asientod',$﻿ATabla,$codigo); 
 	         
 	         $ATotal = $bd->query_array( 'co_asientod',
 	                                            'sum(debe) as debe, sum(haber) as haber',
 	                                            'id_asiento='.$bd->sqlvalue_inyeccion($id_asiento,true)
 	             );
 	         
 	         $debe  = $ATotal['debe'];
 	         $haber = $ATotal['haber'];
 	         
 	         $saldo = $debe - $haber;
 	         
 	         
 	         
 	         
 	         $DivAsientosTareas = 'guardado saldo: '.$saldo;
 	     }
 	     
 	     echo $DivAsientosTareas;
 	 }
 	 
?>
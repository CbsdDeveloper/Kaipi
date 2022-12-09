<?php 
 session_start(); 

 require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 
 require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
 
  
 
 
    $bd	   =	 	new Db ;
   
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
    
    $ruc_registro     =  $_SESSION['ruc_registro'];
    $fanio            =  $_GET['fanio'];
 
  
 	 if (isset($_GET['fanio']))	{
 	  
 	     $sql = "select count(*) as nn, max(id_asiento) as id_asiento
             from co_asiento
            where tipo    = ".$bd->sqlvalue_inyeccion('T' ,true)." and
                  registro=".$bd->sqlvalue_inyeccion($ruc_registro ,true)." and
                  anio    =".$bd->sqlvalue_inyeccion($fanio ,true);
 	     
 	     $resultado1 = $bd->ejecutar($sql);
 	     $x          = $bd->obtener_array( $resultado1);
 	     $id_asiento = $x['id_asiento'] ;
 	     
 	     
 	     $DivAsientosTareas = '';
  	     $tipo   = $_GET['tipo'];
 	     $valor  = $_GET['valor'];
 	     
 	     
 	     $codigo     = $_GET['codigo'];
 	     
  	     
 	     if ($tipo == 'D') {
 	         $debe = $valor ;
 	         $haber= '0';
  	     }else {
 	         $debe = '0';
 	         $haber= $valor ;
  	     }
 	 
 
 	         $ATabla = array(
 	             array( campo => 'id_asientod',   tipo => 'NUMBER',    id => '0',    add => 'N',     edit => 'N',     valor => '-',     key => 'S'),
 	             array( campo => 'debe',          tipo => 'NUMBER',    id => '1',    add => 'N',     edit => 'S',     valor => $debe,     key => 'N'),
 	             array( campo => 'haber',         tipo => 'NUMBER',    id => '2',    add => 'N',     edit => 'S',     valor => $haber,     key => 'N')
 	         );
 	         
 	         $bd->_UpdateSQL('co_asientod',$ATabla,$codigo); 
 	         
 	         
 	         $sql = 'UPDATE co_asiento_aux
            			   SET   debe='.$bd->sqlvalue_inyeccion($debe, true).',
            					 haber='.$bd->sqlvalue_inyeccion($haber, true).'
            				 WHERE id_asientod='.$bd->sqlvalue_inyeccion($codigo, true);
 	         
 	         $bd->ejecutar($sql);
 	         
 
 	         
 	         
 	         $ATotal = $bd->query_array( 'co_asientod',
 	                                            'sum(debe) as debe, sum(haber) as haber',
 	                                            'id_asiento='.$bd->sqlvalue_inyeccion($id_asiento,true)
 	             );
 	         
 	         $debe  = $ATotal['debe'];
 	         $haber = $ATotal['haber'];
 	         
 	         $saldo = $debe - $haber;
 	         
 	         
 	         
 	         
 	         $DivAsientosTareas = 'guardado saldo: '.$saldo;
 	      
 	     
 	     echo $DivAsientosTareas;
 	 }
 	 
?>
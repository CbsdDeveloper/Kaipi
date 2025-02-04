 <?php 
 session_start( );
 
 require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
 require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
 
 
 $bd	   =	new Db;
 
 $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

 //-------------------------------------------------
 // verifica sumatoria de facturas
 //--------------------------------------------------
   
 $sql_det1 = "SELECT *
                        FROM migra.existencia2019 where saldo > 0";
 
 $stmt1 = $bd->ejecutar($sql_det1);
 
 $i = 1;
 while ($x=$bd->obtener_fila($stmt1)){
    
     
     $producto = _detalle($bd,$x);
      
    
     $i++;
 }
 
 echo $i.'  registrso '.$producto;
//----------------------------------------
 
 //---------------
 function _detalle(  $bd ,$x ){
     
     //---------------------------------------------------
    
     $sesion 	       =    trim($_SESSION['email']);
     
     $idproducto =  $x['codigo'];
     $id_movimiento = 1129;
     
     //----------------------------------------------------
      
     $venta = $x['costo'];
      
    
     //----------------------------------------------------
     $saldo = $x['saldo'];
     $tributo= 'T';
      
      
     $ingreso = $x['saldo'];
     $egreso = '0';
 
 
         $monto_iva   = '0.00';
         $tarifa_cero = $venta * $saldo;
         $baseiva = '0.00';
 
     
     $ATabla = array(
         array( campo => 'idproducto',   tipo => 'VARCHAR2',   id => '0',  add => 'S',   edit => 'S',   valor => $idproducto,   filtro => 'N',   key => 'N'),
         array( campo => 'cantidad',   tipo => 'NUMBER',   id => '1',  add => 'S',   edit => 'S',   valor => $saldo,   filtro => 'N',   key => 'N'),
         array( campo => 'id_movimiento',   tipo => 'NUMBER',   id => '2',  add => 'S',   edit => 'S',   valor => $id_movimiento,   filtro => 'N',   key => 'N'),
         array( campo => 'id_movimientod',   tipo => 'NUMBER',   id => '3',  add => 'N',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'S'),
         array( campo => 'costo',   tipo => 'NUMBER',   id => '4',  add => 'S',   edit => 'S',   valor => $venta,   filtro => 'N',   key => 'N'),
         array( campo => 'total',   tipo => 'NUMBER',   id => '5',  add => 'S',   edit => 'S',   valor => $tarifa_cero,   filtro => 'N',   key => 'N'),
         array( campo => 'monto_iva',   tipo => 'NUMBER',   id => '6',  add => 'S',   edit => 'S',   valor => $monto_iva,   filtro => 'N',   key => 'N'),
         array( campo => 'tarifa_cero',   tipo => 'NUMBER',   id => '7',  add => 'S',   edit => 'S',   valor => $tarifa_cero,   filtro => 'N',   key => 'N'),
         array( campo => 'estado',   tipo => 'VARCHAR2',   id => '8',  add => 'S',   edit => 'S',   valor => 'S',   filtro => 'N',   key => 'N'),
         array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '9',  add => 'S',   edit => 'S',   valor => $tributo,   filtro => 'N',   key => 'N'),
         array( campo => 'ingreso',   tipo => 'NUMBER',   id => '10',  add => 'S',   edit => 'S',   valor => $ingreso,   filtro => 'N',   key => 'N'),
         array( campo => 'egreso',   tipo => 'NUMBER',   id => '11',  add => 'S',   edit => 'S',   valor => $egreso,   filtro => 'N',   key => 'N'),
         array( campo => 'baseiva',   tipo => 'NUMBER',   id => '12',  add => 'S',   edit => 'S',   valor => $baseiva,   filtro => 'N',   key => 'N'),
         array( campo => 'sesion',   tipo => 'NUMBER',   id => '13',  add => 'S',   edit => 'N',   valor => $sesion,   filtro => 'N',   key => 'N')
         
     );
     
     
    
                     
                     $bd->_InsertSQL('inv_movimiento_det',$ATabla, '-' );
                     
 
     
 }
 //----------------------------------------------
  
  
?>
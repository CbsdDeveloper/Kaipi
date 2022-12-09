<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

$bd	   = new Db ;

 

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);


 
$codigo	         =	trim($_POST["idprov_abono"]);


$xzq = $bd->query_array('inv_movimiento',
                        'min(id_movimiento) as mov1, max(id_movimiento)   as mov2, count(*) as nn',
                        "idprov = ".$bd->sqlvalue_inyeccion($codigo, true)." and
                        cab_codigo=1 and estado= 'digitado'");


    $mov1 =  $xzq["mov1"];
    $mov2 =  $xzq["mov2"];
     
    $numero =  $xzq["nn"];
 
    
    if ($numero  == 1 )  {
        
        genera_datos_solo(  $bd,  $mov1  ,$codigo);
        
    }
    else {
        
        genera_datos_agrupados($bd,$mov1,$mov2,$codigo);
    
    /*
             
           
             
 
*/
 
}
 
 echo 'abono generado para realizar el pago!!!...';
 
//---------------------------------------------------------------------------
 function genera_datos_solo(  $bd,  $mov1  ,$codigo){
     
     
     $mov2 = agrega_movimiento_saldo($bd,  $mov1 );
      
       
     $sql = "SELECT idproducto, producto,
                                sum(monto_iva) as monto_iva,
                                sum(baseiva) as baseiva,
                                sum(tarifa_cero) as tarifa_cero,
                                sum(total) as total
                    FROM view_movimiento_det
                    where idprov = ".$bd->sqlvalue_inyeccion($codigo, true)." and
                          cab_codigo=1 and estado= 'digitado'
                    group by  idproducto, producto";
     
     $stmt_ac = $bd->ejecutar($sql);
     
     
     while ($x=$bd->obtener_fila($stmt_ac)){
         
         $idproducto = $x["idproducto"];
         
         $objeto1 = 'base_'.$x["idproducto"];
         $objeto2 = 'iva_'.$x["idproducto"];
         $objeto3 = 'base0_'.$x["idproducto"];
         //   $objeto4 = 'interes_'.$x["idproducto"];
         $objeto5 = 'total_'.$x["idproducto"];
         
         
         $base_pago  =  $_POST[$objeto1];
         $iva_pago   =  $_POST[$objeto2];
         $base0_pago =  $_POST[$objeto3];
         //  $interes_pago =  $_POST[$objeto4];
         $total_pago =  $_POST[$objeto5];
         
         $base_saldo  =  $x["baseiva"]     -  $base_pago;
         $iva_saldo   =  $x["monto_iva"]   -  $iva_pago;
         $base0_saldo =  $x["tarifa_cero"] -  $base0_pago;
         $total_saldo =  $x["total"]       -  ($base_pago + $iva_pago + $base0_pago);
         
         if ( $total_pago > 0 ){
             
             //-------------------------------------------------saldo abono
             $xq = $bd->query_array('inv_movimiento_det','id_movimientod',
                 'id_movimiento='.$bd->sqlvalue_inyeccion($mov1,true). ' and   idproducto='.$bd->sqlvalue_inyeccion($idproducto,true)
                 );
             
             $costo11 = $base_saldo + $base0_saldo;
             
             $id_movimientod1 =  $xq["id_movimientod"];
             
             if ( !empty($id_movimientod1)) {
                 
                 $sqlSaldop = "update inv_movimiento_det
                                        set costo = ".$bd->sqlvalue_inyeccion($costo11, true)." ,
                                             total= ".$bd->sqlvalue_inyeccion($total_saldo, true)." ,
                                            baseiva= ".$bd->sqlvalue_inyeccion($base_saldo, true)." ,
                                            monto_iva= ".$bd->sqlvalue_inyeccion($iva_saldo, true)." ,
                                            tarifa_cero= ".$bd->sqlvalue_inyeccion($base0_saldo, true)."
                                        where id_movimientod=".$bd->sqlvalue_inyeccion($xq["id_movimientod"], true) ;
                 
                 $bd->ejecutar($sqlSaldop);
                 
             }else  {
                 
                 nuevo($bd,$mov1,$idproducto,  $iva_saldo,$base_saldo,$base0_saldo,$total_saldo,$costo11);
                 
             }
             
              //-------------------------------------------------saldo abono
             //-------------------------------------------------pago
             $yq = $bd->query_array('inv_movimiento_det','id_movimientod',
                 'id_movimiento='.$bd->sqlvalue_inyeccion($mov2,true). ' and idproducto='.$bd->sqlvalue_inyeccion($idproducto,true)
                 );
             
             $costo1 = $base_pago + $base0_pago;
             
             $id_movimientod =  $yq["id_movimientod"];
             
             if ( !empty($id_movimientod)) {
                 
                 if ( $total_pago  > 0 )  {
                     
                     $sql1 = "update inv_movimiento_det
                                                set costo = ".$bd->sqlvalue_inyeccion($costo1, true)." ,
                                                     total= ".$bd->sqlvalue_inyeccion($total_pago, true)." ,
                                                    baseiva= ".$bd->sqlvalue_inyeccion($base_pago, true)." ,
                                                    monto_iva= ".$bd->sqlvalue_inyeccion($iva_pago, true)." ,
                                                    tarifa_cero= ".$bd->sqlvalue_inyeccion($base0_pago, true)."
                                                where id_movimientod=".$bd->sqlvalue_inyeccion($id_movimientod, true) ;
                     
                     $bd->ejecutar($sql1);
                     
                 }
                  
             }else  {
                 
                 if ( $total_pago  > 0 )  {
                     
                     nuevo($bd,$mov2,$idproducto,  $iva_pago,$base_pago,$base0_pago,$total_pago,$costo1);
                     
                 }
             }
             
         }
         
         
         $sql12 = "update inv_movimiento
                                        set   cab_codigo= 0
                                        where id_movimiento=".$bd->sqlvalue_inyeccion($mov2, true) ;
         
         $bd->ejecutar($sql12);
         
         
         $sql_saldo = "update inv_movimiento
                                        set   cab_codigo= 0
                                        where id_movimiento=".$bd->sqlvalue_inyeccion($mov1, true) ;
         
         $bd->ejecutar($sql_saldo);
         
         
         _Verifica_suma_facturas(  $bd,  $mov1  );
         
         _Verifica_suma_facturas(  $bd,  $mov2  );
 
         
     } 
 }
//---------------------------------------------------------------------------
//---------------------------------------------------------------------------
 function genera_datos_agrupados(  $bd,  $mov1 ,$mov2 ,$codigo){
     
     $sql = "SELECT idproducto, producto,
                                sum(monto_iva) as monto_iva,
                                sum(baseiva) as baseiva,
                                sum(tarifa_cero) as tarifa_cero,
                                sum(total) as total
                    FROM view_movimiento_det
                    where idprov = ".$bd->sqlvalue_inyeccion($codigo, true)." and
                          cab_codigo=1 and estado= 'digitado'
                    group by  idproducto, producto";
     
     $stmt_ac = $bd->ejecutar($sql);
     
     
     while ($x=$bd->obtener_fila($stmt_ac)){
         
         $idproducto = $x["idproducto"];
         
         $objeto1 = 'base_'.$x["idproducto"];
         $objeto2 = 'iva_'.$x["idproducto"];
         $objeto3 = 'base0_'.$x["idproducto"];
         //   $objeto4 = 'interes_'.$x["idproducto"];
         $objeto5 = 'total_'.$x["idproducto"];
         
         
         $base_pago  =  $_POST[$objeto1];
         $iva_pago   =  $_POST[$objeto2];
         $base0_pago =  $_POST[$objeto3];
         //  $interes_pago =  $_POST[$objeto4];
         $total_pago =  $_POST[$objeto5];
         
         $base_saldo  =  $x["baseiva"]     -  $base_pago;
         $iva_saldo   =  $x["monto_iva"]   -  $iva_pago;
         $base0_saldo =  $x["tarifa_cero"] -  $base0_pago;
         $total_saldo =  $x["total"]       -  ($base_pago + $iva_pago + $base0_pago);
         
         
         //-------------------------------------------------saldo abono
         $xq = $bd->query_array('inv_movimiento_det','id_movimientod',
             'id_movimiento='.$bd->sqlvalue_inyeccion($mov1,true). ' and   idproducto='.$bd->sqlvalue_inyeccion($idproducto,true)
             );
         
         $costo11 = $base_saldo + $base0_saldo;
         
         $id_movimientod1 =  $xq["id_movimientod"];
         
         if ( !empty($id_movimientod1)) {
             
             $sqlSaldop = "update inv_movimiento_det
                                        set costo = ".$bd->sqlvalue_inyeccion($costo11, true)." ,
                                             total= ".$bd->sqlvalue_inyeccion($total_saldo, true)." ,
                                            baseiva= ".$bd->sqlvalue_inyeccion($base_saldo, true)." ,
                                            monto_iva= ".$bd->sqlvalue_inyeccion($iva_saldo, true)." ,
                                            tarifa_cero= ".$bd->sqlvalue_inyeccion($base0_saldo, true)."
                                        where id_movimientod=".$bd->sqlvalue_inyeccion($xq["id_movimientod"], true) ;
             
             $bd->ejecutar($sqlSaldop);
              
         }else  {
              
             nuevo($bd,$mov1,$idproducto,  $iva_saldo,$base_saldo,$base0_saldo,$total_saldo,$costo11);
              
         }
         
              
         //-------------------------------------------------saldo abono
         //-------------------------------------------------pago
         $yq = $bd->query_array('inv_movimiento_det','id_movimientod',
             'id_movimiento='.$bd->sqlvalue_inyeccion($mov2,true). ' and idproducto='.$bd->sqlvalue_inyeccion($idproducto,true)
             );
         
         $costo1 = $base_pago + $base0_pago;
         
         $id_movimientod =  $yq["id_movimientod"];
         
         if ( !empty($id_movimientod)) {
             
             if ( $total_pago  > 0 )  {
                 
                 $sql1 = "update inv_movimiento_det
                                                set costo = ".$bd->sqlvalue_inyeccion($costo1, true)." ,
                                                     total= ".$bd->sqlvalue_inyeccion($total_pago, true)." ,
                                                    baseiva= ".$bd->sqlvalue_inyeccion($base_pago, true)." ,
                                                    monto_iva= ".$bd->sqlvalue_inyeccion($iva_pago, true)." ,
                                                    tarifa_cero= ".$bd->sqlvalue_inyeccion($base0_pago, true)."
                                                where id_movimientod=".$bd->sqlvalue_inyeccion($id_movimientod, true) ;
                 
                 $bd->ejecutar($sql1);
                 
             }
             
             
             
         }else  {
             
             if ( $total_pago  > 0 )  {
                 
                 nuevo($bd,$mov2,$idproducto,  $iva_pago,$base_pago,$base0_pago,$total_pago,$costo1);
                 
             }
          }
          
     }
     
         
     $sql12 = "update inv_movimiento
                                        set detalle = detalle || "."' CONVENIO DE PAGO GENERADO  '".", cab_codigo= 0
                                        where id_movimiento=".$bd->sqlvalue_inyeccion($mov2, true) ;
     
     $bd->ejecutar($sql12);
     
     
     $sql_saldo = "update inv_movimiento
                                        set   cab_codigo= 0
                                        where id_movimiento=".$bd->sqlvalue_inyeccion($mov1, true) ;
     
     $bd->ejecutar($sql_saldo);
     
     
     _Verifica_suma_facturas(  $bd,  $mov1  );
     
     _Verifica_suma_facturas(  $bd,  $mov2  );
     
 }
 
 
function _Verifica_suma_facturas(  $bd,  $mov1  ){
    
     
 
        
        $ATotal = $bd->query_array(
            'inv_movimiento_det',
            'sum( total) as t1, sum(monto_iva) as t2, sum(tarifa_cero) as t3, sum(baseiva) as t4',
            ' id_movimiento ='.$bd->sqlvalue_inyeccion($mov1,true)
            );
 
            $sqlEdit = "update inv_movimiento
        				           set  iva = ".$bd->sqlvalue_inyeccion($ATotal['t2'],true).",
                                  base0 = ".$bd->sqlvalue_inyeccion($ATotal['t3'],true).",
                                  base12 = ".$bd->sqlvalue_inyeccion($ATotal['t4'],true).",
                                  total = ".$bd->sqlvalue_inyeccion($ATotal['t1'],true)."
         				 		 WHERE  id_movimiento=".$bd->sqlvalue_inyeccion( $mov1, true);
        
        
        $bd->ejecutar($sqlEdit);
        
 
        
        $sqlEdit1 = "delete from  inv_movimiento_det where   total <=".$bd->sqlvalue_inyeccion(0,true)." and 
         				 		    id_movimiento=".$bd->sqlvalue_inyeccion( $mov1, true);
        
        
        $bd->ejecutar($sqlEdit1);
        
        
    
}
///----------------------
function nuevo($bd,$id_movimiento,$idproducto,  $monto_iva,$baseiva,$tarifa_cero,$total,$costo){
 
        $ingreso = '0';
        $egreso = '1';
        
    
    
    //----------------------------------------------------
        if ( $monto_iva > 0  ){
            $tributo = 'I';
        }else {
            $tributo = 'T';
        }
        
        $sesion = trim($_SESSION['email']);
 
    
    
    $ATabla = array(
        array( campo => 'idproducto',   tipo => 'VARCHAR2',   id => '0',  add => 'S',   edit => 'S',   valor => $idproducto,   filtro => 'N',   key => 'N'),
        array( campo => 'cantidad',   tipo => 'NUMBER',   id => '1',  add => 'S',   edit => 'S',   valor => 1,   filtro => 'N',   key => 'N'),
        array( campo => 'id_movimiento',   tipo => 'NUMBER',   id => '2',  add => 'S',   edit => 'S',   valor => $id_movimiento,   filtro => 'N',   key => 'N'),
        array( campo => 'id_movimientod',   tipo => 'NUMBER',   id => '3',  add => 'N',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'S'),
        array( campo => 'costo',   tipo => 'NUMBER',   id => '4',  add => 'S',   edit => 'S',   valor =>$costo,   filtro => 'N',   key => 'N'),
        array( campo => 'total',   tipo => 'NUMBER',   id => '5',  add => 'S',   edit => 'S',   valor => $total,   filtro => 'N',   key => 'N'),
        array( campo => 'monto_iva',   tipo => 'NUMBER',   id => '6',  add => 'S',   edit => 'S',   valor => $monto_iva,   filtro => 'N',   key => 'N'),
        array( campo => 'tarifa_cero',   tipo => 'NUMBER',   id => '7',  add => 'S',   edit => 'S',   valor => $tarifa_cero,   filtro => 'N',   key => 'N'),
        array( campo => 'estado',   tipo => 'VARCHAR2',   id => '8',  add => 'S',   edit => 'S',   valor => 'S',   filtro => 'N',   key => 'N'),
        array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '9',  add => 'S',   edit => 'S',   valor => $tributo,   filtro => 'N',   key => 'N'),
        array( campo => 'ingreso',   tipo => 'NUMBER',   id => '10',  add => 'S',   edit => 'S',   valor => $ingreso,   filtro => 'N',   key => 'N'),
        array( campo => 'egreso',   tipo => 'NUMBER',   id => '11',  add => 'S',   edit => 'S',   valor => $egreso,   filtro => 'N',   key => 'N'),
        array( campo => 'baseiva',   tipo => 'NUMBER',   id => '12',  add => 'S',   edit => 'N',   valor => $baseiva,   filtro => 'N',   key => 'N'),
        array( campo => 'sesion',   tipo => 'NUMBER',   id => '13',  add => 'S',   edit => 'N',   valor => $sesion,   filtro => 'N',   key => 'N')
    );
    
 
                
    if ( $total > 0 ){
        
        $bd->_InsertSQL('inv_movimiento_det',$ATabla, '-' );
        
    }
 
    
}
///************************ $mov2 = ();
function agrega_movimiento_saldo($bd,  $mov1 ){
    
    
    $x = $bd->query_array(
        'inv_movimiento',
        'fecha,registro,detalle,sesion,creacion,comprobante,estado,tipo,id_periodo,documento,idprov,cierre',
        ' id_movimiento ='.$bd->sqlvalue_inyeccion($mov1,true)
        );
    
    $detalle = 'En convenio de pago '.$x['detalle'];
    
    
    $ATabla = array(
        array( campo => 'id_movimiento',   tipo => 'VARCHAR2',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
        array( campo => 'fecha',   tipo => 'DATE',   id => '1',  add => 'S',   edit => 'N',   valor =>  $x['fecha'],   filtro => 'N',   key => 'N'),
        array( campo => 'registro',   tipo => 'VARCHAR2',   id => '2',  add => 'S',   edit => 'N',   valor => $x['registro'],   filtro => 'N',   key => 'N'),
        array( campo => 'detalle',   tipo => 'VARCHAR2',   id => '3',  add => 'S',   edit => 'S',   valor => $detalle,   filtro => 'N',   key => 'N'),
        array( campo => 'sesion',   tipo => 'VARCHAR2',   id => '4',  add => 'S',   edit => 'S',   valor => $x['sesion'] ,   filtro => 'N',   key => 'N'),
        array( campo => 'creacion',   tipo => 'DATE',   id => '5',  add => 'S',   edit => 'N',   valor =>$x['creacion'],   filtro => 'N',   key => 'N'),
        array( campo => 'comprobante',   tipo => 'VARCHAR2',   id => '6',  add => 'N',   edit => 'N',   valor => $x['comprobante'],   filtro => 'N',   key => 'N'),
        array( campo => 'estado',   tipo => 'VARCHAR2',   id => '7',  add => 'S',   edit => 'N',   valor => 'digitado',   filtro => 'N',   key => 'N'),
        array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '8',  add => 'S',   edit => 'N',   valor => 'F',   filtro => 'N',   key => 'N'),
        array( campo => 'id_periodo',   tipo => 'NUMBER',   id => '9',  add => 'S',   edit => 'N',   valor => $x['id_periodo'],   filtro => 'N',   key => 'N'),
        array( campo => 'documento',   tipo => 'VARCHAR2',   id => '10',  add => 'S',   edit => 'S',   valor =>$x['documento'],   filtro => 'N',   key => 'N'),
        array( campo => 'idprov',   tipo => 'VARCHAR2',   id => '11',  add => 'S',   edit => 'S',   valor =>$x['idprov'],   filtro => 'N',   key => 'N'),
        array( campo => 'cierre',   tipo => 'VARCHAR2',   id => '14',  add => 'S',   edit => 'N',   valor => 'N',   filtro => 'N',   key => 'N'),
        array( campo => 'base12',   tipo => 'NUMBER',   id => '15',  add => 'S',   edit => 'S',   valor => '0',   filtro => 'N',   key => 'N'),
        array( campo => 'iva',   tipo => 'NUMBER',   id => '16',  add => 'S',   edit => 'S',   valor => '0',   filtro => 'N',   key => 'N'),
        array( campo => 'base0',   tipo => 'NUMBER',   id => '17',  add => 'S',   edit => 'S',   valor => '0',   filtro => 'N',   key => 'N'),
        array( campo => 'total',   tipo => 'NUMBER',   id => '18',  add => 'S',   edit => 'S',   valor => '0',   filtro => 'N',   key => 'N'),
        array( campo => 'novedad',   tipo => 'VARCHAR2',   id => '19',  add => 'S',   edit => 'N',   valor => 'servicio convenio',   filtro => 'N',   key => 'N'),
        array( campo => 'idbodega',   tipo => 'NUMBER',   id => '20',  add => 'S',   edit => 'N',   valor => '0',   filtro => 'N',   key => 'N'),
        array( campo => 'carga',   tipo => 'VARCHAR2',   id => '21',  add => 'S',   edit => 'N',   valor => '0',   filtro => 'N',   key => 'N'),
        array( campo => 'modulo',   tipo => 'VARCHAR2',   id => '22',  add => 'S',   edit => 'N',   valor => 'arriendo',   filtro => 'N',   key => 'N'),
    );
    
        
        $tabla 	  	  = 'inv_movimiento';
        
        
        $id = $bd->_InsertSQL($tabla,$ATabla, '-' );
    
        return $id ;
}

?>
 
  
<?php
session_start( );

require  '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require  '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require  '../../facturae/crearXMLFactura.php';

date_default_timezone_set('UTC');
date_default_timezone_set('America/Lima');
setlocale(LC_TIME, 'es_ES.UTF-8');
setlocale (LC_TIME,"spanish");

 
 $bd	   =	new Db;
 
 $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

 //-------------------------------------------------
 // verifica sumatoria de facturas
 //--------------------------------------------------
 _Verifica_facturas( $bd  );
// _Verifica_suma_facturas(  $bd  );
 _Verifica_suma_facturas_Total(  $bd  ) ;
 
 
 $id          = $_GET['id'];
 $ruc         = $_SESSION['ruc_registro'];
 
 //---------------- empresa ruc -------------------
 //--------------------------------------------------
 $ADatos = $bd->query_array(
     'web_registro',
     'razon, contacto, correo,direccion,felectronica,estab,ruc_registro,obligado,firma,carpeta,ambiente,comercial',
     'ruc_registro='.$bd->sqlvalue_inyeccion( $ruc,true)
     );
 
 $estab       = trim($ADatos['estab'] )  ;
 
 $ptoEmi      =  '001';
 
 $ambiente    =  $ADatos['ambiente'];
 
 
 $serie = trim($estab).trim($ptoEmi);
 
 //---------------- cliente factura ----------------------
 //--------------------------------------------------
 
 $Array_Cabecera = $bd->query_array(
     'view_inv_movimiento',
     'id_movimiento, fecha, registro, detalle, sesion, creacion, comprobante, estado, tipo,
              id_periodo, documento, idprov, id_asiento_ref, proveedor, razon, direccion,
              telefono, correo, contacto, fechaa, anio, mes, transaccion, carga,autorizacion',
     'id_movimiento ='.$bd->sqlvalue_inyeccion($id,true)
     );

 //------------------------------------------------------------------------------
 //$fecha, $codigo_doc, $ruc, $ambiente, $serie, $secuencia, $codigo, $emision "2018-12-21" -  23 12 2018
  
 if (empty($Array_Cabecera['autorizacion'])){
     
     require "RideSRI/XmlDoc.php" ;
     
     $clave=XmlDoc::createClaveAcceso($Array_Cabecera['fecha'],
         "1",
         trim($ADatos['ruc_registro']),
         $ambiente,
         $serie,
         trim($Array_Cabecera['comprobante']),
         $id,
         1);
     
     
     $data  = $clave;
     
     xml_creacion( $bd,$data,$Array_Cabecera,$ADatos,$id,$ambiente,$estab,$ptoEmi);
     
     
     $sql = "UPDATE inv_movimiento
						   SET 	autorizacion=".$bd->sqlvalue_inyeccion($clave, true)."
 						 WHERE id_movimiento=".$bd->sqlvalue_inyeccion($id, true);
     
     $bd->ejecutar($sql);
     
 }else{
    
     $data = $Array_Cabecera['autorizacion'];
     
 }
 

  
 echo $data; 
 
//----------------------------------------
 function _Verifica_facturas( $bd  ){
     
     $sqlEdit = "update inv_movimiento_det
				      set monto_iva = 0 , 
                          tarifa_cero = total / cantidad , 
                          baseiva = 0 ,
                          costo = total / cantidad "."
 				 		 WHERE  tarifa_cero is null and
                                cantidad > 0 and
                                monto_iva is null and
                                tipo=".$bd->sqlvalue_inyeccion('T', true);
     
     $bd->ejecutar($sqlEdit);
     
     
     //--------------
     $sqlEdit = "update inv_movimiento_det
				      set monto_iva = 0 ,
                          baseiva = 0 
 				 		 WHERE  cantidad > 0 and
                                tarifa_cero > 0 and
                                monto_iva is null and
                                tipo=".$bd->sqlvalue_inyeccion('T', true);
     
     $bd->ejecutar($sqlEdit);
     
     //-----
     
     $sqlEdit = "update inv_movimiento_det
				      set tarifa_cero = 0  
 				 		 WHERE  cantidad > 0 and
                                tarifa_cero is null and
                                monto_iva > 0 ";
     
     $bd->ejecutar($sqlEdit);
     
     //---------------
     
     
     $sql = "update inv_movimiento_det
                        set tipo = ".$bd->sqlvalue_inyeccion('T', true)."
                        where   cantidad > 0 and monto_iva = 0 and tipo is null" ;
     
     $bd->ejecutar($sql);
     
     
     $sql = "update inv_movimiento_det
                     set tarifa_cero = costo * cantidad,
                         total       = costo * cantidad
                   where  tipo = ".$bd->sqlvalue_inyeccion('T', true)." and
                          (monto_iva + tarifa_cero + baseiva) <> total" ;
     
     $bd->ejecutar($sql);
     
     
     //----------------
     $sqlEdit = "update inv_movimiento_det
				      set tarifa_cero = total / cantidad , baseiva = 0 ,costo = total / cantidad "."
 				 		 WHERE  cantidad = 1 and
                                monto_iva = 0 and total <> tarifa_cero  and
                                tipo=".$bd->sqlvalue_inyeccion('T', true);
     
     $bd->ejecutar($sqlEdit);
     
 }
 //---------------
 function _Verifica_suma_facturas(  $bd  ){
     
     
     $sql_det1 = "SELECT id_movimiento,    iva, base0, base12, total
                        FROM inv_movimiento
                        where (base0 is null  or iva is null ) and  estado = 'aprobado' ";
     
     $stmt1 = $bd->ejecutar($sql_det1);
     
     
     while ($x=$bd->obtener_fila($stmt1)){
         
         $id = $x['id_movimiento'];
         
         $ATotal = $bd->query_array(
             'inv_movimiento_det',
             'sum( total) as t1, sum(monto_iva) as t2, sum(tarifa_cero) as t3, sum(baseiva) as t4',
             ' id_movimiento ='.$bd->sqlvalue_inyeccion($id,true)
             );
         
         if ($ATotal['t1'] > 0) {
             
             $sqlEdit = "update inv_movimiento
        				           set  iva = ".$bd->sqlvalue_inyeccion($ATotal['t2'],true).",
                                  base0 = ".$bd->sqlvalue_inyeccion($ATotal['t3'],true).",
                                  base12 = ".$bd->sqlvalue_inyeccion($ATotal['t4'],true).",
                                  total = ".$bd->sqlvalue_inyeccion($ATotal['t1'],true)."
         				 		 WHERE  id_movimiento=".$bd->sqlvalue_inyeccion( $id, true);
             
         }else {
             
             $sqlEdit = "update inv_movimiento
        				           set  estado = ".$bd->sqlvalue_inyeccion('anulado',true)."
          				 		 WHERE  id_movimiento=".$bd->sqlvalue_inyeccion( $id, true);
             
         }
         
         $bd->ejecutar($sqlEdit);
         
         
     }
     
 }
 //----------------------------------------------
 //---------------
 function _Verifica_suma_facturas_Total(  $bd  ){
     
     
     $sql_det1 = "select   id_movimiento
                        FROM inv_movimiento
                        where ( iva + base0 + base12) <> total and    estado = 'aprobado'";
     
     
     
     $stmt1 = $bd->ejecutar($sql_det1);
     
     
     while ($x=$bd->obtener_fila($stmt1)){
         
         $id = $x['id_movimiento'];
         
         $ATotal = $bd->query_array(
             'inv_movimiento_det',
             'sum( total) as t1, sum(monto_iva) as t2, sum(tarifa_cero) as t3, sum(baseiva) as t4',
             ' id_movimiento ='.$bd->sqlvalue_inyeccion($id,true)
             );
         
         $sqlEdit = "update inv_movimiento
				     set  iva = ".$bd->sqlvalue_inyeccion($ATotal['t2'],true).",
                          base0 = ".$bd->sqlvalue_inyeccion($ATotal['t3'],true).",
                          base12 = ".$bd->sqlvalue_inyeccion($ATotal['t4'],true).",
                          total = ".$bd->sqlvalue_inyeccion($ATotal['t1'],true)."
 				 		 WHERE  id_movimiento=".$bd->sqlvalue_inyeccion( $id, true);
         
         $bd->ejecutar($sqlEdit);
         
         
     }
     
 }
 
  
?>
<?php 
 session_start( );
 
 require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
 
 require  '../../facturae/FirmaXades/FirmaElectronicaNativa.php'; 
 require  '../../facturae/crearXMLnotac.php'; 
 
 
 $signer=new FirmaElectronica(); // Instancio la clase
 
 $bd	   =	new Db;
 
 $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

 //-------------------------------------------------
 // verifica sumatoria de facturas
 //--------------------------------------------------
 
 
 
 $id          = $_GET['id'];
 $ruc         = $_SESSION['ruc_registro'];
 
 //---------------- empresa ruc -------------------
 //--------------------------------------------------
 $ADatos = $bd->query_array(
     'web_registro',
     'razon, contacto, correo,direccion,felectronica,estab,ruc_registro,obligado,firma,carpeta,ambiente',
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
 
 
 $Array_CabeceraNC = $bd->query_array(
     'doctor_vta',
     'idcliente, tipocomprobante, comprobante1, secuencial, codestab,
     coddocmodificado, numdocmodificado, fechaemision,
     secuencial1,
     cab_autorizacion, fechaemisiondocsustento, fecha_factura, estab1, ptoemi1',
     'id_diario ='.$bd->sqlvalue_inyeccion($id,true)
     );
 
 
 //------------------------------------------------------------------------------
 //$fecha, $codigo_doc, $ruc, $ambiente, $serie, $secuencia, $codigo, $emision "2018-12-21" -  23 12 2018
  
 if (empty($Array_CabeceraNC['cab_autorizacion'])){
     
     $clave = $signer->createClaveAcceso($Array_CabeceraNC['fechaemisiondocsustento'],
         "4", trim($ADatos['ruc_registro']),
         $ambiente,
         $serie,
         trim($Array_CabeceraNC['secuencial1']),
         $id,1);
     
    
     
     $data  = $clave;
     
     $FacturaElectronica = $clave;
     
     xml_creacion( $bd,$data,$Array_Cabecera,$ADatos,$id,$ambiente,$estab,$ptoEmi,$Array_CabeceraNC);
     
     $sql = "UPDATE doctor_vta
						   SET 	cab_autorizacion=".$bd->sqlvalue_inyeccion($clave, true)."
 						 WHERE id_diario=".$bd->sqlvalue_inyeccion($id, true);
     
     $bd->ejecutar($sql);
     
 }else{
    
     $FacturaElectronica = $Array_Cabecera['cab_autorizacion'];
     
 }
 

  
 echo $FacturaElectronica; 
 
 
 
  
?>
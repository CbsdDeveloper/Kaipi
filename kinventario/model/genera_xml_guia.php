<?php 
session_start( );
require '../../kconfig/Db.class.php';    
require '../../kconfig/Obj.conf.php';  

require  '../../facturae/FirmaXades/FirmaElectronicaNativa.php'; 

require  '../../facturae/crearXMLguia.php'; 
 
 
 $signer=new FirmaElectronica(); // Instancio la clase
 
 $bd	   =	new Db;
 
 $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
 
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
     'guia_cabecera',
     ' cab_codigo, coddoc, estab, ptoemi, secuencial, fecha, dirmatriz, claveacceso, 
     registro, estado, dirpartida, razonsocialtransportista, tipoidentificaciontransportista, 
     ructransportista, placa, fechainitransporte, fechafintransporte, identificaciondestinatario,
     razonsocialdestinatario, dirdestinatario, motivotraslado, ruta, factura, codestabdestino, observacion',
     'cab_codigo ='.$bd->sqlvalue_inyeccion($id,true)
     );

 

 
 
 //------------------------------------------------------------------------------
 //$fecha, $codigo_doc, $ruc, $ambiente, $serie, $secuencia, $codigo, $emision "2018-12-21" -  23 12 2018

 if ( trim($Array_Cabecera['estado'])  == 'digitado' ){
     

  
     $clave = trim($Array_Cabecera['claveacceso']);
     
      if (empty($clave)){
              
          $data =  trim($Array_Cabecera['estado']).' entro '.$Array_Cabecera['fecha'];
                 
          
          
             $data = $signer->createClaveAcceso($Array_Cabecera['fecha'],
                             "6", trim($ADatos['ruc_registro']),
                             $ambiente,
                             $serie,
                             trim($Array_Cabecera['secuencial']),
                             $id,1);
               
                
             $sql = "UPDATE guia_cabecera
            						   SET 	claveacceso=".$bd->sqlvalue_inyeccion($data, true)."
             						 WHERE cab_codigo=".$bd->sqlvalue_inyeccion($id, true);
             
             $bd->ejecutar($sql);
             
             
             xml_creacion( $bd,$data,$Array_Cabecera,$ADatos,$id,$ambiente,$estab,$ptoEmi);
                                
                 
                 
               
             }else{
                
                 $data = $Array_Cabecera['claveacceso'];
                 
             } 
 
 }  
 
 echo $data; 
 
 
  
?>
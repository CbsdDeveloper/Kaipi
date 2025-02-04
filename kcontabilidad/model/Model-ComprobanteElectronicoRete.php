<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

require  '../../facturae/FirmaXades/FirmaElectronicaNativa.php';

require  '../../facturae/crearXMLComprobante.php'; 


$signer=new FirmaElectronica(); // Instancio la clase

$bd	   =	new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);


$id          = $_GET['id_asiento'];

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
                 
$data = 'No Autorizado';

if ( $ADatos['felectronica'] == 'S' ) {
                 
                $y = $bd->query_array(
                    'co_asiento',
                    'detalle',
                    'id_asiento ='.$bd->sqlvalue_inyeccion($id,true)
                    );
                
                $detalle = substr(trim($y['detalle']),0,149);
                
                $sql = "UPDATE co_compras
                 					   SET 	detalle=".$bd->sqlvalue_inyeccion( trim($detalle), true)."
                 						 WHERE id_asiento=".$bd->sqlvalue_inyeccion($id, true);
                
                $bd->ejecutar($sql);
                
                
                $Array_Cabecera = $bd->query_array(
                    'view_anexos_compras',
                    'anio, mes, idprov, razon, id_compras,   codsustento, tpidprov, tipocomprobante, fecharegistro,
                              establecimiento, puntoemision, secuencial, fechaemision, autorizacion, basenograiva, baseimponible,
                              baseimpgrav, montoice, montoiva, valorretbienes, valorretservicios, valretserv100, registro,
                              porcentaje_iva, baseimpair, pagolocext, paisefecpago, faplicconvdobtrib, formadepago, fechaemiret1,
                              serie1, secretencion1, autretencion1, docmodificado, secmodificado, estabmodificado,
                               autmodificado, fpagextsujretnorleg, serie, detalle,comprobante,direccion,correo,id_asiento',
                    'id_asiento ='.$bd->sqlvalue_inyeccion($id,true) 
                    );
                
                //-----------------------------
                $longitud = strlen(trim($Array_Cabecera['autretencion1']));
                
                if ($longitud < 5 ){
                    
                    
                    if ( empty(trim($Array_Cabecera['secretencion1']))){
                        
                        $comprobante = K_comprobante($bd,$ruc );
                        
                    }else{
                        
                        $comprobante = trim($Array_Cabecera['secretencion1']);
                        
                    }
                 
                    
                    
                    $data = $signer->createClaveAcceso($Array_Cabecera['fecharegistro'],
                        "7", trim($ADatos['ruc_registro']),
                        $ambiente,
                        $serie,
                        trim($comprobante),
                        $id,1);
                      
                    $sql = "UPDATE co_compras
                 					   SET 	autretencion1=".$bd->sqlvalue_inyeccion($data, true).",
                                            secretencion1=".$bd->sqlvalue_inyeccion($comprobante, true)."
                 						 WHERE id_asiento=".$bd->sqlvalue_inyeccion($id, true);
                    
                     $bd->ejecutar($sql);
                    
                    
                     xml_creacion( $bd,$data,$Array_Cabecera,$ADatos,$id,$ambiente,$estab,$ptoEmi, trim($comprobante));
                    
                     
                }else{
                    
                    $data = $Array_Cabecera['autretencion1'];
                    
                }
   }
 
   echo $data;

 

//----------------------------------------
//----------------------------------------
//----------------------------------------
function K_comprobante($bd,$ruc ){
    
    
    
    $sql = "SELECT   coalesce(retencion,0) as secuencia
        	    FROM web_registro
        	    where ruc_registro = ".$bd->sqlvalue_inyeccion($ruc   ,true);
    
    
    $parametros 			= $bd->ejecutar($sql);
    
    $secuencia 				= $bd->obtener_array($parametros);
    
    $contador = $secuencia['secuencia'] + 1;
    
    $input = str_pad($contador, 9, "0", STR_PAD_LEFT);
    
    
    $sqlEdit = "UPDATE web_registro
    			   SET 	retencion=".$bd->sqlvalue_inyeccion($contador, true)."
     			 WHERE ruc_registro=".$bd->sqlvalue_inyeccion($ruc , true);
    
    
   $bd->ejecutar($sqlEdit);
    
    
    return $input ;
}


?>
 
 
  
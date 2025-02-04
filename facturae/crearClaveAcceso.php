<?php 
session_start( );
require '../kconfig/Db.class.php'; 
require '../kconfig/Obj.conf.php';  

$bd	   =	new Db;
$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
$id            = $_GET['id'];
$tipo          = $_GET['tipo'];
$ruc           = trim($_SESSION['ruc_registro']);

$ADatos = $bd->query_array(
    'web_registro',
    '*',
    'ruc_registro='.$bd->sqlvalue_inyeccion( $ruc,true)
    );


if ($tipo == '1' ){
    clave_compras($bd, $id ,$ruc ,$ADatos);
}

if ($tipo == '2' ){
    clave_notas($bd, $id ,$ruc ,$ADatos);
}

if ($tipo == '3' ){
    clave_liquidacion($bd, $id ,$ruc ,$ADatos);
}

//-----------------------
function clave_liquidacion($bd, $id ,$ruc ,$ADatos){
    
    $estab       = trim($ADatos['estab'] )  ;
    $ptoEmi      =  '001';
    $ambiente    =  $ADatos['ambiente'];
    $serie       = trim($estab).trim($ptoEmi);
    
    $Array_Cabecera = $bd->query_array(  'view_liquidaciones',   '*',  'id_liquida ='.$bd->sqlvalue_inyeccion($id,true) );
    
    $longitud = strlen(trim($Array_Cabecera['autorizacion']));
    
    if ($longitud < 5 ){
        
        require "RideSRI20/XmlDoc.php" ;
        
      
       $comprobante = trim($Array_Cabecera['secuencial']);
    
        
        $data=XmlDoc::createClaveAcceso($Array_Cabecera['fecharegistro'],
            "3",
            trim($ADatos['ruc_registro']),
            $ambiente,
            $serie,
            trim($comprobante),
            $id,
            1);
        
        $sql = "UPDATE co_liquidacion
                        SET 	autorizacion=".$bd->sqlvalue_inyeccion($data, true)."
                        WHERE id_liquida=".$bd->sqlvalue_inyeccion($id, true);
        
        $bd->ejecutar($sql);
        
        echo  $data;
    }
    
}    
//----------------------------------------
function clave_compras($bd, $id ,$ruc ,$ADatos){

    $estab       = trim($ADatos['estab'] )  ;
    $ptoEmi      =  '001';
    $ambiente    =  $ADatos['ambiente'];
    $serie       = trim($estab).trim($ptoEmi);

    $Array_Cabecera = $bd->query_array(  'view_anexos_compras',   '*',  'id_asiento ='.$bd->sqlvalue_inyeccion($id,true) );
    
    $longitud = strlen(trim($Array_Cabecera['autretencion1']));
    
    if ($longitud < 5 ){

                require "RideSRI20/XmlDoc.php" ;

                if ( empty(trim($Array_Cabecera['secretencion1']))){
                    $comprobante = K_comprobante($bd,$ruc );
                }else{
                    $comprobante = trim($Array_Cabecera['secretencion1']);
                }
    
                $data=XmlDoc::createClaveAcceso($Array_Cabecera['fecharegistro'],
                    "7",
                    trim($ADatos['ruc_registro']),
                    $ambiente,
                    $serie,
                    trim($comprobante),
                    $id,
                    1);
 
                $sql = "UPDATE co_compras
                        SET 	autretencion1=".$bd->sqlvalue_inyeccion($data, true).",
                                secretencion1=".$bd->sqlvalue_inyeccion($comprobante, true)."
                        WHERE id_asiento=".$bd->sqlvalue_inyeccion($id, true);
                
                $bd->ejecutar($sql);
                
            echo  $data;
    }

}    

//----------------------------------------
function clave_notas($bd, $id , $ruc ,$ADatos){
    
    $Array_Cabecera = $bd->query_array(
        'view_inv_movimiento',
        '*',
        'id_movimiento ='.$bd->sqlvalue_inyeccion($id,true)
        );
    
    
    $Array_CabeceraNC = $bd->query_array(
        'doctor_vta',
        '*',
        'id_diario ='.$bd->sqlvalue_inyeccion($id,true)
        );
    
    $estab       = trim($ADatos['estab'] )  ;
    $ptoEmi      =  '001';
    $ambiente    =  $ADatos['ambiente'];
    $serie       = trim($estab).trim($ptoEmi);
    
    $input = str_pad(trim($Array_CabeceraNC['secuencial1']), 9, "0", STR_PAD_LEFT);
          
    if (empty($Array_CabeceraNC['cab_autorizacion'])){
        
        require "RideSRI/XmlDoc.php" ;
   
        $data=XmlDoc::createClaveAcceso($Array_CabeceraNC['fechaemisiondocsustento'],
            "4",
            trim($ADatos['ruc_registro']),
            $ambiente,
            $serie,
            $input,
            $id,
            1);
         
        $sql = "UPDATE doctor_vta
                              SET 	cab_autorizacion=".$bd->sqlvalue_inyeccion($data, true)."
                             WHERE id_diario=".$bd->sqlvalue_inyeccion($id, true);
        
        $bd->ejecutar($sql);
        
    }else{
       
        $data = $Array_Cabecera['cab_autorizacion'];
        
    }
    
   
     
    echo $data; 
}    
//----------------------------------------
//----------------------------------------
function K_comprobante($bd,$ruc ){
     
    $sql = "SELECT   coalesce(retencion,0) as secuencia
        	    FROM web_registro
        	    where ruc_registro = ".$bd->sqlvalue_inyeccion($ruc   ,true);
    
    $parametros 			= $bd->ejecutar($sql);
    $secuencia 				= $bd->obtener_array($parametros);
    $contador               = $secuencia['secuencia'] + 1;
    $input                  = str_pad($contador, 9, "0", STR_PAD_LEFT);
    $sqlEdit                = "UPDATE web_registro
    			                  SET retencion=".$bd->sqlvalue_inyeccion($contador, true)."
     			                WHERE ruc_registro=".$bd->sqlvalue_inyeccion($ruc , true);
    $bd->ejecutar($sqlEdit);
    return $input ;
}
 
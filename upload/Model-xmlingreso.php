<?php
session_start( );

require '../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
	
	//creamos la variable donde se instanciar la clase "mysql"
	
	private $obj;
	private $bd;
	
	private $ruc;
	private $sesion;
	private $hoy;
	private $POST;
	private $datos;
	
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function proceso( ){
		//inicializamos la clase para conectarnos a la bd
		
		$this->obj     = 	new objects;
		$this->bd	   =	new Db ;
		
		$this->ruc       =  $_SESSION['ruc_registro'];
		$this->sesion 	 =  $_SESSION['email'];
		$this->hoy 	     =  date("Y-m-d"); 
		
		$this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
		
	}
   
	//--- calcula libro diario
	function archivo_xml($archivo ){
        
	    $sqldelete = 'delete from xml_sesion where sesion = '.$this->bd->sqlvalue_inyeccion($this->sesion, true);

        $this->bd->ejecutar($sqldelete);

         
         $file = '../archivos/'.$archivo ;

         $myfile = fopen(  $file , "r") or die("Unable to open file!");
	
	     $i = 0;
          
        while(!feof($myfile)) {
	 	
	           // $linea = fgets($myfile) ;
	           
            $linea = fgets($myfile);
	
 	         //  if ( $i <= 300 ){
 	 	
		    $linea = htmlspecialchars_decode($linea);
		            
		 
 			 
                    $sql = "INSERT INTO xml_sesion ( sesion, etiqueta) values (".
                                 $this->bd->sqlvalue_inyeccion($this->sesion, true).",".
                                 $this->bd->sqlvalue_inyeccion( $linea, true).")";   

                     $this->bd->ejecutar($sql);
 
	         // }	
 	            $i++;
         }
	
        fclose($myfile);

        $this->_VariablesAnexo();
        
        $existe_proveedor = $this->existe_proveedor(  trim($this->datos['ruc'] )   );
        
         
       if ($existe_proveedor == 0){
           
           $this->_proveedor_agrega( trim( $this->datos['ruc'] ) );
       }
    
       $longintud = strlen( trim($this->datos['ruc'] ) );
       
       $secuencial   = $this->datos['secuencial'] ;
       
       $procesado =  $this->datos['ruc'].' secuencial '.$secuencial;
      
       
       $valida  = $this->BusquedaFactura( trim($secuencial),   trim( $this->datos['ruc'] ) );
       
       if ( $valida > 0 ){
           
           $procesado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>NO SE PUEDE ACTUALIZAR NRO. DE FACTURA YA EMITIDA ?</b>';
           
       } else {
       
       
       if ($longintud > 9)  {
               
           if  ($this->existe_asiento($this->datos['ruc'], $secuencial ) == 0 ) {
                 
                
               $idAsiento = $this->_asientos_contables( $this->datos['ruc'] , $secuencial);
                   
               $this->_anexosTransacional($idAsiento,$this->datos['ruc'], $secuencial);
               
               $procesado =  $this->datos['ruc'].' secuencial '.$secuencial.' asiento '.$idAsiento;
           
           }
         
         }
       }
       
       echo $procesado;
	
	}
//---------------------------------------------------------
	function _VariablesAnexo(  ){
	    
	    $sql_det = 'SELECT id_xmlserie, etiqueta, sesion
                     FROM xml_sesion 
                     where sesion='.$this->bd->sqlvalue_inyeccion($this->sesion, true);
	    
	    $stmt13 = $this->bd->ejecutar($sql_det);
	    
	    $n1 = 0;
	    $n2 = 0;
	    $n3 = 0;
	    $n4 = 0;
	    $n5 = 0;
	    $n6 = 0;
	    $n7 = 0;
	    $n8 = 0;
	    $n9 = 0;
	    $n10 = 0;
	    $n11 = 0;
	    $n12 = 0;
	    $n13 = 0;
	    
	    while ($x=$this->bd->obtener_fila($stmt13)){
	        
	        $etiqueta = trim($x['etiqueta']);
	        
	        
	        // <razonSocial>
	        if ( $n1 == 0){
	            $pos1_razon = strpos($etiqueta, '<razonSocial>');
    	        $pos2_razon = strpos($etiqueta, '</razonSocial>');
    	        $razon1 =$etiqueta;
	        }
 	        if ($pos2_razon > 0 ){
 	            $razon = substr($razon1,$pos1_razon,$pos2_razon - $pos1_razon);
  	            $aux1 = str_replace ( '<razonSocial>' ,'' , $razon );
  	            $aux2 = str_replace ( '</razonSocial>' ,'' , $aux1 );
  	            $this->datos['razonSocial'] = $aux2;
 	            $n1 = 1;
	        }
	        //  <ruc> 
	        if ( $n2 == 0){
	            $pos1_r = strpos($etiqueta, '<ruc>');
	            $pos2_r = strpos($etiqueta, '</ruc>');
	            $ruc1    =$etiqueta;
	        }
	        if ($pos2_r > 0 ){
	            $razon = trim(substr($ruc1,$pos1_r,$pos2_r - $pos1_r));
	            $aux1 = str_replace ( '<ruc>' ,'' , $razon );
	            $aux2 = str_replace ( '</ruc>' ,'' , $aux1 );
	            $this->datos['ruc'] = $aux2;
	            $n2 = 1;
	        }
	        // </claveAcceso>
	        if ( $n3 == 0){
	            $pos1_a = strpos($etiqueta, '<claveAcceso>');
	            $pos2_a = strpos($etiqueta, '</claveAcceso>');
	            $claveAcceso    =$etiqueta;
	        }
	        if ($pos2_a > 0 ){
	            $razon = substr($claveAcceso,$pos1_a,$pos2_a - $pos1_a);
	            $aux1 = str_replace ( '<claveAcceso>' ,'' , $razon );
	            $aux2 = str_replace ( '</claveAcceso>' ,'' , $aux1 );
	            $this->datos['claveAcceso'] = $aux2;
	            $n3 = 1;
	        }
	        //<estab>
	        if ( $n4 == 0){
	            $pos1_b = strpos($etiqueta, '<estab>');
	            $pos2_b = strpos($etiqueta, '</estab>');
	            $estab    =$etiqueta;
	        }
	        if ($pos2_b > 0 ){
	            $razon = substr($estab,$pos1_b,$pos2_b - $pos1_b);
	            $aux1 = str_replace ( '<estab>' ,'' , $razon );
	            $aux2 = str_replace ( '</estab>' ,'' , $aux1 );
	            $this->datos['estab'] = $aux2;
	            $n4 = 1;
	        }
	        //<ptoEmi>
	        if ( $n5 == 0){
	            $pos1_t = strpos($etiqueta, '<ptoEmi>');
	            $pos2_t = strpos($etiqueta, '</ptoEmi>');
	            $ptoEmi    =$etiqueta;
	        }
	        if ($pos2_t > 0 ){
	            $razon = substr($ptoEmi,$pos1_t,$pos2_t - $pos1_t);
	            $aux1 = str_replace ( '<ptoEmi>' ,'' , $razon );
	            $aux2 = str_replace ( '</ptoEmi>' ,'' , $aux1 );
	            $this->datos['ptoEmi'] = $aux2;
	            $n5 = 1;
	        }
	        //<secuencial>
	        if ( $n6 == 0){
	            $pos1_s = strpos($etiqueta, '<secuencial>');
	            $pos2_s = strpos($etiqueta, '</secuencial>');
	            $secuencial    =$etiqueta;
	        }
	        if ($pos2_s > 0 ){
	            $razon = substr($secuencial,$pos1_s,$pos2_s - $pos1_s);
	            $aux1 = str_replace ( '<secuencial>' ,'' , $razon );
	            $aux2 = str_replace ( '</secuencial>' ,'' , $aux1 );
	            $this->datos['secuencial'] = $aux2;
	            $n6 = 1;
	        }
	        //<dirMatriz>
	        if ( $n7 == 0){
	            $pos1_z = strpos($etiqueta, '<dirMatriz>');
	            $pos2_z = strpos($etiqueta, '</dirMatriz>');
	            $dirMatriz   =$etiqueta;
	        }
	        if ($pos2_z > 0 ){
	            $razon = substr($dirMatriz,$pos1_z,$pos2_z - $pos1_z);
	            $aux1 = str_replace ( '<dirMatriz>' ,'' , $razon );
	            $aux2 = str_replace ( '</dirMatriz>' ,'' , $aux1 );
	            $this->datos['dirMatriz'] = $aux2;
	            $n7 = 1;
	        }
	        //<fechaEmision>
	        if ( $n8 == 0){
	            $pos1_h = strpos($etiqueta, '<fechaEmision>');
	            $pos2_h = strpos($etiqueta, '</fechaEmision>');
	            $fechaEmision   =$etiqueta;
	        }
	        if ($pos2_h > 0 ){
	            $razon = substr($fechaEmision,$pos1_h,$pos2_h - $pos1_h);
	            $aux1 = str_replace ( '<fechaEmision>' ,'' , $razon );
	            $aux2 = str_replace ( '</fechaEmision>' ,'' , $aux1 );
	            $this->datos['fechaEmision'] = $aux2;
	            $n8 = 1;
	        }
	        //<baseImponible>
	        if ( $n9 == 0){
	            $pos1_ba = strpos($etiqueta, '<baseImponible>');
	            $pos2_ba = strpos($etiqueta, '</baseImponible>');
	            $baseImponible   =$etiqueta;
	        }
	        if ($pos2_ba > 0 ){
	            $razon = substr($baseImponible,$pos1_ba,$pos2_ba - $pos1_ba);
	            $aux1 = str_replace ( '<baseImponible>' ,'' , $razon );
	            $aux2 = str_replace ( '</baseImponible>' ,'' , $aux1 );
	            $this->datos['baseImponible'] = $aux2;
	            $n9 = 1;
	        }
	        //<valor>
	        if ( $n10 == 0){
	            $pos1_va = strpos($etiqueta, '<valor>');
	            $pos2_va = strpos($etiqueta, '</valor>');
	            $valoriva   =$etiqueta;
	        }
	        if ($pos2_va > 0 ){
	            $razon = substr($valoriva,$pos1_va,$pos2_va - $pos1_va);
	            $aux1 = str_replace ( '<valor>' ,'' , $razon );
	            $aux2 = str_replace ( '</valor>' ,'' , $aux1 );
	            $this->datos['valor'] = $aux2;
	            $n10 = 1;
	        }
	        //<importeTotal>
	        if ( $n11 == 0){
	            $pos1_ta = strpos($etiqueta, '<importeTotal>');
	            $pos2_ta = strpos($etiqueta, '</importeTotal>');
	            $valor   =$etiqueta;
	        }
	        if ($pos2_ta > 0 ){
	            $razon = substr($valor,$pos1_ta,$pos2_ta - $pos1_ta);
	            $aux1 = str_replace ( '<importeTotal>' ,'' , $razon );
	            $aux2 = str_replace ( '</importeTotal>' ,'' , $aux1 );
	            $this->datos['importeTotal'] = $aux2;
	            $n11 = 1;
	        }
	        
	       

	 	     
	    }
	    

	     
	}
//--------------------------------------------------------
	//----------------------------------------------------
	function BusquedaFactura($secuencial, $idprov){
	    
	    
	    $x = $this->bd->query_array('co_compras',
	        'count(*) as nn',
	        'idprov='.$this->bd->sqlvalue_inyeccion(trim($idprov),true) .' and '.
	        'secuencial='.$this->bd->sqlvalue_inyeccion($secuencial,true) .' and '.
	        'registro='.$this->bd->sqlvalue_inyeccion($this->ruc,true)
	        );
	    
	    
	    return $x['nn'] ;
	    
	    
	}
//---------------------------------------------------------
	function _anexosTransacional($id_asiento,$idprov,$secuencial){
	    
	    //<fechaEmision>27/05/2018</fechaEmision>  date("Y-m-d"); 
	    
	    
	    $hoy = date("Y-m-d");
	    $fecharegistro = "to_date('".$hoy."','yyyy/mm/dd')";
	    
	    $array = explode("/", $this->datos['fechaEmision']);
 	    $fecha = $array[2].'-'.$array[1].'-'.$array[0];
	 
 	    $long = strlen($fecha);
 	    if ($long > 8){
 	        $fechaemision			=  "to_date('".$fecha."','yyyy/mm/dd')";
 	    }
 	    else{
 	        $fechaemision = $fecharegistro;
 	    }
	    
	    $tpidprov = '01';
	    $establecimiento		= $this->datos['estab'];
	    $puntoemision			= $this->datos['ptoEmi'];
 	 
	        //------------------------------------------------------------
	    
	    
	 
	        $sql = "INSERT INTO co_compras(
                    id_asiento, codsustento, tpidprov, idprov, tipocomprobante,
                    fecharegistro,fechaemiret1, establecimiento, puntoemision, secuencial, fechaemision,
                    autorizacion, basenograiva, baseimponible, baseimpgrav, montoice,
                    montoiva, valorretbienes, valorretservicios, valretserv100, porcentaje_iva,baseimpair,
					formadepago,serie1,pagolocext,paisefecpago,faplicconvdobtrib,fpagextsujretnorLeg,detalle,
					registro)
            VALUES (".
            $this->bd->sqlvalue_inyeccion($id_asiento, true).",".
            $this->bd->sqlvalue_inyeccion('01', true).",".
            $this->bd->sqlvalue_inyeccion($tpidprov, true).",".
            $this->bd->sqlvalue_inyeccion(trim($idprov), true).",".
            $this->bd->sqlvalue_inyeccion('01', true).",".
            $fecharegistro.",".
			 $fecharegistro.",".
            $this->bd->sqlvalue_inyeccion($establecimiento, true).",".
            $this->bd->sqlvalue_inyeccion($puntoemision, true).",".
            $this->bd->sqlvalue_inyeccion($secuencial, true).",".
            $fechaemision.",".
            $this->bd->sqlvalue_inyeccion($this->datos['claveAcceso'], true).",".
            $this->bd->sqlvalue_inyeccion('0.00', true).",".
            $this->bd->sqlvalue_inyeccion('0.00', true).",".
            $this->bd->sqlvalue_inyeccion($this->datos['baseImponible'], true).",".
            $this->bd->sqlvalue_inyeccion('0.00', true).",".
            $this->bd->sqlvalue_inyeccion($this->datos['valor'], true).",".
            $this->bd->sqlvalue_inyeccion('0.00', true).",".
            $this->bd->sqlvalue_inyeccion('0.00', true).",".
            $this->bd->sqlvalue_inyeccion('0.00', true).",".
            $this->bd->sqlvalue_inyeccion('0.00', true).",".
            $this->bd->sqlvalue_inyeccion('0.00', true).",".
				 $this->bd->sqlvalue_inyeccion('20', true).",".
				 $this->bd->sqlvalue_inyeccion('001001', true).",".
				$this->bd->sqlvalue_inyeccion('01', true).",".
				$this->bd->sqlvalue_inyeccion('NA', true).",".
				$this->bd->sqlvalue_inyeccion('NA', true).",".
				$this->bd->sqlvalue_inyeccion('NA', true).",".
				$this->bd->sqlvalue_inyeccion('Adquisicion', true).",".
            $this->bd->sqlvalue_inyeccion($this->ruc, true).")";
            
             
            $this->bd->ejecutar($sql);
            
            $id_compras = $this->bd->ultima_secuencia('co_compras');
 
	    return $id_compras;
	}
//---------------------------------------------------------
function existe_proveedor($proveedor ){

    $Aprove = $this->bd->query_array('par_ciu',
        'count(idprov) as nn', 
        'idprov='.$this->bd->sqlvalue_inyeccion($proveedor,true)
        );
    
    
    if ( $Aprove['nn'] == 0 ) {
        return 0;
    }else {
        return 1;
    }
      
}
//---------------------------------------------------------
function existe_asiento($proveedor,$secuencial ){
    
    
    
    $Aprove = $this->bd->query_array('co_asiento',
        'count(idprov) as nn',
        'idprov='.$this->bd->sqlvalue_inyeccion($proveedor,true).' and 
        registro='.$this->bd->sqlvalue_inyeccion($this->ruc,true).' and 
        documento='.$this->bd->sqlvalue_inyeccion($secuencial,true)
        );
    
    
    if ( $Aprove['nn'] == 0 ) {
        return 0;
    }else {
        return 1;
    }
    
}
//---------------------------------------------------------
function _proveedor_agrega( $idproveedor ){
    
    
    $idprov    =    $idproveedor  ;
    $razonSocial     =    $this->datos['razonSocial'] ;
    $dirMatriz =    $this->datos['dirMatriz']  ;
   
   
    
    $InsertQuery = array(
        array( campo => 'idprov', valor => trim($idprov) ),
        array( campo => 'razon', valor => $razonSocial),
        array( campo => 'direccion', valor => $dirMatriz),
        array( campo => 'estado', valor => 'S'),
        array( campo => 'modulo', valor => 'P'),
        array( campo => 'naturaleza', valor => 'NN'),
        array( campo => 'tpidprov', valor => '01'),
        array( campo => 'idciudad', valor => '18'),
        array( campo => 'telefono', valor => '09999999'),
        array( campo => 'correo', valor => 'info@gmail.com'),
        array( campo => 'movil', valor => '09999999'),
         array( campo => 'sesion', valor => $this->sesion),
        array( campo => 'creacion', valor =>  $this->hoy),
        array( campo => 'modificacion', valor =>  $this->hoy),
        array( campo => 'msesion', valor => $this->sesion)
    );
    
    $this->bd->pideSq(0);
    $this->bd->JqueryInsertSQL('par_ciu',$InsertQuery); 
    
    
        
}
//------------------
function _asientos_contables( $idprov,$secuencial  ){
	   
   
    
    $hoy = date("Y-m-d");
    $cadenaFecha = "to_date('".$hoy."','yyyy/mm/dd')";
    
 
     $mes  			= date("m"); 
     $anio  		= date("Y"); 
     
   
     //------------ seleccion de periodo
     $periodo_s = $this->bd->query_array('co_periodo',
                                        'id_periodo',
                                        'registro ='.$this->bd->sqlvalue_inyeccion($this->ruc ,true).' and
                                         anio='.$this->bd->sqlvalue_inyeccion($anio ,true).' and
                                         mes='.$this->bd->sqlvalue_inyeccion($mes ,true)
         );
     
     
     $id_periodo  = $periodo_s["id_periodo"];
     $cuenta      = '';
     $estado      = 'digitado';
   
     $detalle      = 'Adquisicion de compras ';
     $comprobante    = '-';
     
 
     //------------------------------------------------------------
     $sql = "INSERT INTO co_asiento(	fecha, registro, anio, mes, detalle, sesion, creacion,modulo,
                						comprobante, estado, tipo, documento,idprov,cuentag,estado_pago,
                                        id_periodo)
										        VALUES (".$cadenaFecha.",".
										        $this->bd->sqlvalue_inyeccion($this->ruc, true).",".
										        $this->bd->sqlvalue_inyeccion($anio, true).",".
										        $this->bd->sqlvalue_inyeccion($mes, true).",".
										        $this->bd->sqlvalue_inyeccion($detalle, true).",".
										        $this->bd->sqlvalue_inyeccion($this->sesion, true).",".
										        $cadenaFecha.",".
										        $this->bd->sqlvalue_inyeccion('cxpagar', true).",".
										        $this->bd->sqlvalue_inyeccion($comprobante, true).",".
										        $this->bd->sqlvalue_inyeccion($estado, true).",".
										        $this->bd->sqlvalue_inyeccion('F', true).",".
										        $this->bd->sqlvalue_inyeccion(trim($secuencial), true).",".
										        $this->bd->sqlvalue_inyeccion(trim($idprov), true).",".
										        $this->bd->sqlvalue_inyeccion('-', true).",".
										        $this->bd->sqlvalue_inyeccion( 'N', true).",".
										        $this->bd->sqlvalue_inyeccion($id_periodo, true).")";
										        
										        
										        $this->bd->ejecutar($sql);
										        
										        $idAsiento =  $this->bd->ultima_secuencia('co_asiento');
	 	
										        
		 return $idAsiento;
	}
//---------------------------------------	
	
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;

 

//------ grud de datos insercion
if (isset($_GET["archivo"]))	{
	
 
	$archivo 				=     $_GET["archivo"];
	
 
	$gestion->archivo_xml( $archivo );
 
	
}



?>
 
  
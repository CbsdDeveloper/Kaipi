<?php
session_start( );
require '../../kconfig/Db.class.php';
require '../../kconfig/Obj.conf.php';

include('phpqrcode/qrlib.php');


class ReportePdf{

	public $obj ;
	public $bd ;
	public $ruc;
	public $Registro;
	
	public $total_dato;
	
	public $sesion;
	public $login;

	//Constructor de la clase
	function ReportePdf(){

		//inicializamos la clase para conectarnos a la bd
		$this->obj     = 	new objects;
		$this->bd     = 	new Db;
	
		$this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

		$this->ruc       =  $_SESSION['ruc_registro'];
		
		$this->login 	 = $_SESSION['login'] ;
		
		
		$this->sesion 	 =  trim($_SESSION['email']);
	}
 
	//------------------------------------
	function Cabecera($codigo){
		
		//--- beneficiario
	    $sql = "SELECT id_movimiento, fecha, registro, detalle, sesion, creacion, comprobante, estado, tipo, id_periodo, documento, 					
                      idprov, id_asiento_ref,sesion, proveedor, razon, direccion, telefono, correo, contacto, fechaa, anio, mes, transaccion
	  			FROM  view_inv_movimiento
					where  id_movimiento= ".$this->bd->sqlvalue_inyeccion($codigo ,true);
	    
	    $resultado_cab = $this->bd->ejecutar($sql);
	    
	    $datos = $this->bd->obtener_array( $resultado_cab); 
		 
		return $datos;
	}
	//---------------------
	function Memorando($codigo){
		
		    //--- beneficiario
		    $sql = "SELECT *
                    FROM presupuesto.view_pre_tramite
                 where id_tramite = ".$this->bd->sqlvalue_inyeccion($codigo,true);

 	    
		    $resultado_cab = $this->bd->ejecutar($sql);
		    
		    $datos = $this->bd->obtener_array( $resultado_cab);
		
		
		$A = $this->bd->query_array('par_ciu','razon', 'idprov='.$this->bd->sqlvalue_inyeccion(trim($datos['idprov']),true)); 

		$datos['razon'] = $A['razon'] ;
		 
		///-------------------------------------------
		$a10 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(10,true));
		$a11 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(11,true));
		$a12 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(12,true));
		$a13 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(13,true));
		$a14 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(14,true));
		$a15 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(15,true));
		
		$datos["p10"] = $a10["carpeta"];
		$datos["p11"] = $a10["carpetasub"];
		$datos["g10"] = $a11["carpeta"];
		$datos["g11"] = $a11["carpetasub"];
		
		$datos["f10"] = $a12["carpeta"];
		$datos["f11"] = $a12["carpetasub"];
		
		$datos["t10"] = $a13["carpeta"];
		$datos["t11"] = $a13["carpetasub"];
		
		$datos["c10"] = $a14["carpeta"];
		$datos["c11"] = $a14["carpetasub"];
		$datos["e10"] = $a15["carpeta"];
		$datos["e11"] = $a15["carpetasub"];
			
		 
		$usuarios = $this->bd->__user($this->sesion);
		
		$datos['elaborado'] = ucwords(strtolower($usuarios['completo']));  
		
		return $datos;
	}
	//---------
	function Cotizacion_contrato($codigo){
	    
	    //--- beneficiario
	    $sql = "SELECT   id_cotizacion, fecha, fechac, idprov, razon, estado, cabecera, detalle,   fecham,documento
                FROM ven_cotizacion
                where id_cotizacion = ".$this->bd->sqlvalue_inyeccion($codigo,true);
	    
	    $resultado_cab = $this->bd->ejecutar($sql);
	    
	    $datos = $this->bd->obtener_array( $resultado_cab);
	    
	    
	    return $datos;
	}
//-----
	function cliente_contrato($codigo){
	    
	    //--- beneficiario
	    $sql = "SELECT   direccion, telefono, correo, movil, ctelefono
                FROM par_ciu
                where idprov = ".$this->bd->sqlvalue_inyeccion($codigo,true);
	    
	    $resultado_cab = $this->bd->ejecutar($sql);
	    
	    $datos = $this->bd->obtener_array( $resultado_cab);
	    
	    
	    return $datos;
	}
	
 
	//------------------
	function CabReportes($codigo){
	    
	    //--- beneficiario
	    $sql = "SELECT id_reforma, fecha, registro, anio, mes, detalle, sesion, creacion,
                     comprobante, estado, tipo, tipo_reforma, documento, id_departamento, unidad
                  FROM presupuesto.view_reforma
                where id_reforma = ".$this->bd->sqlvalue_inyeccion($codigo ,true);
	    
	    $resultado_cab = $this->bd->ejecutar($sql);
	    
	    $datos = $this->bd->obtener_array( $resultado_cab);
	    
	    $a10 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(10,true));
	    $a11 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(11,true));
	    $a12 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(12,true));
	    $a13 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(13,true));
	    $a14 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(14,true));
	    $a15 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(15,true));
	    
	    $datos["p10"] = $a10["carpeta"];
	    $datos["p11"] = $a10["carpetasub"];
	    $datos["g10"] = $a11["carpeta"];
	    $datos["g11"] = $a11["carpetasub"];
	    
	    $datos["f10"] = $a12["carpeta"];
	    $datos["f11"] = $a12["carpetasub"];
	    
	    $datos["t10"] = $a13["carpeta"];
	    $datos["t11"] = $a13["carpetasub"];
	    
	    $datos["c10"] = $a14["carpeta"];
	    $datos["c11"] = $a14["carpetasub"];
	    $datos["e10"] = $a15["carpeta"];
	    $datos["e11"] = $a15["carpetasub"];
	    
	    
	    $usuarios = $this->bd->__user($this->sesion);
	    
	    $datos['elaborado'] = ucwords(strtolower($usuarios['completo']));  
	    
	    
	    return $datos;
	}
	//---------------------
	function GrillaReforma($id){
	    
	    
	    
	    
	    $sql = 'SELECT id_reforma_det, partida, tipo, saldo, aumento, disminuye, id_reforma, detalle, clasificador, fuente,
                    actividad, funcion, titulo, grupo, subgrupo, item, subitem, disponible, anio
                    FROM presupuesto.view_reforma_detalle
                     where id_reforma= '.$this->bd->sqlvalue_inyeccion($id,true) .' order by partida, clasificador' ;
	    
	    
	    
	    echo ' <table id="table_detalle" class="table table-bordered" cellspacing="0" width="100%" style="font-size: 9px"  >
			<thead>
			 <tr>
				<th width="20%">Partida</th>
				<th width="10%">Item</th>
				<th width="20%">Detalle Item</th>
                <th width="10%">Fuente</th>
                <th width="10%">Saldo</th>
                <th width="10%">Aumento</th>
                <th width="10%">Disminucion</th>
 				</tr>
			</thead>';
	    
	    
	    $stmt1           = $this->bd->ejecutar($sql);
	    
	    $i = 1;
	    
	    $debe =0;
	    $haber =0;
	    
	    while ($y=$this->bd->obtener_fila($stmt1)){
	        
	        
	        $detalle =   trim($y['detalle']) ;
	        
	        
	        
	        echo ' <tr>
		    	<td>'.$y['partida'].'</td>
				<td>'.$y['clasificador'].'</td>
                <td>'.$detalle.'</td>
                <td>'.$y['fuente'].'</td>
                <td align="right">'.$y['saldo'].'</td>
  				<td align="right">'.$y['aumento'].'</td>
                <td align="right">'.$y['disminuye'].'</td>
           </tr>';
	        
	        $i++;
	        
	        $debe = $debe +  $y['aumento'] ;
	        $haber = $haber + $y['disminuye'];
	        
	    }
	    
	    echo ' <tr>
		    	<td> </td>
				<td> </td>
                <td> </td>
                <td> </td>
                <td align="right">Resumen </td>
  				<td align="right">'.number_format($debe,2).'</td>
                <td align="right">'.number_format($haber,2).'</td>
           </tr>';
	    
	    echo	'</table>';
	    
	    
	    
	}
 
	//------------------------
	function fecha_plazo($fecha){
		
	    $dia= $this->conocerDiaSemanaFecha($fecha);
	    
	    $num = date("j", strtotime($fecha));
	    
	    $anno = date("Y", strtotime($fecha));
	    
	    $mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
	 
	    $mes = $mes[(date('m', strtotime($fecha))*1)-1];
	    
	    return   $num.' dia(s) del dia '.$dia.' del mes de '.$mes.' del '.$anno;
	    
	    
 
 
	}	
	//-------------
	function conocerDiaSemanaFecha($fecha) {
	    $dias = array('Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado');
	    $dia = $dias[date('w', strtotime($fecha))];
	    return $dia;
	}
	
	//---------------

	function firma_reportes($codigo_reporte){
	

		$reporte_pie   = $this->bd->query_array('par_reporte', 'pie', 'referencia='.$this->bd->sqlvalue_inyeccion( trim($codigo_reporte) ,true) );
	
	$pie_contenido = $reporte_pie["pie"];

	// NOMBRE / CARGO
	$a10 = $this->bd->query_array('wk_config','carpeta , carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(10,true));
	$pie_contenido = str_replace('#AUTORIDAD',trim($a10['carpeta']), $pie_contenido);
 	$pie_contenido = str_replace('#CARGO_AUTORIDAD',trim($a10['carpetasub']), $pie_contenido);
	
 	$a10 = $this->bd->query_array('wk_config','carpeta , carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(12,true));
	$pie_contenido = str_replace('#FINANCIERO',trim($a10['carpeta']), $pie_contenido);
 	$pie_contenido = str_replace('#CARGO_FINANCIERO',trim($a10['carpetasub']), $pie_contenido);

	 $a10 = $this->bd->query_array('wk_config','carpeta , carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(14,true));
	 $pie_contenido = str_replace('#CONTADOR',trim($a10['carpeta']), $pie_contenido);
	 $pie_contenido = str_replace('#CARGO_CONTADOR',trim($a10['carpetasub']), $pie_contenido);

	 $a10 = $this->bd->query_array('wk_config','carpeta , carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(13,true));
	 $pie_contenido = str_replace('#TESORERO',trim($a10['carpeta']), $pie_contenido);
	 $pie_contenido = str_replace('#CARGO_TESORERO',trim($a10['carpetasub']), $pie_contenido);

	 $a10 = $this->bd->query_array('wk_config','carpeta , carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(15,true));
	 $pie_contenido = str_replace('#PRESUPUESTO',trim($a10['carpeta']), $pie_contenido);
	 $pie_contenido = str_replace('#CARGO_PRESUPUESTO',trim($a10['carpetasub']), $pie_contenido);
		
		//------------- llama a la tabla de parametros ---------------------//

		$usuarios = $this->bd->__user($this->sesion); // nombre del usuario actual

		$sesion   = ucwords(strtolower($usuarios['completo']));  
  
 
		$pie_contenido = str_replace('#SESION',$sesion, $pie_contenido);
	    
		echo $pie_contenido ;


		
		
	}
	//----------------------------------
	function pie_cliente($cliente){
	    
	  $x= $this->bd->query_array('par_usuario',
	                                         'completo', 
	        'login='.$this->bd->sqlvalue_inyeccion(trim($this->sesion) ,true)
	        );
	  
	    
	  echo ' <p class="page" style="font-size: 9px;color: #363636">Documento digital  '.$x['completo'].' <br> </p>';
	    
	}
	//--- resumen IR
	function GrillaCertificacion($id){
	    
	    
	    $sql = 'SELECT partida, actividad,fuente,clasificador,detalle, sum(iva) as iva, sum(base) as base, 
                       sum(certificado) as certificado ,dactividad,dfuente, programa,dprograma
                    FROM presupuesto.view_certificacionesd
                    where id_tramite= '.$this->bd->sqlvalue_inyeccion($id,true) .'
                    group by partida,actividad,fuente,clasificador,detalle,dactividad,dfuente, programa,dprograma  ' ;
 
 	       echo ' <table id="table_detalle"  class="lado" cellspacing="0" width="100%" style="font-size: 9px"  >
			<thead>
			 <tr>
				<th class="lado" width="25%">Actividad</th>
				<th class="lado" width="15%">Item</th>
				<th class="lado" width="40%">Detalle Item</th>
                <th class="lado" width="10%">Fuente</th>
                <th class="lado" width="10%">Monto</th>
 				</tr>
			</thead>';
	       
	     
	       $stmt1           = $this->bd->ejecutar($sql);
 	       $certificado     = 0;
	       $iva             = 0;           
	       $total           = 0;
	       $i = 1;
	       
	       while ($y=$this->bd->obtener_fila($stmt1)){
	            
	        
	           $certificado     = $certificado + $y['certificado'];
	           $iva             = $iva + $y['iva'];
	           $total           = $total + $y['base'];
	           
               $detalle =   trim($y['detalle']) ;
	           
 
               
	           echo ' <tr>
		    	<td class="lado" >'.$y['dprograma'].'</td>
				<td class="lado" >'.$y['partida'].'</td>
                <td class="lado" >'.$detalle.'</td>
                <td class="lado" >'.$y['dfuente'].'</td>
  				<td class="lado" align="right">'.$y['certificado'].'</td>
           </tr>';
	           
	           $i++;
	           
 	       }
	 
	          
	       echo ' <tr>
				<td class="lado"  colspan="3" bordercolor="#FFFFFF"></td>
				<td align="right">TOTAL</td>
                <td align="right">'.number_format($certificado,2).'</td>
                  </tr>';
	       
 
	       echo	'</table>';
      
	       $this->total_dato = $certificado;
	    
	}
///--------------------------
function GrillaCompromiso($id){
	    
	    
 
   
 
	       $sql = 'SELECT partida,actividad,fuente,clasificador,detalle, sum(iva) as iva, sum(base) as base,
                       sum(compromiso) as compromiso ,dactividad,dfuente, programa,dprograma
                    FROM presupuesto.view_certificacionesd
                    where id_tramite= '.$this->bd->sqlvalue_inyeccion($id,true) .'
                    group by partida,actividad,fuente,clasificador,detalle,dactividad,dfuente, programa,dprograma  ' ;
	       
	       
	       echo ' <table id="table_detalle" class="lado" cellspacing="0" width="100%" style="font-size: 9px"  >
			<thead>
			 <tr>
				<th class="lado" width="25%">Actividad</th>
				<th class="lado" width="15%">Item</th>
				<th class="lado" width="40%">Detalle Item</th>
                <th class="lado" width="10%">Fuente</th>
                <th class="lado" width="10%">Monto</th>
 				</tr>
			</thead>';
	       
	     
	       $stmt1           = $this->bd->ejecutar($sql);
 	       $compromiso     = 0;
	       $iva             = 0;           
	       $total           = 0;
	       $i = 1;
	       
	       while ($y=$this->bd->obtener_fila($stmt1)){
	            
	        
	       
	           $iva             = $iva + $y['iva'];
	           $total           = $total + $y['base'];
	           
               $detalle =   trim($y['detalle']) ;
	           
 
               
	           echo ' <tr>
		    	<td class="lado" >'.$y['dprograma'].'</td>
				<td class="lado" >'.$y['partida'].'</td>
                <td class="lado" >'.$detalle.'</td>
                <td class="lado" >'.$y['dfuente'].'</td>
  				<td class="lado" align="right">'.$y['compromiso'].'</td>
           </tr>';
	           
	           $i++;
	           
	           $compromiso     = $compromiso + $y['compromiso'];
	           
 	       }
 
	      
	       
	       echo ' <tr>
				<td colspan="3" bordercolor="#FFFFFF"></td>
				<td align="right">TOTAL</td>
                <td align="right">'.number_format($compromiso,2).'</td>
                  </tr>';
	       
 
	       echo	'</table>';
      
	       $this->total_dato = $compromiso;
	    
	}	  
//------------------------------------------------------------------
	function xcrud($id,$tipo_documento){
        
        $sql = 'SELECT   tipo,fecha_caducidad,quedan_dias,cumple,sesionm,fecha_modifica,id_index_doc
                FROM doc.view_gestion_doc1
                where identificacion = '.$this->bd->sqlvalue_inyeccion($id,true).' and 
                      tipo_documento=    '.$this->bd->sqlvalue_inyeccion($tipo_documento,true).'
                order by tipo'  ;
        
        
        
        echo ' <table id="table_detalle" class="table table-bordered" cellspacing="0" width="100%" style="font-size: 9px"  >
			<thead>
			 <tr>
				<th width="25%">Documento</th>
				<th width="20%">Vigencia</th>
				<th width="20%">Faltan (Dias)</th>
				<th width="10%">Cumple</th>
                <th width="20%">Validado</th>
 				</tr>
			</thead>';
        
        
        $stmt1 = $this->bd->ejecutar($sql);
        
        while ($y=$this->bd->obtener_fila($stmt1)){
            
            
                
            
            if (trim($y['cumple']) == 'N'){
                $imagen = '<img src="../../kimages/alert.png">';
            }else{
                $imagen = '<img src="../../kimages/okk.png">';
            }
          
                 
            if ($y['quedan_dias'] <= 5){
                $color = ' bgcolor=#ec0000 style="color: #FFFFFF"';
            }
            
            if (($y['quedan_dias'] >  5 ) && ($y['quedan_dias'] <= 30 ) ){
                $color = ' bgcolor=#F9FF3B ';
            }
            
            if (($y['quedan_dias'] >  30 ) && ($y['quedan_dias'] <= 45 ) ){
                $color = ' bgcolor=#ff7300 ';
            }
            
            if (($y['quedan_dias'] >  45 ) && ($y['quedan_dias'] <= 60 ) ){
                $color = ' bgcolor=#9DF87D ';
            }
            
            if (($y['quedan_dias'] >  60 ) && ($y['quedan_dias'] <= 3500 ) ){
                $color = ' bgcolor=#fffcfc ';
            }
   
            
            
            echo ' <tr>
				<td  >'.utf8_encode($y['tipo']).'</td>
				<td align="center"  >'.$y['fecha_caducidad'].'</td>
 				<td align="center" '.$color.' >'.$y['quedan_dias'].'</td>
				<td '.$color.' align="center">'.$imagen.'</td>
                <td>'.$y['sesionm'].'</td>
                  </tr>';
        }
        
       
        echo	'</table>';
		
 
    }
	//--- resumen IR
 
	//---
	function Empresa( ){
		
		$sql = "SELECT ruc_registro, razon, contacto, correo, web, direccion, telefono, email, ciudad, estado, url, mision, vision
				FROM view_registro
				where ruc_registro =".$this->bd->sqlvalue_inyeccion(	$this->ruc, true);

		$resultado = $this->bd->ejecutar($sql);

		$this->Registro = $this->bd->obtener_array( $resultado);

		return $this->Registro['razon'];
	}
	//-----------------
	function _Cab( $dato ){
	      
	    return $this->Registro[$dato];
	}
	//-------------------------
	function _total(  ){
	    
	    return $this->total_dato;
	}
	
	
	
 
//--------------------------------------------------------
	function QR_Documento(){
	    
	//    $content = $_SESSION['ruc_registro'];
	    $name    = $_SESSION['razon'] ;
	    $elaborador = $_SESSION['login'];
	  //  $sesion     = $_SESSION['email'];
	    
		$time = time();
 		$fecha =  date("d-m-Y (H:i:s)", $time);
		
	    // we building raw data
	    $codeContents .= $name."\n";
		$codeContents .= $fecha."\n";
		$codeContents .= 'Elaborado '.$elaborador."\n"."\n";
		$codeContents .= 'ControlDocumento'."\n";
	   
	   
	    
	    $filepath = 'documento.png';
	    
	    QRcode::png($codeContents,$filepath , QR_ECLEVEL_H, 20);
	    
	    // Start DRAWING LOGO IN QRCODE
	    
	    $logopath = 'logo_qr.png';
	    $QR = imagecreatefrompng($filepath);
	    
	    // START TO DRAW THE IMAGE ON THE QR CODE
	    $logo = imagecreatefromstring(file_get_contents($logopath));
	    
	    /**
	     *  Fix for the transparent background
	     */
	    imagecolortransparent($logo , imagecolorallocatealpha($logo , 0, 0, 0, 127));
	    imagealphablending($logo , false);
	    imagesavealpha($logo , true);
	    
	    $QR_width = imagesx($QR);
	    $QR_height = imagesy($QR);
 	    $logo_width = imagesx($logo);
	    $logo_height = imagesy($logo);
	    
	    // Scale logo to fit in the QR Code
	    $logo_qr_width = $QR_width/3;
	    $scale = $logo_width/$logo_qr_width;
	    $logo_qr_height = $logo_height/$scale;
	    
	    imagecopyresampled($QR, $logo, $QR_width/3, $QR_height/3, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);
	    
	    // Save QR code again, but with logo on it
	    imagepng($QR,$filepath);
 	    
	}
//-------------------
	function QR_DocumentoDoc($codigo ){
	    
	    
	    $name       = $_SESSION['razon'] ;
	    $sesion     = trim($_SESSION['email']);
	    
	    $datos = $this->bd->query_array('par_usuario',
	        'completo',
	        'email='.$this->bd->sqlvalue_inyeccion($sesion,true)
	        );
	    
	    $nombre     =  $datos['completo'];
	    $year       = date('Y');
	    $codigo     = str_pad($codigo,5,"0",STR_PAD_LEFT ).'-'.$year;
	    $elaborador = base64_encode($codigo);
	    
	    $hoy = date("Y-m-d H:i:s");
	    
	    // we building raw data
	    $codeContents .= 'GENERADO POR:'.$nombre."\n";
	    $codeContents .= 'FECHA: '.$hoy."\n";
	    $codeContents .= 'DOCUMENTO: '.$elaborador."\n";
	    $codeContents .= 'INSTITUCION :'.$name."\n";
	    $codeContents .= '2.4.0'."\n";
	    
	    $tempDir = EXAMPLE_TMP_SERVERPATH;
	    
	    QRcode::png($codeContents,  'logo_qr.png', QR_ECLEVEL_L, 3);
	}
	
	//----------------------------------------------
	function QR_Firma( ){
	    
	    
	    $datos = $this->bd->query_array('par_usuario',
	        'completo',
	        'email='.$this->bd->sqlvalue_inyeccion(trim($_SESSION['email']),true)
	        );
	    
	    $sesion_elabora =  trim($datos['completo']);
	    
	    echo 'Documento Digital '.$_SESSION['login'].'- '. $sesion_elabora ;
	    
	}
	
	
}

?>
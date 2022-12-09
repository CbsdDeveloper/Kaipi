<?php
session_start( );
require '../../kconfig/Db.class.php';
require '../../kconfig/Obj.conf.php';

class ReportePdf{

	public $obj ;
	public $bd ;
	public $ruc;
	public $Registro;
	
	public $total_dato;
	
	public $sesion;

	//Constructor de la clase
	function ReportePdf(){
		//inicializamos la clase para conectarnos a la bd
		$this->obj     = 	new objects;
		$this->bd     = 	new Db;
	
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

		$this->ruc       =  $_SESSION['ruc_registro'];
		
		$this->sesion 	 = $_SESSION['login'] ;
		
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
	function Acta_entrega($codigo){
		
		    //--- beneficiario
		    $sql = "SELECT id_acta, clase_documento, documento, fecha, estado, detalle, resolucion, creacion, 
		                   sesion, modificacion, sesionm, idprov, razon, telefono, correo, unidad,idprov_entrega,cargo
                    FROM activo.view_acta
                   where id_acta = ".$this->bd->sqlvalue_inyeccion($codigo,true);
 	    
		    $resultado_cab = $this->bd->ejecutar($sql);
		    
		    $datos = $this->bd->obtener_array( $resultado_cab);
 		
 
 		 
		    $datos['fecha_completa'] =  $this->bd->_fecha_completa_acta($datos['fecha']);
		
		    $datos_parametro = $this->Funcionario(trim($datos['idprov_entrega']));
		    
		    $datos['funcionario_entrega']  =   $datos_parametro['nombre'] ;
		    $datos['cargo_entrega']        =   $datos_parametro['cargo'] ;
		    $datos['idprov_entrega']        =   $datos_parametro['idprov'] ;
		 
		return $datos;
	}
	//---------
	function Funcionario($idprov_entrega){
	    
	    
	    //--- beneficiario Acta de Entrega - Recepcion
	    
	    if ( $idprov_entrega == '-'){
	        
	        $sql = "SELECT  carpeta as nombre,carpetasub as cargo, modulo as idprov
                FROM wk_config
                where tipo = ".$this->bd->sqlvalue_inyeccion(16,true);
	        
	    }else{
	        
	        $sql = "SELECT  razon as nombre,  cargo, idprov
                FROM view_nomina_rol
                where idprov = ".$this->bd->sqlvalue_inyeccion(trim($idprov_entrega),true);
	        
	    }
 
	 
	    $resultado_cab = $this->bd->ejecutar($sql);
	    
	    $datos = $this->bd->obtener_array( $resultado_cab);
 	    
	    
	    
	    return $datos;
	}
//-----
	function cedula_presupuestaria_detalle($anio,$tipo ){
	    
	    //--- beneficiario
	    $sql ="SELECT  partida  ,
              detalle,
             inicial,  codificado, certificado, compromiso, devengado, pagado, disponible
        FROM presupuesto.pre_gestion
        where tipo = ".$this->bd->sqlvalue_inyeccion($tipo,true) ." and 
              anio=".$this->bd->sqlvalue_inyeccion($anio,true) ." 
        order by partida" ;
	    
 
	    
	    echo ' <table  class="table table-striped table-bordered table-hover table-checkable datatable" border="0" width="100%" style="font-size: 10px"  >
			<thead>
			 <tr>
				<th width="12%">Partida</th>
				<th width="32%">Detalle</th>
				<th align="right" width="8%">Inicial</th>
                <th align="right"  width="8%">Codificado</th>
                <th align="right"  width="8%">Certificado</th>
                <th align="right"  width="8%">Compromiso</th>
				<th align="right"  width="8%">Devengado</th>
				<th align="right"  width="8%">Pagado</th>
                <th align="right"  width="8%">Disponible</th>
 				</tr>
			</thead>';
	    
	    
	    $stmt1           = $this->bd->ejecutar($sql);
	    $a1     = 0;
	    $a2     = 0;
	    $a3     = 0;
	    $a4     = 0;
	    $a5     = 0;
	    $a6     = 0;
	    $a7     = 0;
	    $i = 1;
	    
	    while ($y=$this->bd->obtener_fila($stmt1)){
	        
	        $a1     = $a1 + $y['inicial'];
	        $a2     = $a2 + $y['codificado'];
	        $a3     = $a3 + $y['certificado'];
	        $a4     = $a4 + $y['compromiso'];
	        $a5     = $a5 + $y['devengado'];
	        $a6     = $a6 + $y['pagado'];
	        $a7     = $a7 + $y['disponible'];
 
	        $detalle =   trim($y['detalle']) ;
	        
	        
	        
	        echo ' <tr>
		    	<td>'.$y['partida'].'</td>
                <td>'.$detalle.'</td>
               	<td align="right">'.$y['inicial'].'</td>
  				<td align="right">'.$y['codificado'].'</td>
                <td align="right">'.$y['certificado'].'</td>
                <td align="right">'.$y['compromiso'].'</td>
                <td align="right">'.$y['devengado'].'</td>
                <td align="right">'.$y['pagado'].'</td>
                <td align="right">'.$y['disponible'].'</td>
           </tr>';
	        
	        $i++;
	        
	    }
	    
	    
	    
	    
	    
	    echo ' <tr>
				<td align="right"></td>
				<td align="right">TOTAL</td>
                <td align="right">'.number_format($a1,2).'</td>
                <td align="right">'.number_format($a2,2).'</td>
                <td align="right">'.number_format($a3,2).'</td>
                <td align="right">'.number_format($a4,2).'</td>
                <td align="right">'.number_format($a5,2).'</td>
                <td align="right">'.number_format($a6,2).'</td>
                <td align="right">'.number_format($a7,2).'</td>
                </tr>';
	    
	    
	    echo	'</table>'; 
	    
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
	    
	    return $datos;
	}
	//---------------------
	function GrillaReforma($id){
	    
	    
	    
	    
	    $sql = 'SELECT id_reforma_det, partida, tipo, saldo, aumento, disminuye, id_reforma, detalle, clasificador, fuente,
                    actividad, funcion, titulo, grupo, subgrupo, item, subitem, disponible, anio
                    FROM presupuesto.view_reforma_detalle
                     where id_reforma= '.$this->bd->sqlvalue_inyeccion($id,true)  ;
	    
	    
	    
	    echo ' <table id="table_detalle" class="table table-bordered" cellspacing="0" width="100%" style="font-size: 9px"  >
			<thead>
			 <tr>
				<th width="10%">Actividad</th>
				<th width="10%">Item</th>
				<th width="30%">Detalle Item</th>
                <th width="10%">Fuente</th>
                <th width="10%">Saldo</th>
                <th width="10%">Aumento</th>
                <th width="10%">Disminucion</th>
 				</tr>
			</thead>';
	    
	    
	    $stmt1           = $this->bd->ejecutar($sql);
	    
	    $i = 1;
	    
	    while ($y=$this->bd->obtener_fila($stmt1)){
	        
	        
	        $detalle =   trim($y['detalle']) ;
	        
	        
	        
	        echo ' <tr>
		    	<td>'.$y['actividad'].'</td>
				<td>'.$y['clasificador'].'</td>
                <td>'.$detalle.'</td>
                <td>'.$y['fuente'].'</td>
                <td align="right">'.$y['saldo'].'</td>
  				<td align="right">'.$y['aumento'].'</td>
                <td align="right">'.$y['disminuye'].'</td>
           </tr>';
	        
	        $i++;
	        
	    }
	    
	    
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
	    $dias = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');
	    $dia = $dias[date('w', strtotime($fecha))];
	    return $dia;
	}
	//----------------------------------
	function pie_cliente($cliente){
	    
    $Auser = $this->bd->query_array('par_usuario',
	                                 'completo', 
	        'login='.$this->bd->sqlvalue_inyeccion(trim($this->sesion) ,true)
	        );
	       
   
	    
	  echo '<table width="100%" border="0">
                <tr>
                  <td width="30%"><p class="page" style="font-size: 10px;color: #363636"></p></td>
                  <td width="70%" align="right" style="font-size: 10px;color: #363636"> Documento digital generado: '.$Auser['completo'].'</td>
                </tr>
            </table>';
	    
	}
	//--- resumen IR
	function GrillaBienes($id){
 
  
	       $sql = 'SELECT estado, id_acta_det,  id_bien, sesion, creacion, marca, tipo, tipo_bien, 
	                      descripcion, serie, estado_bien, costo_adquisicion, clasificador, clase
                    FROM activo.view_acta_detalle
                    where id_acta= '.$this->bd->sqlvalue_inyeccion($id,true)  ;

	       
 
	       
	       echo ' <table id="table_detalle"  class="lado" cellspacing="0" width="90%" style="font-size: 9px"  >
			<thead>
			 <tr>
	           <th class="lado" width="5%">Nro.</th>
				<th class="lado" width="15%">Clase</th>
				<th class="lado" width="10%">Item</th>
				<th class="lado" width="40%">Detalle Item</th>
                <th class="lado" width="10%">Marca</th>
                <th class="lado" width="10%">Estado</th>
 				</tr>
			</thead>';
	       
	     
	       $stmt1           = $this->bd->ejecutar($sql);
 	     
	       $i = 1;
	       
	       while ($y=$this->bd->obtener_fila($stmt1)){
	            
 
	           
               $detalle =   trim($y['descripcion']) ;
	           
 
               
	           echo ' <tr>
                <td class="lado" >'.$i.'</td>
		    	<td class="lado" >'.$y['clase'].'</td>
				<td class="lado" >'.trim($y['clasificador']).'</td>
                <td class="lado" >'.trim($detalle).'</td>
                <td class="lado" >'.$y['marca'].'</td>
  				<td class="lado" >'.$y['estado_bien'].'</td>
           </tr>';
	           
	           $i++;
	           
 	       }
 
	      
	  
 
	       echo	'</table>';
      
	    
	    
	}
///--------------------------
function GrillaCompromiso($id){
	    
	    
 
  
	       $sql = 'SELECT actividad,fuente,clasificador,detalle, iva, base, certificado,dactividad,dfuente,compromiso
                    FROM presupuesto.view_certificacionesd
                    where id_tramite= '.$this->bd->sqlvalue_inyeccion($id,true)  ;

 
	       
	       echo ' <table id="table_detalle" class="lado" cellspacing="0" width="90%" style="font-size: 9px"  >
			<thead>
			 <tr>
				<th class="lado" width="20%">Actividad</th>
				<th class="lado" width="15%">Item</th>
				<th class="lado" width="20%">Detalle Item</th>
                <th class="lado" width="15%">Fuente</th>
                <th class="lado" width="20%">Monto</th>
 				</tr>
			</thead>';
	       
	     
	       $stmt1           = $this->bd->ejecutar($sql);
 	       $compromiso     = 0;
	       $iva             = 0;           
	       $total           = 0;
	       $i = 1;
	       
	       while ($y=$this->bd->obtener_fila($stmt1)){
	            
	        
	           $compromiso      = $compromiso + $y['compromiso'];
	           $iva             = $iva + $y['iva'];
	           $total           = $total + $y['base'];
	           
               $detalle =   trim($y['detalle']) ;
	           
 
               
	           echo ' <tr>
		    	<td class="lado" >'.$y['dactividad'].'</td>
				<td class="lado" >'.trim($y['clasificador']).'</td>
                <td class="lado" >'.trim($detalle).'</td>
                <td class="lado" >'.$y['dfuente'].'</td>
  				<td class="lado" align="right">'.$y['compromiso'].'</td>
           </tr>';
	           
	           $i++;
	           
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
	    
	    $content = $_SESSION['ruc_registro'];
	    $name    = $_SESSION['razon'] ;
	    $elaborador = $_SESSION['login'];
	    $sesion     = $_SESSION['email'];
	    
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
	
}

?>
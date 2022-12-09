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
    
    
    
    //Constructor de la clase
    function ReportePdf(){
        //inicializamos la clase para conectarnos a la bd
        $this->obj     = 	new objects;
        $this->bd     = 	new Db;
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        
        $this->sesion 	 = $_SESSION['login'] ;
        
    }
    
	//-------------------------- 
	  function _carpeta(){
		  
		  $url =  $this->bd->_carpeta_archivo(4,1);  
		  
		  return   $url;
		  
	 }	  
		//-------------------------- 
	  function _actualiza_clave($cert_password,$email1){
		  
		 	$sql = 'UPDATE par_usuario 
            SET  acceso1='.$this->bd->sqlvalue_inyeccion(base64_encode($cert_password), true).' 
             WHERE email='. $this->bd->sqlvalue_inyeccion(trim($email1), true);
 	
			            				
			$this->bd->ejecutar($sql);
		  
		  return 1;
 
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
        
        $datos['fecha_completa'] =  $this->bd->_fecha_completa($datos['fecha']);
        
        return $datos;
    }
    //---------------------
    function Documento_Proceso($caso,$process,$doc ){
        
        $ADocumento = $this->bd->query_array('flow.view_proceso_doc_editor',
            'idcasodoc, sesion, idproceso_docu, documento, asunto, tipodoc,  editor, fecha,anio,dia,mes,
								  	departamento_de, email_de, nombre_de, departamento_para, email_para, nombre_para',
            'idproceso      ='.$this->bd->sqlvalue_inyeccion($process,true). ' and
								   idcaso         ='.$this->bd->sqlvalue_inyeccion($caso,true). ' and
								   idproceso_docu ='.$this->bd->sqlvalue_inyeccion($doc,true)
            );
        
        
        return $ADocumento;
    }
    //----------------
    function Documento_Proceso_user($caso,$process,$doc ){
        
        $ADocumento = $this->bd->query_array('flow.view_proceso_doc_editor',
            								 'idcasodoc, sesion, idproceso_docu, documento, asunto, tipodoc,  editor, fecha,anio,dia,mes,
								  			 departamento_de, email_de, nombre_de, departamento_para, email_para, nombre_para',
            'idcasodoc      ='.$this->bd->sqlvalue_inyeccion($doc,true). ' and
								   idcaso         ='.$this->bd->sqlvalue_inyeccion($caso,true)
            );
		
		
		  $ADocumento = $this->bd->query_array('flow.view_proceso_doc_editor',
            								 'idcasodoc, sesion, idproceso_docu, documento, asunto, tipodoc,  editor, fecha,anio,dia,mes,
								  			 departamento_de, email_de, nombre_de, departamento_para, email_para, nombre_para',
            'idcasodoc      ='.$this->bd->sqlvalue_inyeccion($doc,true). ' and
								   idcaso         ='.$this->bd->sqlvalue_inyeccion($caso,true)
            );
		
		
        
     
        return $ADocumento;
    }
    //---------
       
    
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
    //-------------
    function conocer_mes($cmes) {
        
        $mes = $this->bd->_mesc($cmes);
        
        return $mes;
    }
    
    //----------------------------------
    function pie_cliente($cliente){
        
        $Auser = $this->bd->query_array('par_usuario',
            'completo',
            'login='.$this->bd->sqlvalue_inyeccion(trim($this->sesion) ,true)
            );
        
        $x = $this->bd->query_array('wk_config',
            'tipo, carpeta, modulo, carpetasub, formato, opcion, registro',
            'tipo='.$this->bd->sqlvalue_inyeccion(4,true)
            );
        
        
        $string =ucwords(strtolower($this->_Cab( 'ciudad' )));
        
        
        
        if (  $x['formato']  == '1' ){
            
            echo '<table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td colspan="2" align="center" style="font-size: 10px;color: #363636">'. $string.' - Ecuador <br> '.$this->_Cab( 'correo' ).'</td> </tr> <tr>
                  <td width="30%"><p class="page" style="font-size: 10px;color: #363636"> </p></td>
                  <td width="70%" align="right" style="font-size: 10px;color: #363636"> Documento digital generado: '.$Auser['completo'].'</td>
                </tr>
            </table>';
            
        }
        
        
        
    }
	//--------------------------------------
	 function pie_cliente_firma($cliente){
        
        $Auser = $this->bd->query_array('par_usuario',
            'completo',
            'login='.$this->bd->sqlvalue_inyeccion(trim($this->sesion) ,true)
            );
          
        
        
        $string =ucwords(strtolower($this->_Cab( 'ciudad' )));
        
        if ( $cliente == 1){
			$cadena = '  <span style="font-size:10px;color: #363636">Documento digital generado: '.$Auser['completo'].'</span>';
		}	
		 
	   if ( $cliente == 2){
			$cadena =  trim($string).' - Ecuador';
		}
        
         
        return  $cadena;
        
    }
    
	/*
	*/
	
		 function pie_cliente_firma_ec($cliente){
        
        $Auser = $this->bd->query_array('par_usuario',
            'completo',
            'login='.$this->bd->sqlvalue_inyeccion(trim($this->sesion) ,true)
            );
          
        
        
        $string =ucwords(strtolower($this->_Cab( 'ciudad' )));
        
        if ( $cliente == 1){
			$cadena = ' Documento digital generado: '.$Auser['completo'];
		}	
		 
	   if ( $cliente == 2){
			$cadena =  trim($string).' - Ecuador';
		}
        
         
        return  $cadena;
        
    }
     
    //---
    function Empresa( ){
        
        $sql = "SELECT ruc_registro, razon, contacto, correo, web, direccion, telefono, email, ciudad, estado, url, mision, vision
				FROM view_registro
				where ruc_registro =".$this->bd->sqlvalue_inyeccion(	$this->ruc, true);
        
        $resultado = $this->bd->ejecutar($sql);
        
        $this->Registro = $this->bd->obtener_array( $resultado);
		
		$ciudad = $this->Registro['ciudad'];
		
		$ciudad = 	trim($ciudad);
		$ciudad = 	strtolower($ciudad);
		$ciudad = 	ucwords($ciudad);
 
		 $this->Registro['ciudad'] = $ciudad ;
        
        return $this->Registro['razon'];
    }
    //-----------------
    function UserFirma( ){
        
        $sesion 	 =  trim($_SESSION['email']);
        
        $sql = "SELECT  idusuario, login  direccion,   completo,   smtp1, puerto1, acceso1, id_departamento
				FROM par_usuario
				where email =".$this->bd->sqlvalue_inyeccion(	$sesion, true);
        
        $resultado = $this->bd->ejecutar($sql);
        
        $Registro   = $this->bd->obtener_array( $resultado);
         
        $smtp1      =  trim($Registro['smtp1']);
        
        $archivo    = explode('.', $smtp1);
        
        
        $xx = $this->bd->query_array('nom_departamento',    
            'nombre',                      
            'id_departamento='.$this->bd->sqlvalue_inyeccion($Registro['id_departamento'],true) 
            );
        
        
        
        $this->Registro['depa'] = trim($xx['nombre']);
		
		 $this->Registro['archivop12'] = trim($Registro['smtp1']);
        
        $this->Registro['archivo'] = trim($archivo[0]).'.pem';
        
        $this->Registro['login'] = trim($Registro['login']);
        
        $this->Registro['completo'] = trim($Registro['completo']);
        
        $this->Registro['acceso1'] = trim(base64_decode(trim($Registro['acceso1']))) ;
        
        $this->Registro['direccion'] = trim($Registro['direccion']);
        
       
        
        return $this->Registro['completo'];
       
            
    }
    
    
    function _Cab( $dato ){
        
        return $this->Registro[$dato];
    }
    //-------------------------
    function _total(  ){
        
        return $this->total_dato;
    }
    
    //--------------------------------------------------------
    //--------------------------------------------------------
    //--------------------------------------------------------
    function _Encabezado(  ){
        
        $x = $this->bd->query_array('wk_config',
            'tipo, carpeta, modulo, carpetasub, formato, opcion, registro',
            'tipo='.$this->bd->sqlvalue_inyeccion(4,true)
            );
        
        
        
        if (  $x['formato']  == '1' ){
            
            echo $this->_Encabezado_1();
            
        }
         
    }
	//------------
	    function _Encabezado_firma(  ){
        
        $x = $this->bd->query_array('wk_config',
            'tipo, carpeta, modulo, carpetasub, formato, opcion, registro',
            'tipo='.$this->bd->sqlvalue_inyeccion(4,true)
            );
        
        
        
        if (  $x['formato']  == '1' ){
            
            echo $this->_Encabezado_1_firma();
            
        }
         
    }
	
    ///-------------------------------------------------------------------------
    function _Encabezado_1(  $departamento_de, $memo ){
		
        $direccion = explode(" ",  $departamento_de );
		
		$dir1 =  ucwords(trim($direccion[0]));
 		
		$dir2 =  trim($direccion[1]).' '.trim($direccion[2]) .' '.trim($direccion[3]) .' '.trim($direccion[4]) ;
		
		$dir2 =  ucwords($dir2);		
 		
 
		$reporte_pie   = $this->bd->query_array('ven_plantilla', 'contenido', 'id_plantilla='.$this->bd->sqlvalue_inyeccion(6 ,true) );

			$pie_contenido = $reporte_pie["contenido"];

		 	$pie_contenido = str_replace('#DIRECCION1',trim($dir1), $pie_contenido);
		
			$pie_contenido = str_replace('#DIRECCION2',trim($dir2), $pie_contenido);
		
			$pie_contenido = str_replace('#MEMO',trim($memo), $pie_contenido);
 
	        
	        return $pie_contenido;
    }
	 ///-------------------------------------------------------------------------
    function _pie_documento( ){
 
 
			$reporte_pie   = $this->bd->query_array('ven_plantilla', 'contenido', 'id_plantilla='.$this->bd->sqlvalue_inyeccion(22 ,true) );

			$pie_contenido = $reporte_pie["contenido"];
   
	         $_SESSION['pie_contenido'] = $pie_contenido;
		
	        return $pie_contenido;
    }
	//----------------
	function _Encabezado_1_firma(  ){
		
 	/*   $cadena =  '<table width="100%" border="0">
	    <tbody>
	    <tr>
	    <td width="15%" align="left" valign="middle"><img src="../../kimages/'.trim($_SESSION['logo']).'"'.' ></td>
		<td width="5%" align="left" valign="middle">&nbsp;</td>
	    <td width="70%" valign="top"  align="left">'.$this->Empresa().'<br>'.$this->_Cab( 'ruc_registro' ).'<br>'.
	        $this->_Cab( 'direccion' ).'<br>'.$this->_Cab( 'telefono' ).' 
		</td>
		</tr>
		  </tbody>
		</table>';
		
		
 	*/
	
	
		 $cadena = '<div align="left">'.$this->Empresa().'<br>'.$this->_Cab( 'ruc_registro' ).'<br>'.
	        $this->_Cab( 'direccion' ).'<br>'.$this->_Cab( 'telefono' ).'</div>';
	        
	        return $cadena;
    }
    
    //--------------------------------------------------------
    function QR_Documento(){
        
        //   $content = $_SESSION['ruc_registro'];
        $name        = trim($_SESSION['razon'] );
        $elaborador  = $_SESSION['login'];
        //    $sesion     = $_SESSION['email'];
        
        $time = time();
        $fecha =  date("d-m-Y (H:i:s)", $time);
        
        // we building raw data
     
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
     
   //  $tempDir = EXAMPLE_TMP_SERVERPATH;
     
     QRcode::png($codeContents,  'logo_qr.png', QR_ECLEVEL_L, 3);
        
    }
    
}

?>
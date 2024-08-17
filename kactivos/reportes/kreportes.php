<?php
session_start();

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
	
		// $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
		$this->bd->conectar('postgres','db_kaipi','root');

		$this->ruc       =  $_SESSION['ruc_registro'];
		
		$this->sesion 	 =  trim($_SESSION['login']) ;
		
	}
	//---
	function EmpresaCab( ){
	    
	    $sql = "SELECT ruc_registro, razon, contacto, correo, web, direccion, telefono, email, ciudad, estado, url, mision, vision
				FROM view_registro
				where ruc_registro =".$this->bd->sqlvalue_inyeccion(	$this->ruc, true);
	    
	    $resultado = $this->bd->ejecutar($sql);
	    
	    $this->Registro = $this->bd->obtener_array( $resultado);
	    
	    return $this->Registro['razon'];
	}
	//--------------------
 
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
	//--------------------
	function ActivosCustodios($codigo){
		
	  
		
		$xx = $this->bd->query_array('view_nomina_rol',   // TABLA
			'*',                        // CAMPOS
			'idprov='.$this->bd->sqlvalue_inyeccion(trim($codigo),true) // CONDICION
			);
	  
 
			$periodo                  = explode('-',$datos['fecha']);
		    
		 
			$fecha = '2021-12-30';

		    $xx['fecha_completa']  =  $this->bd->_fecha_completa_acta($fecha);

	 
	return $xx;
}
	//---------------------
	function Acta_entrega($codigo){
		
		    //--- beneficiario
		    $sql = "SELECT *
                    FROM activo.view_acta
                   where id_acta = ".$this->bd->sqlvalue_inyeccion($codigo,true);
 	    
		    $resultado_cab = $this->bd->ejecutar($sql);
		    
		    $datos = $this->bd->obtener_array( $resultado_cab);
		    
		    
		    
 		
 
		    $periodo                  = explode('-',$datos['fecha']);
		    $datos['anio']            = $periodo[0];
		    $datos['fecha_completa']  =  $this->bd->_fecha_completa_acta($datos['fecha']);
		   
		    $datos_parametro          = $this->Funcionario(trim($datos['idprov_entrega']));
		    
		    $datos_acta               = $this->Funcionario(trim($datos['idprov']));

		    /*
		    $datos['funcionario_entrega']  =   $datos_parametro['nombre'] ;
		    $datos['cargo_entrega']        =   $datos_parametro['cargo'] ;
		    $datos['idprov_entrega']       =   $datos_parametro['idprov'] ;
		    */
      
		    
		    $xx = $this->bd->query_array('view_nomina_rol',   // TABLA
		        'razon,cargo,unidad',                        // CAMPOS
		        'idprov='.$this->bd->sqlvalue_inyeccion(trim($datos['idprov_entrega']),true) // CONDICION
		        );
		    
		    
			$firmas 		        =   $this->firmas(); 
		    
		    if (trim($datos['clase_documento']) == 'Acta de Entrega - Recepcion'){
		        
		        $datos['entrega']        =   trim($firmas['b10']);
		        $datos['entrega_cargo']  =   trim($firmas['b11']);
		        $datos['departamento']   =   $datos_acta['unidad'] ;
				$datos['idprov_entrega']  =   trim($firmas['b12']);

				$datos['funcionario_entrega']        =    trim($firmas['b10']);
		        $datos['cargo_entrega']              =   trim($firmas['b11']);

				 
		        
		        $AResultado             = $this->bd->query_array('activo.view_sede','nombre',
		            'idsede='.$this->bd->sqlvalue_inyeccion($datos_acta['idciudad'],true));
		    }else
		    {
		             
		        $datos['funcionario_entrega']        =   trim($xx['razon']);
		        $datos['entrega_cargo']              =   trim($xx['unidad']);
		        $datos['departamento']               =   $datos_parametro['unidad'] ;
				$datos['cargo_entrega']              =   trim($xx['cargo']);
				
		        $AResultado             = $this->bd->query_array('activo.view_sede','nombre',
		            'idsede='.$this->bd->sqlvalue_inyeccion($datos_parametro['idciudad'],true));
		        
					
		    }
		        
		        
		    $datos['ubicacion']     =   $AResultado['nombre'] ;
		   
		    $usuarios = $this->bd->__user($datos['sesion']); // nombre del usuario actual
		    
 		        
		    $datos['sesion']       =  trim($usuarios['completo']);  
		    $datos['sesion_cargo'] =  trim($usuarios['cargo']);  
		    
		    
		 
		return $datos;
	}
	//-
	function ficha_bien_compra($tramite,$factura ,$ruc){
	    
	    
	    $qquery = array(
	        array( campo => 'factura',   valor =>trim($factura),  filtro => 'S',   visor => 'S'),
	        array( campo => 'fecha_adquisicion',   valor => '-',  filtro => 'N',   visor => 'S'),
	        array( campo => 'idproveedor',   valor => trim($ruc),  filtro => 'S',   visor => 'S'),
	        array( campo => 'proveedor',   valor => '-',  filtro => 'N',   visor => 'S'),
	        array( campo => 'cantidad',   valor => '-',  filtro => 'N',   visor => 'S'),
	        array( campo => 'anio_adquisicion',   valor => '-',  filtro => 'N',   visor => 'S'),
	        array( campo => 'costo',   valor => '-',  filtro => 'N',   visor => 'S'),
	        array( campo => 'id_tramite',   valor => '-',  filtro => 'N',   visor => 'S')
	    );
	    
	    
	    $datos = $this->bd->JqueryArrayVisorDato('activo.view_bienes_tramite',$qquery );
	    

		$qquery = array(
	        array( campo => 'factura',   valor =>trim($factura),  filtro => 'S',   visor => 'S'),
	        array( campo => 'idproveedor',   valor => trim($ruc),  filtro => 'S',   visor => 'S'),
			array( campo => 'forma_ingreso',   valor => '-',  filtro => 'N',   visor => 'S'),
	        array( campo => 'origen_ingreso',   valor => '-',  filtro => 'N',   visor => 'S'),
	        array( campo => 'tipo_documento',   valor => '-',  filtro => 'N',   visor => 'S'),
	        array( campo => 'fecha_comprobante',   valor => '-',  filtro => 'N',   visor => 'S'),
	        array( campo => 'fecha',   valor => '-',  filtro => 'N',   visor => 'S') 
	    );
	    
	    
	    $datos1 = $this->bd->JqueryArrayVisorDato('activo.view_bienes',$qquery );

	    $datos['forma_ingreso'] = $datos1['forma_ingreso'];
		$datos['origen_ingreso'] = $datos1['origen_ingreso'];
		$datos['tipo_documento'] = $datos1['tipo_documento'];
		$datos['fecha'] = $datos1['fecha'];
		$datos['fecha_comprobante'] = $datos1['fecha_comprobante'];

	    return $datos;
	    
	}
	//-----------------------------------------------------
	function ficha_bien_tramite($id_tramite){
	    
	    
	    $qquery = array(
	        array( campo => 'id_tramite',   valor =>$id_tramite,  filtro => 'S',   visor => 'S'),
	        array( campo => 'fecha',   valor => '-',  filtro => 'N',   visor => 'S'),
	        array( campo => 'detalle',   valor => '-',  filtro => 'N',   visor => 'S'),
	        array( campo => 'observacion',   valor => '-',  filtro => 'N',   visor => 'S'),
	        array( campo => 'unidad',   valor => '-',  filtro => 'N',   visor => 'S'),
	        array( campo => 'fcertifica',   valor => '-',  filtro => 'N',   visor => 'S'),
	        array( campo => 'fcompromiso',   valor => '-',  filtro => 'N',   visor => 'S'),
	        array( campo => 'id_asiento_ref',   valor => '-',  filtro => 'N',   visor => 'S'),
	        array( campo => 'comprobante',   valor => '-',  filtro => 'N',   visor => 'S'),
	    );
	    
	    
	    
	    
	    $datos = $this->bd->JqueryArrayVisorDato('presupuesto.view_pre_tramite',$qquery );
	    
	    
	    
	    return $datos;
	    
	}
	//---------------------
	function ficha_bien($codigo){
	    
	    //--- beneficiario
	    $sql = "SELECT  *
                    FROM activo.view_bienes
                   where id_bien = ".$this->bd->sqlvalue_inyeccion($codigo,true);
 	    
	    $resultado_cab = $this->bd->ejecutar($sql);

	    $datos         = $this->bd->obtener_array( $resultado_cab);
	    
	    //---------------------------------------------------


		$xxy = $this->bd->query_array('web_modelo',   
		'nombre',                        
		'idmodelo='.$this->bd->sqlvalue_inyeccion($datos['id_modelo'],true)  
		 );

		 $datos['modelo']         = $xxy['nombre'];
		//----------------------------------------------------
	    
	    $sqlima = "SELECT archivo
                    FROM activo.ac_bienes_imagen
                   where id_bien = ".$this->bd->sqlvalue_inyeccion($codigo,true). " and tipo='imagen' limit 1";
	    
 
	    $resultadoi = $this->bd->ejecutar($sqlima);

	    $datos_ima  = $this->bd->obtener_array( $resultadoi);
	    
	    //---------------------------------------------------

 
	    $periodo           = explode('-',$datos['fecha']);
	    
	    $anio              = $periodo[0];
	   
	    $input             = str_pad($codigo, 4, "0", STR_PAD_LEFT);
	   
	    $datos['archivo']  = trim($datos_ima['archivo']);
	    
	    //---------------------------------------------
	    if (empty( trim($datos_ima['archivo']))){
	        $datos['archivo']  = 'foto.png';
	    }
	    
	   
	    
	    if ($datos['movimiento'] > 0 ){
	        $xyz = $datos['movimiento'];
 	        $datos['movimiento'] = str_pad($xyz, 5, "0", STR_PAD_LEFT);
	        
	    }else
	    {
	        
	        // SECUENCIAS DE COMPROBANTES...
	        $input_orden          = $this->bd->_secuencias($anio, 'AB',5,'N');
	        //-----------------------
	        
	        $contador             = $input_orden;
	        
	        $datos['movimiento']  = str_pad($contador, 5, "0", STR_PAD_LEFT);
	        
	        $sqlmov = "update activo.ac_bienes 
                          set movimiento =".$this->bd->sqlvalue_inyeccion($contador,true)."
                        where id_bien = ".$this->bd->sqlvalue_inyeccion($codigo,true);
	        $this->bd->ejecutar($sqlmov);
	        
	         
	        
	    }
 
	        
	    $datos['anio_actual']  = $anio;
	    
	    $datos['anio']         = $periodo[0];
	    
	//    $datos['bien'] = trim($datos['tipo_bien']).'-'. $input.'-'.$datos['anio'];
	
	    $datos['bien'] = trim($datos['tipo_bien']).'.'.trim($datos['cuenta']).'-'. $input ;
	    
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
	        
	        $sql = "SELECT  razon as nombre,  cargo, idprov,unidad,idciudad
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
//-----------------------------
	function bien_componente( $idbien ){
	    
	    //--- beneficiario
	    $sql ="SELECT  marca,  detalle_componente, costo_componente
        FROM activo.view_bienes_componente
        where id_bien = ".$this->bd->sqlvalue_inyeccion($idbien,true)    ;
 
	    
	    echo ' <table  class="table table-striped table-bordered table-hover datatable" border="0" width="100%" style="font-size: 9px"  >
			<thead>
			 <tr>
				<th width="25%">Marca</th>
				<th width="65%">Detalle</th>
				<th align="right" width="10%">Costo</th>
 				</tr>
			</thead>';
	    
	    
	    $stmt1           = $this->bd->ejecutar($sql);
	    $a1     = 0;
 
	    $i = 1;
	    
	    while ($y=$this->bd->obtener_fila($stmt1)){
	        
	        $a1     = $a1 + $y['costo_componente'];
 	      
	        
	        $detalle =   trim($y['detalle_componente']) ;
	        
	        
	        
	        echo ' <tr>
		    	<td>'.$y['marca'].'</td>
                <td>'.$detalle.'</td>
               	<td align="right">'.$y['costo_componente'].'</td>
 
           </tr>';
	        
	        $i++;
	        
	    }
	    
 
	    echo ' <tr>
				<td align="right"></td>
				<td align="right">TOTAL</td>
                <td align="right">'.number_format($a1,2).'</td>
               
                </tr>';
	    
	    
	    echo	'</table>';
	    
	}
	
 //----------------------------
	function bien_componente_acta( $id, $idbien ){
	    
		
		$cadena_bien = trim(substr( $idbien ,1,100));
	    //--- beneficiario
	    $sql ="SELECT  marca,  detalle_componente, costo_componente
        FROM activo.view_bienes_componente
        where id_bien in (".$cadena_bien.")"    ;
 
		 
		
	 
	    
	    echo '<table id="table_detalle"  class="lado" cellspacing="0" width="90%" style="font-size: 9px">
			<thead>
			 <tr>
				<th  class="lado"  width="75%">Componente/Novedad</th>
  				</tr>
			</thead>';
	    
	    
	    $stmt11           = $this->bd->ejecutar($sql);
	    $a1     = 0;
 
	    $i = 1;
	    
	    while ($y=$this->bd->obtener_fila($stmt11)){
	        
	        $a1      = $a1 + $y['costo_componente'];
	        $detalle =   trim($y['detalle_componente']) ;
	        
 	        
	        echo '<tr>
                <td  class="lado" >'.$detalle.' '.$y['marca'].'</td>
           		  </tr>';
	        
	        $i++;
	        
	    }
	    
 
	   
	    
	    
	    echo	'</table>';
		
		pg_free_result($stmt11);
	    
	}
	
	//------------------ CabReportes
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
	
	function CabReportesDepre($codigo){
	    
	    //--- beneficiario
	    $sql = "SELECT id_bien_dep, fecha, cuenta, anio, detalle, estado, sesion, 
                        creacion, sesionm, modificacion, fecha2, idprov 
                FROM activo.ac_bienes_cab_dep
                 where id_bien_dep = ".$this->bd->sqlvalue_inyeccion($codigo ,true);
	    
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
	    $dias = array('Domingo', 'Lunes', 'Martes', 'Mi�rcoles', 'Jueves', 'Viernes', 'S�bado');
	    $dia = $dias[date('w', strtotime($fecha))];
	    return $dia;
	}
	//----------------------------------
	function _elaborado(){
	    
		$Auser = $this->bd->query_array('par_usuario',
										 'completo', 
				'login='.$this->bd->sqlvalue_inyeccion(trim($this->sesion) ,true)
				);
			   
	   
				echo '<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tbody>
				  <tr>
					<td width="50%" align="center" style="font-weight: normal;font-size: 10px;">'.$Auser['completo'].'</td>
					<td width="50%" align="center" style="font-weight: normal;font-size: 10px;">&nbsp;</td>
				  </tr>
				  <tr>
					<td align="center" style="font-weight: normal;font-size: 10px;">Elaborado</td>
					<td align="center" style="font-weight: normal;font-size: 10px;">Autorizado</td>
				  </tr>
				</tbody>
			  </table>';
			
		 
		}
		//-------------------------
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

	 $a10 = $this->bd->query_array('wk_config','carpeta , carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(11,true));
	 $pie_contenido = str_replace('#ADMINISTRATIVO',trim($a10['carpeta']), $pie_contenido);
	 $pie_contenido = str_replace('#CARGO_ADMINISTRATIVO',trim($a10['carpetasub']), $pie_contenido);

	 $a10 = $this->bd->query_array('wk_config','carpeta , carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(16,true));
	 $pie_contenido = str_replace('#GUARDAALMACEN',trim($a10['carpeta']), $pie_contenido);
	 $pie_contenido = str_replace('#CARGO_GUARDAALMACEN',trim($a10['carpetasub']), $pie_contenido);

	 $a10 = $this->bd->query_array('wk_config','carpeta , carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(20,true));  
	 $pie_contenido = str_replace('#BIENES',trim($a10['carpeta']), $pie_contenido);
	 $pie_contenido = str_replace('#CARGO_BIENES',trim($a10['carpetasub']), $pie_contenido);
		
		//------------- llama a la tabla de parametros ---------------------//

		$usuarios = $this->bd->__user($this->sesion); // nombre del usuario actual

		$sesion   = ucwords(strtolower($usuarios['completo']));  
  
 
		$pie_contenido = str_replace('#SESION',$sesion, $pie_contenido);
	    
		echo $pie_contenido ;
 
		
	}
	//------------------------
	function firma_baja($codigo_reporte,$datos){
	    
	    
	    $reporte_pie   = $this->bd->query_array('par_reporte', 'pie', 'referencia='.$this->bd->sqlvalue_inyeccion( trim($codigo_reporte) ,true) );
	    
	    $pie_contenido = $reporte_pie["pie"];
	    
	    // NOMBRE / CARGO
	    $a10 = $this->bd->query_array('wk_config','carpeta , carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(20,true));
	    
	    $pie_contenido = str_replace('#BIENES',trim($a10['carpeta']), $pie_contenido);
	    $pie_contenido = str_replace('#CARGO_BIENES',trim($a10['carpetasub']), $pie_contenido);
	    
	    $a10 = $this->bd->query_array('wk_config','carpeta , carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(12,true));
	    $pie_contenido = str_replace('#FINANCIERO',trim($a10['carpeta']), $pie_contenido);
	    $pie_contenido = str_replace('#CARGO_FINANCIERO',trim($a10['carpetasub']), $pie_contenido);
	    
	    $a10 = $this->bd->query_array('wk_config','carpeta , carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(14,true));
	    $pie_contenido = str_replace('#CONTADOR',trim($a10['carpeta']), $pie_contenido);
	    $pie_contenido = str_replace('#CARGO_CONTADOR',trim($a10['carpetasub']), $pie_contenido);
	    
	    $a10 = $this->bd->query_array('wk_config','carpeta , carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(11,true));
	    $pie_contenido = str_replace('#ADMINISTRATIVO',trim($a10['carpeta']), $pie_contenido);
	    $pie_contenido = str_replace('#CARGO_ADMINISTRATIVO',trim($a10['carpetasub']), $pie_contenido);
	    
	    $a10 = $this->bd->query_array('wk_config','carpeta , carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(16,true));
	    $pie_contenido = str_replace('#GUARDAALMACEN',trim($a10['carpeta']), $pie_contenido);
	    $pie_contenido = str_replace('#CARGO_GUARDAALMACEN',trim($a10['carpetasub']), $pie_contenido);
	    
	    //------------- llama a la tabla de parametros ---------------------//
	    
	   $fecha =  $this->bd->_fecha_completa($datos['fecha']);
	    
	    $pie_contenido = str_replace('#ACTA',trim($datos['documento']), $pie_contenido);
	    
	    $pie_contenido = str_replace('#DETALLE',trim($datos['detalle']), $pie_contenido);
	    
	    $pie_contenido = str_replace('#MOTIVO',trim($datos['resolucion']), $pie_contenido);
	    
	    $pie_contenido = str_replace('#RESOLUCION',trim($datos['resolucion']), $pie_contenido);
	    
	    $pie_contenido = str_replace('#CUSTODIO',trim($datos['razon']), $pie_contenido);
	    $pie_contenido = str_replace('#CARGO_CUSTODIO',trim($datos['cargo']), $pie_contenido);
	    
	    
	    $pie_contenido = str_replace('#FECHA',trim($fecha), $pie_contenido);
 
 
	    
	    $usuarios = $this->bd->__user($this->sesion); // nombre del usuario actual
	    
	    $sesion   = ucwords(strtolower($usuarios['completo']));
	    
	    
	    $pie_contenido = str_replace('#SESION',$sesion, $pie_contenido);
	    
	    echo $pie_contenido ;
	    
	    
	}
	function pie_cliente($cliente){
	    
    $Auser = $this->bd->query_array('par_usuario',
	                                 'completo', 
	        'login='.$this->bd->sqlvalue_inyeccion(trim($this->sesion) ,true)
	        );
	       
   
	 $fecha = date('Y-m-d');
	    
	  echo '<table width="100%" border="0">
                <tr>
                  <td width="30%"><p class="page" style="font-size: 10px;color: #363636"></p></td>
                  <td width="70%" align="right" style="font-size: 10px;color: #363636"> Documento digital generado: '.$Auser['completo'].' Impresion '. $fecha.'</td>
                </tr>
            </table>';
	    
	}
//------------------------
	function pie_cliente_final($cliente){
	    
		$Auser = $this->bd->query_array('par_usuario',
										 'completo', 
				'login='.$this->bd->sqlvalue_inyeccion(trim($this->sesion) ,true)
				);
			   
	   
		  $fecha = '2021-12-31';
			
		  echo '<table width="100%" border="0">
					<tr>
					  <td width="30%"><p class="page" style="font-size: 10px;color: #363636"></p></td>
					  <td width="70%" align="right" style="font-size: 10px;color: #363636"> Documento digital generado: '.$Auser['completo'].' Original </td>
					</tr>
				</table>';
			
		}
	//-------
	function BienesHistorial($id){
	    
	    $qquery = array(
	        array( campo => 'id_bien_historico',    valor => '-',  filtro => 'N',   visor => 'S'),
	        array( campo => 'id_bien',valor => $id,filtro => 'S', visor => 'S'),
	        array( campo => 'tipo_h',valor => '-',filtro => 'N', visor => 'S'),
	        array( campo => 'fecha_a',valor => '-',filtro => 'N', visor => 'S'),
	        array( campo => 'documento_h',valor => '-',filtro => 'N', visor => 'S'),
	        array( campo => 'detalle_h',valor => '-',filtro => 'N', visor => 'S'),
	        array( campo => 'depreciacion',valor => '-',filtro => 'N', visor => 'S') ,
	        array( campo => 'costo_bien',valor => '-',filtro => 'N', visor => 'S'),
	        array( campo => 'costo_bien_h',valor => '-',filtro => 'N', visor => 'S'),
	        array( campo => 'vida_util_h',valor => '-',filtro => 'N', visor => 'S'),
	        array( campo => 'vida_util',valor => '-',filtro => 'N', visor => 'S')
	    );
	    
	    $this->bd->_order_by('id_bien_historico desc');
	    
	    $resultado = $this->bd->JqueryCursorVisor('activo.view_revalorizacion',$qquery );
	    
  	    
	    
 	    $titulo = 'HISTORIAL NOVEDADES DEL BIEN';
	    
 	    $estilo = 'style="padding: 3px" ';
 	    
	    echo '<table style="border-collapse: collapse; border: 1px solid #AAAAAA;font-weight: normal;font-size: 10px" border="0" width="100%" cellspacing="0" >
	             <tr>  <td colspan="6" bgcolor="#EDEDED" style="font-weight: normal;font-size: 10px;padding: 6px">6. '.$titulo.'  </td> </tr>
			 <tr>
	           <th '.$estilo.' width="10%">Fecha</th>
				<th '.$estilo.' width="15%">Tipo</th>
				<th '.$estilo.' width="10%">Documento</th>
				<th '.$estilo.' width="45%">Detalle</th>
                <th '.$estilo.' width="10%">Costo Actual</th>
                <th '.$estilo.' width="10%">Vida Util</th>
  				</tr>
			</thead>';
	    
 
	    
	    $i = 1;
	    
	    while ($y=$this->bd->obtener_fila($resultado)){
  	        
 	 
	        echo ' <tr>
                <td '.$estilo.' >'.trim($y['fecha_a']).'</td>
		    	<td '.$estilo.' >'.$y['tipo_h'].'</td>
				<td '.$estilo.' >'.trim($y['documento_h']).'</td>
              	<td '.$estilo.' >'.trim($y['detalle_h']).'</td>
                <td '.$estilo.' >'.$y['costo_bien'].'</td>
  				<td '.$estilo.' >'.$y['vida_util'].'</td>
           </tr>';
	        
	        $i++;
	        
	    }
	    
	     
	    echo	'</table>';
	    
	}
	//-----------------
	function BienesParametrosHistorial($tramite,$factura ,$ruc){
	    
	    $SQL = "SELECT  cuenta || ' - '|| lpad(cast(id_bien as varchar),5,'0') as bien  ,
                        tipo_bien,
                        forma_ingreso,
                        clase_esigef || ' ' as clase_esigef,
		                identificador || '  ' as identificador,
                         descripcion,
                         marca ,
                         serie ,
                         costo_adquisicion
		FROM activo.view_bienes
		where idproveedor= ".$this->bd->sqlvalue_inyeccion(trim($ruc),true)." and
              id_tramite= ".$this->bd->sqlvalue_inyeccion($tramite,true)." and
              factura =".$this->bd->sqlvalue_inyeccion(trim($factura),true)." order by id_bien ";
	    
	    
	    
	    $resultado = $this->bd->ejecutar($SQL);
	    
	    
	    echo ' <table id="table_detalle"  class="lado" cellspacing="0" width="95%" style="font-size:7px"  >
			<thead>
			 <tr>
	           <th class="lado" width="15%">Codigo Bien</th>
				<th class="lado" width="5%">Tipo</th>
				<th class="lado" width="10%">Forma</th>
				<th class="lado" width="10%">Clase</th>
                <th class="lado" width="30%">Descripcion</th>
                <th class="lado" width="10%">Marca</th>
                <th class="lado" width="10%">Serie</th>
                <th class="lado" width="10%">Costo</th>
 				</tr>
			</thead>';
	    
	    
	    
	    $i = 1;
	    
	    while ($y=$this->bd->obtener_fila($resultado)){
	        
	        $detalle =   trim($y['descripcion']) ;
	        
	        echo ' <tr>
                <td class="lado" >'.trim($y['bien']).'</td>
		    	<td class="lado" >'.$y['tipo_bien'].'</td>
				<td class="lado" >'.trim($y['forma_ingreso']).'</td>
              	<td class="lado" >'.trim($y['clase_esigef']).'</td>
                 <td class="lado" >'.trim($detalle).'</td>
                <td class="lado" >'.$y['marca'].'</td>
                <td class="lado" >'.$y['serie'].'</td>
  				<td class="lado" >'.$y['costo_adquisicion'].'</td>
           </tr>';
	        
	        $i++;
	        
	    }
	    
	    
	    echo	'</table>';
	    
	}
	
	//--- resumen IR BienesParametros
	function BienesParametros($datos){
	    
	    
	    $x_tipo = trim($datos['material']);
	    
	    if ( $x_tipo == 'INMUEBLE') {
	       $titulo  = 'IDENTIFICACION DEL BIEN INMUEBLE';
	       $marca   = 'Uso';
	       $modelo  = 'Destino';
	       
	       $serie   = 'Clave Catastral';
	       $uso     = 'Uso';
	       
	       $titulo1 = 'REFERENCIA DE LA ADQUISICION';
	       
	       $proveedor = 'Propietario Anterior';
	       $factura = 'Año';
	       $costo = 'Avaluo';
	       
	    }else{
	        $titulo = 'IDENTIFICACION DEL BIEN';
	        $marca  = 'Marca';
	        $modelo  = 'Modelo';
	        
	        $serie   = 'Serie';
	        $uso     = 'Uso';
	        
	        $titulo1 ='REFERENCIA DE LA ADQUISICION';
	        
	        $proveedor = 'Proveedor';
	        $factura = 'N° Documento';
	        $costo = 'Costo';
	        
	    }
	    
	 
	    
	    $estilo = 'style="padding: 3px" ';

		// Campos para vehículos
		$SQL = "SELECT  * FROM activo.ac_bienes_vehiculo WHERE id_bien =".$this->bd->sqlvalue_inyeccion(trim($datos['id_bien']),true);
	    $resutlado_consulta = $this->bd->ejecutar($SQL);
		$datos_vehiculo = $this->bd->obtener_array($resutlado_consulta);

		$html_datos_vehiculo='';
		if ($datos_vehiculo) {
			// print_r($datos_vehiculo);
			$html_datos_vehiculo='
			<tr>
				<td '.$estilo.' >Clase Vehículo:</td>
				<td '.$estilo.' >'.trim($datos_vehiculo['clase_ve']).'</td>
				<td '.$estilo.' >Nro. Motor:</td>
				<td '.$estilo.' >'.$datos_vehiculo['motor_ve'].'</td>
			</tr>
			<tr>
				<td '.$estilo.' >Nro. Chasis:</td>
				<td '.$estilo.' >'.trim($datos_vehiculo['chasis_ve']).'</td>
				<td '.$estilo.' >Nro. Placa:</td>
				<td '.$estilo.' >'.$datos_vehiculo['placa_ve'].'</td>
			</tr>
			<tr>
				<td '.$estilo.' >Año Fabricacion:</td>
				<td '.$estilo.' >'.trim($datos_vehiculo['anio_ve']).'</td>
				<td '.$estilo.' >Color:</td>
				<td '.$estilo.' >'.$datos_vehiculo['color_ve'].'</td>
			</tr>';
		}

	    echo '<table style="border-collapse: collapse; border: 1px solid #AAAAAA;font-weight: normal;font-size: 10px" border="0" width="95%" cellspacing="0" >
	             <tr>  <td colspan="4" bgcolor="#EDEDED" style="font-weight: normal;font-size: 11px;padding: 6px">2. '.$titulo.'  </td> </tr>
				 
                  <tr>
				     <td colspan="4" style="font-weight: normal;font-size: 11px;padding: 5px"><b>'.$datos['descripcion'].'</b></td>
			      </tr>
                  <tr>
				     <td colspan="4" style="font-weight: normal;font-size: 9px;padding: 1px;padding-left: 5px"><b>Caracteristicas Adicionales:</b> '.$datos['detalle'].'</td>
			      </tr>
				 <tr>
    				   <td '.$estilo.' width="10%">'.$marca.'</td>
    				   <td '.$estilo.' width="50%">'.trim($datos['marca']).'</td>
    				   <td '.$estilo.' width="15%">'.$modelo.'</td>
    				   <td '.$estilo.' width="25%">'.$datos['modelo'].'</td>
			      </tr>
				 <tr>
    				   <td '.$estilo.' >'.$serie.'</td>
    				   <td '.$estilo.' >'.trim($datos['serie']).'</td>
    				   <td '.$estilo.' >'.$uso.'</td>
    				   <td '.$estilo.' >'.$datos['uso'].'</td>
 				 </tr>
				 '.$html_datos_vehiculo.'
   					<tr>
				      <td colspan="4"   bgcolor="#EDEDED" style="font-weight: normal;font-size: 11px;padding: 6px">3.'.$titulo1.'</td>
			       </tr> 
                   <tr>
    				   <td '.$estilo.' >Clase</td>
    				   <td '.$estilo.' >'.trim($datos['clase_documento']).'</td>
    				   <td '.$estilo.' > Documento</td>
    				   <td '.$estilo.' >'.trim($datos['tipo_comprobante']).'</td>
			      </tr>
                   <tr>
    				   <td '.$estilo.' >'.$proveedor.'</td>
    				   <td '.$estilo.' >'.trim($datos['proveedor']).'</td>
    				   <td '.$estilo.' >'.$factura.'</td>
    				   <td '.$estilo.' >'.$datos['factura'].'</td>
			      </tr>
                  <tr>
    				   <td '.$estilo.' >'.$costo.'</td>
    				   <td style="font-weight:bold;font-size: 11px;padding: 3px">'.number_format( $datos['costo_adquisicion'],2) .'</td>
    				   <td '.$estilo.' >Fecha Comprobante  </td>
    				   <td '.$estilo.' > '.$datos['fecha_comprobante'].' </td>
			      </tr>

				  <tr>
				      <td colspan="4"   bgcolor="#EDEDED" style="font-weight: normal;font-size: 11px;padding: 6px">4. VALORIZACIÓN</td>
			       </tr>
				   <tr>
    				   <td '.$estilo.' >Depreciación?</td>
    				   <td '.$estilo.' >'.trim($datos['depreciacion']).'</td>
    				   <td '.$estilo.' >Vida Útil</td>
    				   <td '.$estilo.' >'.trim($datos['vida_util']).'</td>
			      </tr> 
                   <tr>
    				   <td '.$estilo.' >% Depreciación</td>
    				   <td '.$estilo.' >'.trim($datos['razon']).'</td>
    				   <td '.$estilo.' >Valor Depreciación</td>
    				   <td '.$estilo.' >'.trim($datos['valor_depreciacion']).'</td>
			       </tr>
                   <tr>
    				   <td '.$estilo.' >Última Depreciación</td>
    				   <td '.$estilo.' >'.trim($datos['anio_depre']).'</td>
    				   <td '.$estilo.' >Valor en Libros</td>
    				   <td '.$estilo.' >'.trim($datos['valor_libros']?:'0.00').'</td>
			       </tr>
                  

				  <tr>
				      <td colspan="4"   bgcolor="#EDEDED" style="font-weight: normal;font-size: 11px;padding: 6px">5. IDENTIFICACION RESPONSABLE</td>
			       </tr> 
                   <tr>
    				   <td '.$estilo.' >Custodio</td>
    				   <td '.$estilo.' >'.trim($datos['razon']).'</td>
    				   <td '.$estilo.' > Unidad</td>
    				   <td '.$estilo.' >'.trim($datos['unidad']).'</td>
			      </tr>
                  <tr>
    				   <td '.$estilo.' >Ubicacion</td>
    				   <td '.$estilo.' >'.trim($datos['tipo_ubicacion']).'</td>
    				   <td '.$estilo.' > Detalle</td>
    				   <td '.$estilo.' >'.trim($datos['detalle_ubica']).'</td>
			      </tr>

                   <tr>
				      <td colspan="4"   bgcolor="#EDEDED" style="font-weight: normal;font-size: 11px;padding: 6px">6. GARANTIAS</td>
			       </tr> 
                   <tr>
    				   <td '.$estilo.' >Garantia?</td>
    				   <td '.$estilo.' >'.trim($datos['garantia']).'</td>
    				   <td '.$estilo.' > Tiempo</td>
    				   <td '.$estilo.' >'.trim($datos['tiempo_garantia']).' Mes(es)'.'</td>
			      </tr>
			   </table> ';
	 
	}
	//--------
	function GrillaBienes_Compra($tramite,$factura ,$ruc){
 
  
		$sql = 'select clase_esigef ,
						descripcion, 
						cuenta,
						clasificador ,
						marca ,count(*) as cantidad,sum(costo_adquisicion) total,id_bien
				FROM activo.view_bienes
				where trim(idproveedor) = '.$this->bd->sqlvalue_inyeccion($ruc,true) .' and 
					  trim(factura) = '.$this->bd->sqlvalue_inyeccion($factura,true) .'
				group by clase_esigef ,descripcion, cuenta,clasificador ,marca,id_bien';
				
 
   
		
		echo ' <table id="table_detalle"  class="lado" cellspacing="0" width="90%" style="font-size: 9px"  >
		 <thead>
		  <tr>
		  	 <th class="lado" width="10%">Codigo</th>
			 <th class="lado" width="15%">Clase</th>
			 <th class="lado" width="30%">Descripcion</th>
			 <th class="lado" width="10%">Cuenta</th>
			 <th class="lado" width="10%">Clasificador</th>
			 <th class="lado" width="15%">Marca</th>
			 <th class="lado" width="10%">Total</th>
			  </tr>
		 </thead>';
		
	  
		$stmt1           = $this->bd->ejecutar($sql);
	   
		$i = 1;
		
		$total = 0;
		
		while ($y=$this->bd->obtener_fila($stmt1)){
			 
		 
 			
			echo ' <tr>
			<td class="lado" >'.trim($y['cuenta']).'-'.trim($y['id_bien']).'</td>
			<td class="lado" >'.trim($y['clase_esigef']).'</td>
			<td class="lado" >'.trim($y['descripcion']).'</td>
			<td class="lado" >'.trim($y['cuenta']).'</td>
 			 <td class="lado" >'.$y['clasificador'].'</td>
			 <td class="lado" >'.$y['marca'].'</td>
			   <td class="lado" >'.$y['total'].'</td>
		</tr>';
			
			$i++;
			
			$total = $total + $y['total']; 
		 }


		 $IVA = $total * (12/100);

		 $total1 = 	$total +  $IVA;
		 echo ' <tr>
 			  <td class="lado" > </td>
			  <td class="lado" > </td>
			 <td class="lado" > </td>
			<td class="lado" > </td>
			<td class="lado" > </td>
			 <td class="lado" >SubTotal </td>
			   <td class="lado" >'.$total.'</td>
		</tr></table>';

		// echo '<tr>
 		// 	  <td class="lado" > </td>
		// 	  <td class="lado" > </td>
		// 	 <td class="lado" > </td>
		// 	<td class="lado" > </td>
		// 	<td class="lado" > </td>
		// 	 <td class="lado" >IVA </td>
		// 	   <td class="lado" >'. round($IVA,2).'</td>
		// 	   <tr>
 		// 	  <td class="lado" > </td>
		// 	  <td class="lado" > </td>
		// 	 <td class="lado" > </td>
		// 	<td class="lado" > </td>
		// 	<td class="lado" > </td>
		// 	 <td class="lado" >Total </td>
		// 	   <td class="lado" >'. round($total1,2).'</td>
		// </tr></table>';
   
 
 	  
	 
 }
 //----------GrillaBienes
 function GrillaBienesCustodios($id){
 
  
	$sql = 'SELECT *
			 FROM activo.view_bienes
			 where idprov= '.$this->bd->sqlvalue_inyeccion($id,true) .' order by clase,id_bien' ;

	

	
	echo ' <table id="table_detalle"  class="lado" cellspacing="0" width="90%" style="font-size: 9px"  >
	 <thead>
	  <tr>
		<th class="lado" width="5%">Nro.</th>
		 <th class="lado" width="12%">Codigo</th>
		 <th class="lado" width="7%">Clase</th>
		 <th class="lado" width="6%">Estado</th>
		 <th class="lado" width="22%">Detalle Item</th>
		 <th class="lado" width="10%">Marca</th>
		 <th class="lado" width="8%">Serie</th>
		 <th class="lado" width="5%">Vida Util</th>
		 <th class="lado" width="8%">Adquisición</th>
		 <th class="lado" width="8%">Costo</th>
		  </tr>
	 </thead>';
	
  
	$stmt1           = $this->bd->ejecutar($sql);
   
	$i = 1;
	
	$total = 0;
	
	while ($y=$this->bd->obtener_fila($stmt1)){

		  $detalle =   trim($y['descripcion']) .' Color '.trim($y['color']).' '.trim($y['material']).' '.trim($y['dimension'])  ;
 
		$input = str_pad($y['id_bien'], 5, "0", STR_PAD_LEFT);
		
		$codigo =   trim($y['cuenta']).'-'. $input;   
		
		$id_bien = $y['id_bien'];
		
		echo ' <tr>
		 <td class="lado" >'.$i.'</td>
		 <td class="lado" >'.$codigo.'</td>
		 <td class="lado" >'.trim($y['clase']).'</td>
		 <td class="lado" >'.trim($y['estado']).'</td>
		 <td class="lado" >'.trim($detalle).'</td>
		 <td class="lado" >'.$y['marca'].'</td>
		 <td class="lado" >'.$y['serie'].'</td>
		 <td class="lado" >'.$y['vida_util'].'/'.$y['tiempo_anio'].'</td>
		 <td class="lado" >'.$y['fecha_adquisicion'].'</td>
		   <td class="lado" >'.$y['costo_adquisicion'].'</td>
	</tr>';
		
		$i++;
		
		$total = $total + $y['costo_adquisicion']; 
	 }

	 echo ' <tr>
		 <td class="lado" > </td>
		  <td class="lado" > </td>
		  <td class="lado" > </td>
		 <td class="lado" > </td>
		 <td class="lado" > </td>
		 <td class="lado" > </td>
		<td class="lado" > </td>
		<td class="lado" > </td>
 		 <td class="lado" >Total </td>
		   <td class="lado" >'.$total.'</td>
	</tr>';

 
 
	return $i;
 
}

function GrillaBienesCustodios_doc($id){
 
  
	$sql = 'SELECT *
			 FROM activo.view_bienes
			 where idprov= '.$this->bd->sqlvalue_inyeccion($id,true) .' order by clase,id_bien' ;

	

	
	echo ' <table id="table_detalle"  class="lado" cellspacing="0" width="90%" style="font-size: 8px"  >
	 <thead>
	  <tr>
		<th class="lado" width="5%">Nro.</th>
		 <th class="lado" width="15%">Codigo</th>
		 <th class="lado" width="7%">Clase</th>
		 <th class="lado" width="6%">Estado</th>
		 <th class="lado" width="35%">Detalle Item</th>
		 <th class="lado" width="16%">Marca</th>
		 <th class="lado" width="7%">Serie</th>
 		  </tr>
	 </thead>';
	
  
	$stmt1           = $this->bd->ejecutar($sql);
   
	$i = 1;
	
	$total = 0;
	
	while ($y=$this->bd->obtener_fila($stmt1)){

		  $detalle =   trim($y['descripcion']) .' Color '.trim($y['color']).' '.trim($y['material']).' '.trim($y['dimension'])  ;
 
		$input = str_pad($y['id_bien'], 5, "0", STR_PAD_LEFT);
		
		$codigo =   trim($y['cuenta']).'-'. $input;   
		
		$id_bien = $y['id_bien'];
		
		echo ' <tr>
		 <td class="lado" >'.$i.'</td>
		 <td class="lado" >'.$codigo.'</td>
		 <td class="lado" >'.trim($y['clase']).'</td>
		 <td class="lado" >'.trim($y['estado']).'</td>
		 <td class="lado" >'.trim($detalle).'</td>
		 <td class="lado" >'.$y['marca'].'</td>
		 <td class="lado" >'.$y['serie'].'</td>
	</tr>';
		
		$i++;
		
		$total = $total + $y['costo_adquisicion']; 
	 }

 
 
 
	return $i;
 
}
function GrillaBienes_AC($id){
 
  
	$sql = 'SELECT estado, id_acta_det,  id_bien, sesion, creacion, marca, tipo, tipo_bien, 
				   descripcion, serie, estado_bien, costo_adquisicion, clasificador, clase ,cuenta,color,material ,dimension 
			 FROM activo.view_acta_detalle
			 where id_acta= '.$this->bd->sqlvalue_inyeccion($id,true) .' order by clase,id_bien' ;

	

	
	echo ' <table id="table_detalle"  class="lado" cellspacing="0" width="90%" style="font-size: 9px"  >
	 <thead>
	  <tr>
		<th class="lado" width="5%">Nro.</th>
		 <th class="lado" width="14%">Codigo</th>
		 <th class="lado" width="12%">Clase</th>
		 <th class="lado" width="23%">Detalle Item</th>
		 <th class="lado" width="10%">Marca</th>
		 <th class="lado" width="10%">Serie</th>
		 <th class="lado" width="8%">Estado</th>
		 <th class="lado" width="8%">Costo</th>
		  </tr>
	 </thead>';
	
  
	$stmt1           = $this->bd->ejecutar($sql);
   
	$i = 1;
	
	$total = 0;
	
	while ($y=$this->bd->obtener_fila($stmt1)){

		  $detalle =   trim($y['descripcion']) .' Color '.trim($y['color']).' '.trim($y['material']).' '.trim($y['dimension'])  ;


		$input = str_pad($y['id_bien'], 5, "0", STR_PAD_LEFT);
		
		$codigo =   trim($y['cuenta']).'-'. $input;   
		
		$id_bien = $y['id_bien'];
		
		echo ' <tr>
		 <td class="lado" >'.$i.'</td>
		 <td class="lado" >'.$codigo.'</td>
		 <td class="lado" >'.trim($y['clase']).'</td>
		 <td class="lado" >'.trim($detalle).'</td>
		 <td class="lado" >'.$y['marca'].'</td>
		 <td class="lado" >'.$y['serie'].'</td>
		 <td class="lado" >'.$y['estado_bien'].'</td>
		   <td class="lado" >'.$y['costo_adquisicion'].'</td>
	</tr>';
		
		$i++;
		
		$total = $total + $y['costo_adquisicion']; 
	 }

	 echo ' <tr>
		 <td class="lado" > </td>
		  <td class="lado" > </td>
		  <td class="lado" > </td>
		 <td class="lado" > </td>
		<td class="lado" > </td>
		<td class="lado" > </td>
		 <td class="lado" >Total </td>
		   <td class="lado" >'.$total.'</td>
	</tr>';


	echo	'</table><h5>Informacion Adicional</h5>';

	$this->bien_componente_acta( $id_bien );
 
	return $i;
 
}
//-----------------
function GrillaBienesBaja($id){
    
    
    
    $datos = $this->bd->query_array('activo.ac_movimiento','*', 'id_acta='.$this->bd->sqlvalue_inyeccion($id,true));
    
    $fecha = $datos['fecha'];
    
    $sql = 'SELECT *
                    FROM activo.view_acta_detalle
                    where id_acta= '.$this->bd->sqlvalue_inyeccion($id,true) .' order by clase,id_bien' ;
    
    
    
    
    echo ' <table id="table_detalle"  class="lado" cellspacing="0" width="90%" style="font-size: 9px"  >
			<thead>
			 <tr>
	            <th class="lado" width="5%">Nro.</th>
				<th class="lado" width="15%">Codigo</th>
                <th class="lado" width="30%">Detalle Item</th>
                <th class="lado" width="5%">Año Compra</th>
 	            <th class="lado" width="5%">Vida Util</th>
                <th class="lado" width="8%">Dias Utilizados</th>
                <th class="lado" width="8%">Adquisicion</th>
				<th class="lado" width="8%">Valor Residual</th>
                <th class="lado" width="8%">CPD</th>
				<th class="lado" width="8%">Valor Libros</th>
  				</tr>
			</thead>';
    
    
    $stmt1           = $this->bd->ejecutar($sql);
    
    $i = 1;
    
    $total = 0;
    $valor_depreciacion= 0;
    $valor_contable = 0;
	 $valor1 = 0;
    
    
    $cadena = '';
    while ($y=$this->bd->obtener_fila($stmt1)){
        
        $fecha_fin = $y['fecha_adquisicion'];
        
        $dias = (strtotime($fecha)-strtotime($fecha_fin))/86400;
        $dias = abs($dias);
        $dias = floor($dias);
          
        $input = str_pad($y['id_bien'], 5, "0", STR_PAD_LEFT);
        
        $codigo =   trim($y['cuenta']).'-'. $input;
        
        $id_bien = $y['id_bien'];
        
        
        $yy = $this->bd->query_array('activo.view_bienes',   // TABLA
            '*',                        // CAMPOS
            'id_bien='.$this->bd->sqlvalue_inyeccion(  $id_bien,true) // CONDICION
            );
        
        
        $xxy = $this->bd->query_array('web_modelo',
            'nombre',
            'idmodelo='.$this->bd->sqlvalue_inyeccion($yy['id_modelo'],true)
            );
        
        $detalle =   trim($y['descripcion']) .' Color '.trim($y['color']).' '.trim($y['material']).' '.trim($y['dimension']) .' Modelo '. trim($xxy['nombre']) ;
        
 
		$valor = $y['costo_adquisicion']- $yy['valor_depreciacion'];
		
		if ($valor  < 0  ){
			 $valor = 0;
			}
        
        echo ' <tr>
                <td class="lado" >'.$i.'</td>
		    	<td class="lado" >'.$codigo.'</td>
                <td class="lado" >'.trim($detalle).'</td>
		        <td class="lado" >'.trim($y['anio_adquisicion']).'</td>
				<td class="lado" >'.trim($y['vida_util']).'</td>
                <td class="lado"> '. number_format($dias,0).' </td>
                <td class="lado" >'.number_format($y['costo_adquisicion'],2).'</td>
                <td class="lado" >'.$y['valor_residual'].'</td>
  				<td class="lado" >'.$yy['valor_depreciacion'].'</td>
				 <td class="lado" >'.number_format( $valor,2).'</td>
  		   </tr>';
        
        $i++;
        
        $total = $total + $y['costo_adquisicion'];
        $valor_depreciacion = $valor_depreciacion  + $y['valor_residual'];
        $valor_contable=  $valor_contable  + $y['valor_depreciacion'];
        
		 $valor1 =  $valor1 +  $valor ; 
        
        $cadena = $cadena .','.$id_bien;
    }
    
    $total              = number_format($total,2);
    $valor_depreciacion= number_format($valor_depreciacion,2);
    $valor_contable= number_format($valor_contable,2);
    
    
    echo ' <tr>
                 <td class="lado" > </td>
		    	 <td class="lado" > </td>
				 <td class="lado" > </td>
                 <td class="lado" > </td>
                  <td class="lado" > </td>
			       <td class="lado" > Total</td>
			     <td class="lado" >'.$total.' </td>
                 <td class="lado" >'.$valor_depreciacion.' </td>
  				 <td class="lado" >'.$valor_contable.'</td>
				  <td class="lado" >'.$valor1.'</td>
           </tr>';
    
    
    echo	'</table><h5>Informacion Adicional</h5>';
    
    
    pg_free_result($stmt1);
    
    $this->bien_componente_acta( $id ,$cadena);
    
    return $i;
    
}
	//---------------------------------
	function GrillaBienes($id){
 
  
	       $sql = 'SELECT *
                    FROM activo.view_acta_detalle
                    where id_acta= '.$this->bd->sqlvalue_inyeccion($id,true) .' order by clase,id_bien' ;

	    
	  
	       
	       echo ' <table id="table_detalle"  class="lado" cellspacing="0" width="90%" style="font-size: 9px"  >
			<thead>
			 <tr>
	           <th class="lado" width="5%">Nro.</th>
				<th class="lado" width="14%">Codigo</th>
				<th class="lado" width="10%">Referencia</th>
				<th class="lado" width="10%">Clase</th>
				<th class="lado" width="23%">Detalle Item</th>
                <th class="lado" width="10%">Serie</th>
                <th class="lado" width="4%">Estado</th>
				<th class="lado" width="10%">Adquisicion</th>
                <th class="lado" width="4%">Costo</th>
 				</tr>
			</thead>';
	       
	     
	       $stmt1           = $this->bd->ejecutar($sql);
 	     
	       $i = 1;
	       
	       $total = 0;
	       
		
		   $cadena = '';
	       while ($y=$this->bd->obtener_fila($stmt1)){

                 
       

			   $input = str_pad($y['id_bien'], 5, "0", STR_PAD_LEFT);
               
               $codigo =   trim($y['cuenta']).'-'. $input;   
			   
			   $id_bien = $y['id_bien'];


			   $yy = $this->bd->query_array('activo.view_bienes',   // TABLA
			   '*',                        // CAMPOS
			   'id_bien='.$this->bd->sqlvalue_inyeccion(  $id_bien,true) // CONDICION
				);


				$xxy = $this->bd->query_array('web_modelo',   
				'nombre',                        
				'idmodelo='.$this->bd->sqlvalue_inyeccion($yy['id_modelo'],true)  
				 );
               
				 $detalle =   trim($y['descripcion']) .' Color '.trim($y['color']).' '.trim($y['material']).' '.trim($y['dimension']) .' Modelo '. trim($xxy['nombre']) ;


	           echo ' <tr>
                <td class="lado" >'.$i.'</td>
		    	<td class="lado" >'.$codigo.'</td>
				<td class="lado" >'.trim($y['codigo_actual']).'</td>
				<td class="lado" >'.trim($y['clase']).'</td>
                <td class="lado" >'.trim($detalle).'</td>
                 <td class="lado" >'.$y['serie'].'</td>
                <td class="lado" >'.$y['estado_bien'].'</td>
				<td class="lado" >'.$yy['fecha_adquisicion'].'</td>
  				<td class="lado" >'.$y['costo_adquisicion'].'</td>
           </tr>';
	           
	           $i++;
	           
	           $total = $total + $y['costo_adquisicion']; 
			   
			   $cadena = $cadena .','.$id_bien;
 	       }
 
 	       echo ' <tr>
                 <td class="lado" > </td>
		    	 <td class="lado" > </td>
				 <td class="lado" > </td>
                 <td class="lado" > </td>
                  <td class="lado" > </td>
			     <td class="lado" > </td>
			     <td class="lado" > </td>
                 <td class="lado" >Total </td>
  				 <td class="lado" >'.$total.'</td>
           </tr>';
	  
 
	       echo	'</table><h5>Informacion Adicional</h5>';
		
		
			pg_free_result($stmt1);
      
		   $this->bien_componente_acta( $id ,$cadena);
		
	       return $i;
	    
	}
	//--------------------------------
	function ComponentesBienes($id){
	    
	    
	    $sql = 'SELECT estado, id_acta_det,  id_bien, sesion, creacion, marca, tipo, tipo_bien,
	                      descripcion, serie, estado_bien, costo_adquisicion, clasificador, clase
                    FROM activo.view_acta_detalle
                    where id_acta= '.$this->bd->sqlvalue_inyeccion($id,true) .' order by clase,id_bien' ;
	    
	    $stmt1           = $this->bd->ejecutar($sql);
	    
	    $nexiste = 0;
	    
	    while ($y=$this->bd->obtener_fila($stmt1)){
	        
	        $id_bien = $y['id_bien'] ;
	        
	        $AResultado = $this->bd->query_array('activo.view_bienes_componente',
	                                             'count(*) as nn', 
	                                             'id_bien='.$this->bd->sqlvalue_inyeccion($id_bien,true)
	            );
	        
	        $nexiste = $nexiste + $AResultado['nn'] ;
	        
	    }
 
	    
	    
	    
	    
	    if ( $nexiste > 0  ){
	        
	        $stmt2          = $this->bd->ejecutar($sql);
	        
	        echo ' <h3>ANEXO COMPONENTES BIENES ASIGNADOS </h3>';
	        
	        while ($yy=$this->bd->obtener_fila($stmt2)){
	            
	            $id_bien     = $yy['id_bien'] ;
	            $descripcion = trim($yy['descripcion']) ;
	            
	            $apone = $this->bd->query_array('activo.view_bienes_componente',
	                'count(*) as nn',
	                'id_bien='.$this->bd->sqlvalue_inyeccion($id_bien,true)
	                );
	            
	            $nexiste1 = $apone['nn'] ;
	            
	            if ( $nexiste1 > 0  ){
	            
	                echo ' <h5>'.$id_bien.' ('.trim($yy['tipo_bien']) .') '.$descripcion.' </h5>';
	            
	            
	            
	            echo ' <table  class="lado" cellspacing="0" width="90%" style="font-size: 9px"  >
        			<thead>
        			 <tr>
        	            <th class="lado" width="10%">Nro.</th>
        			    <th class="lado" width="50%">Detalle</th>
        				<th class="lado" width="20%">Marca</th>
        			    <th class="lado" width="10%">Estado</th>
                        <th class="lado" width="10%">Costo</th>
         				</tr>
        			</thead>';
	            
	               $sqlcompo = 'SELECT  detalle_componente, marca, costo_componente,   evento
                    FROM activo.view_bienes_componente
                    where id_bien= '.$this->bd->sqlvalue_inyeccion($id_bien,true)  ;
	            
	               $stmt11           = $this->bd->ejecutar($sqlcompo);
	               
	               $i = 1;
	               
	               while ($xy=$this->bd->obtener_fila($stmt11)){
	                   echo ' <tr>
                            <td class="lado" >'.$i.'</td>
            		    	<td class="lado" >'.$xy['detalle_componente'].'</td>
                            <td class="lado" >'.$xy['marca'].'</td>
                            <td class="lado" >'.$xy['evento'].'</td>
                            <td class="lado" >'.$xy['costo_componente'].'</td>
                       </tr>';
	                   
	                   $i++;
	                   
	               }
	               
	                echo	'</table>';
	            }
	        }
	    }
	    
	 
	    
	}
	//-----------------------------------
	function GrillaBienesMaster($id){
	    
	    
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
	//----------------
	function GrillaDetalleDepre_01($id){
	    
	    
	    
	    $sql = "SELECT  id_bien_dep, id_bien,cuenta,     descripcion, costo,vresidual,   vidautil,
                        anio_bien || '  ' AS anio_bien,
                        cuotadp, diferencia ,acumulado,fecha_adquisicion,valor_periodo
        FROM activo.view_bienes_depre
                where   id_bien_dep = ".$this->bd->sqlvalue_inyeccion($id,true)." order by descripcion";
	    
	    
	    $resultado    =  $this->bd->ejecutar($sql);
	    
	    echo '<table border="0" cellpadding="0" cellspacing="0" style="font-size:9px" >
            <thead>
                <tr>
                     <th width="5%" style= "border: 1px solid #ccc;border-collapse: collapse;padding: 3px" align="center">Nro.Bien</th>
                     <th width="5%" style= "border: 1px solid #ccc;border-collapse: collapse;padding: 3px" align="center">Cuenta</th>
                     <th width="30%" style= "border: 1px solid #ccc;border-collapse: collapse;padding: 3px" align="center">Detalle</th>
                      <th width="5%" style= "border: 1px solid #ccc;border-collapse: collapse;padding: 3px" align="center">Vida Util</th> 
                     <th width="5%" style= "border: 1px solid #ccc;border-collapse: collapse;padding: 3px" align="center">Anio</th>
                      <th width="5%" style= "border: 1px solid #ccc;border-collapse: collapse;padding: 3px" align="center">Dias utilizacion</th>
                     <th width="10%" style= "border: 1px solid #ccc;border-collapse: collapse;padding: 3px" align="center">Adquisicion</th>
                     <th width="5%" style= "border: 1px solid #ccc;border-collapse: collapse;padding: 3px" align="center">Costo Bien</th>
                     <th width="10%" style= "border: 1px solid #ccc;border-collapse: collapse;padding: 3px" align="center">Depreciacion Acumulada</th>
                     <th width="10%" style= "border: 1px solid #ccc;border-collapse: collapse;padding: 3px" align="center">Diferencia </th>
					 <th width="10%" style= "border: 1px solid #ccc;border-collapse: collapse;padding: 3px" align="center">Depreciacion Periodo </th>
                    </tr>
            </thead><tbody>';
	    
	    
	    
	    $a=0;
		$b=0;
		$c=0;
		$d=0;
	    
	    
	    while($row=pg_fetch_assoc ($resultado)) {
	        
	        
	        $cadena =  $row['anio_bien'];
	        $entero = intval($cadena);
	        
	        
	        $cadena1 =  $row['acumulado'];
	        $entero1 = intval($cadena1);
	        
	        
	       echo '<tr>
              <td  style= "border: 1px solid #ccc;border-collapse: collapse;padding: 3px" align="center">'.$row['id_bien'].' </td>
              <td style= "border: 1px solid #ccc;border-collapse: collapse;padding: 3px" >'. $row['cuenta'].' </td>
              <td style= "border: 1px solid #ccc;border-collapse: collapse;padding: 3px" > <b>'. $row['descripcion'].' </b></td>
              <td style= "border: 1px solid #ccc;border-collapse: collapse;padding: 3px" align="right"> '. $row['vidautil'].' </td>
              <td style= "border: 1px solid #ccc;border-collapse: collapse;padding: 3px" align="right"> '. $entero.' </td>
              <td style= "border: 1px solid #ccc;border-collapse: collapse;padding: 3px" align="right">'. $row['acumulado'].' </td>
              <td style= "border: 1px solid #ccc;border-collapse: collapse;padding: 3px" align="right">'. $row['fecha_adquisicion'].' </td>
              <td style= "border: 1px solid #ccc;border-collapse: collapse;padding: 3px" align="right"> '. $row['costo'].' </td>
              <td style= "border: 1px solid #ccc;border-collapse: collapse;padding: 3px" align="right"> '. $row['cuotadp'].' </td>
              <td style= "border: 1px solid #ccc;border-collapse: collapse;padding: 3px" align="right"> '. $row['diferencia'].' </td>
              <td style= "border: 1px solid #ccc;border-collapse: collapse;padding: 3px" align="right"> '. $row['valor_periodo'].' </td>
             </tr>';
			
			 $a= $row['costo'] + $a;
		     $b= $row['cuotadp']    + $b;
		     $c= $row['diferencia'] + $c;
			 $d= $row['valor_periodo'] + $d;
			
			
	    }
	    
		
		 echo '<tr>
             <td>&nbsp;</td>
             <td>&nbsp;</td>
             <td>&nbsp;</td>
             <td>&nbsp;</td>
			 <td>&nbsp;</td>
			  <td>&nbsp;</td>
              <td style= "border: 1px solid #ccc;border-collapse: collapse;padding: 3px" align="right">Resumen  </td>
			  <td style= "border: 1px solid #ccc;border-collapse: collapse;padding: 3px" align="right"> <b> '.number_format($a,2) .' </b> </td>
              <td style= "border: 1px solid #ccc;border-collapse: collapse;padding: 3px" align="right"> <b>'. number_format($b,2) .' </b> </td>
              <td style= "border: 1px solid #ccc;border-collapse: collapse;padding: 3px" align="right"> <b>'.number_format($c,2) .'  </b></td>
			    <td style= "border: 1px solid #ccc;border-collapse: collapse;padding: 3px" align="right"> <b>'.number_format($d,2) .'  </b></td>
            
           
             </tr>';
		
	    echo "</tbody></table>";
	    
	}	
	///--------------------------
	function GrillaDetalleDepre($id){
	    
	    
	    
	    $sql = "SELECT  id_bien_dep, id_bien,cuenta,     descripcion, costo,vresidual,   vidautil,
                        anio_bien || '  ' AS anio_bien,
                        cuotadp, diferencia ,acumulado
        FROM activo.view_bienes_depre
                where   id_bien_dep = ".$this->bd->sqlvalue_inyeccion($id,true)." order by descripcion";
	    
	    
	    $resultado    =  $this->bd->ejecutar($sql);
	    
	    echo '<table class="tablaDet"   style="font-size:9px" >
            <thead>
                <tr>
                     <th width="5%" style="padding: 3px" align="center" rowspan="2">Nro.Bien</th>
                     <th width="40%" style="padding: 3px" align="center" rowspan="2">Detalle</th>
                     <th colspan="3" style="padding: 3px" align="center">Costo Bien</th>
                     <th colspan="2" style="padding: 3px" align="center">Costo Proporcional Depreciacion</th>
                     <th width="10%"  style="padding: 3px" align="center" rowspan="2">C = (A) - (B)</th>
                     <th width="10%" style="padding: 3px" align="center" rowspan="2">Dias utilizacion</th>
                    </tr>
				 <tr>
                     <th align="center" style="padding: 3px" width="10%">(A) Costo</th>
                     <th align="center" style="padding: 3px" width="5%">Residual</th>
                     <th align="center" style="padding: 3px" width="5%">Vida Util</th>
                     <th align="center" style="padding: 3px" width="5%">Anio</th>
                     <th align="center" style="padding: 3px" width="10%">(B) CDP</th>
                    </tr>
            </thead><tbody>';
	    
	    
	    
	    
	    
	    
	    while($row=pg_fetch_assoc ($resultado)) {
	        
	        
	        $cadena =  $row['anio_bien'];
	        $entero = intval($cadena);
	        
	        
	        $cadena1 =  $row['acumulado'];
	        $entero1 = intval($cadena1);
	        
	        
	        echo '<tr>
             <td style="padding: 3px">'.$row['id_bien'].' </td>
             <td> <b>'. $row['descripcion'].' </b></td>
             <td> '. $row['costo'].' </td>
             <td> '. $row['vresidual'].' </td>
            <td> '. $row['vidautil'].' </td>
             <td> '. $entero.' </td>
              <td> '. $row['cuotadp'].' </td>
              <td> '. $row['diferencia'].' </td>
             <td> '. $entero1.' </td>
             </tr>';
	    }
	    
	    echo "</tbody></table>";
	    
	}	
//-----------
function GrillaCompromisoTra($id){
	    
	    
 
  
	$sql = 'SELECT actividad,fuente,clasificador,detalle, iva, base, certificado,dactividad,dfuente,compromiso,partida
			 FROM presupuesto.view_certificacionesd
			 where id_tramite= '.$this->bd->sqlvalue_inyeccion($id,true)  ;


	
	echo ' <table id="table_detalle" class="lado" cellspacing="0" width="90%" style="font-size: 9px"  >
	 <thead>
	  <tr>
		 <th class="lado" width="20%">Partida</th>
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
		 <td class="lado" >'.$y['partida'].'</td>
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

	 
 
}	

//--------------------------	
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
	    
 
	    $name    = $_SESSION['razon'] ;
	    $elaborador = $_SESSION['login'];
 	    
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
	    
	 //   $logopath = 'logo_qr.png';
	    $QR = imagecreatefrompng($filepath);
	    
	    // START TO DRAW THE IMAGE ON THE QR CODE
	    
	 //     $logo = imagecreatefromstring(file_get_contents($logopath));
	    

	     /*  Fix for the transparent background
	   
	   
	    imagecolortransparent($logo , imagecolorallocatealpha($logo , 0, 0, 0, 127));
	    imagealphablending($logo , false);
	    imagesavealpha($logo , true);  
	  
	    $QR_width = imagesx($QR);
	    $QR_height = imagesy($QR);
 	    $logo_width = imagesx($logo);
	    $logo_height = imagesy($logo);*/
	    
	    // Scale logo to fit in the QR Code
	 /*  $logo_qr_width = $QR_width/3;
	    $scale = $logo_width/$logo_qr_width;
	    $logo_qr_height = $logo_height/$scale;
	    
	    imagecopyresampled($QR, $logo, $QR_width/3, $QR_height/3, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);*/
	    
	    // Save QR code again, but with logo on it
	    imagepng($QR,$filepath);
 	    
	}
	
	function firmas( ){
	    
	    
	    $a11 = $this->bd->query_array('wk_config','carpeta, carpetasub,modulo', 'tipo='.$this->bd->sqlvalue_inyeccion(10,true));
	    
	    $a12 = $this->bd->query_array('wk_config','carpeta, carpetasub,modulo', 'tipo='.$this->bd->sqlvalue_inyeccion(12,true));
	    
	    $a14 = $this->bd->query_array('wk_config','carpeta, carpetasub,modulo', 'tipo='.$this->bd->sqlvalue_inyeccion(11,true));
	    
	    $a15 = $this->bd->query_array('wk_config','carpeta, carpetasub,modulo', 'tipo='.$this->bd->sqlvalue_inyeccion(15,true));
	    
	    $a20 = $this->bd->query_array('wk_config','carpeta, carpetasub,modulo', 'tipo='.$this->bd->sqlvalue_inyeccion(20,true));
	    
	    $datos["g10"] = $a11["carpeta"];
	    $datos["g11"] = $a11["carpetasub"];
	    
	    
	    $datos["f10"] = $a12["carpeta"];
	    $datos["f11"] = $a12["carpetasub"];
	    
	    
	    $datos["c10"] = $a14["carpeta"];
	    $datos["c11"] = $a14["carpetasub"];
	    
	    $datos["c10"] = $a14["carpeta"];
	    $datos["c11"] = $a14["carpetasub"];
	    
	    $datos["a10"] = $a15["carpeta"];
	    $datos["a11"] = $a15["carpetasub"];
	    
	    $datos["b10"] = $a20["carpeta"];
	    $datos["b11"] = $a20["carpetasub"];
		$datos["b12"] = $a20["modulo"];
	    
	    return $datos;
	    
	  
	}


	function RESUMEN_BIENES( ){
        
        echo '<h3><b>Bienes Larga Duracion</b></h3>';
        
        $xx = $this->bd->query_array('activo.view_bienes',
            'count(*) as nn',
            'uso  <> '.$this->bd->sqlvalue_inyeccion( 'Baja',true)." and tipo_bien = 'BLD'"
            );
        
        
        $sql = "select cuenta ,nombre_cuenta,count(*) as bienes,sum(costo_adquisicion) as total
			from activo.view_bienes where uso <> 'Baja' and tipo_bien = 'BLD'
			group by cuenta ,nombre_cuenta order by 3 desc"   ;

			$estilo = 'style="border-collapse: collapse; border: 1px solid #AAAAAA;font-size: 12px;text-align: center;padding: 5px"';

			$estilo1 = 'style="border-collapse: collapse; border: 1px solid #AAAAAA;font-size: 12px;text-align: left;padding: 5px"';
      
			echo  '<table  width="95%" style="font-size: 10px">
			<tr>
			<th '.$estilo.' bgcolor="lightblue" width="65%">Grupo</th>
			<th '.$estilo.' bgcolor="lightblue" width="10%">Costo</th>
			<th '.$estilo.' bgcolor="lightblue" width="10%">Nro.Items</th>
			<th '.$estilo.' bgcolor="lightblue" width="10%">%</th>
			</tr>'	;
			
        
		$resultado= $this->bd->ejecutar($sql);
         
        while ($y=$this->bd->obtener_fila($resultado)){
            
            $detalle     =  trim($y['cuenta']).' '. trim($y['nombre_cuenta']);
    		 $p 			 = round(($y['bienes'] / $xx['nn']) * 100,2);
            $porcentaje  = $p.' %';
            $total_grupo =  number_format($y['total'],2);
		 
            
             echo '<tr>
		    	<td '.$estilo1 .' >'.$detalle.'</td>
				<td '.$estilo1 .' >'.$total_grupo.'</td>
	            <td '.$estilo1 .' >'.$y['bienes'].'</td>
                <td '.$estilo1 .' >'.$porcentaje.'</td> <tr>';
            
 
        }
         
        
		echo '</table>';
        
         
 
        echo '<h3><b>Bienes Sujetos a Control</b></h3>';
        
       $this->consultaIdBCA( );
        
    }
 

	  ///----------------------
	  function consultaIdBCA( ){
        
        
        $xx = $this->bd->query_array('activo.view_bienes',
            'count(*) as nn',
            'uso  <> '.$this->bd->sqlvalue_inyeccion( 'Baja',true)." and tipo_bien = 'BCA'"
            );
        
        
        $sql = "select cuenta ,nombre_cuenta,count(*) as bienes,sum(costo_adquisicion) as total
			from activo.view_bienes where uso <> 'Baja' and tipo_bien = 'BCA'
			group by cuenta ,nombre_cuenta order by 3 desc"   ;
        
        
        $resultado1= $this->bd->ejecutar($sql);
        
		$estilo = 'style="border-collapse: collapse; border: 1px solid #AAAAAA;font-size: 12px;text-align: center;padding: 5px"';

		$estilo1 = 'style="border-collapse: collapse; border: 1px solid #AAAAAA;font-size: 12px;text-align: left;padding: 5px"';

		echo  '<table  width="95%" style="font-size: 10px">
        <tr>
        <th '.$estilo.' bgcolor="lightblue" width="65%">Grupo</th>
        <th '.$estilo.' bgcolor="lightblue" width="10%">Costo</th>
        <th '.$estilo.' bgcolor="lightblue" width="10%">Nro.Items</th>
        <th '.$estilo.' bgcolor="lightblue" width="10%">%</th>
        </tr>'	;
        
         
        while ($y=$this->bd->obtener_fila($resultado1)){
            
            $detalle =  trim($y['cuenta']).' '. trim($y['nombre_cuenta']);
            
            $p = round(($y['bienes'] / $xx['nn']) * 100,2);
            
            $porcentaje = $p.' %';
            
            
            $total_grupo =  number_format($y['total'],2);
            
            echo '<tr>
		    	<td '.$estilo1 .' >'.$detalle.'</td>
				<td '.$estilo1 .' >'.$total_grupo.'</td>
	            <td '.$estilo1 .'  >'.$y['bienes'].'</td>
                <td '.$estilo1 .'  >'.$porcentaje.'</td> <tr>';
            
            
        }
        
        
        echo '</table>';
        
  
        
        
    }

}

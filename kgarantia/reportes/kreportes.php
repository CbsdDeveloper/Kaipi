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
	//---------------------
	function ficha_combustible($codigo){
		
	    //--- beneficiario
	    $sql = "SELECT  *
                    FROM adm.view_comb_vehi
                   where id_combus = ".$this->bd->sqlvalue_inyeccion($codigo,true);
	    
	    $resultado_cab = $this->bd->ejecutar($sql);
	    $datos         = $this->bd->obtener_array( $resultado_cab);
	    
	    
	    $Auser = $this->bd->query_array('par_usuario',
	        'completo',
	        'login='.$this->bd->sqlvalue_inyeccion(trim($this->sesion) ,true)
	        );
	    
	    
	    $datos['elaborado'] = $Auser['completo'] ;
		        
		    
		 
		return $datos;
	}
	function ficha_combustible_in($codigo){
		
	    //--- beneficiario
	    $sql = "SELECT  *
                    FROM adm.view_comb_vehi_in
                   where id_combus = ".$this->bd->sqlvalue_inyeccion($codigo,true);
	    
	    $resultado_cab = $this->bd->ejecutar($sql);
	    $datos         = $this->bd->obtener_array( $resultado_cab);
	    
	    
	    $Auser = $this->bd->query_array('par_usuario',
	        'completo',
	        'login='.$this->bd->sqlvalue_inyeccion(trim($this->sesion) ,true)
	        );
	    
	    
	    $datos['elaborado'] = $Auser['completo'] ;
		        
		    
		 
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
	function ficha_orden($codigo){
	    
	    //--- beneficiario
	    $sql = "SELECT  *
                    FROM adm.view_adm_orden
                   where id_orden = ".$this->bd->sqlvalue_inyeccion($codigo,true);
 	    
	    $resultado_cab = $this->bd->ejecutar($sql);
	    $datos         = $this->bd->obtener_array( $resultado_cab);
	    
	    
	    $Auser = $this->bd->query_array('par_usuario',
	        'completo',
	        'login='.$this->bd->sqlvalue_inyeccion(trim($this->sesion) ,true)
	        );
	    
	    
	    $datos['elaborado'] = $Auser['completo'] ;
	    
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
        where id_bien = ".$this->bd->sqlvalue_inyeccion($idbien,true) ." and
              evento=".$this->bd->sqlvalue_inyeccion( 'Nuevo',true)  ;
 
	    
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
	//-------
	function BienesParametrosTramite($tramite,$factura ,$ruc){
	    
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
	       $factura = 'A�o';
	       $costo = 'Avaluo';
	       
	    }else{
	        $titulo = 'IDENTIFICACION DEL BIEN';
	        $marca  = 'Marca';
	        $modelo  = 'Modelo';
	        
	        $serie   = 'Serie';
	        $uso     = 'Uso';
	        
	        $titulo1 ='REFERENCIA DE LA ADQUISICION';
	        
	        $proveedor = 'Proveedor';
	        $factura = 'Factura';
	        $costo = 'Costo';
	        
	    }
	    
	    $estilo = 'style="padding: 3px" ';
	    echo '<table style="border-collapse: collapse; border: 1px solid #AAAAAA;font-weight: normal;font-size: 10px" border="0" width="100%" cellspacing="0" >
	             <tr>  <td colspan="4" bgcolor="#EDEDED" style="font-weight: normal;font-size: 11px;padding: 6px">2. '.$titulo.'  </td> </tr>
				 
                  <tr>
				     <td colspan="4" style="font-weight: normal;font-size: 11px;padding: 5px"><b>'.$datos['descripcion'].'</b></td>
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
    				   <td '.$estilo.' >  </td>
    				   <td '.$estilo.' >  </td>
			      </tr>
				  <tr>
				      <td colspan="4"   bgcolor="#EDEDED" style="font-weight: normal;font-size: 11px;padding: 6px">4. IDENTIFICACION RESPONSABLE</td>
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
				      <td colspan="4"   bgcolor="#EDEDED" style="font-weight: normal;font-size: 11px;padding: 6px">5. GARANTIAS</td>
			       </tr> 
                   <tr>
    				   <td '.$estilo.' >Garantia?</td>
    				   <td '.$estilo.' >'.trim($datos['garantia']).'</td>
    				   <td '.$estilo.' > Tiempo</td>
    				   <td '.$estilo.' >'.trim($datos['tiempo_garantia']).' Mes(es)'.'</td>
			      </tr>
			   </table> ';
	 
	}
	
	//---------------------------------
	function GrillaBienes($id){
 
  
	       $sql = 'SELECT estado, id_acta_det,  id_bien, sesion, creacion, marca, tipo, tipo_bien, 
	                      descripcion, serie, estado_bien, costo_adquisicion, clasificador, clase ,cuenta
                    FROM activo.view_acta_detalle
                    where id_acta= '.$this->bd->sqlvalue_inyeccion($id,true) .' order by clase,id_bien' ;

	       
	  
	       
	       echo ' <table id="table_detalle"  class="lado" cellspacing="0" width="90%" style="font-size: 9px"  >
			<thead>
			 <tr>
	           <th class="lado" width="5%">Nro.</th>
				<th class="lado" width="14%">Codigo</th>
				<th class="lado" width="15%">Clase</th>
				<th class="lado" width="20%">Detalle Item</th>
                <th class="lado" width="10%">Marca</th>
                <th class="lado" width="10%">Serie</th>
                <th class="lado" width="8s%">Estado</th>
                <th class="lado" width="8%">Costo</th>
 				</tr>
			</thead>';
	       
	     
	       $stmt1           = $this->bd->ejecutar($sql);
 	     
	       $i = 1;
	       
	       while ($y=$this->bd->obtener_fila($stmt1)){
	            
 
	           
               $detalle =   trim($y['descripcion']) ;
	           
 
             //  $codigo =   trim($y['tipo_bien']).'-'.trim($y['cuenta']).'-'.$y['id_bien'];   
               
               
               $codigo =   trim($y['tipo_bien']).'-'.$y['id_bien'];   
               
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
	           
 	       }
 
	      
	  
 
	       echo	'</table>';
      
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
	    
	    
	    $a11 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(10,true));
	    
	    $a12 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(12,true));
	    
	    $a14 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(11,true));
	    
	    $a15 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(15,true));
	    
	    $a20 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(20,true));
	    
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
	    
	    return $datos;
	    
	  
	}
	
	
	function pie_rol($cliente, $datos,$tipo ){
	    
	    
	  
	    
	   // $sesionm = $datos[];
	    
	    //------------- llama a la tabla de parametros ---------------------//
	    
	    $reporte_pie   = $this->bd->query_array('par_reporte', 'pie', 'referencia='.$this->bd->sqlvalue_inyeccion( trim($cliente) ,true) );
	    
	    $pie_contenido = $reporte_pie["pie"];
 
	    
	    
	    $pie_contenido = str_replace('#FECHA_ABASTECIMIENTO',trim($datos['fecha_modifica']), $pie_contenido);
	    
	    $pie_contenido = str_replace('#FEMISION',trim($datos['fecha']), $pie_contenido);
	    
	    
	    $pie_contenido = str_replace('#REFERENCIA',trim($datos['referencia']), $pie_contenido);
	    
	    $pie_contenido = str_replace('#RESPONSABLE',trim($datos['razon']), $pie_contenido);
	    
	    $pie_contenido = str_replace('#OPERADOR',trim($datos['razon']), $pie_contenido);
	    $pie_contenido = str_replace('#CARGO',trim($datos['cargo']), $pie_contenido);
	    
	    $pie_contenido = str_replace('#MARCA',trim($datos['marca']), $pie_contenido);
	    
	    $pie_contenido = str_replace('#PLACA',trim($datos['placa_ve']), $pie_contenido);
	    
	    $pie_contenido = str_replace('#CARRO_CODIGO',trim($datos['codigo_veh']), $pie_contenido);
	    
	    $pie_contenido = str_replace('#KM',trim($datos['u_km']), $pie_contenido);
	    
	    $pie_contenido = str_replace('#CODIGO',trim($datos['id_combus']), $pie_contenido);
	    
	    $pie_contenido = str_replace('#DETALLE',trim($datos['tipo_comb']), $pie_contenido);
	    
		  $pie_contenido = str_replace('#MEDIDA',trim($datos['medida']), $pie_contenido);
	    
		
	   	  $pie_contenido = str_replace('#CANECA',trim($datos['cantidad_ca']), $pie_contenido);
		
	    $pie_contenido = str_replace('#CANTIDAD',round($datos['cantidad'],2), $pie_contenido);
	    
	    $pie_contenido = str_replace('#UNIDAD',$datos['unidad'], $pie_contenido);
 
	    $pie_contenido = str_replace('#FUNCIONARIO',$datos['elaborado'], $pie_contenido);
	    
	    $pie_contenido = str_replace('#UNITARIO',round($datos['costo'],4), $pie_contenido);
	    
	    if ( $tipo == 1)
	        $pie_contenido = str_replace('#TIPO','ORIGINAL', $pie_contenido);
	    else
	        $pie_contenido = str_replace('#TIPO','COPIA', $pie_contenido);
	    
	    
	    $TOTAL = $datos['costo'] * $datos['cantidad'];
	    
	    $pie_contenido = str_replace('#TOTAL',$TOTAL, $pie_contenido);
	    
	    
	    echo $pie_contenido ;
	    
	}
}

?>
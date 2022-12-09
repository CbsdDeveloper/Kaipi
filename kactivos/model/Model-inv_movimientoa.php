<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/

class proceso{
	
	//creamos la variable donde se instanciar la clase "mysql"
	
	private $obj;
	private $bd;
	
	private $ruc;
	public  $sesion;
	public  $hoy;
	private $POST;
	private $ATabla;
	private $tabla ;
	private $secuencia;
	
	private $estado_periodo;
	
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function proceso( ){
 
		$this->obj     = 	new objects;
		$this->bd	   =	new Db ;
		$this->set     = 	new ItemsController;
		
		$this->ruc       =     trim($_SESSION['ruc_registro']);
		
		$this->sesion 	 =     trim($_SESSION['email']);
		
		$this->hoy 	     =     date("Y-m-d");    	//$this->hoy 	     =  $this->bd->hoy();
		
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
		
	 
		
	}
	 
	
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function div_limpiar( ){
		//inicializamos la clase para conectarnos a la bd
		
		$resultado = '';
		
		echo '<script type="text/javascript">';
		
		echo  'LimpiarPantalla();';
		
		echo '</script>';
		
		return $resultado;
		
	}
	
	
	
	//--------------------------------------------------------------------------------
	//--- busqueda de por codigo para llenar los datos
	//--------------------------------------------------------------------------------
	function consultaId($accion,$id,$factura,$ruc ){
 
		$qquery = array(  
		    array( campo => 'factura',   valor =>trim($factura),  filtro => 'S',   visor => 'S'),
		    array( campo => 'fecha_adquisicion',   valor => '-',  filtro => 'N',   visor => 'S'),
		    array( campo => 'idproveedor',   valor => trim($ruc),  filtro => 'S',   visor => 'S'),
 		    array( campo => 'proveedor',   valor => '-',  filtro => 'N',   visor => 'S'),
		    array( campo => 'cantidad',   valor => '-',  filtro => 'N',   visor => 'S'),
		    array( campo => 'costo',   valor => '-',  filtro => 'N',   visor => 'S'),
 		    array( campo => 'id_tramite',   valor => '-',  filtro => 'N',   visor => 'S')
  		);
		
		
		$datos = $this->bd->JqueryArrayVisorDato('activo.view_bienes_tramite',$qquery );
		
	 
		
		$this->set->div_panel6('DETALLE DE ADQUISICION - COMPRA');
		
		      echo '<h5>Nro.Factura <b>'.$datos['factura'].'</b><br>';
		      echo 'Identificacion  <b>'.$datos['idproveedor'].'</b><br>';
		      echo 'Proveedor  <b>'.$datos['proveedor'].'</b><br><br>';
		      
		      echo 'Fecha Compra  <b>'.$datos['fecha_adquisicion'].'</b><br>';
		      
		      echo 'Nro.Bienes  <b>'.$datos['cantidad'].'</b><br>';
		      echo 'Costo  <b>'.$datos['costo'].'</b><br>';
		      
		      
		      echo '</h5>';
		
		$this->set->div_panel6('fin');
		
		$id_tramite = $datos['id_tramite']; 
		
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
		
		$this->set->div_panel6('DETALLE ADMINISTRATIVO -  FINANCIERO');
	 	
		
		echo '<h5>Nro.Tramite  <b>'.$datos['id_tramite'].' </b><br>';
		echo 'Fecha  <b>'.$datos['fecha'].'</b><br>';
		echo 'Detalle  <b>'.$datos['detalle'].'</b><br><br>';
		
		echo 'Solicita  <b>'.$datos['unidad'].'</b><br>';
		
		echo 'Fecha Certificacion  <b>'.$datos['fcertifica'].'</b><br>';
		echo 'Nro.Comprobante  <b>'.$datos['comprobante'].'</b><br>';
		
 
		
		echo '</h5>';
	 
 
	 	
		$this->set->div_panel6('fin');
		
		
		$this->set->div_panel12('DETALLE BIENES');
 		
		$SQL = "SELECT  cuenta || ' - '|| lpad(cast(id_bien as varchar),5,'0') as bien  ,
                        tipo_bien,   forma_ingreso,  
                        clase_esigef || ' ' as clase_esigef,
		                identificador || '  ' as identificador, 
                         descripcion,   marca ,serie ,costo_adquisicion
		FROM activo.view_bienes
		where idproveedor= ".$this->bd->sqlvalue_inyeccion(trim($ruc),true)." and 
              id_tramite= ".$this->bd->sqlvalue_inyeccion($id_tramite,true)." and 
              factura =".$this->bd->sqlvalue_inyeccion(trim($factura),true)." order by id_bien ";
		
		
		
		$tipo      = $this->bd->retorna_tipo();
		$resultado = $this->bd->ejecutar($SQL);
	 	    
		    
		$this->obj->table->KP_sumatoria(9,8) ;
		
		$this->obj->table->table_basic_js($resultado, // resultado de la consulta
		        $tipo,      // tipo de conexoin
		        '',         // icono de edicion = 'editar'
		        '',			// icono de eliminar = 'del'
		        '' ,        // evento funciones parametro Nombnre funcion - codigo primerio
		        "Codigo Bien,Tipo,Forma Ingreso,Clase, Identificador,Descripcion,Marca,Serie,Costo" , // nombre de cabecera de grill basica,
		        '11px',      // tamaño de letra
		        'id92'         // id
		        );
  
		
		$this->set->div_panel12('fin');
 
		$this->set->div_panel12('RECORRIDO DEL TRAMITE');
		
		$this->flujo_tramite($id_tramite );
		
		$this->set->div_panel12('fin');
		 
		
 	}
//-----------------
 	function flujo_tramite($id ){
 	    
 	    
 	    ///----------- tramite presupuestario...----------------------------
 	    $x = $this->bd->query_array('presupuesto.view_pre_tramite','id_tramite, fecha,
                                            detalle, observacion, comprobante, estado,  documento,   planificado,
                                            solicita, unidad, user_crea,   user_asig, user_sol, control,sesion_control,
                                            proveedor,  telefono, correo, movil, fcompromiso, fcertifica, fdevenga,   estado_presupuesto',
 	        'id_tramite='.$this->bd->sqlvalue_inyeccion($id,true)
 	        );
 	    
 	    //------------------ tramite contable -------------------
 	    $xy = $this->bd->query_array('co_asiento','fecha, detalle,  sesion,  comprobante,id_asiento',
 	        'id_tramite='.$this->bd->sqlvalue_inyeccion($id,true)
 	        );
 	    
 	    //------------------ tramite pagado  -------------------
 	    $yy = $this->bd->query_array('co_asiento','fecha, detalle,  sesion,  comprobante,id_asiento',
 	        'id_asiento_ref='.$this->bd->sqlvalue_inyeccion($xy['id_asiento'],true)
 	        );
 	    //------------------ tramite control  -------------------
 	    $yz = $this->bd->query_array('co_control','fecha, detalle,  motivo,  tipo,sesion',
 	        'idtramite='.$this->bd->sqlvalue_inyeccion($id,true)
 	        );
 	    //------------------ tramite anexos  -------------------
 	    $zz = $this->bd->query_array('co_compras','id_compras, id_asiento, fecharegistro,  idprov, detalle,sesion',
 	        'id_tramite='.$this->bd->sqlvalue_inyeccion($id,true)
 	        );
 	    
 	    
 	    
 	    $detalle      = trim($x['detalle'] );
 	    $fecha_texto  =  $x['fecha'] ;
 	    $fecha_texto1 =  $x['fcertifica'] ;
 	    $fecha_texto2 =  $x['fcompromiso'] ;
 	    
 	    
 	    $tabla_cabecera =  '<table width="100%" class="table1" border="0" cellspacing="0" cellpadding="0"> '.'<tr>
                            <td class="derecha" width="5%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1"></td>
                            <td class="derecha" width="50%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Detalle</td>
                            <td class="derecha" width="15%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Fecha</td>
                            <td class="derecha" width="20%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Responsable </td>
                            </tr>';
 	    
 	    
 	    
 	    echo $tabla_cabecera;
 	    
 	    $numero3        = ' <img src="../../kimages/tab_inicio.png">';
 	    $sesion_nombre  =   trim($x['user_sol']);
 	    
 	    $this->flujo_tramite_det($numero3,'<b>1. '.$detalle.'</b>',$fecha_texto,strtoupper($sesion_nombre));
 	    
 	    $numero3        = ' <img src="../../kimages/tab_tarea_b.png">';
 	    $detalle        = '2. Emision de Certificacion presupuestaria '. trim($x['comprobante']);
 	    $sesion_nombre  =   trim($x['user_crea']);
 	    $this->flujo_tramite_det($numero3,'<b>'.$detalle.'</b>',$fecha_texto1,strtoupper($sesion_nombre));
 	    
 	    $numero3        = ' <img src="../../kimages/tab_condicion.png">';
 	    $detalle        = '3. Proceso de Contratacion Publica '. trim($x['comprobante']);
 	    $sesion_nombre  = 'Unidad Administrativa';
 	    $this->flujo_tramite_det($numero3,'<b>'.$detalle.'</b>',$fecha_texto1,strtoupper($sesion_nombre));
 	    
 	    
 	    //-------------- proveedor  ------------------------
 	    
 	    if ($x['proveedor']){
 	        $numero3        = ' <img src="../../kimages/1480249187.png" align="absmiddle" >';
 	        $detalle        = $numero3.'  Proveedor adjudicado '. trim($x['proveedor']);
 	        $sesion_nombre  =  $x['user_asig'];
 	        $fecha_texto3   =  $x['fcompromiso'] ;
 	    }else{
 	        $numero3        = ' <img src="../../kimages/ok_no.png" align="absmiddle" >';
 	        $detalle        = $numero3.'  No existe Proveedor adjudicado ';
 	        $sesion_nombre  =  '';
 	        $fecha_texto3   = '' ;
 	    }
 	    
 	    $this->flujo_tramite_det('',$detalle,$fecha_texto3,strtoupper($sesion_nombre));
 	    
 	    
 	    
 	    
 	    $numero3        = ' <img src="../../kimages/tab_tarea_b.png">';
 	    $detalle        = '4. Solicitud de Emision de Compromiso Presupuestario '. trim($x['comprobante']);
 	    $sesion_nombre  = 'Unidad Financiera';
 	    $this->flujo_tramite_det($numero3,'<b>'.$detalle.'</b>',$fecha_texto2,strtoupper($sesion_nombre));
 	    
 	    
 	    
 	    //-------------- anexos ------------------------
 	    
 	    if ($zz['detalle']){
 	        $numero3        = ' <img src="../../kimages/1480249187.png" align="absmiddle" >';
 	        $detalle        = $numero3.'  Comprobante electronico emitido '. trim($zz['detalle']);
 	    }else{
 	        $numero3        = ' <img src="../../kimages/ok_no.png" align="absmiddle" >';
 	        $detalle        = $numero3.'  No existe comprobante electronico ';
 	    }
 	    
 	    $completo       = $this->bd->__user($zz['sesion']);
 	    $sesion_nombre  = $completo['completo'];
 	    $fecha_texto3   =  $zz['fecharegistro'] ;
 	    $this->flujo_tramite_det('',$detalle,$fecha_texto3,strtoupper($sesion_nombre));
 	    
 	    
 	    //-------------- control previo  ------------------------
 	    
 	    if (trim($x['control']) == 'N'){
 	        $numero3        = ' <img src="../../kimages/ok_no.png" align="absmiddle" >';
 	        $detalle        = $numero3.'  No existe control previo en el proceso tramite Nro.'. $id.' '.$yz['tipo'];
 	    }else{
 	        $numero3        = ' <img src="../../kimages/cedit.png" align="absmiddle" >';
 	        $detalle        = $numero3.'  Control previo realizado con exito tramite Nro.'. $id.' '.$yz['tipo'];
 	    }
 	    $fecha_texto2   = $yz['fecha'];
 	    $completo       = $this->bd->__user($yz['sesion']);
 	    $sesion_nombre  = $completo['completo'];
 	    $this->flujo_tramite_det('',$detalle,$fecha_texto2,strtoupper($sesion_nombre));
 	    
 	    
 	    
 	    $numero3        = ' <img src="../../kimages/tab_tarea_b.png">';
 	    if ($xy['detalle']){
 	        $detalle        = '5. Contabilidad - Devengado '. trim($xy['detalle']);
 	    }else{
 	        $detalle        = '5. TRAMITE POR DEVENGAR ';
 	    }
 	    
 	    $completo       = $this->bd->__user($xy['sesion']);
 	    $sesion_nombre  = $completo['completo'];
 	    $fecha_texto3   =  $xy['fecha'] ;
 	    $this->flujo_tramite_det($numero3,'<b>'.$detalle.'</b>',$fecha_texto3,strtoupper($sesion_nombre));
 	    
 	    
 	    
 	    $numero3 = ' <img src="../../kimages/tab_fin.png">';
 	    if ($yy['detalle']){
 	        $detalle        = '6. Tesoreria - Pagado '. trim($yy['detalle']);
 	    }else{
 	        $detalle        = '6. TRAMITE POR REALIZAR EL PAGO ';
 	    }
 	    
 	    $completo       = $this->bd->__user($yy['sesion']);
 	    $sesion_nombre  = $completo['completo'];
 	    $fecha_texto3   = $yy['fecha'] ;
 	    $this->flujo_tramite_det($numero3,'<b>'.$detalle.'</b>',$fecha_texto3,strtoupper($sesion_nombre));
 	    
 	    
 	    
 	    
 	    
 	    
 	    echo '</table>';
 	    
 	}
 	//--------------------------------------------------------------------------------
 	//--- busqueda de por codigo para llenar los datos
 	//--------------------------------------------------------------------------------
 	function flujo_tramite_det($numero3,$tarea ,$fecha_envio,$sesion_nombre){
 	    
 	    echo '<tr>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px;text-align: center">'.$numero3.'</td>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px">'.$tarea.'</td>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px;text-align: left">'.$fecha_envio.'</td>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px;text-align: left">'.$sesion_nombre.'</td>
            </tr>';
 	    
 	}
	        
 }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;

//------ poner informacion en los campos del sistema
if (isset($_GET['accion']))	{
	
	$accion    = $_GET['accion'];
	
	$id        = $_GET['id'];
	
	$factura   = $_GET['factura'];
	
	$ruc       = $_GET['ruc'];
 
	
	$gestion->consultaId($accion,$id,$factura,$ruc);
 
 
	
}
 



?>
 
  
<?php
session_start( );
require '../../kconfig/Db.class.php';
require '../../kconfig/Obj.conf.php';

class kreportes{
    
    public $obj ;
    public $bd ;
    public $ruc;
    public $Registro;
    
    public $total_dato;
    
    public $sesion;
    
    
    
    //Constructor de la clase
    
    function kreportes(){
        
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
	//----------------------------
	
    function _Encabezado_1(){
        
       echo '<table width="100%" border="0" style="font-size: 11px">
	    <tbody>
	    <tr>
	    <td width="20%">
			<img align="absmiddle" src="../../kimages/'.trim($_SESSION['logo']).'"'.' width="150" height="110">
		</td>
	    <td width="80%" style="padding-left: 10px;padding-right: 10px"  align="left">'.$this->Empresa().'<br>'.$this->_Cab( 'ruc_registro' ).'<br>'.
	        $this->_Cab( 'direccion' ).'<br>'.$this->_Cab( 'telefono' ).'<br>
		</td>
		</tr>
		  </tbody>
		</table>';
	        
	        
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
    //-----------------------
    
    function Reporte_Proceso($caso,$process,$doc ){
        

        $ADocumento = $this->bd->query_array('flow.view_proceso_caso',
        'idcaso,secuencia,anio, mes, estado_tramite,idprov,nombre_solicita,unidad,fecha',
        'idproceso      ='.$this->bd->sqlvalue_inyeccion($process,true). ' and
                               idcaso         ='.$this->bd->sqlvalue_inyeccion($caso,true) 
        );
        
        $editor_dato = $this->bd->query_array('flow.wk_doc_modelo',
        'formato',
        'id_docmodelo      ='.$this->bd->sqlvalue_inyeccion($doc,true) 
        );


        $sql = 'SELECT  variable, valor,    variable_sis
        FROM flow.view_proceso_caso_var
        where idcaso= '.$this->bd->sqlvalue_inyeccion($caso, true).'  and 
              idproceso='.$this->bd->sqlvalue_inyeccion($process, true).' and valor is not null';

        $cabecera =  $editor_dato['formato'];

        $stmtD = $this->bd->ejecutar($sql);
        
        while ($x=$this->bd->obtener_fila($stmtD)){
            
            $cabecera =  str_replace (trim($x['variable_sis']), trim($x['valor']) , $cabecera);
            
        }
        
        $cabecera =  str_replace ('#UNIDAD', trim($ADocumento['unidad']) , $cabecera);
        $cabecera =  str_replace ('#FECHA_PROCESO', trim($ADocumento['fecha']) , $cabecera);
        $cabecera =  str_replace ('#TRAMITE', trim($ADocumento['idcaso']) , $cabecera);
        $cabecera =  str_replace ('#SOLICITA', trim($ADocumento['nombre_solicita']) , $cabecera);

 

        $ADocumento['editor'] =  $cabecera;

        return $ADocumento;
    }
  
    //---------------------------
  
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
   //----------
    function imagen_caso($codigo){
        
        //--- beneficiario
        
        $sql = "select archivo 
               from  flow.proceso_doc 
            where idcaso = ".$this->bd->sqlvalue_inyeccion($codigo ,true)." limit 1";


 
        $resultado_cab = $this->bd->ejecutar($sql);
        
        $datos = $this->bd->obtener_array( $resultado_cab);
        
        return trim($datos['archivo']);
    }
    
    
    
    
  //----------------------------
  
    function PersonalAsiganado($id){
        
        $sql = "SELECT idprov,razon,cargo
                 FROM bomberos.view_emer_personal 
                WHERE id_caso  =".$this->bd->sqlvalue_inyeccion($id ,true);
        
             
        echo ' <table style="font-size: 9px;border-collapse: collapse;" width="90%" >
			<thead>
                 <tr>
                  <td style="border: 1px solid #ddd; padding: 5px;font-size: 11px"  align="center" colspan="3"><b>PERSONAL ASIGNADO</b></td>
                </tr>
			 <tr>
				<th style="border: 1px solid #ddd; padding: 2px;"   width="20%">CEDULA</th>
				<th style="border: 1px solid #ddd; padding: 2px;  width="60%">PERSONAL</th>
                <th style="border: 1px solid #ddd; padding: 2px;  width="20%">CARGO</th>
 				</tr>
			</thead>';
        
        
        $stmt1           = $this->bd->ejecutar($sql);
        
        $i = 1;
        
        while ($y=$this->bd->obtener_fila($stmt1)){
             
            echo ' <tr>
		    	<td style="border: 1px solid #ddd; padding: 2px;" >'.$y['idprov'].'</td>
				<td style="border: 1px solid #ddd; padding: 2px;" >'.$y['razon'].'</td>
                <td style="border: 1px solid #ddd; padding: 2px;" >'.$y['cargo'].'</td>
            </tr>';
            
            $i++;
            
        }
        
        echo '<tr> <td style="border: 1px solid #ddd; padding: 5px;font-size: 11px"  align="center" colspan="3">&nbsp;</td> </tr>';
        
        echo	'</table>';
        
    }
//----------------------
    function CarroAsiganado($id){
        
        $sql = "SELECT descripcion,placa_ve,tipo_vehiculo, u_km ,s_km
                 FROM bomberos.view_emer_vehiculo
                WHERE id_caso  =".$this->bd->sqlvalue_inyeccion($id ,true);
        
 
        
        echo ' <table style="font-size: 9px;border-collapse: collapse;" width="90%" >
			<thead>
                <tr>
                  <td style="border: 1px solid #ddd; padding: 5px;font-size: 11px"  align="center" colspan="4"><b>VEHICULOS ASIGNADOS</b></td>
                </tr>
			 <tr>
				<th style="border: 1px solid #ddd; padding: 2px;  width="20%">PLACA</th>
				<th style="border: 1px solid #ddd; padding: 2px;  width="60%">VEHICULO</th>
                <th style="border: 1px solid #ddd; padding: 2px;  width="10%">KM SALIDA</th>
                <th style="border: 1px solid #ddd; padding: 2px;  width="10%">KM LLEGADA</th>
 				</tr>
			</thead>';
        
        
        $stmt1           = $this->bd->ejecutar($sql);
        
        $i = 1;
        
        while ($y=$this->bd->obtener_fila($stmt1)){
            
            echo ' <tr>
		    	<td style="border: 1px solid #ddd; padding: 2px;">'.$y['placa_ve'].'</td>
				<td style="border: 1px solid #ddd; padding: 2px;">'.trim($y['descripcion']).' '.trim($y['tipo_vehiculo']).'</td>
                <td style="border: 1px solid #ddd; padding: 2px;" align="center">'.$y['s_km'].'</td>
                <td style="border: 1px solid #ddd; padding: 2px;" align="center">'.$y['u_km'].'</td>
            </tr>';
            
            $i++;
            
        }
        echo '<tr> <td style="border: 1px solid #ddd; padding: 5px;font-size: 11px"  align="center" colspan="4">&nbsp;</td> </tr>';
        
        echo	'</table>';
        
    }
    //---------------
    function PacientesAsiganado($id){
        
        $sql = "SELECT idprov, nombres, edad, tipo,  signos 
                 FROM bomberos.bombero_emer_pac
                WHERE id_caso  =".$this->bd->sqlvalue_inyeccion($id ,true);
        
  
        
        echo ' <table style="font-size: 9px;border-collapse: collapse;" width="90%" >
			<thead>
                <tr>
                  <td style="border: 1px solid #ddd; padding: 5px;font-size: 11px"  align="center" colspan="5"><b>PACIENTES ATENDIDOS / FALLECIDOS</b></td>
                </tr>
			 <tr>
				<th style="border: 1px solid #ddd; padding: 2px;  width="10%">IDENTIFICACION</th>
				<th style="border: 1px solid #ddd; padding: 2px;  width="50%">PACIENTE</th>
                <th style="border: 1px solid #ddd; padding: 2px;  width="10%">EDAD APROX.</th>
                <th style="border: 1px solid #ddd; padding: 2px;  width="10%">ESTADO</th>
                <th style="border: 1px solid #ddd; padding: 2px;  width="20%">SIGNOS/DIAGNOSTICO</th>
 				</tr>
			</thead>';
        
        
        $stmt1           = $this->bd->ejecutar($sql);
        
        $i = 1;
        
        while ($y=$this->bd->obtener_fila($stmt1)){
            
       
            echo ' <tr>
		    	<td style="border: 1px solid #ddd; padding: 2px;">'.$y['idprov'].'</td>
			    <td style="border: 1px solid #ddd; padding: 2px;" align="center">'.$y['nombres'].'</td>
                <td style="border: 1px solid #ddd; padding: 2px;" align="center">'.$y['edad'].'</td>
                <td style="border: 1px solid #ddd; padding: 2px;" align="center">'.$y['tipo'].'</td>
                <td style="border: 1px solid #ddd; padding: 2px;" align="center">'.$y['signos'].'</td>
            </tr>';
            
            $i++;
            
        }
        echo '<tr> <td style="border: 1px solid #ddd; padding: 5px;font-size: 11px"  align="center" colspan="5">&nbsp;</td> </tr>';
        
        
        echo	'</table>';
        
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
    
    //--- resumen IR
    
    function GrillaCertificacion($id){
        
        
        $sql = 'SELECT actividad,fuente,clasificador,detalle, iva, base, certificado,dactividad,dfuente
                    FROM presupuesto.view_certificacionesd
                    where id_tramite= '.$this->bd->sqlvalue_inyeccion($id,true)  ;
        
        
        
        echo ' <table id="table_detalle"  class="lado" cellspacing="0" width="100%" style="font-size: 10px"  >
			<thead>
			 <tr>
				<th class="lado" width="30%">Actividad</th>
				<th class="lado" width="10%">Item</th>
				<th class="lado" width="30%">Detalle Item</th>
                <th class="lado" width="20%">Fuente</th>
                <th class="lado" width="10%">Monto</th>
 				</tr>
			</thead>';
        
        
        $stmt1           = $this->bd->ejecutar($sql);
        $certificado     = 0;
        $iva             = 0;
        $total           = 0;
        $i = 1;
        
        while ($y=$this->bd->obtener_fila($stmt1)){
            
            
            $certificado     = $total + $y['certificado'];
            $iva             = $iva + $y['iva'];
            $total           = $total + $y['base'];
            
            $detalle =   trim($y['detalle']) ;
            
            
            
            echo ' <tr>
		    	<td class="lado" >'.$y['dactividad'].'</td>
				<td class="lado" >'.$y['clasificador'].'</td>
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
        
        
        
        
        $sql = 'SELECT actividad,fuente,clasificador,detalle, iva, base, certificado,dactividad,dfuente,compromiso
                    FROM presupuesto.view_certificacionesd
                    where id_tramite= '.$this->bd->sqlvalue_inyeccion($id,true)  ;
        
        
        
        echo ' <table id="table_detalle" class="lado" cellspacing="0" width="100%" style="font-size: 9px"  >
			<thead>
			 <tr>
				<th class="lado" width="30%">Actividad</th>
				<th class="lado" width="10%">Item</th>
				<th class="lado" width="30%">Detalle Item</th>
                <th class="lado" width="20%">Fuente</th>
                <th class="lado" width="10%">Monto</th>
 				</tr>
			</thead>';
        
        
        $stmt1           = $this->bd->ejecutar($sql);
        $compromiso     = 0;
        $iva             = 0;
        $total           = 0;
        $i = 1;
        
        while ($y=$this->bd->obtener_fila($stmt1)){
            
            
            $compromiso     = $total + $y['compromiso'];
            $iva             = $iva + $y['iva'];
            $total           = $total + $y['base'];
            
            $detalle =   trim($y['detalle']) ;
            
            
            
            echo ' <tr>
		    	<td class="lado" >'.$y['dactividad'].'</td>
				<td class="lado" >'.$y['clasificador'].'</td>
                <td class="lado" >'.$detalle.'</td>
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
        
        //   $content = $_SESSION['ruc_registro'];
        $name    = $_SESSION['razon'] ;
        $elaborador = $_SESSION['login'];
        //    $sesion     = $_SESSION['email'];
        
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
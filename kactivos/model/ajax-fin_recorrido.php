<?php session_start( );
require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/



$bd	   =	new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

$id = $_GET['id'];



///----------- tramite presupuestario...----------------------------
$x = $bd->query_array('presupuesto.view_pre_tramite','id_tramite, fecha,
                                            detalle, observacion, comprobante, estado,  documento,   planificado,
                                            solicita, unidad, user_crea,   user_asig, user_sol, control,sesion_control,
                                            proveedor,  telefono, correo, movil, fcompromiso, fcertifica, fdevenga,   estado_presupuesto',
    'id_tramite='.$bd->sqlvalue_inyeccion($id,true)
    );

//------------------ tramite contable -------------------
$xy = $bd->query_array('co_asiento','fecha, detalle,  sesion,  comprobante,id_asiento',
    'id_tramite='.$bd->sqlvalue_inyeccion($id,true)
    );

//------------------ tramite pagado  -------------------
$yy = $bd->query_array('co_asiento','fecha, detalle,  sesion,  comprobante,id_asiento',
    'id_asiento_ref='.$bd->sqlvalue_inyeccion($xy['id_asiento'],true)
    );
//------------------ tramite control  -------------------
$yz = $bd->query_array('co_control','fecha, detalle,  motivo,  tipo,sesion',
    'idtramite='.$bd->sqlvalue_inyeccion($id,true)
    );
//------------------ tramite anexos  -------------------
$zz = $bd->query_array('co_compras','id_compras, id_asiento, fecharegistro,  idprov, detalle,sesion',
    'id_tramite='.$bd->sqlvalue_inyeccion($id,true)
    );


    //------------------ inventarios  -------------------
$inv = $bd->query_array('inv_movimiento','id_movimiento,fecha,detalle, sesion, creacion, comprobante, estado',
'id_tramite='.$bd->sqlvalue_inyeccion($id,true)
);





$detalle      = trim($x['detalle'] );
$fecha_texto  =  $x['fecha'] ;
$fecha_texto1 =  $x['fcertifica'] ;
$fecha_texto2 =  $x['fcompromiso'] ;

$estilo = 'style ="padding: 10px; background-color: #3e95d1;color:#f8f9fa;background-image: linear-gradient(to bottom, #3e95d1, #368ac5, #2d7fb8, #2474ac, #1a69a0);" ';

$tabla_cabecera =  '<table width="100%"   border="0" cellspacing="0" cellpadding="0"> '.'<tr>
                            <td class="derecha" width="5%" '.$estilo .' valign="top"  ></td>
                            <td class="derecha" width="50%" '.$estilo .' >Procesos</td>
                            <td class="derecha" width="15%" '.$estilo .' >Fecha</td>
                            <td class="derecha" width="20%" '.$estilo .' >Ejecutado por</td>
                            </tr>';



echo $tabla_cabecera;

$numero3        = ' <img src="../../kimages/tab_inicio.png">';
$sesion_nombre  =   trim($x['user_sol']);

flujo_tramite_det($numero3,'<b>1. '.$detalle.'</b>',$fecha_texto,strtoupper($sesion_nombre));

$numero3        = ' <img src="../../kimages/tab_tarea_b.png">';
$detalle        = '2. Emision de Certificacion presupuestaria '. trim($x['comprobante']);
$sesion_nombre  =   trim($x['user_crea']);

flujo_tramite_det($numero3,'<b>'.$detalle.'</b>',$fecha_texto1,strtoupper($sesion_nombre));

$numero3        = ' <img src="../../kimages/tab_condicion.png">';
$detalle        = '3. Proceso de Contratacion Publica '. trim($x['comprobante']);
$sesion_nombre  = 'Unidad Administrativa';

flujo_tramite_det($numero3,'<b>'.$detalle.'</b>',$fecha_texto1,strtoupper($sesion_nombre));


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

flujo_tramite_det('',$detalle,$fecha_texto3,strtoupper($sesion_nombre));




$numero3        = ' <img src="../../kimages/tab_tarea_b.png">';
$detalle        = '4. Solicitud de Emision de Compromiso Presupuestario '. trim($x['comprobante']);
$sesion_nombre  = 'Unidad Financiera';
flujo_tramite_det($numero3,'<b>'.$detalle.'</b>',$fecha_texto2,strtoupper($sesion_nombre));



//-------------- anexos ------------------------

if ($zz['detalle']){
    $numero3        = ' <img src="../../kimages/1480249187.png" align="absmiddle" >';
    $detalle        = $numero3.'  Comprobante electronico emitido '. trim($zz['detalle']);
}else{
    $numero3        = ' <img src="../../kimages/ok_no.png" align="absmiddle" >';
    $detalle        = $numero3.'  No existe comprobante electronico ';
}

$completo       = $bd->__user($zz['sesion']);
$sesion_nombre  = $completo['completo'];
$fecha_texto3   =  $zz['fecharegistro'] ;
flujo_tramite_det('',$detalle,$fecha_texto3,strtoupper($sesion_nombre));


//-------------- inventarios  ------------------------

$inv = $bd->query_array('inv_movimiento','id_movimiento,fecha,detalle, sesion, creacion, comprobante, estado',
'id_tramite='.$bd->sqlvalue_inyeccion($id,true)
);



if ($inv['detalle']){
    $numero3        = ' <img src="../../kimages/perspectiva.png" align="absmiddle" >';
    $detalle        = $numero3.'  Ingreso a inventarios Nro.Comprobante: '.trim($inv['comprobante']).' '. trim($inv['detalle']);

    $completo1       = $bd->__user($inv['sesion']);
    $sesion_nombre  = $completo1['completo'];
    $fecha_texto3   =  $inv['fecha'] ;
    flujo_tramite_det('',$detalle,$fecha_texto3,strtoupper($sesion_nombre));


} 


//-------------- control previo  ------------------------

if (trim($x['control']) == 'N'){
    $numero3        = ' <img src="../../kimages/ok_no.png" align="absmiddle" >';
    $detalle        = $numero3.'  No existe control previo en el proceso tramite Nro.'. $id.' '.$yz['tipo'];
}else{
    $numero3        = ' <img src="../../kimages/cedit.png" align="absmiddle" >';
    $detalle        = $numero3.'  Control previo realizado con exito tramite Nro.'. $id.' '.$yz['tipo'];
}
$fecha_texto2   = $yz['fecha'];
$completo       = $bd->__user($yz['sesion']);
$sesion_nombre  = $completo['completo'];
flujo_tramite_det('',$detalle,$fecha_texto2,strtoupper($sesion_nombre));



$numero3        = ' <img src="../../kimages/tab_tarea_b.png">';
if ($xy['detalle']){
    $detalle        = '5. Contabilidad - Devengado '. trim($xy['detalle']);
}else{
    $detalle        = '5. TRAMITE POR DEVENGAR ';
}

$completo       = $bd->__user($xy['sesion']);
$sesion_nombre  = $completo['completo'];
$fecha_texto3   =  $xy['fecha'] ;
flujo_tramite_det($numero3,'<b>'.$detalle.'</b>',$fecha_texto3,strtoupper($sesion_nombre));



$numero3 = ' <img src="../../kimages/tab_fin.png">';
if ($yy['detalle']){
    $detalle        = '6. Tesoreria - Pagado '. trim($yy['detalle']);
}else{
    $detalle        = '6. TRAMITE POR REALIZAR EL PAGO ';
}

$completo       = $bd->__user($yy['sesion']);
$sesion_nombre  = $completo['completo'];
$fecha_texto3   = $yy['fecha'] ;
flujo_tramite_det($numero3,'<b>'.$detalle.'</b>',$fecha_texto3,strtoupper($sesion_nombre));






echo '</table>';


//-------------------------
function flujo_tramite_det($numero3,$tarea ,$fecha_envio,$sesion_nombre){
    
    echo '<tr>
              <td class="filasupe" valign="top" style="font-size: 13px;padding: 8px;text-align: center">'.$numero3.'</td>
              <td class="filasupe" valign="top" style="font-size: 13px;padding: 8px">'.$tarea.'</td>
              <td class="filasupe" valign="top" style="font-size: 13px;padding: 8px;text-align: left">'.$fecha_envio.'</td>
              <td class="filasupe" valign="top" style="font-size: 13px;padding: 8px;text-align: left">'.$sesion_nombre.'</td>
            </tr>';
    
}
//-------------------------------------------------------------------------------------


?>

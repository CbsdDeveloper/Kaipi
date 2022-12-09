<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 
	$bd	   = new Db ;
	
	$registro= $_SESSION['ruc_registro'];
	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
    $id_concilia	=	$_GET["id_concilia"];
    
 
    
    $Aconciliacion = $bd->query_array('co_concilia',
                                      'anio, mes,   estado, cuenta', 
                                      'id_concilia='.$bd->sqlvalue_inyeccion($id_concilia,true)
                                     );
    /*
    
    $sql1 = "union SELECT id_asiento_aux, fecha,cheque,documento, razon,debe, haber ,bandera
    FROM view_bancos
    where 	registro = ".$bd->sqlvalue_inyeccion($registro,true)." and
    cuenta = ".$bd->sqlvalue_inyeccion(trim($Aconciliacion["cuenta"]),true)." and
    tipo   = 'cheque' and
    haber > 0 and
    COALESCE(cab_codigo,0) = 2  and
    anio   = ".$bd->sqlvalue_inyeccion($Aconciliacion["anio"],true)."  and
    mes    < ".$bd->sqlvalue_inyeccion($Aconciliacion["mes"],true)  ;
    
    
    
    $sql = "SELECT id_asiento_aux, fecha,cheque,documento, razon,debe, haber ,bandera
    FROM view_bancos
    where 	registro = ".$bd->sqlvalue_inyeccion($registro,true)." and
    cuenta = ".$bd->sqlvalue_inyeccion(trim($Aconciliacion["cuenta"]),true)." and
    tipo   = 'cheque' and
    haber > 0 and
    COALESCE(cab_codigo,0) <>   1 and 
    anio   = ".$bd->sqlvalue_inyeccion($Aconciliacion["anio"],true)."  and
    mes    = ".$bd->sqlvalue_inyeccion($Aconciliacion["mes"],true).$sql1." 
    order by 2 asc";		
    */
    
    $sql = "SELECT id_asientod, id_asiento, razon, correo, cuenta, fecha, idprov,comprobante,
                  estado, detalle, debe, haber, modulo, anio, mes, registro, concilia, tipo, documento_pago
            FROM  view_bancos_concilia
where 	registro = ".$bd->sqlvalue_inyeccion($registro,true)." and
        cuenta = ".$bd->sqlvalue_inyeccion(trim($Aconciliacion["cuenta"]),true)." and
        tipo   =   'cheque'  and
        anio   = ".$bd->sqlvalue_inyeccion($Aconciliacion["anio"],true)."  and
        mes    = ".$bd->sqlvalue_inyeccion($Aconciliacion["mes"],true)."
        order by fecha asc";		
    
    echo ' <table id="table_cheque" class="table table-hover datatable" cellspacing="0" width="100%" style="font-size: 11px"  >
			<thead>
			 <tr>
                <th width="10%">Asiento</th>
				<th width="10%">Fecha</th>
				<th width="10%">Comprobante</th>
				<th width="10%">Cheque</th>
				<th width="30%">Beneficiario</th>
				<th width="10%">Ingreso</th>
                <th width="10%">Egreso</th>
                <th width="5%"> &nbsp; </th>
                <th width="5%"> &nbsp; </th>
				</tr>
			</thead>';

       
    $stmt = $bd->ejecutar($sql);
    
    $haber = 0;
    
    while ($x=$bd->obtener_fila($stmt)){
        
    	$cnombre =  trim($x['razon']);
    	
    	$haber =  $haber +  $x['haber'] ;
    	
    	$id_asientod = $x['id_asientod'];
    	
 
    	
    	if ($x['concilia'] == 'S'){
    	    $check ='checked';
    	}else{
    	    $check =' ';
    	}
    	
    	$bandera = '<input type="checkbox" onclick="myFunction('.$id_asientod.',this)" '.$check.'> ';
    	
    	
    	echo ' <tr>
                <td>'.$x['id_asiento'].'</td>
				<td>'.$x['fecha'].'</td>
				<td>'.$x['comprobante'].'</td>
				<td>'.$x['documento_pago'].'</td>
				<td>'.$cnombre.'</td>
				<td>'.$x['debe'].'</td>
                <td>'.$x['haber'].'</td>
                <td> '.$bandera.'</td>
                 <td>'.$x['concilia'].'</td>
				</tr>';
    	
    }
       
    echo	'</table><br>';
    
    echo	'<h5>Total Cheques: '.$haber.'</h5>';
    
    
    
?>
<script>
var $jq = jQuery.noConflict();
$jq( document ).ready(function( $ ) {
	   $jq('#table_cheque').DataTable();
});
 
</script>
 
  
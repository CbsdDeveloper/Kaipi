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
    
    

    
    $sql = "SELECT id_asientod, id_asiento, razon, correo, cuenta, fecha, idprov,comprobante,
                  estado, detalle, debe, haber, modulo, anio, mes, registro, concilia, tipo, documento_pago
            FROM  view_bancos_concilia
where 	registro = ".$bd->sqlvalue_inyeccion($registro,true)." and
        cuenta = ".$bd->sqlvalue_inyeccion(trim($Aconciliacion["cuenta"]),true)." and
        coalesce(tipo,'-')   <>   'cheque'  and  
        anio   = ".$bd->sqlvalue_inyeccion($Aconciliacion["anio"],true)."  and
        mes    = ".$bd->sqlvalue_inyeccion($Aconciliacion["mes"],true)." union
SELECT id_asientod, id_asiento, razon, correo, cuenta, fecha, idprov,comprobante,
                  estado, detalle, debe, haber, modulo, anio, mes, registro, concilia, tipo, documento_pago
            FROM  view_bancos_concilia
where 	registro = ".$bd->sqlvalue_inyeccion($registro,true)." and
        cuenta = ".$bd->sqlvalue_inyeccion(trim($Aconciliacion["cuenta"]),true)." and
        coalesce(tipo,'-')   <>   'cheque'      and concilia = 'N' and 
        anio   = ".$bd->sqlvalue_inyeccion($Aconciliacion["anio"],true)."  and
        mes   < ".$bd->sqlvalue_inyeccion($Aconciliacion["mes"],true)."  order by 5 asc";		

 
 
        
    
    echo ' <table id="table_deposito" class="table table-hover datatable" cellspacing="0" width="100%" style="font-size: 11px"  >
			<thead>
			 <tr>
                <th width="5%">Asiento</th>
				<th width="10%">Fecha</th>
				<th width="10%">Comprobante</th>
				<th width="10%">SPI/Doc</th>
				<th width="30%">Beneficiario</th>
				<th width="10%">Ingreso</th>
                <th width="10%">Egreso</th>
                <th width="5%"> Accion </th>
                <th width="5%"> Conciliado </th>
                <th width="5%"> Ref. </th>
				</tr>
			</thead>';

       
    $stmt = $bd->ejecutar($sql);
    
    $debe  = 0;
    $haber = 0;
 
    
    while ($x=$bd->obtener_fila($stmt)){
        
        $cnombre =    '<b>'.trim($x['razon']) .'</b> '.trim($x['detalle']);
    	
    	$haber =  $haber +  $x['haber'] ;
    	
    	$debe =  $debe +  $x['debe'] ;
    	
    	if ($x['concilia'] == 'S'){
    	    $check ='checked';
 
    	}else{
    	    $check =' ';
    	  
    	}
    	
    	$bandera = '<input type="checkbox" id="che_'.$x['id_asientod'].'" name="che_'.$x['id_asientod'].'"  onclick="myFunctionDeposito('.$x['id_asientod'].',this)" '.$check.'> ';
    	
    	
 
        $xspi = $bd->query_array('tesoreria.view_spi_control',   // TABLA
        'id_spi, referencia',                        // CAMPOS
        'idprov='.$bd->sqlvalue_inyeccion(trim($x['idprov']),true)  .' AND 
         id_asiento='.$bd->sqlvalue_inyeccion($x['id_asiento'],true)  .' AND 
         cuenta='.$bd->sqlvalue_inyeccion(trim($x['cuenta']),true,true)
        );
 
        if ( $xspi['id_spi'] > 0 ){
            $documento_spi = 'SPI-'.$xspi['id_spi'].'.'.trim($xspi['referencia']);
        }else{
            $documento_spi = trim($x['documento_pago']);
        }

       
        
    	echo ' <tr>
	            <td>'.$x['id_asiento'].'</td>
				<td>'.$x['fecha'].'</td>
				<td>'.$x['comprobante'].'</td>
				<td>'.$documento_spi.'</td>
				<td>'.$cnombre.'</td>
				<td>'.$x['debe'].'</td>
                <td>'.$x['haber'].'</td>
                <td> '.$bandera.'</td>
                <td>'.$x['concilia'].'</td>
                <td>'.$x['id_asientod'].'</td>
				</tr>';
    	
    }
 
    echo	'</table>';
    
    echo	' <div class="col-md-12" style="padding: 10px;font-size: 15px">
                   
                    <div class="col-md-3"><b>Ingreso '.number_format($debe,2).' 
                     Egreso '.number_format($haber,2).'</b>
                    </div> <div class="col-md-6" align="right">
                    </div> </div>';

 
 
    
    
?>
 <script>
var $jd = jQuery.noConflict();
$jd( document ).ready(function( $ ) {
	   $jd('#table_deposito').DataTable();
});
 
</script>
  
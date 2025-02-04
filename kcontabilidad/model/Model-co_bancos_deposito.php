<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	 	$bd	   = new Db ;
	$registro= $_SESSION['ruc_registro'];
	
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	
      
    $id_concilia	=	$_GET["id_concilia"];
    
 
    $sql = "update co_asiento_aux set tipo = '-' where tipo is null";
    
    $bd->ejecutar($sql);
    
    
    $Aconciliacion = $bd->query_array('co_concilia',
                                      'anio, mes,   estado, cuenta', 
                                      'id_concilia='.$bd->sqlvalue_inyeccion($id_concilia,true)
                                     );
    
    
    
    $sql = "SELECT id_asiento_aux, fecha,cheque,documento, razon,debe, haber ,bandera
    FROM view_bancos
    where 	registro = ".$bd->sqlvalue_inyeccion($registro,true)." and
    cuenta = ".$bd->sqlvalue_inyeccion(trim($Aconciliacion["cuenta"]),true)." and
    tipo   <>   'cheque'  and
    anio   = ".$bd->sqlvalue_inyeccion($Aconciliacion["anio"],true)."  and
    mes    = ".$bd->sqlvalue_inyeccion($Aconciliacion["mes"],true)." 
    order by fecha asc";		
    
 
    
    echo ' <table id="table_cheque" class="table table-hover datatable" cellspacing="0" width="100%" style="font-size: 11px"  >
			<thead>
			 <tr>
				<th width="15%">Fecha</th>
				<th width="10%">Comprobante</th>
				<th width="10%">Documento</th>
				<th width="65%">Contribuyente</th>
				<th width="10%">Ingreso</th>
                <th width="10%">Egreso</th>
                <th width="10%"> &nbsp; </th>
				</tr>
			</thead>';

       
    $stmt = $bd->ejecutar($sql);
    
    while ($x=$bd->obtener_fila($stmt)){
        
    	$cnombre =  trim($x['razon']);
    	
    	
    	if ($x['bandera'] == '1'){
    	    $check ='checked';
    	}else{
    	    $check =' ';
    	}
    	
    	$bandera = '<input type="checkbox" onclick="myFunctionDeposito('.$x['id_asiento_aux'].',this)" '.$check.'> ';
    	
    	
    	echo ' <tr>
				<td>'.$x['fecha'].'</td>
				<td>'.$x['documento'].'</td>
				<td>'.$x['cheque'].'</td>
				<td>'.$cnombre.'</td>
				<td>'.$x['debe'].'</td>
                <td>'.$x['haber'].'</td>
                <td> '.$bandera.'</td>
				</tr>';
    	
    }
   
    
 
    
    echo	'</table>';
    
?>
 
  
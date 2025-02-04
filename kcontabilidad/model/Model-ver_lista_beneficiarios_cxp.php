<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 
	$bd	   = new Db ;
	
	$registro= $_SESSION['ruc_registro'];
	
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
    $id_asiento	=	$_GET["id_asiento"];
    
 
       
    $sql = "SELECT id_asiento_aux,   idprov, razon,cuenta_detalle ,cuenta, debe, haber 
            FROM  view_aux
            where id_asiento =  ".$bd->sqlvalue_inyeccion($id_asiento,true)." and 
                  registro = ".$bd->sqlvalue_inyeccion(trim($registro),true)."
            order by cuenta, razon";

 
    
    
    echo ' <table id="table_ciu" class="table table-hover datatable" cellspacing="0" width="100%" style="font-size: 11px"  >
			<thead>
			 <tr>
				<th width="5%">Referencia</th>
                <th width="10%">Cuenta</th>
                <th width="40%">Detalle</th>
 				<th width="30%">Beneficiario</th>
		        <th width="5%">Debe</th>
                <th width="5%">Haber</th>
                <th width="5%"></th>
				</tr>
			</thead>';

       
    $stmt = $bd->ejecutar($sql);
 
    
    while ($x=$bd->obtener_fila($stmt)){
        
 
        $bandera = '<button class="btn btn-xs btn-danger"  title = "ELIMINAR AUXILIAR DE LA CUENTA"
                            onClick="goToURLAuxVisor('.$x['id_asiento_aux'].')">
                            <i class="glyphicon glyphicon-remove"></i></button> ';
        
        $bandera = $bandera.' <button class="btn btn-xs btn-info" title = "SELECCIONAR AUXILIAR PRINCIPAL EN EL ASIENTO"
                            onClick="javascript:goToURLAuxMain('."'".$x['idprov']."'".')">
                            <i class="glyphicon glyphicon-flash"></i></button>';
        
     
    	echo ' <tr>
				<td>'.$x['id_asiento_aux'].'</td>
                <td>'.$x['cuenta'].'</td>
                <td>'.$x['cuenta_detalle'].'</td>
 				<td>'.$x['razon'].'</td>
  				<td align="right">'.$x['debe'].'</td>
                <td align="right">'.$x['haber'].'</td>
                <td align="right"> '.$bandera.'</td>
				</tr>';
    	
    }
       
    echo	'</table><br>';
    
     
    
    
?>
<script>
var $jq = jQuery.noConflict();
$jq( document ).ready(function( $ ) {
	 
	  $jq('#table_ciu').dataTable( {      
	         searching: true,
	         paging: true, 
	         info: true,         
	         lengthChange:true ,
	         aoColumnDefs: [
			      { "sClass": "highlight", "aTargets": [ 1 ] },
			      { "sClass": "de", "aTargets": [ 3 ] },
			      { "sClass": "di", "aTargets": [ 4 ] },
			      { "sClass": "ye", "aTargets": [ 5 ] }
			    ] 
	      } );

	   
});
 
</script>
 
  
<?php
session_start();

require '../../kconfig/Db.class.php';
require '../../kconfig/Obj.conf.php';
 


$bd	   =	 	new Db ;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

 
$idaux     = $_GET['idaux'] ;
$accion    = $_GET['accion'] ;
$id_spi    = $_GET['id_spi'] ;
 
$sesion 	 =     trim($_SESSION['email']);

$hoy 	     =     date("Y-m-d");

$x = $bd->query_array('view_bancos_pago',
                      'idprov,   monto_pago,  comprobante,  cod_banco, tipo_cta, cta_banco,detalle',
                     'id_asiento_aux='.$bd->sqlvalue_inyeccion($idaux,true)
                     );

 
$ATabla = array(
    array( campo => 'id_spi_det',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
    array( campo => 'id_spi',tipo => 'NUMBER',id => '1',add => 'S', edit => 'N', valor => $id_spi, key => 'N'),
    array( campo => 'id_asiento_aux',tipo => 'NUMBER',id => '2',add => 'S', edit => 'N', valor => $idaux, key => 'N'),
    array( campo => 'idprov',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => $x['idprov'], key => 'N'),
    array( campo => 'codigo_banco',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor =>$x['cod_banco'], key => 'N'),
    array( campo => 'tipo_cuenta',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor =>$x['tipo_cta'], key => 'N'),
    array( campo => 'nro_cuenta',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => $x['cta_banco'], key => 'N'),
    array( campo => 'gasto_spi',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => '40100', key => 'N'),
    array( campo => 'enviado',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor => 'N', key => 'N'),
    array( campo => 'monto_pagar',tipo => 'NUMBER',id => '9',add => 'S', edit => 'S', valor =>$x['monto_pago'], key => 'N'),
    array( campo => 'sesion',tipo => 'VARCHAR2',id => '10',add => 'S', edit => 'S', valor => $sesion , key => 'N'),
    array( campo => 'creacion',tipo => 'DATE',id => '11',add => 'S', edit => 'S', valor => $hoy , key => 'N'),
    array( campo => 'sesionm',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'S', valor => $sesion , key => 'N'),
    array( campo => 'modificacion',tipo => 'DATE',id => '13',add => 'S', edit => 'S', valor => $hoy , key => 'N')
);
 


if ( $accion == 'add'){
  
    
    if ( !empty($x['cod_banco'] ) ) {
         
        $bd->_InsertSQL('tesoreria.spi_mov_det',$ATabla, 'tesoreria.spi_mov_det_id_spi_det_seq' );
        
        $sql = "update co_asiento_aux set spi = 'S'  where id_asiento_aux =".$bd->sqlvalue_inyeccion($idaux,true);
        
        $bd->ejecutar($sql);
        
    }else{
        echo '<b>NO EXISTE CUENTA BANCARIA REGISTRADA</b>';
    }
}

if ( $accion == 'eliminar'){
    
    $id_asiento_aux    = $_GET['id_asiento_aux'] ;
    $id_spi_det   = $_GET['id_spi_det'] ;
    
    $sql = "DELETE FROM tesoreria.spi_mov_det  where id_spi_det =".$bd->sqlvalue_inyeccion($id_spi_det,true);
    $bd->ejecutar($sql);
    
     
    $sql = "update co_asiento_aux set spi = 'N'  where id_asiento_aux =".$bd->sqlvalue_inyeccion($id_asiento_aux,true);
    
    $bd->ejecutar($sql);
}

 


$sql = 'SELECT id_spi_det,idprov,razon,codigo_banco,nro_cuenta,tipo_cuenta,monto_pagar,detalle,id_spi,gasto_spi,id_asiento_aux
        FROM tesoreria.view_spi_detalle
        where id_spi = '.$bd->sqlvalue_inyeccion($id_spi, true) ;

 

echo '<table id="jsontableDetalleSpi" class="table  table-hover table-bordered" cellspacing="0" width="100%" style="font-size: 11px"  >
     			<thead>
    			 <tr>
                    <th align="center" width="10%">Identificacion</th>
    				<th align="center" width="10%">Referencia</th>
    				<th align="center" width="20%">Nombre</th>
                    <th align="center" width="10%">Institucion</th>
    				<th align="center" width="10%">Nro.Cuenta</th>
    				<th align="center" width="10%">Tipo Cuenta</th>
                    <th align="center" width="10%">Monto</th>
                    <th align="center" width="10%">Concepto</th>
                    <th align="center" width="10%">Accion</th>
                    </tr>
    			</thead>';
 
        $resultado	= $bd->ejecutar($sql);
        
        while ($y=$bd->obtener_fila($resultado)){
            
            $funcion1  = ' onClick="goToSpiCiu('."'".trim($y['idprov'])."'".')" ';
            $title1    = 'data-toggle="modal" data-target="#myModalciu" title="Actualizar Datos beneficiarios"';
            $boton_gas = '<button   class="btn btn-xs" '.$title1.$funcion1.' ><i class="glyphicon glyphicon-user"></i></button>&nbsp;';
            
            
            
            $funcion1  = ' onClick="goToSpiAnula('.$y['id_spi_det'].','.$y['id_asiento_aux'].')" ';
            $title1    = '  title="Anular registro del beneficiario"';
            $boton_anula = '<button   class="btn btn-xs" '.$title1.$funcion1.' ><i class="glyphicon glyphicon-trash"></i></button>&nbsp;';
            
            echo ' <tr>
              	<td>'.$y['idprov'].'</td>
				<td>'.$y['id_spi_det'].'</td>
				<td>'.$y['razon'].'</td>
                <td>'.$y['codigo_banco'].'</td>
                <td>'.$y['nro_cuenta'].'</td>
                <td>'.$y['tipo_cuenta'].'</td>
                <td>'.$y['monto_pagar'].'</td>
                <td>'.$y['gasto_spi'].'</td>
                <td>'.$boton_gas.$boton_anula.'</td>
                 </tr>';
            
        }
        
        echo	'</table> ';
 
?>
<script>
 jQuery.noConflict(); 
 
         jQuery(document).ready(function() {
        	jQuery('#jsontableDetalleSpi').DataTable( {      
                 "searching": true,
                 "paging": true, 
                 "info": true,         
                 "lengthChange":false 
            } );
} );
</script>
  
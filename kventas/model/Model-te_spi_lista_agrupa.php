<?php
session_start();

require '../../kconfig/Db.class.php';
require '../../kconfig/Obj.conf.php';
 


$bd	   =	 	new Db ;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

 
 
$id_spi      =     $_GET['id_spi'] ;
 






$sql = 'select id_spi,idprov,codigo_banco ,nro_cuenta ,nombre_banco ,gasto_spi ,razon,
        	   sum(monto_pagar) as total, count(*) as nn,max(id_spi_det) as  id_spi_det
        from tesoreria.view_spi_detalle 
        where id_spi ='.$bd->sqlvalue_inyeccion($id_spi,true).' 
        group by id_spi,idprov,codigo_banco ,nro_cuenta ,nombre_banco ,gasto_spi ,razon';
				

$resultado	= $bd->ejecutar($sql);

while ($y=$bd->obtener_fila($resultado)){
    
    $nn          = $y['nn'];
    $id_spi_det  = $y['id_spi_det'];
    
    $total       = $y['total'];
    $idprov      = trim($y['idprov']);
    
    if ( $nn > 1 ){
        
        $sqlE = 'update tesoreria.spi_mov_det
                    set monto_pagar= '.$bd->sqlvalue_inyeccion($total,true).'  
                  where id_spi ='.$bd->sqlvalue_inyeccion($id_spi,true).' and
                        idprov ='.$bd->sqlvalue_inyeccion($idprov,true).' and
                        id_spi_det ='.$bd->sqlvalue_inyeccion($id_spi_det,true);
        
        $bd->ejecutar($sqlE);
        
        $sqld = 'DELETE from tesoreria.spi_mov_det
                  where id_spi ='.$bd->sqlvalue_inyeccion($id_spi,true).' and
                        idprov ='.$bd->sqlvalue_inyeccion($idprov,true).' and
                        id_spi_det <> '.$bd->sqlvalue_inyeccion($id_spi_det,true);
        
        $bd->ejecutar($sqld);
        
    }
    
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

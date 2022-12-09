<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


$obj     = 	new objects;
$bd	   =	new Db ;


$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);


$tipo 		= $bd->retorna_tipo();

$anio       =  $_SESSION['anio'];


/*
$sql = "SELECT id_tramite, fecha, unidad , comprobante, detalle,   proveedor,estado_presupuesto
            FROM presupuesto.view_pre_tramite
            where estado in ('3','4','5')  and idprov =".$bd->sqlvalue_inyeccion($idprov, true).' order by fecha';

*/
$sql = "SELECT id_tramite, fecha, unidad ,trim(estado_presupuesto) estado_presupuesto, 
               comprobante, trim(detalle) as detalle
            FROM presupuesto.view_pre_tramite
            where estado in ('3','4','5') and anio = ".$bd->sqlvalue_inyeccion($anio, true)."  order by fecha";

///--- desplaza la informacion de la gestion onclick="javascript:delRequisito('del',)"
$resultado  = $bd->ejecutar($sql);

$cabecera =  "Tramite,Fecha,Unidad,Estado,Comprobante,Detalle";


$evento   = "deltramite-0";

$obj->table->table_basic_seleccion($resultado,$tipo,'seleccion','',$evento ,$cabecera);



$DetalleRequisitos= 'ok';

echo $DetalleRequisitos;



?>
<script>
 jQuery.noConflict(); 
 
         jQuery(document).ready(function() {
        	jQuery('#tablaBasica').DataTable( {      
                 "searching": true,
                 "paging": true, 
                 "info": true,         
                 "lengthChange":true 
            } );
} );
</script>


  
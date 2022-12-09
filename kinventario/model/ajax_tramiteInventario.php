<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


$obj     = 	new objects;
$bd	   =	new Db ;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

$tipo 		= $bd->retorna_tipo();

 
$anio       =  $_SESSION['anio'];
 
$idprov            = trim($_GET['idprov']);
$id_tramite        = $_GET['id_tramite'];

if ( $id_tramite > 0 ) {

            $sql = "select  a.id_tramite, 
                        a.fecha, 
                        a.unidad ,
                        a.comprobante, 
                        a.detalle
            from presupuesto.view_pre_tramite a
            where  
                  a.estado in ('3','4','5','6') and 
                  a.anio = ".$bd->sqlvalue_inyeccion($anio, true)." and a.id_tramite = ".$bd->sqlvalue_inyeccion($id_tramite, true)."
                  order by fecha desc";
} else
{
      $sql = "select  a.id_tramite, 
                  a.fecha, 
                  a.unidad ,
                  a.comprobante, 
                  a.detalle,idprov,proveedor
      from presupuesto.view_pre_tramite a
      where  
            a.estado in ('3','4','5','6') and 
            a.anio = ".$bd->sqlvalue_inyeccion($anio, true)." and a.id_tramite in( SELECT  b.id_tramite 
                                                                        FROM presupuesto.view_dettramites b
                                                                        where b.subgrupo in ('5308','7308','6308','6310','6311','7314')
            ) order by fecha desc";
}
 
 

///--- desplaza la informacion de la gestion onclick="javascript:delRequisito('del',)"
$resultado  = $bd->ejecutar($sql);

$cabecera =  "Tramite,Fecha,Unidad,Comprobante,Detalle,Ruc,Nombre";


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


  
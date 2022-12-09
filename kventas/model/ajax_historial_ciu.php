<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

     
    $obj     = 	new objects;
    $bd	   =	new Db ;
 
 
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
    
 
    $tipo 		= $bd->retorna_tipo();
    
    
    $idprov 		= trim($_GET["idprov"]);
    
    
 
    
    $sql = "SELECT id_movimiento,fecha,anio,comprobante,detalle,total 
            FROM view_ventas_fac
            where estado ='aprobado' and tipo = 'F' and
                  idprov =".$bd->sqlvalue_inyeccion($idprov, true).' order by anio desc,  fecha desc';

    $resultado  = $bd->ejecutar($sql);
     
    $cabecera =  "Movimiento,Fecha,Anio,Comprobante,Detalle,Pago";
 
    $evento   = "";
    
    $obj->table->table_basic_seleccion($resultado,$tipo,'','',$evento ,$cabecera);

   
    
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


  
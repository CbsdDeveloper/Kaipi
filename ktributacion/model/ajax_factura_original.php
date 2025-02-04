<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
 
$bd	   =	new Db;

     $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
    
 
     echo '<table class="table table-striped  table-hover" width="100%"  style="font-size: 12px">  
     <thead> 
         <tr>
          <th width="40%">Articulos/Servicios</th>
          <th  width="10%">Cantidad</th>
          <th  width="10%">Costo</th>
          <th  width="10%">IVA</th>
          <th  width="10%">Base Imponible</th>
          <th  width="10%">Tarifa Cero</th>
          <th width="10%">Total</th>
         </tr>   
       </thead> 
     <tbody>';
     
     
     $id_movimiento      = $_GET['id'];


     $sql = 'SELECT  b.producto ,a.id_movimiento, a.idproducto, a.cantidad, a.costo, a.total, a.monto_iva, a.tarifa_cero, a.baseiva 
     FROM inv_movimiento_det_nota a
     join web_producto b  on a.idproducto = b.idproducto and  
          a.id_movimiento = '.$bd->sqlvalue_inyeccion($id_movimiento, true). ' order by 1 desc';


    $stmt = $bd->ejecutar($sql);


    $total       = 0;
    $monto_iva   = 0;
    $tarifa_cero = 0;
    $baseiva     = 0;
 
     while ($x=$bd->obtener_fila($stmt)){
            
        $id = $x['id']; 
        
        echo '<tr>
            <td>'.$x['producto'].'  </td>
            <td>'.$x['cantidad'].'  </td>
            <td>'.$x['costo'].'  </td>
            <td>'.$x['monto_iva'].'  </td>
            <td>'.$x['baseiva'].'  </td>
            <td>'.$x['tarifa_cero'].'  </td>
            <td>'.$x['total'].'  </td>
             </tr>';
        
        $total       = $total +       $x['total'];
        $monto_iva   = $monto_iva +   $x['monto_iva'];
        $tarifa_cero = $tarifa_cero + $x['tarifa_cero'];
        $baseiva     = $baseiva +     $x['baseiva'] ;
        
   }
  
   echo '<tr>
   <td> </td>
   <td> </td>
   <td>Total  </td>
   <td> <b>'.$monto_iva .' </b> </td>
   <td> <b>'.$baseiva.' </b> </td>
   <td> <b>'. $tarifa_cero.'</b>  </td>
   <td <b>'.$total   .'</b>  </td>
    </tr>';

   echo "</tbody></table>";
   
    
  
 
	echo $procesado;
    
 ?>					 
 
<?php 
    session_start( );   
    
    require '../../kconfig/Db.class.php';    
 	
    require '../../kconfig/Obj.conf.php';  
    
    require '../../kconfig/Set.php'; 
  
    class componente{
 
       
 
      private $obj;
      private $bd;
      private $set;
      
       private $formulario;
       private $evento_form;
          
      private $ruc;
      private $sesion;
      private $hoy;
      private $POST;
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function componente( ){
   
                $this->obj     = 	new objects;
                $this->set     = 	new ItemsController;
             	$this->bd	   =	new Db;
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
                $this->ruc       =  $_SESSION['ruc_registro'];
                $this->sesion 	 =  $_SESSION['email'];
        }
     //---------------------------------------
        function Formulario( $id,$fecha1,$fecha2  ){
      
 
        $cadena2 = ' and ( fecha BETWEEN '.$this->bd->sqlvalue_inyeccion($fecha1,true)." and ".$this->bd->sqlvalue_inyeccion($fecha2,true)." )   ";
            
            
         
         $sql_det =' SELECT  fecha, tipo, costo,
                             cantidad,
                             coalesce(total,0) total,
                             coalesce(ingreso,0) ingreso,
                             coalesce(egreso,0) egreso,
                             (cantidad * costo) as total_variable,
                             id_movimiento, detalle,razon,comprobante,producto
        FROM  view_mov_aprobado
        WHERE idproducto= '.$this->bd->sqlvalue_inyeccion($id,true).$cadena2.'
        order by fecha asc,ingreso desc, tipo asc';
         
         $stmt21 = $this->bd->ejecutar($sql_det);
         
         $i = 1;
         
         $total_saldo    = 0;
         $total_cantidad = 0;
         $tota_promedio  = 0;
 
         
         echo '	<table class="table1" width="100%" border="0" cellspacing="0" cellpadding="0">
  <tbody>
    <tr>  
      <td class="filasupe" width="5%" rowspan="2" style="text-align: center;padding: 3px">FECHA</td>
      <td class="filasupe" width="5%" rowspan="2" style="text-align: center;padding: 3px">TRANSACCION</td>
      <td class="filasupe" width="5%" rowspan="2" style="text-align: center;padding: 3px">DOCUMENTO</td>
      <td class="filasupe" width="20%" rowspan="2" style="text-align: center;padding: 3px">PROVEEDOR/RESPONSABLE</td>
      <td class="filasupe" width="20%" rowspan="2" style="text-align: center;padding: 3px">DETALLE</td>
      <td class="filasupe" colspan="3" bgcolor="#F10206" style="text-align: center; color: #FFFFFF;padding: 3px">ENTRADAS</td>
      <td class="filasupe" colspan="3" bgcolor="#087300" style="text-align: center; color: #FFFFFF;padding: 3px">SALIDAS</td>
      <td class="filasupe" colspan="3" bgcolor="#E8FF05" style="text-align: center;padding: 3px">SALDOS</td>
    </tr>
    <tr>
      <td class="filasupe" width="5%" style="text-align: center">UNIDADES</td>
      <td class="filasupe" width="5%" style="text-align: center">COSTO</td>
      <td class="filasupe" width="5%" style="text-align: center">TOTAL</td>
      <td class="filasupe" width="5%" style="text-align: center">UNIDADES</td>
      <td class="filasupe" width="5%" style="text-align: center">COSTO</td>
      <td class="filasupe" width="5%" style="text-align: center">TOTAL</td>
      <td class="filasupe" width="5%" style="text-align: center">UNIDADES</td>
      <td class="filasupe" width="5%" style="text-align: center">COSTO</td>
      <td class="filasupe" width="5%" style="text-align: center">TOTAL</td>
    </tr> ';
         
         
         while ($y=$this->bd->obtener_fila($stmt21)){
             $costo    = $y['costo'];
             $tipo     = $y['tipo'];
             $cantidad = $y['cantidad'];
             
             // $total    = $y['total_variable']; //  SIN IVA
             $total    = $y['total']; // CON IVA
             
             $ingreso  =  $y['ingreso'];
             $egreso   =  $y['egreso'];
             $producto =  $y['producto'];
              
             if ( $i == 1) {
                 
                 if ( $tipo == 'I') {
                     $total_cantidad = $total_cantidad + $cantidad;
                     $total_saldo    = $total_saldo + $total;
                     $tota_promedio  = $total_saldo / $total_cantidad;
                     $tota_lifo      = $costo;
                     $costo_ingreso  = $tota_promedio;
                     $total_ingreso  = $total ;
                     $costo_egreso   = '0.00';
                     $total_egreso   = '0.00';
                 }
                 
             }else{
                 
                 if ( $tipo == 'I') {
                     
                     $total_cantidad = $total_cantidad + $cantidad;
                     $total_saldo    = round($total_saldo + $total,2);
                     $tota_promedio  = round($total_saldo / $total_cantidad,4);
                     $tota_lifo      = $costo;
                     $costo_ingreso  = $costo;
                     $total_ingreso  = $costo *$cantidad ;
                     $costo_egreso   = '0.00';
                     $total_egreso   = '0.00';
                 }else {
                     
                     $total_egreso   = $cantidad * $tota_promedio;
                     $total_cantidad = $total_cantidad - $cantidad;
                     
                      
                     //---6.83 -- 0 --3.415
                     
                     $total_saldo    = round($total_saldo,2) - $total_egreso;
                      
                     if ( $total_cantidad == 0 ){
                         $tota_promedio = $tota_promedio;
                     }else{
                         $tota_promedio  = round($total_saldo / $total_cantidad,4);
                     }
                     
                     $costo_ingreso  = '0.00';
                     $total_ingreso  = '0.00';
                     $costo_egreso   = $tota_promedio;
                     $total_egreso   = $total ;
                 }
                 
             }
             //-----------------------------------------------------------------
             echo ' <tr><td>'. $y['fecha'].'</td>
                      <td class="filasupe"  style="padding: 3px">'. $y['id_movimiento'].'</td>
                      <td class="filasupe" style="padding: 3px">'. $y['comprobante'].'</td>
                      <td class="filasupe" style="padding: 3px">'. $y['razon'].'</td>
                      <td class="filasupe" style="padding: 3px">'. $y['detalle'].'</td>
                      <td class="filasupe" align="right" valign="middle" style="padding: 3px">'. $ingreso.'</td>
                      <td class="filasupe" align="right" valign="middle" style="padding: 3px">'. round($costo_ingreso,4).'</td>
                      <td class="filasupe" align="right" valign="middle" style="padding: 3px">'. round($total_ingreso,2).'</td>
                      <td class="filasupe" align="right" valign="middle" style="padding: 3px">'. $egreso.'</td>
                      <td class="filasupe" align="right" valign="middle" style="padding: 3px">'. round($costo_egreso,4).'</td>
                      <td class="filasupe" align="right" valign="middle" style="padding: 3px">'. round($total_egreso,2).'</td>
                      <td class="filasupe" align="right" valign="middle" style="padding: 3px">'. $total_cantidad.'</td>
                      <td class="filasupe" align="right" valign="middle" style="padding: 3px">'. round($tota_promedio,4).'</td>
                       <td class="filasupe" align="right" valign="middle" style="padding: 3px">'. round($total_saldo,2).'</td>
                    </tr>';
             
             $i ++;
         }
         
    echo '</tbody> </table>';
     
    
    
    echo '	<div class="col-md-12" style="padding: 25px"><h4><b>RESUMEN PRODUCTO </b></h4>';
    
    echo '<h4>'.$producto.' </h4>';
    echo '<h4>COSTO   :'.round($tota_promedio,2).' </h4>';
    echo '<h4>UNIDADES   :'.round($total_cantidad,2).' </h4>';
    echo '<h4>SALDO   :'.round($total_saldo,2).' </h4>';
    echo '<h4>LIFO    :'.round($tota_lifo,2).' </h4>';
    
   
    echo '</div>';
		 
		 
   }
 //----------------------------------------------
//----------------------------------------------
   function header_titulo($titulo){
          $this->set->header_titulo($titulo);
   }  
    
 
  //----------------------------------------------
  //----------------------------------------------
 
  
 }    
  
 $gestion   = 	new componente;
 
       
       $id     = $_GET['iditem']; 
       $fecha1 = $_GET['fecha1']; 
       $fecha2 = $_GET['fecha2']; 
 
       $gestion->Formulario( $id,$fecha1,$fecha2 );
   
 
   
?>
 
  
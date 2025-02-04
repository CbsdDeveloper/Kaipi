<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
	
 
	
	private $obj;
	private $bd;
	
	private $ruc;
	private $sesion;
	private $hoy;
	private $POST;
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function proceso( ){
 
		
		$this->obj     = 	new objects;
		$this->bd	   =	new Db ;
		
		$this->ruc       =  trim($_SESSION['ruc_registro']);
		$this->sesion 	 =  trim($_SESSION['email']);
		$this->hoy 	     =  $this->bd->hoy();
		
		$this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
		
	}
   
 
	function grilla( $f1,$f2 ){
		
  
	    $this->_cabecera(  );
 	     
	    $sqlO2= "SELECT  idproducto,producto,sum(cantidad) as cantidad,
	    round(avg(costo_producto),2) as costo_unitario,
	    round(avg(costo),2) as venta_unitario,
	    round(sum(costo_producto),2)  as total_costo,
	    round(sum(costo),2)  as total_venta
	    FROM public.view_mov_aprobado 
        where tipo = 'F' and 
              estado = 'aprobado' and 
              registro =".$this->bd->sqlvalue_inyeccion( $this->ruc,true)."  and 
              fecha BETWEEN  ".$this->bd->sqlvalue_inyeccion($f1,true).' and '.$this->bd->sqlvalue_inyeccion($f2,true)." 
	    group by idproducto,producto
	    order by cantidad desc";
	    
	    
	    echo '<h3><b>Analisis periodo de [ '. $f1.' ] - [ '. $f2.' ]</b></h3>'; 
	    
	    $stmt_TA = $this->bd->ejecutar($sqlO2);
	    
	    
	    $t1 = 0;
	    $t2 = 0;
	    $t3 = 0;
	    
	    while ($z=$this->bd->obtener_fila($stmt_TA)){
	        
	        $idproducto         = $z['idproducto'];
	        $producto           = trim($z['producto']). ' ( '.$z['cantidad'].' )'; 
	        
	       // $costo_unitario         = $z['costo_unitario'];
	       
	        $costo_unitario         = $this->_costo_fecha($idproducto,$f1,$f2);
	        $costo_unitario1        = $costo_unitario;
	        
	        
	        $venta_unitario         = $z['venta_unitario'];
	        $total_costo            = $costo_unitario1  * $z['cantidad'];
	        $total_venta            = $z['venta_unitario'] * $z['cantidad'];
 
	        $costo_unitario1 = $costo_unitario;
	        $total_costo1    = $total_costo;
	             
	        if ( $costo_unitario  <= 0 ){
	            $costo_unitario = 0;
	            $costo_unitario1 = 1;
	            $total_costo = 0;
	            $total_costo1= 1;
	            
	        }
	            
	        
	        
	        $variacion = (($venta_unitario - $costo_unitario) / $costo_unitario1) * 100;
	        
	        $diferencia = $total_venta - $total_costo;
	        
	        $variacion2 = (($total_venta - $total_costo) / $total_costo1) * 100;
	        
	        
	        if ( $variacion == 0 && $variacion < 5 ){
	            $imagen = '<img src="../../kimages/if_bullet_red_35785.png" class="media-object" style="width:18px">';
	        }
	        
	        if ( $variacion > 5 && $variacion < 10 ){
	            $imagen = '<img src="../../kimages/if_bullet_orange_35781.png" class="media-object" style="width:18px">';
	        }
	        
	        if ( $variacion > 10 && $variacion < 20 ){
	            $imagen = '<img src="../../kimages/if_bullet_yellow_35791.png" class="media-object" style="width:18px">';
	        }
	        
	        if ( $variacion > 20 && $variacion < 100000 ){
	            $imagen = '<img src="../../kimages/if_bullet_green_35779.png" class="media-object" style="width:18px">';
	        }
	        
	        
	           
	        echo '<tr>
              <td>'.$idproducto.'</td>
              <td>'.$producto.'</td>
              <td style="font-size: 12px;padding: 5px;text-align: right">'.$venta_unitario.'</td>
              <td style="font-size: 12px;padding: 5px;text-align: right">'.$costo_unitario.'</td>
              <td style="font-size: 12px;padding: 5px;text-align: right">'.round($variacion,2).' %'.'</td>
              <td style="font-size: 12px;padding: 5px;text-align: right">'.$total_venta.'</td>
             <td style="font-size: 12px;padding: 5px;text-align: right">'.$total_costo.'</td> 
             <td style="font-size: 12px;padding: 5px;text-align: right">'.$diferencia.'</td>
             <td style="font-size: 12px;padding: 5px;text-align: right">'.round($variacion2,2).' %'.'</td>
             <td style="font-size: 12px;padding: 5px;text-align: center">'.$imagen.'</td>
            </tr>';
	        
	        $t1 = $total_venta + $t1 ;
	        $t2 = $total_costo + $t2;
	        $t3 = $diferencia  + $t3;
	    }
	    
	    $variacion2 = round((($t1 - $t2) / $t2) * 100,2).' %';
	    
	     echo '<tr>
              <td></td>
              <td></td>
              <td style="font-size: 12px;padding: 5px;text-align: right"></td>
              <td style="font-size: 12px;padding: 5px;text-align: right"></td>
              <td style="font-size: 12px;padding: 5px;text-align: right"></td>
              <td style="font-size: 12px;padding: 5px;text-align: right"><b>'.$t1.'</b></td>
             <td style="font-size: 12px;padding: 5px;text-align: right"><b>'.$t2.'</b></td>
             <td style="font-size: 12px;padding: 5px;text-align: right"><b>'.$t3.'</b></td>
             <td style="font-size: 12px;padding: 5px;text-align: right"><b>'.$variacion2.'</b></td>
             <td style="font-size: 12px;padding: 5px;text-align: center"></td>
            </tr>';
	    
	     
	    echo '</table>' ;
 
	}
  ///------------------------------------------
	function _cabecera(  ){
	    
	 
	    echo '<table id="TableAnalisis" class="display table table-striped table-bordered dataTable no-footer" cellspacing="0" width="100%" style="width: 100%;">
  <tbody>
    <tr>
      <td width="5%"  bgcolor="#A5CAE1">Codigo</td>
      <td width="39%"  bgcolor="#A5CAE1">Producto</td>
      <td width="7%" bgcolor="#A5CAE1">Venta</td>
      <td width="7%" bgcolor="#A5CAE1">Costo</td>
      <td width="7%" bgcolor="#A5CAE1">(%) Utilidad</td>
      <td width="7%" bgcolor="#A5CAE1">Venta Total ($)</td>
      <td width="7%" bgcolor="#A5CAE1">Costo Total ($)</td>
      <td width="7%" bgcolor="#A5CAE1">Ganancia ($)</td>
      <td width="7%" bgcolor="#A5CAE1">(%) Utilidad</td>
      <td width="7%" bgcolor="#A5CAE1">Indicador</td>
   </tr>';
	    
	}
	
	//----------------------
	function _costo_fecha( $idproducto,$f1,$f2  ){
	    
	    $f11 = '2019-01-01';
	    
	    $sql_det =' SELECT  fecha, tipo, costo,cantidad,total,ingreso,egreso,(cantidad * costo) as total_variable
        FROM  view_mov_aprobado
        WHERE idproducto= '.$this->bd->sqlvalue_inyeccion($idproducto,true).' and 
              fecha between '.$this->bd->sqlvalue_inyeccion($f11,true).' and '.$this->bd->sqlvalue_inyeccion($f2,true).' 
        order by fecha asc,tipo asc';
	    
	    
	    
	    $stmt21 = $this->bd->ejecutar($sql_det);
	    
	    $i = 1;
	    
	    $total_saldo    = 0;
	    $total_cantidad = 0;
	    $tota_promedio  = 0;
 	    
	    
	    while ($y=$this->bd->obtener_fila($stmt21)){
	        $costo    = $y['costo'];
	        $tipo     = $y['tipo'];
	        $cantidad = $y['cantidad'];
	        $total    = $y['total_variable'];
	        
	        if ( $i == 1) {
	            if ( $tipo == 'I') {
	                $total_cantidad = $total_cantidad + $cantidad;
	                $total_saldo    = $total_saldo + $total;
	                $tota_promedio  = $total_saldo / $total_cantidad;
 	            }
	        }else{
	            
	            if ( $tipo == 'I') {
	                
	                $total_cantidad = $total_cantidad + $cantidad;
	                $total_saldo    = round($total_saldo + $total,2);
	                $tota_promedio  = round($total_saldo / $total_cantidad,4);
 	                
	            }else {
	                
	                $total_egreso   = $cantidad * $tota_promedio;
	                
	                $total_cantidad = $total_cantidad - $cantidad;
	                
	                $total_saldo    = round($total_saldo - $total_egreso,2);
	                $tota_promedio  = round($total_saldo / $total_cantidad,4);
	                
	                if ( $total_cantidad == 0 ){
	                    $tota_promedio = 0;
	                }
	                
	                
 	                
	            }
	            
	        }
	        
	        $i ++;
	    }
	    
 
 	    return $tota_promedio;
	    
	    
	}
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;

 

//------ grud de datos insercion
if (isset($_GET["fecha1"]))	{
	
    $f1 			    =     $_GET["fecha1"];
    $f2 				=     $_GET["fecha2"];
     
     
    $gestion->grilla( $f1,$f2);
 
	
}



?>
 
  
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
	
	private $compa;
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function proceso( ){
		//inicializamos la clase para conectarnos a la bd
		
		$this->obj     = 	new objects;
		$this->bd	   =	new Db ;
		
		$this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
		
		$this->ruc       =  $_SESSION['ruc_registro'];
		
		$this->sesion 	 =  trim($_SESSION['email']);
		
		$this->hoy 	     =  date("Y-m-d");
		
		$this->login     =  trim($_SESSION['login']);
 		
		$this->anio       =  $_SESSION['anio'];
		
		$this->compa      = 'N';
		
	}
   
	//--- calcula libro diario
	function grilla( $f1,$f2,$tipo,$nivel,$auxiliares,$com1){
		
 
		if ( $nivel > 6 ){
		    $nivel = 5;
		}
	    
		$this->compa = $com1;
		
		
		echo '<div class="col-md-12" align="center" style="padding-bottom:10;padding-top:15px"> ';
		
		$this->titulo($f1,$f2);
		
		echo '</div> ';
		
		echo '<div class="col-md-6" style="padding: 30px">  ';
		
		echo '<h5 style="background-color:#d9edf7;padding: 5px;"><b>ACTIVO</b></h5>';
		
		$this->cabecera('CORRIENTE',$com1);
		$suma1 = $this->Bloque_Activo($f1,$f2,1,1);
 		
		$valida = $this->Bloque_Activo_verifica($f1,$f2,1,2);
 		if ( $valida  <> 0 ){
		    $this->cabecera('INVERSIONES',$com1);
		    $suma2 = $this->Bloque_Activo($f1,$f2,1,2);
		}
		
		$valida = $this->Bloque_Activo_verifica($f1,$f2,1,3);
		if ( $valida  <> 0 ){
		    $this->cabecera('DEUDORES FINANCIEROS',$com1);
		    $suma3 = $this->Bloque_Activo($f1,$f2,1,3);
		}
		
		$valida = $this->Bloque_Activo_verifica($f1,$f2,1,4);
		if ( $valida  <> 0 ){
		    $this->cabecera('INVERSIONES EN BIENES DE LARGA DURACION',$com1);
		    $suma4 = $this->Bloque_Activo($f1,$f2,1,4);
		}
		
		$valida = $this->Bloque_Activo_verifica($f1,$f2,1,5);
		if ( $valida  <> 0 ){
		    $this->cabecera('OTROS ACTIVOS FINANCIEROS',$com1);
		    $suma5 = $this->Bloque_Activo($f1,$f2,1,5);
		}
	
		$valida = $this->Bloque_Activo_verifica($f1,$f2,1,6);
		if ( $valida  <> 0 ){
		    $this->cabecera('INVERSIONES EN PROYECTOS Y PROGRAMAS',$com1);
		    $suma6 = $this->Bloque_Activo($f1,$f2,1,6);
		}
 
		
		$activo = $suma1  + $suma2  + $suma3 + $suma4 + $suma5 + $suma6;
		
		echo '<h5 align="right" style="background-color: #d9edf7;padding: 5px"><b> TOTAL ACTIVO '.number_format($activo ,2).'</b></h5>';
 
		echo '</div> ';
		
		echo '<div class="col-md-6" style="padding: 30px">  ';
		
		echo '<h5  style="background-color: #d9edf7;padding: 5px"><b>PASIVO</b></h5>';
		
		$this->cabecera('CORRIENTE',$com1);
		$suma1 = $this->Bloque_Pasivo($f1,$f2,2,1);
		
		
		$valida = $this->Bloque_Pasivo_verifica($f1,$f2,2,2);
		if ( $valida  <> 0 ){
		    $this->cabecera('LARGO PLAZO',$com1);
		    $suma2 = $this->Bloque_Pasivo($f1,$f2,2,2);
		}
		
		$valida = $this->Bloque_Pasivo_verifica($f1,$f2,2,3);
		if ( $valida  <> 0 ){
		    $this->cabecera('PROVISIONES',$com1);
		    $suma3 = $this->Bloque_Pasivo($f1,$f2,2,3);
		}
  	
		
		$pasivo = $suma1  + $suma2  + $suma3 ;
		
		echo '<h5 align="right" style="background-color: #d9edf7;padding: 5px"><b>PASIVO '.number_format($pasivo ,2).'</b></h5>';
		
		echo '<h5><b>PATRIMONIO</b></h5>';
		
		$this->cabecera('OTROS',$com1);
		$patrimonio = $this->Bloque_Patrimonio($f1,$f2,3,1);
		
		echo '<h5 align="right" style="background-color: #d9edf7;padding: 5px"><b>PATRIMONIO '.number_format($patrimonio  ,2).'</b></h5>';
 		
		 
		$totalp = $pasivo + $patrimonio ;
		
		
//		echo '<h5 align="right"><b>ACTIVO '.number_format($activo ,2).' </b></h5>';
		
		echo '<h5 align="right"><b>PASIVO + PATRIMONIO '.number_format($totalp ,2).' </b></h5>';
		
		echo '</div><hr>';
		
		
		$this->firmas( );
		
		 
 
	}
 
	function BuscaTotal($f1,$f2,$cuenta,$cuenta1='',$cuenta2=''){
		
	   
	 
		$wheref = '( fecha BETWEEN '.$this->bd->sqlvalue_inyeccion(trim($f1),true)." and ".
		                             $this->bd->sqlvalue_inyeccion(trim($f2),true)." ) ";
		
		                             
	 if ( trim($cuenta) == '618.03'){
	     
	     $ingreso = $this->bd->query_array('co_diario',
	         'sum(debe) as debe, sum(haber) as haber',
	         'anio='.$this->bd->sqlvalue_inyeccion($this->anio,true). ' and
                                            cuenta like '.$this->bd->sqlvalue_inyeccion('62%',true). ' and  '.$wheref
	         );
	     
 
	     
	     $gasto = $this->bd->query_array('co_diario',
	         'sum(debe) as debe, sum(haber) as haber',
	         'anio='.$this->bd->sqlvalue_inyeccion($this->anio,true). ' and
                                            cuenta like '.$this->bd->sqlvalue_inyeccion('63%',true). ' and  '.$wheref
	         );
	     
	     $saldo =  ($gasto["debe"]  -  $ingreso["haber"]  )  ;
	     
	     
	     
	 }else{
 
	     $datos = $this->bd->query_array('co_diario',
	         'sum(debe) as debe, sum(haber) as haber',
	         'anio='.$this->bd->sqlvalue_inyeccion($this->anio,true). ' and
                                            cuenta like '.$this->bd->sqlvalue_inyeccion($cuenta.'%',true). ' and  '.$wheref
	         );
	     
	     $saldo = $datos["debe"] -  $datos["haber"] ;
	     
	 }
	 
	 if ( $cuenta == '151'){
	     
	     $datos = $this->bd->query_array('co_diario',
	         'sum(debe) as debe, sum(haber) as haber',
	         'anio='.$this->bd->sqlvalue_inyeccion($this->anio,true). ' and
                                            cuenta like '.$this->bd->sqlvalue_inyeccion($cuenta.'%',true). ' and  '.$wheref
	         );
	     
	     $saldo = $datos["debe"]  ;
	     
	 }
	 
	 if ( $cuenta == '152'){
	     
	   
	     
	     $datos = $this->bd->query_array('co_diario',
	         'sum(debe) - sum(haber) as saldo',
	         'anio='.$this->bd->sqlvalue_inyeccion($this->anio,true). ' and
                   cuenta like '.$this->bd->sqlvalue_inyeccion($cuenta.'%',true). ' and  '.$wheref
	         );
	     
	     $datose = $this->bd->query_array('co_diario',
	         'sum(debe) - sum(haber) as saldo',
	         'anio='.$this->bd->sqlvalue_inyeccion($this->anio,true). ' and
                   cuenta like '.$this->bd->sqlvalue_inyeccion($cuenta1.'%',true). ' and  '.$wheref
	         );
	     
	     
	     $saldo = $datos["saldo"] -  $datose["saldo"] ;
	     
	     
	 }
 		           
		
	 if ( $cuenta == '141.99'){
	     
	     $datos = $this->bd->query_array('co_diario',
	         'sum(debe) as debe, sum(haber) as haber',
	         'anio='.$this->bd->sqlvalue_inyeccion($this->anio,true). ' and
                                            cuenta like '.$this->bd->sqlvalue_inyeccion($cuenta.'%',true). ' and  '.$wheref
	         );
	     
	     $saldo = $datos["haber"] * -1;
	 }
		
	 if ( $cuenta == '142.99'){
	     
	     $datos = $this->bd->query_array('co_diario',
	         'sum(debe) as debe, sum(haber) as haber',
	         'anio='.$this->bd->sqlvalue_inyeccion($this->anio,true). ' and
                                            cuenta like '.$this->bd->sqlvalue_inyeccion($cuenta.'%',true). ' and  '.$wheref
	         );
	     
	     $saldo = $datos["haber"] * -1;
	 }
	 
	 if ( $cuenta == '143.99'){
	     
	     $datos = $this->bd->query_array('co_diario',
	         'sum(debe) as debe, sum(haber) as haber',
	         'anio='.$this->bd->sqlvalue_inyeccion($this->anio,true). ' and
                                            cuenta like '.$this->bd->sqlvalue_inyeccion($cuenta.'%',true). ' and  '.$wheref
	         );
	     
	     $saldo = $datos["haber"] * -1;
	 }
	 
	 if ( $cuenta == '141'){
	     
	     $datos = $this->bd->query_array('co_diario',
	         'sum(debe) as debe, sum(haber) as haber',
	         'anio='.$this->bd->sqlvalue_inyeccion($this->anio,true). ' and
                                            cuenta like '.$this->bd->sqlvalue_inyeccion($cuenta.'%',true). ' and  '.$wheref
	         );
	     
	     $saldo = $datos["debe"] ;
	 }
	 
	 
	 if ( $cuenta == '142'){
	     
	     $datos = $this->bd->query_array('co_diario',
	         'sum(debe) as debe, sum(haber) as haber',
	         'anio='.$this->bd->sqlvalue_inyeccion($this->anio,true). ' and
                                            cuenta like '.$this->bd->sqlvalue_inyeccion($cuenta.'%',true). ' and  '.$wheref
	         );
	     
	     $saldo = $datos["debe"] ;
	 }
	 
	 if ( $cuenta == '143'){
	     
	     $datos = $this->bd->query_array('co_diario',
	         'sum(debe) as debe, sum(haber) as haber',
	         'anio='.$this->bd->sqlvalue_inyeccion($this->anio,true). ' and
                                            cuenta like '.$this->bd->sqlvalue_inyeccion($cuenta.'%',true). ' and  '.$wheref
	         );
	     
	     $saldo = $datos["debe"] ;
	 }
	 
	 //---------------------------------------------------------------------
	 if ( $cuenta == '126.99'){
	     
	     $datos = $this->bd->query_array('co_diario',
	         'sum(debe) as debe, sum(haber) as haber',
	         'anio='.$this->bd->sqlvalue_inyeccion($this->anio,true). ' and
                                            cuenta like '.$this->bd->sqlvalue_inyeccion($cuenta.'%',true). ' and  '.$wheref
	         );
	     
	     $saldo = $datos["haber"] * -1;
	 }
	 
	 if ( $cuenta == '126'){
	     
	     $datos = $this->bd->query_array('co_diario',
	         'sum(debe) as debe, sum(haber) as haber',
	         'anio='.$this->bd->sqlvalue_inyeccion($this->anio,true). ' and
                                            cuenta like '.$this->bd->sqlvalue_inyeccion($cuenta.'%',true). ' and  '.$wheref
	         );
	     
	     $saldo = $datos["debe"] ;
	 }
	 
		return  $saldo;
	 
	}
	//-----------------------
	function BuscaTotal_anterior($f1,$f2,$cuenta){
	    
	    
	    $anio = $this->anio - 1;
	    
	    $wheref = ' ';
	   	    
	   	    
	   	    if ( $cuenta == '618'){
	   	        
	   	        $ingreso = $this->bd->query_array('co_diario',
	   	            'sum(debe) as debe, sum(haber) as haber',
	   	            'anio='.$this->bd->sqlvalue_inyeccion($anio,true). ' and
                     cuenta like '.$this->bd->sqlvalue_inyeccion('62%',true).$wheref
	   	            );
	   	        
	   	        
	   	        
	   	        $gasto = $this->bd->query_array('co_diario',
	   	            'sum(debe) as debe, sum(haber) as haber',
	   	            'anio='.$this->bd->sqlvalue_inyeccion($anio,true). ' and
                     cuenta like '.$this->bd->sqlvalue_inyeccion('63%',true).$wheref
	   	            );
	   	        
	   	        $saldo =  ($gasto["debe"]  -  $ingreso["haber"]  )  ;
	   	        
	   	        
	   	        
	   	    }else{
	   	        
	   	        $datos = $this->bd->query_array('co_diario',
	   	            'sum(debe) as debe, sum(haber) as haber',
	   	            'anio='.$this->bd->sqlvalue_inyeccion($anio,true). ' and
                     cuenta like '.$this->bd->sqlvalue_inyeccion($cuenta.'%',true).$wheref
	   	            );
	   	        
	   	        $saldo = $datos["debe"] -  $datos["haber"] ;
	   	        
	   	    }
	   	    
	   	    if ( $cuenta == '151'){
	   	        
	   	        $datos = $this->bd->query_array('co_diario',
	   	            'sum(debe) as debe, sum(haber) as haber',
	   	            'anio='.$this->bd->sqlvalue_inyeccion($anio,true). ' and
                     cuenta like '.$this->bd->sqlvalue_inyeccion($cuenta.'%',true).$wheref
	   	            );
	   	        
	   	        $saldo = $datos["debe"]  ;
	   	        
	   	    }
	   	    
	   	    if ( $cuenta == '152'){
	   	        
	   	        $datos = $this->bd->query_array('co_diario',
	   	            'sum(debe) as debe, sum(haber) as haber',
	   	            'anio='.$this->bd->sqlvalue_inyeccion($anio,true). ' and
                     cuenta like '.$this->bd->sqlvalue_inyeccion($cuenta.'%',true).$wheref
	   	            );
	   	        
	   	        $saldo = $datos["debe"] ;
	   	    }
	   	    
	   	    
	   	    if ( $cuenta == '141.99'){
	   	        
	   	        $datos = $this->bd->query_array('co_diario',
	   	            'sum(debe) as debe, sum(haber) as haber',
	   	            'anio='.$this->bd->sqlvalue_inyeccion($anio,true). ' and
                    cuenta like '.$this->bd->sqlvalue_inyeccion($cuenta.'%',true). $wheref
	   	            );
	   	        
	   	        $saldo = $datos["haber"] * -1;
	   	    }
	   	    
	   	    
	   	    if ( $cuenta == '141'){
	   	        
	   	        $datos = $this->bd->query_array('co_diario',
	   	            'sum(debe) as debe, sum(haber) as haber',
	   	            'anio='.$this->bd->sqlvalue_inyeccion($anio,true). ' and
                     cuenta like '.$this->bd->sqlvalue_inyeccion($cuenta.'%',true).$wheref
	   	            );
	   	        
	   	        $saldo = $datos["debe"] ;
	   	    }
	   	    
	   	    
	   	    return  $saldo;
	   	    
	}
	//----------------------------------------------------------
	function cabecera($titulo,$com1){
	    
	    
	    $anio = $this->anio - 1;
	    
	    $cadena = '';
	    
	    echo '<table  class="table table-bordered" width="100%" style="font-size: 13px;table-layout: auto">';
	    
	    if ( $com1 == 'S'){
	        $cadena = '<td align="right" bgcolor="#f9f9f9" style="color: #474747" width="15%">Dic ('.$anio.')</td>';
	        
	        $cadena0 = '<td align="right" bgcolor="#f9f9f9" style="color: #474747" width="15%">Dic ('.$this->anio.')</td>';
	        
	        echo ' <tr>
                  <td><b>'.$titulo.'</b></td>'.$cadena0.$cadena.'
                 </tr>
                <tr>';
	        
	    }else{
	        
	        echo ' <tr>
                  <td colspan="2"><b>'.$titulo.'</b></td>'.$cadena.'
                 </tr>
                <tr>';
	    }
	    
	   
	  
	   
	/*
	     echo ' <tr>
                  <td colspan="3"><b>'.$titulo.'</b></td>
                 </tr>
                <tr>
                   <td align="center" width="70%">Denominacion</td>
                   <td align="right"  width="15%">Vigente<br> ('.$this->anio.')</td>'.$cadena.'
                </tr>';
                
              
 
	    echo '  <tr>
                   <td align="center" width="70%">Denominacion</td>
                   <td align="right"  width="15%">Vigente<br> ('.$this->anio.')</td>'.$cadena.'
                </tr>';  */
	    
	}
	//--------------------
	public function Bloque_Activo( $f1,$f2,$orden1,$orden2 ){
	    
	 
	    $sql = 'SELECT    grupo2, grupo3, cuenta, sinsigno, consigno, excepcion_cuenta_desde, excepcion_cuenta_hasta, anio
                    FROM presupuesto.matriz_situacion
                    where orden1 = '.$this->bd->sqlvalue_inyeccion( $orden1 ,true).' and 
                          orden2 =  '.$this->bd->sqlvalue_inyeccion( $orden2 ,true).' and 
                          anio='.$this->bd->sqlvalue_inyeccion($this->anio ,true).' order by orden3';
 
	    
	    $stmt = $this->bd->ejecutar($sql);
	    
	    $inicial_debe = 0;
	    $inicial_debea = 0;
	    
	    while ($x=$this->bd->obtener_fila($stmt)){
	        
	        $cuenta = trim($x['cuenta']);
	        
	        $cuenta1 = trim($x['excepcion_cuenta_desde']);
	        
	        $cuenta2 = trim($x['excepcion_cuenta_hasta']);
	        
	        $saldo = $this->BuscaTotal($f1,$f2,$cuenta,$cuenta1,$cuenta2);
	        
	      
	        if ( $saldo <> 0 ){
	        
    	        echo "<tr>";
    	        // echo "<td>".'SG '.$x['cuenta']."</td>";
    	        echo "<td>".$x['grupo3']."</td>";
    	        
    	        echo "<td align='right'>".number_format($saldo,2)."</td>";
    	        
    	        if (   $this->compa == 'S'){
    	            $saldo_anterior = $this->BuscaTotal_anterior($f1,$f2,$cuenta);
    	            echo "<td bgcolor='#f9f9f9' style='color: #474747' align='right'>".number_format($saldo_anterior,2)."</td></tr>";
    	        
    	            $inicial_debea =  $inicial_debea + $saldo_anterior;
    	            
    	        }else{
    	            echo "</tr>";
    	        }
     	        
    	        
    	        $inicial_debe = $inicial_debe + $saldo;
	        }
	      
	    }
	        
	    echo "<tr>";
	   // echo "<td></td>";
	    echo "<td></td>";
	    echo "<td align='right'>".number_format($inicial_debe,2)."</td>";
	    
	    if (   $this->compa == 'S'){
	        echo "<td bgcolor='#f9f9f9' style='color: #474747' align='right'>".number_format($inicial_debea,2)."</td></tr>";
	    }else{
	        echo "</tr>";
	    }
	  
	    
	  echo '</table>';
	    
	  return $inicial_debe;
	}
	//----------------------
	public function Bloque_Activo_verifica( $f1,$f2,$orden1,$orden2 ){
	    
	    
	    $sql = 'SELECT    grupo2, grupo3, cuenta, sinsigno, consigno, excepcion_cuenta_desde, excepcion_cuenta_hasta, anio
                    FROM presupuesto.matriz_situacion
                    where orden1 = '.$this->bd->sqlvalue_inyeccion( $orden1 ,true).' and
                          orden2 =  '.$this->bd->sqlvalue_inyeccion( $orden2 ,true).' and
                          anio='.$this->bd->sqlvalue_inyeccion($this->anio ,true).' order by orden3';
	    
	    
	    $stmt = $this->bd->ejecutar($sql);
	    
	    $inicial_debe = 0;
 	    
	    while ($x=$this->bd->obtener_fila($stmt)){
	        
	        $cuenta = trim($x['cuenta']);
	        
	        $cuenta1 = trim($x['excepcion_cuenta_desde']);
	        
	        $cuenta2 = trim($x['excepcion_cuenta_hasta']);
	        
	        $saldo = $this->BuscaTotal($f1,$f2,$cuenta,$cuenta1,$cuenta2);
	        
	        
	        if ( $saldo <> 0 ){
 	            
	            $inicial_debe = $inicial_debe + $saldo;
	        }
	        
	    }
	  
	    
 	    
	    return $inicial_debe;
	}
	//--- ultimo nivel
	public function Bloque_Pasivo( $f1,$f2,$orden1,$orden2 ){
	    
 	    
	    $sql = 'SELECT    grupo2, grupo3, cuenta, sinsigno, consigno, excepcion_cuenta_desde, excepcion_cuenta_hasta, anio
                    FROM presupuesto.matriz_situacion
                    where orden1 = '.$this->bd->sqlvalue_inyeccion( $orden1 ,true).' and
                          orden2 =  '.$this->bd->sqlvalue_inyeccion( $orden2 ,true).' and
                          anio='.$this->bd->sqlvalue_inyeccion($this->anio ,true).' order by grupo3';
	    
 	    $stmt = $this->bd->ejecutar($sql);
 	    
	    $inicial_debe = 0;
	    
	    $inicial_debea = 0;
	    
	    while ($x=$this->bd->obtener_fila($stmt)){
	        
	        $cuenta = trim($x['cuenta']);
	        
	        $saldo = $this->BuscaTotal($f1,$f2,$cuenta);
	        
	        if ( $saldo <> 0 ){
        	        
        	        echo "<tr>";
        	   //     echo "<td><b>".'SG '.$x['cuenta']."</b></td>";
        	        echo "<td>".$x['grupo3']."</td>";
        	        echo "<td align='right'>".number_format(abs($saldo) ,2)."</td>";
        	        
        	        if (   $this->compa == 'S'){
         	            $saldo_anterior = $this->BuscaTotal_anterior($f1,$f2,$cuenta);
        	            echo "<td bgcolor='#f9f9f9' style='color: #474747' align='right'>".number_format(abs($saldo_anterior),2)."</td></tr>";
        	            $inicial_debea =  $inicial_debea + $saldo_anterior;
        	        }else{
        	            echo "</tr>";
        	        }
	        }
	        
	        $inicial_debe = $inicial_debe + $saldo;
	        
	       
	    }
	    
	    echo "<tr>";
	 //   echo "<td></td>";
	    echo "<td></td>";
	    echo "<td align='right'>".number_format(abs($inicial_debe),2)."</td>";
	    
	    if (   $this->compa == 'S'){
	        echo "<td bgcolor='#f9f9f9' style='color: #474747' align='right'>".number_format(abs($inicial_debea),2)."</td></tr>";
	    }else{
	        echo "</tr>";
	    }
 
	 
	    
	    echo '</table>';
	    
	    return  abs($inicial_debe)  ;
	   
 
	}
	//----------------------
	public function Bloque_Pasivo_verifica( $f1,$f2,$orden1,$orden2 ){
	    
	    
	    $sql = 'SELECT    grupo2, grupo3, cuenta, sinsigno, consigno, excepcion_cuenta_desde, excepcion_cuenta_hasta, anio
                    FROM presupuesto.matriz_situacion
                    where orden1 = '.$this->bd->sqlvalue_inyeccion( $orden1 ,true).' and
                          orden2 =  '.$this->bd->sqlvalue_inyeccion( $orden2 ,true).' and
                          anio='.$this->bd->sqlvalue_inyeccion($this->anio ,true).' order by grupo3';
	    
	    $stmt = $this->bd->ejecutar($sql);
	    
	    $inicial_debe = 0;
	    
 	    
	    while ($x=$this->bd->obtener_fila($stmt)){
	        
	        $cuenta = trim($x['cuenta']);
	        
	        $saldo = $this->BuscaTotal($f1,$f2,$cuenta);
 
 	        
	        $inicial_debe = $inicial_debe + $saldo;
	        
	        
	    }
	     
	    
	    return  $inicial_debe  ;
	    
	    
	}
	//--- ultimo nivel
	public function Bloque_Patrimonio( $f1,$f2,$orden1,$orden2 ){
 
  
	    
	    $sql = 'SELECT    grupo2, grupo3, cuenta, sinsigno, consigno, excepcion_cuenta_desde, excepcion_cuenta_hasta, anio
                    FROM presupuesto.matriz_situacion
                    where orden1 = '.$this->bd->sqlvalue_inyeccion( $orden1 ,true).' and
                          orden2 =  '.$this->bd->sqlvalue_inyeccion( $orden2 ,true).' and
                          anio='.$this->bd->sqlvalue_inyeccion($this->anio ,true).' order by grupo3';
	    
	    
	    $stmt = $this->bd->ejecutar($sql);
	    
 	    $inicial_debe = 0;
	    
 	    $inicial_debea = 0;
 	    
	    while ($x=$this->bd->obtener_fila($stmt)){
	        
	        $cuenta = trim($x['cuenta']);
	        
	        $saldo = $this->BuscaTotal($f1,$f2,$cuenta);
	         
	        if ( $saldo <> 0 ){
    	        echo "<tr>";
    	      //  echo "<td><b>".'SG '.$x['cuenta']."</b></td>";
    	        echo "<td> ".$x['grupo3']." </td>";
    	        echo "<td align='right'>".number_format(abs($saldo),2)."</td>";
    	        
    	        if (   $this->compa == 'S'){
    	            $saldo_anterior = $this->BuscaTotal_anterior($f1,$f2,$cuenta);
    	            echo "<td bgcolor='#f9f9f9' style='color: #474747' align='right'>".number_format(abs($saldo_anterior),2)."</td></tr>";
    	            $inicial_debea =  $inicial_debea + $saldo_anterior;
    	        }else{
    	            echo "</tr>";
    	        }
	        }
	        
 	        
	        $inicial_debe = $inicial_debe + $saldo;
	        
	       
	    }
	    
	    echo "<tr>";
	   // echo "<td></td>";
	    echo "<td></td>";
	    echo "<td align='right'>".number_format(abs($inicial_debe),2)."</td>";
	    
	    if (   $this->compa == 'S'){
	        echo "<td bgcolor='#f9f9f9' style='color: #474747' align='right'>".number_format(abs($inicial_debea),2)."</td></tr>";
	    }else {
	        echo "</tr>";
	    }
	 
	    
	    echo '</table>';
	    
	    return abs($inicial_debe) ;
 	    
	}
//---------------
	function titulo($f1,$f2){
	    
	    
	    $this->hoy 	     =  date("Y-m-d");
	    
	    $this->login     =  trim($_SESSION['login']);
	    
	    
	    
	    $imagen = '<img src="../../kimages/'.trim($_SESSION['logo']).'">';
	    
	    echo '<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 14px;table-layout: auto">
              <tr>
                  <td width="20%" rowspan="2">'.$imagen.'</td>
                  <td  width="60%" rowspan="2" style="text-align: center"><b>'.$_SESSION['razon'].'</b><br>
                        <b>'.$_SESSION['ruc_registro'].'</b><br><br>
                        <b>CONTABILIDAD ( PERIODO '.$this->anio.' ) </b><br>
                        <b>ESTADO DE SITUACION FINANCIERA al '.$f2.'</b></td>
                  <td  width="20%">&nbsp;</td>
                </tr>
                <tr>
                  <td>FECHA '.$this->hoy .'<br>
                     USUARIO '.$this->login.' <br>
                     REPORTE</td>
                </tr>
 	   </table>';
	    
	}
	
	
	function firmas( ){
	    
		$cliente= 'CO-EF';
	   
		$reporte_pie   = $this->bd->query_array('par_reporte', 'pie', 'referencia='.$this->bd->sqlvalue_inyeccion( trim($cliente) ,true) );
	
		$pie_contenido = $reporte_pie["pie"];
	
		// NOMBRE / CARGO
		$a10 = $this->bd->query_array('wk_config','carpeta , carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(10,true));
		$pie_contenido = str_replace('#AUTORIDAD',trim($a10['carpeta']), $pie_contenido);
		 $pie_contenido = str_replace('#CARGO_AUTORIDAD',trim($a10['carpetasub']), $pie_contenido);
		
		 $a10 = $this->bd->query_array('wk_config','carpeta , carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(12,true));
		$pie_contenido = str_replace('#FINANCIERO',trim($a10['carpeta']), $pie_contenido);
		 $pie_contenido = str_replace('#CARGO_FINANCIERO',trim($a10['carpetasub']), $pie_contenido);
	
		 $a10 = $this->bd->query_array('wk_config','carpeta , carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(14,true));
		 $pie_contenido = str_replace('#CONTADOR',trim($a10['carpeta']), $pie_contenido);
		 $pie_contenido = str_replace('#CARGO_CONTADOR',trim($a10['carpetasub']), $pie_contenido);
	
		 $a10 = $this->bd->query_array('wk_config','carpeta , carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(13,true));
		 $pie_contenido = str_replace('#TESORERO',trim($a10['carpeta']), $pie_contenido);
		 $pie_contenido = str_replace('#CARGO_TESORERO',trim($a10['carpetasub']), $pie_contenido);

		 echo  $pie_contenido;
	    
	}
//----------------------------------------------------------------------------------------	
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;

 

//------ grud de datos insercion
if (isset($_POST["bgfecha1"]))	{
	
	$f1 			    =     $_POST["bgfecha1"];
	$f2 				=     $_POST["bgfecha2"];
	$tipo               =     $_POST["tipo"];
	$nivel			    =     $_POST["nivel"];
	$auxiliares			=     $_POST["auxiliares"];
	
	$com1			    =     $_POST["com1"];
	
 
	$gestion->grilla( $f1,$f2,$tipo,$nivel,$auxiliares,$com1);
 
 
	
}



?>
 
  
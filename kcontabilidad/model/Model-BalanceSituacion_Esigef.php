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
		
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
		
		$this->ruc       =  $_SESSION['ruc_registro'];
		
		$this->sesion 	 =  trim($_SESSION['email']);
		
		$this->hoy 	     =  date("Y-m-d");
		
		$this->login     =  trim($_SESSION['login']);
 		
		$this->anio       =  $_SESSION['anio'];
		
		$this->compa      = 'N';
		
	}
   
	//--- calcula libro diario
	function grilla( $f1,$f2,$tipo,$nivel,$auxiliares,$com1,$reporte){
		
 
		if ( $nivel > 7 ){
		    $nivel = 6;
		}
	    
		$this->compa = $com1;
		
		
		echo '<div class="col-md-12" align="center" style="padding-bottom:10;padding-top:15px"> ';
		
		$this->titulo($f1,$f2);
		
		echo '</div> ';
		
		echo '<div class="col-md-2"> </div><div class="col-md-7" style="padding: 30px">  ';
		
		echo '<h5><b>ACTIVO</b></h5>';
		
		$this->cabecera('CORRIENTE',$com1);
		$suma1 = $this->Bloque_Activo($f1,$f2,1,1,$reporte);
 		
		$this->cabecera('INVERSIONES',$com1);
		$suma2 = $this->Bloque_Activo($f1,$f2,1,2,$reporte);
		
		$this->cabecera('DEUDORES FINANCIEROS',$com1);
		$suma3 = $this->Bloque_Activo($f1,$f2,1,3,$reporte);
		
		$this->cabecera('INVERSIONES EN BIENES DE LARGA DURACION',$com1);
		$suma4 = $this->Bloque_Activo($f1,$f2,1,4,$reporte);
		
		$this->cabecera('OTROS ACTIVOS FINANCIEROS',$com1);
		$suma5 = $this->Bloque_Activo($f1,$f2,1,5,$reporte);
		
		$this->cabecera('INVERSIONES EN PROYECTOS Y PROGRAMAS',$com1);
		$suma6 = $this->Bloque_Activo($f1,$f2,1,6,$reporte);
		
		
		
		$activo = $suma1  + $suma2  + $suma3 + $suma4 + $suma5 + $suma6;
		
		echo '<h5 align="right" style="background-color: #F4F1C4;padding: 5px"><b> ACTIVO '.number_format($activo ,2).'</b></h5>';
 
		
		echo '<h5><b>PASIVO</b></h5>';
		
		$this->cabecera('CORRIENTE',$com1);
		$suma1 = $this->Bloque_Pasivo($f1,$f2,2,1,$reporte);
		
		$this->cabecera('LARGO PLAZO',$com1);
		$suma2 = $this->Bloque_Pasivo($f1,$f2,2,2,$reporte);
		
		$this->cabecera('PROVISIONES',$com1);
		$suma3 = $this->Bloque_Pasivo($f1,$f2,2,3,$reporte);
		
		$pasivo = $suma1  + $suma2  + $suma3 ;
		
		echo '<h5 align="right" style="background-color: #F4F1C4;padding: 5px"><b>PASIVO '.number_format($pasivo ,2).'</b></h5>';
		
		echo '<h5><b>PATRIMONIO</b></h5>';
		
		$this->cabecera('OTROS',$com1);
		$patrimonio = $this->Bloque_Patrimonio($f1,$f2,3,1,$reporte);
		
		echo '<h5 align="right" style="background-color: #F4F1C4;padding: 5px"><b>PATRIMONIO '.number_format($patrimonio  ,2).'</b></h5>';
		
		
		echo '<h5><b>CUENTAS ORDEN </b></h5>';
		
		$this->cabecera('CUENTAS DE ORDEN (+)',$com1);
		$orden1 = $this->Bloque_Patrimonio($f1,$f2,5,1,$reporte);
		
		echo '<h5 align="right" style="background-color: #F4F1C4;padding: 5px"><b>ORDEN (+) '.number_format($orden1 ,2).'</b></h5>';
		
		$this->cabecera('CUENTAS DE ORDEN (-)',$com1);
		$orden2= $this->Bloque_Patrimonio($f1,$f2,5,2,$reporte);
		
		echo '<h5 align="right" style="background-color: #F4F1C4;padding: 5px"><b>ORDEN (-) '.number_format($orden2 ,2).'</b></h5>';
	
		$totalp = $pasivo + $patrimonio ;
		
		
		echo '<h5 align="right"><b>ACTIVO '.number_format($activo ,2).' </b></h5>';
		
		echo '<h5 align="right"><b>PASIVO + PATRIMONIO '.number_format($totalp ,2).' </b></h5>';
		
		echo '</div> ';
		
		
		$this->firmas( );
		
		 
 
	}
//-----------------------
function _suma_saldos($wheref,$cuenta){


		$datos_saldos = array();

	   $datos_saldos = $this->bd->query_array('co_diario',
												'sum(debe) as debe, sum(haber) as haber',
												'anio='.$this->bd->sqlvalue_inyeccion($this->anio,true). ' and
												cuenta like '.$this->bd->sqlvalue_inyeccion($cuenta.'%',true). ' and  '.$wheref
		);

		$datos_saldos['saldo'] = $datos_saldos['debe'] - $datos_saldos['haber'];


		return $datos_saldos;


}
//--------------------------
function _detalle_cuenta($cuenta, $f1,$f2,$cuenta1,$cuenta2){

	$wheref = ' and ( fecha BETWEEN '.$this->bd->sqlvalue_inyeccion(trim($f1),true)." and ".
		                             $this->bd->sqlvalue_inyeccion(trim($f2),true)." ) ";
		
 
	$tipo 		     = $this->bd->retorna_tipo(); // TIPO DE CONEXION DE BASE DE DATOS ... POSTGRES
	
	$font ="10";
	$background="#ececec";
	

	$longitud = strlen($cuenta1);

	// 149.99
	$longitud0 = strlen($cuenta);

	

	if ( $longitud  > 2 ){

		$dato = substr($cuenta1,4,2) - 1; 

		$sql22 = "select cuenta,detalle,   sum(debe) - sum(haber) as saldo
		from view_diario_balance
		where anio =".$this->bd->sqlvalue_inyeccion($this->anio, true)." and
			   trim(mayor) = ".$this->bd->sqlvalue_inyeccion($cuenta, true).$wheref." and
			   trim(mayor)|| '.' || trim(grupo) between ".$this->bd->sqlvalue_inyeccion($cuenta.'.01', true)." and 
			   ".$this->bd->sqlvalue_inyeccion($cuenta.'.'.$dato, true)." 
			  group by cuenta,detalle";
 

	}
	else{
					if ( $longitud0 == 3){

							$sql22 = "select cuenta,detalle,   sum(debe) - sum(haber) as saldo
										from view_diario_balance
										where anio =".$this->bd->sqlvalue_inyeccion($this->anio, true)." and
											mayor = ".$this->bd->sqlvalue_inyeccion($cuenta, true).$wheref."
										group by cuenta,detalle";
					 }	else
					 {
						$sql22 = "select cuenta,detalle,   sum(debe) - sum(haber) as saldo
									from view_diario_balance
									where anio =".$this->bd->sqlvalue_inyeccion($this->anio, true)." and
									cuenta like ".$this->bd->sqlvalue_inyeccion($cuenta.'%', true).$wheref."
									group by cuenta,detalle";
				   }	
			}			
	 
				$evento = '';
				$edita    = '';
				$del      = '';			
 
	  
	$resultado22  = $this->bd->ejecutar($sql22); // EJECUTA SENTENCIA SQL  RETORNA RESULTADO
	
	$cabecera =  "Cuenta,Detalle,Saldo"; // CABECERA DE TABLAR GRILLA HA VISUALIZAR

  
 
	$this->obj->table->tabla_visor($resultado22,$tipo,$edita,$del,$evento ,$cabecera,$font,$background,"1");



}
	//--------------------------------------------
 
	function BuscaTotal($f1,$f2,$cuenta,$cuenta1='',$cuenta2=''){
		
	   
	 
		$wheref = '( fecha BETWEEN '.$this->bd->sqlvalue_inyeccion(trim($f1),true)." and ".
		                             $this->bd->sqlvalue_inyeccion(trim($f2),true)." ) ";
		

			$datos = $this->_suma_saldos($wheref,$cuenta);
 										
			$saldo = $datos["debe"] -  $datos["haber"] ;
		 
			

			if ( trim($cuenta) == '611'){
				
				$datos = $this->_suma_saldos($wheref,$cuenta);
			
				$saldo = $datos["debe"] - $datos["haber"]  ;
				
			} 

			if ( trim($cuenta) == '213'){
				
				$datos = $this->_suma_saldos($wheref,$cuenta);
			
				$saldo = $datos["debe"]  -  $datos["haber"];
				
			} 

			if ( trim($cuenta) == '212'){
				
				$datos = $this->_suma_saldos($wheref,$cuenta);
			
				$saldo = $datos["debe"]  -  $datos["haber"];
				
			} 



			if ( trim($cuenta) == '618.03'){
				
				$ingreso = $this->_suma_saldos($wheref,'62%');
		
				$gasto   = $this->_suma_saldos($wheref,'63%');
				
 				$saldo =   $ingreso["saldo"]  +  $gasto["saldo"]     ;
				
				
			} 

		if ( $cuenta == '151'){

	
			$datos = $this->_suma_saldos($wheref,$cuenta);
			
			$datose = $this->_suma_saldos($wheref,$cuenta1);
			
			$saldo = $datos["saldo"] -  $datose["saldo"] ;
			
			
		}

		if ( $cuenta == '152'){
			
			$datos = $this->_suma_saldos($wheref,$cuenta);
			
			$datose = $this->_suma_saldos($wheref,$cuenta1);
			
			
			$saldo = $datos["saldo"] -  $datose["saldo"] ;
			
			
		}
			
		if ( $cuenta == '141.99'){
			
			$datos = $this->_suma_saldos($wheref,$cuenta);
			
			$saldo = $datos["debe"]  -  $datos["haber"];

		}
				
		if ( $cuenta == '141'){
	
			$datos 		= $this->_suma_saldos($wheref,$cuenta);
			$saldo_activo  = $datos["saldo"] ;

			$depreciacion  	  = $this->_suma_saldos($wheref,'141.99');
			$saldo_depreciacion  = $depreciacion["saldo"] ;
				
			$saldo =  $saldo_activo - $saldo_depreciacion ;

		}


		if ( $cuenta == '142.99'){
			
			$datos = $this->_suma_saldos($wheref,$cuenta);
			
			$saldo = $datos["debe"]  -  $datos["haber"];

		}
				
		if ( $cuenta == '142'){
	
			$datos 		= $this->_suma_saldos($wheref,$cuenta);
			$saldo_activo  = $datos["saldo"] ;

			$depreciacion  	  = $this->_suma_saldos($wheref,'142.99');
			$saldo_depreciacion  = $depreciacion["saldo"] ;
				
			$saldo =  $saldo_activo - $saldo_depreciacion ;

		}


		if ( $cuenta == '143.99'){
			
			$datos = $this->_suma_saldos($wheref,$cuenta);
			
			$saldo = $datos["debe"]  -  $datos["haber"];

		}
				
		if ( $cuenta == '143'){
	
			$datos 		= $this->_suma_saldos($wheref,$cuenta);
			$saldo_activo  = $datos["saldo"] ;

			$depreciacion  	  = $this->_suma_saldos($wheref,'143.99');
			$saldo_depreciacion  = $depreciacion["saldo"] ;
				
			$saldo =  $saldo_activo - $saldo_depreciacion ;

		}


		
		if ( $cuenta == '144.99'){
			
			$datos = $this->_suma_saldos($wheref,$cuenta);
			
			$saldo = $datos["debe"]  -  $datos["haber"];

		}
				
		if ( $cuenta == '144'){
	
			$datos 		= $this->_suma_saldos($wheref,$cuenta);
			$saldo_activo  = $datos["saldo"] ;

			$depreciacion  	  = $this->_suma_saldos($wheref,'144.99');
			$saldo_depreciacion  = $depreciacion["saldo"] ;
				
			$saldo =  $saldo_activo - $saldo_depreciacion ;

		}




		if ( $cuenta == '126.99'){
			
			$datos = $this->_suma_saldos($wheref,$cuenta);
			
			$saldo = ($datos["haber"] - $datos["debe"]) * -1;

		}

		if ( $cuenta == '126'){

			$cuenta1 = '126.07';
			
			$datos1 = $this->_suma_saldos($wheref,$cuenta1);
			
			$saldo1 = $datos1["saldo"] ;

			$cuenta1 = '126.06';
			
			$datos2 = $this->_suma_saldos($wheref,$cuenta1);
			
			$saldo2 = $datos2["saldo"] ;

			$saldo = $saldo1 + $saldo2 ;

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
	    
	    if ( $com1 == 'S'){
	        $cadena = '<td align="right" bgcolor="#f9f9f9" style="color: #474747" width="15%">Anterior<br> ('.$anio.')</td>';
	    }
	    
	    echo '<table  class="table table-bordered" width="100%" style="font-size: 13px;table-layout: auto">';
	    echo ' <tr>
                  <td colspan="4"><b>'.$titulo.'</b></td>
                 </tr>
                <tr>
                   <td align="center" width="10%">Cuenta</td>
                   <td align="center" width="60%">Denominacion</td>
                   <td align="right" width="15%">Vigente<br> ('.$this->anio.')</td>'.$cadena.'
                </tr>';
 
	}
	//--------------------
	public function Bloque_Activo( $f1,$f2,$orden1,$orden2,$reporte ){
	    
	 
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
	        
	        echo "<tr>";
	        echo "<td><b>".'SG '.$x['cuenta']."</b></td>";
	        echo "<td>".$x['grupo3']. "</td>";

	        echo "<td align='right'>".number_format($saldo,2)."</td>";
	        
	        if (   $this->compa == 'S'){
	            $saldo_anterior = $this->BuscaTotal_anterior($f1,$f2,$cuenta);
	            echo "<td bgcolor='#f9f9f9' style='color: #474747' align='right'>".number_format($saldo_anterior,2)."</td></tr>";
 	            $inicial_debea =  $inicial_debea + $saldo_anterior;
	            
	        }else{
	            echo "</tr>";
	        }
 	        
		 	if (trim($reporte)  == '1'){

				if (abs($saldo) > 0  ){
						echo '<tr>
						<td></td>
						<td colspan="2">';
								$this->_detalle_cuenta($x['cuenta'], $f1,$f2,$cuenta1,$cuenta2);
						echo '</td>
						</tr>';
				 }
 		   }
	      
	        $inicial_debe = $inicial_debe + $saldo;
	        
	      
	    }
	        
	    echo "<tr>";
	    echo "<td></td>";
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
	//--- ultimo nivel
	public function Bloque_Pasivo( $f1,$f2,$orden1,$orden2,$reporte ){
	    
     
	    
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
	        
	      
	        
	        echo "<tr>";
	        echo "<td><b>".'SG '.$x['cuenta']."</b></td>";
	        echo "<td>".$x['grupo3']."</td>";
	        echo "<td align='right'>".number_format($saldo ,2)."</td>";
	        
	        if (   $this->compa == 'S'){
 	            $saldo_anterior = $this->BuscaTotal_anterior($f1,$f2,$cuenta);
	            echo "<td bgcolor='#f9f9f9' style='color: #474747' align='right'>".number_format($saldo_anterior,2)."</td></tr>";
	            $inicial_debea =  $inicial_debea + $saldo_anterior;
	        }else{
	            echo "</tr>";
	        }
	        
			if (trim($reporte)  == '1'){

				if (abs($saldo) > 0  ){
						echo '<tr>
						<td></td>
						<td colspan="2">';
								$this->_detalle_cuenta($x['cuenta'], $f1,$f2,$cuenta1,$cuenta2);
						echo '</td>
						</tr>';
				 }
 		   }
	      

	        $inicial_debe = $inicial_debe + $saldo;
	        
	       
	    }
	    
	    echo "<tr>";
	    echo "<td></td>";
	    echo "<td></td>";
	    echo "<td align='right'>".number_format($inicial_debe,2)."</td>";
	    
	    if (   $this->compa == 'S'){
	        echo "<td bgcolor='#f9f9f9' style='color: #474747' align='right'>".number_format($inicial_debea,2)."</td></tr>";
	    }else{
	        echo "</tr>";
	    }
 
	 
	    
	    echo '</table>';
	    
	    return  $inicial_debe  ;
	   
 
	}
	//--- ultimo nivel
	public function Bloque_Patrimonio( $f1,$f2,$orden1,$orden2 ,$reporte){
 
  
	    
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
	         
	        
	        echo "<tr>";
	        echo "<td><b>".'SG '.$x['cuenta']."</b></td>";
	        echo "<td> ".$x['grupo3']." </td>";
	        echo "<td align='right'>".number_format($saldo,2)."</td>";
	        
	        if (   $this->compa == 'S'){
	            $saldo_anterior = $this->BuscaTotal_anterior($f1,$f2,$cuenta);
	            echo "<td bgcolor='#f9f9f9' style='color: #474747' align='right'>".number_format($saldo_anterior,2)."</td></tr>";
	            $inicial_debea =  $inicial_debea + $saldo_anterior;
	        }else{
	            echo "</tr>";
	        }
	      
	        if (trim($reporte)  == '1'){

				if (abs($saldo) > 0  ){
						echo '<tr>
						<td></td>
						<td colspan="2">';
								$this->_detalle_cuenta($x['cuenta'], $f1,$f2,$cuenta1,$cuenta2);
						echo '</td>
						</tr>';
				 }
 		   }
 	        
	        $inicial_debe = $inicial_debe + $saldo;
	        
	       
	    }
	    
	    echo "<tr>";
	    echo "<td></td>";
	    echo "<td></td>";
	    echo "<td align='right'>".number_format($inicial_debe,2)."</td>";
	    
	    if (   $this->compa == 'S'){
	        echo "<td bgcolor='#f9f9f9' style='color: #474747' align='right'>".number_format($inicial_debea,2)."</td></tr>";
	    }else {
	        echo "</tr>";
	    }
	 
	    
	    echo '</table>';
	    
	    return $inicial_debe ;
 	    
	}
//---------------
	function titulo($f1,$f2){
	    
	    
	    $this->hoy 	     =  date("Y-m-d");
	    
	    $this->login     =  trim($_SESSION['login']);
	    
	    
	    
	    $imagen = '<img src="../../kimages/'.trim($_SESSION['logo']).'" width="200" height="120">';
	    
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
                  <td>&nbsp;<br>
                     &nbsp; <br>
                     &nbsp;</td>
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
	
	$reporte			=     $_POST["reporte"];
 
	$gestion->grilla( $f1,$f2,$tipo,$nivel,$auxiliares,$com1,$reporte	);
 
 
	
}



?>
 
  
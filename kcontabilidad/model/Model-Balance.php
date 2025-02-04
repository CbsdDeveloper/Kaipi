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
		//inicializamos la clase para conectarnos a la bd
		
		$this->obj     = 	new objects;
		$this->bd	   =	new Db ;
		
		$this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
		
		$this->ruc       =  $_SESSION['ruc_registro'];
		
		$this->sesion 	 =  trim($_SESSION['email']);
		
		$this->hoy 	     =  date("Y-m-d");
		
		$this->login     =  trim($_SESSION['login']);
 		
		$this->anio       =  $_SESSION['anio'];
		
 		
	}
   
	//--- calcula libro diario
	function grilla( $f1,$f2,$tipo,$nivel,$auxiliares){
		
  /*
	 	    
		$this->bd->JqueryDeleteSQL('co_resumensaldos',
		                          'registro ='.$this->bd->sqlvalue_inyeccion(trim($this->ruc), true). ' and 
                                   anio ='.$this->bd->sqlvalue_inyeccion($this->anio , true)
		    );
		*/
	    
	    $datos = $this->sqlwhere( $f1,$f2,$tipo,$nivel);
		
	    $sql     = $datos['sql'];
	    
	    $bandera = $datos['bandera'];
		
		if (!empty($sql)){
			
		//	$resultado  = $this->bd->ejecutar($sql);
			
			$tipo 		= $this->bd->retorna_tipo();
			
			
			echo '<div class="col-md-12" align="center" style="padding-bottom:10;padding-top:15px"> ';
			
			$this->titulo($f1,$f2);
			
			echo '</div> ';
			
			
			$stmt = $this->bd->ejecutar($sql);
			
			echo '<div class="col-md-12" style="padding-bottom:20;padding-top:20px"> ';
			
			$this->cabecera();
			
			$ndebe  = 0;
			$nhaber = 0;
			
			$ndebe1  = 0;
			$nhaber1 = 0;
			
			
			
			while ($x=$this->bd->obtener_fila($stmt)){
  
			   
			    
			    echo "<tr>";
			    echo "<td>".$x['nivel']."</td>";
			    echo "<td><b>".$x['cuenta']."</b></td>";
			    echo "<td><b>".$x['detalle']."</b></td>";
			
			    
			    $cuenta = trim($x['cuenta']).'%';
			    
			    if ( $x['nivel'] == $nivel ){
			        $nivel_color = '';
			    }else{
			        $nivel_color = ' style="color: #BFBFBF" ';
			    }
			    
			    
			    
			    
			    if ( $bandera == 1 ){
			        $debe       =  $x['debe'] ;
			        $haber      =  $x['haber'] ;
			        $deudor     =  $x['deudor'] ;
			        $acreedor   =  $x['acreedor'] ;
			        $nivel_color = '';
			    }else {
			        
			        
			        $xx = $this->bd->query_array('co_resumen_temp',
			                                     'sum(debe) as debe, sum(haber) as haber,sum(deudor) as deudor,sum(acreedor) as acreedor', 
			                                      'anio='.$this->bd->sqlvalue_inyeccion($this->anio ,true). ' and 
                                                   cuenta like '.$this->bd->sqlvalue_inyeccion($cuenta ,true)
			            );
			        
			        $debe       =  $xx['debe'] ;
			        $haber      =  $xx['haber'] ;
			        $deudor     =  $xx['deudor'] ;
			        $acreedor   =  $xx['acreedor'] ;
			    }
			    
			           if ($debe > 0 ){
			               echo "<td ".$nivel_color." align='right'>".number_format($debe,2)."</td>";
        			    }else {
        			        echo "<td> - </td>";
        			    }
        			   
        			    if ( $haber > 0 ){
        			        echo "<td  ".$nivel_color." align='right'>".number_format($haber,2)."</td>";
        			    }else {
        			        echo "<td> - </td>";
        			    }
        			    
        			    
        			    if ( $deudor > 0 ){
        			        echo "<td  ".$nivel_color." align='right'>".number_format($deudor,2)."</td>";
        			    }else {
        			        echo "<td>- </td>";
        			    }
        			    
        			    if ($acreedor  < 0 ){
        			        echo "<td  ".$nivel_color." align='right'>".number_format($acreedor,2)."</td>";
        			    }else {
        			        echo "<td>- </td>";
        			    }
			    
			
			    
			
			    
			    echo "</tr>";
			    
			    $ndebe  = $ndebe + $debe ;
			    $nhaber = $nhaber+ $haber  ;
			    
			    $ndebe1  = $ndebe1 + $deudor ;
			    $nhaber1 = $nhaber1 + $acreedor ;
			    
			}
			
			
			echo "<tr>";
			
 			echo "<td align='right'></td>";
			echo "<td align='right'></td>";
			echo "<td align='right'></td>";
			echo "<td align='right'><b>".number_format($ndebe,2)."</b></td>";
			echo "<td align='right'><b>".number_format($ndebe,2)."</b></td>";
			echo "<td align='right'><b>".number_format($ndebe1,2)."</b></td>";
			echo "<td align='right'><b>".number_format($nhaber1,2)."</b></td>";
			
			
			echo "</tr>";
			echo "</table>";
			echo '</div> ';
			
			unset($x); //eliminamos la fila para evitar sobrecargar la memoria
			
			pg_free_result ($stmt) ;
			
			$this->firmas( );
		 
		}
 
	}
 
	function sqlwhere($f1,$f2,$tipo,$nivel){
		
	    
	    $bandera = 0;
	    
  		
		
		if ( ($tipo)  <> '-' ){
		    
			$cadena1 = '( tipo_cuenta ='.$this->bd->sqlvalue_inyeccion(trim($tipo),true).") and ";
			
			$bandera = 0;
		}
		
		
		
		if ( ($nivel)  == '-1' ){
		    
 		    $bandera = 1;
		   
		}else{
		    
		    $cadena2 =  '( nivel <=  '.$this->bd->sqlvalue_inyeccion(trim($nivel),true).') and ';
		    
		    $bandera = 0;
		}
		
		$cadena3 = '( anio ='.$this->bd->sqlvalue_inyeccion($this->anio ,true).")     ";
		
		
		
		$where = $cadena1.$cadena2.$cadena3;
		
		$wheref = '( fecha BETWEEN '.$this->bd->sqlvalue_inyeccion(trim($f1),true)." and ".
		                             $this->bd->sqlvalue_inyeccion(trim($f2),true)." ) ";
		
 		           
		

		
		$sql_temp = 'SELECT   cuenta, sum(debe) as debe, sum(haber) as haber
            		FROM co_diario
            		where '.$wheref.' 
            		group by cuenta order by cuenta';
		
	 
		$this->inserta_nivel( $sql_temp );
		
		
 
		
		if ( $bandera == 0 ){
		    
		    $sql = 'SELECT cuenta, detalle, nivel, sum(debe) as debe, sum(haber) as haber, sum(deudor) as deudor, sum(acreedor) as  acreedor, tipo_cuenta
 	                FROM  co_resumen_temp where '  .$where.' 
                    group by cuenta, detalle, nivel, tipo_cuenta
                    order by cuenta, detalle';
		    
		     
		}else{
		    
		    $sql = 'SELECT cuenta, detalle, nivel, debe, haber, deudor, acreedor, anio, tipo_cuenta
 	                FROM  co_resumen_temp where '  .$where;
		}
		
	 
		$datos["sql"] = $sql;
		$datos["bandera"] = $bandera;
		
		
		return  $datos;
	 
	}
	
	//----------------------------------------------------------
	function cabecera(){
	    
	    echo '<table id ="tabla2" class="table table-striped table-bordered table-hover table-checkable" width="100%" style="font-size: 10px;table-layout: auto">
                <tr>';
	    echo '<th width="10%" >Nivel</th>';
	    echo '<th width="10%" >Cuenta</th>';
	    echo '<th width="40%" >Detalle</th>';
	 
	    echo '<th width="10%" >Debe</th>';
	    echo '<th width="10%" >Haber</th>';
	    echo '<th width="10%" >Deudor</th>';
	    echo '<th width="10%" >Acreedor</th>';
	    echo '</tr>';
	    
	    

	    
	}
	//--------------------
	public function inserta_periodo($cuenta,  $detalle, $nivel, $tipo,  $estado, $registro,$wheref,$nivelQuery ){
		
		
	    if ($nivelQuery == 0){
	        
	        $dat = '='.$this->bd->sqlvalue_inyeccion(trim($cuenta) ,true);
	        
	    }else{
	        
	        $dat = 'like '.$this->bd->sqlvalue_inyeccion(trim($cuenta).'%' ,true);
	        
	    }
	    
		$saldos = $this->bd->query_array( 'view_balance',
                            				'COALESCE(sum(debe),0) as debe,
                                             COALESCE(sum(haber),0) as haber,
                                             COALESCE(sum(saldo_deudor),0) as sd,
                                             COALESCE(sum(saldo_acreedor),0) as sa',
		                         $wheref.' and anio = '.$this->bd->sqlvalue_inyeccion($this->anio  ,true).' and
                                               cuenta '.$dat.' and
                                               registro ='.$this->bd->sqlvalue_inyeccion($this->ruc ,true)
		      );
				
				
				if ($saldos["sd"] > 0){
					$deudor   = $saldos["sd"];
					$acreedor = 0;
				}
				if ($saldos["sa"] > 0){
					$acreedor   = $saldos["sa"];
					$deudor = 0;
				}
				
				$total = $acreedor + $deudor;
 
				
				$InsertQuery = array( 
						array( campo => 'cuenta',   valor => $cuenta),
						array( campo => 'detalle',   valor => $detalle),
						array( campo => 'nivel',   valor => $nivel),
						array( campo => 'tipo',   valor => $tipo),
						array( campo => 'registro',   valor => $registro),
						array( campo => 'debe',   valor => $saldos["debe"]),
						array( campo => 'haber',   valor => $saldos["haber"]),
						array( campo => 'deudor',   valor => $deudor),
						array( campo => 'acreedor',   valor =>$acreedor),
				        array( campo => 'sesion',   valor =>$this->login),
				        array( campo => 'fecha',   valor =>$this->hoy ),
				        array( campo => 'anio',   valor =>$this->anio )
				);
			
				if ( $total == 0 ){
				    
				}else {
				    $this->bd->pideSq(0);
				    $this->bd->JqueryInsertSQL('co_resumensaldos',$InsertQuery);
				}
        			 
			 
			 
				
	}
	//--- ultimo nivel
	public function inserta_nivel( $sql_temp ){
	    
     
	    $this->bd->JqueryDeleteSQL('co_resumen_temp','anio='.$this->bd->sqlvalue_inyeccion($this->anio, true));	
	    
	    
	    $resultado  = $this->bd->ejecutar($sql_temp);
 	  
	    
	    while ($fetch=$this->bd->obtener_fila($resultado)){
	        
	        $saldo = $fetch["debe"] - $fetch["haber"] ;
 	        
	        // cuenta, sum(debe) as debe, sum(haber) as haber
 	        
	        if ($saldo > 0){
	            $deudor   =  $saldo;
	            $acreedor = 0;
	        }
	         else {
	             $acreedor   =  $saldo;
	             $deudor     = 0;
	        }
	        
	        $cuenta = trim($fetch["cuenta"]);
	        
	        $c1     = $this->bd->query_array('co_plan_ctas','cuenta, cuentas,nivel,detalle,tipo', 
	                                         'cuenta='.$this->bd->sqlvalue_inyeccion($cuenta,true). ' and 
                                               anio = '.$this->bd->sqlvalue_inyeccion($this->anio ,true)
	               );
	        
	        $tipo_cuenta = trim($c1["tipo"]) ;
	        
	        $cuenta1= trim($c1["cuentas"]) ;
	        
	        $c2     = $this->bd->query_array('co_plan_ctas','cuenta, cuentas,nivel,detalle,tipo',
	                                         'cuenta='.$this->bd->sqlvalue_inyeccion($cuenta1,true). ' and
                                              anio = '.$this->bd->sqlvalue_inyeccion($this->anio ,true)
	            );
	        
	        $cuenta2 = trim($c2["cuentas"]) ;
	        
	
	        
	        $c3     = $this->bd->query_array('co_plan_ctas','cuenta, cuentas,nivel,detalle,tipo',
	                                         'cuenta='.$this->bd->sqlvalue_inyeccion($cuenta2,true). ' and
                                              anio = '.$this->bd->sqlvalue_inyeccion($this->anio ,true)
	            );
	        
	        $cuenta3 = trim($c3["cuentas"]) ;
	        
	        $c4    = $this->bd->query_array('co_plan_ctas','cuenta, cuentas,nivel,detalle,tipo',
	            'cuenta='.$this->bd->sqlvalue_inyeccion($cuenta3,true). ' and
                                              anio = '.$this->bd->sqlvalue_inyeccion($this->anio ,true)
	            );
	        
	        $cuenta4 = trim($c4["cuentas"]) ;
	        
	        
	        $c5    = $this->bd->query_array('co_plan_ctas','cuenta, cuentas,nivel,detalle,tipo',
	            'cuenta='.$this->bd->sqlvalue_inyeccion($cuenta4,true). ' and
                                              anio = '.$this->bd->sqlvalue_inyeccion($this->anio ,true)
	            );
	        
	        
	        $cuenta5 = trim($c5["cuentas"]) ;
	        
	        $c6    = $this->bd->query_array('co_plan_ctas','cuenta, cuentas,nivel,detalle,tipo',
	            'cuenta='.$this->bd->sqlvalue_inyeccion($cuenta5,true). ' and
                                              anio = '.$this->bd->sqlvalue_inyeccion($this->anio ,true)
	            );
 	        
	        $InsertQuery = array(
	            array( campo => 'cuenta',   valor => $fetch["cuenta"]),
	            array( campo => 'detalle',   valor => $c1["detalle"]),
	            array( campo => 'nivel',   valor => $c1["nivel"]),
	            array( campo => 'debe',   valor => $fetch["debe"]),
	            array( campo => 'haber',   valor => $fetch["haber"]),
	            array( campo => 'deudor',   valor => $deudor),
	            array( campo => 'acreedor',   valor => $acreedor),
	            array( campo => 'anio',   valor =>$this->anio ),
	            array( campo => 'tipo_cuenta',   valor =>$tipo_cuenta )
	        );
	        
	        
	        
	     
 	        
	        $this->inserta_nivel2($cuenta5,$c6["nivel"],$c6["detalle"],$c6["tipo"]);
	        
	        $this->inserta_nivel2($cuenta4,$c5["nivel"],$c5["detalle"],$c5["tipo"]);
	        
	        $this->inserta_nivel2($cuenta3,$c4["nivel"],$c4["detalle"],$c4["tipo"]);
	        
	        $this->inserta_nivel2($cuenta2,$c3["nivel"],$c3["detalle"],$c3["tipo"]);
	        
	        $this->inserta_nivel2($cuenta1,$c2["nivel"],$c2["detalle"],$c2["tipo"]);
	        
	        $this->bd->pideSq(0);
	        
	        $this->bd->JqueryInsertSQL('co_resumen_temp',$InsertQuery);
	    }
 
	}
	//--- ultimo nivel
	public function inserta_nivel2($cuenta1,$nivel,$detalle,$tipo_cuenta){
 
	    
	    $valida = strlen($cuenta1);
	    
	    if ( $valida == 0 ) {
	        
	    }else {
	        
	        $valida    = $this->bd->query_array('co_resumen_temp','count(*) as nn',
	                                            'cuenta='.$this->bd->sqlvalue_inyeccion(trim($cuenta1),true). ' and
                                                 anio = '.$this->bd->sqlvalue_inyeccion($this->anio ,true)
	            );
	    
	        $InsertQuery = array(
	            array( campo => 'cuenta',   valor =>trim($cuenta1)),
	            array( campo => 'detalle',   valor =>$detalle),
	            array( campo => 'nivel',   valor =>$nivel),
	            array( campo => 'debe',   valor =>0),
	            array( campo => 'haber',   valor =>0),
	            array( campo => 'deudor',   valor =>0),
	            array( campo => 'acreedor',   valor =>0),
	            array( campo => 'anio',   valor =>$this->anio ),
	            array( campo => 'tipo_cuenta',   valor =>$tipo_cuenta )
	        );
	        
	        if ( $valida["nn"] == 0  ){
 	            
	            $this->bd->pideSq(0);
	            $this->bd->JqueryInsertSQL('co_resumen_temp',$InsertQuery);
	        }
	       
	        
	    }
 
 	    
	}
//---------------
	function titulo($f1,$f2){
	    
	    
	    $this->hoy 	     =  date("Y-m-d");
	    
	    $this->login     =  trim($_SESSION['login']);
	    
	    
	    
	    $imagen = '<img src="../../kimages/'.trim($_SESSION['logo']).'" width="200" height="120">';
	    
	    echo '<table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                  <td width="20%" rowspan="2">'.$imagen.'</td>
                  <td  width="60%" rowspan="2" style="text-align: center"><b>'.$_SESSION['razon'].'</b><br>
                        <b>'.$_SESSION['ruc_registro'].'</b><br><br>
                        <b>CONTABILIDAD ( PERIODO '.$this->anio.' ) </b><br>
                        <b>BALANCE DE COMPROBACION POR UNIDAD EJECUTORA '.$f1.'  al '.$f2.'</b></td>
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
	    
	    $a12 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(12,true));
	    
	    $a14 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(14,true));
	    
	    $datos["f10"] = $a12["carpeta"];
	    $datos["f11"] = $a12["carpetasub"];
	    
	    
	    $datos["c10"] = $a14["carpeta"];
	    $datos["c11"] = $a14["carpetasub"];
	    
	    echo '<div class="col-md-12" align="center" style="padding-bottom:10;padding-top:10px"> ';
	    
	    echo '	<table width="100%" border="0" cellspacing="0" cellpadding="0">
        	<tbody>
        	<tr>
        	<td width="50%" style="text-align: center;padding: 30px">&nbsp;</td>
        	<td width="50%" style="text-align: center">&nbsp;</td>
        	</tr>
        	<tr>
        	<td style="text-align: center">'.$datos["f10"] .'r</td>
        	<td style="text-align: center">'.$datos["c10"].'</td>
        	</tr>
        	<tr>
        	<td style="text-align: center">'. $datos["f11"].'</td>
        	<td style="text-align: center">'.$datos["c11"].'</td>
        	</tr>
        	</tbody>
        	</table>';
	    
	    echo '</div> ';
	    
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
if (isset($_POST["ffecha1"]))	{
	
	$f1 			    =     $_POST["ffecha1"];
	$f2 				=     $_POST["ffecha2"];
	$tipo               =     $_POST["tipo"];
	$nivel			    =     $_POST["nivel"];
	$auxiliares			=     $_POST["auxiliares"];
	
	
 
	$gestion->grilla( $f1,$f2,$tipo,$nivel,$auxiliares);
 
	
}



?>
 
  
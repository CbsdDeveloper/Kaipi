<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
	
	//creamos la variable donde se instanciar la clase "mysql"
	
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
	function grilla( $f1,$f2,$tipo,$nivel,$auxiliares,$valida){
		

		$this->bd->JqueryDeleteSQL('co_resumensaldos',
		                          'registro ='.$this->bd->sqlvalue_inyeccion(trim($this->ruc), true). ' and 
                                   anio ='.$this->bd->sqlvalue_inyeccion($this->anio , true)
		    );

		if ( $nivel > 6 ){
		    $nivel = 5;
		}
	    
		 
		
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
			
			$this->cabecera($valida);
			
			$ndebe  = 0;
			$nhaber = 0;
			
			$ndebe1  = 0;
			$nhaber1 = 0;
			
			$ndebe2  = 0;
			$nhaber2 = 0;
			
			$ndebe3  = 0;
			$nhaber3 = 0;
			
		 
			while ($x=$this->bd->obtener_fila($stmt)){
  
			   
			    
			    echo "<tr>";
			    echo "<td>".$x['nivel']."</td>";
			    //echo "<td><b>".$x['cuenta']."</b></td>";
			    
			    $bandera = 0;
			    
			    if (trim($x['cuenta']) == '61') {
			        $bandera= 1;
			    }
			    
			    if (trim($x['cuenta']) == '62') {
			        $bandera= 1;
			    }
			    
			    if (trim($x['cuenta']) == '63') {
			        $bandera= 1;
			    }
			    
			    
			    if ($x['nivel'] == '1') {
			        echo "<td><b>".$x['detalle']."</b></td>";
			    }else {
			        if ( $bandera == 1) {
			            echo "<td><b>".$x['detalle']."</b></td>";
			        }else  {
			            echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$x['detalle']."</td>";
			        }
			      
			    }
			   
			
			   
			    
			    
			    if ( $x['nivel'] == $nivel ){
			        $nivel_color = '';
			    }else{
			        $nivel_color = ' style="color: #848181" ';
			    }
			    
			    $nivel_color1 = '';
			    
			    //inicial_debe, inicial_haber,debe, haber,suma_debe, suma_haber, deudor, acreedor
			    
			    
			    $cuenta = trim($x['cuenta']).'%';
			    
			    if ( $bandera == 1 ){
			        $debe       =  $x['debe'] ;
			        $haber      =  $x['haber'] ;
			    
			        $inicial_debe  =  $x['inicial_debe'] ;
			        $inicial_haber  =  $x['inicial_haber'] ;
			        
			        $suma_debe   =  $x['suma_debe'] ;
			        $suma_haber  =  $x['suma_haber'] ;
			        
			        $nivel_color1 = ' style="color: #848181" ';
			        $nivel_color  = '';
			    
			        $deudor     =  $x['deudor'] ;
			        $acreedor   =  $x['acreedor'] ;
			        
			        
			    }else {
			        
			        
			        $xx = $this->bd->query_array('co_resumensaldos',
			                                     'sum(debe) as debe, sum(haber) as haber,
                                                  sum(deudor) as deudor,
                                                  sum(acreedor) as acreedor,
                                                  sum(inicial_debe) as inicial_debe,
                                                  sum(inicial_haber) as inicial_haber,
                                                  sum(suma_debe) as suma_debe, 
                                                  sum(suma_haber) as suma_haber', 
			                                      'anio='.$this->bd->sqlvalue_inyeccion($this->anio ,true). ' and 
                                                   cuenta like '.$this->bd->sqlvalue_inyeccion($cuenta ,true)
			            );
			        
			        $debe       =  $xx['debe'] ;
			        $haber      =  $xx['haber'] ;

			        
			        $inicial_debe  =   $xx['inicial_debe'] ;
			        $inicial_haber  =  $xx['inicial_haber'] ;
			        
			        $suma_debe   =  $xx['suma_debe'] ;
			        $suma_haber  =  $xx['suma_haber'] ;
			        
			        if ( $x['nivel'] <= 4 ){
			            
			            $deudor     =  $xx['deudor'] ;
			            $acreedor   =  $xx['acreedor'] ;
			            
			        }else {
			            
			            if ( trim($x['deudor_acreedor']) == 'D') {
			                $deudor     =  $suma_debe - $suma_haber ;
			            }else {
			                $acreedor   =  $suma_haber - $suma_debe ;
			            }
			            
			        }
		 
			        
			        
			    }
 			    
			    if ($inicial_debe <> 0 ){
			             echo "<td ".$nivel_color." align='right'>".number_format($inicial_debe,2)."</td>";
        			    }else {
        			        echo "<td ".$nivel_color1." align='right' > 0.00 </td>";
        			    }
        			    
        			    
        			    if ($inicial_haber > 0 ){
        			        echo "<td ".$nivel_color." align='right'>".number_format($inicial_haber,2)."</td>";
        			    }else {
        			        echo "<td ".$nivel_color1." align='right' > 0.00 </td>";
        			    }
			    //-----------------------------------------------------------------------------------------------------------------
			           if ($debe <> 0 ){
			               echo "<td ".$nivel_color." align='right'>".number_format($debe,2)."</td>";
        			    }else {
        			        echo "<td ".$nivel_color1." align='right' > 0.00 </td>";
        			    }
        			   
        			    if ( $haber > 0 ){
        			        echo "<td  ".$nivel_color." align='right'>".number_format($haber,2)."</td>";
        			    }else {
        			        echo "<td ".$nivel_color1." align='right' > 0.00 </td>";
        			    }
        		//-----------------------------------------------------------------------------------------------------------------
        			    if ($suma_debe <> 0 ){
        			        echo "<td ".$nivel_color." align='right'>".number_format($suma_debe,2)."</td>";
        			    }else {
        			        echo "<td ".$nivel_color1." align='right' > 0.00 </td>";
        			    }
         			    
        			    if ($suma_haber > 0 ){
        			        echo "<td ".$nivel_color." align='right'>".number_format($suma_haber,2)."</td>";
        			    }else {
        			        echo "<td ".$nivel_color1." align='right' > 0.00 </td>";
        			    }
        			    
        			    
        			    
        			    
        			    if ( $deudor <> 0 ){
        			        echo "<td  ".$nivel_color." align='right'>".number_format($deudor,2)."</td>";
        			     }else {
        			         echo "<td ".$nivel_color1." align='right' > 0.00 </td>";
        			    }
        			    
        			    if ($acreedor <> 0 ){
        			        echo "<td  ".$nivel_color." align='right'>".number_format($acreedor *-1,2)."</td>";
        			     }else {
        			         echo "<td ".$nivel_color1." align='right' > 0.00 </td>";
        			      }
			    
			
			    
			
			    
			    echo "</tr>";
			    
			    $ndebe  = $ndebe + $debe ;
			    $nhaber = $nhaber+ $haber  ;
			    
			    $ndebe1  = $ndebe1 + $deudor ;
			    $nhaber1 = $nhaber1 + $acreedor ;
			    
			    $ndebe2  = $ndebe2 + $suma_debe;
			    $nhaber2 = $nhaber2 + $suma_haber;
			    
			    $ndebe3  =  $ndebe3  + $inicial_debe;
			    $nhaber3 =  $nhaber3 + $inicial_haber;
			    
			    
			}
			
			
			echo "<tr>";
			
 			 
			echo "<td align='right'></td>";
			echo "<td align='right'></td>";
			echo "<td align='right'><b>".number_format($ndebe3,2)."</b></td>";
			echo "<td align='right'><b>".number_format($nhaber3,2)."</b></td>";
			
			echo "<td align='right'><b>".number_format($ndebe,2)."</b></td>";
			echo "<td align='right'><b>".number_format($nhaber,2)."</b></td>";
			
			echo "<td align='right'><b>".number_format($ndebe2,2)."</b></td>";
			echo "<td align='right'><b>".number_format($nhaber2,2)."</b></td>";
			
			echo "<td align='right'><b>".number_format($ndebe1,2)."</b></td>";
			echo "<td align='right'><b>".number_format($nhaber1 *-1,2)."</b></td>";
			
			
			echo "</tr>";
			echo "</table>";
			echo '</div> ';
			
			unset($x); //eliminamos la fila para evitar sobrecargar la memoria
			
			pg_free_result ($stmt) ;
			
			if ( $valida == 'S'){
			    
			    echo '<script>
                        jQuery.noConflict();
                         jQuery(document).ready(function() {
 	                     jQuery("#tabla_bal_01").DataTable( {
                	        "paging":   true,
                	        "ordering": false,
                	        "info":     false,
                            "aoColumnDefs": [
                            	    { "sClass": "highlight", "aTargets": [ 5] },
                            	    { "sClass": "de", "aTargets": [ 6 ] },
                            	    { "sClass": "highlight", "aTargets": [ 7 ] },
                                     { "sClass": "ye", "aTargets": [ 8 ] },
                                     { "sClass": "highlight", "aTargets": [ 9 ] },
                                     { "sClass": "ye", "aTargets": [ 10 ] }
                            	    ]
                	    } ); } );  </script>';
			    
			    
			    
			}else {
			    
			    $this->firmas( );
			}
			
		 
		}
 
	}
 
	function sqlwhere($f1,$f2,$tipo,$nivel){
		
	    
	    $bandera = 0;
	    
  		
		
		if ( ($tipo)  <> '-' ){
		    
			$cadena1 = '( tipo ='.$this->bd->sqlvalue_inyeccion(trim($tipo),true).") and ";
			
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
		
 		           
		
		$Apertura = $this->bd->query_array('co_asiento','id_asiento', 
		                                   'anio='.$this->bd->sqlvalue_inyeccion($this->anio,true). ' and 
                                            tipo='.$this->bd->sqlvalue_inyeccion('T',true)
		                                  );
		                             
		$sql_ac = "Update co_diario
            		set tipo = 'A' 
            		where id_asiento= ".$this->bd->sqlvalue_inyeccion($Apertura["id_asiento"] ,true) ;
		
		
		$this->bd->ejecutar($sql_ac);
		
		
		$sql_temp = "SELECT   cuenta, sum(debe) as debe, sum(haber) as haber
            		FROM co_diario
            		where tipo  is null and   ".$wheref.' 
            		group by cuenta order by cuenta';
		
		
		
		$sql_apertura = "SELECT   cuenta, sum(debe) as debe, sum(haber) as haber
            		FROM co_diario
            		where tipo = 'A' and   anio=".$this->bd->sqlvalue_inyeccion($this->anio,true).'
            		group by cuenta order by cuenta';
		
		
 
		$this->inserta_nivel_inicial( $sql_apertura );
		
	 	$this->inserta_nivel( $sql_temp );
		
 
	 	
	 	$sql_saldos = "Update co_resumensaldos
            		set suma_debe   = coalesce(inicial_debe,0) + coalesce(debe,0),
                        suma_haber  = coalesce(inicial_haber,0) + coalesce(haber,0) where 1= 1";
	 	
	 	//deudor, acreedor
 	 	
	 	$this->bd->ejecutar($sql_saldos);
	 	
	 	
	 	//---------------------- //deudor, acreedor
	 	
	 	$sql_de = "Update co_resumensaldos
            		set saldo   = coalesce(suma_debe,0) - coalesce(suma_haber,0) where 1 = 1";
	 	
 	 	$this->bd->ejecutar($sql_de);
 	 	
        $sql_ac = "Update co_resumensaldos
            		set deudor   = coalesce(saldo,0) where deudor_acreedor = 'D' ";
 	 	
 	 	$this->bd->ejecutar($sql_ac);
 	 	
 	 	$sql_ac1 = "Update co_resumensaldos
            		set acreedor  = coalesce(saldo,0)    where deudor_acreedor = 'A' ";
 	 	
 	 	$this->bd->ejecutar($sql_ac1);
 	 	
 	 	//--------------------------------------
  
		
		if ( $bandera == 0 ){
		    
		    $sql = 'SELECT cuenta, detalle, nivel, 
                           sum(debe) as debe, sum(haber) as haber, 
                           sum(deudor) as deudor, sum(acreedor) as  acreedor, 
                           sum(coalesce(suma_debe,0)) as suma_debe, 
                           sum(coalesce(suma_haber,0)) as suma_haber,
                           sum(coalesce(inicial_debe,0)) as inicial_debe, 
                           sum(coalesce(inicial_haber,0)) as inicial_haber,deudor_acreedor
 	                FROM  co_resumensaldos where '  .$where.' 
                    group by cuenta, detalle, nivel,deudor_acreedor
                    order by cuenta, detalle';
		    
		  
		     
		}else{
		    
		    $sql = 'SELECT cuenta, detalle, nivel, inicial_debe, inicial_haber,debe, haber,suma_debe, suma_haber, deudor, acreedor, anio, tipo,deudor_acreedor
 	                FROM  co_resumensaldos where '  .$where. '  order by cuenta, detalle';
		}
		
	 
		$datos["sql"] = $sql;
		
		$datos["bandera"] = $bandera;
		
		
		return  $datos;
	 
	}
	
	//----------------------------------------------------------
	function cabecera($valida){
	    
	    if ( $valida == 'S'){
	        
	        
	        echo ' <table id="tabla_bal_01"
                              class="display table table-condensed table-hover datatable" width="100%"  style="font-size: 12px;">';
  	        echo '<thead><tr>
                  <th width="5%">Nivel</th>
                  <th width="47%">Denominacion</th>
                  <th width="6%">Deudor</th>
                  <th width="6%">Acreedor</th>
                  <th width="6%">Debito</th>
                  <th width="6%">Credito</th>
                  <th width="6%">Debito</th>
                  <th width="6%">Credito</th>
                  <th width="6%">Deudor</th>
                  <th width="6%">Acreedor</th>
                </tr></thead>';
	        
	    }else {
	        
	        echo '<table id ="tabla_bal_01" class="table table-striped table-bordered table-hover table-checkable" width="100%" style="font-size: 12px;table-layout: auto">';
	        echo '  <tr>
                  <td colspan="2">&nbsp;</td>
                  <td colspan="2" align="center" bgcolor="#E4FFA7">SALDOS INICIALES</td>
                  <td colspan="2" align="center" bgcolor="#C0D7FF" >FLUJOS</td>
                  <td colspan="2" align="center" bgcolor="#FFDBDB">SUMAS</td>
                  <td colspan="2" align="center" bgcolor="#9EFFA6">SALDOS FINALES</td>
                </tr>
                <tr>
                  <td width="5%">Nivel</td>
                  <td width="47%">Denominacion</td>
                  <td width="6%">Deudor</td>
                  <td width="6%">Acreedor</td>
                  <td width="6%">Debito</td>
                  <td width="6%">Credito</td>
                  <td width="6%">Debito</td>
                  <td width="6%">Credito</td>
                  <td width="6%">Deudor</td>
                  <td width="6%">Acreedor</td>
                </tr>';
	    }
	   
	 

	    

	    
	}
	//--------------------
	public function inserta_nivel_inicial( $sql_temp ){
	    
	    
	    //  co_resumensaldos
	    
	    $resultado  = $this->bd->ejecutar($sql_temp);
	    
	    
	    while ($fetch=$this->bd->obtener_fila($resultado)){
	        
 
	        
	        $cuenta = trim($fetch["cuenta"]);
	        
	        $c1     = $this->bd->query_array('co_plan_ctas','cuenta, cuentas,nivel,detalle,tipo,deudor_acreedor,impresion',
	            'cuenta='.$this->bd->sqlvalue_inyeccion($cuenta,true). ' and
                                               anio = '.$this->bd->sqlvalue_inyeccion($this->anio ,true)
	            );
	        
	        $tipo_cuenta = trim($c1["tipo"]) ;
	        
	        $cuenta1= trim($c1["cuentas"]) ;
	        
	        $c2     = $this->bd->query_array('co_plan_ctas','cuenta, cuentas,nivel,detalle,tipo,deudor_acreedor,impresion',
	            'cuenta='.$this->bd->sqlvalue_inyeccion($cuenta1,true). ' and
                                              anio = '.$this->bd->sqlvalue_inyeccion($this->anio ,true)
	            );
	        
	        $cuenta2 = trim($c2["cuentas"]) ;
	        
	        
	        
	        $c3     = $this->bd->query_array('co_plan_ctas','cuenta, cuentas,nivel,detalle,tipo,deudor_acreedor,impresion',
	            'cuenta='.$this->bd->sqlvalue_inyeccion($cuenta2,true). ' and
                                              anio = '.$this->bd->sqlvalue_inyeccion($this->anio ,true)
	            );
	        
	        $cuenta3 = trim($c3["cuentas"]) ;
	        
	        $c4    = $this->bd->query_array('co_plan_ctas','cuenta, cuentas,nivel,detalle,tipo,deudor_acreedor,impresion',
	            'cuenta='.$this->bd->sqlvalue_inyeccion($cuenta3,true). ' and
                                              anio = '.$this->bd->sqlvalue_inyeccion($this->anio ,true)
	            );
	        
	        $cuenta4 = trim($c4["cuentas"]) ;
	        
	        
	        $c5    = $this->bd->query_array('co_plan_ctas','cuenta, cuentas,nivel,detalle,tipo,deudor_acreedor,impresion',
	            'cuenta='.$this->bd->sqlvalue_inyeccion($cuenta4,true). ' and
                                              anio = '.$this->bd->sqlvalue_inyeccion($this->anio ,true)
	            );
	        
	        
	        $cuenta5 = trim($c5["cuentas"]) ;
	        
	        $c6    = $this->bd->query_array('co_plan_ctas','cuenta, cuentas,nivel,detalle,tipo,deudor_acreedor,impresion',
	            'cuenta='.$this->bd->sqlvalue_inyeccion($cuenta5,true). ' and
                                              anio = '.$this->bd->sqlvalue_inyeccion($this->anio ,true)
	            );
	        
	        $InsertQuery = array(
	            array( campo => 'cuenta',   valor => $fetch["cuenta"]),
	            array( campo => 'detalle',   valor => $c1["detalle"]),
	            array( campo => 'nivel',   valor => $c1["nivel"]),
	            array( campo => 'inicial_debe',   valor => $fetch["debe"]),
	            array( campo => 'inicial_haber',   valor => $fetch["haber"]),
	            array( campo => 'debe',   valor => 0 ),
	            array( campo => 'haber',   valor => 0 ),
 	            array( campo => 'deudor',   valor =>  0 ),
	            array( campo => 'acreedor',   valor =>  0 ),
	            array( campo => 'anio',   valor =>$this->anio ),
	            array( campo => 'tipo',   valor =>$tipo_cuenta ),
	            array( campo => 'registro',   valor =>$this->ruc ),
	            array( campo => 'deudor_acreedor',   valor =>$c1["deudor_acreedor"]),
	            array( campo => 'impresion',   valor =>$c1["impresion"])
	        );
 
	        
	        
	        $this->inserta_nivel2($cuenta5,$c6["nivel"],$c6["detalle"],$c6["tipo"],$c6["deudor_acreedor"],$c6["impresion"]);
	        
	        $this->inserta_nivel2($cuenta4,$c5["nivel"],$c5["detalle"],$c5["tipo"],$c5["deudor_acreedor"],$c5["impresion"]);
	        
	        $this->inserta_nivel2($cuenta3,$c4["nivel"],$c4["detalle"],$c4["tipo"],$c4["deudor_acreedor"],$c4["impresion"]);
	        
	        $this->inserta_nivel2($cuenta2,$c3["nivel"],$c3["detalle"],$c3["tipo"],$c3["deudor_acreedor"],$c3["impresion"]);
	        
	        $this->inserta_nivel2($cuenta1,$c2["nivel"],$c2["detalle"],$c2["tipo"],$c2["deudor_acreedor"],$c2["impresion"]);
	        
	        $this->bd->pideSq(0);
	        
	        $this->bd->JqueryInsertSQL('co_resumensaldos',$InsertQuery);
	    }
	    
	}
	//--- ultimo nivel
	public function inserta_nivel( $sql_temp ){
	    
     
	  //  co_resumensaldos
	    
	    $resultado  = $this->bd->ejecutar($sql_temp);
 	  
	    
	    while ($fetch=$this->bd->obtener_fila($resultado)){
	        
  	        
	        // cuenta, sum(debe) as debe, sum(haber) as haber
 
	            $deudor   =  0;
	            $acreedor = 0;
 
	        
	        $cuenta = trim($fetch["cuenta"]);
	        
	        $c1     = $this->bd->query_array('co_plan_ctas','cuenta, cuentas,nivel,detalle,tipo,deudor_acreedor,impresion', 
	                                         'cuenta='.$this->bd->sqlvalue_inyeccion($cuenta,true). ' and 
                                               anio = '.$this->bd->sqlvalue_inyeccion($this->anio ,true)
	               );
	        
	        $tipo_cuenta = trim($c1["tipo"]) ;
	        
	        $cuenta1= trim($c1["cuentas"]) ;
	        
	        $c2     = $this->bd->query_array('co_plan_ctas','cuenta, cuentas,nivel,detalle,tipo,deudor_acreedor,impresion',
	                                         'cuenta='.$this->bd->sqlvalue_inyeccion($cuenta1,true). ' and
                                              anio = '.$this->bd->sqlvalue_inyeccion($this->anio ,true)
	            );
	        
	        $cuenta2 = trim($c2["cuentas"]) ;
	        
	
	        
	        $c3     = $this->bd->query_array('co_plan_ctas','cuenta, cuentas,nivel,detalle,tipo,deudor_acreedor,impresion',
	                                         'cuenta='.$this->bd->sqlvalue_inyeccion($cuenta2,true). ' and
                                              anio = '.$this->bd->sqlvalue_inyeccion($this->anio ,true)
	            );
	        
	        $cuenta3 = trim($c3["cuentas"]) ;
	        
	        $c4    = $this->bd->query_array('co_plan_ctas','cuenta, cuentas,nivel,detalle,tipo,deudor_acreedor,impresion',
	            'cuenta='.$this->bd->sqlvalue_inyeccion($cuenta3,true). ' and
                                              anio = '.$this->bd->sqlvalue_inyeccion($this->anio ,true)
	            );
	        
	        $cuenta4 = trim($c4["cuentas"]) ;
	        
	        
	        $c5    = $this->bd->query_array('co_plan_ctas','cuenta, cuentas,nivel,detalle,tipo,deudor_acreedor,impresion',
	            'cuenta='.$this->bd->sqlvalue_inyeccion($cuenta4,true). ' and
                                              anio = '.$this->bd->sqlvalue_inyeccion($this->anio ,true)
	            );
	        
	        
	        $cuenta5 = trim($c5["cuentas"]) ;
	        
	        $c6    = $this->bd->query_array('co_plan_ctas','cuenta, cuentas,nivel,detalle,tipo,deudor_acreedor,impresion',
	            'cuenta='.$this->bd->sqlvalue_inyeccion($cuenta5,true). ' and
                                              anio = '.$this->bd->sqlvalue_inyeccion($this->anio ,true)
	            );
	        
	 
	 	        
	        $InsertQuery = array(
	            array( campo => 'cuenta',   valor => trim($fetch["cuenta"])),
	            array( campo => 'detalle',   valor => $c1["detalle"]),
	            array( campo => 'nivel',   valor => $c1["nivel"]),
	            array( campo => 'debe',   valor => $fetch["debe"]),
	            array( campo => 'haber',   valor => $fetch["haber"]),
	            array( campo => 'deudor',   valor => $deudor),
	            array( campo => 'acreedor',   valor => $acreedor),
	            array( campo => 'anio',   valor =>$this->anio ),
	            array( campo => 'tipo',   valor =>$tipo_cuenta ),
	            array( campo => 'registro',   valor =>$this->ruc ),
	            array( campo => 'deudor_acreedor',   valor =>$c1["deudor_acreedor"]),
	            array( campo => 'impresion',   valor =>$c1["impresion"])
	        );
	        
 
	        
	        $UpdateQuery = array(
	            array( campo => 'cuenta',   valor =>trim($fetch["cuenta"]),  filtro => 'S'),
	            array( campo => 'detalle',      valor => $c1["detalle"],  filtro => 'N'),
	            array( campo => 'nivel',      valor => $c1["nivel"],  filtro => 'N'),
	            array( campo => 'debe',      valor => $fetch["debe"],    filtro => 'N'),
	            array( campo => 'haber',      valor =>  $fetch["haber"],    filtro => 'N'),
	            array( campo => 'deudor',  valor => $deudor,  filtro => 'N'),
	            array( campo => 'acreedor',       valor => $acreedor,  filtro => 'N'),
	            array( campo => 'anio',       valor => $this->anio,  filtro => 'S') ,
	            array( campo => 'tipo',      valor => $tipo_cuenta,  filtro => 'N'),
	            array( campo => 'deudor_acreedor',   valor =>$c1["deudor_acreedor"]),
	            array( campo => 'impresion',   valor =>$c1["impresion"])
	        );
	        
	        
	         
	        $this->inserta_nivel2($cuenta5,$c6["nivel"],$c6["detalle"],$c6["tipo"],$c6["deudor_acreedor"],$c6["impresion"]);
	        
	        $this->inserta_nivel2($cuenta4,$c5["nivel"],$c5["detalle"],$c5["tipo"],$c5["deudor_acreedor"],$c5["impresion"]);
	        
	        $this->inserta_nivel2($cuenta3,$c4["nivel"],$c4["detalle"],$c4["tipo"],$c4["deudor_acreedor"],$c4["impresion"]);
	        
	        $this->inserta_nivel2($cuenta2,$c3["nivel"],$c3["detalle"],$c3["tipo"],$c3["deudor_acreedor"],$c3["impresion"]);
	        
	        $this->inserta_nivel2($cuenta1,$c2["nivel"],$c2["detalle"],$c2["tipo"],$c2["deudor_acreedor"],$c2["impresion"]);
	        
	        $this->bd->pideSq(0);
	        
	        $existe    = $this->bd->query_array('co_resumensaldos','count(*) as nn',
	                                            'cuenta='.$this->bd->sqlvalue_inyeccion($cuenta,true). ' and
                                                 anio = '.$this->bd->sqlvalue_inyeccion($this->anio ,true)
	            );
	        
	        if ( $existe["nn"] > 0  ){
	            $this->bd->JqueryUpdateSQL('co_resumensaldos',$UpdateQuery);
	        }else {
	            $this->bd->JqueryInsertSQL('co_resumensaldos',$InsertQuery);
	        }
	        
	    
	        
	        
	    }
 
	}
	//--- ultimo nivel
	public function inserta_nivel2($cuenta1,$nivel,$detalle,$tipo_cuenta,$deudor_acreedor,$impresion){
 
	    
	    $valida = strlen($cuenta1);
	    
	    if ( $valida == 0 ) {
	        
	    }else {
	        
	        $valida    = $this->bd->query_array('co_resumensaldos','count(*) as nn',
	                                            'cuenta='.$this->bd->sqlvalue_inyeccion(trim($cuenta1),true). ' and
                                                 anio = '.$this->bd->sqlvalue_inyeccion($this->anio ,true)
	            );
 
	        
	        $InsertQuery = array(
	            array( campo => 'cuenta',   valor =>trim($cuenta1)),
	            array( campo => 'detalle',   valor =>$detalle),
	            array( campo => 'nivel',   valor =>$nivel),
	            array( campo => 'inicial_debe',   valor => 0 ),
	            array( campo => 'inicial_haber',   valor => 0 ),
	            array( campo => 'debe',   valor => 0 ),
	            array( campo => 'haber',   valor => 0 ),
	            array( campo => 'deudor',   valor => 0 ),
	            array( campo => 'acreedor',   valor => 0 ),
	            array( campo => 'anio',   valor =>$this->anio ),
	            array( campo => 'tipo',   valor =>$tipo_cuenta ),
	            array( campo => 'registro',   valor =>$this->ruc ),
	            array( campo => 'deudor_acreedor',   valor => $deudor_acreedor),
	            array( campo => 'impresion',   valor => $impresion)
	        );
	        
	        if ( $valida["nn"] == 0  ){
 	            
	            $this->bd->pideSq(0);
	            $this->bd->JqueryInsertSQL('co_resumensaldos',$InsertQuery);
	            
	        }else {
	                   
	            $UpdateQuery = array(
	                array( campo => 'cuenta',   valor =>trim($cuenta1),  filtro => 'S'),
	                array( campo => 'detalle',      valor =>$detalle,  filtro => 'N'),
	                array( campo => 'nivel',      valor => $nivel,  filtro => 'N'),
	                array( campo => 'debe',      valor => 0,    filtro => 'N'),
	                array( campo => 'haber',      valor =>0,    filtro => 'N'),
	                array( campo => 'deudor',  valor => 0,  filtro => 'N'),
	                array( campo => 'acreedor',       valor => 0,  filtro => 'N'),
	                array( campo => 'anio',       valor => $this->anio,  filtro => 'S') ,
	                array( campo => 'tipo',      valor => $tipo_cuenta,  filtro => 'N'),
	                array( campo => 'deudor_acreedor',   valor =>$deudor_acreedor),
	                array( campo => 'impresion',   valor => $impresion)
	            );
	            
	            $this->bd->JqueryUpdateSQL('co_resumensaldos',$UpdateQuery);
             }
	       
	        
	    }
 
 	    
	}
//---------------
	function titulo($f1,$f2){
	    
	    
	    $this->hoy 	     =  date("Y-m-d");
	    
	    $this->login     =  trim($_SESSION['login']);
	    
	    
	    
	    $imagen = '<img src="../../kimages/'.trim($_SESSION['logo']).'" width="200" height="120">';
	    
	    echo '<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 13px;table-layout: auto"> 
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
	    
	    $a11 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(10,true));
	    
	    
	    $datos["g10"] = $a11["carpeta"];
	    $datos["g11"] = $a11["carpetasub"];
	    
	    
	    $datos["f10"] = $a12["carpeta"];
	    $datos["f11"] = $a12["carpetasub"];
	    
	    
	    $datos["c10"] = $a14["carpeta"];
	    $datos["c11"] = $a14["carpetasub"];
	    
	    echo '<div class="col-md-12" align="center" style="padding-bottom:10;padding-top:10px"> ';
	    
	    echo '<table width="100%" border="0" cellspacing="0" cellpadding="0">
        	<tbody>
        	<tr>
        	  <td width="33%" style="text-align: center;padding: 15px">&nbsp;</td>
        	<td width="33%" style="text-align: center;padding: 15px">&nbsp;</td>
        	<td width="33%" style="text-align: center">&nbsp;</td>
        	</tr>
        	<tr>
        	  <td style="text-align: center">'. $datos["g10"].'</td>
        	<td style="text-align: center">'. $datos["f10"].'</td>
        	<td style="text-align: center">'. $datos["c10"].'</td>
        	</tr>
        	<tr>
        	  <td style="text-align: center">'. $datos["g11"].'</td>
        	  <td style="text-align: center">'.$datos["f11"].'</td>
        	  <td style="text-align: center">'.$datos["c11"] .'</td>
      	  </tr>
        	<tr>
        	  <td style="text-align: center">&nbsp;</td>
        	<td style="text-align: center">&nbsp;</td>
        	<td style="text-align: center">&nbsp;</td>
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
	
	$valida			=     $_POST["valida"];
	
 
	$gestion->grilla( $f1,$f2,$tipo,$nivel,$auxiliares,$valida);
 
	
}



?>
 
  
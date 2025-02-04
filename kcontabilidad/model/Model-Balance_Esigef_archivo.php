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
		
	    
		$sql_genera = "INSERT INTO co_resumensaldos (cuenta, detalle, nivel, tipo, registro,impresion, deudor_acreedor, anio, sesion ) 
		SELECT cuenta, detalle, nivel, tipo, registro,impresion, deudor_acreedor, anio , ".$this->bd->sqlvalue_inyeccion($this->sesion , true)." as sesion 
			FROM co_plan_ctas a
			where a.anio = ".$this->bd->sqlvalue_inyeccion($this->anio , true)." and 
				a.impresion = 1 and  
				a.estado = 'S' and 
				a.cuenta not in (select b.cuenta from co_resumensaldos b where b.anio= ".$this->bd->sqlvalue_inyeccion($this->anio , true).")
			order by a.cuenta";


		$this->bd->ejecutar($sql_genera); 

 
 		 
	
	    $this->sqlwhere( $f1,$f2,$tipo,$nivel);
 
	    $sql = 'SELECT cuenta, grupo, subgrupo, nivel1, nivel2, detalle, inicial_debe, inicial_haber, debe, haber, suma_debe, suma_haber, deudor, acreedor, anio, sesion, deudor_acreedor, impresion, idpxesigef
                 FROM co_resumen_balance 
                where anio ='.$this->bd->sqlvalue_inyeccion($this->anio , true).' 
                order by cuenta';
	 
		
		if (!empty($sql)){
			

			$stmt = $this->bd->ejecutar($sql); 
 			
			$tipo 		= $this->bd->retorna_tipo();
			
			
			echo '<div class="col-md-12" align="center" style="padding-bottom:10;padding-top:15px"> ';
			
			$this->titulo($f1,$f2);
			
			echo '</div> ';
			
 
			
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
  
			   
				 

				$esi= '';
 

			    
			    echo "<tr>";
			    echo "<td><b>".$x['cuenta']."</b></td>";
			    echo "<td>".$esi.$x['detalle']."</td>";
			
			    echo "<td>".$x['grupo']."</td>";
			    echo "<td>".$x['subgrupo']."</td>";
			    echo "<td>".$x['nivel1']."</td>";
			    
			   
			    
			    if ( $x['nivel'] == $nivel ){
			        $nivel_color = '';
			    }else{
			        $nivel_color = ' style="color: #848181" ';
			    }
			    
			    $nivel_color1 = '';
			    
			    //inicial_debe, inicial_haber,debe, haber,suma_debe, suma_haber, deudor, acreedor
			    
		 
			        
			        $debe       =  $x['debe'] ;
			        $haber      =  $x['haber'] ;

			        
			        $inicial_debe  =   $x['inicial_debe'] ;
			        $inicial_haber  =  $x['inicial_haber'] ;
			        
			        $suma_debe   =  $x['suma_debe'] ;
			        $suma_haber  =  $x['suma_haber'] ;
			        
			        if ( $x['nivel'] <= 4 ){
			            
			            $deudor     =  $x['deudor'] ;
			            $acreedor   =  $x['acreedor'] ;
			            
			        }else {
			            
			            if ( trim($x['deudor_acreedor']) == 'D') {
			                $deudor     =  $suma_debe - $suma_haber ;
			            }else {
			                $acreedor   =  $suma_haber - $suma_debe ;
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
        			    
        			    
        			    $color_negativo = ' style="color: #FF0000;font-weight: 900" ';
        			    
        			    if ( $deudor <> 0 ){
							if ($deudor < 0) {
								echo "<td  ".$color_negativo." align='right'>".number_format($deudor,2)."</td>";
							} else {
								echo "<td  ".$nivel_color." align='right'>".number_format($deudor,2)."</td>";
							}
        			        // echo "<td  ".$nivel_color." align='right'>".number_format($deudor,2)."</td>";
        			     }else {
        			         echo "<td ".$nivel_color1." align='right' > 0.00 </td>";
        			    }
        			    
        			    if ($acreedor <> 0 ){
							if ($deudor < 0) {
								echo "<td  ".$color_negativo." align='right'>".number_format(abs($acreedor),2)."</td>";
							} else {
								echo "<td  ".$nivel_color." align='right'>".number_format(abs($acreedor),2)."</td>";
							}
        			        // echo "<td  ".$nivel_color." align='right'>".number_format(abs($acreedor),2)."</td>";
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
			echo "<td align='right'></td>";
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
 	                     jQuery("#tabla_bal_02").DataTable( {
                	        "paging":   true,
                	        "ordering": false,
							"aLengthMenu": [[30, 50, 100,250,500,2500], [30, 50,100,250,500,2500]],
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
 
		
		
		$sql_temp = "SELECT cuenta, detalle, nivel, tipo, registro, debe, haber, deudor, acreedor, 
                            anio, sesion, fecha, inicial_debe, inicial_haber, suma_debe, suma_haber, saldo, deudor_acreedor, impresion 
                       FROM co_resumensaldos
                      where impresion = '1' and 
                            anio =".$this->bd->sqlvalue_inyeccion($this->anio , true).' 
                            order by "idpkResumen"  ';
		
 
						 
									
		$sql_temp = "select f_saldos(".$this->bd->sqlvalue_inyeccion($this->anio , true)." ,".$this->bd->sqlvalue_inyeccion($this->ruc , true).") ";
 

		$this->bd->ejecutar($sql_temp);

       $sql = $this->inserta_nivel_inicial( $sql_temp );
 
 
 
		
		
return  $sql;
	 
	}
	
	//----------------------------------------------------------
	function cabecera($valida){
	    
	    
	    if ( $valida == 'S'){
	        
 
	        
	        echo '<table id ="tabla_bal_02"   class="display table table-condensed table-hover datatable" width="100%"  style="font-size: 12px;">';
	        echo '  <thead> 
                <tr>
                  <th width="10%">Cuenta</th>
                  <th width="27%">Denominacion</th>
                  <th width="5%">Grupo</th>
                  <th width="5%">Subgrupo</th>
                  <th width="5%">Item</th>
                  <th width="6%">Deudor</th>
                  <th width="6%">Acreedor</th>
                  <th width="6%">Debito</th>
                  <th width="6%">Credito</th>
                  <th width="6%">Debito</th>
                  <th width="6%">Credito</th>
                  <th width="6%">Deudor</th>
                  <th width="6%">Acreedor</th>
                </tr> </thead>';
	        
	        
	    }
	    else {
	    
	    echo '<table id ="tabla2" class="table table-striped table-bordered table-hover table-checkable" width="100%" style="font-size: 12px;table-layout: auto">';
	    echo '  <tr>
                  <td colspan="5">&nbsp;</td>
                  <td colspan="2" align="center" bgcolor="#E4FFA7">SALDOS INICIALES</td>
                  <td colspan="2" align="center" bgcolor="#C0D7FF">FLUJOS</td>
                  <td colspan="2" align="center" bgcolor="#FFDBDB">SUMAS</td>
                  <td colspan="2" align="center" bgcolor="#9EFFA6">SALDOS FINALES</td>
                </tr>
                <tr>
                  <td width="10%">Cuenta</td>
                  <td width="27%">Denominacion</td>
                  <td width="5%">Grupo</td>
                  <td width="5%">Subgrupo</td>
                  <td width="5%">Item</td>
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
	    

		$sql_temp ="UPDATE co_resumen_balance
					SET nivel1 = '00'
				WHERE anio = ".$this->bd->sqlvalue_inyeccion($this->anio ,true)." and 
					  nivel1 is null ";

	  $this->bd->ejecutar($sql_temp);


		/*
	    $resultado  = $this->bd->ejecutar($sql_temp);
	    
	    
	    while ($fetch=$this->bd->obtener_fila($resultado)){
	        
 
	        
	        $cuenta = trim($fetch["cuenta"]).'%';
	        
	        $c1     = $this->bd->query_array('co_resumensaldos',' sum(coalesce(debe,0)) as debe,
                                                	        sum(coalesce(haber,0)) as haber,
                                                	        sum(coalesce(deudor,0)) as deudor,
                                                	        sum(coalesce(acreedor,0)) as acreedor,
                                                	        sum(coalesce(inicial_debe,0)) as inicial_debe,
                                                	        sum(coalesce(inicial_haber,0)) as inicial_haber,
                                                	        sum(coalesce(suma_debe,0)) as suma_debe,
                                                	        sum(coalesce(suma_haber,0)) as suma_haber,
                                                	        sum(saldo) as saldo',
	                                          'cuenta like '.$this->bd->sqlvalue_inyeccion($cuenta,true). ' and
                                               anio = '.$this->bd->sqlvalue_inyeccion($this->anio ,true)
	            );
	        
	        
	        //626.01.01                
	        
	        $cuenta = trim($fetch["cuenta"]);
	        $grupo  = substr($cuenta, 0,3);
	        $subgrupo =  substr($cuenta, 4,2);
	        $nivel1   =  substr($cuenta, 7,2);
 
	        if (empty($nivel1)){
	            $nivel1 = '00';
	        }
	            

			$total_valida = $c1["debe"] + $c1["haber"] + $c1["inicial_debe"] + $c1["inicial_haber"] + $c1["suma_debe"] + $c1["suma_haber"] ;

 
	        
	        $InsertQuery = array(
	            array( campo => 'cuenta',   valor => $cuenta),
	            array( campo => 'grupo',   valor => $grupo),
	            array( campo => 'subgrupo',   valor => $subgrupo),
	            array( campo => 'nivel1',   valor => $nivel1),
	            array( campo => 'nivel2',   valor =>'00'),
	            array( campo => 'detalle',   valor => $fetch["detalle"]),
	            array( campo => 'inicial_debe',   valor => $c1["inicial_debe"]),
	            array( campo => 'inicial_haber',   valor => $c1["inicial_haber"]),
	            array( campo => 'debe',   valor => $c1["debe"]),
	            array( campo => 'haber',   valor =>$c1["haber"]),
	            array( campo => 'deudor',   valor => $c1["deudor"]),
	            array( campo => 'acreedor',   valor => $c1["acreedor"]),
	            array( campo => 'suma_debe',   valor => $c1["suma_debe"]),
	            array( campo => 'suma_haber',   valor => $c1["suma_haber"]),
 	            array( campo => 'anio',   valor =>$this->anio ),
	            array( campo => 'sesion',   valor =>$this->sesion ),
	            array( campo => 'deudor_acreedor',   valor =>$fetch["deudor_acreedor"]),
	            array( campo => 'impresion',   valor =>$fetch["impresion"])
	        );
 
		 
 	        if ( 	$total_valida == 0 ){

			}else{
					$this->bd->pideSq(0);
					$this->bd->JqueryInsertSQL('co_resumen_balance',$InsertQuery);

			}
	    }
	    */
	}
	//--- ultimo nivel
	 
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
 
  
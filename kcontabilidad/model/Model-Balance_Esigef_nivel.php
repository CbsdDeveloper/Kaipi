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
	
	function grilla( $f1,$f2,$tipo,$nivel,$auxiliares,$valida){


   
		$sql_genera = "INSERT INTO co_resumensaldos (cuenta, detalle, nivel, tipo, registro,impresion, deudor_acreedor, anio, sesion ) 
		SELECT cuenta, detalle, nivel, tipo, registro,impresion, deudor_acreedor, anio , ".$this->bd->sqlvalue_inyeccion($this->sesion , true)." as sesion 
			FROM co_plan_ctas a
			where a.anio = ".$this->bd->sqlvalue_inyeccion($this->anio , true)." and 
				a.impresion = 1 and 
				a.cuenta not in (select b.cuenta from co_resumensaldos b where b.anio= ".$this->bd->sqlvalue_inyeccion($this->anio , true).")
			order by a.cuenta";


        $this->bd->ejecutar($sql_genera); 


        $sql_genera = "INSERT INTO co_resumensaldos (cuenta, detalle, nivel, tipo, registro,impresion, deudor_acreedor, anio, sesion ) 
		SELECT cuenta, detalle, nivel, tipo, registro,impresion, deudor_acreedor, anio , ".$this->bd->sqlvalue_inyeccion($this->sesion , true)." as sesion 
			FROM co_plan_ctas a
			where a.anio = ".$this->bd->sqlvalue_inyeccion($this->anio , true)." and 
				a.nivel in ( 1,2,3) and 
				a.cuenta not in (select b.cuenta from co_resumensaldos b where b.anio= ".$this->bd->sqlvalue_inyeccion($this->anio , true).")
			order by a.cuenta";


        $this->bd->ejecutar($sql_genera); 

       

        $datos       = $this->sqlwhere( $f1,$f2,$tipo,$nivel);

	    $sql         = $datos['sql'];
        $bandera     = $datos['bandera'];
	    
 		
		if (!empty($sql)){
			
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
			    echo "<td><b>".$x['cuenta']."</b></td>";

				if ( $x['nivel'] == '1'){
					echo "<td><b>".$x['detalle']."</b></td>";
				}else{
					echo "<td>".$x['detalle']."</td>";
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
			                                     'sum(debe) as debe, 
                                                  sum(haber) as haber,
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
        			    
        			    
        			    if ($inicial_haber <> 0 ){
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
        			   
        			    if ( $haber <> 0 ){
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
         			    
        			    if ($suma_haber <> 0 ){
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
			    

				if ( $nivel < 4 ){
					
					$this->firmas();

				}else {
			    
 				
					echo '<script>
                        jQuery.noConflict();
                         jQuery(document).ready(function() {
 	                     jQuery("#tabla_bal_01").DataTable( {
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
			    
					}
			    
			}else {
			    
			    $this->firmas( );
			}
			
		 
		}
 
      
	}
 
	function sqlwhere($f1,$f2,$tipo,$nivel){
		
 
 	
		$sql_temp = "SELECT cuentas,nivels 
                        FROM view_diario_balance 
                        where anio = ".$this->bd->sqlvalue_inyeccion($this->anio ,true)."
                        group by cuentas,nivels 
                        order by cuentas";
                        
 
		$this->inserta_nivel( $sql_temp );
		
        $where   = 'anio = '.$this->bd->sqlvalue_inyeccion($this->anio  + 1 ,true);

        $bandera = 2;
 
      
        if ( $nivel == '-1' ){
            
            $bandera = 1;
            $where = 'anio = '.$this->bd->sqlvalue_inyeccion($this->anio ,true);

 	 	 }else{
            if ( $nivel > 0 )   {
                if ($tipo == '-' ){

                        $where = 'nivel  <='.$this->bd->sqlvalue_inyeccion($nivel ,true).'  and 
                                anio = '.$this->bd->sqlvalue_inyeccion($this->anio ,true);
                        $bandera = 0;   

                 }   else {
                       
                    $where = 'nivel  <='.$this->bd->sqlvalue_inyeccion($nivel ,true).'  and 
                              anio = '.$this->bd->sqlvalue_inyeccion($this->anio ,true).'  and 
                              tipo = '.$this->bd->sqlvalue_inyeccion($tipo ,true);
                   $bandera = 0;  

                }
            }    
           
        }
  
		
		if ( $bandera == 0 ){
		    
		    $sql = 'SELECT cuenta, detalle, nivel, 
                           sum(debe) as debe, sum(haber) as haber, 
                           sum(deudor) as deudor, sum(acreedor) as  acreedor, 
                           sum(coalesce(suma_debe,0)) as suma_debe, 
                           sum(coalesce(suma_haber,0)) as suma_haber,
                           sum(coalesce(inicial_debe,0)) as inicial_debe, 
                           sum(coalesce(inicial_haber,0)) as inicial_haber,
                           deudor_acreedor
 	                FROM  co_resumensaldos where '  .$where.' 
                    group by cuenta, detalle, nivel,deudor_acreedor
                    order by cuenta, detalle';
		    
		 
		     
		}else{
		    
		    $sql = 'SELECT cuenta, detalle, nivel, inicial_debe, inicial_haber,debe, haber,suma_debe, suma_haber, deudor, acreedor, anio, tipo,deudor_acreedor
 	                FROM  co_resumensaldos where '  .$where. '  order by cuenta, detalle';
		}
		
	 
		$datos["sql"]     = $sql;
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
                  <th width="10%">Cuenta</th>
                  <th width="37%">Denominacion</th>
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
                  <td colspan="3">&nbsp;</td>
                  <td colspan="2" align="center" bgcolor="#E4FFA7">SALDOS INICIALES</td>
                  <td colspan="2" align="center" bgcolor="#C0D7FF" >FLUJOS</td>
                  <td colspan="2" align="center" bgcolor="#FFDBDB">SUMAS</td>
                  <td colspan="2" align="center" bgcolor="#9EFFA6">SALDOS FINALES</td>
                </tr>
                <tr>
                  <td width="5%">Nivel</td>
                  <td width="10%">Cuenta</td>
                  <td width="37%">Denominacion</td>
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
 
	//--- ultimo nivel
	public function inserta_nivel( $sql_temp ){
	    
        $this->bd->pideSq(0);

        $resultado  = $this->bd->ejecutar($sql_temp);
 	      
	    while ($fetch_dato=$this->bd->obtener_fila($resultado)){
	        
  	            $deudor        =   '0.00';
	            $acreedor      =   '0.00';
	            $cuenta        =    trim($fetch_dato["cuentas"]);
	       
	            $c2     = $this->bd->query_array('co_plan_ctas','cuenta, cuentas,nivel,detalle,tipo,deudor_acreedor,impresion',
	                                         'cuenta='.$this->bd->sqlvalue_inyeccion($cuenta,true). ' and
                                              anio = '.$this->bd->sqlvalue_inyeccion($this->anio ,true)
	            );
				
				
			   $tipo_cuenta   = trim($c2["tipo"]) ;
               $existe        = $this->bd->query_array('co_resumensaldos','count(*) as nn',
                                                 'cuenta='.$this->bd->sqlvalue_inyeccion($cuenta,true). ' and
                                                  anio = '.$this->bd->sqlvalue_inyeccion($this->anio ,true)
                                                 );
             
             if ( $existe["nn"] > 0  ){

                    return 0;

             }else {

                $InsertQuery = array(
                    array( campo => 'cuenta',     valor => trim($cuenta)),
                    array( campo => 'detalle',    valor => $c2["detalle"]),
                    array( campo => 'nivel',      valor => $c2["nivel"]),
                    array( campo => 'debe',       valor => $deudor),
                    array( campo => 'haber',      valor => $acreedor),
                    array( campo => 'deudor',     valor => $deudor),
                    array( campo => 'acreedor',   valor => $acreedor),
                    array( campo => 'anio',       valor =>$this->anio ),
                    array( campo => 'tipo',       valor =>$tipo_cuenta ),
                    array( campo => 'registro',   valor =>$this->ruc ),
                    array( campo => 'deudor_acreedor',   valor =>$c2["deudor_acreedor"]),
                    array( campo => 'impresion',         valor =>$c2["impresion"])
                );

                 $this->bd->JqueryInsertSQL('co_resumensaldos',$InsertQuery);

                 return 1;
             }
         
 
	    }
 
	}
  
//---------------
	function titulo($f1,$f2){
	    
	    
	    $this->hoy 	     =  date("Y-m-d");
	    
	    $this->login     =  trim($_SESSION['login']);
	    
 	    
	    $imagen = '<img src="../../kimages/'.trim($_SESSION['logo']).'"  width="200" height="120" >';
	    
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
	
	$valida			    =     $_POST["valida"];
	
 
	$gestion->grilla( $f1,$f2,$tipo,$nivel,$auxiliares,$valida);
 
	
}



?>
 
  
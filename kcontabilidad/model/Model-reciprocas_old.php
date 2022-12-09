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

		ini_set("memory_limit", "-1");
		set_time_limit(0);
		
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
		
		$this->ruc       =  $_SESSION['ruc_registro'];
		
		$this->sesion 	 =  trim($_SESSION['email']);
		
		$this->hoy 	     =  date("Y-m-d");
		
		$this->login     =  trim($_SESSION['login']);
 		
		$this->anio       =  $_SESSION['anio'];
		
 		
	}
   
	//--- calcula libro diario
	
	function grilla(  $f2 ){





		
        $periodo_genera = explode('-',$f2);

        $anio = $periodo_genera[0];
        $mes  = intval($periodo_genera[1]);

		$this->bd->JqueryDeleteSQL('co_reciprocas','1=1');	
		

        $sql_genera = "INSERT INTO co_reciprocas (periodo, ruc, cuenta_1, nivel_11, nivel_12, deudor_1,   acreedor_1, 
                                                ruc1, nombre, grupo, subgrupo, 
                                                item, cuenta_2, nivel_21, nivel_22, deudor_2, 
                                                acreedor_2, asiento, tramite, fecha, fecha_pago, id_asiento_ref,tipo,partida,impresion)
                    SELECT mes,registro,  grupo_es, subgrupo_es,nivel_es,debe, haber,
                            idprov,razon,grupoi,  subgrupoi, itemi,'000' as a,'00' as b,'00' as c,haber,debe,
                            id_asiento,id_tramite,fecha,fecha,coalesce(id_asiento_ref,0) as id_asiento_ref,1 as tipo,partida,impresion
                    FROM  view_aux_esigef
                        where anio = ".$this->bd->sqlvalue_inyeccion($this->anio , true)." and 
                            mes = ".$this->bd->sqlvalue_inyeccion($mes  , true)."
                        order by fecha asc";

 					
     $this->bd->ejecutar($sql_genera);

	 $sql_genera = "INSERT INTO co_reciprocas (periodo, ruc, cuenta_1, nivel_11, nivel_12, deudor_1,   acreedor_1, 
												ruc1, nombre, grupo, subgrupo,  item, 
												cuenta_2, nivel_21, nivel_22, deudor_2, 
												acreedor_2, asiento, tramite, fecha, fecha_pago, id_asiento_ref,tipo,partida,impresion)
 						SELECT mes,registro,  grupo_es, subgrupo_es, '00' as nivel_12, debe, haber,
							   '999999999999' as ruc, 'CONSUMIDOR FINAL' AS nombre,grupoi,  subgrupoi, itemi,
							   '000' as a,'00' as b,'00' as c,haber,debe,
							   id_asiento, 0 as id_tramite,fecha,fecha,0 as id_asiento_ref,2 as tipo,partida,impresion
						FROM  view_aux_esigef_in
						where anio = ".$this->bd->sqlvalue_inyeccion($this->anio , true)." and 
						mes = ".$this->bd->sqlvalue_inyeccion($mes  , true)."
						order by fecha asc";
 
	 $this->bd->ejecutar($sql_genera);



	 $sql_genera = "INSERT INTO co_reciprocas (periodo, ruc, cuenta_1, nivel_11, nivel_12, deudor_1,   acreedor_1, 
												ruc1, nombre, grupo, subgrupo,  item, 
												cuenta_2, nivel_21, nivel_22, deudor_2, 
												acreedor_2, asiento, tramite, fecha, fecha_pago, id_asiento_ref,tipo,partida,impresion)
				SELECT mes,registro,  grupo_es, subgrupo_es, nivel_es, debe, haber,
				idprov , razon ,'00' as grupoi,  '00' as subgrupoi, '00' as itemi,
				'000' as a,'00' as b,'00' as c,haber,debe,
				id_asiento, 0 as id_tramite,fecha,fecha,0 as id_asiento_ref,3 as tipo,partida,esigef
				FROM  view_aux_esigef_an
				where anio = ".$this->bd->sqlvalue_inyeccion($this->anio , true)." and 
						mes = ".$this->bd->sqlvalue_inyeccion($mes  , true)."
						order by fecha asc";

				$this->bd->ejecutar($sql_genera);

 



     $tipo 		= $this->bd->retorna_tipo();
			
			echo '<div class="col-md-12" align="center" style="padding-bottom:10;padding-top:15px"> ';
			
			$this->titulo($f1,$f2);
			
			echo '</div> ';

             

 
            echo '<div class="col-md-12" style="padding-bottom:20;padding-top:20px;overflow-x:scroll;white-space: nowrap;">   ';
         
                       $this->cabecera();

            
                       $sql = 'SELECT *   FROM  co_reciprocas   order by tipo, fecha asc';

                        $stmt = $this->bd->ejecutar($sql);


                        while ($x=$this->bd->obtener_fila($stmt)){

                            echo "<tr>";

							$cuenta      = $x['cuenta_1'];
							$idasiento   = $x['asiento'];
							$partida     = $x['partida'] ;
							$debe        = $x['deudor_1'] ;
							$haber       = $x['acreedor_1'] ;
							$idtramite   = $x['tramite'] ;
							$id_reciproco= $x['id_reciproco'] ;

							$impresion= $x['impresion'] ;

							$tipo_tra  = $x['tipo'] ;

                            echo "<td bgcolor='#FF8D8F'><b>".$x['cuenta_1']."</b></td>";
                            echo "<td bgcolor='#FF8D8F'><b>".$x['nivel_11']."</b></td>";

							$aux_nivel = '00';
							
							if ( $tipo_tra == 3 ) {
								if ( $impresion == 0){
									echo "<td bgcolor='#FF8D8F'><b>00</b></td>";
								}else{
									echo "<td bgcolor='#FF8D8F'><b>".$x['nivel_12']."</b></td>";
									$aux_nivel = $x['nivel_12'];
								}
							}else	{
								    echo "<td bgcolor='#FF8D8F'><b>".$x['nivel_12']."</b></td>";
								    $aux_nivel = $x['nivel_12'];
							}

                            echo "<td>".$x['deudor_1']."</td>";
                            echo "<td>".$x['acreedor_1']."</td>";


							$id_asiento_ref = $x['id_asiento_ref'];

							$datos = $this->verifica_aux( $cuenta, $idasiento, $partida, $debe, $haber,$idtramite,$id_reciproco,$tipo_tra,$impresion ,$aux_nivel  );

							if ( $tipo_tra == 1 ) {
								echo "<td>".$x['ruc1']."</td>";
								echo "<td>".$x['nombre']."</td>";
								if ( $id_asiento_ref == 0 ){
									$id_asiento_ref  = $x['asiento'];
								}
							}

							if ( $tipo_tra == 2 ) {
									echo "<td>".$datos['ruc1']."</td>";
									echo "<td>".$datos['nombre']."</td>";
									$id_asiento_ref  = $x['asiento'];
							}
							if ( $tipo_tra == 3 ) {
								echo "<td>".$x['ruc1']."</td>";
								echo "<td>".$x['nombre']."</td>";
								$id_asiento_ref  = $x['asiento'];
							}


                            echo "<td><b>".$x['grupo']."</b></td>";
                            echo "<td><b>".$x['subgrupo']."</b></td>";
                            echo "<td><b>".$x['item']."</b></td>";

						

                            echo "<td bgcolor='#FBC0FF'><b>".$datos['c1']."</b></td>";
                            echo "<td bgcolor='#FBC0FF'><b>".$datos['c2']."</b></td>";
                            echo "<td bgcolor='#FBC0FF'><b>".$datos['c3']."</b></td>";

                            echo "<td>".$x['deudor_2']."</td>";
                            echo "<td>".$x['acreedor_2']."</td>";
                            echo "<td>".$x['asiento']."</td>";

                            echo "<td>".$id_asiento_ref ."</td>";
                            echo "<td>".$x['fecha']."</td>";
                            echo "<td>".$x['fecha_pago']."</td>";
                

                            echo "</tr>";

                        }

          echo "</table>";
			echo '</div> ';

			echo '<script>
			jQuery.noConflict();
			 jQuery(document).ready(function() {
			  jQuery("#tabla_bal_02").DataTable( {
				"paging":   true,
				"ordering": false,
				"aLengthMenu": [[10,30, 50, 100,250,500,2500], [10,30, 50,100,250,500,2500]],
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
			
			unset($x); //eliminamos la fila para evitar sobrecargar la memoria
			
			pg_free_result ($stmt) ; 
	}
 
	 
	
	//----------------------------------------------------------
	function cabecera(){
	    
 
	        
	        
	        echo ' <table id="tabla_bal_02"
                              class="display table table-condensed table-hover datatable" width="120%"   style="font-size: 11px;">';
  	        echo '<thead><tr>
                  <th width="5%">Cuenta</th>
                  <th width="5%">Nivel1</th>
                  <th width="5%">Nivel2</th>
                  <th width="5%">Deudor</th>
                  <th width="5%">Acreedor</th>
                  <th width="10%">RUC</th>
                  <th width="25%">Nombre</th>
                  <th width="5%">Grupo</th>
                  <th width="5%">Subgrupo</th>
                  <th width="5%">Item</th>
                  <th width="5%">Cuenta</th>
                  <th width="5%">Nivel1</th>
                  <th width="5%">Nivel2</th>
                  <th width="5%">Deudor</th>
                  <th width="5%">Acreedor</th>
                  <th width="5%">Transaccion</th>
                  <th width="5%">Referencia</th>
                  <th width="5%">Fecha</th>
                  <th width="5%">Pago</th>
                </tr></thead>';
	        
            

	    
	}
	//--------------------
	public function verifica_aux( $cuenta, $idasiento, $partida, $debe, $haber,$idtramite,$id_reciproco, $tipo_tra ,$impresion,$aux_nivel  ){
	    
		//------------------------------------------------------------------------------------------------------
		//------------------------------------------------------------------------------------------------------
		if ( $tipo_tra  == 1 ){

				if (  $haber > 0 ){
 							$c1     = $this->bd->query_array('co_asientod',
							'cuenta,  substring(cuenta,1,3) as c1,  substring(cuenta,5,2) as c2, substring(cuenta,8,2) as c3',
							'id_asiento='.$this->bd->sqlvalue_inyeccion($idasiento,true). ' and partida = '.$this->bd->sqlvalue_inyeccion($partida ,true) .' and debe > 0 '
							);
		
							$this->actualiza_cuenta($c1 ,$id_reciproco, $idasiento,1);
							return $c1  ;

				}
				if (  $debe > 0 ){

							$c1     = $this->bd->query_array('co_asientod', 'cuenta,  substring(cuenta,1,3) as c1,  substring(cuenta,5,2) as c2,  substring(cuenta,8,2) as c3',
															'id_asiento='.$this->bd->sqlvalue_inyeccion($idasiento,true). ' and 
															 cuenta like '.$this->bd->sqlvalue_inyeccion('111.%' ,true) 
							);
		
							$c1['c3'] = '00';
							$this->actualiza_cuenta($c1 ,$id_reciproco, $idasiento,2);
							return $c1  ;
 				}
		}

		//------------------------------------------------------------------------------------------------------
		//------------------------------------------------------------------------------------------------------
		if ( $tipo_tra  == 2 ){

						if (  $debe > 0 ){
							$c1     = $this->bd->query_array('co_asientod',
															'cuenta,  substring(cuenta,1,3) as c1,  substring(cuenta,5,2) as c2, substring(cuenta,8,2) as c3',
															'id_asiento='.$this->bd->sqlvalue_inyeccion($idasiento,true). ' and partida = '.$this->bd->sqlvalue_inyeccion( $partida ,true) .' and haber > 0'  );

							$datos_c1 = 	$this->bd->query_array('co_asientod',
															'aux',
															'id_asiento='.$this->bd->sqlvalue_inyeccion($idasiento,true). ' and partida = '.$this->bd->sqlvalue_inyeccion( $partida ,true) .' and 
															 cuenta like ' .$this->bd->sqlvalue_inyeccion( $cuenta.'%' ,true) .'  and debe  > 0' );

							if ( trim($datos_c1['aux']) == 'S'){

								$c1_aux     = $this->bd->query_array('view_asientos_diario',
								'idprov ,razon', 	'id_asiento='.$this->bd->sqlvalue_inyeccion($idasiento,true) );

								$c1['ruc1'] 		= trim($c1_aux['idprov']); 
								$c1['nombre']		= trim($c1_aux['razon']);

							}else{
								$c1['ruc1'] 		= '9999999999999';
								$c1['nombre']		= 'CONSUMIDOR FINAL';
							}
 
							$this->actualiza_cuenta($c1 ,$id_reciproco, $idasiento,3);

							return $c1  ;

						}
 
						if (  $haber > 0 ){
 								$c1     = $this->bd->query_array('co_asientod',
								'cuenta,  substring(cuenta,1,3) as c1,  substring(cuenta,5,2) as c2, substring(cuenta,8,2) as c3',
								'id_asiento='.$this->bd->sqlvalue_inyeccion($idasiento,true). ' and cuenta like '.$this->bd->sqlvalue_inyeccion('111.%' ,true) .' and debe > 0 '
								);

								$datos_c1 = 	$this->bd->query_array('co_asientod',
															'aux',
															'id_asiento='.$this->bd->sqlvalue_inyeccion($idasiento,true). ' and
															partida = '.$this->bd->sqlvalue_inyeccion( $partida ,true) .' and 
															cuenta like ' .$this->bd->sqlvalue_inyeccion( $cuenta.'%' ,true) .'  and haber  > 0' );
		
							    $c1['c3'] = '00';

								if ( trim($datos_c1['aux']) == 'S'){
									$c1_aux     = $this->bd->query_array('view_asientos_diario',
									'idprov ,razon',
									'id_asiento='.$this->bd->sqlvalue_inyeccion($idasiento,true)
									);

									$c1['ruc1'] 		= trim($c1_aux['idprov']); 
									$c1['nombre']		= trim($c1_aux['razon']);

								}else{
									$c1['ruc1'] 		= '9999999999999';
									$c1['nombre']		= 'CONSUMIDOR FINAL';
								}

								$this->actualiza_cuenta($c1 ,$id_reciproco, $idasiento,4);
 								return $c1  ;

				     }

	     	}

		//------------------------------------------------------------------------------------------------------
		//------------------------------------------------------------------------------------------------------
		// anticipos $impresion

		if ( $tipo_tra  == 3 ){

			if (  $debe > 0 ){
 
						 $c1     = $this->bd->query_array('co_asientod',
							'cuenta,  substring(cuenta,1,3) as c1,  substring(cuenta,5,2) as c2, substring(cuenta,8,2) as c3',
							'id_asiento='.$this->bd->sqlvalue_inyeccion($idasiento,true). ' and
							cuenta like '.$this->bd->sqlvalue_inyeccion('111.%' ,true) .' and haber > 0 ' 
							);

						$c1['c3'] = '00';
						$this->actualiza_cuenta($c1 ,$id_reciproco, $idasiento,5,$aux_nivel );

						return $c1  ;
		 
		    }else {
 
				$c1     = $this->bd->query_array('co_asientod',
				   'cuenta,  substring(cuenta,1,3) as c1,  substring(cuenta,5,2) as c2, substring(cuenta,8,2) as c3',
				   'id_asiento='.$this->bd->sqlvalue_inyeccion($idasiento,true). ' and
				   cuenta like '.$this->bd->sqlvalue_inyeccion('111.%' ,true) .' and debe > 0 ' 
				   );

			   $c1['c3'] = '00';
			   $this->actualiza_cuenta($c1 ,$id_reciproco, $idasiento,5,$aux_nivel );

			   return $c1  ;

   }

		}
	 
	}
	//--- ultimo nivel
	public function actualiza_cuenta( $c1 ,$id_reciproco, $idasiento,$tipo ,$aux_nivel = "-"){
	    
       
		if ( $tipo == 1){

			$sql = "update co_reciprocas
					set cuenta_2 = ".$this->bd->sqlvalue_inyeccion(trim($c1['c1']) , true).",
						nivel_21 = ".$this->bd->sqlvalue_inyeccion(trim($c1['c2']) , true).",
						nivel_22 = ".$this->bd->sqlvalue_inyeccion(trim($c1['c3']) , true).
				    "where id_reciproco=".$this->bd->sqlvalue_inyeccion($id_reciproco , true);

					$this->bd->ejecutar($sql);
		}
 
		if ( $tipo == 2){
			$sql = "update co_reciprocas
					set cuenta_2 = ".$this->bd->sqlvalue_inyeccion( trim($c1['c1']) , true).",
						nivel_21 = ".$this->bd->sqlvalue_inyeccion( trim($c1['c2']) , true).",
						nivel_22 = ".$this->bd->sqlvalue_inyeccion('00' , true).
				    "where id_reciproco=".$this->bd->sqlvalue_inyeccion($id_reciproco , true);

					$this->bd->ejecutar($sql);
		}
 				
					
		if ( $tipo == 3){
 			 
		

			$sql = "update co_reciprocas
					set cuenta_2 = ".$this->bd->sqlvalue_inyeccion(trim($c1['c1']) , true).",
						nivel_21 = ".$this->bd->sqlvalue_inyeccion(trim($c1['c2']) , true).",
						id_asiento_ref = ".$this->bd->sqlvalue_inyeccion($idasiento, true).",
 						nombre = ".$this->bd->sqlvalue_inyeccion(trim($c1['nombre']) , true).",
						nivel_22 = ".$this->bd->sqlvalue_inyeccion(trim($c1['c3']) , true).
				    "where id_reciproco=".$this->bd->sqlvalue_inyeccion($id_reciproco , true);

					

					$this->bd->ejecutar($sql);
		}
		 

		if ( $tipo == 4){
			$sql = "update co_reciprocas
					set cuenta_2 = ".$this->bd->sqlvalue_inyeccion( trim($c1['c1']) , true).",
						nivel_21 = ".$this->bd->sqlvalue_inyeccion( trim($c1['c2']) , true).",
						id_asiento_ref = ".$this->bd->sqlvalue_inyeccion($idasiento, true).",
						ruc1 = ".$this->bd->sqlvalue_inyeccion(trim($c1['ruc1']) , true).",
						nombre = ".$this->bd->sqlvalue_inyeccion(trim($c1['nombre']) , true).",
						nivel_22 = ".$this->bd->sqlvalue_inyeccion('00' , true).
				    "where id_reciproco=".$this->bd->sqlvalue_inyeccion($id_reciproco , true);

					$this->bd->ejecutar($sql);
		}


		if ( $tipo == 5){
 			 

			$sql = "update co_reciprocas
					set cuenta_2 = ".$this->bd->sqlvalue_inyeccion(trim($c1['c1']) , true).",
						nivel_21 = ".$this->bd->sqlvalue_inyeccion(trim($c1['c2']) , true).",
						nivel_12 = ".$this->bd->sqlvalue_inyeccion(trim($aux_nivel) , true).",
						id_asiento_ref = ".$this->bd->sqlvalue_inyeccion($idasiento, true).",
						nivel_22 = ".$this->bd->sqlvalue_inyeccion(trim($c1['c3']) , true).
				    "where id_reciproco=".$this->bd->sqlvalue_inyeccion($id_reciproco , true);
 

					$this->bd->ejecutar($sql);
		}

 
	}
	//--- ultimo nivel
	 
//---------------
	function titulo($f1,$f2){
	    
	    
	    $this->hoy 	     =  date("Y-m-d");
	    
	    $this->login     =  trim($_SESSION['login']);
	    
 	    
	    $imagen = '<img src="../../kimages/'.trim($_SESSION['logo']).'" width="190" height="140" >';
	    
	    echo '<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 13px;table-layout: auto"> 
              <tr>
                  <td width="20%" rowspan="2">'.$imagen.'</td>
                  <td  width="60%" rowspan="2" style="text-align: center"><b>'.$_SESSION['razon'].'</b><br>
                        <b>'.$_SESSION['ruc_registro'].'</b><br><br>
                        <b>CONTABILIDAD ( PERIODO '.$this->anio.' ) </b><br>
                        <b>RESUMEN DE TRANSACCIONES RECIPROCAS '.$f1.'  al '.$f2.'</b></td>
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

if (isset($_POST["ffecha2"]))	{
	
 
	$f2 				=     $_POST["ffecha2"];
 
	
 
	$gestion->grilla( $f2 );
 
	
}



?>
 
  
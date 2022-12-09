<?php
session_start();
require '../../kconfig/Db.class.php';
require '../../kconfig/Obj.conf.php';
include('phpqrcode/qrlib.php');


class ReportePdf{

	public $obj ;
	public $bd ;
	public $ruc;
	public $Registro;
	private $anio;
	
	//Constructor de la clase
	
	function ReportePdf(){
		//inicializamos la clase para conectarnos a la bd
		$this->obj       = 	new objects;
		$this->bd        = 	new Db;
		$this->ruc       =  $_SESSION['ruc_registro'];
		$this->anio      =  $_SESSION['anio'];
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
		
	}
	//------------------------------------
	
	function CabCaja($asiento){
	    
	    //--- beneficiario
	    $sqlB = "select fecha, registro, anio, mes, detalle, sesion, creacion, estado, cuenta
			       from co_caja
				  where  id_co_caja =".$this->bd->sqlvalue_inyeccion($asiento,true) ;
	    
	    
	    $resultadoB = $this->bd->ejecutar($sqlB);
	    
	    $datos         =$this->bd->obtener_array( $resultadoB); 
	    
	    return $datos;
	}
	
	//----------------
	
	function Tramite_variables_formulario($tramite,$id_rubro){
	    
	    
	    
	    
	    $sql_det1 = 'SELECT etiqueta
                    FROM rentas.view_ren_tramite_var
                    where id_rubro = '.$this->bd->sqlvalue_inyeccion($id_rubro,true). ' and
						  id_ren_tramite = '.$this->bd->sqlvalue_inyeccion($tramite,true).'  
                    group by etiqueta ORDER BY etiqueta ASC' ;
	    
	    
	    
	    $stmt1 = $this->bd->ejecutar($sql_det1);
	    
	    
	    
	    
	    while ($xx=$this->bd->obtener_fila($stmt1)){
	        
	        
	        $etiqueta  = trim($xx['etiqueta']) ;
	        
	        echo '<div class="col-md-12">';
	        
	        echo '<span style="font-size: 11px"><b>'. strtoupper($etiqueta) .'</b></span>';
	        
	        $this->crea_formulario_formato( $etiqueta, $id_rubro ,$tramite);
	        
	        
	        echo '</div>';
	        
	        
	    }
	    
	    
	    
	}
	/*

	*/

	function Tramite_variables($tramite,$id_rubro){
	    
	   


        $sql_det1 = 'SELECT etiqueta
                    FROM rentas.view_ren_tramite_var
                    where id_rubro = '.$this->bd->sqlvalue_inyeccion($id_rubro,true). ' and 
						  id_ren_tramite = '.$this->bd->sqlvalue_inyeccion($tramite,true).' and valor_variable is not null 
                    group by etiqueta ORDER BY etiqueta ASC' ;

 

        $stmt1 = $this->bd->ejecutar($sql_det1);
 
	 
	

        while ($xx=$this->bd->obtener_fila($stmt1)){


            $etiqueta  = trim($xx['etiqueta']) ;

			echo '<div class="col-md-12">';

            echo '<span style="font-size: 11px"><b>'. strtoupper($etiqueta) .'</b></span>';
   
			$this->crea_formulario( $etiqueta, $id_rubro ,$tramite);


			echo '</div>';

	 
        }

	

	}
	
	/*
	 */
	function crea_formulario_formato(  $etiqueta, $id_rubro ,$id ){
	    
	    
	    
	    $sql_det2 = 'SELECT valor_variable,  nombre_variable,    id_catalogo,   etiqueta, columna
						FROM rentas.view_ren_tramite_var
						where id_rubro = '.$this->bd->sqlvalue_inyeccion($id_rubro,true).' and
					      	  id_ren_tramite = '.$this->bd->sqlvalue_inyeccion($id,true).' and
							  etiqueta = '.$this->bd->sqlvalue_inyeccion($etiqueta,true).'   
					     ORDER BY id_rubro_var' ;
	    
	    $stmt2 = $this->bd->ejecutar($sql_det2);
	    
	    
	    echo '  <table border="0" width="100%" cellspacing="0" cellpadding="0" >';
	    
	    
	    $i = 0;
	    
	    while ($x=$this->bd->obtener_fila($stmt2)){
	        
	        
	        $nombre_variable  = trim($x['nombre_variable']) ;
	        
	        $valor_variable  = trim($x['valor_variable']) ;
	        
	        $catalogo = trim($x['id_catalogo']);
	        
	        $long = strlen($catalogo);
	        
	        if ( $long  > 1 ) {
	            
	            $xy = $this->bd->query_array('par_catalogo',
	                'nombre',
	                'idcatalogo='.$this->bd->sqlvalue_inyeccion(trim($valor_variable) ,true)
	                );
	            
	            $valor_variable = trim($xy['nombre'] );
	            
	        }
	        
	        if ($i%2==0){
	            echo '<tr>';
	            echo '<td width="20%" style="font-size: 10px;padding: 2px; border-collapse: collapse; border: 1px solid #AAAAAA;">'.$nombre_variable.'</td>';
	            echo '<td width="30%" style="font-size: 10px;padding: 2px; border-collapse: collapse; border: 1px solid #AAAAAA;"><strong>&nbsp;</strong></td>';
	        }else{
	            echo '<td width="20%" style="font-size: 10px;padding: 2px; border-collapse: collapse; border: 1px solid #AAAAAA;">'.$nombre_variable.'</td>';
	            echo '<td width="30%" style="font-size: 10px;padding: 2px; border-collapse: collapse; border: 1px solid #AAAAAA;"><strong>&nbsp;</strong></td>';
	            echo '</tr>';
	        }
	        
	        
	        
	        $i ++ ;
	        
	    }
	    
	    echo '</tr>';
	    
	    echo '  </table>';
	    
	}   
	/*
	*/
	function crea_formulario(  $etiqueta, $id_rubro ,$id ){
       

 				
			$sql_det2 = 'SELECT valor_variable,  nombre_variable,    id_catalogo,   etiqueta, columna 
						FROM rentas.view_ren_tramite_var
						where id_rubro = '.$this->bd->sqlvalue_inyeccion($id_rubro,true).' and 
					      	  id_ren_tramite = '.$this->bd->sqlvalue_inyeccion($id,true).' and 
							  etiqueta = '.$this->bd->sqlvalue_inyeccion($etiqueta,true).' and valor_variable is not null 
					     ORDER BY id_rubro_var' ;
			 
					   $stmt2 = $this->bd->ejecutar($sql_det2);
	  
 
	  echo '  <table border="0" width="100%" cellspacing="0" cellpadding="0" >';
 	  
 	
			$i = 0;

			while ($x=$this->bd->obtener_fila($stmt2)){
				
		 
				$nombre_variable  = trim($x['nombre_variable']) ;

				$valor_variable  = trim($x['valor_variable']) ;
	
				$catalogo = trim($x['id_catalogo']);

				$long = strlen($catalogo);

				if ( $long  > 1 ) {
					
					$xy = $this->bd->query_array('par_catalogo',   
					'nombre',                  
					'idcatalogo='.$this->bd->sqlvalue_inyeccion(trim($valor_variable) ,true)  
					);

					$valor_variable = trim($xy['nombre'] );

				}

				if ($i%2==0){
					echo '<tr>';
					echo '<td width="20%" style="font-size: 10px;padding: 2px; border-collapse: collapse; border: 1px solid #AAAAAA;">'.$nombre_variable.'</td>';
					echo '<td width="30%" style="font-size: 10px;padding: 2px; border-collapse: collapse; border: 1px solid #AAAAAA;"><strong>'.$valor_variable.'</strong></td>';
				}else{
					echo '<td width="20%" style="font-size: 10px;padding: 2px; border-collapse: collapse; border: 1px solid #AAAAAA;">'.$nombre_variable.'</td>';
					echo '<td width="30%" style="font-size: 10px;padding: 2px; border-collapse: collapse; border: 1px solid #AAAAAA;"><strong>'.$valor_variable.'</strong></td>';
					echo '</tr>';
				}

 			 

					$i ++ ;
 				
				}

				echo '</tr>';

				echo '  </table>';
 		
	   }   
	//---------------------
	function ResumenCajaEnlace( $id,$f1){
	    
	    
	    $array = explode("-", $f1);
	    
	    $anio = $array[0];
	    
	    
	    $sql = "SELECT substring(cuenta,1,3) as grupo,  sum(debe) - sum(haber) as saldo
                    FROM public.co_asientod_manual
                    where parte = ".$this->bd->sqlvalue_inyeccion(trim($id),true)."
                    group by substring(cuenta,1,3) 
                    having sum(debe) - sum(haber) <> 0 
                    order by 1";
 
	    $resultado  = $this->bd->ejecutar($sql);
	    
	    echo  '<h3>Detalle Informacion</h3>';
	    echo  '<ul class="list-group">';
	    
	    while ($row=$this->bd->obtener_fila($resultado)){
	        
	        $z = $this->bd->query_array('co_plan_ctas',
	            'detalle',
	            'cuenta='.$this->bd->sqlvalue_inyeccion($row["grupo"],true). ' and 
                   anio='.$this->bd->sqlvalue_inyeccion($anio,true)
	            );
 	            
	        echo '<li class="list-group-item">'.$row["grupo"].' '. $z["detalle"].'</li>';
	        
	        $this->GrillaCajaDetBancos($row["grupo"],$id,$anio);
	        
	    }
	    
	   
	    echo  '</ul>';
	     
	}
	//--------------
	function ResumenCajaConta($parte,$f1){
	    
	    $array = explode("-", $f1);
	    
	    $anio = $array[0];
	    
	    
	    $sql = "SELECT  a.cuenta || ' ' as cuenta,
                        b.detalle,
                        a.partida || ' ' as partida ,
                        a.debe , a.haber
                        FROM co_asientod_manual a, co_plan_ctas b
                        where a.parte = ".$this->bd->sqlvalue_inyeccion(trim($parte) , true)." and
                        	  a.cuenta = b.cuenta and
                              b.anio= ".$this->bd->sqlvalue_inyeccion($anio , true)."
                        order by a.cuenta";
	    
	    
	    echo '<div  style="font-size: 11px;padding:10px">';
	    
	    $estilo = 'class="solid"';
	  
	    
	    echo  '<table width="90%">
				  <tr>
			        <td width="10%" '.$estilo.' align="center"><b>Cuenta</b></td>
					<td width="40%" '.$estilo.' align="center"><b>Detalle</b></td>
                    <td width="20%" '.$estilo.' align="center"><b>Partida</b></td>
                    <td width="10%" '.$estilo.' align="right"><b>Debe</b></td>
                    <td width="10%" '.$estilo.' align="right"><b>Haber</b></td>
				  </tr>';
	    
	    $stmt_detalle = $this->bd->ejecutar($sql);
	    
	    $a = 0;
	    $b = 0;
	    
	    while ($row1=$this->bd->obtener_fila($stmt_detalle)){
	        
	        $saldo  = $row1["debe"];
	        $saldo1 = $row1["haber"];
	        echo  '<tr>
					   <td '.$estilo.' align="left">'.$row1["cuenta"].'</td>
					   <td '.$estilo.' align="left">'.$row1["detalle"].'</td>
	                   <td '.$estilo.' align="left">'.$row1["partida"].'</td>
	                   <td '.$estilo.' align="right">'.number_format($saldo, 2, ',', '.').'</td>
	                   <td '.$estilo.' align="right">'.number_format($saldo1, 2, ',', '.').'</td>';
	        echo  "</tr>";
	        
	        
	        $a = $a + $row1["debe"];
	        $b = $b + $row1["haber"];
	    }
	    
	    echo  '<tr>
					   <td align="left"> </td>
					   <td align="left"></td>
	                   <td align="center"></td>
	                   <td align="right"><b>'.number_format($a, 2, ',', '.').'</b></td>
	                   <td align="right"><b>'.number_format($b, 2, ',', '.').'</b></td>';
	    echo  "</tr>";
	    
	    echo  "</table>";
	    echo '  </div>';
	    
	}
	//---------------------------
	function GrillaCajaDetBancos($grupo,$parte,$anio){
	    
	    
 	    
 	    
	    $sql = "SELECT  a.cuenta || ' ' as cuenta,
                        b.detalle, 
                        a.partida || ' ' as partida , 
                        abs(sum(a.debe) - sum(a.haber)) as monto
                        FROM co_asientod_manual a, co_plan_ctas b
                        where a.parte = ".$this->bd->sqlvalue_inyeccion(trim($parte) , true)." and 
                              substring(a.cuenta,1,3)  = ".$this->bd->sqlvalue_inyeccion(trim($grupo) , true)." and
                        	  a.cuenta = b.cuenta and 
                              b.anio= ".$this->bd->sqlvalue_inyeccion($anio , true)."
                        group by a.cuenta, a.partida,b.detalle
                        having sum(a.debe) - sum(a.haber) <> 0 
                        order by a.cuenta";
 
	 
	    echo '<div  style="font-size: 11px;padding:10px">';
	   
	    $estilo = ' ';
	    
	    echo  '<table width="80%">
				  <tr>
			        <td width="10%" '.$estilo.' align="center"></td>
					<td width="40%" '.$estilo.' align="center"></td>
                    <td width="20%" '.$estilo.' align="center"></td>
                    <td width="10%" '.$estilo.' align="center"></td>
				  </tr>';
	    
	    $stmt_detalle = $this->bd->ejecutar($sql);
	    
	    while ($row1=$this->bd->obtener_fila($stmt_detalle)){
	        
	        $saldo = $row1["monto"];
	        echo  '<tr>
					   <td align="left">'.$row1["cuenta"].'</td>
					   <td align="left">'.$row1["detalle"].'</td>
	                   <td align="center">'.$row1["partida"].'</td>
	                   <td align="right">'.number_format($saldo, 2, ',', '.').'</td>';
	        echo  "</tr>";
	     
	    }
	    
	  
	    echo  "</table>";
	    echo '  </div>';
	    
	}
	//--------------------

	function  Impresion_sesion(){
	    
	    $sql = $_SESSION['sql_activo']   ;
	    
	    $formulario  = '';
	    $action      = '';
	    
	    $resultado  = $this->bd->ejecutar($sql);
	    $tipo 		= $this->bd->retorna_tipo();
 
	    
	    $this->obj->grid->KP_GRID_CTA_query($resultado,$tipo,'Id',$formulario,'S','',$action,'','');
 
	}
	//-----------------------------
	
	function  Tramite_req($asiento){
		
	    $sqlB = "SELECT *
                FROM rentas.view_ren_tramite 
                where id_ren_tramite =".$this->bd->sqlvalue_inyeccion($asiento,true)."   limit 1";
		
		$resultadoB = $this->bd->ejecutar($sqlB);
		
		$datos         =$this->bd->obtener_array( $resultadoB); 
		
		
		$sqlC = "SELECT *
                FROM rentas.view_ren_tramite_rubro
                where id_ren_tramite =".$this->bd->sqlvalue_inyeccion($asiento,true)."   limit 1";
		
		$resultadoC = $this->bd->ejecutar($sqlC);
		
		$datos1         =$this->bd->obtener_array( $resultadoC); 
		
		
		$datos["servicio"] = $datos1["servicio"];
 
		
		return $datos;
	}

	
	///-------------

	
	function  Tramite_seg($asiento){


		$query = "SELECT id_tramite_seg, fecha_seg, hora, responsable_seg, novedad_seg, accion_seg FROM rentas.ren_tramite_seg where  id_ren_tramite =".$asiento." order by id_tramite_seg desc limit 1";

		
		$resultadoB    = $this->bd->ejecutar($query);

		$datos         = $this->bd->obtener_array( $resultadoB); 

		

		
		return $datos;
	}
	
	
	function CabAsientoOrden($asiento){
	    
	    //--- beneficiario
	    $sqlB = "SELECT a.id_asiento,
                    a.fecha,
                    a.registro,
                    a.detalle,
                    a.sesion,
                    a.comprobante,
                    a.estado,
                    a.documento,
                    a.modulo,
                    a.idprov,a.anio,
                    ( SELECT x.razon
                           FROM par_ciu x
                          WHERE x.idprov = a.idprov) AS proveedor,
                    a.tipo,a.id_tramite, a.apagar
                   FROM co_asiento a
                  WHERE a.id_asiento  =".$this->bd->sqlvalue_inyeccion($asiento,true)."   limit 1";
	    
	    
	    $resultadoB = $this->bd->ejecutar($sqlB);
	    
	    $datos         =$this->bd->obtener_array( $resultadoB);
	    
 
 ///-------------------------------------------
	    $a10 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(10,true));
	    $a11 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(11,true));
	    $a12 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(12,true));
	    $a13 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(13,true));
	    $a14 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(14,true));
	    $a15 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(15,true));
 	    
	    $datos["p10"] = $a10["carpeta"];
	    $datos["p11"] = $a10["carpetasub"];
	    $datos["g10"] = $a11["carpeta"];
	    $datos["g11"] = $a11["carpetasub"];
	    $datos["f10"] = $a12["carpeta"];
	    $datos["f11"] = $a12["carpetasub"];
	    $datos["t10"] = $a13["carpeta"];
	    $datos["t11"] = $a13["carpetasub"];
	    
	    $datos["c10"] = $a14["carpeta"];
	    $datos["c11"] = $a14["carpetasub"];
	    $datos["e10"] = $a15["carpeta"];
	    $datos["e11"] = $a15["carpetasub"];
	    
	    $idprov = trim($datos["idprov"]);
	    
	    
	    $a16 = $this->bd->query_array('par_ciu','id_banco, tipo_cta,cta_banco', 'idprov='.$this->bd->sqlvalue_inyeccion($idprov,true));
	    
	    $id_banco = trim($a16["id_banco"]);
	    
	    $a17 = $this->bd->query_array('par_catalogo','nombre', 'idcatalogo='.$this->bd->sqlvalue_inyeccion($id_banco,true));
	    
	    if ($a16["tipo_cta"] == '0'){
	        $datos["tipo_cuenta"] = 'Ahorros';
	    }else{
	        $datos["tipo_cuenta"] = 'Corriente';
	    }
	    
	    $datos["cuenta"] = $a16["cta_banco"];
	    $datos["banco"]  = $a17["nombre"];
 
	    
	    if ( empty( $datos["apagar"])){
	        
	        $a20 =  $this->bd->query_array('co_asiento_aux','haber', 
	               'id_asiento='.$this->bd->sqlvalue_inyeccion($asiento,true). ' and 
                    idprov='.$this->bd->sqlvalue_inyeccion($idprov,true)." and cuenta like '111.%'"
	            );
	        
	        $datos["apagar"] = $a20["haber"];
	        
	        $sql = "update co_asiento_aux set 
                           detalle=".$this->bd->sqlvalue_inyeccion(trim($datos["detalle"]),true).", 
                           comprobante=".$this->bd->sqlvalue_inyeccion(trim($datos["comprobante"]),true).'
                    where id_asiento='.$this->bd->sqlvalue_inyeccion($asiento,true);
	        
	        $this->bd->ejecutar($sql);
	    }
 
	    return $datos;
	}
	//--- resumen IR
	
	function GrillaResumenCuentasCaja($fanio,$fmes,$cuenta){
	    
	    
	    $sql ="SELECT  idprov  as identificacion,
                      razon as nombre,
                      sum(montoi) as ingreso,
                      sum(monto) as egreso,
                      count(*) as registros
            FROM view_auxbancos
            where registro=".$this->bd->sqlvalue_inyeccion(trim($this->ruc), true)." and
                  transaccion=".$this->bd->sqlvalue_inyeccion('X', true)." and
                  anio=".$this->bd->sqlvalue_inyeccion($fanio, true)." and
                  mes=".$this->bd->sqlvalue_inyeccion($fmes, true)." and
                  estado=".$this->bd->sqlvalue_inyeccion('aprobado', true).' and
                  cuenta='.$this->bd->sqlvalue_inyeccion($cuenta, true).' 
            group by idprov,razon
            order by 3 desc';
	    
	    
	    $estilo = 'class="solid" style="font-size: 9px" ';
	    
	    echo  '<table>
				  <tr>
			        <td width="20%" '.$estilo.' align="center">Identificacion</td>
					<td width="40%" '.$estilo.' align="center">Nombre</td>
                    <td width="10%" '.$estilo.' align="center">Nro.Transacciones</td>
					<td width="10%" '.$estilo.' align="center">Ingresos</td>
					<td width="10%" '.$estilo.' align="center">Egresos</td>
                    <td width="10%" '.$estilo.' align="center">Saldo</td>
				  </tr>';
	    
	    $stmt_detalle = $this->bd->ejecutar($sql);
	    
	    $valor1 = 0;
	    $valor2 = 0;
	    
	    $saldo = 0;
	    
	    while ($row=$this->bd->obtener_fila($stmt_detalle)){
	      
	        $saldo = $saldo + ($row["ingreso"] -$row["egreso"] ) ;
	        
	        echo  '<tr>
					   <td width="20%" '.$estilo.'  align="left">'.$row["identificacion"].'</td>
						<td width="40%" '.$estilo.'  align="left">'.$row["nombre"].'</td>
	                   <td width="10%" '.$estilo.'  align="center">'.$row["registros"].'</td>
 				    	<td width="10%" '.$estilo.'  align="right">'.number_format($row["ingreso"], 2, ',', '.').'</td>
						<td width="10%" '.$estilo.'  align="right">'.number_format($row["egreso"], 2, ',', '.').'</td> 
	                    <td width="10%" '.$estilo.'  align="right">'.number_format($saldo, 2, ',', '.').'</td>';
	        echo  "</tr>";
	        
	        $valor1 = $valor1 + $row["ingreso"];
	        $valor2 = $valor2 + $row["egreso"];
	    }
	    
	    echo '<tr>
				<td width="20%"></td>
				<td width="50%"></td>
                <td width="10%"></td>
				<td width="10%" '.$estilo.'  align="right"><b>'.number_format($valor1, 2, ',', '.').'</b></td>
				<td width="10%" '.$estilo.'  align="right"><b>'.number_format($valor2, 2, ',', '.').'</b></td>
	            <td width="10%"></td>';
	    echo "</tr>";
	    echo  "</table>";
	    
            	    
	}
//--------------------
	
	function GrillaResumenMensualCaja($fanio,$fmes,$cuenta){
	    
	    
	    $sql ="SELECT  id_asiento as asiento,
              fecha,
               idprov  as identificacion,
              razon as nombre,
              detalle,
              comprobantec as comprobante,
              documento ,
              montoi as ingreso,
              monto as egreso,
              cuenta,anio, mes
            FROM view_auxbancos
            where registro=".$this->bd->sqlvalue_inyeccion(trim($this->ruc), true)." and
                  transaccion=".$this->bd->sqlvalue_inyeccion('X', true)." and
                  anio=".$this->bd->sqlvalue_inyeccion($fanio, true)." and
                  mes=".$this->bd->sqlvalue_inyeccion($fmes, true)." and
                  estado=".$this->bd->sqlvalue_inyeccion('aprobado', true).' and
                  cuenta='.$this->bd->sqlvalue_inyeccion($cuenta, true).'
               order by fecha asc , montoi desc';
	  
	      
	    $estilo = 'class="solid" style="font-size: 9px" ';
	    
	    echo  '<table>
				  <tr>
                    <td width="5%" '.$estilo.' align="center">Asiento</td>
                    <td width="10%" '.$estilo.' align="center">Fecha</td>
			        <td width="10%" '.$estilo.' align="center">Identificacion</td>
					<td width="30%" '.$estilo.' align="center">Nombre</td>
                    <td width="20%" '.$estilo.' align="center">Detalle</td>
					<td width="10%" '.$estilo.' align="center">Ingresos</td>
					<td width="10%" '.$estilo.' align="center">Egresos</td>
                    <td width="5%" '.$estilo.' align="center">Saldo</td>
				  </tr>';
	    
	    $stmt_detalle = $this->bd->ejecutar($sql);
	    
	    $valor1 = 0;
	    $valor2 = 0;
	    
	    $saldo = 0;
	    
	    while ($row=$this->bd->obtener_fila($stmt_detalle)){
	        
	        $saldo = $saldo + ($row["ingreso"] -$row["egreso"] ) ;
	        
	        echo  '<tr>
					   <td width="5%" '.$estilo.'  align="left">'.$row["asiento"].'</td>
						<td width="10%" '.$estilo.'  align="left">'.$row["fecha"].'</td>
	                   <td width="10%" '.$estilo.'  align="left">'.$row["identificacion"].'</td>
                       <td width="30%" '.$estilo.'  align="left">'.$row["nombre"].'</td>
	                   <td width="20%" '.$estilo.'  align="left">'.$row["detalle"].'</td>
 				    	<td width="10%" '.$estilo.'  align="right">'.number_format($row["ingreso"], 2, ',', '.').'</td>
						<td width="10%" '.$estilo.'  align="right">'.number_format($row["egreso"], 2, ',', '.').'</td>
	                    <td width="5%" '.$estilo.'  align="right">'.number_format($saldo, 2, ',', '.').'</td>';
	        echo  "</tr>";
	        
	        $valor1 = $valor1 + $row["ingreso"];
	        $valor2 = $valor2 + $row["egreso"];
	    }
	    
	    echo '<tr>
				<td width="5%"></td>
                <td width="10%"></td>
				<td width="10%"></td>
                <td width="30%"></td>
                <td width="20%"></td>
				<td width="10%" '.$estilo.'  align="right"><b>'.number_format($valor1, 2, ',', '.').'</b></td>
				<td width="10%" '.$estilo.'  align="right"><b>'.number_format($valor2, 2, ',', '.').'</b></td>
	            <td width="5%"></td>';
	    echo "</tr>";
	    echo  "</table>";
	    
	    
	}
	//----------- 
	 
	//--- resumen IR
	function GrillaAsiento($id_asiento){
		
		$sql_detalle = 'SELECT a.cuenta , b.detalle ,a.debe , a.haber , a.aux
 				   FROM co_asientod a, co_plan_ctas b
				  where a.cuenta = b.cuenta and 
                        a.registro = b.registro and
                        b.anio='.$this->bd->sqlvalue_inyeccion($this->anio , true).' and 
				  		a.id_asiento='.$this->bd->sqlvalue_inyeccion($id_asiento, true).' order by 5 asc, 2 desc';
		
		$estilo = 'class="solid" style="font-size: 9px" ';
		
		echo  '<table>
				  <tr>
			        <td width="10%" '.$estilo.' align="center">Cuenta</td>
					<td width="70%" '.$estilo.' align="center">Detalle</td>
					<td width="10%" '.$estilo.' align="center">Debe</td>
					<td width="10%" '.$estilo.' align="center">Haber</td>
				  </tr>';
		
		$stmt_detalle = $this->bd->ejecutar($sql_detalle);
		
		$valor1 = 0;
		$valor2 = 0;
		
		while ($row=$this->bd->obtener_fila($stmt_detalle)){
 			echo  '<tr>
					   <td width="10%" '.$estilo.'  align="left">'.$row["cuenta"].'</td>
						<td width="70%" '.$estilo.'  align="left">'.$row["detalle"].'</td>
 				    	<td width="10%" '.$estilo.'  align="right">'.number_format($row["debe"], 2, ',', '.').'</td>
						<td width="10%" '.$estilo.'  align="right">'.number_format($row["haber"], 2, ',', '.').'</td>';
			echo  "</tr>";
			
			$valor1 = $valor1 + $row["debe"];
			$valor2 = $valor2 + $row["haber"];
 		}
		
 		echo '<tr>
				<td width="10%"></td>
				<td width="70%"></td>
				<td width="10%" '.$estilo.'  align="right"><b>'.number_format($valor1, 2, ',', '.').'</b></td>
				<td width="10%" '.$estilo.'  align="right"><b>'.number_format($valor2, 2, ',', '.').'</b></td>';
 		echo "</tr>";
 		echo  "</table>";
		
 	 
 
	}
	
	//--- resumen IR
 
	//---
	function Empresa( ){
		
		$sql = "SELECT razon
				FROM web_registro
				where ruc_registro =".$this->bd->sqlvalue_inyeccion(	$this->ruc, true);

		$resultado = $this->bd->ejecutar($sql);

		$datos = $this->bd->obtener_array( $resultado);

		return $datos['razon'];
	}
	 
	
	//------------------------------------------

	
	function EmpresaCab( ){
		
		$sql = "SELECT ruc_registro, razon, contacto, correo, web, direccion, telefono, email, ciudad, estado, url, mision, vision
				FROM view_registro
				where ruc_registro =".$this->bd->sqlvalue_inyeccion(	$this->ruc, true);

		$resultado = $this->bd->ejecutar($sql);

		$this->Registro = $this->bd->obtener_array( $resultado);

		return $this->Registro['razon'];
	}
	
	//-----------------
	function _Cab( $dato ){
	      
	    return $this->Registro[$dato];
	}


    //------------
	function QR_DocumentoDoc($codigo ){
	    
	    
	    $name       = $_SESSION['razon'] ;
	    $sesion     = trim($_SESSION['email']);
	    
	    $datos = $this->bd->query_array('par_usuario',
	        'completo',
	        'email='.$this->bd->sqlvalue_inyeccion($sesion,true)
	        );
	    
	    $nombre     =  $datos['completo'];
	    $year       = date('Y');
	    $codigo     = str_pad($codigo,5,"0",STR_PAD_LEFT ).'-'.$year;
	    $elaborador = base64_encode($codigo);
	    
	    $hoy = date("Y-m-d H:i:s");
	    
	    // we building raw data
	    $codeContents .= 'GENERADO POR:'.$nombre."\n";
	    $codeContents .= 'FECHA: '.$hoy."\n";
	    $codeContents .= 'DOCUMENTO: '.$elaborador."\n";
	    $codeContents .= 'INSTITUCION :'.$name."\n";
	    $codeContents .= '2.4.0'."\n";
	    
	    //$tempDir = EXAMPLE_TMP_SERVERPATH;
	    
	    QRcode::png($codeContents,  'logo_qr.png', QR_ECLEVEL_L, 3);
	}
	
	//----------------------------------------------
	function QR_Firma( ){
	    
	    
	    $datos = $this->bd->query_array('par_usuario',
	        'completo',
	        'email='.$this->bd->sqlvalue_inyeccion(trim($_SESSION['email']),true)
	        );
	    
	    $sesion_elabora =  trim($datos['completo']);
	    
	    echo 'Documento Digital '.$_SESSION['login'].'- '. $sesion_elabora ;
	    
 
}

    function  Especie_datos($asiento){
		
	    
	$datos = $this->bd->query_array('rentas.ren_movimiento',   // TABLA
	'*',                        // CAMPOS
	'id_ren_movimiento='.$this->bd->sqlvalue_inyeccion($asiento,true))// CONDICION
	;

	$xx = $this->bd->query_array('par_ciu',   // TABLA
	'*',                        // CAMPOS
	'id_par_ciu='.$this->bd->sqlvalue_inyeccion($datos['id_par_ciu'],true)) // CONDICION
	;


    $datos["idprov"] = $xx["idprov"];
    $datos["razon"] = $xx["razon"];
    $datos["direccion"] = $xx["direccion"];
    
    
    
    return $datos;

}

    function QR_DocumentoDocPermiso($codigo,$actividad,$solicita,$anio ){
	    
	    
	$name       = trim($_SESSION['razon']) ;
	$sesion     = trim($_SESSION['email']);
	
	$datos = $this->bd->query_array('par_usuario',
		'completo',
		'email='.$this->bd->sqlvalue_inyeccion($sesion,true)
		);
	
	$nombre     =  trim($datos['completo']);
	//$year       =  date('Y');
	
	
	$hoy = date("Y-m-d H:i:s");
	
	// we building raw data
	$codeContents .= 'GENERADO POR:'.$nombre."\n";
	$codeContents .= 'FECHA: '.$hoy."\n";
	$codeContents .= 'DOCUMENTO: '.$codigo."\n";
	$codeContents .= 'INSTITUCION :'.$name."\n";
	$codeContents .= 'SOLICITA :'.$solicita."\n";
	$codeContents .= 'PERIODO :'.$anio."\n";
	$codeContents .= '2.4.1'."\n";
	
	$tempDir = EXAMPLE_TMP_SERVERPATH;
	
	QRcode::png($codeContents,  'logo_qr.png', QR_ECLEVEL_L, 3);
}


}

?>
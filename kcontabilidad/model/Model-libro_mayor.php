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
	private $anio;
	private $login;
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function proceso( ){
 		
		$this->obj     = 	new objects;

		$this->bd	   =	new Db ;
		
		$this->ruc       =  $_SESSION['ruc_registro'];
		
		$this->sesion 	 =  trim($_SESSION['email']);
		
		$this->hoy 	     =  date("Y-m-d");
		
		$this->login     =  trim($_SESSION['login']);
		
		$this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
		
		$this->anio       =  $_SESSION['anio'];
	}
   
	//--- calcula libro diario
	function grilla( $id_asiento,$f1,$f2,$cuentat,$cuenta,$auxiliares){
		
 
		$where = $this->sqlwhere_d($f1,$f2,$cuenta,$id_asiento,$cuentat);
		
 		
		$sql = 'SELECT  	a.cuenta, b.detalle,
        						sum(a.debe) as debe , 
                                sum(a.haber) as haber,
                                sum(a.debe) - sum(a.haber) as saldo 
                                FROM co_diario a, co_plan_ctas b where '.$where.'
                                 GROUP BY a.cuenta,b.detalle
                                 ORDER BY a.cuenta asc';
  		
		echo '<div class="col-md-12" align="center" style="padding-bottom:10;padding-top:15px"> ';
		
		$this->titulo($f1,$f2);
		
 		echo '</div> ';
		
         echo '<div class="col-md-12" style="padding-bottom:20;padding-top:20px"> <ul class="list-group">';

		// print_r($sql);

         $stmt = $this->bd->ejecutar($sql);

         while ($x=$this->bd->obtener_fila($stmt)){

                $cuenta  = trim($x['cuenta']); 
                $detalle = trim($x['detalle']); 

              
                $saldo = $x['saldo'];

                echo '  <li class="list-group-item"><b>'.$cuenta.' '. $detalle.'</b></li>';
         	
                $this->detalle_auxiliar( $f1,$f2,$cuenta);

            }
      
      
       


        echo ' </ul></div> ';

       
	
		$this->firmas( );
	}
 //---------------

  
 function sqlwhere_d($f1,$f2,$cuenta,$id_asiento,$cuentat){
		
    //inicializamos la clase para conectarnos a la bd
     
    $cadena0 =  '( a.registro = '.$this->bd->sqlvalue_inyeccion(trim($this->ruc),true).') and ';
    
   

    $cadena6 =  '( a.cuenta = b.cuenta) and ( b.anio= '.$this->bd->sqlvalue_inyeccion( $this->anio ,true).') and ';
    
    if ( strlen ($cuenta) > 1){
        $cadena1 = '( a.cuenta ='.$this->bd->sqlvalue_inyeccion(trim($cuenta),true).") and ";
    }
    
    if ( strlen ($f1) > 1){
        $cadena2 = '( a.fecha BETWEEN '.$this->bd->sqlvalue_inyeccion(trim($f1),true)." and ".$this->bd->sqlvalue_inyeccion(trim($f2),true)." ) and ";
    }
    
    if ( strlen ($id_asiento) > 1){
        $cadena4 = '( a.id_asiento ='.$this->bd->sqlvalue_inyeccion(trim($id_asiento),true).") and ";
    }
    
    if ( strlen ($cuentat) > 1){
        $cadena5 = '( a.cuenta like '.$this->bd->sqlvalue_inyeccion(trim($cuentat),true).") and ";
    }
    
    
    
    $where    = $cadena0.$cadena1.$cadena2.$cadena4.$cadena5.$cadena6 ;
    
    $longitud = strlen($where);

    $where    = substr( $where,0,$longitud - 5);
    
    
    return   $where;
    
    
    
}

  
	
	function cabecera(){
	    
	    echo '<table id ="tabla1" class="table table-striped table-bordered table-hover table-checkable" width="100%" style="font-size: 12px;table-layout: auto">
                <tr>';
            	    echo '<th width="10%" >Asiento</th>';
                    echo '<th width="10%" >Fecha</th>';
                    echo '<th width="10%" >Comprobante</th>';
                    echo '<th width="40%" >Detalle</th>';
            	    echo '<th width="10%" >Debe</th>';
            	    echo '<th width="10%" >Haber</th>';
                    echo '<th width="10%" >Saldo</th>';
      	echo '</tr>';
	    
	}
	//-----------------------
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
                        <b>LIBRO MAYOR POR UNIDAD EJECUTORA '.$f1.'  al '.$f2.'</b></td>
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
//-------------------
	function detalle_auxiliar( $f1,$f2,$cuenta){
	    

		$saldos_periodo = $this->bd->query_array('co_diario','sum(debe) - sum(haber) as saldo', 
										 'fecha < '.$this->bd->sqlvalue_inyeccion( $f1,true). ' and 
										 cuenta = '.$this->bd->sqlvalue_inyeccion(trim($cuenta), true).' and 
										  anio='.$this->bd->sqlvalue_inyeccion($this->anio, true) 
										);

	    $saldos = $saldos_periodo['saldo'];

	 

        $where = '( fecha BETWEEN '.$this->bd->sqlvalue_inyeccion(trim($f1),true)." and ".$this->bd->sqlvalue_inyeccion(trim($f2),true)." )   ";

        $sql = 'SELECT  *
        FROM co_diario  
        where cuenta  = '.$this->bd->sqlvalue_inyeccion(trim($cuenta), true).' and 
            anio = '.$this->bd->sqlvalue_inyeccion($this->anio, true).' and  '. $where.'
         ORDER BY fecha asc, comprobante asc';

         $stmt1 = $this->bd->ejecutar($sql);
		
       

         $this->cabecera();
      
		 $saldo = 0;
		 $ndebe  = 0;
         $nhaber = 0;
		 
		 $saldo_linea = 0;


		 //------- saldos iniciales

		 if ( $saldos < 0 ) {
			$idebe= 0;
			$ihaber=    $saldos*-1;
		}
		 else {	
			$idebe=    $saldos;
			$ihaber=0;
		}
			echo "<tr>";
		    
		 echo "<td> </td>";
		 echo "<td>$f1</td>";
		 echo "<td>-</td>";
		 echo "<td>Saldo Anterior</td>";
		  echo "<td align='right'>".number_format($idebe,2)."</td>";
		 echo "<td align='right'>".number_format($ihaber,2)."</td>";
		 echo "<td align='right'>".number_format(  $saldos,2)."</td>";
		  
		 echo "</tr>";


		 $saldo_linea =   $saldos;
		 //---------------------------
         while ($xx=$this->bd->obtener_fila($stmt1)){
		    
		    $saldo = $xx['debe'] - $xx['haber'];

			$saldo_linea  = $saldo_linea + $saldo;
		    
			$x_aux = $this->bd->query_array('view_asientos',   // TABLA
			'idprov, proveedor',                        // CAMPOS
			'id_asiento='.$this->bd->sqlvalue_inyeccion($xx['id_asiento'],true) // CONDICION
		    );

			$proveedor = trim($x_aux['proveedor']);

			if ( empty($proveedor) ){
				$proveedor= '';
			}	

		    echo "<tr>";
		    
		    echo "<td>".$xx['id_asiento']."</td>";
		    echo "<td>".$xx['fecha']."</td>";
		    echo "<td>".$xx['comprobante']."</td>";
		    echo "<td>".$proveedor.' '.$xx['detalle']."</td>";
 		    echo "<td align='right'>".number_format($xx['debe'],2)."</td>";
		    echo "<td align='right'>".number_format($xx['haber'],2)."</td>";
		    echo "<td align='right'>".number_format( 	$saldo_linea,2)."</td>";
 		    
		    echo "</tr>";
		    
		    $ndebe  = $ndebe + $xx['debe'];
		    $nhaber = $nhaber+ $xx['haber'] ;
		    
		}
 
        $saldo = $ndebe -  $nhaber;
	 
		echo "<tr>";
		
		echo "<td align='right'></td>";
		echo "<td align='right'></td>";
		echo "<td align='right'></td>";
		echo "<td align='right'></td>";
        echo "<td align='right'><b>".number_format($ndebe,2)."</b></td>";
		echo "<td align='right'><b>".number_format($nhaber,2)."</b></td>";
		echo "<td align='right'><b> </b></td>";
		
		
		echo "</tr>";
		 
 		echo "</table>";
 		
		unset($xx); //eliminamos la fila para evitar sobrecargar la memoria
		
		pg_free_result ($stmt1) ;
 
		 
		
		 
	
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
if (isset($_POST["ffecha1"]))	{
	
	$f1 			    =      $_POST["ffecha1"];
	$f2 				=      $_POST["ffecha2"];
	$id_asiento          =     $_POST["id_asiento"];
	
	$cuentat   =     $_POST["cuentat"];
	$cuenta    =     $_POST["cuenta"];
	$auxiliares=     $_POST["auxiliares"];
 
 
	
	$gestion->grilla( $id_asiento,$f1,$f2,$cuentat,$cuenta,$auxiliares);
 
	
}
?>
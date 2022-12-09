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
		
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
		
		$this->anio       =  $_SESSION['anio'];
	}
   
	//--- calcula libro diario
	function grilla( $id_asiento,$f1,$f2,$cuentat,$cuenta,$auxiliares, $grupo){
		
 
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

         $stmt = $this->bd->ejecutar($sql);

         while ($x=$this->bd->obtener_fila($stmt)){

                $cuenta  = trim($x['cuenta']); 
                $detalle = trim($x['detalle']); 

              
                $saldo = $x['saldo'];

                echo '  <li class="list-group-item"><b>'.$cuenta.' '. $detalle.'</b></li>';
         	
                $this->detalle_auxiliar( $f1,$f2,$cuenta, $grupo);

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

  
	
	function cabecera( $grupo){
	    
        if (  $grupo== 'I'){
            $campo = 'Ingreso (D)';
        }else   {
            $campo = 'Egreso (H)';
        }

	    echo '<table id ="tabla1" class="table table-striped table-bordered table-hover table-checkable" width="100%" style="font-size: 12px;table-layout: auto">
                <tr>';
            	    echo '<th width="10%" >Asiento</th>';
                    echo '<th width="10%" >Fecha</th>';
                    echo '<th width="10%" >Comprobante</th>';
                    echo '<th width="60%" >Detalle</th>';
            	    echo '<th width="10%" >'.  $campo.'</th>';
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
        	<td style="text-align: center">'.$datos["f10"] .'</td>
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
//-------------------
	function detalle_auxiliar( $f1,$f2,$cuenta, $grupo){
	    

        $where = '( fecha BETWEEN '.$this->bd->sqlvalue_inyeccion(trim($f1),true)." and ".$this->bd->sqlvalue_inyeccion(trim($f2),true)." )   ";

        $sql = 'SELECT  *
        FROM co_diario  
        where cuenta  = '.$this->bd->sqlvalue_inyeccion(trim($cuenta), true).' and 
            anio = '.$this->bd->sqlvalue_inyeccion($this->anio, true).' and  '. $where.'
         ORDER BY fecha asc, comprobante asc';

         $stmt1 = $this->bd->ejecutar($sql);
		
       

         $this->cabecera( $grupo);
      
		 $saldo = 0;
		 $ndebe  = 0;
         $nhaber = 0;


         if (  $grupo== 'I'){
            $campo = 'debe';
        }else   {
            $campo = 'haber';
        }

		 
         while ($xx=$this->bd->obtener_fila($stmt1)){
		    
 
      
		    
			$x_aux = $this->bd->query_array('view_asientos',   // TABLA
			'idprov, proveedor',                        // CAMPOS
			'id_asiento='.$this->bd->sqlvalue_inyeccion($xx['id_asiento'],true) // CONDICION
		    );

			$proveedor = trim($x_aux['proveedor']);

			if ( empty($proveedor) ){
				$proveedor= '';
			}	

			if ( $xx[ $campo ] <> 0 ) {

		    echo "<tr>";
		    
		    echo "<td>".$xx['id_asiento']."</td>";
		    echo "<td>".$xx['fecha']."</td>";
		    echo "<td>".$xx['comprobante']."</td>";
		    echo "<td>".$proveedor.' '.$xx['detalle']."</td>";
 		    echo "<td align='right'>".number_format($xx[ $campo ],2)."</td>";
  		    
		    echo "</tr>";
		    
		    $ndebe  = $ndebe + $xx[ $campo ];

		}	

 		    
		}
 
 		
		echo "<tr>";
		
		echo "<td align='right'></td>";
		echo "<td align='right'></td>";
		echo "<td align='right'></td>";
		echo "<td align='right'></td>";
        echo "<td align='right'><b>".number_format($ndebe,2)."</b></td>";
 		
		
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

    $grupo=     $_POST["grupo"];
 
 
	
	$gestion->grilla( $id_asiento,$f1,$f2,$cuentat,$cuenta,$auxiliares, $grupo);
 
	
}



?>
 
  
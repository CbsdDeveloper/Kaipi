<!DOCTYPE html>
<html lang="en">
<head>
	
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
 
 	<script type="text/javascript" src="../js/ren_deposito.js"></script> 
	
	
  	  
	
	
</head>
	
<body>
 
 
	 
 	 
	
       <!-- Content Here -->
     <div class="col-md-12"> 
      
       	 
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
	function grilla( $id_asiento,$f11,$f2,$cuentat,$cuenta,$auxiliares){
		
		
		$fecha_array = explode('-',$f11);
		
		$f1 = $fecha_array[0].'-'.$fecha_array[1].'-01';
		
 
	
		
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
         	
                $this->detalle_auxiliar( $f1,$f2,$cuenta);

            }
      
      
       


        echo ' </ul></div> ';

       
	
	 
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
	    
 
	    
	    $imagen = '<img src="../../kimages/'.trim($_SESSION['logo']).'" width="170" height="80">';
	    
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
 
	
 
//-------------------
	function detalle_auxiliar( $f1,$f2,$cuenta){
	    

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
		echo "<td align='right'><b>".number_format($saldo,2)."</b></td>";
		
		
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
if (isset($_GET["fecha"]))	{
	
	$f1 			    =      $_GET["fecha"];
	$f2 				=      $_GET["fecha"];
	$id_asiento         =      0;
	
	$cuentat   =    '111.01%';
	$cuenta    =    '';
	$auxiliares=    'N';
 
 
	
	$gestion->grilla( $id_asiento,$f1,$f2,$cuentat,$cuenta,$auxiliares);
 
	
}
?>
 </div>
		   
 	 
 
     


 </body>
</html>

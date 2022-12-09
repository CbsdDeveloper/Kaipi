<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

require '../../kpresupuesto/model/Model_saldos.php'; /*Incluimos el fichero de la clase objetos*/

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
		
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
		
		$this->ruc       =  $_SESSION['ruc_registro'];
		
		$this->sesion 	 =  trim($_SESSION['email']);
		
		$this->hoy 	     =  date("Y-m-d");
		
		$this->login     =  trim($_SESSION['login']);
 		
		$this->anio       =  $_SESSION['anio'];
		
		$this->saldos     = 	new saldo_presupuesto(  $this->obj,  $this->bd);
		
	}
   
	//--- calcula libro diario
	function grilla( $f1,$f2 ){
		
 
	    $aperiodo = explode('-',$f2);
	    
 
	    $anio = $aperiodo[0];
	    
		
		echo '<div class="col-md-12" align="center" style="padding-bottom:10;padding-top:15px"> ';
		
		$this->titulo($f1,$f2);
		
		echo '</div> ';
		
		echo '</div><div class="col-md-6" style="padding: 30px">  ';
		
		 
		
		$this->saldos->PresupuestoPeriodo($f2);
		
        		$this->cabecera('INGRESO');
        		
        		$this->Bloque_Activo( 'I',$anio);
		
		echo '</div> <div class="col-md-6" style="padding: 30px">';
		
		
        		$this->cabecera('GASTO');
        		
        		$this->Bloque_Activo( 'G',$anio);
 
		echo '</div> ';
		 
 
	}
  
	//----------------------------------------------------------
	function cabecera($titulo){
	    
		$estilo = 'style ="background-color: #3e95d1;color:#f8f9fa;background-image: linear-gradient(to bottom, #3e95d1, #368ac5, #2d7fb8, #2474ac, #1a69a0);" ';


	    echo '<table  class="table table-striped table-bordered table-hover table-checkable" width="100%" style="font-size: 13px;table-layout: auto">';
	    echo ' <tr>
                  <td colspan="5"><b>'.$titulo.'</b></td>
                 </tr>
                <tr>
                    <td width="20%" '. $estilo .'>GRUPO</td>
                    <td width="20%" '. $estilo .'>Inicial</td>
                    <td width="20%" '. $estilo .'>Codificado</td>
                    <td width="20%" '. $estilo .'>Devengado</td>
                    <td width="20%" '. $estilo .'>Recaudado/Pagado</td>
                 </tr>';
 
 
	    
	}
	//--------------------
	public function Bloque_Activo( $tipo,$anio){
	    
	 
	    $sql = 'SELECT grupo ,
    	    sum(inicial) as inicial,
    	    sum(codificado) as codificado,
    	    sum(devengado) as devengado,
    	    sum(pagado) as pagado
    	    FROM presupuesto.pre_gestion_periodo
    	    where tipo = '.$this->bd->sqlvalue_inyeccion( $tipo ,true).'  and anio = '.$this->bd->sqlvalue_inyeccion($this->anio ,true).'
    	    group by grupo
    	    order by grupO';
 	    
	    
	    $stmt = $this->bd->ejecutar($sql);
	    
	    $inicial_debe1 = 0;
	    $inicial_debe2 = 0;
	    $inicial_debe3 = 0;
	    $inicial_debe4 = 0;
	    
	    while ($x=$this->bd->obtener_fila($stmt)){
	        
	        $cuenta = trim($x['grupo']);
	        $saldo1 = $x['inicial'] ;
	        $saldo2 = $x['codificado'] ;
	        $saldo3 = $x['devengado'] ;
	        $saldo4 = $x['pagado'] ;
  	        
	        echo "<tr>";
	        echo "<td><b>".'SG '.$cuenta."</b></td>";
	        echo "<td align='right'>".number_format($saldo1,2)."</td>";
	        echo "<td align='right'>".number_format($saldo2,2)."</td>";
	        echo "<td align='right'>".number_format($saldo3,2)."</td>";
	        echo "<td align='right'>".number_format($saldo4,2)."</td></tr>";
	        
	        $inicial_debe1 = $inicial_debe1 + $saldo1;
	        $inicial_debe2 = $inicial_debe2 + $saldo2;
	        $inicial_debe3 = $inicial_debe3 + $saldo3;
	        $inicial_debe4 = $inicial_debe4 + $saldo4;
	    }
	        
	    echo "<tr>";
	    echo "<td> </td>";
	    echo "<td align='right'>".number_format($inicial_debe1,2)."</td>";
	    echo "<td align='right'>".number_format($inicial_debe2,2)."</td>";
	    echo "<td align='right'>".number_format($inicial_debe3,2)."</td>";
	    echo "<td align='right'>".number_format($inicial_debe4,2)."</td></tr>";
	    
	  echo '</table>';
	    
 	}
  
	//--- ultimo nivel
 
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
                        <b>PRESUPUESTO ( PERIODO '.$this->anio.' ) </b><br>
                        <b>RESUMEN GRUPO al '.$f2.'</b></td>
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
if (isset($_POST["bgfecha1"]))	{
	
	$f1 			    =     $_POST["bgfecha1"];
	$f2 				=     $_POST["bgfecha2"];
 
	
 
	$gestion->grilla( $f1,$f2 );
 
 
	
}



?>
 
  
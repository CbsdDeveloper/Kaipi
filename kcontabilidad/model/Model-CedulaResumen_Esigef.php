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
	function grilla( $f1,$f2,$tipo ){
		
 
	    $aperiodo = explode('-',$f2);
	    
 
	    $anio = $aperiodo[0];
	    
		
		echo '<div class="col-md-12" align="center" style="padding-bottom:10;padding-top:15px"> ';
		
		$this->titulo($f1,$f2);
		
		echo '</div> ';
		
		echo '<div class="col-md-12" style="padding: 30px">  ';
		
 
		if ( $tipo == 'I' ){
		    
		    $this->cabecera('INGRESO');
		    $this->Bloque_Activo( 'I',$anio);
		    
		}else {
		    $this->cabecera('GASTO');
		    $this->Bloque_Gasto( 'G',$anio);
		}
        		
		
	 
 
		echo '</div> ';
		 
 
	}
  
	//----------------------------------------------------------
	function cabecera($titulo){

		$estilo = 'style ="background-color: #3e95d1;color:#f8f9fa;background-image: linear-gradient(to bottom, #3e95d1, #368ac5, #2d7fb8, #2474ac, #1a69a0);" ';
	    
	    if ( $titulo == 'INGRESO')  {
	        
	        echo '<table  class="table table-striped table-bordered table-hover table-checkable" width="100%" style="font-size: 13px;table-layout: auto">';
	        echo ' <tr>
                  <td colspan="10"><b>'.$titulo.'</b></td>
                 </tr>
                <tr>
                     <td width="15%" '.$estilo.'>Clasificador</td>
                     <td width="15%" '.$estilo.'>Grupo</td>
                     <td width="5%" '.$estilo.'>Subgrupo</td>
                     <td width="5%" '.$estilo.'>Item</td>
                    <td width="10%" '.$estilo.'>Inicial</td>
                    <td width="10%" '.$estilo.'>Reformas</td>
                    <td width="10%" '.$estilo.'>Codificado</td>
                    <td width="10%" '.$estilo.'>Devengado</td>
                    <td width="10%" '.$estilo.'>Recaudado</td>
                    <td width="10%" '.$estilo.'>Saldo x Dev</td>
                 </tr>';
	    }else {
	        
	        echo '<table  class="table table-striped table-bordered table-hover table-checkable" width="100%" style="font-size: 13px;table-layout: auto">';
	        echo ' <tr>
                  <td colspan="12"><b>'.$titulo.'</b></td>
                 </tr>
                <tr>
                     <td width="10%" '.$estilo.'>Clasificador</td>
                     <td width="5%" '.$estilo.'>Grupo</td>
                     <td width="5%" '.$estilo.'>Subgrupo</td>
                     <td width="5%" '.$estilo.'>Item</td>
                    <td width="5%" '.$estilo.'>Inicial</td>
                    <td width="10%" '.$estilo.'>Reformas</td>
                    <td width="10%" '.$estilo.'Codificado</td>
                    <td width="10%" '.$estilo.'>Compromiso</td>
                    <td width="10%" '.$estilo.'>Devengado</td>
                    <td width="10%" '.$estilo.'>Pagado</td>
                    <td width="10%" '.$estilo.'>Saldo x Comp</td>
                    <td width="10%" '.$estilo.'>Saldo x Dev</td>
                 </tr>';
	        
	        
	    }
 
	}
	//--------------------
	public function Bloque_Activo( $tipo,$anio){
	    
  
	 
	    $sql = 'SELECT grupo ,subgrupo, item,
    	    sum(inicial) as inicial,
    	    sum(codificado) as codificado,
            sum(compromiso) as compromiso,
    	    sum(devengado) as devengado,
            ( sum(aumento) - sum(disminuye) ) as reforma,
    	    sum(pagado) as pagado,
            sum(codificado) - sum(compromiso) saldo_compromiso,
            sum(codificado) - sum(devengado)  saldo_devengar
    	    FROM presupuesto.pre_gestion_periodo
    	    where tipo = '.$this->bd->sqlvalue_inyeccion( $tipo ,true).'  and anio = '.$this->bd->sqlvalue_inyeccion($this->anio ,true).'
    	    group by grupo ,subgrupo, item
    	    order by grupo ,subgrupo, item';
 	    
	    
	    $stmt = $this->bd->ejecutar($sql);
	    
	    $inicial_debe1 = 0;
	    $inicial_debe2 = 0;
	    $inicial_debe3 = 0;
	    //$inicial_debe4 = 0;
	    
	    $inicial_debe5 = 0;
	    $inicial_debe6 = 0;
	    $inicial_debe7 = 0;
 
	    while ($x=$this->bd->obtener_fila($stmt)){
	        
	        $cuenta = trim($x['grupo']);
	        $saldo1 = $x['inicial'] ;
	        $saldo2 = $x['reforma'] ;
	        $saldo3 = $x['codificado'] ;
	    //    $saldo4 = $x['compromiso'] ;
	        $saldo5 = $x['devengado'] ;
	        $saldo6 = $x['pagado'] ;
	        
	     //   $saldo7 = $x['saldo_compromiso'] ;
	        $saldo8 = $x['saldo_devengar'] ;
  	        
	        $clasificador = $cuenta.'.'.trim($x['subgrupo']).'.'.trim($x['item']);

			$item = "'".$cuenta.trim($x['subgrupo']).trim($x['item'])."'";
			$evento = "verifica_datos(".$item.','.'1'.')';
			$cadena = '<a href="#" data-toggle="modal" onclick='.$evento.' data-target="#myModalAsientos">'.$clasificador.'</a>';

	        echo "<tr>";
	        echo "<td><b>".'SG '.$cadena."</b></td>";
	        echo "<td><b>".$cuenta."</b></td>";
	        echo "<td><b>".trim($x['subgrupo'])."</b></td>";
	        echo "<td><b>".trim($x['item'])."</b></td>";
	        echo "<td align='right'>".number_format($saldo1,2)."</td>";
	        echo "<td align='right'>".number_format($saldo2,2)."</td>";
	        echo "<td align='right'>".number_format($saldo3,2)."</td>";
	        echo "<td align='right'>".number_format($saldo5,2)."</td>";
	        echo "<td align='right'>".number_format($saldo6,2)."</td>";
	        echo "<td align='right'>".number_format($saldo8,2)."</td></tr>";
	        
	        $inicial_debe1 = $inicial_debe1 + $saldo1;
	        $inicial_debe2 = $inicial_debe2 + $saldo2;
	        $inicial_debe3 = $inicial_debe3 + $saldo3;
	        $inicial_debe5 = $inicial_debe5 + $saldo5;
	        $inicial_debe6 = $inicial_debe6 + $saldo6;
	        $inicial_debe7 = $inicial_debe7 + $saldo5;
	    }
	        
	    echo "<tr>";
	    echo "<td> </td>";
	    echo "<td> </td>";
	    echo "<td> </td>";
	    echo "<td> </td>";
	    echo "<td align='right'>".number_format($inicial_debe1,2)."</td>";
	    echo "<td align='right'>".number_format($inicial_debe2,2)."</td>";
	    echo "<td align='right'>".number_format($inicial_debe3,2)."</td>";
	    echo "<td align='right'>".number_format($inicial_debe5,2)."</td>";
	    echo "<td align='right'>".number_format($inicial_debe6,2)."</td>";
	    echo "<td align='right'>".number_format($inicial_debe7,2)."</td></tr>";
	    
	  echo '</table>';
	    
 	}
 
 	public function Bloque_Gasto( $tipo,$anio){
 	    
 	    
 	    
 	    $sql = 'SELECT grupo ,subgrupo, item,
    	    sum(inicial) as inicial,
    	    sum(codificado) as codificado,
            sum(compromiso) as compromiso,
    	    sum(devengado) as devengado,
            ( sum(aumento) - sum(disminuye) ) as reforma,
    	    sum(pagado) as pagado,
            sum(codificado) - sum(compromiso) saldo_compromiso,
            sum(codificado) - sum(devengado)  saldo_devengar
    	    FROM presupuesto.pre_gestion_periodo
    	    where tipo = '.$this->bd->sqlvalue_inyeccion( $tipo ,true).'  and anio = '.$this->bd->sqlvalue_inyeccion($this->anio ,true).'
    	    group by grupo ,subgrupo, item
    	    order by grupo ,subgrupo, item';
 	    
 	    
 	    $stmt = $this->bd->ejecutar($sql);
 	    
 	    $inicial_debe1 = 0;
 	    $inicial_debe2 = 0;
 	    $inicial_debe3 = 0;
 	    $inicial_debe4 = 0;
 	    
 	    $inicial_debe5 = 0;
 	    $inicial_debe6 = 0;
 	    $inicial_debe7 = 0;
 	    $inicial_debe8=0;
 	    
 	    while ($x=$this->bd->obtener_fila($stmt)){
 	        
 	        $cuenta = trim($x['grupo']);
 	        $saldo1 = $x['inicial'] ;
 	        $saldo2 = $x['reforma'] ;
 	        $saldo3 = $x['codificado'] ;
 	        $saldo4 = $x['compromiso'] ;
 	        $saldo5 = $x['devengado'] ;
 	        $saldo6 = $x['pagado'] ;
 	        
 	        $clasificador = $cuenta.'.'.trim($x['subgrupo']).'.'.trim($x['item']);
 	        
 	        $saldo7 = $x['saldo_compromiso'] ;
 	        $saldo8 = $x['saldo_devengar'] ;
 	        
 	       // $novedad = $saldo4 - $saldo5;
 	        
 
 	  
 	        if ( $saldo5  >  $saldo4) {
 	            $clase = ' style="background-color: #F35052" '      ; 
 	         }else{
 	             $clase ='';
 	         }
 	        
 	         
 	         if ( $saldo6  >  $saldo5) {
 	             $clase1 = ' style="background-color: #F35052" '      ;
 	         }else{
 	             $clase1 ='';
 	         }
 	         
			  $item = "'".$cuenta.trim($x['subgrupo']).trim($x['item'])."'";
			  $evento = "verifica_datos(".$item.','.'2'.')';
			  $cadena = '<a href="#" data-toggle="modal" onclick='.$evento.' data-target="#myModalAsientos">'.$clasificador.'</a>';
  
 	         
 	        echo "<tr>";
 	        echo "<td><b>".'SG '.$cadena."</b></td>";
 	        echo "<td><b>".$cuenta."</b></td>";
 	        echo "<td><b>".trim($x['subgrupo'])."</b></td>";
 	        echo "<td><b>".trim($x['item'])."</b></td>";
 	        
 	        echo "<td align='right'>".number_format($saldo1,2)."</td>";
 	        echo "<td align='right'>".number_format($saldo2,2)."</td>";
 	        echo "<td align='right'>".number_format($saldo3,2)."</td>";
 	        echo "<td align='right' ".$clase." >".number_format($saldo4,2)."</td>";
 	        echo "<td align='right'>".number_format($saldo5,2)."</td>";
 	        echo "<td align='right' ".$clase1.">".number_format($saldo6,2)."</td>";
 	        echo "<td align='right'>".number_format($saldo7,2)."</td>";
 	        echo "<td align='right'>".number_format($saldo8,2)."</td></tr>";
 	        
 	        $inicial_debe1 = $inicial_debe1 + $saldo1;
 	        $inicial_debe2 = $inicial_debe2 + $saldo2;
 	        $inicial_debe3 = $inicial_debe3 + $saldo3;
 	        $inicial_debe4 = $inicial_debe4 + $saldo4;
 	        $inicial_debe5 = $inicial_debe5 + $saldo5;
 	        $inicial_debe6 = $inicial_debe6 + $saldo6;
 	        $inicial_debe7 = $inicial_debe7 + $saldo7;
 	        $inicial_debe8 = $inicial_debe8 + $saldo8;
 	    }
 	    
 	    echo "<tr>";
 	    echo "<td> </td>";
 	    echo "<td> </td>";
 	    echo "<td> </td>";
 	    echo "<td> </td>";
 	    echo "<td align='right'>".number_format($inicial_debe1,2)."</td>";
 	    echo "<td align='right'>".number_format($inicial_debe2,2)."</td>";
 	    echo "<td align='right'>".number_format($inicial_debe3,2)."</td>";
 	    echo "<td align='right'>".number_format($inicial_debe4,2)."</td>";
 	    echo "<td align='right'>".number_format($inicial_debe5,2)."</td>";
 	    echo "<td align='right'>".number_format($inicial_debe6,2)."</td>";
 	    echo "<td align='right'>".number_format($inicial_debe7,2)."</td>";
 	    echo "<td align='right'>".number_format($inicial_debe8,2)."</td></tr>";
 	    
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
if (isset($_POST["ffecha1"]))	{
	
	$f1 			    =     $_POST["bgfecha1"];
	$f2 				=     $_POST["bgfecha2"];
 
	$tipo 				=     $_POST["tipo"];
 
	$gestion->grilla( $f1,$f2,$tipo );
 
 
	
}



?>
 
  
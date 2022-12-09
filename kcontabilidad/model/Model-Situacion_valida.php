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
		
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
		
		$this->ruc       =  $_SESSION['ruc_registro'];
		
		$this->sesion 	 =  trim($_SESSION['email']);
		
		$this->hoy 	     =  date("Y-m-d");
		
		$this->login     =  trim($_SESSION['login']);
 		
		$this->anio       =  $_SESSION['anio'];
		
 		
	}
   
	//--- calcula libro diario
	function grilla( $f1,$f2,$ngrupo ,$nsubgrupo,$nitem,$tipo){
		
         	    $aperiodo = explode('-',$f2);
          
        	    $anio = $aperiodo[0];
  		 
        	    echo ' <table id="jsontable_valida" 
                              class="display table table-condensed table-hover datatable" width="100%"  style="font-size: 12px;">';
        	    echo '<thead><tr>
                    <td width="10%">Asiento</td>
                    <td width="10%">Fecha</td>
                    <td width="30%">Detalle</td>
                    <td width="10%">Cuenta</td>
                      <td width="10%">Tipo Enlace</td>
                     <td width="10%">Partida</td>
                     <td width="5%">Debito</td>
                     <td width="5%">Credito</td>
                     <td width="5%">Debe</td>
                     <td width="5%">Haber</td>
                 </tr></thead>';
 
        	    
        	    if ( $tipo == 0) {
                        	        
                        	    if ( $nsubgrupo == '-'){
                         	        $cadena = '';
                         	    }else{
                         	        $cadena = ' and cuenta = '.$this->bd->sqlvalue_inyeccion( $nsubgrupo ,true).'   ';
                         	    }
                         	    if ( $nitem == '-'){
                         	        $cadena1 = '';
                         	    }else{
                         	        $cadena1 = 'and item = '.$this->bd->sqlvalue_inyeccion( $nitem ,true).'   ';
                         	    }
        	    }else {
        	        $cadena = '';
        	        $cadena1 = 'and item = '.$this->bd->sqlvalue_inyeccion( $nitem ,true).'   ';
        	    }
        	    
        	       $sql = 'SELECT id_asiento,
                               fecha, detalle,cuenta,
                               debe, haber,  partida_enlace, partida,   credito, debito,id_asientod
                    	    FROM view_diario_conta
                    	    where anio = '.$this->bd->sqlvalue_inyeccion($anio ,true).' and 
                                  fecha between '.$this->bd->sqlvalue_inyeccion( $f1 ,true).' and '.$this->bd->sqlvalue_inyeccion( $f2 ,true).' and 
                                  subgrupo = '.$this->bd->sqlvalue_inyeccion( $ngrupo ,true).$cadena.$cadena1.'   
             	            order by fecha';
        	            
 
        		
        		
        		$stmt = $this->bd->ejecutar($sql);
        		
        		
        		$s1  = 0;
        		$s2  = 0;
        		
        		while ($x=$this->bd->obtener_fila($stmt)){
        		    
        		    
        		    $saldo1 = $x['debe'] ;
        		    $saldo2 = $x['haber'] ;
        		    
        		    
        		    echo "<tr>";
        		    echo "<td><b>".$x['id_asiento']."</b></td>";
        		    echo "<td>".$x['fecha']."</td>";
        		    echo "<td>".$x['detalle']."</td>";
        		    echo "<td>".$x['cuenta']."</td>";
         		    echo "<td>".$x['partida_enlace']."</td>";
        		    echo "<td>".$x['partida']."</td>";
        		    echo "<td>".$x['credito']."</td>";
        		    echo "<td>".$x['debito']."</td>";
        		    echo "<td align='right'>".number_format($saldo1,2)."</td>";
        		    echo "<td align='right'>".number_format($saldo2,2)."</td></tr>";
        		    
        		    $s1  = $saldo1 + $s1;
        		    $s2  = $saldo2 + $s2;
        		}
 
         		
        		echo '</table>';
		
        		$saldo = $s1 - $s2;
        		
         
        		    echo ' <div class="col-md-12" style="padding-bottom:10;padding-top:10px" align="right"> ';
        		    echo '<h4><b>DEBE:  '.number_format($s1,2).'</b></h4>';
        		    echo '<h4><b>HABER:  '.number_format($s2,2).'</b></h4>';
        		    echo '<h4><b>SALDO:  '.number_format($saldo,2).'</b></h4>';
        		    echo '</div>';
        		    
        		
        		
        		
        		echo '<script>
                        jQuery.noConflict(); 
                         jQuery(document).ready(function() {
 	                     jQuery("#jsontable_valida").DataTable( {
                	        "paging":   true,
                	        "ordering": true,
                	        "info":     true,
                            "aoColumnDefs": [
                            	    { "sClass": "highlight", "aTargets": [ 3] },
                            	    { "sClass": "de", "aTargets": [ 8 ] },
                            	    { "sClass": "ye", "aTargets": [ 9 ] }
                            	    ]
                	    } ); } );  </script>';
 
	}
	
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;

 

 
if (isset($_POST["bgfecha1"]))	{
	
	$f1 			    =     $_POST["bgfecha1"];
	$f2 				=     $_POST["bgfecha2"];
	$ngrupo 			=     $_POST["ngrupo"];
 
	$nsubgrupo			=     $_POST["nsubgrupo"];
	$nitem 			    =     $_POST["nitem"];
 
	$tipo 			    =     $_POST["tipo"];
 
	$gestion->grilla( $f1,$f2,$ngrupo ,$nsubgrupo,$nitem,$tipo);
 
}

?>
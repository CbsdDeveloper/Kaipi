<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
 
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/

class Model_listaAuxq_total{
	
 	
	private $obj;
	private $bd;
	private $set;
	
	private $ruc;
	private $sesion;
	private $hoy;
	private $POST;
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function Model_listaAuxq_total( ){
		//inicializamos la clase para conectarnos a la bd
		
		$this->obj     = 	new objects;
		$this->bd	   =	new Db ;
		$this->set     = 	new ItemsController;
		
		$this->ruc       =  $_SESSION['ruc_registro'];
		$this->sesion 	 =  $_SESSION['email'];
		$this->hoy 	     =  $this->bd->hoy();
		
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
		
	}
   
	//--- calcula libro diario
	function GrillaMaestro(  $anio, $bandera){
		
	    $idprov ='';
	    
	    $cuenta = '112.01.03';
	    
	    echo '<div class="panel panel-default">
              <div class="panel-heading">Detalle de Movimientos por Auxiliar</div>
              <div class="panel-body">
               <ul class="list-group">';

 
 
	    $this->GrillaPago( $idprov,$cuenta,$anio);
     
	    
	    
 	    
	    echo ' </ul>
               </div>
            </div>';
	    
 
		
	    $ViewFormCxc= '<h6><br>'.' Resumen de Auxiliares '.$idprov.'</br></h6>';
	    
	    echo $ViewFormCxc;
	
	}
 	//---------------------------------
	function GrillaPago( $idprov,$cuenta,$anio){
	    
	    $tipo 		    = $this->bd->retorna_tipo();
	    
		$this->titulo();
  
 	    
 
	        
	        $sql = 'SELECT idprov as identificacion,
	        			   funcionario,
				      		round(monto_solicitado/anticipo,2) solicitado, 
						  	round(plazo/anticipo,0) as plazo, 
							round(monto_solicitado /plazo,2) as cuota ,
							round(pagado /anticipo,2) as pagado,
							round((monto_solicitado - pagado)/anticipo,2) as saldo
					FROM view_anticipo_ciu
             where   (monto_solicitado - pagado) >0 and
             		 anio = '. $this->bd->sqlvalue_inyeccion( $anio , true).'   order by funcionario';
 
	            
	      $formulario = 'idprov';
	      
	      $resultado  = $this->bd->ejecutar($sql);
	      
	      $this->obj->grid->KP_sumatoria(4,"solicitado","pagado", 'saldo','');
	 	    
	      $this->obj->grid->KP_GRID_CTAA($resultado,$tipo,'identificacion',$formulario,'S','visor','','','');
	     
  
	     
	}
	function titulo(){
	    
	    
	    $this->hoy 	     =  date("Y-m-d");

		$anio			 = date('Y');
	    
	    $this->login     =  trim($_SESSION['login']);
	    
 
	    
	    $imagen = '<img src="../../kimages/'.trim($_SESSION['logo']).'" width="170" height="110">';
	    
	    echo '<table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                  <td width ="20%" rowspan="2">'.$imagen.'</td>
                  <td  width="60%" rowspan="2" style="text-align: center"><b>'.$_SESSION['razon'].'</b><br>
                        <b>'.$_SESSION['ruc_registro'].'</b><br><br>
                        <b>CONTROL DE ANTICIPOS ( PERIODO '.$anio.' ) </b><br>
                        </td>
                  <td  width="20%">&nbsp;</td>
                </tr>
                <tr>
                  <td>FECHA '.$this->hoy .'<br>
                     USUARIO '.$this->login.' <br>
                     REPORTE</td>
                </tr>
 	   </table>';
	    
	}
 
 
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new Model_listaAuxq_total;

 
 

if (isset($_GET["anio"]))	{
 
    
    $anio					=   $_GET["anio"];
     $bandera				=   $_GET["bandera"];
    
    $gestion->GrillaMaestro( $anio,$bandera);
 
	
}
 
 

?>
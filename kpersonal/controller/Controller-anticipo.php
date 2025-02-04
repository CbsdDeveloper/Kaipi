<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/

class componente{
    
     
    private $obj;
    private $bd;
    private $set;
    
    private $formulario;
    private $evento_form;
    
    private $ruc;
    private $sesion;
    private $hoy;
    private $POST;
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function componente( ){
        //inicializamos la clase para conectarnos a la bd
        
        $this->obj     = 	new objects;
        
        $this->set     = 	new ItemsController;
        
        $this->bd	   =	new  Db ;
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        
        $this->sesion 	 =  $_SESSION['email'];
        
        $this->hoy 	     =  date("Y-m-d");
        
        
    }
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function FiltroFormulario( $idprov ){
        

        $anio       = date('Y') ;
        $cuenta     = '112.01.03%';
        $tipo 		= $this->bd->retorna_tipo();

        $formulario = 'Anticipos';

        $this->titulo();
     

        $Array = $this->bd->query_array('view_nomina_user','completo, regimen,cargo', 'idprov='.$this->bd->sqlvalue_inyeccion($idprov,true));

        echo  '<h5><b>Regimen: '.$Array['regimen'].'<br>Funcionario: '.$Array['completo'].'<br>Cargo: '.$Array['cargo'].'</b></h5>';


        $this->set->div_label(12,'<h4><b>TRAMITES AUTORIZADOS DE ANTICIPOS </b></h4>');	 

        $sql = 'SELECT fecha, documento,detalle,sueldo,garante,garante_sueldo ,plazo,monto_solicitado 
            from view_anticipo_tramite
            where  anio = '. $this->bd->sqlvalue_inyeccion( $anio , true)." and estado = 'aprobado' and 
                   idprov = ". $this->bd->sqlvalue_inyeccion($idprov , true).' order by fecha';

 
             
 
        $resultado  = $this->bd->ejecutar($sql);

        $this->obj->grid->KP_sumatoria(8,"monto_solicitado","", '','');
	 	    
        $this->obj->grid->KP_GRID_CTAA($resultado,$tipo,'identificacion',$formulario,'N','','','','');



        $this->set->div_label(12,'<h4><b>DETALLE DE ANTICIPOS (FINANCIERO) </b></h4>');	 
        

        $sql = "SELECT cuenta_detalle,  cuenta
        FROM view_aux
        where idprov = ".$this->bd->sqlvalue_inyeccion($idprov,true)." and
              cuenta like ".$this->bd->sqlvalue_inyeccion($cuenta,true)." and
              anio = ".$this->bd->sqlvalue_inyeccion($anio,true)." and
              registro = ". $this->bd->sqlvalue_inyeccion(trim($this->ruc) , true)."
        group by cuenta_detalle, cuenta
        order by cuenta_detalle,  cuenta";    

        echo '<div class="panel panel-default">
        <div class="panel-heading">Detalle de Movimientos por Auxiliar</div>
        <div class="panel-body">
         <ul class="list-group">';

         $stmt = $this->bd->ejecutar($sql);
	    
         while ($x=$this->bd->obtener_fila($stmt)){
             
             $cnombre =  trim($x['cuenta_detalle']);
             
             $cuenta =  trim($x['cuenta']);
         
             echo '   <li class="list-group-item">'.$cuenta.' '.$cnombre.'</li>';
             
             $this->GrillaPago( $idprov,$cuenta,$anio);
        
         }
         
          
         echo ' </ul>
                </div>
             </div>';
         
       
    }
     ///------------------------------------------------------------------------
     //---------------------------------
	function GrillaPago( $idprov,$cuenta,$anio){
	    
	    $tipo 		    = $this->bd->retorna_tipo();
	    
	    $sql = 'SELECT  id_asiento as "Asiento",
                        fecha as "Fecha", 
                        substring(comprobante,1,10) || '."' '".' as "Comprobante",
                        substring(detalle,1,150) as "Detalle",  
                        debe as "Debe", 
                        haber as "Haber",  
                        debe - haber as "Saldo"
                FROM view_aux
                where idprov = '. $this->bd->sqlvalue_inyeccion($idprov , true).' and 
                       estado = '. $this->bd->sqlvalue_inyeccion('aprobado' , true).' and 
                       anio = '. $this->bd->sqlvalue_inyeccion( $anio , true).' and 
                       registro = '. $this->bd->sqlvalue_inyeccion(trim($this->ruc) , true).' and 
                      cuenta = '. $this->bd->sqlvalue_inyeccion(trim($cuenta) , true).' order by fecha asc';

	   
      
	    $formulario = '';
	      
	    $resultado  = $this->bd->ejecutar($sql);
	      
	      
	      $this->obj->grid->KP_sumatoria(5,"Debe","Haber", 'Saldo','');
	  
  	 	    
	      $this->obj->grid->KP_GRID_CTAA($resultado,$tipo,'Asiento',$formulario,'N','','','','');
 
	}
    /*
    */
    function titulo(){
	    
	    
	    $this->hoy 	     =  date("Y-m-d");

		$anio			 = date('Y');
	    
	    $this->login     =  trim($_SESSION['login']);
	    
 
	    
	    $imagen = '<img src="../../kimages/'.trim($_SESSION['logo']).'" width="170" height="110">';
	    
	    echo '<table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                  <td width="20%" rowspan="2">'.$imagen.'</td>
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

$gestion   = 	new componente;


$idprov   = trim($_GET['idprov']);

$gestion->FiltroFormulario( $idprov);

?>
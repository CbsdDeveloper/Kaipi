<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
	
 	
	private $obj;
	private $bd;
	
	private $ruc;
	public  $sesion;
	public  $hoy;
	private $POST;
	private $ATabla;
	private $tabla ;
	private $secuencia;
	private $proceso;
	
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function proceso( ){
		//inicializamos la clase para conectarnos a la bd
		
		$this->obj     = 	new objects;
		
		$this->bd	   =	new Db ;
		
		$this->ruc       =  $_SESSION['ruc_registro'];
		
		$this->sesion 	 =  trim($_SESSION['email']);
 		
		$this->hoy 	     =  date("Y-m-d");    
		
		$this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
		
	 
		
	}
	 
	    
 	 
	
	//--------------------------------------------------------------------------------
	function ProcesoNombre($id){
		
		
	    $this->ATabla = $this->bd->query_array('flow.view_proceso',
				' *',
				'idproceso='.$this->bd->sqlvalue_inyeccion($id,true)
				);
 
	    $anio = date("Y"); 
	    
	    $input = str_pad($id, 6, "0", STR_PAD_LEFT).'-'.$anio;
	    
		
	    $this->ATabla['version'] = '1.0 - '.$anio;
	    
	    $this->ATabla['hoy'] =  $this->hoy;
 
	    $this->ATabla['codigo'] =  $input;
	    
	    $this->proceso = $id;
	 
		return $this->ATabla['nombre'];
		
		
	}
	//------------------
	//--------------------------------------------------------------------------------
	function Objetivo( ){
 	    
	    $div ='<div class="panel panel-default"><div class="panel-body">';
	    
	    
	    $ViewProceso = 	'OBJETIVO: &nbsp;&nbsp;&nbsp;&nbsp;'. $this->ATabla['objetivo'].'<br>'.
	   	    'INDICADOR: &nbsp;&nbsp;&nbsp;&nbsp;'. $this->ATabla['indicador'].'<br><br>'.
	   	    'TIPO DE PROCESO: &nbsp;&nbsp;&nbsp;&nbsp;'. $this->ATabla['tipo'].'<br>'.
	   	    'ENTRADA:&nbsp;&nbsp;&nbsp;&nbsp;'. $this->ATabla['entrada'].'<br>'.
	   	    'SALIDA: &nbsp;&nbsp;&nbsp;&nbsp;'. $this->ATabla['salida'].'<br>'.
	   	    'MODELADOR:&nbsp;&nbsp;&nbsp;&nbsp;'. $this->ATabla['modelador'].'<br>';
	    
	    $divi = '</div></div>';
	    
	    echo $div.$ViewProceso.$divi;
 	    
	}
	//---------------------
	function variable( $variable ){
	    echo $this->ATabla[$variable];
	}
	//--------------------------------------------------------------------------------
	function Flujo( ){
	    
	    
	    
 	    
	    $DibujoFlujo = '<img src="../flujo/'.$this->ATabla['archivo'] .'"/>';
 
	    echo $DibujoFlujo;
	   	    
	   	    
	   	    
	}
	//--------------------------------------------------------------------------------
	
	function Requisitos( ){
	    
	    
	    
	    $sql = "select sum(tiempo) as tiempo_total,tipotiempo, ( sum(tiempo) / 8) en_dias
              from flow.wk_procesoflujo
             where idproceso = ".$this->bd->sqlvalue_inyeccion( $this->proceso,true)." and 
             idtarea  <> 0  group by idproceso, tipotiempo";
	    
	    $stmt_nivel1= $this->bd->ejecutar($sql);
	    
	    $totalhora = 0;
	    while ($x=$this->bd->obtener_fila($stmt_nivel1)){
	        $totalhora = $totalhora + $x['tiempo_total'];
	    }
	    
	    
	    $ViewFormTiempo ='<div class="thumbnail">
        <a href="#">
             <img src="../../kimages/relojwk.png" alt="Lights">
            <div class="caption">
            <p align="center">Tiempo de duracion<br><span style="font-size: 25px"><b> '.$totalhora.' horas </b> </span>
            </p>
            </div>
        </a>
    </div>';
	    
	    echo $ViewFormTiempo ;
	    
	    $sql = 'SELECT
                    requisito  ,
                     obligatorio,tipo,prioridad
      FROM flow.wk_proceso_requisitos
      where idproceso = '.$this->bd->sqlvalue_inyeccion($this->proceso ,true)    ;
	    
	    $tipo 		= $this->bd->retorna_tipo();
	    
	    ///--- desplaza la informacion de la gestion
	    $resultado  = $this->bd->ejecutar($sql);
	    
	    $cabecera =  " Requisito, Obligatorio,Tipo,Prioridad";
	    
	    $evento = '';
	    
	    $this->obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
	    
	    
	}
	
	
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------



 


?>
 
  
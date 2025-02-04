<?php
session_start( );

require '../../kconfig/Db.class.php';    

require '../../kconfig/Obj.conf.php';  


class proceso{
	
 
	
	private $obj;
	private $bd;
	private $bd_cat;
	
	private $ruc;
	public  $sesion;
	public  $hoy;
	private $POST;

	private $ATablaPago;
	private $tabla ;
	private $secuencia;
	
	private $estado_periodo;
	
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function proceso( ){
		//inicializamos la clase para conectarnos a la bd
		
		$this->obj     = 	new objects;
		$this->bd	   =	new Db ;
		
		$this->bd_cat	   =	 	new Db ;

		$this->ruc       =     $_SESSION['ruc_registro'];
		
		$this->sesion 	 =     trim($_SESSION['email']);
		
		$this->hoy 	     =     date("Y-m-d");     
		
		$this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
		
	 
		 
		
	}
 
	//-----------------------------------------------------------
 
	function AprobarComprobante($fecha, $novedad,$cajero ){
	    
        $anio = date('Y');

        $x_secuencia = $this->bd->query_array('rentas.view_resumen_caja',   // TABLA
        'max(secuencia) + 1 as secuencia ',                        // CAMPOS
        'anio =' .$this->bd->sqlvalue_inyeccion($anio, true)
        );

  
		 $hora = date('H:i:s');

         $contador = $x_secuencia['secuencia'] ;
	    
         $input = str_pad($contador, 8, "0", STR_PAD_LEFT);


         $parte =  $anio .'-'. $input;
 	    
 	     $sql = " UPDATE rentas.ren_movimiento
    			   SET 	cierre=".$this->bd->sqlvalue_inyeccion('S', true)."
      			 WHERE cierre = 'N' and
                       estado = 'P' and
                       sesion_pago=".$this->bd->sqlvalue_inyeccion($cajero , true)."  and
                       fechap =".$this->bd->sqlvalue_inyeccion($fecha , true);
 	    
 	    
 	     $this->bd->ejecutar($sql);
 	    
 	    
          $sql = " UPDATE rentas.ren_movimiento_pago
          SET 	cierre=".$this->bd->sqlvalue_inyeccion('S', true).",
                parte=".$this->bd->sqlvalue_inyeccion( $parte, true).",
				hora=".$this->bd->sqlvalue_inyeccion( $hora, true).",
                secuencia=".$this->bd->sqlvalue_inyeccion( $contador, true)."
          WHERE cierre = 'N' and
                sesion=".$this->bd->sqlvalue_inyeccion($cajero , true)."  and
                fecha_pago =".$this->bd->sqlvalue_inyeccion($fecha , true);


            $this->bd->ejecutar($sql);


 	   

 	    $result = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>TRANSACCION EMITIDO CON EXITO [ '.$parte.' ]</b>';
	        
	     echo $result;
	        
	}
 	 
 	 
///-------------------------------------------
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;

//------ poner informacion en los campos del sistema
 
 
//---------------------------
    if (isset($_GET["accion"]))	{
        
         
        $accion  = trim($_GET["accion"]);
        $fecha   = trim($_GET["fecha"]);
        $novedad = trim($_GET["novedad"]);

		$cajero = trim($_GET["cajero"]);
        
        if ($accion == 'aprobacion'){
            
            $gestion->AprobarComprobante($fecha, $novedad,$cajero );

        } 
        
        
    }

?>
 
  
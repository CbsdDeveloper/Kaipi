<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
	
	//creamos la variable donde se instanciar la clase "mysql"
	
	private $obj;
	private $bd;
	
	private $ruc;
	public  $sesion;
	public  $hoy;
	private $POST;
	private $ATabla;
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
		
		$this->ruc       =     $_SESSION['ruc_registro'];
		
		$this->sesion 	 =     $_SESSION['email'];
		
		$this->hoy 	     =     date("Y-m-d");    	//$this->hoy 	     =  $this->bd->hoy();
		
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
		
		 
		
	}
 //------------------------------
	function Saldos(){
      
	    
	    $sql = "update inv_movimiento_det
                    set ingreso = cantidad 
                    where     id_movimiento=".$this->bd->sqlvalue_inyeccion(-1, true);
	    
	    $this->bd->ejecutar($sql);
	    
	    
	    $sql_det = 'SELECT registro, anio, idproducto, producto, cantidad, costo, total, ingreso, egreso
                      FROM view_saldos_bodega 
                     where registro ='.$this->bd->sqlvalue_inyeccion($this->ruc, true);
	    
	    
	    
	    $stmt1 = $this->bd->ejecutar($sql_det);
	    
	    
	    while ($x=$this->bd->obtener_fila($stmt1)){
	        
	        $idproducto        = $x['idproducto'];
	        $ingreso           = $x['ingreso'];
	        $costo             = $x['costo'];
	        $egreso            = $x['egreso'];
	        
	        $saldo = $ingreso - $egreso;
	       
	            
	            $sql = 'UPDATE web_producto
						  SET  	saldo   =   '.$this->bd->sqlvalue_inyeccion($saldo, true).',
                                ingreso   =   '.$this->bd->sqlvalue_inyeccion($ingreso, true).',
                                egreso   =   '.$this->bd->sqlvalue_inyeccion($egreso, true).'
						  WHERE idproducto='.$this->bd->sqlvalue_inyeccion($idproducto, true).' and  
						         registro ='.$this->bd->sqlvalue_inyeccion($this->ruc, true);
	            
	            $this->bd->ejecutar($sql);
	        
	            
	     
	          
	        }
	        
	        $SaldoBodega = 'ok';
	        
	        return $SaldoBodega;
	        
 	}    
    
 }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;

//------ poner informacion en los campos del sistema
 
$SaldoBodega =  $gestion->Saldos( );
	
 
echo $SaldoBodega;


?>
 
  
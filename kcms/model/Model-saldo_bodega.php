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
		
		$this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
		
		 
		
	}
 //------------------------------
	function verifica_costos(){
	    
	    
	    $sql_det = 'SELECT costo, total ,id,codigo ,cantidad
                	FROM public.view_movimiento_det
                	where costo = 0';
	    
	    
	    
	    $stmt1 = $this->bd->ejecutar($sql_det);
	    
	    
	    while ($x=$this->bd->obtener_fila($stmt1)){
	        
	        $cantidad                 = $x['cantidad'];
	        $costo                    = $x['total'] / $cantidad;
	        $id_movimientod           = $x['id']; 
	       
	        
	        $sql = "update inv_movimiento_det
                    set costo = ".$this->bd->sqlvalue_inyeccion($costo, true)." 
                        where id_movimientod=".$this->bd->sqlvalue_inyeccion($id_movimientod, true);
	        
	        $this->bd->ejecutar($sql);
	        
	    }
	    
	    
	}
	//------------------------------
	function verifica_costos_inicial(){
	    
	    
	    $sql_det = 'SELECT id_movimiento, fechaa,   idproducto, cantidad, costo, total, ingreso, egreso, anio
                	FROM public.view_mov_aprobado where ingreso > 0';
	    
	    
	    echo $sql_det;
	     
	    
	    $stmt1 = $this->bd->ejecutar($sql_det);
	    
	    
	    while ($x=$this->bd->obtener_fila($stmt1)){
	        
	        $cantidad                 = $x['cantidad'];
	        $costo                    = $x['total'] / $cantidad;
	        $id_movimientod           = $x['idproducto'];
	        
	        
	        $sql = "update web_producto
                    set costo = ".$this->bd->sqlvalue_inyeccion($costo, true).",
                        fob = ".$this->bd->sqlvalue_inyeccion($costo, true).",
                        promedio = ".$this->bd->sqlvalue_inyeccion($costo, true).",
                        fifo = ".$this->bd->sqlvalue_inyeccion($costo, true)."
                        where idproducto=".$this->bd->sqlvalue_inyeccion($id_movimientod, true);
	        
	        $this->bd->ejecutar($sql);
	        
	    }
	    
 
	}
	//------------------------------
	function Saldos(){
      
	    
	   // $this->verifica_costos();
	    
	    $sql = "update inv_movimiento_det
                    set ingreso = cantidad 
                    where     id_movimiento=".$this->bd->sqlvalue_inyeccion(-1, true);
	    
	    $this->bd->ejecutar($sql);
	    
	    
	    $sql = "update web_producto
                    set ingreso=0, egreso=0, saldo=0
                    where     registro=".$this->bd->sqlvalue_inyeccion($this->ruc, true);
	    
	    $this->bd->ejecutar($sql);
	    
	     
	    
	    
	    $sql_det = 'SELECT registro,   idproducto, producto, 
                          sum(cantidad) as cantidad, 
                          avg(costo) as costo, 
                          sum(total) as total, 
                          sum(ingreso) as ingreso, 
                          sum(egreso) as egreso
                      FROM view_saldos_bodega 
                     where registro ='.$this->bd->sqlvalue_inyeccion($this->ruc, true).
	                ' group by  registro,   idproducto, producto';
	    
	    
	    
	    $stmt1 = $this->bd->ejecutar($sql_det);
	    
	    
	    while ($x=$this->bd->obtener_fila($stmt1)){
	        
	        $idproducto        = $x['idproducto'];
	        $ingreso           = $x['ingreso'];
	      // $costo             = $x['costo'];
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
 
  
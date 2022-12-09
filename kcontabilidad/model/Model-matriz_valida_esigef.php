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
	
	private $ATabla;
	private $tabla ;
	private $secuencia;
	private $anio;
	
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function proceso( ){
		//inicializamos la clase para conectarnos a la bd
		
		$this->obj     = 	new objects;
		$this->bd	   =	new Db ;
		
		$this->ruc       =  $_SESSION['ruc_registro'];
		
		$this->sesion 	 =  trim($_SESSION['email']);
		$this->hoy 	     =  $this->bd->hoy();
		
		$this->anio      =  $_SESSION['anio'];
		
		
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
		 
		
	}
 
 
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	function valida_asociacion01( $id_registro ,$anio,$tipo ){
		
   

        $sql1 = 'SELECT cuenta, detalle, debito, credito, envio 
        FROM  co_matriz_e
        where debito is not  null order by cuenta';
        
 
        $stmt1 = $this->bd->ejecutar($sql1);

 
        while ($fila=$this->bd->obtener_fila($stmt1)){
                
                $cuenta = trim($fila['cuenta']).'%';
                $credito = trim($fila['debito']);

                $sql_edit= 'update co_plan_ctas
                                set debito='.$this->bd->sqlvalue_inyeccion($credito,true).'
                                where cuenta like  '.$this->bd->sqlvalue_inyeccion($cuenta,true).' and
                                      anio = '.$this->bd->sqlvalue_inyeccion($anio,true);
 
                $this->bd->ejecutar($sql_edit);
  
        }

        $sql_edit= 'update co_plan_ctas
        set partida_enlace='.$this->bd->sqlvalue_inyeccion('gasto',true).'
        where cuenta like  '.$this->bd->sqlvalue_inyeccion('63%',true).' and
              anio = '.$this->bd->sqlvalue_inyeccion($anio,true);

              $this->bd->ejecutar($sql_edit);

        $sql_edit= 'update co_plan_ctas
        set partida_enlace='.$this->bd->sqlvalue_inyeccion('-',true).'
        where cuenta like  '.$this->bd->sqlvalue_inyeccion('213.%',true).' and
              anio = '.$this->bd->sqlvalue_inyeccion($anio,true);

        $this->bd->ejecutar($sql_edit);
   
 	     echo 'Datos actualizados....';
	}
 
//----------------------------
    

    function valida_esigef(  $anio ){
		
   
        $sql_edit= 'update co_plan_ctas
        set impresion='.$this->bd->sqlvalue_inyeccion(0,true).'
        where anio = '.$this->bd->sqlvalue_inyeccion($anio,true);

        $this->bd->ejecutar($sql_edit);


        $sql1 = "SELECT cuenta, detalle, debito, credito, envio 
        FROM  co_matriz_e
        where envio = '1'    order by cuenta";
        
 

        $stmt1 = $this->bd->ejecutar($sql1);

 
        while ($fila=$this->bd->obtener_fila($stmt1)){
                
                $cuenta = trim($fila['cuenta']);
 
                $sql_edit= 'update co_plan_ctas
                                set impresion='.$this->bd->sqlvalue_inyeccion(1,true).'
                                where cuenta =  '.$this->bd->sqlvalue_inyeccion($cuenta,true).' and
                                      anio = '.$this->bd->sqlvalue_inyeccion($anio,true);
 
                $this->bd->ejecutar($sql_edit);
  
        }

      
   
 	     echo 'Datos actualizados....';
	}
    //--------------------------
	function valida_asociacion( $id_registro ,$anio,$tipo ){
		
   

        $sql1 = 'SELECT cuenta, detalle, debito, credito, envio 
        FROM  co_matriz_e
        where credito is not  null order by cuenta';
        
 
        $stmt1 = $this->bd->ejecutar($sql1);

 
        while ($fila=$this->bd->obtener_fila($stmt1)){
                
                $cuenta = trim($fila['cuenta']).'%';
                $credito = trim($fila['credito']);

                $sql_edit= 'update co_plan_ctas
                                set credito='.$this->bd->sqlvalue_inyeccion($credito,true).'
                                where cuenta like  '.$this->bd->sqlvalue_inyeccion($cuenta,true).' and
                                      anio = '.$this->bd->sqlvalue_inyeccion($anio,true);
 
                $this->bd->ejecutar($sql_edit);
  
        }

        $sql_edit= 'update co_plan_ctas
        set partida_enlace='.$this->bd->sqlvalue_inyeccion('ingreso',true).'
        where cuenta like  '.$this->bd->sqlvalue_inyeccion('62%',true).' and
              anio = '.$this->bd->sqlvalue_inyeccion($anio,true);

              $this->bd->ejecutar($sql_edit);

        $sql_edit= 'update co_plan_ctas
        set partida_enlace='.$this->bd->sqlvalue_inyeccion('-',true).'
        where cuenta like  '.$this->bd->sqlvalue_inyeccion('113.%',true).' and
              anio = '.$this->bd->sqlvalue_inyeccion($anio,true);

        $this->bd->ejecutar($sql_edit);
   
 	     echo 'Datos actualizados....';
	}	 

}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 

$gestion   = 	new proceso;


//------ poner informacion en los campos del sistema
if (isset($_GET['anio_selecciona']))	{
    
      $id              = $_SESSION['ruc_registro'];
  	  $anio            = $_GET['anio_selecciona']  ;
      $tipo            = $_GET['tipo']  ;
	  
      if ( $tipo== 1 ){
  	         $gestion->valida_asociacion($id,$_GET['anio_selecciona'],$tipo  );

             $gestion->valida_asociacion01($id,$_GET['anio_selecciona'],$tipo  );

      }else {

           $gestion->valida_esigef($_GET['anio_selecciona']  );

 
    }
}
 


?>
 
  
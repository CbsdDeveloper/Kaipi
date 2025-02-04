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
    
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
         
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function grafico(){
      
      	$anio = date ("Y");  
      	
       	
      	
      	$sql = "SELECT MES  ,SUM(debe) AS debe,   SUM(haber) AS haber, SUM(haber) - SUM(debe)  saldo
			  FROM view_balance
			  WHERE cuenta like '2%' AND 
					anio = ". $this->bd->sqlvalue_inyeccion($anio,true)."  AND 
				    REGISTRO = ". $this->bd->sqlvalue_inyeccion($this->ruc ,true)." 
			GROUP BY MES
			ORDER BY 1";

 
 
      	$resultado  = $this->bd->ejecutar($sql);
      	
      	
      	
      	$bln = array();
      	
      	$bln['name'] = 'Mes';
      	$rows['name'] = 'Debe';
      	$rows1['name'] = 'Haber';
      	$rows2['name'] = 'Saldo';
      	
      	while ($r=$this->bd->obtener_fila($resultado)){
       	
      		$bln['data'][]  = $r['mes'];
      		$rows['data'][] = (int) $r['debe'];
      		$rows1['data'][] = (int) $r['haber'];
      		$rows2['data'][] = (int) $r['saldo'];
         		
      	}
    
 
      	$rslt = array();
      	array_push($rslt, $bln);
      	array_push($rslt, $rows);
      	array_push($rslt, $rows1);
      	array_push($rslt, $rows2);
      	print json_encode($rslt, JSON_NUMERIC_CHECK);
      	
        
      	
 	}
 
   
 }    
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 
 
    		$gestion   = 	new proceso;
 
  			$gestion->grafico();
 
  
   
 ?>
 
  
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
         
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function grafico(){
      
      	$anio = date ("Y");  
      	
       	
      	
      	$sql = "SELECT mes , total
			  FROM view_res_inv_mes
			  WHERE tipo = 'I' AND 
					anio = ". $this->bd->sqlvalue_inyeccion($anio,true)."
			ORDER BY 1";

      
 
      	$resultado  = $this->bd->ejecutar($sql);
      	
      	
      	
      	$bln = array();
      	
      	$bln['name'] = 'Mes';
      	$rows['name'] = 'Monto';
      	
      	while ($r=$this->bd->obtener_fila($resultado)){
       	
      		$bln['data'][]  = $r['mes'];
      		$rows['data'][] = (int) $r['total'];
        		
      	}
    
 
      	$rslt = array();
      	array_push($rslt, $bln);
      	array_push($rslt, $rows);
      	print json_encode($rslt, JSON_NUMERIC_CHECK);
      	
        
      	
 	}
 
   
 }    
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 
 
    		$gestion   = 	new proceso;
 
  			$gestion->grafico();
 
  
   
 ?>
 
  
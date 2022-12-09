<?php 
     session_start( );   
  
    require '../../kconfig/Db.class.php';    
 	
 	
    require '../../kconfig/Obj.conf.php';  
  
  
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
  
                $this->obj     = 	new objects;
                $this->bd	   =	new Db ;
    
                $this->ruc       =  $_SESSION['ruc_registro'];
                $this->sesion 	 =  $_SESSION['email'];
         
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla($festado,$ffecha1,$ffecha2){
      
      	
      	$sql_ruc ='(SELECT x.razon FROM par_ciu x where x.idprov = a.idprov) as razon';
     
       	$cadena0 =  '( a.registro = '.$this->bd->sqlvalue_inyeccion(trim($this->ruc),true).') and ';
        
      	$cadena1 = '( a.marca ='.$this->bd->sqlvalue_inyeccion(trim($festado),true).") and ";
      
      	$cadena2 = '( a.fecha BETWEEN '.$this->bd->sqlvalue_inyeccion($ffecha1,true)." and ".$this->bd->sqlvalue_inyeccion($ffecha2,true)." )   ";
 
      	
      	$where = $cadena0.$cadena1.$cadena2;
      	
      	$sql = 'SELECT a.id_asiento,
                       a.fecha,
                       a.comprobante,
                       a.detalle,'.$sql_ruc.',
                       a.tipo,
                       a.estado,
                       a.modulo
                from co_asiento a where '. $where;
      	
       
      	
      	$resultado  = $this->bd->ejecutar($sql);
 
      	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
 
      	    
      	    if ($festado == '1'){
      	    
      	        $imagen = ' <img src="../../kimages/star.png"/>';
      	    
      	    }else {
      	        
      	        if ( trim($fetch['estado']) == 'digitado'){
      	            
      	            $imagen =' <img src="../../kimages/star_medio.png"/>';
      	            
      	        }else {
      	            
      	            $imagen =' <img src="../../kimages/starok.png"/>';
      	            
      	        }
      	       
      	    }
      	    
      	    
 	          $output[] = array (
      				    $fetch['id_asiento'],
 						$fetch['fecha'],
 	                    $fetch['estado'],
						$fetch['comprobante'],
 	                    trim($fetch['detalle']),
 	                    $imagen 
        		);	 
      		
      	}
 
 
      	pg_free_result($resultado);
      	
       echo json_encode($output);
      	
      	
      	}
 
   
 }    
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 
///------------------------------------------------------------------------
/*'ffecha1' : ffecha1  ,
 'ffecha2' : ffecha2  ,
 'festado' : festado  */
///------------------------------------------------------------------------ 
 
    		$gestion   = 	new proceso;
    
          
            //------ consulta grilla de informacion
            if (isset($_GET['festado']))	{
            
            	$festado= $_GET['festado'];
            	$ffecha1= $_GET['ffecha1'];
            	$ffecha2= $_GET['ffecha2'];
             	 
            	$gestion->BusquedaGrilla($festado,$ffecha1,$ffecha2);
            	
            	 
            }
  
  
   
 ?>
 
  
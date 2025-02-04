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
      public function BusquedaGrilla($festado,$ffecha1,$ffecha2,$idbancos){
      
 
     
       	$cadena0 =  '( registro = '.$this->bd->sqlvalue_inyeccion(trim($this->ruc),true).') and ';
        
       	$cadena1 = '( estado ='.$this->bd->sqlvalue_inyeccion(trim($festado),true).") and ";
       	
       	$cadena2 = '( cuenta ='.$this->bd->sqlvalue_inyeccion(trim($idbancos),true).") and ";
      
      	$cadena3 = '( fecha BETWEEN '.$this->bd->sqlvalue_inyeccion($ffecha1,true)." and ".$this->bd->sqlvalue_inyeccion($ffecha2,true)." )   ";
 
      	
      	$where = $cadena0.$cadena1.$cadena2.$cadena3;
      	
      	$sql = 'SELECT  id_concilia, fecha,   anio, mes, detalle,  estado,   saldobanco  ,saldoestado ,cuenta
                from co_concilia   where '. $where;
      	
 
      	
      	$resultado  = $this->bd->ejecutar($sql);
 
      	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
 
 	$output[] = array (
      				    $fetch['id_concilia'],
 						$fetch['fecha'],
						$fetch['anio'],
 	                    $fetch['mes'],
      				    trim($fetch['detalle']),
                 	    $fetch['estado'],
                 	    $fetch['saldobanco'],
                 	    $fetch['saldoestado']
 	    
        		);	 
      		
      	}
 
 
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
            	
            	$idbancos= $_GET['idbancos'];
             	 
            	
            	$gestion->BusquedaGrilla($festado,$ffecha1,$ffecha2,$idbancos);
            	 
            }
  
  
   
 ?>
 
  
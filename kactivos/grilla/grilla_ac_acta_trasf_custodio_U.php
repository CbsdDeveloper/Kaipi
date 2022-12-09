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
      public function BusquedaGrilla(){
      
 
        $sql1 = "select * 
                    from activo.view_acta
                    where clase_documento in ('Acta de Entrega - Recepcion','Acta Trasferencia de Bienes')
                    order by documento desc limit 45";

           
        $resultado = $this->bd->ejecutar($sql1);

       	$output    = array();
      	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
 
            $bandera = 1 ;

            if ( trim($fetch['clase_documento']) == 'Acta Trasferencia de Bienes'){
               
                $bandera = 2 ;
            
            }  

		 	$output[] = array (
		      				    $fetch['id_acta'],
		 						trim($fetch['razon']),
		      				    trim($fetch['documento']),
 		 	                    $fetch['estado'],
                		 	    $fetch['modificacion'],
                                $bandera
 		      		);	 
      		
      	}
 
 
 	echo json_encode($output);
      	
      	
      	}
 
   
 }    
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 
///------------------------------------------------------------------------
 
///------------------------------------------------------------------------ 
 
    		$gestion   = 	new proceso;
 
    
  
                
                
                $gestion->BusquedaGrilla();
            	 
         
  
   
 ?>
 
  
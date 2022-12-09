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
                
                $this->hoy 	     =  $this->bd->hoy();
        
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla( $moduloc,$tipoc ){
      
		  
		$qquery = 'SELECT * 
                   FROM planificacion.proceso 
                   where  tipo ='.$this->bd->sqlvalue_inyeccion(  trim($tipoc) ,true). ' order by secuencia';
       

             

         $resultado  = $this->bd->ejecutar($qquery);
    
      	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		

            $x = $this->bd->query_array('nom_departamento',   // TABLA
	                                '*',                        // CAMPOS
	                                'id_departamento='.$this->bd->sqlvalue_inyeccion( $fetch['id_departamento'] ,true) // CONDICION
	        );

           $nombre = trim($x['nombre']);

           if ( $fetch['id_departamento'] == '0') {
                  $nombre = 'Todas las unidades';
            }


                  $output[] = array (
                           $fetch['idproc'],
                           $fetch['secuencia'],
                           $nombre ,
                           $fetch['proceso'],
                           $fetch['estado'],
                           $fetch['valor']
                        

                        
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
///------------------------------------------------------------------------ 
 
    		$gestion   = 	new proceso;
    	
    		
  
    			
            $moduloc   = $_GET['moduloc'];
            $tipoc       =  $_GET['tipoc'];
         
            
             $gestion->BusquedaGrilla($moduloc,$tipoc);
            
  
    		
    		
 
   
 ?>
 
  
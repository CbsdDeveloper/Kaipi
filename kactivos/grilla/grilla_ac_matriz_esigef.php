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
        
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla($bcuenta,$bclase, $bdetalle,   $bitem ){
      
		$lon1      =  strlen(trim($bclase));
        $lon2      =  strlen(trim($bdetalle));
        $lon3      =  strlen(trim($bcuenta));
        $lon4      =  strlen(trim($bitem));

        $filtro1  = 'N';
        $filtro2  = 'N';
        $filtro3  = 'N';
        $filtro4  = 'N';
        
        $bandera = 0 ;
        if ( $lon1 >  3 ){
            $filtro1 = 'S';
            $bclase  = strtoupper($bclase);
            $dato    = 'LIKE.'.'%'.($bclase).'%';   // PALABRA RESERVADA PARA BUSCAR COICIDENCIAS CON LA VARIABLE LIKE
            $bandera = 1 ;
        }

          
        if ( $lon2 >  3 ){
            $filtro2 = 'S';
            $bdetalle  = strtoupper($bdetalle);
            $dato1    = 'LIKE.'.'%'.($bdetalle).'%';   // PALABRA RESERVADA PARA BUSCAR COICIDENCIAS CON LA VARIABLE LIKE
            $bandera = 1 ;
        }


        if ( $lon3 >  3 ){
            $filtro3 = 'S';
            $bandera = 1 ;
        }

        if ( $lon4 >  3 ){
            $filtro4 = 'S';
            $bandera = 1 ;
        }

        if ( $bandera == 0 ){
            $filtro4 = 'S';
            $bitem = '5301' ;
        }

		  $qquery = array(
                array( campo  => 'clase',            valor => $dato,        filtro => $filtro1,  visor  => 'S'),
                array( campo  => 'detalle',          valor => $dato1,       filtro => $filtro2,  visor  => 'S'),
                array( campo  => 'identificador',    valor => '-',          filtro => 'N',       visor  => 'S'),
                array( campo  => 'cuenta',           valor => $bcuenta,     filtro => $filtro3,  visor  => 'S'),
                array( campo  => 'item',             valor => $bitem,       filtro =>  $filtro4, visor  => 'S'),
                array( campo  => 'id_matriz_esigef', valor => '-',          filtro => 'N',       visor  => 'S'),
);
      	
       
		 
       
      	$resultado = $this->bd->JqueryCursorVisor('activo.ac_matriz_esigef',$qquery);
      	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		
      		$output[] = array (
       				   $fetch['id_matriz_esigef'],
                       $fetch['identificador'],
                       $fetch['cuenta'],
      			   	   $fetch['item'],
      				   $fetch['detalle'],
                       $fetch['clase']
      				
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
    	
    		//------ consulta grilla de informacion

    		if (isset($_GET['bcuenta']))	{
    			
    			$bcuenta	  = $_GET['bcuenta'];
                $bclase       = $_GET['bclase'];

                $bdetalle	  = $_GET['bdetalle'];
                $bitem       = $_GET['bitem'];
    		 
    		 
					
    			$gestion->BusquedaGrilla($bcuenta,$bclase, $bdetalle,   $bitem );
    			
    		}
    		
 
   
 ?>
 
  
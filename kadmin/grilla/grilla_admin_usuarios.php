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
      public function BusquedaGrilla($PK_codigo, $qrol , $qdirector ){
      
      	// Soporte Tecnico


        if ( $qrol == '-1'){
                $filtro = 'N';
          }else   {
                $filtro = 'S';
          }  

           if ( $qdirector == '-'){
                $filtro1 = 'N';
          }else   {
                $filtro1 = 'S';
          }  
      
      	$qquery = array(
      			array( campo => 'nombre',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'apellido',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'login',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'email',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
                array( campo => 'director',   valor => $qdirector,  filtro =>  $filtro1,   visor => 'S'),
                array( campo => 'rol',   valor =>  $qrol,  filtro => $filtro ,   visor => 'S'),
      			array( campo => 'tipo',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'idusuario',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'estado',   valor => $PK_codigo ,  filtro => 'S',   visor => 'N')
      	);
      
      	$resultado = $this->bd->JqueryCursorVisor('par_usuario',$qquery );
      
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		 
      	    $output[] = array ( $fetch['idusuario'],
      	                        $fetch['login'],
      	                        $fetch['nombre'],
      		                    $fetch['apellido'],
       		                    $fetch['email'],
      		                    $fetch['estado'],
      		                    $fetch['tipo']
      		                    
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
 
   
    		$qrol       = '-1';
    		$qdirector  = '-';
    		
            //------ consulta grilla de informacion
            if (isset($_GET['qrol']))	{
                $qrol       = $_GET['qrol'];
            }
            
            if (isset($_GET['qdirector']))	{
                $qdirector  = $_GET['qdirector'];
            }
            
            	$PKcodigo   = $_GET['GrillaCodigo'];
               
             

 
             	 
            	$gestion->BusquedaGrilla($PKcodigo,  $qrol, $qdirector );
            	 
            
  
  
   
 ?>
 
  
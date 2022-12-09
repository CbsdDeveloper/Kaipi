<?php 
     session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
  
  
    class proceso{
 
      //creamos la variable donde se instanciar la clase "mysql"
 
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
   
    	      
 //--------------------------------------------------------------------------------
    //--- busqueda de por codigo para llenar los datos
 //--------------------------------------------------------------------------------
      function CodigoId( $id ){
        
      	
      	$AResultado = $this->bd->query_array('SIUNIDAD',
      										' COUNT(*) AS NUMERO', 
      			'IDUNIDADPADRE='.$this->bd->sqlvalue_inyeccion($id,true));
      	
      	$CONTADOR = $AResultado['NUMERO'] + 1 ;
      	
      	
      	$IDUNIDAD = $id .'.'. str_pad($CONTADOR, 2, "0", STR_PAD_LEFT);  // produce "-=-=-Alien"
     
      	echo  $IDUNIDAD;
      	
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
     if (isset($_GET['codigo']))	{
            
           $id        = $_GET['codigo'];
            
            $gestion->CodigoId($id);
     }  
  
    
  
     
   
 ?>
 
  
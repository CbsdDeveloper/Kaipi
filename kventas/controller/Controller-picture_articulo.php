<?php 
    session_start( );   
    
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
    require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
  
    class componente{
 
      //creamos la variable donde se instanciar? la clase "mysql"
 
      private $obj;
      private $bd;
      private $set;
      
       private $formulario;
       private $evento_form;
          
      private $ruc;
      private $sesion;
      private $hoy;
      private $POST;
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function componente( ){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	new  Db ;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario( $tipourl, $url ){
      
      
          $ACarpeta = $this->bd->query_array('wk_config',
              'carpetasub',
              'tipo='.$this->bd->sqlvalue_inyeccion($tipourl,true)
              ); 
      	
      	 
          $folder = trim($ACarpeta['carpetasub']);
      	 
          $archivo = $folder.$url;
      	 
          $VisorArticulo = '<center><img src='.$archivo.'  width="350" height="450" /> </center>';
          
        
          
          echo $VisorArticulo;
      
      }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
  
 
   if (isset($_GET['tipourl']))	{
       
       
       $tipourl        = $_GET['tipourl'];
       $url            = $_GET['url'];
       
       $gestion->FiltroFormulario( $tipourl, $url);
       
   }
 

 ?>


 
  
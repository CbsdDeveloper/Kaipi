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
   
                $this->obj     = 	new objects;
                $this->set     = 	new ItemsController;
             	$this->bd	   =	new Db;
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
                $this->ruc       =  $_SESSION['ruc_registro'];
                $this->sesion 	 =  trim($_SESSION['email']);
                $this->hoy 	     =  $this->bd->hoy();
                
            
                
				    
      }
     //---------------------------------------
     function Formulario( $id ){
         
         
 
        
        $datos = $this->bd->query_array('inv_movimiento','id_movimiento,fecha,fechaa,comprobante,autorizacion', 'id_movimiento='.$this->bd->sqlvalue_inyeccion($id,true));
        
 
        $datos['id_movimiento11'] = $datos['id_movimiento'] ; 
        
        $datos['fechae'] = $datos['fecha'] ;
        
        $datos['comprobantee'] = $datos['comprobante'] ;
        
        
        $this->obj->text->text('Transaccion','texto','id_movimiento11',10,10,$datos ,'','readonly','div-2-4') ;
        
        $this->obj->text->text('Comprobante','texto','comprobantee',10,10,$datos ,'','','div-2-4') ;
         
        $this->obj->text->text('Fecha','date','fechae',10,10,$datos ,'','','div-2-4') ;
        
        $this->obj->text->text('Aprobado','date','fechaa',10,10,$datos ,'','','div-2-4') ;
        
      
        
        
        $this->obj->text->text('Autorizacion','texto','autorizacion',47,47,$datos ,'','readonly','div-2-10') ;
        
        
 
      
   }
  
 }    
 
 
   $gestion   = 	new componente;
   
   $id    = $_GET['id'];
   
   
   $gestion->Formulario($id );
   
   
   
   //----------------------------------------------
   //----------------------------------------------
   
?>
  
<?php 
session_start( );   
    
    require '../../kconfig/Db.class.php';    
 	
    require '../../kconfig/Obj.conf.php';  
    
    require '../../kconfig/Set.php';  
  
    class componente{
 
       
 
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
                   
                $this->bd	   =	new  Db ;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  $this->bd->hoy();
        
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario(){
      
          
       $datos = array();
          
        
      	
      	$tipo = $this->bd->retorna_tipo();
     
 
      	$resultado = $this->bd->ejecutar("select idsede as codigo, nombre
                                            from activo.view_sede_user
                                            where  sesion=". $this->bd->sqlvalue_inyeccion( $this->sesion,true).' order by 2'
      	    );
      	
      	
      	
      	$this->obj->list->listadb($resultado,$tipo,'','vidsede',$datos,'','','div-0-12');
      	
       	
       
      	
      	$MATRIZ = array(
    	    'N'    => 'Acta NO Aprobada',
      	    'S'    => 'Acta Aprobada',
      	    'X'    => 'Acta Anulada',
      	);
      	$this->obj->list->lista('',$MATRIZ,'vestado',$datos,'','','div-0-12');
      	
      	
      	$datos['ffecha1'] =  date('Y-m-d', strtotime("-30 days"));
      	$datos['ffecha2'] =  date("Y-m-d");
      	
      	
      	
      	$this->obj->text->text(' ',"date",'ffecha1',15,15,$datos,'required','','div-0-12');
      	$this->obj->text->text(' ',"date",'ffecha2',15,15,$datos,'required','','div-0-12');
      	
      	
      
      }
     
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
  
 
   $gestion->FiltroFormulario( );

 ?>


 
  
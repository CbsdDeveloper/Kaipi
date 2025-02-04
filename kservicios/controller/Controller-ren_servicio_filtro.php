<?php 
    session_start( );   
    
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
    require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
  
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
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	new  Db ;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario(){
      
          
       $tipo = $this->bd->retorna_tipo();
          
        
       $datos = array();
       
       
      	$MATRIZ = array(
       		 'S'    => 'Servicio',
             'I'    => 'Impuesto',
             'T'    => 'Tasa'
      	);
      
 
      	
      	$this->obj->list->lista('Tipo',$MATRIZ,'tipo1',$datos,'','','div-1-3');
      
      
      	
      	$resultado =$this->bd->ejecutar("select '0' as codigo,' - Mostrar Todas -  ' as nombre union select idcategoria as codigo, nombre
            			                     from web_categoria 
                                             where tipo_categoria ='S'
                                            order by 1 ");
      	

      
      	$this->obj->list->listadb($resultado,$tipo,'Grupo','idcategoria1',$datos,'','','div-1-3');
      
 
      
      }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
  
 
   $gestion->FiltroFormulario( );

 ?>


 
  
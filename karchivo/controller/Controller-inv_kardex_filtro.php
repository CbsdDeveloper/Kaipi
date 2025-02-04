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
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
 
        
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase   bnaturaleza,bidciudad
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario(){
      
       $tipo = $this->bd->retorna_tipo();
          
        
       $anio       =  $_SESSION['anio'];
     
       $datos= array();
 
       
       $evento = '';
      	
      	$resultado =$this->bd->ejecutar("SELECT cuenta_inv as codigo ,cuenta_inv || ' ' || ncuenta_inv as nombre
                                            FROM  view_inv_movimiento_conta
                                            where anio = ".$this->bd->sqlvalue_inyeccion($anio,true)." 
                                            group by cuenta_inv ,ncuenta_inv 
                                            order by cuenta_inv");
      	
      	
      	
      	
       	
      	$this->obj->list->listadbe($resultado,$tipo,'Cuenta','idcategoria',$datos,'required','',$evento,'div-2-4');
      	
      
      	$this->obj->text->text_blue('Producto/Articulo','texto','idproducto',90,90, $datos ,'required','','div-2-4') ;
      	
       	
  
 
      }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
  
 
   $gestion->FiltroFormulario( );

 ?>


 
  
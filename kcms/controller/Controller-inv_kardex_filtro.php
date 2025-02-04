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
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
 
        
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase   bnaturaleza,bidciudad
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario(){
      
       $tipo = $this->bd->retorna_tipo();
          
          
       $anio = date("Y"); 
       
       
 
      	
      	$resultado =$this->bd->ejecutar("select idcategoria as codigo, nombre
            			                     from view_res_inv_CATE
                                            WHERE TIPO = 'I' and ANIO = ".$anio."  order by nombre ");
      	
      	
      	$evento = 'Onchange="Categoria(this.value);"';
      	
      	$this->obj->list->listadbe($resultado,$tipo,'Categoria','idcategoria',$datos,'required','',$evento,'div-3-9');
      	
      
      	
      	$resultado =$this->bd->ejecutar("select idproducto as codigo, producto as  nombre
            			                     from web_producto
                                            WHERE TIPO = 'X' order by producto ");
      	
      	$this->obj->list->listadb($resultado,$tipo,'Producto','idproducto',$datos,'required','','div-3-9');
 
 
      }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
  
 
   $gestion->FiltroFormulario( );

 ?>


 
  
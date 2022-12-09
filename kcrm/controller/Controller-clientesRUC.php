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
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
                $this->ruc       =  $_SESSION['ruc_registro'];
                $this->sesion 	 =  $_SESSION['email'];
                $this->hoy 	     =  $this->bd->hoy();
				
                $this->formulario = 'Model-clientes.php'; 
              	$this->evento_form = '../model/'.$this->formulario;        
      }
     //---------------------------------------
     function Formulario( ){
      
 
        
	
	$this->obj->text->text('Identificacion','texto','idprovRUC',10,15,$datos ,'','','div-2-4') ;
 
	
	$this->obj->text->text('Nacimiento','texto','fechaRUC',120,120,$datos ,'','','div-2-4') ;
	
	$this->obj->text->texto_oculto("razonRUC",$datos); 
	
	
 
	echo '<div class="col-md-2"> </div><div class="col-md-4" style="padding-top: 5px">
          <a href="#" onclick="javascript:BusquedaWSCiu();" class="btn btn-default">
            <span class="glyphicon glyphicon-refresh"></span> Consultar</a>
        </div>';
 
   }
  
  //----------------------------------------------
   function header_titulo($titulo){
          $this->set->header_titulo($titulo);
   }  
    
  
  
  //----------------------------------------------
 }    
   $gestion   = 	new componente;
   
   $gestion->Formulario( );
?>


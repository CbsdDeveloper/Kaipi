<?php 
    session_start( );   
    
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
    require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
  
    class componente{
 
      private $obj;
      private $bd;
      private $set;
      
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
      
                $this->sesion 	 =  $_SESSION['email'];
         
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase  
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario(){
      
        $datos = array();
           
        $evento = '';
          
      	$MATRIZ =  $this->obj->array->catalogo_activo();

        $tipo   = $this->bd->retorna_tipo();
      	
        $MATRIZ_N = array(
          'NN'    => 'Persona Natural',
          'NC'    => 'Persona Natural - Obligado a llevar contabilidad',
          'PJ'    => 'Persona Juridico ',
          'PE'    => 'Persona Juridico - Contribuyente Especial',
          'PP'    => 'Persona Juridico - Sector Publico'
      );

      $resultado =$this->bd->ejecutar("select 0 as codigo, '--  00. Todas las ciudades  ---' as nombre   union
                                      select idcatalogo as codigo, nombre
                                        from par_catalogo
                                        where tipo = 'canton' and publica = 'S' order by 2 ");


        $this->obj->list->listadb($resultado,$tipo,'','bidciudad',$datos,'required','','div-0-12'); // lista dinamica con busqueda de tablas de catalogo

        $this->obj->list->lista('',$MATRIZ_N,'bnaturaleza',$datos,'required','','div-0-12'); // lista estatica que dibuja una lista de valores
       	
        $this->obj->list->listae('',$MATRIZ,'bestado',$datos,'required','',$evento,'div-0-12');  // lista estatica que dibuja una lista de valores con evento
       	 
      	$this->obj->text->text_blue('Buscar Nombre',"texto",'crazon',15,15,$datos,'required','','div-0-12','Busqueda Nombre'); // casillero de texto 

        $this->obj->text->text_blue('Buscar Identificación',"texto",'cidprov',15,15,$datos,'required','','div-0-12','Busqueda Identificacion'); // casillero de texto 
      
      
      }
 ///------------------------------------------------------------------------
 }    

   $gestion   = 	new componente;
  
 
   $gestion->FiltroFormulario();

 ?>
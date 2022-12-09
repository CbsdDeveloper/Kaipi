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
      private $anio;
      
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function componente( ){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	     	new Db ;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
                $this->anio       =  $_SESSION['anio'];
                
    
       }
       //-----------------------------------------------------------------------------------------------------------
 
     function Formulario( ){
      
          
         $datos = array();
  
         $MATRIZ =  $this->obj->array->catalogo_activo();
          
         $tipo   = $this->bd->retorna_tipo();

         $resultado = $this->bd->ejecutar("select 0 as codigo , ' -- 00. Seleccione Rubro -- ' as nombre union 
         select idproducto_ser as codigo, producto as nombre
          from rentas.ren_servicios
          where estado =". $this->bd->sqlvalue_inyeccion('S',true).' order by 2 asc');


         $this->obj->text->text('Id',"number",'id_rubro_matriz',0,10,$datos,'','readonly','div-2-4') ;
        
         $this->obj->text->text_blue('Referencia',"number",'id_rubro1',0,10,$datos,'','readonly','div-2-4') ;
         
         $this->obj->list->listadb($resultado,$tipo,'Detalle','idproducto_ser',$datos,'required','','div-2-10');
         
         $this->obj->list->lista('Estado',$MATRIZ,'estado1',$datos,'required','','div-2-4');
         
         
         $this->obj->text->texto_oculto("action_servicios",$datos); 
 
  
 
      
   }
     //----------------------------------------------------......................-------------------------------------------------------------
  
   //----------------------------------------------
   function header_titulo($titulo){
 
         $this->set->header_titulo($titulo);
 
  }  
    //----------------------------------------------
     
 
 ///------------------------------------------------------------------------
///------------------------------------------------------------------------
  }
  ///------------------------------------------------------------------------
  ///------------------------------------------------------------------------
   
  
  $gestion   = 	new componente;
  
   
  $gestion->Formulario( );
  
 ?>
 
  
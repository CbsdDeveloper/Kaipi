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
                
                $this->hoy 	     =  $this->bd->hoy();
        
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario(){
      
      
          
      	$datos['fecha1'] =  date('Y-m-d', strtotime('-1 month'));
      	$datos['fecha2'] =  date("Y-m-d");
      	$tipo = $this->bd->retorna_tipo();
      	
      	$this->obj->text->text('Inicio','date','fecha1',10,15,$datos ,'required','','div-2-4') ;
      	$this->obj->text->text('Hasta','date','fecha2',10,15,$datos ,'required','','div-2-4') ;
      	
      	$resultado = $this->bd->ejecutar("select idbodega as codigo, nombre
                                            from view_bodega_permiso
                                            where registro =". $this->bd->sqlvalue_inyeccion($this->ruc,true)." and
                                                   sesion=". $this->bd->sqlvalue_inyeccion($this->sesion,true)
      	    );
      	
      	
      	$this->obj->list->listadb($resultado,$tipo,'Bodega','idbodega1',$datos,'','','div-2-4');
      	
      	
      	
      	$MATRIZ = $this->obj->array->inven_tipo();
      	$this->obj->list->lista('Tipo',$MATRIZ,'tipo1',$datos,'','','div-2-4');
      	
      	
      	$MATRIZ =  $this->obj->array->catalogo_co_asientos();
       	$this->obj->list->lista('Estado',$MATRIZ,'estado1',$datos,'','','div-2-4');
      
       

 
      
      
      }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
  
 
   $gestion->FiltroFormulario( );

 ?>


 
  
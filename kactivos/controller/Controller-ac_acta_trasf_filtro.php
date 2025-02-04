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
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  $this->bd->hoy();
        
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario(){
      
          
       $datos = array();
          
        
      	
      	$tipo = $this->bd->retorna_tipo();
     
 
     
      	$resultado = $this->bd->ejecutar("select 0 as codigo, ' [  0. Seleccione ubicacion ]' as nombre  union
                                         select idsede as codigo, nombre
                                            from activo.view_sede_user
                                            where  sesion=". $this->bd->sqlvalue_inyeccion( $this->sesion,true).' order by 2'
      	    );
      	
      	
      	$evento = ' OnChange="BuscaCustodio(this.value,0)" ';
      	
      	$this->obj->list->listadbe($resultado,$tipo,'','vidsede',$datos,'','',$evento,'div-0-12');
      	
       	
     /* 	
      	
      	$resultado = $this->bd->ejecutar("select 0 as codigo, ' [ 0. Seleccione la unidad ] ' as nombre  union
                                          select id_departamento as codigo, unidad as nombre
                                            from activo.view_resumen_custodios
                                            group by id_departamento,unidad order by 2 asc"
      	    );
      	
      	*/
      	$evento = ' OnChange="BuscaCustodio(this.value,1)" ';
      	
      	$this->obj->list->listadbe($resultado,$tipo,'Unidad','Vid_departamento',$datos,'','',$evento,'div-0-12');
      	
      	
        $this->obj->text->text_yellow('Digite nombre funcionario',"texto",'vrazon',40,45,$datos,'','','div-0-12');
      	
     // 	$this->obj->list->listadb($resultado,$tipo,'Custodio','Vidprov',$datos,'','','div-0-4');
      	
       
      	$this->obj->text->texto_oculto("Vidprov",$datos); 
       
      	
      }
     
      
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
  
 
   $gestion->FiltroFormulario( );

 ?>


 
  
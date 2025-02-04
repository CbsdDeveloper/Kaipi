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
                   
                $this->bd	   =	     	new Db ;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
       }
 
      //---------------------------------------
      
     function Formulario( ){
      
 
         $anio       =  $_SESSION['anio'];
 
        $datos = array();
 
        $tipo = $this->bd->retorna_tipo();
        
        $resultado = $this->bd->ejecutar("SELECT cuenta as codigo, detalle as nombre
          											FROM co_plan_ctas
          											where tipo_cuenta = 'B' and 
                                                           univel = 'S' and 
                                                           anio =".$this->bd->sqlvalue_inyeccion($anio , true). " order by 1"  );
        
        $this->obj->list->listadb($resultado,$tipo,'Banco-Caja','cuentaa',$datos,'required','','div-3-9');  
 
        
        $resultado = $this->bd->ejecutar("SELECT partida as codigo,  partida ||' '|| detalle as nombre
          											FROM presupuesto.pre_gestion
          											where tipo = 'I' and
                                                           partida like '37%' and
                                                           anio =".$this->bd->sqlvalue_inyeccion($anio , true). " order by 1"  );
        
        $this->obj->list->listadb($resultado,$tipo,'Partida Enlace','partidaa',$datos,'required','','div-3-9');  
        
        
       $this->obj->text->text_yellow('Monto',"number",'montoa',0,999999999999,$datos,'required','','div-3-9') ;
 
      
      
   }
  
  }
  ///------------------------------------------------------------------------
  ///------------------------------------------------------------------------
   
  
  $gestion   = 	new componente;
  
   
  $gestion->Formulario( );
  
 ?>
 
  
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
                   
                $this->bd	   =	new  Db ;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  date("Y-m-d");
        
                $this->anio       =  $_SESSION['anio'];
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario(){
      
        $datos = array();
       
        $tipo = $this->bd->retorna_tipo();
 
        $this->obj->text->text('Partida',"texto",'fpartida',0,9999999,$datos,'required','readonly','div-3-9') ;
       	
       	
        $this->obj->text->text_yellow('Detalle','texto','ddetalle',250,250,$datos ,'required','','div-3-9') ;
        
        
      	$this->obj->text->text_blue('Monto Inicial','texto','monto_inicial_dato',30,30,$datos ,'required','','div-3-3') ;
      	
       	 
      	$this->obj->text->text('Tipo',"texto",'ftipo',10,10,$datos,'required','readonly','div-3-3') ;
 
        $this->set->div_label(12,'(*) Registro de verificacion de Orientador de Gasto');	 


        $resultado = $this->bd->ejecutar("select '-' as codigo , ' ---  00. No Aplica --- ' as nombre union
                            SELECT   codigo,  codigo || ' ' || detalle as nombre
                    FROM presupuesto.pre_catalogo
                            where   categoria = ".$this->bd->sqlvalue_inyeccion('orientador' ,true)." 
                              ORDER BY 2");

          $this->obj->list->listadb($resultado,$tipo,'Orientador de Gasto','orientador',$datos,'required','','div-3-6');

  
      
      }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
  
 
   $gestion->FiltroFormulario( );

 ?>


 
  
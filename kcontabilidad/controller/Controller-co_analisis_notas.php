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
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =     date("Y-m-d");  
        
                $this->anio       =  $_SESSION['anio'];
                
    
       }
 
      //---------------------------------------
      
     function Formulario( ){
      
          $datos = array();
         
 
                
                
                $resultado = $this->bd->ejecutar("select id_periodo as codigo, (mesc || '-' || anio)  as nombre
                    							       from co_periodo
                    							      where  anio = ".$this->bd->sqlvalue_inyeccion($this->anio, true)." and
                                                            registro=".$this->bd->sqlvalue_inyeccion($this->ruc, true).'
                                                    order by 1 desc');
                
                $tipo = $this->bd->retorna_tipo();
                 
                
                $this->obj->list->listadb($resultado,$tipo,'Periodo','id_periodo',$datos,'','','div-2-10');
                
                
                $MATRIZ = array(
                    'BALANCE DE COMPROBACION'    => 'BALANCE DE COMPROBACION',
                    'ESTADO DE SITUACION FINANCIERA'    => 'ESTADO DE SITUACION FINANCIERA',
                    'ESTADO DE RESULTADOS'    => 'ESTADO DE RESULTADOS',
                    'FLUJO DEL EFECTIVO'    => 'FLUJO DEL EFECTIVO',
                    'EJECUCION PRESUPUESTARIA'    => 'EJECUCION PRESUPUESTARIA' 
                );
                
                $this->obj->list->lista('Tipo Nota',$MATRIZ,'tipo_nota',$datos,'required','','div-2-10');
                
                
                $this->obj->text->text('Referencia',"texto",'asunto_nota',250,250,$datos,'required','','div-2-10');
      
                
                $this->obj->text->editor('Nota','notas',7,120,300,$datos,'required','','div-2-10') ;
 
                
           
         $this->obj->text->texto_oculto("idnota",$datos); 
         
  
  
      
   }
 
  
///------------------------------------------------------------------------
///------------------------------------------------------------------------
  }
 ///------------------------------------------------------------------------
 ///------------------------------------------------------------------------
  
  $gestion   = 	new componente;
   
  $gestion->Formulario( );
  
 ?>
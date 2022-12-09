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
          
          $datos['ffecha1'] = $this->bd->_primer_dia($this->hoy);
          
          $datos['ffecha2'] = $this->bd->_actual_dia($this->hoy);
          
          
          $this->obj->text->text(' Inicio',"date",'ffecha1',15,15,$datos,'required','','div-0-2');
          $this->obj->text->text(' Final',"date",'ffecha2',15,15,$datos,'required','','div-0-2');
          
          $MATRIZ = array(
              '-'    => ' [ Todos los tramites ]',
              'abierto' => 'Abierto',
              'contestado' => 'Contestado',
              'solucionado'    => 'Solucionado',
              'cerrado'    => 'Cerrado',
           );
          
          $this->obj->list->lista('',$MATRIZ,'fmodulo',$datos,'','','div-0-2');
          
          
          $sql ="select '-' as codigo, '[  Todos las Tecnico  ]' as nombre union
                SELECT   sesionm  as codigo, tecnico as nombre
                FROM flow.view_itil_unidad
                group by   sesionm, tecnico  order by 2";
          
          $resultado = $this->bd->ejecutar($sql);
          $this->obj->list->listadbe($resultado,$tipo,'','vtecnico',$datos,'','','','div-0-3');
          
 
      	
 
          $sql ="select '0' as codigo, '[  Todos las Unidades  ]' as nombre union
                SELECT   id_departamento  as codigo, unidad as nombre
                FROM flow.view_itil_unidad
                group by   id_departamento, unidad  order by 2";
  
          $resultado = $this->bd->ejecutar($sql);
          $this->obj->list->listadbe($resultado,$tipo,'','vunidad',$datos,'','','','div-0-3');

          
      
      }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
  
 
   $gestion->FiltroFormulario( );

 ?>


 
  
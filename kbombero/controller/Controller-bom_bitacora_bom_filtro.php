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
                
                $this->hoy 	     =  date('Y-m-d');
        
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario(){
      
      	
        $datos = array();
      	
        $tipo       = $this->bd->retorna_tipo();
        
        $datos_usuario = $this->bd->__user($this->sesion);
        
        $id_departamento = $datos_usuario['id_departamento'];
        
        $datos['ffecha1'] = $this->bd->_primer_dia($this->hoy);
        
        $datos['ffecha2'] = $this->bd->_actual_dia($this->hoy);
        
        
        $this->obj->text->text(' Inicio',"date",'ffecha1',15,15,$datos,'required','','div-0-3');
        $this->obj->text->text(' Final',"date",'ffecha2',15,15,$datos,'required','','div-0-3');
 
 
        $sql = " SELECT  id_departamento as codigo, upper(nombre) as nombre
        FROM nom_departamento
        where estado ='S' and id_departamento = ".$this->bd->sqlvalue_inyeccion($id_departamento,true)."
        order by 2 " ;
        

        
        $resultadod  =  $this->bd->ejecutar($sql);
        
        $this->obj->list->listadb($resultadod,$tipo,'<b>Estacion</b>','vid_departamento',$datos,'required','readonly','div-1-5');	
      
      
      }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
  
 
   $gestion->FiltroFormulario( );

 ?>

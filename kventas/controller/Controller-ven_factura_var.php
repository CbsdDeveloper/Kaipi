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
   
                $this->obj     = 	new objects;
                $this->set     = 	new ItemsController;
             	$this->bd	   =	new Db;
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
                $this->ruc       =  $_SESSION['ruc_registro'];
                $this->sesion 	 =  $_SESSION['email'];
                $this->hoy 	     =  $this->bd->hoy();
                
       }
     //---------------------------------------
     function Formulario( ){
       
         
        $datos = array();

         
        $tipo = $this->bd->retorna_tipo();
        
         
        $resultado = $this->bd->ejecutar("select 0 as codigo, 'Seleccione las variables' as nombre union
                                        select idcategoria as codigo, nombre
                                            from web_categoria
                                            where registro =". $this->bd->sqlvalue_inyeccion($this->ruc,true)." and
                                                   variable <>". $this->bd->sqlvalue_inyeccion('-',true)
            );
        
               
        
        $evento2 =' OnChange="AsignaVariables(this.value);"';
        
        $this->obj->list->listadbe($resultado,$tipo,'Agregar parametros','idcategoria',$datos,'','',$evento2,'div-3-9');
        
         
        $this->set->div_label(12,'Parametros Adicionales');	 
        
        
        echo ' <div class="col-md-12"><div id="variable_seleccion"></div>
             </div>  ';
        
      
                        
           
      
   }
 //----------------------------------------------
  
  //----------------------------------------------
 }    
   $gestion   = 	new componente;
   
   $gestion->Formulario( );
   
   //----------------------------------------------
   //----------------------------------------------
   
?>
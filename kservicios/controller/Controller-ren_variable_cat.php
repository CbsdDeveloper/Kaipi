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
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =     date("Y-m-d");    
  
                $this->anio       =  $_SESSION['anio'];
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario(){
      
          
       $tipo = $this->bd->retorna_tipo();
       
       $datos = array();
       
       
       $sql = "SELECT '0' as codigo, ' [  0. CATALOGOS DISPONIBLES ] ' as nombre UNION
                        SELECT  idcatalogo as codigo, tipo || '- ' ||  trim(nombre) as nombre
                        FROM par_catalogo where modulo = 'S'
                         order by 2 " ;
       
       $resultado =  $this->bd->ejecutar($sql);
       $this->obj->list->listadb($resultado,$tipo,'Tipo Catalogo 1','idcatalogo1',$datos,'required','','div-3-9');
       
       
       $resultado =  $this->bd->ejecutar($sql);
       $this->obj->list->listadb($resultado,$tipo,'Tipo Catalogo 2','idcatalogo2',$datos,'required','','div-3-9');
       
       
       $resultado =  $this->bd->ejecutar($sql);
       $this->obj->list->listadb($resultado,$tipo,'Tipo Catalogo 3','idcatalogo3',$datos,'required','','div-3-9');
       
       $evento = '';
       $this->obj->text->texte('Valor ',"number",'valor',0,30,$datos,'required','',$evento,'div-3-9') ; 
       
      
       $this->obj->text->texto_oculto("action_cata",$datos); 
       
       $this->obj->text->texto_oculto("id_matriz_cat",$datos); 
       
      
        
      }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
  
 
   $gestion->FiltroFormulario( );

 ?>


 
  
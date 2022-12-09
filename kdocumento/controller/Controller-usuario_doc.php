<?php 
    session_start( );   
    
    require '../../kconfig/Db.class.php';   
 	
    require '../../kconfig/Obj.conf.php';  
    
    require '../../kconfig/Set.php'; 
  
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
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  $this->bd->hoy();
        
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario( $idcaso ){
      
          $datos       = array();

          $tipo 		= $this->bd->retorna_tipo();

          $datos = $this->bd->__user($this->sesion);

          $this->set->div_htitulo(4,$datos['unidad'],'S');


          $datos['codigo_tramite'] = $idcaso ;
          

          $id_departamento =  $datos['id_departamento'];
          $orden           =  $datos['orden'];

          $jerarquia        =  strlen($orden);

          if (  $jerarquia  == 2){
              $orden = substr($orden,0,1);
          }

          $this->set->div_label(12,'<b>Enviar documento a: </b>');

          $sql = "SELECT  '-' as codigo, '-- 0. Reasignar tramite --' as nombre union
          SELECT   email as codigo,
                   completo || ' - ' || cargo as nombre
           FROM  view_nomina_user
           WHERE  estado= 'S'  and   
                  orden  like ".$this->bd->sqlvalue_inyeccion(  $orden.'%'  ,true).'  and 
                  cargo is not null
                 ORDER BY 2'   ;
 
              

          $resultado = $this->bd->ejecutar($sql);

          $this->obj->list->listadbe($resultado,$tipo,'Asignar a','sesion_dato',$datos,'required','',$evento,'div-0-12');



          $this->obj->text->texto_oculto("codigo_tramite",$datos);
          
          
      }
      
     //-------------------------- 
       
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
  
   if (isset($_GET['idcaso']))	{
       
        
       $id      = $_GET['idcaso'];
       
      
       
       $gestion->FiltroFormulario( $id );
       
   }

 ?>


 
  
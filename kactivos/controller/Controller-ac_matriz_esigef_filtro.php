<?php 
    session_start( );   
    
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
    require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
  
    class componente{
 
      private $obj;
      private $bd;
      private $set;
      
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
      
                $this->sesion 	 =  $_SESSION['email'];
         
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase  
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario(){
      
        $datos = array();
           
        $evento = '';
          
        $tipo   = $this->bd->retorna_tipo();
		  
        $resultado = $this->sql(1);

        $this->obj->list->listadbe($resultado,$tipo,'Cuenta','bcuenta',$datos,'required','',$evento,'div-3-9');

        $resultado = $this->sql(2);
       
        $this->obj->list->listadbe($resultado,$tipo,'Item','bitem',$datos,'required','',$evento,'div-3-9');

        $this->obj->text->text_yellow('Clase',"texto",'bclase',15,15,$datos,'required','','div-3-9');

      
        $this->obj->text->text_blue('Detalle',"texto",'bdetalle',15,15,$datos,'required','','div-3-9');

      
      
      }
 ///------------------------------------------------------------------------
    function sql($titulo){
          
      if  ($titulo == 1){ 
        
          $sqlb = "Select '-' as codigo, '[ 01. Seleccione Cuenta Contable ]' as nombre   
                    union
                    SELECT  cuenta as codigo,  cuenta  as nombre
                    FROM  activo.ac_matriz_esigef 
                    group by cuenta
                    order by 1";
          
    }
 

    if  ($titulo == 2){
        
      $sqlb = "Select '-' as codigo, '[ 01. Seleccione Item Presupuestario ]' as nombre   
      union
      SELECT  item as codigo,  item  as nombre
      FROM  activo.ac_matriz_esigef 
      group by item
      order by 1";
      

      
    }



    $resultado = $this->bd->ejecutar($sqlb);


    return  $resultado;

    }  
 }    

   $gestion   = 	new componente;
  
 
   $gestion->FiltroFormulario();

 ?>
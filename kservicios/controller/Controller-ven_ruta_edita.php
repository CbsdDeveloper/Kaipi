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
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->sesion 	 =  $_SESSION['email'];
         
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase  
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario( $id  ){


        $xx = $this->bd->query_array('rentas.ren_fre_mov',   // TABLA
        '*',                        // CAMPOS
        'id_ren_movimiento ='.$this->bd->sqlvalue_inyeccion( $id  ,true));
        
 
       

        $datos['id_fre_mov'] = $xx['id_fre_mov'];
        $datos['num_carro']  = $xx['num_carro'];
        $datos['num_placa']  = $xx['num_placa'];
        $datos['hora']  = $xx['hora'];



        $this->obj->text->text_yellow('Unidad','texto','num_carro',10,110,$datos ,'required','','div-2-10') ;

        $this->obj->text->text_blue('Frecuencia','time','num_placa',10,110,$datos ,'required','readonly','div-2-10') ;


        $this->obj->text->text('Salida','time','hora',10,110,$datos ,'required','','div-2-10') ;


        $this->obj->text->texto_oculto("id_fre_mov",$datos); 

     
 
 
      }
 ///------------------------------------------------------------------------
 }    

   $gestion   = 	new componente;
 
   $id	            =	$_GET["id"];
 

   $gestion->FiltroFormulario( $id );
 

 ?>
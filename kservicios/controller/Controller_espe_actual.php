<?php 
 session_start( );   
    
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
    require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
  
    class Controller_espe_actual{
 
  
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
      function Controller_espe_actual( ){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	new  Db ;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
 
        
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase   bnaturaleza,bidciudad
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario( $fecha_aprobacion,$comprobante,$id_ren_movimiento ,$idproducto_ser ){
      
           
      $datos = array();
      
      $datos['id_ren_movimiento_a'] = $id_ren_movimiento;
      $datos['fecha_a'] = $fecha_aprobacion;
      $datos['comprobante_a'] = $comprobante;
      
      $xxx = $this->bd->query_array('rentas.ren_movimiento',   // TABLA
          '*',                        // CAMPOS
          'id_ren_movimiento='.$this->bd->sqlvalue_inyeccion($id_ren_movimiento,true) // CONDICION
          );
      
      $seq = $this->bd->query_array('rentas.ren_serie_espe',   // TABLA
          'actual',                        // CAMPOS
          "estado= 'S' and idproducto_ser =".$this->bd->sqlvalue_inyeccion($idproducto_ser,true) // CONDICION
          );
      
      $datos['hasta_a']     = $xxx['secuencial'];
      
      $datos['secuencia_a'] = $seq['actual'];
      
     $datos['cantidad_a'] =   $xxx['base0']   ;
   
    
      
      $this->obj->text->text('Nro.Referencia',"texto" ,'id_ren_movimiento_a' ,10,10, $datos ,'required','readonly','div-2-4') ;   
      $this->obj->text->text_yellow('Fecha',"date" ,'fecha_a' ,10,10, $datos ,'required','','div-2-4') ;   
      $this->obj->text->text_blue('Nro.Especie',"texto" ,'comprobante_a' ,10,10, $datos ,'required','','div-8-4') ;   
      $this->obj->text->text('Hasta',"texto" ,'hasta_a' ,10,10, $datos ,'required','','div-8-4') ;   
      
      $this->obj->text->text('Cantidad',"texto" ,'cantidad_a' ,10,10, $datos ,'required','readonly','div-8-4') ;   
      
      
      $this->set->div_label(12,'Secuencia actual ');	 
 
      $this->obj->text->text_blue('Nro.Secuencia',"texto" ,'secuencia_a' ,10,10, $datos ,'required','','div-8-4') ;   
      
    
      
      }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new Controller_espe_actual;
   
   $fecha_aprobacion      = $_GET['fecha_aprobacion'];
   $comprobante           = $_GET['comprobante'];
   $id_ren_movimiento     = $_GET['id_ren_movimiento'];
   $idproducto_ser        = $_GET['idproducto_ser'];
 
   
   $gestion->FiltroFormulario($fecha_aprobacion,$comprobante,$id_ren_movimiento,$idproducto_ser );

 ?>


 
  
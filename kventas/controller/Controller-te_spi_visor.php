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
            	$this->bd	   =	new Db;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
                $this->ruc       =  $_SESSION['ruc_registro'];
                $this->sesion 	 =  $_SESSION['email'];
                 
                   
      }
      
      //---------------------------------------
      function Formulario(  $spi,$id,$fcuenta,$idprov ){
      
 
 
          $datos = array(); 
          
          $x = $this->bd->query_array('co_asiento_aux',    
              '*',              
              'id_asiento='.$this->bd->sqlvalue_inyeccion($id,true) .' and 
               cuenta='.$this->bd->sqlvalue_inyeccion($fcuenta,true).' and
               idprov='.$this->bd->sqlvalue_inyeccion(trim($idprov),true)
              );
          
                    $datos['id_asiento_aux_spi'] = $x['id_asiento_aux'];
                    $datos['idprov_spi']         = $x['idprov'];
                    $datos['spi_dato']           = trim($spi);
                    $datos['comprobante_spi']    = trim($x['comprobante']);
                    $datos['tipo_spi']           = trim($x['tipo']);
                    
                    $datos['fecha_o']              = $x['fecha'] ;
                    
                
                	$this->obj->text->text('Id','number','id_asiento_aux_spi',10,10, $datos ,'','readonly','div-2-10') ;
                	
                	$this->obj->text->text('Identificacion','texto','idprov_spi',90,90, $datos ,'required','readonly','div-2-10') ;
                	
                	
                	$this->obj->text->text('Fecha',"date" ,'fecha_o' ,80,80, $datos ,'required','','div-2-10') ;
                	
                	
                	$this->obj->text->text('Comprobante','texto','comprobante_spi',13,13, $datos ,'required','','div-2-10') ;
                	
                	
                	$MATRIZ =  $this->obj->array->catalogo_sino();
                	
                	$this->obj->list->lista('SPI',$MATRIZ,'spi_dato',$datos,'required','','div-2-10');
                	
               
                	$MATRIZ =   $this->obj->array->catalogo_tipo_tpago();
                	$evento =   '';
                	$this->obj->list->listae('Forma pago',$MATRIZ,'tipo_spi',$datos,'required','',$evento,'div-2-10');
                	
  
  
      
   }
   
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
 
    
   
   $spi     = $_GET['spi'];  
   $id      = $_GET['id'];  
   $fcuenta = $_GET['fcuenta']; 
   $idprov  = $_GET['idprov']; 
   
   $gestion->Formulario( $spi,$id,$fcuenta,$idprov);

 ?>


 
  
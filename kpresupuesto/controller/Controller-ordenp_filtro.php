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
      
      private $anio;
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function componente( ){
          
 
                $this->obj     = 	new objects;
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	new  Db ;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  date("Y-m-d");
                
                
                $this->anio       =  $_SESSION['anio'];
        
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario(){
      
         $datos = array();
           
         $datos['ffecha1'] = $this->bd->_primer_dia($this->hoy);
         
         $datos['ffecha2'] = $this->bd->_actual_dia($this->hoy);
           
       	
      	$this->obj->text->text(' Inicio',"date",'ffecha1',15,15,$datos,'required','','div-1-3');
      	$this->obj->text->text(' Final',"date",'ffecha2',15,15,$datos,'required','','div-1-3');
      	
      	$MATRIZ = array(
      	    'cxpagar' => 'Cuentas por Pagar',
       		'cxcobrar'    => 'Cuentas por Cobrar',
      	    'nomina'    => 'Nomina',
      	    'contabilidad'    => 'Contabilidad',
      	    'bancos'    => 'bancos'
      	);
      
      	$this->obj->list->lista('Modulo',$MATRIZ,'fmodulo',$datos,'','','div-1-3');
      
  
        $this->obj->text->text_blue('Nro.Tramite',"number",'fid_tramite',0,10,$datos,'','','div-1-3') ;

        $datos['festado'] =  'aprobado'   ;
        $this->obj->text->texto_oculto("festado",$datos); 


        $this->obj->text->text_blue('Nro.Asiento',"number",'fid_asiento',0,10,$datos,'','','div-1-3') ;


     
      }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
  
 
   $gestion->FiltroFormulario( );

 ?>


 
  
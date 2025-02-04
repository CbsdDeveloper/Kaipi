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
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario(){
      
          $month = date('m');
          $year = date('Y');
           
           $datos['ffecha1'] =   date('Y-m-d', mktime(0,0,0, $month, 1, $year));
      	
      	   $datos['ffecha2'] =  date("Y-m-d");
      	
      	   $tipo = $this->bd->retorna_tipo();
      	   
      	   
      	$this->obj->text->text('Inicio',"date",'ffecha1',15,15,$datos,'required','','div-2-10');
      	
      	$this->obj->text->text('Final',"date",'ffecha2',15,15,$datos,'required','','div-2-10');
      	
      	
      	$sql = "select a.cuenta as codigo, a.cuenta || ' ' || b.detalle as nombre 
				       from co_diario a , co_plan_ctas b
                      where    a.registro =  b.registro and
                                     a.cuenta = b.cuenta and
                                     tipo_cuenta = 'B' and
                                     a.registro = ".$this->bd->sqlvalue_inyeccion($this->ruc, true).'
                      group by a.cuenta, b.detalle
                      order by 1';
      	
      	$resultado = $this->bd->ejecutar($sql);
   
      	
      	
      	$this->obj->list->listadb($resultado,$tipo,'Bancos','idbancos',$datos,'required','','div-2-10');
 
      
      }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
  
 
   $gestion->FiltroFormulario( );

 ?>
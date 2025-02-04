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
                
                    
                $this->bd	   =	new  Db ;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                 
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  date("Y-m-d");
        
                $this->anio       =  $_SESSION['anio'];
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario(){
      
          $datos['ffecha1'] = $this->bd->_primer_dia($this->hoy);
          
          $datos['ffecha2'] = $this->bd->_actual_dia($this->hoy);
          
      	
      	$this->obj->text->text_yellow('',"date",'ffecha1',15,15,$datos,'required','','div-0-2');
      	
      	$this->obj->text->text_yellow('',"date",'ffecha2',15,15,$datos,'required','','div-0-2');
      	
      	$MATRIZ = array(
       		 'N'    => 'Pendiente',
      		'S'    => 'Aprobado',
      	);
      
      	$this->obj->list->lista('',$MATRIZ,'festado',$datos,'','','div-0-3');
      
 
      	$sql = "select a.cuenta as codigo, a.cuenta || ' ' || b.detalle as nombre
				       from co_diario a , co_plan_ctas b
                      where    a.registro =  b.registro and
                                     a.cuenta = b.cuenta and
                                      b.anio =  ".$this->bd->sqlvalue_inyeccion($this->anio  , true)." and 
                                     tipo_cuenta = 'B' and
                                     a.registro = ".$this->bd->sqlvalue_inyeccion($this->ruc, true).'
                      group by a.cuenta, b.detalle
                      order by 1';
      	
      	
      
      	$resultado = $this->bd->ejecutar($sql);
      	
      	$tipo = $this->bd->retorna_tipo();
      	
      	$this->obj->list->listadb($resultado,$tipo,'','idbancos',$datos,'required','','div-0-5');
      
      }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
  
 
   $gestion->FiltroFormulario( );

 ?>


 
  
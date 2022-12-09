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
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                 
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  date("Y-m-d");
        
                $this->anio       =  $_SESSION['anio'];
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario(){
      
           
          $datos['ffecha2'] = $this->bd->_actual_dia($this->hoy);
          
      	
      	$this->obj->text->text_yellow('Fecha Pago',"date",'ffecha2',15,15,$datos,'required','','div-3-9');
      	
		  /*
 
      	$sql = "select a.cuenta as codigo, a.cuenta || ' ' || b.detalle as nombre
				       from co_diario a , co_plan_ctas b
                      where    a.registro =  b.registro and
                                     a.cuenta = b.cuenta and
                                      b.anio =  ".$this->bd->sqlvalue_inyeccion($this->anio  , true)." and 
                                     tipo_cuenta = 'B' and
                                     a.registro = ".$this->bd->sqlvalue_inyeccion($this->ruc, true).'
                      group by a.cuenta, b.detalle
                      order by 1';
      	
      	*/
		  
		   	$sql = "select b.cuenta as codigo, b.cuenta || ' ' || b.detalle as nombre
				       from  co_plan_ctas b
                      where  b.anio =  ".$this->bd->sqlvalue_inyeccion($this->anio  , true)." and 
                                     b.tipo_cuenta = 'B' and b.univel = 'S' and b.estado = 'S' and 
                                     b.registro = ".$this->bd->sqlvalue_inyeccion($this->ruc, true).'
                      group by b.cuenta, b.detalle
                      order by 1';
      
      	$resultado = $this->bd->ejecutar($sql);
      	
      	$tipo = $this->bd->retorna_tipo();
      	
      	$this->obj->list->listadb($resultado,$tipo,'Banco Pago','idbancos',$datos,'required','','div-3-9');
      	
      
 
      }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
  
 
   $gestion->FiltroFormulario( );

 ?>


 
  
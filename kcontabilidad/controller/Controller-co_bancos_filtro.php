<?php 
session_start( );   
    
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
    require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
  
    class componente{
 
      //creamos la variable donde se instanciar? la clase "mysql"
 
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
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario(){
      
        $datos = array();
      	
      	$month = date('m');
      	$year = date('Y');
      	
      	$datos['ffecha1'] =   date('Y-m-d', mktime(0,0,0, $month, 1, $year));
      	
      	$month = date('m');
      	$year = date('Y');
      	$day = date("d", mktime(0,0,0, $month+1, 0, $year));
      	
      	$datos['ffecha2'] =   date('Y-m-d', mktime(0,0,0, $month, $day, $year));
      	
       	
      	
      	$this->obj->text->text('Inicio',"date",'ffecha1',15,15,$datos,'required','','div-2-10');
      	
      	$this->obj->text->text('Final',"date",'ffecha2',15,15,$datos,'required','','div-2-10');
      	
      	
      	$sql = "select b.cuenta as codigo, b.cuenta || ' ' || b.detalle as nombre
				       from   co_plan_ctas b
                      where  b.tipo_cuenta = 'B' and b.univel = 'S' and 
                             b.anio = ".$this->bd->sqlvalue_inyeccion($year, true)." 
                             b.registro = ".$this->bd->sqlvalue_inyeccion($this->ruc, true).'
                      order by 1';
      	
      	$resultado = $this->bd->ejecutar($sql);
      	
      	$tipo = $this->bd->retorna_tipo();
      	
      	$this->obj->list->listadb($resultado,$tipo,'Bancos','idbancos',$datos,'required','','div-2-10');
      	
      	$MATRIZ = array(
      	    'digitado'    => 'Digitado',
       		 'aprobado'    => 'Aprobado'
      	);
      
      	$this->obj->list->lista('Estado',$MATRIZ,'festado',$datos,'','','div-2-10');
      
      
      
      }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
  
 
   $gestion->FiltroFormulario( );

 ?>


 
  
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
                 $this->obj     = 	   new objects;
                 $this->set     = 		    new ItemsController;
                 $this->bd	   =	     	new Db ;
                 $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
                 $this->ruc       =  $_SESSION['ruc_registro'];
                 $this->sesion 	 =  $_SESSION['email'];
                 $this->hoy 	     =  $this->bd->hoy();
      }
      
      function Formulario($id_asiento,$monto){
    
       $tipo =  $this->bd->retorna_tipo();
       
       $datos = array();
  
       	
      	$resultado =  $this->bd->ejecutar("select '-' as codigo, 'Seleccione cuenta' as nombre union
                                      	select a.cuenta codigo, a.cuenta  || ' ' || b.detalle as nombre
                                      	from co_asientod a, co_plan_ctas b
                                      	where a.id_asiento =". $this->bd->sqlvalue_inyeccion($id_asiento ,true)." and 
                                              a.cuenta like '2%'  and
                                      	a.cuenta = b.cuenta and a.anio::character varying::text = b.anio
                                      	group by a.cuenta, b.detalle
                                      	order by 1");
      	
      	 
         $this->obj->list->listadb($resultado,$tipo,'Cuenta','cuentaa',$datos,'required','','div-2-10');	 
      	
      	 
         $resultado =  $this->bd->ejecutar("select '-' as codigo, 'Seleccione partida' as nombre union
                                      	select a.partida codigo, a.partida  || ' ' || b.detalle as nombre
                                      	from co_asientod a, presupuesto.pre_gestion b
                                      	where a.id_asiento =". $this->bd->sqlvalue_inyeccion($id_asiento ,true)." and
                                            a.partida = b.partida and a.anio::character varying::text = b.anio
                                      	group by a.partida, b.detalle
                                      	order by 1");
         
      
         
         $this->obj->list->listadb($resultado,$tipo,'Partida','partidaa',$datos,'required','','div-2-10');
         
         
         
         $datos['montoa'] = $monto ;
         
         $this->obj->text->text('Anticipo',"number",'montoa',0,10,$datos,'required','readonly','div-2-4') ;
 		 
    }
  
  }
  ///------------------------------------------------------------------------
  ///------------------------------------------------------------------------
 
 
           $id_asiento     = $_GET['id_asiento'] ;
           
 	       $monto          = $_GET['monto'] ;
 	
 		   $gestion        = 	new componente;
   
 		   $gestion->Formulario($id_asiento,$monto);
  
     ?>			 						  
 
    
  
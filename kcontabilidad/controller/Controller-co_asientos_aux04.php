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
      private $anio;
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
                 
                 $this->anio       =  $_SESSION['anio'];
      }
      
      function Formulariog($id_asiento,$cuenta,$idasientod,$id_tramite){
    
       $tipo =  $this->bd->retorna_tipo();
       
       $datos = array();
  
       
       	
      	$resultado =  $this->bd->ejecutar("select '-' as codigo, '- 0. Seleccione partida - ' as nombre union
                                      	select partida as codigo, partida  || ' ' || detalle_cuenta as nombre
                                      	from presupuesto.view_pre_gestion_enlace
                                      	where id_tramite =". $this->bd->sqlvalue_inyeccion($id_tramite ,true)." and 
                                              cuenta =". $this->bd->sqlvalue_inyeccion($cuenta ,true) );
      	
      	 
         $this->obj->list->listadb($resultado,$tipo,'Enlace','partida_enlace',$datos,'required','','div-2-10');	 
      	
 
        
 		 
    }
    
    
    function Formulario($id_asiento,$cuenta,$idasientod,$id_tramite){
        
        $tipo =  $this->bd->retorna_tipo();
        
        $datos = array();
        
        
        
        $resultado =  $this->bd->ejecutar("select '-' as codigo, '- 0. Seleccione partida - ' as nombre union
                                      	select partida as codigo, partida  || ' ' || detalle as nombre
                                      	from presupuesto.view_enlace_contable_ingreso
                                      	where anio =". $this->bd->sqlvalue_inyeccion($this->anio   ,true)." and
                                              cuenta =". $this->bd->sqlvalue_inyeccion($cuenta ,true) );
        
 
            
        $this->obj->list->listadb($resultado,$tipo,'Enlace','partida_enlace',$datos,'required','','div-2-10');
        
        
        
        
    }
  
  }
  ///------------------------------------------------------------------------
  ///------------------------------------------------------------------------
 
 
           $id_asiento      = $_GET['id_asiento'] ;
           $id_tramite      = $_GET['id_tramite'] ;
 	       $tipo            = $_GET['tipo'] ;
 	       $idasientod      = $_GET['idasientod'] ;
 	       $cuenta      = $_GET['cuenta'] ;
 	 
 
 	       
 		   $gestion        = 	new componente;
   
 		   if ( $tipo == '0'){
 		       $gestion->Formulario($id_asiento,$cuenta,$idasientod,$id_tramite);
 		   }
 		  
 		   if ( $tipo == '1'){
 		       $gestion->Formulariog($id_asiento,$cuenta,$idasientod,$id_tramite);
 		   }
 		   
 		   
 
  
?>			 						  

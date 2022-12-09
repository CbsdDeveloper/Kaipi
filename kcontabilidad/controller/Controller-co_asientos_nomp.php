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
                 $this->obj     = 	   new objects;
                 $this->set     = 		    new ItemsController;
                 $this->bd	   =	     	new Db ;
                 $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
      }
      
      function Formulario($id_asiento,$idasientod,$id_tramite){
    
       $tipo =  $this->bd->retorna_tipo();
          
       $datos = array();
       $datos['idasientobas'] = $idasientod;
 
        
       	
      	$resultado =  $this->bd->ejecutar("select '' as codigo, '-- 0. Seleccione Partida --' as nombre union
                                    	SELECT    partida as codigo,partida || ' - ' || trim(detalle) as nombre
                                          	FROM presupuesto.view_dettramites
                                          	where id_tramite =". $this->bd->sqlvalue_inyeccion($id_tramite ,true)." 
                                            order by 2");
      	
      	
      
      	  
      	
      	       $this->obj->list->listadb($resultado,$tipo,'Enlace','partidabas',$datos,'required','','div-2-10');	 
      	
      	 
                $this->obj->text->text('Referencia',"number",'idasientobas',0,10,$datos,'required','readonly','div-2-10') ;
                
                
              
              
                
 		 
    }
  
  }
 
  
  $id_asiento     = $_GET['id_asiento'] ;
  $idasientod     = $_GET['idasientod'] ;
  $id_tramite     = $_GET['id_tramite'] ;
  
  $gestion   = 	new componente;
  
  $gestion->Formulario($id_asiento,$idasientod,$id_tramite);
  
  
 ?> 
 
    
  
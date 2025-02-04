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
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario(){
      
    
      	
     
      	$this->set->div_label(12,'Por Cliente');
      	
      	$resultado = $this->bd->ejecutar("select '-' as codigo, '  [  Cliente - Responsable  ]'  as nombre   union
                                            SELECT idprov as codigo,  beneficiario as nombre
                                            FROM  view_cxc
                                            where  registro = ".$this->bd->sqlvalue_inyeccion($this->ruc, true)." and 
                                                   estado_pago = 'N' and 
                                                   estado = 'aprobado' 
                                            group by  beneficiario , idprov  
                                            order by 2" );
      	
      	$tipo = $this->bd->retorna_tipo();
      	
      	$this->obj->list->listadb($resultado,$tipo,' ','idprove_seleccione',$datos,'required','','div-2-10');
      	
 
      
      }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
  
 
   $gestion->FiltroFormulario( );

 ?>


 
  
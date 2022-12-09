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
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  $this->bd->hoy();
        
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario(){
      
          
       $datos = array();
          
        
      	
      	$tipo = $this->bd->retorna_tipo();
     
 
      	$resultado = $this->bd->ejecutar("select idsede as codigo, nombre
                                            from activo.view_sede_user
                                            where  sesion=". $this->bd->sqlvalue_inyeccion( $this->sesion,true).' order by 2'
      	    );
      	
      	
      	
        $evento = ' OnChange="BuscaPrograma(this.value)" ';
      	$this->obj->list->listadbe($resultado,$tipo,'','vidsede',$datos,'','',$evento,'div-0-12');
      	
     
      	
      	$resultado = $this->bd->ejecutar("select 0 as codigo, '[ 0. Seleccione la unidad ]' as nombre " );
      	$this->obj->list->listadb($resultado,$tipo,'Unidad','Vid_departamento',$datos,'','','div-0-12');
      	
      	
      	$MATRIZ = array(
    	    'N'    => 'Acta NO Generadas',
      	    'S'    => 'Actas Generadas'
      	);
      	$this->obj->list->lista('',$MATRIZ,'vtiene_acta',$datos,'','','div-0-12');
      
      }
      //----------------------------------------------
      function sql($titulo){
          
          
    
          if  ($titulo == 1){
              
              $sqlb = "Select '-' as codigo, '[Seleccione cuenta contable]' as nombre
                    union
                    SELECT  cuenta as codigo, (cuenta || '.'||  detalle) as nombre
                    FROM co_plan_ctas
                    where tipo_cuenta = 'A' and
                          univel = 'S'  order by 1";
              
          }
          
             
              
          if  ($titulo == 2){

              $sqlb = "SELECT id_modelo  as codigo ,  nombre
		          FROM  inv.ac_modelo
                 where id_modelo = 0";
               
              
          }
          
          $resultado = $this->bd->ejecutar($sqlb);
          
          
          return  $resultado;
          
      }
      
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
  
 
   $gestion->FiltroFormulario( );

 ?>


 
  
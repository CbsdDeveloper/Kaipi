<?php 
session_start( );   
  
    require '../../kconfig/Db.class.php';   
    require '../../kconfig/Set.php';  
    require '../../kconfig/Obj.conf.php';  
    
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
                 $this->obj     = 	   new objects;
                 $this->bd	    =	   new Db ;
                 $this->set     = 	   new ItemsController;
                  
                 $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
                 $this->ruc          =  $_SESSION['ruc_registro'];
                 $this->sesion 	     =  $_SESSION['email'];
                 $this->hoy 	     =  $this->bd->hoy();
                 $this->anio         =  $_SESSION['anio'];
                 
      }
      
      function Formulario(  $id_asiento, $cuenta, $grupo ){
    
          $datos              = array();
          
          $tipo               = $this->bd->retorna_tipo();
          
          $this->set->div_panel12('<b> Seleccione el enlace a trasladar </b>');
          
          $datos['cuenta0'] = $cuenta;

          $datos['xid_asientod'] = $id_asiento;
          
          
                  $this->obj->text->text('Cuenta',"text",'cuenta0',0,10,$datos,'','readonly','div-2-10') ;
                   
                  $evento = '';
                  
                  
               
                  
                      $resultado = $this->sql_cuenta_gasto($grupo ,$id_asiento );
                      
                      $this->obj->list->listadbe($resultado,$tipo,'Trasladar','cuenta1',$datos,'required','',$evento,'div-2-10');
              
                    
                      $this->obj->text->texto_oculto("xid_asientod",$datos); 
                      
                  $this->set->div_panel12('fin');
          
        
 		 
    }
   
    //-------------
    function sql_cuenta_gasto($grupo ,$id_asiento ){
        
        $anio = $this->anio;
       
 
        $resultado = $this->bd->ejecutar("SELECT '-' as codigo, ' [ 0. Seleccione Cuenta ] ' as nombre union
                                       select cuenta as codigo ,cuenta || ' '|| detalle as nombre
                                            FROM co_plan_ctas
                                            where anio = ".$this->bd->sqlvalue_inyeccion($anio, true)."  and
                                                  substring(cuenta,1,3) in ('124','224','226') and
                                                  estado = 'S' and 
                                                  univel='S'
                                          order by 1"
            );
        
       
        
        
        return $resultado;
    }
     
    
 
  }
  ///------------------------------------------------------------------------
  ///------------------------------------------------------------------------
  $gestion   = 	new componente;
  
 
  $id_asientod      = $_GET['id_asientod'] ;
  $cuenta          = trim($_GET['cuenta']) ;
  $grupo           = trim($_GET['grupo']) ;
 
  $gestion->Formulario( $id_asientod, $cuenta, $grupo);
  
 ?> 
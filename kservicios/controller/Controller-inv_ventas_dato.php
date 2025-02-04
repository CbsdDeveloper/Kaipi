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
                
                $this->sesion 	 =  trim($_SESSION['email']);
 
        
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase   bnaturaleza,bidciudad
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario(){
      
           
      $datos = array();
 
      $tipo = $this->bd->retorna_tipo();
      
      $anio          = $_SESSION['anio']  ;
      
      $sql0 = "  SELECT trim(a.cuenta) as codigo,
                   trim(a.cuenta) || ' ' || trim(b.detalle) as nombre
        FROM co_asientod a,  co_plan_ctas b
        where b.cuenta = a.cuenta AND a.cuenta LIKE '111%' and b.univel = 'S' and b.estado = 'S'
        group by a.cuenta,b.detalle";
      
       $sql = " union SELECT trim(b.cuenta) as codigo,
                   trim(b.cuenta) || ' ' || trim(b.detalle) as nombre
        FROM  co_plan_ctas b
        where b.univel= ".$this->bd->sqlvalue_inyeccion('S', true).' and
              b.anio= '.$this->bd->sqlvalue_inyeccion($anio, true)." and b.estado = 'S' and b.tipo_cuenta='C' and 
              b.cuenta LIKE '113.%'";
      
      $sql1 = " union SELECT trim(a.cuenta) as codigo,
                   trim(a.cuenta) || ' ' || trim(b.detalle) as nombre
        FROM co_asientod a,  co_plan_ctas b
        where b.cuenta = a.cuenta AND a.cuenta LIKE '212.%'  and b.univel = 'S' and b.estado = 'S'
        group by a.cuenta,b.detalle ";
      
      $sql2 = " union SELECT trim(a.cuenta) as codigo,
                   trim(a.cuenta) || ' ' || trim(b.detalle) as nombre
        FROM co_asientod a,  co_plan_ctas b
        where b.cuenta = a.cuenta AND a.cuenta LIKE '213.56%'  and b.univel = 'S' and b.estado = 'S'
        group by a.cuenta,b.detalle
        order by 1";
  
     
      $sql_integra =    $sql0.$sql.$sql1.$sql2;
              
      $resultado = $this->bd->ejecutar("select '-' as codigo,' --- Seleccione Cuenta --- ' as nombre  union ".$sql_integra);
      
      $evento = 'OnChange="busca_cuenta(this.value,1)"';
      
      $this->obj->list->listadbe($resultado,$tipo,'CxCobrar','cuenta_uno',$datos,'required','',$evento ,'div-0-3');
      
      
      $resultado = $this->bd->ejecutar("select '-' as codigo,' --- Seleccione Partida --- ' as nombre ");
      
      $evento = 'OnChange="busca_cuenta(this.value,2)"';
      $this->obj->list->listadbe($resultado,$tipo,'Partida','partida_uno',$datos,'required','',$evento,'div-0-3');
      
      
      $resultado = $this->bd->ejecutar("select '-' as codigo,' --- Seleccione Cuenta --- ' as nombre ");
     
      $this->obj->list->listadb($resultado,$tipo,'ContraCuenta','cuenta_dos',$datos,'required','','div-0-3');
       
      $datos['monto'] = '0.00';
      $this->obj->text->text_blue('',"number",'monto',0,10,$datos,'','','div-0-2') ; 
 
      }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
   
 
   $gestion->FiltroFormulario( );

 ?>


 
  
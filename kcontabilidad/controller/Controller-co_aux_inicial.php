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
                
                $this->set     = 	new ItemsController;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                 
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  date("Y-m-d");
        
                $this->anio       =  $_SESSION['anio'];
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario( $accion,$fanio ){
      
           
      	$datos = array();
 
      	if ( $accion == '1'){
      	    $sql = "select cuenta as codigo,cuenta || '-' || cuenta_detalle as nombre
           FROM view_aux
           where anio = ".$this->bd->sqlvalue_inyeccion( $fanio -1  , true)."  and
                 cuenta like '1%'  and tipo_cuenta <> 'B'
           group by cuenta,cuenta_detalle
           having sum(debe) - sum(haber) > 0
           order by cuenta" ;
      	    
      	}else {
      	    $sql = "select cuenta as codigo,cuenta || '-' || cuenta_detalle as nombre
           FROM view_aux
           where anio = ".$this->bd->sqlvalue_inyeccion( $fanio -1  , true)."  and
                 cuenta like '2%'
           group by cuenta,cuenta_detalle
           having sum(haber) - sum(debe) > 0
           order by cuenta" ;
      	    
      	}
     
       	
      
      	
 
      	$resultado = $this->bd->ejecutar($sql);
      	$tipo      = $this->bd->retorna_tipo();
      	
      	$this->obj->list->listadb($resultado,$tipo,'Cuenta Actual','id_cuenta',$datos,'required','','div-3-9');
      	
      
      	$this->set->div_label(12,'Traslado de Cuentas');	 
      	
      	$evento = '';
      	
      	$sql = "select count(*) as nn, max(id_asiento) as id_asiento
             from co_asiento
            where tipo    = ".$this->bd->sqlvalue_inyeccion('T' ,true)." and
                  anio    =".$this->bd->sqlvalue_inyeccion($fanio ,true);
      	
      	$resultado1 = $this->bd->ejecutar($sql);
      	$x          = $this->bd->obtener_array( $resultado1);
      	$id_asiento = $x['id_asiento'] ;
      	
      	$resultado = $this->bd->ejecutar("SELECT '-' as codigo, ' [ 0. Seleccione Cuenta ] ' as nombre union
                                       select a.cuenta as codigo ,a.cuenta || ' '|| a.detalle as nombre
                                            FROM co_plan_ctas a, co_asientod b
                                            where a.anio = ".$this->bd->sqlvalue_inyeccion($fanio, true)."  and
                                                  substring(a.cuenta,1,3) in ('124','224','135','611','618') and
                                                  b.cuenta = a.cuenta and 
                                                  b.id_asiento = ".$this->bd->sqlvalue_inyeccion($id_asiento, true)." 
                                          order by 1"
      	    );
      	
      	$this->obj->list->listadbe($resultado,$tipo,'Trasladar','cuenta2',$datos,'required','',$evento,'div-3-9');
      	
      	
      
 
      }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
  
   
   
   if (isset($_GET['fanio']))	{
       
       $accion    		        = $_GET['accion'];
       $fanio            		= $_GET['fanio'];
       
       $gestion->FiltroFormulario($accion,$fanio);
       
       
       
   }
   
   
 

 ?>


 
  
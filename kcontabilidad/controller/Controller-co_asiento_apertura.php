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
      
      function Formulario(  $id_asiento, $cuenta, $grupo,$fanio ){
    
          $datos              = array();
          
          $tipo               = $this->bd->retorna_tipo();
          
          $this->set->div_panel12('<b> Seleccione el enlace a trasladar </b>');
          
          $datos['cuenta0'] = $cuenta;

          $datos['xid_asientod'] = $id_asiento;
          
          
                  $this->obj->text->text('Cuenta',"text",'cuenta0',0,10,$datos,'','readonly','div-2-10') ;
                   
                  $evento = '';
                  
                  
               
                  
                      $resultado = $this->sql_cuenta_gasto($grupo ,$id_asiento,$cuenta );
                      
                      $this->obj->list->listadbe($resultado,$tipo,'Trasladar','cuenta1',$datos,'required','',$evento,'div-2-10');
              
                    
                      $this->obj->text->texto_oculto("xid_asientod",$datos); 
                      
                  $this->set->div_panel12('fin');
          
                  $cuenta_filtro = substr($cuenta,0,3);
 		 
                  $evento   = "";  // nombre funcion javascript-columna de codigo primario
                  $edita    = '';
                  $del      = '';
                  $tipo 		     = $this->bd->retorna_tipo(); // TIPO DE CONEXION DE BASE DE DATOS ... POSTGRES

    
                  if (   $cuenta_filtro == '111') {

                  }else 
                  {
                        $sql = "select  idprov,razon,  sum(debe) - sum(haber) saldo
                        from view_aux
                        where anio = ".$this->bd->sqlvalue_inyeccion($fanio-1 , true)." and 
                            estado = 'aprobado' and
                        cuenta = ".$this->bd->sqlvalue_inyeccion($cuenta, true).
                        "group by idprov,razon,cuenta
                        having  sum(debe) - sum(haber) <> 0";

                        $resultado  = $this->bd->ejecutar($sql); // EJECUTA SENTENCIA SQL  RETORNA RESULTADO

                        
                                        
                        $cabecera =  "Identificacion,Nombre,Saldo"; // CABECERA DE TABLAR GRILLA HA VISUALIZAR
                        
                        $evento   = "VerAuxiliarDato-0";
                        $edita = 'seleccion';
                        $del= '';
                        $this->obj->table->table_basic_seleccion($resultado,$tipo,$edita,$del,$evento ,$cabecera);

                    }
                  


    }
   
    //-------------
    function sql_cuenta_gasto($grupo ,$id_asiento,$cuenta ){
        
        $anio = $this->anio;
       
        $cuenta_filtro = substr($cuenta,0,6);
 
                $resultado = $this->bd->ejecutar("SELECT '-' as codigo, ' [ 0. Seleccione Cuenta ] ' as nombre union                    
                                                    SELECT b.cuenta as codigo ,b.cuenta || ' '|| b.detalle as nombre 
                                                    FROM co_traslado a , co_plan_ctas b
                                                    where a.cuenta1 like ".$this->bd->sqlvalue_inyeccion($cuenta_filtro.'%', true)."   and 
                                                            b.cuenta like trim(a.cuenta2) || '%' and 
                                                            b.anio = ".$this->bd->sqlvalue_inyeccion($anio, true)."   and
                                                            b.estado = 'S' and 
                                                            b.univel = 'S' order by 1"
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

  $fanio    = trim($_GET['fanio']) ;
 
  $gestion->Formulario( $id_asientod, $cuenta, $grupo,$fanio);
  
 ?> 
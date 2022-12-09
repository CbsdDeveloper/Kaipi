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
          
          $datos['cuenta0' ]  = $cuenta;
          
          $lon                =  $this->tipo_cuenta($cuenta );
          
  
          
          $this->set->div_panel12('<b> Seleccione el enlace correspondiente </b>');
          
                  $this->obj->text->text('Cuenta',"text",'cuenta0',0,10,$datos,'','readonly','div-2-10') ;
                   
                  
                   ///---- ingresos ----
          
                   if ($lon == 6){
                      
                         $aux_dato = $this->tipo_asiento($id_asiento );
                       
                               
                           $resultado = $this->sql_cuenta_cxc( $grupo );
                           
                           $evento =  'onChange="BuscaPartida(this.value)"';
                           $this->obj->list->listadbe($resultado,$tipo,'ContraCuenta','cuenta1',$datos,'required','',$evento,'div-2-10');
                    
                           
                           $evento =  ' ';
                           $resultado = $this->sql_cuenta_gasto( $grupo ,$id_asiento,$aux_dato);
                           $this->obj->list->listadbe($resultado,$tipo,'Partida','partidad',$datos,'required','',$evento,'div-2-10');
                           
                           
                           /*
                           if ( $aux_dato["bandera"] == '0'){
                            
                                   $evento =  ' ';
                                   $resultado = $this->sql_cuenta_gasto( $grupo ,$id_asiento);
                                   $this->obj->list->listadbe($resultado,$tipo,'Partida','partidad',$datos,'required','',$evento,'div-2-10');
                                   
                           }else{
                               
                               $evento =  ' ';
                               $resultado = $this->sql_cuenta_gasto_prov($grupo );
                               $this->obj->list->listadbe($resultado,$tipo,'Partida','partidad',$datos,'required','',$evento,'div-2-10');
      
                               
                           }
                           */
                       
                       $MATRIZ = array(
                           'H'    => 'Enlazar Partida con cuenta',
                           'D'    => 'Agregar contrapartida y enlace'
                       );
                       
                       $evento =  '';
                       $this->obj->list->listae('Copiar en',$MATRIZ,'tipo_copia',$datos,'required','',$evento,'div-2-4');
                      
                  }
                  
                  
                
                  
                  if ($lon == 2){
                      
                      $grupo = $this->grupo_cuenta($cuenta );
                      
                     
                        
                      $resultado = $this->sql_cuenta_ing( $grupo, $cuenta,$cuenta);
                      
                      $evento =  'onChange="BuscaContra(this.value)"';
                      $this->obj->list->listadbe($resultado,$tipo,'Partida','partidad',$datos,'required','',$evento,'div-2-10');
                      
                      $evento =  ' ';
                      $this->obj->list->listadbe($resultado,$tipo,'ContraCuenta','cuenta1',$datos,'required','',$evento,'div-2-10');
                      
                      $datos['tipo_copia'] = '-';
                      
                      $this->obj->text->texto_oculto("tipo_copia",$datos); 
                      
                  }
       
          $this->set->div_panel12('fin');
          
        
 		 
    }
    function tipo_asiento($idasiento ){
        
        
       $datos = $this->bd->query_array('co_asiento',
                                       '*', 
                                       'id_asiento='.$this->bd->sqlvalue_inyeccion($idasiento,true)
           );
        
 
       
       
       return $datos;
       
    }
    //-------------//-------------//-------------//-------------//-------------//-------------//-------------//-------------
    //-------------//-------------//-------------//-------------//-------------//-------------//-------------//-------------
    function tipo_cuenta($cuenta ){
        
        $anio = $this->anio;
        
        $x = $this->bd->query_array('co_plan_ctas',   // TABLA
            'debito, credito, partida_enlace,deudor_acreedor',                        // CAMPOS
            'cuenta='.$this->bd->sqlvalue_inyeccion($cuenta,true) .' and 
             anio = '.$this->bd->sqlvalue_inyeccion($anio,true) 
            );
        
 
        if (  $x['partida_enlace'] == 'ingreso'){
            return 2;
        }
        
        if (  $x['partida_enlace'] == 'gasto'){
            return 6;
        }
        
        
        if (  $x['partida_enlace'] == '-'){
          
            if (  $x['deudor_acreedor'] == 'D'){
                return 2;
            }else{
                return 6;
            }
            
        }
        
    }
 //----------------------
    function grupo_cuenta($cuenta ){
        
         
        
        $anio = $this->anio;
        
        $x = $this->bd->query_array('co_plan_ctas',   // TABLA
            'debito, credito, partida_enlace,deudor_acreedor',                        // CAMPOS
            'cuenta='.$this->bd->sqlvalue_inyeccion($cuenta,true) .' and 
             anio = '.$this->bd->sqlvalue_inyeccion($anio,true)
            );
        
        
        if (  $x['partida_enlace'] == 'ingreso'){
            return $x['credito'];
        }
        
        if (  $x['partida_enlace'] == 'gasto'){
            return $x['debito'];
        }
        
        
        if (  $x['partida_enlace'] == '-'){
            
            if (  $x['deudor_acreedor'] == 'D'){
                return $x['credito'];
            }else{
                return $x['debito'];
            }
            
        }
        
    }
    //-------------
    function sql_cuenta_gasto($grupo ,$id_asiento ,$aux_dato){
        
        $anio = $this->anio;
        
        $gru = substr($grupo,0,2);
        
        $cuenta = '213.'.$gru.'%';
        
        $sql = "SELECT  partida as codigo,
                        partida ||' '|| detalle_presupuesto || '( ' || sum(haber) - sum(debe) || ' )' as nombre
                FROM view_diario_presupuesto
                where anio =  ".$this->bd->sqlvalue_inyeccion($anio, true)."  and 
                      cuenta like ".$this->bd->sqlvalue_inyeccion($cuenta, true)."  and 
                      mes <= ".$this->bd->sqlvalue_inyeccion($aux_dato['mes'], true)."
                group by partida,detalle_presupuesto
                HAVING  sum(haber) - sum(debe) > 0" ;
        
 
        
        $resultado = $this->bd->ejecutar("SELECT '-' as codigo, ' [ Seleccione partida ] ' as nombre union ".$sql  );
        
         
        
        return $resultado;
    }
    //-------------
    function sql_cuenta_gasto_prov($grupo ){
        
        $anio = $this->anio;
        
        
        $resultado = $this->bd->ejecutar("SELECT '-' as codigo, ' [ Seleccione partida ] ' as nombre union
                            SELECT  a.partida, a.partida || ' ' || b.detalle as nombre
                            FROM  view_diario_conta a, presupuesto.pre_gestion b
                            where a.anio = ".$this->bd->sqlvalue_inyeccion($anio, true)." and 
                                  a.item like ".$this->bd->sqlvalue_inyeccion($grupo.'%', true)." and a.debe >  0 and
                            	  a.partida = b.partida and a.anio::character varying::text = b.anio 
                            group by a.partida ,b.detalle 
                             order by 1"  
 
            );
        
        
        
        
        return $resultado;
    }
    //------------- $grupo, $cuenta,$cuenta
    function sql_cuenta_ing($grupo,$cuentap,$cuenta ){
        
        $anio = $this->anio;
        
        $longitud = strlen(trim($grupo));
        
        
        
        if ( $longitud == 2 ){
            
            $grupo_dato = trim($grupo).'%';
            
    
            $resultado = $this->bd->ejecutar("SELECT '-' as codigo, ' [ Seleccione partida ingreso ] ' as nombre union
                                              SELECT partida,  partida || ' ' || partida_detalle as nombre
                                              FROM  presupuesto.view_enlace_ingreso
                                              where partida like ".$this->bd->sqlvalue_inyeccion($grupo_dato, true)." and
                                                    anio = ".$this->bd->sqlvalue_inyeccion($anio, true)."    
                                              group by partida,partida_detalle
                                         order by 1"
                );
            
        }else {
            $resultado = $this->bd->ejecutar("SELECT '-' as codigo, ' [ Seleccione partida ingreso ] ' as nombre union
                                              SELECT partida,  partida || ' ' || partida_detalle as nombre
                                              FROM  presupuesto.view_enlace_ingreso
                                              where cuenta = ".$this->bd->sqlvalue_inyeccion(trim($cuenta), true)." and
                                                    anio = ".$this->bd->sqlvalue_inyeccion($anio, true)."
                                         order by 1"
                );
            
        }
        
      
        
        
        return $resultado;
    }
    
    //-------------
    function sql_cuenta_cxc( $grupo ){
        
        $anio = $this->anio;
        
        
        $resultado = $this->bd->ejecutar("SELECT '-' as codigo, ' [ Seleccione partida ingreso ] ' as nombre union
                                              SELECT partida,  partida || ' ' || detalle_presupuesto as nombre
                                              FROM  view_diario_presupuesto
                                              where id_asiento = ".$this->bd->sqlvalue_inyeccion($grupo, true)." and
                                                    anio = ".$this->bd->sqlvalue_inyeccion($anio, true)." group by partida,detalle_presupuesto
                                         order by 1"
            );
        
        return $resultado;
    }
  }
  ///------------------------------------------------------------------------
  ///------------------------------------------------------------------------
  $gestion   = 	new componente;
  
 
  $id_asiento      = $_GET['id_asiento'] ;
  $cuenta          = trim($_GET['cuenta']) ;
  $grupo           = trim($_GET['grupo']) ;
 
  $gestion->Formulario( $id_asiento, $cuenta, $grupo);
  
 ?> 
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
                 
                 
                 $this->anio       =  $_SESSION['anio'];
                 
      }
      
      function Formulario( $id_tramite, $id_asientod, $partida,$item,$monto,$iva, $norma   ){
    
          $datos = array();
          
          $tipo = $this->bd->retorna_tipo();
          
          $grupo = substr($item, 0,2);
          
          $datos['partida']         = $partida;
          $datos['grupo']           = $grupo ;
          $datos['base']            = $monto ;
          $datos['monto_iva']       = $iva ;
          $datos['id_asientod']     = $id_asientod;
          $datos['montofuente']     = '0.00';
          $datos['montoriva']     = '0.00';
          $datos['montocxp']     = '0.00';
          
          if ( trim($norma) == 'S') {
            $base_renta =  $monto  ;
          }else    {
            $base_renta =  $monto - $iva ;
          }

          if ( trim($norma) == 'X') {
            $base_renta =  $monto  ;
          }

        
           
          $this->obj->text->texto_oculto("partida",$datos);
          $this->obj->text->texto_oculto("grupo",$datos);
        //  $this->obj->text->texto_oculto("base",$datos);
          $this->obj->text->texto_oculto("monto_iva",$datos);
          $this->obj->text->texto_oculto("id_asientod",$datos);
          
          
         
          
           if ($iva > 0 ){
              
               $this->set->div_panel6('<b> COMPRA IVA [ '.$monto.' ] </b>');
              
               
                          $resultado = $this->sql_iva($grupo );
                          
                          $evento =  'onChange="Contracuenta(this.value)"';
                          $this->obj->list->listadbe($resultado,$tipo,'Iva','iva',$datos,'required','',$evento,'div-2-10');
                          
                          $evento =  'onChange="ContraPartida(this.value)"';
                          $this->obj->list->listadbe($resultado,$tipo,'Contracuenta','ivac',$datos,'required','',$evento,'div-2-10');
                          
                          $evento ='';
                          $this->obj->list->listadbe($resultado,$tipo,'Partida','ivap',$datos,'required','',$evento,'div-2-10');
              
              $this->set->div_panel6('fin');
          }else {
              $this->obj->text->texto_oculto("iva",$datos); 
              $this->obj->text->texto_oculto("ivac",$datos); 
              $this->obj->text->texto_oculto("ivap",$datos); 
          }
          
          
          //---------------- retencion iva
          
          if ($iva > 0 ){
              
              $this->set->div_panel6('<b> RETENCION IVA [ '.$iva.' ] </b>');
              
                      $resultado = $this->sql_iva_retencion($grupo );
                      
                      $evento ='';
                      $this->obj->list->listadbe($resultado,$tipo,'Cuenta','riva',$datos,'required','',$evento,'div-2-10');
                      
                      $MATRIZ = $this->obj->array->iva_compras_total();
                      $evento =  'onChange="monto_riva(this.value,'.$iva.','.trim("'#montoriva'").')" ';
                      $this->obj->list->listae('Retencion',$MATRIZ,'porcentaje_iva',$datos,'required','',$evento,'div-2-10');
                      
                      $this->obj->text->text('Monto',"number",'montoriva',0,10,$datos,'required','','div-2-10') ;
              
              $this->set->div_panel6('fin');
          }else {
                      $this->obj->text->texto_oculto("riva",$datos);
                      $this->obj->text->texto_oculto("porcentaje_iva",$datos);
                      $this->obj->text->texto_oculto("montoriva",$datos);
          }
          
          //---------------- retencion fuente
          
          $this->set->div_panel6('<b> RETENCION FUENTE  [ '.$base_renta.' ] </b>');
          
                      $resultado = $this->sql_fuente_retencion($grupo );

                      $evento =  '';

                      $this->obj->text->text_blue('Base Retencion',"number",'base',0,10,$datos,'required','','div-2-10') ;

                      $this->obj->list->listadbe($resultado,$tipo,'Cuenta','rfuente',$datos,'required','',$evento,'div-2-10');
                      
                      $MATRIZ = array(
                          '0'    => '-',
                          '1'    => '1%',
                          '1.75'    => '1.75%',
                          '2'    => '2%',
                          '2.75'    => '2.75%',
                          '8'    => '8%',
                          '10'    => '10%'
                      );
                      $evento =  'onChange="calculoFuente(this.value,'.$base_renta.','.trim("'#montofuente'").')" ';
                      $this->obj->list->listae('Retencion',$MATRIZ,'porcentaje_fuente',$datos,'required','',$evento,'div-2-10');
                      
                      $this->obj->text->text('Monto',"number",'montofuente',0,10,$datos,'required','','div-2-10') ;
                      
          $this->set->div_panel6('fin');
          
          
          $this->set->div_panel6('<b> CUENTA POR PAGAR</b>');
          
          
          $resultado = $this->sql_cxp($grupo );
                      
          $evento =  'onChange="calculopagar('.$monto.','.trim("'#montoriva'").','.trim("'#montofuente'").','.trim("'#montocxp'").')"';
                      
                      $this->obj->list->listadbe($resultado,$tipo,'Cuenta','cxp',$datos,'required','',$evento,'div-2-10');
                      
                      $this->obj->text->text('Monto',"number",'montocxp',0,10,$datos,'required','','div-2-10') ;
          
          $this->set->div_panel6('fin');
          
		 
 		 
    }
    //-------------//-------------//-------------//-------------//-------------//-------------//-------------//-------------
    //-------------//-------------//-------------//-------------//-------------//-------------//-------------//-------------
    function sql_iva($grupo ){
        
        $resultado = $this->bd->ejecutar("SELECT '-' as codigo, ' [ Seleccione cuenta iva ] ' as nombre union
                                      SELECT cuenta as codigo, cuenta || ' ' || detalle as nombre
                                            FROM co_plan_ctas
                                            where tipo_cuenta = 'I' and 
                                                  registro = ".$this->bd->sqlvalue_inyeccion($this->ruc, true)."  and 
                                                  anio =  ".$this->bd->sqlvalue_inyeccion( $this->anio , true)."  and 
                                                  univel = 'S' and 
                                                  cuenta like '1%'
                                         order by 1"
            );
       
        return $resultado;
    }
    //-------------
    function sql_iva_retencion($grupo ){
        

        $variacion_sql = " union SELECT cuenta as codigo, cuenta || ' ' || detalle as nombre
        FROM co_plan_ctas
        where tipo_cuenta = 'T' and
              registro = ".$this->bd->sqlvalue_inyeccion($this->ruc, true)."  and
              anio =  ".$this->bd->sqlvalue_inyeccion( $this->anio , true)."  and 
              univel = 'S' and
              cuenta like '213.81%' " ;

        $resultado = $this->bd->ejecutar("SELECT '-' as codigo, ' [ No Aplica retencion ] ' as nombre union
                                      SELECT cuenta as codigo, cuenta || ' ' || detalle as nombre
                                            FROM co_plan_ctas
                                            where tipo_cuenta = 'T' and
                                                  registro = ".$this->bd->sqlvalue_inyeccion($this->ruc, true)."  and
                                                  anio =  ".$this->bd->sqlvalue_inyeccion( $this->anio , true)."  and 
                                                  debito = ".$this->bd->sqlvalue_inyeccion($grupo, true)."  and
                                                  univel = 'S' and
                                                  cuenta like '2%' ". $variacion_sql." order by 1"
            );
        
        return $resultado;
    }
    //-------------
    function sql_fuente_retencion($grupo ){
        
        $resultado = $this->bd->ejecutar("SELECT '-' as codigo, ' [ No Aplica retencion ] ' as nombre union
                                      SELECT cuenta as codigo, cuenta || ' ' || detalle as nombre
                                            FROM co_plan_ctas
                                            where tipo_cuenta = 'R' and
                                                  registro = ".$this->bd->sqlvalue_inyeccion($this->ruc, true)."  and
                                                  anio =  ".$this->bd->sqlvalue_inyeccion( $this->anio , true)."  and 
                                                  debito = ".$this->bd->sqlvalue_inyeccion($grupo, true)."  and
                                                  univel = 'S' and
                                                  cuenta like '2%'
                                         order by 1"
            );
        
        return $resultado;
    }
    
    //-------------
    function sql_cxp($grupo ){
        
        $resultado = $this->bd->ejecutar("SELECT '-' as codigo, ' [ Seleccione cuenta por pagar ] ' as nombre union
                                      SELECT cuenta as codigo, cuenta || ' ' || detalle as nombre
                                            FROM co_plan_ctas
                                            where tipo_cuenta in  ('P','D') and
                                                  registro = ".$this->bd->sqlvalue_inyeccion($this->ruc, true)."  and
                                                  anio =  ".$this->bd->sqlvalue_inyeccion( $this->anio , true)."  and 
                                                  debito = ".$this->bd->sqlvalue_inyeccion($grupo, true)."  and
                                                  univel = 'S' and
                                                  cuenta like '2%'
                                         order by 1"
            );
        
        return $resultado;
    }
  }
  ///------------------------------------------------------------------------
  ///------------------------------------------------------------------------
  $gestion   = 	new componente;
  
 
  $id_tramite     = $_GET['id_tramite'] ;
  $id_asientod    = $_GET['id_asientod'] ;
  $partida        = trim($_GET['partida']) ;
  $item           = trim($_GET['item']) ;
  $monto          = $_GET['monto'] ;
  $iva            = $_GET['iva'] ;
  
  $norma            = $_GET['norma'] ;
  
  


  $gestion->Formulario( $id_tramite, $id_asientod, $partida,$item,$monto,$iva, $norma  );
  
 ?> 
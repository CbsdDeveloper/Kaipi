<script type="text/javascript" src="formulario_result.js"></script> 	
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
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	     	new Db ;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  $this->bd->hoy();
        
                $this->anio       =  $_SESSION['anio'];
                
               $this->formulario  = 'Model-ren_servicio.php'; 
   
               $this->evento_form = '../model/'.$this->formulario;        // eventos para ejecucion de editar eliminar y agregar 
      }
 
      //---------------------------------------
      
     function Formulario( ){
      
         $titulo = '';
         
         $datos = array();
         
 
         
        $this->set->evento_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
   
        $this->set->body_tab($titulo,'inicio');
 
    
                $tipo = $this->bd->retorna_tipo();
        
                $this->BarraHerramientas();
          
                
                        $this->obj->text->text_blue('Id',"number",'idproducto_ser',0,10,$datos,'','readonly','div-2-4') ; 
                    
    
                        $resultado = $this->bd->ejecutar("select idcategoria as codigo, nombre 
                                                         from web_categoria where tipo_categoria ='S'  ");
                     
                    	
                        $this->obj->list->listadb($resultado,$tipo,'Grupo','idcategoria',$datos,'required','','div-2-4');
     
    
                        $this->obj->text->text_yellow('Nombre',"texto",'producto',130,130,$datos,'required','','div-2-10') ;  
    
                        $this->obj->text->editor('Referencia','referencia',3,45,350,$datos,'required','','div-2-10') ;
    
                        $MATRIZ =  $this->obj->array->catalogo_activo();	
                	    $this->obj->list->lista('Estado',$MATRIZ,'estado',$datos,'required','','div-2-4');
          
                	    
                	    $MATRIZ = array(
                	        'S'    => 'Servicio',
                	        'I'    => 'Impuesto',
                	        'T'    => 'Tasa'
                	    );
                	    
                	    
                	    $this->obj->list->lista('Tipo',$MATRIZ,'tipo',$datos,'','','div-2-4');
                	    
                      
                        $MATRIZ =  $this->obj->array->catalogo_tributa();
                        $this->obj->list->lista('Tributa',$MATRIZ,'tributo',$datos,'required','','div-2-4');
                        
                   
                        
                        
                        $this->set->div_label(12,'<b>Enlace Financiero</b>');	 
                                      
                                         
                                    $resultado = $this->_sql_partida('1');
                                    $evento    = 'onChange="PonePartida(this.value)"';
                                    $this->obj->list->listadbe($resultado,$tipo,'Presupuesto','partida',$datos,'','',$evento,'div-2-4');
                                    
                                    
                                    
                                    $resultado  = $this->_sql_cuentas('1');
                                    $evento     = 'onChange="PoneCuenta(this.value)"';
                                    $this->obj->list->listadbe($resultado,$tipo,'Ingreso','cuenta_ing',$datos,'','',$evento,'div-2-4');
                                    
                                    
                                    $resultado  = $this->_sql_cuentas('1');
                                    $this->obj->list->listadb($resultado,$tipo,'Cuenta x Cobrar','cuenta_inv',$datos,'','','div-2-4');	
                        
                
                        $this->set->div_label(12,'<b>Enlace Cobro Anios Anteriores</b>');	
                        
                                    $resultado  = $this->_sql_partida('2');
                                    $evento     = 'onChange="PonePartidaa(this.value)"';
                                    $this->obj->list->listadbe($resultado,$tipo,'Presupuesto','partidaa',$datos,'','',$evento,'div-2-4');
                                    
                                    $resultado  = $this->_sql_cuentas('1');
                                    $evento     = 'onChange="PoneCuentaa(this.value)"';
                                    $this->obj->list->listadbe($resultado,$tipo,'Ingreso','cuenta_aa',$datos,'','',$evento,'div-2-4');;	
                                    
                                    $resultado  = $this->_sql_cuentas('1');
                                    $this->obj->list->listadb($resultado,$tipo,'Cuenta x Cobrar','cuenta_ce',$datos,'','','div-2-4');	
                                    
                        
                        $this->set->div_label(12,'<b>Informacion Complementaria</b>');	 
                        
                       
                        $MATRIZ = array(
                            'N'    => 'NO',
                            'S'    => 'SI'
                        );
                         
                        
                        $this->obj->list->lista('Fondo Terceros',$MATRIZ,'fondoa',$datos,'','','div-2-4');
                        
                        $resultado  = $this->_sql_cuentas('2');
                        $this->obj->list->listadb($resultado,$tipo,'Cuenta x Pagar','cuenta_ajeno',$datos,'','','div-2-4');	
                        
                        
                        $this->set->div_label(12,'<b>Parametros Adicionales</b>');	 
                    
                      
                        
                        $MATRIZ = array(
                            'N'    => 'NO',
                            'S'    => 'SI'
                         );
                         
                        
                        $this->obj->list->lista('Interes',$MATRIZ,'interes',$datos,'','','div-2-4');
                        $this->obj->list->lista('Descuento',$MATRIZ,'descuento',$datos,'','','div-2-4');
                        $this->obj->list->lista('Recargo',$MATRIZ,'recargo',$datos,'','','div-2-4');
                         
                        $this->obj->list->lista('Coactiva',$MATRIZ,'coactiva',$datos,'','','div-2-4');
                        
                        $MATRIZ = array(
                            'formula'      => 'formula',
                            'variable'    =>  'variable - F_general',
                            'constante'    => 'constante - F_CONSTANTE'
                        );
                        
                        
                        $this->obj->list->lista('Calculo',$MATRIZ,'tipo_formula',$datos,'required','','div-2-4');
                        
                        
                        $this->obj->text->text_blue('Formula(*)',"texto",'formula',130,130,$datos,'required','','div-2-4') ;
                        
                        $this->obj->text->text_blue('Monto',"number",'costo',0,15,$datos,'required','','div-2-4') ;
                        
                        
                        
         $this->obj->text->texto_oculto("action",$datos); 
         $this->obj->text->texto_oculto("activo",$datos); 
           
         
         
         $this->obj->text->texto_oculto("facturacion",$datos); 
 
         
      
         
          
         
         $this->set->evento_formulario('-','fin'); 
 
  
 
      
   }
     //----------------------------------------------------......................-------------------------------------------------------------
 // retorna el valor del campo para impresion de pantalla
 function _sql_partida($tipo){
    
     
     if ( $tipo == '1') {
         $sql = "SELECT '--' as codigo, ' [ 0. Enlace partida ]' as nombre union
                 SELECT partida as codigo,  trim(partida) || '. ' || detalle as  nombre
                   FROM presupuesto.pre_gestion
                   WHERE tipo = 'I' and
                   anio=". $this->bd->sqlvalue_inyeccion( $this->anio ,true).  " ORDER BY 2 ";
     }
     
     if ( $tipo == '2') {
         $sql = "SELECT '--' as codigo, ' [ 0. Enlace partida ]' as nombre union
                 SELECT partida as codigo,  trim(partida) || '. ' || detalle as  nombre
                   FROM presupuesto.pre_gestion
                   WHERE tipo = 'I' and partida like '38%' and
                   anio=". $this->bd->sqlvalue_inyeccion( $this->anio ,true).  " ORDER BY 2 ";
     }
     
   
     
     
     $x =   $this->bd->ejecutar($sql);
 
     
     
   return $x;
  } 
  // retorna el valor del campo para impresion de pantalla
  function _sql_cuentas($tipo){
      
      
      if ( $tipo == '1') {
          $sql = "SELECT ' -- ' as codigo, ' [ 0. Seleccionar cuenta contable ]' as nombre union
                  SELECT  trim(cuenta) as codigo, (trim(cuenta) || '. ' || trim(detalle))  as nombre
                   from co_plan_ctas
                  where univel = 'S' and estado = 'S' and 
                        anio = ". $this->bd->sqlvalue_inyeccion( $this->anio ,true)." and
                        registro = " . $this->bd->sqlvalue_inyeccion( $this->ruc ,true)." and
                        tipo_cuenta in ('C') order by 1";
      }
      
      
      if ( $tipo == '2') {
          $sql = "SELECT ' -- ' as codigo, ' [ 0. Seleccionar cuenta contable ]' as nombre union
                  SELECT  trim(cuenta) as codigo, (trim(cuenta) || '. ' || trim(detalle))  as nombre
                   from co_plan_ctas
                  where univel = 'S' and estado = 'S' and 
                        anio = ". $this->bd->sqlvalue_inyeccion( $this->anio ,true)." and
                        registro = " . $this->bd->sqlvalue_inyeccion( $this->ruc ,true)." and
                        cuenta like '212%' order by 1";
      }
      
      $x =   $this->bd->ejecutar($sql);
      
      
      
      return $x;
  } 
   //----------------------------------------------
   function BarraHerramientas(){
 
 
 
   
   $formulario_reporte = 'reportes/informe?a=';
   
   $eventoi = "javascript:imprimir_informe('".$formulario_reporte."')";
    
   
    $ToolArray = array( 
                array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
                array( boton => 'Imprimir Informe', evento =>$eventoi,  grafico => 'glyphicon glyphicon-print' ,  type=>"button")
                );
                  
   $this->obj->boton->ToolMenuDiv($ToolArray); 
 
  }  
   //----------------------------------------------
   function header_titulo($titulo){
 
         $this->set->header_titulo($titulo);
 
  }  
    //----------------------------------------------
     
 
 ///------------------------------------------------------------------------
///------------------------------------------------------------------------
  }
  ///------------------------------------------------------------------------
  ///------------------------------------------------------------------------
   
  
  $gestion   = 	new componente;
  
   
  $gestion->Formulario( );
  
 ?>
 
  
<script >// <![CDATA[

   jQuery.noConflict(); 
	
	jQuery(document).ready(function() {
  		
   // InjQueryerceptamos el evento submit
    jQuery('#form, #fat, #fo3').submit(function() {
  		// Enviamos el formulario usando AJAX
        jQuery.ajax({
            type: 'POST',
            url: jQuery(this).attr('action'),
            data: jQuery(this).serialize(),
            // Mostramos un mensaje con la respuesta de PHP
            success: function(data) {
			 			
             	 jQuery('#result').html(data);

            	 jQuery( "#result" ).fadeOut( 1600 );

            	 jQuery("#result").fadeIn("slow");
            
			}
        })        
        return false;
    }); 
 })
</script>	
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
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  $this->bd->hoy();
        
                $this->anio       =  $_SESSION['anio'];
                
               $this->formulario = 'Model-ren_especie.php'; 
   
               $this->evento_form = '../model/'.$this->formulario;        // eventos para ejecucion de editar eliminar y agregar 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function fecha( ){
          $todayh =  getdate();
          $d = $todayh[mday];
          $m = $todayh[mon];
          $y = $todayh[year];
          return '<h6>'.$d.'/'.$m.'/'.$y.'</h6>';
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
                	        'E'    => 'Especie Valorada'
                 	    );
                	    
                	    
                	    $this->obj->list->lista('Tipo',$MATRIZ,'tipo',$datos,'','','div-2-4');
                	    
                	    $datos['tributo'] = '-';
                	    $this->obj->text->texto_oculto("tributo",$datos); 
                	    
                      
              
                        
                        $this->set->div_label(12,'<b>Enlace Financiero - Control Especies</b>');	 
                                      
                        
                                    $datos['partida'] = '-';
                                    $this->obj->text->texto_oculto("partida",$datos); 
                                      
                                    
                                    $resultado  = $this->_sql_cuentas('1');
                                    $evento     = '';
                                    $this->obj->list->listadbe($resultado,$tipo,'Cuenta','cuenta_ing',$datos,'','',$evento,'div-2-4');
                                    
                                    
                                    $resultado  = $this->_sql_cuentas('2');
                                    $this->obj->list->listadb($resultado,$tipo,'Enlace','cuenta_inv',$datos,'','','div-2-4');	
                        

                       $this->set->div_label(12,'<b>Enlace Financiero - Ingreso</b>');	 

                 
                                    
                  
                                    $resultado = $this->_sql_partida('1');
                                    $evento    = 'onChange="PonePartida(this.value)"';
                                    $this->obj->list->listadbe($resultado,$tipo,'Presupuesto','partidaa',$datos,'','',$evento,'div-2-4');
                                    
                                    
                                    
                                    $resultado  = $this->_sql_cuentas('4');
                                    $evento     = 'onChange="PoneCuenta(this.value)"';
                                    $this->obj->list->listadbe($resultado,$tipo,'Ingreso','cuenta_aa',$datos,'','',$evento,'div-2-4');
                                    
                                    
                                    $resultado  = $this->_sql_cuentas('3');
                                    $this->obj->list->listadb($resultado,$tipo,'Cuenta x Cobrar','cuenta_ce',$datos,'','','div-2-4');	






                                    $datos['fondo'] = '-';
                                    $this->obj->text->texto_oculto("fondo",$datos); 
                                    
                                    $datos['cuenta_ajeno'] = '-';
                                    $this->obj->text->texto_oculto("cuenta_ajeno",$datos);
                       
                        
                                    $datos['interes'] = 'N';
                                    $this->obj->text->texto_oculto("interes",$datos);
                                    
                                    $datos['descuento'] = 'N';
                                    $this->obj->text->texto_oculto("descuento",$datos);
                                    
                                    $datos['recargo'] = 'N';
                                    $this->obj->text->texto_oculto("recargo",$datos);
                                    
                                    $datos['coactiva'] = 'N';
                                    $this->obj->text->texto_oculto("coactiva",$datos);
                        
                                    $datos['tipo_formula'] = 'variable';
                                    $this->obj->text->texto_oculto("tipo_formula",$datos);
            
                   
                                    $datos['formula'] = '-';
                                    $this->obj->text->texto_oculto("formula",$datos);
                        
                     $this->set->div_label(12,'<b>Monto Valor Especie</b>');	 
                         
                        $this->obj->text->text_blue('Valor',"number",'costo',0,15,$datos,'required','','div-2-4') ;
                        

                        $this->obj->text->text_blue('Costo',"number",'costoe',0,15,$datos,'required','','div-2-4') ;
                        
                        
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
                  where univel = 'S' and
                        anio = ". $this->bd->sqlvalue_inyeccion( $this->anio ,true)." and
                        registro = " . $this->bd->sqlvalue_inyeccion( $this->ruc ,true)." and
                        cuenta like '911%' order by 1";
      }
      
      
      if ( $tipo == '2') {
          $sql = "SELECT ' -- ' as codigo, ' [ 0. Seleccionar cuenta contable ]' as nombre union
                  SELECT  trim(cuenta) as codigo, (trim(cuenta) || '. ' || trim(detalle))  as nombre
                   from co_plan_ctas
                  where univel = 'S' and
                        anio = ". $this->bd->sqlvalue_inyeccion( $this->anio ,true)." and
                        registro = " . $this->bd->sqlvalue_inyeccion( $this->ruc ,true)." and
                        cuenta like '921%' order by 1";
      }

      if ( $tipo == '3') {
        $sql = "SELECT ' -- ' as codigo, ' [ 0. Seleccionar cuenta contable ]' as nombre union
                SELECT  trim(cuenta) as codigo, (trim(cuenta) || '. ' || trim(detalle))  as nombre
                 from co_plan_ctas
                where univel = 'S' and
                      anio = ". $this->bd->sqlvalue_inyeccion( $this->anio ,true)." and
                      registro = " . $this->bd->sqlvalue_inyeccion( $this->ruc ,true)." and
                      cuenta like '113%' order by 1";
     }

     if ( $tipo == '4') {
        $sql = "SELECT ' -- ' as codigo, ' [ 0. Seleccionar cuenta contable ]' as nombre union
                SELECT  trim(cuenta) as codigo, (trim(cuenta) || '. ' || trim(detalle))  as nombre
                 from co_plan_ctas
                where univel = 'S' and
                      anio = ". $this->bd->sqlvalue_inyeccion( $this->anio ,true)." and
                      registro = " . $this->bd->sqlvalue_inyeccion( $this->ruc ,true)." and
                      cuenta like '62%' order by 1";
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
 
  
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
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
                $this->anio       =  $_SESSION['anio'];
                
               $this->formulario = 'Model-co_plan_ctas.php'; 
   
               $this->evento_form = '../model/Model-co_plan_ctas.php';     
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
 
      //---------------------------------------
      
     function Formulario( ){
      
        $this->set->_formulario( $this->evento_form,'inicio' ); 
        
        $datos = array();
    
                $this->BarraHerramientas();
                     
          
                $this->set->div_label(12,'<b>Informacion Principal</b>');	
                
                $tipo   =  $this->bd->retorna_tipo();
                
                $MATRIZ = $this->obj->array->catalogo_naturaleza_cuenta();

                $java   =  "Filtra_cta(this.value)";
                $evento = ' onChange="'.$java.'" ';

                $this->obj->list->listae('<b>TIPO</b>',$MATRIZ,'tipo',$datos,'required','', $evento ,'div-2-4');
                
                
                
                $resultado = $this->bd->ejecutar("select '-' as codigo,  'No Aplica' as nombre
            									  union
            									  select trim(cuenta) as codigo, (trim(cuenta) || '.' || trim(detalle))  as nombre
            									   from co_plan_ctas
            									   where univel = 'N'  and 
                                                         anio = ". $this->bd->sqlvalue_inyeccion($this->anio ,true)." and
                                                         registro=". $this->bd->sqlvalue_inyeccion( $this->ruc,true)."
												  order by 1");
                 
                $java   =  "realizaProceso(this.value);";
                $evento =  ' onChange="'.$java.'" ';
                
              
                $this->obj->list->listadbe($resultado,$tipo,'Unidad Padre','cuentas',$datos,'','',$evento,'div-2-4');
                
                $this->obj->text->text_yellow('Codigo Cuenta',"texto",'cuenta',25,25,$datos,'required','','div-2-4') ;
                
                $MATRIZ =   $this->obj->array->catalogo_nivel_cuenta();
                $this->obj->list->lista('Nivel',$MATRIZ,'nivel',$datos,'required','','div-2-4');
          
            
                $this->obj->text->editor('Detalle Cuenta','detalle',2,45,150,$datos,'required','','div-2-10') ;
             
                 
                $MATRIZ =   $this->obj->array->catalogo_activo();
                $this->obj->list->lista('Estado',$MATRIZ,'estado',$datos,'required','','div-2-4');
                
                
                $MATRIZ =   $this->obj->array->catalogo_sino();
                $this->obj->list->lista('Cuenta de transacción',$MATRIZ,'univel',$datos,'required','','div-2-4');
                
                
                $MATRIZ =   $this->obj->array->deudor_acreedor();
                
                $this->obj->list->lista('Deudor-Acredor',$MATRIZ,'deudor_acreedor',$datos,'required','','div-2-4');
                
                
                $this->set->div_label(12,'<b>Parametros de la Cuenta</b>');	
                 
                       
                $MATRIZ =   $this->obj->array->catalogo_sino();
                $this->obj->list->lista('auxiliares',$MATRIZ,'aux',$datos,'required','','div-2-4');
                
                
                $MATRIZ =   $this->obj->array->catalogo_tipo_cuenta();
                $this->obj->list->lista('Parametro cuenta',$MATRIZ,'tipo_cuenta',$datos,'required','','div-2-4');
                
                $this->obj->text->text('Nro.Documento',"number",'documento',0,20,$datos,'','','div-2-4') ;
                
                $this->obj->text->text('Nro.Comprobante',"number",'comprobante',0,20,$datos,'','','div-2-4') ;  
                
                $resultado = $this->bd->ejecutar("select '-' as codigo, 'No aplica' as nombre union
           							   select idprov as codigo, razon as nombre
        							   from par_ciu
        							   where naturaleza =".$this->bd->sqlvalue_inyeccion('PP', true).' order by 1 asc');
                
                $tipo = $this->bd->retorna_tipo();
                
                $evento ='';
                $this->obj->list->listadbe($resultado,$tipo,'Auxiliar','idprov',$datos,'','',$evento,'div-2-10');
                
                
                $MATRIZ = array(
                    '0'    => 'NO',
                    '1'    => 'SI' 
                );
                $this->obj->list->lista('ArchivoEsigef',$MATRIZ,'impresion',$datos,'required','','div-2-4');
                
                $this->set->div_label(12,'<b>Asociacion Presupuestaria</b>');	
                 
                $this->obj->text->text_blue('DEBITO',"texto",'debito',25,25,$datos,'required','','div-2-4') ;
                
                $this->obj->text->text_blue('CREDITO',"texto",'credito',25,25,$datos,'required','','div-2-4') ;
                
 
                $this->set->div_label(12,'<b>Enlace Presupuestaria</b>');	
                
                 
                $MATRIZ = array(
                    '-'    => 'No Aplica',
                    'ingreso'    => 'Ingreso',
                    'gasto'    => 'Gasto' 
                );
                
                $this->obj->list->lista('Tipo Enlace Presupuesto',$MATRIZ,'partida_enlace',$datos,'required','','div-2-4');
                

                $this->set->div_label(12,'<b>Enlace Contra-Cuenta inventarios 131-151-152</b>');	

                
                $resultado = $this->bd->ejecutar("select '-' as codigo,  'No Aplica' as nombre
                union
                select trim(cuenta) as codigo, (trim(cuenta) || '.' || trim(detalle))  as nombre
                 from co_plan_ctas
                 where univel = 'S'  and 
                       tipo_cuenta = 'V' and
                       substring(cuenta,1,6) in ('634.08','631.54','631.53','631.55') and
                       anio = ". $this->bd->sqlvalue_inyeccion($this->anio ,true)." and
                       registro=". $this->bd->sqlvalue_inyeccion( $this->ruc,true)."
                order by 1");

           
                $evento =  ' ';

                

               $this->obj->list->listadbe($resultado,$tipo,'Contra Cuenta','cuenta_ing',$datos,'','',$evento,'div-2-4');
               
               
               $this->obj->text->text_blue('% Retencion',"number",'valor',0,10,$datos,'','','div-2-4') ;


         $this->obj->text->texto_oculto("action",$datos); 
         
         $this->set->evento_formulario('-','fin'); 
 
  
      
   }
 
   //----------------------------------------------
   function BarraHerramientas(){
 
  
   
   $formulario_reporte = '../../reportes/PlanCtas.php';
   
   $eventoi = "javascript:imprimir_informe('".$formulario_reporte."')";
 
   
   $formulario_excel = '../../reportes/PlanCtasExcel.php';
   
   $eventoe = "javascript:imprimir_informe('".$formulario_excel."')";
   
    $ToolArray = array( 
    		    array( boton => 'Filtro de datos',    evento =>"#myModal", grafico => 'glyphicon glyphicon-filter' ,  type=>"modal"),
                array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
                array( boton => 'Imprimir Informe', evento =>$eventoi,  grafico => 'glyphicon glyphicon-print' ,  type=>"button"),
                array( boton => 'Excel', evento =>$eventoe,  grafico => 'glyphicon glyphicon-download-alt' ,  type=>"button")
               );
                  
  //  <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-filter"></span></button>
    
    
   $this->obj->boton->ToolMenuDiv($ToolArray); 
 
  }  
   //----------------------------------------------
   function header_titulo($titulo){
 
         $this->set->header_titulo($titulo);
 
  }  
    
 
 ///------------------------------------------------------------------------
///------------------------------------------------------------------------
  }
  ///------------------------------------------------------------------------
  ///------------------------------------------------------------------------
   
  
  $gestion   = 	new componente;
  
   
  $gestion->Formulario( );
  
 ?>
 
  
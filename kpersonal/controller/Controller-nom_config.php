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
               
                jQuery('#result').html('<div class="alert alert-info">'+ data + '</div>');

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
  
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
            	$this->bd	   =	new Db;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  $this->bd->hoy();
              
                $this->anio       =  $_SESSION['anio'];
                
                
               $this->formulario = 'Model-nom_config.php'; 
   
               $this->evento_form = '../model/'. $this->formulario;        // eventos para ejecucion de editar eliminar y agregar 
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
      
 
        $this->set->_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
 
                $datos = array();
    
                $this->BarraHerramientas();
                
                $tipo = $this->bd->retorna_tipo();
                
                
                
                $this->obj->text->text('Identificacion',"number",'id_config',20,15,$datos,'required','readonly','div-2-4') ; 
                
                
                $MATRIZ =  $this->obj->array->nom_tipo();
                
                $this->obj->list->lista('Tipo',$MATRIZ,'tipo',$datos,'required','','div-2-4');
                
                
                
                $this->obj->text->text_yellow('Concepto',"texto",'nombre',80,80,$datos,'required','','div-2-10') ; 
 
                
                
                $MATRIZ =  $this->obj->array->catalogo_sino();
                $this->obj->list->lista('Estado',$MATRIZ,'estado',$datos,'required','','div-2-4');
                
                
                $MATRIZ =  $this->obj->array->nom_formula();
                $this->obj->list->lista('Parametro',$MATRIZ,'estructura',$datos,'required','','div-2-4');
                
                $MATRIZ =  $this->obj->array->nom_formula_afecta();
                $this->obj->list->lista('Afecta a la formula',$MATRIZ,'formula',$datos,'required','','div-2-4');
                
                $MATRIZ =  $this->obj->array->nom_formula_par();
                $this->obj->list->lista('formula de:',$MATRIZ,'tipoformula',$datos,'required','','div-2-4');
                
                
                $this->obj->text->text('valor (*)',"number",'monto',10,10,$datos,'required','','div-2-4') ; 
                
                
                $this->obj->text->text('Variable',"texto",'variable',20,20,$datos,'','readonly','div-2-4') ; 
                
                
                $this->set->div_label(12,'<h5><b>APLICA AL REGIMEN</b></h5>');
                  
            
                
                
                $resultado =  $this->combo_lista("nom_regimen");
                $this->obj->list->listadb($resultado,$tipo,'Regimen laboral?','regimen',$datos,'','','div-2-10');
                
                
                $evento ='GuardaRolParametroPro()';
                $texto  = '<a href="#" onClick="'.$evento.'">Programa (+)</a>';
                
                $resultado =  $this->combo_lista("presupuesto.pre_catalogo");
                $this->obj->list->listadb($resultado,$tipo,$texto,'programa',$datos,'','','div-2-4');
                
                
                $resultado =  $this->combo_lista("items");
                $evento ='onChange="PoneCuenta(this.value)"';
                
                $this->obj->list->listadbe($resultado,$tipo,'Clasificador','partida',$datos,'','',$evento,'div-2-4');
 
                
                
                $sql = "select '-' as codigo, 'No Aplica' as nombre
								 union
							     select trim(cuenta) as codigo, trim(cuenta) || '. ' || detalle as nombre
								 from co_plan_ctas
								 where univel = 'S' and tipo_cuenta in ('D','N','P') AND 
                                       anio =".$this->bd->sqlvalue_inyeccion($this->anio  ,true)." order by 1";
                 
                $resultado = $this->bd->ejecutar($sql);
                
                $evento ='PonePartida(this.value)';
                $texto  = '<a href="#" onClick="'.$evento.'">Cuenta(Debe)</a>';
                
                $this->obj->list->listadbe($resultado,$tipo,$texto,'cuentai',$datos,'','','','div-2-4');
                
                
                
                $resultado1 = $this->bd->ejecutar($sql);
                
                
                $this->obj->list->listadb($resultado1,$tipo,'Cuenta(Haber)','cuentae',$datos,'','','div-2-4');
         
             
                
              
                      
         $this->obj->text->texto_oculto("action",$datos); 
         
          
         $this->set->_formulario('-','fin'); 
 
  
      
   }
   
   //----------------------------------------------
   function BarraHerramientas(){
 
 
   //$evento = 'javascript:open_editor();';
   
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
   function combodb(){
    
        $datos = array();
        
        $sql = "SELECT idprov as codigo, razon as nombre 
                  FROM view_crm_incidencias 
                  WHERE sesion=".$this->bd->sqlvalue_inyeccion(trim($this->sesion),true)." 
                  group by idprov,razon order by razon";
		
        echo $this->bd->combodb($sql,'tipo',$datos);
 
 
  }   
    //----------------------------------------------
   function combodbA(){
       
        $datos = array();
       
        $sql = "SELECT idprov as codigo, razon as nombre 
                  FROM view_crm_incidencias  
                  group by idprov,razon order by razon";
		
        echo $this->bd->combodb($sql,'tipoa',$datos);
 
 
  }    
///------------------------------------------------------------------------
//----------------------------------------------
  function combo_lista($tabla ){
      
      if  ($tabla == 'presupuesto.pre_catalogo'){
          
          $sql ="SELECT ' - ' as codigo,' [ Sin Programa ]' as nombre union
                        SELECT codigo as codigo, detalle as nombre
                            FROM  presupuesto.pre_catalogo
                            WHERE estado = 'S' and  categoria = ".$this->bd->sqlvalue_inyeccion('programa'  ,true)."
                        order by 1"   ;
          
          
          
          $resultado = $this->bd->ejecutar($sql);
          
          
          
      }
      
      if  ($tabla == 'items'){

   

        $sql_alimentacion = " union SELECT  trim(cuenta_item) as codigo, ( cuenta_item || ' ' ||  detalle_partida)  as nombre
                                    FROM presupuesto.view_enlace_conta_gasto
                                    where cuenta_item in ('730303','530303') and anio = '2021'
                                    group by cuenta_item, detalle_partida 
                                    order by 1";
          
          $sql ="SELECT ' - ' as codigo,' [ 0. Sin Clasificador ]' as nombre union
                         SELECT trim(clasificador) as codigo, ( clasificador || ' ' ||  detalle)  as nombre
                            FROM presupuesto.view_gasto_nomina_grupo
                            group by clasificador, detalle " . $sql_alimentacion  ;
          
          
          
          $resultado = $this->bd->ejecutar($sql);
          
          
          
      }
      
      //--------------------------------
      
      
      
      if  ($tabla == 'nom_departamento'){
          
          $resultado =  $this->bd->ejecutarLista("id_departamento,nombre",
              $tabla,
              "ruc_registro = ".$this->bd->sqlvalue_inyeccion( trim($this->ruc ) ,true),
              "order by 2");
              
      }
      
      if  ($tabla == 'nom_cargo'){
          
          $resultado =  $this->bd->ejecutarLista("id_cargo,nombre",
              $tabla,
              "-",
              "order by 2");
              
      }
      
      
      if  ($tabla == 'nom_regimen'){
          
          $resultado =  $this->bd->ejecutarLista("regimen,regimen",
              $tabla,
              "activo = ".$this->bd->sqlvalue_inyeccion('S' ,true),
              "order by 2");
              
      }
      
      
      
      
      return $resultado;
      
      
  } 
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
 
   $gestion->Formulario( );

?>
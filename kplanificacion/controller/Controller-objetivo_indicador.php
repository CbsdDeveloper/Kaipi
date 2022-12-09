
<script >// <![CDATA[

   jQuery.noConflict(); 
	
	   // InjQueryerceptamos el evento submit
	    jQuery('#fo411').submit(function() {
	  		// Enviamos el formulario usando AJAX
	        jQuery.ajax({
	            type: 'POST',
	            url: jQuery(this).attr('action'),
	            data: jQuery(this).serialize(),
	            // Mostramos un mensaje con la respuesta de PHP
	            success: function(data) {
	               
			      jQuery('#resultadoIndicador').html(data);
			      
			      busquedaIndicadores ();
	 
	            
				}
	        })        
	        return false;
	    }); 

   
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
       private $POST;
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function componente( ){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd     = 	new Db;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                 
                $this->sesion 	 =  trim($_SESSION['email']);
                
               $this->formulario = 'Model-OO-indicador_uni.php'; 
   
               $this->evento_form = '../model/'.$this->formulario ;        // eventos para ejecucion de editar eliminar y agregar 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
       function Formulario( ){

         $this->set->_formulario_id( $this->evento_form,'inicio','fo411' ); // activa ajax para insertar informacion
   
          
         $tipo = $this->bd->retorna_tipo();
         
         $this->BarraHerramientas();
         
         $datos = array();
         
  
         
         $MATRIZ = array(
             '-'    => '- Seleccionar -',
             'N'    => 'NO',
             'S'    => 'SI'
         );
         $evento =' Onchange="PoneObjetivoI()"';
         $this->obj->list->listae('Publicar',$MATRIZ,'estado2',$datos,'','',$evento,'div-2-10');
          
        
            
         $resultado =  $this->Objetivo();
         $this->obj->list->listadb($resultado,$tipo,'Objetivo Operativo','idobjetivo_indicador',$datos,'required','','div-2-10');
         
         $this->obj->text->text_yellow('Indicador',"texto" ,'indicador' ,150,150, $datos ,'required','','div-2-10') ;
       
         $this->obj->text->text_yellow('<b>Meta</b>',"number" ,'meta' ,150,150, $datos ,'required','','div-2-10') ;
         
         
         $this->obj->text->editor('Detalle','detalle',2,250,250,$datos,'','','div-2-10');
         
         
         
         $this->obj->text->editor('Medio Verificacion','medio',2,250,250,$datos,'','','div-2-10');
         
         $this->set->div_label(12,'<h6>PARAMETROS DEL INDICADOR</h6>');
         
         $MATRIZ = array(
             'mensual'    => 'mensual',
             'trimestral'    => 'trimestral',
             'semestral'    => 'semestral',
             'anual'    => 'anual'
         );
         $evento     = '';
         $this->obj->list->listae('Periodo',$MATRIZ,'periodo',$datos,'','',$evento,'div-2-4');
         
         
         $MATRIZ = array(
             'Porcentual'    => 'Porcentual',
             'Sumatoria'    => 'Sumatoria'
          );
         $evento     = '';
         $this->obj->list->listae('Tipo Formula',$MATRIZ,'tipoformula',$datos,'','',$evento,'div-2-4');
         
         $this->obj->text->text_blue('Formula',"texto" ,'formula' ,150,150, $datos ,'required','','div-2-10') ;
         
         $this->obj->text->text('Variable1',"texto" ,'variable1' ,150,150, $datos ,'required','','div-2-4') ;
         $this->obj->text->text('Variable2',"texto" ,'variable2' ,150,150, $datos ,'required','','div-2-4') ;
       
         
         
         $this->obj->text->texto_oculto("id_departamento_indicador",$datos); 
         
         $this->obj->text->texto_oculto("idperiodo_indicador",$datos); 
         
         $this->obj->text->texto_oculto("anio_indicador",$datos); 
         
         $this->obj->text->texto_oculto("id_idobjetivoindicador",$datos); 
         
         $datos['actionindicador'] = 'add';
         
         $this->obj->text->texto_oculto("actionindicador",$datos); 
         
         $this->set->_formulario_id('-','fin',''); 
 
  
      
   }
   //----------------------------------------------
   function BarraHerramientas(){
 
   
    $eventoa = "anular_iinformacion()";
        
    $ToolArray = array( 
                  array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
                  array( boton => 'Eliminar Transaccion', evento =>$eventoa,  grafico => 'glyphicon glyphicon-trash' ,  type=>"button_danger")
                 );
     
    $this->obj->boton->ToolMenuDivId($ToolArray,'resultadoIndicador'); 
   
 
 
  }  
   //----------------------------------------------
   function header_titulo($titulo){
 
         $this->set->header_titulo($titulo);
 
  }  
 
  //-----------------------------------------------------------------------------------------------------------
  function PerfilSqlPeriodo(){
      
      $resultado =  $this->bd->ejecutarLista( 'idperiodo,detalle',
          'presupuesto.view_periodo',
          "estado = 'ejecucion' ",
          'order by 1,2');
      
      return $resultado;
      
      
  }
  //-----------------------------------------------------------------------------------------------------------
  function Objetivo(){
      
      $sqlb = "SELECT  0 as codigo, '[ 0. Matriz Objetivo Operativo ]'  AS nombre ";
      
      $resultado = $this->bd->ejecutar($sqlb);
      
      
      return $resultado;
      
  }
  //-----------------------------------------------------------------------------------------------------------
  function PerfilSqlUsuario(){
      
      
      
      $x =  $this->bd->query_array('par_usuario',
          'tipo,id_departamento',
          'email='. $this->bd->sqlvalue_inyeccion( $this->sesion,true)
          ) ;
      
      
      $WHERE = "id_departamento = ".$this->bd->sqlvalue_inyeccion( $x['id_departamento'] ,true);
      
      
      
      if (  trim($x['tipo']) == 'admin'  ){
          $WHERE = " nivel >= 1  ";
      }
      
      if (  trim($x['tipo']) == 'planificacion'  ){
          $WHERE = " nivel >= 1   ";
      }
      
      
      $resultado1 =  $this->bd->ejecutarLista( 'id_departamento,nombre',
          'nom_departamento',
          $WHERE,
          'order by  2');
          
          return $resultado1;
          
          
  }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
  }
  
  
  $gestion   = 	new componente;
  
  $gestion->Formulario( );
  
 ?>

  
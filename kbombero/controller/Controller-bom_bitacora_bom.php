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
                
                $this->hoy 	     =  date('Y-m-d');
        
                
               $this->formulario = 'Model-bom_bitacora_bom.php'; 
   
               $this->evento_form = '../model/'. $this->formulario ;        // eventos para ejecucion de editar eliminar y agregar 
      }
      
      //---------------------------------------
      
     function Formulario( ){
      

        $tipo       = $this->bd->retorna_tipo();
        
        $datos      = array();
        
        $datos_usuario = $this->bd->__user($this->sesion);
        
        $responsable = $datos_usuario['responsable'];
        
        $sqld = "SELECT id_departamento as codigo, unidad as nombre
                FROM view_nomina_user
                where estado ='S' and
                      tipo_cargo = 'B' and email = ".$this->bd->sqlvalue_inyeccion($this->sesion, true)."
                 order by 2 ";
        

        if ( $responsable == 'S'){
            
             $sql = "SELECT '-' as codigo, ' --  0. USUARIO GUARDIA  --  ' as nombre UNION
                SELECT  idprov as codigo, upper(completo) as nombre
                FROM view_nomina_user
                where estado ='S' and
                      tipo_cargo = 'B'
                 order by 2 ";
            
        }else{
            $sql = "SELECT  idprov as codigo, upper(completo) as nombre
                FROM view_nomina_user
                where estado ='S' and
                      tipo_cargo = 'B' and email = ".$this->bd->sqlvalue_inyeccion($this->sesion, true)."
                 order by 2 ";
        
            
        }
       
        $resultado  =  $this->bd->ejecutar($sql);

        
      
        
        $resultadod  =  $this->bd->ejecutar($sqld);
        
      
        $MATRIZ_S = array(
            'digitado'    => 'Digitado',
            'autorizado'    => 'Autorizado',
            'anulado'    => 'Anulado'
        );
        
        $MATRIZ_B = array(
            'Primer Peloton'    => 'Primer Peloton',
            'Segundo Peloton'    => 'Segundo Peloton',
            'Tercer Peloton'    => 'Tercer Peloton',
            'Cuarto Peloton'    => 'Cuarto Peloton',
            'Quinto Peloton'    => 'Quinto Peloton'
        );
        
     /*   $MATRIZ_B = array(
            'Primer Turno'    => 'Primer Turno',
            'Segundo Turno'    => 'Segundo Turno',
            'Tercer Turno'    => 'Tercer Turno',
            'Cuarto Turno'    => 'Cuarto Turno',
            'Quinto Turno'    => 'Quinto Turno',
            'Sexto Turno'    => 'Sexto Turno',
            'Septimo Turno'    => 'Septimo Turno',
            'Octavo Turno'    => 'Octavo Turno',
        );
 */
        $datos['usuario'] =  trim($datos_usuario['cedula']);
        
        
        
        
        
        $this->set->evento_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
   
        $this->set->body_tab('Catalogo','inicio');
    
                $this->BarraHerramientas();


                $this->set->div_label(12,'<B>  INFORMACION DE LA BITACORA</B>');	 

               
                $this->obj->text->text_yellow('Codigo',"number" ,'id_bita_bom' ,80,80, $datos ,'required','readonly','div-2-4') ;
                     
                $this->obj->text->text('Fecha',"date" ,'fecha' ,80,80, $datos ,'required','','div-2-4') ;

                $this->obj->list->lista('Estado',$MATRIZ_S,'estado',$datos,'','readonly','div-2-4'); 

                $this->obj->list->listadb($resultadod,$tipo,'<b>Estacion</b>','id_departamento',$datos,'required','readonly','div-2-4');	
                
                $this->obj->list->lista('<b>Peloton/Turno</b>',$MATRIZ_B,'peloton',$datos,'required','','div-2-4'); 
                 
                 
                $this->obj->list->listadb($resultado,$tipo,'Turno','usuario',$datos,'required','','div-2-4');	
                
              
 
                $this->obj->text->editor('Novedad','novedad',3,250,250,$datos,'','','div-2-10');


                $this->set->div_label(12,'<B>  COMPLETE LA INFORMACION DEL DETALLE DE LA BITACORA</B>');	 
 
         $this->obj->text->texto_oculto("action",$datos); 
         
         $this->set->evento_formulario('-','fin'); 
 
  
      
   }
 
   //----------------------------------------------
   function BarraHerramientas(){
 
 
    
   
   $formulario_reporte = '../../reportes/bitacora';

   $eventoi            = "imprimir_informe('".$formulario_reporte."')";
    
   
   $eventoe = "AprobarBitacora()";
   
    $ToolArray = array( 
                array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
                array( boton => 'Imprimir Informe', evento =>$eventoi,  grafico => 'glyphicon glyphicon-print' ,  type=>"button"),
                array( boton => 'Autorizar registro actual',  evento =>$eventoe,  grafico => 'glyphicon glyphicon-ok' ,  type=>"button_danger")
                );
                  
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
  
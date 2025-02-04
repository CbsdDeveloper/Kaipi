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
     
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	     	new Db ;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  date("Y-m-d");  
        
                
               $this->formulario = 'Model-cli_reasignar.php'; 
   
               $this->evento_form = '../model/'. $this->formulario ;         
      }
 
      //---------------------------------------
      
     function Formulario( ){
      
 
        $datos      = array();
 
        $this->set->_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
   
   
                $this->BarraHerramientas();
                     
                /*
                SELECT idcaso,caso,estado,nombre_solicita,
                       unidad,proceso,tarea,
                       idtareactual,
                       sesion_actual,
                       unidad_actual
                from flow.view_proceso_caso
                where idcaso = 42
                */
                
                
                $resultado  = '';
                $tipo 		= $this->bd->retorna_tipo();
                
                $this->set->div_panel7('PROCESO - TAREA ACTUAL');
                
                        $this->obj->text->text('Nro.Tramite',"number",'idcaso',40,45,$datos,'required','readonly','div-2-4') ;
                        
                        $this->obj->text->text('Fecha',"date",'fecha',15,15,$datos,'disabled','readonly','div-2-4');
                        
                        
                        $MATRIZ = array(
                            '1'    => '1. Por Enviar',
                            '2'    => '2. Enviados',
                            '3'    => '3. En ejecucion',
                            '4'    => '4. Terminados',
                            '5'    => '5. Finalizados',
                            '6'    => '6. Anulados',
                        );
                        $this->obj->list->lista('Estado',$MATRIZ,'estado',$datos,'','','div-2-10');
                        
                        
                        
                        $this->obj->text->text('Unidad',"texto",'unidad',70,70,$datos,'required','readonly','div-2-10') ;
                        
                        $this->obj->text->text_yellow('<b>PROCESO</b>',"texto",'proceso',70,70,$datos,'','readonly','div-2-10') ;
                         
                        $this->obj->text->editor('Tarea','tarea',3,70,250,$datos,'','readonly','div-2-10');
               
               $this->set->div_panel7('fin');
                        
               $this->set->div_panel5('<b>REASIGNAR - TAREA ACTUAL</b>');
               
                        $this->obj->list->listadb($resultado,$tipo,'Tarea','idtareactual',$datos,'required','','div-2-10');
               
                        $evento = 'onChange="PoneUsuarios(this.value)"';
                        $this->obj->list->listadbe($resultado,$tipo,'Unidad','unidad_actual',$datos,'required','',$evento,'div-2-10');
                        
                        
                        $sql1 = "SELECT email as codigo,completo as nombre
                            FROM flow.view_proceso_user group by email,completo
                            order by 2";
                                    
                        
                        $resultado = $this->bd->ejecutar($sql1);
                        
                        $this->obj->list->listadb($resultado,$tipo,'Usuario','sesion_actual',$datos,'required','','div-2-10');
                        
                       
             $this->set->div_panel5('fin');
              
             
             $this->set->div_panel7('DOCUMENTO SOLICITADO');
             
        
             $this->obj->text->editor('NECESIDAD CASO','caso',3,70,250,$datos,'','','div-2-10');
             
             
             $this->obj->text->text('SOLICITA',"texto",'nombre_solicita',70,70,$datos,'required','readonly','div-2-10') ;
             
              
            
             
             $this->set->div_panel7('fin');
 		                   
         $this->obj->text->texto_oculto("action",$datos); 
         
             
           
         $this->set->_formulario('-','fin'); 
 
  
      
   }
 
   //----------------------------------------------
   function BarraHerramientas(){
 
       
       $evento = 'javascript:EnviarProceso();';
       $evento1 = 'javascript:FinProceso();';
       
       
       
       $ToolArray = array(
           array( boton => 'Guardar ', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit"),
           array( boton => 'Finalizar ',  evento =>$evento,  grafico => 'glyphicon glyphicon-ok' ,  type=>"button"),
           array( boton => 'Anular ',  evento =>$evento1,  grafico => 'glyphicon glyphicon-record' ,  type=>"button_danger")
       );
       
       
       
       
       $this->obj->boton->ToolMenuDivCrm($ToolArray);
 
  }  
   //----------------------------------------------
   
   function header_titulo($titulo){
 
         $this->set->header_titulo($titulo);
 
  }  
    
  //----------------------------------------------
  function listaValores($titulo,$campo){
  	
    $datos = array();
      
      
  	if  ($titulo == 'Unidad'){
  	 	   $sqlb = " SELECT  id_departamento as codigo,   nombre
							                FROM nom_departamento
							                WHERE id_departamento <> -1 and 
                                                  ruc_registro = ".$this->bd->sqlvalue_inyeccion($this->ruc  ,true)." 
							                order by id_departamento";
		  	
  	 	   
  	 	   
		  
		  	
  	}
  	
  	if  ($titulo == 'Responsable'){
  		$sqlb = "SELECT ltrim(rtrim(x.email))  as codigo ,  ltrim(rtrim(x.completo)) as nombre
		                                            FROM par_usuario x where estado = 'S' ORDER BY x.completo ";
  		
  		
  		
  	}
  	
  	$resultado = $this->bd->ejecutar($sqlb);
  	
  	$tipo = $this->bd->retorna_tipo();
  	
   	
  	$this->obj->list->listadb($resultado,$tipo,$titulo,$campo,$datos,'required','','div-2-10');
  	
  }  
 
 
}
    
 $gestion   = 	new componente;
  
   
  $gestion->Formulario( );
  
 ?>
 <script>
		var posicion_x; 
		var posicion_y; 
			posicion_x=(screen.width/2)-(450/2); 
			posicion_y=(screen.height/2)-(200/2); 

	    	$( document ).ready( function() {
				$("a[rel='pop-up']").click(function () {
					var caracteristicas = "height=220,width=550,scrollTo,resizable=1,scrollbars=1,location=0" + ",left="+posicion_x+",top="+posicion_y;
					nueva=window.open(this.href, 'Popup', caracteristicas);
					return false;
			 });
			 
			posicion_x=(screen.width/2)-(550/2); 
			posicion_y=(screen.height/2)-(350/2); 
			
			 $("a[rel='pop-upo']").click(function () {
					var caracteristicas = "height=350,width=550,scrollTo,resizable=1,scrollbars=1,location=0" + ",left="+posicion_x+",top="+posicion_y;
					nueva=window.open(this.href, 'Popup', caracteristicas);
					return false;
			 });
		});
</script>
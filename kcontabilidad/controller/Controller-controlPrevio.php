<script >// <![CDATA[

    jQuery.noConflict(); 
	jQuery(document).ready(function() {
   // InjQueryerceptamos el evento submit
    jQuery('#form, #fat, #fo3').submit(function() {
  		// Enviamos el formulario usando AJAX
        jQuery.ajax({
            type: 'POST',
            url:  jQuery(this).attr('action'),
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
</script><?php 
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
                
                $this->hoy 	     =     date("Y-m-d");  
        
                $this->anio       =  $_SESSION['anio'];
                
               $this->formulario = 'Model-controlPrevio.php'; 
   
               $this->evento_form = '../model/'.$this->formulario ;        // eventos para ejecucion de editar eliminar y agregar 
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
      
          
        $datos           = array();

        $tipo 		       = $this->bd->retorna_tipo();
        
        $datos           = $this->bd->query_array('view_nomina_user',   // TABLA
                          '*',                        // CAMPOS
                          'sesion_corporativo='.$this->bd->sqlvalue_inyeccion(  $this->sesion,true) // CONDICION
                          );
 
        $MATRIZ = array(
          'Anticipo Viatico'    => 'Anticipo Viatico',
          'Anticipo Remuneracion'    => 'Anticipo Remuneracion',
          'Adquisicion Bienes'    => 'Adquisicion Bienes',
          'Consultoria/Servicios'    => 'Consultoria/Servicios',
          'Otros'    => 'Otros'
         );

         $sql = "SELECT  '0' as codigo,  ' -  0. Seleccionar Unidad Administrativa  - ' as nombre union
         SELECT  id_departamento as codigo ,unidad as nombre
         from view_nomina_user
         group by id_departamento ,unidad order by 2 asc"   ;

        $sql1 = "SELECT  '0' as codigo,  ' -  0. Seleccionar Responsable  - ' as nombre union
        SELECT  email as codigo ,completo as nombre
        from view_nomina_user
        where estado = 'S'
        order by 2 asc"   ;

 

        $MATRIZE = array(
            '1'    => 'Por Enviar',
            '2'    => 'Enviados',
            '3'    => 'En Ejecucion',
            '4'    => 'Terminado',
            '5'    => 'Finalizado',
            '6'    => 'Anulado' 
        );
        


         $resultado       = $this->bd->ejecutar($sql);

         $resultado1       = $this->bd->ejecutar($sql1);
       
         $evento          = 'Onchange="BuscaPersonal(this.value)"';
                 
         $datos['fecha']  = $this->hoy;

        
          
        $this->set->_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
   
     
                $this->BarraHerramientas();
                
                
                $this->set->div_panel6('<b> RESPONSABLE CONTROL PREVIO </b>');


                    $this->obj->text->text_yellow('Caso','number','idcaso',10,10,$datos ,'','readonly','div-2-4') ;
                        
                    $this->obj->text->text('Fecha',"date",'fecha',15,15,$datos,'required','','div-2-4');
                
                    $this->obj->text->text_blue('<b>Funcionario</b>',"texto",'razon',40,45,$datos,'required','readonly','div-2-10');
                            
                    $this->obj->text->text_blue('<b>Identificacion</b>','texto','idprov',10,10,$datos ,'','readonly','div-2-10') ;

                    $this->obj->text->text_blue('<b>Unidad</b>',"texto",'unidad',40,45,$datos,'required','readonly','div-2-10');

                    $this->obj->text->text_blue('<b>Cargo</b>',"texto",'cargo',40,45,$datos,'required','readonly','div-2-10');
                       
                                  
                $this->set->div_panel6('fin');
  


                $this->set->div_panel6('<b> DETALLE NOVEDADES CONTROL PREVIO </b>');
   

                        $this->obj->list->listae('Proceso',$MATRIZ,'categoria',$datos,'required','','','div-2-4');

                        $this->obj->text->text_blue('Nro.Tramite','number','id_tramite',10,10,$datos ,'','','div-2-4') ;
                                                
                        $this->obj->text->editor('Detalle','caso',3,45,350,$datos,'required','','div-2-10') ;
                  
                        $this->obj->list->listadbe($resultado,$tipo,'Unidad','unidad_actual',$datos,'required','',$evento,'div-2-10');
                
                        $this->obj->list->listadbe($resultado1,$tipo,'Enviar a','sesion_siguiente',$datos,'','','','div-2-10');
                        
                          
                        $this->obj->list->listae('Estado',$MATRIZE,'estado',$datos,'required','readonly',$evento,'div-2-4');
                        
               $this->set->div_panel6('fin');
             
                      
              $this->obj->text->texto_oculto("action",$datos); 

              

              $this->obj->text->texto_oculto("id_departamento",$datos); 
         
       
         
         $this->set->_formulario('-','fin'); 
 
  
      
   }
 //-------------
      
   //----------------------------------------------
   function BarraHerramientas(){
 
 
   	$evento     = 'aprobacion()';


    $eventof     = 'FinProceso()'; 
     
 
    $eventop     = 'Actualizar_Proceso()'; 
 
       
    $ToolArray = array( 
                array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
    		    array( boton => 'Iniciar proceso de Control Previo ',  evento =>$evento,  grafico => 'glyphicon glyphicon-ok' ,  type=>"button_success"),
                array( boton => 'Finalizar Control Previo Generado',  evento =>$eventof,  grafico => 'glyphicon glyphicon-record' ,  type=>"button_danger"),
                array( boton => 'Autorizar Control Previo Generado - Anticipos',  evento =>$eventop,  grafico => 'glyphicon glyphicon-warning-sign' ,  type=>"button_info"),
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
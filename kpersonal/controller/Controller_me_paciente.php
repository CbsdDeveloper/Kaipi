<script type="text/javascript" src="formulario_result.js"></script> 
<?php 
    
    session_start( );   
    
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
    require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
 
    
    class Controller_me_paciente{
 
  
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
      function Controller_me_paciente( ){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
            	$this->bd	   =	new Db;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  $this->bd->hoy();
        
                
               $this->formulario = 'Model-nom_ingreso.php'; 
   
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
              
                $MATRIZ = array(
                    '02'    => 'Cedula',
                    '01'    => 'RUC',
                    '03'    => 'Pasaporte'
                );

                $evento = ' ';
                
                $MATRIZ_E =  $this->obj->array->catalogo_activo();
                
                $resultado = $this->bd->ejecutar_catalogo('canton');

                
                $this->obj->list->lista('<b>Tipo</b>',$MATRIZ,'tpidprov',$datos,'required','readonly','div-2-4');
                
             
                $this->obj->text->texte('<b>Identificacion</b>',"texto",'idprov',20,15,$datos,'required','readonly',$evento,'div-2-4') ; 
                
         
                $this->obj->text->text_yellow('<b>Apellido</b>',"texto",'apellido',40,45,$datos,'required','readonly','div-2-4');
                
                $this->obj->text->text_yellow('<b>Nombre</b>',"texto",'nombre',40,45,$datos,'required','readonly','div-2-4');
                
                $this->obj->text->text_blue('Direccion',"texto",'direccion',180,180,$datos,'required','readonly','div-2-10');
            
             
                $this->obj->list->listadb($resultado,$tipo,'Ciudad','idciudad',$datos,'required','readonly','div-2-10');
                
                $this->obj->text->text('Email',"email",'correo',30,45,$datos,'required','readonly','div-2-4');
                
                $this->obj->list->lista('Estado',$MATRIZ_E,'estado',$datos,'required','readonly','div-2-4');
                
                
                $this->obj->text->text('Telefono',"texto",'telefono',40,45,$datos,'required','readonly','div-2-4');
                
                $this->obj->text->text('Movil',"texto",'movil',40,45,$datos,'required','readonly','div-2-4');
                
                $this->set->div_label(12,'<h5><b> DATOS ADICIONALES </b></h5>');
                
                  
                $this->set->nav_tab("#tab_1_1",'Signos Vitales',
                                    "#tab_1_2",'Antecedentes Personales',
                                    "#tab_1_3",'Antecedentes Familiares',
                                    '#tab_1_4','Consultas Medicas',
                                    '',''
                    );
                
                
                $this->K_tab_1_1('Signos Vitales',$tipo);
                
                $this->K_tab_1_2('Antecedentes Personales',$tipo);
                
                $this->K_tab_1_3('Antecedentes Familiares',$tipo);
                
                $this->K_tab_1_4('Consultas Medicas',$tipo);
                
           
                
                $this->set->nav_tab('/');
                
                
              
                      
         $this->obj->text->texto_oculto("action",$datos); 
         
         $this->obj->text->texto_oculto("razon",$datos); 
         
         $this->set->_formulario('-','fin'); 
 
  
      
   }
   //-------------
   function K_tab_1_1($titulo,$tipo){
       
       
        
       $this->set->nav_tabs_inicio("tab_1_1",'active');
           
       echo '<h5>&nbsp;</h5>';
       
       
       
           
       
      
       
       $this->set->frame_fin();
       
       $this->set->nav_tabs_cierre();
   }
   //-------------
   function K_tab_1_2($titulo,$tipo){
       
       
     
       $datos = array();
       
       $this->set->nav_tabs_inicio("tab_1_2",'');
       
      
 
       
       $this->set->frame_fin();
       
       $this->set->nav_tabs_cierre();
   }
   //-------------
   function K_tab_1_3($titulo,$tipo){
         
       
        
       $this->set->nav_tabs_inicio("tab_1_3",'');
       
        
                echo '<div id="ViewCarga"> </div>';
       
       $this->set->frame_fin();
       
       $this->set->nav_tabs_cierre();
   }
   //-------------
    //-------------
   function K_tab_1_4($titulo,$tipo){
       
       
       $this->set->nav_tabs_inicio("tab_1_4",'');
       
       
       $datos = array();
       
      
       
      
       
       $this->set->frame_fin();
       
       
       $this->set->nav_tabs_cierre();
   }
   //----------------------------------------------
   function BarraHerramientas(){
 
 
   
   $formulario_reporte = '../../reportes/ficha_empleado?';
   
   $eventoi = "javascript:imprimir_informe('".$formulario_reporte."')";
  
    
    $ToolArray = array( 
                 array( boton => 'Imprimir Informe', evento =>$eventoi,  grafico => 'glyphicon glyphicon-print' ,  type=>"button")
                );
                  
   $this->obj->boton->ToolMenuDiv($ToolArray); 
 
  }  
   //----------------------------------------------
   function header_titulo($titulo){
 
         $this->set->header_titulo($titulo);
 
  }  
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
///------------------------------------------------------------------------
 }    
   $gestion   = 	new Controller_me_paciente;
 
   $gestion->Formulario( );

 ?>


 
  
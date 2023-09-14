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
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function componente( ){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
            	$this->bd	   =	new Db;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
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

                $MATRIZ_E =  $this->obj->array->catalogo_activo();

                
                $this->obj->list->lista('<b>Tipo</b>',$MATRIZ,'tpidprov',$datos,'required','','div-2-4');
                
                $evento = 'onChange="javascript:validarCiu()"';
                $this->obj->text->texte('<b>Identificacion</b>',"texto",'idprov',20,15,$datos,'required','',$evento,'div-2-4') ; 
                
         
                $this->obj->text->text_yellow('<b>Apellido</b>',"texto",'apellido',40,45,$datos,'required','','div-2-4');
                
                $this->obj->text->text_yellow('<b>Nombre</b>',"texto",'nombre',40,45,$datos,'required','','div-2-4');
                
                $this->obj->text->text_blue('Direccion',"texto",'direccion',180,180,$datos,'required','','div-2-10');
            
                $resultado = $this->bd->ejecutar_catalogo('canton');
                $this->obj->list->listadb($resultado,$tipo,'Ciudad','idciudad',$datos,'required','','div-2-10');
                
                
                
                $this->obj->text->text('Email',"email",'correo',30,45,$datos,'required','','div-2-4');
                $this->obj->list->lista('Estado',$MATRIZ_E,'estado',$datos,'required','','div-2-4');
                
                
                $this->obj->text->text('Telefono',"texto",'telefono',40,45,$datos,'required','','div-2-4');
                
                $this->obj->text->text('Movil',"texto",'movil',40,45,$datos,'required','','div-2-4');
                
                $this->set->div_label(12,'<h5><b> DATOS ADICIONALES </b></h5>');
                
                  
                $this->set->nav_tab("#tab_1_1",'Informacion Actual',
                                    "#tab_1_2",'Informacion Personal',
                                    "#tab_1_3",'Informacion Economica',
                                    '#tab_1_4','Informacion Rol de pagos',
                                    '',''
                    );
                
                
                $this->K_tab_1_1('Informacion Actual',$tipo);
                
                $this->K_tab_1_2('Informacion Personal',$tipo);
                
                $this->K_tab_1_3('Informacion Economica',$tipo);
                
                $this->K_tab_1_4('Informacion Rol de pagos',$tipo);
                
           
                
                $this->set->nav_tab('/');
                
                
              
                      
         $this->obj->text->texto_oculto("action",$datos); 
         
         $this->obj->text->texto_oculto("razon",$datos); 
         
         $this->set->_formulario('-','fin'); 
 
  
      
   }
   //-------------
   function K_tab_1_1($titulo,$tipo){
       
       
       $datos = array();
       
       $this->set->nav_tabs_inicio("tab_1_1",'active');
           
       echo '<h5>&nbsp;</h5>';
       
        
       $resultado =  $this->combo_lista("presupuesto.pre_catalogo");
       $this->obj->list->listadb($resultado,$tipo,'Programa','programa',$datos,'required','','div-2-4');
       
       
      
       $resultado =  $this->combo_lista("nom_departamento");
       $this->obj->list->listadb($resultado,$tipo,'Unidad','id_departamento',$datos,'required','','div-2-4');
       
       
       $resultado =  $this->combo_lista("nom_cargo");
       $this->obj->list->listadb($resultado,$tipo,'Cargo','id_cargo',$datos,'required','','div-2-4');
       
       
       $MATRIZ =  $this->obj->array->catalogo_sino();
       $this->obj->list->lista('Responsable?',$MATRIZ,'responsable',$datos,'required','','div-2-4');
       
      
       
       $resultado =  $this->combo_lista("nom_regimen");
       $this->obj->list->listadb($resultado,$tipo,'Regimen laboral?','regimen',$datos,'required','','div-2-4');
  
       
       $this->obj->text->text('Fecha ingreso',"date",'fecha',15,15,$datos,'required','','div-2-4');
       
       
       $this->obj->text->text('Nro.Documento',"texto",'contrato',30,30,$datos,'required','','div-2-4');
       
       $this->obj->text->text('Email Corporativo',"email",'emaile',50,50,$datos,'','','div-2-4');
 
       $this->obj->text->text('Sueldo',"number",'sueldo',40,45,$datos,'required','','div-2-4') ;
       
           
       
      
       
       $this->set->frame_fin();
       
       $this->set->nav_tabs_cierre();
   }
   //-------------
   function K_tab_1_2($titulo,$tipo){
       
       
     
       $datos = array();
       
       $this->set->nav_tabs_inicio("tab_1_2",'');
       
     
       
       $this->obj->text->texto_oculto("foto",$datos); 
       
       $file = "javascript:openFile('../../upload/CargaFoto?file=2',650,300)";
       
       $path_imagen = '<a href="#" onClick="'.$file.'">';
       
       echo '<div class="col-md-10" style="padding-bottom:5px; padding-top:5px">'.$path_imagen.'
                    			<img id="ImagenUsuario" width="100" height="100"></a>
                    		</div>';
       
       
       $this->set->div_label(12,' Informacion Personal');
       
       $this->obj->text->text('Nacimiento',"date",'fechan',15,15,$datos,'required','','div-2-4');
       
       
       $MATRIZ =  $this->obj->array->catalogo_ecivil();
       $this->obj->list->lista('Estado Civil',$MATRIZ,'ecivil',$datos,'required','','div-2-4');
       
       
       
       $MATRIZ =  $this->obj->array->catalogo_nacionalidad();
       $this->obj->list->lista('Nacionalidad',$MATRIZ,'nacionalidad',$datos,'required','','div-2-4');
       
     
       $MATRIZ =  $this->obj->array->catalogo_etnia();
       $this->obj->list->lista('Etnia',$MATRIZ,'etnia',$datos,'required','','div-2-4');
       
 
       
       $MATRIZ =  $this->obj->array->catalogo_vivecon();
       $this->obj->list->lista('Vive con',$MATRIZ,'vivecon',$datos,'required','','div-2-4');
 
       
     
           $MATRIZ = array(
               '0'    => 'No Aplica',
               '1'    => '1 Persona',
               '2'    => '2 Personas',
               '3'    => '3 Personas',
               '4'    => '4 Personas',
               '5'    => '5 Personas',
               '6'    => '6 Personas'
           );
       $this->obj->list->lista('Cargas Familiares',$MATRIZ,'cargas',$datos,'required','','div-2-4');
       
       
       $MATRIZ =  $this->obj->array->catalogo_tipo_sangre();
       $this->obj->list->lista('Tipo de Sangre',$MATRIZ,'tsangre',$datos,'required','','div-2-4');
       

       $MATRIZ = array(
           '-'    => 'No Ninguna',
           'Intelectual' => 'Intelectual',
           'Sustituto'    => 'Sustituto',
           'Discapacidad fisica'    => 'Discapacidad fisica',
           'Discapacidad auditiva'    => 'Discapacidad auditiva',
           'Discapacidad visual'    => 'Discapacidad visual',
           'Multidiscapidad'    => 'Multidiscapidad'
       );
       $this->obj->list->lista('Discapacidad',$MATRIZ,'discapacidad',$datos,'required','','div-2-4');
       
       
       
       
       $MATRIZ = array(
           'M'    => 'Masculino',
           'F'    => 'Femenino' 
       );
       $this->obj->list->lista('Genero',$MATRIZ,'genero',$datos,'required','','div-2-4');
       
       
       $this->set->div_label(12,' Informacion Academica');
       
       $MATRIZ = array(
           'No Aplica'    => 'No Aplica',
           'Primaria'    => 'Primaria',
           'Secundaria'    => 'Secundaria',
           'Bachiller'    => 'Bachiller',
           'Tercer Nivel'    => 'Tercer Nivel',
           'Cuarto Nivel'    => 'Cuarto Nivel' 
       );
         
       $this->obj->list->lista('Nivel Estudio',$MATRIZ,'estudios',$datos,'required','','div-2-4');
       
     
       $MATRIZ = array(
           'No Aplica'    => 'No Aplica',
           'Tecnologo'    => 'Tecnologo',
           'Ingeniero'    => 'Ingeniero',
           'Licenciado'    => 'Licenciado',
           'Disenador'    => 'Disenador',
           'Psicologo'    => 'Psicologo',
           'Abogado'    => 'Abogado',
           'Arquitecto'    => 'Arquitecto',
           'Doctor'    => 'Doctor',
           'Tecnico'    => 'Tecnico',
           'Entrenador'    => 'Entrenador',
        );
       
       $this->obj->list->lista('Titulo Obtenido',$MATRIZ,'titulo',$datos,'required','','div-2-4');
       
       
       $this->obj->text->text('Carrera',"texto",'carrera',80,80,$datos,'required','','div-2-4');
       
       
       
       $this->set->div_label(12,' Seguridad y Salud Ocupacional');
       
       $this->obj->text->text('Tiempo llegada a casa',"texto",'recorrido',80,80,$datos,'required','','div-3-9');
       
       $this->obj->text->editor('Recorrido referencia','tiempo',4,45,450,$datos,'required','','div-3-9') ;
       
       
     
       
 
       
       $this->set->frame_fin();
       
       $this->set->nav_tabs_cierre();
   }
   //-------------
   function K_tab_1_3($titulo,$tipo){
         
       
       $datos = array();
       
       $this->set->nav_tabs_inicio("tab_1_3",'');
       
       echo '<h5>&nbsp;</h5>';
       
       $resultado = $this->bd->ejecutar("SELECT idcatalogo as codigo, nombre FROM par_catalogo where tipo = 'bancos' ");
       $this->obj->list->listadb($resultado,$tipo,'Entidad Bancaria','id_banco',$datos,'required','','div-2-10');
       
       
       $MATRIZ =  $this->obj->array->nom_tipo_banco();
       $this->obj->list->lista('Tipo Cuenta',$MATRIZ,'tipo_cta',$datos,'required','','div-2-10');
       
       
       $this->obj->text->text('Nro.Cuenta',"texto",'cta_banco',30,30,$datos,'required','','div-2-4');
       
 
       $cadena = ' <button class="btn btn-default btn-xs" data-toggle="modal" data-target="#myModalCarga">
                    <i class="glyphicon glyphicon-plus"></i></button>';
       
       $this->set->div_labelmin(12,$cadena.' Cargas Familiares / Retencion Judicial');
       
       echo '<div id="ViewCarga"> </div>';
       
       $this->set->frame_fin();
       
       $this->set->nav_tabs_cierre();
   }
   //-------------
    //-------------
   function K_tab_1_4($titulo,$tipo){
       
       
       $this->set->nav_tabs_inicio("tab_1_4",'');
       
       $this->set->div_labelmin(12,'Acumulacion de Beneficios de Ley');
       
       $datos = array();
       
       $MATRIZ =  $this->obj->array->catalogo_sino();
       
     
     
       $this->obj->list->lista('Fondos Reserva?',$MATRIZ,'sifondo',$datos,'required','','div-3-3');
       $this->obj->list->lista('Decimo tercero?',$MATRIZ,'sidecimo',$datos,'required','','div-3-3');
       $this->obj->list->lista('Decimo Cuarto?',$MATRIZ,'sicuarto',$datos,'required','','div-3-3');
       

 
       $this->set->div_labelmin(12,' Autorizaciones - Permisos / Horas ');
       
       $this->obj->list->lista('Horas Extras/Suplementarias?',$MATRIZ,'sihoras',$datos,'required','','div-3-3');
       $this->obj->list->lista('Subrogacion?',$MATRIZ,'sisubrogacion',$datos,'required','','div-3-3');
       
       $this->set->div_labelmin(12,' Deducibles Impuesto a la Renta');
       
       $this->obj->text->text('Vivienda',"number",'vivienda',40,45,$datos,'required','','div-2-4') ;
       
       $this->obj->text->text('Salud',"number",'salud',40,45,$datos,'required','','div-2-4') ;
       
       $this->obj->text->text('Alimentacion',"number",'alimentacion',40,45,$datos,'required','','div-2-4') ;
       
       $this->obj->text->text('Vestimenta',"number",'vestimenta',40,45,$datos,'required','','div-2-4') ;
       
       $this->obj->text->text('Educacion',"number",'educacion',40,45,$datos,'required','','div-2-4') ;
       
       $this->obj->text->text('Turismo',"number",'turismo',40,45,$datos,'required','','div-2-4') ;
       

       $MATRIZ = array(
        '0'    => 'NO APLICA',
        '60'    => 'De 30% al 49%' ,
        '70'    => 'De 50% al 74%' ,
        '80'    => 'De 75% al 84%' ,
        '100'    => 'De 85% y más' ,
    );
   


       $this->set->div_label(12,'Rebaja por gastos personales ');


       $this->obj->list->lista('Deducción discapacidad:',$MATRIZ,'de_disca',$datos,'required','','div-8-4');

       $MATRIZ =  $this->obj->array->catalogo_sino();
       $this->obj->list->lista('Deducción Tercera Edad:',$MATRIZ,'de_edad',$datos,'required','','div-8-4');


       $this->obj->list->lista('¿Usted o alguna carga familiar padece una enfermedad catastrófica, rara y/o huérfana?',$MATRIZ,'de_enfer',$datos,'required','','div-8-4');
      
       $this->obj->text->text('Número de cargas familiares (que no perciban ingresos gravados y sean dependientes del sujeto pasivo)',"number",'de_carga',40,45,$datos,'required','','div-8-4') ;



       $this->set->div_label(12,'<h5>(*) Aplica funcionario cumple con el tiempo del beneficio del Fondo de Reserva</h5>');
 
       $this->obj->list->lista('Fondos Reserva(*)',$MATRIZ,'fondo',$datos,'required','','div-3-3');
       
       
       $this->set->div_label(12,'<h5>Fin de Gestion </h5>');
       
       
       $this->obj->text->editor('Motivo','motivo',4,45,450,$datos,'','readonly','div-2-10') ;
       
       $this->obj->text->text_yellow('Fecha Salida',"date",'fecha_salida',15,15,$datos,'','readonly','div-2-4');
       
       
      
       
      
       
       $this->set->frame_fin();
       
       
       $this->set->nav_tabs_cierre();
   }
   //----------------------------------------------
   function BarraHerramientas(){
 
 
   
   $formulario_reporte = '../../reportes/ficha_empleado?';
   
   $eventoi = "javascript:imprimir_informe('".$formulario_reporte."')";
  
   $evento =  "javascript:valida()";
   
    $ToolArray = array( 
                array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                array( boton => 'Guardar Registros', evento =>$evento, grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
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
   $gestion   = 	new componente;
 
   $gestion->Formulario( );

 ?>


 
  
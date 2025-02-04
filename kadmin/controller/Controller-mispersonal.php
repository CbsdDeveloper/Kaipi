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
                   
                $this->bd	   =	     	new Db ;
             
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
 
     function Formulario( ){


        $x = $this->bd->query_array('view_nomina_user',   // TABLA
        'completo ,cargo ,unidad ,regimen,idprov',                        // CAMPOS
        'email='.$this->bd->sqlvalue_inyeccion($this->sesion,true) .' or 
        sesion_corporativo='.$this->bd->sqlvalue_inyeccion($this->sesion,true)
        );


        $datos = $this->bd->query_array('view_nomina_rol',   // TABLA
        '*',                        // CAMPOS
        'idprov='.$this->bd->sqlvalue_inyeccion( trim($x['idprov']),true));
         


        $this->set->div_label(12,' Información del Funcionario');
       
      
 
        echo '<h4>';
        echo  '<b>'.$x['completo'].'</b><br>'.$x['regimen'].'<br>'.$x['unidad'].'<br>'.$x['cargo'];
        echo '</h4>';

        $this->set->_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion


        $this->obj->text->texto_oculto("idprov",$datos); 

        $this->obj->text->texto_oculto("razon",$datos); 


                    $this->obj->text->text_blue('Direccion',"texto",'direccion',180,180,$datos,'required','','div-2-10');
                     
                    $this->obj->text->text('Email',"email",'correo',30,45,$datos,'required','','div-2-4');
                    
                    $this->obj->text->text('Telefono',"texto",'telefono',40,45,$datos,'required','','div-2-4');
                    
                    $this->obj->text->text('Movil',"texto",'movil',40,45,$datos,'required','','div-2-4');
 
      

        $this->set->div_label(12,' Mi Información Personal');


                    $this->obj->text->text('Nacimiento',"date",'fechan',15,15,$datos,'required','','div-2-10');
                
                
                    $MATRIZ =  $this->obj->array->catalogo_ecivil();
                    $this->obj->list->lista('Estado Civil',$MATRIZ,'ecivil',$datos,'required','','div-2-10');
            
                    
                    $MATRIZ =  $this->obj->array->catalogo_nacionalidad();
                    $this->obj->list->lista('Nacionalidad',$MATRIZ,'nacionalidad',$datos,'required','','div-2-10');
                    
                
                    $MATRIZ =  $this->obj->array->catalogo_etnia();
                    $this->obj->list->lista('Etnia',$MATRIZ,'etnia',$datos,'required','','div-2-10');
                    
            
                    
                    $MATRIZ =  $this->obj->array->catalogo_vivecon();
                    $this->obj->list->lista('Vive con',$MATRIZ,'vivecon',$datos,'required','','div-2-10');
  
        
      
                                $MATRIZ = array(
                                    '0'    => 'No Aplica',
                                    '1'    => '1 Persona',
                                    '2'    => '2 Personas',
                                    '3'    => '3 Personas',
                                    '4'    => '4 Personas',
                                    '5'    => '5 Personas',
                                    '6'    => '6 Personas'
                                );
                            $this->obj->list->lista('Cargas Familiares',$MATRIZ,'cargas',$datos,'required','','div-2-10');
                            
                            
                            $MATRIZ =  $this->obj->array->catalogo_tipo_sangre();
                            $this->obj->list->lista('Tipo de Sangre',$MATRIZ,'tsangre',$datos,'required','','div-2-10');
                            
                    
                            $MATRIZ = array(
                                '-'    => 'No Ninguna',
                                'Intelectual' => 'Intelectual',
                                'Sustituto'    => 'Sustituto',
                                'Discapacidad fisica'    => 'Discapacidad fisica',
                                'Discapacidad auditiva'    => 'Discapacidad auditiva',
                                'Discapacidad visual'    => 'Discapacidad visual',
                                'Multidiscapidad'    => 'Multidiscapidad'
                            );
                            $this->obj->list->lista('Discapacidad',$MATRIZ,'discapacidad',$datos,'required','','div-2-10');
                            
                            
                            
                            
                            $MATRIZ = array(
                                'M'    => 'Masculino',
                                'F'    => 'Femenino' 
                            );
                            $this->obj->list->lista('Genero',$MATRIZ,'genero',$datos,'required','','div-2-10');
        
        
        $this->set->div_label(12,' Informacion Academica');
        
                            $MATRIZ = array(
                                'No Aplica'    => 'No Aplica',
                                'Primaria'    => 'Primaria',
                                'Secundaria'    => 'Secundaria',
                                'Bachiller'    => 'Bachiller',
                                'Tercer Nivel'    => 'Tercer Nivel',
                                'Cuarto Nivel'    => 'Cuarto Nivel' 
                            );
                            
                            $this->obj->list->lista('Nivel Estudio',$MATRIZ,'estudios',$datos,'required','','div-2-10');
                            
                        
                            $MATRIZ = array(
                                'No Aplica'    => 'No Aplica',
                                'Tecnologo'    => 'Tecnologo',
                                'Ingeniero'    => 'Ingeniero',
                                'Licenciado'    => 'Licenciado',
                                'Disenador'    => 'Disenador',
                                'Abogado'    => 'Abogado',
                                'Arquitecto'    => 'Arquitecto',
                                'Doctor'    => 'Doctor',
                                'Tecnico'    => 'Tecnico',
                                'Entrenador'    => 'Entrenador',
                            );
                            
                            $this->obj->list->lista('Titulo Obtenido',$MATRIZ,'titulo',$datos,'required','','div-2-10');
                            
                            
                            $this->obj->text->text('Carrera',"texto",'carrera',80,80,$datos,'required','','div-2-10');
        
        $this->set->div_label(12,' Información Económica - Proyección de Gastos Personales');
            $this->obj->text->text('Vivienda',"number",'vivienda',40,45,$datos,'required','','div-2-4');
            $this->obj->text->text('Salud',"number",'salud',40,45,$datos,'required','','div-2-4');
            $this->obj->text->text('Alimentacion',"number",'alimentacion',40,45,$datos,'required','','div-2-4');
            $this->obj->text->text('Vestimenta',"number",'vestimenta',40,45,$datos,'required','','div-2-4');
            $this->obj->text->text('Educacion',"number",'educacion',40,45,$datos,'required','','div-2-4');
            $this->obj->text->text('Turismo',"number",'turismo',40,45,$datos,'required','','div-2-4');

        
        $this->set->div_label(12,' Seguridad y Salud Ocupacional');
        
                            $this->obj->text->text('Tiempo llegada a casa',"texto",'recorrido',80,80,$datos,'required','','div-3-9');
                            
                            $this->obj->text->editor('Recorrido referencia','tiempo',4,45,450,$datos,'required','','div-3-9');
        

        $this->set->_formulario('-','fin'); 


   }




   
 
 ///------------------------------------------------------------------------
///------------------------------------------------------------------------
  }
  ///------------------------------------------------------------------------
  ///------------------------------------------------------------------------
   
  
  $gestion   = 	new componente;
  
   
  $gestion->Formulario( );
  
 ?>
 
  
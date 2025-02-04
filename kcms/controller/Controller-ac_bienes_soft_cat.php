<?php 
     session_start( );   
  
    require '../../kconfig/Db.class.php';  
 	
    require '../../kconfig/Obj.conf.php';  
    
    require '../../kconfig/Set.php';  
  
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
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =     date("Y-m-d");  
        
                $this->anio       =  $_SESSION['anio'];
                
    
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
                
    
                
                
                $MATRIZ = array(
                    'Software de sistema'   =>  'Software de sistema' ,
                    'Software de aplicacion'    => 'Software de aplicacion',
                    'Software de programacion'    => 'Software de programacion'
                );
                
                
                
                $evento='';
                $this->obj->list->listae('Tipo',$MATRIZ,'tipo',$datos,'','',$evento,'div-2-4');
                
                
                $MATRIZ = array(
                    'Sistemas Operativos'    => 'Sistemas Operativos',
                    'Aplicaciones de ofimatica'    => 'Aplicaciones de ofimatica',
                    'Bases de Datos'    => 'Bases de Datos',
                    'Empresarial'    => 'Empresarial',
                    'Educativo'    => 'Educativo',
                    'Control'    => 'Control'
                );
                
                        
                $this->obj->list->listae('Categoria',$MATRIZ,'categoria',$datos,'','',$evento,'div-2-4');
                
                
 
                $this->obj->text->text('Software',"texto",'detalle_soft',220,220,$datos,'required','','div-2-10') ;
          
                
                $MATRIZ = array(
                    'Software libre'    => 'Software libre',
                    'Copyleft'    => 'Copyleft',
                    'GPL'    => 'GPL',
                    'Debian'    => 'Debian',
                    'Dominio publico'    => 'Dominio publico',
                    'Freeware'    => 'Freeware',
                    'Comercial'    => 'Comercial',
                    'Trial'    => 'Trial'
                );
                
                
                $this->obj->list->listae('Licencias',$MATRIZ,'licencia',$datos,'','',$evento,'div-2-4');
           
                
 		                   
         $this->obj->text->texto_oculto("action",$datos); 
         
         $this->obj->text->texto_oculto("id_software",$datos); 
 
         $this->set->_formulario('-','fin'); 
 
  
      
   }
 
   //----------------------------------------------
   function BarraHerramientas(){
 
 
       
 
       $eventoi = 'javascript:GuardarSoftware()"';
 
    $ToolArray = array( 
                  array( boton => 'Guardar Registros', evento =>$eventoi,  grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"button_default") 
                 );
                  
   $this->obj->boton->ToolMenuDiv($ToolArray); 
 
  }  
//----------------------------------------------
   function header_titulo($titulo){
 
         $this->set->header_titulo($titulo);
 
  }  
 //----------------------------------------------
}
  
 $gestion   = 	new componente;
  
 $gestion->Formulario( );
  
?>
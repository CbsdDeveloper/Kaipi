<?php 
    session_start( );   
    
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
  	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
    require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
  
    class componente{
 
      //creamos la variable donde se instanciar? la clase "mysql"
 
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
        
           
      }
    
    
      //---------------------------------------
      
     function Formulario( ){
      
 
         $this->set->div_panel('<b> CONFIGURACION DE FIRMA ELECTRONICA  </b>');
 
         
         $datos['email1'] =  $this->sesion  ;
         
         $Asmpt = $this->bd->query_array('par_usuario',
                                              'smtp1, puerto1, acceso1', 
                                              'email='.$this->bd->sqlvalue_inyeccion( $datos['email1'] ,true)
             );
         
         
         $datos['smtp1']   = $Asmpt['smtp1'] ;
         $datos['puerto1'] = '-'; 
         
         $datos['acceso1'] = base64_decode($Asmpt['acceso1']) ;
         
         $this->obj->text->text('Email',"email",'email1',100,100,$datos,'required','readonly','div-2-10');
         
         $this->obj->text->text('Archivo (*.p12)',"texto",'smtp1',40,45,$datos,'','','div-2-10');
         
          
         $this->obj->text->text('Acceso',"password",'acceso1',80,80,$datos,'','readonly','div-2-10');
         
         
         $this->obj->text->texto_oculto("puerto1",$datos); 
         
         
         $this->set->div_panel('fin');
 
 
    
      
   }
   //----------------------------------------------
   function BarraHerramientas(){
 
     
    $ToolArray = array( 
                 array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit")  
                 );
                  
   $this->obj->boton->ToolMenuDiv($ToolArray); 
 
  }  
   //----------------------------------------------
   function header_titulo($titulo){
 
         $this->set->header_titulo($titulo);
 
  }  
  //----------------------------------------------
  function pathFile($id ){
      
      
      $ACarpeta = $this->bd->query_array('wk_config',
          'carpetasub',
          'tipo='.$this->bd->sqlvalue_inyeccion($id,true)
          );
      
      $carpeta = trim($ACarpeta['carpetasub']);
      
      return $carpeta;
      
  }
  //----------------------------------------------
  function consultaId(  ){
      
      
      
      $qquery = array(
          array( campo => 'idusuario',   valor =>'-' ,  filtro => 'N',   visor => 'S'),
          array( campo => 'login',   valor => '-',  filtro => 'N',   visor => 'S'),
          array( campo => 'email',   valor => $this->sesion,  filtro => 'S',   visor => 'S'),
          array( campo => 'cedula',   valor => '-',  filtro => 'N',   visor => 'S'),
          array( campo => 'idusuario',   valor => '-',  filtro => 'N',   visor => 'S'),
          array( campo => 'url',   valor => '-',  filtro => 'N',   visor => 'S')
      );
      
      
      $datos = $this->bd->JqueryArrayVisorDato('par_usuario',$qquery );
      
       return $datos;
  }	
  //-------------------------------------------
 }    
   $gestion   = 	new componente;
 
   $gestion->Formulario( );

 
   
 ?>


 
  
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
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
                
               $this->formulario = 'admin_permiso.php'; 
   
               $this->evento_form = 'model/admin_permiso.php';        // eventos para ejecucion de editar eliminar y agregar 
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
      
 
        $this->set->evento_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
   
        $this->set->body_tab($titulo,'inicio');
 
    
                $this->BarraHerramientas();
                
                                     
                    $this->obj->text->text('Id',"number",'idusuario',0,10,$datos,'','readonly','div-2-4') ; 
                    
                    $this->obj->text->text('Login',"texto",'login',20,15,$datos,'required','','div-2-4') ; 
                                  
                    $this->obj->text->text('Email',"email",'email',30,45,$datos,'required','','div-2-4');
                    
                    $this->obj->text->text('Nombre',"texto",'nombre',40,45,$datos,'required','','div-2-4');
                   
                    $this->obj->text->text('Apellido',"texto",'apellido',40,45,$datos,'required','','div-2-4');
                    
           
                    $evento = 'onChange="AsignaModulo(this.value,'.'0'.')"';
	
	                $resultado = $this->bd->ejecutar("select 0 as codigo,'No aplica' as nombre 
                                from par_modulos 
                                where id_par_modulo =  1
                                union select id_par_modulo as codigo,modulo as nombre
                                from par_modulos 
                                where fid_par_modulo = 0 and estado = 'S' order by 1");
                                
	                $tipo = $this->bd->retorna_tipo();
                    
                    $this->obj->list->listadbe($resultado,$tipo,'Modulo','id_par_modulo',$datos,'required','',$evento,'div-2-4');
            
                    $this->set->div_label(12,'<h5>Opciones Disponibles</h5>');
                    
                    
                    echo '<div class="col-md-6" id="modulo"></div>';
   
                    echo '<div class="col-md-6" id="asignado">asignado</div>';
 
    
 
         $this->obj->text->texto_oculto("action",$datos); 
         
         $this->set->evento_formulario('-','fin'); 
 
  
      
   }
   //----------------------------------------------
   function BarraHerramientas(){
 
 
 
   $eventoi = "javascript:window.print();";
    
   
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
   function combodb(){
    
        $sql = "SELECT idprov as codigo, razon as nombre 
                  FROM view_crm_incidencias 
                  WHERE sesion=".$this->bd->sqlvalue_inyeccion(trim($this->sesion),true)." 
                  group by idprov,razon order by razon";
		
        echo $this->bd->combodb($sql,'tipo',$datos);
 
 
  }   
    //----------------------------------------------
   function combodbA(){
    
        $sql = "SELECT idprov as codigo, razon as nombre 
                  FROM view_crm_incidencias  
                  group by idprov,razon order by razon";
		
        echo $this->bd->combodb($sql,'tipoa',$datos);
 
 
  }    
  
  
///------------------------------------------------------------------------
///------------------------------------------------------------------------
  }    

 
   $gestion   = 	new componente;
    
   $gestion->Formulario();
   
   ?>
  
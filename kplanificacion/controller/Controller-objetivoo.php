<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/jquery-ui.js"></script>
<link rel="stylesheet" href="../js/jquery-ui.css" type="text/css" />
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
                   
                $this->bd     = 	new Db;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                 
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  $this->bd->hoy();
        
                
               $this->formulario = 'Model-OO.php'; 
   
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

         
        $this->set->_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
   
        $tipo       = $this->bd->retorna_tipo();
        $datos      = array();
       
           
        $this->BarraHerramientas();
        
        $this->set->div_label(12,'<h5>PERIODO DE LA PLANIFICACION</h5>');
        
         
        $datos['idperiodo'] = $_SESSION['id_periodo'];
        
        $resultado =  $this->PerfilSqlPeriodo(); 
        $this->obj->list->listadb($resultado,$tipo,'Periodo','idperiodo',$datos,'required','','div-2-10');
 
 
        $datos['idperiodo'] = $_SESSION['id_periodo'];
          
        
        
        $MATRIZ = array(
            'N'    => 'NO',
            'S'    => 'SI'
        );
        $evento     = 'Onchange="ListaDes()"';
        $this->obj->list->listae('Publicar',$MATRIZ,'estado',$datos,'','',$evento,'div-2-4');
      
        $this->set->div_label(12,'<h5>ARTICULACION OBJETIVO ESTRATEGICO</h5>');
          
        
        $resultado =  $this->Objetivoe();
        $this->obj->list->listadb($resultado,$tipo,'Objetivo Estrategico','idestrategia',$datos,'required','','div-2-10');
        
        
        
        $resultado =  $this->PerfilSqlUsuario();
        $this->obj->list->listadb($resultado,$tipo,'Unidad Administrativa','id_departamento',$datos,'required','','div-2-10');
        
        
        $this->obj->text->editor('Objetivo Operativo','objetivo',3,350,350,$datos,'','','div-2-10');
        
        
        $MATRIZ = array(
            'Comunidad'    => 'Comunidad',
            'Institucional'    => 'Institucional',
            'Servicios'    => 'Servicios'
        );
        $this->obj->list->listae('Ambito',$MATRIZ,'ambito',$datos,'','',$evento,'div-2-4');
        
        
        $MATRIZ = array(
            'Desarrollo regional'    => 'Desarrollo regional',
            'Desarrollo Local'    => 'Desarrollo Local',
            'Fomentar las actividades productivas'    => 'Fomentar las actividades productivas',
            'Cumplimiento de sus competencias'    => 'Cumplimiento de sus competencias',
        );
        $this->obj->list->listae('Aporte a',$MATRIZ,'aporte',$datos,'','',$evento,'div-2-4');
        
        
      
        $this->obj->text->texto_oculto("action",$datos); 
                
        $this->obj->text->texto_oculto("idobjetivo",$datos); 
 
        $this->obj->text->texto_oculto("anio",$datos); 
        
    
         $this->set->_formulario('-','fin'); 
 
  
      
   }
   //----------------------------------------------
   function BarraHerramientas(){
 
   
   
       $eventoModal='javascript:verifica_oo()';
       $eventocc= '#myModalPlan-'.$eventoModal;
   
       
       
       $ToolArray = array(
           array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
           array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
           array( boton => 'Matriz de Objetivos ', evento =>$eventocc,  grafico => 'glyphicon glyphicon-bed' ,  type=>"modal") ,
           
       );
       
       $this->obj->boton->ToolMenuDiv($ToolArray); 
 
  }  
  
  //-----------------------------------------------------------------------------------------------------------
  function PerfilSqlPeriodo(){
  	
      $resultado =  $this->bd->ejecutarLista( 'idperiodo,detalle',
          'presupuesto.view_periodo',
          "tipo  <>".$this->bd->sqlvalue_inyeccion('cierre',true). " and
                                                   estado <>".$this->bd->sqlvalue_inyeccion('cierre',true),
          'order by 1,2');
      
      
      
      
      return $resultado;
  	
  	
  }
  //-----------------------------------------------------------------------------------------------------------
  function Objetivoe(){
      
      $sqlb = "SELECT  0 as codigo, '[ 0. Matriz Objetivo Estrategico ]'  AS nombre union
                    SELECT  idestrategia as codigo, '[' || nivel ||'] ' || SUBSTR(objetivoe,1,200) AS nombre
                    FROM  planificacion.pyestrategia
                    where univel = 'S'  and
                          estado =".$this->bd->sqlvalue_inyeccion('S', true).' order by 1';
      
      $resultado = $this->bd->ejecutar($sqlb);
      
     
      return $resultado;
      
  }
  //-----------------------------------------------------------------------------------------------------------
  function PerfilSqlUsuario(){
  	
  	 	
      $x =  $this->bd->query_array('par_usuario',
          '*',
          'email='. $this->bd->sqlvalue_inyeccion( $this->sesion,true)
          ) ;
      
      
      $WHERE = "id_departamento = ".$this->bd->sqlvalue_inyeccion( $x['id_departamento'] ,true);
      
      
      
      
      if (trim($x['responsable']) == 'S'){
          $WHERE = "nivel > 0  and id_departamento = ".$this->bd->sqlvalue_inyeccion( $x['id_departamento'] ,true);
      }
      
      
      if (  trim($x['tipo']) == 'admin'  ){
          $WHERE = "nivel > 0";
      }
      if (  trim($x['tipo']) == 'planificacion'  ){
          $WHERE = "nivel > 0";
      }
      
      $resultado1 =  $this->bd->ejecutarLista( 'id_departamento,nombre',
          'nom_departamento',
          $WHERE,
          'order by  2');
          
          return $resultado1;
  	
  	
  }
   //----------------------------------------------
   function header_titulo($titulo){
 
         $this->set->header_titulo($titulo);
 
  }  
 
  
///------------------------------------------------------------------------
///------------------------------------------------------------------------
  }
  
  
  $gestion   = 	new componente;
  
  $gestion->Formulario( );
  
 ?>
 
 
  
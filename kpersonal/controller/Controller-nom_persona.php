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
                
               echo '<div id="Ficha" class="col-md-12" style="padding: 15px;" ></div>';
         
         $this->set->_formulario('-','fin'); 
 
  
      
   }
   //-------------
   
   //----------------------------------------------
   function BarraHerramientas(){
 
 
 
   
   $eventoi = "javascript:imprimir_informe()";
    
   
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
   $gestion   = 	new componente;
 
   $gestion->Formulario( );

 ?>
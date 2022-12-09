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
	               
	            	 jQuery('#result').html('<div class="alert alert-info">'+ data + '</div>');
	                 jQuery( "#result" ).fadeOut( 1600 );
	                 jQuery("#result").fadeIn("slow");

	                 VisorObjetivos();
	                 VisorActividad();
	            
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
                   
                $this->bd     = 	new Db;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                 
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  $this->bd->hoy();
                 
               $this->formulario = 'Model-ActividadPOA.php'; 
   
               $this->evento_form = '../model/'.$this->formulario ;        // eventos para ejecucion de editar eliminar y agregar 
      }
   
      //---------------------------------------
      
     function Formulario( ){

      
         $tipo = $this->bd->retorna_tipo();
           
         $datos = array();
         
 

       

      


        $MATRIZ_S = array(
            'S'    => 'SI',
            'N'    => 'NO'
        );

        
           
        $resultado =  $this->Objetivoo();

        $resultado1 =  $this->Objetivoi();
        

        $this->set->_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion

            
        $this->BarraHerramientas();
         
                 echo '<div id="UnidadSeleccionadaActividad" style="padding: 3px"></div>';
                
                 $evento = ' Onchange="poneObjetivosIndicadores( )" ';
                 
                 $this->obj->list->listadbe($resultado,$tipo,'Objetivo Operativo','idobjetivo',$datos,'required','',$evento,'div-2-10');
        
         
                 $this->obj->text->editor('Actividad','actividad',3,250,250,$datos,'','','div-2-10');
                 
                 $this->obj->text->text('Entregable',"texto",'producto',120,120,$datos,'required','','div-2-10') ;
       
          
                 $this->obj->list->listae('Publicado',$MATRIZ_S,'estado',$datos,'','',$evento,'div-2-10');
        
                 $this->obj->list->listadb($resultado1,$tipo,'Indicador enlace','idobjetivoindicador',$datos,'','','div-2-10');
        
            
        $this->obj->text->texto_oculto("aportaen",$datos);
        
        $this->obj->text->texto_oculto("anio",$datos);
        $this->obj->text->texto_oculto("idperiodo",$datos); 
        $this->obj->text->texto_oculto("beneficiario",$datos); 
        
 
        $this->obj->text->texto_oculto("id_departamento",$datos); 
        $this->obj->text->texto_oculto("idactividad",$datos); 
        $this->obj->text->texto_oculto("action",$datos); 
        
      
     
         $this->set->_formulario('-','fin'); 
 
  
      
   }
   //----------------------------------------------
   function BarraHerramientas(){
 
  
         $eventoi = "javascript:window.print();";
 
         $eventoa = "anular_ainformacion()";
        
         
         if ( $this->EstadoPoa() > 0){
             
             $ToolArray = array(
                 array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit"),
                 array( boton => 'Imprimir Informe', evento =>$eventoi,  grafico => 'glyphicon glyphicon-print' ,  type=>"button"),
                 array( boton => 'Eliminar Transaccion', evento =>$eventoa,  grafico => 'glyphicon glyphicon-trash' ,  type=>"button_danger"),
             );
             
          }else {
          
              $ToolArray = array(
                 array( boton => 'Imprimir Informe', evento =>$eventoi,  grafico => 'glyphicon glyphicon-print' ,  type=>"button")
             );
         }
         
         $this->obj->boton->ToolMenuDiv($ToolArray); 
   
 
 
  }  
   //----------------------------------------------
   function header_titulo($titulo){
 
         $this->set->header_titulo($titulo);
 
  }  
  //----------------------------------------------
  function catalogo($titulo){
  	
  	if ( $titulo == 'Estado'){
  	$MATRIZ = array(
  			'N'    => 'NO',
  			'S'    => 'SI'
  	);
  	
  	}
  	
  	return $MATRIZ;
  	
  }
  
  //-----------------------------------------------
  function Objetivoo(){
      
      $sqlb = "SELECT  0 as codigo, '[ 0. Matriz Objetivo Operativo ]'  AS nombre  ";
                 
      
      $resultado = $this->bd->ejecutar($sqlb);
      
      
      return $resultado;
      
  }
  //------------------------------------------------
  
  //-----------------------------------------------
  function Objetivoi(){
      
      $sqlb = "SELECT  0 as codigo, '[ 0. Matriz Indicadores ]'  AS nombre  ";
      
      
      $resultado = $this->bd->ejecutar($sqlb);
      
      
      return $resultado;
      
  }
  //----------------------------------------------
  function sql($titulo){
  	
  	$year = date('Y');
  	
  	
  	if ( $titulo == 'IDOBJETIVO'){
  		
  		$sql = "SELECT   IDOBJETIVO AS CODIGO,OBJETIVO AS NOMBRE
		        FROM VIEW_OBJETIVOO
		        WHERE  anio = ".$year;
  		
  	}
  
  	if ( $titulo == 'TIPOGESTION'){
  		
  		$IDPARAMETRO_SISTEMA = 15;  // tipo de presupuesto ;
  		
  		$sql = "SELECT  IDPARAMETRO as CODIGO , TIPO as NOMBRE
				FROM SIPARAMETROS
				where IDPARAMETRO_PADRE = ".$IDPARAMETRO_SISTEMA;
  	}
 
  	if ( $titulo == 'PROGRAMA'){
  		
  		$IDPARAMETRO_CATALOGO= 1;  // tipo de PROGRAMA;
  		
  		$sql = "SELECT  IDCATALOGODETALLE as codigo, NOMBRE
			FROM SICATALOGODETALLE
			where  ESTADO = 'S' AND IDCATALOGO =  ".$IDPARAMETRO_CATALOGO;
  		
  	}
  	
  	if ( $titulo == 'COMPONENTE'){
  		
  		$IDPARAMETRO_CATALOGO= 3;  // componenete COMPONENTE;
  		
  		$sql = "SELECT IDCATALOGODETALLE as codigo, NOMBRE
			FROM SICATALOGODETALLE
			where  ESTADO = 'S' AND IDCATALOGO =  ".$IDPARAMETRO_CATALOGO;
  		
  	}
 
  	if ( $titulo == 'APORTAEN'){
  		
  		$IDPARAMETRO_SISTEMA = 16;  // tipo de APORTAEN;
  		
  		$sql = "SELECT  IDPARAMETRO as CODIGO , TIPO as NOMBRE
				FROM SIPARAMETROS
				where IDPARAMETRO_PADRE = ".$IDPARAMETRO_SISTEMA;
  		
  	}
  
  	if ( $titulo == 'LISTAAPORTE'){
  		
  		$IDPARAMETRO_SISTEMA = 3;  // LISTAAPORTE;
  		
  		$sql = "SELECT  IDPARAMETRO as CODIGO , TIPO as NOMBRE
				FROM SIPARAMETROS
				where IDPARAMETRO_PADRE = ".$IDPARAMETRO_SISTEMA;
  		
  		
  	}
  	
  	if ( $titulo == 'IDINDICADOR'){
  		
   		
  		$sql = "SELECT  IDINDICADOR as CODIGO , NOMBRE
				FROM VIEW_INDICADOR
				where ANIO = ".$year;
  		
  		
  	}
  	
 
  	
  	return $sql;
  	
  }
  // estado poa
  function EstadoPoa(   ){
      
      
      $AUnidad = $this->bd->query_array('presupuesto.pre_periodo',
          'count(*) as nn',
          'tipo = '.$this->bd->sqlvalue_inyeccion('elaboracion',true)
          );
      
      $valida = 0;
      
      if ( $AUnidad['nn']  > 0 ){
          $valida = 1;
      }
      
      
      return $valida ;
      
  }
  
///------------------------------------------------------------------------
///------------------------------------------------------------------------
  }
  
  
  $gestion   = 	new componente;
  
  $gestion->Formulario( );
  
 ?>
 

  
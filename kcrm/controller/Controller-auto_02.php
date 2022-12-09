
 <script >// <![CDATA[

   jQuery.noConflict(); 
	
	jQuery(document).ready(function() {
  		
   // InjQueryerceptamos el evento submit
    jQuery(' #fo21').submit(function() {
  		// Enviamos el formulario usando AJAX
        jQuery.ajax({
            type: 'POST',
            url: jQuery(this).attr('action'),
            data: jQuery(this).serialize(),
            // Mostramos un mensaje con la respuesta de PHP
            success: function(data) {
				
 				    jQuery('#VisorTarea').html(data);
            
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
                   
                $this->bd	   =	     	new Db ;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
        
      }
  //----------------------------------- 
  function Formulario( $idproceso,$idtarea){
      
     
     		    $this->set->div_label(12,'<h5> Parametros  Iniciales <h5>');
     		    
     		    $datos = array();
     		    
     		    $evento = '';
     		      
     		       $sqlDepa = "SELECT acceso,variable,tipo,enlace,tabla,lista,orden
									      FROM flow.view_proceso_form 
										WHERE idtarea =   ".$this->bd->sqlvalue_inyeccion($idtarea,true). "  and 
											  idproceso =  ".$this->bd->sqlvalue_inyeccion($idproceso,true). "
									  ORDER BY  orden";

     		       $stmt_depa		=		$this->bd->ejecutar($sqlDepa);
     		       $tipo_c 			=		 $this->bd->retorna_tipo();
     		       
     		       $i = 1;
                
     		       while ($x=$this->bd->obtener_fila($stmt_depa)){
     		       	
     		                           $variable       = utf8_decode(trim($x['variable']));
					     		       	$tipo			= trim($x['tipo']);
					     		       	$tabla  		=  $x['tabla'];
					     		       	$objeto			=  'col_'.$x['orden'];
					     		       	$lista	  		=  $x['lista'];
					     		       	
					     		       	$acceso			=  $x['acceso'];
					     		       	//----------------------------------------------------------------------------------------------------------------------------
					     		       	if ($tipo == 'listaDB'){
					     		       		        	$resultado = $this->combolista($tabla);
					     		       		        	$visualiza = 1;
					     		       		        	if($acceso== 1) {
								     		       			$required = '';
								     		       			$disabled = 'disabled';
					     		       		        	} else if($acceso== 2) {
								     		       			$required = 'required';
								     		       			$disabled = '';
								     		       		} else {
								     		       			$visualiza =0;
								     		       		}
								     		       		
								     		       		if ($visualiza == 1){
								     		       			$this->obj->list->listadb($resultado,$tipo_c,$variable,$objeto,$datos,$required,$disabled,'div-2-4');
								     		       		}
 								     		       		
 					     		        }
					     		        //------------------------------------------------------------------------------------------------------------------------
					     		        if ($tipo == 'caracter'){
								     		        	$visualiza = 1;
								     		        	if($acceso== 1) {
								     		        		$required = '';
								     		        		$disabled = 'readonly';
								     		        	} else if($acceso== 2) {
								     		        		$required = 'required';
								     		        		$disabled = '';
								     		        	} else {
								     		        		$visualiza =0;
								     		        	}
								     		        	
								     		        	if ($visualiza == 1){
								     		        		$this->obj->text->text($variable,"texto",$objeto,120,120,$datos,$required ,$disabled,'div-2-4') ;
								     		        	}
					     		        	
					     		        }
					     		        //--------------------------------------------------------------------------
					     		        if ($tipo == 'editor'){
					     		            $visualiza = 1;
					     		            if($acceso== 1) {
					     		                $required = '';
					     		                $disabled = 'readonly';
					     		            } else if($acceso== 2) {
					     		                $required = 'required';
					     		                $disabled = '';
					     		            } else {
					     		                $visualiza =0;
					     		            }
					     		            
					     		            if ($visualiza == 1){
 					     		                $this->obj->text->editor($variable,$objeto,3,250,300,$datos,$required,'','div-2-4') ;
					     		            }
					     		            
					     		        }
					     		        //------------------------------------------------------------------------------------------------------------------------
					     		        if ($tipo == 'lista'){
					     		        	$MATRIZ = $this->lista($lista);
					     		        	
					     		        	$visualiza = 1;
					     		        	if($acceso== 1) {
					     		        		$required = '';
					     		        		$disabled = 'disabled';
					     		        	} else if($acceso== 2) {
					     		        		$required = 'required';
					     		        		$disabled = '';
					     		        	} else {
					     		        		$visualiza =0;
					     		        	}
					     		        	
					     		        	if ($visualiza == 1){
					     		        		$this->obj->list->listae( $variable,$MATRIZ, $objeto, $datos,$required, $disabled,$evento,'div-2-4');
					     		        	}
 					     		        }
 					     		        //------------------------------------------------------------------------------------------------------------------------
  					     		        if ($tipo == 'email'){
	 					     		        	$visualiza = 1;
	 					     		        	if($acceso== 1) {
	 					     		        		$required = '';
	 					     		        		$disabled = 'readonly';
	 					     		        	} else if($acceso== 2) {
	 					     		        		$required = 'required';
	 					     		        		$disabled = '';
	 					     		        	} else {
	 					     		        		$visualiza =0;
	 					     		        	}
 					     		        	
	 					     		        	if ($visualiza == 1){
	 					     		        		$this->obj->text->text($variable,"email",$objeto,170,170,$datos, $required, $disabled ,'div-2-4') ;
	 					     		        	}
					     		        }
					     		        //------------------------------------------------------------------------------------------------------------------------
					     		        if ($tipo == 'numerico'){
					     		        	$visualiza = 1;
					     		        	if($acceso== 1) {
					     		        		$required = '';
					     		        		$disabled = 'readonly';
					     		        	} else if($acceso== 2) {
					     		        		$required = 'required';
					     		        		$disabled = '';
					     		        	} else {
					     		        		$visualiza =0;
					     		        	}
					     		        	
					     		        	if ($visualiza == 1){
					     		      		  	$this->obj->text->text($variable,"number",$objeto,70,70,$datos,'required','','div-2-4') ;
					     		        	}
					     		        }
					     		        if ($tipo == 'date'){
					     		            $visualiza = 1;
					     		            if($acceso== 1) {
					     		                $required = '';
					     		                $disabled = 'readonly';
					     		            } else if($acceso== 2) {
					     		                $required = 'required';
					     		                $disabled = '';
					     		            } else {
					     		                $visualiza =0;
					     		            }
					     		            
					     		            if ($visualiza == 1){
					     		                $this->obj->text->text($variable,"date",$objeto,70,70,$datos,'required','','div-2-4') ;
					     		            }
					     		        }
					     		        //------------------------------------------------------------------------------------------------------------------------
					     		        if ($tipo == 'condicion'){
					     		        	$MATRIZ = array(
 					     		        			'SI'    => 'SI',
					     		        			'NO'    => 'NO'
					     		        	);
					     		        	$visualiza = 1;
					     		        	if($acceso== 1) {
					     		        		$required = '';
					     		        		$disabled = 'disabled';
					     		        	} else if($acceso== 2) {
					     		        		$required = 'required';
					     		        		$disabled = '';
					     		        	} else {
					     		        		$visualiza =0;
					     		        	}
					     		        	
					     		        	if ($visualiza == 1){
					     		        		$this->obj->list->listae( $variable,$MATRIZ, $objeto, $datos,$required ,$disabled  , $evento,'div-2-4');
					     		        	}
					     		        }
					     		        //------------------------------------------------------------------------------------------------------------------------
					     		        if ($tipo == 'vinculo'){
					     		        	
					     		         //   $div2 = 'div-2-4';
					     		        	
					     		        	$enlace = '<a href="'.$lista.'" target="_blank">'.$variable.'</a>';
					     		        	
					     		        	echo '<div  style="padding-top: 5px;text-align: right;" class="col-md-2">'.' <img src="../../kimages/wurl.png" />' .'</div>';
					     		        	
					     		        	echo '<div style="padding-top: 5px;" class="col-md-4">'.$enlace.'</div>';
 
					     		        }
 					     		$i++;     
     		       }
     		       $valida = $i-1;
     		       
     		       if($valida%2<>0)
     		       {
     		             	echo '<div   class="col-md-6"></div>';
     		       }
       
 
   }
  //----------------------------------------------
   function combolista($tabla){
 
   	$sqlb = " SELECT    nombre  AS codigo, nombre
			   FROM ".$tabla." order by 1";
 
 
   	$resultado = $this->bd->ejecutar($sqlb);
   	
   	return $resultado;
   	
  }  
   //----------------------------------------------
  function lista($lista){
  	
  	$pieces = explode(",", $lista);
  	
  	$a = array();
  	$b = array();
  	 
  	foreach($pieces as $elemento)
  	{
  	
  		$a[] = $elemento;
  		$b[] = $elemento;
  	 
  	}
  	
  	$MATRIZ = array_combine ($a ,  $b);
   	 
  	return $MATRIZ;
  	
  }  
///------------------------------------------------------------------------
  //----------------------------------------------
  function principal($idproceso,$idtarea){
      
      echo ' <ul class="nav nav-pills">
    <li class="active"><a data-toggle="pill" href="#home">Formulario</a></li>
     <li><a data-toggle="pill" href="#menu1">Responsables</a></li>
    <li><a data-toggle="pill" href="#menu2">Requisitos</a></li>
    <li><a data-toggle="pill" href="#menu3">Documentos</a></li>
  </ul>
									      
  <div class="tab-content">
        <div id="home" class="tab-pane fade in active"> ';
       $this->Formulario( $idproceso,$idtarea);
         
      echo '</div>
    
   
 
      <div id="menu1" class="tab-pane fade">';
      $this->departamento_responsable($idproceso,$idtarea);
      echo '</div>
        
    <div id="menu2" class="tab-pane fade">';
      $this->requisitos_proceso($idproceso,$idtarea);
      
      echo ' </div>
        
    <div id="menu3" class="tab-pane fade">';
      $this->documento_proceso($idproceso,$idtarea);
      echo '</div>
            
  </div>';
   }  
   //----------------------------------------------
   function departamento_responsable( $idproceso,$idtarea){
       
       $this->set->div_label(12,'<h5> Asignar unidad operativa<h5>');
       
       $tipo 		= $this->bd->retorna_tipo();
       
       $sql = 'SELECT  idproceso ,
                    idtarea  ,
                    unidad  ,
                    ambito_proceso ,
                    reasignar ,
                    perfil ,
                    sesion,idtareaunidad
      FROM flow.view_unidadProcesotarea
      where idproceso = '. $this->bd->sqlvalue_inyeccion($idproceso ,true).' and
            idtarea = '. $this->bd->sqlvalue_inyeccion($idtarea ,true)      ;
       
       
       ///--- desplaza la informacion de la gestion
       $resultado  =  $this->bd->ejecutar($sql);
       
       $cabecera =  "Proceso,Tarea,Unidad,Ambito,Reasignar,Perfil";
       
       $evento   =  " ";
       $this->obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
       
   } 
///------------------------------------------------------------------------
   //----------------------------------------------
   function documento_proceso($idproceso,$idtarea ){
       
       $this->set->div_label(12,'<h5> Emision de documentos<h5>');
       
       $tipo 		= $this->bd->retorna_tipo();
         
       $sql = 'SELECT  idproceso ,
                    idtarea  ,
                    documento  ,
                    perfil_documento ,
                    tipo ,
                    estado ,
                    sesion,idtareadoc
      FROM flow.view_unidadProcesodocu
      where idproceso = '.$this->bd->sqlvalue_inyeccion($idproceso ,true).' and
            idtarea = '.$this->bd->sqlvalue_inyeccion($idtarea ,true)      ;
       
       
       
       ///--- desplaza la informacion de la gestion
       $resultado  = $this->bd->ejecutar($sql);
       
       $cabecera =  "Proceso,Tarea,Documento,Perfil,Tipo,Estado,sesion";
       
       $evento   = "";
      
       $this->obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
  
   } 
   //----------------------------------------------
   function requisitos_proceso($idproceso,$idtarea ){
       
       $this->set->div_label(12,'<h5> Requisitos <h5>');
       
       $tipo 		= $this->bd->retorna_tipo();
         
       $sql = 'SELECT  idproceso ,
                    idtarea  ,
                    requisito  ,
                    requisito_perfil ,
                    tipo ,
                    obligatorio ,
                    sesion,idtarearequi
      FROM flow.view_unidadprocesorequi
      where idproceso = '.$this->bd->sqlvalue_inyeccion($idproceso ,true).' and
            idtarea = '.$this->bd->sqlvalue_inyeccion($idtarea ,true)      ;
       
       $evento = '';
       
       ///--- desplaza la informacion de la gestion
       $resultado  = $this->bd->ejecutar($sql);
       
       $cabecera =  "Proceso,Tarea,Requisito,Perfil,Tipo,Obligatorio,sesion";
       
       $this->obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
       
   } 
   //----------------------------------------------
   function editor_proceso($idproceso,$idtarea ){
  
       
       echo '<p>&nbsp;</p><textarea cols="80" id="editor1" name="editor1" rows="7" >
          
	      </textarea> ';
     
       
   } 
  //-------------------------- 
  }
  ///------------------------------------------------------------------------
  ///------------------------------------------------------------------------
   
  
  $gestion   = 	new componente;
 
  
  if (isset($_GET['id']))	{
  	
  	
  	$id               = $_GET['id'];
  	
  	$idproceso        = $_GET['idproceso'];
  	
  	$gestion->principal( $idproceso,$id);
  	
  }
  

  
 ?>
 
  
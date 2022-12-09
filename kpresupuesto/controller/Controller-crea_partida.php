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
      
      private $anio;
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function componente( ){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	new  Db ;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  date("Y-m-d");
        
                $this->anio       =  $_SESSION['anio'];
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario(){
      
        $datos = array();
       
        $tipo = $this->bd->retorna_tipo();
      	
        $datos['fanio']	= $this->anio ;
      	
      	
      	$this->set->div_label(12,'CREACION DE PARTIDAS PRESUPUESTARIA');
      	
      	
      	
      	$this->set->div_panel6('Definir Partida INGRESO');
      	
   
      	        
      	
              	$resultado = $this->bd->ejecutar("SELECT   '-' as codigo, '[ Seleccione grupo presupuestaria ]' as nombre union 
                                           SELECT   codigo, codigo || ' ' || detalle AS nombre
                                                   FROM presupuesto.pre_catalogo
                                                  WHERE categoria = 'clasificador' and subcategoria = 'ingreso' and 
                                                         nivel = 2  and estado = 'S' order by 1 asc");
              	
              	$evento2 =  'onChange="PoneItem(this.value)"';
              	
              	$this->obj->list->listadbe($resultado,$tipo,'Grupo','grupoi',$datos,'','',$evento2,'div-3-9');
      	
      	
              	
              	$evento2 =  'onChange="PoneSubItemi(this.value)"';
              	
              	$this->obj->list->listadbe($resultado,$tipo,'Items','itemi',$datos,'','',$evento2,'div-3-9');
              	
              	
              	
              	$this->obj->text->text('SubItem',"texto" ,'subitemi' ,80,80, $datos ,'required','','div-3-9') ;
                 	
              	
              	$resultado = $this->bd->ejecutar("Select '-' as codigo , ' [ Seleccione la Fuente ]' as nombre union
                                          SELECT   codigo, codigo || ' ' || detalle AS nombre
                                           FROM presupuesto.pre_catalogo
                                          WHERE categoria = 'fuente'  and estado = 'S'");
              	
              	$evento2 =  '';
              	
              	
              	
              	$this->obj->list->listadbe($resultado,$tipo,'Fuente','fuentei',$datos,'','',$evento2,'div-3-9');
              	
              	
              	$this->obj->text->text('Descripcion',"texto" ,'detallei' ,180,180, $datos ,'required','','div-3-9') ;
              	
      	$this->set->div_panel6('fin');
      	
      	
      	
      	//------------------- GASTO ---------------------------------------
      	//-------------------//-------------------//-------------------
      	//-------------------//-------------------//-------------------
      	
      	$this->set->div_panel6('Definir Partida GASTO');
      	
       	
      	
      	
      	$sqlO1= "SELECT idpre_estructura, anio, catalogo, tipo, orden, esigef, campo, etiqueta, lista, elemento, estado
								   FROM presupuesto.pre_estructura
				 				  WHERE tipo = 'G' and estado ='S' and anio = ".$this->bd->sqlvalue_inyeccion($datos['fanio']	,true).' order by orden' ;
      	
      	
      	$xxx = '';
      	
      	$stmt_ac = $this->bd->ejecutar($sqlO1);
      	
      	$bandera = 0;
      	
      	while ($x=$this->bd->obtener_fila($stmt_ac)){
      	    
      	    $etiqueta = trim($x['etiqueta']);
      	    
      	    $campo = trim($x['campo']);
      	    
      	    $evento2 ='';
      	    
      	    $lista    = trim($x['lista']);
      	    $elemento = trim($x['elemento']);
      	    
      	    if ( $lista == 'catalogo'){
      	        
      	        $resultado = $this->bd->ejecutar("SELECT   codigo, detalle AS nombre
                                           FROM presupuesto.pre_catalogo
                                          WHERE categoria = '".$elemento."' and estado = 'S' order by codigo"); 
      	        
                $evento2 =  'onChange="Ponepartida()"';
      	        $this->obj->list->listadbe($resultado,$tipo,$etiqueta,$campo,$datos,'','',$evento2,'div-3-9');
      	        
      	    }
      	    
      	    
      	    if ( $lista == 'clasificador'){
      	        
      	        $resultado = $this->bd->ejecutar("SELECT   '-' as codigo, '[ Seleccione grupo presupuestaria ]' as nombre union
                                           SELECT   codigo, codigo || ' ' || detalle AS nombre
                                                   FROM presupuesto.pre_catalogo
                                                  WHERE categoria = 'clasificador' and subcategoria = 'gasto' and
                                                         nivel = 2  and estado = 'S' order by 1 asc");
      	        if ( $etiqueta == 'Item'){
      	            $evento2 =  'onChange="PoneSubItemg(this.value)"';
      	        }else {
      	            $evento2 =  'onChange="PoneItemg(this.value)"';
      	        }
      	      
      	        $this->obj->list->listadbe($resultado,$tipo,$etiqueta,$campo,$datos,'','',$evento2,'div-3-9');
      	        
      	    }
      	    
       	    
      	    
      	    if ( $lista == 'item'){
        	       $this->obj->text->text('SubItem',"texto" ,'subitemg' ,80,80, $datos ,'required','','div-3-9') ;
        	       $bandera = 1;
       	    
      	    }
      	    
      	    $xxx = $xxx.'-'.$campo;
      	    
      	    
      	}
      	
      	$this->obj->text->text('Descripcion',"texto" ,'detalleg' ,180,180, $datos ,'required','','div-3-9') ;
      	
      	if ( $bandera == 1){
      	    $xxy = str_replace('-itemg', '', $xxx);
      	    $xxx = str_replace('-grupog', '', $xxy);
      	}
      	
      	if ( $bandera == 0){
      	    $xxx = str_replace('-grupog', '', $xxx);
      	}
      	
      	$length = strlen($xxx);
      	$longitud = substr($xxx,1,$length);
      	
      	
      	$datos['estructura_gasto'] = $longitud;
      	
      	$this->obj->text->text('PARTIDA GASTO',"texto" ,'partidag' ,80,80, $datos ,'required','readonly','div-3-9') ;
      	
      	
      	$this->obj->text->texto_oculto("estructura_gasto",$datos); 
      	
      	
      	
      	//------------------------
      	$sqlO1= "SELECT idpre_estructura, anio, catalogo, tipo, orden, esigef, campo, etiqueta, lista, elemento, estado
								   FROM presupuesto.pre_estructura
				 				  WHERE tipo = 'G' and estado ='N' and anio = ".$this->bd->sqlvalue_inyeccion($datos['fanio']	,true).' order by orden' ;
      	
      	$stmt_acc = $this->bd->ejecutar($sqlO1);
      	
       	
      	while ($xX=$this->bd->obtener_fila($stmt_acc)){
      	    $campo = trim($xX['campo']);
      	    $datos[$campo] = '-';
      	    
      	    $this->obj->text->texto_oculto($campo,$datos); 
      	    
      	}
      	
      	
      	$this->set->div_panel6('fin');
      	
     
      
      }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
  
 
   $gestion->FiltroFormulario( );

 ?>


 
  
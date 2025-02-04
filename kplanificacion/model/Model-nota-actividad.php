<?php 
     session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
  
  
    class proceso{
 
      //creamos la variable donde se instanciar la clase "mysql"
 
      private $obj;
      private $bd;
      
      private $ruc;
      private $sesion;
      private $hoy;
      private $POST;
      private $ATabla;
      private $tabla ;
      private $secuencia;
      
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function proceso( ){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                $this->bd	   =	new Db ;
    
             
                $this->sesion 	 =  $_SESSION['login'];
                $this->hoy 	     =  $this->bd->hoy();
        
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
                
                $this->tabla 	  	  = 'web_notas';
                
 
                
                $this->secuencia 	     = '-';
                
                $this->ATabla = array(
                		array( campo => 'idwebnota',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
                		array( campo => 'actividad',   tipo => 'VARCHAR2',   id => '1',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                		array( campo => 'usuario',   tipo => 'VARCHAR2',   id => '2',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                		array( campo => 'fecha',   tipo => 'DATE',   id => '3',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                		array( campo => 'vencimiento',   tipo => 'DATE',   id => '4',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                		array( campo => 'ambito',   tipo => 'VARCHAR2',   id => '5',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                		array( campo => 'leido',   tipo => 'VARCHAR2',   id => '6',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                		array( campo => 'detalle',   tipo => 'VARCHAR2',   id => '7',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                		array( campo => 'adjunto',   tipo => 'VARCHAR2',   id => '8',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                		array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '9',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N')
                );
      }
   
 
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function div_actividad( ){
            //inicializamos la clase para conectarnos a la bd
       
             $resultado = '';
             echo '<script type="text/javascript">';
              
             echo    "$('#listaActividad').load('../model/Model-lista-mi-actividad.php');" ;
   
            echo  ' $("#action_modal_nota").val("no"); ';
             
            echo '</script>'; 
 
            return $resultado;   
 
      }     
   
   
    	 
     //--------------------------------------------------------------------------------
      //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
      //--------------------------------------------------------------------------------        
     function agregar(   ){
     	
     	$carpeta = $_POST['adjunto'] ;
     	$accion  = $_POST['action_modal_nota'] ;
     	
     	
     	$this->ATabla[2][valor] =  $this->sesion;
     	$this->ATabla[6][valor] = 'N';
     	$this->ATabla[9][valor] = 'Actividad';
     	$this->ATabla[8][valor] = $carpeta;
     	
     	if ($accion <> 'no'){
     		
     		$id = $this->bd->_InsertSQL($this->tabla,$this->ATabla,'-');
     		
     		$this->div_actividad();
     		
     		$resultado_notas = 'Informacion generada';
     		
     	}else{
     		$resultado_notas = '-';
     	}
		     	

    	echo $resultado_notas;
     	
     }	

 }    
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 
 
    $gestion   = 	new proceso;
    
 
    
    $gestion->agregar( );
     
   
 ?>
 
  
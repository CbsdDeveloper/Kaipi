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
    
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =   date("Y-m-d"); 
        
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
                
                $this->tabla 	  	  = 'seg_proceso';
                
                $this->secuencia 	     = '-';
                
                $this->ATabla = array(
                    array( campo => 'id_seg_proceso',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
                    array( campo => 'anio_perido',      tipo => 'VARCHAR2',id => '1',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'fecha_apertura',tipo => 'DATE',id => '2',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'fecha_cierre',tipo => 'DATE',id => '3',add => 'N', edit => 'N', valor => '-', key => 'N'),
                    array( campo => 'tipo_examen',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'id_departamento',tipo => 'NUMBER',id => '5',add => 'S', edit => 'N', valor => '-', key => 'N'),
                    array( campo => 'nro_informe',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'tema_recomendacion',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'cumplimiento',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'N', valor => 'No aplica', key => 'N'),
                    array( campo => 'estado',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'N', valor => 'D', key => 'N'),
                    array( campo => 'marco_legal',tipo => 'VARCHAR2',id => '10',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'observacion',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'idusuario_asignado',tipo => 'NUMBER',id => '12',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'documento_respaldo',tipo => 'VARCHAR2',id => '13',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'documento_digital',tipo => 'VARCHAR2',id => '14',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'periodo',tipo => 'VARCHAR2',id => '15',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'nombre_examen',tipo => 'VARCHAR2',id => '16',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'ultimo_comentario',tipo => 'VARCHAR2',id => '17',add => 'N', edit => 'N', valor => '-', key => 'N'),
                    array( campo => 'sesion',tipo => 'VARCHAR2',id => '18',add => 'S', edit => 'N', valor => $this->sesion, key => 'N'),
                    array( campo => 'fecha',tipo => 'DATE',id => '19',add => 'S', edit => 'N', valor =>  $this->hoy , key => 'N'),
                    array( campo => 'modificado',tipo => 'VARCHAR2',id => '20',add => 'S', edit => 'S', valor => $this->sesion, key => 'N'),
                    array( campo => 'fmodificado',tipo => 'DATE',id => '21',add => 'S', edit => 'S', valor => $this->hoy , key => 'N'),
                );
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function div_resultado($accion,$id,$tipo){
            //inicializamos la clase para conectarnos a la bd
      
        
      	   echo '<script type="text/javascript">accion('. $id. ','. "'".$accion."'" .')</script>';
             
             if ($tipo == 0){
                
                  if ($accion == 'editar')
                      $resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>EDITAR REGISTRO TRANSACCION ?</b><br>';
                      if ($accion == 'del')    
                          $resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ELIMINAR REGISTRO TRANSACCION ?</b><br>';
                          
             }
             
             if ($tipo == 1){
                 $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO ['.$id.']</b><br>';
             }
 
              
             
            return $resultado;   
 
      }
 
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function div_limpiar( ){
            //inicializamos la clase para conectarnos a la bd
       
             $resultado = '';
             echo '<script type="text/javascript">';
              
             echo  'LimpiarPantalla();';               
   
             echo '</script>';
 
            return $resultado;   
 
      }     
   
   
    	      
 //--------------------------------------------------------------------------------
    //--- busqueda de por codigo para llenar los datos
 //--------------------------------------------------------------------------------
 function consultaId($accion,$id ){
          
 	
  	
 	$qquery = array( 
 	    array( campo => 'id_seg_proceso',   valor => $id,  filtro => 'S',   visor => 'S'),
 	    array( campo => 'anio_perido',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'fecha_apertura',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'fecha_cierre',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'tipo_examen',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'id_departamento',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'nro_informe',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'tema_recomendacion',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'cumplimiento',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'estado',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'marco_legal',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'observacion',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'idusuario_asignado',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'documento_respaldo',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'periodo',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'nombre_examen',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'documento_digital',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'responsable',valor => '-',filtro => 'N', visor => 'N'),
 	    array( campo => 'estado_tramite',valor => '-',filtro => 'N', visor => 'S')
     );
 	
 
          
 	        $datos = $this->bd->JqueryArrayVisorObj('view_recomedacion_doc',$qquery,0 );           
 
 	        
 	        echo '<script type="text/javascript">myelemento('."'".$datos["responsable"]."'". ','. $datos["idusuario_asignado"]  .')</script>';
 	        
            $result =  $this->div_resultado($accion,$id,0) ;
     
        echo  $result;
      }	
  
      //--------------------------------------------------------------------------------
      //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
      //--------------------------------------------------------------------------------        
 
     function xcrud($action,$id){
          
 
                 // ------------------  agregar
                 if ($action == 'add'){
                    
                     $this->agregar( );
                 
                 }  
                 // ------------------  editar
                 if ($action == 'editar'){
        
                     $this->edicion($id );
     
                 }  
                 // ------------------  eliminar
                  if ($action == 'del'){
        
                     $this->eliminar($id );
     
                 }  
 
     }  
     //--------------------------------------------------------------------------------
      //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
      //--------------------------------------------------------------------------------        
     function agregar(   ){
     	
         
             $archivo =     @$_POST["documento_respaldo"];
         
             $len = strlen(trim($archivo));
             
             $this->ATabla[13][valor] = trim($archivo) ;
             
 
        	
             if ( $len > 5 ) {
                    
                 $id = $this->bd->_InsertSQL($this->tabla,$this->ATabla,'seg_proceso_id_seg_proceso_seq');
             	     
                	$result = $this->div_resultado('editar',$id,1);
                	
             }	else {
                 
                 $result = '<img src="../../kimages/rojo.png" align="absmiddle"/>&nbsp;<b>DEBE CARGAR AL MENOS UN ARCHIVO DIGITAL</b><br>';
             }
                 
   
            echo $result;
       
     }	
   
      //--------------------------------------------------------------------------------
      //--- edicion de registros
      //--------------------------------------------------------------------------------              
       function edicion($id  ){
 
           $archivo = $_POST["documento_respaldo"];
           
           
           $estado =  $_POST["estado"];
           
           
           $len = strlen(trim($archivo));
           
           $this->ATabla[13][valor] = trim($archivo) ;
           
           
           
           if ( $len > 5 ) {
               
               if ($estado == 'D') {
                   $id = $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
                   $result = $this->div_resultado('editar',$id,1);
               }else  {
                   $result = '<img src="../../kimages/rojo.png" align="absmiddle"/>&nbsp;<b>NO SE PUEDE EDITAR EL REGISTRO</b><br>';
               }
           }
        	else {
           
           $result = '<img src="../../kimages/rojo.png" align="absmiddle"/>&nbsp;<b>DEBE CARGAR AL MENOS UN ARCHIVO DIGITAL</b><br>';
           
           }
            
     
 
           echo $result;
    }
  
      //--------------------------------------------------------------------------------
      //--- eliminar de registros
      //--------------------------------------------------------------------------------              
     function eliminar($id ){
      
     	$result ='No se puede eliminar el registro';
  
       echo $result;
      
   }
   
   //----------------------
   function id_secuencia(  ){
       
       $AResultado = $this->bd->query_array(
           'wk_config',
           'max(tipo) as secuencia', 
           '1='.$this->bd->sqlvalue_inyeccion('1',true)
           );
       
       return $AResultado['secuencia'] +1;
       
       ;
       
   }
   
 
   
   
 }    
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 
 
    $gestion   = 	new proceso;
    
 
    //------ poner informacion en los campos del sistema
     if (isset($_GET['accion']))	{
         
            
            $accion    = $_GET['accion'];
            
            $id        = $_GET['id'];
            
            $gestion->consultaId($accion,$id);

     }  
  
      //------ grud de datos insercion
      
     
     if (isset($_POST["action"]))	{
        
            $action 	= $_POST["action"];
        
            $id 			= $_POST["id_seg_proceso"];
        
           $gestion->xcrud(trim($action),$id );
           
    }      
  
     
   
 ?>
 
  
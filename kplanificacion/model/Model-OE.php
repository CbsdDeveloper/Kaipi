<?php 
     session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
   
	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
  
  
    class proceso{
 
  
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
                $this->bd	   =		new Db ;
    
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  date("Y-m-d");
        
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
                $this->tabla 	  	  = 'planificacion.pyestrategia';
                
                $this->secuencia 	     = 'planificacion.pyestrategia_idestrategia_seq';
                
                $this->ATabla = array(
                		array( campo => 'idestrategia',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   visor => 'S',   valor => '-',   filtro => 'N',   key => 'S'),
                        array( campo => 'idestrategia_padre',tipo => 'NUMBER',id => '1',add => 'S', edit => 'S', valor => '-', key => 'N'),
                        array( campo => 'idestrategia_matriz',tipo => 'NUMBER',id => '2',add => 'S', edit => 'S', valor => '-', key => 'N'),
                        array( campo => 'objetivoe',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
                        array( campo => 'estado',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => '-', key => 'N'),
                        array( campo => 'aporte',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
                        array( campo => 'ambito',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => '-', key => 'N'),
                        array( campo => 'sesion',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'N', valor => $this->sesion , key => 'N'),
                        array( campo => 'creacion',tipo => 'DATE',id => '8',add => 'S', edit => 'N', valor => $this->hoy , key => 'N'),
                        array( campo => 'sesionm',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'S', valor => $this->sesion , key => 'N'),
                        array( campo => 'modificacion',tipo => 'DATE',id => '10',add => 'S', edit => 'S', valor => $this->hoy , key => 'N'),
                        array( campo => 'bandera',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'N', valor => 'N', key => 'N'),
                        array( campo => 'nivel',tipo => 'NUMBER',id => '12',add => 'S', edit => 'S', valor => '-', key => 'N'),
                        array( campo => 'univel',tipo => 'VARCHAR2',id => '13',add => 'S', edit => 'S', valor => '-', key => 'N'),
                        array( campo => 'siglas',tipo => 'VARCHAR2',id => '13',add => 'S', edit => 'S', valor => '-', key => 'N'),
                 );
                
               
}
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function div_resultado($accion,$id,$tipo){
       
        
             echo '<script type="text/javascript">accion("'.$id.'","'.$accion.'")</script>';
 
             if ($tipo == 0){
                
                  if ($accion == 'editar')
                      $resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>EDITAR REGISTRO TRANSACCION ... PRESIONE EL ICONO DE GUARDAR PARA PROCESAR ESTA ACCION</b>';
                     
                  if ($accion == 'del')    
                      $resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ELIMINAR REGISTRO TRANSACCION ... PRESIONE EL ICONO DE GUARDAR PARA PROCESAR ESTA ACCION</b>';
                      
             }
             
             if ($tipo == 1){
                   
                 $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle" />&nbsp;<b>INFORMACIÓN GUARDADA CON EXITO ... </b>';
                 
                   
             }
             
             
            return $resultado;   
 
      }
       
 //--------------------------------------------------------------------------------
    //--- busqueda de por codigo para llenar los datos
 //--------------------------------------------------------------------------------
 function consultaId($accion,$id ){
          
     /*
      SELECT , , ,
      , estado, aporte, ambito, sesion, creacion, sesionm, modificacion, bandera, nivel
      FROM 
      
      nextval(''::regclass)
      */
 	
 	$qquery = array( 
 			array( campo => 'idestrategia',   valor => $id,  filtro => 'S',   visor => 'S'),
 			array( campo => 'idestrategia_padre',   valor => '-',  filtro => 'N',   visor => 'S'),
 			array( campo => 'idestrategia_matriz',   valor => '-',  filtro => 'N',   visor => 'S'),
 			array( campo => 'objetivoe',   valor => '-',  filtro => 'N',   visor => 'S'),
 			array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
 			array( campo => 'aporte',   valor => '-',  filtro => 'N',   visor => 'S'),
 			array( campo => 'ambito',   valor => '-',  filtro => 'N',   visor => 'S'),
 			array( campo => 'aporte',   valor => '-',  filtro => 'N',   visor => 'S') ,
       array( campo => 'siglas',   valor => '-',  filtro => 'N',   visor => 'S') ,
 	        array( campo => 'nivel',   valor => '-',  filtro => 'N',   visor => 'S') ,
 	        array( campo => 'univel',   valor => '-',  filtro => 'N',   visor => 'S') 
 	);
 	
 		$this->bd->JqueryArrayVisorTab('planificacion.pyestrategia',$qquery,'-' );           
  
        $result =  $this->div_resultado($accion,$id,0);
     
        echo  $result;
      }	
  
      //--------------------------------------------------------------------------------
      //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
      //--------------------------------------------------------------------------------        
 
      function xcrud($action,$id,$idQuery){
          
 
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
                 // ------------------  visor
                 if ($action == 'visor'){
                 	
                 	$this->consultaId('editar',$idQuery);
                 	
                 }  
 
     }  
     //--------------------------------------------------------------------------------
      //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
      //--------------------------------------------------------------------------------        
     function agregar(   ){
     	
       
         
 
        $nivel 	   = trim($_POST["nivel"]);
     	     	
    
        if (  $nivel == '1'){
            $this->ATabla[1][valor] = '0';
            $this->ATabla[2][valor] = '0';
        }
        if (  $nivel == '2'){
            $this->ATabla[1][valor] = '0';
            $this->ATabla[2][valor] = '0';
        }
           	
     	$id = $this->bd->_InsertSQL($this->tabla,$this->ATabla,$this->secuencia);
     	
                 
     	$result = $this->div_resultado('editar',$id,1);
   
         echo $result;
          
     }	
   
      //--------------------------------------------------------------------------------
      //--- edicion de registros
      //--------------------------------------------------------------------------------              
       function edicion($id  ){
       	
           $nivel 	   = trim($_POST["nivel"]);
           
           
           if (  $nivel == '1'){
               $this->ATabla[1][valor] = '0';
               $this->ATabla[2][valor] = '0';
           }
           if (  $nivel == '2'){
               $this->ATabla[1][valor] = '0';
               $this->ATabla[2][valor] = '0';
           }
       		
      	   $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id); 

      	 	$result = $this->div_resultado('editar',$id,1) ;
            
            echo $result;
    }
  
      //--------------------------------------------------------------------------------
      //--- eliminar de registros
      //--------------------------------------------------------------------------------              
     function eliminar($id ){
      
     
         $Array = $this->bd->query_array(
             'planificacion.pyobjetivos',
             'count(*) as nn',
             'idestrategia='.$this->bd->sqlvalue_inyeccion($id,true)
             );
         
         $nn =   $Array['nn'] ;
         
         if (  $nn > 0 ){
             $result = '<img src="../../kimages/ksavee.png" align="absmiddle" />&nbsp;<b>NO SE PUEDE ELIMINAR ESTE REGISTRO ... </b> '. $nn;
             
         }else {
             
             $this->bd->JqueryDeleteSQL ( 'planificacion.pyestrategia' ,'idestrategia='.$this->bd->sqlvalue_inyeccion($id, true) );
             
             $result = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>REGISTRO ELIMINADA ... ACTUALIZAR FORMULARIO PARA PROCESAR ESTA ACCION</b> '. $nn;
             
         }
         
         
       
  
       echo $result;
      
   }
   
 }    
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 
 
    $gestion   = 	new proceso;
    
 
      //------ grud de datos insercion
     if (isset($_POST["action"]))	{
        
            $action        = $_POST["action"];
        
            $id 	     = $_POST["idestrategia"];
            
            $idQuery     = $_POST['id'];
           
        
            $gestion->xcrud(trim($action),$id,$idQuery);
           
    }      
  
     
   
 ?>
 
  
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
      private $ATablaDestino;
      
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
                $this->hoy 	     =  $this->bd->hoy();
        
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
                
                $this->tabla 	  	  = 'guia_cabecera';
                
                $this->secuencia 	     = 'guia_cabecera_cab_codigo_seq';
         
                   
                $this->ATabla = array(
                		array( campo => 'cab_codigo',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
                        array( campo => 'coddoc',tipo => 'VARCHAR2',id => '1',add => 'S', edit => 'S', valor => '06', key => 'N'),
                        array( campo => 'estab',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => '-', key => 'N'),
                        array( campo => 'ptoemi',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
                        array( campo => 'secuencial',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'N', valor => '-', key => 'N'),
                        array( campo => 'fecha',tipo => 'DATE',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
                        array( campo => 'dirmatriz',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => '-', key => 'N'),
                        array( campo => 'claveacceso',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => '-', key => 'N'),
                        array( campo => 'registro',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'N', valor => $this->ruc , key => 'N'),
                        array( campo => 'estado',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'S', valor => '-', key => 'N'),
                        array( campo => 'dirpartida',tipo => 'VARCHAR2',id => '10',add => 'S', edit => 'S', valor => '-', key => 'N'),
                        array( campo => 'razonsocialtransportista',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'S', valor => '-', key => 'N'),
                        array( campo => 'tipoidentificaciontransportista',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'S', valor => '-', key => 'N'),
                        array( campo => 'ructransportista',tipo => 'VARCHAR2',id => '13',add => 'S', edit => 'S', valor => '-', key => 'N'),
                        array( campo => 'placa',tipo => 'VARCHAR2',id => '14',add => 'S', edit => 'S', valor => '-', key => 'N'),
                        array( campo => 'fechainitransporte',tipo => 'DATE',id => '15',add => 'S', edit => 'S', valor => '-', key => 'N'),
                        array( campo => 'fechafintransporte',tipo => 'DATE',id => '16',add => 'S', edit => 'S', valor => '-', key => 'N'),
                        array( campo => 'identificaciondestinatario',tipo => 'VARCHAR2',id => '17',add => 'S', edit => 'S', valor => '-', key => 'N'),
                        array( campo => 'razonsocialdestinatario',tipo => 'VARCHAR2',id => '18',add => 'S', edit => 'S', valor => '-', key => 'N'),
                        array( campo => 'dirdestinatario',tipo => 'VARCHAR2',id => '19',add => 'S', edit => 'S', valor => '-', key => 'N'),
                        array( campo => 'motivotraslado',tipo => 'VARCHAR2',id => '20',add => 'S', edit => 'S', valor => '-', key => 'N'),
                        array( campo => 'ruta',tipo => 'VARCHAR2',id => '21',add => 'S', edit => 'S', valor => '-', key => 'N'),
                        array( campo => 'factura',tipo => 'VARCHAR2',id => '22',add => 'S', edit => 'S', valor => '-', key => 'N'),
                        array( campo => 'codestabdestino',tipo => 'VARCHAR2',id => '23',add => 'S', edit => 'S', valor => '-', key => 'N'),
                        array( campo => 'observacion',tipo => 'VARCHAR2',id => '24',add => 'S', edit => 'S', valor => '-', key => 'N')
                 );
        
                //---------------------------------------
                $this->ATablaDestino = array(
                      array( campo => 'des_codigo',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
                      array( campo => 'cab_codigo',tipo => 'NUMBER',id => '1',add => 'S', edit => 'N', valor => '-', key => 'N'),
                      array( campo => 'codigointerno',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => '-', key => 'N'),
                      array( campo => 'descripcion',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
                      array( campo => 'cantidad',tipo => 'NUMBER',id => '4',add => 'S', edit => 'S', valor => '-', key => 'N'),
                );
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function div_resultado($accion,$id,$tipo){
            //inicializamos la clase para conectarnos a la bd
          
          $resultado = '<img src="../../kimages/kfav.png" align="absmiddle" />&nbsp;<b>ACTUALIZANDO INFORMACION</b><br>';
         
          
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
 			array( campo => 'cab_codigo',   valor => $id,  filtro => 'S',   visor => 'S'),
      	    array( campo => 'coddoc',valor => '-',filtro => 'N', visor => 'S'),
     	    array( campo => 'estab',valor => '-',filtro => 'N', visor => 'S'),
     	    array( campo => 'ptoemi',valor => '-',filtro => 'N', visor => 'S'),
     	    array( campo => 'secuencial',valor => '-',filtro => 'N', visor => 'S'),
     	    array( campo => 'fecha',valor => '-',filtro => 'N', visor => 'S'),
     	    array( campo => 'dirmatriz',valor => '-',filtro => 'N', visor => 'S'),
     	    array( campo => 'claveacceso',valor => '-',filtro => 'N', visor => 'S'),
      	    array( campo => 'estado',valor => '-',filtro => 'N', visor => 'S'),
     	    array( campo => 'dirpartida',valor => '-',filtro => 'N', visor => 'S'),
     	    array( campo => 'razonsocialtransportista',valor => '-',filtro => 'N', visor => 'S'),
     	    array( campo => 'tipoidentificaciontransportista',valor => '-',filtro => 'N', visor => 'S'),
     	    array( campo => 'ructransportista',valor => '-',filtro => 'N', visor => 'S'),
     	    array( campo => 'placa',valor => '-',filtro => 'N', visor => 'S'),
     	    array( campo => 'fechainitransporte',valor => '-',filtro => 'N', visor => 'S'),
     	    array( campo => 'fechafintransporte',valor => '-',filtro => 'N', visor => 'S'),
     	    array( campo => 'identificaciondestinatario',valor => '-',filtro => 'N', visor => 'S'),
     	    array( campo => 'razonsocialdestinatario',valor => '-',filtro => 'N', visor => 'S'),
     	    array( campo => 'dirdestinatario',valor => '-',filtro => 'N', visor => 'S'),
     	    array( campo => 'motivotraslado',valor => '-',filtro => 'N', visor => 'S'),
     	    array( campo => 'ruta',valor => '-',filtro => 'N', visor => 'S'),
     	    array( campo => 'factura',valor => '-',filtro => 'N', visor => 'S'),
     	    array( campo => 'codestabdestino',valor => '-',filtro => 'N', visor => 'S'),
     	    array( campo => 'observacion',valor => '-',filtro => 'N', visor => 'S') 
   	);
 
          
      $this->bd->JqueryArrayVisor('guia_cabecera',$qquery );           
 
     //--------------------------
      $result =  $this->div_resultado($accion,$id,0);
     
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
         
           $factura = trim($_POST["factura"]);
           
           $Acontador = $this->bd->query_array('guia_cabecera',
                                               'count(*)  as nn', 
                                               'trim(registro) ='.$this->bd->sqlvalue_inyeccion(trim($this->ruc),true)
               );
         
           if ( $Acontador['nn']  > 0 ){
               
               $contador = $Acontador['nn'] + 1;
               
           }else{
               
               $contador = 1;
           }
        
         
             
           $comprobante =str_pad($contador, 9, "0", STR_PAD_LEFT);
           
           $this->ATabla[4][valor] = $comprobante ;
           
           
             $id = $this->bd->_InsertSQL($this->tabla,$this->ATabla,$this->secuencia);
     	    
             echo '<script> $("#secuencial").val("'.$comprobante.' ");</script> ';
 
             
             //------------ seleccion de destino
             $qquery = array(
                 array( campo => 'id',   valor => '-',  filtro => 'N',   visor => 'S'),
                 array( campo => 'producto',   valor => '-',  filtro => 'N',   visor => 'S'),
                 array( campo => 'unidad',   valor => '-',  filtro => 'N',   visor => 'S'),
                 array( campo => 'cantidad',   valor => '-',  filtro => 'N',   visor => 'S'),
                 array( campo => 'comprobante',   valor => $factura,  filtro => 'S',   visor => 'N'),
                 array( campo => 'registro',   valor => $this->ruc ,  filtro => 'S',   visor => 'N'),
             );
             
              
             $this->ATablaDestino[1][valor] = $id ;
             
             $resultado = $this->bd->JqueryCursorVisor('view_factura_detalle',$qquery );
             
             while ($fetch=$this->bd->obtener_fila($resultado)){
                 
                 $this->ATablaDestino[2][valor] = $fetch['id'] ;
                 $this->ATablaDestino[3][valor] = $fetch['producto'] ;
                 $this->ATablaDestino[4][valor] = $fetch['cantidad'] ;
                    
                 $this->bd->_InsertSQL('guia_destinatario_detalle',$this->ATablaDestino,'guia_destinatario_detalle_dde_codigo_seq');
             }
          
        	 $result = $this->div_resultado('editar',$id,1);
   
            echo $result;
          
     }	
   
      //--------------------------------------------------------------------------------
      //--- edicion de registros
      //--------------------------------------------------------------------------------              
       function edicion($id  ){
 
       $estado = trim($_POST["estado"]);
       $factura = trim($_POST["factura"]);
           
       if ( $estado == 'digitado'){
           
            
           
                $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
            
             
                //------------ seleccion de destino
                $qquery = array(
                    array( campo => 'id',   valor => '-',  filtro => 'N',   visor => 'S'),
                    array( campo => 'producto',   valor => '-',  filtro => 'N',   visor => 'S'),
                    array( campo => 'unidad',   valor => '-',  filtro => 'N',   visor => 'S'),
                    array( campo => 'cantidad',   valor => '-',  filtro => 'N',   visor => 'S'),
                    array( campo => 'comprobante',   valor => $factura,  filtro => 'S',   visor => 'N'),
                    array( campo => 'registro',   valor => $this->ruc ,  filtro => 'S',   visor => 'N'),
                );
                
                
                $this->ATablaDestino[1][valor] = $id ;
                
                $resultado = $this->bd->JqueryCursorVisor('view_factura_detalle',$qquery );
                
                while ($fetch=$this->bd->obtener_fila($resultado)){
                    
                    $this->ATablaDestino[2][valor] = $fetch['id'] ;
                    $this->ATablaDestino[3][valor] = $fetch['producto'] ;
                    $this->ATablaDestino[4][valor] = $fetch['cantidad'] ;
                    
               //     $this->bd->_InsertSQL('guia_destinatario_detalle',$this->ATablaDestino,'guia_destinatario_detalle_dde_codigo_seq');
                }
                
       }
       
        $result = $this->div_resultado('editar',$id,1);
            
        echo $result;
    }
  
      //--------------------------------------------------------------------------------
      //--- eliminar de registros
      //--------------------------------------------------------------------------------              
     function eliminar($id ){
      
     	$result ='No se puede eliminar el registro';
  
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
    
 
    //------ poner informacion en los campos del sistema
     if (isset($_GET['accion']))	{
            
            $accion    = $_GET['accion'];
            
            $id        = $_GET['id'];
            
            $gestion->consultaId($accion,$id);
     }  
  
      //------ grud de datos insercion
     if (isset($_POST["action"]))	{
        
            $action 	= $_POST["action"];
        
            $id 		= $_POST["cab_codigo"];
        
            $gestion->xcrud(trim($action),$id );
           
    }      
  
     
   
 ?>
 
  
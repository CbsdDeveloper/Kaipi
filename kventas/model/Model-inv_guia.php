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
        
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
                
                $this->tabla 	  	  = 'guia_cabecera';
                
                $this->secuencia 	     = 'guia_cabecera_cab_codigo_seq';
         
                $this->ATabla = array(
                		array( campo => 'cab_codigo',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
                        array( campo => 'cab_estado_comprobante',tipo => 'VARCHAR2',id => '1',add => 'N', edit => 'N', valor => '-', key => 'N'),
                        array( campo => 'cab_observacion',tipo => 'VARCHAR2',id => '2',add => 'N', edit => 'N', valor => '-', key => 'N'),
                        array( campo => 'cab_autorizacion',tipo => 'VARCHAR2',id => '3',add => 'N', edit => 'N', valor => '-', key => 'N'),
                        array( campo => 'coddoc',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => '06', key => 'N'),
                        array( campo => 'estab',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
                        array( campo => 'ptoemi',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => '-', key => 'N'),
                        array( campo => 'secuencial',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'N', valor => '-', key => 'N'),
                        array( campo => 'fechaemision',tipo => 'DATE',id => '8',add => 'S', edit => 'S', valor => '-', key => 'N'),
                        array( campo => 'tipoidentificacioncomprador',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'S', valor => '-', key => 'N'),
                        array( campo => 'guiaremision',tipo => 'VARCHAR2',id => '10',add => 'S', edit => 'S', valor => '-', key => 'N'),
                        array( campo => 'razonsocialcomprador',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'S', valor => '-', key => 'N'),
                        array( campo => 'identificacioncomprador',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'S', valor => '-', key => 'N'),
                        array( campo => 'rise',tipo => 'VARCHAR2',id => '13',add => 'N', edit => 'N', valor => '-', key => 'N'),
                        array( campo => 'coddocmodificado',tipo => 'VARCHAR2',id => '14',add => 'N', edit => 'N', valor => '-', key => 'N'),
                        array( campo => 'numdocmodificado',tipo => 'VARCHAR2',id => '15',add => 'N', edit => 'N', valor => '-', key => 'N'),
                        array( campo => 'fechaemisiondocsustento',tipo => 'DATE',id => '16',add => 'N', edit => 'N', valor => '-', key => 'N'),
                        array( campo => 'ruc',tipo => 'VARCHAR2',id => '17',add => 'S', edit => 'S', valor => $this->ruc , key => 'N'),
                        array( campo => 'direccioncomprador',tipo => 'VARCHAR2',id => '18',add => 'S', edit => 'S', valor => '-', key => 'N'),
                        array( campo => 'dirpartida',tipo => 'VARCHAR2',id => '19',add => 'S', edit => 'S', valor => '-', key => 'N'),
                        array( campo => 'fechafintransporte',tipo => 'DATE',id => '20',add => 'S', edit => 'S', valor => '-', key => 'N'),
                        array( campo => 'placa',tipo => 'VARCHAR2',id => '21',add => 'S', edit => 'S', valor => '-', key => 'N'),
                        array( campo => 'modelo',tipo => 'VARCHAR2',id => '22',add => 'S', edit => 'S', valor => '-', key => 'N'),
                        array( campo => 'marca',tipo => 'VARCHAR2',id => '23',add => 'S', edit => 'S', valor => '-', key => 'N'),
                        array( campo => 'color',tipo => 'VARCHAR2',id => '24',add => 'S', edit => 'S', valor => '-', key => 'N'),
                        array( campo => 'estado',tipo => 'VARCHAR2',id => '25',add => 'S', edit => 'N', valor => 'digitado', key => 'N') 
                 );
        
                //---------------------------------------
                $this->ATablaDestino = array(
                    array( campo => 'des_codigo',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
                    array( campo => 'cab_codigo',tipo => 'NUMBER',id => '1',add => 'S', edit => 'N', valor => '-', key => 'N'),
                    array( campo => 'identificaciondestinatario',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'razonsocialdestinatario',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'dirdestinatario',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'motivotraslado',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'docaduanerounico',tipo => 'VARCHAR2',id => '6',add => 'N', edit => 'N', valor => '-', key => 'N'),
                    array( campo => 'codestabdestino',tipo => 'VARCHAR2',id => '7',add => 'N', edit => 'N', valor => '-', key => 'N'),
                    array( campo => 'ruta',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'coddocsustento',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'numdocsustento',tipo => 'VARCHAR2',id => '10',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'numautdocsustento',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'fechaemisiondocsustento',tipo => 'DATE',id => '12',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'factura',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'S', valor => '-', key => 'N')
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
  	    array( campo => 'cab_estado_comprobante',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'cab_observacion',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'cab_autorizacion',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'coddoc',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'estab',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'ptoemi',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'secuencial',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'fechaemision',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'tipoidentificacioncomprador',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'guiaremision',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'razonsocialcomprador',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'identificacioncomprador',valor => '-',filtro => 'N', visor => 'S'),
  	    array( campo => 'direccioncomprador',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'dirpartida',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'fechafintransporte',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'modelo',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'marca',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'estado',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'color',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'placa',valor => '-',filtro => 'N', visor => 'S')
   	);
 
          
     $datos = $this->bd->JqueryArrayVisor('guia_cabecera',$qquery );           
 
     //--------------------------
     $x = $this->bd->query_array('guia_destinatario',
                                 'numdocsustento,numautdocsustento,fechaemisiondocsustento,factura,des_codigo, identificaciondestinatario,razonsocialdestinatario, dirdestinatario,motivotraslado,ruta,coddocsustento', 
                                 'cab_codigo='.$this->bd->sqlvalue_inyeccion($id,true));
     
     
     echo '<script>
              $("#des_codigo").val("'.$x['des_codigo'].'");
              $("#identificaciondestinatario").val("'.$x['identificaciondestinatario'].'");
              $("#razonsocialdestinatario").val("'.$x['razonsocialdestinatario'].'");
              $("#dirdestinatario").val("'.$x['dirdestinatario'].'");
              $("#motivotraslado").val("'.$x['motivotraslado'].'");
              $("#ruta").val("'.$x['ruta'].'");
              $("#coddocsustento").val("'.$x['coddocsustento'].'");

              $("#numdocsustento").val("'.$x['numdocsustento'].'");
              $("#numautdocsustento").val("'.$x['numautdocsustento'].'");
              $("#fechaemisiondocsustento").val("'.$x['fechaemisiondocsustento'].'");
              $("#factura").val("'.$x['factura'].'");

      </script>';
  
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
         
         
           //  $idperiodo = $this->periodo($fecha);
         
           //
           
           $Acontador = $this->bd->query_array('guia_cabecera',
                                               '(count(cab_codigo) + 1) as codigo', 
                                               'ruc='.$this->bd->sqlvalue_inyeccion($this->ruc,true)
               );
         
            
           $comprobante =str_pad($Acontador['codigo'], 9, "0", STR_PAD_LEFT);
           
           $this->ATabla[7][valor] = $comprobante ;
           
           
             $id = $this->bd->_InsertSQL($this->tabla,$this->ATabla,$this->secuencia);
     	    
             echo '<script> $("#secuencial").val("'.$comprobante.' ");</script> ';
 
   
            //------------ seleccion de destino
             $this->ATablaDestino[1][valor] = $id ;
             $this->bd->_InsertSQL('guia_destinatario',$this->ATablaDestino,'guia_destinatario_des_codigo_seq');
             
             //------------ seleccion de destino
             /*
              SELECT id,  producto, unidad, cantidad
             FROM public.view_factura_detalle
             where estado = 'aprobado' and registro = '1711407567001' and comprobante like '%54%'
           */
          
        	$result = $this->div_resultado('editar',$id,1);
   
            echo $result;
          
     }	
   
      //--------------------------------------------------------------------------------
      //--- edicion de registros
      //--------------------------------------------------------------------------------              
       function edicion($id  ){
 
       $estado = trim($_POST["estado"]);
           
           
       if ( $estado == 'digitado'){
           
                $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
               	
                
                $idC = $_POST["des_codigo"];
                
                $this->ATablaDestino[0][valor] = $idC ;
                
                $this->bd->_UpdateSQL('guia_destinatario',$this->ATablaDestino,$idC);
                
             
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
 
  
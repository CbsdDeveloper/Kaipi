<h4>Importando archivo CSV</h4>
  <form action='Model_ventas_excel.php' method='post' enctype="multipart/form-data">
   Importar Archivo : <input type='file' name='sel_file' size='80' accept=".csv">
   <input type='submit' name='submit' value='Cargar Informacion'>
    <input name="MAX_FILE_SIZE" type="hidden" value="20000" /> 
     <input name="valida" type="hidden" value="S" /> 
  </form>
<?php 
session_start( );  
require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Db.conf.php';   /*Incluimos el fichero de la clase Conf*/

$bd	   =	new Db ;
$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

if(isset($_POST['submit']))
{
    //Aquí es donde seleccionamos nuestro csv
    $fname = $_FILES['sel_file']['name'];
    echo 'Cargando nombre del archivo: '.$fname.' <br>';
    $chk_ext = explode(".",$fname);
          
        $filename = $_FILES['sel_file']['tmp_name'];
        $handle = fopen($filename, "r");
        
        $i = 0;
        
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE)
        {
           
            $FECHA   =   trim($data[0]) ;
            $SERIE   =   trim($data[1]) ;
            $FACTURA =   trim($data[2]) ;
            $RUC_CLIENTE	 =   trim($data[3]) ;
            $NOMBRE_CLIENTE	 =   strtoupper(utf8_encode(trim($data[4])));
           
            $TARIFA0  =   str_replace(',','.',trim($data[5])) ;
            $BASE12   =   str_replace(',','.',trim($data[6])) ;
            $IVA      =   str_replace(',','.',trim($data[7])) ;
            $TOTAL    =   str_replace(',','.',trim($data[8])) ;
            
            
            $FECHA_RETE  =   trim($data[9]) ;
            $SERIE_RETE  =   trim($data[10]) ;
            $AUTO_RETE  =   trim($data[11]) ;
            
            $MONTO_RETENCION_FUENTE      =   str_replace(',','.',trim($data[12])) ;
            $MONTO_RETENCION_IVA     =   str_replace(',','.',trim($data[13])) ;
                
            
            $AValida = $bd->query_array('par_ciu',
                'count(idprov) as nproveedor',
                'idprov='.$bd->sqlvalue_inyeccion($RUC_CLIENTE,true)
                );
            
            //---- crea proveedor -----------------------
            if ($AValida["nproveedor"] == 0 ){
                
                if ( $i > 0 ){
                    
                    _proveedor($bd,$RUC_CLIENTE,$NOMBRE_CLIENTE);
                    
                }
              
            }
            //------------- VALIDA factura
            $ruc_registro  =  $_SESSION['ruc_registro'];
            $comprobante_f  =  str_pad($FACTURA, 9, "0", STR_PAD_LEFT);
            
            
            $ACompras = $bd->query_array('co_ventas',
            'count(co_ventas) as nfactura',
            'idcliente   ='.$bd->sqlvalue_inyeccion($RUC_CLIENTE,true). ' and
             registro ='.$bd->sqlvalue_inyeccion($ruc_registro,true). ' and
             secuencial='.$bd->sqlvalue_inyeccion($comprobante_f,true) 
             );
            
            //---------------------------------------------------------------------
            if ($ACompras["nfactura"] == 0 ){
                
                if ( $i > 0 ){
                    
                    
                    $establecimiento =  substr( $SERIE,0,3);
                    $puntoemision =  substr( $SERIE,3,3);
     
        
                    $fecharegistro = _fecha($FECHA);
                   
                    
                     
                    $tpidprov  = '04';
                    $len = strlen($RUC_CLIENTE);
                    
                      if($len == 10)
                        $tpidprov = '05';
                     elseif($len == 13)
                        $tpidprov = '04';
                        
                     if ($idcliente == '9999999999999')     {
                            $tpidprov = '07';
                     }
                        
                     if ($idcliente == '999999999')     {
                         $tpidprov = '07';
                     }
                     
                          
                    $ATabla = array(
                        array( campo => 'id_ventas',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
                        array( campo => 'id_asiento',tipo => 'NUMBER',id => '1',add => 'S', edit => 'N', valor => '0', key => 'N'),
                        array( campo => 'tpidcliente',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'N', valor => $tpidprov, key => 'N'),
                        array( campo => 'idcliente',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'N', valor => $RUC_CLIENTE, key => 'N'),
                        array( campo => 'tipocomprobante',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => '18', key => 'N'),
                        array( campo => 'numerocomprobantes',tipo => 'NUMBER',id => '5',add => 'S', edit => 'S', valor => '1', key => 'N'),
                        array( campo => 'basenograiva',tipo => 'NUMBER',id => '6',add => 'S', edit => 'S', valor => '0', key => 'N'),
                        array( campo => 'baseimponible',tipo => 'NUMBER',id => '7',add => 'S', edit => 'S', valor => $TARIFA0, key => 'N'),
                        array( campo => 'baseimpgrav',tipo => 'NUMBER',id => '8',add => 'S', edit => 'S', valor => $BASE12, key => 'N'),
                        array( campo => 'montoiva',tipo => 'NUMBER',id => '9',add => 'S', edit => 'S', valor =>$IVA, key => 'N'),
                        array( campo => 'valorretiva',tipo => 'NUMBER',id => '10',add => 'S', edit => 'S', valor => $MONTO_RETENCION_IVA, key => 'N'),
                        array( campo => 'valorretrenta',tipo => 'NUMBER',id => '11',add => 'S', edit => 'S', valor =>$MONTO_RETENCION_FUENTE, key => 'N'),
                        array( campo => 'secuencial',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'S', valor => $comprobante_f, key => 'N'),
                        array( campo => 'codestab',tipo => 'VARCHAR2',id => '13',add => 'S', edit => 'S', valor => $establecimiento, key => 'N'),
                        array( campo => 'fechaemision',tipo => 'DATE',id => '14',add => 'S', edit => 'S', valor =>$fecharegistro, key => 'N'),
                        array( campo => 'registro',tipo => 'VARCHAR2',id => '15',add => 'S', edit => 'N', valor => $ruc_registro  , key => 'N'),
                        array( campo => 'valorretbienes',tipo => 'NUMBER',id => '16',add => 'S', edit => 'S', valor => $MONTO_RETENCION_FUENTE, key => 'N'),
                        array( campo => 'valorretservicios',tipo => 'NUMBER',id => '17',add => 'S', edit => 'S', valor =>$MONTO_RETENCION_IVA, key => 'N'),
                        array( campo => 'anexo',tipo => 'NUMBER',id => '18',add => 'S', edit => 'S', valor => '1', key => 'N'),
                        array( campo => 'tipoemision',tipo => 'VARCHAR2',id => '19',add => 'S', edit => 'S', valor => 'F', key => 'N'),
                        array( campo => 'formapago',tipo => 'VARCHAR2',id => '20',add => 'S', edit => 'S', valor => '01', key => 'N'),
                        array( campo => 'montoice',tipo => 'VARCHAR2',id => '21',add => 'S', edit => 'S', valor => '0', key => 'N')
                    );
                    
                    $tabla 	  	  = 'co_ventas';
                    $secuencia 	     = '-';
                    
        
                    $id = $bd->_InsertSQL($tabla,$ATabla,$secuencia);
                    
               
                    
                }
                
            }
            //---------------------------------------------------------------------
             $i = 1 + $i;
                   
        }
        
        
        //cerramos la lectura del archivo "abrir archivo" con un "cerrar archivo"
        fclose($handle);
        echo "Importacion exitosa! Registros: ".$i.' '.$valida_total;
        
    }
     
 //-----------------------------------
    function _fecha($fecha_variable){
     
        // caso 1  16/8/2018 
        // caso 2  16/02/2015
        
        $longitud = strlen(trim($fecha_variable));
        
        $trozos = explode("/", $fecha_variable);
  
        $anio1 = $trozos[2];
        $mes1 =  $trozos[1];
        $dia1 =  $trozos[0]; 	
        
        
        $dia  =  str_pad($dia1, 2, "0", STR_PAD_LEFT);
        $mes  =  str_pad($mes1, 2, "0", STR_PAD_LEFT);
        
 
        return $anio1.'-'.$mes.'-'.$dia;
        
        
    }
    //----------------------------
    function _proveedor($bd,$RUC,$PROVEDOR){
        
        $sesion 	 =  $_SESSION['email'];
        
        $hoy 	     =  date("Y-m-d");     
        
        $ATabla = array(
            array( campo => 'idprov',   tipo => 'VARCHAR2',   id => '0',  add => 'S',   edit => 'N',   valor => $RUC,   filtro => 'N',   key => 'N'),
            array( campo => 'razon',   tipo => 'VARCHAR2',   id => '1',  add => 'S',   edit => 'N',   valor => $PROVEDOR,   filtro => 'N',   key => 'N'),
            array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '2',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
            array( campo => 'direccion',   tipo => 'VARCHAR2',   id => '3',  add => 'S',   edit => 'S',   valor => 'SD',   filtro => 'N',   key => 'N'),
            array( campo => 'telefono',   tipo => 'VARCHAR2',   id => '4',  add => 'S',   edit => 'S',   valor => '02-000000',   filtro => 'N',   key => 'N'),
            array( campo => 'correo',   tipo => 'VARCHAR2',   id => '5',  add => 'S',   edit => 'S',   valor => 'info@gmail.com',   filtro => 'N',   key => 'N'),
            array( campo => 'movil',   tipo => 'VARCHAR2',   id => '6',  add => 'S',   edit => 'S',   valor => '099999999',   filtro => 'N',   key => 'N'),
            array( campo => 'idciudad',   tipo => 'NUMBER',   id => '7',  add => 'S',   edit => 'S',   valor => '1',   filtro => 'N',   key => 'N'),
            array( campo => 'contacto',   tipo => 'VARCHAR2',   id => '8',  add => 'S',   edit => 'S',   valor => $PROVEDOR,   filtro => 'N',   key => 'N'),
            array( campo => 'ctelefono',   tipo => 'VARCHAR2',   id => '9',  add => 'S',   edit => 'S',   valor => '02-000000',   filtro => 'N',   key => 'N'),
            array( campo => 'ccorreo',   tipo => 'VARCHAR2',   id => '10',  add => 'S',   edit => 'S',   valor => 'info@gmail.com',   filtro => 'N',   key => 'N'),
            array( campo => 'estado',   tipo => 'VARCHAR2',   id => '11',  add => 'S',   edit => 'S',   valor => 'S',   filtro => 'N',   key => 'N'),
            array( campo => 'tpidprov',   tipo => 'VARCHAR2',   id => '12',  add => 'S',   edit => 'N',   valor => '03',   filtro => 'N',   key => 'N'),
            array( campo => 'modulo',   tipo => 'VARCHAR2',   id => '13',  add => 'S',   edit => 'S',   valor => 'C',   filtro => 'N',   key => 'N'),
            array( campo => 'naturaleza',   tipo => 'VARCHAR2',   id => '14',  add => 'S',   edit => 'S',   valor => 'NN',   filtro => 'N',   key => 'N'),
            array( campo => 'sesion',   tipo => 'VARCHAR2',   id => '15',  add => 'S',   edit => 'N',   valor => $sesion,   filtro => 'N',   key => 'N'),
            array( campo => 'creacion',   tipo => 'DATE',   id => '16',  add => 'S',   edit => 'N',   valor => $hoy,   filtro => 'N',   key => 'N'),
            array( campo => 'modificacion',   tipo => 'DATE',   id => '17',  add => 'S',   edit => 'S',   valor => $hoy,   filtro => 'N',   key => 'N'),
            array( campo => 'msesion',   tipo => 'VARCHAR2',   id => '18',  add => 'S',   edit => 'S',   valor => $sesion,   filtro => 'N',   key => 'N'),
            array( campo => 'cmovil',   tipo => 'VARCHAR2',   id => '19',  add => 'S',   edit => 'S',   valor => '099999999',   filtro => 'N',   key => 'N')
        );
        
        $tabla 	  		    = 'par_ciu';
        $secuencia 	        = '-';
        $bd->_InsertSQL($tabla,$ATabla,$RUC);
        
    }
  
    //--------------------------
    function total_ir_add( $bd,$idcompra,$comprobante_f,$codretair ,$porcentaje, $baseimponible,$retencion){
        
 
        $AFuente = $bd->query_array('co_compras_f',
                                'count(*) as existe',
                                'codretair='.$bd->sqlvalue_inyeccion(trim($codretair),true).' and
                                id_compras='.$bd->sqlvalue_inyeccion($idcompra,true)
            );
        
        
        
        if ($AFuente["existe"] == 0) {
            
            if (trim($codretair) <> '-') {
                
                if ($baseimponible > 0 ) {
                       
                    $sql = "INSERT INTO co_compras_f(
                                                id_compras, id_asiento, secuencial, codretair, baseimpair, porcentajeair, valretair )
                                        VALUES (".
                                        $bd->sqlvalue_inyeccion($idcompra, true).",".
                                        $bd->sqlvalue_inyeccion(0, true).",".
                                        $bd->sqlvalue_inyeccion($comprobante_f, true).",".
                                        $bd->sqlvalue_inyeccion(trim($codretair), true).",".
                                        $bd->sqlvalue_inyeccion($baseimponible, true).",".
                                        $bd->sqlvalue_inyeccion($porcentaje , true).",".
                                        $bd->sqlvalue_inyeccion($retencion, true).")";
                                        
                                        $bd->ejecutar($sql);
                }
            }
        }
        
 
        
    }
 
?>
  
  
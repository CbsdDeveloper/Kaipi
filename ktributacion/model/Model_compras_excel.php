<h4>Importando archivo CSV</h4>
  <form action='Model_compras_excel.php' method='post' enctype="multipart/form-data">
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
    //Aqu� es donde seleccionamos nuestro csv
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
            $AUT_SRI =   trim($data[3]) ;
            $RUC     =   trim($data[4]) ;
            $PROVEDOR  =  strtoupper(utf8_encode(trim($data[5])));
            $DETALLE  =  strtoupper(utf8_encode(trim($data[6])));
            
            $TARIFA0  =   str_replace(',','.',trim($data[7])) ;
            $BASE12   =   str_replace(',','.',trim($data[8])) ;
            $IVA      =   str_replace(',','.',trim($data[9])) ;
            $TOTAL    =   str_replace(',','.',trim($data[10])) ;
            
            $FECHA_RETE  =   trim($data[11]) ;
            $SERIE_RETE  =   trim($data[12]) ;
            $NUMRETE  =   trim($data[13]) ;
            $AUTO_RETE  =   trim($data[14]) ;
            $PORCENTAJE_RETE  =   trim($data[15]) ;
            $CODIGO_RETE  =   trim($data[16]) ;
        
            $BASE_RETE      =   str_replace(',','.',trim($data[17])) ;
            $MONTO_RETE     =   str_replace(',','.',trim($data[18])) ;
            $PORCENTAJE_RETE_IVA  =   str_replace(',','.',trim($data[19])) ;
            $MONTO_IVA_RETE       =   str_replace(',','.',trim($data[20])) ;
            
            $CHEQUE  =   trim($data[21]) ;
            

           
            
            $AValida = $bd->query_array('par_ciu',
                'count(idprov) as nproveedor',
                'idprov='.$bd->sqlvalue_inyeccion($RUC,true)
                );
            
            //---- crea proveedor -----------------------
            if ($AValida["nproveedor"] == 0 ){
                
                if ( $i > 0 ){
                    
                    _proveedor($bd,$RUC,$PROVEDOR);
                    
                }
              
            }
            //------------- VALIDA factura
            $ruc_registro  =  $_SESSION['ruc_registro'];
            $comprobante_f  =  str_pad($FACTURA, 9, "0", STR_PAD_LEFT);
            
            
            $ACompras = $bd->query_array('co_compras',
            'count(secuencial) as nfactura',
            'idprov   ='.$bd->sqlvalue_inyeccion($RUC,true). ' and
             registro ='.$bd->sqlvalue_inyeccion($ruc_registro,true). ' and
             secuencial='.$bd->sqlvalue_inyeccion($comprobante_f,true) 
             );
            
            //---------------------------------------------------------------------
            if ($ACompras["nfactura"] == 0 ){
                
                if ( $i > 0 ){
                    
                    
                    $establecimiento =  substr( $SERIE,0,3);
                    $puntoemision =  substr( $SERIE,3,3);
                    
                    $baseimpair =  $TARIFA0+  $BASE12;
 
                     
                    $fecharegistro = _fecha($FECHA);
                    $fechaemiret1  = _fecha($FECHA_RETE);
                    
                    $porcentaje_iva = '0';
                    $valorretbienes     = '0';
                    $valorretservicios  = '0';
                    $valretserv100      = '0';
                    
                    if ($PORCENTAJE_RETE_IVA == '10'){
                        $porcentaje_iva = '4';
                        $valorretbienes     =  $MONTO_IVA_RETE;
                    }elseif($PORCENTAJE_RETE_IVA == '20'){
                        $porcentaje_iva = '5';
                        $valorretservicios     =  $MONTO_IVA_RETE;
                     }elseif($PORCENTAJE_RETE_IVA == '30'){
                         $porcentaje_iva = '1';
                         $valorretbienes     =  $MONTO_IVA_RETE;
                    }elseif($PORCENTAJE_RETE_IVA == '70'){
                        $porcentaje_iva = '2';
                        $valorretservicios     =  $MONTO_IVA_RETE;
                    }elseif($PORCENTAJE_RETE_IVA == '100'){
                        $porcentaje_iva = '3';
                        $valretserv100        =  $MONTO_IVA_RETE;
                    }

                     
                    $ATabla = array(
                        array( campo => 'id_compras',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
                        array( campo => 'id_asiento',tipo => 'NUMBER',id => '1',add => 'S', edit => 'N', valor => '0', key => 'N'),
                        array( campo => 'codsustento',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => '01', key => 'N'),
                        array( campo => 'tpidprov',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => '01', key => 'N'),
                        array( campo => 'idprov',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => $RUC, key => 'N'),
                        array( campo => 'tipocomprobante',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => '01', key => 'N'),
                        array( campo => 'fecharegistro',tipo => 'DATE',id => '6',add => 'S', edit => 'S', valor => $fecharegistro, key => 'N'),
                        array( campo => 'establecimiento',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => $establecimiento, key => 'N'),
                        array( campo => 'puntoemision',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor => $puntoemision, key => 'N'),
                        array( campo => 'secuencial',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'S', valor => $comprobante_f, key => 'N'),
                        array( campo => 'fechaemision',tipo => 'DATE',id => '10',add => 'S', edit => 'S', valor =>$fecharegistro, key => 'N'),
                        array( campo => 'autorizacion',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'S', valor =>$AUT_SRI, key => 'N'),
                        array( campo => 'basenograiva',tipo => 'NUMBER',id => '12',add => 'S', edit => 'S', valor => '0', key => 'N'),
                        array( campo => 'baseimponible',tipo => 'NUMBER',id => '13',add => 'S', edit => 'S', valor => $TARIFA0, key => 'N'),
                        array( campo => 'baseimpgrav',tipo => 'NUMBER',id => '14',add => 'S', edit => 'S', valor => $BASE12, key => 'N'),
                        array( campo => 'montoice',tipo => 'NUMBER',id => '15',add => 'S', edit => 'S', valor => '0', key => 'N'),
                        array( campo => 'montoiva',tipo => 'NUMBER',id => '16',add => 'S', edit => 'S', valor => $IVA, key => 'N'),
                        array( campo => 'valorretbienes',tipo => 'NUMBER',id => '17',add => 'S', edit => 'S', valor =>$valorretbienes, key => 'N'),
                        array( campo => 'valorretservicios',tipo => 'NUMBER',id => '18',add => 'S', edit => 'S', valor =>$valorretservicios, key => 'N'),
                        array( campo => 'valretserv100',tipo => 'NUMBER',id => '19',add => 'S', edit => 'S', valor =>$valretserv100, key => 'N'),
                        array( campo => 'registro',tipo => 'VARCHAR2',id => '20',add => 'S', edit => 'N', valor =>$ruc_registro , key => 'N'),
                        array( campo => 'porcentaje_iva',tipo => 'NUMBER',id => '21',add => 'S', edit => 'S', valor => $porcentaje_iva, key => 'N'),
                        array( campo => 'baseimpair',tipo => 'NUMBER',id => '22',add => 'S', edit => 'S', valor =>$baseimpair, key => 'N'),
                        array( campo => 'pagolocext',tipo => 'VARCHAR2',id => '23',add => 'S', edit => 'S', valor => '01', key => 'N'),
                        array( campo => 'paisefecpago',tipo => 'VARCHAR2',id => '24',add => 'S', edit => 'S', valor => 'NA', key => 'N'),
                        array( campo => 'faplicconvdobtrib',tipo => 'VARCHAR2',id => '25',add => 'S', edit => 'S', valor => 'NA', key => 'N'),
                        array( campo => 'fpagextsujretnorLeg',tipo => 'VARCHAR2',id => '26',add => 'N', edit => 'S', valor => '-', key => 'N'),
                        array( campo => 'formadepago',tipo => 'VARCHAR2',id => '27',add => 'S', edit => 'S', valor => '01', key => 'N'),
                        array( campo => 'fechaemiret1',tipo => 'DATE',id => '28',add => 'S', edit => 'S', valor => $fechaemiret1, key => 'N'),
                        array( campo => 'serie1',tipo => 'VARCHAR2',id => '29',add => 'S', edit => 'S', valor => $SERIE_RETE, key => 'N'),
                        array( campo => 'secretencion1',tipo => 'VARCHAR2',id => '30',add => 'S', edit => 'S', valor => $NUMRETE, key => 'N'),
                        array( campo => 'autretencion1',tipo => 'VARCHAR2',id => '31',add => 'S', edit => 'S', valor => $AUTO_RETE, key => 'N'),
                        array( campo => 'docmodificado',tipo => 'VARCHAR2',id => '32',add => 'N', edit => 'S', valor => '-', key => 'N'),
                        array( campo => 'secmodificado',tipo => 'VARCHAR2',id => '33',add => 'N', edit => 'S', valor => '-', key => 'N'),
                        array( campo => 'estabmodificado',tipo => 'VARCHAR2',id => '34',add => 'N', edit => 'S', valor => '-', key => 'N'),
                        array( campo => 'autmodificado',tipo => 'VARCHAR2',id => '35',add => 'N', edit => 'S', valor => '-', key => 'N'),
                        array( campo => 'detalle',tipo => 'VARCHAR2',id => '36',add => 'S', edit => 'S', valor => $DETALLE, key => 'N')
                    );
                    
                    $tabla 	  	  = 'co_compras';
                    $secuencia 	     = '-';
                    
        
                    $id = $bd->_InsertSQL($tabla,$ATabla,$secuencia);
                    
                    total_ir_add(  $bd,$id,$comprobante_f,$CODIGO_RETE ,$PORCENTAJE_RETE, $BASE_RETE,$MONTO_RETE);
                    
              
                    
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
            array( campo => 'modulo',   tipo => 'VARCHAR2',   id => '13',  add => 'S',   edit => 'S',   valor => 'P',   filtro => 'N',   key => 'N'),
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
  
  
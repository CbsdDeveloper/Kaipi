<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
    
     
    private $obj;
    private $bd;
    private $saldos;
    
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
        
        $this->sesion 	 =  trim($_SESSION['email']);
        
        $this->hoy 	     =  $this->bd->hoy();
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        


        $this->ATabla = array(
            array( campo => 'id_compras',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
            array( campo => 'id_asiento',tipo => 'NUMBER',id => '1',add => 'S', edit => 'N', valor => '0', key => 'N'),
            array( campo => 'codsustento',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'tpidprov',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'idprov',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'tipocomprobante',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'fecharegistro',tipo => 'DATE',id => '6',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'establecimiento',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'puntoemision',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'secuencial',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'fechaemision',tipo => 'DATE',id => '10',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'autorizacion',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'basenograiva',tipo => 'NUMBER',id => '12',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'baseimponible',tipo => 'NUMBER',id => '13',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'baseimpgrav',tipo => 'NUMBER',id => '14',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'montoice',tipo => 'NUMBER',id => '15',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'montoiva',tipo => 'NUMBER',id => '16',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'valorretbienes',tipo => 'NUMBER',id => '17',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'valorretservicios',tipo => 'NUMBER',id => '18',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'valretserv100',tipo => 'NUMBER',id => '19',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'registro',tipo => 'VARCHAR2',id => '20',add => 'S', edit => 'N', valor => $this->ruc , key => 'N'),
            array( campo => 'porcentaje_iva',tipo => 'NUMBER',id => '21',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'baseimpair',tipo => 'NUMBER',id => '22',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'pagolocext',tipo => 'VARCHAR2',id => '23',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'paisefecpago',tipo => 'VARCHAR2',id => '24',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'faplicconvdobtrib',tipo => 'VARCHAR2',id => '25',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'fpagextsujretnorLeg',tipo => 'VARCHAR2',id => '26',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'formadepago',tipo => 'VARCHAR2',id => '27',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'fechaemiret1',tipo => 'DATE',id => '28',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'serie1',tipo => 'VARCHAR2',id => '29',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'secretencion1',tipo => 'VARCHAR2',id => '30',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'autretencion1',tipo => 'VARCHAR2',id => '31',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'docmodificado',tipo => 'VARCHAR2',id => '32',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'secmodificado',tipo => 'VARCHAR2',id => '33',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'estabmodificado',tipo => 'VARCHAR2',id => '34',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'autmodificado',tipo => 'VARCHAR2',id => '35',add => 'S', edit => 'S', valor => '-', key => 'N') ,
            array( campo => 'detalle',tipo => 'VARCHAR2',id => '36',add => 'S', edit => 'S', valor => '-', key => 'N') ,
            array( campo => 'estado',tipo => 'VARCHAR2',id => '37',add => 'S', edit => 'N', valor => 'S', key => 'N') ,
            array( campo => 'id_tramite',tipo => 'VARCHAR2',id => '38',add => 'S', edit => 'S', valor => '-', key => 'N') ,
            array( campo => 'sesion',tipo => 'VARCHAR2',id => '39',add => 'S', edit => 'S', valor => $this->sesion, key => 'N') ,
            array( campo => 'porcentaje_iva2',tipo => 'NUMBER',id => '40',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'bservicios',tipo => 'NUMBER',id => '41',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'bbienes',tipo => 'NUMBER',id => '42',add => 'S', edit => 'S', valor => '-', key => 'N')
        );
        
         
        
        
        $this->tabla 	  	  = 'co_compras';
        
        $this->secuencia 	     = '-';
        
    }
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function div_resultado($accion,$id,$tipo,$estado){
         
        return  $this->bd->resultadoCRUD('ACTUALIZACION',$accion,$id,$tipo);
        
    }
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function div_limpiar($id ){
        //inicializamos la clase para conectarnos a la bd
        
       
        
        echo '<script type="text/javascript">';
        
        echo  'LimpiarPantalla();';
        
        echo '</script>';
        
        $resultado = '<b>TRANSACCION ANULADA/ELIMINADA.  Transaccion:'.$id .' </b>';

        return $resultado;
        
    }
    //--- busqueda de por codigo para llenar los datos
    //--------------------------------------------------------------------------------
    function consultaId($accion,$id ){
        
        $qqueryCompras = array(
            array( campo => 'id_compras',valor => $id ,filtro => 'S', visor => 'S'),
            array( campo => 'codsustento',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'tpidprov',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'idprov',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'razon',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'tipocomprobante',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'fecharegistro',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'establecimiento',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'fechaemision',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'autorizacion',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'basenograiva',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'baseimponible',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'baseimpgrav',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'montoice',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'montoiva',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'valorretbienes',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'valorretservicios',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'valretserv100',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'registro',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'porcentaje_iva',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'baseimpair',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'pagolocext',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'paisefecpago',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'faplicconvdobtrib',valor => '-',filtro => 'N', visor => 'S'),
             array( campo => 'formadepago',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'fechaemiret1',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'serie1',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'serie',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'secretencion1',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'autretencion1',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'docmodificado',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'secmodificado',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'estabmodificado',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'secuencial',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'autmodificado',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'fpagextsujretnorleg',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'id_asiento',valor => '-',filtro => 'N', visor => 'S')       ,
            array( campo => 'id_tramite',valor => '-',filtro => 'N', visor => 'S')       ,
            array( campo => 'detalle',valor => '-',filtro => 'N', visor => 'S')   ,    
            array( campo => 'porcentaje_iva2',valor => '-',filtro => 'N', visor => 'S') ,
            array( campo => 'bservicios',valor => '-',filtro => 'N', visor => 'S') , 
            array( campo => 'bbienes',valor => '-',filtro => 'N', visor => 'S')  
        );
        
        $estado = '';
        
        $this->bd->JqueryArrayVisor('view_anexos_compras',$qqueryCompras );
        
        $result =  $this->div_resultado($accion,$id,0,$estado);
        
        echo  $result;
    }
     //--------------------------------------------------------------------------------
     function xcrud($action,$id){
        
        
        // ------------------  agregar
        if ($action == 'add'){
            
            $this->agregar();
            
        }
        // ------------------  editar
        if ($action == 'editar'){
            
            $this->edicion($id);
            
        }
        // ------------------  eliminar
        if ($action == 'del'){
            
            $this->eliminar($id );
            
        }
        
    }
     //--------------------------------------------------------------------------------
      function total_ir_add( $idcompra,$secuencia ){
        
        $codretair       = $_POST["codretair"];
        $baseimponible   = $_POST["baseimpair"];
        
        //
        
        $AFuente = $this->bd->query_array('co_compras_f',
                                          'count(*) as existe', 
                                          'codretair='.$this->bd->sqlvalue_inyeccion(trim($codretair),true).' and
                                           id_compras='.$this->bd->sqlvalue_inyeccion($idcompra,true)
                                        );
        
        $totalFuente = $this->bd->query_array('co_compras_f',
            'sum(baseimpair) as total_fuente',
            'id_compras='.$this->bd->sqlvalue_inyeccion($idcompra,true)
            );
        
        $total_retencion = $totalFuente["total_fuente"] + $baseimponible ;
        
        $compra_base = $this->bd->query_array('co_compras',
            '(COALESCE(basenograiva,0) + COALESCE(baseimponible,0) + COALESCE(baseimpgrav,0) ) as total_fuente',
            'id_compras='.$this->bd->sqlvalue_inyeccion($idcompra,true)
            );
        
        
        $total_tt = $compra_base["total_fuente"]   ;
        
 
        
        
        if ($AFuente["existe"] == 0) {
            
            if (trim($codretair) <> '-') { 
                
                if ($baseimponible > 0 ) { 
               
                            $Aporcentaje = $this->bd->query_array('co_catalogo',
                                'valor1',
                                'tipo='.$this->bd->sqlvalue_inyeccion('Fuente de Impuesto a la Renta',true).' and
                                 codigo='.$this->bd->sqlvalue_inyeccion($codretair,true) .' and
                                 activo='.$this->bd->sqlvalue_inyeccion('S',true)
                                );
                            
                            $porcentaje = $Aporcentaje['valor1'] /100 ;
                            
                            $total = round($porcentaje * $baseimponible,2) ;
                            
                            if ( $total_retencion <= $total_tt  ) { 
                                
                           
          
                            $sql = "INSERT INTO co_compras_f(
                                                id_compras, id_asiento, secuencial, codretair, baseimpair, porcentajeair, valretair )
                                        VALUES (".
                                        $this->bd->sqlvalue_inyeccion($idcompra, true).",".
                                        $this->bd->sqlvalue_inyeccion(0, true).",".
                                        $this->bd->sqlvalue_inyeccion($secuencia, true).",".
                                        $this->bd->sqlvalue_inyeccion(trim($codretair), true).",".
                                        $this->bd->sqlvalue_inyeccion($baseimponible, true).",".
                                        $this->bd->sqlvalue_inyeccion($Aporcentaje['valor1'] , true).",".
                                        $this->bd->sqlvalue_inyeccion($total, true).")";
                                         
                                        $this->bd->ejecutar($sql);
                                        
                            }
                 }
            }
        }
          
            
    }
    //---
    function agrupar_retencion(  $idprov,$fecharegistro, $id ){
        
        $periodo= explode('-',$fecharegistro);

        $mes_periodo  = $periodo[1];
        $anio_periodo = $periodo[0];
        
        $mes = intval( $mes_periodo);
         
        $datos = $this->bd->query_array('co_compras',
        '*', 
         'idprov='.$this->bd->sqlvalue_inyeccion(trim($idprov),true) .' and '.
         'id_compras='.$this->bd->sqlvalue_inyeccion($id,true)  
        );
        
        $valida = $this->bd->query_array('view_anexos_compras',
        'count(*) as nn', 
         'idprov='.$this->bd->sqlvalue_inyeccion(trim($idprov),true) .' and '.
         'anio='.$this->bd->sqlvalue_inyeccion(  $anio_periodo,true)  .' and '.
         'mes='.$this->bd->sqlvalue_inyeccion(   $mes ,true)  .' and '.
         'grupo='.$this->bd->sqlvalue_inyeccion( 'N',true) . ' and '.
         'id_tramite='.$this->bd->sqlvalue_inyeccion( $datos['id_tramite'],true) 
        );

        $totales = $this->bd->query_array('view_anexos_compras',
                'sum(baseimponible) as baseimponible,
                sum(baseimpgrav) as baseimpgrav,
                sum(montoice) as montoice,
                sum(montoiva) as montoiva,
                sum(valorretbienes) as valorretbienes,
                sum(valorretservicios) as valorretservicios,
                sum(baseimpair) as baseimpair,
                sum(valretserv100) as valretserv100
        ', 
         'idprov='.$this->bd->sqlvalue_inyeccion(trim($idprov),true) .' and '.
         'anio='.$this->bd->sqlvalue_inyeccion(  $anio_periodo,true)  .' and '.
         'mes='.$this->bd->sqlvalue_inyeccion(   $mes ,true)  .' and '.
         'grupo='.$this->bd->sqlvalue_inyeccion( 'N',true)  . ' and '.
         'id_tramite='.$this->bd->sqlvalue_inyeccion( $datos['id_tramite'],true) 
        );


        if (  $valida['nn'] > 0 ){

             $estado = 'X';
            
            $this->ATabla[2][valor] =  $datos['codsustento'];
            $this->ATabla[3][valor] =  $datos['tpidprov'];
            $this->ATabla[4][valor] =  $datos['idprov'];
            $this->ATabla[5][valor] =  $datos['tipocomprobante'];
            $this->ATabla[6][valor] =  $datos['fecharegistro'];

            $this->ATabla[7][valor] =  $datos['establecimiento'];
            $this->ATabla[8][valor] =  $datos['puntoemision'];
            $this->ATabla[9][valor] =  $datos['secuencial'];
            $this->ATabla[10][valor] =  $datos['fechaemision'];
            $this->ATabla[11][valor] =  $datos['autorizacion'];
            $this->ATabla[12][valor] =  $datos['basenograiva'];

            $this->ATabla[13][valor] =  $totales['baseimponible'];
            $this->ATabla[14][valor] =  $totales['baseimpgrav'];
            $this->ATabla[15][valor] =  $totales['montoice'];
            $this->ATabla[16][valor] =  $totales['montoiva'];
            $this->ATabla[17][valor] =  $totales['valorretbienes'];
            $this->ATabla[18][valor] =  $totales['valorretservicios'];
            
            $this->ATabla[19][valor] =  $totales['valretserv100'];

            $this->ATabla[21][valor] =  $datos['porcentaje_iva'];
            $this->ATabla[22][valor] =  $totales['baseimpair'];
            $this->ATabla[23][valor] =  $datos['pagolocext'];
            $this->ATabla[24][valor] =  $datos['paisefecpago'];
            $this->ATabla[25][valor] =  $datos['faplicconvdobtrib'];
 
            $this->ATabla[26][valor] =  $datos['fpagextsujretnorLeg'];
            $this->ATabla[27][valor] =  $datos['formadepago'];
            $this->ATabla[28][valor] =  $datos['fechaemiret1'];
            $this->ATabla[29][valor] =  $datos['serie1'];
            $this->ATabla[30][valor] =  $datos['secretencion1'];

            $this->ATabla[31][valor] =  $datos['autretencion1'];
            $this->ATabla[32][valor] =  $datos['docmodificado'];
            $this->ATabla[33][valor] =  $datos['secmodificado'];
            $this->ATabla[34][valor] =  $datos['estabmodificado'];
            $this->ATabla[35][valor] =  $datos['autmodificado'];
  
            $this->ATabla[36][valor] =  $datos['detalle'];
            $this->ATabla[37][valor] =  'X';
            $this->ATabla[38][valor] =  $datos['id_tramite'];
          
            $this->ATabla[40][valor] =  $datos['porcentaje_iva2'];
            $this->ATabla[41][valor] =  $datos['montoiva'];
            $this->ATabla[42][valor] =  $datos['bbienes'];


            $idcompra = $this->bd->_InsertSQL($this->tabla,$this->ATabla,$this->secuencia);


            $valida = $this->bd->query_array('view_anexos_compras',
            'count(*) as nn', 
             'idprov='.$this->bd->sqlvalue_inyeccion(trim($idprov),true) .' and '.
             'anio='.$this->bd->sqlvalue_inyeccion(  $anio_periodo,true)  .' and '.
             'mes='.$this->bd->sqlvalue_inyeccion(   $mes ,true)  .' and '.
             'grupo='.$this->bd->sqlvalue_inyeccion( 'N',true)  
            );


                        $sql_det = "select * from view_anexos_fuente 
                                    where ".
                                    'idprov='.$this->bd->sqlvalue_inyeccion(trim($idprov),true) .' and '.
                                    'anio='.$this->bd->sqlvalue_inyeccion(  $anio_periodo,true)  .' and '.
                                    'mes='.$this->bd->sqlvalue_inyeccion(   $mes ,true)  .' and '.
                                    'grupo='.$this->bd->sqlvalue_inyeccion( 'N',true)  ;

                    $stmt1              = $this->bd->ejecutar($sql_det);


                    $CADENA = '';
                    while ($x=$this->bd->obtener_fila($stmt1)){

 
                        $secuencia   = trim($x['secuencial']);
                        $codretair   =    $x['codretair'];
                        $baseimpair     = $x['baseimpair'];
                        $porcentajeair  = $x['porcentajeair'];
                        $valretair      = $x['valretair'];

                        $idco  =  $x['id_compras'];

                        $sql = "INSERT INTO co_compras_f(
                            id_compras, id_asiento, secuencial, codretair, baseimpair, porcentajeair, valretair )
                            VALUES (".
                            $this->bd->sqlvalue_inyeccion($idcompra, true).",".
                            $this->bd->sqlvalue_inyeccion(0, true).",".
                            $this->bd->sqlvalue_inyeccion($secuencia, true).",".
                            $this->bd->sqlvalue_inyeccion(trim($codretair), true).",".
                            $this->bd->sqlvalue_inyeccion($baseimpair, true).",".
                            $this->bd->sqlvalue_inyeccion($porcentajeair , true).",".
                            $this->bd->sqlvalue_inyeccion($valretair, true).")";
                            
                            $this->bd->ejecutar($sql);


                            $sqlE = "UPDATE co_compras
                            SET 	referencia=".$this->bd->sqlvalue_inyeccion($idcompra, true).",
                                    grupo=".$this->bd->sqlvalue_inyeccion('S', true)."
                            WHERE id_compras=".$this->bd->sqlvalue_inyeccion($idco, true);

                            $this->bd->ejecutar($sqlE);

                            $CADENA = $CADENA .' '.$secuencia ;
                    
                }
  
        }

        $sqlE = "UPDATE co_compras
        SET 	detalle=".$this->bd->sqlvalue_inyeccion('Pago de facturas '. $CADENA, true)."
        WHERE id_compras=".$this->bd->sqlvalue_inyeccion($idcompra, true);
        $this->bd->ejecutar($sqlE);

        $result = 'COMPROBANTE PRE-EMITIDO .. VERIFIQUE LA INFORMACION '.$idcompra;

        echo $result;
        
										        
    }
    //----------------------------------------------------
    function agregar( ){
        
            
        $tpidprov = '01';
        
        $estado = '';
        
        $this->ATabla[3][valor] =  $tpidprov;
        $this->ATabla[7][valor] =  substr(@$_POST["serie"],0,3);
        $this->ATabla[8][valor] =  substr(@$_POST["serie"],3,3);
        
        $detalle = trim($_POST["detalle"]);
        $this->ATabla[36][valor] =   substr($detalle,0,149);
        
       
        $secuencia  = trim($_POST["secuencial"]);
        
        $idprov = $_POST["idprov"];
        
        $long = strlen($idprov);
        
        $montoiva    = $_POST["montoiva"];
        $bservicios  = $_POST["bservicios"];
        $bbienes     = $_POST["bbienes"];

        $tipocomprobante     = $_POST["tipocomprobante"];


        
        
        $total_iva = $bservicios +  $bbienes;
        
        $valida  = $this->BusquedaFactura($secuencia, trim($idprov), substr(@$_POST["serie"],0,3),substr(@$_POST["serie"],3,3), $tipocomprobante); 
        
        if ( $valida > 0 ){
            
            $result = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>NO SE PUEDE ACTUALIZAR NRO. DE FACTURA YA EMITIDA ?</b>';
            
        } else {
            
            if ( $long  >  9  ) {
                
                if ( $total_iva  > $montoiva ) {
                    
                    $result = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>EL MONTO RETENIDO EN IVA NO ES EL CORRECTO ?</b>';
                    
                }else {
                    $id = $this->bd->_InsertSQL($this->tabla,$this->ATabla,$this->secuencia);
                    
                    
                    $this->total_ir_add( $id,$secuencia );
                    
                    
                    $result = $this->div_resultado('editar',$id,1,$estado);
                }
            } else {
                
                $result = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>INGRESE EL CODIGO DEL PROVEEDOR ?</b>';
            }
            
        }
       
        
       
        
        echo $result;
        
										        
    }
    //--------------------------------.
    //----------------------------------------------------
    function BusquedaFactura($secuencial, $idprov,$establecimiento,$puntoemision, $tipocomprobante){
        
         
        

        $x = $this->bd->query_array('co_compras',
                                    'count(*) as nn', 
                                     'idprov='.$this->bd->sqlvalue_inyeccion(trim($idprov),true) .' and '.
                                     'establecimiento='.$this->bd->sqlvalue_inyeccion($establecimiento,true) .' and '.
                                     'tipocomprobante='.$this->bd->sqlvalue_inyeccion($tipocomprobante,true) .' and '.
                                     'puntoemision='.$this->bd->sqlvalue_inyeccion($puntoemision,true) .' and '.
                                     'secuencial='.$this->bd->sqlvalue_inyeccion($secuencial,true) .' and '.
                                     'registro='.$this->bd->sqlvalue_inyeccion($this->ruc,true)  
            );
        
 
        return $x['nn'] ;
        
        
    }
    //--------------------------------------------------------------------------------
    
    //--------------------------------------------------------------------------------
    function edicion($id){
        

        $AAnexo = $this->bd->query_array('co_compras',
            'id_asiento,autretencion1,secretencion1,fecharegistro,transaccion,coalesce(codigoe,0) as codigoe,estado,secuencial,grupo',
            'id_compras='.$this->bd->sqlvalue_inyeccion($id,true)
            );

                
        $tpidprov = '01';
        $estado  = '';
        
        $montoiva    = $_POST["montoiva"];
        $bservicios  = $_POST["bservicios"];
        $bbienes     = $_POST["bbienes"];
        
        $total_iva = $bservicios +  $bbienes;
        
        $this->ATabla[3][valor] =  $tpidprov;
        $this->ATabla[7][valor] =  substr(@$_POST["serie"],0,3);	 
        $this->ATabla[8][valor] =  substr(@$_POST["serie"],3,3);
        
        $secuencia  = trim($_POST["secuencial"]);

        $detalle = trim($_POST["detalle"]);
        
        $this->ATabla[36][valor] =   substr($detalle,0,149);
        
        $grupo = 0;

        if ( trim($AAnexo['estado']) == 'X' ) {
            $grupo = 1;
        }

        if (  $grupo == 1 ){

                $sql = "UPDATE co_compras
                SET 	codigoe=".$this->bd->sqlvalue_inyeccion(trim($AAnexo['codigoe']), true).",
                        transaccion=".$this->bd->sqlvalue_inyeccion(trim($AAnexo['transaccion']), true).",
                        autretencion1=".$this->bd->sqlvalue_inyeccion(trim($AAnexo['autretencion1']), true).",
                        secretencion1=".$this->bd->sqlvalue_inyeccion(trim($AAnexo['secretencion1']), true)."
                WHERE referencia=".$this->bd->sqlvalue_inyeccion($id, true);

            $this->bd->ejecutar($sql);
        }


        if ( $total_iva  > $montoiva ) {
            
            $result = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>EL MONTO RETENIDO EN IVA NO ES EL CORRECTO ?</b>';
            
        }else {
        
                $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
                
                $x = $this->bd->query_array('co_compras','transaccion', 'id_compras='.$this->bd->sqlvalue_inyeccion($id,true));
                
                
                if ( $x['transaccion'] <> 'E' ){
                    
                    $this->total_ir_add( $id,$secuencia );
                    
                }
                
               $result = $this->div_resultado('editar',$id,1,$estado);
 
        }
     
        
        echo $result;
    }
    
    //--------------------------------------------------------------------------------
    //--- eliminar de registros
    //--------------------------------------------------------------------------------
    function eliminar($id ){
        
  
        $AAnexo = $this->bd->query_array('co_compras',
            'id_asiento,autretencion1,transaccion,coalesce(codigoe,0) as codigoe,estado',
            'id_compras='.$this->bd->sqlvalue_inyeccion($id,true)
            );
        
        $result = '<b> NO SE PUEDE ELIMINAR LA TRANSACCION - ENLACE CONTABLE NRO.'.$AAnexo['id_compras'] .' </b>';
        
        if ( trim($AAnexo['transaccion']) == 'E' ) {
            
            $result = '<b> NO SE PUEDE ELIMINAR LA TRANSACCION - ANEXO AUTORIZADO </b>';
            
        }else {
          
                        if ( trim($AAnexo['codigoe'] ) == 0 ){
                                    $sql = 'delete from co_compras  where id_compras='.$this->bd->sqlvalue_inyeccion($id, true);
                                    $this->bd->ejecutar($sql);
                                    
                                    $sql = 'delete from co_compras_f  where id_compras='.$this->bd->sqlvalue_inyeccion($id, true);
                                    $this->bd->ejecutar($sql);
                                    
                                    $result = $this->div_limpiar($id);
                        }else {
                            $result = '<b> NO SE PUEDE ELIMINAR LA TRANSACCION - COMPROBANTE ENVIADO</b>';
                        }
            
        }
           
        echo $result;
        
    }
    //-------------------
    function AnularFactura($id ){
        
       
        $AAnexo = $this->bd->query_array('co_compras',
            'id_asiento,autretencion1,transaccion,coalesce(codigoe,0) as codigoe,estado,secuencial,grupo',
            'id_compras='.$this->bd->sqlvalue_inyeccion($id,true)
            );
        
 

        $result1 = '<b> NO SE PUEDE ANULAR LA TRANSACCION.'.$AAnexo['codigoe'].' Transaccion:'.$AAnexo['transaccion'] .' </b>';


 
        $bandera = 0;    
        $grupo   = 0;    

        if ( trim($AAnexo['transaccion']) == 'E' ) {
            $bandera = 1;
        }

        if ( trim($AAnexo['codigoe']) == '1' ) {
            $bandera = 1;
        }
        
        if ( trim($AAnexo['estado']) == 'X' ) {
            $grupo = 1;
        }


           
        if (  $grupo == 1 ){

            if (   $bandera == 0){
                $sql = 'delete from co_compras  where id_compras='.$this->bd->sqlvalue_inyeccion($id, true);
                $this->bd->ejecutar($sql);

                $sql = 'delete from co_compras_f  where id_compras='.$this->bd->sqlvalue_inyeccion($id, true);
                $this->bd->ejecutar($sql);

                $sql = "UPDATE co_compras
                SET 	grupo=".$this->bd->sqlvalue_inyeccion('N', true).",
                        referencia=".$this->bd->sqlvalue_inyeccion(0, true)."
                WHERE referencia=".$this->bd->sqlvalue_inyeccion($id, true);
        
                $this->bd->ejecutar($sql);

            }else{
            
                $secuencial = trim($AAnexo['secuencial'] ) ;
                
                $anulado    = '-'.substr($secuencial,1,9) ;

                $sql = "UPDATE co_compras
                SET 	codigoe=".$this->bd->sqlvalue_inyeccion(0, true).",
                        estado=".$this->bd->sqlvalue_inyeccion('N', true).",
                        secuencial=".$this->bd->sqlvalue_inyeccion($anulado, true).",
                        transaccion=".$this->bd->sqlvalue_inyeccion('', true)."
                WHERE id_compras=".$this->bd->sqlvalue_inyeccion($id, true);
        
              

               $this->bd->ejecutar($sql);
 
                $sql = 'delete from co_compras_f  where id_compras='.$this->bd->sqlvalue_inyeccion($id, true);
                $this->bd->ejecutar($sql);

                $sql = "UPDATE co_compras
                SET 	grupo=".$this->bd->sqlvalue_inyeccion('N', true).",
                        autretencion1=".$this->bd->sqlvalue_inyeccion('', true).",
                        secretencion1=".$this->bd->sqlvalue_inyeccion('', true).",
                        referencia=".$this->bd->sqlvalue_inyeccion(0, true)."
                WHERE referencia=".$this->bd->sqlvalue_inyeccion($id, true);
        
                $this->bd->ejecutar($sql);
            }
    
        }else{
            if (   $bandera == 1){

                $secuencial = trim($AAnexo['secuencial'] ) ;
                
                $anulado    = '-'.substr($secuencial,1,9) ;

                $sql = "UPDATE co_compras
                SET 	codigoe=".$this->bd->sqlvalue_inyeccion(0, true).",
                        estado=".$this->bd->sqlvalue_inyeccion('N', true).",
                        secuencial=".$this->bd->sqlvalue_inyeccion($anulado, true).",
                        transaccion=".$this->bd->sqlvalue_inyeccion('', true)."
                WHERE id_compras=".$this->bd->sqlvalue_inyeccion($id, true);
        
               $this->bd->ejecutar($sql);
 
                $sql = 'delete from co_compras_f  where id_compras='.$this->bd->sqlvalue_inyeccion($id, true);
                $this->bd->ejecutar($sql);
            }     
        }  

        $result= '';

       $result = $this->div_limpiar($id);

      
       
        
        echo   $result ;
        
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
    
    $accion    		    = $_GET['accion'];
    $id            		= $_GET['id'];
    
    if ( $accion == 'anular'){

        $gestion->AnularFactura($id);


    }elseif  ( $accion == 'agrupar'){

        $id            		= $_GET['id'];
        $razon            	= trim($_GET['razon']);
        $idprov            	= trim($_GET['idprov']);
        $fecharegistro      = $_GET['fecharegistro'];

        $gestion->agrupar_retencion($idprov,$fecharegistro,$id );
    
    }else {
        $gestion->consultaId($accion,$id);
    }

    
    
    
}

//------ grud de datos insercion
if (isset($_POST["action"]))	{
    
    $action 		=     @$_POST["action"];
    
    $id 			=     @$_POST["id_compras"];
    
    
    $gestion->xcrud(trim($action) ,  $id  );
    
    
}



?> 
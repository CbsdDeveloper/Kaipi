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
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
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
            array( campo => 'sesion',tipo => 'VARCHAR2',id => '39',add => 'S', edit => 'S', valor => $this->sesion, key => 'N') 
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
    function div_limpiar( ){
        //inicializamos la clase para conectarnos a la bd
        
        $resultado = 'REGISTRO ELIMINADO ';
        
        echo '<script type="text/javascript">';
        
        echo  'LimpiarPantalla();';
        
        echo '</script>';
        
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
            array( campo => 'detalle',valor => '-',filtro => 'N', visor => 'S')       
            
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
        
        $valida  = $this->BusquedaFactura($secuencia, trim($idprov)); 
        
        if ( $valida > 0 ){
            
            $result = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>NO SE PUEDE ACTUALIZAR NRO. DE FACTURA YA EMITIDA ?</b>';
            
        } else {
            
            if ( $long  >  9  ) {
                
        
            $id = $this->bd->_InsertSQL($this->tabla,$this->ATabla,$this->secuencia);
            
            
            $this->total_ir_add( $id,$secuencia );
            
            
            $result = $this->div_resultado('editar',$id,1,$estado);
            
            } else {
                
                $result = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>INGRESE EL CODIGO DEL PROVEEDOR ?</b>';
            }
            
        }
       
        
       
        
        echo $result;
        
										        
    }
    //--------------------------------.
    //----------------------------------------------------
    function BusquedaFactura($secuencial, $idprov){
        
        
        $x = $this->bd->query_array('co_compras',
                                    'count(*) as nn', 
                                     'idprov='.$this->bd->sqlvalue_inyeccion(trim($idprov),true) .' and '.
                                     'secuencial='.$this->bd->sqlvalue_inyeccion($secuencial,true) .' and '.
                                     'registro='.$this->bd->sqlvalue_inyeccion($this->ruc,true)  
            );
        
 
        return $x['nn'] ;
        
        
    }
    //--------------------------------------------------------------------------------
    
    //--------------------------------------------------------------------------------
    function edicion($id){
        
                
        $tpidprov = '01';
        $estado  = '';
        
        $this->ATabla[3][valor] =  $tpidprov;
        $this->ATabla[7][valor] =  substr(@$_POST["serie"],0,3);	 
        $this->ATabla[8][valor] =  substr(@$_POST["serie"],3,3);
        
        $secuencia  = trim($_POST["secuencial"]);

        $detalle = trim($_POST["detalle"]);
        $this->ATabla[36][valor] =   substr($detalle,0,149);
        
        $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
        
        $x = $this->bd->query_array('co_compras','transaccion', 'id_compras='.$this->bd->sqlvalue_inyeccion($id,true));
        
        
        if ( $x['transaccion'] <> 'E' ){
            
            $this->total_ir_add( $id,$secuencia );
            
        }
        
       $result = $this->div_resultado('editar',$id,1,$estado);
 
         
     
        
        echo $result;
    }
    
    //--------------------------------------------------------------------------------
    //--- eliminar de registros
    //--------------------------------------------------------------------------------
    function eliminar($id ){
        
  
        $AAnexo = $this->bd->query_array('co_compras',
            'id_asiento,autretencion1,transaccion,codigoe,estado',
            'id_compras='.$this->bd->sqlvalue_inyeccion($id,true)
            );
        
        $result = '<b> NO SE PUEDE ELIMINAR LA TRANSACCION - ENLACE CONTABLE NRO.'.$AAnexo['id_compras'] .' </b>';
        
        if ($AAnexo['transaccion'] == 'E' ) {
            
            $result = '<b> NO SE PUEDE ELIMINAR LA TRANSACCION - ANEXO AUTORIZADO </b>';
            
        }else {
          
                        if ( trim($AAnexo['estado'] ) == 'S' ){
                                    $sql = 'delete from co_compras  where id_compras='.$this->bd->sqlvalue_inyeccion($id, true);
                                    $this->bd->ejecutar($sql);
                                    
                                    $sql = 'delete from co_compras_f  where id_compras='.$this->bd->sqlvalue_inyeccion($id, true);
                                    $this->bd->ejecutar($sql);
                                    
                                    $result = $this->div_limpiar();
                        }else {
                            $result = '<b> NO SE PUEDE ELIMINAR LA TRANSACCION - COMPROBANTE ENVIADO</b>';
                        }
            
        }
           
        echo $result;
        
    }
    //-------------------
    function AnularFactura($id ){
        
       
        $AAnexo = $this->bd->query_array('co_compras',
            'id_asiento,autretencion1,transaccion,codigoe,estado,secuencial',
            'id_compras='.$this->bd->sqlvalue_inyeccion($id,true)
            );
        
        $result = '<b> NO SE PUEDE ELIMINAR LA TRANSACCION - ENLACE CONTABLE NRO.'.$AAnexo['id_asiento'] .' </b>';
        
        if ($AAnexo['transaccion'] <> 'E' ) {
            
            $result = '<b> NO SE PUEDE ANULAR LA TRANSACCION </b>';
            
        }else {
            
            if ( trim($AAnexo['estado'] ) == 'S' ){
                
                $secuencial = trim($AAnexo['secuencial'] ) ;
                
                $anulado    = '-'.substr($secuencial,1,9) ;
                
                
                
                $sql = "UPDATE co_compras
                        SET 	codigoe=".$this->bd->sqlvalue_inyeccion(0, true).",
                                estado=".$this->bd->sqlvalue_inyeccion('N', true).",
                                secuencial=".$this->bd->sqlvalue_inyeccion($anulado, true).",
                                secretencion1=".$this->bd->sqlvalue_inyeccion('', true).",
                                autretencion1=".$this->bd->sqlvalue_inyeccion('', true).",
                                transaccion=".$this->bd->sqlvalue_inyeccion('', true)."
                        WHERE id_compras=".$this->bd->sqlvalue_inyeccion($id, true);
                
                $this->bd->ejecutar($sql);
                
                $sql = 'delete from co_compras_f  where id_compras='.$this->bd->sqlvalue_inyeccion($id, true);
                $this->bd->ejecutar($sql);
                
                $result = $this->div_limpiar();
                
                
            }else {
                $result = '<b> NO SE PUEDE ELIMINAR LA TRANSACCION - COMPROBANTE ENVIADO</b>';
            }
            
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


//------ poner informacion en los campos del sistema
if (isset($_GET['accion']))	{
    
    $accion    		    = $_GET['accion'];
    $id            		= $_GET['id'];
    
    if ( $accion == 'anular'){
        $gestion->AnularFactura($id);
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
 
  
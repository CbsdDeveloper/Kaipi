<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
    
    //creamos la variable donde se instanciar la clase "mysql"
    
    private $obj;
    private $bd;
    private $bdMysql;
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
        
        $this->sesion 	 =  $_SESSION['email'];
        
        $this->hoy 	     =  $this->bd->hoy();
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
     
        $this->bdMysql	   =	new Db ;
        
        $this->bdMysql->conectar_Mysql();
        
        $this->bdMysql->DBtipo('mysql');
        
        
        
    }
      
     //--------------------------------------------------------------------------------
    function retencionFuente( $idcompra,$secuencia,$codretair,$baseimponible,$retencion,$porcentajeair ){
 
        
        
        $AFuente = $this->bd->query_array('co_compras_f',
                                          'count(*) as existe', 
                                          'codretair='.$this->bd->sqlvalue_inyeccion(trim($codretair),true).' and
                                           id_compras='.$this->bd->sqlvalue_inyeccion($idcompra,true)
                                        );
        
        
        
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
                            
                             
          
                            $sql = "INSERT INTO co_compras_f(
                                                id_compras, id_asiento, secuencial, codretair, baseimpair, porcentajeair, valretair )
                                        VALUES (".
                                        $this->bd->sqlvalue_inyeccion($idcompra, true).",".
                                        $this->bd->sqlvalue_inyeccion(0, true).",".
                                        $this->bd->sqlvalue_inyeccion($secuencia, true).",".
                                        $this->bd->sqlvalue_inyeccion(trim($codretair), true).",".
                                        $this->bd->sqlvalue_inyeccion($baseimponible, true).",".
                                        $this->bd->sqlvalue_inyeccion($porcentajeair, true).",".
                                        $this->bd->sqlvalue_inyeccion($retencion, true).")";
                                         
                                        $this->bd->ejecutar($sql);
                 }
            }
        }
          
            
    }
    //----------------------------------------------------
    function agregar( $id ){
         
        $datos = $this->busqueda( $id );
        
        $existe_proveedor = $this->existe_proveedor(  trim($datos['rucpro'] )   );
        
        $idrete = $datos['IDRETE'];
        
                if ($existe_proveedor == 0){
                    
         
                    $this->_proveedor_agrega( trim( $datos['rucpro'] ), 
                                              trim( $datos['nompro']),   
                                              trim( $datos['dirpro']) , 
                                              trim( $datos['email']), 
                                              trim( $datos['telefono']) 
                                        );
                }
            
                
                $nvalida_tramite = $this->Asiento_valida( $id );
        
                if ($nvalida_tramite == 0){
                    
           
                        $hoy = date("Y-m-d");
                        $fecharegistro = "to_date('".$hoy."','yyyy/mm/dd')";
                        
                        $serie = trim($datos['numserie']);
                        
                        $establecimiento = substr($serie,0,3);
                        $puntoemision = substr($serie,3,3);
                        
                      
                          
                        $comprobante1 =str_pad(trim($datos['numdoc']), 9, "0", STR_PAD_LEFT);
                        
                        $secuencial = $comprobante1;
                        
                        $fechaemision =  "to_date('".$datos['fechaemision']."','yyyy/mm/dd')";
                         
                         
                        $total1 = $datos['valorretbienes'] + $datos['valorretservicios'] + $datos['valretserv100'];
                        $total2 = $datos['montoiva'];
                        
                        $p1 = ($total1 /  $total2) * 100;
                        $p2 = round($p1,0);
                        
                        $porcentaje_iva = 0;
                        
                        if ($p2 == 10){
                            $porcentaje_iva = 4;
                        }
                        if ($p2 == 20){
                            $porcentaje_iva = 5;
                        }
                        if ($p2 == 30){
                            $porcentaje_iva = 1;
                        }
                        if ($p2 == 70){
                            $porcentaje_iva = 2;
                        }
                        if ($p2 == 100){
                            $porcentaje_iva = 3;
                        }
                 
                        $AResultado = $this->bd->query_array('co_compras',
                                   'count(*) nn', 
                                    'idprov='.$this->bd->sqlvalue_inyeccion(trim($datos['rucpro']),true).' and 
                                    secuencial='.$this->bd->sqlvalue_inyeccion(trim($secuencial),true)
                             );
                        
                        if ( $AResultado['nn'] == 0 ){
                            
                        
                        
                        $sql = "INSERT INTO co_compras(
                                    id_asiento, codsustento, tpidprov, idprov, tipocomprobante,
                                    fecharegistro, establecimiento, puntoemision, secuencial, fechaemision,fechaemiret1,
                                    autorizacion, 
                                    basenograiva, 
                                    baseimponible, 
                                    baseimpgrav, montoice,
                                    montoiva, 
                                    valorretbienes, valorretservicios, valretserv100, porcentaje_iva,baseimpair,detalle,formadepago,
                                    pagolocext,paisefecpago,faplicconvdobtrib,fpagextsujretnorLeg,registro)
                            VALUES (".
                            $this->bd->sqlvalue_inyeccion($id, true).",".
                            $this->bd->sqlvalue_inyeccion('01', true).",".
                            $this->bd->sqlvalue_inyeccion($datos['tipoidentificacion'], true).",".
                            $this->bd->sqlvalue_inyeccion(trim($datos['rucpro']), true).",".
                            $this->bd->sqlvalue_inyeccion('01', true).",".
                            $fecharegistro.",".
                            $this->bd->sqlvalue_inyeccion($establecimiento, true).",".
                            $this->bd->sqlvalue_inyeccion($puntoemision, true).",".
                            $this->bd->sqlvalue_inyeccion($secuencial, true).",".
                            $fechaemision.",".
                            $fecharegistro.",".
                            $this->bd->sqlvalue_inyeccion($datos['autorizacion'], true).",".
                            $this->bd->sqlvalue_inyeccion($datos['basenograiva'], true).",".
                            $this->bd->sqlvalue_inyeccion($datos['baseimponible'], true).",".
                            $this->bd->sqlvalue_inyeccion($datos['baseimpgrav'], true).",".
                            $this->bd->sqlvalue_inyeccion(0, true).",".
                            $this->bd->sqlvalue_inyeccion($datos['montoiva'], true).",".
                            $this->bd->sqlvalue_inyeccion($datos['valorretbienes'], true).",".
                            $this->bd->sqlvalue_inyeccion($datos['valorretservicios'], true).",".
                            $this->bd->sqlvalue_inyeccion($datos['valretserv100'], true).",".
                            $this->bd->sqlvalue_inyeccion($porcentaje_iva, true).",".
                            $this->bd->sqlvalue_inyeccion($datos['baseimpair'], true).",".
                            $this->bd->sqlvalue_inyeccion($datos['descripcion'], true).",".
                            $this->bd->sqlvalue_inyeccion('01', true).",".
                            $this->bd->sqlvalue_inyeccion('01', true).",".
                            $this->bd->sqlvalue_inyeccion('NA', true).",".
                            $this->bd->sqlvalue_inyeccion('NA', true).",".
                            $this->bd->sqlvalue_inyeccion('NA', true).",".
                            $this->bd->sqlvalue_inyeccion($this->ruc, true).")";
                            
                            
                             $this->bd->ejecutar($sql);
                            
                            $id_compras = $this->bd->ultima_secuencia('co_compras'); 
                       
                            
                            ///--- inserta retencion
      
                            
                            $sql_opcion = 'SELECT b.codretair , a.baseimpair,a.valretair,   b.porcretair 
                                    from anetran_emapa.airxrete a , anetran_emapa.tabla10 b 
                                    WHERE a.idrete= '.$idrete.' AND a.idtabla10 =  b.idtabla10';
                            
                            
                            
                            $resultado = $this->bdMysql->ejecutar_Mysql($sql_opcion);
                            
                            $i= 0;
                            $ss = ' aqui ';
                            while ($row = mysqli_fetch_array($resultado)) { 
                               
                                $codretair     =  $row['codretair'];
                                $baseimponible =  $row['baseimpair'];
                                $retencion     =  $row['valretair'];
                                $porcentajeair =  $row['porcretair'];
                                
                               $this->retencionFuente( $id_compras,$secuencial,$codretair,$baseimponible ,$retencion,$porcentajeair);
                                
                                 
                             } 
        
                          $this->_actualiza_mysql($id);
                          
                        }
                }
        
                $result = 'ok'   ;
            
        return  $result;
 										        
    }
    //-------------------------------
    function _proveedor_agrega( $idproveedor ,$nombre,$dirpro,$email,$telefono){
        
        
        $idprov    =    $idproveedor  ;
        $razonSocial     =   $nombre ;
        $dirMatriz =    $dirpro ;
        
 
        
        $InsertQuery = array(
            array( campo => 'idprov', valor => trim($idprov) ),
            array( campo => 'razon', valor => $razonSocial),
            array( campo => 'direccion', valor => $dirMatriz),
            array( campo => 'estado', valor => 'S'),
            array( campo => 'modulo', valor => 'P'),
            array( campo => 'naturaleza', valor => 'NN'),
            array( campo => 'tpidprov', valor => '01'),
            array( campo => 'idciudad', valor => '18'),
            array( campo => 'telefono', valor => $telefono),
            array( campo => 'correo', valor => $email),
            array( campo => 'movil', valor =>$telefono),
            array( campo => 'sesion', valor => $this->sesion),
            array( campo => 'creacion', valor =>  $this->hoy),
            array( campo => 'modificacion', valor =>  $this->hoy),
            array( campo => 'msesion', valor => $this->sesion)
        );
        
        $this->bd->pideSq(0);
        
        $this->bd->JqueryInsertSQL('par_ciu',$InsertQuery);
        
        
        
    }
    //--------------------------------------------------------------------------------
    function busqueda( $id ){
         
        
        $sql = 'SELECT * 
                  FROM anetran_emapa.view_ane
                 WHERE numtrami = '.$id;
        
      $datosTramite = $this->bdMysql->ArrayVisor($sql);
        
      return $datosTramite ;
        
    }
    //--------------
    function Asiento_valida( $id ){
        
        
        $Aprove = $this->bd->query_array('co_compras',
            'count(id_asiento) as nn',
            'id_asiento='.$this->bd->sqlvalue_inyeccion($id,true)
            );
        
        
        if ( $Aprove['nn'] == 0 ) {
            return 0;
        }else {
            return 1;
        }
        
    }
    //-------------
    function _actualiza_mysql( $id ){
        
 
        $sql = 'update anetran_emapa.retenciones set k1 = 1 WHERE numtrami = '.$id;
        
        $this->bdMysql->ejecutar_Mysql($sql);
           
        return 1 ;
        
    }
    
     //---------------------------------------------------------
    function existe_proveedor($proveedor ){
        
        $Aprove = $this->bd->query_array('par_ciu',
            'count(idprov) as nn',
            'idprov='.$this->bd->sqlvalue_inyeccion($proveedor,true)
            );
        
        
        if ( $Aprove['nn'] == 0 ) {
            return 0;
        }else {
            return 1;
        }
        
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
if (isset($_GET['id_tramite']))	{
    
     $id            		= $_GET['id_tramite'];
    
  $ViewEnlace =  $gestion->agregar( $id );

   
  
     echo $ViewEnlace;
    
}
 



?>
 
  
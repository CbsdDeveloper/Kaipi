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
    private $datos;
    
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function proceso( ){
        //inicializamos la clase para conectarnos a la bd
        
        $this->obj     = 	new objects;
        $this->bd	   =	new Db ;
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        $this->sesion 	 =  $_SESSION['email'];
        $this->hoy 	     =  date("Y-m-d");
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
    }
    
    //--- calcula libro diario
    function archivo_asiento($id_ventas,$id_asiento,$idprov,$secuencial ){
        
       
        
        if (empty($id_asiento)){
            
               $idAsiento = $this->_asientos_contables( $idprov, $secuencial,$id_ventas);
               
               $this->_anexosTransacional($idAsiento,$id_ventas);
               
               echo '<script type="text/javascript">';
               
               echo  " $('#id_asiento').val(".$idAsiento."); ";
               
               echo '</script>';
               
               
               $result = '<img src="../../kimages/kfav.png" align="absmiddle"/>&nbsp;<b>ASIENTO EMITIDO CON EXITO ['.$idAsiento.']</b>';
               
                
        }else   
        {
            
            if ( $id_asiento == 0){
                
                $idAsiento = $this->_asientos_contables( $idprov, $secuencial,$id_ventas);
                
                $this->_anexosTransacional($idAsiento,$id_ventas);
                
                echo '<script type="text/javascript">';
                
                echo  " $('#id_asiento').val(".$idAsiento."); ";
                
                echo '</script>';
                
                
                $result = '<img src="../../kimages/kfav.png" align="absmiddle"/>&nbsp;<b>ASIENTO EMITIDO CON EXITO ['.$idAsiento.']</b>';
            }
            else {
                $this->_anexosTransacional($id_asiento,$id_ventas);
                
                $result = '<img src="../../kimages/nogusta.png" align="absmiddle"/>&nbsp;<b>ASIENTO GENERADO CONTABILIDAD</b>';
            }
           
            
        }
        
        echo $result;
        
    }
    //---------------------------------------------------------
     
    //---------------------------------------------------------
    function _anexosTransacional($id_asiento,$id_ventas){
        
        //<fechaEmision>27/05/2018</fechaEmision>  date("Y-m-d");
        
           
           $sql = "UPDATE co_ventas 
                   SET id_asiento = ".$this->bd->sqlvalue_inyeccion($id_asiento, true)."
                   WHERE id_ventas =".$this->bd->sqlvalue_inyeccion($id_ventas, true) ;

       
            $this->bd->ejecutar($sql);
            
           
            
             
            return $id_ventas;
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
    //---------------------------------------------------------
    
    //---------------------------------------------------------
    function _proveedor_agrega( $idproveedor ){
        
        
        $idprov    =    $idproveedor  ;
        $razonSocial     =    $this->datos['razonSocial'] ;
        $dirMatriz =    $this->datos['dirMatriz']  ;
        
        
        
        $InsertQuery = array(
            array( campo => 'idprov', valor => trim($idprov) ),
            array( campo => 'razon', valor => $razonSocial),
            array( campo => 'direccion', valor => $dirMatriz),
            array( campo => 'estado', valor => 'S'),
            array( campo => 'modulo', valor => 'C'),
            array( campo => 'naturaleza', valor => 'NN'),
            array( campo => 'tpidprov', valor => '01'),
            array( campo => 'idciudad', valor => '18'),
            array( campo => 'telefono', valor => '09999999'),
            array( campo => 'correo', valor => 'info@gmail.com'),
            array( campo => 'movil', valor => '09999999'),
            array( campo => 'sesion', valor => $this->sesion),
            array( campo => 'creacion', valor =>  $this->hoy),
            array( campo => 'modificacion', valor =>  $this->hoy),
            array( campo => 'msesion', valor => $this->sesion)
        );
        
        $this->bd->pideSq(0);
        $this->bd->JqueryInsertSQL('par_ciu',$InsertQuery);
        
        
        
    }
    //------------------
    function _asientos_contables( $idprov, $secuencial,$id_ventas  ){
        
        
        //------------ seleccion de periodo
        $Acompra = $this->bd->query_array('view_anexos_ventas',
            'fechaemision,anio,mes',
            'id_ventas ='.$this->bd->sqlvalue_inyeccion($id_ventas ,true) 
            );
        
        
        $detalle1 = 'Ventas del periodo';
        
        $hoy = $Acompra["fechaemision"];
        
        $cadenaFecha = "to_date('".$hoy."','yyyy/mm/dd')";
        
        
        $mes  	    = trim($Acompra["mes"]);
        $anio  		= trim($Acompra["anio"]);
        
        
        //------------ seleccion de periodo
        $periodo_s = $this->bd->query_array('co_periodo',
            'id_periodo',
            'registro ='.$this->bd->sqlvalue_inyeccion($this->ruc ,true).' and
                                         anio='.$this->bd->sqlvalue_inyeccion($anio ,true).' and
                                         mes='.$this->bd->sqlvalue_inyeccion($mes ,true)
            );
        
        
        $id_periodo  = $periodo_s["id_periodo"];
        $cuenta      = '';
        $estado      = 'digitado';
        
        $detalle      = 'Ventas '. $detalle1;
        $comprobante    = '-';
        
        
        //------------------------------------------------------------
        $sql = "INSERT INTO co_asiento(	fecha, registro, anio, mes, detalle, sesion, creacion,modulo,
                						comprobante, estado, tipo, documento,idprov,cuentag,estado_pago,
                                        id_periodo)
										        VALUES (".$cadenaFecha.",".
										        $this->bd->sqlvalue_inyeccion($this->ruc, true).",".
										        $this->bd->sqlvalue_inyeccion($anio, true).",".
										        $this->bd->sqlvalue_inyeccion($mes, true).",".
										        $this->bd->sqlvalue_inyeccion($detalle, true).",".
										        $this->bd->sqlvalue_inyeccion($this->sesion, true).",".
										        $cadenaFecha.",".
										        $this->bd->sqlvalue_inyeccion('cxcobrar', true).",".
										        $this->bd->sqlvalue_inyeccion($comprobante, true).",".
										        $this->bd->sqlvalue_inyeccion($estado, true).",".
										        $this->bd->sqlvalue_inyeccion('F', true).",".
										        $this->bd->sqlvalue_inyeccion(trim($secuencial), true).",".
										        $this->bd->sqlvalue_inyeccion(trim($idprov), true).",".
										        $this->bd->sqlvalue_inyeccion('-', true).",".
										        $this->bd->sqlvalue_inyeccion( 'N', true).",".
										        $this->bd->sqlvalue_inyeccion($id_periodo, true).")";
										        
										        
										        $this->bd->ejecutar($sql);
										        
										        $idAsiento =  $this->bd->ultima_secuencia('co_asiento');
										        
										        
										        return $idAsiento;
    }
    //---------------------------------------
    
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;



//------ grud de datos insercion
if (isset($_GET["id_ventas"]))	{
    
    
    $id_ventas 				=     $_GET["id_ventas"];
    $id_asiento 				=     $_GET["id_asiento"];
    $idprov 				    =     $_GET["idprov"];
    $secuencial 				=     $_GET["secuencial"];
    
    
    
    
    
    $gestion->archivo_asiento( $id_ventas, $id_asiento ,$idprov,$secuencial);
    
    
}



?>
 
  
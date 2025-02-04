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
        
        $this->sesion 	 =  $_SESSION['email'];
        
        $this->hoy 	     =  $this->bd->hoy();
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
        $this->ATabla = array(
            array( campo => 'id_ventas',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
            array( campo => 'id_asiento',tipo => 'NUMBER',id => '1',add => 'S', edit => 'N', valor => '0', key => 'N'),
            array( campo => 'tpidcliente',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'idcliente',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'tipocomprobante',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'numerocomprobantes',tipo => 'NUMBER',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'basenograiva',tipo => 'NUMBER',id => '6',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'baseimponible',tipo => 'NUMBER',id => '7',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'baseimpgrav',tipo => 'NUMBER',id => '8',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'montoiva',tipo => 'NUMBER',id => '9',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'valorretiva',tipo => 'NUMBER',id => '10',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'valorretrenta',tipo => 'NUMBER',id => '11',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'secuencial',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'codestab',tipo => 'VARCHAR2',id => '13',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'fechaemision',tipo => 'DATE',id => '14',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'registro',tipo => 'VARCHAR2',id => '15',add => 'S', edit => 'N', valor => $this->ruc  , key => 'N'),
            array( campo => 'valorretbienes',tipo => 'NUMBER',id => '16',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'valorretservicios',tipo => 'NUMBER',id => '17',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'anexo',tipo => 'NUMBER',id => '18',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'tipoemision',tipo => 'VARCHAR2',id => '19',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'formapago',tipo => 'VARCHAR2',id => '20',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'montoice',tipo => 'VARCHAR2',id => '21',add => 'S', edit => 'S', valor => '0.00', key => 'N')
        );
        
        $this->tabla 	  	  = 'co_ventas';
        
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
            array( campo => 'id_ventas',valor => $id,filtro => 'S', visor => 'S'),
            array( campo => 'id_asiento',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'tpidcliente',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'idcliente',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'razon',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'tipocomprobante',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'numerocomprobantes',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'basenograiva',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'baseimponible',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'baseimpgrav',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'montoiva',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'valorretiva',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'valorretrenta',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'secuencial',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'codestab',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'fechaemision',valor => '-',filtro => 'N', visor => 'S'),
             array( campo => 'valorretbienes',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'valorretservicios',valor => '-',filtro => 'N', visor => 'S'),
             array( campo => 'tipoemision',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'formapago',valor => '-',filtro => 'N', visor => 'S')
        );
        
        $estado = '';
        
        $this->bd->JqueryArrayVisor('view_anexos_ventas',$qqueryCompras );
        
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
     
    //----------------------------------------------------
    function agregar( ){
        
        $tpidprov  = '04';
        $idcliente = trim($_POST["idcliente"]);
        
        $len = strlen($idcliente);
        
        if($len == 10)
            $tpidprov = '05';
        elseif($len == 13)
            $tpidprov = '04';
            
       if ($idcliente == '9999999999999')     {
           $tpidprov = '07';
        }
            
            
        $estado= 'digitado';
        
        $this->ATabla[2][valor] =   $tpidprov ;
 
        
        $id = $this->bd->_InsertSQL($this->tabla,$this->ATabla,$this->secuencia);
        
 
        
        $result = $this->div_resultado('editar',$id,1,$estado);
        
        echo $result;
        
										        
    }
    //--------------------------------------------------------------------------------
    
    //--------------------------------------------------------------------------------
    function edicion($id){
        
        $tpidprov  = '04';
        $idcliente = trim($_POST["idcliente"]);
        
        $len = strlen($idcliente);
        
        if($len == 10)
            $tpidprov = '05';
            elseif($len == 13)
            $tpidprov = '04';
            
            if ($idcliente == '9999999999999')     {
                $tpidprov = '07';
            }
            
            
            
            $this->ATabla[2][valor] =   $tpidprov ;
        
        $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
                
 
        $estado = '';
        
        
        $result = $this->div_resultado('editar',$id,1,$estado);
        
        echo $result;
    }
    
    //--------------------------------------------------------------------------------
    //--- eliminar de registros
    //--------------------------------------------------------------------------------
    function eliminar($id ){
 
            $sql = 'delete from co_ventas  where id_ventas='.$this->bd->sqlvalue_inyeccion($id, true);
            $this->bd->ejecutar($sql);
            
          
            $result = $this->div_limpiar();
            
 
           
        echo $result;
        
    }

    /*
    */
    function enlace_datos($anio,$mes){
 
     
        $largo = strlen($mes);
        if ( $largo == 1){
            $mes = '0'.$mes;
        }
    

                    $sql = "SELECT  
                    max(secuencial) as secuencia   ,
                    idprov  ,
                    count(*) as nn,
                    coalesce(sum(base12),0) as base_imponible,
                    coalesce(sum(iva),0) as monto_iva,
                    coalesce(sum(base0),0) as tarifa_cero ,
                    max(fechap) as fecha
            FROM  rentas.view_ren_factura
            where  anio = ".$this->bd->sqlvalue_inyeccion( $anio,true)." and 
                mes = ".$this->bd->sqlvalue_inyeccion($mes,true)." and 
                envio = 'S'
                group by idprov
            order by idprov desc";


         

            $resultado  = $this->bd->ejecutar($sql);
                    
            while ($x=$this->bd->obtener_fila($resultado)){

              
                    
                $tpidprov   =   '04';
                $idcliente  =    trim($x['idprov'] ) ;
                $len        =    strlen($idcliente);
                if($len == 10) {
                    $tpidprov = '05';
                }    
                elseif($len == 13)  {
                    $tpidprov = '04';
                }  
               if ($idcliente == '9999999999999')     {
                   $tpidprov = '07';
                }
                  
                $this->ATabla[2][valor] =   $tpidprov ;
                $this->ATabla[3][valor] =   $idcliente  ;
                $this->ATabla[4][valor] =   '18'  ;
                $this->ATabla[5][valor] =   $x['nn']  ;

                $this->ATabla[6][valor] =  '0.00';
                $this->ATabla[7][valor] =   $x['tarifa_cero']  ;
                $this->ATabla[8][valor] =   $x['base_imponible']  ;
                $this->ATabla[9][valor] =   $x['monto_iva']  ;

                $this->ATabla[10][valor] =  '0.00';
                $this->ATabla[11][valor] =  '0.00';

                $secuencia = trim($x['secuencia'] );
                $this->ATabla[12][valor] =  trim($x['secuencia'] ) ;
                $this->ATabla[13][valor] = '001';

                $this->ATabla[14][valor] =  trim($x['fecha'] ) ;

                $this->ATabla[16][valor] =  '0.00';
                $this->ATabla[17][valor] =  '0.00';
                $this->ATabla[21][valor] =  '0.00';

                $this->ATabla[18][valor] =  '1';
                $this->ATabla[19][valor] =  'E';
                $this->ATabla[20][valor] =  '20';
  
                $datos = $this->bd->query_array('co_ventas',
                                                'count(*) as nn', 
                                                'idcliente='.$this->bd->sqlvalue_inyeccion($idcliente,true). ' and 
                                                 secuencial='.$this->bd->sqlvalue_inyeccion($secuencia,true)
                    );
                
                if ( $datos['nn'] > 0 ) {
                    
                }else {
                    $this->bd->_InsertSQL($this->tabla,$this->ATabla,$this->secuencia);
                }
               
                
            }

            $result = 'DATOS REALIZADOS CON EXITO VERIFICAR LA INFORMACION... ';
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
    

    if (  $accion   == 'enlace'){

        $anio    		    = $_GET['anio'];
        $mes    		    = $_GET['mes'];
        
        $gestion->enlace_datos($anio,$mes);
    }
    else    {
        $gestion->consultaId($accion,$id);
    }
       
    
    
    
}

//------ grud de datos insercion
if (isset($_POST["action"]))	{
    
    $action 		=     @$_POST["action"];
    
    $id 			=     @$_POST["id_ventas"];
    
    
    $gestion->xcrud(trim($action) ,  $id  );
    
    
}



?>
 
  
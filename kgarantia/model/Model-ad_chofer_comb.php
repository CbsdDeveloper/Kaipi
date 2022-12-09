<?php
session_start( );

require '../../kconfig/Db.class.php';    

require '../../kconfig/Obj.conf.php';  


class proceso{
    
     
    private $obj;
    private $bd;
    
    private $ruc;
    public  $sesion;
    public  $hoy;
    private $POST;
    private $ATabla;
     
    private $tabla ;
    private $secuencia;
    
    private $estado_periodo;
    private $ATabla_custodio ;
    
    private $ATabla_carro ;
    
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function proceso( ){
        //inicializamos la clase para conectarnos a la bd
        
        $this->obj     = 	new objects;
        $this->bd	   =	new Db ;
        
        $this->ruc       =     trim($_SESSION['ruc_registro']);
        
        $this->sesion 	 =     trim($_SESSION['email']);
        
        $this->hoy 	     =     date("Y-m-d");
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
        $this->ATabla = array(
            array( campo => 'id_bien',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
            array( campo => 'idbodega',tipo => 'NUMBER',id => '1',add => 'S', edit => 'N', valor => '0', key => 'N'),
            array( campo => 'tipo_bien',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'fecha',tipo => 'DATE',        id => '3',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'forma_ingreso',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'identificador',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'descripcion',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'origen_ingreso',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'N', valor => 'Compra', key => 'N'),
            array( campo => 'tipo_documento',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'N', valor => 'Factura', key => 'N'),
            array( campo => 'clase_documento',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'tipo_comprobante',tipo => 'VARCHAR2',id => '10',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'fecha_comprobante',tipo => 'DATE',id => '11',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'codigo_actual',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'estado',tipo => 'VARCHAR2',id => '13',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'costo_adquisicion',tipo => 'NUMBER',id => '14',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'depreciacion',tipo => 'VARCHAR2',id => '15',add => 'S', edit => 'N', valor => 'N', key => 'N'),
            array( campo => 'serie',tipo => 'VARCHAR2',id => '16',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'id_modelo',tipo => 'NUMBER',id => '17',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'id_marca',tipo => 'NUMBER',id => '18',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'clasificador',tipo => 'VARCHAR2',id => '19',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'cuenta',tipo => 'VARCHAR2',id => '20',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'valor_residual',tipo => 'NUMBER',id => '21',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'anio_depre',tipo => 'NUMBER',id => '22',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'cantidad',tipo => 'NUMBER',id => '23',add => 'S', edit => 'N', valor => '1', key => 'N'),
            array( campo => 'vida_util',tipo => 'NUMBER',id => '24',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'color',tipo => 'VARCHAR2',id => '25',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'dimension',tipo => 'VARCHAR2',id => '26',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'uso',tipo => 'VARCHAR2',id => '27',add => 'S', edit => 'N', valor => 'Libre', key => 'N'),
            array( campo => 'fecha_adquisicion',tipo => 'DATE',id => '28',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'clase',tipo => 'VARCHAR2',id => '29',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'sesion',tipo => 'VARCHAR2',id => '30',add => 'S', edit => 'N', valor =>  $this->sesion 	, key => 'N'),
            array( campo => 'creacion',tipo => 'DATE',id => '31',add => 'S', edit => 'N', valor => $this->hoy, key => 'N'),
            array( campo => 'sesionm',tipo => 'VARCHAR2',id => '32',add => 'S', edit => 'S', valor =>  $this->sesion 	, key => 'N'),
            array( campo => 'modificacion',tipo => 'DATE',id => '33',add => 'S', edit => 'S', valor => $this->hoy, key => 'N'),
            array( campo => 'material',tipo => 'VARCHAR2',id => '34',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'detalle',tipo => 'VARCHAR2',id => '35',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'detalle_ubica',tipo => 'VARCHAR2',id => '36',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'idsede',tipo => 'NUMBER',id => '37',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'idproveedor',tipo => 'VARCHAR2',id => '38',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'factura',tipo => 'NUMBER',id => '39',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'id_tramite',tipo => 'NUMBER',id => '40',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'tiempo_garantia',tipo => 'VARCHAR2',id => '41',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'garantia',tipo => 'VARCHAR2',id => '42',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'tipo',tipo => 'VARCHAR2',id => '43',add => 'S', edit => 'N', valor => 'BIENES', key => 'N')
        );
        
        
        
        
        
        $this->tabla 	  	  = 'activo.ac_bienes';
        
        $this->secuencia 	     = 'activo.ac_bienes_id_bien_seq';
        
        
        $this->ATabla_custodio = array(
            array( campo => 'id_bien_custodio',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
            array( campo => 'id_bien',tipo => 'NUMBER',id => '1',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'idprov',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'id_departamento',tipo => 'NUMBER',id => '3',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'creacion',tipo => 'DATE',id => '4',add => 'S', edit => 'N', valor =>  $this->hoy, key => 'N'),
            array( campo => 'sesion',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'N', valor =>$this->sesion , key => 'N'),
            array( campo => 'modificacion',tipo => 'DATE',id => '6',add => 'S', edit => 'S', valor =>  $this->hoy, key => 'N'),
            array( campo => 'sesionm',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => $this->sesion , key => 'N'),
            array( campo => 'tipo_ubicacion',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'tiene_acta',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'N', valor => 'N', key => 'N'),
            array( campo => 'ubicacion_fisica',tipo => 'VARCHAR2',id => '10',add => 'S', edit => 'S', valor => 'N', key => 'N')
        );
        
        
        
        
        
        
        $this->ATabla_carro = array(
            array( campo => 'id_bien_vehiculo',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
            array( campo => 'id_bien',tipo => 'NUMBER',id => '1',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'clase_ve',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'motor_ve',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'chasis_ve',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'placa_ve',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'anio_ve',tipo => 'NUMBER',id => '6',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'color_ve',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => '-', key => 'N'),
        );
        
      
    }
    //-----------------------------------------------------------------------------------------------------------
   
    
    //--------------------------------------------------------------------------------
    //--- busqueda de por codigo para llenar los datos
    //--------------------------------------------------------------------------------
    function consultaId($accion,$id ){
 
        
        $qquery = array(
            array( campo => 'id_bien',valor => $id,filtro => 'S', visor => 'S'),
            array( campo => 'descripcion',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'placa_ve',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'chofer_actual',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'placa_ve',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'codigo_veh',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'u_km',valor => '-',filtro => 'N', visor => 'S')
        );
        
        
       
       $datos =  $this->bd->JqueryArrayVisorDato('adm.view_bien_vehiculo',$qquery ,0);
    
       echo "<script>$('#id_bien').val(".trim($datos['id_bien'] ).");</script>";
       echo "<script>$('#nombre_vehiculo').val("."'".trim($datos['descripcion'] )."'".");</script>";
       echo "<script>$('#placa_vehiculo').val("."'".trim($datos['placa_ve'] )."'".");</script>";
       echo "<script>$('#chofer_vehiculo').val("."'".trim($datos['chofer_actual'] )."'".");</script>";
       
       echo "<script>$('#vcarro').val("."'".trim($datos['placa_ve'] )."'".");</script>";
       echo "<script>$('#vchofer').val("."'".trim($datos['chofer_actual'] )."'".");</script>";
       echo "<script>$('#u_km').val("."'".trim($datos['u_km'] )."'".");</script>";
       
       echo "<script>$('#codigo_veh').val("."'".trim($datos['codigo_veh'] )."'".");</script>";
       
       echo "<script>$('#Viewcarro').html("."'".trim($datos['descripcion'] )."'".");</script>";
       
       
       
       echo '<b>Generar Comprobante de Control de Combustible</b>';
        
  
    }
//-------------------
  
      
    function vehiculos($idbien){
        
        
        $Ac = $this->bd->query_array('activo.ac_bienes_vehiculo',
            'id_bien_vehiculo',
            'id_bien='.$this->bd->sqlvalue_inyeccion($idbien,true)
            );
        
        $id_bien_vehiculo = $Ac['id_bien_vehiculo'] ;
        
        
        
        if ( $id_bien_vehiculo > 0 ) {
            
            $this->bd->_UpdateSQL('activo.ac_bienes_vehiculo',$this->ATabla_carro,$id_bien_vehiculo);
            
        }else{
            $this->bd->_InsertSQL('activo.ac_bienes_vehiculo',$this->ATabla_carro, 'activo.ac_bienes_vehiculo_id_bien_vehiculo_seq');
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
if (isset($_GET['accion']))	{
    
    $accion    = $_GET['accion'];
    
    $id        = $_GET['id'];
    
    $gestion->consultaId($accion,$id);
    
    
    
}
 


?>
 
  
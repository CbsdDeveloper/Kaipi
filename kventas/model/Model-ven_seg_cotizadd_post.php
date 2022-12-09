<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
    
    //creamos la variable donde se instanciar la clase "mysql"
    
    private $obj;
    private $bd;
    
    private $ruc;
    public  $sesion;
    public  $hoy;
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
        
        $this->ruc       =     $_SESSION['ruc_registro'];
        
        $this->sesion 	 =     $_SESSION['email'];
        
        $this->hoy 	     =     date("Y-m-d");
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
        $this->ATabla = array(
            array( campo => 'id_cotizacion',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
            array( campo => 'fecha',tipo => 'DATE',id => '1',add => 'S', edit => 'N', valor =>$this->hoy, key => 'N'),
            array( campo => 'modulo',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'idprov',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'razon',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'estado',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'N', valor => '0', key => 'N'),
            array( campo => 'cabecera',tipo => 'VARCHAR2',id => '6',add => 'N', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'detalle',tipo => 'VARCHAR2',id => '7',add => 'N', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'sesion',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor =>$this->sesion, key => 'N'),
            array( campo => 'fecham',tipo => 'DATE',id => '9',add => 'S', edit => 'S', valor =>$this->hoy, key => 'N'),
            array( campo => 'idvengestion',tipo => 'NUMBER',id => '10',add => 'S', edit => 'S', valor =>'-', key => 'N'),
            array( campo => 'documento',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'N', valor =>'-', key => 'N'),
            array( campo => 'condicion_comercial',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'S', valor =>'-', key => 'N')
        );
        
       
        $this->tabla 	  	  = 'ven_cotizacion';
        $this->secuencia 	  = 'ven_cotizacion_id_cotizacion_seq';
 
        
    }
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function div_resultado($accion,$id,$tipo){
        
        return $this->bd->resultadoCRUD('ACTUALIZACION',$accion,$id,$tipo);
        
    }
    //--------------------------------------------------------------------------------
    //--- busqueda de por codigo para llenar los datos
    //--------------------------------------------------------------------------------
    function consultaId($accion,$id ){
        
        
        $qquery = array(
            array( campo => 'idvengestion',valor => $id,filtro => 'S', visor => 'N'),
            array( campo => 'estado',valor => '-',filtro => 'N', visor => 'S'),
             array( campo => 'canal',valor => '-',filtro => 'N', visor => 'S') 
        );
        
        $datos = $this->bd->JqueryArrayVisorObj('ven_cliente_seg',$qquery,0 );
        
        $result =  $this->div_resultado($accion,$id,0);
        
        echo  $result;
    }
    
    
    
    //--------------------------------------------------------------------------------
    //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
    //--------------------------------------------------------------------------------
    
    function xcrud($action,$id){
        
 
        // ------------------  editar
        if ($action == 'editar'){
            
            $this->edicion($id );
            
        }
       
        
    }
    //--------------------------------------------------------------------------------
    //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
    //--------------------------------------------------------------------------------
    function agregar( $id_cotizacion,$modulo,$idcliente,$razon, $editor2, $editor3,$idvengestion ){
        
 
        $this->ATabla[11][valor] =   $this->_comprobante_();
        
        $this->ATabla[0][valor] =   $id_cotizacion;
        $this->ATabla[2][valor] =   $modulo       ;
        $this->ATabla[3][valor] =   $idcliente	 ;
        $this->ATabla[4][valor] =   $razon	     ;
        $this->ATabla[6][valor] =   $editor2	     ;
        $this->ATabla[7][valor] =   $editor3	     ;
        $this->ATabla[10][valor] =  $idvengestion;
         
        $this->ATabla[12][valor] =  $editor3;
        
        $data = $this->bd->_InsertSQL( $this->tabla,$this->ATabla, $this->secuencia);
  
        $sql = "UPDATE ven_cotizacion
			   SET  cabecera=".$this->bd->sqlvalue_inyeccion($editor2, true).",
                    detalle=".$this->bd->sqlvalue_inyeccion($editor3, true)."
			 WHERE id_cotizacion =".$this->bd->sqlvalue_inyeccion($data, true);
        
         $this->bd->ejecutar($sql);
         
     
        echo $data;
            
    }
    //------------------------------------
    function _comprobante_(    ){
      
        $anio 	     =     date("Y");
        
        
        $ADatos = $this->bd->query_array(
            'ven_registro',
            " cotiza::int + 1 as secuencia",
            'idven_registro='.$this->bd->sqlvalue_inyeccion( 1,true) 
            );
        
        $contador = $ADatos['secuencia'] ;
        
        $comprobante =str_pad($contador, 6, "0", STR_PAD_LEFT).'-'.$anio;
        
        
        $sql = 'update ven_registro
                        set cotiza='.$this->bd->sqlvalue_inyeccion($contador,true).' 
                        where idven_registro = '.$this->bd->sqlvalue_inyeccion('1',true);
        
       $this->bd->ejecutar($sql);
        
        
        return $comprobante ;
        
    }
    //--------------------------------------------------------------------------------
    //--- edicion de registros
    //--------------------------------------------------------------------------------
    function edicion( $id_cotizacion,$modulo,$idcliente,$razon, $editor2, $editor3,$idvengestion  ){
        
        $this->ATabla[0][valor] =   $id_cotizacion;
        $this->ATabla[2][valor] =   $modulo       ;
        $this->ATabla[3][valor] =   $idcliente	 ;
        $this->ATabla[4][valor] =   $razon	     ;
        $this->ATabla[6][valor] =   $editor2	     ;
        $this->ATabla[7][valor] =   $editor3	     ;
        $this->ATabla[10][valor] =  $idvengestion;
        
        $this->ATabla[12][valor] =  $editor3;
        
        
        $this->bd->_UpdateSQL($this->tabla,$this->ATabla,trim($id_cotizacion));
        
        $sql = "UPDATE ven_cotizacion
			   SET  cabecera=".$this->bd->sqlvalue_inyeccion($editor2, true).",
                    detalle=".$this->bd->sqlvalue_inyeccion($editor3, true)."
			 WHERE id_cotizacion =".$this->bd->sqlvalue_inyeccion($id_cotizacion, true);
        
        $resultado = $this->bd->ejecutar($sql);
             
    
        $data = $id_cotizacion;
        
        echo $data;
    }
    
    //--------------------------------------------------------------------------------
    //--- eliminar de registros
    //--------------------------------------------------------------------------------
    function eliminar($id ){
        
        /*
         $sql = 'delete from par_ciu  where idprov='.$this->bd->sqlvalue_inyeccion($id, true);
         $this->bd->ejecutar($sql);
         
         $result =  $this->bd->resultadoCRUD('ELIMINADO','',$id,'');
         
         echo $result;
         
         */
        
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
if (isset($_POST['accion']))	{
    
    $accion          = $_POST['accion'];
    $id_cotizacion   = $_POST['id_cotizacion'];
    $modulo          = $_POST['modulo'];
    $idcliente       = $_POST['idcliente'];
    $razon           = $_POST['razon'];
    $editor2         = $_POST['editor2'];
    $editor3         = $_POST['editor3'];
    $idvengestion    = $_POST['idvengestion'];
    
    
    if( $accion == 'add'){
        
        $gestion->agregar($id_cotizacion,$modulo,$idcliente,$razon, $editor2, $editor3,$idvengestion);
        
    }else{
        
        $gestion->edicion( $id_cotizacion,$modulo,$idcliente,$razon, $editor2, $editor3,$idvengestion );
        
    }
     
}

 
 

?>
 
  
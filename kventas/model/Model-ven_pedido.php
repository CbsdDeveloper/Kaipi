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
    private $ATablaTarea;
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
            array( campo => 'idvengestion',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
            array( campo => 'idprov',tipo => 'VARCHAR2',id => '1',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'razon',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'estado',tipo => 'NUMBER',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'medio',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'canal',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'sesion',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => $this->sesion, key => 'N'),
            array( campo => 'novedad',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'fecha',tipo => 'DATE',id => '8',add => 'S', edit => 'S', valor => $this->hoy, key => 'N'),
            array( campo => 'producto',tipo => 'VARCHAR2',id => '9',add => 'N', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'porcentaje',tipo => 'NUMBER',id => '10',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'registro',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'S', valor => $this->ruc, key => 'N') 
        );
        
        $this->tabla 	  	  = 'ven_cliente_seg';
        
        $this->secuencia 	     = 'ven_cliente_seg_idvengestion_seq';
        
        
        $this->ATablaTarea  = array(
            array( campo => 'idventarea',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
            array( campo => 'idvengestion',tipo => 'NUMBER',id => '1',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'estado',tipo => 'NUMBER',id => '2',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'canal',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'sesion',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor =>  $this->sesion, key => 'N'),
            array( campo => 'novedad',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'fecha',tipo => 'DATE',id => '6',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'hora',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'mensaje',tipo => 'VARCHAR2',id => '8',add => 'N', edit => 'S', valor => '-', key => 'N')
        );
        
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
            array( campo => 'novedad',valor => '-',filtro => 'N', visor => 'S'),
             array( campo => 'canal',valor => '-',filtro => 'N', visor => 'S')
        );
        
        //   array( campo => 'idprov',valor => '-',filtro => 'N', visor => 'S'),
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
    function agregar( ){
        
        /*
         '0'  => 'No Confirmados',
         '1' => 'Por Actualizar',
         '2'  => 'En proceso',
         3 Muestra interes
         4 Seguimiento en proceso
         5 Oferta - Cotizacion generada
         6   => 'Negociacion aceptada',
         */
        
        $procesado = @$_POST["estado"];
        $idprov    = @$_POST["idprov_tarea"];
        $novedad   = @$_POST["novedad"];
        $razon    = @$_POST["razon_nombre"];
        $novedad   = @$_POST["novedad"];
        
        
        if ($procesado == '9'){
            $porcentaje = 0;
            $mov = 'No esta interesado';
        }
        elseif($procesado == '3'){
            $porcentaje = 10;
            $mov = 'Muestra interes';
        }
        elseif($procesado == '4'){
            $porcentaje = 15;
            $mov = 'Seguimiento en proceso';
        }
        elseif($procesado == '5'){
            $porcentaje = 25;
            $mov = 'Oferta - Cotizacion generada';
        }
        elseif($procesado == '6'){
            $porcentaje = 50;
            $mov = 'En Proceso de Negociacion';
        }
        elseif($procesado == '10'){
            $porcentaje = 75;
            $mov = 'Cierre de negocio';
        }
        elseif($procesado == '7'){
            $porcentaje = 50;
            $mov = 'Condiciones Comerciales';
        }
        elseif($procesado == '10'){
            $porcentaje = 75;
            $mov = 'Cierre de negocio';
        }
        elseif($procesado == '11'){
            $porcentaje = 85;
            $mov = 'Emitir Prefactura';
        }
        elseif($procesado == '12'){
            $porcentaje = 100;
            $mov = '(*) Cerrar proceso';
        }
        
        $this->ATabla[10][valor] =  $porcentaje	 ;
        $this->ATabla[3][valor] =  $procesado	 ;
        $this->ATabla[1][valor] =  trim($idprov)	 ;
        $this->ATabla[2][valor] =  trim($razon)	 ;
        $this->ATabla[7][valor] =  trim($novedad)	 ;
        
        
        
        $id = $this->bd->_InsertSQL($this->tabla,$this->ATabla,$this->secuencia);
        
        $result = $this->div_resultado('editar',$id,1);
        
        //--- en el caso de no estar autorizado editamos como cliente y sacamos de la lista
        
        if ( $procesado == '9'){
            $sql = 'update ven_cliente
                        set estado='.$this->bd->sqlvalue_inyeccion('0',true). ',
                            proceso='.$this->bd->sqlvalue_inyeccion($mov,true). ',
                            id_campana='.$this->bd->sqlvalue_inyeccion(0,true). ',
                            detalle='.$this->bd->sqlvalue_inyeccion($novedad,true). '
                        where id_campana  <> 0 and  idprov= '.$this->bd->sqlvalue_inyeccion(trim($idprov),true);
            
            $bandera = 0;
        }
        else {
            $sql = 'update ven_cliente
                        set estado='.$this->bd->sqlvalue_inyeccion($procesado,true). ',
                            proceso='.$this->bd->sqlvalue_inyeccion($mov,true). ',
                            detalle='.$this->bd->sqlvalue_inyeccion($novedad,true). '
                        where id_campana  <> 0 and  idprov= '.$this->bd->sqlvalue_inyeccion(trim($idprov),true);
            
            $bandera = 1;
        }
        
        
        
        $this->bd->ejecutar($sql);
        
        $this->ATablaTarea[2][valor] =  $procesado ;
        $this->ATablaTarea[1][valor] =  $id	 ;
        $this->ATablaTarea[5][valor] =  trim($novedad)	 ;
        
        if (  $bandera == 1 ){
            $this->bd->_InsertSQL('ven_cliente_task',$this->ATablaTarea,'ven_cliente_task_idventarea_seq');
        }
        
        
        
        echo $result;
        
        
    }
    //--------------
    function agregar_tarea( $id ){
        
        
        $procesado = @$_POST["estado"];
        $idprov    = @$_POST["idprov_tarea"];
        $novedad   = @$_POST["novedad"];
        $razon    = @$_POST["razon_nombre"];
        $novedad   = @$_POST["novedad"];
        
 
        
        if ($procesado == '9'){
            $porcentaje = 0;
            $mov = 'No esta interesado';
        }
        elseif($procesado == '6'){
            $porcentaje = 50;
            $mov = 'Negociacion aceptada';
        }
        elseif($procesado == '7'){
            $porcentaje = 50;
            $mov = 'Condiciones Comerciales';
        }
        elseif($procesado == '8'){
            $porcentaje = 75;
            $mov = '(*) Orden de trabajo/Servicio';
        }
        elseif($procesado == '6'){
            $porcentaje = 50;
            $mov = 'En Proceso de Negociacion';
        }
        elseif($procesado == '10'){
            $porcentaje = 75;
            $mov = 'Cierre de negocio';
        }
        elseif($procesado == '11'){
            $porcentaje = 85;
            $mov = 'Emitir Prefactura';
        }
        elseif($procesado == '12'){
            $porcentaje = 100;
            $mov = '(*) Cerrar proceso';
        }
        
       
        
        $this->ATablaTarea[2][valor] =  $procesado ;
        $this->ATablaTarea[1][valor] =  $id	 ;
        $this->ATablaTarea[5][valor] =  trim($novedad)	 ;
        
        
        $this->bd->_InsertSQL('ven_cliente_task',$this->ATablaTarea,'ven_cliente_task_idventarea_seq');
        
        
        
        
    }
    //--------------------------------------------------------------------------------
    //--- edicion de registros
    //--------------------------------------------------------------------------------
    function edicion($id  ){
        
        
        $procesado =  (@$_POST["estado"]);
        $idprov    = @$_POST["idprov_tarea"];
        $novedad   = @$_POST["novedad"];
        $razon    = @$_POST["razon_nombre"];
        $novedad   = @$_POST["novedad"];
        
        
        if ($procesado == '9'){
            $porcentaje = 0;
            $mov = 'No esta interesado';
        }
        elseif($procesado == '5'){
            $porcentaje = 50;
            $mov = 'Negociacion aceptada';
        }
        elseif($procesado == '7'){
            $porcentaje = 50;
            $mov = 'Condiciones Comerciales';
        }
        elseif($procesado == '8'){
            $porcentaje = 75;
            $mov = '(*) Orden de trabajo/Servicio';
        }
        elseif($procesado == '6'){
            $porcentaje = 50;
            $mov = 'En Proceso de Negociacion';
        }
        elseif($procesado == '10'){
            $porcentaje = 75;
            $mov = 'Cierre de negocio';
        }
         elseif($procesado == '11'){
            $porcentaje = 85;
            $mov = 'Emitir Prefactura';
        }
         elseif($procesado == '12'){
            $porcentaje = 100;
            $mov = '(*) Cerrar proceso';
        }
       
      
        $this->ATabla[10][valor] =  $porcentaje	 ;
        $this->ATabla[3][valor] =   ($procesado)	 ;
        $this->ATabla[1][valor] =  trim($idprov)	 ;
        $this->ATabla[2][valor] =  trim($razon)	 ;
        $this->ATabla[7][valor] =  trim($novedad)	 ;
        
        $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
        
        $this->agregar_tarea( $id );
        
        $result =$this->div_resultado('editar',$id,1);
        
        //--- en el caso de no estar autorizado editamos como cliente y sacamos de la lista
        
        if ( $procesado == '9'){
            
            $sql = 'update ven_cliente
                        set estado='.$this->bd->sqlvalue_inyeccion('0',true). ',
                            proceso='.$this->bd->sqlvalue_inyeccion($mov,true). ',
                            id_campana='.$this->bd->sqlvalue_inyeccion(0,true). ',
                            detalle='.$this->bd->sqlvalue_inyeccion($novedad,true). '
                        where id_campana  <> 0 and  idprov= '.$this->bd->sqlvalue_inyeccion(trim($idprov),true);
            
         }
        else {
            $sql = 'update ven_cliente
                        set estado='.$this->bd->sqlvalue_inyeccion($procesado,true). ',
                            proceso='.$this->bd->sqlvalue_inyeccion($mov,true). ',
                            detalle='.$this->bd->sqlvalue_inyeccion($novedad,true). '
                        where id_campana  <> 0 and  idprov= '.$this->bd->sqlvalue_inyeccion(trim($idprov),true);
            
           
         }
        
         $this->bd->ejecutar($sql);
         
        echo $result  ;
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
if (isset($_GET['accion']))	{
    
    $accion           = $_GET['accion'];
    $id               = $_GET['idvengestion'];
    $idcliente        = $_GET['idcliente'];
    
    $gestion->consultaId($accion,$id);
    
}

//------ grud de datos insercion
if (isset($_POST["action"]))	{
    
    $action = @$_POST["action"];
    
    $id =     @$_POST["idvengestion"];
    
      
    if ( $action == 'editar'){
        
        $gestion->edicion( $id );
        
    }
    
    if ( $action == 'add'){
        
        $gestion->agregar(   );
        
    }
    
}



?>
 
  
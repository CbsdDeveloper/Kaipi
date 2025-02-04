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
        $this->hoy 	     =      date("Y-m-d");    	//$this->hoy 	     =  $this->bd->hoy();
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
        $this->ATabla = array(
            array( campo => 'id_rol',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
            array( campo => 'id_periodo',tipo => 'NUMBER',id => '1',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'mes',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'anio',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'registro',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'N', valor =>  $this->ruc , key => 'N'),
            array( campo => 'estado',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'fecha',tipo => 'DATE',id => '6',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'novedad',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'sesion',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor =>  $this->sesion, key => 'N')  ,
            array( campo => 'tipo',tipo => 'NUMBER',id => '9',add => 'S', edit => 'S', valor =>  '-', key => 'N')  
        );
        
        $this->tabla 	  		    = 'nom_rol_pago';
       
        $this->secuencia 	     = 'id_nom_rol_pago';
        
    }
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function div_resultado($accion,$id,$tipo){
        //inicializamos la clase para conectarnos a la bd
        
        $estado='';
        
        echo '<script type="text/javascript">accion('.$id.',"'.$accion.'","'.$estado.'"  );</script>';
        
        if ($tipo == 0){
            
            if ($accion == 'editar')
                $resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>EDITAR REGISTRO TRANSACCION ?</b>';
                if ($accion == 'del')
                    $resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ELIMINAR REGISTRO TRANSACCION ?</b>';
                    
        }
        
        if ($tipo == 1){
            
            
            $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO ['.$id.']</b>';
            
        }
        
        
        
        return $resultado;
        
    }
    
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function div_limpiar( ){
        //inicializamos la clase para conectarnos a la bd
        
        $resultado = '';
        echo '<script type="text/javascript">';
        
        echo  'LimpiarPantalla();';
        
        echo '</script>';
        
        return $resultado;
        
    }
    
    
    
    //--------------------------------------------------------------------------------
    //--- busqueda de por codigo para llenar los datos
    //--------------------------------------------------------------------------------
    function consultaId($accion,$id ){
        
        
        $qquery = array(
            array( campo => 'id_rol',   valor =>$id,  filtro => 'S',   visor => 'S'),
            array( campo => 'registro',   valor => $this->ruc ,  filtro => 'S',   visor => 'N'),
            array( campo => 'anio',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'id_periodo',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'mes',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'novedad',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'fecha',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'tipo',   valor => '-',  filtro => 'N',   visor => 'S')
         );
     
 
        
        $this->bd->JqueryArrayVisor('nom_rol_pago',$qquery );
        
        $result =  $this->div_resultado($accion,$id,0);
        
        echo  $result;
    }
    
    
    
    //--------------------------------------------------------------------------------
    //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
    //--------------------------------------------------------------------------------
    
    function xcrud($action,$id){
        
        
        // ------------------  agregar
        if ($action == 'add'){
            
            $this->agregar( );
            
        }
        // ------------------  editar
        if ($action == 'editar'){
            
            $this->edicion($id );
            
        }
        // ------------------  eliminar
        if ($action == 'del'){
            
            $this->eliminar($id );
            
        }
        
    }
    //--------------------------------------------------------------------------------
    //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
    //--------------------------------------------------------------------------------
    function agregar(   ){
        
        $mes  =  @$_POST["mes"];
        $anio =  @$_POST["anio"];
        
        $tipo =  @$_POST["tipo"];
 
        
        $x = $this->bd->query_array('nom_rol_pago',
            'count(*) as nn',
            'registro='.$this->bd->sqlvalue_inyeccion($this->ruc,true) . ' and '.
            'anio='.$this->bd->sqlvalue_inyeccion($anio,true) . ' and '.
            'mes='.$this->bd->sqlvalue_inyeccion($mes,true).' AND 
            tipo = '.$this->bd->sqlvalue_inyeccion($tipo,true)
            );
        
        
        if ( $x['nn']  > 0 ){
            
            
            $result = ' Periodo ya generado ';
            
        }else{
            
            
            $id = $this->bd->_InsertSQL($this->tabla,$this->ATabla,$this->secuencia);
            
            $result = $this->div_resultado('editar',$id,1);
            
        }
        
        echo $result;
        
    }
    //--------------------------------------------------------------------------------
    //--- edicion de registros
    //--------------------------------------------------------------------------------
    function edicion($id  ){
        
 
        $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
        
        $result = $this->div_resultado('editar',$id,1);
        
        
        echo $result  ;
    }
    
    //--------------------------------------------------------------------------------
    //--- eliminar de registros
    //--------------------------------------------------------------------------------
    function eliminar($id ){
        
 
        
        
        
        $sql = "SELECT count(*) as nro_registros
         FROM nom_rol_pagod
         where id_rol = ".$this->bd->sqlvalue_inyeccion($id ,true);
        
        $resultado = $this->bd->ejecutar($sql);
        
        $datos_valida = $this->bd->obtener_array( $resultado);
        
        if ($datos_valida['nro_registros'] > 0){
            $result = 'NO SE PUEDE ELIMINAR REGISTRO EXISTE TRANSACCIONES GENERADAS';
        }
        else {
            
            $sql = 'delete from '. $this->tabla .'  where id_rol='.$this->bd->sqlvalue_inyeccion($id, true);
            
            $this->bd->ejecutar($sql);
            
            $result = $this->div_limpiar();
            
        }
        
        
        
        
        echo $result;
        
    }
    //----------------------
    function cierre($anio ){
        
        
        
        $sql = 'update  nom_rol_pago
                   set  estado='.$this->bd->sqlvalue_inyeccion('N', true).
                   'WHERE  registro= '.$this->bd->sqlvalue_inyeccion($this->ruc, true). ' and
                        anio = '.$this->bd->sqlvalue_inyeccion($anio, true);
        
        $this->bd->ejecutar($sql);
        
        
        $result = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>TODOS LOS PERIODOS DEL PERIODO '.$anio.' ESTAN CERRADOS  </b>';
        
        echo $result;
        
    }

        //----------------------
        function cierre_dato($id ){
        
        
        
            $sql = 'update  nom_rol_pago
                       set  estado='.$this->bd->sqlvalue_inyeccion('S', true).
                       'WHERE  id_rol = '.$this->bd->sqlvalue_inyeccion($id, true);
            
            $this->bd->ejecutar($sql);
            
            
            $result = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>PERIODOS '.$id.'   CERRADO  </b>';
            
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
    
    $accion    = $_GET['accion'];
    
    $id        = $_GET['id'];
    
    if ( $accion == 'cierre'){
        
        $anio        = $_GET['anio'];
        
        $gestion->cierre($anio);
        
    }elseif ( $accion == 'SI'){
        
        $anio        = $_GET['anio'];
        
        $gestion->cierre_dato($id);
        
    }
     else{
        
        $gestion->consultaId($accion,$id);
        
    }
    
}

//------ grud de datos insercion
if (isset($_POST["action"]))	{
    
    $action = @$_POST["action"];
    
    $id =     @$_POST["id_rol"];
    
    $gestion->xcrud(trim($action),$id );
    
}



?>
 
  
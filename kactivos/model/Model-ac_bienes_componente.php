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
    private $ATabla_custodio ;
    
    private $tabla ;
    private $secuencia;
    
    private $estado_periodo;
    
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function proceso( ){
       
        
        $this->obj     = 	new objects;
        $this->bd	   =	new Db ;
        
        $this->ruc       =     trim($_SESSION['ruc_registro']);
        
        $this->sesion 	 =     trim($_SESSION['email']);
        
        $this->hoy 	     =     date("Y-m-d");    
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
        $this->ATabla = array(
            array( campo => 'id_bien_componente',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
            array( campo => 'id_bien',tipo => 'NUMBER',id => '1',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'id_marca_componente',tipo => 'NUMBER',id => '2',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'detalle_componente',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'costo_componente',tipo => 'NUMBER',id => '4',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'relacionado',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'estado',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'sesion',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'N', valor => $this->sesion , key => 'N'),
            array( campo => 'creacion',tipo => 'DATE',id => '9',add => 'S', edit => 'S', valor =>$this->hoy, key => 'N'),
            array( campo => 'sesionm',tipo => 'VARCHAR2',id => '10',add => 'S', edit => 'S', valor =>$this->sesion, key => 'N'),
            array( campo => 'modificacion',tipo => 'DATE',id => '11',add => 'S', edit => 'S', valor => $this->hoy, key => 'N'),
            array( campo => 'evento',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'S', valor => '-', key => 'N')
        );
  
        
        $this->tabla 	  	     = 'activo.ac_bienes_componente';
        
        $this->secuencia 	     = 'activo.ac_bienes_componente_id_bien_componente_seq';
         
        
    }
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function div_resultado($accion,$id,$tipo,$estado,$comprobante,$idbien){
        //inicializamos la clase para conectarnos a la bd
        $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO ['.$id.']</b>';
        
        if ($tipo == 1){
            
            $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO ['.$id.']</b>';
            
        }
        
        if ($tipo == 0){
            if ($accion == 'editar')
                    $resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>EDITAR REGISTRO TRANSACCION ? ( '.$id.' )</b>';
                if ($accion == 'del')
                    $resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ELIMINAR REGISTRO TRANSACCION ?( '.$id.' )</b>';
        }
        
        if ($tipo == -1){
            $resultado = '<img src="../../kimages/nogusta.png" align="absmiddle"/>&nbsp;<b>VERIFIQUE LA INFORMACION DEL PROVEEDOR/RESPONSABLE</b>';
        }
        
        if ($tipo == -2){
            $resultado = '<img src="../../kimages/nogusta.png" align="absmiddle"/>&nbsp;<b>DEBE APERTURAR EL PERIODO EN CONTABILIDAD</b>';
        }
        
        if ($tipo == 2){
            $resultado ='<img src="../../kimages/kfav.png" align="absmiddle"/>&nbsp;<b>COMPROBANTE EMITIDO CON EXITO ['.$id.']</b>';
        }
        
        
        
        $datos = array(
            'resultado' => $resultado,
            'id' => $id,
            'idbien'=>  $idbien,
            'accion' => $accion
        );
        
        
        return $datos;
        
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
  
    
    //--------
    function grilla_componentes($id){
        
        
        
        $qquery = array(
            array( campo => 'id_bien_componente',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'id_bien',valor => $id,filtro => 'S', visor => 'S'),
            array( campo => 'id_marca_componente',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'creacion',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'marca',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'detalle_componente',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'costo_componente',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'estado',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'id_bien_relacionado',valor => '-',filtro => 'N', visor => 'S')
        );
        
       
        
        $resultado = $this->bd->JqueryCursorVisor('activo.view_bienes_componente',$qquery );
        
        
        echo '<table id="jsontableDoc" class="display table-condensed table-bordered table-hover" cellspacing="0" width="100%">
          <thead> <tr>
                <th> Referencia </th>
                <th> Fecha </th>
                <th> Detalle</th>
                <th> Marca </th>
                <th> Activo </th>
                <th> Costo </th>
                <th> Acciones</th></thead> </tr>';
        
        

        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
            $idproducto =  $fetch['id_bien_componente'] ;
            
            
            $boton2 = '&nbsp;&nbsp;&nbsp;<button class="btn btn-xs"
                              title="Eliminar Registro"
                              onClick="javascript:goToURLComdel('.$idproducto.","."'".$id."'".')">
                             <i class="glyphicon glyphicon-remove"></i></button>';
            
            $boton1 =  '&nbsp;&nbsp;&nbsp;<button class="btn btn-xs"
                              title="Editar Registro"
                              onClick="javascript:goToURLCom('.$idproducto.","."'".$id."'".')">
                             <i class="glyphicon glyphicon-edit"></i></button>';
            
            echo ' <tr>';
            
            echo ' <td>'.$idproducto.'</td>';
            echo ' <td>'.$fetch['creacion'].'</td>';
            echo ' <td>'.$fetch['detalle_componente'].'</td>';
            echo ' <td>'.$fetch['marca'].'</td>';
            echo ' <td>'.$fetch['estado'].'</td>';
            echo ' <td>'.$fetch['costo_componente'].'</td>';
            echo ' <td>'.$boton1.$boton2.'</td>';
            
            echo ' </tr>';
        }
        
        
        echo "   </tbody>
               </table>";
        
        
        pg_free_result($resultado);
    }
    
    //--------------------------------------------------------------------------------
    //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
    //--------------------------------------------------------------------------------
    
    function xcrud($action,$id){
        
        
        // ------------------  agregar
        if ($action == 'add'){
            
            $this->agregar();
            
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
    function agregar( ){
        
              $idbien =    $_POST["id_bien"];
  
                
              $id = $this->bd->_InsertSQL($this->tabla,$this->ATabla, $this->secuencia );
 
              $datos = $this->div_resultado('editar',$id, 1,'digitado','0',$idbien) ;
                
              header('Content-Type: application/json');
        
        
        echo json_encode($datos, JSON_FORCE_OBJECT);
        
        
    }
    //--------------------------------------------------------------------------------
    //--- edicion de registros
    //--------------------------------------------------------------------------------
    function edicion( $id  ){
  
        $idbien =    $_POST["id_bien"];
        
        $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
        
        $datos = $this->div_resultado('editar',$id, 1,'digitado','0',$idbien) ;
        
        echo json_encode($datos, JSON_FORCE_OBJECT);
        
    }
    
    //--------------------------------------------------------------------------------
    //--- eliminar de registros
    //--------------------------------------------------------------------------------
    function eliminar($id_bien_componente,$id ){
        
 
        $sql = 'delete from activo.ac_bienes_componente  
                 where id_bien_componente='.$this->bd->sqlvalue_inyeccion($id_bien_componente, true);
        
            $this->bd->ejecutar($sql);
            
             
            $this->grilla_componentes($id);
 
        
        
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

//------ poner informacion en los campos del sistema
if (isset($_GET['accion']))	{
    
    $accion    = $_GET['accion'];
    
    $id        = $_GET['id'];
    
    if ( $accion == 'visor'){
        
        $gestion->grilla_componentes($id);
        
    }
    if ( $accion == 'del'){
          
        $id_bien_componente        = $_GET['id_bien_componente'];
        
        $gestion->eliminar($id_bien_componente,$id);
        
    }
  
 
    
    
}

//------ grud de datos insercion
if (isset($_POST["action"]))	{
    
    $action = @$_POST["action"];
    
    $id =     @$_POST["id_bien_componente"];
    
    $gestion->xcrud(trim($action),$id);
    
}



?>
 
  
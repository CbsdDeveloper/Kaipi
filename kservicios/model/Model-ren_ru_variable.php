<?php
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/


require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
    
    private $obj;
    private $bd;
    
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
        
        $this->tabla 	  	  = 'rentas.ren_rubros_var';
        
        $this->secuencia 	     = 'rentas.ren_rubros_var_id_rubro_var_seq';
        
  
        
        $this->ATabla = array(
            array( campo => 'id_rubro_var',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
            array( campo => 'id_rubro',tipo => 'NUMBER',id => '1',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'nombre_variable',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'imprime',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'tipo',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'lista',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'id_catalogo',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'variable',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'relacion',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'publica',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'etiqueta',tipo => 'VARCHAR2',id => '10',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'columna',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'requerido',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'S', valor => '-', key => 'N')
        );

        
 


    }
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function div_resultado($accion,$id,$tipo){
        //inicializamos la clase para conectarnos a la bd
        
        
        echo '<script type="text/javascript">accion_variable('. $id. ','. "'".$accion."'" .')</script>';
        
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
    function consultaId($idcategoriavar ){
        
        
        
        $qquery = array(
            array( campo => 'id_rubro_var',   valor => $idcategoriavar,  filtro => 'S',   visor => 'S'),
            array( campo => 'nombre_variable',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'lista',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'tipo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'imprime',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'variable',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'relacion',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'id_catalogo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'publica',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'etiqueta',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'columna',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'requerido',valor => '-',filtro => 'N', visor => 'S')
        );
        
 
 
        $this->bd->JqueryArrayVisorObj('rentas.ren_rubros_var',$qquery ,0);
        
        $result =  $this->div_resultado('editar',$idcategoriavar,0);
        
        echo  $result;
    }
    
    //--------------------------------------------------------------------------------
    //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
    //--------------------------------------------------------------------------------
    
    function xcrud($accion,$GET){
        
        
        $idcategoriavar     = $GET['id_rubro_var'];
        
        // ------------------  agregar
        if ($accion == 'add'){
            
            $this->agregar( $GET );
            
        }
        // ------------------  editar
        if ($accion == 'editar'){
            
            $this->edicion( $GET);
            
        }
 
        
        if ($accion == 'visor'){
            
            $this->consultaId( $idcategoriavar );
            
        }
        
    }
    //--------------------------------------------------------------------------------
    //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
    //--------------------------------------------------------------------------------
    function agregar( $GET ){
        
        $variable           = strtoupper (trim($GET['variable']));
        $imprime            = trim($GET['imprime']);
        $tipo               = trim($GET['tipo']);
        $lista              = trim($GET['lista']);
        
        $tipo_dato          = trim($GET['id_catalogo']);
        
        $relacion           = trim($GET['relacion']);
        $publica            = trim($GET['publica']);

        $etiqueta           = trim($GET['etiqueta']);
        $columna            = trim($GET['columna']);

        $requerido            = trim($GET['requerido']);

        


 
        $this->ATabla[1][valor] =  $GET['id_rubro'];
        $this->ATabla[2][valor] =  $variable ;
        $this->ATabla[3][valor] =  trim($imprime) ;
        $this->ATabla[4][valor] =  trim($tipo) ;
        $this->ATabla[5][valor] =  strtoupper(trim($lista)) ;
        $this->ATabla[6][valor] = '-';

        $this->ATabla[10][valor] =  $etiqueta ;
        $this->ATabla[11][valor] =  $columna;
        $this->ATabla[12][valor] =  $requerido;

        $variable1 = str_replace(" ","_",$variable);
        $variable2 = $variable1.'_1';
        
        $this->ATabla[7][valor] = strtoupper (trim($variable2)) ;
        $this->ATabla[8][valor] =  strtoupper (trim($relacion)) ;
        $this->ATabla[9][valor] =  strtoupper (trim($publica)) ;
        
        $bandera = 1;
        $lon = strlen($lista);
        $lon1 = strlen($variable);
        
        if ($tipo == 'L'){
            if ( $lon < 5){
                $bandera = 0;
            }else {
                $bandera = 1;
            }
        }
        
        
        if ($tipo == 'B'){
            $this->ATabla[6][valor] = trim($tipo_dato) ;
            $bandera = 1;
        }
        //----------variable
        
        if ( $lon1 < 4 ){
            $bandera = 0;
        }else{
            $bandera = 1;
        }
        
        if ( $bandera == 0 ){
            
            $GuardaVariable = 'Verifique los datos, lista separado por ,';
            
        }else{
            
            $id = $this->bd->_InsertSQL($this->tabla,$this->ATabla, $this->secuencia);
            
            $GuardaVariable = $this->div_resultado('editar',$id,1);
            
        }
        
        
        echo $GuardaVariable;
        
    }
    
    //--------------------------------------------------------------------------------
    //--- edicion de registros
    //--------------------------------------------------------------------------------
    function edicion($GET ){
        
        $idcategoriavar     =  $GET['id_rubro_var'];
        $variable           = strtoupper (trim($GET['variable']));
        $imprime            = trim($GET['imprime']);
        $tipo               = trim($GET['tipo']);
        $lista              = trim($GET['lista']);
        $tipo_dato          = trim($GET['id_catalogo']);
        $relacion           = trim($GET['relacion']);
        $publica            = trim($GET['publica']);

        $etiqueta           = trim($GET['etiqueta']);
        $columna            = trim($GET['columna']);
        $requerido            = trim($GET['requerido']);
        
        $this->ATabla[1][valor] =  $GET['id_rubro'];
        $this->ATabla[2][valor] =  $variable ;
        $this->ATabla[3][valor] =  trim($imprime) ;
        $this->ATabla[4][valor] =  trim($tipo) ;
        $this->ATabla[5][valor] =  strtoupper(trim($lista)) ;
        $this->ATabla[6][valor] = '0';
        $variable1 = str_replace(" ","_",$variable);
        $variable2 = $variable1.'_1';
        
        $this->ATabla[7][valor] = strtoupper (trim($variable2)) ;
        $this->ATabla[8][valor] =  strtoupper (trim($relacion)) ;
        $this->ATabla[9][valor] =  strtoupper (trim($publica)) ;

        $this->ATabla[10][valor] =  $etiqueta ;
        $this->ATabla[11][valor] =  $columna;
        $this->ATabla[12][valor] =  $requerido;
        
        $bandera = 1;
        $lon = strlen($lista);
        
        $variable1 = str_replace(" ","_",$variable);
        $variable2 = $variable1.'_1';
        
        $this->ATabla[7][valor] = strtoupper (trim($variable2)) ;
        
        $this->ATabla[8][valor] =  strtoupper (trim($relacion)) ;
        $this->ATabla[9][valor] =  strtoupper (trim($publica)) ;
        
        
        
        if ($tipo == 'L'){
            if ( $lon < 5){
                $bandera = 0;
            }else {
                $bandera = 1;
            }
        }
        
        if ($tipo == 'B'){
            $this->ATabla[6][valor] = trim($tipo_dato) ;
            $bandera = 1;
        }
        
        
        
        if ( $bandera == 0 ){
            $GuardaVariable = 'Verifique los datos, lista separado por ,';
        }else{
            $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$idcategoriavar);
            $GuardaVariable = $this->div_resultado('editar',$idcategoriavar,1);
        }
        
        
        echo $GuardaVariable;
    }
    
    //--------------------------------------------------------------------------------
    //--- eliminar de registros
    //--------------------------------------------------------------------------------
    function eliminar($id ){
        
        
        $sql = " delete
                   from rentas.ren_rubros_var
            	  where id_rubro_var=".$this->bd->sqlvalue_inyeccion($id, true);
        
        $this->bd->ejecutar($sql);
        
        
        $GuardaVariable = $this->div_resultado('editar',$id,1);
        
        echo $GuardaVariable;
        
    }
    
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;


if (isset($_GET['action_variable']))	{
    
    $accion             = $_GET['action_variable'];
    
    $idcategoriavar     = $_GET['id_rubro_var'];
  
    $GuardaVariable = ' listo';
    
    if ( $accion == 'del'){
        
        $gestion->eliminar($idcategoriavar);
        
    }else{
        
        $gestion->xcrud($accion,$_GET);
        
    }
 
    
    
}




echo $GuardaVariable;




?>
 
  
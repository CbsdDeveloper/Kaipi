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
    private $anio;
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function proceso( ){
        //inicializamos la clase para conectarnos a la bd
        
        $this->obj     = 	new objects;
        $this->bd	   =	new Db ;
        
        $this->ruc       =     $_SESSION['ruc_registro'];
        
        $this->sesion 	 =  trim($_SESSION['email']);
        
        $this->hoy 	     =  date("Y-m-d");    	 
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
        $this->ATabla = array(
            array( campo => 'id_anulados',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
            array( campo => 'tipocomprobante',tipo => 'VARCHAR2',id => '1',add => 'S', edit => 'N', valor => 'XP', key => 'N'),
            array( campo => 'establecimiento',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => '000', key => 'N'),
            array( campo => 'puntoemision',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => '000', key => 'N'),
            array( campo => 'secuencialinicio',tipo => 'NUMBER',id => '4',add => 'S', edit => 'S', valor => '1', key => 'N'),
            array( campo => 'secuencialfin',tipo => 'NUMBER',id => '5',add => 'S', edit => 'S', valor => '1', key => 'N'),
            array( campo => 'autorizacion',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => '', key => 'N'),
            array( campo => 'registro',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor =>$this->ruc, key => 'N'),
            array( campo => 'mes',tipo => 'NUMBER',id => '8',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'anio',tipo => 'NUMBER',id => '9',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'fecha',tipo => 'DATE',id => '10',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'sesion',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'S', valor => $this->sesion, key => 'N'),
            array( campo => 'detalle',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'cuenta',tipo => 'VARCHAR2',id => '13',add => 'S', edit => 'S', valor => '-', key => 'N'),
        );
        
        $this->tabla 	  		    = 'co_anulados';
        
        $this->secuencia 	     = 'id_co_anulados';
        
        $this->anio       =  $_SESSION['anio'];
        
    }
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function div_resultado($accion,$id,$tipo){
        //inicializamos la clase para conectarnos a la bd
        
        $estado = 'OK';
        
        echo '<script type="text/javascript">accion('.$id.',"'.$accion.'","'.$estado.'"  );</script>';
        
        if ($tipo == 0){
            
            if ($accion == 'editar')
                $resultado = '<img src="../../kimages/kedit.png"/>&nbsp;<b>Editar registro?</b><br>';
                if ($accion == 'del')
                    $resultado = '<img src="../../kimages/kdel.png"/>&nbsp;<b>Eliminar registro?</b><br>';
                    
        }
        
        if ($tipo == 1){
            
            
            $resultado = '<img src="../../kimages/ksavee.png"/>&nbsp;<b>Informacion actualizada</b><br>';
            
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
    function consultaId($cuenta ){
        
        
        $qquery = array(
            array( campo => 'id_anulados',    valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'cuenta',valor => trim($cuenta),filtro => 'S', visor => 'S'),
            array( campo => 'detalle',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'sesion',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'fecha',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'autorizacion',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'anio',valor =>  $this->anio,filtro => 'S', visor => 'S'),
        );
        
       
        
        $resultado = $this->bd->JqueryCursorVisor('co_anulados',$qquery );
        
        
        echo '<table id="jsontableDoc" class="display table-condensed table-bordered table-hover" cellspacing="0" width="100%">
          <thead> <tr>
                <th> Referencia </th>
                <th> Fecha </th>
                <th> Comprobante </th>
                <th> Detalle </th>
                <th> Sesion </th>
                <th> Accion</th></thead> </tr>';
        
        
        
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
            $idproducto =  $fetch['id_anulados'] ;
            
            
            $boton1 = '<button class="btn btn-xs"
                              title="Eliminar Registro"
                              onClick="javascript:goToURLDocdel('.$idproducto.')">
                             <i class="glyphicon glyphicon-remove"></i></button>';
            
            $boton1 = '';
            $boton2 = '<button class="btn btn-xs"
                             title="Documento Relacionado"
                            onClick="javascript:PoneDoc(' .$idproducto . ')">
                           <i class="glyphicon glyphicon-file"></i></button>&nbsp;&nbsp;&nbsp;';
            
            echo ' <tr>';
            
            echo ' <td>'.$idproducto.'</td>';
            echo ' <td>'.$fetch['fecha'].'</td>';
            echo ' <td>'.$fetch['autorizacion'].'</td>';
            echo ' <td>'.$fetch['detalle'].'</td>';
            echo ' <td>'.$fetch['sesion'].'</td>';
            echo ' <td>'.$boton2.$boton1.'</td>';
            
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
        
 
        $id     =      $_POST["autorizacion"];
        $fecha  =      $_POST["fecha"];
        $cuenta =      trim($_POST["cuenta"]);
        
        $trozos = explode("-", $fecha,3);
        
        $anio = $trozos[0];
        $nmes = $trozos[1];
        
        $this->ATabla[8][valor] = (int) $nmes;
        $this->ATabla[9][valor] = (int) $anio	 ;
 
        
        $input= str_pad($id, 8, "0", STR_PAD_LEFT).'-'.$anio;
        
        $this->ATabla[6][valor] =  $input;
        
        $x = $this->bd->query_array('co_asiento_aux',                  // TABLA
            'count(*) as nn',                                         // CAMPOS
            'cuenta = '.$this->bd->sqlvalue_inyeccion($cuenta,true).' and 
             comprobante='.$this->bd->sqlvalue_inyeccion($input,true) // CONDICION
            );
        
        if ( $x['nn']  > 0 ){
            
            $result = 'Ya existe este comprobante';
            
        }else{
            
            $id = $this->bd->_InsertSQL($this->tabla,$this->ATabla,$id);
            
            $result = $this->div_resultado('editar',$id,1);
            
        }
 
        
        echo $result;
        
    }
    //--------------------------------------------------------------------------------
    //--- edicion de registros
    //--------------------------------------------------------------------------------
    function edicion($id  ){
 
        
        
        $id = $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
        
        $result = $this->div_resultado('editar',$id,1);
        
        
        echo $result  ;
    }
    
    //--------------------------------------------------------------------------------
    //--- eliminar de registros
    //--------------------------------------------------------------------------------
    function eliminar($id ){
        
        if (strlen(trim($id)) == 9){
            $id = '0'.$id;
        }
        if (strlen(trim($id)) == 12){
            $id = '0'.$id;
        }
        
        $sql = "SELECT count(*) as nro_registros
	       FROM co_asiento_aux
           where idprov = ".$this->bd->sqlvalue_inyeccion($id ,true);
        
        $resultado = $this->bd->ejecutar($sql);
        
        $datos_valida = $this->bd->obtener_array( $resultado);
        
        if ($datos_valida['nro_registros'] == 0){
            
            $sql = 'delete from par_ciu  where idprov='.$this->bd->sqlvalue_inyeccion($id, true);
            $this->bd->ejecutar($sql);
        }
        
        $result = $this->div_limpiar();
        
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

 
//------ grud de datos insercion
if (isset($_POST["action"]))	{
    
    $action = $_POST["action"];
    
    $id =     $_POST["id_anulados"];
    
    if ( $action == 'visor_grid'){
        
        $cuenta= $_POST["cuenta"];
        
        $gestion->consultaId(trim($cuenta));
        
    }else{
        $gestion->xcrud(trim($action),$id );
    }
   
    
}



?>
 
  
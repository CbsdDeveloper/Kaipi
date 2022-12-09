<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


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
    private $anio;
    
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function proceso( ){
        //inicializamos la clase para conectarnos a la bd
        
        $this->obj     = 	new objects;
        $this->bd	   =	new Db ;
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        $this->sesion 	 =  trim($_SESSION['email']);
        $this->hoy 	     =  date("Y-m-d");    	 
        
        $this->anio      =  $_SESSION['anio'];
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
        $this->ATabla = array(
            array( campo => 'id_accion',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
            array( campo => 'idprov',tipo => 'VARCHAR2',id => '1',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'anio',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'N', valor => $this->anio, key => 'N'),
            array( campo => 'comprobante',tipo => 'VARCHAR2',id => '3',add => 'N', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'fecha',tipo => 'DATE',id => '4',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'tipo',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'motivo',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'fecha_rige',tipo => 'DATE',id => '7',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'novedad',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'otro',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'estado',tipo => 'VARCHAR2',id => '10',add => 'S', edit => 'N', valor => 'N', key => 'N'),
            array( campo => 'regimen',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'programa',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'id_departamento',tipo => 'NUMBER',id => '13',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'id_cargo',tipo => 'NUMBER',id => '14',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'sueldo',tipo => 'NUMBER',id => '15',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'p_regimen',tipo => 'VARCHAR2',id => '16',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'p_programa',tipo => 'VARCHAR2',id => '17',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'p_id_departamento',tipo => 'NUMBER',id => '18',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'p_id_cargo',tipo => 'NUMBER',id => '19',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'p_sueldo',tipo => 'NUMBER',id => '20',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'sesion',tipo => 'VARCHAR2',id => '21',add => 'S', edit => 'N', valor => $this->sesion , key => 'N'),
            array( campo => 'creacion',tipo => 'DATE',id => '22',add => 'S', edit => 'N', valor => $this->hoy , key => 'N'),
            array( campo => 'modificacion',tipo => 'VARCHAR2',id => '23',add => 'S', edit => 'S', valor => $this->sesion , key => 'N'),
            array( campo => 'fmodificacion',tipo => 'DATE',id => '24',add => 'S', edit => 'S', valor =>$this->hoy , key => 'N'),
            array( campo => 'finalizado',tipo => 'VARCHAR2',id => '25',add => 'S', edit => 'N', valor =>'N' , key => 'N'),
            array( campo => 'ffinalizacion',tipo => 'DATE',id => '26',add => 'S', edit => 'S', valor =>'-' , key => 'N'),
            array( campo => 'modulo',tipo => 'VARCHAR2',id => '27',add => 'S', edit => 'N', valor =>'S' , key => 'N'),
            array( campo => 'baselegal',tipo => 'VARCHAR2',id => '28',add => 'S', edit => 'S', valor =>'-' , key => 'N'),
            array( campo => 'referencia',tipo => 'VARCHAR2',id => '29',add => 'S', edit => 'S', valor =>'-' , key => 'N'),
            array( campo => 'idprovc',tipo => 'VARCHAR2',id => '30',add => 'S', edit => 'S', valor =>'-' , key => 'N'),
            array( campo => 'observacion',tipo => 'VARCHAR2',id => '31',add => 'S', edit => 'S', valor =>'-' , key => 'N')
        );
        
        
        
        $this->tabla 	  		    = 'nom_accion';
   
        $this->secuencia 	     = 'nom_accion_id_accion_seq';
        
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
        
        if ($tipo == -1){
            
            
            $resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>NO SE PUEDE ACTUALIZAR ?</b>';
            
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
    //-----------------
    function aprobado_doc($estado,$comprobante,$tipo ){
        //inicializamos la clase para conectarnos a la bd
        
        $resultado = '';
        
        echo '<script type="text/javascript">';
        
        if ( $tipo == 1){
            echo  '$("#estado").val('."'".$estado."'".');';
            echo  '$("#comprobante").val('."'".$comprobante."'".');';
            
        }else {
            echo  '$("#finalizado").val('."'".$estado."'".');';
        }
        
        echo '</script>';
        
        return $resultado;
        
    }
    
    
    //--------------------------------------------------------------------------------
    //--- busqueda de por codigo para llenar los datos
    //--------------------------------------------------------------------------------
    function consultaId($accion,$id ){
        
        
        $qquery = array(
            array( campo => 'id_accion',   valor =>$id,  filtro => 'S',   visor => 'S'),
            array( campo => 'idprov',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'comprobante',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'fecha',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'tipo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'motivo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'fecha_rige',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'novedad',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'otro',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'estado',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'regimen',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'programa',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'id_departamento',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'id_cargo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'sueldo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'p_regimen',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'p_programa',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'p_id_departamento',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'p_id_cargo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'p_sueldo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'razon',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'idprovc',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'finalizado',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'ffinalizacion',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'baselegal',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'referencia',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'observacion',valor => '-',filtro => 'N', visor => 'S')
         );
         
        
        
        $this->bd->JqueryArrayVisor('view_nom_accion',$qquery );
        
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
        
       
            
            
            $id = $this->bd->_InsertSQL($this->tabla,$this->ATabla,$this->secuencia);
            
            $result = $this->div_resultado('editar',$id,1);
            
     
        echo $result;
        
    }
    //--------------------------------------------------------------------------------
    //--- edicion de registros
    //--------------------------------------------------------------------------------
    function edicion($id  ){
        
         
        $xx= $this->bd->query_array('nom_accion',   // TABLA
        '*',                        // CAMPOS
        'id_accion='.$this->bd->sqlvalue_inyeccion($id,true) // CONDICION
        );

       

            $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
            
            $result = $this->div_resultado('editar',$id,1);
        
        echo $result  ;
    }
    
    //--------------------------------------------------------------------------------
    //--- eliminar de registros
    //--------------------------------------------------------------------------------
    function eliminar($id ){
        
 
        
        
        
        $sql = "SELECT finalizado,estado
         FROM ".$this->tabla."
         where id_accion = ".$this->bd->sqlvalue_inyeccion($id ,true);
        
        $resultado = $this->bd->ejecutar($sql);
        
        $datos_valida = $this->bd->obtener_array( $resultado);
        
        if ($datos_valida['finalizado'] == 'S'){
            $result = 'NO SE PUEDE ELIMINAR REGISTRO EXISTE TRANSACCIONES GENERADAS';
        }
        else {
            
            if ($datos_valida['estado'] == 'N'){

                        $sql = 'delete from '. $this->tabla .'  where id_accion='.$this->bd->sqlvalue_inyeccion($id, true);
                        
                        $this->bd->ejecutar($sql);
                        
                        $result = $this->div_limpiar();
            }else{

                $sql = 'update  nom_accion
                set  estado='.$this->bd->sqlvalue_inyeccion('X', true).', 
                     finalizado='.$this->bd->sqlvalue_inyeccion('S', true).' 
               where  id_accion= '.$this->bd->sqlvalue_inyeccion($id, true) ;
     
             $this->bd->ejecutar($sql);

            }
        }
        
        
        
        
        echo $result;
        
    }
  //----------------------
    function K_comprobante(  ){
        
 

        $sql = "SELECT max(comprobante::int) as secuencia
			      FROM nom_accion
			      where estado =".$this->bd->sqlvalue_inyeccion('S' ,true);
        
        $parametros 			= $this->bd->ejecutar($sql);
        $secuencia 				= $this->bd->obtener_array($parametros);

        $contador = $secuencia['secuencia'] + 1;
        
        $input = str_pad($contador, 8, "0", STR_PAD_LEFT);
        
        return $input ;
    }
    //------------
    function cierre_revertir( $id_accion ){
           
        $x = $this->bd->query_array('nom_accion',   // TABLA
        '*',                        // CAMPOS
        'id_accion='.$this->bd->sqlvalue_inyeccion($id_accion,true) // CONDICION
        );

        $comprobante = 'A-'.trim($x['comprobante']);

        $sql = 'update  nom_accion
                   set  estado='.$this->bd->sqlvalue_inyeccion('N', true).', 
                        comprobante='.$this->bd->sqlvalue_inyeccion($comprobante , true).',
                        finalizado='.$this->bd->sqlvalue_inyeccion('S', true).' ,
                        ffinalizacion='.$this->bd->sqlvalue_inyeccion($this->hoy , true).' 
                  where  id_accion= '.$this->bd->sqlvalue_inyeccion($id_accion, true) ;
        
        $this->bd->ejecutar($sql);
         
        $this->aprobado_doc('N',$comprobante,2 );
        
        $idprov = trim($x['idprov']);

        $motivo = trim($x['motivo']);

        $sql = " UPDATE nom_personal
        		    SET 	motivo   =".$this->bd->sqlvalue_inyeccion(trim('XX'), true).",
                            fecha_salida = NULL
        		WHERE idprov  =".$this->bd->sqlvalue_inyeccion(trim($idprov), true);
            
             $this->bd->ejecutar($sql);
        
        
        $result = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION GENERADA CON EXITO '.$id_accion.' ESTAN CERRADOS  </b>';
        
        echo $result;
    }     
    //----------------------
    function cierre( $id_accion ){
        
        
        $comprobante = $this->K_comprobante();
        
        
        $sql = 'update  nom_accion
                   set  estado='.$this->bd->sqlvalue_inyeccion('S', true).', 
                        comprobante='.$this->bd->sqlvalue_inyeccion($comprobante, true) .' 
                  where  id_accion= '.$this->bd->sqlvalue_inyeccion($id_accion, true) ;
        
        $this->bd->ejecutar($sql);
         
        $this->aprobado_doc('S',$comprobante,1 );
        

        $this->cambio($id_accion);
        
        
        $result = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION GENERADA CON EXITO '.$id_accion.' ESTAN CERRADOS  </b>';
        
        echo $result;
        
    }
    //----------------------
    function cambio( $id_accion ){
        
        ///---------------------------------------------------
        $x = $this->bd->query_array('nom_accion',   // TABLA
                                    '*',                        // CAMPOS
                                    'id_accion='.$this->bd->sqlvalue_inyeccion($id_accion,true) // CONDICION
            );
        
        $motivo = trim($x['motivo']);
        
    
        
        $salida = 0;
        
        if ( $motivo == 'RENUNCIA') {
            $salida = 1;
        }
        if ( $motivo == 'SALIDA') {
            $salida = 1;
        }
        if ( $motivo == 'REINGRESO') {
            $salida = 2;
        }
        
        if ( $motivo == 'TRASLADO') {
            $salida = 3;
        }
        
        
        if ( $motivo == 'CAMBIO ADMINISTRATIVO') {
            $salida = 3;
        }
        
        if ( $motivo == 'RECLASIFICACION') {
            $salida = 3;
        }
        
        if ( $motivo == 'RESTITUCION') {
            $salida = 3;
        }

        if ( $motivo == 'ENCARGO_no') {
            $salida = 3;
        }
        
        $p_regimen   =          trim( $x['p_regimen'] );
        $p_programa   =         trim( $x['p_programa'] );
        $p_id_departamento   =  $x['p_id_departamento']  ;
        $p_id_cargo   =         $x['p_id_cargo'] ;
        $p_sueldo      =        $x['p_sueldo'] ;
        $fecha_rige =           $x['fecha_rige'];
        $novedad    =           $x['novedad'];
        $idprov     =           trim( $x['idprov'] );
        
        
        echo $motivo.' '.$p_programa.' ';
        
        
        if ( $salida == 1 ){
            //-------------------------
            $sql = " UPDATE nom_personal
        							              SET 	motivo   =".$this->bd->sqlvalue_inyeccion(trim($novedad), true).",
                                                        fecha_salida  =".$this->bd->sqlvalue_inyeccion($fecha_rige, true)."
        							      WHERE idprov  =".$this->bd->sqlvalue_inyeccion(trim($idprov), true);
            
            $this->bd->ejecutar($sql);
            
            $sql = " UPDATE par_ciu
        				    SET  estado   =".$this->bd->sqlvalue_inyeccion('N', true)."
        							      WHERE idprov  =".$this->bd->sqlvalue_inyeccion(trim($idprov), true);
            
            $this->bd->ejecutar($sql);
            
        }
        
        if ( $salida == 2 ){
            //-------------------------
            $sql = " UPDATE nom_personal
        							              SET 	motivo   =".$this->bd->sqlvalue_inyeccion(trim(''), true).",
	                                                    id_departamento   =".$this->bd->sqlvalue_inyeccion($p_id_departamento, true).",
                                                        id_cargo   =".$this->bd->sqlvalue_inyeccion($p_id_cargo, true).",
                                                        regimen   =".$this->bd->sqlvalue_inyeccion($p_regimen, true).",
                                                        sueldo   =".$this->bd->sqlvalue_inyeccion($p_sueldo, true).",
                                                        fecha   =".$this->bd->sqlvalue_inyeccion($fecha_rige, true).",
                                                        fecha_salida = NULL
        							      WHERE idprov  =".$this->bd->sqlvalue_inyeccion(trim($idprov), true);
            
            $this->bd->ejecutar($sql);
            
            $sql = " UPDATE par_ciu
        				    SET  estado   =".$this->bd->sqlvalue_inyeccion('S', true).",
                                 programa   =".$this->bd->sqlvalue_inyeccion($p_programa, true)."
        							      WHERE idprov  =".$this->bd->sqlvalue_inyeccion(trim($idprov), true);
            
            $this->bd->ejecutar($sql);
            
        }
        
        if ( $salida == 3 ){
            //-------------------------
            $sql = " UPDATE nom_personal
        							              SET 	id_departamento   =".$this->bd->sqlvalue_inyeccion($p_id_departamento, true).",
                                                        id_cargo   =".$this->bd->sqlvalue_inyeccion($p_id_cargo, true).",
                                                        regimen   =".$this->bd->sqlvalue_inyeccion($p_regimen, true).",
                                                        sueldo   =".$this->bd->sqlvalue_inyeccion($p_sueldo, true)."
        							      WHERE idprov  =".$this->bd->sqlvalue_inyeccion(trim($idprov), true);
            
            $this->bd->ejecutar($sql);
            
            $sql1 = "UPDATE par_ciu
        			   SET  programa=".$this->bd->sqlvalue_inyeccion(trim($p_programa), true)."
        			 WHERE idprov  =".$this->bd->sqlvalue_inyeccion(trim($idprov), true);
            
            $this->bd->ejecutar($sql1);
            
        }
        
    }
    
    //--------------------------
    function Finalizado( $id_accion ){
        
 
        
        $sql = 'update  nom_accion
                   set  finalizado='.$this->bd->sqlvalue_inyeccion('S', true).' ,
                        ffinalizacion='.$this->bd->sqlvalue_inyeccion($this->hoy , true).' 
                  where  id_accion= '.$this->bd->sqlvalue_inyeccion($id_accion, true) ;
        
        $this->bd->ejecutar($sql);
        
         
        $this->aprobado_doc('S','0',0 );
         
        $result = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>TRAMITE FINALIZADO'.$id_accion.' ESTAN CERRADOS  </b>';
        
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
         
        $gestion->cierre($id);
        
    }elseif(  $accion == 'fin'){
    
        $gestion->Finalizado($id);

    }elseif(  $accion == 'revertir'){
    
        $gestion->cierre_revertir($id);
    }
    else{
        
        $gestion->consultaId($accion,$id);
        
    }
    
    
}

//------ grud de datos insercion
if (isset($_POST["action"]))	{
    
    $action = @$_POST["action"];
    
    $id =     @$_POST["id_accion"];
    
    $gestion->xcrud(trim($action),$id );
    
}



?>
 
  
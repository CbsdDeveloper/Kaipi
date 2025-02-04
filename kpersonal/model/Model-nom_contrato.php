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
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
        $this->ATabla = array(
            array( campo => 'id_accion',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
            array( campo => 'idprov',tipo => 'VARCHAR2',id => '1',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'anio',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'N', valor => $this->anio, key => 'N'),
            array( campo => 'comprobante',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'fecha',tipo => 'DATE',id => '4',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'tipo',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'motivo',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'fecha_rige',tipo => 'DATE',id => '7',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'novedad',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'otro',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'estado',tipo => 'VARCHAR2',id => '10',add => 'S', edit => 'N', valor => 'N', key => 'N'),
            array( campo => 'regimen',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'programa',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'id_departamento',tipo => 'NUMBER',id => '13',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'id_cargo',tipo => 'NUMBER',id => '14',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'sueldo',tipo => 'NUMBER',id => '15',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'p_regimen',tipo => 'VARCHAR2',id => '16',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'p_programa',tipo => 'VARCHAR2',id => '17',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'p_id_departamento',tipo => 'NUMBER',id => '18',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'p_id_cargo',tipo => 'NUMBER',id => '19',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'p_sueldo',tipo => 'NUMBER',id => '20',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'sesion',tipo => 'VARCHAR2',id => '21',add => 'S', edit => 'N', valor => $this->sesion , key => 'N'),
            array( campo => 'creacion',tipo => 'DATE',id => '22',add => 'S', edit => 'N', valor => $this->hoy , key => 'N'),
            array( campo => 'modificacion',tipo => 'VARCHAR2',id => '23',add => 'S', edit => 'S', valor => $this->sesion , key => 'N'),
            array( campo => 'fmodificacion',tipo => 'DATE',id => '24',add => 'S', edit => 'S', valor =>$this->hoy , key => 'N'),
            array( campo => 'finalizado',tipo => 'VARCHAR2',id => '25',add => 'S', edit => 'N', valor =>'S' , key => 'N'),
            array( campo => 'ffinalizacion',tipo => 'DATE',id => '26',add => 'S', edit => 'S', valor =>$this->hoy , key => 'N'),
            array( campo => 'modulo',tipo => 'VARCHAR2',id => '27',add => 'S', edit => 'N', valor =>'C' , key => 'N')
        );
        
 
        
        $this->tabla 	  		    = 'nom_accion';
   
        $this->secuencia 	     = 'nom_accion_id_accion_seq';
        
    }
    //-----------------------------------------------------------------------------------------------------------
  
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
            array( campo => 'finalizado',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'ffinalizacion',valor => '-',filtro => 'N', visor => 'S')
         );
 
        
        $this->bd->JqueryArrayVisor('view_nom_accion',$qquery );
        
        $result =  $this->div_resultado($accion,$id,0);
        
        echo  $result;
    }
    
    
    
    //--------------------------------------------------------------------------------
    //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
    //--------------------------------------------------------------------------------
    
    function xcrud( $novedad , $idprov ,$p_sueldo ){
        
        
        $v1 = strlen(trim($novedad));
        $v2 = strlen(trim($idprov));
        
        $bandera = 0;
        
        // ------------------  agregar
        if ($v1 > 5){
            
            $bandera = 1;
            
        }
        // ------------------  
        if ($v2 >  5){
            
            $bandera = $bandera + 1;
            
        }
        // ------------------   
        if ($p_sueldo >  100 ){
            
            $bandera = $bandera + 1;
            
        }
        // ------------------  
        if ($bandera == 3 ){
            
            $bandera = 1;
            
        }else{
            $bandera = 0;
        }
        
        return $bandera;
    }
    //--------------------------------------------------------------------------------
    //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
    //--------------------------------------------------------------------------------
    function agregar( $idprov,$novedad,$motivo,$programa,$regimen,$id_departamento,$id_cargo,$sueldo,$fecha,$fecha_rige,
        $p_regimen,$p_programa,$p_id_departamento,$p_id_cargo,$p_sueldo){
  
            $this->ATabla[1][valor] =  trim($idprov);
            $this->ATabla[3][valor] =  'C-'.trim($idprov);
            $this->ATabla[4][valor] =  $fecha_rige;
            $this->ATabla[5][valor] =  'Contrato';
            
            $this->ATabla[6][valor] =  $motivo;
            $this->ATabla[7][valor] =  $fecha_rige;
            
            $this->ATabla[8][valor] =  $novedad;
            $this->ATabla[9][valor] =  'Regimen Contratos';
            $this->ATabla[10][valor] =  'S';
            
            $this->ATabla[11][valor] =  $regimen;
            $this->ATabla[12][valor] =  $programa;
            $this->ATabla[13][valor] =  $id_departamento;
            $this->ATabla[14][valor] =  $id_cargo;
            $this->ATabla[15][valor] =  $sueldo;

            $this->ATabla[16][valor] =  $p_regimen;
            $this->ATabla[17][valor] =  $p_programa;
            $this->ATabla[18][valor] =  $p_id_departamento;
            $this->ATabla[19][valor] =  $p_id_cargo;
            $this->ATabla[20][valor] =  $p_sueldo;
            
            
            $id = $this->bd->_InsertSQL($this->tabla,$this->ATabla,$this->secuencia);
            
            $result = 'Transaccion generada....('.$idprov.') Proceso '.$id;
            
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
                
                $sql = "UPDATE par_ciu
        				    SET  programa   =".$this->bd->sqlvalue_inyeccion(trim($p_programa), true)."
        							      WHERE idprov  =".$this->bd->sqlvalue_inyeccion(trim($idprov), true);
                
                $this->bd->ejecutar($sql);
                
            }
            
          
             
        return $result;
        
    }
    //--------------------------------------------------------------------------------
    //--- edicion de registros
    //--------------------------------------------------------------------------------
    function edicion($id  ){
        
        $estado = @$_POST["estado"];
 
        if ( $estado == 'N'){
            
            $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
            
            $result = $this->div_resultado('editar',$id,1);
            
        }else {
            $result = $this->div_resultado('editar',$id,-1);
        }
            
           
            
        
        echo $result  ;
    }
    
    //--------------------------------------------------------------------------------
    
   
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;


 
//------ grud de datos insercion
if (isset($_POST["idprov"]))	{
    
    $idprov    = $_POST['idprov'];
    $novedad   = $_POST['novedad'];
    $motivo    = $_POST['motivo'];
    $programa  = $_POST['programa'];
    $regimen   = $_POST['regimen'];
    
    $id_departamento  = $_POST['id_departamento'];
    $id_cargo         = $_POST['id_cargo'];
    $sueldo           = $_POST['sueldo'];
    $fecha            = $_POST['fecha'];
    $fecha_rige       = $_POST['fecha_rige'];
    
    $p_regimen        = $_POST['p_regimen'];
    $p_programa       = $_POST['p_programa'];
    $p_id_departamento  = $_POST['p_id_departamento'];
    $p_id_cargo         = $_POST['p_id_cargo'];
    $p_sueldo           = $_POST['p_sueldo'];
    
    $valida = $gestion->xcrud(trim($novedad),trim($idprov),$p_sueldo );
    
    if ($valida == 1){
        
        $resul =  $gestion->agregar($idprov,$novedad,trim($motivo),trim($programa),trim($regimen),$id_departamento,$id_cargo,$sueldo,$fecha,$fecha_rige,
            trim($p_regimen),trim($p_programa),$p_id_departamento,$p_id_cargo,$p_sueldo);
        
    }else {
        $resul = 'Revise los datos para generar la transaccion '.$valida;
    }
    
    echo $resul;
}



?>
 
  
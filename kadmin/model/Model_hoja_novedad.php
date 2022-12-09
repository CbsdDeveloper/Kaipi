<?php
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class Model_hoja_novedad{
    
    
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
    function Model_hoja_novedad( ){
        
        $this->obj     = 	new objects;
        $this->bd	   =	new Db ;
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        
        $this->sesion 	 =  trim($_SESSION['email']);
        
        $this->hoy 	     =  date('Y-m-d');
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
        $this->tabla 	  	     = 'hoja_ruta';
        
        $this->secuencia 	     = 'hoja_ruta_id_hoja_ruta_seq';
          
         
        $this->ATabla = array(
            array( campo => 'id_hoja_ruta',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
            array( campo => 'desde',tipo => 'DATE',id => '1',add => 'S', edit => 'S', valor =>  $this->hoy 	, key => 'N'),
            array( campo => 'hasta',tipo => 'DATE',id => '2',add => 'S', edit => 'S', valor =>  $this->hoy 	, key => 'N'),
            array( campo => 'destino',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'mo_salida',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'observaciones',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'registro',tipo => 'DATE',id => '6',add => 'S', edit => 'S', valor => $this->hoy, key => 'N'),
            array( campo => 'hora_desde',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'hora_saluda',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'tipo',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'S', valor => 'hoja', key => 'N'),
            array( campo => 'idprov',tipo => 'VARCHAR2',id => '10',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'estado',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'S', valor => 'registro', key => 'N') 
        );
        
        
        
    }
    
    
    
    //--------------------------------------------------------------------------------
    //--- busqueda de por codigo para llenar los datos
    //--------------------------------------------------------------------------------
    function clean($str)
    {
         
        $str = str_replace("&nbsp;", "", $str);
        $str = preg_replace("/\s+/", " ", $str);
        $str = trim($str);
        return $str;
    }
    
    function consultaId( ){
        
        $datos = $this->bd->__user($this->sesion);
        
        $idprov = $datos['idprov'];
        
        $sql = "SELECT *
                 FROM hoja_ruta
               WHERE idprov = ".$this->bd->sqlvalue_inyeccion( $idprov, true)." and
                     registro = ".$this->bd->sqlvalue_inyeccion(  $this->hoy , true)."
               order by registro desc, hora_desde desc";
        
   
        
        $stmt1 = $this->bd->ejecutar($sql);
        
        $fecha = $this->bd->_formato_fecha($this->hoy);
        
        echo '<h4><b>'.$fecha .'</b></h4>';
        
        while ($fila=$this->bd->obtener_fila($stmt1)){
            
            $fecha     = trim($fila['hora_desde']);
            $tipo      = trim($fila['mo_salida']);
            $actividad = trim($fila['destino']);
            
            $id_bom_nov = $fila['id_hoja_ruta'];
            
            
            $actividad = $this->clean($actividad);
            
            
            
            echo '<div class="media">
                     <div class="media-left">
                       <a href="#" onClick="EliminaNovedad('.$id_bom_nov.')" title="DESEA ELIMINAR LA NOVEDAD?">
                            <img src="../../kimages/if_bullet_red_35785.png" class="media-object" style="width:32px"></a>
                    </div>
                    <div class="media-body">
                    <h4 class="media-heading">'. $actividad.' <small><i>Hora: '.$fecha.'</i></small></h4>
                    <p>'. $tipo .'</p>
             </div>
            </div><hr>';
            
        }
        
        
        
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
    function agregar(  $POST ){
        
        $datos = $this->bd->__user($this->sesion);
        
        $idprov = $datos['idprov'];
       
        
        $this->ATabla[3][valor] =  trim(strtoupper($POST['actividad'])) ;
        $this->ATabla[4][valor] =  trim(strtoupper($POST['motivo'])) ;
        $this->ATabla[5][valor] =  trim(strtoupper($POST['observacion'])) ;
        
        $this->ATabla[7][valor] =  trim($POST['hora1'])  ;
        $this->ATabla[8][valor] =  trim($POST['hora2'])  ;
        
        $this->ATabla[10][valor] =  trim( $idprov )  ;
        
        $this->bd->_InsertSQL($this->tabla,$this->ATabla, $this->secuencia );
        
         
    }
    
    
    
    //--------------------------------------------------------------------------------
    //--- eliminar de registros
    //--------------------------------------------------------------------------------
    function eliminar($id_bom_nov ){
        
        $this->bd->JqueryDeleteSQL($this->tabla,'id_hoja_ruta='.$this->bd->sqlvalue_inyeccion($id_bom_nov, true));
        
        $result ='<b>DATO ELIMINADO CORRECTAMENTE....</b>';
        
        echo $result;
        
    }
    
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new Model_hoja_novedad;


//------ grud de datos insercion

if (isset($_POST["accion"]))	{
    
    $action = trim($_POST["accion"]);
 
    
    if ( $action == 'agregar' ){
        $gestion->agregar( $_POST );
        $gestion->consultaId();
    }
    
    
    if ( $action == 'visor' ){
        $gestion->consultaId();
    }
    
    
    if ( $action == 'eliminar' ){
        $id_bom_nov     = $_POST["id_bom_nov"];
        $gestion->eliminar($id_bom_nov);
        $gestion->consultaId();
    }
    
    
    
}



?>
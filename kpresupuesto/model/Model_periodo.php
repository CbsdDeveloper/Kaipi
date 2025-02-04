<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

require 'Model_saldos.php'; /*Incluimos el fichero de la clase objetos*/

class proceso{
    
    //creamos la variable donde se instanciar la clase "mysql"
    
    private $obj;
    private $bd;
    private $saldos;
    
    private $ruc;
    private $sesion;
    private $hoy;
    private $POST;
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function proceso( ){
        //inicializamos la clase para conectarnos a la bd
        
        $this->obj     = 	new objects;
        $this->bd	   =	new Db ;
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        $this->sesion 	 =  $_SESSION['email'];
 
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
        $this->saldos     = 	new saldo_presupuesto(  $this->obj,  $this->bd);
        
        
    }
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function div_resultado($accion,$id,$tipo,$estado){
        //inicializamos la clase para conectarnos a la bd
        
        echo '<script type="text/javascript">accion_periodo('.$id.',"'.$accion.'" );</script>';
        
      
        if ($tipo == 0){
            
            if ($accion == 'editar'){
                $resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>EDITAR REGISTRO TRANSACCION ?</b>';
            }
            
            if ($accion == 'del'){
                $resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ELIMINAR REGISTRO TRANSACCION ?</b>';
            }
            
         }
        
        if ($tipo == 1){
            
            $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO ['.$id.']</b>';
            
             
        }
        
        if ($tipo == 2){
            
            $resultado = '<img src="../../kimages/kfav.png" align="absmiddle" />&nbsp;<b>ACTUALIZANDO INFORMACION</b>';
            
        }
        
        
        return $resultado;
        
    }
    
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function div_limpiar( ){
        //inicializamos la clase para conectarnos a la bd
        
        $resultado = 'TRANSACCION ELIMINADA';
        
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
            array( campo => 'idperiodo',    valor =>$id,  filtro => 'S',   visor => 'S'),
            array( campo => 'anio',    valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'sesionm',         valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'modificacion',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'estado',     valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'detalle',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'registro',  valor =>$this->ruc,  filtro => 'S',   visor => 'S')
        );
        
        $datos = $this->bd->JqueryArrayVisorTab('presupuesto.pre_periodo',$qquery,'-' );
 
       
        $result =  $this->div_resultado($accion,$id,0,$datos['estado']);
        
        echo  $result;
    }
    //--------------------------------------------------------------------------------------
    
    function xcrud($action,$id){
        
        
        // ------------------  agregar
        if ($action == 'add'){
            
            $this->agregar();
            
        }
        // ------------------  editar
        if ($action == 'editar'){
            
            $this->edicion($id);
            
        }
        // ------------------  eliminar
        if ($action == 'del'){
            
            $this->eliminar($id );
            
        }
        
        // ------------------  eliminar
        if ($action == 'aprobacion'){
            
            $this->aprobacion($id );
            
        }
        
    }
    //--------------------------------------------------------------------------------
    //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
    //--------------------------------------------------------------------------------
    function agregar( ){
        
        $fecha_registro		=  date("Y-m-d"); 
        $fecha			    = $this->bd->fecha($fecha_registro);
        $anio               = $_POST["anio"];
        $estado             = $_POST["estado"];
        $detalle            = 'Periodo Presupuestario '.$anio.' - '.$estado ;
       
        $x = $this->bd->query_array('presupuesto.pre_periodo',
                                    'count(*) as nn', 
                                    'anio='.$this->bd->sqlvalue_inyeccion($anio,true).' and 
                                     registro='.$this->bd->sqlvalue_inyeccion($this->ruc,true)
         );
        
        $_SESSION['periodo_presupuesto'] = $estado ;
        
        if ( $x["nn"] > 0 ){
            
            $result = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>PERIODO YA GENERADO '.$anio.' </b>';
            
        }else{
            
        $sql = "INSERT INTO presupuesto.pre_periodo (  creacion,anio, sesion, sesionm, modificacion, estado, registro, detalle)
										        VALUES (".$fecha.",".
										        $this->bd->sqlvalue_inyeccion($anio, true).",".
										        $this->bd->sqlvalue_inyeccion( $this->sesion , true).",".
										        $this->bd->sqlvalue_inyeccion( $this->sesion , true).",".
										        $fecha.",".
										        $this->bd->sqlvalue_inyeccion($estado, true).",".
										        $this->bd->sqlvalue_inyeccion( $this->ruc, true).",".
										        $this->bd->sqlvalue_inyeccion($detalle, true).")";
										        
										        
										        $this->bd->ejecutar($sql);
										        
										        $idAsiento =  $this->bd->ultima_secuenciaP('presupuesto.pre_periodo_idperiodo_seq');
										          
										        $result = $this->div_resultado('editar',$idAsiento,1,$estado);
        }
        
        echo $result;
										        
    }
  
    //--------------------------------------------------------------------------------
    //--- edicion de registros
    //--------------------------------------------------------------------------------
    function edicion($id){
        
        $fecha_registro		=  date("Y-m-d");
        $fecha			    = $this->bd->fecha($fecha_registro);
        $anio               = $_POST["anio"];
        $estado             = $_POST["estado"];
        $detalle            = 'Periodo Presupuestario '.$anio.' - '.$estado ;
        
        $_SESSION['periodo_presupuesto'] = $estado ;
            
            $sql = "UPDATE presupuesto.pre_periodo
						SET 	detalle =".$this->bd->sqlvalue_inyeccion($detalle, true).",
							    estado  =".$this->bd->sqlvalue_inyeccion($estado, true).",
                                modificacion  =".$fecha.",
								sesionm        =".$this->bd->sqlvalue_inyeccion( $this->sesion , true)."
					  WHERE idperiodo   =".$this->bd->sqlvalue_inyeccion($id, true);
            
            $this->bd->ejecutar($sql);
            
     
            
 
            $result = $this->div_resultado('editar',$id,1,$estado);
        
        echo $result;
    }
    
    //--------------------------------------------------------------------------------
    //--- eliminar de registros
    //--------------------------------------------------------------------------------
    function eliminar($id ){
         
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


//------ poner informacion en los campos del sistema
if (isset($_GET['accion']))	{
    
    $accion    		= $_GET['accion'];
    
    $id            		= $_GET['id'];
    
    $gestion->consultaId($accion,$id);
    
    
    
}

//------ grud de datos insercion
if (isset($_POST["action2"]))	{
    
    $action 		    =     @$_POST["action2"];
    
    $id 				=     @$_POST["idperiodo"];
    
    
    $gestion->xcrud(trim($action) ,  $id  );
    
    
}



?>
 
  
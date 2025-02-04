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
        array( campo => 'idprov',tipo => 'VARCHAR2',id => '0',add => 'S', edit => 'S', valor => '-', key => 'N'),
        array( campo => 'anio',tipo => 'VARCHAR2',id => '1',add => 'S', edit => 'S', valor =>  $this->anio, key => 'N'),
        array( campo => 'unidad',tipo => 'NUMBER',id => '2',add => 'S', edit => 'S', valor => '-', key => 'N'),
        array( campo => 'cargo',tipo => 'NUMBER',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
        array( campo => 'regimen',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => '-', key => 'N'),
        array( campo => 'salario',tipo => 'NUMBER',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
        array( campo => 'ingreso',tipo => 'DATE',id => '6',add => 'S', edit => 'S', valor => '-', key => 'N'),
        array( campo => 'salida',tipo => 'DATE',id => '7',add => 'S', edit => 'S', valor => '-', key => 'N'),
        array( campo => 'motivo',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor => '-', key => 'N'),
        array( campo => 'discapacidad',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'S', valor => '-', key => 'N'),
        array( campo => 'detalle',tipo => 'VARCHAR2',id => '10',add => 'S', edit => 'S', valor => '-', key => 'N'),
        array( campo => 'sesion',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'S', valor => $this->sesion, key => 'N'),
        array( campo => 'creacion',tipo => 'DATE',id => '12',add => 'S', edit => 'S', valor => $this->hoy, key => 'N'),
        array( campo => 'id_liqcab',   tipo => 'NUMBER',   id => '13',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
        array( campo => 'comprobante',tipo => 'VARCHAR2',id => '14',add => 'S', edit => 'S', valor => '-', key => 'N'),
        array( campo => 'fecha',tipo => 'DATE',id => '15',add => 'S', edit => 'S', valor => '-', key => 'N'),
        array( campo => 'estado',tipo => 'VARCHAR2',id => '16',add => 'S', edit => 'N', valor => 'digitado', key => 'N'),
        array( campo => 'id_tramite',tipo => 'NUMBER',id => '17',add => 'S', edit => 'S', valor => '0', key => 'N'),
        array( campo => 'tingreso',tipo => 'NUMBER',id => '18',add => 'S', edit => 'S', valor => '-', key => 'N'),
        array( campo => 'tdescuento',tipo => 'NUMBER',id => '19',add => 'S', edit => 'S', valor => '-', key => 'N'),
        array( campo => 'tpago',tipo => 'NUMBER',id => '20',add => 'S', edit => 'S', valor => '-', key => 'N') 
        );
        
 
        $this->tabla 	  		    = 'nom_liq_cab';
   
        $this->secuencia 	     = 'nom_liq_cab_id_liqcab_seq';
        
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
    function _detalle_liquidacion( $id ){
        //inicializamos la clase para conectarnos a la bd
        
        $sql1 = "SELECT referencia, grupo, variables, clasificador, objeto ,formulario
        FROM nom_liq_matriz
        order by formulario,referencia asc";

 
        $stmt1 = $this->bd->ejecutar($sql1);

 
        while ($fila=$this->bd->obtener_fila($stmt1)){
    
            $formulario = trim($fila['formulario']);
            $referencia = trim($fila['referencia']);
            $objeto     = trim($fila['objeto']);

            $valor = $_POST[$referencia];

            $ingreso   = '0.00';
            $descuento = '0.00';
            $monto     = '0.00';

            if (  $formulario == 'GRUPO1'){
                $ingreso   = '0.00';
                $descuento = '0.00';
                $monto     =  $valor ;
            }
            if (  $formulario == 'GRUPO2'){
                $ingreso   = $valor ;
                $descuento = '0.00';
                $monto     = '0.00';
            }
            if (  $formulario == 'GRUPO3'){
                $ingreso   =  '0.00';
                $descuento =  $valor ;
                $monto     =  '0.00';
            }
            
            $item  = '--';

            if (  $objeto == 'lista'){
                $ingreso   = '0.00';
                $descuento = '0.00';
                $monto     =  '0.00';
                $item = $valor;
            }
            
            


 
            $ATabla = array(
                array( campo => 'id_liqcabdet',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
                array( campo => 'id_liqcab',tipo => 'NUMBER',id => '1',add => 'S', edit => 'S', valor => $id, key => 'N'),
                array( campo => 'referencia',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => $referencia, key => 'N'),
                array( campo => 'ingreso',tipo => 'NUMBER',id => '3',add => 'S', edit => 'S', valor =>  $ingreso, key => 'N'),
                array( campo => 'partida',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => '-', key => 'N'),
                array( campo => 'item',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor =>   $item , key => 'N'),
                array( campo => 'sesion',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor =>$this->sesion , key => 'N'),
                array( campo => 'creacion',tipo => 'DATE',id => '7',add => 'S', edit => 'S', valor =>  $this->hoy 	, key => 'N'),
                array( campo => 'descuento',tipo => 'NUMBER',id => '8',add => 'S', edit => 'S', valor => $descuento, key => 'N'),
                array( campo => 'monto',tipo => 'NUMBER',id => '8',add => 'S', edit => 'S', valor => $monto , key => 'N'),
                );

              $this->bd->_InsertSQL('nom_liq_cab_det',$ATabla,'nom_liq_cab_det_id_liqcabdet_seq');
              
        }
 
    }

    //---------------
    function _detalle_liquidacion_edicion( $id ){
        //inicializamos la clase para conectarnos a la bd
        
        $sql1 = "SELECT a.id_liqcabdet, a.id_liqcab, a.referencia, 
                        a.ingreso, a.partida, a.item, b.objeto, b.formulario 
                FROM  nom_liq_cab_det a, nom_liq_matriz b
                where a.id_liqcab= ".$this->bd->sqlvalue_inyeccion($id,true)." and 
                      a.referencia = b.referencia 
             order by b.formulario,a.referencia asc";

 
        $stmt1 = $this->bd->ejecutar($sql1);

 
        while ($fila=$this->bd->obtener_fila($stmt1)){
    
            $formulario = trim($fila['formulario']);
            $referencia = trim($fila['referencia']);
            $objeto     = trim($fila['objeto']);


            $id_liqcabdet = $fila['id_liqcabdet'];

            $valor = $_POST[$referencia];

            $ingreso   = '0.00';
            $descuento = '0.00';
            $monto     = '0.00';

            if (  $formulario == 'GRUPO1'){
                $ingreso   = '0.00';
                $descuento = '0.00';
                $monto     =  $valor ;
            }
            if (  $formulario == 'GRUPO2'){
                $ingreso   = $valor ;
                $descuento = '0.00';
                $monto     = '0.00';
            }
            if (  $formulario == 'GRUPO3'){
                $ingreso   =  '0.00';
                $descuento =  $valor ;
                $monto     =  '0.00';
            }
            
            $item  = '--';

            if (  $objeto == 'lista'){
                $ingreso   = '0.00';
                $descuento = '0.00';
                $monto     =  '0.00';
                $item = $valor;
            }
            
            


 
            $ATabla = array(
                array( campo => 'id_liqcabdet',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
                array( campo => 'id_liqcab',tipo => 'NUMBER',id => '1',add => 'N', edit => 'N', valor => $id, key => 'N'),
                array( campo => 'referencia',tipo => 'VARCHAR2',id => '2',add => 'N', edit => 'N', valor => $referencia, key => 'N'),
                array( campo => 'ingreso',tipo => 'NUMBER',id => '3',add => 'S', edit => 'S', valor =>  $ingreso, key => 'N'),
                array( campo => 'partida',tipo => 'VARCHAR2',id => '4',add => 'N', edit => 'N', valor => '-', key => 'N'),
                array( campo => 'item',tipo => 'VARCHAR2',id => '5',add => 'N', edit => 'S', valor =>   $item , key => 'N'),
                array( campo => 'sesion',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor =>$this->sesion , key => 'N'),
                array( campo => 'creacion',tipo => 'DATE',id => '7',add => 'S', edit => 'S', valor =>  $this->hoy 	, key => 'N'),
                array( campo => 'descuento',tipo => 'NUMBER',id => '8',add => 'S', edit => 'S', valor => $descuento, key => 'N'),
                array( campo => 'monto',tipo => 'NUMBER',id => '8',add => 'S', edit => 'S', valor => $monto , key => 'N'),
                );

                $this->bd->_UpdateSQL( 'nom_liq_cab_det',$ATabla,$id_liqcabdet);

               
        }
 
    }
    
    
    //--------------------------------------------------------------------------------
    //--- busqueda de por codigo para llenar los datos
    //--------------------------------------------------------------------------------
    function consultaId($accion,$id ){
  
        $qquery = array(
            array( campo => 'id_liqcab',   valor =>$id,  filtro => 'S',   visor => 'S'),
            array( campo => 'idprov',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'anio',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'unidad',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'cargo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'regimen',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'salario',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'ingreso',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'salida',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'motivo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'discapacidad',valor => '-',filtro => 'N', visor => 'S'),
             array( campo => 'comprobante',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'fecha',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'estado',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'id_tramite',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'programa',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'tingreso',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'tdescuento',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'tpago',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'razon',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'direccion',valor => '-',filtro => 'N', visor => 'S'),
         );
 
        
        
        $this->bd->JqueryArrayVisor('view_liq_cab',$qquery );

        $this->_consulta_detalle($id);
        
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


            $this->_detalle_liquidacion($id );

            $result = $this->div_resultado('editar',$id,1);
            
     
        echo $result;
        
    }
    //--------------------------------------------------------------------------------
    //--- edicion de registros
    //--------------------------------------------------------------------------------
    function edicion( $id  ){
        
           

            $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);

            $this->_detalle_liquidacion_edicion( $id );
            
            $result = $this->div_resultado('editar',$id,1);
        
        echo $result  ;
    }
    
    //--------------------------------------------------------------------------------
    //--- eliminar de registros
    //--------------------------------------------------------------------------------
    function eliminar($id ){
         
 

        
        $sql = "SELECT *
         FROM nom_liq_cab
         where id_liqcab = ".$this->bd->sqlvalue_inyeccion($id ,true);
        
        $resultado = $this->bd->ejecutar($sql);
        
        $datos_valida = $this->bd->obtener_array( $resultado);
        
        if ( trim($datos_valida['estado']) == 'digitado'){
            
            $sql = 'delete from nom_liq_cab  where id_liqcab='.$this->bd->sqlvalue_inyeccion($id, true);
            
            $this->bd->ejecutar($sql);

            $sql = 'delete from nom_liq_cab_det  where id_liqcab='.$this->bd->sqlvalue_inyeccion($id, true);
            
            $this->bd->ejecutar($sql);
            
            $result = $this->div_limpiar();

        }
        else {
            
            $result = 'NO SE PUEDE ELIMINAR REGISTRO EXISTE TRANSACCIONES GENERADAS';
          
            
        }
        
        
        
        
        echo $result;
        
    }
  //----------------------
    function K_comprobante(  ){
       

      
        $sql = "SELECT max(comprobante::int) as secuencia
			      FROM nom_liq_cab 
			      where estado = 'aprobado' and anio =".$this->bd->sqlvalue_inyeccion( $this->anio   ,true);
        
        $parametros 			= $this->bd->ejecutar($sql);
        $secuencia 				= $this->bd->obtener_array($parametros);

        $contador = $secuencia['secuencia'] + 1;
        
        $input = str_pad($contador, 8, "0", STR_PAD_LEFT);
        
        return $input ;
    }
    //------------
    function _consulta_detalle( $id_accion ){
 

        $sql1 = "SELECT id_liqcabdet, id_liqcab, referencia, ingreso, partida, item, sesion, creacion, descuento, monto 
        FROM nom_liq_cab_det
        where id_liqcab = ".$this->bd->sqlvalue_inyeccion($id_accion,true).'
        order by referencia,id_liqcabdet';

  
        $result = $this->bd->ejecutar($sql1);


        echo "<script>";

        while ($fila=$this->bd->obtener_fila($result)){
    
                    $ingreso   =  ($fila['ingreso']);
                    $descuento =  ($fila['descuento']);
                    $monto     =  ($fila['monto']);

                    $item            = trim($fila['item']);
                    $referencia      = trim($fila['referencia']);

                    if ( $item == '--'){

                            $tipo = substr( $referencia,0,1);

                            if (   $tipo == 'A'){
                                echo "$('#".$referencia."').val("."'". $monto."'".");";
                            }
                            if (   $tipo == 'I'){
                                echo "$('#".$referencia."').val("."'". $ingreso."'".");";
                            }
                            if (   $tipo == 'E'){
                                echo "$('#".$referencia."').val("."'". $descuento."'".");";
                            }
                            if (   $tipo == 'J'){
                                echo "$('#".$referencia."').val("."'". $ingreso."'".");";
                            }
                    }
                    else {
                         echo "$('#".$referencia."').val("."'". $item."'".");";
                     }
                 }

                 echo "</script>";
        
       
    }     
    //----------------------
 
    
    //--------------------------
    function Aprobar_tramite( $id_accion ){
        
 
      $comprobante =   $this->K_comprobante();
        
        $sql = 'update  nom_liq_cab
                   set  estado='.$this->bd->sqlvalue_inyeccion('aprobado', true).' ,
                        comprobante='.$this->bd->sqlvalue_inyeccion($comprobante , true).' 
                  where  id_liqcab= '.$this->bd->sqlvalue_inyeccion($id_accion, true) ;
        
        $this->bd->ejecutar($sql);

        $accion = 'editado';
        $estado = 'aprobado';

        echo '<script type="text/javascript">accion('.$id_accion.',"'.$accion.'","'.$estado.'"  );</script>';
        
        
         
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
    
    if ( $accion == 'aprobar'){
         
        $gestion->Aprobar_tramite($id);
        
    } 
    else{
        
        $gestion->consultaId($accion,$id);
        
    }
    
    
}

//------ grud de datos insercion
if (isset($_POST["action"]))	{
    
    $action = @$_POST["action"];
    
    $id =     @$_POST["id_liqcab"];
    
    $gestion->xcrud(trim($action),$id );
    
}



?>
 
  
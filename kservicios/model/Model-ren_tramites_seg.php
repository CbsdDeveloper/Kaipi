<?php
session_start();

require '../../kconfig/Db.class.php';  

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
    
     
    private $obj;
    private $bd;
    
    private $ruc;
    public  $sesion;
    public  $hoy;
    private $POST;
    private $ATabla;
    private $ATabla_parametros;
    private $tabla ;
    private $secuencia;
    
    private $estado_periodo;
    private $anio;
    
    private $id;
    
    
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function proceso( ){
        //inicializamos la clase para conectarnos a la bd
        
        $this->obj     = 	new objects;
        $this->bd	   =	new Db ;
        
        $this->ruc       =     trim($_SESSION['ruc_registro']);
        $this->sesion 	 =     trim($_SESSION['email']);
        $this->hoy 	     =     date("Y-m-d");     
        $this->anio      =     $_SESSION['anio'];
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
        $this->ATabla_parametros = array(
            array( campo => 'id_ren_tramite_var',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
            array( campo => 'id_ren_tramite',tipo => 'NUMBER',id => '1',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'id_rubro_var',tipo => 'NUMBER',id => '2',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'id_rubro',tipo => 'NUMBER',id => '3',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'valor_variable',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'sesion',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor =>$this->sesion, key => 'N'),
        );
         
        
        $usuario = $this->bd->__user(  $this->sesion);
        
        $this->ATabla = array(
            array( campo => 'id_ren_tramite',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
            array( campo => 'id_par_ciu',tipo => 'NUMBER',id => '1',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'id_departamento',tipo => 'NUMBER',id => '2',add => 'S', edit => 'S', valor =>$usuario['id_departamento'], key => 'N'),
            array( campo => 'id_rubro',tipo => 'NUMBER',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'estado',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'N', valor => 'digitado', key => 'N'),
            array( campo => 'fecha_inicio',tipo => 'DATE',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'fecha_cierre',tipo => 'DATE',id => '6',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'detalle',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'resolucion',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'multa',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'base',tipo => 'NUMBER',id => '10',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'sesion',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'N', valor =>  $this->sesion, key => 'N'),
            array( campo => 'msesion',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'S', valor =>$this->sesion, key => 'N'),
            array( campo => 'creacion',tipo => 'DATE',id => '13',add => 'S', edit => 'N', valor =>$this->hoy, key => 'N'),
            array( campo => 'modificacion',tipo => 'DATE',id => '14',add => 'S', edit => 'S', valor =>$this->hoy, key => 'N') ,
            array( campo => 'apago',tipo => 'VARCHAR2',id => '15',add => 'N', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'fecha_pago',tipo => 'DATE',id => '16',add => 'N', edit => 'S', valor => '-', key => 'N')
        );
        
       
        
        $this->id = 'id_ren_tramite';
         
        $this->tabla 	  	     = 'rentas.ren_tramites';
        
        $this->secuencia 	     = 'rentas.ren_tramites_id_ren_tramite_seq';
        
 
    }
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function div_resultado($accion,$id,$estado,$tipo){
        //inicializamos la clase para conectarnos a la bd
        
        

        
        if ($tipo == 0){
            
            echo '<script>accion('. $id. ','. "'".$accion."'," ."'".$estado."'" .')</script>';
            
            if ($accion == 'editar')
                $resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>EDITAR REGISTRO TRANSACCION ['.$id.']</b>';
           
           if ($accion == 'del')
                $resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ELIMINAR REGISTRO TRANSACCION ['.$id.']</b>';
                    
        }
        
        if ($tipo == 1){
            
            echo '<script>accion('. $id. ','. "'".$accion."'," ."'".$estado."'" .')</script>';
            
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
            array( campo => 'id_ren_tramite',   valor => $id,  filtro => 'S',   visor => 'S'),
            array( campo => 'id_par_ciu',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'id_rubro',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'estado',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'fecha_inicio',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'fecha_cierre',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'detalle',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'resolucion',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'direccion',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'multa',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'base',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'idprov',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'razon',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'correo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'apago',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'contacto',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'comprobante',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'fecha_pago',valor => '-',filtro => 'N', visor => 'S')
        );
       
 
        
      $this->bd->JqueryArrayVisor('rentas.view_ren_tramite',$qquery );
        
  
       $result = $this->div_resultado('editar',$id,'',0);
        
        echo $result;
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
            
            $this->edicion($id) ;
            
        }
        // ------------------  eliminar
        if ($action == 'del'){
            
           $this->eliminar();
            
        }
        
    }
    //--------------------------------------------------------------------------------
    //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
    //--------------------------------------------------------------------------------
    function agregar( ){
        
        $idprov           = trim($_POST["idprov"]);

        $id_par_ciu       = $_POST["id_par_ciu"];
             


        if ( $id_par_ciu > 0 ){
            

        }else{

            $x = $this->bd->query_array('par_ciu',
                '*',
                'idprov='.$this->bd->sqlvalue_inyeccion(trim($idprov),true)
                );
            
            $this->ATabla[1][valor] =  $x['id_par_ciu'];
        }
   
        
        $id_ren_tramite         = $this->bd->_InsertSQL($this->tabla,$this->ATabla, $this->secuencia );
        
        $id_rubro               = $_POST["id_rubro"];

        
        $this->agregar_variables( $id_ren_tramite , $id_rubro) ;
        
        $this->editar_ciu();
 
        $result = $this->div_resultado('editar',$id_ren_tramite,'digitado',1);
        
         
        echo $result;
        
        
    }
//-------------------------------------------    
    function agregar_variables( $id_ren_tramite , $id_rubro){
        
 
        $sql_det1 = 'SELECT id_rubro_var, nombre_variable,  variable,
                            imprime, tipo, lista,id_catalogo,variable_formula
                    FROM rentas.ren_rubros_var
                    where id_rubro = '.$this->bd->sqlvalue_inyeccion($id_rubro,true) ;
        
        $stmt1 = $this->bd->ejecutar($sql_det1);
        
        //-----------------------------------------------------------------
       
        while ($xx=$this->bd->obtener_fila($stmt1)){
            
          //  $objeto  = trim($xx['nombre_variable']).'_'.$xx['id_rubro_var'].'_'.$id_rubro ;
            
            $objeto   = trim($xx['variable'])  ;
              
            $valor    = $_POST[$objeto];
            
            $this->ATabla_parametros[4][valor]  =  trim($valor);
             
            $this->ATabla_parametros[1][valor]  =  $id_ren_tramite;
            $this->ATabla_parametros[2][valor]  =  $xx['id_rubro_var'];
            $this->ATabla_parametros[3][valor]  =  $id_rubro;
            $this->ATabla_parametros[4][valor]  =  trim($valor);
            
            
            $this->bd->_InsertSQL('rentas.ren_tramites_var',$this->ATabla_parametros, 'rentas.ren_tramites_var_id_ren_tramite_var_seq');
                
         
         }
}
//-------------------------------------------
function editar_variables( $id_ren_tramite, $id_rubro ){
    
 
        $id_ren_tramite_var = 0;

 
        $sql_det1 = 'SELECT id_rubro_var, nombre_variable,  variable,
        imprime, tipo, lista,id_catalogo,variable_formula
        FROM rentas.ren_rubros_var
        where id_rubro = '.$this->bd->sqlvalue_inyeccion($id_rubro,true) .' order by id_rubro_var';

        $stmt11 = $this->bd->ejecutar($sql_det1);
    
     
       while ($xx=$this->bd->obtener_fila($stmt11)){
    
        $objeto                   = trim($xx['variable'])  ;

        $bandera                  = 0;

        $valor                    = $_POST[$objeto];

        $xy                       = $this->bd->query_array('rentas.view_ren_tramite_var',   
                                                            '*',                  
                                                            'id_ren_tramite='.$this->bd->sqlvalue_inyeccion($id_ren_tramite,true) . ' and  
                                                            id_rubro_var='.$this->bd->sqlvalue_inyeccion($xx['id_rubro_var'],true)
        );

          
        $id_ren_tramite_var       = $xy['id_ren_tramite_var'];


        if ( $id_ren_tramite_var  > 0 ){
                 $bandera = 1;
         }

         if ( !empty($id_ren_tramite_var)){
                 $bandera = 1;
         }



        if ( $bandera  == 1 ){
                     
                    $this->ATabla_parametros[4][valor]  =  trim($valor);
                    
                    $this->bd->_UpdateSQL('rentas.ren_tramites_var',$this->ATabla_parametros,$id_ren_tramite_var );
         }else{

 
            $this->ATabla_parametros[4][valor]  =  trim($valor);
            $this->ATabla_parametros[1][valor]  =  $id_ren_tramite;
            $this->ATabla_parametros[2][valor]  =  $xx['id_rubro_var'];
            $this->ATabla_parametros[3][valor]  =  $id_rubro;
            $this->ATabla_parametros[4][valor]  =  trim($valor);
             
            $this->bd->_InsertSQL('rentas.ren_tramites_var',$this->ATabla_parametros, 'rentas.ren_tramites_var_id_ren_tramite_var_seq');

        }
    }
        
 }
   //------------------------------
    function editar_ciu( ){
        
        $direccion              = $_POST["direccion"];
        $correo                 = $_POST["correo"];
        $id_par_ciu             = $_POST["id_par_ciu"];
        $contacto             = $_POST["contacto"];

        $razon                  = $_POST["razon"];
        
 
        
        $UpdateQuery = array(
            array( campo => 'id_par_ciu',     valor => $id_par_ciu ,  filtro => 'S'),
            array( campo => 'direccion',      valor => trim($direccion) ,  filtro => 'N'),
            array( campo => 'razon',          valor => trim($razon) ,  filtro => 'N'),
            array( campo => 'correo',         valor => trim($correo),  filtro => 'N')  ,
            array( campo => 'contacto',         valor => trim($contacto),  filtro => 'N')  
        );
        
        
        $this->bd->JqueryUpdateSQL('par_ciu',$UpdateQuery);
        
        
}
    //--------------------------------------------------------------------------------
    //--- edicion de registros
    //--------------------------------------------------------------------------------
function edicion( $id_ren_tramite ){
 
        $estado                = $_POST['estado'];
        $id_rubro              = $_POST["id_rubro"];
        $idprov                = trim($_POST["idprov"]);
        $id_par_ciu            = $_POST["id_par_ciu"];
        

        if ( $id_par_ciu > 0 ){
            
        }else{
            $x = $this->bd->query_array('par_ciu',
                '*',
                'idprov='.$this->bd->sqlvalue_inyeccion(trim($idprov),true)
                );
            
            $this->ATabla[1][valor] =  $x['id_par_ciu'];
        }
        

        $xxx = $this->bd->query_array('rentas.ren_movimiento ',
        'max(fechap) as fechap,fecha',
        'id_tramite='.$this->bd->sqlvalue_inyeccion( $id_ren_tramite ,true). " and estado = 'P' "
        );

        $periodo_pago =  $xxx['fechap'];
        $xq = explode('-', $periodo_pago);
 
        $this->ATabla[15][valor] =  $xq[0];
        $this->ATabla[16][valor] =  $xxx['fechap'];

        $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id_ren_tramite);
      
        
         

        $this->editar_ciu();
        
 
      $this->editar_variables( $id_ren_tramite , $id_rubro);

       
     
        
         
        $result = $this->div_resultado('editar',$id_ren_tramite,$estado,1);
        
        echo $result;
        
    }
    
    //--------------------------------------------------------------------------------
    //--- eliminar de registros
    //--------------------------------------------------------------------------------
    function eliminar($id ){
        
        
 
         
        $x = $this->bd->query_array('rentas.ren_tramites',   // TABLA
            'estado',                        // CAMPOS
            'id_ren_tramite='.$this->bd->sqlvalue_inyeccion($id,true) // CONDICION
            );
        
        $estado =  $x["estado"];
        
        if (trim($estado) == 'digitado') {
            
                $sql = 'delete from rentas.ren_tramites
                         where id_ren_tramite='.$this->bd->sqlvalue_inyeccion($id, true);
                
                $this->bd->ejecutar($sql);
 
 
        } 
 
        
    }
    function anula_cierra($id,$novedad){
        
        
 
         
        $x = $this->bd->query_array('rentas.ren_tramites',   // TABLA
            'estado',                        // CAMPOS
            'id_ren_tramite='.$this->bd->sqlvalue_inyeccion($id,true) // CONDICION
            );
        
        $estado =  $x["estado"];
        
        if (trim($estado) == 'digitado') {
            
            echo ' ESTADO NO VALIDO';
 
 
        }else {
            

            $long = strlen($novedad);

            if (   $long  > 10 )  {
                    $sql = 'update rentas.ren_tramites
                            set estado = '.$this->bd->sqlvalue_inyeccion('cierre', true).',
                            detalle_cierre  = '.$this->bd->sqlvalue_inyeccion($novedad, true).',
                            fecha_cierre= '.$this->bd->sqlvalue_inyeccion( $this->hoy, true).'
                            where id_ren_tramite='.$this->bd->sqlvalue_inyeccion($id, true);
                    
                    
                    $this->bd->ejecutar($sql);
                    
                    
                    echo ' CIERRE/ANULACION DE TRANSACCION...'; 

             }else  {

                echo ' INGRESE LA NOVEDAD Y/O MOTIVO CIERRE ...'; 

            }
            
        }
    
 
        
    }
    //---------------------------------------
 
    function aprobacion($id){
        
        
        
   
        $sql = " UPDATE rentas.ren_tramites
						   SET 	estado=".$this->bd->sqlvalue_inyeccion('aprobado', true).",
                                fecha_aprobacion= ".$this->bd->sqlvalue_inyeccion( $this->hoy, true)."
						 WHERE id_ren_tramite=".$this->bd->sqlvalue_inyeccion($id, true);
        
        $this->bd->ejecutar($sql);
        
 
        $result =  $this->div_resultado('aprobado',$id, 'aprobado','0') ;
 
        $result = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO ['.$id.']</b>';
         
         echo $result;
        
    }
    //------------------
    function K_comprobante($tipo,$anio ){
	  

        $x = $this->bd->query_array('rentas.ren_rubros',   // TABLA
        'sigla',                        // CAMPOS
        'id_rubro='.$this->bd->sqlvalue_inyeccion( $tipo    ,true) // CONDICION
       );

       $sigla = $x['sigla'];

        $sql = "SELECT count(comprobante) as secuencia
                      FROM rentas.view_ren_tramite
                      where  anio = ".$this->bd->sqlvalue_inyeccion($anio ,true)." and
                             id_rubro =".$this->bd->sqlvalue_inyeccion($tipo ,true)." and
                             comprobante is not null";
            
            $parametros 			= $this->bd->ejecutar($sql);
            $secuencia 				= $this->bd->obtener_array($parametros);
            
             
            $contador = $secuencia['secuencia'] + 1;
            
            $input = $sigla.'-'. str_pad($contador, 6, "0", STR_PAD_LEFT).'-'.$anio ;
            
            return $input ;
        }
    //--------------------------------------------
    function envio($id,$comprobante,$frubro, $estado){
 
          $lista =  strlen($comprobante);
          $anio   =  date("Y");

          if ( $lista > 5 ){
            $sql = " UPDATE rentas.ren_tramites
            SET 	estado=".$this->bd->sqlvalue_inyeccion('enviado', true)."
            WHERE id_ren_tramite=".$this->bd->sqlvalue_inyeccion($id, true);

            $this->bd->ejecutar($sql);

          }else{

            $comprobante_nuevo = $this->K_comprobante($frubro,$anio );

            if ( $estado == 'digitado'){

                    $sql = " UPDATE rentas.ren_tramites
                    SET 	estado=".$this->bd->sqlvalue_inyeccion('enviado', true).",
                            comprobante=".$this->bd->sqlvalue_inyeccion( $comprobante_nuevo, true)."
                WHERE id_ren_tramite=".$this->bd->sqlvalue_inyeccion($id, true);

                $this->bd->ejecutar($sql);

             }else{

                $sql = " UPDATE rentas.ren_tramites
                SET 	comprobante=".$this->bd->sqlvalue_inyeccion( $comprobante_nuevo, true)."
                      WHERE id_ren_tramite=".$this->bd->sqlvalue_inyeccion($id, true);

                      $this->bd->ejecutar($sql);
            }

          echo '<script type="text/javascript">';
          echo  '  $("#comprobante").val('."'". $comprobante_nuevo."'".'); ';
          echo '</script>';

          }
         
        

         
            
           
         
        
            $result = $this->div_resultado('enviado',$id,'enviado',1);
        
        
        echo $result;
        
        
    }

    function envio_seg($id,$datosi){
 
            
        $sql = " UPDATE rentas.ren_tramites
                       SET 	estado=".$this->bd->sqlvalue_inyeccion('aprobado', true)."
                     WHERE id_ren_tramite=".$this->bd->sqlvalue_inyeccion($id, true);
        
        $this->bd->ejecutar($sql);


        $sql = " UPDATE rentas.ren_tramite_seg
        SET 	leido=".$this->bd->sqlvalue_inyeccion('S', true)."
             WHERE id_tramite_seg=".$this->bd->sqlvalue_inyeccion($datosi, true);

          $this->bd->ejecutar($sql);
     
    
        $result = $this->div_resultado('aprobado',$id,'aprobado',1).' Leido';
    
    
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
            
            $accion         = trim($_GET['accion']);
            
            $id             = $_GET['id'];

            $dato_si        = $_GET['dato_si'];
          
          
            
            
            if ( $accion == 'aprobado'){
                
                $gestion->aprobacion($id);
                
            }elseif ( $accion == 'envio'){
                
	           $comprobante         = trim($_GET['comprobante']);
               $frubro              = $_GET['frubro'];
               $estado              = trim($_GET['estado']);

                $gestion->envio($id,$comprobante,$frubro, $estado);
                
            }elseif ( $accion == 'envio_seg'){
                
                $gestion->envio_seg($id,  $dato_si);
                
            }elseif ( $accion == 'del'){
                
                $gestion->eliminar($id);
                
           
            }elseif ( $accion == 'anula'){
                    
                $novedad        = trim($_GET['novedad']);
                
                $gestion->anula_cierra($id,$novedad);
                
            }
              else{
                 
                 $gestion->consultaId($accion,$id);
                 
            }
           
                
            
        }
        
        //------ grud de datos insercion
        if (isset($_POST["action"]))	{
            
            $action 	    = $_POST["action"];
            
            $id 			= $_POST["id_ren_tramite"];
            
            $gestion->xcrud(trim($action),$id );
            
        }



?>
 
  
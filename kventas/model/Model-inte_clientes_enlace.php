<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/


require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
    
    //creamos la variable donde se instanciar la clase "mysql"
    
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
        $this->hoy 	     =  date("Y-m-d");    	
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
        $this->tabla 	  	  = 'ven_cliente';
        
        $this->secuencia 	     = '-';
        
        $this->ATabla = array(  
            array( campo => 'idvencliente',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
            array( campo => 'idprov',tipo => 'VARCHAR2',id => '1',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'razon',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'direccion',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'telefono',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'correo',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'movil',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'contacto',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'estado',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'provincia',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'canton',tipo => 'VARCHAR2',id => '10',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'web',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'identificacion',tipo => 'VARCHAR2',id => '12',add => 'N', edit => 'S', valor => '-', key => 'N')
         );
    }
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function div_resultado($accion,$id,$tipo){
        //inicializamos la clase para conectarnos a la bd
        
        
       
        
        if ($tipo == 0){
            
            if ($accion == 'editar')
                $resultado = '<img src="../../kimages/kedit.png"/>&nbsp;<b>Editar registro?</b><br>';
                if ($accion == 'del')
                    $resultado = '<img src="../kimages/kdel.png"/>&nbsp;<b>Eliminar registro?</b><br>';
                    
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
    function consultaId( $id,$idvengestion ){
        
        
        
        $qquery = array(
            array( campo => 'idvencliente',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'idprov',   valor => $id,  filtro => 'S',   visor => 'N'),
             array( campo => 'direccion',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'telefono',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'correo',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'razon',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'movil',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'contacto',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'provincia',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'canton',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'web',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'actualizado',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'identificacion',   valor => '-',  filtro => 'N',   visor => 'S')
        );
        
        
        $datos = $this->bd->JqueryArray('ven_cliente',$qquery );
        
        if ( $datos['actualizado'] == 'N'){
            
            $Aestado = $this->bd->query_array('ven_cliente_seg',
                                                 'estado', 
                                                 'idvengestion='.$this->bd->sqlvalue_inyeccion($key,true)
                                                );
            
            $identificacion = trim($datos['identificacion']);
            
            if ($Aestado['estado']  <> 12){
                
                if ( $this->_busca_ruc( $identificacion) > 0 ){
                    
                    $dato = '<b>Cliente Ya Ingresado '.$identificacion.'</b>';
                    
                    $sqlEdit = "update ven_cliente
                                                  set proceso  =".$this->bd->sqlvalue_inyeccion( 'cliente',true).",
                                                      actualizado  =".$this->bd->sqlvalue_inyeccion( 'S',true)."
                                                where idprov= ".$this->bd->sqlvalue_inyeccion($id,true)  ;
                    
                    $this->bd->ejecutar($sqlEdit);
                
                }else{
                          
                            $longitud = strlen($identificacion); 
                            
                            if ( $longitud >= 10 ){
                                
                                $this->agregar($datos,$identificacion,$idvengestion);
                                
                                $sqlEdit = "update ven_cliente
                                                  set proceso  =".$this->bd->sqlvalue_inyeccion( 'cliente',true).",
                                                      actualizado  =".$this->bd->sqlvalue_inyeccion( 'S',true)."
                                                where idprov= ".$this->bd->sqlvalue_inyeccion($id,true)  ;
                                
                                $this->bd->ejecutar($sqlEdit);
                                
                                $dato = '<b>Cliente Ingresado  '.$identificacion.'</b>';
                                
                            }else{
                                $dato = '<b>Actualice la informacion del Cliente '.$identificacion.'!!! </b>';
                            }
                }
                                
 
            }
 
        }else{
            $dato = '<b>Cliente  ya Ingresado '.$identificacion.'</b>';
        }
        
        
        return  $dato;
        
    } 
    //--------------------
    function _busca_ruc( $id){
        
        
        $longi = strlen(trim($id));
        
     
        $AResultado = $this->bd->query_array(
                'par_ciu',
                'count(*) as nn',
                'idprov='.$this->bd->sqlvalue_inyeccion(trim($id),true)
                );
            
            return  $AResultado['nn'];
       
        
    }
    
 
    //--------------------------------------------------------------------------------
    //--- edicion de registros
    //--------------------------------------------------------------------------------
    function agregar($datos,$identificacion,$idvengestion){
   
 
 
 
        $ATabla = array(
            array( campo => 'idprov',   tipo => 'VARCHAR2',   id => '0',  add => 'S',   edit => 'N',   valor =>$identificacion,   filtro => 'N',   key => 'S'),
            array( campo => 'razon',   tipo => 'VARCHAR2',   id => '1',  add => 'S',   edit => 'N',   valor =>$datos['razon'],   filtro => 'N',   key => 'N'),
            array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '2',  add => 'S',   edit => 'N',   valor => 'CRM',   filtro => 'N',   key => 'N'),
            array( campo => 'direccion',   tipo => 'VARCHAR2',   id => '3',  add => 'S',   edit => 'S',   valor => $datos['direccion'],   filtro => 'N',   key => 'N'),
            array( campo => 'telefono',   tipo => 'VARCHAR2',   id => '4',  add => 'S',   edit => 'S',   valor => $datos['telefono'],   filtro => 'N',   key => 'N'),
            array( campo => 'correo',   tipo => 'VARCHAR2',   id => '5',  add => 'S',   edit => 'S',   valor => $datos['correo'],   filtro => 'N',   key => 'N'),
            array( campo => 'movil',   tipo => 'VARCHAR2',   id => '6',  add => 'S',   edit => 'S',   valor => $datos['movil'],   filtro => 'N',   key => 'N'),
            array( campo => 'idciudad',   tipo => 'NUMBER',   id => '7',  add => 'S',   edit => 'S',   valor => '1',   filtro => 'N',   key => 'N'),
            array( campo => 'contacto',   tipo => 'VARCHAR2',   id => '8',  add => 'S',   edit => 'S',   valor => $datos['contacto'],   filtro => 'N',   key => 'N'),
            array( campo => 'ctelefono',   tipo => 'VARCHAR2',   id => '9',  add => 'S',   edit => 'S',   valor => $datos['telefono'],   filtro => 'N',   key => 'N'),
            array( campo => 'ccorreo',   tipo => 'VARCHAR2',   id => '10',  add => 'S',   edit => 'S',   valor => $datos['correo'],   filtro => 'N',   key => 'N'),
            array( campo => 'estado',   tipo => 'VARCHAR2',   id => '11',  add => 'S',   edit => 'S',   valor => 'S',   filtro => 'N',   key => 'N'),
            array( campo => 'tpidprov',   tipo => 'VARCHAR2',   id => '12',  add => 'S',   edit => 'N',   valor => '01',   filtro => 'N',   key => 'N'),
            array( campo => 'modulo',   tipo => 'VARCHAR2',   id => '13',  add => 'S',   edit => 'S',   valor => 'p',   filtro => 'N',   key => 'N'),
            array( campo => 'naturaleza',   tipo => 'VARCHAR2',   id => '14',  add => 'S',   edit => 'S',   valor => 'NN',   filtro => 'N',   key => 'N'),
            array( campo => 'sesion',   tipo => 'VARCHAR2',   id => '15',  add => 'S',   edit => 'N',   valor => $this->sesion,   filtro => 'N',   key => 'N'),
            array( campo => 'creacion',   tipo => 'DATE',   id => '16',  add => 'S',   edit => 'N',   valor =>  $this->hoy ,   filtro => 'N',   key => 'N'),
            array( campo => 'modificacion',   tipo => 'DATE',   id => '17',  add => 'S',   edit => 'S',   valor =>  $this->hoy ,   filtro => 'N',   key => 'N'),
            array( campo => 'msesion',   tipo => 'VARCHAR2',   id => '18',  add => 'S',   edit => 'S',   valor => $this->sesion,   filtro => 'N',   key => 'N'),
            array( campo => 'cmovil',   tipo => 'VARCHAR2',   id => '19',  add => 'S',   edit => 'S',   valor => $datos['movil'],   filtro => 'N',   key => 'N') ,
            array( campo => 'nacimiento',   tipo => 'DATE',   id => '20',  add => 'S',   edit => 'S',   valor =>$this->hoy,   filtro => 'N',   key => 'N')
        );
        
        $tabla 	  		    = 'par_ciu';
         
        $this->bd->_InsertSQL($tabla,$ATabla,$identificacion);
        
         
        return $identificacion;
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
if (isset($_GET['idcliente']))	{
    
    
    
    $id              = $_GET['idcliente'];
    
    $idvengestion    = $_GET['idvengestion'];
    
    $mensaje_ciu =   $gestion->consultaId($id,$idvengestion);
    
    echo $mensaje_ciu;
}
 


?>
 
  
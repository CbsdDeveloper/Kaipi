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
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function proceso( ){
        //inicializamos la clase para conectarnos a la bd
        
        $this->obj     = 	new objects;
        $this->bd	   =	new Db ;
        
        $this->ruc       =     $_SESSION['ruc_registro'];
        
        $this->sesion 	 =  $_SESSION['email'];
        
        $this->hoy 	     =  date("Y-m-d");    	//$this->hoy 	     =  $this->bd->hoy();
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
        
        $this->tabla 	  	  = 'nom_rol_horas';
        
        $this->secuencia 	     = 'nom_rol_horas_id_rolhora_seq';
        
        $this->ATabla = array(
            array( campo => 'id_rolhora',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
            array( campo => 'id_rol',tipo => 'NUMBER',id => '1',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'id_periodo',tipo => 'NUMBER',id => '2',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'registro',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'N', valor =>  $this->ruc, key => 'N'),
            array( campo => 'anio',tipo => 'NUMBER',id => '4',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'mes',tipo => 'NUMBER',id => '5',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'sueldo',tipo => 'NUMBER',id => '6',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'id_departamento',tipo => 'NUMBER',id => '7',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'id_cargo',tipo => 'NUMBER',id => '8',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'regimen',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'fecha',tipo => 'DATE',id => '10',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'idprov',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'dias',tipo => 'NUMBER',id => '12',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'horasextras',tipo => 'NUMBER',id => '13',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'horassuple',tipo => 'NUMBER',id => '14',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'atrasos',tipo => 'NUMBER',id => '15',add => 'S', edit => 'S', valor => '-', key => 'N')
        );
        
        
    }
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function Empresa(){
        
        
        $sql = 'SELECT   ruc_empresa, razon, contacto, correo,  detalle,
                fecha_inicio,   fecha_final, quedan_dias
                FROM doc.view_empresa'  ;
        
        
        
        echo ' <table id="table_tipo" class="table table-bordered" cellspacing="0" width="100%" style="font-size: 11px"  >
			<thead>
			 <tr>
				<th width="10%">Identificacion</th>
				<th width="35%">Empresa</th>
				<th width="20%">Contacto</th>
				<th width="10%">Email</th>
                <th width="15%">ingreso</th>
                <th width="10%">Falta(dias)</th>
				</tr>
			</thead>';
        
        
        $stmt = $this->bd->ejecutar($sql);
        
        while ($x=$this->bd->obtener_fila($stmt)){
            
            echo ' <tr>
				<td>'.$x['ruc_empresa'].'</td>
				<td>'.$x['razon'].'</td>
 				<td>'.$x['contacto'].'</td>
				<td>'.$x['correo'].'</td>
                <td>'.$x['fecha_inicio'].'</td>
                <td>'.$x['quedan_dias'].'</td>
                </tr>';
        }
        
        echo	'</table>';
        
    }
    
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function editar($idhora,$dia,$extra,$suple,$atraso){
        //inicializamos la clase para conectarnos a la bd
        
        $User = $this->bd->query_array('view_nomina_rol',
            'id_departamento, id_cargo, responsable, regimen,sueldo,fecha',
            'idprov='.$this->bd->sqlvalue_inyeccion($idprov,true)
            );
        
        $this->ATabla[1][valor] =  $id_rol	 ;
        $this->ATabla[2][valor] =  $id_periodo	 ;
        $this->ATabla[4][valor] =  $anio	 ;
        $this->ATabla[5][valor] =  $mes	 ;
        $this->ATabla[11][valor] =  $idprov	 ;
        $this->ATabla[6][valor] =   $User['sueldo']	 ;
        $this->ATabla[7][valor] =  $User['id_departamento']	 ;
        $this->ATabla[8][valor] =  $User['id_cargo']	 ;
        $this->ATabla[9][valor] =  $User['regimen']	 ;
        $this->ATabla[10][valor] = $User['fecha']	 ;
        $this->ATabla[12][valor] =  $dia	 ;
        $this->ATabla[13][valor] =  $extra	 ;
        $this->ATabla[14][valor] =  $suple	 ;
        $this->ATabla[15][valor] =  $atraso	 ;
    
            
        
        $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$idhora);
        
        
        $ViewHora = 'OK';
        
        echo $ViewHora;
        
    }
    
  
    //-------------------------------------
    function agregar( $id_periodo,$id_rol,$anio,$mes,$idprov,$dia,$extra,$suple,$atraso ){
        
 
        $User = $this->bd->query_array('view_nomina_rol',
                                        'id_departamento, id_cargo, responsable, regimen,sueldo,fecha', 
                                        'idprov='.$this->bd->sqlvalue_inyeccion($idprov,true)
                                        );
        
       $this->ATabla[1][valor] =  $id_rol	 ;
       $this->ATabla[2][valor] =  $id_periodo	 ;
       $this->ATabla[4][valor] =  $anio	 ;
       $this->ATabla[5][valor] =  $mes	 ;
       $this->ATabla[11][valor] =  $idprov	 ;
       $this->ATabla[6][valor] =   $User['sueldo']	 ;
       $this->ATabla[7][valor] =  $User['id_departamento']	 ;
       $this->ATabla[8][valor] =  $User['id_cargo']	 ;
       $this->ATabla[9][valor] =  $User['regimen']	 ;
       $this->ATabla[10][valor] = $User['fecha']	 ;
       $this->ATabla[12][valor] =  $dia	 ;
       $this->ATabla[13][valor] =  $extra	 ;
       $this->ATabla[14][valor] =  $suple	 ;
       $this->ATabla[15][valor] =  $atraso	 ;
    
     
           
      
        $id = $this->bd->_InsertSQL($this->tabla,$this->ATabla,$this->secuencia);
        
        echo '<script type="text/javascript">';
      
        echo  "$('#id".$idprov."').val(".$id.");";
        
        echo '</script>';
        
        
        $ViewHora = 'OK';
        
        echo $ViewHora;
        
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
if (isset($_POST['accion']))	{
    
    
    $accion = $_POST['accion'];
    
    $id_periodo = $_POST['id_periodo'];
    $id_rol = $_POST['id_rol'];
    $anio = $_POST['anio'];
    $mes = $_POST['mes'];
    $idprov = $_POST['idprov'];
    $dia = $_POST['dia'];
    $extra = $_POST['extra'];
    $suple = $_POST['suple'];
    $atraso = $_POST['atraso'];
    $idhora= $_POST['idhora'];
    
   
    if ( $accion == 'edit'){
        if ( $dia > 0 ) {
            if ($idhora > 0){
                $gestion->editar($idhora,$dia,$extra,$suple,$atraso);
            }else{
                $gestion->agregar($id_periodo,$id_rol,$anio,$mes,$idprov,$dia,$extra,$suple,$atraso);
            }
           
        }
       
        
    }
    
 
  
}





?>
 
  
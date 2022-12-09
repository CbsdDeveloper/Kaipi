<?php
session_start( );
require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

class proceso{

    private $obj;
    private $bd;
    private $saldos;
    
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
        
        $this->sesion 	 =  trim($_SESSION['email']);
        
        $this->hoy 	     =  $this->bd->hoy();
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
        $this->ATabla = array(
            array( campo => 'id_redep',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
            array( campo => 'registro',tipo => 'VARCHAR2',id => '1',add => 'S', edit => 'N', valor => $this->ruc, key => 'N'),
            array( campo => 'sesion',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor =>$this->sesion, key => 'N'),
            array( campo => 'anio',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'bengalpg',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => 'NO', key => 'N'),
            array( campo => 'enfcatastro',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => 'NO', key => 'N'),
            array( campo => 'tipidret',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => 'C', key => 'N'),
            array( campo => 'idret',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'apellidotrab',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'nombretrab',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'estab',tipo => 'VARCHAR2',id => '10',add => 'S', edit => 'S', valor => '001', key => 'N'),
            array( campo => 'residenciatrab',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'S', valor => '01', key => 'N'),
            array( campo => 'paisresidencia',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'S', valor => '593', key => 'N'),
            array( campo => 'aplicaconvenio',tipo => 'VARCHAR2',id => '13',add => 'S', edit => 'S', valor => 'NA', key => 'N'),
            array( campo => 'tipotrabajdiscap',tipo => 'VARCHAR2',id => '14',add => 'S', edit => 'S', valor => '01', key => 'N'),
            array( campo => 'porcentajediscap',tipo => 'NUMBER',id => '15',add => 'S', edit => 'S', valor => '0', key => 'N'),
            array( campo => 'tipiddiscap',tipo => 'VARCHAR2',id => '16',add => 'S', edit => 'S', valor => 'N', key => 'N'),
            array( campo => 'iddiscap',tipo => 'VARCHAR2',id => '17',add => 'S', edit => 'S', valor => '999', key => 'N'),
            array( campo => 'suelsal',tipo => 'NUMBER',id => '18',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'sobsuelcomremu',tipo => 'NUMBER',id => '19',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'partutil',tipo => 'NUMBER',id => '20',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'intgrabgen',tipo => 'NUMBER',id => '21',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'imprentempl',tipo => 'NUMBER',id => '22',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'decimter',tipo => 'NUMBER',id => '23',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'decimcuar',tipo => 'NUMBER',id => '24',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'fondoreserva',tipo => 'NUMBER',id => '25',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'salariodigno',tipo => 'NUMBER',id => '26',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'otrosingrengrav',tipo => 'NUMBER',id => '27',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'inggravconesteempl',tipo => 'NUMBER',id => '28',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'sissalnet',tipo => 'VARCHAR2',id => '29',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'apoperiess',tipo => 'NUMBER',id => '30',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'aporperiessconotrosempls',tipo => 'NUMBER',id => '31',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'deducvivienda',tipo => 'NUMBER',id => '32',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'deducsalud',tipo => 'NUMBER',id => '33',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'deduceducartcult',tipo => 'NUMBER',id => '34',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'deducaliement',tipo => 'NUMBER',id => '35',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'deducvestim',tipo => 'NUMBER',id => '36',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'exodiscap',tipo => 'NUMBER',id => '37',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'exotered',tipo => 'NUMBER',id => '38',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'basimp',tipo => 'NUMBER',id => '39',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'imprentcaus',tipo => 'NUMBER',id => '40',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'valretasuotrosempls',tipo => 'NUMBER',id => '41',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'valimpasuesteempl',tipo => 'NUMBER',id => '42',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'valret',tipo => 'NUMBER',id => '43',add => 'S', edit => 'S', valor => '-', key => 'N'),
        );
      
    
        $this->tabla 	  	  = 'nom_redep';
        
        $this->secuencia 	     = 'nom_redep_id_redep_seq';
        
    }
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function div_resultado($accion,$id,$tipo,$estado){
         
        return  $this->bd->resultadoCRUD('ACTUALIZACION',$accion,$id,$tipo);
        
    }
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function div_limpiar( ){
        //inicializamos la clase para conectarnos a la bd
        
        $resultado = 'REGISTRO ELIMINADO ';
        
        echo '<script type="text/javascript">';
        
        echo  'LimpiarPantalla();';
        
        echo '</script>';
        
        return $resultado;
        
    }
    //--- busqueda de por codigo para llenar los datos
    //--------------------------------------------------------------------------------
    function consultaId($accion,$id ){
        
        $qqueryCompras = array(
            array( campo => 'id_redep',valor => $id,filtro => 'S', visor => 'S'),
            array( campo => 'anio',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'bengalpg',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'enfcatastro',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'tipidret',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'idret',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'apellidotrab',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'nombretrab',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'estab',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'residenciatrab',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'paisresidencia',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'aplicaconvenio',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'tipotrabajdiscap',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'porcentajediscap',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'tipiddiscap',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'iddiscap',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'suelsal',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'sobsuelcomremu',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'partutil',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'intgrabgen',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'imprentempl',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'decimter',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'decimcuar',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'fondoreserva',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'salariodigno',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'otrosingrengrav',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'inggravconesteempl',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'sissalnet',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'apoperiess',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'aporperiessconotrosempls',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'deducvivienda',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'deducsalud',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'deduceducartcult',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'deducaliement',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'deducvestim',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'exodiscap',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'exotered',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'basimp',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'imprentcaus',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'valretasuotrosempls',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'valimpasuesteempl',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'valret',valor => '-',filtro => 'N', visor => 'S')
        );
        
        $estado = '';
        
        $this->bd->JqueryArrayVisor('nom_redep',$qqueryCompras );
        
        $result =  $this->div_resultado($accion,$id,0,$estado);
        
        echo  $result;
    }
     //--------------------------------------------------------------------------------
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
        
    }
     //--------------------------------------------------------------------------------
     
    //----------------------------------------------------
    function agregar( ){
        
 
        $estado = '';
        
        $id = $this->bd->_InsertSQL($this->tabla,$this->ATabla,$this->secuencia);
        
 
        
        $result = $this->div_resultado('editar',$id,1,$estado);
        
        echo $result;
        
										        
    }
    //--------------------------------------------------------------------------------
    
    function proceso_tthh($anio){
        
        
        $sql_opcion = "SELECT    idprov
                        FROM view_rol_impresion
                        where  anio= ".$this->bd->sqlvalue_inyeccion($anio,true).'
                        group by idprov';
         
        
        $stmt = $this->bd->ejecutar($sql_opcion);
        
        $i = 1;
 
        while ($x=$this->bd->obtener_fila($stmt)){
 
            $idprov     = $x["idprov"] ;
            
            $y = $this->bd->query_array('nom_redep',   // TABLA
                'count(*) as nn',                        // CAMPOS
                'idret='.$this->bd->sqlvalue_inyeccion(trim($idprov),true). ' and 
                  anio ='.$this->bd->sqlvalue_inyeccion($anio,true)
                );
            
            if ($y["nn"] > 0 ) {
                
            }else {
                $this->agregar_persona($idprov,$anio );
                $i ++;
            }
                
        }
        
         
         
        $result = 'Registros procesados...'.$i.' verifique por favor la informacion';
        
        echo $result;
    }
   //--------------------
    function poner_ir( $accion,$idprov,$anio){
      
        
        $row_p = array();
        
        
        $sql_opcion = 'SELECT   coalesce(sum(ingreso),0) as ingreso,
                	     coalesce(sum(descuento),0) as descuento,
                         tipoformula
                FROM view_rol_impresion
                where anio= '.$this->bd->sqlvalue_inyeccion($anio,true).' and
                      idprov ='.$this->bd->sqlvalue_inyeccion(trim($idprov),true).'
                group by  tipoformula';
        
        
        $stmt11 = $this->bd->ejecutar($sql_opcion);
        
        $salario        =  '0.00';
        $sobsuelcomremu =  '0.00';
      
        $apoperiess =  '0.00';
        $imprentcaus =  '0.00';
        
        
        while ($row_p=$this->bd->obtener_fila($stmt11)){
            
            
            if ( trim($row_p['tipoformula']) == 'RS'  ){
                $salario =  $row_p['ingreso'];
            }
            
            if (trim($row_p['tipoformula']) == '-'  ){
                if (  $row_p['ingreso'] > 0  ){
                    $sobsuelcomremu =  $row_p['ingreso'];
                }else{
                    $sobsuelcomremu = '0.00';
                }
                
            }
            
          
            
            if ( trim($row_p['tipoformula']) == 'AP'  ){
                $apoperiess =  $row_p['descuento'];
                
            }
            
            if ( trim($row_p['tipoformula']) == 'RR'  ){
                $imprentcaus =  $row_p['descuento'];
                
            }
            
            
        }
        
        
 
        if ( $accion == '1' ){
            
            $y = $this->bd->query_array('nom_redep',
                ' coalesce(deducvivienda,0) as vivienda,
                coalesce(deducsalud,0) as salud ,
                coalesce(deduceducartcult,0) as educacion,
                coalesce(deducaliement,0) as alimentacion,
                coalesce(deducvestim,0) as vestimenta',
                'anio='.$this->bd->sqlvalue_inyeccion($anio,true). ' and 
                 idret='.$this->bd->sqlvalue_inyeccion(trim($idprov),true)
                );
            
        }else{
            
            $y = $this->bd->query_array('view_nomina_rol',
                ' nombre ,apellido,
            coalesce(vivienda,0) as vivienda,
            coalesce(salud,0) as salud ,
            coalesce(educacion,0) as educacion,
            coalesce(alimentacion,0) as alimentacion,
            coalesce(vestimenta,0) as vestimenta,
            discapacidad',
                'idprov='.$this->bd->sqlvalue_inyeccion(trim($idprov),true)
                );
        }
       
        
        
        $deducvivienda    = $y['vivienda'];
        $deducsalud       = $y['salud'];
        $deduceducartcult = $y['educacion'];
        $deducaliement    = $y['alimentacion'];
        $deducvestim      = $y['vestimenta'];
        
 
        $inggravconesteempl = $salario + $sobsuelcomremu;
        
        
        $descuentos = ( $deducvivienda+$deducsalud+$deduceducartcult+$deducaliement+$deducvestim+$apoperiess) ;
    
        // BASE
        $base  = $inggravconesteempl - $descuentos;
        
         
        $IR =  $this->_monto_impuesto_renta(  $base ,$anio  ) ;
        
        if (empty($imprentcaus)){
            $imprentcaus =  '0.00';
        }
        
        if ( $accion == '1' ){
            $imprentcaus = round($IR,2);
        } 
        
        $base = round($base,2);
   
        echo json_encode(
            array("a"=>$base,
                "b"=> $imprentcaus
            )
            );
        
         
    }
    //----------------------------------------------------
    function agregar_persona( $idprov,$anio){
         
       
        $row_p = array();
 
 
        $sql_opcion = 'SELECT   coalesce(sum(ingreso),0) as ingreso,
                	     coalesce(sum(descuento),0) as descuento, 
                         tipoformula 
                FROM view_rol_impresion
                where anio= '.$this->bd->sqlvalue_inyeccion($anio,true).' and 
                      idprov ='.$this->bd->sqlvalue_inyeccion(trim($idprov),true).'
                group by  tipoformula';
  
        
        $stmt11 = $this->bd->ejecutar($sql_opcion);
        
        $salario        =  '0.00';
        $sobsuelcomremu =  '0.00';
        $decimter  =  '0.00';
        $decimcuar  =  '0.00';
        $fondoreserva  =  '0.00';
        $apoperiess =  '0.00';
        $imprentcaus =  '0.00';
        
        
        while ($row_p=$this->bd->obtener_fila($stmt11)){
            

            if ( trim($row_p['tipoformula']) == 'RS'  ){
                $salario =  $row_p['ingreso'];
            }
            
            if (trim($row_p['tipoformula']) == '-'  ){
                if (  $row_p['ingreso'] > 0  ){
                    $sobsuelcomremu =  $row_p['ingreso'];
                }else{
                    $sobsuelcomremu = '0.00';
                }
               
            }
            
            if ( trim($row_p['tipoformula'])== 'DT'  ){
                $decimter =  $row_p['ingreso'];
                
            }
            
            if ( trim($row_p['tipoformula']) == 'DC'  ){
                $decimcuar =  $row_p['ingreso'];
                
            }
            
            if ( trim($row_p['tipoformula']) == 'FR'  ){
                $fondoreserva =  $row_p['ingreso'];
                
            }
            
            if ( trim($row_p['tipoformula']) == 'AP'  ){
                $apoperiess =  $row_p['descuento'];
                
            }
            
            if ( trim($row_p['tipoformula']) == 'RR'  ){
                $imprentcaus =  $row_p['descuento'];
                
            }
            
          
        }

        $y = $this->bd->query_array('view_nomina_rol',
            ' nombre ,apellido,
            coalesce(vivienda,0) as vivienda,
            coalesce(salud,0) as salud ,
            coalesce(educacion,0) as educacion,
            coalesce(alimentacion,0) as alimentacion,
            coalesce(vestimenta,0) as vestimenta,discapacidad',
            'idprov='.$this->bd->sqlvalue_inyeccion(trim($idprov),true)
            );
        
        
        $deducvivienda    = $y['vivienda'];
        $deducsalud       = $y['salud'];
        $deduceducartcult = $y['educacion'];
        $deducaliement    = $y['alimentacion'];
        $deducvestim      = $y['vestimenta'];
 
        if (empty($deducvivienda)){
            $deducvivienda =  '0.00';
        }
        if (empty($deducsalud)){
            $deducsalud =  '0.00';
        }
        if (empty($deduceducartcult)){
            $deduceducartcult =  '0.00';
        }
        if (empty($deduceducartcult)){
            $deduceducartcult =  '0.00';
        }
        if (empty($deducaliement)){
            $deducaliement =  '0.00';
        }
        if (empty($deducvestim)){
            $deducvestim =  '0.00';
        }
        
        $this->ATabla[32][valor]        =   $deducvivienda;
        $this->ATabla[33][valor]        =   $deducsalud;
        $this->ATabla[34][valor]        =   $deduceducartcult;
        $this->ATabla[35][valor]        =   $deducaliement;
        $this->ATabla[36][valor]        =   $deducvestim;
        
         
        $this->ATabla[3][valor]         =   $anio;
        $this->ATabla[7][valor]         =   $idprov;
        
        if (empty($y['apellido'])){
            $this->ATabla[8][valor]         =   'Actualizar';
        }else{
            $this->ATabla[8][valor]         =   $y['apellido'];
        }
     
        if (empty($y['nombre'])){
            $this->ATabla[9][valor]         =   'Actualizar';
        }else{
            $this->ATabla[9][valor]         =   $y['nombre'];
        }
        
      
        
        $this->ATabla[18][valor]        =   $salario;
        $this->ATabla[19][valor]        =   $sobsuelcomremu;
        
        $this->ATabla[23][valor]        =   $decimter;
        $this->ATabla[24][valor]        =   $decimcuar;
        $this->ATabla[25][valor]        =   $fondoreserva;
        
        $this->ATabla[29][valor]        =   '1';
        
        $this->ATabla[30][valor]        =   $apoperiess;
        
         
        $monto =  '0.00';
        $inggravconesteempl = $salario + $sobsuelcomremu;
        
        // BASE
        $base  = $inggravconesteempl - ( $deducvivienda+$deducsalud+$deduceducartcult+$deducaliement+$deducvestim+$apoperiess) ;
        $this->ATabla[39][valor]        =   $base;
        
        
        $IR =  $this->_monto_impuesto_renta(  $base ,$anio  ) ;
        
        if ( $IR == $imprentcaus ){
            
        }else{
            $imprentcaus = $IR;
        }
        
        if (empty($imprentcaus)){
            $imprentcaus =  '0.00';
        }
        
         
        
        $this->ATabla[40][valor]        =   $imprentcaus;
        
        $this->ATabla[20][valor]        =   $monto;
        $this->ATabla[21][valor]        =   $monto;
        $this->ATabla[22][valor]        =   $monto;
        $this->ATabla[26][valor]        =   $monto;
        $this->ATabla[27][valor]        =   $monto;
        $this->ATabla[28][valor]        =   $inggravconesteempl;
        $this->ATabla[31][valor]        =   $monto;
        $this->ATabla[37][valor]        =   $monto;
        $this->ATabla[38][valor]        =   $monto;
        
        
        $this->ATabla[41][valor]        =   $monto;
        $this->ATabla[42][valor]        =   $monto;
        $this->ATabla[43][valor]        =   $monto;
    
        
        
         
//        if ( $salario > 0  ){
           
             
            $this->bd->_InsertSQL($this->tabla,$this->ATabla,$this->secuencia);
            
  //      }
        
        $this->bd->libera_cursor($stmt11);
        
        unset($row_p); 
        unset($y);
        
        
         
 
        
    }
    //------------
    function _monto_impuesto_renta(  $base_imponible ,$anio  ){
        
        $renta = $this->bd->query_array('nom_imp_renta','anio, tipo, fracbasica, excehasta, impubasico, impuexcedente',
            'anio = '.$this->bd->sqlvalue_inyeccion($anio,true).'
            and ( '.$base_imponible.'  between fracbasica and excehasta )'
            );
        
        
        $excedente      = 0;
        $valor_obtenido = 0;
        $IR             = 0 ;
        
        $excedente      = $base_imponible - $renta['fracbasica'];
        
        $valor_obtenido = $excedente * ( $renta['impuexcedente'] / 100 );
        
        $IR = ( $valor_obtenido +  $renta['impubasico'] )      ;
        
        $valor_mensual = round($IR,2);
         
        
        echo 'Impuesto '.  $valor_mensual;
    }
    //--------------------------------------------------------------------------------
    function edicion($id){
        
        
        
       
 
        
        $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
                
 
        $estado = '';
        
        
        $result = $this->div_resultado('editar',$id,1,$estado);
        
        echo $result;
    }
    
    //--------------------------------------------------------------------------------
    //--- eliminar de registros
    //--------------------------------------------------------------------------------
    function eliminar($id ){
        
      
            $sql = 'delete from nom_redep  where id_redep='.$this->bd->sqlvalue_inyeccion($id, true);
            $this->bd->ejecutar($sql);
            
          
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
if (isset($_GET['anio']))	{
    
    $anio    		                = $_GET['anio'];
    $base_imponible            		= $_GET['base'];
    
    $anio = 2020;
    
    $gestion->_monto_impuesto_renta(  $base_imponible ,$anio  );
    
     
 
    }
  
     



?>
 
  
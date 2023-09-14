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
        
        $this->ruc       =  trim($_SESSION['ruc_registro']);
        
        $this->sesion 	 =  $_SESSION['email'];
        
        $this->hoy 	     =  $this->bd->hoy();
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
        
    }
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function _rdep( $anio ){
          
        $sql = "SELECT  *
             FROM nom_redep 
             WHERE anio=".$this->bd->sqlvalue_inyeccion($anio,true);
        
          $stmt = $this->bd->ejecutar($sql);
        
        return   $stmt;
        
    }
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function _empresa( $anio  ){
        
        $sql = "SELECT razon,felectronica,estab
				FROM web_registro
				where ruc_registro = ".$this->bd->sqlvalue_inyeccion(  $this->ruc,true);
        
        $resultado = $this->bd->ejecutar($sql);
        $datos     = $this->bd->obtener_array( $resultado);
      
        
        return $datos;
        
    }
    //--- busqueda de por codigo para llenar los datos
    //--------------------------------------------------------------------------------
    function consultaId($anio ){
        
        $stmt           = $this->_rdep($anio);
          
        print '<?xml version="1.0" encoding="ISO-8859-1" standalone="yes"?>';
        print '<rdep>';
        print '<numRuc>'.trim($this->ruc).'</numRuc>';
        print '<anio>'.trim($anio).'</anio>';
        print '<retRelDep>';
        while ($x=$this->bd->obtener_fila($stmt)){
            $nombre           = $this->bd->eliminar_simbolos(trim($x['nombretrab']));
            $apellido         = $this->bd->eliminar_simbolos(trim($x['apellidotrab']));
            
            $nombre = str_replace("ñ","n",$nombre);
            $nombre = str_replace("Ñ","N",$nombre);

            $apellido = str_replace("ñ","n",$apellido);
            $apellido = str_replace("Ñ","N",$apellido);

            $apellido = str_replace("Á","A",$apellido);
            $apellido = str_replace("Í","I",$apellido);
            $apellido = str_replace("Ó","O",$apellido);
            $apellido = str_replace("Ú","U",$apellido);
            $apellido = str_replace("É","E",$apellido);

            $nombre = str_replace("Á","A",$nombre);
            $nombre = str_replace("Í","I",$nombre);
            $nombre = str_replace("Ó","O",$nombre);
            $nombre = str_replace("Ú","U",$nombre);
            $nombre = str_replace("É","E",$nombre);

            

            print  '<datRetRelDep>';
            print  '<empleado>';
                    print  '<benGalpg>'.trim($x['bengalpg']).'</benGalpg>';
                    print  '<enfcatastro>'.trim($x['enfcatastro']).'</enfcatastro>';
                    print  '<tipIdRet>'.trim($x['tipidret']).'</tipIdRet>';
                    print  '<idRet>'.trim($x['idret']).'</idRet>';
                    print  '<apellidoTrab>'.trim($apellido).'</apellidoTrab>';
                    print  '<nombreTrab>'.trim($nombre).'</nombreTrab>';
                    print  '<estab>'.trim($x['estab']).'</estab>';
                    print  '<residenciaTrab>'.trim($x['residenciatrab']).'</residenciaTrab>';
                    print  '<paisResidencia>'.trim($x['paisresidencia']).'</paisResidencia>';
                    print  '<aplicaConvenio>'.trim($x['aplicaconvenio']).'</aplicaConvenio>';
                    print  '<tipoTrabajDiscap>'.trim($x['tipotrabajdiscap']).'</tipoTrabajDiscap>';
                    print  '<porcentajeDiscap>'.trim($x['porcentajediscap']).'</porcentajeDiscap>';
                    print  '<tipIdDiscap>'.trim($x['tipiddiscap']).'</tipIdDiscap>';
                    print  '<idDiscap>'.trim($x['iddiscap']).'</idDiscap>';
            print  '</empleado>';
             print  '<suelSal>'.trim(str_replace(',','.',$x['suelsal'])).'</suelSal>';
             print  '<sobSuelComRemu>'.trim(str_replace(',','.',$x['sobsuelcomremu'])).'</sobSuelComRemu>';
             print  '<partUtil>'.trim(str_replace(',','.',$x['partutil'])).'</partUtil>';
             print  '<intGrabGen>'.trim(str_replace(',','.',$x['intgrabgen'])).'</intGrabGen>';
             print  '<impRentEmpl>'.trim(str_replace(',','.',$x['imprentempl'])).'</impRentEmpl>';
             print  '<decimTer>'.trim(str_replace(',','.',$x['decimter'])).'</decimTer>';
             print  '<decimCuar>'.trim(str_replace(',','.',$x['decimcuar'])).'</decimCuar>';
             print  '<fondoReserva>'.trim(str_replace(',','.',$x['fondoreserva'])).'</fondoReserva>';
             print  '<salarioDigno>'.trim(str_replace(',','.',$x['salariodigno'])).'</salarioDigno>';
             print  '<otrosIngRenGrav>'.trim(str_replace(',','.',$x['otrosingrengrav'])).'</otrosIngRenGrav>';
             print  '<ingGravConEsteEmpl>'.trim(str_replace(',','.',$x['inggravconesteempl'])).'</ingGravConEsteEmpl>';
             print  '<sisSalNet>'.trim($x['sissalnet']).'</sisSalNet>';
             print  '<apoPerIess>'.trim(str_replace(',','.',$x['apoperiess'])).'</apoPerIess>';
             print  '<aporPerIessConOtrosEmpls>'.trim(str_replace(',','.',$x['aporperiessconotrosempls'])).'</aporPerIessConOtrosEmpls>';
             print  '<deducVivienda>'.trim(str_replace(',','.',$x['deducvivienda'])).'</deducVivienda>';
             print  '<deducSalud>'.trim(str_replace(',','.',$x['deducsalud'])).'</deducSalud>';
             print  '<deducEducartcult>'.trim(str_replace(',','.',$x['deduceducartcult'])).'</deducEducartcult>';
             print  '<deducAliement>'.trim(str_replace(',','.',$x['deducaliement'])).'</deducAliement>';
             print  '<deducVestim>'.trim(str_replace(',','.',$x['deducvestim'])).'</deducVestim>';
             print  '<deduccionTurismo>'.trim(str_replace(',','.',$x['deduturismo'])).'</deduccionTurismo>';
 
             print  '<exoDiscap>'.trim(str_replace(',','.',$x['exodiscap'])).'</exoDiscap>';
             print  '<exoTerEd>'.trim(str_replace(',','.',$x['exotered'])).'</exoTerEd>';
             print  '<basImp>'.trim(str_replace(',','.',$x['basimp'])).'</basImp>';
             print  '<impRentCaus>'.trim(str_replace(',','.',$x['imprentcaus'])).'</impRentCaus>';
             print  '<rebajaGastosPersonales>'.trim(str_replace(',','.',$x['rebajagapersona'])).'</rebajaGastosPersonales>';
             print  '<impuestoRentaRebajaGastosPersonales>'.trim(str_replace(',','.',$x['imprebajagapersona'])).'</impuestoRentaRebajaGastosPersonales>';

             print  '<valRetAsuOtrosEmpls>'.trim(str_replace(',','.','0.00')).'</valRetAsuOtrosEmpls>';
             print  '<valImpAsuEsteEmpl>'.trim(str_replace(',','.',$x['valimpasuesteempl'])).'</valImpAsuEsteEmpl>';
             print  '<valRet>'.trim(str_replace(',','.',$x['valret'])).'</valRet>';
             print  '</datRetRelDep>';
         }
         print  '</retRelDep>';
        print '</rdep>';
        
}
    //--------------------------------------------------------------------------------
    
    //----------------------------------------------------
    function generaxml( $anio ){
     
        $archivo = 'RDEP_'.$anio.'.xml';
           
        return  $archivo;
    }
    //--------------------------------------------------------------------------------
       
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
$gestion        = 	new proceso;
$anio           =  $_GET['anio'];
$downloadfile   =  $gestion->generaxml($anio);
header("Content-Type: application/force-download");
header("Content-type: MIME");
header('Content-type: text/html; charset=utf-8');
header("Content-type: application/octet-stream");
header('Content-Type: application/octet-stream');
header("Content-Disposition: attachment; filename=".$downloadfile);
header('Content-Transfer-Encoding: binary');
header("Expires: 0");

$gestion->consultaId($anio);

 
?> 
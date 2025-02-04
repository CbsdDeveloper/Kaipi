<?php
session_start( );
require '../../kconfig/Db.class.php';
require '../../kconfig/Obj.conf.php';

require 'Formulas-roles_nomina.php';

class proceso{
    
    
    private $obj;
    private $bd;
    
    private $ruc;
    private $sesion;
    private $hoy;
    private $POST;
    private $ATabla;
    private $tabla ;
    private $secuencia;
    private $anio;
    
    private $monto_iess;

    private $formula;


    
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function proceso( ){
        //inicializamos la clase para conectarnos a la bd
        
        $this->obj     = 	new objects;
        $this->bd	   =	new Db ;
        
        $this->ruc       =  trim($_SESSION['ruc_registro']);
        $this->sesion 	 =  trim($_SESSION['email']);
        $this->hoy 	     =  date("Y-m-d");
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
        $this->anio       =  $_SESSION['anio'];


        $this->formula     = 	new Formula_rol(  $this->obj,  $this->bd);
        
    }
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function _tabla_ingresos($where,$id_rol,$id_config,$id_departamento){
        
        $cadena = " || ' ' ";
        
        $sql = 'SELECT a.id_rold as "id",
                       b.fecha as "Ingreso",
                       a.programa '.$cadena.' as "Programa",
                       a.dias '.$cadena.' as "No.Dias",
                       a.idprov as "identificacion",
            		   b.razon as "Nombre",
                       b.unidad as "Departamento",
                       b.cargo as "Cargo",
                       a.descuento as "Monto"
               FROM    nom_rol_pagod a, view_nomina_rol b
              WHERE '. $where. ' order by b.razon asc';
        
        
        $resultado = $this->bd->ejecutar($sql);
        
        
        $tipo = $this->bd->retorna_tipo();
        
        
        $variables  = 'id_rol='.$id_rol.'&id_config='.$id_config.'&id_departamento='.$id_departamento;
        
        $this->obj->grid->KP_sumatoria(10,"Monto","", "",'');
        
        $this->obj->grid->KP_GRID_POP_NOM($resultado,$tipo,'id', $variables,'S','visor','edit','del' );
        
    }
    
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function _procesa_rol($id_rol, $idprov  ){
        
         
 
        
        $rol = $this->bd->query_array('nom_rol_pago',
            'id_periodo, mes, anio, registro',
            'id_rol='.$this->bd->sqlvalue_inyeccion($id_rol,true));
        
        //---------------------------------------------------------------------------
        
        $anio = $rol["anio"];
        $mes  = $rol["mes"];

        $id_periodo  = $rol["id_periodo"];
        
        echo 'Periodo:'. $anio.'-'.$mes.' Periodo '.  $id_periodo.'<br><br>';
             
            
            $sql = 'SELECT idprov, id_departamento, id_cargo, regimen,  fecha, sueldo,
                           fondo,vivienda,salud, alimentacion,educacion,vestimenta,
                           sifondo,sidecimo,sicuarto,sihoras,sisubrogacion,programa,fecha_salida
     	       FROM view_nomina_rol
			   where    idprov='.$this->bd->sqlvalue_inyeccion($idprov ,true)  ;
            
      
           
        
        $stmt = $this->bd->ejecutar($sql);
        
        
        //---------------------------------------------------------------------------
        
        
        while ($x=$this->bd->obtener_fila($stmt)){
             
          
                  
              $dias         =  $this->formula->_n_sueldo_dias($x['fecha'],$rol["mes"],$rol["anio"], $x['fecha_salida'] );
                
 
                echo 'Nro dias trabajados :'.  $dias .'<br><br><br>';
                
      
                
           //     $ingreso =  $this->formula->_n_decimo_cuarto_acumulado(  $id_periodo, $id_rol,$idprov ,$anio,$mes ,'S' );

              //  $ingreso =  $this->formula->_n_impuesto_renta(  $id_periodo, $id_rol,$idprov ,$anio,$mes ,'S' );

                echo $ingreso;


            }
              
        
        
    }
    //--------------------------------------------------------------------------------
    //--- busqueda de por codigo para llenar los datos
    //--------------------------------------------------------------------------------
    function consultaId($id_rol,$id_config,$id_departamento,$regimen,$programa,$accion ){
        
        
        $_SESSION['id_config'] = $id_config;
        
        $where = $this->_where($id_rol,$id_config,$id_departamento,$regimen,$programa);
        
        if ( trim($accion) == 'add'){
            
            if ( $id_config <> '-'){
                
                $this->_procesa_rol($id_rol, $id_config, $id_departamento ,$regimen,$programa);
            }
            
            
            
        }
        
        if ( $id_config <> '-'){
            
            $this->_tabla_ingresos($where,$id_rol,$id_config,$id_departamento);
            
        }
        
        
       
        
        
        
    }
    
    //--------------------------------------------------------------------------------
    //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
    //--------------------------------------------------------------------------------
    
    function _where($id_rol,$id_config,$id_departamento,$regimen,$programa){
        
        
        $cadena1 = '';
        $cadena2 = '';
        $cadena3 = '';
        $cadena4 = '';
        $cadena5 = '';
        $cadena6 = '';
        
       
        $cadena1 = "(  a.idprov=b.idprov ) and ";
        
        $cadena6 = '( a.regimen ='.$this->bd->sqlvalue_inyeccion(trim($regimen),true).") and ";
        
        if (  ($id_rol) >= 1){
            
            $cadena2 = '( a.id_rol ='.$this->bd->sqlvalue_inyeccion(trim($id_rol),true).") and ";
            
        }
        
        if (  ($id_config) >= 1){
            
            $cadena3 = '( a.id_config ='.$this->bd->sqlvalue_inyeccion(trim($id_config),true).") and ";
            
        }
        
        if (  ($id_departamento) <> '-' ){
            
            $cadena4 = '( a.id_departamento ='.$this->bd->sqlvalue_inyeccion(trim($id_departamento),true).") and ";
            
        }
        
      
            
            $cadena5 = '( a.programa ='.$this->bd->sqlvalue_inyeccion(trim($programa),true).") and ";
            
 
        
        $where    =  $cadena1.$cadena6.$cadena2.$cadena3.$cadena4.$cadena5;
        
        $longitud = strlen($where);
        
        $where    = substr( $where,0,$longitud - 5);
        
        return   $where;
        
        
    }
    
   
    ///---------------

   
    function meses($fech_ini,$fech_fin) {
 
     
        $fIni_yr=substr($fech_ini,0,4);
         $fIni_mon=substr($fech_ini,5,2);
         $fIni_day=substr($fech_ini,8,2);
     
        //SEPARO LOS VALORES DEL ANIO, MES Y DIA PARA LA FECHA FINAL EN DIFERENTES
        //VARIABLES PARASU MEJOR MANEJO
        $fFin_yr=substr($fech_fin,0,4);
         $fFin_mon=substr($fech_fin,5,2);
         $fFin_day=substr($fech_fin,8,2);
     
        $yr_dif=$fFin_yr - $fIni_yr;
     //   echo "la diferencia de años es -> ".$yr_dif."<br>";
        //LA FUNCION strtotime NOS PERMITE COMPARAR CORRECTAMENTE LAS FECHAS
        //TAMBIEN ES UTIL CON LA FUNCION date
        if(strtotime($fech_ini) > strtotime($fech_fin)){
           echo 'ERROR -> la fecha inicial es mayor a la fecha final <br>';
           exit();
        }
        else{
            if($yr_dif == 1){
              $fIni_mon = 12 - $fIni_mon;
              $meses = $fFin_mon + $fIni_mon;
              return $meses;
              //LA FUNCION utf8_encode NOS SIRVE PARA PODER MOSTRAR ACENTOS Y
              //CARACTERES RAROS
              //echo utf8_encode("la diferencia de meses con un año de diferencia es -> ".$meses."<br>");
           }
           else{
               if($yr_dif == 0){
                  $meses=$fFin_mon - $fIni_mon;
                 return $meses;
                 //echo utf8_encode("la diferencia de meses con cero años de diferencia es -> ".$meses.", donde el mes inicial es ".$fIni_mon.", el mes final es ".$fFin_mon."<br>");
              }
              else{
                  if($yr_dif > 1){
                    $fIni_mon = 12 - $fIni_mon;
                    $meses = $fFin_mon + $fIni_mon + (($yr_dif - 1) * 12);
                    return $meses;
                    //echo utf8_encode("la diferencia de meses con mas de un año de diferencia es -> ".$meses."<br>");
                 }
                 else
                    echo "ERROR -> la fecha inicial es mayor a la fecha final <br>";
                    exit();
              }
           }
        }
     
     }
    
     
    
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;



$id_rol             = $_GET['id_rol'];
$id_prov           = trim($_GET['cedula']);
 

$gestion->_procesa_rol($id_rol, $id_prov  )

 

?>
 
  
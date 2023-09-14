<?php 
session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 
    
	$bd	   = new Db ;
	
	$anio  = $_SESSION['anio'];
	
  
	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	



 
    /*

    'idprov'   : idprov ,
                     'salario'   : salario ,
                     'ingreso'   : ingreso ,
                     'salida'   : salida ,
                     'motivo'   : motivo ,
                     'discapacidad'   : discapacidad ,
                     'A1'   : A1 ,
                     'A7'   : A7 

      */
    $salario = $_POST['salario'];


    $idprov       = trim($_POST['idprov']);
    $discapacidad = trim($_POST['discapacidad']);

    // resta dia si ha salido sin paga

    $motivo           = trim($_POST['motivo']);
    
    $dia_proporcional = trim($_POST['A1']);
    $tiene_fondos     = trim($_POST['A7']);


    $ingreso          = $_POST['ingreso'];
    $salida           = $_POST['salida'];
    $fecha_dia        = strtotime($salida);
    $dia              = date( "j", $fecha_dia);
    $periodo          = date( "Y", $fecha_dia);

    $saldo_vaca       = $_POST['A9'] ;
    

     // años de servicio
    $diferencia_anio = abs((strtotime($salida) - strtotime($ingreso))/86400); 

    $anio_servicio   =  round($diferencia_anio/365,2);
    $anio_des        = intval( $anio_servicio );
  
    
    $sql        = "SELECT   *  FROM view_nomina_rol  where idprov =".$bd->sqlvalue_inyeccion($idprov,true) ;
    $resultado1 = $bd->ejecutar($sql);
    $x          = $bd->obtener_array( $resultado1);
    
    if (    $dia_proporcional == 'S'){
        $nro_dia_proporcional = '0';
        $salario_parcial      = 0;
     }else{
        $nro_dia_proporcional =  $dia;
        $parcial =  $salario / 30;
    
        $salario_parcial =  $parcial *   $nro_dia_proporcional;
        $salario_parcial = round( $salario_parcial ,2);
    }
 
    /// A5 AÑOS EFECTIVOS DESPIDO
    if (    $motivo  == 'DESPIDO INTEMPESTIVO'){
        if (    $anio_servicio < 3){
                 $dia_efectivo = 3;
        }else {
            if (    $anio_servicio > 25){
                $dia_efectivo = 25;
            }else
            {
                $dia_efectivo = round( $anio_servicio ,2);
            }
        }    
     }else{
        $dia_efectivo = 0;
     }
 
    // A8 CALCULO DE VALOR DE VACACIONES
    $valor_vacacion =  round($salario  * (12/360),2);

    //---------- valor de vacaciones
    
    $liquida_vacacion =   $valor_vacacion * $saldo_vaca ;


    //---- decimo cuarto
    
    $smu = $bd->query_array('wk_config',
    'modulo as salario',
    'tipo='.$bd->sqlvalue_inyeccion('70',true) 
    );

    $decimo_cuarto =  intval($smu['salario']);


/*
INDEMNIZACION POR DESPIDO =  SI(B13="DESPIDO INTEMPESTIVO",B22*B14,0)
INDEMNIZACION POR DESAHUCIO  =+B14*B21*25%
INDEMNIZACION POR DISCAPACIDAD =SI(B15="NO",0,G23*18)

*/

if (    $motivo  == 'DESPIDO INTEMPESTIVO'){
     $DESPIDO = $salario  * $dia_efectivo ;
 }else{
     $DESPIDO = 0;
 }

 $DESAHUCIO = ($salario * $anio_des) * 25/100;
 $DESAHUCIO = round( $DESAHUCIO,2);

 if (    $discapacidad  == 'N'){
    $I_DISCAPACIDAD = 0;
}else{
    $I_DISCAPACIDAD = $salario  * (18/100);
    $I_DISCAPACIDAD = round( $I_DISCAPACIDAD,2);
}


$decimo14  =_n_decimo_cuarto(  $bd, $idprov ,$anio  , $decimo_cuarto , $salida,  $dia  );


$decimo13  =_n_decimo_tercero(  $bd, $idprov ,$anio  , $salario , $salida,  $dia  );


if (    $tiene_fondos  == 'S'){
    $fondos = $salario  * (8.33/100) ;
}else{
    $fondos = 0;
}
 
 
    
    echo json_encode( array("a"=>$nro_dia_proporcional, 
                            "b"=> $anio_servicio ,
                            "c"=> $anio_des ,
                            "d"=> $dia_efectivo  ,
                            "e"=> $decimo_cuarto ,
                            "f"=> round($valor_vacacion,2) ,
                            "g"=> round($liquida_vacacion,2) ,
                            "h"=>  $DESPIDO,
                            "i"=>  $DESAHUCIO,
                            "j"=>  $I_DISCAPACIDAD,
                            "k"=>  $salario_parcial,
                            "l"=>  round($decimo14,2),
                            "m"=>  round($decimo13,2),
                            "n"=>  round($fondos,2),
                       )  
                    );
    
//--------------------------


function _n_decimo_tercero(  $bd, $idprov ,$anio  , $salario, $salida,  $dia   ){
        
     
                
                    $xxx = $bd->query_array('view_nomina_rol',
                    'fecha,sueldo,sifondo,fondo, sidecimo, sicuarto, sihoras, sisubrogacion,fecha_salida',
                    'idprov='.$bd->sqlvalue_inyeccion(trim($idprov),true) 
                    );
                
                    $udia           =    30;
                    $parcial        =    $salario/12;
                    $dias_valor     =    $parcial/ $udia ;

                    $dia_ultimo     =    $dia * $dias_valor  ;
                     



                    if ( $xxx['sidecimo']  == 'N') {
                        
                        $valor_hora = 0;
                        
                        
                    }else{

                            
                            $anio0        = $anio -1;
                            $fecha_final  =  $anio  .'-11-30';
                            $fecha_p1     =  $anio0  .'-12-31';

                                $meses00        =    meses($xxx['fecha'],$fecha_p1);
                                $meses01        =    meses(  $salida,$fecha_final);

                                if ( $meses00 > 0 ){
                                    $parcialm        = 1  *   $parcial;
                                 } else{
                                    $parcialm        = $meses00  *   $parcial;
                                }

                                $mes_tope = 11 -  $meses01 - 1   ;

                                $tota_d14 =   $parcialm +  $dia_ultimo  + ($mes_tope * $parcial);
 

                                 $valor_hora =  $tota_d14  ;
                    }
                     
                    
                    return $valor_hora;
                    
     }
//--------------------------
function _n_decimo_cuarto(  $bd, $idprov ,$anio  , $decimo_cuarto, $salida,  $dia   ){
        
     
                
    $xxx = $bd->query_array('view_nomina_rol',
    'fecha,sueldo,sifondo,fondo, sidecimo, sicuarto, sihoras, sisubrogacion,fecha_salida',
    'idprov='.$bd->sqlvalue_inyeccion(trim($idprov),true) 
    );

    $udia           =    30;
    $parcial        =    $decimo_cuarto/12;
    $dias_valor     =    $parcial/ $udia ;

    $dia_ultimo     =    $dia * $dias_valor  ;
     
    if ( $xxx['sicuarto']  == 'N') {
        
        $valor_hora = 0;
        
        
    }else{

            $region = 'S';
            $anio0  = $anio -1;

                if ($region=='C')
                {
                    $fecha_final  =  $anio  .'-02-28';
                    $fecha_p1  =  $anio0  .'-12-31';
                }else  {
                    $fecha_final  =  $anio  .'-07-30';

                    $fecha_p1  =  $anio0  .'-12-31';
                }

                $meses00        =    meses($xxx['fecha'],$fecha_p1);

                $meses01        =    meses(  $salida,$fecha_final);

                if ( $meses00 > 4  ){
                    $parcialm        = 5  *   $parcial;
                 } else{
                    $parcialm        = $meses00  *   $parcial;
                }

                $mes_tope = 7 -  $meses01 - 1   ;

                $tota_d14 =   $parcialm +  $dia_ultimo  + ($mes_tope * $parcial);


                 $valor_hora =  $tota_d14  ;
    }
     
    
    return $valor_hora;
    
}     
//-------------------------
function _dias($fecha_inicial,$fecha_final)
{
    $dias = (strtotime($fecha_inicial)-strtotime($fecha_final))/86400;
    $dias = floor($dias);
    return $dias;
}
//---------------------------
function _mes($fecha_inicial,$fecha_final)
{
    
    
    $fecha1         = explode('-', $fecha_inicial);
    $fecha2         = explode('-', $fecha_final);
    
    $anio1  =  $fecha1[0] ;
    $anio2  =  $fecha2[0] ;
    
    $mes1  =  $fecha1[1] ;
    $mes2  =  $fecha2[1] ;
    
    
    
    if ( $anio1 == $anio2) {
         $variable1  = intval($mes2);
         $variable2  = intval($mes1);
         $nro_meses  = ($variable2 - $variable1) + 1;
         $dias = $nro_meses * 30 ;
        
    }else{
        
    }
     
    return $dias;
}    
//-----------------------------------------------
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
      // echo 'ADVERTENCIA -> la fecha inicial es mayor a la fecha final <br>'.$fech_ini.' '.$fech_fin;
       return 0;
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
               // echo "ADVERTENCIA -> la fecha inicial es mayor a la fecha final <br>";
               return 0;
         }
      }
   }

}
?>
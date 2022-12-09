<?php 
session_start( );   
  
/*
 CLASE CALCULO DE FORMULAS DE IESS
 VERSION 1.1
 FECHA: 2022-08-2021
 AUTOR JA
 */

class Formula_rol{
 
      private $obj;
      private $bd;
      
      private $ruc;
      private $sesion;
      private $hoy;
      private $POST;
      private $ATabla;
      private $tabla ;
      private $secuencia;
      private $variable_valor;

      private $monto_iess;
      
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function Formula_rol( $obj, $bd ){
            //inicializamos la clase para conectarnos a la bd
  

              
        $this->obj     = 	$obj;
        $this->bd	   =	$bd ;

    
                $this->ruc       =  $_SESSION['ruc_registro'];
                $this->sesion 	 =  $_SESSION['email'];
                $this->hoy 	     =  date("Y-m-d");    
         

           
                
      }
     /*
     variable del rubro 
     */
    function tipo_rubro($id_config ){

        $variable_formula = $this->bd->query_array('view_nomina_rol_reg',
        'estructura, 
         formula, 
         monto, 
         variable ,
         tipoformula', 
        'id_config_reg='.$this->bd->sqlvalue_inyeccion($id_config,true)
        );
        
        $this->variable_valor  =  $variable_formula["monto"] ;


        $tipoformula        =  trim($variable_formula["tipoformula"] );
        
         
 
        if ($tipoformula  == 'AP'){
             $this->monto_iess =  $variable_formula["monto"] ;
         }
            
  
        

    }


    //--------------------------------------------------------------------------------
    //---  dias trabajados
    //--------------------------------------------------------------------------------
    function _n_sueldo_dias($fecha,$mes,$anio,$fecha_salida  ){
        
 
        $bandera = 0;
        
        $dia     = 30;
        
        $periodo = explode('-', $fecha);

        $fecha_inicio = $anio.'-'.$mes.'-01';
  
        if ( $anio == $periodo[0] ){
            $bandera = 1;
        }
        
        //--------------------------------------------------------------
        
        if ( $bandera == 1){
            
            if ( $mes == $periodo[1] ){
                
                $bandera = 2;
                
            }
            
        }
        
        //--------------------------------------------------------------
        
        if ( $bandera == 2){
            
            $ndia = $periodo[2] - 1;
            
            $dia = 30 - $ndia;
            
        }
 

        if (!empty($fecha_salida)){
            $dia =  $this->diasEntreFechas($fecha_inicio,$fecha_salida );
        } 

        
        return $dia ;
        
    }


    // Calcula el número de días entre dos fechas.
// Da igual el formato de las fechas 
// (dd-mm-aaaa o aaaa-mm-dd),
// pero el carácter separador debe ser un guión.
function diasEntreFechas($fechainicio, $fechafin){

    return ((strtotime($fechafin)-strtotime($fechainicio))/86400);
    
}

//--------------------------------------------------------------------------------
//--- Saca el valor del sueldo y proporcional
//--------------------------------------------------------------------------------
    function _n_sueldo_mes( $id_periodo, $id_rol,$idprov ,$anio,$mes,$sueldo,$fecha,$fecha_salida ){
        
        $valor_parcial = $sueldo;
        
        /*
        $User = $this->bd->query_array('nom_rol_horas',
                                       'id_rolhora, sueldo,dias, horasextras, horassuple, atrasos',
                                       'idprov='.$this->bd->sqlvalue_inyeccion(trim($idprov),true).' and
                                        id_periodo='.$this->bd->sqlvalue_inyeccion($id_periodo,true).' and
                                        id_rol='.$this->bd->sqlvalue_inyeccion($id_rol,true).' and
                                        anio='.$this->bd->sqlvalue_inyeccion($anio,true).' and
                                        mes='.$this->bd->sqlvalue_inyeccion($mes,true)
            );
        */
        
        $nro_dias = $this->_n_sueldo_dias($fecha,$mes,$anio,$fecha_salida);
 
            
           if ( $nro_dias == 30 ){
               
                $valor_parcial = $sueldo;
                
            }else {
                
                $valor_parcial = ( $nro_dias * $sueldo ) / 30;
                
            }
 
        
        return $valor_parcial;
        
    }

     //--------------------------------------------------------------------------------
    //--- Calculo de los fondos de reserva....
    //--------------------------------------------------------------------------------
    function _n_fondos_reserva(  $id_periodo, $id_rol,$idprov ,$anio,$mes  ){
        
        
        $User = $this->bd->query_array('view_nom_rol_formula',
                                       'sum(coalesce(ingreso,0)) as suma',
                                       'idprov='.$this->bd->sqlvalue_inyeccion(trim($idprov),true).' and
                                         id_periodo='.$this->bd->sqlvalue_inyeccion($id_periodo,true).' and
                                         id_rol='.$this->bd->sqlvalue_inyeccion($id_rol,true)." and
                                         tipoformula in ('RS','OO','EE','HE','HS')  and
                                         formula=".$this->bd->sqlvalue_inyeccion( 'I',true)
            );
        
        
        $xxx = $this->bd->query_array('view_nomina_rol','fecha,sifondo,fondo, sidecimo, sicuarto, sihoras, sisubrogacion',
            'idprov='.$this->bd->sqlvalue_inyeccion(trim($idprov),true)
            );
        
        if ( $xxx['fondo']  == 'S') {
            
            $valor_parcial = 0;
            
            if ( $xxx['sifondo']  == 'S') {
                
                if (!empty($User['suma'])){
                    
                    $valor_hora = ( $User['suma'] * (8.33 / 100) );
                    
                    $valor_parcial =  $valor_hora    ;
                    
                }
            
            }
        }
 
        
        
        return $valor_parcial;
        
        
    }

      //-----------------------------
      // calculo de cargas familiares
      function _n_carga_familiar(  $id_periodo, $id_rol,$idprov ,$anio,$mes  ){
        
        
        
        
        $xxx = $this->bd->query_array('view_nomina_rol',
            'anio_trascurrido,fecha,sifondo,fondo,
                sidecimo, sicuarto, sihoras, sisubrogacion,sueldo,coalesce(cargas,0) as cargas',
            'idprov='.$this->bd->sqlvalue_inyeccion(trim($idprov),true)
            );
        
        $salaria        =   $xxx['cargas'];
        
        $monto_pago =  $salaria * 4;
 
        
        
        return $monto_pago;
        
        
        
    }  


     //-------------------------
     // calculo de horas suplementarias
     function _n_horas_suplementarias( $id_periodo, $id_rol,$idprov ,$anio,$mes ){
        
        
        $User = $this->bd->query_array('nom_rol_horas',
            'id_rolhora, sueldo, dias, horasextras, horassuple, atrasos',
            'idprov='.$this->bd->sqlvalue_inyeccion(trim($idprov),true).' and
                 id_periodo='.$this->bd->sqlvalue_inyeccion($id_periodo,true).' and
                 id_rol='.$this->bd->sqlvalue_inyeccion($id_rol,true).' and
                 registro='.$this->bd->sqlvalue_inyeccion( trim($_SESSION['ruc_registro']) ,true).' and
                 anio='.$this->bd->sqlvalue_inyeccion($anio,true).' and
                 mes='.$this->bd->sqlvalue_inyeccion($mes,true)
            );
        
        $valor_parcial = 0;
        
        
        
        if (!empty($User['horassuple'])){
            
            
            $valor_hora = ( $User['sueldo'] / 240);
            
            $valor_suple =  $valor_hora * 1.5;
            
            $valor_hora = $valor_suple  ; /// 60 ;
            
            $valor_parcial =  round($valor_hora,2) * $User['horassuple']   ;
            
            
            
        }
        
        
        return $valor_parcial;
    }


     //-------------------------
     // horas extras 
     function _n_horas_extras( $id_periodo, $id_rol,$idprov ,$anio,$mes ){
        
        
        $User = $this->bd->query_array('nom_rol_horas',
            'id_rolhora, sueldo,dias, horasextras, horassuple, atrasos',
            'idprov='.$this->bd->sqlvalue_inyeccion(trim($idprov),true).' and
                 id_periodo='.$this->bd->sqlvalue_inyeccion($id_periodo,true).' and
                 id_rol='.$this->bd->sqlvalue_inyeccion($id_rol,true).' and
                 registro='.$this->bd->sqlvalue_inyeccion( trim($_SESSION['ruc_registro']) ,true).' and
                 anio='.$this->bd->sqlvalue_inyeccion($anio,true).' and
                 mes='.$this->bd->sqlvalue_inyeccion($mes,true)
            );
        
        $valor_parcial = 0;
        
        if (!empty($User['horasextras'])){
            
            
            $valor_hora = ( $User['sueldo'] / 240);
            
            $valor_suple =  $valor_hora * 2;
            
            $valor_hora = $valor_suple;  /// 60 ;
            
            $valor_parcial =  round($valor_hora,2) * $User['horasextras']   ;
            
        }
        
        
        return $valor_parcial;
    }
//-------------------------
// calculo de antiguedad_n_antiguedad
function _n_antiguedad(  $id_periodo, $id_rol,$idprov ,$anio,$mes  ){
        
        
        
        
    $xxx = $this->bd->query_array('view_nomina_rol',
            'anio_trascurrido,fecha,sifondo,fondo, 
            sidecimo, sicuarto, sihoras, sisubrogacion,sueldo',
        'idprov='.$this->bd->sqlvalue_inyeccion(trim($idprov),true)
        );
    
   $salaria         =   $xxx['sueldo'];
    
   $valor           =  ($this->variable_valor  *  $salaria) / 100;
   
   $monto_pago      =  0;
   
 
       
       $monto_pago = $valor *  $xxx['anio_trascurrido'];
       
 

 
    
   return $monto_pago;
    
    
    
}
/*
Decimo Tercero
*/
function _n_decimo_tercero( $id_periodo, $id_rol,$idprov ,$anio,$mes,$simula="N" ){
        
        
    $User_a = $this->bd->query_array('view_nom_rol_formula',
        'sum(coalesce(ingreso,0)) as suma,count(*) as nn',
        'idprov='.$this->bd->sqlvalue_inyeccion(trim($idprov),true).' and
         anio='.$this->bd->sqlvalue_inyeccion($anio - 1,true)." and
         mes=".$this->bd->sqlvalue_inyeccion(12,true)." and
         tipoformula  =  'RS'"
        );
    
      
    $User = $this->bd->query_array('view_nom_rol_formula',
        'sum(coalesce(ingreso,0)) as suma,count(*) as nn',
        'idprov='.$this->bd->sqlvalue_inyeccion(trim($idprov),true).' and ( mes between 1 and 11  ) and
         anio='.$this->bd->sqlvalue_inyeccion($anio,true)."  and 
         tipoformula  =  'RS'"  
        );
    
    
    $xxx = $this->bd->query_array('view_nomina_rol',
                                  'fecha,sueldo,sifondo,fondo, sidecimo, sicuarto, sihoras, sisubrogacion', 
                                  'idprov='.$this->bd->sqlvalue_inyeccion(trim($idprov),true)
                                  );
    
    $fecha = $anio.'-11-30'; 
    /*
    $dias = (strtotime($fecha)-strtotime($xxx['fecha']))/86400;
    $dias = abs($dias); 
    $dias = floor($dias);
    
    $meses = round(($dias * 12) / 365);*/
    
    $parcial   = $User['suma'] + $User_a['suma'];
    $numero    = $User['nn'] + $User_a['nn'];

    $parcial        =  $parcial/12;

     


    if ( trim($xxx['sidecimo'])  == 'S') {

         
        $valor_parcial =  round($parcial,2)   ;
        
         
    } 
   

    return $valor_parcial;
    
    
}

 //----------------------
    // CALCULO DEL DECIMO TERCERO ACUMULADO ----  que se paga mensual
    function _n_decimo_tercero_acumula( $id_periodo, $id_rol,$idprov ,$anio,$mes,$simula="N"  ){
        
    
        $x = $this->bd->query_array('view_nomina_rol',
        'fecha,sueldo,sifondo,fondo, sidecimo, sicuarto, sihoras, sisubrogacion,fecha_salida',
        'idprov='.$this->bd->sqlvalue_inyeccion(trim($idprov),true)
        );


        $dias         = $this->_n_sueldo_dias($x['fecha'],$mes,$anio, $x['fecha_salida'] );
        
        $User = $this->bd->query_array('view_nom_rol_formula',
            'sum(coalesce(ingreso,0)) as suma',
            'idprov='.$this->bd->sqlvalue_inyeccion(trim($idprov),true).' and
                                         id_periodo='.$this->bd->sqlvalue_inyeccion($id_periodo,true).' and
                                         id_rol='.$this->bd->sqlvalue_inyeccion($id_rol,true)." and
                                         tipoformula  IN ( 'EE','HS','HE','OO' ) "
            );
   
         
            
            $salaria =  $x['sueldo']  ;
            $parcial = $salaria/12;
            $dia_valor =  $parcial /30;



   
        
         /*
     
        $parcial = 0;
        $udia        = $this->bd->_ultimo_dia($xxx['fecha']);
        
        $fecha         = explode('-', $xxx['fecha']);
        $anio_regitro  =  $fecha[0] ;
        $mes_registro  =  $fecha[1] ;
        $dias_registro =  $fecha[2] - 1;
        
        $valor_parcial = 0;
      
        
        $udia = 30;
     
        if ( $anio_regitro == $anio) {

            if ( $mes_registro == $mes) {
                $parcial_hora = $parcial/30;
                $dias =  $udia - $dias_registro;
                $parcial = $dias*$parcial_hora;
            }

        }
     
        */

        if ( trim($x['sidecimo'])  == 'N') {
            
            $parcial = $dia_valor * $dias;
            
           $valor_parcial =  round($parcial,2)    ;
         
          
            
        }
 
        
        return $valor_parcial;
        
        
    }
 //----------------------
 function _n_decimo_cuarto_acumulado(  $id_periodo, $id_rol, $idprov ,$anio, $mes ,$simula="N" ){
        
         
        
    $xxx = $this->bd->query_array('view_nomina_rol','fecha,sifondo,fondo, sidecimo, sicuarto, sihoras, sisubrogacion',
        'idprov='.$this->bd->sqlvalue_inyeccion(trim($idprov),true)
        );
    
    
    $fecha         = explode('-', $xxx['fecha']);

    $anio_regitro  =  $fecha[0] ;
    
    $mes_regitro  =  $fecha[1] ;

    $dia_regitro  =  $fecha[2] ;

    $anio_anterior =  $anio - 1 ;
    
    $valor_hora     =    0;
    $salaria        =    425;
    $udia           =    30;
    $parcial        =    $salaria/12;
   
    $dias_valor     =     $parcial/ $udia ;
     
    $region = 'C';
    
    if ($region=='C')
    {
        $fecha_inicia =  $anio_anterior .'-03-01';
        $fecha_final  =  $anio  .'-02-28';
        $fecha_base   =  $anio  .'-01-01';
        $fecha_tope   =  $anio_anterior  .'-12-31';
     }else  {
        $fecha_inicia =  $anio_anterior .'-07-01';
        $fecha_final  =  $anio  .'-07-30';
        $fecha_base   =  $anio  .'-01-01';
        $fecha_tope   =  $anio_anterior  .'-12-30';
     }
     // (Salario b�sico x Dias Laborados/Total d�as)


     $dias01         =    $this->_dias($fecha_final,$xxx['fecha']);

     $meses01        =    $this->meses($xxx['fecha'],$fecha_final);
 



     

    if ( $dias01 > 360  ){
        $parcial        = $salaria;

   }else{
        $dias01 =   $meses01  * 30 ;
        $parcial_dia = 31 - intval( $dia_regitro );
        $dias01      = $dias01 + $parcial_dia;

         $parcial        =    $dias_valor  * $dias01   ;
    }   


    if ( $simula == 'S'){
 
        echo 'Fecha  Ingreso :'. $xxx['fecha'].' mes '. $mes_regitro .' dia: '. $dia_regitro  .'<br>';
        echo 'Fecha Decimo   :'. $fecha_final .' <br>';
        echo 'Nro dias       :'.  $dias01  .'<br><br>';

        echo 'Valor dia :'.  $dias_valor .'<br>';
        echo 'Nro dias  :'.  $dias01 .'<br>';
        echo 'A pagar   :'.   $dias_valor *  $dias01    .'<br>';
    }

 
 
    
    if ( $xxx['sicuarto']  == 'S') {
        
       $valor_hora =  round($parcial,2);
        
       
        
    }
    
    
    
    return $valor_hora;
    
    
}
//----------------------------- que se paga mensual

function _n_decimo_cuarto(  $id_periodo, $id_rol,$idprov ,$anio,$mes  ){
        
         
        /*
    $xxx = $this->bd->query_array('view_nomina_rol','fecha,sifondo,fondo, sidecimo, sicuarto, sihoras, sisubrogacion',
        'idprov='.$this->bd->sqlvalue_inyeccion(trim($idprov),true)
        );
    
    
    $fecha         = explode('-', $xxx['fecha']);
    $anio_regitro  =  $fecha[0] ;
    $mes_regitro  =  $fecha[1] ;
    
     $anio_anterior =  $anio - 1 ;
    
    $valor_hora     =    0;
   
    
    $region = 'S';
    
    if ($region=='C')
    {
        $fecha_inicia =  $anio_anterior .'-03-01';
        $fecha_final  =  $anio  .'-02-28';
        $fecha_base   =  $anio  .'-01-01';
        $fecha_tope   =  $anio_anterior  .'-12-31';
    }else  {
        $fecha_inicia =  $anio_anterior .'-07-01';
        $fecha_final  =  $anio  .'-08-30';
        $fecha_base   =  $anio  .'-01-01';
        $fecha_tope   =  $anio_anterior  .'-12-31';
    }
    // (Salario b�sico x Dias Laborados/Total d�as)
    
    if ( $anio == $anio_regitro){
         
        if ( $mes_regitro == $mes) {
            
              $dias01       = $this->_mes($fecha_final,$xxx['fecha']);
              $dias01 = 30;
       }
        
    }

    */

    $x = $this->bd->query_array('view_nomina_rol',
    'fecha,sueldo,sifondo,fondo, sidecimo, sicuarto, sihoras, sisubrogacion,fecha_salida',
    'idprov='.$this->bd->sqlvalue_inyeccion(trim($idprov),true)
    );

    $salaria        =    425;
    $udia           =    30;
    $parcial        =    $salaria/12;
    $dias_valor     =    $parcial/ $udia ;


    $dias         = $this->_n_sueldo_dias($x['fecha'],$mes,$anio, $x['fecha_salida'] );
    
   
    
    if ( $x['sicuarto']  == 'N') {
        
      
        $parcial    = $dias_valor *  $dias ;
        $valor_hora =  round($parcial,2);
        
        
    }
     
    
    return $valor_hora;
    
    
    
}
 
   //-------------------------
   function dias_pasados($fecha_inicial,$fecha_final)
   {
       $dias = (strtotime($fecha_inicial)-strtotime($fecha_final))/86400;
       $dias = abs($dias); 
       $dias = floor($dias);
       return $dias;
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
   
//------------
   function _mes_dato($fecha_inicial,$fecha_final)
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
           $nro_meses  = ($variable2 - $variable1) + 1 ;
            
       }else{
           
       }
       
       return $nro_meses;
   }
/*
ASIGNA VALOR DEL CALCULO IESS
*/
function _monto_Aporte_IESS( $monto_iess  ){


    $this->monto_iess = $monto_iess ;

}
   /*
   CALCULO DEL APORTE PERSONAL
   */
   function _n_Aporte_personal_IESS( $id_periodo, $id_rol,$idprov ,$anio,$mes ){
        
        
 
    $User = $this->bd->query_array('view_nom_rol_formula',
        'sum(ingreso) as suma',
        'idprov='.$this->bd->sqlvalue_inyeccion(trim(trim($idprov)),true).' and
             id_periodo='.$this->bd->sqlvalue_inyeccion($id_periodo,true).' and
             id_rol='.$this->bd->sqlvalue_inyeccion($id_rol,true).' and
             formula='.$this->bd->sqlvalue_inyeccion( 'I',true) ." and tipoformula  in ('EE', 'RS','HE','HS') "
        );

    
 
    $valor_parcial = 0;
    
    if (!empty($User['suma'])){
         
        $valor_hora = ( $User['suma'] * ($this->monto_iess  / 100) );
        
        $valor_parcial =  $valor_hora    ;
        
    }
    
    
     
    return $valor_parcial;
}

//--------------------------------------------------------------------------------
    //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
    //--------------------------------------------------------------------------------
    function _n_fondos_reserva01(  $id_periodo, $id_rol,$idprov ,$anio,$mes  ){
        
        
        $xxx = $this->bd->query_array('view_nomina_rol','sifondo,fondo, sidecimo, sicuarto, sihoras, sisubrogacion', 'idprov='.$this->bd->sqlvalue_inyeccion(trim($idprov),true));
        
 
        $User = $this->bd->query_array('view_nom_rol_formula',
            'sum(ingreso) as suma',
            'idprov='.$this->bd->sqlvalue_inyeccion(trim($idprov),true).' and
                                         id_periodo='.$this->bd->sqlvalue_inyeccion($id_periodo,true).' and
                                         id_rol='.$this->bd->sqlvalue_inyeccion($id_rol,true)." and
                                         tipoformula in ('RS','OO','EE','HE','HS')  and
                                         formula=".$this->bd->sqlvalue_inyeccion( 'I',true)
            );
        
        
        
        $valor_parcial = 0;
        
        
        if ( $xxx['fondo']  == 'S') {
        
                //if ( $xxx['sifondo']  == 'S') {
                
                    if (!empty($User['suma'])){
                        
                        $valor_hora = ( $User['suma'] * (8.33 / 100) );
                        
                        $valor_parcial =  $valor_hora    ;
                        
                    }
                
            //    }
        }
        
        return $valor_parcial;
        
        
    }

     //- impuesto a la renta
     function _n_impuesto_renta(  $id_periodo, $id_rol,$idprov ,$anio,$mes,$simula="N" ){
        
   
        $actual = $this->bd->query_array('view_nom_rol_formula',
            ' coalesce(sum(ingreso),0) promedio',
            'idprov='.$this->bd->sqlvalue_inyeccion(trim($idprov),true).' and
                 tipoformula  in ('." 'RS','EE'".')'.' AND
                  mes  =  '.$this->bd->sqlvalue_inyeccion($mes,true).' and
                  anio = '.$this->bd->sqlvalue_inyeccion($anio,true).' and
                  formula='.$this->bd->sqlvalue_inyeccion( 'I',true)
            );
        
       $ingresos_fondo = $this->bd->query_array('view_nom_rol_formula',
            'sum(coalesce(ingreso,0)) as suma',
             'idprov='.$this->bd->sqlvalue_inyeccion(trim($idprov),true).' and
              id_periodo='.$this->bd->sqlvalue_inyeccion($id_periodo,true).' and
              id_rol='.$this->bd->sqlvalue_inyeccion($id_rol,true)." and
              tipoformula  = 'FR' "
            );
 
      
        $sueldo_mes   = round($actual['promedio'],2);
        

        $decimo_tercero  = round($actual['promedio'],2);

        $sueldo_anual   = $sueldo_mes * 12 ;

        if ( $simula == 'S'){
            echo 'Sueldo y Salario Mes:'.  $sueldo_mes .'<br>';
        }



        $xxx = $this->bd->query_array('view_nomina_rol',
            'fecha,sueldo,
             coalesce(vivienda,0) + coalesce(vestimenta,0) +coalesce(salud,0) + coalesce(educacion,0)  + coalesce(turismo,0) +coalesce(alimentacion,0) as saldo',
            'idprov='.$this->bd->sqlvalue_inyeccion(trim($idprov),true));
        
        $gastos_personales =  $xxx['saldo'];
        
        if ( $simula == 'S'){
            echo 'Gastos Personales:'. round($gastos_personales,2) .'<br>';
        }



        $iess_parcial            =  $sueldo_mes * (11.45/100) ;
        
        ///$this->_n_Aporte_personal_IESS_renta( $id_periodo, $id_rol,$idprov ,$anio,$mes,   $sueldo_mes );

        if ( $simula == 'S'){
            echo 'Aporte Iess mensual:'.  round(  $iess_parcial) .'<br>';
        }
        
        $base1 = ( $sueldo_mes   * 12 ) - (   $iess_parcial  * 12) ;
         
        if ( $simula == 'S'){
            echo ' Base Imponible:'.  round($base1,2) .'<br>';
        }
      

        $IR =  $this->_monto_impuesto_renta(  $base1 ,$anio  );

        if ( $simula == 'S'){
            echo ' TABLA IRENTA:'.  round($IR,2) .'<br>';
        }


        $dec4 =  425;
         

        $ingresos_adicionales    = ( $ingresos_fondo['suma'] * 12)  ;  
 
        $ingresos_excento =  $decimo_tercero +  $dec4 +    $ingresos_adicionales  ;

        if ( $simula == 'S'){

            echo ' INGRESOS excento:'.$decimo_tercero.'+'.$dec4 .'+'. $ingresos_adicionales .'='.$ingresos_excento .'<br>';

        }

        $indice     =  24090.30; 

        $canasta    =  5037.55 ; 

/*
        if ( $simula == 'S'){
            echo ' TABLA IRENTA:'.  round($IR,2) .'<br>';
        }
*/

        if (  $gastos_personales > $canasta ){
                $base_calculo = $canasta ;
        }else{
            $base_calculo = $gastos_personales ;
        }

        $ingresos_brutos = $ingresos_excento +   $sueldo_anual;

        if ( $simula == 'S'){

            echo ' INGRESOS BRUTOS : '.$ingresos_brutos.'<br>';

        }

        if ($ingresos_brutos >  $indice  ){
            $rebaja =    $base_calculo *(10/100)  ;
        }else{
            $rebaja =    $base_calculo *(20/100)  ;
        }


        $impuesto =   $IR -  $rebaja;


         $valor_mensual =  $impuesto / 12;

 
        return  $valor_mensual ;
        
        
    }
    
/*
impuesto a la renta
**/
    function _monto_impuesto_renta(  $base_imponible ,$anio  ){
        
        $renta = $this->bd->query_array('nom_imp_renta','anio, tipo, fracbasica, excehasta, impubasico, impuexcedente',
            'anio = '.$this->bd->sqlvalue_inyeccion($anio,true).'
            and ( '.$base_imponible.'  between fracbasica and excehasta )'
            );
        
        
        $excedente      = 0;
        $valor_obtenido = 0;
        $IR             = 0 ;
        
        $excedente      = $base_imponible - ( $renta['fracbasica'] );
        
        $valor_obtenido = $excedente * ( $renta['impuexcedente'] / 100 );
        
        $IR =   $valor_obtenido +   $renta['impubasico']     ;
        
        $valor_mensual = round($IR,2);
        
        
        return  $valor_mensual;
    }
    



    
    //-------------------------
    function _n_Aporte_personal_IESS_renta( $id_periodo, $id_rol,$idprov ,$anio,$mes ,$sueldo){
        
        
       
    $User = $this->bd->query_array('view_nom_rol_formula',
    'sum(ingreso) as suma',
    'idprov='.$this->bd->sqlvalue_inyeccion(trim(trim($idprov)),true).' and
         id_periodo='.$this->bd->sqlvalue_inyeccion($id_periodo,true).' and
         id_rol='.$this->bd->sqlvalue_inyeccion($id_rol,true).' and
         formula='.$this->bd->sqlvalue_inyeccion( 'I',true) ." and tipoformula  in ('EE', 'RS','HE','HS') "
    );
          
   
          
    
    $valor_parcial = 0;
    
    if (!empty($User['suma'])){
         
        $valor_hora = ( $User['suma'] * ($this->monto_iess  / 100) );
        
        $valor_parcial =  $valor_hora    ;
        
    }
    
          
          
          return $valor_parcial;
      }
/*
meses
*/
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
  
     
   
 ?>
 
  
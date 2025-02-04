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

    /*
    */

    function _busca_configuracion($id_config, $regimen,$programa){
        
        $AResultado = $this->bd->query_array(
            'nom_config_regimen',
            'id_config_reg,tipo_config',
            'id_config='.$this->bd->sqlvalue_inyeccion($id_config,true) .' and 
               regimen='.$this->bd->sqlvalue_inyeccion(trim( $regimen),true) .' and 
               programa='.$this->bd->sqlvalue_inyeccion(trim($programa),true) 
            );
        
 
       
                   
         return  $AResultado;
                   
    }

 
    //--------------------------------------------------------------------------------
    //--- busqueda de por codigo para llenar los datos
    //--------------------------------------------------------------------------------
    function consultaId($id_rol,$id_config,$regimen,$accion){
        
        
        $rol = $this->bd->query_array('nom_rol_pago',
        'id_periodo, mes, anio, registro',
        'id_rol='.$this->bd->sqlvalue_inyeccion($id_rol,true));
    
    //---------------------------------------------------------------------------
    
    $anio = $rol["anio"];
    $mes  = $rol["mes"];
    
         
    if ( $regimen == '-') {
        $sql = 'SELECT idprov, id_departamento, id_cargo, regimen,  fecha, sueldo,
        fondo,vivienda,salud, alimentacion,educacion,vestimenta,razon,cargo,
        sifondo,sidecimo,sicuarto,sihoras,sisubrogacion,programa,fecha_salida
        FROM view_nomina_rol
        where 
            asale <= '.$this->bd->sqlvalue_inyeccion($anio ,true) .' and
            msale <= '.$this->bd->sqlvalue_inyeccion($mes ,true) .' order by razon';

    }else   {  
        $sql = 'SELECT idprov, id_departamento, id_cargo, regimen,  fecha, sueldo,
                       fondo,vivienda,salud, alimentacion,educacion,vestimenta,razon,cargo,
                       sifondo,sidecimo,sicuarto,sihoras,sisubrogacion,programa,fecha_salida
            FROM view_nomina_rol
           where 
                 regimen='.$this->bd->sqlvalue_inyeccion(trim($regimen) ,true). ' and
                 asale <= '.$this->bd->sqlvalue_inyeccion($anio ,true) .' and
                 msale <= '.$this->bd->sqlvalue_inyeccion($mes ,true) .' order by razon';
     }

    $stmt1 = $this->bd->ejecutar($sql);
    
    
            if ( $id_config > 0 )  {  
                
                            echo '<table id="jsontable" class="table table-striped table-bordered table-hover datatable" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                            <th align="center" width="10%">Identificacion</th>
                            <th align="center" width="30%">Nombre</th>
                            <th align="center" width="20%">Regimen</th>
                            <th align="center" width="5%">Programa</th>
                            <th align="center" width="15%">Cargo</th>
                            <th align="center" width="10%">Sueldo</th>
                            <th align="center" width="10%">Monto</th>
                                </tr>
                        </thead>';


                        $ntotal = 0;
                                
                                while ($y=$this->bd->obtener_fila($stmt1)){
                                
                                $regimen  = trim($y['regimen']);

                                $programa = trim($y['programa']);

                                $id_config_array =   $this->_busca_configuracion($id_config, $regimen,$programa);


                                $id_config_reg =  $id_config_array['id_config_reg'];

                                    echo ' <tr>
                                    <td>'.trim($y['idprov']).'</td>';
                                    echo '<td>'.trim($y['razon']).'</td>';
                                    echo '<td>'.trim($y['regimen']).'</td>';
                                    echo '<td>'.trim($y['programa']).'</td>';
                                    echo '<td>'.trim($y['cargo']).'</td>';
                                    echo '<td>'.$y['sueldo'].'</td>';

                                    if (  $id_config_reg > 0 ){



                                        $datos = $this->bd->query_array(
                                            'nom_rol_pagod',
                                            'ingreso,descuento,id_rold',
                                            'id_config='.$this->bd->sqlvalue_inyeccion($id_config_reg,true) .' and 
                                             id_rol='.$this->bd->sqlvalue_inyeccion($id_rol,true) .' and 
                                             idprov='.$this->bd->sqlvalue_inyeccion(trim($y['idprov']),true) 
                                            );

                                           if ( $datos['id_rold'] > 0  ) {    
                                               $valor   = $datos['ingreso'] + $datos['descuento'];
                                               $accion  = 'editar';
                                               $id_rold = $datos['id_rold'];

                                           }else{
                                               $valor   = '0.00';
                                               $accion  = 'add';
                                               $id_rold = 0;
                                           }

                                          

                                            $evento = '  Onchange="ActualizaDatos('.'this.value,'."'".trim($y['idprov'])."'".",". $id_config_reg.","."'".$accion."'".",".$id_rold.')" ';

                                            echo '<td>'.
                                            ' <input type="number" '. $evento.'
                                            value="'.  $valor.'" class="form-control"'.' 
                                            id  ="d'.trim($y['idprov']).'"  
                                            name="d'.trim($y['idprov']).'" >'.'<span style="font-size:0px">'.$valor.'</span>' .
                                            '</td>';

                                    }else{
                                          echo ' <td>No Parametro</td>';
                                    }

                                    echo ' </tr>';

                                    $ntotal =  $ntotal +  $valor ;

                                }
                                echo	'</table> ';
                    }
 
        
              //      echo '<h3>'.number_format($ntotal,2) .'</h3>';
    }
 
  
    
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;



$id_rol              = $_GET['id_rol'];
$id_config           = $_GET['id_config'];
 $regimen            = $_GET['regimen'];
 
$accion             = $_GET['accion'];

$gestion->consultaId($id_rol,$id_config,$regimen,$accion);

 

?>
<script>

   jQuery.noConflict(); 

   jQuery(document).ready(function() {

	   jQuery('#jsontable').DataTable( {
    	        "paging":   true,
    	        "ordering": true,
    	        "info":     true
    	    } );
        
    } ); 
</script>  
  
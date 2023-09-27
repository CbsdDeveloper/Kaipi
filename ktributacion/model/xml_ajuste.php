<?php
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class proceso
{


    private $obj;
    private $bd;
    private $saldos;

    private $ruc;
    private $sesion;
    private $hoy;
    private $POST;

    private $ATabla;
    private $tabla;
    private $secuencia;

    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function proceso()
    {
        //inicializamos la clase para conectarnos a la bd

        $this->obj     =     new objects;
        $this->bd       =    new Db;

        $this->ruc       =  $_SESSION['ruc_registro'];

        $this->sesion      =  $_SESSION['email'];

        $this->hoy          =  $this->bd->hoy();

        $this->bd->conectar($_SESSION['us'], $_SESSION['db'], $_SESSION['ac']);
    }

    //--- busqueda de por codigo para llenar los datos
    //--------------------------------------------------------------------------------
    function consultaPeriodo($mes, $anio)
    {

        $resumen_ventas = $this->VentasPeriodo($mes, $anio);


        $sql = "UPDATE co_ventas 
                   SET id_asiento = " . $this->bd->sqlvalue_inyeccion($id_asiento, true) . "
                   WHERE id_ventas =" . $this->bd->sqlvalue_inyeccion($id_ventas, true);


        $this->bd->ejecutar($sql);

        $result = ' Datos Procesados: ' . $mes . '-' . $anio;

        echo  $result;
    }
    /////////////// llena datos de la consulta individual
    function VentasPeriodo($anio, $mes)
    {

        $ventas = $this->bd->query_array(
            'rentas.view_ren_movimiento_pagos',
            'idprov, COUNT(idprov) as cantidad_ventas, max(fechap) as fechap, sum(base0) as base0, sum(base12) as base12, sum(iva) as iva, max(secuencial) as secuencial',
            "date_part('month', fechap) = " . $this->bd->sqlvalue_inyeccion($mes, true) . " and date_part('year', fechap) = " . $this->bd->sqlvalue_inyeccion($anio, true),
            "0",
            "group by idprov"
        );

        return $ventas;
    }
    //-------------------------------------------   $this->bd->sqlvalue_inyeccion(, true)
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   =     new proceso;


//------ poner informacion en los campos del sistema
if (isset($_GET['mes'])) {

    $mes    = $_GET['mes'];

    $anio    = $_GET['anio'];

    $gestion->consultaId($mes, $anio);
}

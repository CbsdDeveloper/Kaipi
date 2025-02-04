<?php
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

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

        $this->bd->conectar($_SESSION['us'], '', $_SESSION['ac']);
    }

    //--- busqueda de por codigo para llenar los datos
    //--------------------------------------------------------------------------------
    function consultaPeriodo($mes, $anio)
    {

        $resumen_ventas = $this->VentasPeriodo($mes, $anio);


        // Eliminano registros de ventas actuales
        $sql = "DELETE FROM co_ventas WHERE date_part('month', fechaemision) = " . $this->bd->sqlvalue_inyeccion($mes, true) . " and date_part('year', fechaemision) = " . $this->bd->sqlvalue_inyeccion($anio, true);
        $this->bd->ejecutar($sql);


        for ($i=0; $i < count($resumen_ventas); $i++) { 
            // echo $resumen_ventas[$i]["idprov"];
            // print_r  ("<br>");
            $nuevo_id = $this->bd->query_array(
                'public.co_ventas',
                'max(id_ventas)+1 as id',
                "1=1",
                "0",
                ""
            );
            $sql="INSERT INTO public.co_ventas VALUES  (".$nuevo_id['id'].", 0, '". (strlen(trim($resumen_ventas[$i]["idprov"])) == 10 ? '05' : '04')  . "', '".trim($resumen_ventas[$i]["idprov"])."', '18', ".$resumen_ventas[$i]["cant"].", 0, ".$resumen_ventas[$i]["base0"].", ".$resumen_ventas[$i]["base12"].", ".$resumen_ventas[$i]["iva"].", 0, 0, '000000001', '001', '".$resumen_ventas[$i]["fecha"]."', '2360003540001', 0, 0, 1, 'E', '20',0);";
            // echo $sql;
            $this->bd->ejecutar($sql);
            // print_r  ("<br>");
        }

        // ACTUALIZAR SECUENCIA GLOBAL
        $nuevo_id = $this->bd->query_array(
            'public.co_ventas',
            'max(id_ventas)+1 as id',
            "1=1",
            "0",
            ""
        );
        $sql="alter sequence id_co_ventas restart with ".$nuevo_id['id'].";";
        $this->bd->ejecutar($sql);

        // $sql = "UPDATE co_ventas 
        //            SET id_asiento = " . $this->bd->sqlvalue_inyeccion($id_asiento, true) . "
        //            WHERE id_ventas =" . $this->bd->sqlvalue_inyeccion($id_ventas, true);
        // // $this->bd->ejecutar($sql);


        // print_r  ($resumen_ventas);
        
        $result = ' Datos Procesados: ' . $mes . '-' . $anio.', Por favor presiones nuevamente el botón Búsqueda!';
        echo $result;
    }
    /////////////// llena datos de la consulta individual
    function VentasPeriodo($mes, $anio)
    {

        // $ventas = $this->bd->query_array_all(
        //     'rentas.view_ren_emision',
        //     'idprov, count(idprov) as cant, max(fecha_emision) as fecha, sum(coalesce(total,0 )) as total',
        //     "date_part('month', fecha_emision) = " . $this->bd->sqlvalue_inyeccion($mes, true) . " and date_part('year', fecha_emision) = " . $this->bd->sqlvalue_inyeccion($anio, true). " and modulo  <> 'especies' and estado_proceso = 'Pagado'",
        //     "0",
        //     "group by idprov"
        // );
        $ventas = $this->bd->query_array_all(
            'rentas.view_ren_emision',
            'idprov, count(idprov) as cant, max(fecha_emision) as fecha, sum(coalesce(base0,0 )) as base0, sum(coalesce(base12,0 )) as base12, sum(coalesce(iva,0 )) as iva',
            "date_part('month', fecha_emision) = " . $this->bd->sqlvalue_inyeccion($mes, true) . " and date_part('year', fecha_emision) = " . $this->bd->sqlvalue_inyeccion($anio, true). " and modulo  <> 'especies' and estado_proceso = 'Pagado'",
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

    $gestion->consultaPeriodo($mes, $anio);
}

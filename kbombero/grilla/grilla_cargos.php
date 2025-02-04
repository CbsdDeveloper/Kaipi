<?php
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

class proceso
{


  private $obj;
  private $bd;

  private $ruc;
  private $sesion;
  private $hoy;
  private $POST;
  //-----------------------------------------------------------------------------------------------------------
  //Constructor de la clase
  //-----------------------------------------------------------------------------------------------------------
  function proceso()
  {
    //inicializamos la clase para conectarnos a la bd

    $this->obj     =   new objects;
    $this->bd     =  new Db;

    $this->ruc       =  $_SESSION['ruc_registro'];
    $this->sesion    =  $_SESSION['email'];
    $this->hoy        =  $this->bd->hoy();

    $this->bd->conectar($_SESSION['us'], '', $_SESSION['ac']);
  }

  //-----------------------------------------------------------------------------------------------------------
  //--- busqueda de grilla primer tab
  //-----------------------------------------------------------------------------------------------------------
  public function BusquedaGrilla($vestado)
  {
    $anio = date('Y');
    $qquery =
      array(
        array('campo' => 'cargo_id',  'valor' => '-', 'filtro' => 'N',   'visor' => 'S'),
        array('campo' => 'cargo_denominacion', 'valor' => '-', 'filtro' => 'N', 'visor' => 'S'),
        array('campo' => 'cargo_horario', 'valor' => '-', 'filtro' => 'N', 'visor' => 'S'),
        array('campo' => 'cargo_horas_dia', 'valor' => '-', 'filtro' => 'N', 'visor' => 'S'),
        array('campo' => 'cargo_hora_entrada', 'valor' =>  '-', 'filtro' => 'N', 'visor' => 'S'),
        array('campo' => 'cargo_hora_salida', 'valor' => '-', 'filtro' => 'N', 'visor' => 'S')
      );

    $output = array();

    $resultado = $this->bd->JqueryCursorVisor('bomberos.bombero_cargo', $qquery);

    while ($fetch = $this->bd->obtener_fila($resultado)) {

      $output[] = array(
        $fetch['cargo_id'],
        $fetch['cargo_denominacion'],
        trim($fetch['cargo_horario']),
        trim($fetch['cargo_horas_dia']),
        trim($fetch['cargo_hora_entrada']),
        trim($fetch['cargo_hora_salida'])
      );
    }

    echo json_encode($output);
  }
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 

$gestion   =   new proceso;

$vestado    = $_GET['vestado'];

$gestion->BusquedaGrilla($vestado);

<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
 
require 'Model_saldos.php'; /*Incluimos el fichero de la clase objetos*/

class proceso{
    
    
    
    private $obj;
    private $bd;
    private $set;
    
    private $ruc;
    private $sesion;
    private $hoy;
    private $POST;
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function proceso( ){
        //inicializamos la clase para conectarnos a la bd
        
        $this->obj     = 	new objects;
        $this->bd	   =	new Db ;
         
        $this->ruc       =  $_SESSION['ruc_registro'];
        $this->sesion 	 =  $_SESSION['email'];
        $this->hoy 	     =  $this->bd->hoy();
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
        $this->saldos     = 	new saldo_presupuesto(  $this->obj,  $this->bd);
        
    }
      //------------($resultado,$tipo,"G","jtabla_gastos");

    function saldos($fanio)  {
        
        
        $SaldoIngreso =  $this->saldos->_saldo_ingreso($fanio);
        
        
        echo 'Saldos '.$SaldoIngreso ;
            
    }
    //------------($resultado,$tipo,"G","jtabla_gastos");
    function saldosg($fanio)  {
        
        $SaldoIngreso =  $this->saldos->_saldo_gasto($fanio);
        
        echo 'Saldos '.$SaldoIngreso ;
        
    }
    
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;



//------ grud de datos insercion
if (isset($_GET["fanio"]))	{
    
    
     $fanio		=   $_GET["fanio"];
     $tipo       =   $_GET["tipo"];
     

    if ( $tipo == 'I' ){
        $gestion->saldos( $fanio);
    }else {
        $gestion->saldosg( $fanio);
    }
  
        
 
 
}
?>
 
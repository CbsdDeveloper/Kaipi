<?php 
 session_start(); 

 require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 
 require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
 


    $bd	   =	 	new Db ;
   
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

    $id = $_POST['id_reciproco'];

    $data = 'DATOS ACTUALIZADOS....';

    $ATabla = array(
        array( campo => 'cuenta_1',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => $_POST['cuenta_1'], key => 'N'),
        array( campo => 'nivel_11',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => $_POST['nivel_11'], key => 'N'),
        array( campo => 'nivel_12',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => $_POST['nivel_12'], key => 'N'),
        array( campo => 'deudor_1',tipo => 'NUMBER',id => '5',add => 'S', edit => 'S', valor => $_POST['deudor_1'], key => 'N'),
        array( campo => 'acreedor_1',tipo => 'NUMBER',id => '6',add => 'S', edit => 'S', valor => $_POST['acreedor_1'], key => 'N'),
        array( campo => 'ruc1',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => $_POST['ruc1'], key => 'N'),
        array( campo => 'nombre',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor => $_POST['nombre'], key => 'N'),
        array( campo => 'grupo',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'S', valor => $_POST['grupo'], key => 'N'),
        array( campo => 'subgrupo',tipo => 'VARCHAR2',id => '10',add => 'S', edit => 'S', valor => $_POST['subgrupo'], key => 'N'),
        array( campo => 'item',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'S', valor => $_POST['item'], key => 'N'),
        array( campo => 'cuenta_2',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'S', valor => $_POST['cuenta_2'], key => 'N'),
        array( campo => 'nivel_21',tipo => 'VARCHAR2',id => '13',add => 'S', edit => 'S', valor => $_POST['nivel_21'], key => 'N'),
        array( campo => 'nivel_22',tipo => 'VARCHAR2',id => '14',add => 'S', edit => 'S', valor => $_POST['nivel_22'], key => 'N'),
        array( campo => 'deudor_2',tipo => 'NUMBER',id => '15',add => 'S', edit => 'S', valor => $_POST['deudor_2'], key => 'N'),
        array( campo => 'acreedor_2',tipo => 'NUMBER',id => '16',add => 'S', edit => 'S', valor => $_POST['acreedor_2'], key => 'N'),
        array( campo => 'asiento',tipo => 'NUMBER',id => '17',add => 'S', edit => 'S', valor => $_POST['asiento'], key => 'N'),
        array( campo => 'fecha',tipo => 'DATE',id => '19',add => 'S', edit => 'S', valor => $_POST['fecha'], key => 'N'),
        array( campo => 'fecha_pago',tipo => 'DATE',id => '20',add => 'S', edit => 'S', valor => $_POST['fecha_pago'], key => 'N'),
        array( campo => 'id_reciproco',tipo => 'NUMBER',id => '21',add => 'N', edit => 'N', valor => '-', key => 'S'),
        array( campo => 'id_asiento_ref',tipo => 'NUMBER',id => '22',add => 'S', edit => 'S', valor => $_POST['id_asiento_ref'], key => 'N')
        );

        $bd->_UpdateSQL('co_reciprocas',$ATabla,$id);
 
   
	 
        echo $data;
 	 
?>
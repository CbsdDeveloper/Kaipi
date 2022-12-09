<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


require 'Model-asientos_saldos.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
    
  
    
    private $obj;
    private $bd;
    private $saldos;
    
    private $ruc;
    private $sesion;
    private $hoy;
    private $POST;
    private $ruc_sri;
    private $anio;
    private $ATabla;
    
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function proceso( ){
        //inicializamos la clase para conectarnos a la bd
        
        $this->obj     = 	new objects;
        $this->bd	   =	new Db ;
        
        $this->ruc       =  $_SESSION['ruc_registro'];

        $this->sesion 	 =  trim($_SESSION['email']);
        
        $this->hoy 	     =  date('Y-m-d');
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
        $this->saldos     = 	new saldo_contable(  $this->obj,  $this->bd);
        
 
        $this->ATabla = array(
            array( campo => 'id_control',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
            array( campo => 'fecha',tipo => 'DATE',id => '1',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'detalle',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'motivo',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'idtramite',tipo => 'NUMBER',id => '4',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'sesion',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'N', valor => $this->sesion , key => 'N'),
            array( campo => 'msesion',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => $this->sesion , key => 'N'),
            array( campo => 'fmodificacion',tipo => 'DATE',id => '7',add => 'S', edit => 'S', valor =>  $this->hoy, key => 'N'),
            array( campo => 'estado',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'N', valor => 'N', key => 'N'),
            array( campo => 'tipo',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor => '-', key => 'N')
        );
        
        
        $this->anio       =  $_SESSION['anio'];
        
        
    }
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function div_resultado($accion,$id,$tipo,$estado,$id_compras){
        //inicializamos la clase para conectarnos a la bd
        
        echo '<script type="text/javascript">accion('.$id.',"'.$accion.'","'.trim($estado).'"  );</script>';
        
        
        if ($tipo == 0){
            
            if ($accion == 'editar'){
                $resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>EDITAR REGISTRO TRANSACCION ?</b>';
            }
            
            if ($accion == 'del'){
                $resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ELIMINAR REGISTRO TRANSACCION ?</b>';
            }
            
            //   echo '<script type="text/javascript">DetalleAsiento();</script>';
        }
        
        if ($tipo == 1){
            
            $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO ['.$id.']</b>';
            
            //	echo '<script type="text/javascript">DetalleAsiento();DetalleAsientoIR();</script>';
            
        }
        
        if ($tipo == 2){
            
            $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO ['.$id.']</b>';
            
        }
        
        
        
        return $resultado;
        
    }
    
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function div_limpiar( ){
        //inicializamos la clase para conectarnos a la bd
        
        $resultado = 'REGISTRO ELIMINADO / ANULADO';
        
        echo '<script type="text/javascript">';
        
        echo  'LimpiarPantalla();';
        
        echo '</script>';
        
        return $resultado;
        
    }
    //--------------------------------------------------------------------------------
    //--- busqueda de por codigo para llenar los datos
    //--------------------------------------------------------------------------------
    function flujo_tramite_det($numero3,$tarea ,$fecha_envio,$sesion_nombre){
        
        echo '<tr>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px;text-align: center">'.$numero3.'</td>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px">'.$tarea.'</td>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px;text-align: left">'.$fecha_envio.'</td>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px;text-align: left">'.$sesion_nombre.'</td>
            </tr>';
        
    }
     //--------------------------------------------------------------------------------
    //--- busqueda de por codigo para llenar los datos
    //--------------------------------------------------------------------------------
    function flujo_tramite($id ){
      
        
        ///----------- tramite presupuestario...----------------------------
        $x = $this->bd->query_array('presupuesto.view_pre_tramite','id_tramite, fecha,
                                            detalle, observacion, comprobante, estado,  documento,   planificado,
                                            solicita, unidad, user_crea,   user_asig, user_sol, control,sesion_control,
                                            proveedor,  telefono, correo, movil, fcompromiso, fcertifica, fdevenga,   estado_presupuesto',
            'id_tramite='.$this->bd->sqlvalue_inyeccion($id,true)
            );
        
        //------------------ tramite contable -------------------
          $xy = $this->bd->query_array('co_asiento','fecha, detalle,  sesion,  comprobante,id_asiento',
                                     'id_tramite='.$this->bd->sqlvalue_inyeccion($id,true)
            );
        
          //------------------ tramite pagado  -------------------
          $yy = $this->bd->query_array('co_asiento','fecha, detalle,  sesion,  comprobante,id_asiento',
              'id_asiento_ref='.$this->bd->sqlvalue_inyeccion($xy['id_asiento'],true)
              );
          //------------------ tramite control  -------------------
          $yz = $this->bd->query_array('co_control','fecha, detalle,  motivo,  tipo,sesion',
              'idtramite='.$this->bd->sqlvalue_inyeccion($id,true)
              );
          //------------------ tramite anexos  -------------------
          $zz = $this->bd->query_array('co_compras','id_compras, id_asiento, fecharegistro,  idprov, detalle,sesion',
              'id_tramite='.$this->bd->sqlvalue_inyeccion($id,true)
              );
          
 
        
        $detalle      = trim($x['detalle'] );
        $fecha_texto  =  $x['fecha'] ;
        $fecha_texto1 =  $x['fcertifica'] ;
        $fecha_texto2 =  $x['fcompromiso'] ;
     
        
        $tabla_cabecera =  '<table width="100%" class="table1" border="0" cellspacing="0" cellpadding="0"> '.'<tr>
                            <td class="derecha" width="5%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1"></td>
                            <td class="derecha" width="50%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Detalle</td>
                            <td class="derecha" width="15%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Fecha</td>
                            <td class="derecha" width="20%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Responsable </td>
                            </tr>';
        
     
        
        echo $tabla_cabecera;
        
        $numero3        = ' <img src="../../kimages/tab_inicio.png">';
        $sesion_nombre  =   trim($x['user_sol']);
        
        $this->flujo_tramite_det($numero3,'<b>1. '.$detalle.'</b>',$fecha_texto,strtoupper($sesion_nombre));
        
        $numero3        = ' <img src="../../kimages/tab_tarea_b.png">';
        $detalle        = '2. Emision de Certificacion presupuestaria '. trim($x['comprobante']);
        $sesion_nombre  =   trim($x['user_crea']);
        $this->flujo_tramite_det($numero3,'<b>'.$detalle.'</b>',$fecha_texto1,strtoupper($sesion_nombre));
        
        $numero3        = ' <img src="../../kimages/tab_condicion.png">';
        $detalle        = '3. Proceso de Contratacion Publica '. trim($x['comprobante']);
        $sesion_nombre  = 'Unidad Administrativa';
        $this->flujo_tramite_det($numero3,'<b>'.$detalle.'</b>',$fecha_texto1,strtoupper($sesion_nombre));
        
        
        //-------------- proveedor  ------------------------
       
        if ($x['proveedor']){
            $numero3        = ' <img src="../../kimages/1480249187.png" align="absmiddle" >';
            $detalle        = $numero3.'  Proveedor adjudicado '. trim($x['proveedor']);
            $sesion_nombre  =  $x['user_asig'];
            $fecha_texto3   =  $x['fcompromiso'] ;
        }else{
            $numero3        = ' <img src="../../kimages/ok_no.png" align="absmiddle" >';
            $detalle        = $numero3.'  No existe Proveedor adjudicado ';
            $sesion_nombre  =  '';
            $fecha_texto3   = '' ;
        }
  
        $this->flujo_tramite_det('',$detalle,$fecha_texto3,strtoupper($sesion_nombre));
        
        
        
        
        $numero3        = ' <img src="../../kimages/tab_tarea_b.png">';
        $detalle        = '4. Solicitud de Emision de Compromiso Presupuestario '. trim($x['comprobante']);
        $sesion_nombre  = 'Unidad Financiera';
        $this->flujo_tramite_det($numero3,'<b>'.$detalle.'</b>',$fecha_texto2,strtoupper($sesion_nombre));
        
        
 
        //-------------- anexos ------------------------ 
    
        if ($zz['detalle']){
            $numero3        = ' <img src="../../kimages/1480249187.png" align="absmiddle" >';
            $detalle        = $numero3.'  Comprobante electronico emitido '. trim($zz['detalle']);
        }else{
            $numero3        = ' <img src="../../kimages/ok_no.png" align="absmiddle" >';
            $detalle        = $numero3.'  No existe comprobante electronico ';
        }
        
        $completo       = $this->bd->__user($zz['sesion']);
        $sesion_nombre  = $completo['completo'];
        $fecha_texto3   =  $zz['fecharegistro'] ;
        $this->flujo_tramite_det('',$detalle,$fecha_texto3,strtoupper($sesion_nombre));
        
        
        //-------------- control previo  ------------------------
          
        if (trim($x['control']) == 'N'){
            $numero3        = ' <img src="../../kimages/ok_no.png" align="absmiddle" >';
            $detalle        = $numero3.'  No existe control previo en el proceso tramite Nro.'. $id.' '.$yz['tipo'];
        }else{
            $numero3        = ' <img src="../../kimages/cedit.png" align="absmiddle" >';
            $detalle        = $numero3.'  Control previo realizado con exito tramite Nro.'. $id.' '.$yz['tipo'];
        }
        $fecha_texto2   = $yz['fecha'];
        $completo       = $this->bd->__user($yz['sesion']);
        $sesion_nombre  = $completo['completo'];
        $this->flujo_tramite_det('',$detalle,$fecha_texto2,strtoupper($sesion_nombre));
        
        
      
        $numero3        = ' <img src="../../kimages/tab_tarea_b.png">';
        if ($xy['detalle']){
            $detalle        = '5. Contabilidad - Devengado '. trim($xy['detalle']);
        }else{
            $detalle        = '5. TRAMITE POR DEVENGAR ';
        }
        
        $completo       = $this->bd->__user($xy['sesion']);
        $sesion_nombre  = $completo['completo'];
        $fecha_texto3   =  $xy['fecha'] ;
        $this->flujo_tramite_det($numero3,'<b>'.$detalle.'</b>',$fecha_texto3,strtoupper($sesion_nombre));
        
        
        
        $numero3 = ' <img src="../../kimages/tab_fin.png">';
        if ($yy['detalle']){
            $detalle        = '6. Tesoreria - Pagado '. trim($yy['detalle']);
        }else{
            $detalle        = '6. TRAMITE POR REALIZAR EL PAGO ';
        }
        
        $completo       = $this->bd->__user($yy['sesion']);
        $sesion_nombre  = $completo['completo'];
        $fecha_texto3   = $yy['fecha'] ;
        $this->flujo_tramite_det($numero3,'<b>'.$detalle.'</b>',$fecha_texto3,strtoupper($sesion_nombre));
        
        
         
        
     
        
        echo '</table>';
        
    }
    //--------------------------------------------------------------------------------
 
     
    
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;


if (isset($_GET['id_tramite']))	{
    
    $id_tramite    		    = $_GET['id_tramite'];
     
 
    $gestion->flujo_tramite($id_tramite);
    
}

 

?>
 
  
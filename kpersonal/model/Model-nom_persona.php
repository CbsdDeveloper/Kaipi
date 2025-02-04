<?php 
     session_start( );   
  
    require '../../kconfig/Db.class.php';   
 	
 	
    require '../../kconfig/Obj.conf.php';  
  
    require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
    
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
      
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function proceso( ){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                $this->bd	   =	new Db ;
                
                $this->set     = 	new ItemsController;
    
                $this->ruc       =  $_SESSION['ruc_registro'];
                $this->sesion 	 =  $_SESSION['email'];
                $this->hoy 	     =     date("Y-m-d");    
        
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
                
                
                $this->anio       =  $_SESSION['anio'];
     
                
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function div_resultado($accion,$id,$tipo){
 
 
      }
 
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function div_limpiar( ){
 
 
      }     
   
   
    	      
 //--------------------------------------------------------------------------------
    //--- busqueda de por codigo para llenar los datos
 //--------------------------------------------------------------------------------
 function consultaId($accion,$id ){
          
 	
  	
     $qquery = array( 
         array( campo => 'idprov',   valor => $id,  filtro => 'S',   visor => 'S'),
         array( campo => 'razon',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'direccion',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'telefono',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'correo',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'movil',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'idciudad',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'nombre',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'apellido',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'id_departamento',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'id_cargo',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'responsable',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'regimen',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'fecha',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'contrato',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'sueldo',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'unidad',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'cargo',   valor => '-',  filtro => 'N',   visor => 'S'),
          array( campo => 'fechan',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'nacionalidad',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'etnia',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'ecivil',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'vivecon',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'tsangre',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'unidad',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'cargas',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'cta_banco',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'id_banco',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'tipo_cta',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'sifondo',   valor => '-',  filtro => 'N',   visor => 'S'),
          array( campo => 'vivienda',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'salud',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'educacion',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'alimentacion',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'estudios',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'recorrido',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'titulo',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'carrera',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'tiempo',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'genero',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'emaile',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'fondo',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'vestimenta',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'foto',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'programa',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'sidecimo',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'fecha_salida',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'motivo',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'sicuarto',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'sihoras',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'sisubrogacion',   valor => '-',  filtro => 'N',   visor => 'S')
           );
     
   
 
       $datos = $this->bd->JqueryArrayVisorDato('view_nomina_rol',$qquery );           
 
        
       
       $this->titulo();
       
       $this->set->div_panel('<h6> Informacion Personal - Laboral Funcionario<h6>');
       
       $this->etiqueta('Apellido y Nombre', $datos['razon'],'S');
       $this->etiqueta('Identificacion', $datos['idprov'],'S');
       $this->etiqueta('Direccion', $datos['direccion'],'N');
       
       $this->etiqueta('Telefono Convencional', $datos['telefono'],'N');
       $this->etiqueta('Correo Electronico', $datos['correo'],'N');
       $this->etiqueta('Telefono Movil', $datos['movil'],'N');
       
       $this->etiqueta('', 'INFORMACION LABORAL','S');
       
       $this->etiqueta('Regimen', $datos['regimen'],'S');
       $this->etiqueta('Programa', $datos['programa'],'S');
       $this->etiqueta('Unidad', $datos['unidad'],'N');
       $this->etiqueta('Cargo', $datos['cargo'],'N');
       $this->etiqueta('Ingreso', $datos['fecha'],'N');
 
       $this->set->div_panel('fin');
       
       $this->set->div_panel('<h6> Informacion Roles de Pago - Periodo<h6>');
       
       $this->GestionValor(trim($id) );
     
       $this->set->div_panel('fin');
       
       
       $this->set->div_panel('<h6> Informacion Detalle Ingresos - Descuentos<h6>');
       
       $this->GestionValorDescuentos(trim($id) );
       
       $this->set->div_panel('fin');
       
       
 
       
       $this->set->div_panel('<h6> Resumen Vacaciones/Permisos<h6>');
       
       $this->GestionValorVacacion(trim($id) );
       
       $this->set->div_panel('fin');
       
       
       $this->set->div_panel('<h6> Resumen Bienes Asignados<h6>');
       
       $this->GestionValorBIenes(trim($id) );
       
       $this->set->div_panel('fin');
       
      
      }	
  
      //--------------------------------------------------------------------------------
      //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
      //--------------------------------------------------------------------------------        
 
     function etiqueta($nombre,$valor,$negrita){
          
         if ( $negrita == 'S'){
             $valor_datos = '<b>'.trim($valor).'</b>';
         }else{
             $valor_datos = trim($valor);
         }
         
 
         echo '<div style="padding: 2px;font-size: 13px" class="col-md-3"> '.$nombre.'</div>'.'<div style="padding: 2px;font-size: 13px" class="col-md-9">'.$valor_datos.'</div>';
              
 
     }  
     //--------------------------------------------------------------------------------
     function GestionValor($idprov ){
            
         $sql = " SELECT b.novedad  , sum(a.ingreso) as ingreso,sum(a.descuento) as egreso,
                 sum(a.ingreso) - sum(a.descuento) as apagar
                FROM view_rol_personal a, nom_rol_pago b
                where a.idprov =".$this->bd->sqlvalue_inyeccion($idprov,true)."  and 
                      a.id_rol = b.id_rol and b.anio =".$this->bd->sqlvalue_inyeccion($this->anio ,true)." 
                group by a.id_rol,b.novedad
                order by a.id_rol";
                         
          
         
         $tipo = $this->bd->retorna_tipo();
         
         $resultado  = $this->bd->ejecutar($sql);
         
         $cabecera =  "Periodo Rol,Ingresos,Descuentos, A Pagar";
         
         $evento   = "";
         
         $this->obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
         
         
     }
     //--------------------------------------------------------------------------------
     function GestionValorBIenes($idprov ){
         
         $sql = " SELECT clase, count(*) as bienes ,sum(costo_adquisicion) as costo
                FROM activo.view_bienes
                where idprov =".$this->bd->sqlvalue_inyeccion($idprov,true)."  
                group by clase ";
         
 
         
         $tipo = $this->bd->retorna_tipo();
         
         $resultado  = $this->bd->ejecutar($sql);
         
         $cabecera =  "Bienes Asignados,Nro.Bienes, Costo Adquisicion";
         
         $evento   = "";
         
         echo '<div class="col-md-6">';
         
         $this->obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
         
         echo '</div>';
         
         
     }
     //--------------------------------------------------------------------------------
     function GestionValorDescuentos($idprov ){
         
         $sql = " SELECT a.nombre  , sum(a.ingreso) as ingreso 
                FROM view_rol_personal a, nom_rol_pago b
                where a.idprov =".$this->bd->sqlvalue_inyeccion($idprov,true)."  and
                      a.id_rol = b.id_rol and b.anio =".$this->bd->sqlvalue_inyeccion($this->anio ,true)." and
                      a.tipo = 'I'
                 group by a.nombre";
         
         
             
         $tipo = $this->bd->retorna_tipo();
         
         $resultado  = $this->bd->ejecutar($sql);
         
         $cabecera =  "Detalle Ingresos,Monto Ingresos";
         
         $evento   = "";
         
         //--------------- ingresoss 
         
         
         echo '<div class="col-md-6">';
         
            $this->obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
         
         echo '</div>';
         
         
         
         $sql = " SELECT a.nombre  , sum(a.descuento) as egreso
                FROM view_rol_personal a, nom_rol_pago b
                where a.idprov =".$this->bd->sqlvalue_inyeccion($idprov,true)."  and
                      a.id_rol = b.id_rol and b.anio =".$this->bd->sqlvalue_inyeccion($this->anio ,true)." and
                      a.tipo = 'E'
                 group by a.nombre";
         
         
         
         $tipo = $this->bd->retorna_tipo();
         
         $resultado1  = $this->bd->ejecutar($sql);
         
         $cabecera =  "Detalle Descuentos,Monto Descuentos";
         
         
         echo '<div class="col-md-6">';
         
         $this->obj->table->table_basic_js($resultado1,$tipo,'','',$evento ,$cabecera);
         
         echo '</div>';
         
     }
     //--------------------------------------------------------------------------------
     function GestionValorVacacion($idprov ){
         
         $sql = " SELECT motivo, sum(dia_tomados) nro_dias, sum(hora_tomados) nro_horas
                FROM view_nomina_vacacion
                where idprov =".$this->bd->sqlvalue_inyeccion($idprov,true)."  and
                      anio =".$this->bd->sqlvalue_inyeccion($this->anio ,true)." and
                      tipo = 'vacacion'
                 group by motivo";
         
 
         
         $tipo = $this->bd->retorna_tipo();
         
         $resultado  = $this->bd->ejecutar($sql);
         
         $cabecera =  "Detalle Motivo,Nro.Dias,Nro.Horas";
         
         $evento   = "";
         
         //--------------- ingresoss
         
         
         echo '<div class="col-md-6"><h4>Vacaciones</h4>';
         
         $this->obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
         
         echo '</div>';
         
         
         
         $sql = " SELECT motivo, sum(dia_tomados) nro_dias, sum(hora_tomados) nro_horas
                FROM view_nomina_vacacion
                where idprov =".$this->bd->sqlvalue_inyeccion($idprov,true)."  and
                      anio =".$this->bd->sqlvalue_inyeccion($this->anio ,true)." and
                      tipo = 'permiso'
                 group by motivo";
         
         
         
         $tipo = $this->bd->retorna_tipo();
         
         $resultado1  = $this->bd->ejecutar($sql);
         
         $cabecera =  "Detalle Motivo,Nro.Dias,Nro.Horas";
         
         
         echo '<div class="col-md-6"><h4>Permisos</h4>';
         
         $this->obj->table->table_basic_js($resultado1,$tipo,'','',$evento ,$cabecera);
         
         echo '</div>';
         
     }
     //---------------
     function titulo( ){
         
         
         $this->hoy 	     =  date("Y-m-d");
         
         $this->login     =  trim($_SESSION['login']);
 
         
         echo '<table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                   <td  width="80%" rowspan="4" style="text-align:left"><b>'.$_SESSION['razon'].'</b><br>
                        <b>'.$_SESSION['ruc_registro'].'</b><br><br>
                        <b>HISTORIA LABORAL ( PERIODO '.$this->anio.' ) </b><br> </td>
                  <td  width="20%">&nbsp;</td>
                </tr>
                <tr>
                  <td>FECHA '.$this->hoy .'<br>
                     USUARIO '.$this->login.' <br>
                     REPORTE</td>
                </tr>
 	   </table>';
         
     }
   
 }    
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 
 
    $gestion   = 	new proceso;
    
 
    //------ poner informacion en los campos del sistema
     if (isset($_GET['accion']))	{
            
            $accion    = $_GET['accion'];
            
            $id        = $_GET['id'];
            
            $gestion->consultaId($accion,$id);
     }  
  
 
    
  
     
   
 ?>
 
  
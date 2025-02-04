<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
    
    private $obj;
    private $bd;
    
    private $ruc;
    public  $sesion;
    public  $hoy;
    private $POST;
    private $ATabla;
    private $tabla ;
    private $secuencia;
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function proceso( ){
        
        //inicializamos la clase para conectarnos a la bd
        
        $this->obj     = 	new objects;
        $this->bd	   =	new Db ;
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        
        $this->sesion 	 =  trim($_SESSION['email']);
        
        $this->hoy 	     =  date("Y-m-d");  
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
        
        
    }
    
    
    //--------------------------------------------------------------------------------
    //--- busqueda de por codigo para llenar los datos
    //--------------------------------------------------------------------------------
    function CargarArchivoTemp($id ){
        
      
        
        $sql = "SELECT count(*) as nn
						FROM flow.wk_procesoflujo
						WHERE idproceso = ".$this->bd->sqlvalue_inyeccion($id ,true);
        
        $resultado  = $this->bd->ejecutar($sql);
        $datos      = $this->bd->obtener_array($resultado);
        $nexiste    =  $datos['nn'];
        //----------------------------------------------------------------------------
       
        
        if ($nexiste > 0 ){
            $Viewtareas = '';
        }
        else{
            
            $flujo = $this->bd->query_array('flow.wk_proceso',
                'archivo',
                'idproceso='.$this->bd->sqlvalue_inyeccion($id,true)
                );
            
            $folder = '../flujo/'.rtrim($flujo['archivo']);
            
            
            $file = fopen($folder , "r") or exit("Unable to open file!");
            
            $i = 1;
            
            $loop = 0;
            
            $Valida = '[Not supported by viewer]';
            
            while(!feof($file))
            {
               
                $line = stream_get_line($file,10240, "<switch>");
                
                 
                $InsertQuery = array(
                    array( campo => 'idprocesod',   valor => $i),
                    array( campo => 'idproceso',   valor => $id),
                    array( campo => 'sesion',   valor => $this->sesion  ),
                    array( campo => 'grafico',   valor => $line )
                );
                
                 $this->bd->pideSq('0');
                 
                 $encuentra = stristr($line, $Valida) ;
                 
                 if(!empty($encuentra)) {
                     $loop = 1;
                 }
                 
                 if ( $loop == 0) {
                     $this->bd->JqueryInsertSQL('flow.wk_procesotemp',$InsertQuery);
                 }
                
         
                  
                $i ++;
                $Viewtareas .= $Viewtareas;
            }
            
            fclose($file);
            
            $Viewtareas = 'VERIFIQUE LA INFORMACION DEL FLUJO (NO DEBE CONTENER CARACTERES ESPECIALES)';
 
            if ( $loop == 0) {
                
                $this->DibujarProceso( $id   );
                
                $Viewtareas = 'Procesado<br>';
                
                $this->valida_nombre($id);
                
            }
               
  
}
        
     
        
        echo  $Viewtareas;
        
    }
    //--------------------------
    
    function DibujarProceso( $id   ){
        
        // COLOCA LA INFORMACI�N PARA CREAR EL PROCESO
        
        $sql = "SELECT grafico, idproceso, sesion,idprocesod,LENGTH(grafico) as longitud
  				    FROM flow.wk_procesotemp
    			  WHERE idproceso = ".$id.' order by idprocesod ' ;
        
        $stmt = $this->bd->ejecutar($sql);
        
        $i= 1;
        
         
        
        while ($x=$this->bd->obtener_fila($stmt)){
            
     
            $linea			  = trim($x['grafico']);
            
            $nombreproceso	  = $this->nombreproceso($linea);
            
            $secuenciaid = 0;
            
            if( $nombreproceso <> 'NO') {
                
                $secuencia		= $this->ordensecuencia(trim($nombreproceso),$linea,$secuenciaid);
                
            }else {
                $secuencia = 0;
                
            }
            
            $nombreurl = $nombreproceso;
         
            if (   $i == 1 )  {
                $linea 			=  trim($x['grafico']);
            }else {
                $linea 			= '<switch>'.trim($x['grafico']);
            }
            
            $actual			= trim($nombreurl);
            
            $UrlFlow        =  '<a href="#">'.$actual.'</a>';
            $UrlVisor       =  '<a href="'."javascript:Visor(".$secuencia.")".'">'.$actual.'</a>';
            $Ejecuta		=  '<a href="'."javascript:Ejecuta(".$secuencia.")".'">'.$actual.'</a>';
            
            
            if ( $secuencia == 0){
                $parametro1     = $linea;
                $ejecucion1     = $linea;
                $visor          = $linea;
                $nombreproceso = '-';
            }else{
                $parametro1     = str_replace ( $actual, $UrlFlow,$linea );
                $ejecucion1     = str_replace ( $actual, $Ejecuta,$linea );
                $visor          = str_replace ( $actual, $UrlVisor,$linea );
            }
            
            
 
            
            $InsertQuery = array(
                array( campo => 'idproceso',   valor =>    $id ),
                array( campo => 'secuencia',   valor =>   $i),
                array( campo => 'idprocesoflujo',   valor =>   $i),
                array( campo => 'idtarea',   valor => $secuencia),
                array( campo => 'ejecucion',   valor => $ejecucion1),
                array( campo => 'visor',   valor => $visor),
                array( campo => 'sesion',   valor =>$this->sesion  ),
                array( campo => 'original',   	valor =>$linea ),
                array( campo => 'tarea',   valor =>trim($nombreproceso)),
                array( campo => 'parametro',   valor => $parametro1)
            );
            
           $this->bd->JqueryInsertSQL('flow.wk_procesoflujo',$InsertQuery);
            
            
         
            $i++; 
     
        
        }
        
        $sql = "DELETE
  				FROM flow.wk_procesotemp
    			WHERE idproceso = ".$id ;
        
        $this->bd->ejecutar($sql);
    
    }
    
    
    
    //--------------------------------------------------------------------------------
    //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
    //--------------------------------------------------------------------------------
    
    function nombreproceso($linea){
        
        $parrafo    = explode("<text",trim($linea));
      
             
        $parrafo2   = trim($parrafo['1']);
             
        
        $parrafoSecuencia    = explode("[",trim($parrafo2));
        
        
       $parrafoNombre =   trim($parrafoSecuencia['1']);
        
       $parrafoSecuencia    = explode("]",trim($parrafoNombre));
        
       $parrafoTarea = trim($parrafoSecuencia['0']);
        
 
       $posicion_coincidencia = strpos($parrafoTarea, '...');
       
      //-------------------- verifica la version del sgv 
        
       if ($posicion_coincidencia > 0){
 
           
           $textofinal='NO';
           
           $parrafo    = explode("]</div>",trim($linea));
           
           $parrafoNombre =   trim($parrafo[0]);
           
           $parrafoSecuencia    = explode("[",trim($parrafoNombre));
      
           $parrafoTarea = trim($parrafoSecuencia[1]);
           
           $longitud  = strlen($parrafoTarea);
           
           if ($longitud > 5){
               
               $textofinal =$parrafoTarea;
               
           }else{
               $textofinal='NO';
           }
           
           
       }else {
           if (!empty($parrafoTarea)){
               
               $textofinal =$parrafoTarea;
               
           }else{
               $textofinal='NO';
           }
       }
        
        
        
 
        return $textofinal;
    }
    //------------
    function nombreurl($linea){
        
        $parrafo    = explode(".-",trim($linea));
        
        $parrafo1 = trim($parrafo['0']);
        
        $parrafo2 = trim($parrafo['1']);
        
        $parrafoSecuencia    = explode(">",trim($parrafo1));
        
        $num_tags = count($parrafoSecuencia) -1;
        
        $secuencia = $parrafoSecuencia[$num_tags] ;
        
        
        $parrafotexto    = explode(".",trim($parrafo2));
        
        
        $url = $parrafotexto[0];
        
        $parrafourl    = explode("</tspan>",trim($url));
        
        if (!empty($secuencia)){
            
            $texto =   $parrafourl['0'];
            
            $textofinal = trim($secuencia).".-".trim($texto);
            
        }else{
            $textofinal='NO';
        }
        
        
        
        return $textofinal;
    }
    //--------------------------------------------------------------------------------
    //--- eliminar de registros
    function ordenproceso($linea){
        
        
        // a xlink:href="javascript(1)">
        $parrafo    = explode(")",trim($linea));
        $cadenaurl  = trim($parrafo['0']);
        $parrafoUr2 = explode("(",trim($cadenaurl));
        $nombreproceso= htmlentities ($parrafoUr2[1]);
        
        return $nombreproceso;
        
        
    }
    function valida_nombre($id_proceso){
        
 
 
        $sql1 = ' SELECT   idproceso,   tarea, idprocesoflujo
        FROM flow.wk_procesoflujo
        where idproceso='.$this->bd->sqlvalue_inyeccion($id_proceso,true).' and idtarea > 0';

 
    
        $stmt1 = $this->bd->ejecutar($sql1);
     
    
        while ($fila=$this->bd->obtener_fila($stmt1)){
        
            $parrafo1        = trim($fila['tarea']);
            
            $parrafo        = explode("]",trim($parrafo1));
       
            $idprocesoflujo = $fila['idprocesoflujo'];
        
            $sqle = 'update flow.wk_procesoflujo
                        set tarea = '.$this->bd->sqlvalue_inyeccion($parrafo[0],true).' 
                      where idprocesoflujo='.$this->bd->sqlvalue_inyeccion($idprocesoflujo,true).' and  
                            idproceso='.$this->bd->sqlvalue_inyeccion($id_proceso,true);
            
            
            $this->bd->ejecutar($sqle);
            
        }
    
        
 
        
        
    }
    //--------------------------------------------------------------------------------
    //--- eliminar de registros
    function ordensecuencia($nombreurl,$linea,$secuenciaid){
        
       // $parrafo    = explode(".-",trim($linea));
        
        $parrafo    = explode(".-",trim($nombreurl));
        
        
        $parrafo1 = trim($parrafo['0']);
        
        
        
        if (empty($parrafo1)){
            
            $nombreproceso = 0;
            
        }else{
            
            $nombreproceso = $parrafo1;
            
        }
        
        return $nombreproceso;
        
        
    }
    
    
    
    //--------------------------------------------------------------------------------
    function ProcesoNombre($id){
        
        
        $flujo = $this->bd->query_array('flow.view_proceso',
            'nombre, idproceso, responsable, completo, id_departamento, unidad,
				 objetivo, tipo, alcance, entrada, salida, publica,indicador',
            'idproceso='.$this->bd->sqlvalue_inyeccion($id,true)
            );
        
        
        $ViewProceso = '<div class="panel panel-default">
				        <div class="panel-body">
					       <h3><b><img src="../controller/1p.png"/ align="absmiddle"> '.$flujo['nombre'].'</b></h3> ';
        
        
        $ViewProceso .= '<div class="col-md-9">
                            <div class="col-md-3" style="padding: 2px;font-size: 13px">REFERENCIA</div> <div class="col-md-9" style="padding: 2px;font-size: 13px">'. $flujo['idproceso'].'</div>
                           <div class="col-md-3" style="padding: 2px;font-size: 13px">RESPONSABLE</div> <div class="col-md-9" style="padding: 2px;font-size: 13px">'. $flujo['completo'].'</div>
                           <div class="col-md-3" style="padding: 2px;font-size: 13px">DEPARTAMENTO</div> <div class="col-md-9" style="padding: 2px;font-size: 13px">'. $flujo['unidad'].'</div>
                        <div class="col-md-3" style="padding: 2px;font-size: 13px">OBJETIVO</div> <div class="col-md-9" style="padding: 2px;font-size: 13px">'. $flujo['objetivo'].'</div>
                        <div class="col-md-3" style="padding: 2px;font-size: 13px">PROCESO</div> <div class="col-md-9" style="padding: 2px;font-size: 13px">'. $flujo['tipo'].'</div>
                        <div class="col-md-3" style="padding: 2px;font-size: 13px">AUTORIZADO</div> <div class="col-md-9" style="padding: 2px;font-size: 13px">'. $flujo['publica'].'</div>';
 
        
        $ViewProceso .= '</div></div></div>';
        
        echo $ViewProceso;
        
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
if (isset($_GET['id']))	{
    
    
    $id        = $_GET['id'];
    
    $gestion->CargarArchivoTemp($id);
    
    $gestion->ProcesoNombre($id);
    
    

    
    
}




?>
 
  
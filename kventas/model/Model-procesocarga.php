<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
    
    //creamos la variable donde se instanciar la clase "mysql"
    
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
        
        $this->ruc       =     $_SESSION['ruc_registro'];
        
        $this->sesion 	 =  $_SESSION['email'];
        
        $this->hoy 	     =  date("Y-m-d");    	//$this->hoy 	     =  $this->bd->hoy();
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
        
        
    }
    
    
    //--------------------------------------------------------------------------------
    //--- busqueda de por codigo para llenar los datos
    //--------------------------------------------------------------------------------
    function CargarArchivoTemp($id ){
        
        
        
        $sql = "SELECT count(*) as nn
						FROM wk_procesoflujo
						WHERE idproceso = ".$this->bd->sqlvalue_inyeccion($id ,true);
        
        $resultado  = $this->bd->ejecutar($sql);
        $datos      = $this->bd->obtener_array($resultado);
        $nexiste    =  $datos['nn'];
        //----------------------------------------------------------------------------
        
        if ($nexiste > 0 ){
            $Viewtareas = 'Ya generado<br>';
        }
        else{
            $flujo = $this->bd->query_array('wk_proceso',
                'archivo',
                'idproceso='.$this->bd->sqlvalue_inyeccion($id,true)
                );
            
            $folder = '../flujo/'.rtrim($flujo['archivo']);
            
            
            $file = fopen($folder , "r") or exit("Unable to open file!");
            
            $i = 1;
            
            $loop = 0;
            
            while(!feof($file))
            {
                $line = stream_get_line($file,10240, '<g');
                
                $InsertQuery = array(
                    array( campo => 'idprocesod',   valor => $i),
                    array( campo => 'idproceso',   valor => $id),
                    array( campo => 'sesion',   valor => $this->sesion  ),
                    array( campo => 'grafico',   valor => $line )
                );
                
                $this->bd->JqueryInsertSQL('wk_procesotemp',$InsertQuery);
                
                $i ++;
            }
            
            fclose($file);
            
             $this->DibujarProceso( $id   );
            
            $Viewtareas = 'Procesado<br>';
        }
        
        
        
        $Viewtareas = 'Procesado<br>';
        
    }
    //--------------------------
    
    function DibujarProceso( $id   ){
        
        // COLOCA LA INFORMACI�N PARA CREAR EL PROCESO
        
        $sql = "SELECT grafico, idproceso, sesion,idprocesod
  				    FROM wk_procesotemp
    			  WHERE idproceso = ".$id.' order by idprocesod ' ;
        
        $stmt = $this->bd->ejecutar($sql);
        
        $i= 1;
        
        while ($x=$this->bd->obtener_fila($stmt)){
            
            
            $linea			  = trim($x['grafico']);
            
            $nombreproceso	  = $this->nombreproceso($linea);
                
             
            if( $nombreproceso <> 'NO') {
                
                $nombreurl	    = trim($nombreproceso) ; //$this->nombreurl($linea);
                 
                $secuencia		= $this->ordensecuencia(trim($nombreurl),$linea,$secuenciaid);
                
                $linea 			= '<g '.trim($x['grafico']);
                
                $actual			= trim($nombreurl);
                
                $UrlFlow        =  '<a href="#">'.$actual.'</a>';
                $UrlVisor       =  '<a href="'."javascript:Visor(".$secuencia.")".'">'.$actual.'</a>';
                $Ejecuta		=  '<a href="'."javascript:Ejecuta(".$secuencia.")".'">'.$actual.'</a>';
                
                if (trim($nombreproceso) == 'NO'){
                    $parametro1     = $linea;
                    $ejecucion1     = $linea;
                    $visor          = $linea;
                    $nombreproceso = '-';
                }else{
                    $parametro1     = str_replace ( $actual, $UrlFlow,$linea );
                    $ejecucion1     = str_replace ( $actual, $Ejecuta,$linea );
                    $visor          = str_replace ( $actual, $UrlVisor,$linea );
                }
                
                
            } else {
                if (  $i == 1 ){
                    $parametrosLinea  = $linea;
                    $parametro1		  =  $linea;
                    $visor			  = $linea;
                    $ejecucion1		  = $linea;
                }else{
                    $parametrosLinea  = '<g '.$linea;
                    $parametro1		  = '<g '.$linea;
                    $visor			  = '<g '.$linea;
                    $ejecucion1		  = '<g '.$linea;
                }
                $variabletarea[1] = '-';
                $variableId[1]    = 0;
                $secuencia        = 0;
            }
            
            
            
            $secuenciaid =  $x['idprocesod'];
            
            
            $InsertQuery = array(
                array( campo => 'idproceso',   valor =>    $id ),
                array( campo => 'secuencia',   valor =>  $secuenciaid),
                array( campo => 'idprocesoflujo',   valor =>  $secuenciaid),
                array( campo => 'idtarea',   valor => $secuencia),
                array( campo => 'ejecucion',   valor => $ejecucion1),
                array( campo => 'visor',   valor => $visor),
                array( campo => 'sesion',   valor =>$this->sesion  ),
                array( campo => 'original',   	valor =>$linea ),
                array( campo => 'tarea',   valor =>trim($nombreproceso)),
                array( campo => 'parametro',   valor => $parametro1)
            );
            
           $this->bd->JqueryInsertSQL('wk_procesoflujo',$InsertQuery);
            
            
            $i++;
        }
        
        
        $sql = "DELETE
  				FROM wk_procesotemp
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
        
 
        
        if (!empty($parrafoTarea)){
             
            $textofinal =$parrafoTarea;
            
        }else{
            $textofinal='NO';
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
        
        
        $flujo = $this->bd->query_array('view_proceso',
            'nombre, idproceso, responsable, completo, id_departamento, unidad,
				 objetivo, tipo, alcance, entrada, salida, publica,indicador',
            'idproceso='.$this->bd->sqlvalue_inyeccion($id,true)
            );
        
        
        $ViewProceso = '<div class="panel panel-default">
				        <div class="panel-body">
					       <h4><b><img src="../controller/1p.png"/ align="absmiddle"> '.$flujo['nombre'].'</b></h4> ';
        
        
        $ViewProceso .= 'REFERENCIA:&nbsp;&nbsp;&nbsp;&nbsp;'. $flujo['idproceso'].'<br>'.
            'RESPONSABLE: &nbsp;&nbsp;&nbsp;&nbsp;'. $flujo['completo'].'<br>'.
            'DEPARTAMENTO: &nbsp;&nbsp;&nbsp;&nbsp;'. $flujo['unidad'].'<br><br>'.
            'OBJETIVO: &nbsp;&nbsp;&nbsp;&nbsp;'. $flujo['objetivo'].'<br>'.
            'PROCESO: &nbsp;&nbsp;&nbsp;&nbsp;'. $flujo['tipo'].'<br>'.
            'AUTORIZADO:&nbsp;&nbsp;&nbsp;&nbsp;'. $flujo['publica'];
        
        
        $ViewProceso .= '</div></div>';
        
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
 
  
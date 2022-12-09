<?php 
session_start();   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
   
 class componente{
 
  
      private $obj;
      private $bd;
      private $set;
      
       private $formulario;
       private $evento_form;
          
      private $ruc;
      private $sesion;
      private $hoy;
      private $POST;
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function componente( ){
           
                $this->obj     = 	new objects;
                     
                $this->bd	   =	     	new Db ;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
     }
  
   //----------------------------------------------
      function principal($idepartamento,$anio,$pmes){
      
  
          $sql1 = "SELECT idcaso , caso , count(*) as nn
                    FROM flow.view_archivo
                    where anio=".$this->bd->sqlvalue_inyeccion($anio,true)."  and 
                          id_departamento_caso = ".$this->bd->sqlvalue_inyeccion($idepartamento,true)." and 
                          mes = ".$this->bd->sqlvalue_inyeccion($pmes,true)." 
                    group by idcaso , caso
                    order by idcaso desc";
          
        $stmt1 = $this->bd->ejecutar($sql1);
          
          
          while ($fila=$this->bd->obtener_fila($stmt1)){
              
              $idcaso  =  $fila['idcaso'];
              $caso1   =  trim($fila['caso']);
               
              $datos = $this->bd->query_array('flow.view_proceso_caso',
                  'nombre_solicita,estado_tramite',
                  'idcaso='.$this->bd->sqlvalue_inyeccion($idcaso,true)  
                  );
              
              $nombre_solicita = trim($datos['nombre_solicita']);
              $estado_tramite  = trim($datos['estado_tramite']);
               
              
              echo ' <div style="float: left;padding: 10px;position: relative;width:15%;" align="center" >
                        <a data-toggle="modal" data-target="#myModalMemo" onClick="DetalleArchivo('.$idcaso.')"  title = "'.$caso1.'" href="#">
				       <img src="../../kimages/1434650725_folder-new.png" align="absmiddle"/><br> 
					 Tramite<br><b> '.$idcaso.'</b><br>'.$nombre_solicita.'/'.$estado_tramite.
                    '</a></div>';
              
          }
           
          
   }  
  //------------------
   function principal_cadena($anio,$ccodigo,$casunto){
         
       $len1            = strlen($casunto);
       $casunto_filtro  = '%'.strtoupper($casunto).'%';
       
       $nbandera        = 0;
       
       if ( $ccodigo > 0 ) {
           
           $sql1 = "SELECT idcaso , caso , count(*) as nn
                    FROM flow.view_archivo
                    where anio=".$this->bd->sqlvalue_inyeccion($anio,true)."  and
                          idcaso = ".$this->bd->sqlvalue_inyeccion($ccodigo,true)."
                    group by idcaso , caso
                    order by idcaso desc";
           $nbandera = 1;
           
       }
       
       if ( $len1 > 3 ){
           
           $sql1 = "SELECT idcaso , caso , count(*) as nn
                    FROM flow.view_archivo
                    where anio=".$this->bd->sqlvalue_inyeccion($anio,true)."  and
                          caso like ".$this->bd->sqlvalue_inyeccion($casunto_filtro,true)."
                    group by idcaso , caso
                    order by idcaso desc";
           $nbandera = 1;
       }
       
       if ( $nbandera == 1 ){
           
                    $stmt1 = $this->bd->ejecutar($sql1);
           
                    while ($fila=$this->bd->obtener_fila($stmt1)){
                        
                        $idcaso  =  $fila['idcaso'];
                        $caso1   =  trim($fila['caso']);
                        
                        $datos = $this->bd->query_array('flow.view_proceso_caso',
                            'nombre_solicita,estado_tramite',
                            'idcaso='.$this->bd->sqlvalue_inyeccion($idcaso,true)
                            );
                        
                        $nombre_solicita = trim($datos['nombre_solicita']);
                        $estado_tramite  = trim($datos['estado_tramite']);
                        
                        echo ' <div style="float: left;padding: 10px;position: relative;width:15%;" align="center" >
                        <a data-toggle="modal" data-target="#myModalMemo" onClick="DetalleArchivo('.$idcaso.')"  title = "'.$caso1.'" href="#">
				       <img src="../../kimages/1434650725_folder-new.png" align="absmiddle"/><br>
					 Tramite<br> <b>'.$idcaso.'</b><br>'.$nombre_solicita.'/'.$estado_tramite.
					 '</a></div>';
                        
                    }
       }
  //-------------------------- 
    } 
  }
     
  $gestion   = 	new componente;
 
     	
  	$idproceso        = $_GET['departamento'];
  	$anio             = $_GET['anio'];
  	$accion           = $_GET['accion'];
  	$ccodigo          = $_GET['ccodigo'];
  	$casunto          = $_GET['casunto'];
  	$pmes             = $_GET['pmes'];
  	

  	if ($accion == 1){
  	    $gestion->principal_cadena($anio,$ccodigo,$casunto);
  	}else {
  	    $gestion->principal($idproceso,$anio,$pmes);
  	}
  	
 
 
?>
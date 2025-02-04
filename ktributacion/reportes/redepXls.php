<?php
 
    session_start( );  
 
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
     
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
    $obj     = 	new objects;
    
     $bd     = 	new Db;
    
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
    
 
  
     if (isset($_GET['anio']))	
     {
          $anio =  $_GET['anio']; 
       
            
          $cadena1 =" '''' "; 
          $cadena =" '   ' ";
          
          $sql = "SELECT ANIO,
								   NUMRUC, BENGALPG, 
								   TIPIDRET, IDRET, APELLIDOTRAB, 
								   NOMBRETRAB, ESTAB, RESIDENCIATRAB, 
								   PAISRESIDENCIA, APLICACONVENIO, TIPOTRABAJDISCAP, 
								   PORCENTAJEDISCAP, TIPIDDISCAP, IDDISCAP, 
								   SUELSAL, SOBSUELCOMREMU, PARTUTIL, 
								   INTGRABGEN, IMPRENTEMPL, DECIMTER, 
								   DECIMCUAR, FONDORESERVA, SALARIODIGNO, 
								   OTROSINGRENGRAV, INGGRAVCONESTEEMPL, SISSALNET, 
								   APOPERIESS, APORPERIESSCONOTROSEMPLS, DEDUCVIVIENDA, 
								   DEDUCSALUD, DEDUCEDUCA, DEDUCALIEMENT, 
								   DEDUCVESTIM, EXODISCAP, EXOTERED, 
								   BASIMP, IMPRENTCAUS, VALRETASUOTROSEMPLS, 
								   VALIMPASUESTEEMPL, VALRET, 
								   REMUNCONTRESTEMPL, REMUNCONTROTREMPL, EXONREMUNCONTR, 
								   TOTREMUNCONTR, NUMMESTRABCONTRESTEMPL, NUMMESTRABCONTROTREMPL, 
								   TOTNUMMESTRABCONTR, REMUNMENPROMCONTR, NUMMESCONTRGENESTEMPL, 
								   NUMMESCONTRGENOTREMPL, TOTNUMMESCONTRGEN, TOTCONTRGEN, 
								   CREDTRIBDONCONTROTREMPL, CREDTRIBDONCONTRESTEMPL, CREDTRIBDONCONTRNOESTEMPL, 
								   TOTCREDTRIBDONCONTR, CONTRPAG, CONTRASUOTREMPL, 
								   CONTRRETOTREMPL, CONTRASUESTEMPL, CONTRRETESTEMPL
								FROM RDEP 
                WHERE ANIO =  ".$anio.'  
                order by APELLIDOTRAB';
                
       }
       
  
       
    $resultado  = $bd->ejecutar($sql);
    
    $tipo 		= $bd->retorna_tipo();
    
    $tbHtml = $obj->grid->KP_GRID_EXCEL($resultado,$tipo); 
  
    header ('Content-type: text/html; charset=utf-8');
    header("Content-type: application/octet-stream");
 	header("Content-Disposition: attachment; filename=ResumenRdep.xls");
	header("Pragma: no-cache");
	header("Expires: 0"); 

 
 	echo $tbHtml; 
    
    
?>
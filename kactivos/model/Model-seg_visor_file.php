<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

     
    $obj     = 	new objects;
    $bd	   =	new Db ;
    
    $ruc       =    $_SESSION['ruc_registro'];
    $sesion 	 =  $_SESSION['email'];
   
 
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
    
    $idunidad     = $_GET['idunidad'];
    
    $tipo 		= $bd->retorna_tipo();
    
    
    $Aperfil = $bd->query_array('par_usuario','archivo', 'email='.$bd->sqlvalue_inyeccion($sesion,true));
    
    
    if ( $Aperfil['archivo'] == 'publico'){
  
        $sql = 'SELECT  fecha, evento, 
                        responsable,
                        publicado, file_archivo, 
                        unidad, id_departamento, 
                        detalle, referencia, tipo, origen, modulo, archivo
          FROM view_seg_file
          where id_departamento = '.$bd->sqlvalue_inyeccion($idunidad ,true).' order by referencia desc'     ;
    }
    
    if ( $Aperfil['archivo'] == 'privado'){
        
        $sql = 'SELECT  fecha, evento,
                        responsable,
                        publicado, file_archivo,
                        unidad, id_departamento,
                        detalle, referencia, tipo, origen, modulo, archivo
          FROM view_seg_file
          where id_departamento = '.$bd->sqlvalue_inyeccion($idunidad ,true).' order by referencia desc'     ;
    }
    
    if ( $Aperfil['archivo'] == 'personal'){
        
        $sql = 'SELECT  fecha, evento,
                        responsable,
                        publicado, file_archivo,
                        unidad, id_departamento,
                        detalle, referencia, tipo, origen, modulo, archivo
          FROM view_seg_file
          where id_departamento = '.$bd->sqlvalue_inyeccion($idunidad ,true).' and 
                responsable='.$bd->sqlvalue_inyeccion(trim($sesion) ,true).' order by referencia desc'     ;
        
    }
    
  
    
    $stmt_depa= $bd->ejecutar($sql);
    
    
    
  echo ' <input class="form-control" id="myInput" type="text" placeholder="Search..">
            <br>
              <table class="table table-bordered table-striped" style="font-size: 10px">
                <thead>
                  <tr>
                    <th width="50%">Nombre</th>
                    <th width="30%">Publicado</th>
                    <th width="20%">Fecha</th>
                    </tr>
                </thead>
                <tbody id="myTable">';
    
                while ($x=$bd->obtener_fila($stmt_depa)){
                    
                    $archivo = $x['file_archivo'];
                    
                    $enlace = "'"."../../archivos/".$x['file_archivo']."'";
                    
                    
                    $pdf = '<a href="#" onClick="javascript:visorPdf('.$enlace.');">
                                <img src="../../kimages/seg_pdf.png" align="absmiddle" title="'. $x['evento'].'"/>
                            </a>&nbsp;';
                    
                      
                   echo '<tr>
                        <td>'.$pdf.$archivo.' </td>
                        <td>'. $x['publicado'].'</td>
                        <td>'.$x['fecha'].'</td>
                        </tr>';
                                    
               
                }
    
    echo ' </tbody>
  </table>';
?>
<script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script> 
  
<?php
	session_start( );
?>	
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
 
</head>
<body>
  <div class="well">  
  
	  

	  
        <div class="modal-content">

        	<div class="modal-body"> 
 
                  <div class="list-group">
					  
					  
                     
                     <?php
							require 'SesionInicio.php';

  							$tipo 		    = $bd->retorna_tipo();

							$sql = 'SELECT item, identificador, detalle, cuenta, id_matriz_esigef, clase
									 FROM activo.ac_matriz_esigef  order by 2';

  						   $resultado  = $bd->ejecutar($sql);
 	

							echo '<table class="table table-bordered table-hover table-tabletools" id="datos_a" border="0" width="100%">
							<thead> <tr>';

							   echo '<th width="10%" bgcolor="#167cd8" style="color: #F4F4F4">Referencia</th>';
							   echo '<th width="40%" bgcolor="#167cd8" style="color: #F4F4F4">Detalle</th>';
							   echo '<th width="30%" bgcolor="#167cd8" style="color: #F4F4F4">Clase</th>';
							   echo '<th width="10%" bgcolor="#167cd8" style="color: #F4F4F4">Cuenta</th>';
							   echo '<th width="10%" bgcolor="#167cd8" style="color: #F4F4F4">Accion</th>';

							echo '</tr></thead><tbody>';

								 
									while($row=pg_fetch_assoc($resultado)) {
										
										
										$cadena= "'".trim($row['detalle'])."',". "'".trim($row['clase'])."',". "'".trim($row['cuenta'])."',"."'".trim($row['item'])."',"."'".trim($row['identificador'])."'" ;
										
										echo "<tr>";
 												echo "<td>".trim($row['id_matriz_esigef']).'</td>';
												echo "<td>".trim($row['detalle']).'</td>';
												echo "<td>".trim($row['clase']).'</td>';
												echo "<td>".trim($row['cuenta']).'</td>';
												echo '<td><a href="#" onClick="Enlazar('.$cadena.')">Copiar</a></td>';
										  echo "</tr>";
                                     } 
		  
                
								echo "</tbody></table>";
 								pg_free_result ($resultado) ;
							?>
    					  <script>
							oTable 	= $('#datos_a').dataTable( {      
								searching: true,
								paging: true, 
								info: true,         
								lengthChange:true 
						   } );
							  
					   function Enlazar($detalle,$clase,$cuenta,$clasificador,$identificador)
							  	{
								
									window.opener.document.getElementById('clase_esigef').value = $detalle;
									window.opener.document.getElementById('clase').value = $clase;
									window.opener.document.getElementById('cuenta').value = $cuenta;
									window.opener.document.getElementById('clasificador').value = $clasificador;
									
									window.opener.document.getElementById('identificador').value = $identificador;
									
									
									
									
									window.close();
					 			}
 
						 </script>
 				  </div>
	</div>
   </div>
 </div>
</body>
</html>

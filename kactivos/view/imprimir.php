<?php 
session_start();  

ob_start(); 
  ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Codificación bienes</title>


	<script type="text/javascript">
		
            function imprimir() {
				
                if (window.print) {
					
                    window.print();
					
				    window.onafterprint = window.close;

					
                } else {
                    alert("La función de impresion no esta soportada por su navegador.");
                }
            }
        </script>
</head>
<body  onload="imprimir();">
	<?php 
	 $cod=$_GET['cod'];
	 $nom=$_GET['nom'];
	 ?>

<div class="page"  align="center">
		<img src="logo_b.png" width="44" height="36" ><br>
		<label style="font-size: 9px; margin:0;"><b>
			<?php 
		$da=substr($nom, 0,20) ;
		echo  $da;

		; ?> 
			
		</b></label><br>
		<img src="../code/<?php echo $cod; ?> " width="140px" height="45px"><br>
		
</div>

	

</body>
</html>
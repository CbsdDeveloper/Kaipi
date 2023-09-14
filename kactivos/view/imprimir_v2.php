<!DOCTYPE html>
<html>
<head>
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
 
	
		<style>
			.barcode {
		  font-family: "Libre Barcode 128", "Courier New", Courier, monospace;
		  font-weight: normal;
		  font-size: 45px;
		  white-space: nowrap;
		  text-align:center;
 		}

		.with-text {
		  font-family: "Libre Barcode 128 text";
		}
	</style>
	
	
	
</head>
<?php 
session_start( );  

	
	
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
 	

	$cod=$_GET['cod'];

	$nom=$_GET['nom'];

	// 141.01.03-000016.png

	$codigo =   str_replace(".png","",$cod);


	$cuenta = explode('-',$codigo );	

	$variable = $cuenta[0];
	$codigo   = $cuenta[1];

	
	$bd     = 	new Db;
	
	$name       = $_SESSION['razon'] ;
      
 
	
	  ob_start();  
	
?> 
<body  onload="imprimir();">
 	
 	 
	
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Libre+Barcode+128">
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Libre+Barcode+128+Text">
 
 	   <div class="page" style="font-size: 10px; margin:0; font-family:Courier, 'Courier New';font-weight: 650" align="center">
  	    	 <?php echo '<b style="font-size: 12px;"> '.$name.'</b> <br>'. $nom .'<br>'. $variable .'<br>' ?> 
   			</div>	
	   
      <div class="barcode"    data-barcode="<?php echo $codigo ?>"></div>
 
	 
	
<script>
	
 const checkbox = document.getElementById('withtext')

function toSetC(data) {
  var str = data.match(/\d{2}|./g).map((ascii) => {
    if(ascii.length == 1) {
    	return String.fromCharCode(200) + ascii;
    }
    return String.fromCharCode(Number(ascii) + 32);
  }).join('');
  return str;
}

function checkSum128(data, startCode) {
  var sum = startCode;
  for (var i = 0; i < data.length; i++) {
    var code = data.charCodeAt(i);
  	var value = code > 199 ? code - 100 : code - 32;
    sum += (i + 1) * (value);
  }
  
  var checksum = (sum % 103) + 32;
  if (checksum > 126) checksum = checksum + 68 ;
  return String.fromCharCode(checksum);
}

function encodeToCode128(text, codeABC = "B") {
  var startCode = String.fromCharCode(codeABC.toUpperCase().charCodeAt() + 138);
  var stop = String.fromCharCode(206);
  
  text = codeABC == 'C' && toSetC(text) || text;

  var check = checkSum128(text, startCode.charCodeAt(0) - 100);

  text = text.replace(" ", String.fromCharCode(194));
	
	 

  return startCode + text + check + stop;
}

function renderBarcodes(withText = true) {
  var barcodeElements = document.querySelectorAll(".barcode");
  var codes = [];
  barcodeElements.forEach((e) => {
    var code = e.attributes["data-barcode"]?.value;
    if (!code) return;
    var set = e.attributes["data-set"]?.value;
    e.innerHTML = encodeToCode128(code, set);
	
	 
	
    e.classList.toggle('with-text', withText)
  });
}

renderBarcodes();

 
	</script>
</body>
</html>
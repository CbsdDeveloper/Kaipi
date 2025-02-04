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
    
    include('phpqrcode/qrlib.php');	
	

	$cod=$_GET['cod'];

	$nom=$_GET['nom'];

	// 141.01.03-000016.png

	$codigo =   str_replace(".png","",$cod);



	$cuenta = explode('-',$codigo );	

	$variable = $cuenta[0];
	$codigo   = $cuenta[1];
	


	
	$bd     = 	new Db;

	$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	
	 $idbien= intval($codigo );
	
	  $dato_bien            = $bd->query_array('activo.view_bienes',
										   'vida_util,costo_adquisicion,serie, proveedor', 
										  'id_bien='.$bd->sqlvalue_inyeccion($idbien,true)
										  );

	 $costo     = $dato_bien['costo_adquisicion'];
	 $serie     = trim($dato_bien['serie']) ; 
	 $proveedor = trim($dato_bien['proveedor']);
		 
	
	  $name       = $_SESSION['razon'] ;
      
      
      $hoy = date("Y-m-d H:i:s");
	
	 $archivo = 'code/'.$codigo.'.png';
	
	 $url = 'https://g-kaipi.cloud/BSigsig/qr/bien?bien='. $codigo;
      
      // we building raw data
  //    $codeContents .= 'FECHA: '.$hoy."\n";
	  $codeContents .= 'CODIGO: '.$codigo."\n";
      $codeContents .= 'CUENTA: '.$variable."\n";
	  $codeContents .= 'NOMBRE: '.trim($nom)."\n";
	//  $codeContents .= 'NRO SERIE: '.$serie."\n";
	//  $codeContents .= 'COSTO: '.$costo."\n";
//	  $codeContents .= 'PROVEEDOR: '.$proveedor."\n";
      $codeContents .= 'INSTITUCION:'.$name."\n";
 //     $codeContents .= 'Version: 1.0.0'."\n";
      $codeContents .= 'Visualizar en '.$url."\n";
	 
      
       
      QRcode::png($codeContents, $archivo , QR_ECLEVEL_L, 3);
	
 	
	  ob_start();  
	
?> 
<body  onload="imprimir();">

	
 <table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tbody>
    <tr>
      <td width="15%" align="left" valign="middle">
		  <img src="<?php echo trim($archivo) ?>" width="70px" height="70px"/></td>
		<td width="85%" align="justify" valign="middle">  
			<div class="page" style="font-size:8px;">
 							 <?php echo '<b>'.$nom.'<br>'  ?> 
							 <?php echo  $variable.'-'.$codigo.'</b>' ?> 
			 </div>	</td>
    </tr>
  </tbody>
</table>

    
	
 					
				   



 					   
 
		 
	
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
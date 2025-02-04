

<?php  session_start( );     ?>


<?php

   	require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	require '../../kconfig/Db.conf.php';   /*Incluimos el fichero de la clase Conf*/
	require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	require '../../kconfig/convertir.php'; /*Incluimos el fichero de la clase objetos*/

	ob_end_clean();
    require  'fpdf.php';

 	/*Creamos la instancia del objeto. Ya estamos conectados*/
	global $bd,$obj,$datos, $formulario,$set;
	//header ('Content-type: text/html; charset=utf-8');


    $obj   = 	new objects;
	$bd	   =	Db::getInstance();

 	$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);



//==============================================================
//==============================================================
//==============================================================
 class PDF extends FPDF
{

   public $col_datos;



  function Header($titulo){ //función header

		$id = utf8_decode('Nro.Identificación:'.$_SESSION['ruc_registro']);
		
	 	$this->SetXY(10, 10);
        $this->SetFont('Arial','',10);
    //    $this->SetFillColor(2,157,116);//Fondo verde de celda
        $this->SetTextColor(0, 0, 0); //Letra color blanco
	    //titulo del encabezado
	    $titulo = trim($_SESSION['razon']);
   		$this->Cell(150,0,$titulo,0,1,'L');
  		$this->Ln(5); //salto de linea
		
		$this->SetFont('Arial','',8);
		$this->Cell(10,0, utf8_decode('PLATAFORMA DE GESTION FINANCIERA'),0, 1 , 'L' );
	    $this->Ln(5); //salto de linea
	    $this->Cell(10,0, utf8_decode('MODULO FINANCIERO-CONTABILIDAD'),0, 1 , 'L' );
	    $this->Ln(5); //salto de linea
		  
	      
	   		
	/*	$this->SetFont('Courier','',8);
		$this->Cell(150,5,$id,0,1,'L');
		 
		$this->Ln(12); //salto de linea
*/
  }

  function Footer() { //función footer
    $this->SetY(-15); //posición en el pie. 1.5 cm del borde
    $this->SetFont("Arial", "I", 0); //tipo de letra
    //Texto del pie de página
    $this->Cell(0,10,  utf8_decode('Página '.$this->PageNo()) ,0,0,'C');
  }

 


    function cabeceraHorizontal($cabecera,$fuente, $row_col,$proveedor,$pago)
    {

		//CABECERA

		$this->SetXY(10, 25);

        $this->SetFont('Arial','',8);
        $this->SetTextColor(0, 0, 0); //Letra color blanco

	   $MENSAJE = 'LIBRO DIARIO DE GESTIÓN CONTABLE '.$_SESSION['ireporte'];
	 
	   $this->Cell(10,0, utf8_decode($MENSAJE),0, 1 , 'L' );
 	   $this->Ln(5); //salto de linea
    }

    function datosHorizontal($resultado,$fuente,$row_col)
    {


		global $bd,$obj,$datos, $formulario,$set;


		$this->SetXY(10,35);
        $this->SetFont('Times','B',$fuente);
        $this->SetFillColor(229, 229, 229); //Gris tenue de cada fila
        $this->SetTextColor(3, 3, 3); //Color del texto: Negro
        $bandera = true; //Para alternar el relleno
		$this->SetLineWidth(0.1);
		
		$this->CellFitSpace(18,5, 'Fecha',1, 0 , 'C', $bandera );
		$this->CellFitSpace(18,5, 'Comprobante',1, 0 , 'C', $bandera );
		$this->CellFitSpace(20,5, 'Cta Contable',1, 0 , 'C', $bandera );
		$this->CellFitSpace(85,5, 'Cuenta',1, 0 , 'C', $bandera );
		$this->CellFitSpace(85,5, 'Detalle',1, 0 , 'C', $bandera );
	//	$this->CellFitSpace(35,5, 'Beneficiario',1, 0 , 'C', $bandera );
		$this->CellFitSpace(20,5, 'Debe',1, 0 , 'C', $bandera );
		$this->CellFitSpace(20,5, 'Haber',1, 0 , 'C', $bandera );

//Detalle	Beneficiario	Debe	Haber

		$this->Ln();//Salto de línea para generar otra fila
		$bandera = false;

		$this->SetFont('Times','',$fuente);
		$this->SetLineWidth(0.1);

       $y = 37;
	   $total1 = 0;
	   $total2 = 0;
		while ($x=$bd->obtener_fila($resultado)){

			$debe =  $x['7'] ;
			$haber =  $x['8'];

			$total1 =  $total1 + $debe;
			$total2 =  $total2 + $haber;

			$this->CellFitSpace(18,5, ($x['1']),1, 0 , 'C', $bandera );
			$this->CellFitSpace(18,5, trim($x['2']),1, 0 , 'L', $bandera );
			$this->CellFitSpace(20,5, utf8_decode(trim($x['3'])),1, 0 , 'L', $bandera );
			$this->CellFitSpace(85,5, utf8_decode(trim($x['4'])),1, 0 , 'L', $bandera );
			$this->CellFitSpace(85,5, utf8_decode(trim($x['5'])),1, 0 , 'L', $bandera );
		
			$this->CellFitSpace(20,5, number_format($debe,2),1, 0 , 'R', $bandera );
			$this->CellFitSpace(20,5, number_format($haber,2),1, 0 , 'R', $bandera );

		    $this->Ln();//Salto de línea para generar otra fila
			$y++;
		}

 

		// total
			$this->CellFitSpace(18,5, '',0, 0 , 'C', $bandera );
			$this->CellFitSpace(18,5, '',0, 0 , 'L', $bandera );
			$this->CellFitSpace(20,5, '',0, 0 , 'L', $bandera );
			$this->CellFitSpace(85,5, '',0, 0 , 'L', $bandera );
			$this->CellFitSpace(85,5, 'TOTAL',1, 0 , 'R', $bandera );

		 	$this->CellFitSpace(20,5, number_format($total1),1, 0 , 'R', $bandera );
		 	$this->CellFitSpace(20,5, number_format($total2),1, 0 , 'R', $bandera );

 		//
	/*	$this->SetXY(10,$y+10);
		$this->Ln(10);//Salto de línea para generar otra fila
		$this->CellFitSpace(40,15, 'ELABORADO',0, 0 , 'C', $bandera );
		$this->CellFitSpace(40,15, 'REVISADO',0, 0 , 'C', $bandera );
		$this->CellFitSpace(40,15, 'APROBADO',0, 0 , 'C', $bandera );
		 */

    }

    function tablaHorizontal($datosHorizontal,$fuente, $row_col)
    {
         $this->cabeceraHorizontal($fuente, $row_col);
         $this->datosHorizontal($datosHorizontal,$fuente, $row_col);
    }

    //***** Aquí comienza código para ajustar texto *************
    //***********************************************************
    function CellFit($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $scale=false, $force=true)
    {
        //Get string width
        $str_width=$this->GetStringWidth($txt);

        //Calculate ratio to fit cell
        if($w==0)
            $w = $this->w-$this->rMargin-$this->x;
        $ratio = ($w-$this->cMargin*2)/$str_width;

        $fit = ($ratio < 1 || ($ratio > 1 && $force));
        if ($fit)
        {
            if ($scale)
            {
                //Calculate horizontal scaling
                $horiz_scale=$ratio*100.0;
                //Set horizontal scaling
                $this->_out(sprintf('BT %.2F Tz ET',$horiz_scale));
            }
            else
            {
                //Calculate character spacing in points
                $char_space=($w-$this->cMargin*2-$str_width)/max($this->MBGetStringLength($txt)-1,1)*$this->k;
                //Set character spacing
                $this->_out(sprintf('BT %.2F Tc ET',$char_space));
            }
            //Override user alignment (since text will fill up cell)
            $align='';
        }

        //Pass on to Cell method
        $this->Cell($w,$h,$txt,$border,$ln,$align,$fill,$link);

        //Reset character spacing/horizontal scaling
        if ($fit)
            $this->_out('BT '.($scale ? '100 Tz' : '0 Tc').' ET');
    }

    function CellFitSpace($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
    {
        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,false,false);
    }

    //Patch to also work with CJK double-byte text
    function MBGetStringLength($s)
    {
        if($this->CurrentFont['type']=='Type0')
        {
            $len = 0;
            $nbbytes = strlen($s);
            for ($i = 0; $i < $nbbytes; $i++)
            {
                if (ord($s[$i])<128)
                    $len++;
                else
                {
                    $len++;
                    $i++;
                }
            }
            return $len;
        }
        else
            return strlen($s);
    }

//************** Fin del código para ajustar texto *****************
//******************************************************************
} // FIN Class PDF




	 //damos salida a la tabla P
     $diseno = 'L';
     $tamano = 'A4';
	 $titulo = 'COMPROBANTE DE EGRESO';
     $fuente = '8';
     $sesion 	 = $_SESSION['email'];

  

     $sql = $_SESSION['isql'] ;

	 /*Ejecutamos la query*/
	 $stmt = $bd->ejecutar($sql);



    $pdf = new PDF($diseno,'mm',$tamano );

	$pdf->AddPage();

 	$pdf->Header($titulo); 
 	$pdf->tablaHorizontal($stmt,$fuente,$row_col);

	$pdf->Output(); //Salida al navegador


od_end_clean();


  ?>

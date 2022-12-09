<?php  session_start( );     

   	require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	require '../../kconfig/Db.conf.php';   /*Incluimos el fichero de la clase Conf*/
	require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

	ob_end_clean(); 
    require  'fpdf.php'; 
 
 	/*Creamos la instancia del objeto. Ya estamos conectados*/
	global $bd,$obj,$datos, $formulario,$set;
	header ('Content-type: text/html; charset=utf-8');	

   
    $obj   = 	new objects;
	$bd	   =	Db::getInstance();
 
 	$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

 
	
//==============================================================
//==============================================================
//==============================================================
 class PDF extends FPDF
{
   
   public $col_datos;
   
   
  
  function Header($titulo){ //función header
  		
	 $id = $_SESSION['ruc_registro'];
 		 
	 	$this->SetXY(10, 10);
        $this->SetFont('Times','',11);
        $this->SetFillColor(2,157,116);//Fondo verde de celda
        $this->SetTextColor(0, 0, 0); //Letra color blanco
	    //titulo del encabezado
	    $titulo = trim($_SESSION['razon']);
   		$this->Cell(0,10,$titulo,1,1,'C');
  		$this->Ln(12); //salto de linea
  }
 
  function Footer() { //función footer
    $this->SetY(-15); //posición en el pie. 1.5 cm del borde
    $this->SetFont("Arial", "I", 0); //tipo de letra
    //Texto del pie de página
    $this->Cell(0,10,  utf8_decode('Página '.$this->PageNo()) ,0,0,'C');
  }

  function buscarc($row_col,$search) { //función footer
    $longitud = count($row_col);
	 
	  for($i=0; $i<$longitud; $i++){
			if (trim($row_col[$i][1]) == trim($search) ){
				$ancho = $row_col[$i][0].'-'.$row_col[$i][2];
		 	}	
	  }
	  return $ancho;
  }  
  
 
    function cabeceraHorizontal($cabecera,$fuente, $row_col)
    {
        
		//CABECERA
		
		$this->SetXY(10, 27);
		
 
		
        $this->SetFont('Times','B',$fuente);
        $this->SetFillColor(255,255,255);//Fondo verde de celda
        $this->SetTextColor(0, 0, 0); //Letra color blanco
       
	    $this->SetFont('Times','B',$fuente);
	    $this->CellFitSpace(50 ,5, 'MOVIMIENTO DE INVENTARIOS',0, 0 , 'L', true);	
		$this->Ln(5); //salto de linea
	
	    $this->SetFont('Times','B',$fuente);
		$this->CellFitSpace(20 ,5, 'Fecha:',0, 0 , 'L', true);
		$this->SetFont('Times','',$fuente);
		$this->CellFitSpace(50 ,5, $cabecera['fecha'],0, 0 , 'L', true);
		
		$this->SetFont('Times','B',$fuente);
		$this->CellFitSpace(35 ,5, 'Nro.Movimiento:',0, 0 , 'L', true);
		$this->SetFont('Times','',$fuente);
		$this->CellFitSpace(50 ,5, $cabecera['id_movimiento'],0, 0 , 'L', true);
		 
		$this->Ln(5); //salto de linea
		
		$this->SetFont('Times','B',$fuente);
	    $this->CellFitSpace(20 ,5, 'Identificacion:',0, 0 , 'L', true);
		$this->SetFont('Times','',$fuente);
		$this->CellFitSpace(50 ,5, $cabecera['idprov'],0, 0 , 'L', true);
		
		 
		 $this->SetFont('Times','B',$fuente);
	    $this->CellFitSpace(35 ,5, 'Responsable/Beneficiario:',0, 0 , 'L', true);
		$this->SetFont('Times','',$fuente);
		$this->CellFitSpace(150 ,5, utf8_decode($cabecera['proveedor']),0, 0 , 'L', true);
		
		$this->Ln(5); //salto de linea
		
		if ($cabecera['tipo'] = 'I')
			$tipo = 'INGRESO';
		else	
			$tipo = 'EGRESO';
		
		$this->SetFont('Times','B',$fuente);
	    $this->CellFitSpace(20 ,5, 'Movimiento:',0, 0 , 'L', true);
		$this->SetFont('Times','',$fuente);
		$this->CellFitSpace(50 ,5, $tipo,0, 0 , 'L', true);
		
		 
		 $this->SetFont('Times','B',$fuente);
	    $this->CellFitSpace(35 ,5, 'Nro.Comprobante:',0, 0 , 'L', true);
		$this->SetFont('Times','',$fuente);
		$this->CellFitSpace(150 ,5, $cabecera['comprobante'],0, 0 , 'L', true);
		
		$this->Ln(5); //salto de linea
		$this->SetFont('Times','B',$fuente);
	    $this->CellFitSpace(20 ,5, 'Usuario:',0, 0 , 'L', true);
		$this->SetFont('Times','',$fuente);
		$this->CellFitSpace(50 ,5, $cabecera['sesion'],0, 0 , 'L', true);

		$this->Ln(5); //salto de linea
		$this->SetFont('Times','B',$fuente);
	    $this->CellFitSpace(20 ,5, 'Detalle:',0, 0 , 'L', true);
		$this->SetFont('Times','',$fuente);
		$this->CellFitSpace(350 ,5,utf8_decode($cabecera['detalle']),0, 0 , 'L', true);
				
       // $this->CellFitSpace(700 ,5, 'Responsable/Beneficiario',0, 0 , 'L', true);
	   
	      
	   //  $this->CellFitSpace(150 ,5, utf8_decode($cabecera['proveedor']),0, 0 , 'L', true);
		 
        
    }
 
    function datosHorizontal($resultado,$fuente,$row_col)
    {
        
		
		global $bd,$obj,$datos, $formulario,$set; 
		
		
		$this->SetXY(10,60);
        $this->SetFont('Times','B',$fuente);
        $this->SetFillColor(229, 229, 229); //Gris tenue de cada fila
        $this->SetTextColor(3, 3, 3); //Color del texto: Negro
        $bandera = true; //Para alternar el relleno
		$this->SetLineWidth(0.1);
		$this->CellFitSpace(20,5, 'Codigo',1, 0 , 'C', $bandera ); 
		$this->CellFitSpace(90,5, 'Detalle',1, 0 , 'C', $bandera ); 
		$this->CellFitSpace(20,5, 'Unidad',1, 0 , 'C', $bandera ); 
		$this->CellFitSpace(20,5, 'Cantidad',1, 0 , 'C', $bandera ); 
		$this->CellFitSpace(20,5, 'Costo',1, 0 , 'C', $bandera ); 
		$this->CellFitSpace(20,5, 'Total',1, 0 , 'C', $bandera ); 
		
		$this->Ln();//Salto de línea para generar otra fila
		$bandera = false;
		
		$this->SetFont('Times','',$fuente);
		$this->SetLineWidth(0.1);
		 
	   $y = 90;
	   $total_suma = 0; 
		while ($x=$bd->obtener_fila($resultado)){
			 
			$total =  $x['5'] * $x['6'];
			$total_suma =  $total_suma + $total;
			
			$this->CellFitSpace(20,5, ($x['0']),1, 0 , 'C', $bandera ); 
			$this->CellFitSpace(90,5, utf8_decode(trim($x['2'])),1, 0 , 'L', $bandera ); 
			$this->CellFitSpace(20,5, trim($x['3']),1, 0 , 'L', $bandera ); 
			$this->CellFitSpace(20,5, $x['5'],1, 0 , 'R', $bandera ); 
			$this->CellFitSpace(20,5, $x['6'],1, 0 , 'R', $bandera ); 
			$this->CellFitSpace(20,5, $total,1, 0 , 'R', $bandera ); 									
		    $this->Ln();//Salto de línea para generar otra fila
			$y++;
		}
		// total
			 $this->CellFitSpace(20,5, '',0, 0 , 'C', $bandera ); 
			$this->CellFitSpace(90,5, '',0, 0 , 'L', $bandera ); 
			$this->CellFitSpace(20,5, '',0, 0 , 'L', $bandera ); 
			$this->CellFitSpace(20,5, '',0, 0 , 'R', $bandera ); 
			$this->CellFitSpace(20,5, 'Total',1, 0 , 'R', $bandera ); 
			$this->CellFitSpace(20,5, $total_suma,1, 0 , 'R', $bandera ); 
 
 		//
		$this->Ln(15);//Salto de línea para generar otra fila
		$this->CellFitSpace(40,15, 'ELABORADO',0, 0 , 'C', $bandera ); 
		$this->CellFitSpace(40,15, 'REVISADO',0, 0 , 'C', $bandera ); 
		$this->CellFitSpace(40,15, 'APROBADO',0, 0 , 'C', $bandera );
		$this->CellFitSpace(40,15, 'RECIBI CONFORME',0, 0 , 'C', $bandera );
		 
    }
 
    function tablaHorizontal($cabeceraHorizontal, $datosHorizontal,$fuente, $row_col)
    {
        $this->cabeceraHorizontal($cabeceraHorizontal,$fuente, $row_col);
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

	$id_movimiento		= $_GET['a'];


	 //damos salida a la tabla
     $diseno = 'P';
     $tamano = 'A4';
	 $titulo = 'COMPROBANTE DE INVENTARIOS';
     $fuente = '9';
     $sesion 	 = $_SESSION['email'];
  
  
  
  	  $sql = "SELECT *
	  		    FROM view_inv_movimiento  
			   where id_movimiento = ".$bd->sqlvalue_inyeccion($id_movimiento ,true);
  	  $resultado = $bd->ejecutar($sql);
      $datos = $bd->obtener_array( $resultado); 
   
 
 	 $sql = 'SELECT a.id_movimientod as id,
	 			    b.codigo,b.producto,
	 				b.unidad,
					b.saldo ,
					coalesce(a.cantidad,0) as cantidad,
					coalesce(a.costo,0) as costo, 
					coalesce(a.total,0) as total,
					b.lifo
			from inv_movimiento_det a, web_producto b
			where 	a.idproducto = b.idproducto and 
					a.id_movimiento = '.$bd->sqlvalue_inyeccion($id_movimiento, true);
				
				
	 /*Ejecutamos la query*/
	 $stmt = $bd->ejecutar($sql);
									
  
 
    $pdf = new PDF($diseno,'mm',$tamano );
 
	$pdf->AddPage();
	 	 
 	$pdf->Header($titulo); 
 	$pdf->tablaHorizontal(	$datos,$stmt,$fuente,$row_col);
	 
	$pdf->Output(); //Salida al navegador
  
 
od_end_clean(); 
 
   
  ?> 

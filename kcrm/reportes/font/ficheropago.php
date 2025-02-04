 

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
  
 
    function cabeceraHorizontal($cabecera,$fuente, $row_col,$proveedor,$pago)
    {
        
		//CABECERA
		
		$this->SetXY(10, 27);
		
 
		
        $this->SetFont('Times','B',$fuente);
        $this->SetFillColor(255,255,255);//Fondo verde de celda
        $this->SetTextColor(0, 0, 0); //Letra color blanco
       
	    $this->SetFont('Times','B',$fuente);
	    $this->CellFitSpace(50 ,5, 'COMPROBANTE DE PAGO',0, 0 , 'L', true);	
		$this->Ln(5); //salto de linea
	
	    $this->SetFont('Times','B',$fuente);
		$this->CellFitSpace(20 ,5, 'Fecha:',0, 0 , 'L', true);
		$this->SetFont('Times','',$fuente);
		$this->CellFitSpace(50 ,5, $cabecera['fecha'],0, 0 , 'L', true);
		
		$this->SetFont('Times','B',$fuente);
		$this->CellFitSpace(35 ,5, 'Nro.Asiento:',0, 0 , 'L', true);
		$this->SetFont('Times','',$fuente);
		$this->CellFitSpace(50 ,5, $cabecera['id_asiento'],0, 0 , 'L', true);
		 
		$this->Ln(5); //salto de linea
		
		$this->SetFont('Times','B',$fuente);
	    $this->CellFitSpace(20 ,5, 'Identificacion:',0, 0 , 'L', true);
		$this->SetFont('Times','',$fuente);
		$this->CellFitSpace(50 ,5, $proveedor['idprov'],0, 0 , 'L', true);
		
		 
		 $this->SetFont('Times','B',$fuente);
	    $this->CellFitSpace(35 ,5, 'Responsable/Beneficiario:',0, 0 , 'L', true);
		$this->SetFont('Times','',$fuente);
		$this->CellFitSpace(150 ,5, utf8_decode($proveedor['proveedor']),0, 0 , 'L', true);
		
		$this->Ln(5); //salto de linea
		
		 
		
		$this->SetFont('Times','B',$fuente);
	    $this->CellFitSpace(20 ,5, 'Modulo:',0, 0 , 'L', true);
		$this->SetFont('Times','',$fuente);
		$this->CellFitSpace(50 ,5, $cabecera['modulo'],0, 0 , 'L', true);
		
		 
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
		$this->CellFitSpace(350 ,5, $cabecera['detalle'],0, 0 , 'L', true);
		
		
		$this->Ln(5); //salto de linea
		 
		$this->CellFitSpace(350 ,15, utf8_decode($pago),0, 0 , 'L', true);
				
       // $this->CellFitSpace(700 ,5, 'Responsable/Beneficiario',0, 0 , 'L', true);
	   
	      
	   //  $this->CellFitSpace(150 ,5, utf8_decode($cabecera['proveedor']),0, 0 , 'L', true);
		 
        
    }
 
    function datosHorizontal($resultado,$fuente,$row_col)
    {
        
		
		global $bd,$obj,$datos, $formulario,$set; 
		
		
		$this->SetXY(10,70);
        $this->SetFont('Times','B',$fuente);
        $this->SetFillColor(229, 229, 229); //Gris tenue de cada fila
        $this->SetTextColor(3, 3, 3); //Color del texto: Negro
        $bandera = true; //Para alternar el relleno
		$this->SetLineWidth(0.1);
		$this->CellFitSpace(35,5, 'Cuenta',1, 0 , 'C', $bandera ); 
		$this->CellFitSpace(100,5, 'Detalle',1, 0 , 'C', $bandera ); 
		$this->CellFitSpace(20,5, 'Debe',1, 0 , 'C', $bandera ); 
		$this->CellFitSpace(20,5, 'Haber',1, 0 , 'C', $bandera ); 
	 
		
		$this->Ln();//Salto de línea para generar otra fila
		$bandera = false;
		
		$this->SetFont('Times','',$fuente);
		$this->SetLineWidth(0.1);
		 
	   $y = 80;
	   $total1 = 0;
	   $total2 = 0; 
		while ($x=$bd->obtener_fila($resultado)){
			 
			$debe =  $x['2'] ;
			$haber =  $x['3'];
			
			$total1 =  $total1 + $debe;
			$total2 =  $total2 + $haber;
			
			$this->CellFitSpace(35,5, ($x['0']),1, 0 , 'C', $bandera ); 
			$this->CellFitSpace(100,5, trim($x['1']),1, 0 , 'L', $bandera ); 
			$this->CellFitSpace(20,5, number_format($debe,2),1, 0 , 'R', $bandera ); 
			$this->CellFitSpace(20,5, number_format($haber,2),1, 0 , 'R', $bandera ); 
											
		    $this->Ln();//Salto de línea para generar otra fila
			$y++;
		}
		
		 
		
		// total
			$this->CellFitSpace(35,5, '',0, 0 , 'C', $bandera ); 
			$this->CellFitSpace(100,5, 'Total',0, 0 , 'R', $bandera ); 
			$this->CellFitSpace(20,5, number_format($total1,2),1, 0 , 'R', $bandera ); 
			$this->CellFitSpace(20,5, number_format($total2,2),1, 0 , 'R', $bandera ); 
 
 		//
		$this->SetXY(10,$y+10);
		$this->Ln(10);//Salto de línea para generar otra fila
		$this->CellFitSpace(40,15, 'ELABORADO',0, 0 , 'C', $bandera ); 
		$this->CellFitSpace(40,15, 'REVISADO',0, 0 , 'C', $bandera ); 
		$this->CellFitSpace(40,15, 'APROBADO',0, 0 , 'C', $bandera );
		$this->CellFitSpace(40,15, 'RECIBI CONFORME',0, 0 , 'C', $bandera );
		 
    }
 
    function tablaHorizontal($cabeceraHorizontal, $datosHorizontal,$fuente, $row_col,$proveedor,$pago)
    {
        $this->cabeceraHorizontal($cabeceraHorizontal,$fuente, $row_col,$proveedor,$pago);
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




	 //damos salida a la tabla
     $diseno = 'P';
     $tamano = 'A4';
	 $titulo = 'COMPROBANTE DE EGRESO';
     $fuente = '9';
     $sesion 	 = $_SESSION['email'];
  
  
  $id		= $_GET['a'];
	
   $sql = 'SELECT max(a.id_asiento) as id_asiento_ref, max(idprov) as idprov,sum(a.haber) as monto
   				 FROM co_asiento_aux a where  a.id_asiento_aux ='.$bd->sqlvalue_inyeccion($id,true);
	
     $resultado = $bd->ejecutar($sql);
  	 $asiento = $bd->obtener_array( $resultado);
	 
     $id_asiento = $asiento['id_asiento_ref'];
     $idprov  = $asiento['idprov'];
	 
	 
	 $sql = 'SELECT idprov, razon as proveedor, direccion, telefono, correo
		       FROM par_ciu where  idprov ='.$bd->sqlvalue_inyeccion($idprov,true);
	
     $resultado = $bd->ejecutar($sql);
  	 $proveedor = $bd->obtener_array( $resultado);
	 
	 
	 
	$monto_imprime = (float) $asiento['monto'] ;
    $cadena = convertir($monto_imprime).' dólares --------------------------------------------' ;
	$pago = 'PAGUESE LA ORDEN DE '.$cadena;
	 
  
  	 $sql = "SELECT *
	  FROM view_asientos  where id_asiento =".$bd->sqlvalue_inyeccion($id_asiento ,true);
  	  $resultado = $bd->ejecutar($sql);
      $datos = $bd->obtener_array( $resultado); 
   
 
 	     $sql = 'SELECT a.cuenta as "Cuenta", b.detalle as "Cuenta Detalle",a.debe as "Debe", a.haber as "Haber", a.aux
 				   FROM co_asientod a, co_plan_ctas b
				  where a.cuenta = b.cuenta and a.registro = b.registro and
				  		a.id_asiento='.$bd->sqlvalue_inyeccion($id_asiento, true).' order by 5 asc, 2 desc';
				
	 /*Ejecutamos la query*/
	 $stmt = $bd->ejecutar($sql);
									
  
 
    $pdf = new PDF($diseno,'mm',$tamano );
 
	$pdf->AddPage();
	 	 
 	$pdf->Header($titulo); 
 	$pdf->tablaHorizontal(	$datos,$stmt,$fuente,$row_col, $proveedor,$pago);
	 
	$pdf->Output(); //Salida al navegador
  
 
od_end_clean(); 
 
   
  ?> 

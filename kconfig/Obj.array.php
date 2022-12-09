<?php
/* Clase encargada de gestionar las conexiones a la base de datos */
class objects_array  {
 private static $_instance; 
 // catalogo para lista de valores de catalogos generales
 
 
 //--------------------------
 function catalogo_TipoBaja(){
     
     $MATRIZ = array(
         '1'    => 'Titulo Incobrable',
         '2'    => 'Exoneracion Ley del Anciano',
         '3'    => 'Otras Exoneraciones',
         '4'    => 'Actualizacion de Informacion'
     );
     
     return  $MATRIZ;
 }
 //--------
 function catalogo_estado_contrato(){

	$MATRIZ = array(
		'-' => ' -- Ver Todos -- ',
	        'E'  => 'Ejecucion',
      	    'S'  => 'Suspendido',
      	    'C'  => 'Cancelado',
      	    'V'  => 'Vencido',
      	    'A'  => 'Ampliacion',
      	    'F'  => 'Finalizado'
   );
   
   return  $MATRIZ;
   }
 //-------------
 function catalogo_tipo_contrato(){

 $MATRIZ = array(
	 '-' => ' -- Ver Todos -- ',
	'Bien'  => 'Bien',
	'Servicios'  => 'Servicios',
	'Obra Publica'  => 'Obra Publica'
);

return  $MATRIZ;
}
 //--------------------------
 function catalogo_tipoPermiso(){
     
     $MATRIZ = array(
		 'permiso_hora'    => 'Permiso por Horas'  ,   
		 'permiso_dia'    => 'Permiso por Dias'  ,   
         'vacaciones'    => 'Vacaciones'
      
      );
     
     return  $MATRIZ;
 }
 //--------------------------------------------
 function catalogo_compras(){
     
    $MATRIZ = array(
		'-'    => 'No Aplica',
		'Arrendamiento de Inmuebles'                => 'Arrendamiento de Inmuebles',
		'Catalogo Electrónico'                     => 'Catalogo Electrónico',
		'Cotización'                               => 'Cotización',
		'Contratacion directa'                     => 'Contratacion directa',
		'Concurso Publico'                         => 'Concurso Publico',
		'Compra de Inmuebles'                      => 'Compra de Inmuebles',
		'Contratacion Integral por precio Fijo'    => 'Contratacion Integral por precio Fijo',
		'Emergencia'                               => 'Emergencia',
		'Ferias Inclusivas'                        => 'Ferias Inclusivas',
		'Infima Cuantía'                           => 'Infima Cuantía',
		'Licitación'                               => 'Licitación',
		'Lista Corta'                              => 'Lista Corta',
		'Menor cuantia'                            => 'Menor Cuantía',
		'Régimen Especial'                         => 'Regimen Especial',
		'Subasta Inversa Electrónica'              => 'Subasta Inversa Electrónica',
		'Obra artística, científica o literaria'   => 'Obra artística, científica o literaria',
		'Repuestos o Accesorios'                   => 'Repuestos o Accesorios',
		'Contratos entre Entidades Públicas o sus subsidiarias' => 'Contratos entre Entidades Públicas o sus subsidiarias',
	);
     
     return  $MATRIZ;
 }
 
 //-------------------------------------------
 function catalogo_accion(){
     
     $MATRIZ = array(
         'INGRESO'    => 'INGRESO',
         'TRASLADO'    => 'TRASLADO',
         'NOMBRAMIENTO'    => 'NOMBRAMIENTO',
         'ASCENSO'    => 'ASCENSO',
         'SUBROGACION'    => 'SUBROGACION',
         'ENCARGO'    => 'ENCARGO',
         'VACACIONES'    => 'VACACIONES',
         'CAMBIO ADMINISTRATIVO'    => 'CAMBIO ADMINISTRATIVO',
         'LICENCIA'    => 'LICENCIA',
         'RENUNCIA'    => 'RENUNCIA',
         'RESTITUCION'    => 'RESTITUCION',
         'RECLASIFICACION'    => 'RECLASIFICACION',
         'REVALORIZACION'    => 'REVALORIZACION',
         'DESTITUCION'    => 'DESTITUCION',
         'UBICACION'    => 'UBICACION',
         'JUBILACION'    => 'JUBILACION',
         'OTRO'    => 'OTRO'
     );
     
     return  $MATRIZ;
 }
 //-------------------------------------------------
 function catalogo_motivoPermiso(){
     
     $MATRIZ = array(
	 	 'Asunto Oficial'    => 'Permiso - Asunto Oficial',
         'Estudios Regulares'    => 'Permiso - Estudios Regulares',
         'Atención Medica'    => 'Permiso - Atención Medica',
         'Cuidado Del Recien Nacido'    => 'Permiso - Cuidado Del Recien Nacido',
         'Representación De Una Asociación Laboral'    => 'Permiso - Representación De Una Asociación Laboral',
		 'Cuidado De Familiares Con Discapacidades Severas'    => 'Cuidado De Familiares Con Discapacidades Severas',
		 'Cuidado De Familiares Con Enfermedades Catastróficas'    => 'Cuidado De Familiares Con Enfermedades Catastróficas',
		 'Matriculación De Hijos O Hijas'    => 'Matriculación De Hijos O Hijas',
		 'Permiso Imputable a Vacaciones'    => 'Permiso Imputable a Vacaciones',
		 'Vacaciones'    => 'Vacaciones',
         'Otros'    => 'Otros'
     );
     
	 													
																
	

     return  $MATRIZ;
 }
  //-------------------------------------------------
  function catalogo_motivoPermiso_std(){
     
	$MATRIZ = array(
		'Permiso'    => 'Permiso',
		'Vacaciones'    => 'Vacaciones',
		'Otros'    => 'Otros'
	);
	
														
															   
   

	return  $MATRIZ;
}
 //----------------------------------
function catalogo_general(){
  $MATRIZ = array(
	'-'    => '-',
	'canton'    => 'Canton',
	'provincia'    => 'Provincia',
	'TipoAsiento'    => 'Comprobantes Contables',
	'bancos'    => 'Instituciones Bancarias',
	'tarjetas'    => 'Tarjeta de Credito',
    'proyecto-costo'    => 'Proyecto-Costo',
    'tipo-costo'    => 'Tipo Costo',
    'categoria-costo'    => 'Categoria-Costo',
    'detalle-costo'    => 'Item-Costo'
   );
	return  $MATRIZ; 
 }
  // catalogo para lista de valores de catalogos generales
 
 //--------------------------
 function catalogo_tipoCiu(){
     $MATRIZ = array(
         '02'    => 'Cedula',
         '01'    => 'RUC',
         '03'    => 'Pasaporte'
     );
     return  $MATRIZ;
 }
 //-------------------------
 function catalogo_control_previo(){
     $MATRIZ = array(
         '(*) Cumple con la documentacion solicitada'    => '(*) Cumple con la documentacion solicitada',
         'No existe documentacion habilitante'    => 'No existe documentacion habilitante',
         'No existe comprobantes electronicos emitidos'    => 'No existe comprobantes electronicos emitidos',
         'No existe documentos cronologicos generados'    => 'No existe documentos cronologicos generados'
     );
     return  $MATRIZ;
 }
 
 
 function catalogo_anio(){
     
     $year = date('Y');
	 
     $MATRIZ = array(
         $year    => $year,
         $year - 1   => $year - 1,
         $year - 2  => $year  - 2,
         $year - 3    => $year - 3,
         $year - 4   => $year -4,
         $year - 5   => $year -5,
         $year - 6   => $year -6,
         $year - 7   => $year -7
     );
     return  $MATRIZ;
 }
// 
function catalogo_tipo_general(){
  $MATRIZ = array(
	'admin_catalogo'    => 'Catalogo General',
	'admin_acategoria'    => '- Categoria ',
	'admin_amarca'    => '- Marca ',
	'admin_amodelo'    => '- Modelo '
   );
	return  $MATRIZ;
 }
 
 function iva_comprass(){
     
     //  10% 9 20% 10 30% 1 50% 11 70% 2 100% 3
     
     $MATRIZ = array(
         '0'    => '-',
         '10'    => '20%',
         '11'    => '50%',
         '2'    => '70%',
         '3'    => '100%'
     );
     return  $MATRIZ;
 }
 
 function iva_compras_total(){
     
     //  10% 9 20% 10 30% 1 50% 11 70% 2 100% 3
     
     $MATRIZ = array(
         '0'    => '-',
         '9'    => '10%',
         '10'    => '20%',
         '1'    => '30%',
         '11'    => '50%',
         '2'    => '70%',
         '3'    => '100%'
     );
     return  $MATRIZ;
 }
 
function iva_compras(){
    
   //  10% 9 20% 10 30% 1 50% 11 70% 2 100% 3
    
  $MATRIZ = array(
	'0'    => '-',
    '9'    => '10%',
	'1'    => '30%',
  );
  return  $MATRIZ;
}
function nom_tipo_banco(){
  $MATRIZ = array(
	'0'    => 'Ahorros',
	'1'    => 'Corriente'
  );
  return  $MATRIZ;
}
function inven_tipo(){
  $MATRIZ = array(
	'I'    => 'Ingreso',
	'E'    => 'Egreso',
	'F'    => 'Facturacion'
  );
  return  $MATRIZ;
}
function nom_tipo(){
  $MATRIZ = array(
	'I'    => 'Ingreso',
	'E'    => 'Descuento',
	'X'    => 'Otros'
   );
  return  $MATRIZ;
}
function nom_tipo_sector(){
  $MATRIZ = array(
	'publico'    => 'Publico',
	'privado'    => 'Privado'
   );
  return  $MATRIZ;
}
function nom_formula(){
  $MATRIZ = array(
	'Formula'    => 'Formula',
	'Constante'    => 'Constante',
    'Manual'    => 'Manual',
	'Sistema'  => 'Sistema'
   );
  return  $MATRIZ;
}
function nom_formula_afecta(){
  $MATRIZ = array(
	'-'    => 'No aplica',
	'I'    => 'Afecta IESS',
	'R'    => 'Afecta SRI'
    );
  return  $MATRIZ;
}
function nom_formula_par(){
  $MATRIZ = array(
	'-'    => 'No aplica',
    'RS'    => 'Sueldo Basico Unificado',
	'AP'    => 'Aporte personal  IESS',
	'HS'    => 'Horas Suplementarias',
	'HE'    => 'Horas Extraordinarias',
	'JN'    => 'Jornada Nocturna',
	'FR'    => 'Fondos de Reserva',
	'DT'    => 'Decimo Tercero',
	'DC'    => 'Decimo Cuarto',
    'AN'    => 'Anticipo Empleado',
	'VA'    => 'Vacaciones',
    'PP'    => 'Aporte Patronal  IESS',
    'RR'    => 'Impuesto a la Renta',
     'EE'    => 'Encargo-Subrogacion',
      'AA'    => 'Alimentacion',
      'AT'    => 'Antiguedad',
      'AC'    => 'Carga Familiar',
      'OO'    => 'Otros'
    );
  return  $MATRIZ;
}

 // catalogo para lista de valores de catalogos generales
function catalogo_unidades(){
  $MATRIZ = array(
	'Unidad'    => 'Unidad',
	'Kilos'    => 'Kilos',
	'Gramos'    => 'Gramos',
     'Militros'    => 'Militros',
      'Rollos'    => 'Rollos',
	'Litros'    => 'Litros',
	'Galon'    => 'Galon',
	'Metros'    => 'Metros',
    'Metros cuadrados'    => 'Metros cuadrados',
    'Metros cubicos'    => 'Metros cubicos',
	'Resmas' => 'Resmas',
	'Caja' => 'Caja',
	'Libras' => 'Libras',
	'Par' => 'Par',
	'Caneca' => 'Caneca',
	'Centimetros Cubicos'    => 'Centimetros Cubicos',
    'Centimetros Cuadrados'    => 'Centimetros Cuadrados',
	'Quintal'    => 'Quintal',
	'Centimetros'    => 'Centimetros',
	'Horas'    => 'Horas',
	'Dias'    => 'Dias',
	'Minutos'    => 'Minutos',
	'Segundos'    => 'Segundos'
 	);
	return  $MATRIZ;
 }  

 function catalogo_unidades_pac(){
	$MATRIZ = array(
	  'UNIDAD'    => 'UNIDAD',
	  'KILOS'    => 'KILOS',
	  'GRAMOS'    => 'GRAMOS',
		'ROLLOS'    => 'ROLLOS',
	  'LITROS'    => 'LITROS',
	  'GALON'    => 'GALON',
	  'METROS'    => 'METROS',
	  'METROS CUADRADO'    => 'METROS CUADRADO',
	  'METROS CUBICOS'    => 'METROS CUBICOS',
	  'RESMAS' => 'RESMAS',
	  'CAJA' => 'CAJA',
	  'LIBRAS' => 'LIBRAS',
	  'CANECA' => 'CANECA'
	   );
	  return  $MATRIZ;
   }  
 

 // catalogo para lista de valores de catalogos generales
 function catalogo_pro_ser(){
   $MATRIZ = array(
	 '-'    => '-',
	 'S'    => 'Servicio',
	 'B'    => 'Bien/Producto'
	);
	return  $MATRIZ;
 }   
 // catalogo para lista de valores de catalogos generales
 function catalogo_tipocomp_pago(){
   $MATRIZ = array(
	 'C'    => 'Nro.Documento/Cheque'
	);
	return  $MATRIZ;
 }   
 function catalogo_tpIdProv(){
   $MATRIZ = array(
	'01'    => 'RUC',
	'02'    => 'Cedula',
	'03'    => 'Pasaporte'
	);
	return  $MATRIZ;
 }  
 //-------- 
 function catalogo_SalarioNeto(){
     $MATRIZ = array(
         '1'    => 'SIN sistema de salario neto',
         '2'    => 'CON sistema de salario neto'
     );
     return  $MATRIZ;
 } 
 //-------------
 function catalogo_Residencia(){
     $MATRIZ = array(
         '01'    => 'Residente Local',
         '02'    => 'Residente en el Exterior'
     );
     return  $MATRIZ;
 }  
 //--------------
 function catalogo_tpPersonal(){
     $MATRIZ = array(
         'C'    => 'Cedula',
         'P'    => 'Pasaporte'
     );
     return  $MATRIZ;
 }  
 //------------
 function catalogo_modulo_ciu(){
     $MATRIZ = array(
         'C'    => 'Cliente',
         'P'    => 'Proveedor',
         'N'    => 'Nomina'
     );
     return  $MATRIZ;
 }  
 //-------------------
 function catalogo_tipo_tpago(){
		 $MATRIZ = array(
						''    => '-',
		                'transferencia'    => 'Transferencia',
						'cheque'    => 'Cheque',
						'efectivo'    => 'Efectivo',
		                'debito'    => 'Debito Bancario'
					);
		 return  $MATRIZ;
   }     
 /////
    function catalogo_nacionalidad(){
		 $MATRIZ = array(
						'ECUATORIANA'    => 'ECUATORIANA',
						'COLOMBIANA'    => 'COLOMBIANA',
						'CHILENA'    => 'CHILENA',
						'VENEZOLANA'    => 'VENEZOLANA',
						'ESTADOUNIDENSE'    => 'ESTADOUNIDENSE',
						'MEXICANA'    => 'MEXICANA'
					);
		 return  $MATRIZ;
   } 
  /////
    function catalogo_etnia(){
		 $MATRIZ = array(
						'Afroecuatoriano'    => 'Afroecuatoriano',
						'Blanco'    => 'Blanco',
						'Indigena'    => 'Indigena',
						'Mestizo'    => 'Mestizo',
 						'Montubio'    => 'Montubio'
					);
		 return  $MATRIZ;
   }  
   /////
    function catalogo_ecivil(){
		 $MATRIZ = array(
						'Casado'    => 'Casado',
						'Divorciado'    => 'Divorciado',
						'Soltero'    => 'Soltero',
						'Union Libre'    => 'Union Libre',
 						'Viudo'    => 'Viudo'
					);
		 return  $MATRIZ;
   }   
   function catalogo_sexo(){
       $MATRIZ = array(
           'Masculino'    => 'Masculino',
           'Femenino'    => 'Femenino' 
       );
       return  $MATRIZ;
   }   
     /////
    function catalogo_vivecon(){
		 $MATRIZ = array(
						'Amigos'    => 'Amigos',
		                'Solo'    => 'Solo',
						'Familiares'    => 'Familiares',
						'Otros'    => 'Otros'
					);
		 return  $MATRIZ;
   }   
  ///
    function catalogo_naturaleza(){
		 $MATRIZ = array(
		     '-'  => 'No Aplica',
		     'NN'    => 'Persona Natural',
		     'NC'    => 'Persona Natural - Obligado a llevar contabilidad',
		     'PJ'    => 'Persona Juridico ',
		     'PE'    => 'Persona Juridico - Contribuyente Especial',
		     'PP'    => 'Persona Juridico - Sector Publico'
					);
		 return  $MATRIZ;
   }   
    function catalogo_tipo_pago(){
		 $MATRIZ = array(
						'N'    => 'Pagos por realizar',
						'S'    => 'Pagos realizados'
 					);
		 return  $MATRIZ;
   }   
   // agregar lista de catalogos comunes
    function catalogo_tipo_sangre(){
		 $MATRIZ = array(
						'B Rh-Positivo'    => 'B Rh-Positivo',
						'A Rh-Negativo'    => 'A Rh-Negativo',
						'A Rh-Positivo'    => 'A Rh-Positivo',
						'Ab Rh-Negativo'    => 'Ab Rh-Negativo',
						'Ab Rh-Positivo'    => 'Ab Rh-Positivo',
						'O Rh-Negativo'    => 'O Rh-Negativo',
						'O Rh-Positivo'    => 'O Rh-Positivo',
						'B Rh-Negativo'    => 'B Rh-Negativo'
					);
		 return  $MATRIZ;
   }   
       // agregar lista de catalogos comunes
    function catalogo_cargasf(){
		 $MATRIZ = array(
						'1'    => '1 Persona',
						'2'    => '2 Personas',
						'3'    => '3 Personas',
						'4'    => '4 Personas',
						'5'    => '5 Personas',
						'6'    => '6 Personas'
					);
		 return  $MATRIZ;
   }    
       // agregar lista de catalogos comunes
    function catalogo_nivel_cuenta(){
		 $MATRIZ = array(
						'0'    => '-',
						'1'    => '1',
						'2'    => '2',
						'3'    => '3',
						'4'    => '4',
						'5'    => '5',
						'6'    => '6',
		                '7'    => '7',
                        '8'    => '8'
					);
		 return  $MATRIZ;
   } 
        // agregar lista de catalogos comunes
    function catalogo_dnivel_cuenta(){
		 $MATRIZ = array(
						'0'    => '-',
						'1'    => 'Nivel 1',
						'2'    => 'Nivel 2',
						'3'    => 'Nivel 3',
						'4'    => 'Nivel 4',
						'5'    => 'Nivel 5',
						'6'    => 'Nivel 6'
					);
		 return  $MATRIZ;
   } 
     // agregar lista de catalogos comunescatalogo_con_tipoa
    function catalogo_con_tipoa(){
		 $MATRIZ = array(
						'F'    => 'N1 Finaciero',
		                'A'    => 'N2 Ajuste',
		                'C'    => 'N3 Orden',
		                'T'    => 'N4 Apertura',
						'O'    => 'A1 Anticipo Nomina',
						'P'    => 'A2 Anticipo Proveedor',
		                'B'    => 'A3 Bancos',
		                'X'    => 'A4 Caja',
		                'R'    => 'G1 Ingresos',
						'I'    => 'G2 Inventario',
		                'D'    => 'G3 Activos Fijos',
						'N'    => 'G4 Nomina',
		                'K'    => 'B1 AFECTACION FLUJO-CAJA'
  					);
		 return  $MATRIZ;
   } 
   //---------
   // agregar lista de catalogos comunescatalogo_con_tipoa
   function catalogo_con_tipo_teso(){
       $MATRIZ = array(
           'O'    => 'A1 Anticipo Nomina',
           'P'    => 'A2 Anticipo Proveedor',
           'B'    => 'A3 Bancos',
           'X'    => 'A4 Caja',
           'R'    => 'G1 Ingresos'
       );
       return  $MATRIZ;
   } 
      // agregar lista de catalogos comunescatalogo_con_tipoa
    function catalogo_con_tipob(){
		 $MATRIZ = array(
						'F'    => 'Finaciero',
						'I'    => 'Inventario',
						'N'    => 'Nomina'
 					);
		 return  $MATRIZ;
   } 
       // agregar lista de catalogos comunescatalogo_con_tipoa
    function catalogo_modulo_anexos(){
		 $MATRIZ = array(
						'C'    => 'Compras',
						'V'    => 'Ventas',
						'I'    => 'Importaciones',
						'T'    => 'Anexos Transaccional',
 					);
		 return  $MATRIZ;
   } 
       // agregar lista de catalogos comunescatalogo_con_tipoa
    function catalogo_tmodulo_anexos(){
		 $MATRIZ = array(
						'1'    => 'Detalle',
 						'2'    => 'Resumen',
 					);
		 return  $MATRIZ;
   }   
     // agregar lista de catalogos comunescatalogo_con_tipoa
    function catalogo_mes(){
		 $MATRIZ = array(
						'1'    => 'Enero',
						'2'    => 'Febrero',
						'3'    => 'Marzo',
						'4'    => 'Abril',
						'5'    => 'Mayo',
						'6'    => 'Junio',
						'7'    => 'Julio',
						'8'    => 'Agosto',
						'9'    => 'Septiembre',
						'10'    => 'Octubre',
						'11'    => 'Noviembre',
						'12'    => 'Diciembre'
					);
		 return  $MATRIZ;
   }   
   
   function catalogo_mes_nomina(){
	$MATRIZ = array(
				   '-'    => ' -- Todos los meses -- ',
				   '1'    => 'Enero',
				   '2'    => 'Febrero',
				   '3'    => 'Marzo',
				   '4'    => 'Abril',
				   '5'    => 'Mayo',
				   '6'    => 'Junio',
				   '7'    => 'Julio',
				   '8'    => 'Agosto',
				   '9'    => 'Septiembre',
				   '10'    => 'Octubre',
				   '11'    => 'Noviembre',
				   '12'    => 'Diciembre'
			   );
	return  $MATRIZ;
} 

  // agregar lista de catalogos comunes
   function catalogo_naturaleza_cuenta(){
		 $MATRIZ = array(
						'A'    => 'ACTIVO',
						'P'    => 'PASIVO',
						'T'    => 'PATRIMONIO',
						'I'    => 'INGRESO',
						'G'    => 'GASTO',
                        'O'    => 'ORDEN' 
					);
		 return  $MATRIZ;
   }  
    // agregar lista de catalogos comunes
   function catalogo_tributa(){
		 $MATRIZ = array(
						'-'    => 'No Aplica',
						'I'    => 'Genera 12 %',
						'T'    => 'Genera Tarifa 0'
					);
		 return  $MATRIZ;
   }    
  // agregar lista de catalogos comunes
   function catalogo_tipo_cuenta(){
		 $MATRIZ = array(
						'-'    => 'Normal',
						'B'    => 'Bancos',
						'P'    => 'Cta x Pagar Proveedores',
						'C'    => 'Cta x Cobrar Ingresos',
						'I'    => 'IVA Compras',
		                'G'    => 'IVA Ventas',
						'R'    => 'Retencion en la Fuente',
		                'T'    => 'Retencion IVA Compras',
						'V'    => 'Inventarios',
						'F'    => 'Facturacion-Ingresos',
                        'X'    => 'Resultado Actual',
		                'E'    => 'Resultado Anterior',
            		     'J'    => 'Anticipo Proveedor',
            		     'M'    => 'Anticipo Cliente',
            		     'N'    => 'Anticipo Empleado',
						 'A'    => 'Activos Fijos',
		                 'D'    => 'Roles Nomina',
		                 'K' => 'Aplicacion de Gasto',
		                 'H' => 'Acumulacion del Gasto',
		                 'L' => 'Inversion Publica' 
		     
					);
		 return  $MATRIZ;
   }        
   // agregar lista de catalogos comunes
   function catalogo_tipo_cuentab(){
		 $MATRIZ = array(
		     '-'    => 'Normal',
		     'B'    => 'Bancos',
		     'P'    => 'Cta x pagar',
		     'C'    => 'Cta x Cliente',
		     'I'    => 'IVA Compras',
		     'R'    => 'Retencion Fuente',
		     'T'    => 'Retencion IVA',
		     'V'    => 'Inventarios',
		     'F'    => 'Facturacion',
		     'X'    => 'Resultado actual',
		     'J'    => 'Anticipo Proveedor',
		     'M'    => 'Anticipo Cliente',
		     'N'    => 'Anticipo Empleado',
		     'A'    => 'Activos Fijos',
		     'D'    => 'Roles Nomina'
					);
		 return  $MATRIZ;
   } 
   // catalogo para lista de valores de catalogos activo
    function catalogo_activo(){
				$MATRIZ = array(
				'S'    => 'Activo',
				'N'    => 'Inactivo'
				);
		 return  $MATRIZ;
   }  
   // catalogo para lista de valores de catalogos activo
    function catalogo_activo_periodo(){
				$MATRIZ = array(
				'cerrado'    => 'cerrado',
				'abierto'    => 'abierto'
				);
		 return  $MATRIZ;
   } 
     // catalogo para lista de valores de catalogos activo
    function catalogo_prioridad_tarea(){
				$MATRIZ = array(
				'baja'    => 'Baja',
				'media'    => 'Media',
				'alta'    => 'Alta'
				);
		 return  $MATRIZ;
   }  
     // catalogo para lista de valores de catalogos activo
    function catalogo_estado_tarea(){
				$MATRIZ = array(
				'solicitado'    => 'solicitado',
				'en proceso'    => 'en proceso',
				'finalizado'    => 'finalizado',
				'no cumplido'    => 'no cumplido',
				'anulado'    => 'anulado'
				);
		 return  $MATRIZ;
   }         
   // catalogo para lista de valores de catalogos activo
   
   function catalogo_categoria_noticia(){   
  		 $MATRIZ = array( 
                                                        "Actualidad" => 'Actualidad',
                                                        "Opinion" => 'Opini�n',
                                                        "Servicios" => 'Servicios',
                                                        "Comunidad" => 'Comunidad'
                                                    );
		 return  $MATRIZ;
   } 
/*
3.  catalogo para lista de valores de catalogos activo
*/
  
   
   function catalogo_regimen_laboral(){   
  		 $MATRIZ = array( 
  		        "codigo de trabajo" => 'Contrato codigo de trabajo',
  		        "contrato" => 'Servicios personal por contrato',
                "nombramiento" => 'Nombramiento',
 				"pasantes" => 'Pasantes'
                                                    );
		 return  $MATRIZ;
     } 
      // catalogo para lista de valores de catalogos activo

   function catalogo_categoria_galeria(){   
														$MATRIZ = array(
															'Actualidad' => 'Actualidad',
															'Comunidad' => 'Comunidad',
															'Gente' => 'Gente' ,
															'Naturaleza' => 'Naturaleza' ,
															'Paisaje' => 'Paisaje' ,
															'Publicidad' => 'Publicidad',
															'Social' => 'Social' 
														);
		 return  $MATRIZ;
   }            
   // catalogo para determinar la empresa principal en los parametros
    function catalogo_empresa_principal(){
			$MATRIZ = array(
				'-'    => '-',
				'principal'    => 'Principal'
		);
 		return $MATRIZ; 	
   }  
   // catalogo para determinar la empresa principal en los parametros
    function catalogo_sino(){
		$MATRIZ = array(
			'N'    => 'No',
			'S'    => 'Si'
		);
		return $MATRIZ; 	
   } 
   // catalogo para determinar la empresa principal en los parametros
   function deudor_acreedor(){
       $MATRIZ = array(
           'D'    => 'Deudor',
           'A'    => 'Acreedor'
       );
       return $MATRIZ;
   } 
   // catalogo para determinar la empresa principal en los parametros
    function catalogo_sinob(){
		$MATRIZ = array(
			''    => '-',
			'N'    => 'No',
			'S'    => 'Si'
		);
		return $MATRIZ; 	
   }      
    // catalogo para determinar la empresa principal en los parametros
    function catalogo_query_sino(){
		$MATRIZ = array(
			''    => '-',
			'N'    => 'No',
			'S'    => 'Si'
		);
		return $MATRIZ; 	
   }   
   // catalogo para determinar la empresa principal en los parametros
    function catalogo_si(){
 		$MATRIZ = array(
														'SI'    => 'Si',
														'NO'    => 'No'
 		);
		return $MATRIZ; 	
   }    

   // catalogo para determinar la empresa principal en los parametros
    function catalogo_publica(){
	$MATRIZ = array( 
															"1" => '1',
															"2" => '2',
															"3" => '3',
															"4" => '4',
															"5" => '5',	
															"6" => '6',	
															"7" => '7',	
															"8" => '8',	
															"9" => '9',	
															"10" => '10',	
															"99" => '99'
														);	    
   		return $MATRIZ; 	
   }    
     // catalogo para determinar la empresa principal en los parametros
    function catalogo_modulo(){			
	$MATRIZ = array( 'A'    => 'Gesti�n Administrativo',
						 'F'    => 'Gesti�n Financiera',
						 'E'    => 'Gesti�n Empresarial'
						); 
 		return $MATRIZ; 
   }			
	 // catalogo para determinar la empresa principal en los parametros
    function catalogo_ruta(){			
		$MATRIZ = array(
														'kadmin'    => 'kadmin',
														'kcontabilidad'    => 'kcontabilidad',
														'Kpersonal'    => 'Kpersonal',
														'kclientes'    => 'kclientes',
														'ktesoreria'    => 'ktesoreria',
														'kdocumento'    => 'kdocumento',		
														'kcms'    => 'kcms',		
														'kcrm'    => 'kcrm',		
														'kflujo'    => 'kflujo',		
														'kestructura'    => 'kestructura',									
														'ktributacion'    => 'ktributacion',
														'kfacturacion'    => 'kfacturacion',							
														'kinventario'    => 'kinventario'
													);
 		return $MATRIZ; 					 
	}
	 // catalogo para determinar la empresa principal en los parametros
    function catalogo_ambito(){			
	$MATRIZ = array(
														'general'    => 'general',
														'administrativo'    => 'administrativo',
														'financiero'    => 'financiero',
														'hotel'    => 'hotel',
														'web cms'    => 'web cms',
														'crm'    => 'crm',
														'documental'    => 'documental',
														'workflow'    => 'workflow',
														'doctor'    => 'doctor',
		                                            );
     return $MATRIZ; 
	}
	 // catalogo para determinar la empresa principal en los parametros
    function catalogo_perfil(){			
		$MATRIZ = array(
			'web'    => 'Visitante',
			'admin'    => 'Administrador',
			'operativo'    => 'Operativo',
		    'autorizador'    => 'Autorizador',
		    'tecnico'    => 'Tecnico',
			'tthh'    => 'TTHH',
		    'planificacion'    => 'planificacion',
		    'financiero'    => 'financiero',
		    'administrativo'    => 'administrativo',
		    'procesos'    => 'procesos'
		);
 		return $MATRIZ; 
  }
	 // catalogo para determinar estado de asientos
    function catalogo_co_asientos(){			
		$MATRIZ = array(
			'digitado'    => 'Digitado',
			'aprobado'    => 'Aprobado',
			'anulado'    => 'Anulado'
		);
 		return $MATRIZ; 
  }
	 // catalogo de cuentas contables
    function catalogo_co_grupo(){			
		$MATRIZ = array(
			'-'    => ' ',
			'1'    => 'Activo',
			'2'    => 'Pasivo',
			'3'    => 'Patrimonio',
			'4'    => 'Ingreso',
			'5'    => 'Costo',
			'6'    => 'Gasto'
		);
 		return $MATRIZ; 
  }
}


?>
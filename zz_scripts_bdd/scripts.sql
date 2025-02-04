-- total de ciertos egresos
SELECT c.id_config, c.nombre, sum(descuento) as descuento FROM public.nom_rol_pagod d inner join public.nom_config_regimen r on r.id_config_reg = d.id_config inner join public.nom_config c on c.id_config = r.id_config WHERE anio = 2022 and c.id_config in (4,31,28,13,14) AND d.id_rol in (18) GROUP BY c.id_config,c.nombre

-- ver anticipos por cedula
SELECT * FROM public.co_anticipo WHERE anio = 2023 and idprov in ('1723274740','2300046568','1717610131','1717124661','2350079816') and estado='contabilizado' ORDER BY id_anticipo ASC



-- crear descuento

INSERT INTO nom_rol_pagod values (26,77602,114,1286,0,912.50,'2360003540001',2023,'07',2478,5,24,'NOMBRAMIENTOS LOSEP', '2021-04-01','1717124661',30,null, 288.69,'N',131,null)

INSERT INTO nom_rol_pagod values (26,77604,114,1360,0,152.22,'2360003540001',2023,'07',585,133,18,'NOMBRAMIENTOS LOSEP', '2018-04-09','2350079816',30,null, 68.15,'N',223,null)

INSERT INTO nom_rol_pagod values (26,77605,114,1360,0,77.78,'2360003540001',2023,'07',585,134,18,'NOMBRAMIENTOS LOSEP', '2018-04-09','1723274740',30,null, 68.15,'N',223,null)

INSERT INTO nom_rol_pagod values (26,77606,114,1360,0,200,'2360003540001',2023,'07',622,143,19,'NOMBRAMIENTOS LOSEP', '2015-01-07','1717610131',30,null, 72.46,'N',223,null)


-- enlace contable - presupuestario
select a.programa,a.partida, a.item, b.detalle, a.cuenta,
sum(a.debe) as debe, sum(a.haber) as haber
from co_asientod a, presupuesto.pre_catalogo b
where a.id_asiento = ".$this->bd->sqlvalue_inyeccion($id_asiento, true)." and
a.item = b.codigo and b.tipo= 'arbol'
group by a.partida, a.cuenta, a.item, a.programa,b.detalle
order by a.programa, a.item, a.cuenta


-- CONSULTA DE VALORES DE FACTURAS EMITIDAS PARA VALIDAR EN LA DECLARACIÓN DE LA TABLA co_ventas
SELECT total,a.creacion,mes,secuencial,enlace,a.autorizacion,x.razon,x.idprov
FROM rentas.ren_movimiento a
JOIN par_ciu x ON x.id_par_ciu = a.id_par_ciu
WHERE fecha between '2023-09-01' and '2023-09-30' and sesion_pago='wmoreno@cbsd.gob.ec'
ORDER BY id_ren_movimiento ASC 

SELECT secuencial,baseimponible,* FROM public.co_ventas
WHERE fechaemision between '2023-10-01' and '2023-10-31'

-- INSERT A LA TABLA co_ventas
INSERT INTO public.co_ventas VALUES  (1528, 0, '04', '2390626005001', '18', 1, 0, 40.5, 0, 0, 0, 0, '000000001', '001', '2023-11-05', '2360003540001', 0, 0, 1, 'E', '20',0);


--CONSULTAR ASIENTOS CON DETALLES POR BENEFICIARIO
SELECT  id_asiento as "Asiento",cuenta,
fecha as "Fecha", 
substring(comprobante,1,10)  as "Comprobante",
substring(detalle,1,150) as "Detalle",  
debe as "Debe", 
haber as "Haber",  
debe - haber as "Saldo"
FROM view_aux
where 
--idprov = '1723108930' and 
estado = 'aprobado' and 
anio = '2023' 
--and registro = '2360003540001' 
-- and cuenta = '. $this->bd->sqlvalue_inyeccion(trim($cuenta) , true).' 
order by cuenta, fecha

-- CUENTAS POR CIERTO TIPO DE CUENTA 
SELECT * FROM public.co_plan_ctas
WHERE tipo_cuenta in ('P','C','N') and anio='2023' and nivel = 5 -- P=CXP C=CXC N=NOMINA
ORDER BY cuenta ASC, registro ASC, anio ASC 


-- prototipo de consulta para asientos sin cerrar
select * from
(SELECT  idprov,cuenta,
Sum(debe - haber) as saldo
FROM view_aux
where 
estado = 'aprobado' and 
anio = '2023' and
cuenta in (SELECT cuenta FROM public.co_plan_ctas
WHERE tipo_cuenta in ('P','C','N') and anio='2023' and nivel = 5)
group by idprov,cuenta) as datos_cuentas
where saldo >0


--CONSULTAS PARA VALIDACION DE PRESUPUESO PARA SOLICITACION DE CERTIFICACION DE ROLES
SELECT  programa,programa, clasificador, patronal as monto
FROM  view_rol_patronal
where id_rol= 30 and 
regimen = 'CONTRATO OCASIONAL' union
SELECT programa,programa_original,clasificador,sum(ingreso) as monto
FROM view_rol_cer
where id_rol=30 and
tipo = 'Ingresos' and 
regimen ='CONTRATO OCASIONAL'
group by programa,programa_original,clasificador,nombre


--CONSULTAS PARA VALIDACION DE PRESUPUESO PARA SOLICITACION DE CERTIFICACION DE ROLES
SELECT  programa,programa as programa_original, clasificador, patronal as monto
FROM  view_rol_patronal
where id_rol= 30 and
regimen = 'CONTRATO OCASIONAL' union
SELECT programa,programa_original,clasificador,sum(ingreso) as monto
FROM view_rol_cer
where id_rol=30 and
tipo = 'Ingresos' and regimen ='CONTRATO OCASIONAL'
group by programa,programa_original,clasificador,nombre


-- CONSULTA DE ESPECIES EMITIDAS
select a.id_ren_movimiento,fecha,comprobante,base0,subtotal,a.total,secuencial
from rentas.ren_movimiento a
JOIN rentas.ren_movimiento_det c ON c.id_ren_movimiento = a.id_ren_movimiento
where idproducto_ser = 13 and anio = '2023' --and mes = '12'
AND (a.estado = ANY (ARRAY['E'::bpchar, 'P'::bpchar]))
order by a.id_ren_movimiento

select fecha ,min(comprobante) as d1, max(comprobante) as d2 ,sum(total) total, sum(cantidad) as nn 
from rentas.view_ren_especies
where  
mes = '09' and 
anio = '2023' and 
idproducto_ser = '13' 
group by fecha
order by fecha desc

-- FACTURAS EMITIDAS
SELECT  id_ren_movimiento, 
fecha_emision as fecha,  
idprov, 
nombre_rubro as detalle,
estado_proceso as estado,
coalesce(interes,0) as interes,
coalesce(descuento,0) as descuento,
coalesce(recargo,0) as recargo,
coalesce(emision,0 ) as emision ,
coalesce(total,0 ) as total 
FROM  rentas.view_ren_emision
where  fecha_emision between ".$this->bd->sqlvalue_inyeccion( $f1,true).' and '.$this->bd->sqlvalue_inyeccion($f2,true)." and 
modulo  <> 'especies' and 
sesion = 'wmoreno@cbsd.gob.ec'
order by id_ren_movimiento desc 
-- MOVIMIENTOS DE MEDICAMENTOS DE LA PLATAFORMA SERVICIOS EN LINEA.
-- INCLUYE CONSULTA MEDICA Y PACIENTE
SELECT im.inventario_registro, im.inventario_transaccion, im.inventario_cantidad, im.inventario_descripcion,im.fk_table, im.fk_id, me.medicamento_codigo, me.medicamento_presentacion, me.medicamento_nombre, me.medicamento_generico, me.medicamento_dosis, cm.personal_nombre,cm.consulta_motivo
FROM tthh.tb_inventario_medicamentos im
INNER JOIN tthh.tb_medicamentos me ON me.medicamento_id = im.fk_medicamento_id
LEFT OUTER JOIN tthh.vw_consultasmedicas cm ON cm.consulta_id = im.fk_id
ORDER BY inventario_registro ASC 

-- LISTADO DE MEDICAMENTOS CON MOVIMIENTOS
SELECT DISTINCT me.medicamento_codigo, me.medicamento_presentacion, me.medicamento_nombre, me.medicamento_generico, me.medicamento_dosis -- , im.inventario_registro, im.inventario_transaccion, im.inventario_cantidad, im.inventario_descripcion,im.fk_table, im.fk_id
FROM tthh.tb_inventario_medicamentos im
INNER JOIN tthh.tb_medicamentos me ON me.medicamento_id = im.fk_medicamento_id
ORDER BY medicamento_nombre ASC 

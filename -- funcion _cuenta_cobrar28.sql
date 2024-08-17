-- funcion _cuenta_cobrar28
-- View: public.view_aux_esigef_tr
-- DROP VIEW public.view_aux_esigef_tr;
CREATE
OR REPLACE VIEW public.view_aux_esigef_tr AS
SELECT
  a.id_asiento,
  a.idprov,
  a.cuenta,
  "substring"(a.cuenta :: text, 1, 6) AS cuenta_es,
  "substring"(a.cuenta :: text, 1, 3) AS grupo_es,
  "substring"(a.cuenta :: text, 5, 2) AS subgrupo_es,
  '00' :: text AS nivel_es,
  a.debe,
  a.haber,
  b.razon,
  a.registro,
  c.fecha,
  a.comprobante,
  a.id_asiento_ref,
  c.id_tramite,
  COALESCE(a.debe, 0 :: numeric) + COALESCE(a.haber, 0 :: numeric) AS monto,
  "substring"(x.item :: text, 1, 2) AS grupoi,
  "substring"(x.item :: text, 3, 2) AS subgrupoi,
  "substring"(x.item :: text, 5, 2) AS itemi,
  c.anio,
  c.mes,
  x.partida,
  d.impresion
FROM
  co_asiento_aux a
  JOIN par_ciu b ON a.idprov = b.idprov
  JOIN co_asiento c ON c.id_asiento = a.id_asiento
  AND a.anio :: text = c.anio :: character varying :: text
  AND c.estado = 'aprobado' :: bpchar
  JOIN co_plan_ctas d ON a.cuenta = d.cuenta
  AND a.anio :: character varying :: text = d.anio :: text
  AND (
    "substring"(d.cuenta :: text, 1, 3) = ANY (ARRAY ['113'::text])
  )
  AND (
    "substring"(d.cuenta :: text, 5, 2) = ANY (ARRAY ['28'::text, '18'::text])
  )
  LEFT JOIN co_asientod x ON x.id_asiento = c.id_asiento
  AND x.id_asientod = a.id_asientod
ORDER BY
  c.anio,
  c.mes,
  c.id_asiento;

ALTER TABLE
  public.view_aux_esigef_tr OWNER TO postgres;
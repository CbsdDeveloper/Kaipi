-- funcion _cuenta_anticipo
-- View: public.view_aux_esigef_an
-- DROP VIEW public.view_aux_esigef_an;
CREATE
OR REPLACE VIEW public.view_aux_esigef_an AS
SELECT
  a.id_asiento,
  a.idprov,
  a.cuenta,
  "substring"(a.cuenta :: text, 1, 6) AS cuenta_es,
  "substring"(a.cuenta :: text, 1, 3) AS grupo_es,
  "substring"(a.cuenta :: text, 5, 2) AS subgrupo_es,
  "substring"(a.cuenta :: text, 8, 2) AS nivel_es,
  a.debe,
  a.haber,
  b.razon,
  a.registro,
  c.fecha,
  a.comprobante,
  a.id_asiento_ref,
  c.id_tramite,
  COALESCE(a.debe, 0 :: numeric) + COALESCE(a.haber, 0 :: numeric) AS monto,
  c.anio,
  c.mes,
  x.partida,
  d.impresion AS esigef
FROM
  co_asiento_aux a
  JOIN par_ciu b ON a.idprov = b.idprov
  JOIN co_asiento c ON c.id_asiento = a.id_asiento
  AND a.anio :: text = c.anio :: character varying :: text
  AND c.estado = 'aprobado' :: bpchar
  JOIN co_plan_ctas d ON a.cuenta = d.cuenta
  AND a.anio :: character varying :: text = d.anio :: text
  AND (
    "substring"(d.cuenta :: text, 1, 6) = ANY (
      ARRAY ['112.05'::text, '112.07'::text, '212.05'::text, '212.07'::text]
      -- se cambia para que muestr solo las 112 en general
    )
  )
  LEFT JOIN co_asientod x ON x.id_asiento = c.id_asiento
  AND x.id_asientod = a.id_asientod
ORDER BY
  c.anio,
  c.mes,
  c.id_asiento;

ALTER TABLE
  public.view_aux_esigef_an OWNER TO postgres;
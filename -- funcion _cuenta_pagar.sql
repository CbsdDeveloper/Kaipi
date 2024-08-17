-- funcion _cuenta_pagar
-- View: public.view_aux_esigef
-- DROP VIEW public.view_aux_esigef;

CREATE
OR REPLACE VIEW public.view_aux_esigef AS
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
  COALESCE("substring"(x.item :: text, 1, 2), '00' :: text) AS grupoi,
  COALESCE("substring"(x.item :: text, 3, 2), '00' :: text) AS subgrupoi,
  COALESCE("substring"(x.item :: text, 5, 2), '00' :: text) AS itemi,
  c.anio,
  c.mes,
  x.partida,
  d.impresion,
  CASE
    WHEN a.debe <> 0 :: numeric THEN 'D' :: text
    ELSE 'H' :: text
  END AS tipo_dato
FROM
  co_asiento_aux a
  JOIN par_ciu b ON a.idprov = b.idprov
  JOIN co_asiento c ON c.id_asiento = a.id_asiento
  AND a.anio :: text = c.anio :: character varying :: text
  AND c.estado = 'aprobado' :: bpchar
  JOIN co_plan_ctas d ON a.cuenta = d.cuenta
  AND a.anio :: character varying :: text = d.anio :: text
  AND (
    "substring"(d.cuenta :: text, 1, 3) = ANY (ARRAY ['213'::text])
  )
  AND (
    "substring"(d.cuenta :: text, 5, 2) = ANY (
      ARRAY ['53'::text, '58'::text, '57'::text, '77'::text, '98'::text, '84'::text, '85'::text, '73'::text, '75'::text, '97'::text, '78'::text, '84'::text, '83'::text, '85'::text, '96'::text, '56'::text]
      -- se debe agregar la 51
    )
  )
  LEFT JOIN co_asientod x ON x.id_asiento = c.id_asiento
  AND x.id_asientod = a.id_asientod
ORDER BY
  c.anio,
  c.mes,
  c.id_asiento;

ALTER TABLE
  public.view_aux_esigef OWNER TO postgres;
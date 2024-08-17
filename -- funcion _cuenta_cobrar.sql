-- funcion _cuenta_cobrar
-- View: public.view_aux_esigef_cxc
-- DROP VIEW public.view_aux_esigef_cxc;
CREATE
OR REPLACE VIEW public.view_aux_esigef_cxc AS
SELECT
  a.anio,
  a.mes,
  b.registro,
  max(a.id_asiento) AS id_asiento,
  a.cuenta_esigef,
  a.clasificador AS item,
  a.grupo,
  a.subgrupo,
  a.item_p,
  sum(a.haber) AS debe,
  sum(a.debe) AS haber,
  '113.' :: text || a.grupo AS cxc,
  max(b.fecha) AS fechaa,
  '113' :: text AS grupo_es,
  '9999999999999' :: text AS ruc,
  'CONSUMIDOR FINAL' :: text AS nombre
FROM
  view_diario_tipo a,
  co_asiento b
WHERE
  a.cuenta_esigef ~~ '62%' :: text
  AND (
    a.grupo = ANY (
      ARRAY ['11'::text, '13'::text, '14'::text, '15'::text, '17'::text, '19'::text, '24'::text, '25'::text]
    )
  )
  AND a.id_asiento = b.id_asiento
  AND b.estado = 'aprobado' :: bpchar
  AND a.id_asiento = b.id_asiento
GROUP BY
  a.anio,
  a.mes,
  b.registro,
  a.cuenta_esigef,
  a.clasificador,
  a.grupo,
  a.subgrupo,
  a.item_p
UNION
SELECT
  a.anio,
  a.mes,
  b.registro,
  max(a.id_asiento) AS id_asiento,
  a.cuenta_esigef,
  a.item,
  a.grupo,
  a.subgrupo,
  a.item_p,
  sum(a.haber) AS debe,
  sum(a.debe) AS haber,
  '113.' :: text || a.grupo AS cxc,
  max(b.fecha) AS fechaa,
  '113' :: text AS grupo_es,
  '9999999999999' :: text AS ruc,
  'CONSUMIDOR FINAL' :: text AS nombre
FROM
  view_diario_tipo a,
  co_asiento b
WHERE
  a.cuenta_esigef ~~ '124%' :: text
  AND a.id_asiento = b.id_asiento
  AND (a.grupo = ANY (ARRAY ['37'::text, '38'::text]))
  AND b.estado = 'aprobado' :: bpchar
GROUP BY
  a.anio,
  a.mes,
  a.cuenta_esigef,
  a.item,
  a.grupo,
  a.subgrupo,
  a.item_p,
  b.registro
UNION
SELECT
  a.anio,
  a.mes,
  b.registro,
  max(a.id_asiento) AS id_asiento,
  "substring"(a.cuenta_esigef, 1, 6) AS cuenta_esigef,
  '00' :: character varying AS item,
  max(a.grupo) AS grupo,
  '00' :: text AS subgrupo,
  '00' :: text AS item_p,
  sum(a.debe) AS debe,
  sum(a.haber) AS haber,
  '113.' :: text || max(a.grupo) AS cxc,
  max(b.fecha) AS fechaa,
  '113' :: text AS grupo_es,
  '9999999999999' :: text AS ruc,
  'CONSUMIDOR FINAL' :: text AS nombre
FROM
  view_diario_tipo a,
  co_asiento b
WHERE
  a.cuenta_esigef ~~ '113%' :: text
  AND (
    a.grupo = ANY (
      ARRAY ['11'::text, '13'::text, '14'::text, '15'::text, '17'::text, '19'::text, '24'::text, '38'::text]
      -- se debe agregar la 85
    )
  )
  AND a.id_asiento = b.id_asiento
  AND b.estado = 'aprobado' :: bpchar
  AND a.haber <> 0 :: numeric
GROUP BY
  a.anio,
  a.mes,
  ("substring"(a.cuenta_esigef, 1, 6)),
  b.registro
ORDER BY
  1,
  2;

ALTER TABLE
  public.view_aux_esigef_cxc OWNER TO postgres;

-- CARGOS DISTRIBUTIVO
DROP TABLE IF EXISTS bomberos.bombero_cargo;
CREATE TABLE IF NOT EXISTS bomberos.bombero_cargo (
    cargo_id SERIAL PRIMARY KEY,
    fk_id_estacion integer,
    cargo_registro timestamp without time zone DEFAULT ('now' :: text) :: timestamp(0) with time zone,
    cargo_denominacion text COLLATE pg_catalog."default",
    cargo_horario text COLLATE pg_catalog."default",
    cargo_horas_dia integer,
    cargo_hora_entrada text COLLATE pg_catalog."default",
    cargo_hora_salida text COLLATE pg_catalog."default",
    cargo_hora_descanso text COLLATE pg_catalog."default",
    cargo_descanso_entrada text COLLATE pg_catalog."default",
    cargo_descanso_salida text COLLATE pg_catalog."default",
    cargo_rancho text COLLATE pg_catalog."default",
    cargo_estado text COLLATE pg_catalog."default" DEFAULT 'ACTIVO' :: text
) WITH (OIDS = FALSE) TABLESPACE pg_default;
-- FIN CARGOS DISTRIBUTIVO

-- GRUPOS
DROP TABLE IF EXISTS bomberos.bombero_grupo;
CREATE TABLE IF NOT EXISTS bomberos.bombero_grupo (
    grupo_id SERIAL PRIMARY KEY,
    grupo_registro timestamp without time zone DEFAULT ('now' :: text) :: timestamp(0) with time zone,
    fk_id_estacion integer NOT NULL,
    grupo_estado text COLLATE pg_catalog."default" DEFAULT 'ACTIVO' :: text,
    grupo_numero text COLLATE pg_catalog."default"
) WITH (OIDS = FALSE) TABLESPACE pg_default;
-- FIN GRUPOS

-- ENCABEZADO DISTRIBUTIVO
DROP TABLE IF EXISTS bomberos.bombero_distributivo;
CREATE TABLE IF NOT EXISTS bomberos.bombero_distributivo (
    distributivo_id SERIAL PRIMARY KEY,
    anio integer NOT NULL,
    fk_sesion varchar(120) NOT NULL,
    distributivo_estado text COLLATE pg_catalog."default" DEFAULT 'ACTIVO' :: text,
    distributivo_codigo text COLLATE pg_catalog."default",
    distributivo_registro timestamp without time zone DEFAULT ('now' :: text) :: timestamp(0) with time zone,
    distributivo_documento text COLLATE pg_catalog."default",
    distributivo_rigedesde timestamp without time zone NOT NULL,
    distributivo_rigehasta timestamp without time zone NOT NULL,
    fk_idprov_jefe varchar(13) NOT NULL,
    fk_id_cargo_jefe integer NOT NULL,
    fk_idprov_subjefe varchar(13) NOT NULL,
    fk_id_cargo_subjefe integer NOT NULL,
    fk_idprov_operaciones varchar(13) NOT NULL,
    fk_id_cargo_operaciones integer NOT NULL,
    fk_idprov_tthh varchar(13) NOT NULL,
    fk_id_cargo_tthh integer NOT NULL
) WITH (OIDS = FALSE) TABLESPACE pg_default;
-- FIN ENCABEZADO DISTRIBUTIVO

-- DETALLE DISTRIBUTIVO - ASIGNACIONES 
DROP TABLE IF EXISTS bomberos.bombero_distributivo_det;
CREATE TABLE IF NOT EXISTS bomberos.bombero_distributivo_det (
    distributivo_det_id SERIAL PRIMARY KEY,
    fk_distributivo_id integer NOT NULL,
    fk_grupo_id varchar(13) NOT NULL,
    fk_cargo_id varchar(13) NOT NULL,
    fk_idprov varchar(13) NOT NULL,
    fk_id_cargo_idprov integer NOT NULL,
    distributivo_det_estado text COLLATE pg_catalog."default" DEFAULT 'ACTIVO' :: text
) WITH (OIDS = FALSE) TABLESPACE pg_default;
-- FIN DETALLE DISTRIBUTIVO - ASIGNACIONES 

DROP SEQUENCE IF EXISTS adm.adm_vehiculos_id_seq;

CREATE SEQUENCE IF NOT EXISTS adm.adm_vehiculos_id_seq
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1
    OWNED BY adm.adm_vehiculos;

CREATE TABLE IF NOT EXISTS adm.adm_vehiculos (
    vehiculo_id integer NOT NULL DEFAULT nextval('adm.ad_taller_eje_id_ta_eje_seq'::regclass),
    fk_usuario_id integer,
    vehiculo_registro timestamp without time zone DEFAULT ('now' :: text) :: timestamp(0) with time zone,
    vehiculo_estado text COLLATE pg_catalog."default" DEFAULT 'ACTIVO' :: text,
    vehiculo_direccion text COLLATE pg_catalog."default",
    vehiculo_placa text COLLATE pg_catalog."default" NOT NULL,
    vehiculo_toneladas numeric(4, 2),
    vehiculo_tipo text COLLATE pg_catalog."default" DEFAULT 'CAMION' :: text,
    vehiculo_color1 text COLLATE pg_catalog."default",
    vehiculo_marca text COLLATE pg_catalog."default",
    vehiculo_fingreso timestamp without time zone DEFAULT ('now' :: text) :: timestamp(0) with time zone,
    propietario_id integer,
    vehiculo_modelo text COLLATE pg_catalog."default",
    vehiculo_chasis text COLLATE pg_catalog."default",
    vehiculo_motor text COLLATE pg_catalog."default",
    vehiculo_combustible text COLLATE pg_catalog."default" DEFAULT 'DIESEL' :: text,
    vehiculo_avaluo numeric(10, 2),
    vehiculo_anio integer,
    vehiculo_pais text COLLATE pg_catalog."default",
    vehiculo_corroceria text COLLATE pg_catalog."default",
    vehiculo_pasajeros integer,
    vehiculo_cilindraje numeric(6, 2),
    vehiculo_color2 text COLLATE pg_catalog."default",
    vehiculo_proposito text COLLATE pg_catalog."default" DEFAULT 'PARTICULAR' :: text,
    vehiculo_anio_matricula integer,
    vehiculo_ramv text COLLATE pg_catalog."default",
    CONSTRAINT tb_vehiculoglp_pkey PRIMARY KEY (vehiculo_id),
    CONSTRAINT tb_vehiculoglp_fk_usuario_id_fkey FOREIGN KEY (fk_usuario_id) REFERENCES admin.tb_usuarios (usuario_id) MATCH SIMPLE ON UPDATE NO ACTION ON DELETE NO ACTION,
    CONSTRAINT tb_vehiculos_propietario_id_fkey FOREIGN KEY (propietario_id) REFERENCES resources.tb_personas (persona_id) MATCH SIMPLE ON UPDATE NO ACTION ON DELETE NO ACTION
) WITH (OIDS = FALSE) TABLESPACE pg_default;
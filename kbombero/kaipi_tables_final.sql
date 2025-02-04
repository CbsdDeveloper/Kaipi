DROP TABLE IF EXISTS bomberos.incidentes_bom CASCADE;
DROP TABLE IF EXISTS bomberos.sci_personas CASCADE;
DROP TABLE IF EXISTS bomberos.bombero_sci_resumen_acciones CASCADE;
DROP TABLE IF EXISTS bomberos.bombero_sci_datos_generales CASCADE;
DROP TABLE IF EXISTS bomberos.bombero_sci_objetivos CASCADE;
DROP TABLE IF EXISTS bomberos.detalles_marcador CASCADE;
DROP TABLE IF EXISTS bomberos.iconos_marcador CASCADE;
DROP TABLE IF EXISTS bomberos.bombero_sci_analisis_seguridad CASCADE;
DROP TABLE IF EXISTS bomberos.bombero_sci_registro_personal CASCADE;
DROP TABLE IF EXISTS bomberos.bombero_sci_recursos CASCADE;
DROP TABLE IF EXISTS bomberos.bombero_sci_plan_comunicaciones CASCADE;
DROP TABLE IF EXISTS bomberos.bombero_sci_verificacion_desmovilizacion CASCADE;
DROP TABLE IF EXISTS bomberos.bombero_sci_asignaciones CASCADE;
DROP TABLE IF EXISTS bomberos.bombero_sci_responsables CASCADE;
DROP TABLE IF EXISTS bomberos.bombero_sci_pai_dat_gen CASCADE;
DROP TABLE IF EXISTS bomberos.bombero_sci_pai_objetivos CASCADE;
DROP TABLE IF EXISTS bomberos.bombero_sci_214 CASCADE;

---------------------------------------------------------------------
-- INCIDENTES
---------------------------------------------------------------------

CREATE TABLE bomberos.incidentes_bom (
    id_incidentes serial PRIMARY KEY not null,
    nombre_inci text not null,
    lugar_inci text not null,
    municipio_canton text not null,
    localidad text,
    estatus text not null,
    fecha_hora_inci timestamp without time zone DEFAULT CURRENT_TIMESTAMP(0) not null,
    fecha_cierre_oper timestamp without time zone DEFAULT CURRENT_TIMESTAMP(0),
	anio INTEGER,
	email_usuario TEXT
);
---------------------------------------------------------------------
-- REGISTRO DE VICTIMAS
---------------------------------------------------------------------
CREATE TABLE bomberos.sci_personas (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(255),
    sexo CHAR(10) NOT NULL,
    edad INT,
    clasificacion VARCHAR(50) NOT NULL,
    lugar_traslado VARCHAR(255),
    trasladado_por VARCHAR(255),
    fecha_hora timestamp without time zone DEFAULT CURRENT_TIMESTAMP(0),
    probable_diagnostico TEXT,
	id_incidente INTEGER REFERENCES bomberos.incidentes_bom(id_incidentes)
);
---------------------------------------------------------------------
-- RESUMEN ACCIONES
---------------------------------------------------------------------

CREATE TABLE bomberos.bombero_sci_resumen_acciones (
    id_bom_res_acc SERIAL PRIMARY KEY,
    actividad TEXT NOT NULL,
    fecha_hora timestamp without time zone DEFAULT CURRENT_TIMESTAMP(0) NOT NULL,
    posicion_institucion TEXT NOT NULL,
    id_incidente INTEGER REFERENCES bomberos.incidentes_bom(id_incidentes)
);
---------------------------------------------------------------------
-- DATOS GENERALES
---------------------------------------------------------------------
CREATE TABLE bomberos.bombero_sci_datos_generales (
    id_bom_datos_g SERIAL PRIMARY KEY,
    evaluacion_inicial TEXT NOT NULL,
    ubicacion_puesto_comando TEXT NOT NULL,
    area_espera TEXT NOT NULL,
    ruta_egreso TEXT NOT NULL,
    ruta_ingreso TEXT NOT NULL,
    mensaje_seguridad TEXT,
    distribucion_canales_comunicacion TEXT,
    datos_meteorologicos TEXT,
    fecha_hora_preparacion timestamp without time zone DEFAULT CURRENT_TIMESTAMP(0) not null,
    fecha_creacion timestamp without time zone DEFAULT CURRENT_TIMESTAMP(0) not null,
    fecha_edicion timestamp without time zone DEFAULT CURRENT_TIMESTAMP(0),
    anio INTEGER,
    email_usuario TEXT,
    id_incidente INTEGER REFERENCES bomberos.incidentes_bom(id_incidentes),
    posicion TEXT,
    elaborado_por TEXT
);


CREATE TABLE bomberos.bombero_sci_objetivos (
    id_objetivo SERIAL PRIMARY KEY,
    id_bom_datos_g INTEGER REFERENCES bomberos.bombero_sci_datos_generales(id_bom_datos_g),
    objetivo TEXT,
    estrategia TEXT,
    tactica TEXT
);
---------------------------------------------------------------------
-- MAPA
---------------------------------------------------------------------
CREATE TABLE bomberos.detalles_marcador (
    id SERIAL PRIMARY KEY,
    titulo TEXT NOT NULL,
    latitud TEXT NOT NULL,
    longitud TEXT NOT NULL,
    observaciones TEXT,
    imagen_url TEXT,
    fecha_creacion timestamp without time zone DEFAULT CURRENT_TIMESTAMP(0),
    id_incidente INTEGER REFERENCES bomberos.incidentes_bom(id_incidentes)
);

-- Tabla para almacenar la información del icono
CREATE TABLE bomberos.iconos_marcador (
    id SERIAL PRIMARY KEY,
    marcador_id INTEGER REFERENCES bomberos.detalles_marcador(id) ON DELETE CASCADE,
    clase_icono TEXT,
    color_icono TEXT,
    imagen_url TEXT,
    fecha_creacion timestamp without time zone DEFAULT CURRENT_TIMESTAMP(0)
);
---------------------------------------------------------------------
-- REGISTRO DE ANALISIS DE SEGURIDAD
---------------------------------------------------------------------


CREATE TABLE bomberos.bombero_sci_analisis_seguridad (
    id_analisis_seguridad SERIAL PRIMARY KEY,
    area VARCHAR(255) NOT NULL,
    riesgo TEXT NOT NULL,
    accion_mitigante TEXT NOT NULL,
    posicion VARCHAR(50) NOT NULL,
    id_incidente INTEGER REFERENCES bomberos.incidentes_bom(id_incidentes),
    fecha_creacion timestamp without time zone DEFAULT CURRENT_TIMESTAMP(0) NOT NULL,
    fecha_edicion timestamp without time zone DEFAULT CURRENT_TIMESTAMP(0)
);


---------------------------------------------------------------------
-- REGISTRO DEL PERSONAL
---------------------------------------------------------------------

CREATE TABLE bomberos.bombero_sci_registro_personal (
    id_bombero SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    especialidad VARCHAR(100),
    institucion VARCHAR(150) NOT NULL,
    matricula_vehiculo VARCHAR(50),
    observaciones TEXT,
    id_incidente INTEGER REFERENCES bomberos.incidentes_bom(id_incidentes),
    fecha_creacion timestamp without time zone DEFAULT CURRENT_TIMESTAMP(0) not null,
    fecha_edicion timestamp without time zone DEFAULT CURRENT_TIMESTAMP(0)
);

---------------------------------------------------------------------
-- REGISTRO DEL RECURSOS
---------------------------------------------------------------------

CREATE TABLE bomberos.bombero_sci_recursos (
    id SERIAL PRIMARY KEY,
    clase TEXT NOT NULL,
    tipo TEXT NOT NULL,
    fecha_hora_solicitud TEXT NOT NULL,
    solicitado_por TEXT NOT NULL,
    fecha_hora_arribo TEXT,
    institucion TEXT,
    matricula TEXT,
    numero_personas TEXT,
    estado_recurso TEXT NOT NULL,
    asignado_a TEXT,
    periodo_operacional TEXT,
    fecha_hora_desmovilizacion TEXT,
    responsable_desmovilizacion TEXT,
    observaciones TEXT,
    id_incidente INTEGER REFERENCES bomberos.incidentes_bom(id_incidentes)
);


---------------------------------------------------------------------
-- REGISTRO DE PLAN DE COMUNICACIONES
---------------------------------------------------------------------

CREATE TABLE bomberos.bombero_sci_plan_comunicaciones (
    id_plan_comunicaciones SERIAL PRIMARY KEY,
    periodo VARCHAR(50),
    sistema VARCHAR(50),
    canal_frecuencia VARCHAR(100),
    asignado VARCHAR(100),
    ubicacion VARCHAR(255),
    observaciones TEXT,
    elaborado_por VARCHAR(100),
    posicion VARCHAR(50),
    id_incidente INTEGER,
    fecha_creacion timestamp without time zone DEFAULT CURRENT_TIMESTAMP(0),
    FOREIGN KEY (id_incidente) REFERENCES bomberos.incidentes_bom(id_incidentes)
);

---------------------------------------------------------------------
-- PAI DATOS GENERALES
---------------------------------------------------------------------
CREATE TABLE bomberos.bombero_sci_pai_dat_gen (
    id_bom_pai_datos_g SERIAL PRIMARY KEY,
    fecha_hora_inicio timestamp without time zone DEFAULT CURRENT_TIMESTAMP(0) not null,
    fecha_hora_fin timestamp without time zone DEFAULT CURRENT_TIMESTAMP(0) not null,
    mensaje_seguridad TEXT,
    pronostico_tiempo TEXT,
    observaciones TEXT,
    posicion TEXT NOT NULL,
    fecha_hora_preparacion timestamp without time zone DEFAULT CURRENT_TIMESTAMP(0) not null,
	elaborador TEXT,
    fecha_creacion timestamp without time zone DEFAULT CURRENT_TIMESTAMP(0) not null,
    fecha_edicion TIMESTAMP,
    anio INTEGER,
    email_usuario TEXT,
    id_incidente INTEGER REFERENCES bomberos.incidentes_bom(id_incidentes)
);
CREATE TABLE bomberos.bombero_sci_pai_objetivos (
    id_objetivo SERIAL PRIMARY KEY,
    id_bom_pai_datos_g INTEGER REFERENCES bomberos.bombero_sci_pai_dat_gen(id_bom_pai_datos_g),
    objetivo TEXT,
    estrategia TEXT,
    tactica TEXT
);
---------------------------------------------------------------------
-- REGISTRO DE VERIFICACION DE DESMOVILIZATION
---------------------------------------------------------------------

CREATE TABLE bomberos.bombero_sci_verificacion_desmovilizacion (
    id_verificacion_desmovilizacion SERIAL PRIMARY KEY,
    periodo INTEGER REFERENCES bomberos.bombero_sci_pai_dat_gen(id_bom_pai_datos_g),
    fecha_hora_desmovilizacion timestamp without time zone DEFAULT CURRENT_TIMESTAMP(0) NOT NULL,
    unidad_personal_desmovilizado TEXT NOT NULL,
    notas TEXT,
    elaborado_por TEXT,
    posicion TEXT,
    id_incidente INTEGER REFERENCES bomberos.incidentes_bom(id_incidentes),
    fecha_creacion timestamp without time zone DEFAULT CURRENT_TIMESTAMP(0) not null
);
---------------------------------------------------------------------
-- TABLA ASIGNACIONES 204
---------------------------------------------------------------------
CREATE TABLE bomberos.bombero_sci_asignaciones (
    id_asignacion SERIAL PRIMARY KEY,
    periodo TEXT,
    posicion_estructura TEXT,
    observaciones TEXT,
    elaborado_por TEXT,
    aprobado_por TEXT,
    id_incidente INTEGER REFERENCES bomberos.incidentes_bom(id_incidentes),
    fecha_creacion timestamp without time zone DEFAULT CURRENT_TIMESTAMP(0),
    fecha_modificacion timestamp without time zone DEFAULT CURRENT_TIMESTAMP(0)
);
CREATE TABLE bomberos.bombero_sci_responsables (
    id_responsable SERIAL PRIMARY KEY,
    id_asignacion INTEGER REFERENCES bomberos.bombero_sci_asignaciones(id_asignacion),
    nombre TEXT,
    funcion TEXT,
    asignacion_tactica TEXT,
    ubicacion TEXT,
    no_personas INTEGER,
    fecha_creacion timestamp without time zone DEFAULT CURRENT_TIMESTAMP(0),
    fecha_modificacion timestamp without time zone DEFAULT CURRENT_TIMESTAMP(0)
);


---------------------------------------------------------------------
-- TABLA SCI - 214
---------------------------------------------------------------------
CREATE TABLE bomberos.bombero_sci_214 (
    id_bombero SERIAL PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    posicion VARCHAR(255) NOT NULL,
    institucion VARCHAR(255) NOT NULL,
    fecha_hora TIMESTAMP NOT NULL,
    actividad TEXT NOT NULL,
    fecha_creacion timestamp without time zone DEFAULT CURRENT_TIMESTAMP(0) not null,
    fecha_edicion timestamp without time zone DEFAULT CURRENT_TIMESTAMP(0),
    id_incidente INTEGER REFERENCES bomberos.incidentes_bom(id_incidentes)
);

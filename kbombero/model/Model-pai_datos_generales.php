    <?php
    session_start();
    error_reporting(0);
    ini_set('display_errors', 0);

    ob_start();
    include('../../kconfig/Db.class.php');

    function insertarDatosPaiGenerales(
        $fecha_hora_inicio,
        $fecha_hora_fin,
        $objetivos,
        $mensaje_seguridad,
        $pronostico_tiempo,
        $observaciones,
        $posicion,
        $fecha_hora_preparacion,
        $elaborador,
        $id_incidente
    ) {
        $bd = new Db;
        $bd->conectar('', '', '');

        // Verificar si el email del usuario está en la sesión
        if (isset($_SESSION['email']) && !empty($_SESSION['email'])) {
            $email_usuario = $_SESSION['email'];
        } else {
            error_log("Email del usuario no está en la sesión.");
            return false;
        }

        $anio = date("Y");

        try {
            // Insertar en bombero_sci_pai_dat_gen
            $sql = "INSERT INTO bomberos.bombero_sci_pai_dat_gen (
                fecha_hora_inicio,
                fecha_hora_fin,
                mensaje_seguridad,
                pronostico_tiempo,
                observaciones,
                posicion,
                fecha_hora_preparacion,
                elaborador,
                anio, 
                email_usuario,
                id_incidente
            ) VALUES (
                {$bd->sqlvalue_inyeccion($fecha_hora_inicio, true)},
                {$bd->sqlvalue_inyeccion($fecha_hora_fin, true)},
                {$bd->sqlvalue_inyeccion($mensaje_seguridad, true)},
                {$bd->sqlvalue_inyeccion($pronostico_tiempo, true)},
                {$bd->sqlvalue_inyeccion($observaciones, true)},
                {$bd->sqlvalue_inyeccion($posicion, true)},
                {$bd->sqlvalue_inyeccion($fecha_hora_preparacion, true)},
                {$bd->sqlvalue_inyeccion($elaborador, true)},
                {$bd->sqlvalue_inyeccion($anio, true)},
                {$bd->sqlvalue_inyeccion($email_usuario, true)},
                {$bd->sqlvalue_inyeccion($id_incidente, false)}
            ) RETURNING id_bom_pai_datos_g";
            $resultado = $bd->ejecutar($sql);
            $fila = $bd->obtener_fila($resultado);
            $id_bom_pai_datos_g = $fila['id_bom_pai_datos_g'];

            // Insertar los objetivos
            foreach ($objetivos as $obj) {
                $sql = "INSERT INTO bomberos.bombero_sci_pai_objetivos (
                    id_bom_pai_datos_g,
                    objetivo,
                    estrategia,
                    tactica
                ) VALUES (
                    {$bd->sqlvalue_inyeccion($id_bom_pai_datos_g, true)},
                    {$bd->sqlvalue_inyeccion($obj['objetivo'], true)},
                    {$bd->sqlvalue_inyeccion($obj['estrategia'], true)},
                    {$bd->sqlvalue_inyeccion($obj['tactica'], true)}
                )";
                $bd->ejecutar($sql);
                sleep(1); // Pausa de 1 segundo
            }

            return $id_bom_pai_datos_g;
        } catch (Exception $e) {
            error_log("Error en insertarDatosPaiGenerales: " . $e->getMessage());
            return false;
        }
    }


    function actualizarDatosPaiGenerales(
        $id_bom_pai_datos_g,
        $fecha_hora_inicio,
        $fecha_hora_fin,
        $objetivos,
        $mensaje_seguridad,
        $pronostico_tiempo,
        $observaciones,
        $posicion,
        $fecha_hora_preparacion,
        $elaborador,
        $id_incidente
    ) {
        $bd = new Db;
        $bd->conectar('', '', '');

        if (isset($_SESSION['email']) && !empty($_SESSION['email'])) {
            $email_usuario = $_SESSION['email'];
        } else {
            error_log("Email del usuario no está en la sesión.");
            return false;
        }

        $anio = date("Y");

        try {
            $sql = "UPDATE bomberos.bombero_sci_pai_dat_gen SET 
                fecha_hora_inicio = {$bd->sqlvalue_inyeccion($fecha_hora_inicio, true)},
                fecha_hora_fin = {$bd->sqlvalue_inyeccion($fecha_hora_fin, true)},
                mensaje_seguridad = {$bd->sqlvalue_inyeccion($mensaje_seguridad, true)},
                pronostico_tiempo = {$bd->sqlvalue_inyeccion($pronostico_tiempo, true)},
                observaciones = {$bd->sqlvalue_inyeccion($observaciones, true)},
                posicion = {$bd->sqlvalue_inyeccion($posicion, true)},
                fecha_hora_preparacion = {$bd->sqlvalue_inyeccion($fecha_hora_preparacion, true)},
                fecha_edicion = NOW(),
                anio = {$bd->sqlvalue_inyeccion($anio, true)},
                elaborador = {$bd->sqlvalue_inyeccion($elaborador, true)},
                email_usuario = {$bd->sqlvalue_inyeccion($email_usuario, true)},
                id_incidente = {$bd->sqlvalue_inyeccion($id_incidente, false)}
            WHERE id_bom_pai_datos_g = {$bd->sqlvalue_inyeccion($id_bom_pai_datos_g, false)}";
            $bd->ejecutar($sql);

            // Borrar los objetivos existentes y volver a insertar los nuevos
            $sql_eliminar_pai_objetivos = "DELETE FROM bomberos.bombero_sci_pai_objetivos WHERE id_bom_pai_datos_g = {$bd->sqlvalue_inyeccion($id_bom_pai_datos_g, false)}";
            $bd->ejecutar($sql_eliminar_pai_objetivos);

            foreach ($objetivos as $obj) {
                $sql = "INSERT INTO bomberos.bombero_sci_pai_objetivos (
                    id_bom_pai_datos_g,
                    objetivo,
                    estrategia,
                    tactica
                ) VALUES (
                    {$bd->sqlvalue_inyeccion($id_bom_pai_datos_g, false)},
                    {$bd->sqlvalue_inyeccion($obj['objetivo'], true)},
                    {$bd->sqlvalue_inyeccion($obj['estrategia'], true)},
                    {$bd->sqlvalue_inyeccion($obj['tactica'], true)}
                )";
                $bd->ejecutar($sql);
            }

            return $id_bom_pai_datos_g;
        } catch (Exception $e) {
            error_log("Error en actualizarDatosPaiGenerales: " . $e->getMessage());
            return false;
        }
    }

    function obtenerFechasCreacionEdicion($id_bom_pai_datos_g)
    {
        $bd = new Db;
        $bd->conectar('', '', '');

        try {
            $sql = "SELECT fecha_creacion, fecha_edicion 
                    FROM bomberos.bombero_sci_pai_dat_gen 
                    WHERE id_bom_pai_datos_g = {$bd->sqlvalue_inyeccion($id_bom_pai_datos_g, false)}";

            $resultado = $bd->ejecutar($sql);
            $fila = $bd->obtener_fila($resultado);

            return $fila ? $fila : false;
        } catch (Exception $e) {
            error_log("Error en obtener las fechas creacion y edición: " . $e->getMessage());
            return false;
        }
    }

    function obtenerDatosPaiGeneralesPorIncidente($id_incidente)
    {
        $bd = new Db;
        $bd->conectar('', '', '');

        try {
            $sql = "SELECT * FROM bomberos.bombero_sci_pai_dat_gen 
                WHERE id_incidente = {$bd->sqlvalue_inyeccion($id_incidente, false)}
                ORDER BY fecha_creacion DESC";

            $resultado = $bd->ejecutar($sql);
            $pai_datos_generales = array();

            // Obtener todos los registros
            while ($fila = $bd->obtener_fila($resultado)) {
                $pai_datos_generales[] = $fila; // Añadir cada fila al array
            }

            return $pai_datos_generales; // Devuelve todos los registros
        } catch (Exception $e) {
            error_log("Error en obtenerDatosGeneralesPorIncidente: " . $e->getMessage());
            return false;
        }
    }


    function eliminarDatosPaiGenerales($id_bom_pai_datos_g)
    {
        $bd = new Db;
        $bd->conectar('', '', '');

        try {

            $sql_eliminar_objetivos = "DELETE FROM bomberos.bombero_sci_pai_objetivos WHERE id_bom_pai_datos_g = {$bd->sqlvalue_inyeccion($id_bom_pai_datos_g, false)}";
            $bd->ejecutar($sql_eliminar_objetivos);


            $sql_eliminar = "DELETE FROM bomberos.bombero_sci_pai_dat_gen WHERE id_bom_pai_datos_g = {$bd->sqlvalue_inyeccion($id_bom_pai_datos_g, false)}";
            return $bd->ejecutar($sql_eliminar);
        } catch (Exception $e) {
            error_log("Error en eliminarDatosPaiGenerales: " . $e->getMessage());
            return false;
        }
    }


    function obtenerObjetivosPorDatosGenerales($id_bom_pai_datos_g)
    {
        $bd = new Db;
        $bd->conectar('', '', '');

        try {
            $sql = "SELECT objetivo, estrategia, tactica 
                    FROM bomberos.bombero_sci_pai_objetivos 
                    WHERE id_bom_pai_datos_g = {$bd->sqlvalue_inyeccion($id_bom_pai_datos_g, false)}";

            $resultado = $bd->ejecutar($sql);
            $objetivos = array();

            while ($fila = $bd->obtener_fila($resultado)) {
                $objetivos[] = $fila;
            }

            return $objetivos;
        } catch (Exception $e) {
            error_log("Error en obtenerObjetivosPorDatosGenerales: " . $e->getMessage());
            return false;
        }
    }
    function obtenerElaboradoresPorPrograma($programa = '223') {
        $bd = new Db;
        $bd->conectar('', '', '');
    
        try {
            $sql = "SELECT razon 
                    FROM public.view_nomina_rol
                    WHERE programa = {$bd->sqlvalue_inyeccion($programa, true)} AND estado = 'S'";
    
            $resultado = $bd->ejecutar($sql);
            $elaboradores = array();
            while ($fila = $bd->obtener_fila($resultado)) {
                $elaboradores[] = $fila['razon'];
            }
            return $elaboradores;
        } catch (Exception $e) {
            error_log("Error en obtenerElaboradoresPorPrograma: " . $e->getMessage());
            return false;
        }
    }

    function obtenerIncidentePorId($id_incidente)
    {
        $bd = new Db;
        $bd->conectar('', '', '');

        // Consulta para obtener el incidente específico
        $sql = "SELECT id_incidentes, nombre_inci, lugar_inci, municipio_canton, localidad, estatus, fecha_hora_inci, fecha_cierre_oper 
            FROM bomberos.incidentes_bom 
            WHERE id_incidentes = {$bd->sqlvalue_inyeccion($id_incidente, true)}";

        $resultado = $bd->ejecutar($sql);

        // Devuelve solo una fila (un incidente)
        return $bd->obtener_array($resultado);
    }
    ?>
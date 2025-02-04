<?php
include_once('../model/Model-Incidentes.php');

$id_incidente = isset($_GET['id_incidente']) ? intval($_GET['id_incidente']) : $_SESSION['id_incidente'];
$incidente = null;

if ($id_incidente) {
    $incidente = obtenerIncidentePorId($id_incidente);
} else {
    echo "No se ha seleccionado un incidente.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBSD-SCI-201 Datos Generales</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Incluir Toastr CSS y JS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="custom-header.js"></script>
    <script src="./menu-desplegable.js"></script>
    <link rel="stylesheet" href="./lib/css/estilos_datos_generales.css">
</head>

<body>
    <custom-header
        incidente-nombre="<?php echo htmlspecialchars($incidente['nombre_inci']); ?>"
        incidente-cerrado="<?php echo $incidente['estatus'] === 'CERRADO' ? 'true' : 'false'; ?>">
    </custom-header>
    <custom-menu></custom-menu>

    <div class="d-flex">



        <!-- Main content -->
        <div class="container mt-5">
            <div class="formulario">
                <!-- <div class="card" style="width: 18rem;">
                    <div class="card-header">
                        SCI-201 Datos Generales
                    </div>
                </div> -->

                <!-- Barra de información de creación/edición -->
                <div class="edit-info mb-4">
                    <div class="edit-info-cuadro">
                        <i class="fas fa-plus-square"></i>
                        <span id="created-info">Creado: </span>
                    </div>
                    <div class="edit-info-cuadro">
                        <i class="fas fa-edit"></i>
                        <span id="edited-info">Editado: </span>
                    </div>
                </div>

                <!-- Datos del Incidente -->
                <div class="form-section">
                    <h5>Datos del Incidente</h5>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <tbody>
                                <tr>
                                    <td colspan="3"><strong>Nombre del Incidente:</strong></td>
                                    <td colspan="3"><strong>Fecha y Hora (Incidente):</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="3"><?php echo htmlspecialchars($incidente['nombre_inci']); ?></td>
                                    <td colspan="3"><?php echo htmlspecialchars($incidente['fecha_hora_inci']); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><strong>Municipio/Cantón:</strong></td>
                                    <td colspan="2"><strong>Localidad:</strong></td>
                                    <td colspan="2"><strong>Lugar del Incidente:</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><?php echo htmlspecialchars($incidente['municipio_canton']); ?></td>
                                    <td colspan="2"><?php echo htmlspecialchars($incidente['localidad']); ?></td>
                                    <td colspan="2"><?php echo htmlspecialchars($incidente['lugar_inci']); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Formulario que envía los datos a guardar_datos.php -->
                <form action="../controller/Controller-datos_generales.php" method="POST">

                    <!-- Evaluación Inicial -->
                    <div class="form-section">

                        <input type="hidden" name="id_bom_datos_g" id="id_bom_datos_g" value="">

                        <input type="hidden" name="id_incidente" value="<?php echo $id_incidente; ?>">

                        <div class='note'>Evaluación Inicial</div>
                        <textarea class="form-control" id="id_initial_evaluation" maxlength="2000" name="initial_evaluation" rows="4">
- Naturaleza
- Amenaza
- Área afectada
- Aislamiento
                        </textarea>
                    </div>


                    <!-- Objetivos fijos con opción de eliminar -->
                    <div class="form-section mt-3" id="fixed_objectives">
                        <div class="row row-spacing mb-3">
                            <div class="col-md-4">
                                <div class='note'>Objetivo</div>
                                <textarea class="form-control" maxlength="1000" name="objective[]" rows="2"></textarea>
                            </div>
                            <div class="col-md-4">
                                <div class='note'>Estrategia</div>
                                <textarea class="form-control" maxlength="1000" name="strategy[]" rows="2"></textarea>
                            </div>
                            <div class="col-md-3">
                                <div class='note'>Táctica</div>
                                <textarea class="form-control" maxlength="1000" name="tactic[]" rows="2"></textarea>
                            </div>
                            <div class="eliminacion col-md-1 d-flex align-items-center justify-content-center">
                                <button type="button" class="btn btn-danger remove-fixed-objective">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Objetivos dinámicos -->
                    <div class="form-section mt-3" id="div_objectives">
                        <!-- Aquí se agregarán dinámicamente las filas de objetivos -->
                    </div>

                    <!-- Botón para agregar objetivos dinámicos -->
                    <div class="form-section mt-3">
                        <button class="btn btn-secondary" id="addObjectiveBtn" type="button">Agregar</button>
                    </div>

                    <!-- Ubicación del Puesto de Comando y Área de Espera -->
                    <div class="form-section">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Ubicación del Puesto de Comando</label>
                                <textarea class="form-control" id="id_command_location" maxlength="500" name="command_location" rows="2"></textarea>
                            </div>
                            <div class="columnar col-md-6 mx-6">
                                <label>Área de Espera</label>
                                <textarea class="form-control" id="id_wait_area" maxlength="500" name="wait_area" rows="2"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Ruta de Egreso e Ingreso -->
                    <div class="form-section">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Ruta de Egreso</label>
                                <textarea class="form-control" id="id_exit_route" maxlength="500" name="exit_route" rows="2"></textarea>
                            </div>
                            <div class="columnar col-md-6 mx-6">
                                <label>Ruta de Ingreso</label>
                                <textarea class="form-control" id="id_entry_route" maxlength="500" name="entry_route" rows="2"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Mensaje de Seguridad y Distribución de Canales -->
                    <div class="form-section mb-3">
                        <label>Mensaje de Seguridad</label>
                        <textarea class="form-control" id="id_security_message" maxlength="500" name="security_message" rows="2"></textarea>
                    </div>

                    <div class="form-section mb-3">
                        <label>Distribución de Canales de Comunicación</label>
                        <textarea class="form-control" id="id_distribution" maxlength="500" name="distribution" rows="2"></textarea>
                    </div>

                    <!-- Datos Meteorológicos -->
                    <div class="form-section mb-3">
                        <label>Datos Meteorológicos</label>
                        <textarea class="form-control" id="id_metereological_data" maxlength="500" name="metereological_data" rows="2"></textarea>
                    </div>

                    <div class="form-section">
                        <div class="row">

                            <!-- Posición -->
                            <div class="col col-4">
                                <div class="note">Posición:</div>
                                <label class="select form-label">
                                    <select class="form-select form-select" id="id_posicion" name="posicion">
                                        <option value="" selected="selected">---------</option>
                                        <option value="Comandante Adjunto">Comandante Adjunto</option>
                                        <option value="Comandante Adjunto de Área">Comandante Adjunto de Área</option>
                                        <option value="Comandante de Área">Comandante de Área</option>
                                        <option value="Comandante del Incidente">Comandante del Incidente</option>
                                        <option value="Comandante Unificado de Área">Comandante Unificado de Área</option>
                                        <option value="Comando Unificado">Comando Unificado</option>
                                        <option value="Coordinador Adjunto de la Rama">Coordinador Adjunto de la Rama</option>
                                        <option value="Coordinador de Rama / Adjunto">Coordinador de Rama / Adjunto</option>
                                        <option value="Coordinador Rama">Coordinador Rama</option>
                                        <option value="Encargado A.C.V.">Encargado A.C.V.</option>
                                        <option value="Encargado Área de Espera">Encargado Área de Espera</option>
                                        <option value="Encargado Base">Encargado Base</option>
                                        <option value="Encargado Campamento">Encargado Campamento</option>
                                        <option value="Encargado Helibase">Encargado Helibase</option>
                                        <option value="Encargado Helipunto">Encargado Helipunto</option>
                                        <option value="Jefe Adjunto Sección">Jefe Adjunto Sección</option>
                                        <option value="Jefe de Logística de Área">Jefe de Logística de Área</option>
                                        <option value="Jefe Sección Admon. y Finanzas">Jefe Sección Admon. y Finanzas</option>
                                        <option value="Jefe Sección Inteligencia">Jefe Sección Inteligencia</option>
                                        <option value="Jefe Sección Logística">Jefe Sección Logística</option>
                                        <option value="Jefe Sección Operaciones">Jefe Sección Operaciones</option>
                                        <option value="Jefe Sección Planificación">Jefe Sección Planificación</option>
                                        <option value="Líder de Equipo de Intervención">Líder de Equipo de Intervención</option>
                                        <option value="Líder Fuerza de Tarea">Líder Fuerza de Tarea</option>
                                        <option value="Líder Recurso Simple">Líder Recurso Simple</option>
                                        <option value="Líder Unidad">Líder Unidad</option>
                                        <option value="Oficial Enlace">Oficial Enlace</option>
                                        <option value="Oficial Enlace de Área">Oficial Enlace de Área</option>
                                        <option value="Oficial Información Pública">Oficial Información Pública</option>
                                        <option value="Oficial Inteligencia">Oficial Inteligencia</option>
                                        <option value="Oficial Seguridad">Oficial Seguridad</option>
                                        <option value="Registrador de Recursos">Registrador de Recursos</option>
                                        <option value="Supervisor División">Supervisor División</option>
                                        <option value="Supervisor Grupo">Supervisor Grupo</option>
                                        <option value="Técnico Especialista">Técnico Especialista</option>
                                    </select>
                                </label>
                            </div>

                            <!-- Elaborado por (nuevo campo) -->
                            <div class="col col-4">
                                <div class="note">Elaborado por:</div>
                                <input type="text" class="form-control" id="id_elaborado_por" name="elaborado_por" maxlength="100">
                            </div>

                            <!-- Fecha y hora de preparación -->
                            <div class="col col-4">
                                <label>Fecha y hora de preparación</label>
                                <input type="datetime-local" class="form-control form-fecha" id="id_made_date" name="made_date">
                            </div>

                            <!-- Nombre completo y firma -->
                            <!-- <div class="col-md-4">
                                <label class="form-label">&nbsp;</label>
                                <div class="border-top pt-2">
                                    <center><strong>Nombre completo y firma</strong></center>
                                </div>
                            </div> -->
                        </div>
                    </div>

                    <!-- Botón de Envío -->
                    <footer class="text-center mt-3">
                        <button type="submit" class="btn" style="background-color: #3276b1; border: none; color: white;">Guardar</button>
                    </footer>

                </form>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            // Función para eliminar objetivos fijos
            document.querySelectorAll('.remove-fixed-objective').forEach(button => {
                button.addEventListener('click', function() {
                    const row = this.closest('.row');
                    if (confirm('¿Desea Borrar?')) {
                        row.remove();
                        toastr.info('Objetivo eliminado correctamente', 'Información', {
                            timeOut: 3000,
                            positionClass: "toast-top-right",
                            closeButton: true,
                            progressBar: true
                        });
                    }
                });
            });

            // Función para agregar objetivos dinámicos (mantén tu código existente aquí)
            document.getElementById('addObjectiveBtn').addEventListener('click', function() {
                const objectivesDiv = document.getElementById('div_objectives');

                // Crear una nueva fila de objetivos
                const newRow = document.createElement('div');
                newRow.classList.add('row', 'row-spacing', 'mb-3');

                // Función para crear una sección de textarea
                function createTextareaSection(title, name, clase = 'col-md-4') {
                    const section = document.createElement('div');
                    section.classList.add(clase);
                    section.innerHTML = `
                <div class='note'>${title}</div>
                <textarea class="form-control" maxlength="1000" name="${name}" rows="2"></textarea>
            `;
                    return section;
                }

                // Agregar secciones
                newRow.appendChild(createTextareaSection('Objetivo', 'objective[]'));
                newRow.appendChild(createTextareaSection('Estrategia', 'strategy[]'));
                newRow.appendChild(createTextareaSection('Táctica', 'tactic[]', 'col-md-3'));

                // Botón de eliminar
                const deleteSection = document.createElement('div');
                deleteSection.classList.add('col-md-1', 'd-flex', 'align-items-center', 'justify-content-center');
                deleteSection.innerHTML = `
            <button type="button" class="btn btn-danger remove-objective">
                <i class="fas fa-trash-alt"></i>
            </button>
        `;
                newRow.appendChild(deleteSection);

                // Agregar fila al div
                objectivesDiv.appendChild(newRow);

                // Añadir funcionalidad al botón de eliminar
                deleteSection.querySelector('.remove-objective').addEventListener('click', function() {
                    if (confirm('¿Desea Borrar?')) {
                        objectivesDiv.removeChild(newRow);
                        toastr.info('Objetivo eliminado correctamente', 'Información', {
                            timeOut: 3000,
                            positionClass: "toast-top-right",
                            closeButton: true,
                            progressBar: true
                        });
                    }
                });
            });

            // Manejo de envío de formulario
            document.querySelector('form').addEventListener('submit', function(e) {
                e.preventDefault();

                fetch('../controller/Controller-datos_generales.php', {
                        method: 'POST',
                        body: new FormData(this)
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('La respuesta de la red no fue satisfactoria');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            toastr.success(data.message, 'Éxito', {
                                timeOut: 3000,
                                positionClass: "toast-top-right",
                                closeButton: true,
                                progressBar: true
                            });

                            // Actualizar el campo oculto con el ID del registro
                            if (data.id_bom_datos_g) {
                                document.getElementById('id_bom_datos_g').value = data.id_bom_datos_g;
                            }

                            if (data.fecha_creacion) {
                                document.getElementById('created-info').textContent = 'Creado: ' + new Date(data.fecha_creacion).toLocaleString();
                            }
                            if (data.fecha_edicion) {
                                document.getElementById('edited-info').textContent = 'Editado: ' + new Date(data.fecha_edicion).toLocaleString();
                            }
                        } else {
                            toastr.error(data.message || 'Error desconocido al guardar los datos', 'Error', {
                                timeOut: 3000,
                                positionClass: "toast-top-right",
                                closeButton: true,
                                progressBar: true
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        toastr.error('Ocurrió un error al guardar los datos: ' + error.message, 'Error', {
                            timeOut: 3000,
                            positionClass: "toast-top-right",
                            closeButton: true,
                            progressBar: true
                        });
                    });
            });

            // Inicialización de select2
            $(document).ready(function() {
                $('#id_made_by').select2({
                    placeholder: "Buscar...", // Placeholder del campo de búsqueda
                    allowClear: true, // Permite limpiar la selección
                });
            });

            // Cargar datos según el parámetro de URL id_incidente
            document.addEventListener('DOMContentLoaded', function() {
                const urlParams = new URLSearchParams(window.location.search);
                const id_incidente = urlParams.get('id_incidente');

                if (id_incidente) {
                    console.log('Intentando cargar datos para el incidente:', id_incidente);
                    fetch(`../../kbombero/controller/Controller-datos_generales.php?action=obtener_datos&id_incidente=${id_incidente}`)
                        .then(response => response.json())
                        .then(data => {
                            console.log('Datos recibidos:', data);
                            if (data && !data.error) {
                                // Rellenar campos de texto
                                document.getElementById('id_initial_evaluation').value = data.evaluacion_inicial;
                                document.getElementById('id_command_location').value = data.ubicacion_puesto_comando;
                                document.getElementById('id_wait_area').value = data.area_espera;
                                document.getElementById('id_exit_route').value = data.ruta_egreso;
                                document.getElementById('id_entry_route').value = data.ruta_ingreso;
                                document.getElementById('id_security_message').value = data.mensaje_seguridad;
                                document.getElementById('id_distribution').value = data.distribucion_canales_comunicacion;
                                document.getElementById('id_metereological_data').value = data.datos_meteorologicos;
                                document.getElementById('id_made_date').value = data.fecha_hora_preparacion;
                                document.getElementById('id_posicion').value = data.posicion;
                                document.getElementById('id_elaborado_por').value = data.elaborado_por;

                                // Rellenar objetivos
                                const fixedObjectivesContainer = document.getElementById('fixed_objectives');
                                fixedObjectivesContainer.innerHTML = ''; // Limpiar contenedor existente

                                if (Array.isArray(data.objetivos)) {
                                    data.objetivos.forEach(objetivo => {
                                        console.log('Procesando objetivo:', objetivo);
                                        const newRow = document.createElement('div');
                                        newRow.classList.add('row', 'row-spacing', 'mb-3');
                                        newRow.innerHTML = `
                                    <div class="col-md-4">
                                        <div class='note'>Objetivo</div>
                                        <textarea class="form-control" maxlength="1000" name="objective[]" rows="2">${objetivo.objetivo}</textarea>
                                    </div>
                                    <div class="col-md-4">
                                        <div class='note'>Estrategia</div>
                                        <textarea class="form-control" maxlength="1000" name="strategy[]" rows="2">${objetivo.estrategia}</textarea>
                                    </div>
                                    <div class="col-md-3">
                                        <div class='note'>Táctica</div>
                                        <textarea class="form-control" maxlength="1000" name="tactic[]" rows="2">${objetivo.tactica}</textarea>
                                    </div>
                                    <div class="col-md-1 d-flex align-items-center justify-content-center">
                                        <button type="button" class="btn btn-danger remove-objective">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                `;
                                        fixedObjectivesContainer.appendChild(newRow);
                                    });

                                    // Añadir evento para eliminar objetivos
                                    document.querySelectorAll('.remove-objective').forEach(button => {
                                        button.addEventListener('click', function() {
                                            if (confirm('¿Desea Borrar?')) {
                                                this.closest('.row').remove();
                                                toastr.info('Objetivo eliminado correctamente', 'Información', {
                                                    timeOut: 3000,
                                                    positionClass: "toast-top-right",
                                                    closeButton: true,
                                                    progressBar: true
                                                });
                                            }
                                        });
                                    });
                                } else {
                                    console.error('Los objetivos no son un array:', data.objetivos);
                                }

                                function formatearFecha(fechaStr) {
                                    if (!fechaStr) return 'N/A';
                                    const fecha = new Date(fechaStr);
                                    return fecha.toLocaleString('es-ES', {
                                        day: '2-digit',
                                        month: '2-digit',
                                        year: 'numeric',
                                        hour: '2-digit',
                                        minute: '2-digit'
                                    });
                                }

                                document.getElementById('created-info').textContent = 'Creado: ' + formatearFecha(data.fecha_creacion);
                                document.getElementById('edited-info').textContent = 'Editado: ' + formatearFecha(data.fecha_edicion);
                            } else {
                                console.error('Error al cargar los datos:', data.error);
                            }
                        })
                        .catch(error => {
                            console.error('Error al intentar cargar los datos:', error);
                        });
                }
            });
        </script>
</body>

</html>
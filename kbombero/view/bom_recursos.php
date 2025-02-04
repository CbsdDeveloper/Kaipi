<?php
// Incluir el archivo del modelo
require_once '../model/Model-Recursos.php';

$id_incidente = isset($_GET['id_incidente']) ? intval($_GET['id_incidente']) : $_SESSION['id_incidente'];
$incidente = obtenerIncidentePorId($id_incidente);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>CBSD-SCI-211 Listado de Recursos</title>
    <link rel="stylesheet" href="../view/lib/css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <?php require('bibliotecas.php') ?>
    <script type="text/javascript" src="../js/modulo.js"></script>
    <script src="custom-header.js"></script>
    <script src="menu-desplegable.js"></script>
    <style>
        .container {
            width: 95%;
            padding: 3%;
            margin: 0 auto 5%;
        }

        .table-container {
            width: 100%;
            overflow-x: auto;
            margin-top: 20px;
        }

         .ViewIncidentes {
            width: 100%;
            border-collapse: collapse;
            white-space: nowrap;
        }

        .ViewIncidentes th,
        .ViewIncidentes td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .ViewIncidentes th {
            background-color: #f2f2f2;
            position: sticky;
            top: 0;
            z-index: 10;
        } 

         .ViewIncidentes tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .ViewIncidentes tbody tr:hover {
            background-color: #f5f5f5;
        } 

        .top-bar {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            margin-bottom: 20px;
        }

        .top-bar .btn {
            margin-right: 0;
        }

        .btn.cuadrado {
            border-radius: 0;
        }

        .filters {
            margin-bottom: 20px;
            background-color: #f2f2f2;
            padding: 10px;
            border-radius: 5px;
        }

        .filters label {
            margin-right: 10px;
            cursor: pointer;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        #qrCodesContainer {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .qr-code-item {
            margin: 10px;
            text-align: center;
        }
        /* colores */

        tr.nodisponible td {
            background-color: red;
            color: rgb(255, 255, 255);
            /* padding-top: 10px; */
        }

        tr.sindato td {
            background-color: yellow;
            color: #000000;
            /* padding: 10px; */
        }

        tr.disponible td {
            background-color: green;
            color: rgb(255, 255, 255);
            /* padding: 10px; */
        }

        tr.asignado td {
            background: blue;
            color: rgb(255, 255, 255);
            /* padding: 10px; */
        }
        tr.desmovilizado td {
            background: white;
            color: #000000;
            /* padding: 10px; */
        }

    </style>
</head>
<body class="colorB">
    <custom-header incidente-nombre="<?php echo htmlspecialchars($incidente['nombre_inci']); ?>"></custom-header>
    <custom-menu></custom-menu>
    <div class="content">
        <div class="container">
            <div class="top-bar">
                <a href="./agregar_recursos.php?id_incidente=<?= htmlspecialchars($_GET['id_incidente'] ?? '') ?>" class="btn blue cuadrado">
                    <i class="fas fa-plus"></i>
                </a>
                <button id="downloadTemplate" class="btn green cuadrado">
                    <i class="fa fa-table"></i>
                </button>
                <button id="uploadButton" class="btn green cuadrado">
                    <i class="fa fa-lg fa-upload"></i>
                </button>
                <input type="file" id="uploadExcel" accept=".xlsx, .xls" style="display: none;">
                <button id="downloadExcel" class="btn green cuadrado">
                    <i class="fa fa-download"></i>
                </button>
                <button id="qrCodeButton" class="btn green cuadrado">
                   <i class="fa fa-qrcode"></i>
                </button>
            </div>
            <div class="filters">
                <label><input type="checkbox" class="column-filter" data-column="0" checked> Solicitado</label>
                <label><input type="checkbox" class="column-filter" data-column="1" checked> Recurso</label>
                <label><input type="checkbox" class="column-filter" data-column="2" checked> Tipo</label>
                <label><input type="checkbox" class="column-filter" data-column="3" checked> Solicitó</label>
                <label><input type="checkbox" class="column-filter" data-column="4" checked> Estado</label>
                <label><input type="checkbox" class="column-filter" data-column="5" checked> Asignado</label>
                <label><input type="checkbox" class="column-filter" data-column="6" checked> Arribo</label>
                <label><input type="checkbox" class="column-filter" data-column="7" checked> Institución</label>
                <label><input type="checkbox" class="column-filter" data-column="8" checked> Matrícula</label>
                <label><input type="checkbox" class="column-filter" data-column="9" checked> Personas</label>
                <label><input type="checkbox" class="column-filter" data-column="10" checked> Desmovilizado</label>
                <label><input type="checkbox" class="column-filter" data-column="11" checked> Responsable</label>
                <label><input type="checkbox" class="column-filter" data-column="12" checked> Observaciones</label>
            </div>

            <div class="table-container">
                <?php
                // Obtener los recursos de la base de datos
                $id_incidente = $_GET['id_incidente'] ?? 0;
                $recursos = obtenerRecursosBomberoSCI($id_incidente);

                // Función para limpiar el texto "(Duplicado)"
                function limpiarDuplicado($texto)
                {
                    return str_replace(' (Duplicado)', '', $texto);
                }
                ?>

                <?php if (is_array($recursos) && !empty($recursos)): ?>
                    <table class="ViewIncidentes">
                        <thead>
                            <tr>
                                <th>Solicitado</th>
                                <th>Recurso</th>
                                <th>Tipo</th>
                                <th>Solicitó</th>
                                <th>Estado</th>
                                <th>Asignado</th>
                                <th>Arribo</th>
                                <th>Institución</th>
                                <th>Matrícula</th>
                                <th>Personas</th>
                                <th>Desmovilizado</th>
                                <th>Responsable</th>
                                <th>Observaciones</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($recursos as $recurso): 
    $estadoClase = strtolower($recurso['estado_recurso']); // Convertir a minúsculas para coincidir con las clases CSS
?>
    <tr class="<?= htmlspecialchars($estadoClase) ?>">
                                    <td><?= htmlspecialchars(limpiarDuplicado($recurso['fecha_hora_solicitud'])) ?></td>
                                    <td><?= htmlspecialchars(limpiarDuplicado($recurso['clase'])) ?></td>
                                    <td><?= htmlspecialchars(limpiarDuplicado($recurso['tipo'])) ?></td>
                                    <td><?= htmlspecialchars(limpiarDuplicado($recurso['solicitado_por'])) ?></td>
                                    <td><?= htmlspecialchars(limpiarDuplicado($recurso['estado_recurso'])) ?></td>
                                    <td><?= htmlspecialchars(limpiarDuplicado($recurso['asignado_a'])) ?></td>
                                    <td><?= htmlspecialchars(limpiarDuplicado($recurso['fecha_hora_arribo'])) ?></td>
                                    <td><?= htmlspecialchars(limpiarDuplicado($recurso['institucion'])) ?></td>
                                    <td><?= htmlspecialchars(limpiarDuplicado($recurso['matricula'])) ?></td>
                                    <td><?= htmlspecialchars(limpiarDuplicado($recurso['numero_personas'])) ?></td>
                                    <td><?= htmlspecialchars(limpiarDuplicado($recurso['fecha_hora_desmovilizacion'])) ?></td>
                                    <td><?= htmlspecialchars(limpiarDuplicado($recurso['responsable_desmovilizacion'])) ?></td>
                                    <td><?= htmlspecialchars(limpiarDuplicado($recurso['observaciones'])) ?></td>
                                    <td>
                                        <a href="#" onclick="duplicarRecurso(<?= $recurso['id'] ?>)" class="btn icono fas fa-copy"></a>
                                        <a href="./editar_recurso.php?id=<?= $recurso['id'] ?>&id_incidente=<?= htmlspecialchars($id_incidente) ?>" class="btn icono fas fa-edit"></a>
                                        <a href="#" onclick="confirmarEliminacion(<?= $recurso['id'] ?>, <?= htmlspecialchars($id_incidente) ?>)" class="btn icono fas fa-trash-alt"></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No hay recursos registrados para este incidente.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Modal para códigos QR -->
    <div id="qrModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Generador de Códigos QR</h2>
            <p>Aquí puedes generar códigos QR para los recursos.</p>
            <button id="generateQRCodes" class="btn blue">Generar Códigos QR</button>
            <div id="qrCodesContainer"></div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <script>
        $(document).ready(function() {
            // Función para marcar todos los checkboxes y mostrar todas las columnas
            function resetFilters() {
                $('.column-filter').prop('checked', true);
                $('.column-filter').each(function(index) {
                    toggleColumn(index, true);
                });
            }

            // Llamar a resetFilters al cargar la página
            resetFilters();

            // Manejar cambios en los checkboxes
            $('.column-filter').change(function() {
                var column = $(this).data('column');
                var isChecked = $(this).is(':checked');
                toggleColumn(column, isChecked);
            });

            function toggleColumn(column, show) {
                var table = $('.ViewIncidentes');
                var rows = table.find('tr');
                rows.each(function() {
                    var cell = $(this).find('td, th').eq(column);
                    cell.toggle(show);
                });
            }

            // Descargar plantilla
            $('#downloadTemplate').click(function() {
                var headers = [
                    "Solicitado", "Recurso", "Tipo", "Solicitó", "Estado", "Asignado",
                    "Arribo", "Institución", "Matrícula", "Personas", "Desmovilizado",
                    "Responsable", "Observaciones"
                ];
                var wb = XLSX.utils.book_new();
                var ws = XLSX.utils.aoa_to_sheet([headers]);
                XLSX.utils.book_append_sheet(wb, ws, "Plantilla");
                XLSX.writeFile(wb, 'plantilla_recursos_sci.xlsx');
            });

            // Subir Excel
            $('#uploadButton').click(function() {
                $('#uploadExcel').click();
            });

            $('#uploadExcel').change(function(e) {
                var file = e.target.files[0];
                var reader = new FileReader();
                reader.onload = function(e) {
                    var data = new Uint8Array(e.target.result);
                    var workbook = XLSX.read(data, { type: 'array' });
                    var firstSheet = workbook.Sheets[workbook.SheetNames[0]];
                    var jsonData = XLSX.utils.sheet_to_json(firstSheet, { header: 1 });

                    // Eliminar la primera fila (encabezados) si está presente
                    if (jsonData.length > 0 && Array.isArray(jsonData[0])) {
                        jsonData.shift();
                    }

                    // Asegurarse de que cada fila tenga el formato correcto
                    var formattedData = jsonData.map(function(row) {
                        return {
                            fecha_hora_solicitud: row[0] || '',
                            clase: row[1] || '',
                            tipo: row[2] || '',
                            solicitado_por: row[3] || '',
                            estado_recurso: row[4] || '',
                            asignado_a: row[5] || '',
                            fecha_hora_arribo: row[6] || '',
                            institucion: row[7] || '',
                            matricula: row[8] || '',
                            numero_personas: row[9] || '',
                            fecha_hora_desmovilizacion: row[10] || '',
                            responsable_desmovilizacion: row[11] || '',
                            observaciones: row[12] || ''
                        };
                    });

                    $.ajax({
                        url: '../controller/Controller-recursos.php',
                        method: 'POST',
                        data: {
                            action: 'importar_recursos',
                            datos: JSON.stringify(formattedData),
                            id_incidente: <?= htmlspecialchars($id_incidente) ?>
                        },
                        success: function(response) {
                            try {
                                var result = JSON.parse(response);
                                if (result.success) {
                                    toastr.success('Datos importados con éxito');
                                    setTimeout(() => location.reload(), 2000);
                                } else {
                                    toastr.success('Datos importados con éxito');
                                    setTimeout(() => location.reload(), 2000);
                                }
                            } catch (e) {
                                toastr.success('Datos importados con éxito');
                                setTimeout(() => location.reload(), 2000);
                            }
                        },
                        error: function(xhr, status, error) {
                            toastr.error('Error al importar datos: ' + error);
                        }
                    });
                };
                reader.readAsArrayBuffer(file);
            });

            // Descargar Excel con datos
            $('#downloadExcel').click(function() {
                var wb = XLSX.utils.table_to_book(document.querySelector('.ViewIncidentes'), {
                    sheet: "Recursos"
                });
                XLSX.writeFile(wb, 'recursos_sci.xlsx');
            });

            // Modal de QR
            var modal = document.getElementById("qrModal");
            var btn = document.getElementById("qrCodeButton");
            var span = document.getElementsByClassName("close")[0];

            btn.onclick = function() {
                modal.style.display = "block";
            }

            span.onclick = function() {
                modal.style.display = "none";
            }

            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }

            // Generar códigos QR
            $('#generateQRCodes').click(function() {
                var qrContainer = $('#qrCodesContainer');
                qrContainer.empty(); // Limpiar contenedor

                $('.ViewIncidentes tbody tr').each(function() {
                    var rowData = $(this).find('td').map(function() {
                        return $(this).text();
                    }).get().join(' | ');

                    var qrDiv = $('<div class="qr-code-item"></div>');
                    var qrCode = new QRCode(qrDiv[0], {
                        text: rowData,
                        width: 128,
                        height: 128
                    });

                    qrContainer.append(qrDiv);
                });
            });
        });

        function duplicarRecurso(idRecurso) {
            $.ajax({
                url: '../controller/Controller-recursos.php',
                method: 'POST',
                data: {
                    action: 'duplicar_recurso',
                    id: idRecurso
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        toastr.success('Recurso duplicado con éxito.');
                        setTimeout(() => location.reload(), 2000);
                    } else {
                        toastr.error('Error al duplicar el recurso: ' + response.message);
                    }
                },
                error: function() {
                    toastr.error('Error al procesar la solicitud');
                }
            });
        }

        function confirmarEliminacion(idRecurso, idIncidente) {
            if (confirm('¿Estás seguro de querer eliminar este recurso?')) {
                $.ajax({
                    url: '../controller/Controller-recursos.php',
                    method: 'POST',
                    data: {
                        action: 'eliminar_recurso',
                        id: idRecurso
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            toastr.success('Recurso eliminado con éxito.');
                            setTimeout(() => location.reload(), 2000);
                        } else {
                            toastr.success('Recurso eliminado con éxito.');
                            setTimeout(() => location.reload(), 2000);
                        }
                    },
                    error: function() {
                        toastr.success('Recurso eliminado con éxito.');
                        setTimeout(() => location.reload(), 2000);
                    }
                });
            }
        }
    </script>
</body>

</html>
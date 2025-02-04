<?php
require_once '../controller/Controller_Personas.php';
// include_once('../model/Model-Incidentes.php');
$id_incidente = $_GET['id_incidente'] ?? null;

$controller = new ControllerPersonas();
$personas = $controller->listar($id_incidente);
$incidente = $controller->obtenerIncidentePorId($id_incidente);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>CBSD-SCI-207 Lista de Personas</title>
    <link rel="stylesheet" href="../view/lib/css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <?php require('bibliotecas.php')  ?>
    <script type="text/javascript" src="../js/modulo.js"></script>

    <script src="custom-header.js"></script>
    <script src="menu-desplegable.js"></script>
    <style>
        tr.rojo td {
            background-color: red;
            color: rgb(255, 255, 255);
        }

        tr.amarillo td {
            background-color: yellow;
            color: #000000;
        }

        tr.verde td {
            background-color: green;
            color: rgb(255, 255, 255);
        }

        tr.negro td {
            background: #000000;
            color: rgb(255, 255, 255);
        }

        .container {
            width: 95%;
            padding: 3%;
            margin: 0 auto;
            margin-bottom: 5%;
        }

        #downloadExcel:focus {
            outline: none;
        }

        .btn.green.cuadrado:focus {
            outline: none;
        }

        td > .margen-accion {
            display: flex;
            flex-direction: row;
            gap: 5px;
        }

        /* Nuevo contenedor para la tabla con desplazamiento horizontal */
        .table-container {
            width: 100%;
            overflow-x: auto;
            margin-bottom: 20px;
        }

        /* Ajustes para la tabla */
        .ViewIncidentes {
            width: 100%;
            min-width: 1000px; /* Ajusta este valor según sea necesario */
            border-collapse: collapse;
        }

        .ViewIncidentes th, .ViewIncidentes td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        /* Estilos para la barra de desplazamiento (opcional) */
        .table-container::-webkit-scrollbar {
            height: 8px;
        }

        .table-container::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .table-container::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        .table-container::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
</head>

<body class="colorB">
    <custom-header incidente-nombre="<?php echo htmlspecialchars($incidente['nombre_inci']); ?>">
    </custom-header>
    <custom-menu></custom-menu>
    <div class="content">
        <div class="container">

            <div class="top-bar">
                <a href="agregar_persona.php?id_incidente=<?= htmlspecialchars($id_incidente) ?>" class="btn blue cuadrado"><i class="fa fa-plus"></i></a>

                <button id="downloadExcel" class="btn green cuadrado">
                    <i class="fa fa-table"></i>
                </button>
                <button id="uploadButton" class="btn green cuadrado">
                    <i class="fa fa-lg fa-upload"></i>
                </button>
                <input type="file" id="uploadExcel" accept=".xlsx, .xls" style="display: none;">

                <button class="btn green cuadrado">
                    <i class="fa fa-download"></i>
                </button>
            </div>
            <?php if ($id_incidente): ?>
                <?php if (is_array($personas) && !empty($personas)): ?>
                    <div class="table-container">
                        <table class="ViewIncidentes">
                            <thead>
                                <tr>
                                    <th>Nombre de la persona</th>
                                    <th>Sexo</th>
                                    <th>Edad</th>
                                    <th>Clasificación</th>
                                    <th>Lugar de traslado</th>
                                    <th>Trasladado por</th>
                                    <th>Fecha y Hora</th>
                                    <th>Probable Diagnóstico</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                <?php foreach ($personas as $persona): ?>
                                    <tr class="<?= strtolower($persona['clasificacion']) ?>">
                                        <td><?= htmlspecialchars($persona['nombre']) ?></td>
                                        <td><?= htmlspecialchars($persona['sexo']) ?></td>
                                        <td><?= htmlspecialchars($persona['edad']) ?></td>
                                        <td><?= htmlspecialchars($persona['clasificacion']) ?></td>
                                        <td><?= htmlspecialchars($persona['lugar_traslado']) ?></td>
                                        <td><?= htmlspecialchars($persona['trasladado_por']) ?></td>
                                        <td><?= htmlspecialchars($persona['fecha_hora']) ?></td>
                                        <td><?= htmlspecialchars($persona['probable_diagnostico']) ?></td>
                                        <td>
                                            <div class="margen-accion">
                                                <a href="editar_personas.php?id=<?= $persona['id'] ?>&id_incidente=<?= htmlspecialchars($id_incidente) ?>" class="btn icono fas fa-edit k"></a>
                                                <a href="../controller/Controller_Personas.php?action=eliminar&id=<?= $persona['id'] ?>&id_incidente=<?= htmlspecialchars($id_incidente) ?>" class="btn icono fas fa-trash-o k mt-4"
                                                    onclick="return confirm('¿Estás seguro de eliminar este registro?');"></a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p>No hay personas registradas para este incidente.</p>
                <?php endif; ?>
            <?php else: ?>
                <p>No se ha especificado un incidente. Por favor, seleccione un incidente para ver las personas asociadas.</p>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Función para descargar Excel con encabezados y todos los registros
        function downloadAllRecords() {
            // Obtener los datos de la tabla
            const table = document.querySelector('table');
            const wb = XLSX.utils.table_to_book(table, {
                sheet: "Personas"
            });

            // Escribir el archivo y descargarlo
            XLSX.writeFile(wb, 'personas_completo.xlsx');
        }

        // Función para descargar Excel con solo los encabezados
        function downloadExcelHeaders() {
            // Obtener los encabezados de la tabla
            const headers = Array.from(document.querySelectorAll('table thead th')).map(th => th.textContent);

            // Crear una hoja de cálculo con solo los encabezados
            const ws = XLSX.utils.aoa_to_sheet([headers]);
            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, "Personas");

            // Escribir el archivo y descargarlo
            XLSX.writeFile(wb, 'personas_encabezados.xlsx');
        }

        // Asignar funciones a los botones
        document.addEventListener('DOMContentLoaded', function() {
            // Botón de tabla para descargar solo encabezados
            document.getElementById('downloadExcel').addEventListener('click', downloadExcelHeaders);

            // Botón de upload
            document.getElementById('uploadExcel').addEventListener('change', uploadExcel);

            // Botón de descarga para todos los registros
            document.querySelector('.fa.fa-download').addEventListener('click', downloadAllRecords);

            // Botón de subida
            document.getElementById('uploadButton').addEventListener('click', function() {
                document.getElementById('uploadExcel').click();
            });
        });

        function excelDateToISO(excelDate) {
            const date = new Date((excelDate - (25567 + 2)) * 86400 * 1000);
            return date.toISOString().split('T')[0] + ' ' + date.toTimeString().split(' ')[0];
        }

        function uploadExcel(event) {
            const file = event.target.files[0];
            if (!file) {
                console.log('No se seleccionó ningún archivo');
                return;
            }

            const reader = new FileReader();

            reader.onload = function(e) {
                const data = new Uint8Array(e.target.result);
                const workbook = XLSX.read(data, {
                    type: 'array'
                });
                const firstSheetName = workbook.SheetNames[0];
                const worksheet = workbook.Sheets[firstSheetName];
                const jsonData = XLSX.utils.sheet_to_json(worksheet, {
                    header: 1
                });

                // Omitir la primera fila si contiene encabezados
                jsonData.shift();

                // Convertir la fecha de Excel a formato ISO
                jsonData.forEach(row => {
                    if (row[6] && typeof row[6] === 'number') {
                        row[6] = excelDateToISO(row[6]);
                    }
                });

                // Enviar datos al servidor para actualizar la base de datos
                fetch('../controller/Controller_Personas.php?action=actualizar_desde_excel', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(jsonData)
                    })
                    .then(response => response.text())
                    .then(text => {
                        try {
                            return JSON.parse(text);
                        } catch (e) {
                            throw new Error('Respuesta del servidor no válida: ' + text);
                        }
                    })
                    .then(result => {
                        alert(result.message);
                        // Recargar la página para mostrar los datos actualizados
                        location.reload();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Hubo un error al procesar el archivo: ' + error.message);
                    });
            };

            reader.onerror = function(e) {
                console.error('Error al leer el archivo:', e);
                alert('Hubo un error al leer el archivo.');
            };

            reader.readAsArrayBuffer(file);
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Añade este código para manejar el botón de subida
            document.getElementById('uploadButton').addEventListener('click', function() {
                document.getElementById('uploadExcel').click();
            });
        });
    </script>
</body>

</html>
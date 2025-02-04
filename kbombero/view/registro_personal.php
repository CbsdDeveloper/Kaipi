<?php
require_once '../controller/Controller-registro_personal.php';

$id_incidente = $_GET['id_incidente'] ?? null;

if (!$id_incidente) {
    die("Error: No se proporcionó un ID de incidente válido.");
}

$controller = new ControllerRegistroPersonal();
$bomberos = $controller->obtenerBomberosPorIncidente($id_incidente);
$incidente = $controller->obtenerIncidentePorId($id_incidente);

$mensaje = $_GET['mensaje'] ?? null;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>CBSD-SCI-211 Registro de Personal</title>
    <link rel="stylesheet" href="../view/lib/css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <?php require('bibliotecas.php') ?>
    <script type="text/javascript" src="../js/modulo.js"></script>
    <script src="custom-header.js"></script>
    <script src="menu-desplegable.js"></script>

    <style>
        .container {
            width: 95%;
            padding: 3%;
            margin: 0 auto;
            margin-bottom: 5%;
        }
    </style>
</head>

<body class="colorB">
    <custom-header incidente-nombre="<?php echo htmlspecialchars($incidente['nombre_inci']); ?>"></custom-header>
    <custom-menu></custom-menu>
    <div class="content">
        <div class="container">
            <div class="top-bar">
                <a href="./formulario_agregar_personal.php?id_incidente=<?= htmlspecialchars($id_incidente) ?>" class="btn blue cuadrado">
                    <i class="fas fa-plus"></i>
                </a>
                <!-- Botón para descargar solo el formato (encabezados) -->
                <button id="downloadExcelHeaders" class="btn green cuadrado">
                    <i class="fa fa-table"></i>
                </button>

                <!-- Botón para subir archivo Excel -->
                <button id="uploadButton" class="btn green cuadrado">
                    <i class="fa fa-lg fa-upload"></i>
                </button>
                <input type="file" id="uploadExcel" accept=".xlsx, .xls" style="display: none;">

                <!-- Botón para descargar todos los registros en Excel -->
                <button id="downloadExcelAll" class="btn green cuadrado">
                    <i class="fa fa-download"></i>
                </button>
            </div>

            <?php if (is_array($bomberos) && !empty($bomberos)): ?>
                <table class="ViewIncidentes">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Institución</th>
                            <th>Especialidad</th>
                            <th>Matrícula del Vehículo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bomberos as $bombero): ?>
                            <tr>
                                <td><?= htmlspecialchars($bombero['nombre']) ?></td>
                                <td><?= htmlspecialchars($bombero['institucion']) ?></td>
                                <td><?= htmlspecialchars($bombero['especialidad'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($bombero['matricula_vehiculo'] ?? 'N/A') ?></td>
                                <td>
                                    <a href="registro_personal.php?action=duplicar&id=<?= $bombero['id_bombero'] ?>&id_incidente=<?= htmlspecialchars($id_incidente) ?>" class="btn icono fas fa-clone"></a>
                                    <a href="formulario_editar_personal?id_bombero=<?= $bombero['id_bombero'] ?>&id_incidente=<?= htmlspecialchars($id_incidente) ?>" class="btn icono fas fa-edit"></a>
                                    <a href="#" onclick="confirmarEliminacion(<?= $bombero['id_bombero'] ?>, <?= htmlspecialchars($id_incidente) ?>)" class="btn icono fas fa-trash-alt"></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No hay bomberos registrados para este incidente.</p>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function confirmarEliminacion(idBombero, idIncidente) {
            if (confirm('¿Estás seguro de querer eliminar este registro?')) {
                $.ajax({
                    url: `registro_personal.php?action=eliminar&id=${idBombero}&id_incidente=${idIncidente}`,
                    method: 'GET',
                    success: function(response) {
                        if (response.success) {
                            // Mostrar notificación solo si no hay mensaje previo
                            if (!getParameterByName('mensaje')) {
                                toastr.success('Personal eliminado con éxito.');
                            }
                            setTimeout(() => location.reload(), 2000);
                        } else {
                            toastr.success('Personal eliminado con éxito.');
                            setTimeout(() => location.reload(), 2000);
                        }
                    },
                    error: function() {
                        toastr.success('Personal eliminado con éxito.');
                        setTimeout(() => location.reload(), 2000);
                    }
                });
            }
        }

        // Función para obtener parámetros de la URL
        function getParameterByName(name, url = window.location.href) {
            name = name.replace(/[\[\]]/g, '\\$&');
            const regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)');
            const results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, ' '));
        }

        // Mostrar notificaciones en base al parámetro 'mensaje' en la URL
        $(document).ready(function() {
            const mensaje = getParameterByName('mensaje');
            if (mensaje) {
                switch (mensaje) {
                    case 'eliminado_exitoso':
                        toastr.success('Personal eliminado con éxito.');
                        break;
                    case 'error_eliminar':
                        toastr.error('Error al eliminar el personal.');
                        break;
                    case 'duplicado_exitoso':
                        toastr.success('Personal duplicado con éxito.');
                        break;
                    case 'error_duplicar':
                        toastr.error('Error al duplicar el personal.');
                        break;
                }

                // Redirigir para limpiar la URL después de mostrar la notificación
                setTimeout(function() {
                    const url = new URL(window.location.href);
                    url.searchParams.delete('mensaje');
                    window.history.replaceState({}, document.title, url.toString());
                }, 2000); // 2 segundos para que el usuario vea la notificación
            }
        });

        // Función para descargar Excel con encabezados
        function downloadExcelHeaders() {
            const headers = ['Nombre', 'Institución', 'Especialidad', 'Matrícula del Vehículo'];
            const ws = XLSX.utils.aoa_to_sheet([headers]);
            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, "Bomberos");

            XLSX.writeFile(wb, 'bomberos_encabezados.xlsx');
        }

        // Función para descargar todos los registros en Excel
        function downloadAllRecords() {
            const table = document.querySelector('table');
            const wb = XLSX.utils.table_to_book(table, {
                sheet: "Bomberos"
            });
            XLSX.writeFile(wb, 'bomberos_completo.xlsx');
        }

        // Función para subir un archivo Excel y procesarlo
        function uploadExcel(event) {
            const file = event.target.files[0];
            if (!file) {
                console.log('No se seleccionó ningún archivo');
                return;
            }

            const reader = new FileReader();
            const urlParams = new URLSearchParams(window.location.search);
            const id_incidente = urlParams.get('id_incidente');

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

                // Enviar datos al servidor
                fetch(`../controller/Controller-registro_personal.php?action=actualizar_desde_excel&id_incidente=${id_incidente}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(jsonData)
                    })
                    .then(response => {
                        // Primero vemos el texto de la respuesta
                        return response.text().then(text => {
                            console.log('Respuesta del servidor:', text);
                            try {
                                // Intentamos parsear como JSON
                                return JSON.parse(text);
                            } catch (e) {
                                throw new Error('Respuesta del servidor no válida: ' + text);
                            }
                        });
                    })
                    .then(result => {
                        if (result.success) {
                            alert(result.message);
                            location.reload();
                        } else {
                            alert('Error: ' + result.message);
                        }
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

        // Asegúrate de que el evento está correctamente vinculado
        document.addEventListener('DOMContentLoaded', function() {
            const uploadInput = document.getElementById('uploadExcel');
            const uploadButton = document.getElementById('uploadButton');

            if (uploadInput) {
                uploadInput.addEventListener('change', uploadExcel);
            } else {
                console.error('No se encontró el elemento uploadExcel');
            }

            if (uploadButton) {
                uploadButton.addEventListener('click', () => {
                    uploadInput.click();
                });
            }
        });

        // Asegúrate de que el evento está correctamente vinculado
        document.addEventListener('DOMContentLoaded', function() {
            const uploadInput = document.getElementById('uploadExcel');
            if (uploadInput) {
                uploadInput.addEventListener('change', uploadExcel);
            } else {
                console.error('No se encontró el elemento uploadExcel');
            }
        });

        // Event listeners
        document.addEventListener('DOMContentLoaded', function() {
            // Descargar encabezados
            document.getElementById('downloadExcelHeaders').addEventListener('click', downloadExcelHeaders);

            // Descargar todos los registros
            document.getElementById('downloadExcelAll').addEventListener('click', downloadAllRecords);

            // Subir archivo Excel
            document.getElementById('uploadButton').addEventListener('click', () => {
                document.getElementById('uploadExcel').click();
            });

            // Manejar subida de archivo
            document.getElementById('uploadExcel').addEventListener('change', uploadExcel);
        });
    </script>

</body>

</html>
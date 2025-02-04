<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBSD-SCI-201 Mapa SCI-201</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <link rel="stylesheet" href="./lib/css/style.css" />
    <link rel="stylesheet" href="./lib/leaflet/leaflet.css" />
    <!-- Add Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="custom-header.js"></script>
    <script src="menu-desplegable.js"></script>
</head>

<body>
    <?php
    include_once('../model/Model-Incidentes.php');

    $id_incidente = isset($_GET['id_incidente']) ? intval($_GET['id_incidente']) : null;
    $incidente = null;

    if ($id_incidente) {
        $incidente = obtenerIncidentePorId($id_incidente);
    } else {
        echo "No se ha seleccionado un incidente.";
        exit;
    }
    ?>

    <custom-header
        incidente-nombre="<?php echo htmlspecialchars($incidente['nombre_inci']); ?>"
        incidente-cerrado="<?php echo $incidente['estatus'] === 'CERRADO' ? 'true' : 'false'; ?>">
    </custom-header>
    <custom-menu></custom-menu>
    <div class="content">
        <!-- <div class="card" style="width: 18rem;">
            <div class="card-header">
                SCI-201 Mapa
            </div>
        </div> -->
        <div class="version-container">
            <div class="version-text">
                <i class="fas fa-map"></i> Mapa de Santo Domingo
            </div>
            <div class="button-container">
                <button id="fillDetailsBtn" class="button"><i class="fas fa-map-marked-alt"></i> Agregar marcador en mapa</button>
            </div>
            <div id="mapContainer"></div>
        </div>

        <!-- Modal -->
        <div id="myModal" class="modal">
            <div class="modal-content">
                <h2>Alfileres de Ubicación</h2>
                <div id="pins" class="pin-container"></div>
                <div class="button-container">
                    <button type="button" class="cancel-btn" id="closeModalBtn">Cerrar</button>
                    <button type="button" class="button custom-btn" id="customIconBtn">
                        <i class="fas fa-fire"></i> <span>Personalizado</span>
                    </button>
                </div>
                <div id="fireIcons" class="fire-icons"></div>
            </div>
        </div>

        <!-- Formulario Modal -->
        <div id="formModal" class="form-modal">
            <div class="form-content">
                <h2>Detalles del Alfiler</h2>
                <form id="pinForm">
                    <div class="form-group">
                        <label for="pinTitle">Título:</label>
                        <input type="text" id="pinTitle" required>
                    </div>
                    <div class="coordinates-group">
                        <div class="form-group">
                            <label for="pinLatitude">Latitud:</label>
                            <input type="text" id="pinLatitude" readonly>
                        </div>
                        <div class="form-group">
                            <label for="pinLongitude">Longitud:</label>
                            <input type="text" id="pinLongitude" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pinObservations">Observaciones:</label>
                        <textarea id="pinObservations" rows="3"></textarea>
                    </div>
                    <div class="form-buttons">
                        <button type="button" class="cancel-btn" id="cancelPinBtn">Cancelar</button>
                        <button type="submit" class="button">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="./lib/leaflet/leaflet.js"></script>
    <!-- Add jQuery (required for Toastr) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Add Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        // Variables globales
        var fillDetailsBtn = document.getElementById("fillDetailsBtn");
        var map;
        var userMarker;
        var watchID;
        var selectedPinColor = null;
        var selectedIconClass = null;
        var markers = [];
        var tempMarker = null;
        var formModal = document.getElementById("formModal");
        var currentIncidentId = <?php echo json_encode($id_incidente); ?>;
        var alertDiv;
        var mapCanvas;
        var captureTimeout;
        const CAPTURE_DELAY = 2000; // Retraso para capturar el mapa después de cambios

        // Configuración de Toastr
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        // Inicialización
        window.onload = function() {
            initMap();
            cargarMarcadoresDesdeBaseDeDatos();
            createAlertDiv();
            initializeCanvasCapture();
        };

        // Funciones principales
        function initMap() {
            map = L.map('mapContainer').setView([-0.2369, -79.1654], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(map);

            map.on('moveend zoomend', captureAndSaveMap);

            map.on('click', function(e) {
                if (selectedPinColor || selectedIconClass) {
                    showPinForm(e.latlng);
                    hideAlert();
                }
            });

            if (navigator.geolocation) {
                watchID = navigator.geolocation.watchPosition(function(position) {
                    var lat = position.coords.latitude;
                    var lon = position.coords.longitude;

                    if (userMarker) {
                        userMarker.setLatLng([lat, lon]);
                    } else {
                        userMarker = L.marker([lat, lon], {
                            icon: L.divIcon({
                                className: 'fa-user-location',
                                html: '<i class="fas fa-user" style="color: blue; font-size: 24px;"></i>',
                                iconSize: [25, 41]
                            })
                        }).addTo(map);

                        userMarker.on('mouseover', function(e) {
                            showDetails(e.target.getLatLng());
                        });
                    }

                    // map.setView([lat, lon], 13);
                });
            }
        }

        function captureAndSaveMap() {
            clearTimeout(captureTimeout);
            captureTimeout = setTimeout(function() {
                html2canvas(document.getElementById('mapContainer'), {
                    useCORS: true,
                    allowTaint: true,
                    logging: false,
                    backgroundColor: null
                }).then(canvas => {
                    canvas.toBlob(function(blob) {
                        const formData = new FormData();
                        formData.append('imagen', blob, `mapa_${currentIncidentId}.png`);
                        formData.append('id_incidente', currentIncidentId);
                        formData.append('action', 'guardar_imagen_mapa');

                        fetch('../controller/Controller-Mapa.php', {
                                method: 'POST',
                                body: formData
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    console.log('Imagen del mapa guardada exitosamente');
                                    toastr.success('Imagen del mapa actualizada', 'Éxito');
                                } else {
                                    console.error('Error al guardar la imagen:', data.message, data.debug);
                                }
                            })
                            .catch(error => {
                                console.error('Error en la petición:', error);
                            });
                    }, 'image/png');
                });
            }, CAPTURE_DELAY);
        }

        function createAlertDiv() {
            alertDiv = document.createElement('div');
            alertDiv.id = 'mapAlert';
            alertDiv.style.position = 'fixed';
            alertDiv.style.top = '20px';
            alertDiv.style.left = '50%';
            alertDiv.style.transform = 'translateX(-50%)';
            alertDiv.style.backgroundColor = 'rgba(0, 0, 0, 0.8)';
            alertDiv.style.color = 'white';
            alertDiv.style.padding = '15px';
            alertDiv.style.borderRadius = '5px';
            alertDiv.style.display = 'none';
            alertDiv.style.zIndex = '9999';
            alertDiv.style.boxShadow = '0 0 10px rgba(0,0,0,0.5)';
            document.body.appendChild(alertDiv);
        }

        function showPinForm(latlng) {
            document.getElementById("pinLatitude").value = latlng.lat.toFixed(6);
            document.getElementById("pinLongitude").value = latlng.lng.toFixed(6);
            formModal.style.display = "block";

            if (tempMarker) {
                map.removeLayer(tempMarker);
            }
            tempMarker = L.marker(latlng).addTo(map);
        }

        function closeFormModal() {
            formModal.style.display = "none";
            if (tempMarker) {
                map.removeLayer(tempMarker);
                tempMarker = null;
            }
        }

        function guardarMarcadorEnBaseDeDatos(latlng, titulo, observaciones) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "../controller/Controller-Mapa.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                    var response = JSON.parse(this.responseText);
                    if (response.success) {
                        placePin(latlng, titulo, observaciones, response.id, selectedIconClass || 'fas fa-map-pin', selectedPinColor);
                        toastr.success('Marcador agregado exitosamente', 'Éxito');
                        captureAndSaveMap();
                    } else {
                        console.error("Error al guardar el marcador:", response.message);
                        toastr.error('Error al guardar el marcador', 'Error');
                    }
                }
            }
            var claseIcono = selectedIconClass || 'fas fa-map-pin';
            xhr.send("action=guardar_marcador&latitud=" + latlng.lat + "&longitud=" + latlng.lng +
                "&titulo=" + encodeURIComponent(titulo) + "&observaciones=" + encodeURIComponent(observaciones) +
                "&clase_icono=" + encodeURIComponent(claseIcono) + "&color_icono=" + encodeURIComponent(selectedPinColor) +
                "&id_incidente=" + currentIncidentId);
        }

        function placePin(latlng, titulo, observaciones, id, clase_icono, color_icono) {
            var iconHtml = `<i class="${clase_icono}" style="color: ${color_icono}; font-size: 24px;"></i>`;

            var icon = L.divIcon({
                className: 'custom-div-icon',
                html: `
            <div style="position: relative;">
                ${iconHtml}
                <div class="marker-delete">×</div>
            </div>
        `,
                iconSize: [30, 42],
                iconAnchor: [15, 42]
            });

            var marker = L.marker(latlng, {
                icon: icon
            }).addTo(map);

            marker.bindPopup(`<b>${titulo}</b><br>${observaciones}`);

            marker.getElement().querySelector('.marker-delete').addEventListener('click', function(e) {
                e.stopPropagation();
                eliminarMarcadorDeBaseDeDatos(id);
                map.removeLayer(marker);
                markers = markers.filter(m => m !== marker);
                captureAndSaveMap();
            });

            markers.push(marker);

            selectedPinColor = null;
            selectedIconClass = null;
            updateSelection();
        }

        function eliminarMarcadorDeBaseDeDatos(id) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "../controller/Controller-Mapa.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                    var response = JSON.parse(this.responseText);
                    if (response.success) {
                        toastr.success('Marcador eliminado exitosamente', 'Éxito');
                    } else {
                        console.error("Error al eliminar el marcador:", response.message);
                        toastr.error('Error al eliminar el marcador', 'Error');
                    }
                }
            }
            xhr.send("action=eliminar_marcador&id=" + id);
        }

        function cargarMarcadoresDesdeBaseDeDatos() {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "../controller/Controller-Mapa.php?action=obtener_marcadores&id_incidente=" + currentIncidentId, true);
            xhr.onreadystatechange = function() {
                if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                    var response = JSON.parse(this.responseText);
                    if (response.success) {
                        response.marcadores.forEach(function(marcador) {
                            placePin(
                                L.latLng(parseFloat(marcador.latitud), parseFloat(marcador.longitud)),
                                marcador.titulo,
                                marcador.observaciones,
                                marcador.id,
                                marcador.clase_icono,
                                marcador.color_icono
                            );
                        });
                        toastr.success('Marcadores cargados exitosamente', 'Éxito');
                        captureAndSaveMap();
                    } else {
                        console.error("Error al obtener marcadores:", response.message);
                        toastr.error('Error al cargar los marcadores', 'Error');
                    }
                }
            }
            xhr.send();
        }

        function showDetails(latlng) {
            fetch(`https://nominatim.openstreetmap.org/reverse?lat=${latlng.lat}&lon=${latlng.lng}&format=json`)
                .then(response => response.json())
                .then(data => {
                    var address = data.address || {};
                    var details = `
            <b>Detalles de ubicación:</b><br>
            Calle: ${address.road || 'No disponible'}<br>
            Parroquia: ${address.suburb || 'No disponible'}<br>
            ${address.village ? 'Cooperativa: ' + address.village : 
             address.neighbourhood ? 'Urbanización: ' + address.neighbourhood : ''}
        `;
                    L.popup()
                        .setLatLng(latlng)
                        .setContent(details)
                        .openOn(map);
                })
                .catch(error => {
                    console.error("Error al obtener detalles de ubicación:", error);
                    toastr.error('Error al obtener detalles de ubicación', 'Error');
                });
        }

        // Event Listeners
        fillDetailsBtn.onclick = function() {
            displayPins();
            document.getElementById("myModal").style.display = "block";
        }

        document.getElementById("closeModalBtn").onclick = function() {
            document.getElementById("myModal").style.display = "none";
            selectedPinColor = null;
            selectedIconClass = null;
            updateSelection();
            hideAlert();
        }

        document.getElementById("customIconBtn").onclick = function() {
            var fireIconsContainer = document.getElementById("fireIcons");
            var btnIcon = this.querySelector('i');
            var btnText = this.querySelector('span');

            if (fireIconsContainer.style.display === 'grid') {
                fireIconsContainer.style.display = 'none';
                btnIcon.className = 'fas fa-fire';
                btnText.textContent = 'Personalizado';
            } else {
                fireIconsContainer.style.display = 'grid';
                fireIconsContainer.innerHTML = '';
                btnIcon.className = 'fas fa-times';
                btnText.textContent = 'Cerrar iconos personalizados';
                var fireIcons = ['fas fa-fire-extinguisher', 'fas fa-fire', 'fas fa-burn', 'fas fa-hiking', 'fas fa-water', 'fas fa-socks'];

                fireIcons.forEach(iconClass => {
                    var iconDiv = document.createElement('div');
                    iconDiv.innerHTML = `<i class="${iconClass}" style="color: red;"></i>`;
                    iconDiv.onclick = function() {
                        selectedIconClass = iconClass;
                        selectedPinColor = 'red';
                        updateSelection();
                        showAlert(selectedIconClass);
                        document.getElementById("myModal").style.display = "none";
                        console.log('Custom icon selected:', selectedIconClass);
                    }
                    fireIconsContainer.appendChild(iconDiv);
                });
            }
        }

        document.getElementById("pinForm").onsubmit = function(e) {
            e.preventDefault();
            var title = document.getElementById("pinTitle").value;
            var lat = document.getElementById("pinLatitude").value;
            var lng = document.getElementById("pinLongitude").value;
            var observations = document.getElementById("pinObservations").value;

            guardarMarcadorEnBaseDeDatos(L.latLng(lat, lng), title, observations);
            closeFormModal();
        }

        document.getElementById("cancelPinBtn").addEventListener('click', closeFormModal);

        window.addEventListener('click', function(event) {
            if (event.target == formModal) {
                closeFormModal();
            }
        });

        function displayPins() {
            const pinsContainer = document.getElementById("pins");
            pinsContainer.innerHTML = '';

            const colors = ['#FF6347', '#4682B4', '#FFD700', '#32CD32', '#FF4500', '#FF1493', '#00BFFF', '#8A2BE2'];
            for (let i = 0; i < colors.length; i++) {
                let pinDiv = document.createElement('div');
                pinDiv.className = 'pin';
                pinDiv.innerHTML = `<i class="fas fa-map-pin" style="color: ${colors[i]};"></i>`;
                pinDiv.onclick = function() {
                    selectedPinColor = colors[i];
                    selectedIconClass = 'fas fa-map-pin';
                    updateSelection();
                    showAlert(selectedIconClass);
                    document.getElementById("myModal").style.display = "none";
                    console.log('Pin selected:', selectedIconClass, selectedPinColor);
                }
                pinsContainer.appendChild(pinDiv);
            }
        }

        document.getElementById("closeModalBtn").onclick = function() {
            document.getElementById("myModal").style.display = "none";
            selectedPinColor = null;
            selectedIconClass = null;
            updateSelection();
            hideAlert();
        }

        document.getElementById("customIconBtn").onclick = function() {
            var fireIconsContainer = document.getElementById("fireIcons");
            var btnIcon = this.querySelector('i');
            var btnText = this.querySelector('span');

            if (fireIconsContainer.style.display === 'grid') {
                fireIconsContainer.style.display = 'none';
                btnIcon.className = 'fas fa-fire';
                btnText.textContent = 'Personalizado';
            } else {
                fireIconsContainer.style.display = 'grid';
                fireIconsContainer.innerHTML = '';
                btnIcon.className = 'fas fa-times';
                btnText.textContent = 'Cerrar iconos personalizados';
                var fireIcons = ['fas fa-fire-extinguisher', 'fas fa-fire', 'fas fa-burn', 'fas fa-hiking', 'fas fa-water', 'fas fa-socks'];

                fireIcons.forEach(iconClass => {
                    var iconDiv = document.createElement('div');
                    iconDiv.innerHTML = `<i class="${iconClass}" style="color: red;"></i>`;
                    iconDiv.onclick = function() {
                        selectedIconClass = iconClass;
                        selectedPinColor = 'red';
                        updateSelection();
                        showAlert(selectedIconClass);
                        document.getElementById("myModal").style.display = "none";
                        console.log('Custom icon selected:', selectedIconClass);
                    }
                    fireIconsContainer.appendChild(iconDiv);
                });
            }
        }

        function updateSelection() {
            document.querySelectorAll('.pin, .fire-icons > div').forEach(el => {
                el.classList.remove('selected');
            });

            if (selectedPinColor) {
                document.querySelector(`.pin i[style*="${selectedPinColor}"]`).parentNode.classList.add('selected');
            } else if (selectedIconClass) {
                document.querySelector(`.fire-icons i.${selectedIconClass}`).parentNode.classList.add('selected');
            }
        }

        function limpiarMapa() {
            markers.forEach(marker => map.removeLayer(marker));
            markers = [];
            captureAndSaveMap(); // Capturar el mapa después de limpiarlo
        }

        function actualizarMapa(nuevoIdIncidente) {
            currentIncidentId = nuevoIdIncidente;
            limpiarMapa();
            cargarMarcadoresDesdeBaseDeDatos();
        }

        // Agregar la librería html2canvas en el head del documento
        document.addEventListener('DOMContentLoaded', function() {
            var script = document.createElement('script');
            script.src = 'https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js';
            document.head.appendChild(script);
        });
    </script>
</body>

</html>
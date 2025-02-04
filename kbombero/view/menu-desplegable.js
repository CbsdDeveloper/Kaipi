class CustomMenu extends HTMLElement {
    constructor() {
        super();
        this.attachShadow({ mode: 'open' });

        // Recupera el id_incidente y la página actual desde la URL
        const urlParams = new URLSearchParams(window.location.search);
        let id_incidente = urlParams.get('id_incidente');
        const currentPage = urlParams.get('page');

        fetch('../model/Model-ObtenerIncidente.php') // Archivo PHP
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la solicitud: ' + response.status);
                }
                return response.json(); // Parsear la respuesta como JSON
            })
            .then(data => {
                id_incidente = data;
                console.log(data);

                // Inserta el HTML dentro del shadow DOM
                this.shadowRoot.innerHTML = `
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
        <style>
            .sidebar {
                width: 250px;
                background-color: #d21e20;
                height: 100vh;
                position: fixed;
                top: 40px;
                left: 0;
                padding-top: 20px;
                color: white;
                margin-top: 3px
            }

            .menu-item, .menu-subitem {
                display: block;
                padding: 10px 20px;
                color: white;
                text-decoration: none;
                font-size: 14px;
                transition: background-color 0.3s ease;
            }

            .menu-item:hover, .menu-subitem:hover {
                background-color: #1d314a;
            }

            .submenu {
                max-height: 0;
                overflow: hidden;
                margin-left: 30px;
            }

            .submenu-active {
                max-height: 500px; /* Adjust this value based on your content */
            }

            .toggle-icon {
                float: right;
            }

            @media (max-width: 768px) {
                .sidebar {
                    width: 100%;
                    height: auto;
                    position: relative;
                }
            }
        </style>
        <div class="sidebar">
            <span class="menu-item"><i class="fas fa-user-cog"></i> admin</span>
            <a href="#" class="menu-item" id="toggle-sci201"><i class="fas fa-file-alt"></i> SCI-201 <span class="toggle-icon" id="icon-sci201">+</span></a>
            <div id="submenu-sci201" class="submenu">
                <a href="datos_generales.php?page=datos&id_incidente=${id_incidente}" class="menu-subitem"><i class="fas fa-info-circle"></i> Datos Generales</a>
                <a href="mapa.php?page=mapa&id_incidente=${id_incidente}" class="menu-subitem"><i class="fas fa-map-marked-alt"></i> Mapa</a>
                <a href="principal.php?page=resumen&id_incidente=${id_incidente}" class="menu-subitem"><i class="fas fa-list-alt"></i> Resumen de las acciones</a>
                <a href="?page=estructura&id_incidente=${id_incidente}" class="menu-subitem"><i class="fas fa-sitemap"></i> Estructura</a>
            </div>

            <a href="lista_personas.php?page=personas&id_incidente=${id_incidente}" class="menu-item"><i class="fas fa-file-medical"></i> SCI-207</a>
            <a href="#" class="menu-item" id="toggle-sci211"><i class="fas fa-file-excel"></i> SCI-211 <span class="toggle-icon" id="icon-sci211">+</span></a>
            <div id="submenu-sci211" class="submenu">
                <a href="bom_recursos.php?page=sci211_recursos&id_incidente=${id_incidente}" class="menu-subitem"><i class="fas fa-cubes"></i>Recursos</a>
                <a href="registro_personal.php?page=registro&id_incidente=${id_incidente}" class="menu-subitem"><i class="fas fa-users"></i> Registro de Personal</a>
            </div>
            <a href="#" class="menu-item" id="toggle-sci202"><i class="fas fa-file-contract"></i> SCI-202 <span class="toggle-icon" id="icon-sci202">+</span></a>
            <div id="submenu-sci202" class="submenu">
                <a href="table_datos_generales.php?page=datos&id_incidente=${id_incidente}" class="menu-subitem"><i class="fas fa-info-circle"></i> Datos Generales</a>
                <a href="?page=pai_estructura&id_incidente=${id_incidente}" class="menu-subitem"><i class="fas fa-sitemap"></i> PAI Estructura</a>
            </div>
            <a href="?page=sci203" class="menu-item"><i class="fas fa-file-alt"></i> SCI-203</a>
            <a href="bom_asignaciones.php?page=sci204&id_incidente=${id_incidente}" class="menu-item"><i class="fas fa-chevron-up"></i> SCI-204</a>
            <a href="listar_CommunicationPlan.php?page=plan_comunicaciones&id_incidente=${id_incidente}" class="menu-item"><i class="fas fa-rss"></i> SCI-205</a>
            <a href="?page=sci206" class="menu-item"><i class="fas fa-user"></i> SCI-206</a>
            <a href="registro_sci-214.php?page=sci214&id_incidente=${id_incidente}" class="menu-item"><i class="fas fa-edit"></i> SCI-214</a>
            <a href="listar_SafetyAnalysis.php?page=security&id_incidente=${id_incidente}"class="menu-item"><i class="fas fa-edit"></i> SCI-215a</a>
            <a href="listar_DemobilizationVerification.php?page=desmovilizacion&id_incidente=${id_incidente}" class="menu-item"><i class="fas fa-th"></i> SCI-221</a>
            <a href="?page=rpi" class="menu-item"><i class="fas fa-file-signature"></i> RPI</a>
            <a href="?page=reportero" class="menu-item"><i class="fas fa-user-edit"></i> Reportero</a>
            <a href="documentos.php?page=documentos" class="menu-item"><i class="fas fa-folder-open"></i> Documentos</a>
            <a href="./inicio.php" class="menu-item"><i class="fas fa-sign-out-alt"></i> Salida</a>

        </div>
    `;

                // Función para abrir o cerrar el submenú
                const toggleSubmenu = (submenuId, iconId, open) => {
                    const submenu = this.shadowRoot.getElementById(submenuId);
                    const icon = this.shadowRoot.getElementById(iconId);
                    if (open) {
                        submenu.classList.add('submenu-active');
                        icon.textContent = '-';
                    } else {
                        submenu.classList.remove('submenu-active');
                        icon.textContent = '+';
                    }
                };

                // Función para cerrar todos los submenús
                const closeAllSubmenus = () => {
                    ['submenu-sci201', 'submenu-sci211', 'submenu-sci202'].forEach(submenuId => {
                        const submenu = this.shadowRoot.getElementById(submenuId);
                        const icon = this.shadowRoot.getElementById(`icon-${submenuId.split('-')[1]}`);
                        submenu.classList.remove('submenu-active');
                        icon.textContent = '+';
                    });
                };

                // Definir las páginas de cada submenú
                const submenuPages = {
                    'sci201': ['datos', 'mapa', 'resumen', 'estructura'],
                    'sci211': ['sci211_recursos', 'sci211_registro_personal'],
                    'sci202': ['pai_datos_generales', 'pai_estructura']
                };

                // Función para manejar la navegación y el estado de los submenús
                const handleNavigation = (newPage) => {
                    closeAllSubmenus();
                    for (const [submenu, pages] of Object.entries(submenuPages)) {
                        if (pages.includes(newPage)) {
                            toggleSubmenu(`submenu-${submenu}`, `icon-${submenu}`, true);
                            break;
                        }
                    }
                };

                // Toggle de los submenús al hacer clic
                ['sci201', 'sci211', 'sci202'].forEach(submenu => {
                    this.shadowRoot.getElementById(`toggle-${submenu}`).addEventListener('click', (e) => {
                        e.preventDefault();
                        const submenuElement = this.shadowRoot.getElementById(`submenu-${submenu}`);
                        toggleSubmenu(`submenu-${submenu}`, `icon-${submenu}`, !submenuElement.classList.contains('submenu-active'));
                    });
                });

                // Escucha cambios en la URL
                window.addEventListener('popstate', () => {
                    const newUrlParams = new URLSearchParams(window.location.search);
                    const newPage = newUrlParams.get('page');
                    handleNavigation(newPage);
                });

                // Manejar la recarga de la página
                window.addEventListener('load', () => {
                    // Cerrar todos los submenús al recargar
                    closeAllSubmenus();
                    // Luego, abrir el submenú correspondiente a la página actual si es necesario
                    if (currentPage) {
                        handleNavigation(currentPage);
                    }
                });

                // Agregar listener para los enlaces del submenú
                this.shadowRoot.querySelectorAll('.menu-subitem').forEach(link => {
                    link.addEventListener('click', (e) => {
                        const pageParam = new URL(e.target.href).searchParams.get('page');
                        handleNavigation(pageParam);
                    });
                });
                // document.getElementById('output').textContent = JSON.stringify(data, null, 2); // Mostrar datos en la página
            })
            .catch(error => {
                console.error('Hubo un problema con la solicitud:', error);
                // document.getElementById('output').textContent = 'Error: ' + error.message;
            });


    }
}


customElements.define('custom-menu', CustomMenu);

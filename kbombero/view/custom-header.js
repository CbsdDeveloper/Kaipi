class CustomHeader extends HTMLElement {
    constructor() {
        super();
        this.attachShadow({ mode: 'open' });
        this.shadowRoot.innerHTML = `
            <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
            <style>
                :host {
                    --bg-color: #f4f7f9;
                    --text-color: #000;
                    --header-bg: #fff;
                    --header-border: #ddd;
                    --etiqueta-bg: #3276b1;
                    --etiqueta-color: white;
                    --etiqueta-cerrado-bg: #999999;
                    //formulario blanco 
                    --bg-form: #fff;
                    --text-form: #000;
                    --border-form: #ddd;
                    --btn-bg: #3276b1;
                    --btn-color: white;
                }

                :host(.dark-mode) {
                    --bg-color: #1a1a1a;
                    --text-color: #fff;
                    --header-bg: #2c2c2c;
                    --header-border: #444;
                    --etiqueta-bg: #4a90e2;
                    --etiqueta-color: white;
                    --etiqueta-cerrado-bg: #666666;
                    //formulario oscuro
                    --bg-form: #333;
                    --text-form: #fff;
                    --border-form: #444;
                    --btn-bg: #4a90e2;
                    --btn-color: white;
                }

                body, html {
                    margin: 0;
                    padding: 0;
                    font-family: Helvetica, sans-serif;
                    font-size: 16px;
                    background-color: var(--bg-color);
                    color: var(--text-color);
                    height: 100%;
                    overflow-x: hidden;
                }
                .header {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    background-color: var(--header-bg);
                    padding: 10px 2%;
                    border-bottom: 1px solid var(--header-border);
                    position: fixed;
                    width: 100%;
                    top: 0;
                    left: 0;
                    z-index: 9999;
                    height: 60px;
                    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
                    font-size: 18px;
                }

                .user-info {
                    display: flex;
                    align-items: center;
                }

                .user-info i {
                    margin-right: 8px;
                }

                .actions i {
                    margin-left: 15px;
                    cursor: pointer;
                }
                .etiqueta-incidente {
                    background-color: var(--etiqueta-bg);
                    color: var(--etiqueta-color);
                    padding: 3px 5px;
                    border-radius: 5px;
                    font-size: 14px;
                    margin-right: 15px;
                }

                .etiqueta-incidente-cerrado {
                    background-color: var(--etiqueta-cerrado-bg);
                    color: var(--etiqueta-color);
                    padding: 3px 5px;
                    border-radius: 5px;
                    font-size: 14px;
                }

                .flexb {
                    display: flex;
                    justify-content: flex-end;
                    margin-left: 30px;
                    width: 100%;
                }
            </style>
            <div class="header">
                <img alt="SCI Logo" src="./images/header.png" width="150" height="50"/>
                <div class="flexb">
                    <div class="etiqueta-incidente" id="incidente-label"></div>
                    <div class="etiqueta-incidente-cerrado" id="incidente-cerrado-label"></div>
                    <div class="actions">
                        <i class="fas fa-home" id="home-icon"></i>
                        <i class="fas fa-print" id="print-icon"></i>
                        <i class="fas fa-expand" id="fullscreen-icon"></i>
                        <i class="fas fa-adjust" id="dark-mode-icon"></i>
                    </div>
                </div>
            </div>
        `;
    }

    connectedCallback() {
        const incidenteNombre = this.getAttribute('incidente-nombre');
        const incidenteCerrado = this.getAttribute('incidente-cerrado') === 'true';

        if (incidenteNombre) {
            this.shadowRoot.querySelector('#incidente-label').textContent = incidenteNombre;
        }

        const cerradoLabel = this.shadowRoot.querySelector('#incidente-cerrado-label');
        if (incidenteCerrado) {
            cerradoLabel.textContent = 'Incidente Cerrado';
            cerradoLabel.style.display = 'inline-block';
        } else {
            cerradoLabel.style.display = 'none';
        }

        this.shadowRoot.querySelector('#home-icon').addEventListener('click', () => {
            window.location.href = './inicio.php';
        });

        this.shadowRoot.querySelector('#print-icon').addEventListener('click', () => {
            window.print();
        });

        this.shadowRoot.querySelector('#fullscreen-icon').addEventListener('click', () => {
            if (document.fullscreenElement) {
                document.exitFullscreen();
            } else {
                document.documentElement.requestFullscreen();
            }
        });

        this.shadowRoot.querySelector('#dark-mode-icon').addEventListener('click', () => {
            this.toggleDarkMode();
        });

        // Verificar si el modo oscuro estaba activo
        if (localStorage.getItem('darkMode') === 'true') {
            this.enableDarkMode();
        }
    }

    toggleDarkMode() {
        if (this.classList.contains('dark-mode')) {
            this.disableDarkMode();
        } else {
            this.enableDarkMode();
        }
    }

    enableDarkMode() {
        this.classList.add('dark-mode');
        document.body.classList.add('dark-mode');
        localStorage.setItem('darkMode', 'true');
    }

    disableDarkMode() {
        this.classList.remove('dark-mode');
        document.body.classList.remove('dark-mode');
        localStorage.setItem('darkMode', 'false');
    }
}

customElements.define('custom-header', CustomHeader);
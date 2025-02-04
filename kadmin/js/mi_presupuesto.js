

$(document).ready(function () {

	$("#NavMod").load('../view/View-HeaderMain.php');

	$("#FormPie").load('../view/View-pie.php');

	$("#viewform").load('../controller/Controller_micombustible.php');

	Busqueda();
});
//--------------
function Busqueda() {


	$.ajax({
		type: 'GET',
		url: '../model/Model_reportes_presupuesto.php',
		success: function (response) {
			$("#viewformResultado").html(response);

		}
	});


}

function filterTable() {
	// Obtener el valor de búsqueda
	const input = document.getElementById("searchInput");
	const filter = input.value.toUpperCase();
	const table = document.getElementById("jtabla_gasto");
	const tr = table.getElementsByTagName("tr");

	// Iterar sobre las filas de la tabla y ocultar las que no coincidan
	for (let i = 1; i < tr.length; i++) { // Empezar en 1 para saltar el encabezado
		const td = tr[i].getElementsByTagName("td");
		console.log(td)
		let match = false;

		// Verificar cada celda de la fila
		for (let j = 0; j < td.length; j++) {
			if (td[j] && td[j].innerText.toUpperCase().indexOf(filter) > -1) {
				match = true;
				break;
			}
		}

		// Mostrar u ocultar la fila
		tr[i].style.display = match ? "" : "none";
	}
}

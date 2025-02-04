$(function () {

	$(document).bind("contextmenu", function (e) {
		return false;
	});

});

$.ajax({
    url: '../model/Model-Incidentes.php', // Asegúrate de que esta es la ruta correcta
    type: 'GET',
    dataType: 'json',
    data: { accion: 'consulta' }, // Esto hace que consultes los incidentes
    success: function (data) {
        let tableBody = '';
        $.each(data, function (index, incidente) {
            tableBody += '<tr>';
            tableBody += '<td><a href="../view/navbar.php?id_incidente=' + incidente.id_incidentes + '" class="btn blue"><i class="fa fa-th-list"></i> Formularios</a>';
            tableBody += '</td>';
            tableBody += '<td>' + incidente.nombre_inci + '</td>';
            tableBody += '<td>' + incidente.fecha_hora_inci + '</td>';
            tableBody += '<td>' + incidente.fecha_cierre_oper + '</td>';
            tableBody += '<td>' + incidente.estatus + '</td>';
            tableBody += '<td><a href="#" class="btn icono" onclick="editar(' + incidente.id_incidentes + ')"><i class="fas fa-edit k"></i></a>';
            tableBody += '<a href="#" class="btn icono" onclick="eliminar(' + incidente.id_incidentes + ')"><i class="fas fa-trash-o k"></i></a></td>';
            tableBody += '</tr>';
        });

        $('#ViewIncidentes tbody').html(tableBody);
		$('.ViewIncidentes').DataTable({
			"language": {
				"lengthMenu": "Mostrar _MENU_ registros por página",
				"zeroRecords": "No se encontraron registros",
				"info": "Mostrando página _PAGE_ de _PAGES_",
				"infoEmpty": "No hay registros disponibles",
				"search": "Buscar:",
				"infoFiltered": "(filtrado de _MAX_ registros totales)",
				"paginate": {
					"first": "Primero",
					"last": "Último",
					"next": "Siguiente",
					"previous": "Anterior"
				}
			},
			initComplete: function () {
				// Añadir clase al cuadro de búsqueda
				$('.dataTables_filter input').addClass('buscar-container'); 
			}
		});
		
    },
	
    error: function (xhr, status, error) {
        console.error("Status: " + status + ", Error: " + error);
        $('#ViewIncidentes tbody').html('<tr><td colspan="6">No se pudieron cargar los datos.</td></tr>');
    }
});


function eliminar(id) {
	console.log("Eliminar")
	if (confirm('¿Estás seguro de que deseas eliminar este incidente? :)')) {
		$.ajax({
			url: '../controller/Controller-incidente.php',
			type: 'POST',
			data: {
				accion: 'eliminar',
				id_incidentes: id
			},
			success: function (response) {
				console.log(response); 
				try {
					let data = typeof response === 'string' ? JSON.parse(response) : response;
					if (data.status === 'success') {
						alert('Incidente eliminado exitosamente.');
						location.reload();  
					} else {
						alert('Error al eliminar el incidente.');
					}
				} catch (e) {
					console.error("Error procesando la respuesta: ", e);
					alert("Error al procesar la respuesta del servidor.");
				}
			}
			,
			error: function (xhr, status, error) {
				console.error("Status: " + status + ", Error: " + error);
			}
		});
	}
}



function editar(id) {
	
	console.log("Editar")
	$.ajax({
		url: '../controller/Controller-incidente.php',
		type: 'POST',
		dataType: 'json',
		data: { accion: 'obtenerIncidente', id_incidentes: id },
		success: function (data) {
			console.log("Datos del incidente recibidos: ", data);
			if (data && data.id_incidentes) {
				$('#id_incidentes').val(data.id_incidentes);
				$('#nombre').val(data.nombre_inci);
				$('#lugar').val(data.lugar_inci);
				$('#municipio').val(data.municipio_canton);
				$('#localidad').val(data.localidad);
				$('#estatus').val(data.estatus);
				$('#fecha_incidente').val(data.fecha_hora_inci);
				$('#fecha_cierre').val(data.fecha_cierre_oper);
				jQuery.noConflict();
				
				$('#modalEditar').css('display', 'block');

			} else {
				alert('Error al obtener los datos del incidente.');
			}
		},
		error: function (xhr, status, error) {
			console.error("Error al obtener los datos: ", error); 
			alert('Error al obtener los datos del incidente.');
		}
	});
	

}



function GuardaIncidente() {
    var id_incidentes = $("#id_incidentes").val();
    var nombre = $("#nombre").val();
    var lugar = $("#lugar").val();
    var municipio = $("#municipio").val();
    var localidad = $("#localidad").val();
    var estatus = $("#estatus").val();
    var fecha_incidente = $("#fecha_incidente").val();
    var fecha_cierre = $("#fecha_cierre").val();

    alert('Datos del incidente cargados correctamente.');

    var parametros = {
        'id_incidentes': id_incidentes,
        'nombre': nombre,
        'lugar': lugar,
        'municipio': municipio,
        'localidad': localidad,
        'estatus': estatus,
        'fecha_incidente': fecha_incidente,
        'fecha_cierre': fecha_cierre,
        'accion': 'editar'
    };

    $.ajax({
        data: parametros,
        url: '../controller/Controller-incidente.php',
        type: 'POST',
        success: function (response) {
            console.log("Respuesta del servidor: ", response);
            try {
                let data = JSON.parse(response);
                if (data.status === 'success') {
                    alert('Incidente actualizado exitosamente.');
                    
                } else {
                    alert('Error al actualizar el incidente. Por favor corrija:');
                }
            } catch (e) {
                console.error("JSON Parse Error: " + e.message);
                jQuery.noConflict();
				location.reload();
            }
        },
        error: function (xhr, status, error) {
            console.error("Error: " + error);
        }
    });
}


//----------------------
$(document).ready(function () {


	var modulo = 'kbombero';

	var parametros = {
		'ViewModulo': modulo
	};


	$.ajax({
		data: parametros,
		url: '../model/Model-moduloOpcion.php',
		type: 'GET',
		beforeSend: function () {
			$("#ViewModulo").html('Procesando');
		},
		success: function (data) {
			$("#ViewModulo").html(data);  // $("#cuenta").html(response);

		}
	});

	$.ajax({
		type: 'GET',
		url: '../model/_estados_resumen.php',
		dataType: "json",
		success: function (response) {
			$("#nvence").html(response.a);
			$("#nutil").html(response.b);
			$("#nmalo").html(response.c);
		}
	});




	$('#ParametroContable').load('../model/Model-ViewEmergencia.php');


	$("#FormEmpresa").load('../model/Model-modulo.php');

	$("#NavMod").load('../view/View-HeaderInicio.php');


	$("#ViewGrupo").load('../model/Model-ViewGrupo.php');

	$("#ViewSede").load('../model/Model-ViewSede.php');

	$("#ViewSedeHAS").load('../model/Model-ViewSedeHAS.php');

	$("#FormPie").load('../view/View-pie.php');



});

//----------------------
function variableEmpresa() {

	var ruc = $("#ruc_registro").val();

	var parametros = {
		'ruc': ruc
	};

	/*
  $.ajax({
		  data:  parametros,
		   url:   '../model/moduloCliente.php',
		  type:  'GET' ,
			  beforeSend: function () { 
					  $("#RucRegistro").html('Procesando');
			  },
		  success:  function (data) {
				   $("#RucRegistro").html(data);  // $("#cuenta").html(response);
				   
			  } 
  });  
*/
};

//----------------------
function ListaEmergencias(lista) {


	var parametros = {
		'lista': lista
	};


	$.ajax({
		data: parametros,
		url: '../model/ajax_detalle_emergencia.php',
		type: 'GET',
		beforeSend: function () {
			$("#detallef").html('Procesando');
		},
		success: function (data) {
			$("#detallef").html(data);  // $("#cuenta").html(response);

		}
	});

};

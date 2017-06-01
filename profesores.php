<?php
###
### Página de pantalla de bienvenida.
###

$page_title = 'I.S.F.D. "Prof. Agustín Gómez" - Gestión Alumnado';

include 'config.php';
include 'db_connect.php';

include 'layout_page_top.php';
?>

<script>

    /**
     * Busca registros y los muestra en la tabla, teniendo en cuenta
     * el formulario de búsqueda.
     */
    function searchByFormdata() {
        // Nombre del action al que responderá nuestra solicitud.
        var action_name = 'search_for_tablelist';

        var formdata = {
            Apellido_search:   $("#Apellido_search").val(),
            Nombre_search:     $("#Nombre_search").val(),
            DNI_search:        $("#DNI_search").val()
        };

        // Solicitud de tipo GET.
        // Tres parámetros: url, datos a enviar, y formato de datos.
        // Luego se encadenan los "setters" done y fail para manejar el resultado.
        $.get('profesores_action.php?action=' + action_name, formdata, "json")
            .done(function(data) {
                var error_msg = "";

                if (data.success) {
                    $("#profesores-table").bootstrapTable('load', data.results);
                } else {
                    // Si incluyera un mensaje con el detalle del error.
                    if (typeof data.error_msg !== "undefined") {
                        error_msg = data.error_msg;
                    }

                    // TODO: Mostrar con un cartel flotante éstos tipos de mensaje.
                    alert("No se pudo completar la solicitud. \n\n" + error_msg);
                }
            })
            .fail(function() {
                alert("Ocurrió un error en la conexión.");
            });
    }

    /**
     * Muestra el form de carga de prof. para el alta, ó presentando los datos
     * en caso de que se proporcione por param. el id del registro a editar.
     * Para ambos casos se prepara según el tipo de operación a efectuar.
     * @param   is_modif        boolean     True si es modificar, false si es alta.
     * @param   id_registro     int         Id del registro para el que mostrar datos.
     */
    function showEditProfModal(is_modif, id_registro) {
        var form = $("#save-modify-profesor-form")[0];

        // Vaciar el formulario del modal.
        form.reset();

        $("#operation").val("create");
        $("#modal-title").text("Nuevo");

        if (is_modif) {
            var action_name = "fetch_single";
            var formdata = {
                Id:         id_registro
            };

            $("#operation").val("update");
            $("#modal-title").text("Modificar");

            // Solicitud de tipo GET.
            $.get('profesores_action.php?action=' + action_name, formdata, "json")
                .done(function(data) {
                    var error_msg = "";
                    var row;

                    if (data.success) {
                        row = data.result;

                        // Rellenar los datos sobre el registro a editar.
                        $("#Apellido").val(row.Apellido);
                        $("#Nombre").val(row.Nombre);
                        $("#DNI").val(row.DNI);
                        $("#Id").val(row.Id);
                    } else {
                        // Si incluyera un mensaje con el detalle del error.
                        if (typeof data.error_msg !== "undefined") {
                            error_msg = data.error_msg;
                        }

                        // Como estamos en el "callback" del done(), el modal para entonces ya
                        // estaría abierto. Lo cerramos.
                        $("#userModal").modal("hide");

                        alert("No se pudo completar la solicitud. \n\n" + error_msg);
                    }
                })
                .fail(function() {
                    alert("Ocurrió un error en la conexión.");
                });

        }

        $("#userModal").modal("show")
                        // Cuando termina de mostrarse.
                        .on("shown.bs.modal", function(e) {
                            $("#Apellido").select(); // Selecciona todo el texto.
                        });
    }

    /**
     * Pregunta si borrar el registro pasado por param. Si se acepta,
     * lo elimina vía ajax.
     */
    function deleteReg(id) {
        var action_name = "delete";
        var formdata = {
            Id: id
        };

        if ( ! confirm("Eliminar el registro \n\n¿Está seguro?")) {
            return;
        }

        // Solicitud de tipo POST.
        $.post('profesores_action.php?action=' + action_name, formdata, "json")
            .done(function(data) {
                var error_msg = "";

                if (data.success) {
                    alert("Registrado eliminado con éxito.");
                    searchByFormdata(); // Recargar la busq.
                } else {
                    // Si incluyera un mensaje con el detalle del error.
                    if (typeof data.error_msg !== "undefined") {
                        error_msg = data.error_msg;
                    }

                    alert("No se pudo completar la solicitud. \n\n" + error_msg);
                }
            })
            .fail(function() {
                alert("Ocurrió un error en la conexión.");
            });
    }

    /**
     * Da el formato requerido al valor presente en la columna de opciones.
     * @param value     valor que contiene la columna.
     */
    function opcionesFormatter(value) {
        var Id = value;

        return '<button type="button" class="btn btn-primary btn-xs"'+
                        'title="Editar registro" onclick="showEditProfModal(true, '+ Id +')">'+
                    '<i class="glyphicon glyphicon-pencil"></i>'+
                '</button>'+
                '&nbsp;'+
                '<button type="button" class="btn btn-danger btn-xs"'+
                    'title="Eliminar registro" onclick="deleteReg('+ Id +')">'+
                    '<i class="glyphicon glyphicon-remove"></i>'+
                '</button>';
    }

    // Uno de los usos importantes del ready() es de declarar allí los "listeners"
    // de eventos como submit, click, etc.
    // También se utiliza para inicializar componentes de javascript.
    $(document).ready(function() {

        // Al enviar el formulario de nuevo/modif.
        $("#save-modify-profesor-form").on("submit", function(event) {

            // Cancelar. Dado que vamos a manejar nosotros el envío.
            event.preventDefault();

            // En el form está definido el tipo de operación.
            var action_name = $("#operation").val();

            // Obtener todos los datos cargados.
            var form = $("#save-modify-profesor-form")[0];
            var formdata = $(form).serialize();

            // Solicitud de tipo POST.
            $.post('profesores_action.php?action=' + action_name, formdata, "json")
                .done(function(data) {
                    var error_msg = "";

                    if (data.success) {
                        alert("Registrado con éxito.");
                        $("#userModal").modal("hide");
                        searchByFormdata(); // Recargar la busq.
                    } else {
                        // Si incluyera un mensaje con el detalle del error.
                        if (typeof data.error_msg !== "undefined") {
                            error_msg = data.error_msg;
                        }

                        alert("No se pudo completar la solicitud. \n\n" + error_msg);
                    }
                })
                .fail(function() {
                    alert("Ocurrió un error en la conexión.");
                });
        });

    });
</script>

<fieldset>
    <legend>Profesores</legend>

    <div class="form-inline">
        <input type="text" class="form-control" name="Apellido_search" id="Apellido_search" placeholder="Apellido" value="">
        <input type="text" class="form-control" name="Nombre_search" id="Nombre_search" placeholder="Nombre" value="">
        <input type="text" class="form-control" name="DNI_search" id="DNI_search" placeholder="DNI" value="">
        <button type="button" class="btn btn-default" id="form-search-btn" onclick="searchByFormdata()">Buscar</button>
        <button type="button" class="pull-right btn btn-primary"
                id="form-search-btn" onclick="showEditProfModal(false, 0)">Nuevo</button>
    </div>
</fieldset>
<br>

<div class="panel panel-default">
    <table id="profesores-table"
        class="table table-condensed table-hover table-bordered"
        data-toggle="table"
        data-search="true">
        <thead>
            <tr>
                <th data-field="Apellido" data-sortable="true">Apellido</th>
                <th data-field="Nombre" data-sortable="true">Nombre</th>
                <th data-field="DNI" data-sortable="true">DNI</th>
                <th data-field="Id" data-formatter="opcionesFormatter">Opciones</th>
            </tr>
        </thead>
    </table>
</div>

<div id="userModal" class="modal fade">
	<div class="modal-dialog">
		<form method="post" id="save-modify-profesor-form">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 id="modal-title">&nbsp;</h4>
				</div>
				<div class="modal-body">
                    <label>Apellido</label>
					<input type="text" class="form-control" name="Apellido" id="Apellido" required>
                    <br>
					<label>Nombre</label>
					<input type="text" class="form-control" name="Nombre" id="Nombre" required>
                    <br>
					<label>DNI</label>
					<input type="text" class="form-control" name="DNI" id="DNI" pattern="\d{7,8}" required>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="Id" id="Id" value="0">
					<input type="hidden" id="operation">
					<input type="submit" id="btn-submit" class="btn btn-success" value="Aceptar">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				</div>
			</div>
		</form>
	</div>
</div>

<?php
include 'layout_page_bottom.php';
?>

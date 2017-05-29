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
     * Búsqueda de registros, teniendo en cuenta el formulario de búsqueda.
     */
    function searchByFormdata() {
        // Nombre del action al que responderá nuestra solicitud.
        var action_name = 'search_for_tablelist';

        var formdata = {
            Apellido:   $("#Apellido").val(),
            Nombre:     $("#Nombre").val(),
            DNI:        $("#DNI").val()
        };

        $.ajax({
            type:  'get', // Método HTTP a utilizar.
            dataType: "json", // Formato de respuesta con el que vamos a tratar.
            data: formdata, // Datos adicionales a enviar.
            url:   'profesores_action.php?action=' + action_name
            //success: function(data) { // Usaremos done() en su lugar.

            //},
            //error: function(xhr, err) { // Usaremos fail() en su lugar.

            //}
        })
        .done(function(data) {
            if (data.success) {
                $("#profesores-table").bootstrapTable('load', data.results);
            }
        })
        .fail(function() {
            alert("No se pudo completar la solicitud.");
        });
    }

    /**
     * Da el formato requerido al valor presente en la columna de opciones.
     * @param value     valor que contiene la columna.
     */
    function opcionesFormatter(value) {
        var Id = value;

        return '<button type="button" class="btn btn-primary btn-xs" title="Editar registro '+Id+'">'+
                    '<i class="glyphicon glyphicon-pencil"></i>'+
                '</button>'+
                '&nbsp;'+
                '<button type="button" class="btn btn-primary btn-xs" title="Eliminar registro '+Id+'">'+
                    '<i class="glyphicon glyphicon-remove"></i>'+
                '</button>';
    }

    $(document).ready(function() {

    });
</script>

<fieldset>
    <legend>Profesores</legend>

    <div class="form-inline">
        <input type="text" class="form-control" name="Apellido" id="Apellido" placeholder="Apellido" value="">
        <input type="text" class="form-control" name="Nombre" id="Nombre" placeholder="Nombre" value="">
        <input type="text" class="form-control" name="DNI" id="DNI" placeholder="DNI" value="">
        <button type="button" class="pull-right btn btn-info" id="form-search-btn" onclick="searchByFormdata()">Buscar</button>
    </div>
</fieldset>
<br>

<table id="profesores-table"
    class="table table-condensed table-hover table-bordered"
    data-toggle="table">
    <thead>
        <tr>
            <th data-field="Apellido" data-sortable="true">Apellido</th>
            <th data-field="Nombre" data-sortable="true">Nombre</th>
            <th data-field="DNI" data-sortable="true">DNI</th>
            <th data-field="Id" data-formatter="opcionesFormatter">Opciones</th>
        </tr>
    </thead>
</table>

<?php
include 'layout_page_bottom.php';
?>

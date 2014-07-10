$(document).ready(function() {

function getURLParameter(url, name) {
        return (RegExp(name + '=' + '(.+?)(&|$)').exec(url) || [, null])[1];
    }

    $('#listado-colores a.eliminar-color').click(function() {

        var url = $(this).parent().find(".editar-color").attr('href');
        var color = $(this).parent().parent().find("h2").html();

        var texto = "¿Estás seguro que deseas eliminar el color <strong>" + color + "</strong>?";
        // alert(texto);
        //var id = getURLParameter(url, 'id');
        var id=parseInt(url.split('/')[url.split('/').length - 2]);
        var idioma=parseInt(url.split('/')[url.split('/').length - 1]);
        $('a.elimina-este').attr('href', base_url+'index.php/cms/colores/delete/' + id+'/'+idioma);
        $('.modalDelBook .modal-body').html(texto);
    });
});
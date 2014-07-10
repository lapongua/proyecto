$(document).ready(function() {

function getURLParameter(url, name) {
        return (RegExp(name + '=' + '(.+?)(&|$)').exec(url) || [, null])[1];
    }

    $('#listado-categorias a.eliminar-categoria').click(function() {

        var url = $(this).parent().find(".editar-categoria").attr('href');
        var cat = $(this).parent().parent().find("h2").html();

        var texto = "¿Estás seguro que deseas eliminar la categoria <strong>" + cat + "</strong>?";
        // alert(texto);
        //var id = getURLParameter(url, 'id');
        var id=parseInt(url.split('/')[url.split('/').length - 2]);
        var idioma=parseInt(url.split('/')[url.split('/').length - 1]);
        $('a.elimina-este').attr('href', base_url+'index.php/cms/categorias/delete/' + id+'/'+idioma);
        $('.modalDelBook .modal-body').html(texto);
    });
});
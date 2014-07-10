$(document).ready(function() {

function getURLParameter(url, name) {
        return (RegExp(name + '=' + '(.+?)(&|$)').exec(url) || [, null])[1];
    }

    $('#listado-productos a.eliminar-producto').click(function() {

        var url = $(this).parent().find(".editar-producto").attr('href');
        var producto = $(this).parent().parent().find("h2").html();

        var texto = "¿Estás seguro que deseas eliminar el producto <strong>" + producto + "</strong>?";
        // alert(texto);
        //var id = getURLParameter(url, 'id');
        var id=parseInt(url.split('/')[url.split('/').length - 2]);
        var idioma=parseInt(url.split('/')[url.split('/').length - 1]);
        $('a.elimina-este').attr('href', base_url+'index.php/cms/productos/delete/' + id+'/'+idioma);
        $('.modalDelBook .modal-body').html(texto);
    });
});
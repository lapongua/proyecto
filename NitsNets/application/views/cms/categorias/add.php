<?php
$admin_logged_in = $this->session->userdata('isAdmin');
if (!isset($admin_logged_in) || $admin_logged_in == FALSE) {
    $this->session->set_userdata('novalido', 'No tienes permisos para acceder a esta página.');
    redirect('/cms/login/index');
}
?>
<div class="clearfix wrapper-title">
    <h1 class="pull-left"><span class="glyphicon glyphicon-book"></span>Categorías</h1>
    <a href="javascript:history.back()" class="back pull-right" title="Atrás"><span class="fa fa-arrow-left"></span> Volver</a>
</div>

<nav>
    <ol class="breadcrumb">
        <li><?php echo anchor('cms/dashboard', 'Home', array('title' => 'Ir a Inicio')) ?></li>
        <li><?php echo anchor('cms/categorias', 'Categorías', array('title' => 'Ir a Categorías')) ?></li>
        <li class="active">Nueva categoría</li>
    </ol>
</nav>


<?php
$attributes = array('class' => 'formAddCategoria');
if ($this->uri->segment(4) != NULL && $this->uri->segment(5) != NULL) {//Editar y traducir
    $openform = form_open('cms/categorias/add/' . $this->uri->segment(4) . '/' . $this->uri->segment(5), $attributes);
} else { //nueva categoria
    $openform = form_open('cms/categorias/add', $attributes);
}
//$openform = ($this->uri->segment(4) != NULL) ? form_open('cms/categorias/add/' . $this->uri->segment(4), $attributes) : form_open('cms/categorias/add', $attributes);
echo $openform;
?>
<div class="form-group">
    <label>Idioma</label>
<?php
//IDIOMA SELECCIONADO
$trobat = false;
foreach ($languages as $language) {
    if ($this->uri->segment(5) == $language->id) {
        $options = array(
            $language->id => $language->nombre
        );
        $trobat = true;
    }
}
if (!$trobat) { //idioma por defecto
    $options = array(
        '1' => 'Español'
    );
}

$idioma = (isset($categoria->fk_idioma)) ? $categoria->fk_idioma : '1';
$selectname = "idioma";

echo form_dropdown($selectname, $options, set_value($selectname, $idioma));
?>
</div>

<div class="form-group">
    <label>nombre *</label><?php echo form_error('nombre'); ?>
    <?php $nombre = (isset($categoria->nombre)) ? $categoria->nombre : ''; ?>
    <input type="text" name="nombre" id="nombreCat" class="form-control" value="<?php echo set_value('nombre', $nombre); ?>">
</div>
<div class="form-group">
    <label>descripción *</label><?php echo form_error('descripcion'); ?>
    <?php $desc = (isset($categoria->descripcion)) ? $categoria->descripcion : ''; ?>
    <textarea class="form-control" name="descripcion" id="desCat" rows="3"><?php echo set_value('descripcion', $desc); ?></textarea>
</div>
<a href="javascript:history.back()" class="btn btn-default">Cancelar</a>
<button type="submit" class="btn btn-primary">Guardar</button>


<?php
echo form_close();

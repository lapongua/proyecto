<?php
$admin_logged_in = $this->session->userdata('isAdmin');
if (!isset($admin_logged_in) || $admin_logged_in == FALSE) {
    $this->session->set_userdata('novalido', 'No tienes permisos para acceder a esta página.');
    redirect('/cms/login/index');
}
?>

<div class="clearfix wrapper-title">
    <h1 class="pull-left"><span class="fa fa-pencil"></span>Productos</h1>
    <a href="javascript:history.back()" class="back pull-right" title="Atrás"><span class="fa fa-arrow-left"></span> Volver</a>
</div>

<nav>
    <ol class="breadcrumb">
        <li><?php echo anchor('cms/dashboard', 'Home', array('title' => 'Ir a Inicio')) ?></li>
        <li><?php echo anchor('cms/productos', 'Productos', array('title' => 'Ir a Productos')) ?></li>
        <li class="active">Nuevo producto</li>
    </ol>
</nav>


<?php
//print_r("<pre>");
//print_r($producto);
//print_r("</pre>");


$attributes = array('class' => 'formAddProducto');
if ($this->uri->segment(4) != NULL && $this->uri->segment(5) != NULL) {//Editar y traducir
    $openform = form_open('cms/productos/add/' . $this->uri->segment(4) . '/' . $this->uri->segment(5), $attributes);
} else { //nuevo producto
    $openform = form_open('cms/productos/add', $attributes);
}

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

    $idioma = (isset($producto->fk_idioma)) ? $producto->fk_idioma : '1';
    $selectname = "idioma";

    echo form_dropdown($selectname, $options, set_value($selectname, $idioma));
    ?>
</div>

<div class="form-group">
    <label>nombre *</label><?php echo form_error('nombre'); ?>
<?php $nombre = (isset($producto->nombre)) ? $producto->nombre : ''; ?>
    <input type="text" name="nombre" id="nombreProd" class="form-control" value="<?php echo set_value('nombre', $nombre); ?>" placeholder="Nombre del producto">
</div>
<div class="form-group">
    <label>descripción *</label><?php echo form_error('descripcion'); ?>
<?php $desc = (isset($producto->descripcion)) ? $producto->descripcion : ''; ?>
    <textarea class="form-control" name="descripcion" id="desProd" rows="3" placeholder="Descripción del producto (máx. 500 caracteres)"><?php echo set_value('descripcion', $desc); ?></textarea>
</div>


<div class="row">

    <div class="form-group right-inner-addon col-md-3">
        <label for="e-precio">precio *</label><?php echo form_error('precio'); ?>
<?php $precio = (isset($producto->precio)) ? $producto->precio : ''; ?>
        <input type="text" value="<?php echo set_value('precio', $precio); ?>" placeholder="Precio" id="e-precio" name="precio" class="form-control input-group">
        <i class="fa fa-euro"></i>
    </div>
    <div class="form-group col-md-3">
        <label for="e-sku">sku *</label><?php echo form_error('sku'); ?>
<?php $sku = (isset($producto->sku)) ? $producto->sku : ''; ?>
        <input type="text" value="<?php echo set_value('sku', $sku); ?>" placeholder="Referencia" id="e-sku" name="sku" class="form-control input-group">
    </div>

    <div class="form-group col-md-3">
        <label>Categoría *</label><br>
<?php $cate = (isset($producto->fk_categoria)) ? $producto->fk_categoria : ''; ?>
        <?php
        $cat = array();
        $cat[null] = 'Seleciona una categoría';

        foreach ($categorias as $categoria) {
            $cat[$categoria->id] = $categoria->nombre;
        }
        $jp = ' class="form-control"';
        // echo "Cat: ".$cate;
        echo form_dropdown('categoria', $cat, set_value('categoria', $cate), $jp);
        ?>
    </div>
    <div class="form-group col-md-3">
        <label>Colores *</label><br><?php echo form_error('color'); ?>
<?php
$data = array();

foreach ($colores as $color) {
    $data[$color->id] = $color->nombre;
}
$js = "multiple class='form-control'";

// $this->input->post('color')
if (isset($producto->miscolores)) {
    $seleccionados = array();
    foreach ($producto->miscolores as $key => $value) {
        $seleccionados[] = $value->fk_color;
    }
}
//prin_r("<pre>");
//print_r($seleccionados);
//prin_r("<pre>");
$select = (isset($producto->miscolores)) ? $seleccionados : $this->input->post('color');
echo form_multiselect('color[]', $data, $select, $js);
?>
    </div>
</div>
<!--<a href="javascript:history.back()" class="btn btn-default">Cancelar</a>-->
<?php echo anchor('cms/productos', 'cancelar', array('class' => 'btn btn-default')); ?>
<button type="submit" class="btn btn-primary">Guardar</button>


<?php
echo form_close();

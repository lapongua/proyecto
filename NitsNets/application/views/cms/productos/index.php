<?php
$admin_logged_in = $this->session->userdata('isAdmin');
if (!isset($admin_logged_in) || $admin_logged_in == FALSE) {
    $this->session->set_userdata('novalido', 'No tienes permisos para acceder a esta página.');
    redirect('/cms/login/index');
}
?>
<div class="clearfix wrapper-title">
    <h1 class="pull-left"><span class="fa fa-pencil"></span>Productos <span class="badge"><?php echo count($productos); ?></span></h1>
    <?php echo anchor('cms/productos/add', '<span class="fa fa-plus-square"></span> Nuevo producto</a>', array('title' => 'Nuevo producto', 'class' => 'add-item pull-right')) ?>
</div>
<nav>
    <ol class="breadcrumb">
        <li><?php echo anchor('cms/dashboard', 'Home', array('title' => 'Ir a Inicio')) ?></li>
        <li class="active">Productos</li>
    </ol>
</nav>
<?php
if ($this->session->userdata('valido')) {
    ?>

    <div class="alert alert-success alert-dismissable">
        <i class="fa fa-check"></i>
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <?php echo $this->session->userdata('valido'); ?>
    </div>
    <?php
    $this->session->unset_userdata('valido');
}

if ($this->session->userdata('novalido')) {
    ?>

    <div class="alert alert-danger alert-dismissable">
        <i class="fa fa-check"></i>
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <?php echo $this->session->userdata('novalido'); ?>
    </div>
    <?php
    $this->session->unset_userdata('novalido');
}
?>
<div class="row">
    <?php
    $attributes = array('id' => 'filtrar-col', 'role' => 'form', 'class' => 'form-inline');
    echo form_open('cms/productos/filtrar', $attributes)
    ?>
    <div class="col-md-5">

        <div class="form-group col-md-6">
            <?php
            $selectname = "idioma";
            $options = array();
            foreach ($languages as $language) {
                $options[$language->id] = $language->nombre;
            }
            $js = 'id="idioma" class="form-control"';
            echo form_dropdown($selectname, $options, set_value($selectname, $this->session->userdata('idioma')), $js);
            $this->session->unset_userdata('idioma');
            ?>
        </div>
        <div class="form-group col-md-6">
            <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Filtrar</button>
        </div>

    </div>
    <?php
    echo form_close();
    ?>

</div>

<!-- Listado de productos -->        
<table id="listado-productos" class="table table-hover table-condensed">
    <thead>
        <tr>
            <th>id</th>
            <th>nombre</th>
            <th>descripción</th>
            <th>idiomas disponibles</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
       if($productos!=NULL)
       {
        foreach ($productos as $producto) {
            ?>
            <tr>
                <td><?php echo $producto->id; ?></td>
                <td><h2><?php echo $producto->nombre; ?></h2></td>
                <td><?php echo $producto->descripcion; ?></td>
                <td>
                    <?php
                    // echo $categoria->idioma . "//";

                    foreach ($producto->traducciones as $key => $value) {

                        echo anchor('cms/productos/edit/' . $producto->id . '/' . $value->fk_idioma, $value->short,array('title'=>'Editar traducción')) . " ";
                    }
                    if ($producto->Notraducciones != "") {
                        foreach ($producto->Notraducciones as $key => $value) {

                            echo anchor('cms/productos/add/' . $producto->id . '/' . $value->id, $value->short, array('style' => 'text-decoration:line-through;color:red;','title'=>'Añadir traducción')) . " ";
                        }
                    }
                    ?>


                </td>
                <td>
                    <?php
                    echo anchor('cms/productos/edit/' . $producto->id . '/' . $producto->fk_idioma, '<span class="glyphicon glyphicon-edit btn-lg"></span>', array('class' => 'tooltipt transition editar-producto', 'title' => 'Editar'))
                    ?>                
                    <a href="" class="tooltipt transition eliminar-producto" data-toggle="modal" data-target="#myModal" title="Eliminar"><span class="glyphicon glyphicon-remove btn-lg"></span></a>         
                </td>
            </tr>
            <?php
        }
       }
       else
       {
           ?>
            <tr><td colspan="5">No productos en este idioma</td></tr>
            <?php
       }
        ?>

    </tbody>
</table>

<div class="modal fade modalDelBook" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Eliminar producto</h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <a href="" class="btn btn-danger elimina-este">Eliminar</a>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

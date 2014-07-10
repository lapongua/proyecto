<?php
switch ($this->uri->segment(2)) {

    case 'categorias':
        $miescript[0] = "assets/scripts/categorias.js";
        break;
    case 'productos':
        $miescript[0] = "assets/scripts/productos.js";
        break;
    case 'colores':
        $miescript[0] = "assets/scripts/colores.js";
        break;
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta name="author" content="">
        <title>Admin NitsNets</title>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">

        <!-- font Awesome -->
        <link href="<?php echo base_url() ?>assets/styles/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

        <link href="<?php echo base_url() ?>assets/styles/css/backend.less" rel="stylesheet/less" type="text/css" />


        <script type="text/javascript" src="<?php echo base_url() ?>assets/scripts/less/less.min.js"></script>
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
          <![endif]--> 
        <script type="text/javascript">
            var base_url = "<?php echo base_url(); ?>";
        </script>
    </head>
    <body>


        <div class="container">
            <header id="navbar" class="navbar navbar-default navbar-fixed-top">
                <div class="wrapper-navbar clearfix">


                    <div class="navbar-header navbar-left">
                        <a class="navbar-brand" href="home.php" title="Ir a Dashboard"><span class="pull-left">NitsNets</span><small> Content Management System</small></a>

                    </div>
                    <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle navbar-right" type="button">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <div class="navbar-header navbar-right navbar-collapse collapse">
                        <p class="navbar-text">Hola, <a href="#" title="Ir a mi cuenta"><?php echo $this->session->userdata('name'); ?></a>
                            <?php /*  <a title="Salir" class="logout transition" href="<?php echo base_url('cms/login/logout');?>"><span class="glyphicon glyphicon-log-out"></span></a> */ ?>
                            <?php
                            echo anchor('cms/login/logout', '<span class="glyphicon glyphicon-log-out"></span>', array('title' => 'Salir', 'class' => 'logout transition'));
                            ?>
                        </p>
                    </div>

                </div>

                <nav id="subnavbar" class="navbar-collapse collapse">          
                    <ul class="nav navbar-nav">  
                        <?php
                        $full_name = $_SERVER['PHP_SELF'];
                        $name_array = explode('/', $full_name);
                        $count = count($name_array);
                        $page_name = $name_array[$count - 1];

                        //echo $page_name;
                        ?>
                        <li class="divider">            
                            <?php
                            if ($page_name == 'dashboard') {
                                $active = 'active';
                            } else {
                                $active = '';
                            }
                            echo anchor('cms/dashboard', '<span class="fa fa-home"></span><span>Dashboard</span>', array('title' => 'Ir a Dashboard', 'class' => $active));
                            ?>
                        </li>  
                        <li>
                            <?php
                            if ($page_name == 'productos') {
                                $active = 'active';
                            } else {
                                $active = '';
                            }
                            echo anchor('cms/productos', '<span class="fa fa-pencil"></span><span>Productos</span>', array('title' => 'Ir a Procutos', 'class' => $active));
                            ?>
                        </li>  
                        <li>
                            <?php
                            if ($page_name == 'colores') {
                                $active = 'active';
                            } else {
                                $active = '';
                            }
                            echo anchor('cms/colores', '<span class="fa fa-picture-o"></span><span>Colores</span>', array('title' => 'Ir a Colores', 'class' => $active));
                            ?>
                        </li>  
                        <li>
                            <?php
                            if ($page_name == 'categorias') {
                                $active = 'active';
                            } else {
                                $active = '';
                            }
                            echo anchor('cms/categorias', '<span class="fa fa-folder-open"></span><span>Categorias</span>', array('title' => 'Ir a Categorias', 'class' => $active));
                            ?>
                        </li>  
                    </ul>
                </nav>


            </header>
            <section>
                <?php echo $yield ?>
            </section>
        </div>
        <footer class="clearfix">                    
            <div class="pull-left">&copy; 2014 Backend NitsNets</div><div class="pull-right">By Lara Pont</div>
        </footer>


        <script src="<?php echo base_url() ?>assets/scripts/jquery/jquery-1.10.2.js"></script>
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
        <?php
        if (isset($miescript)) {
            foreach ($miescript as $key => $value) {
                ?>
                <script src="<?php echo base_url() . '' . $miescript[$key]; ?>" type="text/javascript"></script>
                <?php
            }
        }
        ?>
    </body>
</html>
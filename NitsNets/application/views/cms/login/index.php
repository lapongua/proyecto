<?php
//si tenemos el rol de adminsitrador vamos directamente al dashboard
if ($this->session->userdata('isAdmin')) {
    redirect('cms/dashboard');
}
?>
<div class="container">    
    <div id="loginbox" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
        <div class="panel panel-info" >
            <div class="panel-heading">
                <div class="panel-title">Iniciar sesión</div>
                <div class="forgot"><a href="#">¿Olvidaste tu contraseña?</a></div>
            </div>     

            <div class="panel-body" >

                <?php
                $attributes = array('class' => 'form-horizontal', 'id' => 'loginform', 'role' => 'form');
                echo form_open('cms/login/log_in', $attributes);

                if ($this->session->userdata('novalido')) {
                    echo ' <p id="login-alert" class="alert alert-danger"><button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>' . $this->session->userdata('novalido') . '</p>';
                    $this->session->unset_userdata('novalido');
                }
                echo validation_errors();
                ?>


                <div class="input-group marginb25">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input id="login-username" type="text" class="form-control" name="email" value="<?php echo set_value('email'); ?>" placeholder="correo electrónico"  required autofocus>                                        
                </div>

                <div class="input-group marginb25">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <input id="login-password" type="password" class="form-control" name="password" value="<?php echo set_value('password'); ?>" placeholder="contraseña"  required>
                </div>



                <div class="input-group">
                    <div class="checkbox">
                        <label>
                            <input id="login-remember" type="checkbox" name="remember" value="1"> Recordar mis datos
                        </label>
                    </div>
                </div>


                <div class="form-group margint10">
                    <!-- Button -->

                    <div class="col-sm-12 controls">
                        <button id="btn-login" href="#" class="btn btn-success">Iniciar sesión  </button>
                        <a id="btn-fblogin" href="#" class="btn btn-primary">Iniciar sesión con Facebook</a>

                    </div>
                </div>
                </form>     
            </div>                     
        </div>  
    </div>

</div>
